<?php

namespace App\Models;

class OrdemServico
{
    private ?int $id = null;
    private Pessoa $pessoa;
    private Veiculo $veiculo;
    private string $dataAbertura;
    private ?string $dataFechamento = null;
    private ?string $dataCancelamento = null;
    private string $status;
    private ?string $descricao = null;
    private float $valorTotal = 0;
    private array $produtos = [];
    private array $servicos = [];

    public static function fromArray(array $dados): OrdemServico{
        $ordemServico = new OrdemServico();

        $ordemServico->setId(
            isset($dados['id']) && $dados['id'] !== ''
                ? (int) $dados['id']
                : null
        );

        $pessoa = new Pessoa();
        $pessoa->setId((int)$dados['pessoaId']);

        $veiculo = new Veiculo();
        $veiculo->setId((int)$dados['veiculoId']);

        $ordemServico->setPessoa($pessoa);
        $ordemServico->setVeiculo($veiculo);
        $ordemServico->setDataAbertura($dados['dataAbertura'] ?? date('Y-m-d H:i:s'));
        $ordemServico->setDataFechamento($dados['dataFechamento'] ?? null);
        $ordemServico->setDataCancelamento($dados['dataCancelamento'] ?? null);
        $ordemServico->setStatus($dados['status'] ?? 'ABERTA');
        $ordemServico->setDescricao($dados['descricao'] ?? null);
        $ordemServico->setValorTotal((float) ($dados['valorTotal'] ?? 0));
        $ordemServico->setProdutos($dados['produtos'] ?? []);
        $ordemServico->setServicos($dados['servicos'] ?? []);

        return $ordemServico;
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'pessoaId' => $this->pessoa->getId(),
            'veiculoId' => $this->veiculo->getId(),
            'dataAbertura' => $this->dataAbertura,
            'dataFechamento' => $this->dataFechamento,
            'dataCancelamento' => $this->dataCancelamento,
            'status' => $this->status,
            'descricao' => $this->descricao,
            'valorTotal' => $this->valorTotal,
            'produtos' => $this->produtos,
            'servicos' => $this->servicos
        ];
    }

    public function getId(): ?int{
        return $this->id;
    }

    public function getPessoa(): Pessoa{
        return $this->pessoa;
    }

    public function getVeiculo(): Veiculo{
        return $this->veiculo;
    }

    public function getDataAbertura(): string{
        return $this->dataAbertura;
    }

    public function getDataFechamento(): ?string{
        return $this->dataFechamento;
    }

    public function getDataCancelamento(): ?string{
        return $this->dataCancelamento;
    }

    public function getStatus(): string{
        return $this->status;
    }

    public function getDescricao(): ?string{
        return $this->descricao;
    }

    public function getValorTotal(): float{
        return $this->valorTotal;
    }

    public function getProdutos(): array{
        return $this->produtos;
    }

    public function getServicos(): array{
        return $this->servicos;
    }

    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setPessoa(Pessoa $pessoa): void{
        $this->pessoa = $pessoa;
    }

    public function setVeiculo(Veiculo $veiculo): void{
        $this->veiculo = $veiculo;
    }

    public function setDataAbertura(string $dataAbertura): void{
        $this->dataAbertura = $dataAbertura;
    }

    public function setDataFechamento(?string $dataFechamento): void{
        $this->dataFechamento = $dataFechamento;
    }

    public function setDataCancelamento(?string $dataCancelamento): void{
        $this->dataCancelamento = $dataCancelamento;
    }

    public function setStatus(string $status): void{
        $this->status = $status;
    }

    public function setDescricao(?string $descricao): void{
        $this->descricao = $descricao;
    }

    public function setValorTotal(float $valorTotal): void{
        $this->valorTotal = $valorTotal;
    }

    public function setProdutos(array $produtos): void{
        $this->produtos = $produtos;
    }

    public function setServicos(array $servicos): void{
        $this->servicos = $servicos;
    }
}