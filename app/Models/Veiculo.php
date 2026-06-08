<?php

namespace App\Models;

class Veiculo{
    private ?int $id = null;
    private string $cor;
    private string $marca;
    private string $modelo;
    private string $placa;
    private string $tipo;
    private int $ano;
    private bool $ativo;

    public static function fromArray(array $dados): Veiculo{
        $veiculo = new Veiculo();

        $veiculo->setId(
            isset($dados['id']) && $dados['id'] !== ''
                ? (int) $dados['id']
                : null
        );

        $veiculo->setCor($dados['cor']);
        $veiculo->setMarca($dados['marca']);
        $veiculo->setModelo($dados['modelo']);
        $veiculo->setPlaca(strtoupper($dados['placa']));
        $veiculo->setTipo($dados['tipo']);
        $veiculo->setAno($dados['ano']);
        $veiculo->setAtivo($dados['ativo'] ?? true);

        return $veiculo;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'cor' => $this->cor,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'placa' => $this->placa,
            'tipo' => $this->tipo,
            'ano' => $this->ano,
            'ativo' => $this->ativo
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getCor(): ?string{
        return $this->cor;
    }

    public function getMarca(): string{
        return $this->marca;
    }

    public function getModelo(): string{
        return $this->modelo;
    }

    public function getPlaca(): string{
        return $this->placa;
    }

    public function getAno(): ?int{
        return $this->ano;
    }

    public function isAtivo(): bool{
        return $this->ativo;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setCor(?string $cor): void{
        $this->cor = $cor;
    }

    public function setMarca(string $marca): void{
        $this->marca = $marca;
    }

    public function setModelo(string $modelo): void{
        $this->modelo = $modelo;
    }

    public function setPlaca(string $placa): void{
        $this->placa = $placa;
    }

    public function setAno(?int $ano): void{
        $this->ano = $ano;
    }

    public function setAtivo(bool $ativo): void{
        $this->ativo = $ativo;
    }

    public function getTipo(): string{
        return $this->tipo;
    }

    public function setTipo(string $tipo): void{
        $this->tipo = $tipo;
    }


}