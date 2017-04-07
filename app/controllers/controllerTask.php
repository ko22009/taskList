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
}