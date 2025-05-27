<?php
class ComplexOperations {
    private $data;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->data = [];
    }

    public function fetchData($table, $conditions = []) {
        $query = "SELECT * FROM $table WHERE 1";
        foreach ($conditions as $column => $value) {
            $query .= " AND $column = :$column";
        }
        $stmt = $this->db->prepare($query);
        foreach ($conditions as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }
        $stmt->execute();
        $this->data = $stmt->fetchAll();
        return $this;
    }

    public function processData() {
        foreach ($this->data as &$row) {
            $row['processed'] = true;
            $row['timestamp'] = time();
        }
        return $this;
    }

    public function saveData($table) {
        foreach ($this->data as $row) {
            $columns = implode(',', array_keys($row));
            $placeholders = implode(',', array_map(fn($key) => ":$key", array_keys($row)));
            $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->db->prepare($query);
            foreach ($row as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
        }
        return $this;
    }

    public function updateData($table, $conditions) {
        foreach ($this->data as $row) {
            $set = [];
            foreach ($row as $column => $value) {
                $set[] = "$column = :$column";
            }
            $setClause = implode(',', $set);
            $whereClause = '';
            foreach ($conditions as $column => $value) {
                $whereClause .= " AND $column = :$column";
            }
            $query = "UPDATE $table SET $setClause WHERE 1 $whereClause";
            $stmt = $this->db->prepare($query);
            foreach ($row as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
            foreach ($conditions as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
            $stmt->execute();
        }
        return $this;
    }

    public function deleteData($table, $conditions) {
        $query = "DELETE FROM $table WHERE 1";
        foreach ($conditions as $column => $value) {
            $query .= " AND $column = :$column";
        }
        $stmt = $this->db->prepare($query);
        foreach ($conditions as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }
        $stmt->execute();
        return $this;
    }

    public function customQuery($query, $params = []) {
        $stmt = $this->db->prepare($query);
        foreach ($params as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function generateReport($table) {
        $data = $this->fetchData($table)->processData()->data;
        $report = [];
        foreach ($data as $row) {
            $report[] = [
                'id' => $row['id'],
                'processed' => $row['processed'],
                'timestamp' => date('Y-m-d H:i:s', $row['timestamp'])
            ];
        }
        return $report;
    }

    public function aggregateData($table, $column, $operation = 'SUM') {
        $query = "SELECT $operation($column) FROM $table";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function filterData($column, $value) {
        return array_filter($this->data, fn($row) => $row[$column] == $value);
    }

    public function transformData($callback) {
        $this->data = array_map($callback, $this->data);
        return $this;
    }

    public function mergeData($newData) {
        $this->data = array_merge($this->data, $newData);
        return $this;
    }

    public function sortData($column, $order = 'ASC') {
        usort($this->data, fn($a, $b) => $order == 'ASC' ? $a[$column] <=> $b[$column] : $b[$column] <=> $a[$column]);
        return $this;
    }

    public function paginateData($page, $perPage) {
        $offset = ($page - 1) * $perPage;
        $this->data = array_slice($this->data, $offset, $perPage);
        return $this;
    }

    public function getData() {
        return $this->data;
    }
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $operations = new ComplexOperations($pdo);
    $operations->fetchData('users', ['status' => 'active'])->processData()->saveData('processed_users');
    $report = $operations->generateReport('users');
    echo json_encode($report);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
