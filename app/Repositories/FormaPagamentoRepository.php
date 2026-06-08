<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\FormaPagamento;
use PDO;

class FormaPagamentoRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function consultarAtivas(): array{
        $sql = "SELECT * FROM formas_pagamento WHERE ativo = true";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id): ?array{
        $sql = "SELECT * FROM formas_pagamento WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $arrayFormaPagto = $stmt->fetch(PDO::FETCH_ASSOC);
        return $arrayFormaPagto ?: null;
    }

    public function buscarPorNomeId(string $filtro): array{
        $sql = "
            SELECT *
            FROM formas_pagamento
            WHERE nome LIKE :filtro
               OR id LIKE :filtro
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(FormaPagamento $formaPagto): int{
        $sql = "
            INSERT INTO formas_pagamento (nome, ativo)
            VALUES(:nome, true)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nome' => $formaPagto->getNome(),
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function alterar(FormaPagamento $formaPagto): bool{
        $sql = "
            UPDATE formas_pagamento
            SET nome = :nome,
                ativo = :ativo
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $formaPagto->getId(),
            ':nome' => $formaPagto->getNome(),
            ':ativo' => $formaPagto->isAtivo(),
        ]);
    }

    public function foiUtilizado(int $id): bool{
        $sql = "
            SELECT 
                (SELECT COUNT(*) FROM contas_receber WHERE forma_pagamento_id = :id)
                +
                (SELECT COUNT(*) FROM movimentos_caixa WHERE forma_pagamento_id = :id) AS total
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function inativar(int $id): bool{
        $sql = "UPDATE formas_pagamento SET ativo = false WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function excluir(int $id): bool{
        $sql = "DELETE FROM formas_pagamento WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

}