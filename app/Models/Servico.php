<?php

namespace App\Models;

class Servico
{
    private ?int $id = null;
    private string $nome;
    private ?string $descricao = null;
    private float $valor;
    private bool $ativo;

    public static function fromArray(array $dados): Servico{
        $servico = new Servico();

        $servico->setId(
            isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null
        );

        $servico->setNome($dados['nome']);
        $servico->setDescricao($dados['descricao'] ?? null);
        $servico->setValor((float) $dados['valor']);
        $servico->setAtivo($dados['ativo'] ?? true);

        return $servico;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'descricao' => $this->getDescricao(),
            'valor' => $this->getValor(),
            'ativo' => $this->isAtivo()
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function getDescricao(): ?string{
        return $this->descricao;
    }

    public function getValor(): float{
        return $this->valor;
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

    public function setDescricao(?string $descricao): void{
        $this->descricao = $descricao;
    }

    public function setValor(float $valor): void{
        $this->valor = $valor;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }
}