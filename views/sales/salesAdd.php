<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Venda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {background-color: #f0f1f3}
    .card-add {background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin: 2rem auto;}
  </style>
</head>
<body>
<div class="container">
  <?php
    require_once "../../controllers/salesController.php";
    $controller = new SalesController();
    $customers = $controller->buscarClientes();
    $products = $controller->buscarProdutos();
  ?>
  <div class="card-add">
    <h3 class="fw-bold text-success mb-4">
      <i class="bi bi-plus-circle me-2"></i> Registrar Venda
    </h3>
    <form action="../../controllers/salesController.php" method="POST">
      <!-- Cliente -->
      <div class="mb-3">
        <label for="customer_id" class="form-label">Cliente</label>
        <select name="customer_id" id="customer_id" class="form-select" required>
          <option value="">Selecione o cliente</option>
          <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id']; ?>">
              <?= htmlspecialchars($c['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Produto -->
      <div class="mb-3">
        <label for="product_id" class="form-label">Produto</label>
        <select name="product_id" id="product_id" class="form-select" required>
          <option value="">Selecione o produto</option>
          <?php foreach ($products as $p): ?>
            <option value="<?= $p['id']; ?>">
              <?= htmlspecialchars($p['name']); ?> - R$ <?= number_format($p['price'], 2, ',', '.'); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Quantidade -->
      <div class="mb-3">
        <label for="quantity" class="form-label">Quantidade</label>
        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
      </div>

      <input type="hidden" name="acao" value="incluir">

      <div class="d-flex justify-content-between mt-4">
        <a href="salesView.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
        </a>
        <button class="btn btn-success text-white" type="submit">
          <i class="bi bi-check-circle me-1"></i> Registrar
        </button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
