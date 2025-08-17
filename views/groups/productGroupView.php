<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Grupos de Produtos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Lista de Grupos de Produtos</h1>
        <a class="btn btn-primary" href="productGroupAdd.php" role="button">Cadastrar</a>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Ícone</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($groups as $group): ?>
            <tr>
                <td><?php echo $group['id']; ?></td>
                <td><?php echo $group['name']; ?></td>
                <td><?php echo $group['icon']; ?></td>
                <td>
                    <a class="btn btn-warning" href="productGroupUpdate.php?id=<?php echo $group['id']?>" role="button">Editar</a>
                </td>
                <td>
                    <a class="btn btn-danger" href="productGroupDelete.php?id=<?php echo $group['id']?>" role="button">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>