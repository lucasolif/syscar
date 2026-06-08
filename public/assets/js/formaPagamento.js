const campoConsultaFormaPagamento = document.getElementById('campoConsultaFormaPagamento');
const resultadoConsultaFormaPagamento = document.getElementById('resultadoConsultaFormaPagamento');
const formFormaPagamento = document.getElementById('formFormaPagamento');
const idFormaPagamento = document.getElementById('id');

const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir = document.getElementById('btnExcluir');


const rotas = {
    salvar: '/forma-pagamento/salvar',
    editar: '/forma-pagamento/editar/',
    excluir: '/forma-pagamento/excluir',
    buscar: '/forma-pagamento/buscar?filtro='
};


campoConsultaFormaPagamento.addEventListener('keyup', function () {

    const filtro = campoConsultaFormaPagamento.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(formasPagamento => {

            resultadoConsultaFormaPagamento.innerHTML = '';

            formasPagamento.forEach(formaPagamento => {

                const status = formaPagamento.ativo ? 'Ativo' : 'Inativo';

                resultadoConsultaFormaPagamento.innerHTML += `
                    <tr>
                        <td>${formaPagamento.id}</td>
                        <td>${formaPagamento.nome}</td>
                        <td>${status}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherFormaPagamento(${JSON.stringify(formaPagamento)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
});

btnSalvar.addEventListener('click', function () {
    formFormaPagamento.action = rotas.salvar;
});

btnAlterar.addEventListener('click', function () {
    formFormaPagamento.action = rotas.editar;
});

btnExcluir.addEventListener('click', function (event) {
    if (!confirm('Deseja realmente excluir esta forma de pagamento?')) {
        event.preventDefault();
        return;
    }
    formFormaPagamento.action = rotas.excluir;
});

function atualizarBotoes() {
    if (idFormaPagamento.value.trim() !== '') {
        btnSalvar.disabled = true;
        btnAlterar.disabled = false;
        btnExcluir.disabled = false;
    } else {
        btnSalvar.disabled = false;
        btnAlterar.disabled = true;
        btnExcluir.disabled = true;
    }
}

function escolherFormaPagamento(formaPagamento) {

    document.getElementById('id').value = formaPagamento.id;
    document.getElementById('nome').value = formaPagamento.nome;
    document.getElementById('status').checked = formaPagamento.ativo;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaFormaPagamento')
    );

    modal.hide();
    atualizarBotoes();
}