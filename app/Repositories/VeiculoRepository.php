<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Veiculo;
use PDO;

class VeiculoRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "SELECT * FROM veiculos WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $arrayVeiculo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $arrayVeiculo ?: null;
    }

    public function buscarPorPlacaId(string $filtro): array{
        $sql = "
            SELECT *
            FROM veiculos
            WHERE placa LIKE :filtro
               or modelo LIKE :filtro
               OR id LIKE :filtro
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorPlacaIdAtivo(string $filtro): array{
        $sql = "
            SELECT *
            FROM veiculos
            WHERE placa LIKE :filtro
               or modelo LIKE :filtro
               OR id LIKE :filtro
               AND ativo = true
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvar(Veiculo $veiculo): int{
        $sql = "
            INSERT INTO veiculos (cor, marca, modelo, placa, tipo, ano, ativo)
            VALUES(:cor, :marca, :modelo, :placa, :tipo, :ano, true)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':cor' => $veiculo->getCor(),
            ':marca' => $veiculo->getMarca(),
            ':modelo' => $veiculo->getModelo(),
            ':placa' => $veiculo->getPlaca(),
            ':tipo' => $veiculo->getTipo(),
            ':ano' => $veiculo->getAno()
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function alterar(Veiculo $veiculo): bool{
        $sql = "
            UPDATE veiculos
            SET cor = :cor,
                marca = :marca,
                modelo = :modelo,
                placa = :placa,
                tipo = :tipo,
                ano = :ano,
                ativo = :ativo
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $veiculo->getId(),
            ':cor' => $veiculo->getCor(),
            ':marca' => $veiculo->getMarca(),
            ':modelo' => $veiculo->getModelo(),
            ':placa' => $veiculo->getPlaca(),
            ':tipo' => $veiculo->getTipo(),
            ':ano' => $veiculo->getAno(),
            ':ativo' => $veiculo->isAtivo(),
        ]);
    }

    public function foiUtilizado(int $id): bool{

        $sql = "
            SELECT COUNT(*)
            FROM ordens-servico
            WHERE veiculo_id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function inativar(int $id): bool{
        $sql = "UPDATE veiculos SET ativo = false WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function excluir(int $id): bool{
        $sql = "DELETE FROM veiculos WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function consultar(array $filtros): array{
        $sql = "SELECT *  FROM veiculos v WHERE 1 = 1";
        $params = [];

        if (!empty($filtros['id'])) {
            $sql .= " AND v.id = :id";
            $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['modelo'])) {
            $sql .= " AND v.modelo LIKE :modelo";
            $params[':modelo'] = '%' . $filtros['modelo'] . '%';
        }

        if (!empty($filtros['placa'])) {
            $sql .= " AND v.placa LIKE :placa";
            $params[':placa'] = '%' . $filtros['placa'] . '%';
        }

        if (!empty($filtros['marca'])) {
            $sql .= " AND v.marca LIKE :marca";
            $params[':marca'] = '%' . $filtros['marca'] . '%';
        }

        if (!empty($filtros['tipo'])) {
            $sql .= " AND v.tipo = :tipo";
            $params[':tipo'] = $filtros['tipo'];
        }

        $sql .= " ORDER BY v.modelo ASC";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}