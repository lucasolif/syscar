<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\EstoqueService;

class EstoqueController{
    private EstoqueService $estoqueService;

    public function __construct(){
        $this->estoqueService = new EstoqueService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/estoque/form-movimentacao.php';
    }

    public function movimentarEstoqueAvulso(): void{
        $dados = $_POST;
        $resultado = $this->estoqueService->movimentarEstoqueAvulso($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /estoque');
        exit;
    }

    public function consultarEstoque(): void{

        $estoque = [];

        if (!empty($_GET)) {
            $filtros = [
                'id' => $_GET['id'] ?? null,
                'nome' => $_GET['nome'] ?? null
            ];

            $estoque =  $this->estoqueService->consultarEstoque($filtros);
        }
        require __DIR__ . '/../Views/estoque/form-consultaEstoque.php';
    }

    public function consultarMovimentacao(): void{

        $movimentacoes = [];

        if (!empty($_GET)) {
            $filtros = [
                'produtoId' => $_GET['produtoId'] ?? null,
                'nome' => $_GET['nome'] ?? null,
                'tipoMovimento' => $_GET['tipoMovimento'] ?? null,
                'origem' => $_GET['origem'] ?? null,
                'dataMovimento' => $_GET['dataMovimento'] ?? null
            ];

            $movimentacoes =  $this->estoqueService->consultarMovimentacao($filtros);
        }
        require __DIR__ . '/../Views/estoque/form-consultaMovimentacao.php';
    }

}