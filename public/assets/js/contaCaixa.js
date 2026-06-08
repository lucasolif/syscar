const campoConsultaContaCaixa = document.getElementById('campoConsultaContaCaixa');
const resultadoConsultaContaCaixa = document.getElementById('resultadoConsultaContaCaixa');
const formContaCaixa = document.getElementById('formContaCaixa');
const idContaCaixa = document.getElementById('id');
const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir = document.getElementById('btnExcluir');

const rotas = {
    salvar: '/conta-caixa/salvar',
    editar: '/conta-caixa/editar/',
    excluir: '/conta-caixa/excluir',
    buscar: '/conta-caixa/buscar?filtro='
};

campoConsultaContaCaixa.addEventListener('keyup', function () {

    const filtro = campoConsultaContaCaixa.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(contas => {

            resultadoConsultaContaCaixa.innerHTML = '';

            contas.forEach(conta => {

                const status = conta.ativo
                    ? 'Ativo'
                    : 'Inativo';

                resultadoConsultaContaCaixa.innerHTML += `
                    <tr>
                        <td>${conta.id}</td>
                        <td>${conta.nome}</td>
                        <td>${status}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherContaCaixa(${JSON.stringify(conta)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });

        });

});

btnSalvar.addEventListener('click', function () {
    formContaCaixa.action = rotas.salvar;
});

btnAlterar.addEventListener('click', function () {
    formContaCaixa.action = rotas.editar;
});

btnExcluir.addEventListener('click', function (event) {
    if (!confirm('Deseja realmente excluir esta conta caixa?')) {
        event.preventDefault();
        return;
    }
    formContaCaixa.action = rotas.excluir;
});

function atualizarBotoes() {

    if (idContaCaixa.value.trim() !== '') {
        btnSalvar.disabled = true;
        btnAlterar.disabled = false;
        btnExcluir.disabled = false;
    } else {
        btnSalvar.disabled = false;
        btnAlterar.disabled = true;
        btnExcluir.disabled = true;
    }
}

function escolherContaCaixa(contaCaixa) {

    document.getElementById('id').value = contaCaixa.id;
    document.getElementById('nome').value = contaCaixa.nome;
    document.getElementById('status').checked = contaCaixa.ativo;
    document.getElementById('agencia').value = contaCaixa.agencia;
    document.getElementById('conta').value = contaCaixa.conta;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaContaCaixa')
    );

    modal.hide();

    atualizarBotoes();
}