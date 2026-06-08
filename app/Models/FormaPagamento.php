<?php

namespace App\Models;

class FormaPagamento{
    private ?int $id = null;
    private string $nome;
    private bool $ativo;

    public static function fromArray(array $dados): FormaPagamento{
        $formaPagamento = new FormaPagamento();

        $formaPagamento->setId(
            isset($dados['id']) && $dados['id'] !== ''
                ? (int) $dados['id']
                : null
        );

        $formaPagamento->setNome($dados['nome']);
        $formaPagamento->setAtivo($dados['ativo'] ?? true);

        return $formaPagamento;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'ativo' => $this->ativo
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function isAtivo(): bool{
        return $this->ativo;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }
}