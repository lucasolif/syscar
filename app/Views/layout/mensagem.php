<?php if (isset($_SESSION['flash'])): ?>

    <div id="flash-message" class="alert alert-<?= $_SESSION['flash']['tipo']; ?> alert-dismissible fade show" role="alert">

        <?= $_SESSION['flash']['mensagem']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert">
        </button>

    </div>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');

            if (flash) {
                flash.classList.remove('show');

                setTimeout(() => {
                    flash.remove();
                }, 150);
            }
        }, 10000);
    </script>

    <?php unset($_SESSION['flash']); ?>

<?php endif; ?>