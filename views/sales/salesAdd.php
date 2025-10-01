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
  <script>
document.querySelectorAll('.qtd-input').forEach(input => {
    input.addEventListener('input', atualizarTotal);
});

function atualizarTotal() {
    let total = 0;
    document.querySelectorAll('.qtd-input').forEach(input => {
        let qtd = parseInt(input.value) || 0;
        let preco = parseFloat(input.dataset.preco);
        total += qtd * preco;
    });
    
    document.getElementById('totalCompra').innerText = 
        'R$ ' + total.toFixed(2).replace('.', ',');
    document.getElementById('total_amount').value = total.toFixed(2);
}
</script>
</head>
<body>
<div class="container">
  <?php
    require_once "../../controllers/salesController.php";
    $controller = new SalesController();
    $customers = $controller->buscarClientes();
    $products = $controller->buscarProdutos();
  ?>
  <h2><i class="fas fa-plus-circle"></i> Registrar Venda</h2>

<form action="../../controllers/salesController.php?action=create" method="POST">
    <!-- Cliente -->
    <div class="form-group">
    <label for="customer_id">Cliente</label>
    <select name="customer_id" id="customer_id" required>
        <option value="">Selecione um cliente</option>
        <?php foreach ($customers as $cliente): ?>
            <option value="<?= $cliente['id'] ?>">
                <?= htmlspecialchars($cliente['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

    <!-- Lista de Produtos -->
    <h3>Produtos</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
    <?php foreach ($products as $produto): ?>
        <tr>
            <td><?= htmlspecialchars($produto['name']); ?></td>
            <td>R$ <?= number_format($produto['price'], 2, ',', '.'); ?></td>
            <td><?= isset($produto['stock']) ? (int)$produto['stock'] : 0; ?></td>
            <td>
                <input 
                    type="number" 
                    name="quantidades[<?= $produto['id']; ?>]" 
                    min="0" 
                    max="<?= isset($produto['stock']) ? (int)$produto['stock'] : 0; ?>" 
                    value="0" 
                    class="qtd-input"
                    data-preco="<?= $produto['price']; ?>"
                >
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>


        </tbody>
    </table>

    <!-- Total -->
    <div class="form-group">
        <label>Total da Compra:</label>
        <h3 id="totalCompra">R$ 0,00</h3>
        <input type="hidden" name="total_amount" id="total_amount" value="0">
    </div>

    <!-- Botões -->
    <div class="form-actions">
        <a href="salesList.php" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success">Registrar</button>
    </div>
</form>

  </div>
</div>
</body>
</html>
