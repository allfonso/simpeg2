<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cpanel extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function menu(){
		
	}

	public function resources()
	{
		$this->load->view('cpanel/layout_data_resources');
	}
}