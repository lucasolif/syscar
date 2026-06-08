<?php

namespace App\Services;

use App\Models\Servico;
use App\Repositories\ServicoRepository;
use Throwable;

class ServicoService{
    private ServicoRepository $servicoRepository;

    public function __construct(){
        $this->servicoRepository = new ServicoRepository();
    }

    public function consultarPorId(int $id): array{
        return $this->servicoRepository->buscarPorId($id);
    }

    public function consultarPorNomeId(string $filtro): array{
        return $this->servicoRepository->buscarPorNomeId($filtro);
    }

    public function consultarPorNomeIdAtivo(string $filtro): array{
        return $this->servicoRepository->buscarPorNomeIdAtivo($filtro);
    }

    public function salvar(array $dados): array{
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try {
            $contaCaixa = Servico::fromArray($dados);
            $this->servicoRepository->salvar($contaCaixa);

            return [
                'success' => true,
                'message' => 'Serviço cadastrado com sucesso!'
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

    public function alterar(array $dados): array{

        $dados['ativo'] = isset($dados['ativo']);
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try {
            $servico = Servico::fromArray($dados);
            $this->servicoRepository->alterar($servico);

            return [
                'success' => true,
                'message' => 'Serviço alterado com sucesso!'
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

    public function excluir(int $id): array{
        try{
            if ($this->servicoRepository->foiUtilizado($id)) {
                $this->servicoRepository->inativar($id);

                return [
                    'success' => true,
                    'message' => 'Serviço inativado com sucesso!.'
                ];
            }

            $this->servicoRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Serviço excluído com sucesso.'
            ];
        }catch (Throwable $e) {
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }
    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['nome'])) {
            $erros['nome'] = 'O nome do serviço é obrigatório.';
        }

        if (empty($dados['valor'])) {
            $erros['valor'] = 'O valor do serviço é obrigatório é obrigatório.';
        }

        return $erros;
    }
}