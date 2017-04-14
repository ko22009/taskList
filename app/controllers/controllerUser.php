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
        $data['title'] = 'Регистрация';
        $this->view->generate('user/register.php', 'templateView.php', $data);
    }

    function api_register()
    {
        if(!isset($_REQUEST['pass']) || empty($_REQUEST['pass'])) echo json_encode(new errorMessage(errorList::EmptyPass)), exit;
        if(!isset($_REQUEST['login']) || empty($_REQUEST['login'])) echo json_encode(new errorMessage(errorList::EmptyLogin)), exit;
        if(!isset($_REQUEST['email']) || empty($_REQUEST['email'])) echo json_encode(new errorMessage(errorList::EmptyEmail)), exit;
        if(!isset($_REQUEST['pass2']) || empty($_REQUEST['pass2'])) echo json_encode(new errorMessage(errorList::EmptyPass2)), exit;
        if(!isset($_REQUEST['captcha']) || empty($_REQUEST['captcha']) || !isset($_SESSION['captcha'])) echo json_encode(new errorMessage(errorList::CaptchaEmpty)), exit;
        if($_REQUEST['captcha'] != $_SESSION['captcha']) echo json_encode(new errorMessage(errorList::CaptchaError)), exit;
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
            echo json_encode($auth), exit;
        } else if(property_exists($auth, 'error')) echo json_encode($auth), exit;
    }

    function login_index()
    {
        $data['title'] = 'Вход';
        $this->view->generate('user/login.php', 'templateView.php', $data);
    }

    function api_login()
    {
        if(!isset($_REQUEST['login']) || empty($_REQUEST['login'])) echo json_encode(new errorMessage(errorList::EmptyLogin)), exit;
        if(!isset($_REQUEST['pass']) || empty($_REQUEST['pass'])) echo json_encode(new errorMessage(errorList::EmptyPass)), exit;
        if(!isset($_REQUEST['captcha']) || empty($_REQUEST['captcha']) || !isset($_SESSION['captcha'])) echo json_encode(new errorMessage(errorList::CaptchaEmpty)), exit;
        if($_REQUEST['captcha'] != $_SESSION['captcha']) echo json_encode(new errorMessage(errorList::CaptchaError)), exit;
        $this->model->login = $_REQUEST['login'];
        $this->model->pass = $_REQUEST['pass'];
        $auth = $this->model->auth();
        if(property_exists($auth, 'success'))
        {
            $_SESSION['user_id'] = $this->model->id;
            echo json_encode($auth), exit;
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

    function image()
    {
        header('Content-type: image/png');
        $im = imagecreatetruecolor(180, 30);
        $white = imagecolorallocate($im, 255, 255, 255);
        imagefilledrectangle($im, 0, 0, 399, 29, $white);
        $text = mt_rand();
        $_SESSION['captcha'] = $text;
        $font = 'arial.ttf';
        imagettftext($im, 20, 0, 10, 25, 0, $font, $text);
        imagepng($im);
        imagedestroy($im);
    }
}
