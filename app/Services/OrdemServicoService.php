<?php

namespace App\Services;

use App\Core\Database;
use App\Models\OrdemServico;
use App\Repositories\OrdemServicoRepository;
use Exception;
use PDO;
use Throwable;

class OrdemServicoService{
    private OrdemServicoRepository $ordemServicoRepository;
    private ContaReceberService  $contaReceberService;
    private PDO $conn;

    public function __construct(){
        $this->ordemServicoRepository = new OrdemServicoRepository();
        $this->contaReceberService = new ContaReceberService();
        $this->conn = Database::getConnection();
    }

    public function consultarPorId(int $id): array{
        return $this->ordemServicoRepository->buscarPorId($id);
    }
    public function buscarPorPessoaVeiculoOrdem(string $filtro): array{
        return $this->ordemServicoRepository->buscarPorPessoaVeiculoOrdem($filtro);
    }

    public function salvar(array $dados): array{
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try{
            $ordemServico = OrdemServico::fromArray($dados);
            $this->ordemServicoRepository->salvar($ordemServico);

            return [
                'success' => true,
                'message' => 'Ordem de Serviço N° '. $ordemServico->getId() .' cadastrada com sucesso!'
            ];
        }catch(Exception $e){
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }

    }

    public function editar(array $dados): array{
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try{
            $ordemServico = OrdemServico::fromArray($dados);
            $this->ordemServicoRepository->editar($ordemServico);

            return [
                'success' => true,
                'message' => 'Ordem de Serviço N° ' . $ordemServico->getId() . ' alterada com sucesso!'
            ];
        }catch(Exception $e){
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function cancelar(int $ordemServicoId): array{
        try{
            $this->ordemServicoRepository->cancelar($ordemServicoId);
            return [
                'success' => true,
                'message' => 'Ordem de Serviço N° ' . $ordemServicoId . ' cancelada com sucesso!'
            ];
        }catch(Exception $e){
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function fechar(int $ordemServicoId): array{
        try {
            $this->ordemServicoRepository->fechar($ordemServicoId);

            return [
                'success' => true,
                'message' => 'Ordem de serviço fechada com sucesso!'
            ];

        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            return [
                'success' => false,
                'error' => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function faturar(array $dadosFaturamento, int $ordemServicoId): array{
        try {
            $this->conn->beginTransaction();

            $this->ordemServicoRepository->faturar($ordemServicoId);
            $resultadoContaReceber = $this->contaReceberService->faturarOrdemServico($dadosFaturamento);

            if (!$resultadoContaReceber['success']) {
                throw new Exception(implode('<br>', $resultadoContaReceber['error']));
            }

            $this->conn->commit();

            return [
                'success' => true,
                'message' => 'Ordem de serviço fechada e faturada com sucesso!'
            ];

        } catch (\Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            return [
                'success' => false,
                'error' => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function reabrir(int $ordemServicoId){
        try {
            $this->ordemServicoRepository->reabrir($ordemServicoId);

            return [
                'success' => true,
                'message' => 'Ordem de serviço foi reaberta com sucesso!'
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

    public function consultar(array $filtros): array{
        return $this->ordemServicoRepository->consultar($filtros);
    }

    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['pessoaId'])) {
            $erros[] = 'Informe o cliente.';
        }

        if (empty($dados['veiculoId'])) {
            $erros[] = 'Informe o veículo.';
        }

        if (empty($dados['descricao'])) {
            $erros[] = 'Informe o descriçao do problema do veículo.';
        }

        return $erros;
    }

}