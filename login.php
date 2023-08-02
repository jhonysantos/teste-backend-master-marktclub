<?php
require __DIR__ . '/vendor/autoload.php';

use Classes\Entidade\Usuario;
use \Classes\Sessao\LoginUser;

//obriga o usuario esta deslogado
LoginUser::requireLogout();


if(isset($_POST['acao'])){

    switch($_POST['acao']){
        case 'logar':
            //busca usuario por cpf
            $usuario = Usuario::getUsuarioPorCpf($_POST['cpf']);
            
            //valida a instacia e a senha
            if(!$usuario instanceof Usuario || !password_verify($_POST['senha'],$usuario->senha)){
                break;
            }
           LoginUser::login($usuario);
            break;
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div id="site">
        <figure>
            <img src="images/logo.png" alt="Logo Markt Club">
        </figure>
        <form action="login.php" method="post">
            <legend>FAÇA SEU LOGIN</legend>
            <p>Digite seu CPF no campo abaixo e clique em logar para fazer seu login.</p>

            <div class="input">
                <input type="text" id="input_login" placeholder="CPF" inputmode="numeric" name="cpf">
                <label for="input_login">CPF</label>
            </div>
            <div class="input">
                <input type="password" id="input_senha" placeholder="Senha" inputmode="numeric" name="senha">
                <label for="input_senha">Senha</label>
            </div>

            <button type="submit" name="acao" value="logar">LOGAR</button>
        </form>
    </div>
</body>

</html>
