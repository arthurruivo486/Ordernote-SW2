<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?controller=login&action=index");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons (opcional) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body {
      background-color: #f0f1f3;
    }
    .sidebar {
      min-height: 100vh;
      background-color: #4e555b;
      color: white;
    }
    .sidebar .nav-link {
      color: white;
    }
    .sidebar .nav-link.active {
      background-color: #fff;
      color: #333;
      border-radius: 0.5rem;
    }
    .card-summary {
      background-color: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .recent-orders {
      background-color: white;
      padding: 1rem;
      border-radius: 1rem;
      height: 100%;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar d-flex flex-column align-items-center py-4">
      <div class="text-center mb-4">
        <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
        <p class="mt-2 fw-bold">nome</p>
      </div>
      <ul class="nav flex-column w-100 px-3">
        <li class="nav-item mb-2">
          <a class="nav-link active" href="#"><i class="bi bi-grid me-2"></i>Home</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../HTML/vendas.html"><i class="bi bi-cart me-2"></i>Vendas</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../HTML/produtos.html"><i class="bi bi-box me-2"></i>Produtos</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../HTML/usuario.html"><i class="bi bi-people me-2"></i>Usuarios</a>
        </li>
      </ul>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Home</h2>
        <button class="btn btn-dark">historico</button>
      </div>

      <!-- Resumo -->
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="card-summary text-center">
            <p class="mb-1">total do dia $</p>
            <h3>350</h3>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-summary text-center">
            <p class="mb-1">total de vendas</p>
            <h3>10</h3>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card-summary text-center">
            <i class="bi bi-cart" style="font-size: 2rem;"></i>
            <p class="mt-2">vendas</p>
          </div>
        </div>
      </div>

      <!-- Gráfico e pedidos -->
      <div class="row">
        <div class="col-md-8">
          <div class="card-summary">
            <h5 class="fw-bold mb-3">vendas por semana/dia</h5>
            <canvas id="salesChart"></canvas>
          </div>
        </div>
        <div class="col-md-4">
          <div class="recent-orders">
            <h6 class="fw-bold">Ultimos pedidos</h6>
            <div class="my-2 p-2 bg-dark text-white rounded d-flex justify-content-between">
              <span>José xxxx-xxx</span><strong>$10,00</strong>
            </div>
            <div class="my-2 p-2 bg-dark text-white rounded d-flex justify-content-between">
              <span>Rodrigo xxxx-xxx</span><strong>$60,00</strong>
            </div>
            <div class="my-2 p-2 bg-dark text-white rounded d-flex justify-content-between">
              <span>Loren xxxx-xxx</span><strong>$30,00</strong>
            </div>
            <div class="my-2 p-2 bg-dark text-white rounded d-flex justify-content-between">
              <span>José xxxx-xxx</span><strong>$100,00</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart script -->
<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
      datasets: [{
        label: 'Vendas',
        data: [8, 12, 16, 20, 15, 13, 4],
        backgroundColor: [
          '#ced4da', '#adb5bd', '#6c757d', '#495057', '#343a40', '#212529', '#000'
        ]
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>