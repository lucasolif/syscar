document.addEventListener('DOMContentLoaded', function () {

    if (window.abrirModalAlterarSenha) {
        const modalAlterarSenha = document.getElementById('modalAlterarSenha');

        if (modalAlterarSenha) {
            const modal = new bootstrap.Modal(modalAlterarSenha);
            modal.show();

            setTimeout(() => {
                modal.hide();
                window.location.href = '/logout';
            }, 2000);
        }
    }
});