<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Caixa;
use Exception;
use PDO;

class CaixaRepository{
    private PDO $conn;

    public function __construct(){
        $this->conn = Database::getConnection();
    }

    public function movimentarCaixa(Caixa $movimentoCaixa): void{
        try {
            $sql = "
                INSERT INTO movimentos_caixa (conta_receber_id, valor, tipo_movimento, data_movimento, origem, descricao, conta_caixa_id, forma_pagamento_id, ativo)
                VALUES (:contaReceberId, :valor, :tipoMovimento, NOW(), :origem, :descricao, :contaCaixaId, :formaPagamentoId, true)
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':contaReceberId' => $movimentoCaixa->getContaReceberId(),
                ':valor' => $movimentoCaixa->getValor(),
                ':tipoMovimento' => $movimentoCaixa->getTipoMovimento(),
                ':dataCancelamento' => $movimentoCaixa->getDataCancelamento(),
                ':origem' => $movimentoCaixa->getOrigem(),
                ':descricao' => $movimentoCaixa->getDescricao(),
                ':contaCaixaId' => $movimentoCaixa->getContaCaixaId(),
                ':formaPagamentoId' => $movimentoCaixa->getFormaPagamentoId()
            ]);

        } catch (Exception $e) {
            throw $e;
        }
    }
}