<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cadastrar Grupo de Produtos</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f1f3;
    }
    .card-add {
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
  <div class="card-add">
    <h3 class="fw-bold text-success mb-4">
      <i class="bi bi-plus-circle me-2"></i> 
      Cadastrar Grupo de Produtos
    </h3>

    <form action="../../controllers/productGroupController.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>

      <div class="mb-3">
        <label for="icon" class="form-label">Ícone</label>
        <input type="text" class="form-control" id="icon" name="icon">
      </div>

      <input type="hidden" name="acao" value="incluir">

      <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">
          <i class="bi bi-arrow-left-circle me-1"></i> Cancelar
        </a>
        <button class="btn btn-success text-white" type="submit">
          <i class="bi bi-check-circle me-1"></i> Cadastrar
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
