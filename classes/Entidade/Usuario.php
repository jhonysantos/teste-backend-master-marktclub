<?php

namespace Classes\Entidade;

use Classes\BancoDeDados\DataBase;
use \PDO;


function guidv4($data = null)
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}





class Usuario
{
    /**
     * Identificador primario do usuário
     * @var Integer
     */
    public $id;

    /**
     * Identificador Universal Unico do usário
     * @var String
     */
    public $uuid;

    /**
     * Nome do usuário
     * @var String
     */
    public $nome;

    /**
     * CPF do usuario
     * @var Integer
     */
    public $cpf;

    /**
     * E-mail do usuário
     * @var String
     */
    public $email;

    /**
     * Senha do usuário
     * @var String
     */
    public $senha;

    /**
     * Permissao do usuário
     * @var String
     */
    public $permissao;

    /**
     * Data de criação de usuário
     * @var String
     */
    public $data_criacao;

    /**
     * Data de atualização
     * @var String
     */
    public $data_atualizacao;

    /**
     * Status do usuario
     * @var Integer(1/2)
     */
    public $status;

    /* *
     * Método responsável por cadastrar um novo usuário no banco
     * @return boolean
     */
    public function cadastrar()
    {
        //Definindo a data
        $this->data_criacao = date('Y-m-d H:i:s');
        $this->data_atualizacao = date('Y-m-d H:i:s');

        //Definindo a UUID
        $this->uuid = guidv4();

        //Inserindo usuário no Banco
        $bancoDeDados = new DataBase('usuario');
        $this->id = $bancoDeDados->insert([
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'senha' => $this->senha,
            'permissao' => $this->permissao,
            'status' => $this->status,
            'data_criacao' => $this->data_criacao,
            'data_atualizacao' => $this->data_atualizacao,
            'uuid' => $this->uuid
        ]);
        // retornando sucesso
        return true;
    }

    /**
     * Metodo que atualiza informações dos usuários
     * @return boolean
     */
    public function atualizar()
    {
        $this->data_atualizacao = date('Y-m-d H:i:s');
        return (new DataBase('usuario'))->update(' id = ' . $this->id, [
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'senha' => $this->senha,
            'permissao' => $this->permissao,
            'status' => $this->status,
            'data_atualizacao' => $this->data_atualizacao,
        ]);
    }
    /**
     * Metodo que exclui usuário
     * @return boolean
     */
    public function excluir()
    {
        return (new DataBase('usuario'))->delete('id = ' . $this->id);
    }

    /**
     * Metodo que busca usuarios do Banco de Dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getUsuarios($where = null, $order = null, $limit = null)
    {
        return (new DataBase('usuario'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }
    /**
     * Metodo que busca quantidade de usuarios do Banco de Dados
     * @param string $where
     * @return integer
     */
    public static function getQuantidadeUsuarios($where = null)
    {
        return (new DataBase('usuario'))->select($where,null,null,'COUNT(*) as qtd ')
                                        ->fetchObject()
                                        ->qtd;
    }

    /**
     * Metodo que busca o id do usuario
     * @param integer $id
     * @return Usuario
     */
    public static function getUsuario($id)
    {
        return (new DataBase('usuario'))->select(' id = ' . $id)
            ->fetchObject(self::class);
    }

    /**
     * metodo que retorna uma instancia de usuario pelo cpf
     * @param integer $cpf
     * @return Usuario
     */
    public static function getUsuarioPorCpf($cpf){
        return (new DataBase('usuario'))->select(' cpf = "'.$cpf.'"')->fetchObject(self::class);
    }
}
