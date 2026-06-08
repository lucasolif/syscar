<?php

namespace App\Models;

class Caixa{
    private ?int $id;
    private ?int $contaReceberId;
    private float $valor;
    private string $tipoMovimento;
    private string $dataMovimento;
    private ?string $dataCancelamento;
    private string $origem;
    private string $descricao;
    private int $contaCaixaId;
    private int $formaPagamentoId;
    private bool $ativo;


    public static function fromArray(array $dados): Caixa{
        $movimentoCaixa = new Caixa();

        $movimentoCaixa->setId($dados['id'] ?? null);
        $movimentoCaixa->setContaReceberId($dados['contaReceberId'] ?? null);
        $movimentoCaixa->setValor((float) $dados['valor']);
        $movimentoCaixa->setTipoMovimento($dados['tipoMovimento']);
        $movimentoCaixa->setDataMovimento($dados['dataMovimento']);
        $movimentoCaixa->setDataCancelamento($dados['dataCancelamento'] ?? null);
        $movimentoCaixa->setOrigem($dados['origem']);
        $movimentoCaixa->setDescricao($dados['descricao']);
        $movimentoCaixa->setContaCaixaId($dados['contaCaixaId']);
        $movimentoCaixa->setFormaPagamentoId($dados['formaPagamentoId']);
        $movimentoCaixa->setAtivo($dados['ativo'] ?? true);

        return $movimentoCaixa;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'contaReceberId' => $this->contaReceberId,
            'valor' => $this->valor,
            'tipoMovimento' => $this->tipoMovimento,
            'dataMovimento' => $this->dataMovimento,
            'dataCancelamento' => $this->dataCancelamento,
            'origem' => $this->origem,
            'descricao' => $this->descricao,
            'contaCaixaId' => $this->contaCaixaId,
            'formaPagamentoId' => $this->formaPagamentoId,
            'ativo' => $this->ativo
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getContaReceberId(): ?int{
        return $this->contaReceberId;
    }

    public function getValor(): float{
        return $this->valor;
    }

    public function getTipoMovimento(): string{
        return $this->tipoMovimento;
    }

    public function getDataMovimento(): string{
        return $this->dataMovimento;
    }

    public function getDataCancelamento(): ?string{
        return $this->dataCancelamento;
    }

    public function getOrigem(): string{
        return $this->origem;
    }

    public function getDescricao(): string{
        return $this->descricao;
    }

    public function getContaCaixaId(): int{
        return $this->contaCaixaId;
    }

    public function getFormaPagamentoId(): int{
        return $this->formaPagamentoId;
    }

    public function getAtivo(): bool{
        return $this->ativo;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setContaReceberId(?int $contaReceberId): void{
        $this->contaReceberId = $contaReceberId;
    }

    public function setValor(float $valor): void{
        $this->valor = $valor;
    }

    public function setTipoMovimento(string $tipoMovimento): void{
        $this->tipoMovimento = $tipoMovimento;
    }

    public function setDataMovimento(string $dataMovimento): void{
        $this->dataMovimento = $dataMovimento;
    }

    public function setDataCancelamento(?string $dataCancelamento): void{
        $this->dataCancelamento = $dataCancelamento;
    }

    public function setOrigem(string $origem): void{
        $this->origem = $origem;
    }

    public function setDescricao(string $descricao): void{
        $this->descricao = $descricao;
    }

    public function setContaCaixaId(int $contaCaixaId): void{
        $this->contaCaixaId = $contaCaixaId;
    }

    public function setFormaPagamentoId(int $formaPagamentoId): void{
        $this->formaPagamentoId = $formaPagamentoId;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }
}