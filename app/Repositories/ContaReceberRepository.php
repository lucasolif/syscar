<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\ContaReceber;
use App\Models\NotaSaida;
use App\Services\CaixaService;
use Exception;
use PDO;

class ContaReceberRepository{
    private PDO $conn;
    private NotaSaidaRepository $notaSaidaRepository;
    private CaixaService $caixaService;

    public function __construct(){
        $this->conn = Database::getConnection();
        $this->notaSaidaRepository = new NotaSaidaRepository();
        $this->caixaService = new CaixaService();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "
            SELECT
                cr.id,
                cr.descricao,
                cr.data_geracao AS dataGeracao,
                cr.data_cancelamento AS dataCancelamento,
                cr.data_vencimento AS dataVencimento,
                cr.data_pagamento AS dataPagamento,
                cr.nota_id AS notaId,
                cr.pessoa_id AS pessoaId,
                cr.origem,
                cr.os_id AS ordemServicoId,
                cr.forma_pagamento_id AS formaPagamentoId,
                cr.valor,
                cr.valor_pago AS valorPago,
                cr.valor_pendente AS valorPendente,
                cr.parcela,
                cr.status
            FROM contas_receber cr
            WHERE cr.id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $arrayContaReceber = $stmt->fetch(PDO::FETCH_ASSOC);
        return $arrayContaReceber ?: null;
    }

    public function salvar(array $arrayContaReceber): void{
        try {
            if (empty($arrayContaReceber)) {
                throw new Exception('Nenhuma conta a receber foi informada.');
            }

            // Gera nota fiscal pra vincular com as contas a receber
            $notaId = $this->gerarNota($arrayContaReceber[0]->getPessoaId());

            $sql = "
                INSERT INTO contas_receber (descricao, data_geracao, data_vencimento, nota_id, pessoa_id, origem, os_id, forma_pagamento_id, valor, valor_pago, valor_pendente, parcela, status) 
                VALUES (:descricao, NOW(), :dataVencimento, :notaId, :pessoaId, :origem, :osId, :formaPagamentoId, :valor, :valorPago, :valorPendente, :parcela, :status)
            ";

            $stmt = $this->conn->prepare($sql);

            foreach ($arrayContaReceber as $contaReceber) {
                $stmt->execute([
                    ':descricao' => $contaReceber->getDescricao(),
                    ':dataVencimento' => $contaReceber->getDataVencimento(),
                    ':notaId' => $notaId,
                    ':pessoaId' => $contaReceber->getPessoaId(),
                    ':origem' => $contaReceber->getOrigem(),
                    ':osId' => $contaReceber->getOsId(),
                    ':formaPagamentoId' => $contaReceber->getFormaPagamentoId(),
                    ':valor' => $contaReceber->getValor(),
                    ':valorPago' => $contaReceber->getValorPago(),
                    ':valorPendente' => $contaReceber->getValorPendente(),
                    ':parcela' => $contaReceber->getParcela(),
                    ':status' => $contaReceber->getStatus()
                ]);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function baixar(array $dadosPagamento): void{

        try{
            $this->conn->beginTransaction();

            $sql = "
                UPDATE contas_receber
                SET valor_pendente = :valorPendente,
                    valor_pago = :valorPago,
                    status = :status,
                    data_pagamento = :dataPagamento,
                    forma_pagamento_id = :formaPagamentoId
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $dadosPagamento['contaReceberId'],
                ':valorPendente' => $dadosPagamento['valorPendente'],
                ':valorPago' => $dadosPagamento['valorPago'],
                ':status' => $dadosPagamento['status'],
                ':dataPagamento' => $dadosPagamento['dataPagamento'],
                ':formaPagamentoId' => $dadosPagamento['formaPagamentoId']
            ]);

            $this->conn->commit();
        }catch(Exception $e){
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function cancelarBaixa(array $dadosCancelamento): void{

        try{
            $this->conn->beginTransaction();

            $sql = "
                UPDATE contas_receber
                SET valor_pendente = :valorPendente,
                    valor_pago = :valorPago,
                    status = :status,
                    data_pagamento = :dataPagamento
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $dadosCancelamento['contaReceberId'],
                ':valorPendente' => $dadosCancelamento['valorPendente'],
                ':valorPago' => $dadosCancelamento['valorPago'],
                ':status' => $dadosCancelamento['status'],
                ':dataPagamento' => $dadosCancelamento['dataPagamento']
            ]);

            $this->conn->commit();
        }catch(Exception $e){
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function cancelarContaReceber(array $dadosCancelamento): void{

        try{
            $this->conn->beginTransaction();

            $sql = "
                UPDATE contas_receber
                SET valor_pendente = :valorPendente,
                    valor_pago = :valorPago,
                    status = :status,
                    data_pagamento = :dataPagamento,
                    data_cancelamento = NOW()
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $dadosCancelamento['contaReceberId'],
                ':valorPendente' => $dadosCancelamento['valorPendente'],
                ':valorPago' => $dadosCancelamento['valorPago'],
                ':status' => $dadosCancelamento['status'],
                ':dataPagamento' => $dadosCancelamento['dataPagamento']
            ]);

            $this->conn->commit();
        }catch(Exception $e){
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    private function gerarNota(int $pessoaId): int{
        $notaSaida = new NotaSaida();
        $notaSaida->setPessoaId($pessoaId);

        return $this->notaSaidaRepository->gerarNotaSaida($notaSaida);
    }


    public function consultar(array $filtros): array{
        $sql = "
            SELECT 
                cr.id,
                cr.descricao,
                cr.data_geracao AS dataGeracao,
                cr.data_cancelamento AS dataCancelamento,
                cr.data_vencimento AS dataVencimento,
                cr.data_pagamento AS dataPagamento,
                cr.nota_id AS notaId,
                cr.os_id AS ordemServicoId,
                cr.pessoa_id AS pessoaId,
                p.nome AS pessoaNome,
                cr.origem,
                cr.forma_pagamento_id AS formaPagamentoId,
                fp.nome AS formaPagamentoNome,
                cr.valor,
                cr.valor_pago AS valorPago,
                cr.valor_pendente AS valorPendente,
                cr.parcela,
                cr.status
            FROM contas_receber cr
            LEFT JOIN pessoas p ON p.id = cr.pessoa_id
            INNER JOIN formas_pagamento fp ON fp.id = cr.forma_pagamento_id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filtros['cliente'])) {
            $sql .= " AND (p.id = :clienteId OR p.nome LIKE :clienteNome)";
            $params[':clienteId'] = $filtros['cliente'];
            $params[':clienteNome'] = '%' . $filtros['cliente'] . '%';
        }

        if (!empty($filtros['ordemServicoId'])) {
            $sql .= " AND cr.os_id = :ordemServicoId";
            $params[':ordemServicoId'] = $filtros['ordemServicoId'];
        }

        if (!empty($filtros['formaPagamentoId'])) {
            $sql .= " AND cr.forma_pagamento_id = :formaPagamentoId";
            $params[':formaPagamentoId'] = $filtros['formaPagamentoId'];
        }

        if (!empty($filtros['status'])) {
            $sql .= " AND cr.status = :status";
            $params[':status'] = $filtros['status'];
        }

        if (!empty($filtros['dataGeracaoInicial'])) {
            $sql .= " AND cr.data_geracao >= :dataGeracaoInicial";
            $params[':dataGeracaoInicial'] = $filtros['dataGeracaoInicial'] . ' 00:00:00';
        }

        if (!empty($filtros['dataGeracaoFinal'])) {
            $sql .= " AND cr.data_geracao <= :dataGeracaoFinal";
            $params[':dataGeracaoFinal'] = $filtros['dataGeracaoFinal'] . ' 23:59:59';
        }

        if (!empty($filtros['dataVencimentoInicial'])) {
            $sql .= " AND cr.data_vencimento >= :dataVencimentoInicial";
            $params[':dataVencimentoInicial'] = $filtros['dataVencimentoInicial'] . ' 00:00:00';
        }

        if (!empty($filtros['dataVencimentoFinal'])) {
            $sql .= " AND cr.data_vencimento <= :dataVencimentoFinal";
            $params[':dataVencimentoFinal'] = $filtros['dataVencimentoFinal'] . ' 23:59:59';
        }

        if (!empty($filtros['dataPagamentoInicial'])) {
            $sql .= " AND cr.data_pagamento >= :dataPagamentoInicial";
            $params[':dataPagamentoInicial'] = $filtros['dataPagamentoInicial'] . ' 00:00:00';
        }

        if (!empty($filtros['dataPagamentoFinal'])) {
            $sql .= " AND cr.data_pagamento <= :dataPagamentoFinal";
            $params[':dataPagamentoFinal'] = $filtros['dataPagamentoFinal'] . ' 23:59:59';
        }

        $sql .= " ORDER BY cr.id DESC";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}