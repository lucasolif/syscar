<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\VeiculoService;

class VeiculoController{
    private VeiculoService $veiculoService;

    public function __construct(){
        $this->veiculoService = new VeiculoService();
    }
    public function index(): void{
        require __DIR__ . '/../Views/veiculo/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';
        $arrayVeiculo = $this->veiculoService->consultarPorPlacaId($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayVeiculo, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function buscarAtivos(): void{
        $filtro = $_GET['filtro'] ?? '';
        $arrayVeiculo = $this->veiculoService->consultarPorPlacaIdAtivo($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayVeiculo, JSON_UNESCAPED_UNICODE);
        exit;
    }


    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->veiculoService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /veiculo');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->veiculoService->alterar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /veiculo');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];
        $resultado = $this->veiculoService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /veiculo');
        exit;
    }

    public function consultar(): void{

        $veiculos = [];

        if (!empty($_GET)) {
            $filtros = [
                'id' => $_GET['id'] ?? null,
                'nome' => $_GET['nome'] ?? null,
                'cpf' => $_GET['cpf'] ?? null
            ];
            $veiculos =  $this->veiculoService->consultar($filtros);
        }

        require __DIR__ . '/../Views/veiculo/form-consulta.php';
    }
}