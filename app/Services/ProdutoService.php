<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;
use Throwable;

class ProdutoService{
    private ProdutoRepository $produtoRepository;

    public function __construct(){
        $this->produtoRepository = new ProdutoRepository();
    }

    public function consultarPorId(int $id): array{
        return $this->produtoRepository->buscarPorId($id);
    }

    public function consultarPorNomeId(string $filtro): array{
        return $this->produtoRepository->buscarPorNomeId($filtro);
    }

    public function consultarPorNomeIdAtivo(string $filtro): array{
        return $this->produtoRepository->buscarPorNomeIdAtivo($filtro);
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
            $produto = Produto::fromArray($dados);
            $this->produtoRepository->salvar($produto);

            return [
                'success' => true,
                'message' => 'Produto cadastrado com sucesso!'
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
            $produto = Produto::fromArray($dados);
            $this->produtoRepository->alterar($produto);

            return [
                'success' => true,
                'message' => 'Produto alterado com sucesso!'
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
        if ($this->produtoRepository->foiUtilizado($id)) {
            $this->produtoRepository->inativar($id);

            return [
                'success' => true,
                'message' => 'Produto inativado com sucesso!'
            ];
        }

        try {
            $this->produtoRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Produto excluído com sucesso!'
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
            $erros['nome'] = 'O nome do produto é obrigatório.';
        }

        if (empty($dados['precoCusto'])) {
            $erros['precoCusto'] = 'O preço de custo é obrigatório.';
        }


        if (isset($dados['precoCusto']) && $dados['precoCusto'] < 0) {
            $erros['precoCusto'] = 'O preço de custo não pode ser negativo.';
        }

        if (empty($dados['precoVenda'])) {
            $erros['precoVenda'] = 'O preço de venda é obrigatório.';
        }


        if (isset($dados['precoVenda']) && $dados['precoVenda'] < 0) {
            $erros['precoVenda'] = 'O preço de venda não pode ser negativo.';
        }

        if (empty($dados['marca'])) {
            $erros['marca'] = 'A marca do produto é obrigatório.';
        }

        return $erros;
    }

    public function consultar(array $filtros): array{
        return $this->produtoRepository->consultar($filtros);
    }
}