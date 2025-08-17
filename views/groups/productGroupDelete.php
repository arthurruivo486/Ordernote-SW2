<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Grupo de Produtos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Exclusão do Grupo de Produtos</h1>
        <?php 
        require "../../controllers/productGroupController.php";
        $controller = new ProductGroupController();
        $group = $controller->buscarUm($_GET['id']);
        ?>
        <form action="../../controllers/productGroupController.php" method="POST">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" disabled value="<?php echo $group['name'];?>">
            </div>
            <div class="form-group">
                <label for="icon">Ícone:</label>
                <input type="text" class="form-control" id="icon" name="icon" disabled value="<?php echo $group['icon'];?>">
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <input type="hidden" name="acao" value="excluir">
            <button class="btn btn-primary" type="submit">Confirmar Exclusão</button>
        </form>
    </div>
</body>
</html>