<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\ServicoService;

class ServicoController{
    private ServicoService $servicoService;

    public function __construct(){
        $this->servicoService = new ServicoService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/servico/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayServico = $this->servicoService->consultarPorNomeId($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayServico, JSON_UNESCAPED_UNICODE);

        exit;
    }

    public function buscarAtivos(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayServico = $this->servicoService->consultarPorNomeIdAtivo($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayServico, JSON_UNESCAPED_UNICODE);

        exit;
    }

    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->servicoService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /servico');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->servicoService->alterar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /servico');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];

        $resultado = $this->servicoService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /servico');
        exit;
    }
}