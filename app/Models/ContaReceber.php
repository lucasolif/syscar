<?php

namespace App\Models;

class ContaReceber{
    private ?int $id;
    private string $descricao;
    private ?string $dataGeracao;
    private ?string $dataCancelamento;
    private string $dataVencimento;
    private ?string $dataPagamento;
    private int $notaId;
    private ?int $pessoaId;
    private string $origem;
    private ?int $osId;
    private int $formaPagamentoId;
    private float $valor;
    private float $valorPago;
    private float $valorPendente;
    private int $parcela;
    private string $status;

    public static function fromArray(array $dados): ContaReceber{

        $contaReceber = new ContaReceber();

        $contaReceber->setId($dados['id'] ?? null);
        $contaReceber->setDescricao($dados['descricao']);
        $contaReceber->setDataGeracao($dados['dataGeracao']  ?? null);
        $contaReceber->setDataCancelamento($dados['dataCancelamento'] ?? null);
        $contaReceber->setDataPagamento($dados['dataPagamento'] ?? null);
        $contaReceber->setDataVencimento($dados['dataVencimento']);
        $contaReceber->setPessoaId($dados['pessoaId'] ?? null);
        $contaReceber->setOrigem($dados['origem']);
        $contaReceber->setOsId($dados['osId'] ?? null);
        $contaReceber->setFormaPagamentoId($dados['formaPagamentoId']);
        $contaReceber->setValor((float) $dados['valor']);
        $contaReceber->setValorPago((float) ($dados['valorPago'] ?? 0));
        $contaReceber->setValorPendente((float) ($dados['valorPendente'] ?? $dados['valor']));
        $contaReceber->setParcela($dados['parcela']);
        $contaReceber->setStatus($dados['status'] ?? 'PENDENTE');

        return $contaReceber;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'dataGeracao' => $this->dataGeracao,
            'dataCancelamento' => $this->dataCancelamento,
            'dataVencimento' => $this->dataVencimento,
            'dataPagamento' => $this->dataPagamento,
            'notaId' => $this->notaId,
            'pessoaId' => $this->pessoaId,
            'origem' => $this->origem,
            'osId' => $this->osId,
            'formaPagamentoId' => $this->formaPagamentoId,
            'valor' => $this->valor,
            'valorPago' => $this->valorPago,
            'valorPendente' => $this->valorPendente,
            'parcela' => $this->parcela,
            'status' => $this->status
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getDescricao(): string{
        return $this->descricao;
    }

    public function getDataGeracao(): ?string{
        return $this->dataGeracao;
    }

    public function getDataCancelamento(): ?string{
        return $this->dataCancelamento;
    }

    public function getDataVencimento(): string{
        return $this->dataVencimento;
    }

    public function getNotaId(): int{
        return $this->notaId;
    }

    public function getPessoaId(): ?int{
        return $this->pessoaId;
    }

    public function getOrigem(): string{
        return $this->origem;
    }

    public function getOsId(): ?int{
        return $this->osId;
    }

    public function getFormaPagamentoId(): int{
        return $this->formaPagamentoId;
    }

    public function getValor(): float{
        return $this->valor;
    }

    public function getValorPago(): float{
        return $this->valorPago;
    }

    public function getValorPendente(): float{
        return $this->valorPendente;
    }

    public function getParcela(): int{
        return $this->parcela;
    }

    public function getStatus(): string{
        return $this->status;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setDescricao(string $descricao): void{
        $this->descricao = $descricao;
    }

    public function setDataGeracao(?string $dataGeracao): void{
        $this->dataGeracao = $dataGeracao;
    }

    public function setDataCancelamento(?string $dataCancelamento): void{
        $this->dataCancelamento = $dataCancelamento;
    }

    public function setDataVencimento(string $dataVencimento): void{
        $this->dataVencimento = $dataVencimento;
    }

    public function setNotaId(int $notaId): void{
        $this->notaId = $notaId;
    }

    public function setPessoaId(?int $pessoaId): void{
        $this->pessoaId = $pessoaId;
    }

    public function setOrigem(string $origem): void{
        $this->origem = $origem;
    }

    public function setOsId(?int $osId): void{
        $this->osId = $osId;
    }

    public function setFormaPagamentoId(int $formaPagamentoId): void{
        $this->formaPagamentoId = $formaPagamentoId;
    }

    public function setValor(float $valor): void{
        $this->valor = $valor;
    }

    public function setValorPago(float $valorPago): void{
        $this->valorPago = $valorPago;
    }

    public function setValorPendente(float $valorPendente): void{
        $this->valorPendente = $valorPendente;
    }

    public function setParcela(int $parcela): void{
        $this->parcela = $parcela;
    }

    public function setStatus(string $status): void{
        $this->status = $status;
    }

    public function getDataPagamento(): ?string{
        return $this->dataPagamento;
    }

    public function setDataPagamento(?string $dataPagamento): void{
        $this->dataPagamento = $dataPagamento;
    }

}