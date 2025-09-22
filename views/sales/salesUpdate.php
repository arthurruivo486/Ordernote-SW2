<?php 
require "../../controllers/salesController.php";
$controller = new SalesController();
$venda = $controller->buscarPorId($_GET['id']);
$products = $controller->buscarProdutos();
$customers = $controller->buscarClientes();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Venda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
  <div class="card p-4 shadow">
    <h3 class="fw-bold text-warning mb-3"><i class="bi bi-pencil"></i> Editar Venda</h3>
    <form action="../../controllers/salesController.php" method="POST">
      <input type="hidden" name="id" value="<?= $venda['id']; ?>">
      <div class="mb-3">
        <label class="form-label">Cliente</label>
        <select class="form-control" name="customer_id" required>
          <?php foreach ($customers as $c): ?>
            <option value="<?= $c['id']; ?>" <?= $c['id']==$venda['customer_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Produto</label>
        <select class="form-control" name="product_id" required>
          <?php foreach ($products as $p): ?>
            <option value="<?= $p['id']; ?>" <?= $p['id']==$venda['product_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($p['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Quantidade</label>
        <input type="number" class="form-control" name="quantity" value="<?= $venda['quantity']; ?>" required>
      </div>
      <input type="hidden" name="acao" value="atualizar">
      <div class="d-flex justify-content-between">
        <a href="salesView.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
        <button type="submit" class="btn btn-warning text-white"><i class="bi bi-save"></i> Atualizar</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>