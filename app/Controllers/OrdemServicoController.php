<?php

namespace App\Controllers;

use App\Services\OrdemServicoService;

class OrdemServicoController{
    private OrdemServicoService $ordemServicoService;

    public function __construct(){
        $this->ordemServicoService = new OrdemServicoService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/ordemServico/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayOrdem = $this->ordemServicoService->buscarPorPessoaVeiculoOrdem($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayOrdem, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function consultarPorId(int $id): void{
        $ordemServico = $this->ordemServicoService->consultarPorId($id);

        header('Content-Type: application/json');
        echo json_encode($ordemServico, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function salvar(): void{
        $dados = json_decode(file_get_contents('php://input'), true);

        $resultado = $this->ordemServicoService->salvar($dados);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }

    public function editar(): void{
        $dados = json_decode(file_get_contents('php://input'), true);

        $resultado = $this->ordemServicoService->editar($dados);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }
    public function cancelar(int $id): void{
        $resultado = $this->ordemServicoService->cancelar($id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }
    public function fechar(int $id): void{
        $resultado = $this->ordemServicoService->fechar($id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }
    public function faturar(int $id): void{
        $dados = json_decode(file_get_contents('php://input'), true);
        $resultado = $this->ordemServicoService->faturar($dados, $id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }
    public function reabrir(int $id): void{
        $resultado = $this->ordemServicoService->reabrir($id);

        header('Content-Type: application/json');

        echo json_encode($resultado);
        exit;
    }

    public function consultar(): void{

        $ordensServico = [];

        if (!empty($_GET)) {
            $filtros = [
                'id' => $_GET['id'] ?? null,
                'pessoa' => $_GET['pessoa'] ?? null,
                'placa' => $_GET['placa'] ?? null,
                'status' => $_GET['status'] ?? null,

                'dataAberturaInicial' => $_GET['dataAberturaInicial'] ?? null,
                'dataAberturaFinal' => $_GET['dataAberturaFinal'] ?? null,

                'dataFechamentoInicial' => $_GET['dataFechamentoInicial'] ?? null,
                'dataFechamentoFinal' => $_GET['dataFechamentoFinal'] ?? null,

                'dataFaturamentoInicial' => $_GET['dataFaturamentoInicial'] ?? null,
                'dataFaturamentoFinal' => $_GET['dataFaturamentoFinal'] ?? null,
            ];

            $ordensServico = $this->ordemServicoService->consultar($filtros);
        }

        require __DIR__ . '/../Views/ordemServico/form-consulta.php';
    }
}