<?php

namespace App\Services;

use App\Core\Database;
use App\Models\ContaCaixa;
use App\Repositories\ContaCaixaRepository;
use PDO;
use Throwable;

class ContaCaixaService{
    private ContaCaixaRepository $contaCaixaRepository;

    public function __construct(){
        $this->contaCaixaRepository = new ContaCaixaRepository();
    }

    public function consultarAtivas(): array{
        return $this->contaCaixaRepository->consultarAtivas();
    }

    public function consultarPorId(int $id): array{
        return $this->contaCaixaRepository->buscarPorId($id);
    }
    public function consultarPorNomeId(string $filtro): array{
        return $this->contaCaixaRepository->buscarPorNomeId($filtro);
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
            $contaCaixa = ContaCaixa::fromArray($dados);
            $this->contaCaixaRepository->salvar($contaCaixa);

            return [
                'success' => true,
                'message' => 'Conta caixa cadastrada com sucesso!'
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
            $contaCaixa = ContaCaixa::fromArray($dados);
            $this->contaCaixaRepository->alterar($contaCaixa);

            return [
                'success' => true,
                'message' => 'Conta caixa alterada com sucesso!'
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
            if ($this->contaCaixaRepository->foiUtilizado($id)) {
                $this->contaCaixaRepository->inativar($id);

                return [
                    'success' => true,
                    'message' => 'Conta caixa inativada, pois já possui movimentações.'
                ];
            }

            $this->contaCaixaRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Conta caixa excluída com sucesso.'
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
            $erros['nome'] = 'O nome da conta caixa é obrigatório.';
        }

        return $erros;
    }
}