<?php
namespace Classes\Sessao;

class LoginUser{

    /**
     * metodo responsavel por iniciar a sessao
     */
    private static function init(){
        //verifica o status da sessao
        if(session_status() !== PHP_SESSION_ACTIVE){

            //inicia a sessão
            session_start();
        }
    }

    /**
     * metodo para logar usuario
     * @return Usuario $usuario
     */
    public static function login($usuario){
        //inicia a sessao
        self::init();

        //sessao de usuario
        $_SESSION['usuario'] = [
            'id' => $usuario->id,
            'cpf' => $usuario->cpf,
            'permissao' => $usuario->permissao
        ];
        // redireciona usuario para index
        header('location: index.php');
        exit;
    }

    /**
     * metodo que desloga o usuario
     */
    public static function logout(){
        //inicia a sessao
        self::init();

        // remove a sessão do usuario
        unset($_SESSION['usuario']);
        
        // redireciona para o login
        header('Location: login.php');
        
    }

    /**
     * metodo responsável por verificar se o usuario está logado
     * @return boolean
     */
    public static function isLogged(){
        //inicia a sessao
        self::init();

        return isset($_SESSION['usuario']['id']);
    }

    /**
     * metodo que obriga usuario está logado
     */
    public static function requireLogin(){
        if(!self::isLogged()){
            header('Location: login.php');
            exit;
        }
    }

    /**
     * metodo que obriga usuario está deslogado
     */
    public static function requireLogout(){
        if(self::isLogged()){
            header('Location: index.php');
            exit;
        }
    }
}