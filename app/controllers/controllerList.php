<?php

class controllerList extends Controller
{
    function __construct()
    {
        $this->model = new modelList();
        parent::__construct();
    }

    function index()
    {
        $data['title'] = 'Списки';
        $this->view->generate('list/index.php', 'templateView.php', $data);
    }

    function api_create()
    {
        $this->model->id_user = $_SESSION['user_id'];
        if(isset($_REQUEST['name']))
        {
            echo $this->model->create($_REQUEST['name']);
        }
    }

    function api_read()
    {
        $this->model->id_user = $_SESSION['user_id'];
        if(!isset($_REQUEST['id']) || $_REQUEST['id'] == "undefined")
        {
            echo $this->model->readAll();
        } else
        {
            echo $this->model->read($_REQUEST['id']);
        }
    }

    function api_update()
    {
        if(isset($_REQUEST['name']) && isset($_REQUEST['id']))
        {
            echo $this->model->update($_REQUEST['id'], $_REQUEST['name']);
        }
    }

    function api_delete()
    {
        if(isset($_REQUEST['id']))
        {
            echo $this->model->delete($_REQUEST['id']);
        }
    }
}