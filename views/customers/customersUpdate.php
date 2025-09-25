<?php
require '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("Cliente não encontrado!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("UPDATE customers SET name = ?, phone = ?, address_street = ?, address_number = ?, address_notes = ? WHERE id = ?");
    $stmt->execute([
        $_POST['name'],
        $_POST['phone'],
        $_POST['address_street'],
        $_POST['address_number'],
        $_POST['address_notes'],
        $id
    ]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Cliente</title>
</head>
<body>
    <h1>Editar Cliente</h1>
    <form method="post">
        Nome: <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required><br>
        Telefone: <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>"><br>
        Rua: <input type="text" name="address_street" value="<?= htmlspecialchars($customer['address_street']) ?>"><br>
        Número: <input type="text" name="address_number" value="<?= htmlspecialchars($customer['address_number']) ?>"><br>
        Notas: <textarea name="address_notes"><?= htmlspecialchars($customer['address_notes']) ?></textarea><br>
        <button type="submit">Salvar</button>
    </form>
    <a href="index.php">Voltar</a>
</body>
</html>
