<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\ContaCaixa;
use PDO;

class ContaCaixaRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "SELECT * FROM contas_caixa WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $arrayContaCaixa = $stmt->fetch(PDO::FETCH_ASSOC);
        return $arrayContaCaixa ?: null;
    }

    public function consultarAtivas(): array{
        $sql = "SELECT * FROM contas_caixa WHERE ativo = true";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorNomeId(string $filtro): array{
        $sql = "
            SELECT *
            FROM contas_caixa
            WHERE nome LIKE :filtro
               OR id LIKE :filtro
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(ContaCaixa $contaCaixa): int{
        $sql = "
            INSERT INTO contas_caixa (nome, ativo, agencia, conta)
            VALUES(:nome, true, :agencia, :conta)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nome' => $contaCaixa->getNome(),
            ':agencia' => $contaCaixa->getAgencia(),
            ':conta' => $contaCaixa->getConta(),
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function alterar(ContaCaixa $contaCaixa): bool{
        $sql = "
            UPDATE contas_caixa
            SET nome = :nome,
                ativo = :ativo,
                agencia = :agencia,
                conta = :conta
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $contaCaixa->getId(),
            ':nome' => $contaCaixa->getNome(),
            ':ativo' => $contaCaixa->isAtivo(),
            ':agencia' => $contaCaixa->getAgencia(),
            ':conta' => $contaCaixa->getConta()
        ]);
    }

    public function foiUtilizado(int $id): bool{
        $sql = "
            SELECT COUNT(*)
            FROM movimentos_caixa
            WHERE conta_caixa_id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function inativar(int $id): bool{
        $sql = "UPDATE contas_caixa SET ativo = false WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function excluir(int $id): bool{
        $sql = "DELETE FROM contas_caixa WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

}