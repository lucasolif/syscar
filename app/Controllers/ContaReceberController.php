<?php

namespace App\Controllers;

use App\Services\ContaReceberService;

class ContaReceberController{

    private ContaReceberService $contaReceberService;

    public function __construct(){
        $this->contaReceberService = new ContaReceberService();
    }

    public function index(): void{
        require __DIR__ . '/../Views/contaReceber/form-cadastro.php';
    }

    public function consultar(): void{

        $contasReceber = [];

        if (!empty($_GET)) {
            $filtros = [
                'cliente' => $_GET['cliente'] ?? null,
                'ordemServicoId' => $_GET['ordemServicoId'] ?? null,
                'formaPagamentoId' => $_GET['formaPagamentoId'] ?? null,
                'status' => $_GET['status'] ?? null,

                'dataGeracaoInicial' => $_GET['dataGeracaoInicial'] ?? null,
                'dataGeracaoFinal' => $_GET['dataGeracaoFinal'] ?? null,

                'dataVencimentoInicial' => $_GET['dataVencimentoInicial'] ?? null,
                'dataVencimentoFinal' => $_GET['dataVencimentoFinal'] ?? null,

                'dataPagamentoInicial' => $_GET['dataPagamentoInicial'] ?? null,
                'dataPagamentoFinal' => $_GET['dataPagamentoFinal'] ?? null,
            ];

            $contasReceber = $this->contaReceberService->consultar($filtros);
        }

        require __DIR__ . '/../Views/contaReceber/form-consulta.php';
    }
    public function baixar(int $id): void{
        $dados = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->contaReceberService->baixar($dados, $id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }

    public function cancelarBaixa(int $id): void{
        $resultado = $this->contaReceberService->cancelarBaixar($id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }

    public function cancelarContaReceber(int $id): void{
        $resultado = $this->contaReceberService->cancelarContaReceber($id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }
}