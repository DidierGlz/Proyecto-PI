<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">Usuarios</h1>

  <div class="d-flex gap-2">
    <a class="btn btn-outline-primary" href="<?= site_url('documents'); ?>">Documentos</a>
    <a class="btn btn-primary" href="<?= site_url('users/create'); ?>">+ Nuevo</a>
  </div>
</div>

<div class="card">
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-striped m-0">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Login</th>
            <th style="width:160px">Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= esc($u['id']) ?></td>
            <td><?= esc($u['name']) ?></td>
            <td><?= esc($u['login']) ?></td>
            <td>
              <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('users/'.$u['id'].'/edit'); ?>">Editar</a>
              <form class="d-inline" action="<?= site_url('users/'.$u['id'].'/delete'); ?>" method="post" onsubmit="return confirmDelete(event)">
                <?= csrf_field() ?>
                <button class="btn btn-sm btn-outline-danger" type="submit">Borrar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
