<?php

namespace App\Abstract;

use mysqli;
use mysqli_result;

abstract class Model
{
    protected string $host = 'localhost';
    protected string $user = 'root';
    protected string $password = 'root';
    protected string $port = '8889';
    protected string $db_name = 'todo_app';
    protected string $table;
    protected string $where = '';
    protected string $orderby = '';
    protected string $join = '';
    protected string $select = '';

    protected function query($sql): mysqli_result|bool
    {
        $db = new mysqli($this->host, $this->user, $this->password, $this->db_name, $this->port);
        return $db->query($sql);
    }

    public function create(array $data)
    {
        $arrayKeys = array_keys($data);
        $arrayValues = array_values($data);
        $keys = '';
        $values = '';
        foreach ($arrayKeys as $key) {
            if (end($arrayKeys) == $key) {
                $keys .= "`" . $key . "`";
            } else {
                $keys .= "`" . $key . "`, ";
            }
        }
        $count = count($arrayValues);
        for ($i = 0; $i < $count; $i++) {
            if ($i == $count - 1) {
                $values .= $this->value($arrayValues[$i]);
            } else {
                $values .= $this->value($arrayValues[$i]) . ", ";
            }
        }
        $sql = "INSERT INTO `" . $this->table . "`($keys) VALUES($values)";
        return $this->query($sql);
    }

    public function get(...$fields)
    {
        $this->select(...$fields);
        $sql = "SELECT " . $this->select . " FROM `" . $this->table . "`";

        if (!empty($this->join)) {
            $sql .= $this->join;
        }
        if (!empty($this->where)) {
            $sql .= $this->where;
        }
        if (!empty($this->orderby)) {
            $sql .= $this->orderby;
        }
        $data = $this->query($sql);
        $final = [];
        while ($row = $data->fetch_assoc()) {
            $final[] = $row;
        }
        return $final;
    }

    public function where(string $column, string $operator, mixed $value): static
    {
        if (empty($this->where)) {
            $this->where .= " WHERE $column $operator " . $this->value($value) . " ";
        } else {
            $this->where .= "AND $column $operator " . $this->value($value) . " ";
        }
        return $this;
    }

    public function first(): bool|array|null
    {
        $sql = "SELECT * FROM `" . $this->table . "`";
        if (!empty($this->where)) {
            $sql .= $this->where;
        }
        $sql .= "LIMIT 1";
        return $this->query($sql)->fetch_assoc();
    }


    private function value($value)
    {
        if (is_double($value)) {
            $value = doubleval($value);
        } elseif (is_int($value)) {
            $value = (int) $value;
        } elseif (is_string($value)) {
            $value = "'" . $value . "'";
        } elseif (is_null($value)) {
            $value = 'null';
        }
        return $value;
    }

    public function delete()
    {
        $sql = "DELETE FROM `" . $this->table . "` ";
        if (!empty($this->where)) {
            $sql .= $this->where;
        }
        return $this->query($sql);
    }

    public function orWhere(string $column, string $operator, mixed $value)
    {

        if (!empty($this->where)) {
            $this->where .= " OR $column $operator " . $this->value($value) . " ";
        }
        return $this;
    }

    public function OrderBy(string $column, $type = 'asc')
    {
        $type = strtoupper($type);

        if ($type == 'ASC' or $type == 'DESC') {
            $this->orderby = " ORDER BY $column $type ";
        }
        return $this;
    }

    public function update(array $update)
    {
        $set = '';
        $count = count($update);
        $i = 0;
        foreach ($update as $key => $value) {
            if ($i == $count - 1) {
                $set .= "$key= " . $this->value($value);
            } else {
                $set .= "$key= " . $this->value($value) . ",";
            }
            $i++;
        }
        $sql = "UPDATE " . $this->table . " SET $set";
        if (!empty($this->where)) {
            $sql .= $this->where;
        }
        return $this->query($sql);
    }

    public function join($table, $first, $second)
    {
        $this->join = " INNER JOIN $table ON " . $this->table . "." . $first . " = " . $table . "." . $second;
        return $this;
    }

    public function rightJoin($table, $first, $second)
    {
        $this->join = " RIGHT JOIN $table ON " . $this->table . "." . $first . " = " . $table . "." . $second;
        return $this;
    }

    public function leftJoin($table, $first, $second)
    {
        $this->join = " LEFT JOIN $table ON " . $this->table . "." . $first . " = " . $table . "." . $second;
        return $this;
    }
    public function select(...$fields)
    {
        $keys = '';
        if (empty($fields)) {
            $keys = '*';
        } else {
            $count = count($fields);
            $i = 0;
            foreach ($fields as $field) {
                $as = explode(" as ", $field);
                if (isset($as[1])) {
                    $keys .= $as[0] . " as " . $as[1];
                } else {
                    $keys .= $field;
                }
                if ($i != $count - 1) {
                    $keys .= ", ";
                }
                $i++;
            }
        }
        $this->select = $keys;
        return $this;
    }
    public function pagination($per_page, $page)
    {
        $sql = "SELECT " . $this->select . " FROM `" . $this->table . "`";
        if (!empty($this->join)) {
            $sql .= $this->join;
        }
        if (!empty($this->where)) {
            $sql .= $this->where;
        }
        if (!empty($this->orderby)) {
            $sql .= $this->orderby;
        }
        $offset = ($page - 1) * $per_page;
        $data = $this->query($sql);
        $total = $data->num_rows;
        $sql .= " LIMIT $per_page OFFSET $offset";
        $data = $this->query($sql);
        $final = [];
        while ($row = $data->fetch_assoc()) {
            $final[] = $row;
        }
        return [$total, $final];
    }
}
