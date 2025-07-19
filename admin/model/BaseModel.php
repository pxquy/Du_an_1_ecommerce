<?php
class BaseModel
{
    protected $table;
    protected $pdo;

    public function __construct()
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8',
            DB_HOST,
            DB_PORT,
            DB_NAME,
        );
        try {
            $this->pdo = new PDO(
                $dsn,
                DB_USERNAME,
                DB_PASSWORD,
                DB_OPTIONS,
            );
        } catch (PDOException $e) {
            die("ket noi co so du lieu that bai: {$e->getMessage()}. Vui long thu lai sau");
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }


    public function select($column = '*', $condition = null, $params = [])
    {
        $sql = "SELECT $column FROM {$this->table}";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function count($condition = null, $params = [])
    {
        $sql = "SELECT COUNT(*) FROM {$this->table}";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function paginate($page = 0, $perPage = 5, $column = '*', $condition = null, $params = [])
    {
        $sql = "SELECT $column FROM {$this->table}";
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        $offset = ($page - 1) * $perPage;
        $sql .= " LIMIT $perPage OFFSET $offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find($column = '*', $condition = null, $params = [])
    {
        $sql = "SELECT $column FROM {$this->table}";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    public function insert($data)
    {
        $keys = array_keys($data);
        $column = implode(',', $keys);
        $placeholders = ':' . implode(', :', $keys);
        $sql = "INSERT INTO {$this->table} ($column) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $data['id'];
    }

    public function update($data, $condition = null, $params = [])
    {
        $sets = implode(',', array_map(fn($key) => "$key =:set_$key", array_keys($data)));
        $sql = "UPDATE {$this->table} SET $sets";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => &$value) {
            $stmt->bindParam(":set_$key", $value);
        }

        foreach ($params as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($condition = null, $params = [])
    {
        $sql = "DELETE FROM {$this->table}";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function softDelete($id)
    {
        $data = [
            'isActive' => 0,
            'deletedAt' => date('Y-m-d H:i:s')
        ];

        return $this->update($data, 'id = :id', ['id' => $id]);
    }
    public function restore($id)
    {
        $data = [
            'isActive' => 1,
            'updatedAt' => date('Y-m-d H:i:s'),
            'deletedAt' => null,
        ];

        return $this->update($data, 'id = :id', ['id' => $id]);
    }

    public function selectRaw(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}