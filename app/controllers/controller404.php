<?php

class controller404 extends Controller
{
	function index()
	{
        $data['title'] = 'Не найдено';
		$this->view->generate('404View.php', 'templateView.php', $data);
	}
}
