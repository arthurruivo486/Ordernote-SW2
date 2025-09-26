<?php
// views/sales/salesUpdate.php
require_once __DIR__ . '/../../controllers/salesController.php';
$controller = new SalesController();

$id = $_GET['id'] ?? 0;
if (!$id) {
    die("ID da venda não informado.");
}

// buscarPorId pode retornar array de linhas (venda + itens) ou apenas uma linha
$rows = $controller->buscarPorId($id);
if (!$rows) {
    die("Venda não encontrada.");
}

// Normalize: se veio apenas uma linha associativa, transforme em array de linhas
if (isset($rows['id']) || isset($rows['sale_id'])) {
    $rows = [$rows];
}

// Extrai dados da venda (usa a primeira linha como fonte)
$first = $rows[0];
$saleId = $first['sale_id'] ?? $first['id'] ?? $id;
$customer_id = $first['customer_id'] ?? null;
$user_id = $first['user_id'] ?? null;
$total_amount = $first['total_amount'] ?? $first['total'] ?? '';
$payment_method = $first['payment_method'] ?? '';
$status = $first['status'] ?? '';
$created_at = $first['created_at'] ?? $first['date'] ?? '';

// Monta lista de itens a partir das linhas (se existirem)
$items = [];
foreach ($rows as $r) {
    // Só adiciona se houver informação de item
    if (isset($r['product_id']) || isset($r['product_name']) || isset($r['quantity'])) {
        $items[] = [
            'product_id' => $r['product_id'] ?? null,
            'product_name' => $r['product_name'] ?? ($r['name'] ?? null),
            'quantity' => $r['quantity'] ?? ($r['qty'] ?? 1),
            'unit_price' => $r['unit_price'] ?? ($r['price'] ?? 0),
            'subtotal' => $r['subtotal'] ?? null
        ];
    }
}

// buscando listas para selects
$customers = $controller->buscarClientes(); // array de clientes [id, name]
$products  = $controller->buscarProdutos(); // array de produtos [id, name, price?]

// helper para escapar valores
function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Editar Venda #<?= e($saleId); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f0f1f3; }
    .card { background:#fff; padding:2rem; border-radius:1rem; margin:2rem auto; max-width:900px; }
    .item-row { margin-bottom: .5rem; }
  </style>
</head>
<body>
<div class="container">
  <div class="card">
    <h3 class="fw-bold text-warning mb-3"><i class="bi bi-pencil"></i> Editar Venda #<?= e($saleId); ?></h3>

    <form action="../../controllers/salesController.php" method="POST">
      <input type="hidden" name="acao" value="editar">
      <input type="hidden" name="id" value="<?= e($saleId); ?>">

      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Cliente</label>
          <select class="form-select" name="customer_id" required>
            <option value="">Selecione o cliente</option>
            <?php foreach ($customers as $c): ?>
              <option value="<?= e($c['id']); ?>" <?= ($c['id'] == $customer_id) ? 'selected' : ''; ?>>
                <?= e($c['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Usuário (ID)</label>
          <input type="number" name="user_id" class="form-control" value="<?= e($user_id); ?>">
        </div>

        <div class="col-md-3">
          <label class="form-label">Data</label>
          <input type="text" class="form-control" value="<?= e($created_at); ?>" disabled>
        </div>
      </div>

      <!-- Itens da venda -->
      <div class="mb-3">
        <label class="form-label">Itens</label>
        <div id="items-container">
          <?php if (!empty($items)): ?>
            <?php foreach ($items as $i => $it): ?>
              <div class="row item-row align-items-end" data-index="<?= $i; ?>">
                <div class="col-md-6">
                  <label class="form-label small">Produto</label>
                  <select class="form-select" name="items[<?= $i; ?>][product_id]" required>
                    <option value="">Selecione</option>
                    <?php foreach ($products as $p): ?>
                      <option value="<?= e($p['id']); ?>" <?= ($p['id'] == $it['product_id']) ? 'selected' : ''; ?>>
                        <?= e($p['name']); ?><?= isset($p['price']) ? ' - R$ '.number_format($p['price'],2,',','.') : ''; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-3">
                  <label class="form-label small">Quantidade</label>
                  <input type="number" class="form-control" name="items[<?= $i; ?>][quantity]" min="1" value="<?= e($it['quantity']); ?>" required>
                </div>

                <div class="col-md-2">
                  <label class="form-label small">Preço unit.</label>
                  <input type="text" class="form-control" name="items[<?= $i; ?>][unit_price]" value="<?= e($it['unit_price']); ?>">
                </div>

                <div class="col-md-1 text-end">
                  <button type="button" class="btn btn-danger btn-sm remove-item" title="Remover">&times;</button>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <!-- Nenhum item: renderiza uma linha vazia -->
            <div class="row item-row" data-index="0">
              <div class="col-md-6">
                <label class="form-label small">Produto</label>
                <select class="form-select" name="items[0][product_id]" required>
                  <option value="">Selecione</option>
                  <?php foreach ($products as $p): ?>
                    <option value="<?= e($p['id']); ?>"><?= e($p['name']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label small">Quantidade</label>
                <input type="number" class="form-control" name="items[0][quantity]" min="1" value="1" required>
              </div>
              <div class="col-md-2">
                <label class="form-label small">Preço unit.</label>
                <input type="text" class="form-control" name="items[0][unit_price]" value="">
              </div>
              <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-item" title="Remover">&times;</button>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <div class="mt-2">
          <button type="button" id="add-item" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-plus"></i> Adicionar item
          </button>
        </div>
      </div>

      <!-- Totais e pagamento (opcional) -->
      <div class="row g-3 mb-3">
        <div class="col-md-4">
          <label class="form-label">Total (R$)</label>
          <input type="text" name="total_amount" class="form-control" value="<?= e($total_amount); ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Forma de pagamento</label>
          <input type="text" name="payment_method" class="form-control" value="<?= e($payment_method); ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label">Status</label>
          <input type="text" name="status" class="form-control" value="<?= e($status); ?>">
        </div>
      </div>

      <div class="d-flex justify-content-between">
        <a href="salesView.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
        <button type="submit" class="btn btn-warning text-white"><i class="bi bi-save"></i> Atualizar</button>
      </div>
    </form>
  </div>
</div>

<script>
(function(){
    const productsOptions = `<?php 
        foreach ($products as $p) {
            echo '<option value="'.htmlspecialchars($p['id'], ENT_QUOTES).'">'
                . htmlspecialchars($p['name'], ENT_QUOTES);

            if (isset($p['price'])) {
                echo ' - R$ '.number_format($p['price'], 2, ',', '.');
            }

            echo '</option>';
        }
    ?>`;

    const container = document.getElementById('items-container');
    const addBtn = document.getElementById('add-item');

    function getNextIndex() {
        let max = -1;
        container.querySelectorAll('.item-row').forEach(row => {
            const idx = parseInt(row.getAttribute('data-index')) || 0;
            if (idx > max) max = idx;
        });
        return max + 1;
    }

    function createRow(index) {
        const div = document.createElement('div');
        div.className = 'row item-row align-items-end';
        div.setAttribute('data-index', index);
        div.innerHTML = `
            <div class="col-md-6">
                <label class="form-label small">Produto</label>
                <select class="form-select" name="items[${index}][product_id]" required>
                    <option value="">Selecione</option>
                    ${productsOptions}
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small">Quantidade</label>
                <input type="number" class="form-control" name="items[${index}][quantity]" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Preço unit.</label>
                <input type="text" class="form-control" name="items[${index}][unit_price]" value="">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-item" title="Remover">&times;</button>
            </div>
        `;
        return div;
    }

    addBtn.addEventListener('click', function(){
        const idx = getNextIndex();
        container.appendChild(createRow(idx));
    });

    container.addEventListener('click', function(e){
        if (e.target && e.target.matches('.remove-item')) {
            const row = e.target.closest('.item-row');
            if (row) row.remove();
        }
    });
})();
</script>
</body>
</html>
