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