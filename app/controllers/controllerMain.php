<?php

class controllerMain extends Controller
{
	function index()
	{	
		$this->view->generate('mainView.php', 'templateView.php');
	}
}