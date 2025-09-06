<?php
  $controller = $_GET['controller'] ?? 'login';
  $action = $GET['action'] ?? 'index';

 require_once __DIR__ . '/../controllers/' . ucfirst($controller) . 'Controller.php';

 $controllerClass = ucfirst($controller) . "Controller";
 $controllerInstace = new $controllerClass();

 if (method_exists($controllerInstace, $action)) {
    $controllerInstace->$action();
 } else {
    echo "Ação não encontrada.";
 }
 
?>