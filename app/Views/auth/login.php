<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h4 mb-3">Acceso de usuario</h1>
        <form action="<?= site_url('login'); ?>" method="post" onsubmit="return validateLoginForm(event)">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" name="login" class="form-control" required minlength="3" value="<?= esc(old('login','')) ?>">
          </div>
          <div class="mb-3">
            <label class="form-label d-flex justify-content-between">
              <span>Password</span>
              <a href="#" onclick="togglePwd();return false;">Mostrar/Ocultar</a>
            </label>
            <input type="password" id="pwd" name="password" class="form-control" required minlength="4">
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label" for="remember">Recordarme (30 días)</label>
          </div>
          <div class="text-center mt-3">
    <a href="<?= site_url('register'); ?>">¿No tienes cuenta? Regístrate aquí</a>
</div>
          <button class="btn btn-primary" type="submit">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
