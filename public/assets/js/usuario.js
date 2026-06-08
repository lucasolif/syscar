const formularioUsuario = document.getElementById('formUsuario');
const campoConsultaUsuario = document.getElementById('campoConsultaUsuario');
const resultadoConsultaUsuario = document.getElementById('resultadoConsultaUsuario');;

const btnSalvar = document.getElementById('btnSalvar');
const btnAlterar = document.getElementById('btnAlterar');
const btnExcluir =  document.getElementById('btnExcluir');

const rotasUsuario = {
    salvar: '/usuario/salvar',
    editar: '/usuario/editar',
    excluir: '/usuario/excluir',
    buscar: '/usuario/buscar?filtro='
};


btnSalvar.addEventListener('click', function () {

    const senha = document.getElementById('senha').value;
    const confirmacaoSenha = document.getElementById('confirmacaoSenha').value;

    if(senha !== confirmacaoSenha) {
        mensagem('warning', 'As senhas não coencidem. Verifique e tente novamente');
        return;
    }
    formularioUsuario.action = rotasUsuario.salvar;
});

btnAlterar.addEventListener('click', function () {
    formularioUsuario.action = rotasUsuario.editar;
});

btnExcluir.addEventListener('click', function () {
    if (!confirm('Deseja realmente excluir este usuário?')) {
        return;
    }
    formularioUsuario.action = rotasUsuario.excluir;
});

campoConsultaUsuario.addEventListener('keyup', function () {
    consultarUsuario();
});


function consultarUsuario() {

    const filtro = campoConsultaUsuario.value;

    fetch(rotasUsuario.buscar + encodeURIComponent(filtro))
    .then(response => response.json())
    .then(usuarios => {

        resultadoConsultaUsuario.innerHTML = '';

        usuarios.forEach(usuario => {
            resultadoConsultaUsuario.innerHTML += `
                <tr>
                    <td>${usuario.id}</td>
                    <td>${usuario.nome}</td>
                    <td>${usuario.login}</td>
                    <td>${usuario.ativo === 1 ? 'Ativo' : 'Inativo'}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" onclick='selecionarUsuario(${JSON.stringify(usuario)})'>
                            Escolher
                        </button>
                    </td>
                </tr>
            `;
        });
    });
}

function selecionarUsuario(usuario) {

    document.getElementById('id').value = usuario.id;
    document.getElementById('nome').value = usuario.nome;
    document.getElementById('login').value = usuario.login;
    document.getElementById('login').readOnly = true;
    document.getElementById('login').classList.add('campo-readonly');
    document.getElementById('senha').value = '';
    document.getElementById('senha').readOnly = true;
    document.getElementById('senha').classList.add('campo-readonly');
    document.getElementById('confirmacaoSenha').value = '';
    document.getElementById('confirmacaoSenha').readOnly = true;
    document.getElementById('confirmacaoSenha').classList.add('campo-readonly');
    document.getElementById('ativo').checked = usuario.ativo;

    document.getElementById('btnSalvar').disabled = true;
    document.getElementById('btnAlterar').disabled = false;
    document.getElementById('btnExcluir').disabled = false;

    const modal = bootstrap.Modal.getInstance(
        document.getElementById('modalConsultaUsuario')
    );

    modal.hide();
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