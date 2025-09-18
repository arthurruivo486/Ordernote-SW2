<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Produtos</title>
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
    .table-card {
      background: #fff;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
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
          <a class="nav-link" href="../HTML/index.html"><i class="bi bi-grid me-2"></i>Home</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../HTML/vendas.html"><i class="bi bi-cart me-2"></i>Vendas</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="productGroupView.php"><i class="bi bi-box me-2"></i>Grupos</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link active" href="#"><i class="bi bi-bag me-2"></i>Produtos</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="../HTML/usuario.html"><i class="bi bi-people me-2"></i>Usuários</a>
        </li>
      </ul>
    </div>

    <!-- Main content -->
    <div class="col-md-10 p-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Produtos</h2>
        <a class="btn btn-success" href="productAdd.php"><i class="bi bi-plus-circle me-1"></i> Cadastrar</a>
      </div>

      <div class="table-card">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Grupo</th>
              <th>Nome</th>
              <th>Descrição</th>
              <th>Imagem</th>
              <th>Preço</th>
              <th>Estoque</th>
              <th>Status</th>
              <th class="text-center">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
              <td><?php echo $product['id']; ?></td>
              <td><?php echo $product['group_id']; ?></td>
              <td><?php echo $product['name']; ?></td>
              <td><?php echo $product['description']; ?></td>
              <td>
                <?php if (!empty($product['image_url'])): ?>
                  <img src="<?php echo $product['image_url']; ?>" alt="Imagem" width="50" class="rounded">
                <?php else: ?>
                  <span class="text-muted">Sem imagem</span>
                <?php endif; ?>
              </td>
              <td>R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
              <td><?php echo $product['stock']; ?></td>
              <td>
                <?php if ($product['is_active']): ?>
                  <span class="badge bg-success">Ativo</span>
                <?php else: ?>
                  <span class="badge bg-secondary">Inativo</span>
                <?php endif; ?>
              </td>
              <td class="text-center">
                <a class="btn btn-warning btn-sm" href="productUpdate.php?id=<?php echo $product['id']?>">
                  <i class="bi bi-pencil-square"></i> Editar
                </a>
                <a class="btn btn-danger btn-sm" href="productDelete.php?id=<?php echo $product['id']?>">
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
