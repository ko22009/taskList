<?php

class controllerUser extends Controller
{
	function __construct()
    {
        $this->model = new modelUser();
        parent::__construct();
    }
	function action_index()
	{
		$this->view->generate('userView.php', 'templateView.php');
	}
	function action_readAll()
    {
        $data = $this->model->readAll();
        echo json_encode($data);
    }
    /*function action_create()
    {
        $this->model->login =
        $this->model->email =
        $this->model->pass =
        $data = $this->model->create();
        $this->view->generate('userView.php', 'templateView.php', $data);
    }*/
}
