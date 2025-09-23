<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f1f3
    }

    .card-view {
      background: #fff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      margin: 2rem auto;
    }
  </style>
</head>

<body>
  <div class="container">
    <?php
    require_once __DIR__ .  "/../../controllers/salesController.php";
    $controller = new SalesController();
    $vendas = $controller->listar();
    ?>
    <div class="card-view">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary"><i class="bi bi-list me-2"></i> Lista de Vendas</h3>
        <a href="salesAdd.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Nova Venda</a>
      </div>
      <table class="table table-striped">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($vendas)): ?>
            <?php foreach ($vendas as $v): ?>
              <tr>
                <td><?= $v['id']; ?></td>
                <td><?= htmlspecialchars($v['customer_name']); ?></td>
                <td><?= htmlspecialchars($v['product_name']); ?></td>
                <td><?= $v['quantity']; ?></td>
                <td><?= $v['created_at']; ?></td>
                <td>
                  <a href="salesUpdate.php?id=<?= $v['id']; ?>" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="salesDelete.php?id=<?= $v['id']; ?>" class="btn btn-danger btn-sm">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">Nenhuma venda encontrada.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>