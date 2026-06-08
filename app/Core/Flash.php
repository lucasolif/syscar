<?php

namespace App\Core;

class Flash{
    public static function success(string $mensagem): void{
        $_SESSION['flash'] = [
            'tipo' => 'success',
            'mensagem' => $mensagem
        ];
    }

    public static function warning(string $mensagem): void{
        $_SESSION['flash'] = [
            'tipo' => 'warning',
            'mensagem' => $mensagem
        ];
    }

    public static function danger(string $mensagem): void{
        $_SESSION['flash'] = [
            'tipo' => 'danger',
            'mensagem' => $mensagem
        ];
    }
}