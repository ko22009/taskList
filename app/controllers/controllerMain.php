<?php

class controllerMain extends Controller
{
	function action_index()
	{	
		$this->view->generate('mainView.php', 'templateView.php');
	}
}