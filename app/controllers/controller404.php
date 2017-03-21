<?php

class controller404 extends Controller
{
	function action_index()
	{
		$this->view->generate('404View.php', 'templateView.php');
	}
}
