<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Produto;
use Exception;
use PDO;

class ProdutoRepository{
    private PDO $conn;
    private EstoqueRepository $estoqueRepository;

    public function __construct(){
        $this->conn = Database::getConnection();
        $this->estoqueRepository = new EstoqueRepository();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "SELECT * FROM produtos WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $produto ?: null;
    }

    public function buscarPorNomeId(string $filtro): array{
        $sql = "
            SELECT 
                id,
                nome,
                marca,
                descricao,
                preco_venda as precoVenda,
                preco_custo as precoCusto,
                ativo
            FROM produtos
            WHERE nome LIKE :filtro
               OR id LIKE :filtro
            LIMIT 50
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNomeIdAtivo(string $filtro): array{
        $sql = "
            SELECT 
                p.id,
                p.nome,
                p.marca,
                p.descricao,
                p.preco_venda AS precoVenda,
                p.preco_custo AS precoCusto,
                p.ativo,
                COALESCE(e.quantidade, 0) AS quantidade
            FROM produtos p
            LEFT JOIN estoque e ON e.produto_id = p.id
            WHERE (p.nome LIKE :filtro
                OR p.id LIKE :filtro)
                AND p.ativo = true
            LIMIT 50
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(Produto $produto): void{
        try {
            $sql = "
                INSERT INTO produtos (nome, marca, descricao, preco_custo, preco_venda, ativo)
                VALUES(:nome, :marca, :descricao, :precoCusto, :precoVenda, true)
            ";

            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nome' => $produto->getNome(),
                ':marca' => $produto->getMarca(),
                ':descricao' => $produto->getDescricao(),
                ':precoCusto' => $produto->getPrecoCusto(),
                ':precoVenda' => $produto->getPrecoVenda(),
            ]);

            $idproduto = (int)$this->conn->lastInsertId();
            $this->criarEstoqueInicial($idproduto);

            $this->conn->commit();
        } catch (\Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function alterar(Produto $produto): void{

        $sql = "
            UPDATE produtos
            SET nome = :nome,
                marca = :marca,
                descricao = :descricao,
                preco_custo = :precoCusto,
                preco_venda = :precoVenda,
                ativo = :ativo
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $produto->getId(),
            ':nome' => $produto->getNome(),
            ':marca' => $produto->getMarca(),
            ':descricao' => $produto->getDescricao(),
            ':precoCusto' => $produto->getPrecoCusto(),
            ':precoVenda' => $produto->getPrecoVenda(),
            ':ativo' => $produto->isAtivo(),
        ]);

    }

    public function foiUtilizado(int $id): bool{
        $sql = "
            SELECT 
                (SELECT COUNT(*) FROM estoque WHERE produto_id = :id and quantidade <> 0)
                +
                (SELECT COUNT(*) FROM movimentos_estoque WHERE produto_id = :id and quantidade <> 0)
                +
                (SELECT COUNT(*) FROM ordem_servico_produtos WHERE produto_id = :id) AS total
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function inativar(int $id): void{
        $sql = "UPDATE produtos SET ativo = false WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function excluir(int $id): void{
        $sql = "DELETE FROM produtos WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function consultar(array $filtros): array{
        $sql = "
            SELECT 
                p.id,
                p.nome,
                p.marca,
                p.preco_custo As precoCusto,
                p.preco_venda as precoVenda,
                p.ativo,
                COALESCE(e.quantidade, 0) AS quantidade
            FROM produtos p
            LEFT JOIN estoque e ON e.produto_id = p.id
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

        if (!empty($filtros['marca'])) {
            $sql .= " AND p.marca LIKE :marca";
            $params[':marca'] = '%' . $filtros['marca'] . '%';
        }

        $sql .= " ORDER BY p.nome";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function criarEstoqueInicial(int $produtoId): void{
        $this->estoqueRepository->criarEstoqueInicial($produtoId);
    }
}