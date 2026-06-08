<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\FormaPagamentoService;

class FormaPagamentoController{
    private FormaPagamentoService $formaPagtoService;

    public function __construct(){
        $this->formaPagtoService = new FormaPagamentoService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/formaPagamento/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayFormaPagamento = $this->formaPagtoService->consultarPorNomeId($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayFormaPagamento, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function listarAtivas(): void{
        $formasPagamento = $this->formaPagtoService->consultarAtivas();

        header('Content-Type: application/json');
        echo json_encode($formasPagamento);
        exit;
    }

    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->formaPagtoService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /forma-pagamento');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->formaPagtoService->alterar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /forma-pagamento');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];
        $resultado = $this->formaPagtoService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /forma-pagamento');
        exit;
    }
}