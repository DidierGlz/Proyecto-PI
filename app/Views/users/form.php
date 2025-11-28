<?php
  $isEdit = ($mode === 'edit');
  $action = $isEdit ? site_url('users/'.$user['id']) : site_url('users');
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0"><?= $isEdit ? 'Editar usuario' : 'Crear usuario' ?></h1>
  <a class="btn btn-light" href="<?= site_url('users'); ?>">← Volver</a>
</div>

<div class="card">
  <div class="card-body">
    <form action="<?= $action ?>" method="post" onsubmit="return validateUserForm(event)">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input class="form-control" type="text" name="name" required minlength="3"
               value="<?= esc(old('name', $user['name'])) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Login</label>
        <input class="form-control" type="text" name="login" required minlength="3"
               value="<?= esc(old('login', $user['login'])) ?>">
      </div>
      <div class="mb-3">
        <label class="form-label"><?= $isEdit ? 'Password (dejar en blanco para conservar)' : 'Password' ?></label>
        <input class="form-control" type="password" name="password" <?= $isEdit ? '' : 'required' ?> minlength="4">
      </div>
      <button class="btn btn-primary" type="submit"><?= $isEdit ? 'Actualizar' : 'Crear' ?></button>
    </form>
  </div>
</div>
