<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\OrdemServico;
use PDO;
use Exception;

class OrdemServicoRepository{
    private PDO $conn;
    private EstoqueRepository $estoqueRepository;

    public function __construct(){
        $this->conn = Database::getConnection();
        $this->estoqueRepository = new EstoqueRepository();
    }

    public function buscarPorId(int $id): ?array{
        $sql = "
            SELECT 
                os.id,
                os.pessoa_id as pessoaId,
                os.veiculo_id as veiculoId,
                DATE_FORMAT(os.data_abertura, '%Y-%m-%d') as dataAbertura,
                DATE_FORMAT(os.data_fechamento, '%Y-%m-%d') as dataFechamento,
                DATE_FORMAT(os.data_cancelamento, '%Y-%m-%d') as dataCancelamento,
                os.status as status,
                os.valor_total as valorTotal,
                os.descricao as descricao,
                p.nome as pessoaNome,
                p.cpf as pessoaCpf,
                p.telefone as pessoaTelefone,
                p.email as pessoaEmail,
                p.logradouro as pessoaLogradouro,
                p.numero as pessoaNumero, 
                p.complemento as pessoaComplemento,
                p.bairro as pessoaBairro,
                p.cidade as pessoaCidade,
                p.cep as pessoaCep,
                p.estado as pessoaEstado,
                v.cor as veiculoCor,
                v.marca as veiculoMarca,
                v.modelo as veiculoModelo,
                v.placa as veiculoPlaca,
                v.tipo as veiculoTipo,
                v.ano as veiculoAno
            FROM ordens_servico os
            INNER JOIN pessoas p ON p.id = os.pessoa_id
            INNER JOIN veiculos v ON v.id = os.veiculo_id
            WHERE os.id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $ordemServico = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ordemServico) {
            return null;
        }

        $ordemServico['produtos'] = $this->buscarProdutos($id);
        $ordemServico['servicos'] = $this->buscarServicos($id);

        return $ordemServico;
    }

    public function buscarPorPessoaVeiculoOrdem(string $filtro): array{
        $sql = "
            SELECT 
                os.id as id,
                os.pessoa_id as pessoaId,
                os.veiculo_id as veiculoId,
                os.data_abertura as dataAbertura,
                os.data_fechamento as dataFechamento,
                os.data_cancelamento as dataCancelamento,
                os.status as status,
                os.valor_total as valorTotal,
                p.nome AS pessoaNome,
                v.placa AS veiculoPlaca
            FROM ordens_servico os
            INNER JOIN pessoas p ON p.id = os.pessoa_id
            INNER JOIN veiculos v ON v.id = os.veiculo_id
        ";

        if (substr($filtro, 0, 1) === '*') {
            $filtro = substr($filtro, 1);
            $sql .= "
                WHERE os.id LIKE :filtro
                ORDER BY os.id DESC
                LIMIT 20
            ";
        } else {
            $sql .= "
                WHERE os.pessoa_id LIKE :filtro
                   OR p.nome LIKE :filtro
                   OR v.placa LIKE :filtro
                ORDER BY os.id DESC
                LIMIT 20
            ";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':filtro', "%{$filtro}%");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function salvar(OrdemServico $ordemServico): void{
        try {
            $this->conn->beginTransaction();

            $sql = "
                INSERT INTO ordens_servico (pessoa_id, veiculo_id, status, descricao, valor_total)
                VALUES(:pessoaId, :veiculoId, 'ABERTA', :descricao, :valorTotal)
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':pessoaId' => $ordemServico->getPessoa()->getId(),
                ':veiculoId' => $ordemServico->getVeiculo()->getId(),
                ':descricao' => $ordemServico->getDescricao(),
                ':valorTotal' => $ordemServico->getValorTotal()
            ]);

            $ordemServicoId = (int) $this->conn->lastInsertId();

            if(count($ordemServico->getProdutos()) > 0){
                $this->adicionarProdutos($ordemServicoId, $ordemServico->getProdutos());
            }

            if(count($ordemServico->getServicos()) > 0){
                $this->adicionarServicos($ordemServicoId, $ordemServico->getServicos());
            }

            $this->conn->commit();
        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $e;
        }
    }

    public function editar(OrdemServico $ordemServico): void{
        try {
            $this->conn->beginTransaction();

            $sql = "
                UPDATE ordens_servico
                SET pessoa_id = :pessoaId,
                    veiculo_id = :veiculoId,
                    descricao = :descricao,
                    valor_total = :valorTotal
                WHERE id = :id
            ";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $ordemServico->getId(),
                ':pessoaId' => $ordemServico->getPessoa()->getId(),
                ':veiculoId' => $ordemServico->getVeiculo()->getId(),
                ':descricao' => $ordemServico->getDescricao(),
                ':valorTotal' => $ordemServico->getValorTotal()
            ]);

            $this->excluirProdutos($ordemServico->getId());
            $this->excluirServicos($ordemServico->getId());

            if(count($ordemServico->getProdutos()) > 0){
                $this->adicionarProdutos($ordemServico->getId(), $ordemServico->getProdutos());
            }

            if(count($ordemServico->getServicos()) > 0){
                $this->adicionarServicos($ordemServico->getId(), $ordemServico->getServicos());
            }

            $this->conn->commit();

        } catch (Exception $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            throw $e;
        }
    }

    public function fechar(int $id): void{
        $sql = "
            UPDATE ordens_servico
            SET status = 'FECHADA',
                data_fechamento = NOW()
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function faturar(int $id): void{
        $sql = "
            UPDATE ordens_servico
            SET status = 'FATURADA',
                data_fechamento = COALESCE(data_fechamento, NOW()),
                data_faturamento = NOW()
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function reabrir(int $id): void{
        $sql = "
            UPDATE ordens_servico
            SET status = 'ABERTA',
                data_fechamento = null
            WHERE id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function cancelar(int $ordemServicoId): void{
        try{
            $sql = "
                UPDATE ordens_servico
                SET status = 'CANCELADA',
                    data_cancelamento = NOW()
                WHERE id = :id
            ";

            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $ordemServicoId]);

            $produtosOrdemServico = $this->buscarProdutos($ordemServicoId);
            $this->entradaProdutoEstoque($produtosOrdemServico);

            $this->conn->commit();
        }catch(Exception $e){
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            throw $e;
        }
    }

    public function consultar(array $filtros): array{
        $sql = "
            SELECT 
                os.id,
                os.status,
                os.data_abertura AS dataAbertura,
                os.data_fechamento AS dataFechamento,
                os.data_faturamento AS dataFaturamento,
                os.valor_total AS valorTotal,
                p.id AS pessoaId,
                p.nome AS pessoaNome,
                v.placa AS veiculoPlaca
            FROM ordens_servico os
            INNER JOIN pessoas p ON p.id = os.pessoa_id
            INNER JOIN veiculos v ON v.id = os.veiculo_id
            WHERE 1 = 1
        ";

        $params = [];

        if (!empty($filtros['id'])) {
            $sql .= " AND os.id = :id";
            $params[':id'] = $filtros['id'];
        }

        if (!empty($filtros['pessoa'])) {
            $sql .= " AND (p.id = :pessoaId OR p.nome LIKE :pessoaNome)";
            $params[':pessoaId'] = $filtros['pessoa'];
            $params[':pessoaNome'] = '%' . $filtros['pessoa'] . '%';
        }

        if (!empty($filtros['placa'])) {
            $sql .= " AND v.placa LIKE :placa";
            $params[':placa'] = '%' . $filtros['placa'] . '%';
        }

        if (!empty($filtros['status'])) {
            $sql .= " AND os.status = :status";
            $params[':status'] = $filtros['status'];
        }

        if (!empty($filtros['dataAberturaInicial'])) {
            $sql .= " AND os.data_abertura >= :dataAberturaInicial";
            $params[':dataAberturaInicial'] = $filtros['dataAberturaInicial'] . ' 00:00:00';
        }

        if (!empty($filtros['dataAberturaFinal'])) {
            $sql .= " AND os.data_abertura <= :dataAberturaFinal";
            $params[':dataAberturaFinal'] = $filtros['dataAberturaFinal'] . ' 23:59:59';
        }

        if (!empty($filtros['dataFechamentoInicial'])) {
            $sql .= " AND os.data_fechamento >= :dataFechamentoInicial";
            $params[':dataFechamentoInicial'] = $filtros['dataFechamentoInicial'] . ' 00:00:00';
        }

        if (!empty($filtros['dataFechamentoFinal'])) {
            $sql .= " AND os.data_fechamento <= :dataFechamentoFinal";
            $params[':dataFechamentoFinal'] = $filtros['dataFechamentoFinal'] . ' 23:59:59';
        }

        if (!empty($filtros['dataFaturamentoInicial'])) {
            $sql .= " AND os.data_faturamento >= :dataFaturamentoInicial";
            $params[':dataFaturamentoInicial'] = $filtros['dataFaturamentoInicial'] . ' 00:00:00';
        }

        if (!empty($filtros['dataFaturamentoFinal'])) {
            $sql .= " AND os.data_faturamento <= :dataFaturamentoFinal";
            $params[':dataFaturamentoFinal'] = $filtros['dataFaturamentoFinal'] . ' 23:59:59';
        }

        $sql .= " ORDER BY os.id DESC";

        $stmt = $this->conn->prepare($sql);

        foreach ($params as $campo => $valor) {
            $stmt->bindValue($campo, $valor);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    private function adicionarProdutos(int $ordemServicoId, array $produtos): void{
        $sql = "
            INSERT INTO ordem_servico_produtos(ordem_servico_id, produto_id, quantidade, valor_unitario, valor_total)
            VALUES(:ordemServicoId, :produtoId, :quantidade, :valorUnitario, :valorTotal)
        ";

        $stmt = $this->conn->prepare($sql);

        foreach ($produtos as $produto) {
            $stmt->execute([
                ':ordemServicoId' => $ordemServicoId,
                ':produtoId' => $produto['produtoId'],
                ':quantidade' => $produto['quantidade'],
                ':valorUnitario' => $produto['valorUnitario'],
                ':valorTotal' => $produto['valorTotal']
            ]);
        }

        //Saída do produto do estoque, que foram adicionados na OS
        $this->saidaProdutoEstoque($produtos, $ordemServicoId);
    }

    private function adicionarServicos(int $ordemServicoId, array $servicos): void{

        $sql = "
            INSERT INTO ordem_servico_servicos(ordem_servico_id, servico_id, quantidade, valor_unitario, valor_total)
            VALUES(:ordemServicoId, :servicoId, :quantidade, :valorUnitario, :valorTotal)
        ";

        $stmt = $this->conn->prepare($sql);

        foreach ($servicos as $servico) {
            $stmt->execute([
                ':ordemServicoId' => $ordemServicoId,
                ':servicoId' => $servico['servicoId'],
                ':quantidade' => $servico['quantidade'] ?? 1,
                ':valorUnitario' => $servico['valorUnitario'],
                ':valorTotal' => $servico['valorTotal']
            ]);
        }
    }

    private function buscarProdutos(int $ordemServicoId): array{
        $sql = "
            SELECT 
                osp.id,
                osp.ordem_servico_id as ordemServicoId,
                osp.produto_id as produtoId,
                osp.quantidade as quantidade,
                osp.valor_unitario as valorUnitario,
                osp.valor_total as valorTotal,
                p.nome as nome
            FROM ordem_servico_produtos osp
            INNER JOIN produtos p ON p.id = osp.produto_id
            WHERE osp.ordem_servico_id = :ordem_servico_id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ordem_servico_id' => $ordemServicoId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function buscarServicos(int $ordemServicoId): array{
        $sql = "
            SELECT 
                oss.id,
                oss.ordem_servico_id as ordemServicoId,
                oss.servico_id as servicoId,
                oss.quantidade as quantidade,
                oss.valor_unitario as valorUnitario,
                oss.valor_total as valorTotal,
                s.nome as nome
            FROM ordem_servico_servicos oss
            INNER JOIN servicos s ON s.id = oss.servico_id
            WHERE oss.ordem_servico_id = :ordem_servico_id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ordem_servico_id' => $ordemServicoId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function excluirProdutos(int $ordemServicoId): void{

        $sql = "
            DELETE FROM ordem_servico_produtos
            WHERE ordem_servico_id = :ordemServicoId
        ";


        //Busca os produtos que foram excluídos da OS, e retornado para o estoque
        $produtosExcluidosOs = $this->buscarProdutos($ordemServicoId);

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ordemServicoId' => $ordemServicoId]);

        //Adiciona os produtos que estavam na OS, de volta ao estoque.
        if(count($produtosExcluidosOs) > 0){
            $this->entradaProdutoEstoque($produtosExcluidosOs);
        }

    }

    private function excluirServicos(int $ordemServicoId): bool{
        $sql = "
            DELETE FROM ordem_servico_servicos
            WHERE ordem_servico_id = :ordemServicoId
        ";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':ordemServicoId' => $ordemServicoId
        ]);
    }

    private function saidaProdutoEstoque(array $produtosAdicionadoOs, int $ordemServicoId): void{
         $this->estoqueRepository->saidaProdutosOsEstoque($produtosAdicionadoOs, $ordemServicoId);
    }

    private function entradaProdutoEstoque(array $produtosExcluidoOs): void{
        $this->estoqueRepository->entradaProdutosOsEstoque($produtosExcluidoOs);
    }
}