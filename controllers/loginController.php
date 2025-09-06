<?php
class LoginController {
    public function index() {
        require __DIR__ . '/../views/auth/login.php';
    }
    public function autenticar() {
        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $result = $userModel->login($email, $senha);

        if($result) {
            session_start();
            $_SESSION['usuario'] = [
                'id' => $result['id'],
                'name' => $result['name'],
                'email' => $result['email'],
                'role' => $result['role'],
            ];

            header("Location: index.php?controller=home&action=index");
            exit;
        }else {
            echo "E-mail ou senha inválidos";
        }
    }
}
