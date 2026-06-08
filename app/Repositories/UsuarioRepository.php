<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Usuario;
use PDO;

class UsuarioRepository{

    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "
            SELECT
                id,
                nome,
                login,
                senha,
                ativo
            FROM usuarios
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    public function buscarPorLogin(string $login): ?array{
        $sql = "
            SELECT
                id,
                nome,
                login,
                senha,
                ativo
            FROM usuarios
            WHERE login = :login
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':login', $login);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        return $usuario ?: null;
    }

    public function buscarPorNomeLoginId(string $filtro): array{
        $sql = "
            SELECT
                id,
                nome,
                login,
                ativo
            FROM usuarios
            WHERE login LIKE :filtro
               OR id LIKE :filtro
               OR nome LIKE :filtro
            LIMIT 20
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function existeAlgumUsuario(): bool{
        $sql = "SELECT COUNT(*) FROM usuarios";
        $stmt = $this->conn->query($sql);

        return $stmt->fetchColumn() > 0;
    }

    public function criarUsuarioPadrao(): void{
        $sql = "
            INSERT INTO usuarios (nome, login, senha, ativo)
            VALUES (:nome, :login, :senha, true)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nome' => 'Administrador',
            ':login' => 'admin',
            ':senha' => password_hash('admin123', PASSWORD_DEFAULT)
        ]);
    }

    public function salvar(Usuario $usuario): void{
        $sql = "
            INSERT INTO usuarios (nome, login,senha, ativo)
            VALUES (:nome, :login, :senha, true)
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':nome' => $usuario->getNome(),
            ':login' => $usuario->getLogin(),
            ':senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT)
        ]);

        $this->conn->lastInsertId();
    }

    public function alterar(Usuario $usuario): bool{
        if (!empty($usuario->getSenha())) {
            $sql = "
                UPDATE usuarios
                SET nome = :nome,
                    senha = :senha,
                    ativo = :ativo
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            return $stmt->execute([
                ':id' => $usuario->getId(),
                ':nome' => $usuario->getNome(),
                ':senha' => password_hash($usuario->getSenha(), PASSWORD_DEFAULT),
                ':ativo' => $usuario->isAtivo()
            ]);
        }

        $sql = "
            UPDATE usuarios
            SET nome = :nome,
                ativo = :ativo
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $usuario->getId(),
            ':nome' => $usuario->getNome(),
            ':ativo' => $usuario->isAtivo()
        ]);
    }

    public function excluir(int $id): void{
        $sql = "DELETE FROM usuarios WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function inativar(int $id): void{
        $sql = "UPDATE usuarios SET ativo = false WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function alterarSenha(int $id, string $senha): bool{
        $sql = "
            UPDATE usuarios
            SET senha = :senha
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':senha' => password_hash($senha, PASSWORD_DEFAULT)
        ]);
    }
}