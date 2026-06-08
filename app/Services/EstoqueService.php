<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Estoque;
use App\Models\MovimentoEstoque;
use App\Repositories\EstoqueRepository;
use DateTime;
use PDO;
use Throwable;

class EstoqueService{
    private EstoqueRepository $estoqueRepository;

    public function __construct(){
        $this->estoqueRepository = new EstoqueRepository();
    }
    public function movimentarEstoqueAvulso(array $dados): array{
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try {
            $estoque = Estoque::fromArray($dados);
            $tipoMovimento = $dados['tipoMovimento'];

            if($tipoMovimento == "SAIDA"){
                $this->estoqueRepository->saidaProdutoAvulsoEstoque($estoque);
            }else{
                $this->estoqueRepository->entradaProdutoAvulsoEstoque($estoque);
            }

            return [
                'success' => true,
                'message' => 'Produto registrado com sucesso!'
            ];

        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }
    public function consultarEstoque(array $filtros): array{
        return $this->estoqueRepository->consultarEstoque($filtros);
    }
    public function consultarMovimentacao(array $filtros): array{
        return $this->estoqueRepository->consultarMovimentacao($filtros);
    }
    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['produtoId'])) {
            $erros['produtoId'] = 'O produto é obrigatorio.';
        }

        if (empty($dados['quantidade'])) {
            $erros['quantidade'] = 'A quantidade do produto é obrigatorio.';
        }

        return $erros;
    }

}