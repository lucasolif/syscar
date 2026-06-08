const campoConsultaServico = document.getElementById('campoConsultaServico');
const resultadoConsultaServico = document.getElementById('resultadoConsultaServico');
const formServico = document.getElementById('formServico');
const campoIdServico = document.getElementById('id');
const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir = document.getElementById('btnExcluir');

const rotas = {
    salvar: '/servico/salvar',
    editar: '/servico/editar/',
    excluir: '/servico/excluir',
    buscar: '/servico/buscar?filtro='
};

campoConsultaServico.addEventListener('keyup', function () {

    const filtro = campoConsultaServico.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(servicos => {

            resultadoConsultaServico.innerHTML = '';

            servicos.forEach(servico => {
                const status = servico.ativo
                    ? 'Ativo'
                    : 'Inativo';

                resultadoConsultaServico.innerHTML += `
                    <tr>
                        <td>${servico.id}</td>
                        <td>${servico.nome}</td>
                        <td>${servico.valor}</td>
                        <td>${status}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherServico(${JSON.stringify(servico)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });

        });

});

btnSalvar.addEventListener('click', function () {
    formServico.action = rotas.salvar;
});

btnAlterar.addEventListener('click', function () {
    formServico.action = rotas.editar;
});

btnExcluir.addEventListener('click', function (event) {
    if (!confirm('Deseja realmente excluir este serviço?')) {
        event.preventDefault();
        return;
    }
    formServico.action = rotas.excluir;
});

function atualizarBotoes() {
    if (campoIdServico.value.trim() !== '') {
        btnSalvar.disabled = true;
        btnAlterar.disabled = false;
        btnExcluir.disabled = false;
    } else {
        btnSalvar.disabled = false;
        btnAlterar.disabled = true;
        btnExcluir.disabled = true;
    }
}

function escolherServico(servico) {

    document.getElementById('id').value = servico.id;
    document.getElementById('nome').value = servico.nome;
    document.getElementById('descricao').value = servico.descricao;
    document.getElementById('valor').value = servico.valor;
    document.getElementById('status').checked = servico.ativo;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaServico')
    );

    modal.hide();
    atualizarBotoes();
}