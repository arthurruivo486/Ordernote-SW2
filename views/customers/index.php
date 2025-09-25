<?php
require_once '../../config/config.php';

$stmt = $pdo->query("SELECT * FROM customers ORDER BY id DESC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head><title>Lista de Clientes</title></head>
<body>
    <h1>Lista de Clientes</h1>
    <a href="customersAdd.php">+ Adicionar Cliente</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Nome</th><th>Telefone</th><th>Endereço</th><th>Ações</th>
        </tr>
        <?php foreach ($customers as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['name']) ?></td>
            <td><?= htmlspecialchars($c['phone']) ?></td>
            <td><?= htmlspecialchars($c['address_street']) . ', ' . htmlspecialchars($c['address_number']) ?></td>
            <td>
                <a href="customersView.php?id=<?= $c['id'] ?>">Ver</a> |
                <a href="customersUpdate.php?id=<?= $c['id'] ?>">Editar</a> |
                <a href="customersDelete.php?id=<?= $c['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>


