<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\AuthService;

class AuthController{
    private AuthService $authService;

    public function __construct(){
        $this->authService = new AuthService();
    }

    public function login(): void{

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