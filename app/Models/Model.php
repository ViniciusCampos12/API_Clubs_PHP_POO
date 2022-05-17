<?php

namespace App\Models;

use App\Database\Connection;

class Model
{
    /**
     * Guarda o nome da tabela.
     *
     * @var string
     */
    protected $table;
    /**
     * Guarda a conexão com banco de dados.
     *
     * @var PDO
     */
    private $connection;

    /**
     * Guarda a conexão com banco de dados no atributo.
     */
    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * Exibe todos os clubes existentes
     *
     * @return array
     */
    public function all(): array
    {
        $query = $this->connection->prepare("SELECT * FROM $this->table");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Exibe o registro de um clube especifico.
     *
     * @param integer $id
     * @return array
     */
    public function findAndView(int $id): array
    {
        $query = $this->connection->prepare("SELECT * FROM $this->table where id = $id");
        $query->execute();
        $row = $query->rowCount();

        if ($row == 1) {
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        return [];
    }

    /**
     * Inseri no banco o registro de um novo clube.
     *
     * @param array $data
     * @return array
     */
    public function insert($data = []): array
    {
        $query = $this->connection->prepare("INSERT INTO $this->table(name,color,state) VALUES(:name,:color,:state)");
        $query->bindValue(":name",  $data['name']);
        $query->bindValue(":color", $data['color']);
        $query->bindValue(":state", $data['state']);
        $query->execute();

        $lastInsert = $this->connection->query("SELECT * FROM $this->table where id = LAST_INSERT_ID();");
        return $lastInsert->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza o registro de um clube no banco de dados.
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function update(int $id, $data = []): array
    {
        $fields = array_keys($data);
        $params = array_values($data);

        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE id = ' . $id;
        $statement = $this->connection->prepare($query);
        $statement->execute($params);


        $rowUpdate = $this->connection->query("SELECT * FROM $this->table where id = $id");
        return $rowUpdate->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Exlui do banco o registro de um clube.
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool
    {
        $query = $this->connection->prepare("DELETE FROM $this->table where id = $id");
        $query->execute();
        $row = $query->rowCount();

        if ($row == 1) {
            return true;
        }

        return false;
    }
}
