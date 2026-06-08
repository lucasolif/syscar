let contaReceberSelecionadaId = null;
let contaReceberSelecionadaStatus = null;
let contaReceberSelecionadaValorPendente = 0;
let contaReceberSelecionadaPessoaId = 0;
let contaReceberSelecionadaPessoaNome = null;

const rotas = {
    cancelarBaixa: '/conta-receber/cancelar-baixa/',
    cancelar: '/conta-receber/cancelar/',
    baixar: '/conta-receber/baixar/',
    consultarFormasPagamento: '/forma-pagamento/listar',
    consultarContasCaixa: '/conta-caixa/listar'
};

document.addEventListener('DOMContentLoaded', function () {

    carregarFormasPagamento('filtroFormaPagamentoId', 'Todas');
    carregarFormasPagamento('formaPagamentoId', 'Selecione');

    carregarContasCaixa();

    const hoje = new Date().toISOString().split('T')[0];
    document.getElementById('dataPagamento').value = hoje;

    document.getElementById('btnEstornarBaixa').addEventListener('click', estornarBaixaContaReceber);
    document.getElementById('btnCancelar').addEventListener('click', cancelarContaReceber);
});

function selecionarContaReceber(linha, contaReceber) {
    contaReceberSelecionadaId = contaReceber.id;
    contaReceberSelecionadaStatus = contaReceber.status;
    contaReceberSelecionadaValorPendente = parseFloat(contaReceber.valorPendente);
    contaReceberSelecionadaPessoaId = contaReceber.pessoaId;
    contaReceberSelecionadaPessoaNome = contaReceber.pessoaNome;

    document.querySelectorAll('tbody tr').forEach(tr => {
        tr.classList.remove('table-primary');
    });

    linha.classList.add('table-primary');

    if(contaReceberSelecionadaStatus === 'PENDENTE'){
        document.getElementById('btnEstornarBaixa').disabled = true;
        document.getElementById('btnCancelar').disabled = false;
        document.getElementById('btnAbrirModalBaixa').disabled = false;
    }else if(contaReceberSelecionadaStatus === 'PAGO'){
        document.getElementById('btnEstornarBaixa').disabled = false;
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnAbrirModalBaixa').disabled = true;
    }else if(contaReceberSelecionadaStatus === 'PARCIAL'){
        document.getElementById('btnEstornarBaixa').disabled = false;
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnAbrirModalBaixa').disabled = false;
    }else if(contaReceberSelecionadaStatus === 'CANCELADA'){
        document.getElementById('btnEstornarBaixa').disabled = true;
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnAbrirModalBaixa').disabled = true;
    }


    document.getElementById('contaReceberId').value = contaReceber.id;
    document.getElementById('parcela').value = contaReceber.parcela;
    document.getElementById('pessoaId').value = contaReceber.pessoaId;
    document.getElementById('pessoaNome').value = contaReceber.pessoaNome;
    document.getElementById('valorPendente').value = contaReceberSelecionadaValorPendente.toFixed(2);
    document.getElementById('valorPago').value = contaReceberSelecionadaValorPendente.toFixed(2);

    if (contaReceber.formaPagamentoId) {
        document.getElementById('formaPagamentoId').value = contaReceber.formaPagamentoId;
    }
}

function estornarBaixaContaReceber() {
    if (!contaReceberSelecionadaId) {
        mensagem('warning', 'Selecione uma conta a receber.');
        return;
    }

    if (!confirm('Deseja realmente estornar a baixa desta conta?')) {
        return;
    }

    fetch(rotas.cancelarBaixa + encodeURIComponent(contaReceberSelecionadaId), {
        method: 'POST'
    })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                mensagem('success', response.message);

                setTimeout(() => {
                    window.location.href = '/conta-receber/consultar';
                }, 3000);
            } else {
                mensagem('danger', response.error.join('<br>'));
            }
        });
}

function cancelarContaReceber() {

    if (!contaReceberSelecionadaId) {
        mensagem('warning', 'Selecione uma conta a receber.');
        return;
    }

    if (!confirm('Deseja realmente cancelar esta conta a receber?')) {
        return;
    }

    fetch(rotas.cancelar + encodeURIComponent(contaReceberSelecionadaId), {
        method: 'POST'
    })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                mensagem('success', response.message);

                setTimeout(() => {
                    window.location.href = '/conta-receber/consultar';
                }, 3000);
            } else {
                mensagem('danger', response.error.join('<br>'));
            }
        });
}

function baixarContaReceber() {

    const valorPendente = document.getElementById('valorPago').value;
    const hoje = new Date().toISOString().split('T')[0];
    const modalBaixa = bootstrap.Modal.getInstance(document.getElementById('modalBaixa'));

    const dadosBaixa = {
        contaReceberId: document.getElementById('contaReceberId').value,
        formaPagamentoId: document.getElementById('formaPagamentoId').value,
        contaCaixaId: document.getElementById('contaCaixaId').value,
        valorPago: document.getElementById('valorPago').value,
        dataPagamento: document.getElementById('dataPagamento').value
    };

    if (!dadosBaixa.formaPagamentoId) {
        modalBaixa.hide();
        mensagem('warning', 'Informe a forma de pagamento.');
        return;
    }

    if (!dadosBaixa.dataPagamento) {
        modalBaixa.hide();
        mensagem('warning', 'Informe a data de pagamento.');
        return;
    }

    if (dadosBaixa.dataPagamento > hoje) {
        modalBaixa.hide();
        mensagem('warning', 'A data de pagamento não pode ser maior que a data atual.');
        return;
    }

    if (!dadosBaixa.contaCaixaId) {
        modalBaixa.hide();
        mensagem('warning', 'Informe a conta caixa.');
        return;
    }

    if (parseFloat(dadosBaixa.valorPago) <= 0) {
        modalBaixa.hide();
        mensagem('warning', 'Informe um valor pago maior que zero.');
        return;
    }

    if (parseFloat(dadosBaixa.valorPago) > parseFloat(valorPendente)) {
        modalBaixa.hide();
        mensagem('warning', 'O valor pago não pode ser maior que o valor pendente.');
        return;
    }

    fetch(rotas.baixar + encodeURIComponent(dadosBaixa.contaReceberId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosBaixa)
    })
        .then(response => response.json())
        .then(response => {
            if (response.success) {

                modalBaixa.hide();
                mensagem('success', response.message);

                setTimeout(() => {
                    window.location.href = '/conta-receber/consultar';
                }, 3000);
            } else {
                mensagem('danger', response.error.join('<br>'));
            }
        });
}

function carregarFormasPagamento(idSelect, textoPadrao = 'Selecione') {
    fetch(rotas.consultarFormasPagamento)
        .then(response => response.json())
        .then(formas => {
            const select = document.getElementById(idSelect);

            select.innerHTML = `<option value="">${textoPadrao}</option>`;

            const formaSelecionada =
                new URLSearchParams(window.location.search)
                    .get('formaPagamentoId');

            formas.forEach(forma => {
                select.innerHTML += `
                    <option value="${forma.id}"
                        ${formaSelecionada === forma.id ? 'selected' : ''}>
                        ${forma.nome}
                    </option>
                `;
            });
        });
}
function carregarContasCaixa() {
    fetch(rotas.consultarContasCaixa)
        .then(response => response.json())
        .then(contas => {
            const select = document.getElementById('contaCaixaId');

            select.innerHTML = '<option value="">Selecione</option>';

            contas.forEach(conta => {
                select.innerHTML += `
                    <option value="${conta.id}">
                        ${conta.nome}
                    </option>
                `;
            });
        });
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