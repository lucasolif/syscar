<?php

namespace App\Services;

use App\Models\ContaReceber;
use App\Repositories\ContaReceberRepository;
use DateTime;
use Throwable;


class ContaReceberService{
    private ContaReceberRepository $contaReceberRepository;
    private PessoaService $pessoaService;

    public function __construct(){
        $this->contaReceberRepository = new ContaReceberRepository();
        $this->pessoaService = new PessoaService();
    }

    public function faturarOrdemServico(array $dados): array{

        $erros = $this->validar($dados);
        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try {
            $arrayContaReceber = $this->gerarParcelasCrOrdemServico($dados);
            $this->contaReceberRepository->salvar($arrayContaReceber);

            return [
                'success' => true,
                'message' => 'Contas Receber geradas com sucesso!'
            ];

        } catch (Throwable $e) {
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }

    }

    public function consultar(array $filtros): array{
        return $this->contaReceberRepository->consultar($filtros);
    }
    private function gerarParcelasCrOrdemServico(array $dados): array{

        $nomePessoa = $this->pessoaService->consultarNomePessoa($dados['pessoaId']);
        $pessoaId = (int) $dados['pessoaId'];
        $osId = (int) $dados['ordemServicoId'];
        $formaPagamentoId = (int) $dados['formaPagamentoId'];

        $descricaoBase = $nomePessoa . ' | OS ' . $osId;

        $primeiroVencimento = new DateTime($dados['primeiroVencimento']);
        $intervaloParcela = (int) $dados['intervaloParcela'];

        $valorTotal = (float) $dados['valorTotal'];
        $quantidadeParcelas = (int) $dados['quantidadeParcelas'];
        $valorParcela = $valorTotal / $quantidadeParcelas;

        $contasReceber = [];


        for ($i = 1; $i <= $quantidadeParcelas; $i++) {
            $dataVencimento = clone $primeiroVencimento;

            if ($i > 1) {
                $diasAdicionar = ($i - 1) * $intervaloParcela;
                $dataVencimento->modify("+{$diasAdicionar} days");
            }

            $contasReceber[] = ContaReceber::fromArray([
                'descricao' => $descricaoBase.' - PARC: '.$quantidadeParcelas.'/'.$i,
                'dataVencimento' => $dataVencimento->format('Y-m-d H:i:s'),
                'pessoaId' => $pessoaId,
                'origem' => 'OS',
                'osId' => $osId,
                'formaPagamentoId' => $formaPagamentoId,
                'valor' => $valorParcela,
                'valorPago' => 0,
                'valorPendente' => $valorParcela,
                'parcela' => $i,
                'status' => 'PENDENTE'
            ]);
        }

        return $contasReceber;
    }

    public function baixar(array $contaBaixada, int $id): array{

        try {
            $arrayCr = $this->contaReceberRepository->buscarPorId($id);

            $valorTotalParcela = $arrayCr['valor'];
            $valorPendenteAnterior = $arrayCr['valorPendente'];
            $valorPagoAnterior = $arrayCr['valorPago'];

            $valorPago = $contaBaixada['valorPago'];
            $formaPagamentoId = $contaBaixada['formaPagamentoId'];
            $contaCaixa = $contaBaixada['contaCaixaId'];
            $dataPagamento = $contaBaixada['dataPagamento'];

            $novoValorPendente = 0;
            $novoValorPago = 0;
            $novoStatus = '';

            if($valorTotalParcela == $valorPago){
                $novoValorPago = $valorPago;
                $novoStatus = 'PAGO';
            }else if($valorPago < $valorTotalParcela){
                $novoValorPendente = $valorPendenteAnterior - $valorPago;
                $novoValorPago = $valorPagoAnterior + $valorPago;

                if($novoValorPendente == 0){
                    $novoStatus = 'PAGO';
                }else{
                    $novoStatus = 'PARCIAL';
                }
            }

            $dadosPagamento = [
                'contaReceberId' => $id,
                'valorPendente' => $novoValorPendente,
                'valorPago' => $novoValorPago,
                'status' => $novoStatus,
                'dataPagamento' => $dataPagamento,
                'formaPagamentoId' => $formaPagamentoId
            ];

            $this->contaReceberRepository->baixar($dadosPagamento);

            return [
                'success' => true,
                'message' => 'A conta foi baixada com sucesso.!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error' => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function cancelarBaixar(int $id): array{
        try {
            $arrayCr = $this->contaReceberRepository->buscarPorId($id);

            $dadosCancelamento = [
                'contaReceberId' => $id,
                'valorPendente' => $arrayCr['valor'],
                'valorPago' => 0,
                'status' => 'PENDENTE',
                'dataPagamento' => null
            ];

            $this->contaReceberRepository->cancelarBaixa($dadosCancelamento);

            return [
                'success' => true,
                'message' => 'A baixa foi cancelada e a conta está pendente!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error' => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function cancelarContaReceber(int $id): array{
        try {
            $arrayCr = $this->contaReceberRepository->buscarPorId($id);

            $dadosCancelamento = [
                'contaReceberId' => $id,
                'valorPendente' => $arrayCr['valor'],
                'valorPago' => 0,
                'status' => 'CANCELADA',
                'dataPagamento' => null
            ];

            $this->contaReceberRepository->cancelarContaReceber($dadosCancelamento);

            return [
                'success' => true,
                'message' => 'A baixa foi cancelada e a conta está pendente!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error' => [
                    $e->getMessage()
                ]
            ];
        }
    }
    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['primeiroVencimento'])) {
            $erros['primeiroVencimento'] = 'A data do primeiro vencimento é obrigatorio.';
        }

        if (empty($dados['intervaloParcela'])) {
            $erros['intervaloParcela'] = 'Informe o intervalo entre as datas de vencimento das parcelas.';
        }

        if (empty($dados['ordemServicoId'])) {
            $erros['ordemServicoId'] = 'O número da ordem de serviço é obrigatorio.';
        }

        if (empty($dados['pessoaId'])) {
            $erros['pessoaId'] = 'O código da pessoa/cliente é obrigatorio.';
        }

        if (empty($dados['formaPagamentoId'])) {
            $erros['formaPagamentoId'] = 'A forma de pagamento é obrigatorio.';
        }

        if (empty($dados['quantidadeParcelas'])) {
            $erros['quantidadeParcelas'] = 'A quantidade de parcelas é obrigatorio.';
        }

        if (empty($dados['valorTotal'])) {
            $erros['valorTotal'] = 'O valor total do faturamento é obrigatorio.';
        } elseif ((float) $dados['valorTotal'] <= 0) {
            $erros['valorTotal'] = 'O valor total do faturamento deve ser maior que zero.';
        }

        return $erros;
    }

}