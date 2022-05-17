<?php

namespace App\Database;

class Connection
{
    private CONST HOST = "mysql";

    private CONST DBNAME = "ClubsFootball";

    private CONST USER = "root";

    private CONST PASSW = "12345";

    /**
     * Guarda a instancia da conexao
     *
     */
    private static $instance;

    /**
     * Cria um conexao com banco de dados
     */
    public static function getInstance()
    {
        try{
            self::$instance = new \PDO("mysql:dbname=".self::DBNAME."; host=".self::HOST,self::USER,self::PASSW);
        }catch(\PDOException $e)
        {
            die("Não foi possivel conectar-se ". $e->getMessage());
        }
       
        return self::$instance;
    }
}