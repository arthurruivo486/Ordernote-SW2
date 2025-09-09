<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>
    <form action="index.php?controller=user&action=store" method="post">
        <Label>Nome: </Label>
        <input type="text" name="text" required>
        <br>
        <Label>E-mail: </Label>
        <input type="email" name="email" required>
        <br>
        <Label>Senha: </Label>
        <input type="password" name="senha" required>
        <br>
        <br>
        <button type="submit">entrar</button>
    </form>
</body>

</html>