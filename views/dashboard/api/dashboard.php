<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Configuração do banco de dados
$host = 'localhost';
$dbname = 'ordernote-db';
$username = 'root'; // ajuste conforme necessário
$password = ''; // ajuste conforme necessário

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Total do dia
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT SUM(total_amount) as total_dia, COUNT(*) as total_vendas
                           FROM sales
                           WHERE DATE(created_at) = ? AND status = 'completed'");
    $stmt->execute([$today]);
$todayData = $stmt->fetch(PDO::FETCH_ASSOC);

// Debug: verificar data e resultados
error_log("Data de hoje: " . $today);
error_log("Total do dia: " . ($todayData['total_dia'] ?: '0'));
error_log("Total vendas: " . ($todayData['total_vendas'] ?: '0'));

    // Últimos pedidos (últimas 4 vendas)
    $stmt = $pdo->prepare("SELECT s.total_amount, c.name as customer_name, s.created_at
                           FROM sales s
                           LEFT JOIN customers c ON s.customer_id = c.id
                           WHERE s.status = 'completed'
                           ORDER BY s.created_at DESC
                           LIMIT 4");
    $stmt->execute();
    $lastOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vendas da semana (últimos 7 dias)
    $stmt = $pdo->prepare("SELECT DAYNAME(created_at) as dia, COUNT(*) as vendas
                           FROM sales
                           WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                           AND status = 'completed'
                           GROUP BY DAYNAME(created_at)
                           ORDER BY created_at");
    $stmt->execute();
    $weekData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'total_dia' => $todayData['total_dia'] ?: 0,
        'total_vendas' => $todayData['total_vendas'] ?: 0,
        'ultimos_pedidos' => $lastOrders,
        'vendas_semana' => $weekData
    ]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>