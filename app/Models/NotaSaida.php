<?php

namespace App\Models;

class NotaSaida{
    private ?int $id;
    private string $dataVenda;
    private ?string $dataCancelamento;
    private ?int $pessoaId;
    private bool $ativo;

    public static function fromArray(array $dados): NotaSaida{
        $nota = new NotaSaida();

        $nota->setId($dados['id'] ?? null);
        $nota->setDataVenda($dados['dataVenda']);
        $nota->setDataCancelamento($dados['dataCancelamento'] ?? null);
        $nota->setPessoaId($dados['pessoaId'] ?? null);
        $nota->setAtivo($dados['ativo'] ?? true);

        return $nota;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'dataVenda' => $this->dataVenda,
            'dataCancelamento' => $this->dataCancelamento,
            'pessoaId' => $this->pessoaId,
            'ativo' => $this->ativo
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getDataVenda(): string{
        return $this->dataVenda;
    }

    public function getDataCancelamento(): ?string{
        return $this->dataCancelamento;
    }

    public function getPessoaId(): ?int{
        return $this->pessoaId;
    }

    public function isAtivo(): bool{
        return $this->ativo;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setDataVenda(string $dataVenda): void{
        $this->dataVenda = $dataVenda;
    }

    public function setDataCancelamento(?string $dataCancelamento): void{
        $this->dataCancelamento = $dataCancelamento;
    }

    public function setPessoaId(?int $pessoaId): void{
        $this->pessoaId = $pessoaId;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }
}