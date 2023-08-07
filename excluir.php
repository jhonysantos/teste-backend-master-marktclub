<?php
require __DIR__ . '/vendor/autoload.php';



use \Classes\Entidade\Usuario;
use \Classes\Sessao\LoginUser;

//obriga o usuario esta logado
LoginUser::requireLogin();

// Validação do ID se tem e se é numerico
if (!isset($_GET['id']) or !is_numeric($_GET['id'])) {
    header('location: index.php?status=error');
    exit;
}

//consultando usuário
$usuario = Usuario::getUsuario($_GET['id']);

//Validando o usuário
if (!$usuario instanceof Usuario) {
    header('location: index.php?status=error');
    exit;
}
//validação do POST
if (isset($_POST['excluir'])) {

    $usuario->excluir();

    header('location: index.php?status=success');
    exit; 
}



include __DIR__ . '/confirmarExclusao.php';
