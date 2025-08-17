<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Grupo de Produtos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Grupo de Produtos</h1>
        <form action="../../controllers/productGroupController.php" method="POST">

            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="icon">Ícone:</label>
                <input type="text" class="form-control" id="icon" name="icon">
            </div>
            <input type="hidden" name="acao" value="incluir">
            <button class="btn btn-primary" type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>