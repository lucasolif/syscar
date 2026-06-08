<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\AuthService;
use App\Services\UsuarioService;

class AuthController{
    private AuthService $authService;
    private UsuarioService $usuarioService;

    public function __construct(){
        $this->authService = new AuthService();
        $this->usuarioService = new UsuarioService();
    }

    public function login(): void{

        $this->usuarioService->criarUsuarioInicial();

        if (isset($_SESSION['usuario_id'])) {
            header('Location: /inicio');
            exit;
        }

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function autenticar(): void{
        $resultado = $this->authService->autenticar($_POST);

        if ($resultado['success']) {
            header('Location: /inicio');
            exit;
        }

        Flash::danger(implode('<br>', $resultado['error']));
        header('Location: /login');
        exit;
    }

    public function logout(): void{
        session_destroy();

        header('Location: /login');
        exit;
    }
}