let produtos = [];
let servicos = [];

const resultadoConsultaPessoa = document.getElementById('resultadoConsultaPessoa');
const resultadoConsultaVeiculo = document.getElementById('resultadoConsultaVeiculo');
const resultadoConsultaProduto = document.getElementById('resultadoConsultaProduto');
const resultadoConsultaServico = document.getElementById('resultadoConsultaServico');
const resultadoConsultaOrdemServico = document.getElementById('resultadoConsultaOrdemServico');

const tabelaProdutos = document.getElementById('tabelaProdutos');
const tabelaServicos = document.getElementById('tabelaServicos');

const campoConsultaOrdemServico = document.getElementById('campoConsultaOrdemServico');
const campoConsultaPessoa = document.getElementById('campoConsultaPessoa');
const campoConsultaProduto = document.getElementById('campoConsultaProduto');
const campoConsultaServico = document.getElementById('campoConsultaServico');
const campoConsultaVeiculo = document.getElementById('campoConsultaVeiculo');

const btnSalvar = document.getElementById('btnSalvar');
const btnFechar = document.getElementById('btnFechar');
const btnCancelar = document.getElementById('btnCancelar');
const btnFaturar = document.getElementById('btnFaturar');
const btnReabrir = document.getElementById('btnReabrir');


const rotas = {
    salvar: '/ordem-servico/salvar',
    fechar: '/ordem-servico/fechar/',
    reabrir: '/ordem-servico/reabrir/',
    editar: '/ordem-servico/editar/',
    cancelar: '/ordem-servico/cancelar/',
    faturar: '/ordem-servico/faturar/',
    consultarOrdem: '/ordem-servico/buscar?filtro=',
    consultarOrdemPorId: '/ordem-servico/',

    consultarPessoa: '/pessoa/buscar-ativos?filtro=',
    consultarVeiculo: '/veiculo/buscar-ativos?filtro=',

    consultarProduto: '/produto/buscar-ativos?filtro=',
    consultarServico: '/servico/buscar-ativos?filtro=',

    consultarFormasPagamento: '/forma-pagamento/listar',
};


btnSalvar.addEventListener('click', function () {
    salvarOrdemServico();
});

btnFechar.addEventListener('click', function () {
    fecharOrdemServico();
});

btnCancelar.addEventListener('click', function () {
    cancelarOrdemServico();
});

btnFaturar.addEventListener('click', function (){
    faturarOrdemServico();
})

btnReabrir.addEventListener('click', function (){
    reabrirOrdemServico();
})


document.addEventListener('DOMContentLoaded', function () {

    const dataAtual = new Date().toISOString().split('T')[0];

    document.getElementById('status').value = 'ABERTA';
    document.getElementById('dataAbertura').value = dataAtual;
    document.getElementById('primeiroVencimento').value = dataAtual;

    atualizarCorStatus();
    desabilitarBotoes('ABERTA');
    carregarFormasPagamento();
});

campoConsultaOrdemServico.addEventListener('keyup', function () {
    consultarOrdemServico(this.value);
});

campoConsultaPessoa.addEventListener('keyup', function () {
    consultarPessoa(this.value);
});

campoConsultaVeiculo.addEventListener('keyup', function () {
    consultarVeiculo(this.value);
});

campoConsultaServico.addEventListener('keyup', function () {
    consultarServico(this.value);
});

campoConsultaProduto.addEventListener('keyup', function () {
    consultarProduto(this.value);
});


//Funções referente a OS

function salvarOrdemServico(){
    const ordemServicoId = document.getElementById('id').value;

    if(ordemServicoId === ''){
        cadastrarOrdemServico();
    }else{
        alterarOrdemServico();
    }
}

function cadastrarOrdemServico() {
    const dados = {
        pessoaId: document.getElementById('pessoaId').value,
        veiculoId: document.getElementById('veiculoId').value,
        dataAbertura: document.getElementById('dataAbertura').value,
        status: document.getElementById('status').value,
        descricao: document.getElementById('descricao').value,
        valorTotal: document.getElementById('valorTotal').value,
        produtos: produtos,
        servicos: servicos
    };

    fetch(rotas.salvar, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico';
            }, 10000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function consultarOrdemServico(filtro) {
    fetch(rotas.consultarOrdem + encodeURIComponent(filtro))
    .then(response => response.json())
    .then(ordens => {
        resultadoConsultaOrdemServico.innerHTML = '';

        ordens.forEach(os => {
            resultadoConsultaOrdemServico.innerHTML += `
                <tr>
                    <td>${os.id}</td>
                    <td>${os.pessoaNome}</td>
                    <td>${os.veiculoPlaca}</td>
                    <td>${os.status}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" onclick='escolherOrdemServico(${os.id})'>
                            Escolher
                        </button>
                    </td>
                </tr>
            `;
        });
    });
}

function escolherOrdemServico(ordemServicoId) {
    fetch(rotas.consultarOrdemPorId + encodeURIComponent(ordemServicoId))
    .then(response => response.json())
    .then(os => {
        document.getElementById('id').value = os.id;
        document.getElementById('status').value = os.status;
        document.getElementById('dataAbertura').value = os.dataAbertura;
        document.getElementById('dataFechamento').value = os.dataFechamento ?? '';
        document.getElementById('dataCancelamento').value = os.dataCancelamento ?? '';
        document.getElementById('valorTotal').value = os.valorTotal;

        document.getElementById('pessoaId').value = os.pessoaId;
        document.getElementById('pessoaNome').value = os.pessoaNome;
        document.getElementById('pessoaCpf').value = os.pessoaCpf;
        document.getElementById('pessoaTelefone').value = os.pessoaTelefone;
        document.getElementById('pessoaEmail').value = os.pessoaEmail;
        document.getElementById('pessoaLogradouro').value = os.pessoaLogradouro;
        document.getElementById('pessoaNumero').value = os.pessoaNumero;
        document.getElementById('pessoaComplemento').value = os.pessoaComplemento ?? '';
        document.getElementById('pessoaBairro').value = os.pessoaBairro;
        document.getElementById('pessoaCidade').value = os.pessoaCidade;
        document.getElementById('pessoaEstado').value = os.pessoaEstado;

        document.getElementById('veiculoId').value = os.veiculoId;
        document.getElementById('veiculoPlaca').value = os.veiculoPlaca;
        document.getElementById('veiculoMarca').value = os.veiculoMarca;
        document.getElementById('veiculoModelo').value = os.veiculoModelo;
        document.getElementById('veiculoAno').value = os.veiculoAno;
        document.getElementById('veiculoCor').value = os.veiculoCor;

        document.getElementById('descricao').value = os.descricao ?? '';

        produtos = os.produtos ?? [];
        servicos = os.servicos ?? [];

        this.converterValoresProdutosServicos();
        this.popularProdutos();
        this.popularServico();
        this.calcularTotaisOrdemServico();
        this.desabilitarBotoes(os.status);
        this.atualizarCorStatus();

        const modal = bootstrap.Modal.getInstance(
            document.getElementById('modalConsultaOrdemServico')
        );
        modal.hide();
    });
}

function alterarOrdemServico(){
    const dados = {
        id: document.getElementById('id').value,
        pessoaId: document.getElementById('pessoaId').value,
        veiculoId: document.getElementById('veiculoId').value,
        dataAbertura: document.getElementById('dataAbertura').value,
        status: document.getElementById('status').value,
        descricao: document.getElementById('descricao').value,
        valorTotal: document.getElementById('valorTotal').value,
        produtos: produtos,
        servicos: servicos
    };

    fetch(rotas.editar, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dados)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico';
            }, 10000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function cancelarOrdemServico(){

    if (!confirm('Deseja realmente cancelar esta Ordem de Serviço?')) {
        return;
    }

    const ordemServicoId = document.getElementById('id').value;

    fetch(rotas.cancelar + encodeURIComponent(ordemServicoId), {
        method: 'POST'
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico';
            }, 10000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function fecharOrdemServico(){

    if (!confirm('Se houve alguma alteração, salve antes de fechar a OS. Continuar?')) {
        return;
    }

    const ordemServicoId = document.getElementById('id').value;

    fetch(rotas.fechar + encodeURIComponent(ordemServicoId), {
        method: 'POST'
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico';
            }, 10000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function reabrirOrdemServico(){

    if (!confirm('Deseja realmente reabrir esta Ordem de Serviço?')) {
        return;
    }

    const ordemServicoId = document.getElementById('id').value;

    fetch(rotas.reabrir + encodeURIComponent(ordemServicoId), {
        method: 'POST'
    })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                mensagem('success', response.message);
                setTimeout(() => {
                    window.location.href = '/ordem-servico';
                }, 10000);
            } else {
                mensagem('danger', response.error.join('<br>'));
            }
        });
}

function faturarOrdemServico(){

    const formaPagamentoId = document.getElementById('formaPagamentoId').value;
    const valorTotal = document.getElementById('valorTotalFechamento').value;
    const status = document.getElementById('status').value;

    if (formaPagamentoId === '') {
        alert('Para faturar uma OS é necessário informar a forma de pagamento');
        return false;
    }

    if (valorTotal <= 0) {
        alert('Não é possível faturar uma OS sem valores (produto ou/e serviço)');
        return false;
    }

    if(status !== 'FECHADA'){
        if (!confirm('Se houve alguma alteração, salve antes de faturar a OS. Continuar?')) {
            return;
        }
    }

    const dadosFaturamento = {
        ordemServicoId: document.getElementById('id').value,
        pessoaId: document.getElementById('pessoaId').value,
        formaPagamentoId: document.getElementById('formaPagamentoId').value,
        quantidadeParcelas: document.getElementById('quantidadeParcelas').value,
        valorTotal: document.getElementById('valorTotalFechamento').value,
        primeiroVencimento: document.getElementById('primeiroVencimento').value,
        intervaloParcela: document.getElementById('intervaloParcela').value
    };

    fetch(rotas.faturar + encodeURIComponent(dadosFaturamento.ordemServicoId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosFaturamento)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico';
            }, 10000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}


//Funções referente aos processo da pessoa
function consultarPessoa(filtro) {
    fetch(rotas.consultarPessoa + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(pessoas => {
            resultadoConsultaPessoa.innerHTML = '';

            pessoas.forEach(pessoa => {
                resultadoConsultaPessoa.innerHTML += `
                    <tr>
                        <td>${pessoa.id}</td>
                        <td>${pessoa.nome}</td>
                        <td>${pessoa.cpf}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherPessoa(${JSON.stringify(pessoa)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
}

function escolherPessoa(pessoa) {

    document.getElementById('pessoaId').value = pessoa.id;
    document.getElementById('pessoaNome').value = pessoa.nome;
    document.getElementById('pessoaCpf').value = pessoa.cpf;
    document.getElementById('pessoaTelefone').value = pessoa.telefone;
    document.getElementById('pessoaEmail').value = pessoa.email;
    document.getElementById('pessoaLogradouro').value = pessoa.logradouro;
    document.getElementById('pessoaNumero').value = pessoa.numero;
    document.getElementById('pessoaComplemento').value = pessoa.complemento ?? '';
    document.getElementById('pessoaBairro').value = pessoa.bairro;
    document.getElementById('pessoaCidade').value = pessoa.cidade;
    document.getElementById('pessoaEstado').value = pessoa.estado;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaPessoa')
    );

    modal.hide();
}


//Funções referente ao veículo
function consultarVeiculo(filtro) {
    fetch(rotas.consultarVeiculo + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(veiculos => {
            resultadoConsultaVeiculo.innerHTML = '';

            veiculos.forEach(veiculo => {
                resultadoConsultaVeiculo.innerHTML += `
                    <tr>
                        <td>${veiculo.id}</td>
                        <td>${veiculo.placa}</td>
                        <td>${veiculo.modelo}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherVeiculo(${JSON.stringify(veiculo)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
}

function escolherVeiculo(veiculo) {

    document.getElementById('veiculoId').value = veiculo.id;
    document.getElementById('veiculoPlaca').value = veiculo.placa;
    document.getElementById('veiculoMarca').value = veiculo.marca ?? '';
    document.getElementById('veiculoModelo').value = veiculo.modelo ?? '';
    document.getElementById('veiculoAno').value = veiculo.ano ?? '';
    document.getElementById('veiculoCor').value = veiculo.cor ?? '';

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaVeiculo')
    );

    modal.hide();
}


//Funções referente aos produtos
function consultarProduto(filtro) {
    fetch(rotas.consultarProduto + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(produtos => {
            resultadoConsultaProduto.innerHTML = '';

            produtos.forEach(produto => {
                resultadoConsultaProduto.innerHTML += `
                    <tr>
                        <td>${produto.id}</td>
                        <td>${produto.nome}</td>
                        <td>${produto.marca}</td>
                        <td>${produto.precoVenda}</td>
                        <td>${produto.quantidade}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='adicionarProduto(${JSON.stringify(produto)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
}

function adicionarProduto(produto) {

    if(produto.quantidade <= 0){
        if (!confirm('O produto está com a quantidade negativa. Continuar?')) {
            return;
        }
    }

    if (!validaAlteracaoItens()) {
        return;
    }

    produtos.push({
        produtoId: produto.id,
        nome: produto.nome,
        quantidade: 1,
        valorUnitario: parseFloat(produto.precoVenda),
        valorTotal: parseFloat(produto.precoVenda)
    });

    popularProdutos();
    calcularTotaisOrdemServico();

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaProduto')
    );
    modal.hide();
}

function popularProdutos() {

    tabelaProdutos.innerHTML = '';

    produtos.forEach((produto, index) => {
        tabelaProdutos.innerHTML += `
            <tr>
                <td>${produto.produtoId}</td>
                <td>${produto.nome}</td>
                <td>
                    <input type="number" min="1" value="${produto.quantidade}" class="quantidade-grid" onchange="alterarQuantidadeProduto(${index}, this.value)">
                </td>
                <td>
                    <input type="number" min="0" step="0.01" value="${produto.valorUnitario.toFixed(2)}"  class="quantidade-grid" onchange="alterarValorUnitarioProduto(${index}, this.value)">
                </td>
                <td>${produto.valorTotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removerProduto(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

function alterarQuantidadeProduto(index, quantidade) {

    if (!validaAlteracaoItens()) {
        popularProdutos();
        return;
    }

    produtos[index].quantidade = parseInt(quantidade);
    produtos[index].valorTotal = produtos[index].quantidade * produtos[index].valorUnitario;

    popularProdutos();
    calcularTotaisOrdemServico();
}

function alterarValorUnitarioProduto(index, valorUnitario) {

    if (!validaAlteracaoItens()) {
        popularProdutos();
        return;
    }

    produtos[index].valorUnitario = parseFloat(valorUnitario);
    produtos[index].valorTotal = produtos[index].quantidade * produtos[index].valorUnitario;

    popularProdutos();
    calcularTotaisOrdemServico();
}

function removerProduto(index) {
    if (!validaAlteracaoItens()) {
        return;
    }

    produtos.splice(index, 1);
    popularProdutos();
    calcularTotaisOrdemServico();
}


//Funções pertinentes aos serviços
function consultarServico(filtro) {
    fetch(rotas.consultarServico + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(servicos => {
            resultadoConsultaServico.innerHTML = '';

            servicos.forEach(servico => {
                resultadoConsultaServico.innerHTML += `
                    <tr>
                        <td>${servico.id}</td>
                        <td>${servico.nome}</td>
                        <td>${servico.valor}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='adicionarServico(${JSON.stringify(servico)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
}

function adicionarServico(servico) {

    if (!validaAlteracaoItens()) {
        return;
    }

    servicos.push({
        servicoId: servico.id,
        nome: servico.nome,
        quantidade: 1,
        valorUnitario: parseFloat(servico.valor),
        valorTotal: parseFloat(servico.valor)
    });

    popularServico();
    calcularTotaisOrdemServico();

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaServico')
    );
    modal.hide();
}

function popularServico() {

    tabelaServicos.innerHTML = '';
    servicos.forEach((servico, index) => {
        tabelaServicos.innerHTML += `
            <tr>
                <td>${servico.servicoId}</td>
                <td>${servico.nome}</td>
                <td>
                    <input type="number" min="1" value="${servico.quantidade}" class="quantidade-grid" onchange="alterarQuantidadeServico(${index}, this.value)">
                </td>
                 <td>
                    <input type="number" min="0" step="0.01" value="${servico.valorUnitario.toFixed(2)}"  class="quantidade-grid" onchange="alterarValorUnitarioServico(${index}, this.value)">
                </td>
                <td>${servico.valorTotal.toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removerServico(${index})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

function alterarQuantidadeServico(index, quantidade) {

    if (!validaAlteracaoItens()) {
        popularServico();
        return;
    }

    servicos[index].quantidade = parseInt(quantidade);
    servicos[index].valorTotal = servicos[index].quantidade * servicos[index].valorUnitario;

    popularServico();
    calcularTotaisOrdemServico();
}

function alterarValorUnitarioServico(index, valorUnitario) {

    if (!validaAlteracaoItens()) {
        popularServico();
        return;
    }

    servicos[index].valorUnitario = parseFloat(valorUnitario);
    servicos[index].valorTotal = servicos[index].quantidade * servicos[index].valorUnitario;

    popularServico();
    calcularTotaisOrdemServico();
}

function removerServico(index) {

    if (!validaAlteracaoItens()) {
        return;
    }

    servicos.splice(index, 1);
    popularServico();
    calcularTotaisOrdemServico();
}


function calcularTotaisOrdemServico() {
    let totalProdutos = 0;
    let totalServicos = 0;

    produtos.forEach(produto => {
        totalProdutos += produto.quantidade * produto.valorUnitario;
    });

    servicos.forEach(servico => {
        totalServicos += servico.quantidade * servico.valorUnitario;
    });

    const valorTotal = totalProdutos + totalServicos;

    document.getElementById('valorTotal').value = valorTotal.toFixed(2);
    document.getElementById('totalProdutos').innerText = totalProdutos.toFixed(2).replace('.', ',');
    document.getElementById('totalServicos').innerText = totalServicos.toFixed(2).replace('.', ',');
    document.getElementById('totalProdutosFechamento').value = totalProdutos.toFixed(2);
    document.getElementById('totalServicosFechamento').value = totalServicos.toFixed(2);
    document.getElementById('valorTotalFechamento').value = valorTotal.toFixed(2);
}

function atualizarCorStatus() {

    const campoStatus = document.getElementById('status');

    campoStatus.classList.remove(
        'status-aberta',
        'status-fechada',
        'status-faturada',
        'status-cancelada'
    );

    switch (campoStatus.value) {
        case 'ABERTA':
            campoStatus.classList.add('status-aberta');
            break;

        case 'FECHADA':
            campoStatus.classList.add('status-fechada');
            break;

        case 'FATURADA':
            campoStatus.classList.add('status-faturada');
            break;

        case 'CANCELADA':
            campoStatus.classList.add('status-cancelada');
            break;
    }
}

function mensagem(tipo, mensagem) {
    const div = document.getElementById('mensagem');

    div.innerHTML = `
        <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
            ${mensagem}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

    setTimeout(() => {
        div.innerHTML = '';
    }, 10000);
}

function validaAlteracaoItens() {
    const status = document.getElementById('status').value;

    if (status !== 'ABERTA') {
        alert('Só é permitido adicionar ou remover produtos e serviços quando a Ordem de Serviço estiver ABERTA.');
        return false;
    }

    return true;
}

function desabilitarBotoes(status){

    let idOS = document.getElementById('id').value;

    if(status !== 'ABERTA'){
        document.getElementById('btnFechar').disabled = true;
        document.getElementById('btnFaturar').disabled = true;
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnSalvar').disabled = true;
        document.getElementById('btnAddVeiculo').disabled = true;
        document.getElementById('btnAddPessoa').disabled = true;
        document.getElementById('btnAddServico').disabled = true;
        document.getElementById('btnAddProduto').disabled = true;
    }else if(status === 'ABERTA' && idOS === ''){
        document.getElementById('btnFechar').disabled = true;
        document.getElementById('btnFaturar').disabled = true
        document.getElementById('btnCancelar').disabled = true;
    }else if(status === 'ABERTA' && idOS !== ''){
        document.getElementById('btnSalvar').disabled = true;
        document.getElementById('btnFechar').disabled = false;
        document.getElementById('btnFaturar').disabled = false
        document.getElementById('btnCancelar').disabled = false;
    }

    const btnReabrir = document.getElementById('btnReabrir');
    if (status === 'FECHADA') {
        btnReabrir.style.display = 'inline-block';
    } else {
        btnReabrir.style.display = 'none';
    }

    if(status === 'FECHADA' && idOS !== ''){
        document.getElementById('btnFaturar').disabled = false
    }

}

function converterValoresProdutosServicos(){
    produtos.forEach(produto => {
        produto.valorUnitario = parseFloat(produto.valorUnitario);
        produto.valorTotal = parseFloat(produto.valorTotal);
    });
    servicos.forEach(servico => {
        servico.valorUnitario = parseFloat(servico.valorUnitario);
        servico.valorTotal = parseFloat(servico.valorTotal);
    });
}

function carregarFormasPagamento() {
    fetch(rotas.consultarFormasPagamento)
    .then(response => response.json())
    .then(formas => {
        const select = document.getElementById('formaPagamentoId');

        select.innerHTML = '<option value="">Selecione</option>';

        formas.forEach(forma => {
            select.innerHTML += `
                <option value="${forma.id}">
                    ${forma.nome}
                </option>
            `;
        });
    });
}
