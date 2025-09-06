$controller = $_GET['controller'] ?? 'login';
$action = $_GET['action'] ?? 'index';

require_once __DIR__ . '/app/controllers/LoginController.php';

$controllerClass = ucfirst($controller) . "Controller";
$controllerInstance = new $controllerClass();

if(method_exists($controllerInstance, $action)) {
    $controllerInstance->$action();
} else {
    echo "Ação não encontrada.";
}