<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? esc($title) . ' | ' : '' ?>Sistema Visitas Médicas</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    header.navbar {
      background-color: #007bff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    header .navbar-brand {
      font-weight: 600;
      color: #fff !important;
      font-size: 1.3rem;
    }
    header .nav-link {
      color: #fff !important;
      margin-right: 10px;
      transition: all 0.3s ease;
    }
    header .nav-link:hover {
      text-decoration: underline;
      color: #dfe6e9 !important;
    }
    footer {
      background: #007bff;
      color: white;
      text-align: center;
      padding: 15px;
      margin-top: 30px;
    }
  </style>
</head>

<body>
  <header class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="<?= base_url('menu') ?>">
        <i class="fa-solid fa-hospital-user"></i> Visitas Médicas
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('empleado') ?>"><i class="fa-solid fa-users"></i> Empleados</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('departamento') ?>"><i class="fa-solid fa-building"></i> Departamentos</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('informegasto') ?>"><i class="fa-solid fa-file-invoice-dollar"></i> Informe de Gastos</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('bonificacion') ?>"><i class="fa-solid fa-gift"></i> Bonificaciones</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('nomina') ?>"><i class="fa-solid fa-money-bill-wave"></i> Nómina</a></li>
          <li class="nav-item"><a class="nav-link text-warning" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Salir</a></li>
        </ul>
      </div>
    </div>
  </header>

  <main class="container py-4">