<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Estoque;
use Exception;
use PDO;

class EstoqueRepository{

    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function criarEstoqueInicial(int $produtoId): void{
        $sql = "
            INSERT INTO estoque (produto_id, quantidade)
            VALUES (:produtoId, :quantidade)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':produtoId' => $produtoId,
            ':quantidade' => 0
        ]);
    }

    public function saidaProdutoAvulsoEstoque(Estoque $estoque): void{

        try{
            $sql = "
                UPDATE estoque
                SET quantidade = quantidade - :quantidade
                WHERE produto_id = :produtoId
            ";

            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':produtoId' => $estoque->getProdutoId(),
                ':quantidade' => $estoque->getQuantidade()
            ]);

            $this->registrarMovimentoAvulsoEstoque($estoque, "SAIDA");
            $this->conn->commit();
        }catch (Exception $e) {
            throw $e;
        }
    }

    public function entradaProdutoAvulsoEstoque(Estoque $estoque): void{

        $sql = "
            UPDATE estoque
            SET quantidade = quantidade + :quantidade
            WHERE produto_id = :produtoId
        ";

        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':produtoId' => $estoque->getProdutoId(),
            ':quantidade' => $estoque->getQuantidade()
        ]);

        $this->registrarMovimentoAvulsoEstoque($estoque, "ENTRADA");
        $this->conn->commit();
    }

    public function saidaProdutosOsEstoque(array $produtosAdicionadoOs, int $ordemServicoId): void{

        try{
            $sql = "
                UPDATE estoque
                SET quantidade = quantidade - :quantidade
                WHERE produto_id = :produtoId
            ";

            $stmt = $this->conn->prepare($sql);

            foreach ($produtosAdicionadoOs as $produto) {
                $stmt->execute([
                    ':produtoId' => $produto['produtoId'],
                    ':quantidade' => $produto['quantidade']
                ]);
            }

            $this->registrarMovimentoOrdemServicoEstoque($produtosAdicionadoOs, 'SAIDA', $ordemServicoId);
        }catch (Exception $e) {
            throw new Exception(
                'Erro ao registrar a saída do estoque, referente aos produtos da OS',
                0,
                $e
            );
        }
    }

    public function entradaProdutosOsEstoque(array $produtosRemovidoOs): void{

        $ordemServicoId = null;

        $sql = "
            UPDATE estoque
            SET quantidade = quantidade + :quantidade
            WHERE produto_id = :produtoId
        ";

        $stmt = $this->conn->prepare($sql);

        foreach ($produtosRemovidoOs as $produto) {
            $stmt->execute([
                ':produtoId' => $produto['produtoId'],
                ':quantidade' => $produto['quantidade']
            ]);
            $ordemServicoId = $produto['ordemServicoId'];
        }

        $this->registrarMovimentoOrdemServicoEstoque($produtosRemovidoOs, 'ENTRADA', $ordemServicoId);
    }

    public function registrarMovimentoAvulsoEstoque(Estoque $mvEstoque, string $tipoMovimento): void{
        $sql = "
            INSERT INTO movimentos_estoque (produto_id, tipo_movimento, quantidade, origem)
            VALUES (:produtoId, :tipoMovimento, :quantidade, :origem)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':produtoId' => $mvEstoque->getProdutoId(),
            ':tipoMovimento' => $tipoMovimento,
            ':quantidade' => $mvEstoque->getQuantidade(),
            ':origem' => "AVULSO",
        ]);
    }

    public function registrarMovimentoOrdemServicoEstoque(array $produtos, string $tipoMovimento,  int $ordemServicoId): void {

        $sql = "
            INSERT INTO movimentos_estoque (produto_id, tipo_movimento, quantidade, origem, ordem_servico_id)
            VALUES (:produtoId, :tipoMovimento, :quantidade, :origem, :ordemServicoId)
        ";

        $stmt = $this->conn->prepare($sql);

        foreach ($produtos as $produto) {
            $stmt->execute([
                ':produtoId' => $produto['produtoId'],
                ':tipoMovimento' => $tipoMovimento,
                ':quantidade' => $produto['quantidade'],
                ':origem' => 'OS',
                ':ordemServicoId' => $ordemServicoId
            ]);
        }
    }

    public function buscarQtdEstoquePorId(int $produtoId): int{
        $sql = "
            SELECT quantidade
            FROM estoque
            WHERE produto_id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $produtoId
        ]);

        $resultado = $stmt->fetchColumn();

        return $resultado !== false ? (int) $resultado : 0;
    }

    public function consultarEstoque(array $filtros): array{
        $sql = "
            SELECT
                p.id AS produtoId,
                p.nome,
                p.marca,
                e.quantidade,
                ult.dataMovimento AS dataMovimento
            FROM estoque e
            INNER JOIN produtos p ON p.id = e.produto_id
            LEFT JOIN (
                SELECT 
                    produto_id,
                    MAX(data_movimento) AS dataMovimento
                FROM movimentos_estoque
                GROUP BY produto_id
            ) ult ON ult.produto_id = e.produto_id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filtros['id'])) {
            $sql .= " AND p.id = :id";
            $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['nome'])) {
            $sql .= " AND p.nome LIKE :nome";
            $params[':nome'] = '%' . $filtros['nome'] . '%';
        }

        $sql .= " ORDER BY p.nome";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultarMovimentacao(array $filtros): array{
        $sql = "
            SELECT
                m.id,
                m.produto_id AS produtoId,
                p.nome AS produtoNome,
                m.tipo_movimento as tipoMovimento,
                m.quantidade,
                m.origem,
                m.ordem_servico_id AS ordemServicoId,
                m.data_movimento as dataMovimento
            FROM movimentos_estoque m
            INNER JOIN produtos p ON p.id = m.produto_id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filtros['produtoId'])) {
            $sql .= " AND m.produto_id = :produtoId";
            $params[':produtoId'] = $filtros['produtoId'];
        }

        if (!empty($filtros['nome'])) {
            $sql .= " AND p.nome LIKE :nome";
            $params[':nome'] = '%' . $filtros['nome'] . '%';
        }

        if (!empty($filtros['tipoMovimento'])) {
            $sql .= " AND m.tipo_movimento = :tipoMovimento";
            $params[':tipoMovimento'] = $filtros['tipoMovimento'];
        }

        if (!empty($filtros['origem'])) {
            $sql .= " AND m.origem = :origem";
            $params[':origem'] = $filtros['origem'];
        }

        if (!empty($filtros['dataMovimento'])) {
            $sql .= " AND DATE(m.data_movimento) = :dataMovimento";
            $params[':dataMovimento'] = $filtros['dataMovimento'];
        }

        $sql .= " ORDER BY m.data_movimento DESC";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}