<?php

class Database {
    private $db;

    public function __construct() {
        // var_dump(new SQLite3("ku")); die;
        $this->db = new SQLite3("ku");
    }

    public function insert($tableName, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        $query = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $this->db->lastInsertRowID();
    }

    public function update($tableName, $data, $condition) {
        $set = "";
        foreach ($data as $column => $value) {
            $set .= "$column = '$value', ";
        }
        $set = rtrim($set, ", ");
        $query = "UPDATE $tableName SET $set WHERE $condition";
        // var_dump($query); die;
        return $this->db->exec($query);
    }

    // public function delete($tableName, $condition) {
    //     $query = "DELETE FROM $tableName WHERE $condition";
    //     return $this->db->exec($query);
    // }

    public function select($tableName, $columns = "*", $condition = "") {
        $query = "SELECT $columns FROM $tableName";
        if (!empty($condition)) {
            $query .= " WHERE $condition";
        }
        $result = $this->db->query($query);
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function close() {
        $this->db->close();
    }
}
