<?php

namespace App\Models;

class Produto{
    private ?int $id;
    private string $nome;
    private string $marca;
    private ?string $descricao;
    private float $precoCusto;
    private float $precoVenda;
    private bool $ativo;


    public static function fromArray(array $dados): Produto{

        $produto = new Produto();

        $produto->setId(!empty($dados['id']) ? (int) $dados['id'] : null);
        $produto->setNome($dados["nome"]);
        $produto->setDescricao($dados["descricao"]);
        $produto->setMarca($dados["marca"]);
        $produto->setPrecoCusto($dados["precoCusto"]);
        $produto->setPrecoVenda($dados["precoVenda"]);
        $produto->setAtivo($dados['ativo'] ?? true);

        return $produto;
    }


    public function getId(): ?int{
        return $this->id;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function getDescricao(): ?string{
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): void{
        $this->descricao = $descricao;
    }

    public function getPrecoCusto(): float{
        return $this->precoCusto;
    }

    public function setPrecoCusto(float $precoCusto): void{
        $this->precoCusto = $precoCusto;
    }

    public function getPrecoVenda(): float{
        return $this->precoVenda;
    }

    public function setPrecoVenda(float $precoVenda): void{
        $this->precoVenda = $precoVenda;
    }

    public function getMarca(): string{
        return $this->marca;
    }

    public function setMarca(string $marca): void{
        $this->marca = $marca;
    }

    public function isAtivo(): bool{
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }

}