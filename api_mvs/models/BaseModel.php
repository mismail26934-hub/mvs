<?php

require_once __DIR__ . '/../config/database.php';

abstract class BaseModel
{
    /** @var PDO */
    protected $db;

    /** @var string */
    protected $table;

    /** @var string */
    protected $primaryKey;

    /** @var array */
    protected $fillable;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll()
    {
        $stmt = $this->db->query(
            "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey} DESC"
        );

        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        return $row ? $row : null;
    }

    public function create(array $data)
    {
        $filtered = $this->filterFillable($data);
        $columns = implode(', ', array_keys($filtered));
        $placeholders = implode(', ', array_fill(0, count($filtered), '?'));

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($filtered));

        return (int) $this->db->lastInsertId();
    }

    public function update($id, array $data)
    {
        $filtered = $this->filterFillable($data);
        $sets = [];
        foreach (array_keys($filtered) as $col) {
            $sets[] = "{$col} = ?";
        }
        $setsStr = implode(', ', $sets);

        $sql = "UPDATE {$this->table} SET {$setsStr} WHERE {$this->primaryKey} = ?";
        $values = array_values($filtered);
        $values[] = $id;

        $stmt = $this->db->prepare($sql);

        return $stmt->execute($values);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?"
        );

        return $stmt->execute([$id]);
    }

    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    protected function filterFillable(array $data)
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }
}
