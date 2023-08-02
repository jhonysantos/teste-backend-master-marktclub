<?php
require __DIR__ . '/vendor/autoload.php';

define('TITLE','Editar usuário');

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
if (isset($_POST['nome'], $_POST['cpf'], $_POST['email'], $_POST['senha'], $_POST['status'], $_POST['permissao'])) {

    $usuario->nome = $_POST['nome'];
    $usuario->cpf = $_POST['cpf'];
    $usuario->email = $_POST['email'];
    $usuario->senha = $_POST['senha'];
    $usuario->status = $_POST['status'];
    $usuario->permissao = implode(",",$_POST['permissao']);
    $usuario->atualizar();

    header('location: index.php?status=success');
    exit; 
}

// validação do campo status
function selected($valor, $selected)
{
    return $valor == $selected ? 'selected="selected"' : '';
}

// validacao de campo de permissão
$permissoes = explode(",", $usuario->permissao);

include __DIR__ . '/formEditar.php';
