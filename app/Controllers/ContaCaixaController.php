<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\ContaCaixaService;

class ContaCaixaController{
    private ContaCaixaService $contaCaixaService;

    public function __construct(){
        $this->contaCaixaService = new ContaCaixaService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/contaCaixa/form-cadastro.php';
    }

    public function listarAtivas(): void{
        $contasCaixa = $this->contaCaixaService->consultarAtivas();

        header('Content-Type: application/json');
        echo json_encode($contasCaixa);
        exit;
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayContaCaixa = $this->contaCaixaService->consultarPorNomeId($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayContaCaixa, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->contaCaixaService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /conta-caixa');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->contaCaixaService->alterar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /conta-caixa');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];

        $resultado = $this->contaCaixaService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /conta-caixa');
        exit;
    }

}