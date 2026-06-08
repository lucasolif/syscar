<?php

use App\Controllers\AuthController;
use App\Controllers\ContaCaixaController;
use App\Controllers\ContaReceberController;
use App\Controllers\EstoqueController;
use App\Controllers\FormaPagamentoController;
use App\Controllers\OrdemServicoController;
use App\Controllers\ServicoController;
use App\Controllers\UsuarioController;
use App\Controllers\VeiculoController;
use App\Core\Router;
use App\Controllers\ProdutoController;
use App\Controllers\HomeController;
use App\Controllers\PessoaController;

$router = new Router();

$router->get('/', [AuthController::class, 'login']);
$router->get('/inicio', [HomeController::class, 'index']);

$router->get('/produto', [ProdutoController::class, 'index']);
$router->get('/produto/buscar', [ProdutoController::class, 'buscar']);
$router->get('/produto/buscar-ativos', [ProdutoController::class, 'buscarAtivos']);
$router->post('/produto/salvar', [ProdutoController::class, 'salvar']);
$router->post('/produto/editar', [ProdutoController::class, 'editar']);
$router->post('/produto/excluir', [ProdutoController::class, 'excluir']);
$router->get('/produto/consultar', [ProdutoController::class, 'consultar']);
$router->get('/produto/{id}', [ProdutoController::class, 'consultarPorId']);

$router->get('/pessoa', [PessoaController::class, 'index']);
$router->get('/pessoa/buscar', [PessoaController::class, 'buscar']);
$router->get('/pessoa/buscar-ativos', [PessoaController::class, 'buscarAtivos']);
$router->post('/pessoa/salvar', [PessoaController::class, 'salvar']);
$router->post('/pessoa/editar', [PessoaController::class, 'editar']);
$router->post('/pessoa/excluir', [PessoaController::class, 'excluir']);
$router->get('/pessoa/consultar', [PessoaController::class, 'consultar']);
$router->get('/pessoa/{id}', [PessoaController::class, 'consultarPorId']);

$router->get('/veiculo', [VeiculoController::class, 'index']);
$router->get('/veiculo/buscar', [VeiculoController::class, 'buscar']);
$router->get('/veiculo/buscar-ativos', [VeiculoController::class, 'buscarAtivos']);
$router->post('/veiculo/salvar', [VeiculoController::class, 'salvar']);
$router->post('/veiculo/editar', [VeiculoController::class, 'editar']);
$router->post('/veiculo/excluir', [VeiculoController::class, 'excluir']);
$router->get('/veiculo/consultar', [VeiculoController::class, 'consultar']);
$router->get('/veiculo/{id}', [VeiculoController::class, 'consultarPorId']);

$router->get('/conta-caixa', [ContaCaixaController::class, 'index']);
$router->get('/conta-caixa/buscar', [ContaCaixaController::class, 'buscar']);
$router->post('/conta-caixa/salvar', [ContaCaixaController::class, 'salvar']);
$router->post('/conta-caixa/editar', [ContaCaixaController::class, 'editar']);
$router->post('/conta-caixa/excluir', [ContaCaixaController::class, 'excluir']);
$router->get('/conta-caixa/{id}', [ContaCaixaController::class, 'consultarPorId']);
$router->get('/conta-caixa/listar', [ContaCaixaController::class, 'listarAtivas']);

$router->get('/forma-pagamento', [FormaPagamentoController::class, 'index']);
$router->get('/forma-pagamento/buscar', [FormaPagamentoController::class, 'buscar']);
$router->post('/forma-pagamento/salvar', [FormaPagamentoController::class, 'salvar']);
$router->post('/forma-pagamento/editar', [FormaPagamentoController::class, 'editar']);
$router->post('/forma-pagamento/excluir', [FormaPagamentoController::class, 'excluir']);
$router->get('/forma-pagamento/listar', [FormaPagamentoController::class, 'listarAtivas']);
$router->get('/forma-pagamento/{id}', [FormaPagamentoController::class, 'consultarPorId']);

$router->get('/servico', [ServicoController::class, 'index']);
$router->get('/servico/buscar', [ServicoController::class, 'buscar']);
$router->get('/servico/buscar-ativos', [ServicoController::class, 'buscarAtivos']);
$router->post('/servico/salvar', [ServicoController::class, 'salvar']);
$router->post('/servico/editar', [ServicoController::class, 'editar']);
$router->post('/servico/excluir', [ServicoController::class, 'excluir']);
$router->get('/servico/{id}', [ServicoController::class, 'consultarPorId']);

$router->get('/estoque', [EstoqueController::class, 'index']);
$router->post('/estoque/movimentar', [EstoqueController::class, 'movimentarEstoqueAvulso']);
$router->get('/estoque/consultar', [EstoqueController::class, 'consultarEstoque']);
$router->get('/estoque/consultar-movimentacao', [EstoqueController::class, 'consultarMovimentacao']);
$router->get('/estoque/{id}', [EstoqueController::class, 'consultarPorId']);

$router->get('/ordem-servico', [OrdemServicoController::class, 'index']);
$router->post('/ordem-servico/salvar', [OrdemServicoController::class, 'salvar']);
$router->post('/ordem-servico/editar', [OrdemServicoController::class, 'editar']);
$router->post('/ordem-servico/cancelar/{id}', [OrdemServicoController::class, 'cancelar']);
$router->post('/ordem-servico/fechar/{id}', [OrdemServicoController::class, 'fechar']);
$router->post('/ordem-servico/reabrir/{id}', [OrdemServicoController::class, 'reabrir']);
$router->post('/ordem-servico/faturar/{id}', [OrdemServicoController::class, 'faturar']);
$router->get('/ordem-servico/buscar', [OrdemServicoController::class, 'buscar']);
$router->get('/ordem-servico/consultar', [OrdemServicoController::class, 'consultar']);
$router->get('/ordem-servico/{id}', [OrdemServicoController::class, 'consultarPorId']);

$router->get('/conta-receber', [ContaReceberController::class, 'index']);
$router->post('/conta-receber/cancelar-baixa/{id}', [ContaReceberController::class, 'cancelarBaixa']);
$router->post('/conta-receber/cancelar/{id}', [ContaReceberController::class, 'cancelarContaReceber']);
$router->post('/conta-receber/baixar/{id}', [ContaReceberController::class, 'baixar']);
$router->get('/conta-receber/consultar', [ContaReceberController::class, 'consultar']);

$router->get('/usuario', [UsuarioController::class, 'index']);
$router->get('/usuario/buscar', [UsuarioController::class, 'buscar']);
$router->post('/usuario/salvar', [UsuarioController::class, 'salvar']);
$router->post('/usuario/editar', [UsuarioController::class, 'editar']);
$router->post('/usuario/excluir', [UsuarioController::class, 'excluir']);
$router->post('/usuario/alterar-senha', [UsuarioController::class, 'alterarSenha']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login/autenticar', [AuthController::class, 'autenticar']);
$router->get('/logout', [AuthController::class, 'logout']);


