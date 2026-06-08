<?php

namespace App\Models;

use DateTime;

class Pessoa{
    private ?int $id;
    private string $nome;
    private string $cpf;
    private string $telefone;
    private string $email;
    private ?DateTime $dataNascimento = null;
    private bool $ativo;
    private string $logradouro;
    private string $numero;
    private ?string $complemento;
    private string $bairro;
    private string $cidade;
    private string $cep;
    private string $estado;

    public static function fromArray(array $dados): Pessoa{
        $pessoa = new Pessoa();

        $pessoa->setId(!empty($dados['id']) ? (int) $dados['id'] : null);
        $pessoa->setNome($dados["nome"]);
        $pessoa->setCpf($dados["cpf"]);
        $pessoa->setTelefone($dados["telefone"]);
        $pessoa->setEmail($dados["email"]);
        $pessoa->setDataNascimento(new DateTime($dados["dataNascimento"]));
        $pessoa->setAtivo($dados["ativo"] ?? true);
        $pessoa->setLogradouro($dados["logradouro"]);
        $pessoa->setNumero($dados["numero"]);
        $pessoa->setComplemento($dados["complemento"]  ?? null);
        $pessoa->setBairro($dados["bairro"]);
        $pessoa->setCidade($dados["cidade"]);
        $pessoa->setCep($dados["cep"]);
        $pessoa->setEstado($dados["estado"]);

        return $pessoa;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'dataNascimento' => $this->dataNascimento->format('Y-m-d'),
            'ativo' => $this->ativo,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'cidade' => $this->cidade,
            'cep' => $this->cep,
            'estado' => $this->estado
        ];
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

    public function getCpf(): string{
        return $this->cpf;
    }

    public function getTelefone(): string{
        return $this->telefone;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getDataNascimento(): DateTime{
        return $this->dataNascimento;
    }

    public function setDataNascimento(DateTime $dataNascimento): void{
        $this->dataNascimento = $dataNascimento;
    }

    public function isAtivo(): bool{
        return $this->ativo;
    }

    public function getLogradouro(): string{
        return $this->logradouro;
    }

    public function getNumero(): string{
        return $this->numero;
    }

    public function getComplemento(): ?string{
        return $this->complemento;
    }

    public function getBairro(): string{
        return $this->bairro;
    }

    public function getCidade(): string{
        return $this->cidade;
    }

    public function getCep(): string{
        return $this->cep;
    }

    public function getEstado(): string{
        return $this->estado;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function setCpf(string $cpf): void{
        $this->cpf = $cpf;
    }

    public function setTelefone(string $telefone): void{
        $this->telefone = $telefone;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }

    public function setLogradouro(string $logradouro): void{
        $this->logradouro = $logradouro;
    }

    public function setNumero(string $numero): void{
        $this->numero = $numero;
    }

    public function setComplemento(?string $complemento): void{
        $this->complemento = $complemento;
    }

    public function setBairro(string $bairro): void{
        $this->bairro = $bairro;
    }

    public function setCidade(string $cidade): void{
        $this->cidade = $cidade;
    }

    public function setCep(string $cep): void{
        $this->cep = $cep;
    }

    public function setEstado(string $estado): void{
        $this->estado = $estado;
    }
}