<?php

namespace App\Models;

class Estoque{

    private ?int $id;
    private int $produtoId;
    private int $quantidade;

    public static function fromArray(array $dados): Estoque{

        $estoque = new Estoque();

        $estoque->setId(isset($dados['id']) && $dados['id'] !== '' ? (int) $dados['id'] : null);
        $estoque->setQuantidade($dados['quantidade']);
        $estoque->setProdutoId($dados['produtoId']);

        return $estoque;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'produtoId' => $this->produtoId,
            'quantidade' => $this->quantidade
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function getProdutoId(): int{
        return $this->produtoId;
    }

    public function setProdutoId(int $produtoId): void{
        $this->produtoId = $produtoId;
    }

    public function getQuantidade(): int{
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): void{
        $this->quantidade = $quantidade;
    }

}