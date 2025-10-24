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
        body { background-color: #f8f9fa; }
        .card-view {
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 2rem auto;
        }
        .table th {
            background-color: #343a40;
            color: white;
            border: none;
        }
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-pendente {
            background-color: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card-view">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark">
                    <i class="bi bi-receipt me-2"></i> Vendas
                </h3>
                <a href="salesAdd.php" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Nova Venda
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Pedido</th>
                            <th>Total</th>
                            <th>Pagamento</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($vendas) && is_array($vendas)): ?>
                            <?php foreach ($vendas as $v): ?>
                                <?php 
                                $saleId = $v['id'] ?? $v['sale_id'] ?? null;
                                if (!$saleId) continue;
                                
                                $customerName = $v['customer_name'] ?? 'N/A';
                                $orderId = $v['order_id'] ?? '#' . $saleId;
                                $total = isset($v['total_amount']) ? 'R$ ' . number_format((float)$v['total_amount'], 2, ',', '.') : 'R$ 0,00';
                                $paymentMethod = $v['payment_method'] ?? 'Cash';
                                $status = $v['status'] ?? 'Pendente';
                                $date = isset($v['created_at']) ? date('d/m/Y', strtotime($v['created_at'])) : '-';
                                ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($saleId); ?></strong></td>
                                    <td><?= htmlspecialchars($customerName); ?></td>
                                    <td><?= htmlspecialchars($orderId); ?></td>
                                    <td><strong><?= $total; ?></strong></td>
                                    <td><?= htmlspecialchars($paymentMethod); ?></td>
                                    <td>
                                        <span class="status-badge status-pendente">
                                            <?= htmlspecialchars($status); ?>
                                        </span>
                                    </td>
                                    <td><?= htmlspecialchars($date); ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="salesUpdate.php?id=<?= urlencode($saleId); ?>" 
                                               class="btn btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="salesDelete.php?id=<?= urlencode($saleId); ?>" 
                                               class="btn btn-outline-danger" title="Excluir"
                                               onclick="return confirm('Tem certeza que deseja excluir esta venda?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                    Nenhuma venda encontrada.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>