<div class="container" style="max-width: 420px;">
    <h2 class="mb-3 text-center">Crear cuenta</h2>

    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <?php foreach(session('errors') as $e): ?>
                <div><?= esc($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= site_url('register'); ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control"
                   required minlength="3" value="<?= old('name') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" name="login" class="form-control"
                   required minlength="3" value="<?= old('login') ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control"
                   required minlength="4">
        </div>

        <button class="btn btn-primary w-100">Crear cuenta</button>

        <div class="text-center mt-3">
            <a href="<?= site_url('login'); ?>">← Volver al login</a>
        </div>
    </form>
</div>
