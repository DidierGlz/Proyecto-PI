<?php
  $user = session('user');
  $isAdmin = isset($user['role']) && $user['role'] === 'admin';
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h1 class="h3 m-0">Mis imágenes</h1>
    <small class="text-muted">
      <?php if ($isAdmin): ?>
        Administrador: <?= esc($user['name'] ?? $user['login'] ?? '') ?>
      <?php else: ?>
        Usuario: <?= esc($user['name'] ?? $user['login'] ?? '') ?>
      <?php endif; ?>
    </small>
  </div>

  <div class="d-flex gap-2">
    <?php if ($isAdmin && !empty($usersList)): ?>
      <form method="get" action="<?= site_url('images'); ?>" class="d-flex align-items-center gap-2">
        <label class="form-label m-0 me-1">Ver galería de:</label>
        <select name="user_id" class="form-select form-select-sm" onchange="this.form.submit()">
          <?php foreach ($usersList as $uItem): ?>
            <option value="<?= esc($uItem['id']); ?>" <?= (int)$currentUserId === (int)$uItem['id'] ? 'selected' : '' ?>>
              <?= esc($uItem['name'].' ('.$uItem['login'].')'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    <?php endif; ?>
    <a class="btn btn-light" href="<?= site_url('users'); ?>">← Panel de usuarios</a>
  </div>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="h5">Agregar imagen</h2>
        <form action="<?= site_url('images/upload'); ?>" method="post" enctype="multipart/form-data" onsubmit="return validateImageForm(event)">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" required minlength="3" value="<?= esc(old('title','')) ?>">
          </div>

          <div class="mb-3">
            <label class="form-label">Categoría (opcional)</label>
            <input type="text" name="category" class="form-control" value="<?= esc(old('category','')) ?>" placeholder="Ej. Proyecto, Familiar, Trabajo">
          </div>

          <div class="mb-3">
            <label class="form-label">Archivo de imagen</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
          </div>

          <button class="btn btn-primary w-100" type="submit">Subir imagen</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 m-0">Galería</h2>
      <form class="d-flex gap-2" method="get" action="<?= site_url('images'); ?>">
        <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
          <option value="">Todas las categorías</option>
          <?php foreach ($categories as $c): ?>
            <?php $cat = $c['category']; ?>
            <option value="<?= esc($cat) ?>" <?= $cat === $currentCategory ? 'selected' : '' ?>>
              <?= esc($cat) ?>
            </option>
          <?php endforeach; ?>
        </select>
        <?php if ($currentCategory): ?>
          <a class="btn btn-sm btn-outline-secondary" href="<?= site_url('images'); ?>">Limpiar filtro</a>
        <?php endif; ?>
      </form>
    </div>

    <?php if (empty($images)): ?>
      <div class="alert alert-info">Aún no has agregado imágenes.</div>
    <?php else: ?>
      <div class="row g-3">
        <?php foreach ($images as $img): ?>
          <div class="col-sm-6 col-lg-4">
            <div class="card h-100 shadow-sm image-card">
              <div class="ratio ratio-4x3">
                <img src="<?= base_url('uploads/images/'.$img['filename']); ?>" 
                     alt="<?= esc($img['title']); ?>" class="card-img-top object-fit-cover">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-1"><?= esc($img['title']); ?></h5>
                <?php if ($img['category']): ?>
                  <span class="badge bg-secondary mb-2"><?= esc($img['category']); ?></span>
                <?php endif; ?>
                <small class="text-muted mb-2">Subida: <?= esc($img['created_at']); ?></small>
                <form action="<?= site_url('images/'.$img['id'].'/delete'); ?>" method="post" class="mt-auto" onsubmit="return confirmDeleteImage(event)">
                  <?= csrf_field() ?>
                  <button type="submit" class="btn btn-sm btn-outline-danger w-100">Eliminar</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
