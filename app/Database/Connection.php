<?php

namespace App\Database;

class Connection{

    private const DBNAME = "ClubsFootball";

    private const DBHOST = "mysql";

    private const DBUSER = "root";

    private const DBPASSW = "12345";

    /**
     * Guarda a instancia do PDO
     *
     * @var [object] $object
     */
    public $instance;


    /**
     * Guarda o rersultado da query
     *
     * @var [array] $result
     */
    public $result;


    /**
     * Inicia a conexao com banco de dados, assim que o objeto é instanciado 
     */
    public function __construct()
    {
        $this->connection();
    }

    public function connection()
    {
        try{
            $pdo = new \PDO("mysql:dbname=". self::DBNAME . "; host=" . self::DBHOST, self::DBUSER, self::DBPASSW);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->instance = $pdo;


        }catch(\PDOException $e){
           echo $e->getMessage();
        }
    }

    /**
     * Executa a query e recupera os dados para exibir todos os registros do banco
     *
     * @return void
     */
    public function index()
    {
    
        $query = $this->instance->query("SELECT * FROM clubs;");
        $query->execute();
        $this->result = $query->fetchAll(\PDO::FETCH_ASSOC);
     
    }

    /**
     * Executa a query e recupera os dados para exibir um registro especifico
     *
     * @param [integer] $id
     * @return void
     */
    public function show($id)
    {
     
        $query = $this->instance->prepare("SELECT * FROM clubs where id = $id;");
        $query->execute();
        $this->result = $query->fetch(\PDO::FETCH_ASSOC);

    }

    /**
     * Executa a query que insere um registro no banco de dados
     *
     * @param [array] $data
     * @return void
     */
    public function insert($data)
    {
        $query = $this->instance->prepare("INSERT INTO clubs(name,color,state) VALUES(:name,:color,:state)");
        $query->bindValue(":name",  $data['name']);
        $query->bindValue(":color", $data['color']);
        $query->bindValue(":state", $data['state']);
        $query->execute();

        $lastInsert = $this->instance->query("SELECT * FROM clubs where id = LAST_INSERT_ID();");
        $this->result = $lastInsert->fetch(\PDO::FETCH_ASSOC);

    }

    /**
     * Executa  a query que atualiza um registro no banco de dados
     *
     * @param [integer] $id
     * @return void
     */
    public function update($data,$id)
    {
     
        $fields = array_keys($data);
        $params = array_values($data);

        $query = 'UPDATE clubs SET '.implode('=?,',$fields).'=? WHERE id = '.$id;
        $statement = $this->instance->prepare($query);
        $statement->execute($params);
        
        
        $rowUpdate = $this->instance->query("SELECT * FROM clubs where id = $id");
        $this->result = $rowUpdate->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Deleta um registro do banco de dados
     *
     * @param [integer] $id
     * @return void
     */
    public function delete($id)
    {
        $query = $this->instance->prepare("DELETE FROM clubs where id = $id");
        $query->execute();
        if($query->rowCount() === 1){
            return true;
        }else{
            return false;
        }
    }
}