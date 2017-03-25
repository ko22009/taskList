<?php

class controllerUser extends Controller
{
    function __construct()
    {
        $this->model = new modelUser();
        parent::__construct();
    }

    function register_index()
    {
        if(isset($_SESSION['user_id']))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']);
        } else
        {
            $data['title'] = 'Регистрация';
            $this->view->generate('user/register.php', 'templateView.php', $data);
        }
    }

    function register_create()
    {
        if(!isset($_SESSION['user_id']))
        {
            //$this->model->email
            //$this->model->login
            if(!isset($_REQUEST['pass']) || empty($_REQUEST['pass'])) echo json_encode(new errorMessage(errorList::EmptyPass)), exit;
            if(!isset($_REQUEST['login']) || empty($_REQUEST['login'])) echo json_encode(new errorMessage(errorList::EmptyLogin)), exit;
            if(!isset($_REQUEST['email']) || empty($_REQUEST['email'])) echo json_encode(new errorMessage(errorList::EmptyEmail)), exit;
            if(!isset($_REQUEST['pass2']) || empty($_REQUEST['pass2'])) echo json_encode(new errorMessage(errorList::EmptyPass2)), exit;
            $pass = $_REQUEST['pass'];
            $pass2 = $_REQUEST['pass2'];
            $email = $_REQUEST['email'];
            $login = $_REQUEST['login'];
            if($pass != $pass2) echo json_encode(new errorMessage(errorList::PassIsNotEqual)), exit;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(new errorMessage(errorList::MailIncorrect)), exit;
            }
            if( strlen($login) < 3 ) echo json_encode(new errorMessage(errorList::ShortLogin)), exit;
            $this->model->email = $email;
            $this->model->login = $login;
            $auth = $this->model->create($pass);
            if(property_exists($auth, 'success'))
            {
                $_SESSION['user_id'] = $this->model->id;
                header("Location: http://" . $_SERVER['HTTP_HOST']);
            } else if(property_exists($auth, 'error')) echo json_encode($auth), exit;
        }
    }

    function login_index()
    {
        if(isset($_SESSION['user_id']))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']);
        } else
        {
            $data['title'] = 'Вход';
            $this->view->generate('user/login.php', 'templateView.php', $data);
        }
    }

    function login_in()
    {
        if(!isset($_REQUEST['login']) || empty($_REQUEST['login'])) echo json_encode(new errorMessage(errorList::EmptyLogin)), exit;
        if(!isset($_REQUEST['pass']) || empty($_REQUEST['pass'])) echo json_encode(new errorMessage(errorList::EmptyPass)), exit;
        $this->model->login = $_REQUEST['login'];
        $this->model->pass = $_REQUEST['pass'];
        $auth = $this->model->auth();
        if(property_exists($auth, 'success'))
        {
            $_SESSION['user_id'] = $this->model->id;
            header("Location: http://" . $_SERVER['HTTP_HOST']);
        } else if(property_exists($auth, 'error')) echo json_encode($auth), exit;
    }

    function login_out()
    {
        if(isset($_SESSION['user_id']))
        {
            unset($_SESSION['user_id']);
        }
        header("Location: http://" . $_SERVER['HTTP_HOST']);
    }
}
