<?php

namespace App\Libraries;

use \PDO;
use \PDOException;
use \PDOStatement;

/**
 * Gerencia o Banco de dados
 */
class Database 
{
    
    /**
     * Conexão com o banco de dados
     * @var PDO
     */
    private PDO $db;
    
    /**
     * Instância do PDO para trabalhar com as querys
     * @var PDOStatement
     */
    private PDOStatement $stmt;
    
    public function __construct()
    {
        
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION
        ];
        
        try{
            $this->db = new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';charset='.getenv('DB_CHARSET').';dbname='.getenv('DB_BASE'),  getenv('DB_USER'), getenv('DB_PASS'), $options);
        } catch (PDOException $e) {
            phpError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            die();
        }
                
    }
        
    /**
     * Prepara o SQL
     * @param string $sql
     * @return void
     */
    public function query(string $sql): void
    {
        $this->stmt = $this->db->prepare($sql);
    }
    
    /**
     * Aplica os valores na query SQL
     * @param string $param
     * @param string $value
     * @param string $type
     * @return void
     */
    public function bind(string $param, string $value, string $type = null): void
    {
        if(is_null($type)){
            
            switch (true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;
            
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;
            
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;
            
                default:
                    $type = PDO::PARAM_STR;
                break;
            }
            
            $this->stmt->bindValue($param, $value, $type);
        }
    }
    
    /**
     * Executa a query SQL
     * @return PDOStatement
     */
    public function execute(): PDOStatement
    {
        return $this->stmt->execute();
    }
    
    /**
     * Retorna um resultado
     * @return PDOStatement
     */
    public function result(): PDOStatement
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Retorna vários resultados
     * @return PDOStatement
     */
    public function results(): PDOStatement
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    
    /**
     * Retorna a quantidade total de linhas afetadas
     * @return PDOStatement
     */
    public function totalLines(): PDOStatement
    {
        return $this->stmt->rowCount();
    }
    
    /**
     * Retorna o último ID inserido no banco de dados
     * @return PDOStatement
     */
    public function lastInsertId(): PDOStatement
    {
        return $this->stmt->lastInsertId();
    }
    
}
