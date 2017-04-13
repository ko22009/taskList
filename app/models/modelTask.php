<?php

class modelTask extends Model
{
    public $id;
    public $id_user;
    public $listID;
    public $name;
    public $surname;
    public $phone;
    public $email;
    public $image;
    function __construct()
    {
        parent::__construct();
    }
    function existList($num)
    {
        $query = "SELECT * FROM lists WHERE id=:id AND id_user=:id_user";
        $stmt = $this->connection->prepare($query);
        if (!$stmt->execute([':id' => $num, ':id_user' => $this->id_user])) {
            return new errorMessage($stmt->errorInfo());
        }
        return new successMessage(errorList::ListNotYour);
    }
    function taskHaveThisList()
    {
        $query = "SELECT * FROM tasks WHERE id=:id and id_list=:id_list";
        $stmt = $this->connection->prepare($query);
        if (!$stmt->execute([':id' => $this->id, ':id_list' => $this->listID])) {
            return json_encode(new errorMessage($stmt->errorInfo()));
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($rows) > 0)
            return new successMessage(errorList::TaskFound);

        return new errorMessage(errorList::TaskNotFound);
    }
    function haveList($num)
    {
        $query = "SELECT * FROM lists WHERE id=:id and id_user=:id_user";
        $stmt = $this->connection->prepare($query);
        if(!$stmt->execute([':id' => $num, ':id_user' => $this->id_user]))
        {
            return new errorMessage($stmt->errorInfo());
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($rows) > 0)
            return new successMessage(errorList::FoundResult);

        return new errorMessage(errorList::NotFoundResult);
    }
    function create()
    {
        $query = "INSERT INTO tasks SET id_list=:id_list, name=:name, surname=:surname, phone=:phone, email=:email, image=:image";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id_list' => $this->listID, ':name' => $this->name, ':surname' => $this->surname, ':phone' => $this->phone, ':email' => $this->email, ':image' => $this->image])) {
            $this->id = $this->connection->lastInsertId();
            return (object) array_merge((array)new successMessage(errorList::SuccessCreate), ['id' => $this->id, 'image' => $this->image]);
        } else {
            return new errorMessage($stmt->errorInfo());
        }
    }
    function read()
    {
        $query = "SELECT * FROM tasks WHERE id_list=:id_list and id=:id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id_list' => $this->listID, ':id' => $this->id])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0)
            {
                $list = $rows;
            } else $list = [];
        } else $list = [];
        return json_encode($list);
    }
    function readAll()
    {
        $query = "SELECT * FROM tasks WHERE id_list=:id_list";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id_list' => $this->listID])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0)
            {
                $list = $rows;
            } else $list = [];
        } else $list = [];
        return json_encode($list);
    }
    function update()
    {
        $query = "UPDATE tasks SET name=:name, surname=:surname, phone=:phone, email=:email, image=:image WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id' => $this->id, ':name' => $this->name, ':surname' => $this->surname, ':phone' => $this->phone, ':email' => $this->email, ':image' => $this->image])) {
            return (object) array_merge((array)new successMessage(errorList::SuccessUpdate), ['image' => $this->image]);
        } else {
            return new errorMessage($stmt->errorInfo());
        }
    }
    function delete()
    {
        $query = "DELETE FROM tasks WHERE id=:id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id' => $this->id])) {
            return json_encode(new successMessage(errorList::SuccessRemove));
        } else return json_encode(new errorMessage($stmt->errorInfo()));
    }
    function removePrevImage()
    {
        $query = "SELECT image FROM tasks WHERE id=:id and image != ''";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id' => $this->id])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0)
            {
                $file = $_SERVER['DOCUMENT_ROOT'] . '/app/uploads/' . $rows[0]['image'];
                if(file_exists($file)) unlink($file);
            }
        } else {
            return new errorMessage($stmt->errorInfo());
        }
    }
}