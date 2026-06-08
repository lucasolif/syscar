<?php

namespace App\Models;

class Usuario{
    private ?int $id;
    private string $login;
    private string $nome;
    private ?string $senha;
    private bool $ativo;


    public static function fromArray(array $dados): Usuario{
        $usuario = new Usuario();

        $usuario->setId(!empty($dados['id']) ? (int) $dados['id'] : null);
        $usuario->setNome($dados['nome']);
        $usuario->setLogin($dados['login']);
        $usuario->setSenha($dados['senha'] ?? null);
        $usuario->setAtivo(isset($dados['ativo']));

        return $usuario;
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function getLogin(): string{
        return $this->login;
    }

    public function setLogin(string $login): void{
        $this->login = $login;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function getSenha(): ?string{
        return $this->senha;
    }

    public function setSenha(?string $senha): void{
        $this->senha = $senha;
    }

    public function isAtivo(): bool{
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }
}