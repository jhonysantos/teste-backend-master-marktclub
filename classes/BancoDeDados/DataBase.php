<?php

namespace Classes\BancoDeDados;

use Exception;
use \PDO;
use PDOException;

class DataBase
{
    /**
     * Host de conexao com o banco de dados
     * @var string
     */
    const HOST = 'localhost';

    /**
     * Nome do banco de dados
     * @var string
     */
    const NAME = 'teste_backend';

    /**
     * Usuario do Bando de Dados
     * @var string
     */
    const USER = 'root';

    /**
     * Senha de acesso do Banco de Dados
     * @var string
     */
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Intanciando a conexão ao banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Definindo a tabela, instancia e a conexao
     * @param string $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Metodo responsável de criar a conexão com o banco de dados
     */
    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
    /**
     * Metodo para colocar executar query dentro dos banco de dados
     * @param String
     * @param array
     * @return PDOStatiment
     */
    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Metodo que insere dados no banco
     * @param array $valores [fild => valor]
     * @return integer Id inserido
     */
    public function insert($values)
    {
        //buscando dados da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        // query insert
        $query = 'INSERT INTO ' . $this->table . '(' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

        //executando o insert
        $this->execute($query, array_values($values));

        //retorna o id inserido
        return $this->connection->lastInsertId();
    }

    /**
     * Metodo para consultar o dados no banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //buscando dados da query
        $where = strlen($where) ? 'WHERE' . $where : '';
        $order = strlen($order) ? 'ORDE BY' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        // montando a query
        $query = 'SELECT '.$fields.' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        // executando a query
        return $this->execute($query);
    }

    /**
     * Metodo para atualizar usuario no banco de dados
     * @param string $where
     * @param array $values [field => value]
     * @return boolean
     */
    public function update($where, $values)
    {
        //buscando dados da query
        $fields = array_keys($values);

        //montando a query
        $query = 'UPDATE ' . $this->table . ' SET  ' . implode('=?,', $fields) . '=? WHERE' . $where;


        //executando a query
        $this->execute($query, array_values($values));
        //retorna sucesso
        return true;
    }

    /**
     * Metodo responsavel de excluir usuário do banco de dados
     * @param string $where
     * @return boolean
     */
    public function delete($where)
    {
        //montando a query
        $query = 'DELETE FROM '.$this->table.' WHERE ' . $where;

        //executando a query
        $this->execute($query);
        //retorna sucesso
        return true;
    }
}
