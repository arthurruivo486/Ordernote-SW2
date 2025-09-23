<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Grupos de Produtos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
    .table-card {
      background: #fff;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
          <a class="nav-link" href="../dashboard/HTML/index.html"><i class="bi bi-grid me-2"></i>Home</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../sales/index.php"><i class="bi bi-cart me-2"></i>Vendas</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link active" href="#"><i class="bi bi-boxes me-2"></i>Grupos</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../products/index.php"><i class="bi bi-box me-2"></i>Produtos</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../customers/index.php"><i class="bi bi-people me-2"></i>Clientes</a>
        </li>
      </ul>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Grupos de Produtos</h2>
        <a class="btn btn-success" href="productGroupAdd.php"><i class="bi bi-plus-circle me-1"></i> Cadastrar</a>
      </div>

      <div class="table-card">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Ícone</th>
              <th class="text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($groups as $group): ?>
            <tr>
              <td><?php echo $group['id']; ?></td>
              <td><?php echo $group['name']; ?></td>
              <td><i class="bi <?php echo $group['icon']; ?>"></i> <?php echo $group['icon']; ?></td>
              <td class="text-center">
                <a class="btn btn-warning btn-sm" href="productGroupUpdate.php?id=<?php echo $group['id']?>">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a class="btn btn-danger btn-sm" href="productGroupDelete.php?id=<?php echo $group['id']?>" onclick="return confirm('Deseja realmente excluir este grupo?');">
                  <i class="bi bi-trash"></i> Excluir
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
