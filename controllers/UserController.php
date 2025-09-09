<?php 

require_once __DIR__ . '/../models/User.php';

class UserController {
    public function create() {
        require __DIR__ . '/../views/auth/register.php';
    }
    public function store() {
        $userModel = new User();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $result = $userModel->createUser($name, $email, $senha);

        if ($result) {
            echo "Usuário cadastrado com sucesso ! <a href='index.php?controller=login&action=index'>Fazer login</a>";
        } else {
            echo "Erro ao cadastrar (talvez já exista).";
        }
        
    }
}

?>