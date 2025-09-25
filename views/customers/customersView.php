<?php
require '../db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$id]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("Cliente não encontrado!");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detalhes do Cliente</title>
</head>
<body>
    <h1>Detalhes do Cliente</h1>
    <p><strong>ID:</strong> <?= $customer['id'] ?></p>
    <p><strong>Nome:</strong> <?= htmlspecialchars($customer['name']) ?></p>
    <p><strong>Telefone:</strong> <?= htmlspecialchars($customer['phone']) ?></p>
    <p><strong>Rua:</strong> <?= htmlspecialchars($customer['address_street']) ?></p>
    <p><strong>Número:</strong> <?= htmlspecialchars($customer['address_number']) ?></p>
    <p><strong>Notas:</strong> <?= nl2br(htmlspecialchars($customer['address_notes'])) ?></p>
    <p><strong>Criado em:</strong> <?= $customer['created_at'] ?></p>
    <a href="index.php">Voltar</a>
</body>
</html>
