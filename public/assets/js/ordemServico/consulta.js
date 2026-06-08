
let ordemServicoSelecionadaId = null;
let ordemServicoSelecionadaValor = 0;
let ordemServicoSelecionadaStatus = null;
let ordemServicoSelecionadaPessoaId = 0;
let ordemServicoSelecionadaPessoaNome = null;

const rotasConsultaOS = {
    cancelar: '/ordem-servico/cancelar/',
    fechar: '/ordem-servico/fechar/',
    faturar: '/ordem-servico/faturar/',
    reabrir: '/ordem-servico/reabrir/',
    consultarFormasPagamento: '/forma-pagamento/listar'
};

document.addEventListener('DOMContentLoaded', function () {
    carregarFormasPagamentoConsulta();

    const hoje = new Date().toISOString().split('T')[0];
    document.getElementById('primeiroVencimentoConsulta').value = hoje;

    document.getElementById('btnCancelar').addEventListener('click', cancelarOrdemServicoConsulta);
    document.getElementById('btnFechar').addEventListener('click', fecharOrdemServicoConsulta);
    document.getElementById('btnReabrir').addEventListener('click', reabrirOrdemServicoConsulta);
});

function selecionarOrdemServicoConsulta(linha, ordemServico) {
    ordemServicoSelecionadaId = ordemServico.id;
    ordemServicoSelecionadaValor = parseFloat(ordemServico.valorTotal);
    ordemServicoSelecionadaStatus = ordemServico.status;
    ordemServicoSelecionadaPessoaId = ordemServico.pessoaId;
    ordemServicoSelecionadaPessoaNome = ordemServico.pessoaNome;

    document.querySelectorAll('tbody tr').forEach(tr => {
        tr.classList.remove('table-primary');
    });

    linha.classList.add('table-primary');

    if(ordemServicoSelecionadaStatus === 'ABERTA'){
        document.getElementById('btnCancelar').disabled = false;
        document.getElementById('btnFechar').disabled = false;
        document.getElementById('btnReabrir').disabled = true;
        document.getElementById('btnAbrirModalFaturamento').disabled = false;
    }else if(ordemServicoSelecionadaStatus === 'FECHADA'){
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnFechar').disabled = true;
        document.getElementById('btnReabrir').disabled = false;
        document.getElementById('btnAbrirModalFaturamento').disabled = false;
    }else if(ordemServicoSelecionadaStatus === 'FATURADA'){
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnFechar').disabled = true;
        document.getElementById('btnReabrir').disabled = true;
        document.getElementById('btnAbrirModalFaturamento').disabled = true;
    }else if(ordemServicoSelecionadaStatus === 'CANCELADA'){
        document.getElementById('btnCancelar').disabled = true;
        document.getElementById('btnFechar').disabled = true;
        document.getElementById('btnReabrir').disabled = true;
        document.getElementById('btnAbrirModalFaturamento').disabled = true;
    }

    document.getElementById('ordemServicoIdFaturamento').value = ordemServicoSelecionadaId;
    document.getElementById('valorTotalFaturamentoConsulta').value = ordemServicoSelecionadaValor.toFixed(2);
    document.getElementById('pessoaIdfaturamentoConsulta').value = ordemServicoSelecionadaPessoaId;
    document.getElementById('pessoaNomeFaturamentoConsulta').value = ordemServicoSelecionadaPessoaNome;
}

function cancelarOrdemServicoConsulta() {
    if (!ordemServicoSelecionadaId) {
        mensagem('warning', 'Selecione uma OS.');
        return;
    }

    if (!confirm('Deseja realmente cancelar esta Ordem de Serviço?')) {
        return;
    }

    fetch(rotasConsultaOS.cancelar + encodeURIComponent(ordemServicoSelecionadaId), {
        method: 'POST'
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico/consultar';
            }, 5000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function reabrirOrdemServicoConsulta() {
    if (!ordemServicoSelecionadaId) {
        mensagem('warning', 'Selecione uma OS.');
        return;
    }

    if (!confirm('Deseja realmente fechar esta Ordem de Serviço?')) {
        return;
    }

    fetch(rotasConsultaOS.reabrir + encodeURIComponent(ordemServicoSelecionadaId), {
        method: 'POST'
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico/consultar';;
            }, 5000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function fecharOrdemServicoConsulta() {
    if (!ordemServicoSelecionadaId) {
        mensagem('warning', 'Selecione uma OS.');
        return;
    }

    if (!confirm('Deseja realmente fechar esta Ordem de Serviço?')) {
        return;
    }

    fetch(rotasConsultaOS.fechar + encodeURIComponent(ordemServicoSelecionadaId), {
        method: 'POST'
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            mensagem('success', response.message);
            setTimeout(() => {
                window.location.reload();
            }, 5000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function faturarOrdemServicoConsulta() {
    const dadosFaturamento = {
        ordemServicoId: document.getElementById('ordemServicoIdFaturamento').value,
        pessoaId: document.getElementById('pessoaIdfaturamentoConsulta').value,
        formaPagamentoId: document.getElementById('formaPagamentoIdConsulta').value,
        quantidadeParcelas: document.getElementById('quantidadeParcelasConsulta').value,
        valorTotal: document.getElementById('valorTotalFaturamentoConsulta').value,
        primeiroVencimento: document.getElementById('primeiroVencimentoConsulta').value,
        intervaloParcela: document.getElementById('intervaloParcelaConsulta').value
    };

    if (!dadosFaturamento.formaPagamentoId) {
        mensagem('warning', 'Informe a forma de pagamento.');
        return;
    }

    if (parseFloat(dadosFaturamento.valorTotal) <= 0) {
        mensagem('warning', 'Não é possível faturar OS com valor zerado.');
        return;
    }

    fetch(rotasConsultaOS.faturar + encodeURIComponent(dadosFaturamento.ordemServicoId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(dadosFaturamento)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById('modalFaturamento')
            );

            modal.hide();

            mensagem('success', response.message);
            setTimeout(() => {
                window.location.href = '/ordem-servico/consultar';
            }, 5000);
        } else {
            mensagem('danger', response.error.join('<br>'));
        }
    });
}

function carregarFormasPagamentoConsulta() {
fetch(rotasConsultaOS.consultarFormasPagamento)
    .then(response => response.json())
    .then(formas => {
        const select = document.getElementById('formaPagamentoIdConsulta');

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
    }, 5000);
}

