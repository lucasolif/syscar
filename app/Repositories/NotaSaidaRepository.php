<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\NotaSaida;
use Exception;
use PDO;

class NotaSaidaRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function gerarNotaSaida(NotaSaida $notaSaida): int{
        try{
            $sql = "
                INSERT INTO notas_saida (data_venda, pessoa_id, ativo) 
                VALUES (NOW(), :pessoaId, true)
            ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':pessoaId' => $notaSaida->getPessoaId(),
            ]);

            return (int) $this->conn->lastInsertId();
        }catch (Exception $e){
            throw $e;
        }

    }

}