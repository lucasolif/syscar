<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Veiculo;
use App\Repositories\VeiculoRepository;
use Throwable;

class VeiculoService{
    private VeiculoRepository $veiculoRepository;

    public function __construct(){
        $this->veiculoRepository = new VeiculoRepository();
    }

    public function consultarPorId(int $id): array{
        return $this->veiculoRepository->buscarPorId($id);
    }

    public function consultarPorPlacaId(string $filtro): array{
        return $this->veiculoRepository->buscarPorPlacaId($filtro);
    }

    public function consultarPorPlacaIdAtivo(string $filtro): array{
        return $this->veiculoRepository->buscarPorPlacaIdAtivo($filtro);
    }

    public function salvar(array $dados): array{
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try {
            $veiculo = Veiculo::fromArray($dados);
            $this->veiculoRepository->salvar($veiculo);

            return [
                'success' => true,
                'message' => 'Veículo cadastrado com sucesso!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function alterar(array $dados): array{
        $dados['ativo'] = isset($dados['ativo']);
        $erros = $this->validar($dados);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error'  => $erros
            ];
        }

        try {
            $veiculo = Veiculo::fromArray($dados);
            $this->veiculoRepository->alterar($veiculo);

            return [
                'success' => true,
                'message' => 'Veículo alterado com sucesso!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function excluir(int $id): array{
        if ($this->veiculoRepository->foiUtilizado($id)) {
            $this->veiculoRepository->inativar($id);

            return [
                'success' => true,
                'message' => 'Veículo inativado com sucesso!'
            ];
        }

        try {
            $this->veiculoRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Veículo excluído com sucesso!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error'  => [
                    $e->getMessage()
                ]
            ];
        }
    }

    public function consultar(array $filtros): array{
        return $this->veiculoRepository->consultar($filtros);
    }

    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['cor'])) {
            $erros['cor'] = 'É obrigatório informar a cor do veiculo.';
        }

        if (empty($dados['marca'])) {
            $erros['marca'] = 'É obrigatório informar a marca do veiculo.';
        }

        if (empty($dados['placa'])) {
            $erros['placa'] = 'A placa do veículo é obrigatorio.';
        }

        if (empty($dados['ano'])) {
            $erros['ano'] = 'O ano do veículo é obrigatório';
        }

        if (empty($dados['tipo'])) {
            $erros['tipo'] = 'O tipo do veículo é obrigatório';
        }

        if (empty($dados['modelo'])) {
            $erros['modelo'] = 'O modelo do veículo é obrigatório';
        }

        return $erros;
    }

}