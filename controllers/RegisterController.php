<?php
class RegisterController{
    public function index(){
        require __DIR__ . '/../views/auth/register.php';
    }

    public function store(){
        require_once __DIR__ . '/../models/User.php';
        $userModel = new User();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($userModel->register($name, $email, $password)) {
        header("Location: index.php?controller=login&action=index");
        exit;
        } else {
          echo "Erro ao registrar usuário.";
        }

    }
}

?>