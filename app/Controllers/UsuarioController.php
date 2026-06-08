<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\UsuarioService;

class UsuarioController{
    private UsuarioService $usuarioService;

    public function __construct(){
        $this->usuarioService = new UsuarioService();
    }

    public function index(): void{
        $this->usuarioService->criarUsuarioInicial();
        require __DIR__ . '/../Views/usuario/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';

        $usuarios = $this->usuarioService->consultarPorLoginId($filtro);

        header('Content-Type: application/json');
        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->usuarioService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /usuario');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->usuarioService->alterar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /usuario');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];
        $resultado = $this->usuarioService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /usuario');
        exit;
    }

    public function alterarSenha(): void{
        $resultado = $this->usuarioService->alterarSenha($_POST);

        if ($resultado['success'] === true) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        $_SESSION['abrirModal'] = true;
        header('Location: /inicio');
        exit;
    }
}