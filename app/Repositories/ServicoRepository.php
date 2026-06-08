<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Servico;
use PDO;

class ServicoRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "SELECT * FROM servicos WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $arrayServico = $stmt->fetch(PDO::FETCH_ASSOC);
        return $arrayServico ?: null;
    }

    public function buscarPorNomeId(string $filtro): array{
        $sql = "
            SELECT *
            FROM servicos
            WHERE nome LIKE :filtro
               OR id LIKE :filtro
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNomeIdAtivo(string $filtro): array{
        $sql = "
            SELECT *
            FROM servicos
            WHERE nome LIKE :filtro
               OR id LIKE :filtro
               AND ativo = true
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(Servico $servico): int{
        $sql = "
            INSERT INTO servicos (nome, descricao, valor, ativo)
            VALUES(:nome, :descricao, :valor, true)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nome' => $servico->getNome(),
            ':descricao' => $servico->getDescricao(),
            ':valor' => $servico->getValor()
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function alterar(Servico $servico): bool{
        $sql = "
            UPDATE servicos
            SET nome = :nome,
                descricao = :descricao,
                valor = :valor
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $servico->getId(),
            ':nome' => $servico->getNome(),
            ':descricao' => $servico->getDescricao(),
            ':valor' => $servico->getValor()
        ]);
    }

    public function foiUtilizado(int $id): bool{
        $sql = "
            SELECT COUNT(*)
            FROM ordem_servico_servicos
            WHERE servico_id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function inativar(int $id): bool{
        $sql = "UPDATE servicos SET ativo = false WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function excluir(int $id): bool{
        $sql = "DELETE FROM servicos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}