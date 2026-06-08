<?php

namespace App\Services;

use App\Repositories\UsuarioRepository;

class AuthService{
    private UsuarioRepository $usuarioRepository;

    public function __construct(){
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function autenticar(array $dados): array{
        if (empty($dados['login']) || empty($dados['senha'])) {
            return [
                'success' => false,
                'error' => ['Informe login e senha.']
            ];
        }

        $usuario = $this->usuarioRepository->buscarPorLogin($dados['login']);

        if (!$usuario) {
            return [
                'success' => false,
                'error' => ['Login ou senha inválidos.']
            ];
        }

        if (!$usuario['ativo']) {
            return [
                'success' => false,
                'error' => ['Usuário inativo.']
            ];
        }

        if (!password_verify($dados['senha'], $usuario['senha'])) {
            return [
                'success' => false,
                'error' => ['Login ou senha inválidos.']
            ];
        }

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_login'] = $usuario['login'];

        return [
            'success' => true
        ];
    }
}