<?php 
require "../../controllers/salesController.php";
$controller = new SalesController();
$venda = $controller->buscarPorId($_GET['id']);
$products = $controller->buscarProdutos();
$customers = $controller->buscarClientes();
?>