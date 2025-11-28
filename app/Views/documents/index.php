<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h3 m-0">Panel de documentos</h1>
  <a class="btn btn-light" href="<?= site_url('users'); ?>">← Panel de usuarios</a>
</div>

<p>Genera reportes de los usuarios registrados en diferentes formatos de archivo.</p>

<div class="d-flex flex-wrap gap-2">
  <a class="btn btn-outline-primary" href="<?= site_url('documents/word'); ?>">Descargar Word</a>
  <a class="btn btn-outline-success" href="<?= site_url('documents/excel'); ?>">Descargar Excel</a>
  <a class="btn btn-outline-danger" href="<?= site_url('documents/pdf'); ?>">Descargar PDF</a>
</div>
