<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Produto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background-color: #f0f1f3; }
    .card-edit { background: #fff; padding: 2rem; border-radius: 1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 700px; margin: 5rem auto; }
  </style>
</head>
<body>
<div class="container">
  <?php
    require "../../controllers/productController.php";
    $controller = new ProductController();
    $product = $controller->buscarUm($_GET['id']);
    $grupos = $controller->buscarGrupos();
  ?>
  <div class="card-edit">
    <h3 class="fw-bold text-warning mb-4">
      <i class="bi bi-pencil-square me-2"></i> Editar Produto
    </h3>
    <form action="../../controllers/productController.php" method="POST">
      <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
      <div class="mb-3">
        <label for="group_id" class="form-label">Grupo</label>
        <select class="form-control" id="group_id" name="group_id" required>
          <option value="">Selecione um grupo</option>
          <?php foreach ($grupos as $grupo): ?>
            <option value="<?php echo $grupo['id']; ?>" <?php echo ($grupo['id'] == $product['group_id']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($grupo['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required value="<?php echo htmlspecialchars($product['name']); ?>">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Descrição</label>
        <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($product['description']); ?></textarea>
      </div>
      <div class="mb-3">
        <label for="image_url" class="form-label">URL da Imagem</label>
        <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>">
      </div>
      <div class="mb-3">
        <label for="price" class="form-label">Preço</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" required value="<?php echo $product['price']; ?>">
      </div>
      <div class="mb-3">
        <label for="stock" class="form-label">Estoque</label>
        <input type="number" class="form-control" id="stock" name="stock" required value="<?php echo $product['stock']; ?>">
      </div>
      <div class="mb-3">
        <label for="is_active" class="form-label">Ativo</label>
        <select class="form-control" id="is_active" name="is_active">
          <option value="1" <?php echo $product['is_active'] ? 'selected' : ''; ?>>Sim</option>
          <option value="0" <?php echo !$product['is_active'] ? 'selected' : ''; ?>>Não</option>
        </select>
      </div>
      <input type="hidden" name="acao" value="editar">
      <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
        </a>
        <button class="btn btn-warning text-dark" type="submit">
          <i class="bi bi-check-circle me-1"></i> Atualizar
        </button>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>