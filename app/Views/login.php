<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div style="color: red;">
            <?php echo session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="celular">Número do Celular:</label>
        <input type="text" name="telefone" id="telefone" required>
        <br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <br><br>

        <button type="submit">Entrar</button>
    </form>

</body>
</html>
