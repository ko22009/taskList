<?php

class modelUser extends Model
{
    public $id;
    public $login;
    public $email;
    public $pass;

    function create()
    {
        $query = "INSERT INTO users SET login=:login, email=:email, pass=:pass";

        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':login' => $this->login, ':email' => $this->email, ':pass' => $this->pass])) {
            return true;
        } else {
            return false;
        }
    }

    function readAll()
    {
        $query = "SELECT id, login, email FROM users";

        $result = $this->connection->query($query);
        $comments = $result->fetchAll();
        return $comments;
    }

    function update()
    {
        $query = "UPDATE users SET login = :login, email = :email WHERE id = :id";

        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':login' => $this->login, ':email' => $this->email, ':id' => $this->id])) {
            return true;
        } else {
            return false;
        }
    }

    // delete the product
    function delete()
    {

        $query = "DELETE FROM users WHERE id = :id";

        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id' => $this->id])) {
            return true;
        } else {
            return false;
        }
    }
}
