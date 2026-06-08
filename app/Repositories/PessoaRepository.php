<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Pessoa;
use PDO;

class PessoaRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "SELECT * FROM pessoas WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $arrayPessoa = $stmt->fetch(PDO::FETCH_ASSOC);
        return $arrayPessoa ?: null;
    }

    public function buscarNomePessoa(int $id): string{
        $sql = "SELECT nome FROM pessoas WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['nome'] ?? '';
    }

    public function buscarPorNomeId(string $filtro): array{
        $sql = "
            SELECT 
                id,
                nome,
                cpf,
                telefone,
                email,
                data_nascimento as dataNascimento,
                ativo,
                logradouro,
                numero,
                complemento,
                bairro,
                cidade,
                cep,
                estado
            FROM pessoas
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
            SELECT 
                id,
                nome,
                cpf,
                telefone,
                email,
                data_nascimento as dataNascimento,
                ativo,
                logradouro,
                numero,
                complemento,
                bairro,
                cidade,
                cep,
                estado
            FROM pessoas
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

    public function salvar(Pessoa $pessoa): int{
        $sql = "
            INSERT INTO pessoas (nome, cpf, telefone, email, data_nascimento, ativo, logradouro, numero, complemento, bairro, cidade, cep, estado)
            VALUES(:nome, :cpf, :telefone, :email, :dataNacimento, true, :logradouro, :numero, :complemento, :bairro, :cidade, :cep, :estado)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nome' => $pessoa->getNome(),
            ':cpf' => $pessoa->getCpf(),
            ':telefone' => $pessoa->getTelefone(),
            ':email' => $pessoa->getEmail(),
            ':dataNacimento' => $pessoa->getDataNascimento()->format('Y-m-d'),
            ':logradouro' => $pessoa->getLogradouro(),
            ':numero' => $pessoa->getNumero(),
            ':complemento' => $pessoa->getComplemento(),
            ':bairro' => $pessoa->getBairro(),
            ':cidade' => $pessoa->getCidade(),
            ':cep' => $pessoa->getCep(),
            ':estado' => $pessoa->getEstado(),
        ]);

        return (int) $this->conn->lastInsertId();
    }

    public function alterar(Pessoa $pessoa): bool{
        $sql = "
            UPDATE pessoas
            SET nome = :nome,
                cpf = :cpf,
                telefone = :telefone,
                email = :email,
                data_nascimento = :dataNacimento,
                ativo = :ativo,
                logradouro = :logradouro,
                numero = :numero,
                complemento = :complemento,
                bairro = :bairro,
                cidade = :cidade,
                cep = :cep,
                estado = :estado
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $pessoa->getId(),
            ':nome' => $pessoa->getNome(),
            ':cpf' => $pessoa->getCpf(),
            ':telefone' => $pessoa->getTelefone(),
            ':email' => $pessoa->getEmail(),
            ':dataNacimento' => $pessoa->getDataNascimento()->format('Y-m-d'),
            ':ativo' => $pessoa->isAtivo(),
            ':logradouro' => $pessoa->getLogradouro(),
            ':numero' => $pessoa->getNumero(),
            ':complemento' => $pessoa->getComplemento(),
            ':bairro' => $pessoa->getBairro(),
            ':cidade' => $pessoa->getCidade(),
            ':cep' => $pessoa->getCep(),
            ':estado' => $pessoa->getEstado()
        ]);
    }

    public function foiUtilizado(int $id): bool{
        $sql = "
            SELECT 
                (SELECT COUNT(*) FROM notas WHERE pessoa_id = :id)
                +
                (SELECT COUNT(*) FROM ordens_servico WHERE pessoa_id = :id)
                +
                (SELECT COUNT(*) FROM contas_receber WHERE pessoa_id = :id) AS total
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function inativar(int $id): bool{
        $sql = "UPDATE pessoas SET ativo = false WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function excluir(int $id): bool{
        $sql = "DELETE FROM pessoas WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }

    public function consultar(array $filtros): array{
        $sql = "SELECT *  FROM pessoas p WHERE 1 = 1";

        $params = [];

        if (!empty($filtros['id'])) {
            $sql .= " AND p.id = :id";
            $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['nome'])) {
            $sql .= " AND p.nome LIKE :nome";
            $params[':nome'] = '%' . $filtros['nome'] . '%';
        }

        if (!empty($filtros['cpf'])) {
            $sql .= " AND p.cpf LIKE :cpf";
            $params[':cpf'] = '%' . $filtros['cpf'] . '%';
        }

        $sql .= " ORDER BY p.nome";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}