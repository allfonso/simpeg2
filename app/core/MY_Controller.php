<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	}
}

include_once APPPATH . "libraries/Admin_Controller.php";
include_once APPPATH . "libraries/Public_Controller.php";