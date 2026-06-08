const campoConsultaVeiculo = document.getElementById('campoConsultaVeiculo');
const resultadoConsultaVeiculo = document.getElementById('resultadoConsultaVeiculo');
const formVeiculo = document.getElementById('formVeiculo');
const idVeiculo = document.getElementById('id');

const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir = document.getElementById('btnExcluir');

const rotas = {
    salvar: '/veiculo/salvar',
    editar: '/veiculo/editar/',
    excluir: '/veiculo/excluir',
    buscar: '/veiculo/buscar?filtro='
};


campoConsultaVeiculo.addEventListener('keyup', function () {
    const filtro = campoConsultaVeiculo.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(veiculos => {
            resultadoConsultaVeiculo.innerHTML = '';

            veiculos.forEach(veiculo => {
                let status = veiculo.ativo ? 'Ativo' : 'Inativo';

                resultadoConsultaVeiculo.innerHTML += `
                    <tr>
                        <td>${veiculo.id}</td>
                        <td>${veiculo.modelo}</td>
                        <td>${veiculo.placa}</td>
                        <td>${status}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherVeiculo(${JSON.stringify(veiculo)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
});

btnSalvar.addEventListener('click', function () {
    formVeiculo.action = rotas.salvar;
});

btnAlterar.addEventListener('click', function () {
    formVeiculo.action = rotas.editar;
});

btnExcluir.addEventListener('click', function (event) {
    if (!confirm('Deseja realmente excluir este veículo?')) {
        event.preventDefault();
        return;
    }
    formVeiculo.action = rotas.excluir;
});

function atualizarBotoes() {
    if (idVeiculo.value.trim() !== '') {
        btnSalvar.disabled = true;
        btnAlterar.disabled = false;
        btnExcluir.disabled = false;
    } else {
        btnSalvar.disabled = false;
        btnAlterar.disabled = true;
        btnExcluir.disabled = true;
    }
}

function escolherVeiculo(veiculo) {
    document.getElementById('id').value = veiculo.id;
    document.getElementById('modelo').value = veiculo.modelo;
    document.getElementById('placa').value = veiculo.placa;
    document.getElementById('marca').value = veiculo.marca;
    document.getElementById('cor').value = veiculo.cor;
    document.getElementById('tipo').value = veiculo.tipo;
    document.getElementById('ano').value = veiculo.ano;
    document.getElementById('status').checked = veiculo.ativo;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaVeiculo')
    );

    modal.hide();
    atualizarBotoes();
}