<?php

class controllerTask extends Controller
{
    function __construct()
    {
        $this->model = new modelTask();
        parent::__construct();
    }

    function index($num)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $result = $this->model->haveList($num);
        if (property_exists($result, 'success')) {
            $data['title'] = 'Контакты';
            $this->view->generate('task/index.php', 'templateView.php', $data);
        } else if (property_exists($result, 'error')) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
            $controller = new controller404();
            $controller->index();
        }
    }

    function api_create($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
        $result = $this->model->existList($listID);
        if (property_exists($result, 'error')) {
            echo json_encode($result), exit;
        }
        if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) echo json_encode(new errorMessage(errorList::EmptyName)), exit;
        if (!isset($_REQUEST['surname']) || empty($_REQUEST['surname'])) echo json_encode(new errorMessage(errorList::EmptySurname)), exit;
        if (!isset($_REQUEST['phone']) || empty($_REQUEST['phone'])) echo json_encode(new errorMessage(errorList::EmptyPhone)), exit;
        if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) echo json_encode(new errorMessage(errorList::EmptyEmail)), exit;

        $this->model->name = $_REQUEST['name'];
        $this->model->surname = $_REQUEST['surname'];
        $this->model->phone = $_REQUEST['phone'];
        $this->model->email = $_REQUEST['email'];
        $this->model->image = '';

        if (!ctype_alpha($this->model->name)) {
            echo json_encode(new errorMessage(errorList::IncorrectName)), exit;
        }

        if (!ctype_alpha($this->model->surname)) {
            echo json_encode(new errorMessage(errorList::IncorrectSurname)), exit;
        }

        if (!filter_var($this->model->phone, FILTER_VALIDATE_INT)) {
            echo json_encode(new errorMessage(errorList::IncorrectPhoneNumber)), exit;
        }

        if (!filter_var($this->model->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(new errorMessage(errorList::MailIncorrect)), exit;
        }

        $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/uploads/';

        if (isset($_FILES['image'])) {
            $img = $_FILES['image']['name'];
            $tmp = $_FILES['image']['tmp_name'];
            // get uploaded file's extension
            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
            // can upload same image using rand function
            $final_image = md5(time() . $img) . '.' . $ext;
            // check's valid format
            if (in_array($ext, $valid_extensions)) {
                $path = $path . strtolower($final_image);
                if (move_uploaded_file($tmp, $path)) {
                    if (filesize($path) > 1024 * 1024 * 2) // filesize возвращает в байтах
                    {
                        unlink($path);
                        echo json_encode(new errorMessage(errorList::FileMoreSize)), exit;
                    }
                    $this->model->image = $final_image;
                } else echo json_encode(new errorMessage(errorList::FileNoWrite)), exit; // заходит также, если объем файла большой и на сервере upload_max_filesize
            } else {
                echo json_encode(new errorMessage(errorList::InvalidTypeFormat)), exit;
            }
        }
        $task = $this->model->create();
        if (property_exists($task, 'success')) {
            echo json_encode($task), exit;
        } else if (property_exists($task, 'error')) {
            if(file_exists($path)) unlink($path);
            echo json_encode($task), exit;
        }
    }

    function api_read($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
        $result = $this->model->haveList($listID);
        if (property_exists($result, 'error')) {
            echo json_encode($result), exit;
        }
        if (!isset($_REQUEST['id']) || $_REQUEST['id'] == "undefined") {
            echo $this->model->readAll();
        } else {
            echo $this->model->read();
        }
    }

    function api_update($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
        $result = $this->model->haveList($listID);
        if (property_exists($result, 'error')) {
            echo json_encode($result), exit;
        }
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) echo json_encode(new errorMessage(errorList::EmptyId)), exit;
        if (!isset($_REQUEST['name']) || empty($_REQUEST['name'])) echo json_encode(new errorMessage(errorList::EmptyName)), exit;
        if (!isset($_REQUEST['surname']) || empty($_REQUEST['surname'])) echo json_encode(new errorMessage(errorList::EmptySurname)), exit;
        if (!isset($_REQUEST['phone']) || empty($_REQUEST['phone'])) echo json_encode(new errorMessage(errorList::EmptyPhone)), exit;
        if (!isset($_REQUEST['email']) || empty($_REQUEST['email'])) echo json_encode(new errorMessage(errorList::EmptyEmail)), exit;

        $this->model->id = $_REQUEST['id'];
        $this->model->name = $_REQUEST['name'];
        $this->model->surname = $_REQUEST['surname'];
        $this->model->phone = $_REQUEST['phone'];
        $this->model->email = $_REQUEST['email'];
        $this->model->image = '';

        if (!ctype_alpha($this->model->name)) {
            echo json_encode(new errorMessage(errorList::IncorrectName)), exit;
        }

        if (!ctype_alpha($this->model->surname)) {
            echo json_encode(new errorMessage(errorList::IncorrectSurname)), exit;
        }

        if (!filter_var($this->model->phone, FILTER_VALIDATE_INT)) {
            echo json_encode(new errorMessage(errorList::IncorrectPhoneNumber)), exit;
        }

        if (!filter_var($this->model->email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(new errorMessage(errorList::MailIncorrect)), exit;
        }

        $result = $this->model->taskHaveThisList();
        if (property_exists($result, 'error')) {
            echo json_encode($result), exit;
        }

        $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        $path = $_SERVER['DOCUMENT_ROOT'] . '/app/uploads/';

        if (isset($_FILES['image']) || isset($_REQUEST['image'])) {
            if (isset($_FILES['image'])) {
                $img = $_FILES['image']['name'];
                $tmp = $_FILES['image']['tmp_name'];
                // get uploaded file's extension
                $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                // can upload same image using rand function
                $final_image = md5(time() . $img) . '.' . $ext;
                // check's valid format
                if (in_array($ext, $valid_extensions)) {
                    $path = $path . strtolower($final_image);
                    if (move_uploaded_file($tmp, $path)) {
                        if (filesize($path) > 1024 * 1024 * 2) // filesize возвращает в байтах
                        {
                            unlink($path);
                            echo json_encode(new errorMessage(errorList::FileMoreSize)), exit;
                        }
                        $this->model->removePrevImage();
                        $this->model->image = $final_image;
                        $result = $this->model->update();
                        if (property_exists($result, 'success')) {
                            echo json_encode($result), exit;
                        } else if (property_exists($result, 'error')) {
                            unlink($path);
                            echo json_encode($result), exit;
                        }
                    } else echo json_encode(new errorMessage(errorList::FileNoWrite)), exit; // заходит также, если объем файла большой и на сервере upload_max_filesize
                } else {
                    echo json_encode(new errorMessage(errorList::InvalidTypeFormat)), exit;
                }
            } else {
                $this->model->image = $_REQUEST['image']=='undefined'?'':$_REQUEST['image'];
                $result = $this->model->update();
                if (property_exists($result, 'success')) {
                    echo json_encode($result), exit;
                } else if (property_exists($result, 'error')) {
                    unlink($path);
                    echo json_encode($result), exit;
                }
            }
        }
    }

    function api_delete($listID)
    {
        $this->model->id_user = $_SESSION['user_id'];
        $this->model->listID = $listID;
        $result = $this->model->haveList($listID);
        if (property_exists($result, 'error')) {
            echo json_encode($result), exit;
        }
        if (!isset($_REQUEST['id']) || empty($_REQUEST['id'])) echo json_encode(new errorMessage(errorList::EmptyId)), exit;
        $this->model->id = $_REQUEST['id'];
        $result = $this->model->taskHaveThisList();
        if (property_exists($result, 'error')) {
            echo json_encode($result), exit;
        }
        $this->model->removePrevImage();
        $result = $this->model->delete();
        echo json_encode($result), exit;
    }
}