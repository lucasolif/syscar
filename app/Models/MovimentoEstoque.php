<?php

namespace App\Models;

use DateTime;

class MovimentoEstoque{
    private ?int $id;
    private int $produtoId;
    private string $tipoMovimento;
    private int $quantidade;
    private string $origem;
    private ?int $ordemServicoId;
    private DateTime $dataMovimento;

    public static function fromArray(array $dados): MovimentoEstoque{
        $movimento = new MovimentoEstoque();

        $movimento->setProdutoId($dados['produtoId']);
        $movimento->setTipoMovimento($dados['tipoMovimento']);
        $movimento->setQuantidade($dados['quantidade']);
        $movimento->setOrigem($dados['origem']);
        $movimento->setOrdemServicoId($dados['ordemServicoId'] ?? null);

        return $movimento;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'produtoId' => $this->produtoId,
            'tipoMovimento' => $this->tipoMovimento,
            'quantidade' => $this->quantidade,
            'origem' => $this->origem,
            'ordemServicoId' => $this->ordemServicoId,
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getProdutoId(): int{
        return $this->produtoId;
    }

    public function setProdutoId(int $produtoId): void{
        $this->produtoId = $produtoId;
    }

    public function getTipoMovimento(): string{
        return $this->tipoMovimento;
    }

    public function setTipoMovimento(string $tipoMovimento): void{
        $this->tipoMovimento = $tipoMovimento;
    }

    public function getQuantidade(): int{
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): void{
        $this->quantidade = $quantidade;
    }

    public function getOrigem(): string{
        return $this->origem;
    }

    public function setOrigem(string $origem): void{
        $this->origem = $origem;
    }

    public function getOrdemServicoId(): ?int{
        return $this->ordemServicoId;
    }

    public function setOrdemServicoId(?int $ordemServicoId): void{
        $this->ordemServicoId = $ordemServicoId;
    }

    public function getDataMovimento(): ?DateTime{
        return $this->dataMovimento;
    }

    public function setDataMovimento(?DateTime $dataMovimento): void{
        $this->dataMovimento = $dataMovimento;
    }
}