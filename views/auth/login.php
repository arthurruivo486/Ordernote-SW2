<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="/index.php?controller=login&action=autenticar" method="POST">
        <Label>E-mail:</Label>
        <input type="email" name="email" required>
        <br>
        <Label>Senha:</Label>
        <input type="password" name="senha" required>
        <br>
        <br>
        <button type="submit">entrar</button>
    </form>
    <p>Não tem conta ?<a href="index.php?controller=register&action=index">Cadastre-se</a></p>
</body>
</html>