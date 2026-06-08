const campoConsultaProduto = document.getElementById('campoConsultaProduto');
const resultadoConsultaProduto = document.getElementById('resultadoConsultaProduto');
const formMovimentacaoEstoque = document.getElementById('formMovimentacaoEstoque');

const rotas = {
    movimentar: '/estoque/movimentar',
    buscar: '/produto/buscar?filtro='
};

campoConsultaProduto.addEventListener('keyup', function () {
    const filtro = campoConsultaProduto.value;

    fetch(rotas.buscar + encodeURIComponent(filtro))
        .then(response => response.json())
        .then(produtos => {
            resultadoConsultaProduto.innerHTML = '';

            produtos.forEach(produto => {

                resultadoConsultaProduto.innerHTML += `
                    <tr>
                        <td>${produto.id}</td>
                        <td>${produto.nome}</td>
                        <td>${produto.marca}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" onclick='escolherProduto(${JSON.stringify(produto)})'>
                                Escolher
                            </button>
                        </td>
                    </tr>
                `;
            });
        });
});

formMovimentacaoEstoque.addEventListener('click', function () {
    formMovimentacaoEstoque.action = rotas.movimentar;
});

function escolherProduto(produto) {
    document.getElementById('produtoId').value = produto.id;
    document.getElementById('produtoNome').value = produto.nome;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaProduto')
    );
    modal.hide();
}