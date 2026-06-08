<?php

namespace App\Services;

use App\Core\Database;
use App\Models\Pessoa;
use App\Repositories\PessoaRepository;
use DateTime;
use Throwable;

class PessoaService{
    private PessoaRepository $pessoaRepository;

    public function __construct(){
        $this->pessoaRepository = new PessoaRepository();
    }

    public function consultarPorId(int $id): array{
        return $this->pessoaRepository->buscarPorId($id);
    }

    public function consultarNomePessoa(int $id): string{
        return $this->pessoaRepository->buscarNomePessoa($id);
    }

    public function consultarPorNomeId(string $filtro): array{
        return $this->pessoaRepository->buscarPorNomeId($filtro);
    }

    public function consultarPorNomeIdAtivo(string $filtro): array{
        return $this->pessoaRepository->buscarPorNomeIdAtivo($filtro);
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
            $pessoa = Pessoa::fromArray($dados);
            $this->pessoaRepository->salvar($pessoa);

            return [
                'success' => true,
                'message' => 'Pessoa cadastrada com sucesso!'
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
            $pessoa = Pessoa::fromArray($dados);
            $this->pessoaRepository->alterar($pessoa);

            return [
                'success' => true,
                'message' => 'Pessoa alterada com sucesso!'
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
        if ($this->pessoaRepository->foiUtilizado($id)) {
            $this->pessoaRepository->inativar($id);

            return [
                'success' => true,
                'message' => 'Pessoa inativada com sucesso!'
            ];
        }

        try {
            $this->pessoaRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Pessoa excluída com sucesso!'
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
        return $this->pessoaRepository->consultar($filtros);
    }

    private function validar(array $dados): array{
        $erros = [];

        if (empty($dados['nome'])) {
            $erros['nome'] = 'O nome da pessoa é obrigatório.';
        }

        if (empty($dados['cpf'])) {
            $erros['cpf'] = 'O CPF da pessoa é obrigatório';
        }

        if (empty($dados['telefone'])) {
            $erros['telefone'] = 'O telefone da pessoa é obrigatório';
        }

        if (empty($dados['email'])) {
            $erros['email'] = 'O email da pessoa é obrigatório';
        }

        if (empty($dados['numero'])) {
            $erros['numero'] = 'O número da pessoa é obrigatório';
        }

        if (empty($dados['logradouro'])) {
            $erros['logradouro'] = 'O logradouro da pessoa é obrigatório';
        }

        if (empty($dados['cidade'])) {
            $erros['cidade'] = 'A cidade da pessoa é obrigatório';
        }

        if (empty($dados['cep'])) {
            $erros['cep'] = 'O CEP da pessoa é obrigatório';
        }

        if (empty($dados['bairro'])) {
            $erros['bairro'] = 'O bairro da pessoa é obrigatório';
        }

        if (empty($dados['estado'])) {
            $erros['estado'] = 'O estado da pessoa é obrigatório';
        }

        if(!empty($dados['data_nascimento'])){

            $dataNascimento = new DateTime($dados['data_nascimento']);
            $hoje = new DateTime();

            if($dataNascimento > $hoje){
                $erros['data_nascimento'] = 'A data de nascimento precisa ser menor que a data atual';
            }
        }

        return $erros;
    }

}