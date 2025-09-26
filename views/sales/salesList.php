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
  <title>Lista de Vendas</title>
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
            $saleId = $v['sale_id'] ?? null;
            if (!$saleId) continue;

            $customerName = $v['customer_name'] ?? '-';
            $total = isset($v['total_amount']) ? number_format((float)$v['total_amount'], 2, ',', '.') : '-';
            $date = $v['created_at'] ?? '-';

            // Busca os itens da venda (garante que sempre mostra produtos)
            $itens = $controller->buscarItensVenda($saleId);
            $productsDisplay = '-';
            if (!empty($itens)) {
                $parts = [];
                foreach ($itens as $it) {
                    $iname = $it['product_name'] ?? ('ID ' . ($it['product_id'] ?? '?'));
                    $iqty  = $it['quantity'] ?? 0;
                    $parts[] = htmlspecialchars($iname) . ' (' . (int)$iqty . ')';
                }
                $productsDisplay = implode(', ', $parts);
            }

            $editHref = "salesUpdate.php?id=" . urlencode($saleId);
            $delHref  = "salesDelete.php?id=" . urlencode($saleId);
          ?>
          <tr>
            <td><?= htmlspecialchars($saleId); ?></td>
            <td><?= htmlspecialchars($customerName); ?></td>
            <td><?= $productsDisplay; ?></td>
            <td><?= $total; ?></td>
            <td><?= htmlspecialchars($date); ?></td>
            <td>
              <a href="<?= $editHref; ?>" class="btn btn-warning btn-sm" title="Editar">
                <i class="bi bi-pencil-square"></i>
              </a>
              <a href="<?= $delHref; ?>" class="btn btn-danger btn-sm" title="Excluir">
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