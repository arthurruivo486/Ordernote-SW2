<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO customers (name, phone, address_street, address_number, address_notes) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['phone'],
        $_POST['address_street'],
        $_POST['address_number'],
        $_POST['address_notes']
    ]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Cliente</title>
</head>
<body>
    <h1>Adicionar Cliente</h1>
    <form method="post">
        Nome: <input type="text" name="name" required><br>
        Telefone: <input type="text" name="phone"><br>
        Rua: <input type="text" name="address_street"><br>
        Número: <input type="text" name="address_number"><br>
        Notas: <textarea name="address_notes"></textarea><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
