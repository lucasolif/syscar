const campoConsultaProduto = document.getElementById('campoConsultaProduto');
const resultadoConsultaProduto = document.getElementById('resultadoConsultaProduto');
const formProduto = document.getElementById('formProduto');
const idProduto = document.getElementById('id');
const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir = document.getElementById('btnExcluir');

const rotas = {
    salvar: '/produto/salvar',
    editar: '/produto/editar/',
    excluir: '/produto/excluir',
    buscar: '/produto/buscar?filtro='
};

campoConsultaProduto.addEventListener('keyup', function () {
    consultarUsuario();
});

btnSalvar.addEventListener('click', function (event) {
    formProduto.action = rotas.salvar;
});

btnAlterar.addEventListener('click', function (event) {
    formProduto.action = rotas.editar;
});

btnExcluir.addEventListener('click', function () {
    if (!confirm('Deseja realmente excluir este produto?')) {
        return;
    }
    formProduto.action = rotas.excluir;
});

function atualizarBotoes() {
    if (idProduto.value.trim() !== '') {
        btnSalvar.disabled = true;
        btnAlterar.disabled = false;
        btnExcluir.disabled = false;
    } else {
        btnSalvar.disabled = false;
        btnAlterar.disabled = true;
        btnExcluir.disabled = true;
    }
}

function consultarUsuario(){
    const filtro = campoConsultaProduto.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
    .then(response => response.json())
    .then(produtos => {
        resultadoConsultaProduto.innerHTML = '';
        produtos.forEach(produto => {

            let status;

            if (produto.ativo) {
                status = 'Ativo';
            } else {
                status = 'Inativo';
            }

            resultadoConsultaProduto.innerHTML += `
                <tr>
                    <td>${produto.id}</td>
                    <td>${produto.nome}</td>
                    <td>${status}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" onclick='escolherProduto(${JSON.stringify(produto)})'>
                            Escolher
                        </button>
                    </td>
                </tr>
            `;
        });
    });
}

function escolherProduto(produto) {
    document.getElementById('id').value = produto.id;
    document.getElementById('nome').value = produto.nome;
    document.getElementById('marca').value = produto.marca;
    document.getElementById('descricao').value = produto.descricao;
    document.getElementById('precoCusto').value = produto.precoCusto;
    document.getElementById('precoVenda').value = produto.precoVenda;
    document.getElementById('status').checked = produto.ativo;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaProduto')
    );
    modal.hide();
    this.atualizarBotoes();
}