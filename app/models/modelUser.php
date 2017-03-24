<?php

class modelUser extends Model
{
    public $id;
    public $login;
    public $email;
    public $pass;

    function __construct()
    {
        parent::__construct();
    }

    function auth()
    {
        $query = "SELECT * FROM users WHERE login=:login";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':login' => $this->login])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows) > 0) {
                if (password_verify($this->pass, $rows[0]['pass']))
                {
                    $_SESSION['user_id'] = $rows[0]['id'];
                    $this->id = $rows[0]['id'];
                    $this->email = $rows[0]['email'];
                    return new successMessage(errorList::LogInSuccess);
                }
                else
                {
                    return new errorMessage(errorList::InCorrectLoginOrPass);
                }
            }
            else
            {
                return new errorMessage(errorList::InCorrectLoginOrPass);
            }
        } else {
            return new errorMessage($stmt->errorInfo());
        }
    }

    function create($pass)
    {
        $query = "SELECT login FROM users WHERE login = :login || email = :email";
        $stmt = $this->connection->prepare($query);
        if(!$stmt->execute([':login' => $this->login, ':email' => $this->email]))
        {
            return new errorMessage($stmt->errorInfo());
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($rows) > 0)
            return new errorMessage(errorList::OccupiedLoginOrEmail);

        $this->pass = password_hash($pass, PASSWORD_BCRYPT, ['cost' => 12]);

        $query = "INSERT INTO users SET login=:login, email=:email, pass=:pass";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':login' => $this->login, ':email' => $this->email, ':pass' => $this->pass])) {
            $this->id = $this->connection->lastInsertId();
            return new successMessage(errorList::SuccessRegistration);
        } else {
            return new errorMessage($stmt->errorInfo());
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
        $query = "UPDATE users SET login=:login, email=:email WHERE id = :id";

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
