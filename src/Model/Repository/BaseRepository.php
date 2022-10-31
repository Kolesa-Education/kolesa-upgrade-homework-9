<?php

namespace App\Model\Repository;

use App\Model\Entity\AbstractModel;
use config\Database;
use Exception;
use PDO;

abstract class BaseRepository
{
    private Database $db;
    protected ?PDO $connection;
    protected AbstractModel $model;
    protected string $table;
    protected array $columns;
    protected array $values;

    public function __construct()
    {
        $this->db = new Database();
        $this->connection = $this->db->getConnection();
    }

    public function getAll()
    {
        $result = [];

        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL;";
        $stmt = $this->connection->query($sql);

        $records = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($records as $record) {
            $result[] = new $this->model(json_decode(json_encode($record),true));
        }

        return $result;
    }

    public function getById(int $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE deleted_at IS NULL AND id = :id;";
        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue("id", $id);
        $stmt->execute();

        $record = $stmt->fetch(PDO::FETCH_OBJ);

        if (!$record) {
            throw new Exception('No data found');
        }

        return new $this->model(json_decode(json_encode($record),true));
    }
}