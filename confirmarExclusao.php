<?php
require __DIR__.'/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Exclusão</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <div id="site">
        <header>
            <h1 class="total">Excluir Usuário</h1>
            <figure></figure>
            <a class="sair" href="login.php">sair</a>
        </header>
        
        <form method="POST" class="cadastro">
        <h2>Você deseja realmente excluir o usuário <?=$usuario->nome?>?</h2>

        <a href="index.php">Cancelar</a> <button type="submit" name="excluir">Excluir</button>
        </form>
    </div>
</body>

</html>
