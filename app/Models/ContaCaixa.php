<?php

namespace App\Models;

class ContaCaixa{
    private ?int $id = null;
    private string $nome;
    private bool $ativo;
    private string $agencia;
    private string $conta;

    public static function fromArray(array $dados): ContaCaixa{
        $contaCaixa = new ContaCaixa();

        $contaCaixa->setId(
            isset($dados['id']) && $dados['id'] !== ''
                ? (int) $dados['id']
                : null
        );

        $contaCaixa->setNome($dados['nome']);
        $contaCaixa->setAtivo($dados['ativo'] ?? true);
        $contaCaixa->setAgencia($dados['agencia'] ?? true);
        $contaCaixa->setConta($dados['conta'] ?? true);

        return $contaCaixa;
    }
    public function toArray(): array{
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'ativo' => $this->ativo,
            'agencia' => $this->agencia,
            'conta' => $this->conta
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
    public function getAgencia(): string{
        return $this->agencia;
    }
    public function setAgencia(string $agencia): void{
        $this->agencia = $agencia;
    }
    public function getConta(): string{
        return $this->conta;
    }
    public function setConta(string $conta): void{
        $this->conta = $conta;
    }

}