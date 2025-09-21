<?php
require "../../controllers/salesController.php";
$controller = new SalesController();
$venda = $controller->buscarPorId($_GET['id']);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Excluir Venda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4 shadow">
            <h3 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle"></i> Excluir Venda</h3>
            <p>Tem certeza que deseja excluir a venda <strong>#<?= $venda['id']; ?></strong> do cliente <strong><?= htmlspecialchars($venda['customer_name']); ?></strong>?</p>
            <form action="../../controllers/salesController.php" method="POST">
                <input type="hidden" name="id" value="<?= $venda['id']; ?>">
                <input type="hidden" name="acao" value="excluir">
                <div class="d-flex justify-content-between mt-4">
                    <a href="salesView.php" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Cancelar</a>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i> Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>