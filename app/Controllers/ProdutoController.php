<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\ProdutoService;

class ProdutoController{

    private ProdutoService $produtoService;

    public function __construct(){
        $this->produtoService = new ProdutoService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/produto/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';
        $produtos = $this->produtoService->consultarPorNomeId($filtro);

        header('Content-Type: application/json');
        echo json_encode($produtos, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function buscarAtivos(): void{
        $filtro = $_GET['filtro'] ?? '';
        $produtos = $this->produtoService->consultarPorNomeIdAtivo($filtro);

        header('Content-Type: application/json');
        echo json_encode($produtos, JSON_UNESCAPED_UNICODE);
        exit;
    }


    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->produtoService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /produto');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->produtoService->alterar($dados);


        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /produto');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];
        $resultado = $this->produtoService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /produto');
        exit;
    }

    public function consultar(): void{

        $produtos = [];

        if (!empty($_GET)) {

            $filtros = [
                'id' => $_GET['id'] ?? null,
                'nome' => $_GET['nome'] ?? null,
                'marca' => $_GET['marca'] ?? null
            ];

            $produtos =  $this->produtoService->consultar($filtros);
        }
        require __DIR__ . '/../Views/produto/form-consulta.php';
    }
}