<?php


require __DIR__ . '/vendor/autoload.php';

use \Classes\Entidade\Usuario;
use \Classes\BancoDeDados\Pagination;
use \Classes\Sessao\LoginUser;

//obriga o usuario esta logado
LoginUser::requireLogin();

//pegando dados da sessão

$permissaoUsuario = $_SESSION['usuario'];
if (array_values($permissaoUsuario)) {
    $permissao = $permissaoUsuario['permissao'];
}




//busca
$busca = filter_input(INPUT_GET, 'pesquisa', FILTER_UNSAFE_RAW);

//condições SQL
$condicoes = [
    strlen($busca) ? ' nome LIKE "%' . str_replace(' ', '%', $busca) . '%"' : null
];
//clausula where
$where = implode(' AND ', $condicoes);

//quantidade total de usuários
$qtdUsuarios = Usuario::getQuantidadeUsuarios($where);

//paginação
$pagination = new Pagination($qtdUsuarios, $_GET['pagina'] ?? 1, 5);


//obtem os usuários
$usuarios = Usuario::getUsuarios($where, null, $pagination->getLimit());

$resultados = '';
foreach ($usuarios as $usuario) {
    if (isset($permissao) && in_array("usuario_editar", explode(",",$permissao))) {
        $validarEditar = '<div class="editar"><a href="editar.php?id=' . $usuario->id . '"><img src="images/editar.svg"></a></div>';
    }else{
        $validarEditar = null;
    }
    if (isset($permissao) && in_array("usuario_deletar", explode(",",$permissao))) {
        $validarExcluir =  '<div class="deletar"><a href="excluir.php?id=' . $usuario->id . '"><img src="images/deletar.svg"></a></div>';
    }else{
        $validarExcluir = null;
    }
    $resultados .= '<li class="dado">
    <div class="texto nome">' . $usuario->nome . '</div>
    <div class="texto cpf">' . $usuario->cpf . '</div>
    <div class="texto email">' . $usuario->email . '</div>
    <div class="texto data">' . date('d/m/Y', strtotime($usuario->data_atualizacao)) . '</div>
    <div class="texto status">' . ($usuario->status == '1' ? 'Ativo' : 'Inativo') . '</div>'.
    $validarEditar.
     $validarExcluir.
 '</li>';
}

$resultados = strlen($resultados) ? $resultados : '<center><li class="dado"><div class="texto nome">Nenhum usuário encontrado.</div><li></center>';

//gets
unset($_GET['status']);
unset($_GET['pagina']);
$gets = http_build_query($_GET);
//paginação
$paginacao = '';
$paginas = $pagination->getPages();
foreach ($paginas as $key => $pagina) {
    $style = 'style="background-color:#CE6B2F;"';
    $class = $pagina['atual'] ? $style : '';
    $paginacao .= '<a href="?pagina=' . $pagina['pagina'] . '&' . $gets . '"' . $class . '>
                    <button type="button">' . $pagina['pagina'] . '</button>
                    </a>';
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div id="site">
        <header>
            <h1>USUÁRIOS</h1>
            <form class="busca" method="GET" action="">
                <i><img src="images/lupa.svg"></i>
                <input type="text" name="pesquisa" value="<?= $busca ?>" placeholder="Pesquisar...">
            </form>
            <figure></figure>
            <a class="sair" href="logout.php">sair</a>
        </header>

        <ul>
            <li class="titulo">
                <div class="texto nome">Nome</div>
                <div class="texto cpf">CPF</div>
                <div class="texto email">E-MAIL</div>
                <div class="texto data">DATA</div>
                <div class="texto status">STATUS</div>
                <div class="editar"></div>
                <div class="deletar"></div>
            </li>

            <?= $resultados ?>

        </ul>
        <div class="pagina">
            <?= $paginacao ?>
        </div>
        <?php
        if (isset($permissao) && in_array("usuario_add", explode(",",$permissao))) {
            echo '<a href="cadastrar.php" class="botao_add">Adicionar novo</a>';
        }else{
            echo '';
        }
        ?>
       
    </div>
</body>

</html>