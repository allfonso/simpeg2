<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agama extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		//check_user('referensi.agama');
		$this->load->model('referensi/agama_model');
	}

	public function index()
	{
		$this->load->view('referensi/agama/grid');
	}

	public function load_data()
	{
		$response = array('count' => 0 ,'row' => array());
		$data = $this->agama_model->get_data();
		if( $data ){
			$arr = array();
			foreach($data->result() as $row){
				$arr[] = $row;
			}
			$response = array('total' => $data->num_rows() ,'rows' => $arr);
		}
		$this->output->set_content_type('application/json')->set_output( json_encode($response) );
	}

	public function save()
	{
		pr( $_POST );
	}
}