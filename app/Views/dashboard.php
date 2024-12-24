<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>

    <h2>Bem-vindo, <?php echo $nome; ?></h2>

    <p>Você é um(a) <?php echo ucfirst($role); ?>.</p>

    <a href="<?php echo base_url('/logout'); ?>">Sair</a>

</body>
</html>
