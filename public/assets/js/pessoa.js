const campoConsultaPessoa = document.getElementById('campoConsultaPessoa');
const resultadoConsultaPessoa = document.getElementById('resultadoConsultaPessoa');
const formPessoa = document.getElementById('formPessoa');
const idPessoa = document.getElementById('id');
const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir = document.getElementById('btnExcluir');

const rotas = {
    salvar: '/pessoa/salvar',
    editar: '/pessoa/editar/',
    excluir: '/pessoa/excluir',
    buscar: '/pessoa/buscar?filtro='
};

campoConsultaPessoa.addEventListener('keyup', function () {
    const filtro = campoConsultaPessoa.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(pessoas => {
            resultadoConsultaPessoa.innerHTML = '';

            pessoas.forEach(pessoa => {
                let status = pessoa.ativo ? 'Ativo' : 'Inativo';

                resultadoConsultaPessoa.innerHTML += `
                    <tr>
                        <td>${pessoa.id}</td>
                        <td>${pessoa.nome}</td>
                        <td>${pessoa.cpf}</td>
                        <td>${status}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherPessoa(${JSON.stringify(pessoa)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
});

btnSalvar.addEventListener('click', function () {
    formPessoa.action = rotas.salvar;
});

btnAlterar.addEventListener('click', function () {
    formPessoa.action = rotas.editar;
});

btnExcluir.addEventListener('click', function (event) {
    if (!confirm('Deseja realmente excluir esta pessoa?')) {
        event.preventDefault();
        return;
    }
    formPessoa.action = rotas.excluir;
});

function atualizarBotoes() {
    if (idPessoa.value.trim() !== '') {
        btnSalvar.disabled = true;
        btnAlterar.disabled = false;
        btnExcluir.disabled = false;
    } else {
        btnSalvar.disabled = false;
        btnAlterar.disabled = true;
        btnExcluir.disabled = true;
    }
}

function escolherPessoa(pessoa) {
    document.getElementById('id').value = pessoa.id;
    document.getElementById('nome').value = pessoa.nome;
    document.getElementById('cpf').value = pessoa.cpf;
    document.getElementById('telefone').value = pessoa.telefone;
    document.getElementById('email').value = pessoa.email;
    document.getElementById('dataNascimento').value = pessoa.dataNascimento ?? '';
    document.getElementById('logradouro').value = pessoa.logradouro;
    document.getElementById('numero').value = pessoa.numero;
    document.getElementById('complemento').value = pessoa.complemento ?? '';
    document.getElementById('bairro').value = pessoa.bairro;
    document.getElementById('cidade').value = pessoa.cidade;
    document.getElementById('cep').value = pessoa.cep;
    document.getElementById('estado').value = pessoa.estado;
    document.getElementById('status').checked = pessoa.ativo;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaPessoa')
    );

    modal.hide();

    atualizarBotoes();
}