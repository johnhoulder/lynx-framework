<?php

class CalcController extends Controller
{
	function index()
	{
		$this->load('demo');
		require($this->view('calc_index'));
	}
	
	function results()
	{
		$answer = $_POST['num1'] + $_POST['num2'];
		require($this->view('calc_results'));
	}
}

?>