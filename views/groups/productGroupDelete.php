<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Excluir Grupo de Produtos</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f1f3;
    }
    .card-delete {
      background: #fff;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 5rem auto;
    }
  </style>
</head>
<body>

<div class="container">
  <?php 
    require "../../controllers/productGroupController.php";
    $controller = new ProductGroupController();
    $group = $controller->buscarUm($_GET['id']);
  ?>

  <div class="card-delete">
    <h3 class="fw-bold text-danger mb-4">
      <i class="bi bi-exclamation-triangle-fill me-2"></i> 
      Confirmar Exclusão
    </h3>
    <p class="mb-4">Tem certeza que deseja excluir o grupo abaixo? Essa ação não poderá ser desfeita.</p>

    <form action="../../controllers/productGroupController.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" class="form-control" disabled value="<?php echo $group['name']; ?>">
      </div>
      <div class="mb-3">
        <label class="form-label">Ícone</label>
        <input type="text" class="form-control" disabled value="<?php echo $group['icon']; ?>">
      </div>

      <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
      <input type="hidden" name="acao" value="excluir">

      <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
        </a>
        <button class="btn btn-danger" type="submit">
          <i class="bi bi-trash me-1"></i> Confirmar Exclusão
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
