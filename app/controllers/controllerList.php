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
        $id = $_SESSION['user_id'];
        $data = $this->model->read($id);
        $data['title'] = 'Списки';
        $this->view->generate('list/index.php', 'templateView.php', $data);
    }
}