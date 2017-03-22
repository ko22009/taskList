<?php

class controllerUser extends Controller
{
    function __construct()
    {
        $this->model = new modelUser();
        parent::__construct();
    }

    function index()
    {
        $this->view->generate('user/index.php', 'templateView.php');
    }

    function register_index()
    {
        if(isset($_SESSION['user_id']))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']);
        } else
        {
            $this->view->generate('user/register.php', 'templateView.php');
        }
    }

    function register_create()
    {
        if(!isset($_SESSION['user_id']))
        {
            //$this->model->email
            //$this->model->login
            if(!isset($_REQUEST['pass']) || empty($_REQUEST['pass'])) echo json_encode(new errorMessage("Пустое поле пароль")), exit;
            if(!isset($_REQUEST['login']) || empty($_REQUEST['login'])) echo json_encode(new errorMessage("Пустое поле логин")), exit;
            if(!isset($_REQUEST['email']) || empty($_REQUEST['email'])) echo json_encode(new errorMessage("Пустое поле email")), exit;
            if(!isset($_REQUEST['pass2']) || empty($_REQUEST['pass2'])) echo json_encode(new errorMessage("Пустое поле подтверждение пароля")), exit;
            $pass = $_REQUEST['pass'];
            $pass2 = $_REQUEST['pass2'];
            $email = $_REQUEST['email'];
            $login = $_REQUEST['login'];
            if($pass != $pass2) echo json_encode(new errorMessage("Пароли не совпадают")), exit;
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo json_encode(new errorMessage("Почта имеет не верный формат!")), exit;
            }
            if( strlen($login) < 3 ) echo json_encode(new errorMessage("Логин не может быть короче 3 символов!")), exit;
            $auth = $this->model->create($pass);
            switch ($auth)
            {
                case 0:
                default:
                {
                    $_SESSION['user_id'] = $this->model->id;
                    header("Location: http://" . $_SERVER['HTTP_HOST']);

                }
            }
        }
    }

    function login_index()
    {
        if(isset($_SESSION['user_id']))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']);
        } else
        {
            $this->view->generate('user/login.php', 'templateView.php');
        }
    }

    function login_in()
    {
        if(!isset($_SESSION['user_id']))
        {
            if(!isset($_REQUEST['login']) || empty($_REQUEST['login'])) echo json_encode(new errorMessage("Пустое поле логин")), exit;
            if(!isset($_REQUEST['pass']) || empty($_REQUEST['pass'])) echo json_encode(new errorMessage("Пустое поле пароль")), exit;
            $this->model->login = $_REQUEST['login'];
            $this->model->pass = $_REQUEST['pass'];
            $auth = $this->model->auth();
            if(property_exists($auth, 'success'))
            {
                $_SESSION['user_id'] = $this->model->id;
                header("Location: http://" . $_SERVER['HTTP_HOST']);
            } else if(property_exists($auth, 'error')) echo json_encode($auth), exit;
        }
    }

    function login_out()
    {
        if(!isset($_SESSION['user_id']))
        {
            header("Location: http://".$_SERVER['HTTP_HOST']);
        } else unset($_SESSION['user_id']);
    }
}
