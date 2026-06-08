<?php

namespace App\Services;

use App\Core\Database;
use App\Models\FormaPagamento;
use App\Repositories\FormaPagamentoRepository;
use Throwable;

class FormaPagamentoService{
    private FormaPagamentoRepository $formaPagtoRepository;

    public function __construct(){
        $this->formaPagtoRepository = new FormaPagamentoRepository();
    }

    public function consultarPorId(int $id): array{
        return $this->formaPagtoRepository->buscarPorId($id);
    }

    public function consultarPorNomeId(string $filtro): array{
        return $this->formaPagtoRepository->buscarPorNomeId($filtro);
    }

    public function consultarAtivas(): array{
        return $this->formaPagtoRepository->consultarAtivas();
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
            $formaPagto = FormaPagamento::fromArray($dados);
            $this->formaPagtoRepository->salvar($formaPagto);

            return [
                'success' => true,
                'message' => 'Forma de pagamento cadastrada com sucesso!'
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
            $formaPagto = FormaPagamento::fromArray($dados);
            $this->formaPagtoRepository->alterar($formaPagto);

            return [
                'success' => true,
                'message' => 'Forma de pagamento alterada com sucesso!'
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
        if ($this->formaPagtoRepository->foiUtilizado($id)) {
            $this->formaPagtoRepository->inativar($id);
            return [
                'success' => true,
                'message' => 'Forma de pagamento inativada!'
            ];
        }

        try {
            $this->formaPagtoRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Forma de pagamento excluída com sucesso!'
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
    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['nome'])) {
            $erros['nome'] = 'O nome da forma de pagamento é obrigatório.';
        }

        return $erros;
    }
}