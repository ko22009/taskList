<?php

class controllerTask extends Controller
{
    function __construct()
    {
        $this->model = new modelTask();
        parent::__construct();
    }
    function index()
    {
        $data['title'] = 'Контакты';
        $this->view->generate('task/index.php', 'templateView.php', $data);
    }
    function api_create($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
        if(!isset($_REQUEST['name']) || empty($_REQUEST['name'])) echo json_encode(new errorMessage(errorList::EmptyName)), exit;
        if(!isset($_REQUEST['surname']) || empty($_REQUEST['surname'])) echo json_encode(new errorMessage(errorList::EmptySurname)), exit;
        if(!isset($_REQUEST['phone']) || empty($_REQUEST['phone'])) echo json_encode(new errorMessage(errorList::EmptyPhone)), exit;
        if(!isset($_REQUEST['email']) || empty($_REQUEST['email'])) echo json_encode(new errorMessage(errorList::EmptyEmail)), exit;

        $this->model->name = $_REQUEST['name'];
        $this->model->surname = $_REQUEST['surname'];
        $this->model->phone = $_REQUEST['phone'];
        $this->model->email = $_REQUEST['email'];

        $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/uploads/';

        if(isset($_FILES['image']))
        {
            $img = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            $final_image = md5(time().$img). '.' . $ext;
            // check's valid format
            if(in_array($ext, $valid_extensions))
            {
                $path = $path.strtolower($final_image);
                if(move_uploaded_file($tmp,$path)) {
                    if(filesize($path) > 1024 * 1024 * 8 * 2) // в байты 2Мбайт
                    {
                        unlink($path);
                        echo json_encode(new errorMessage(errorList::FileMoreSize)), exit;
                    }
                    $this->model->image = $final_image;
                    $task = $this->model->create();
                    if(property_exists($task, 'success'))
                    {
                        echo json_encode($task), exit;
                    } else if(property_exists($task, 'error')) {
                        unlink($path);
                        echo json_encode($task), exit;
                    }
                } else echo json_encode(new errorMessage(errorList::FileNoWrite)), exit;
            }
            else
            {
                echo json_encode(new errorMessage(errorList::InvalidTypeFormat)), exit;
            }
        }
    }
    function api_read($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
        if(!isset($_REQUEST['id']) || $_REQUEST['id'] == "undefined")
        {
            echo $this->model->readAll();
        } else
        {
            echo $this->model->read($_REQUEST['id']);
        }
    }
    function api_update($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
    }
    function api_delete($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
    }
}