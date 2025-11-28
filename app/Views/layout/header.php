<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>MVC – Panel de usuarios</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body { background-color: #f8f9fa; }
  section { box-shadow: 0 0 8px rgba(0,0,0,0.05); }
</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-white border-bottom mb-3">
  <div class="container">

    <a class="navbar-brand" href="<?= site_url('users'); ?>">Usuarios</a>
    <a class="btn btn-outline-primary ms-2" href="<?= site_url('documents'); ?>">Documentos</a>
    <a class="btn btn-outline-secondary ms-2" href="<?= site_url('images'); ?>">Imágenes</a>

    <div class="ms-auto">
      <?php if (session()->has('user')): ?>
        <span class="me-2">Hola, <?= esc(session('user.name')) ?></span>
        <a class="btn btn-sm btn-outline-danger" href="<?= site_url('logout'); ?>">Salir</a>
      <?php endif; ?>
    </div>

  </div>
</nav>

<main class="container">
  <section class="text-center p-4 mb-4 bg-white border rounded">
  <h2 class="fw-bold">Universidad de Guadalajara – UDGVirtual</h2>
  <h3>Licenciatura en Desarrollo de Sistemas Web</h3>
  <h4 class="mt-3">Producto Integrador</h4>
  <p><strong>Alumno:</strong> Néstor Didier Lino González<br>
     <strong>Asesor:</strong> Luis Eduardo Alvarez Becerra<br>
     <strong>Materia:</strong> Lenguajes de programación Back End<br>
     <strong>Fecha:</strong> <?= date('d/m/Y'); ?>
  </p>
</section>
<?php if (session()->getFlashdata('msg')): ?>
  <div class="alert alert-success"><?= esc(session()->getFlashdata('msg')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
  <div class="alert alert-danger">
    <?php foreach(session('errors') as $e): ?>
      <div>• <?= esc($e) ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
