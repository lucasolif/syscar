<?php

namespace App\Services;

use App\Models\Usuario;
use App\Repositories\UsuarioRepository;
use Throwable;

class UsuarioService{
    private UsuarioRepository $usuarioRepository;

    public function __construct(){
        $this->usuarioRepository = new UsuarioRepository();
    }

    public function consultarPorLoginId(string $filtro): array{
        return $this->usuarioRepository->buscarPorNomeLoginId($filtro);
    }

    public function salvar(array $dados): array{
        $erros = $this->validar($dados, true);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error' => $erros
            ];
        }

        try {
            if ($this->usuarioRepository->buscarPorLogin($dados['login'])) {
                return [
                    'success' => false,
                    'error' => ['Já existe um usuário com este login.']
                ];
            }

            $usuario = Usuario::fromArray($dados);
            $this->usuarioRepository->salvar($usuario);

            return [
                'success' => true,
                'message' => 'Usuário cadastrado com sucesso!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error' => [$e->getMessage()]
            ];
        }
    }

    public function alterar(array $dados): array{
        $erros = $this->validar($dados, false);

        if (!empty($erros)) {
            return [
                'success' => false,
                'error' => $erros
            ];
        }

        try {
            $usuarioExistente = $this->usuarioRepository->buscarPorLogin($dados['login']);

            if ($usuarioExistente && (int) $usuarioExistente['id'] !== (int) $dados['id']) {
                return [
                    'success' => false,
                    'error' => ['Já existe outro usuário com este login.']
                ];
            }

            $usuario = Usuario::fromArray($dados);
            $this->usuarioRepository->alterar($usuario);

            return [
                'success' => true,
                'message' => 'Usuário alterado com sucesso!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error' => [$e->getMessage()]
            ];
        }
    }

    public function excluir(int $id): array{
        try {
            $this->usuarioRepository->excluir($id);

            return [
                'success' => true,
                'message' => 'Usuário excluído com sucesso!'
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'error' => [$e->getMessage()]
            ];
        }
    }

    public function alterarSenha(array $dados): array{
        if (empty($dados['id'])) {
            return [
                'success' => false,
                'error' => ['Usuário não informado.']
            ];
        }

        if (empty($dados['senha'])) {
            return [
                'success' => false,
                'error' => ['Informe a nova senha.']
            ];
        }

        if ($dados['senha'] !== ($dados['confirmacaoSenha'] ?? '')) {
            return [
                'success' => false,
                'error' => ['As senhas não coincidem.']
            ];
        }

        $arrayUsuario = $this->usuarioRepository->buscarPorId($dados['id']);
        $senhaAtual = $arrayUsuario['senha'];
        $senhaAtualInformada = $dados['senhaAtual'];

        if(!password_verify($senhaAtualInformada, $senhaAtual)){
            return [
                'success' => false,
                'error' => ['A senha atual informada no coincidem com a senha cadastrada.']
            ];
        }

        $this->usuarioRepository->alterarSenha((int) $dados['id'], $dados['senha']);

        return [
            'success' => true,
            'message' => 'Senha alterada com sucesso!'
        ];
    }

    public function criarUsuarioInicial(): void{
        if (!$this->usuarioRepository->existeAlgumUsuario()) {
            $this->usuarioRepository->criarUsuarioPadrao();
        }
    }

    private function validar(array $dados, bool $senhaObrigatoria): array{
        $erros = [];

        if (empty($dados['login'])) {
            $erros['login'] = 'O login é obrigatório.';
        }

        if (empty($dados['nome'])) {
            $erros['nome'] = 'O nome é obrigatório.';
        }

        if ($senhaObrigatoria && empty($dados['senha'])) {
            $erros['senha'] = 'A senha é obrigatória.';
        }

        if (!empty($dados['senha']) && strlen($dados['senha']) < 4) {
            $erros['senha'] = 'A senha deve ter pelo menos 4 caracteres.';
        }

        return $erros;
    }

}