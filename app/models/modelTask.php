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
}