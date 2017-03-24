<?php

class modelUser extends Model
{
    public $id;
    public $login;
    public $email;
    public $pass;
    private $salt;

    function __construct()
    {
        $this->salt = substr(md5(uniqid()), -8);
        parent::__construct();
    }

    function auth()
    {
        $query = "SELECT * FROM users WHERE login=:login && pass=:pass";

        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':login' => $this->login, ':pass' => $this->pass])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(count($rows) > 0) {
                if(md5(md5($_POST['pass']).$rows[0]['salt']) == $rows[0]['pass'])
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
            return new errorMessage(errorList::IncorrectQuery);
        }
    }

    function create($pass)
    {
        /*$query = "SELECT login FROM users WHERE login = :login || email = :email";
        $stmt = $this->connection->prepare($query);
        if(!$stmt->execute([':login' => $this->login, ':email' => $this->email]))
        {
            return new errorMessage(errorList::IncorrectQuery);
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($rows) > 0)
            return new errorMessage(errorList::OccupiedLoginOrEmail);*/

        $this->pass = md5(md5($pass).$this->salt);
        $salt = md5($this->salt);

        $query = "INSERT INTO users SET login=:login, email=:email, pass=:pass, salt=:salt";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute(['login' => $this->login, 'email' => $this->email, 'pass' => $this->pass, 'salt' => $salt])) {
            $this->id = $this->connection->lastInsertId();
            return new successMessage(errorList::SuccessRegistration);
        } else {
            return new errorMessage(errorList::IncorrectQuery);
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
