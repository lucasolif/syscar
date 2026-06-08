<?php

namespace App\Controllers;

use App\Core\Flash;
use App\Services\PessoaService;

class PessoaController{
    private PessoaService $pessoaService;

    public function __construct(){
        $this->pessoaService = new PessoaService();
    }

    public function index(): void{
        require __DIR__ . '/../Views/pessoa/form-cadastro.php';
    }

    public function buscar(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayPessoa = $this->pessoaService->consultarPorNomeId($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayPessoa, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function buscarAtivos(): void{
        $filtro = $_GET['filtro'] ?? '';

        $arrayPessoa = $this->pessoaService->consultarPorNomeIdAtivo($filtro);

        header('Content-Type: application/json');
        echo json_encode($arrayPessoa, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function salvar(): void{
        $dados = $_POST;
        $resultado = $this->pessoaService->salvar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /pessoa');
        exit;
    }

    public function editar(): void{
        $dados = $_POST;
        $resultado = $this->pessoaService->alterar($dados);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /pessoa');
        exit;
    }

    public function excluir(): void{
        $id = (int) $_POST['id'];
        $resultado = $this->pessoaService->excluir($id);

        if ($resultado['success']) {
            Flash::success($resultado['message']);
        } else {
            Flash::danger(implode('<br>', $resultado['error']));
        }

        header('Location: /pessoa');
        exit;
    }

    public function consultar(): void{

        $pessoas = [];

        if (!empty($_GET)) {
            $filtros = [
                'id' => $_GET['id'] ?? null,
                'nome' => $_GET['nome'] ?? null,
                'cpf' => $_GET['cpf'] ?? null
            ];

            $pessoas =  $this->pessoaService->consultar($filtros);
        }
        require __DIR__ . '/../Views/pessoa/form-consulta.php';
    }

}