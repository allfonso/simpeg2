<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		check_user('Root');
		$this->load->model('application_model');
	}

	public function group_id()
	{
		return $this->dx_auth->get_role_id();
	}

	public function user_id()
	{
		return $this->dx_auth->get_user_id();
	}
}