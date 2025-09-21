<?php
session_start();
require_once '../../config/conexao.php'; // ajuste o caminho

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conexao::getInstance();

        $email = trim($_POST['email']);
        $senha = $_POST['senha']; // senha digitada

        // Busca o usuário
        $sql = "SELECT id, name, email, password_hash, role, status 
                FROM user 
                WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $erro[] = "Este email não pertence a nenhum usuário.";
        } else {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Comparação em texto puro (NÃO seguro)
            if ($user['password_hash'] === $senha) {
                // Login ok
                $_SESSION['usuario'] = $user['id'];
                $_SESSION['email']   = $user['email'];
                $_SESSION['nome']    = $user['name'];
                $_SESSION['role']    = $user['role'];

                echo "<script>alert('Login efetuado com sucesso'); location.href='../dashboard/HTML/index.html'; </script>";
                exit;
            } else {
                $erro[] = "Senha incorreta.";
            }
        }

    } catch (PDOException $e) {
        die("Erro no banco: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Ordernote - Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #f2f2f2;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: bold;
        }
        input[type="email"], input[type="password"] {
            width: 93.5%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }
        input[type="submit"] {
            width: 100%;
            background: #555;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }
        input[type="submit"]:hover {
            background: #333;
        }
        .extra-links {
            text-align: center;
            margin-top: 15px;
        }
        .extra-links a {
            color: #666;
            font-size: 14px;
            text-decoration: none;
        }
        .extra-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Ordernote</h1>
        <form method="POST" action="">
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Digite seu e-mail" required>

            <label for="senha">Senha</label>
            <input type="password" name="senha" placeholder="Digite sua senha" required>

            <input type="submit" value="Entrar">
        </form>
        <div class="extra-links">
            <a href="#">Esqueceu sua senha?</a>
        </div>
    </div>
</body>
</html>
