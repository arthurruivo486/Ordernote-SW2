<?php
require_once __DIR__ . "/../../controllers/salesController.php";
$controller = new SalesController();
$vendas = $controller->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Vendas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {background-color: #f0f1f3}
    .card-view {background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin: 2rem auto;}
  </style>
</head>
<body>
<div class="container">
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
          <th>Produtos (qtd)</th>
          <th>Total</th>
          <th>Data</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($vendas) && is_array($vendas)): ?>
        <?php foreach ($vendas as $v): ?>
          <?php
            $saleId = $v['id'] ?? $v['sale_id'] ?? null;
            if (!$saleId) {
                continue;
            }

            $customerName = $v['customer_name'] ?? $v['name'] ?? '-';

            $total = isset($v['total_amount']) ? number_format((float)$v['total_amount'], 2, ',', '.') : '-';

            $date = $v['created_at'] ?? $v['date'] ?? '-';

// Produtos (se já vierem no array como 'products')
$productsDisplay = '-';
if (!empty($v['products'])) {
    // Caso já venha como string formatada
    if (is_string($v['products'])) {
        $productsDisplay = htmlspecialchars($v['products']);
    }
    // Caso venha como array (lista de itens)
    elseif (is_array($v['products'])) {
        $parts = [];
        foreach ($v['products'] as $p) {
            $pname = $p['product_name'] ?? '-';
            $pqty  = $p['quantity'] ?? 0;
            $parts[] = htmlspecialchars($pname) . ' (' . (int)$pqty . ')';
        }
        $productsDisplay = implode(', ', $parts);
    }
}


            // URLs seguras para ação (só cria hrefs se id existir)
            $editHref = $saleId ? "salesUpdate.php?id=" . urlencode($saleId) : '#';
            $delHref  = $saleId ? "salesDelete.php?id=" . urlencode($saleId) : '#';
          ?>
          <tr>
            <td><?= htmlspecialchars($saleId); ?></td>
            <td><?= htmlspecialchars($customerName); ?></td>
            <td><?= $productsDisplay; ?></td>
            <td><?= $total; ?></td>
            <td><?= htmlspecialchars($date); ?></td>
            <td>
              <?php if ($saleId): ?>
                <a href="<?= $editHref; ?>" class="btn btn-warning btn-sm" title="Editar">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <a href="<?= $delHref; ?>" class="btn btn-danger btn-sm" title="Excluir">
                  <i class="bi bi-trash"></i>
                </a>
              <?php else: ?>
                <span class="text-muted">Sem ações</span>
              <?php endif; ?>
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
