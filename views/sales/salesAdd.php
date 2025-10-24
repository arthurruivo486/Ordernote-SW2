<?php
require_once __DIR__ . '/../../controllers/salesController.php';
$controller = new SalesController();

// Buscar clientes e produtos para os selects
$clientes = $controller->buscarClientes();
$produtos = $controller->buscarProdutos();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Nova Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f1f3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-view {
            background: #fff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 800px;
        }
        .header-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #34495e;
            margin-bottom: 0.5rem;
        }
        .product-item {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .total-section {
            background: #e8f5e8;
            border: 2px solid #28a745;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }
        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            font-weight: 500;
        }
        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card-view">
            <h3 class="header-title">
                <i class="bi bi-cart-plus me-2"></i>Registrar Venda
            </h3>

            <form action="../../controllers/salesController.php" method="POST" id="salesForm">
                <input type="hidden" name="acao" value="incluir">
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Pedido</label>
                        <select class="form-select" name="order_id" required>
                            <option value="">Selecione</option>
                            <option value="1">#1</option>
                            <option value="2">#2</option>
                            <option value="3">#3</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Método de Pagamento</label>
                        <select class="form-select" name="payment_method" required>
                            <option value="">Selecione</option>
                            <option value="cash">Dinheiro</option>
                            <option value="credit">Cartão de Crédito</option>
                            <option value="debit">Cartão de Débito</option>
                            <option value="pix">PIX</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Cliente</label>
                        <select class="form-select" name="customer_id" id="customerSelect" required>
                            <option value="">Selecione</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= htmlspecialchars($cliente['id']) ?>">
                                    <?= htmlspecialchars($cliente['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="pending">Pendente</option>
                            <option value="completed">Concluído</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>
                </div>

                <!-- Seção de Produtos -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="form-label mb-0">Itens da Venda</h5>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addProduct">
                            <i class="bi bi-plus-lg me-1"></i>Adicionar Produto
                        </button>
                    </div>

                    <div id="productsContainer">
                        <!-- Produtos serão adicionados aqui dinamicamente -->
                        <div class="product-item" data-index="0">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">Produto</label>
                                    <select class="form-select product-select" name="products[0][product_id]" required onchange="updatePrice(this)">
                                        <option value="">Selecione</option>
                                        <?php foreach ($produtos as $produto): ?>
                                            <option value="<?= htmlspecialchars($produto['id']) ?>" 
                                                    data-price="<?= htmlspecialchars($produto['price']) ?>">
                                                <?= htmlspecialchars($produto['name']) ?> - R$ <?= number_format($produto['price'], 2, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Quantidade</label>
                                    <input type="number" class="form-control quantity-input" name="products[0][quantity]" 
                                           min="1" value="1" required onchange="updateSubtotal(this)">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Preço Unit.</label>
                                    <input type="text" class="form-control price-input" name="products[0][unit_price]" 
                                           value="0.00" readonly>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-product" onclick="removeProduct(this)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <small class="text-muted">Subtotal: R$ <span class="subtotal">0.00</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção do Total -->
                <div class="total-section">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="form-label mb-0">Valor Total</h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <h4 class="text-success mb-0">R$ <span id="totalAmount">0.00</span></h4>
                            <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="salesView.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>Registrar Venda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let productIndex = 1;

        // Adicionar novo produto
        document.getElementById('addProduct').addEventListener('click', function() {
            const container = document.getElementById('productsContainer');
            const newProduct = document.createElement('div');
            newProduct.className = 'product-item';
            newProduct.setAttribute('data-index', productIndex);
            
            newProduct.innerHTML = `
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small">Produto</label>
                        <select class="form-select product-select" name="products[${productIndex}][product_id]" required onchange="updatePrice(this)">
                            <option value="">Selecione</option>
                            <?php foreach ($produtos as $produto): ?>
                                <option value="<?= htmlspecialchars($produto['id']) ?>" 
                                        data-price="<?= htmlspecialchars($produto['price']) ?>">
                                    <?= htmlspecialchars($produto['name']) ?> - R$ <?= number_format($produto['price'], 2, ',', '.') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Quantidade</label>
                        <input type="number" class="form-control quantity-input" name="products[${productIndex}][quantity]" 
                               min="1" value="1" required onchange="updateSubtotal(this)">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Preço Unit.</label>
                        <input type="text" class="form-control price-input" name="products[${productIndex}][unit_price]" 
                               value="0.00" readonly>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-product" onclick="removeProduct(this)">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <small class="text-muted">Subtotal: R$ <span class="subtotal">0.00</span></small>
                    </div>
                </div>
            `;
            
            container.appendChild(newProduct);
            productIndex++;
        });

        // Atualizar preço quando produto é selecionado
        function updatePrice(select) {
            const productItem = select.closest('.product-item');
            const priceInput = productItem.querySelector('.price-input');
            const quantityInput = productItem.querySelector('.quantity-input');
            const subtotalSpan = productItem.querySelector('.subtotal');
            
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price') || 0;
            
            priceInput.value = parseFloat(price).toFixed(2);
            updateSubtotal(quantityInput);
        }

        // Atualizar subtotal
        function updateSubtotal(input) {
            const productItem = input.closest('.product-item');
            const priceInput = productItem.querySelector('.price-input');
            const subtotalSpan = productItem.querySelector('.subtotal');
            
            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(input.value) || 0;
            const subtotal = price * quantity;
            
            subtotalSpan.textContent = subtotal.toFixed(2);
            calculateTotal();
        }

        // Remover produto
        function removeProduct(button) {
            const productItem = button.closest('.product-item');
            if (document.querySelectorAll('.product-item').length > 1) {
                productItem.remove();
                calculateTotal();
            } else {
                alert('É necessário pelo menos um produto na venda.');
            }
        }

        // Calcular total geral
        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.product-item').forEach(item => {
                const subtotalText = item.querySelector('.subtotal').textContent;
                total += parseFloat(subtotalText) || 0;
            });
            
            document.getElementById('totalAmount').textContent = total.toFixed(2);
            document.getElementById('totalAmountInput').value = total.toFixed(2);
        }

        // Inicializar cálculos
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
        });
    </script>
</body>
</html>