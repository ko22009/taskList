<?php

class modelList extends Model
{
    public $id_user;
    public $list;
    function __construct()
    {
        parent::__construct();
    }
    function create($listname)
    {
        $query = "INSERT INTO lists SET id_user=:id_user, name=:listname";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id_user' => $this->id_user, ':listname' => $listname])) {
            $data = new successMessage(errorList::SuccessCreate);
            $data->id = $this->connection->lastInsertId();
            $data->name = $listname;
            return json_encode($data);
        } else {
            return json_encode(new errorMessage($stmt->errorInfo()));
        }
    }
    function read($id)
    {
        $query = "SELECT * FROM lists WHERE id_user=:id_user && id=:id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id_user' => $this->id_user, ':id' => $id])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0)
            {
                $this->list = $rows;
            } else $this->list = [];
        } else $this->list = [];
        return json_encode($this->list);
    }
    function readAll()
    {
        $query = "SELECT * FROM lists WHERE id_user=:id_user";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id_user' => $this->id_user])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0)
            {
                $this->list = $rows;
            } else $this->list = [];
        } else $this->list = [];
        return json_encode($this->list);
    }
    function update($id, $name)
    {
        $query = "UPDATE lists SET name=:name WHERE id=:id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':name' => $name, ':id' => $id])) {
            return json_encode(new successMessage(errorList::SuccessUpdate));
        } else return json_encode(new errorMessage($stmt->errorInfo()));
    }
    function delete($id)
    {
        $query = "DELETE FROM lists WHERE id=:id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id' => $id])) {
            return json_encode(new successMessage(errorList::SuccessRemove));
        } else return json_encode(new errorMessage($stmt->errorInfo()));
    }
}