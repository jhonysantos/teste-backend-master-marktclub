<?php
require __DIR__.'/vendor/autoload.php';

use \Classes\Entidade\Usuario;
use \Classes\Sessao\LoginUser;

//obriga o usuario esta logado
LoginUser::requireLogin();

//instancia de usuario
$usuario = new Usuario();

//validação do POST
if (isset($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha'], $_POST['status'], $_POST['permissao'])) {

    $usuario->nome = $_POST['nome'];
    $usuario->cpf = $_POST['cpf'];
    $usuario->email = $_POST['email'];
    $usuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $usuario->status = $_POST['status'];
    $usuario->permissao = implode(",",$_POST['permissao']);
    $usuario->cadastrar();

    header('location: index.php?status=success');
    exit;
}

include __DIR__ . '/form.php';