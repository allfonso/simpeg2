<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys_resources extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('system/resources_model');
	}

	public function index(){
		$this->resources_model->init_data_resources();
		$resources = $this->resources_model->get_resources();
		$data['resources'] = $resources;
		$this->load->view('cpanel/layout_data_resources',$data);
	}

	public function load_data()
	{
		$this->resources_model->init_data_resources();
		$resources = $this->resources_model->get_resources();

		$json['total'] = count($resources);
		$json['rows'] = $resources;
		$this->output->set_content_type('application/json')->set_output(json_encode($resources));
	}

	public function get_resources()
	{
		$this->resources_model->init_data_resources(0,1,false);
		$resources = $this->resources_model->get_resources();

		$this->output->set_content_type('application/json')->set_output(json_encode($resources));
	}

	public function save()
	{
		$response = array("status"=>0,"msg" => "Gagal simpan data");
		if( $this->input->post('name') && $this->input->post('title') && $this->input->post('parent_id') ){
			$post['name'] = $this->input->post('name');
			$post['title'] = $this->input->post('title');
			$post['parent_id'] = $this->input->post('parent_id');
			$response = $this->resources_model->save( $post );
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function delete()
	{
		$response = array("status"=>0,"msg" => "Gagal hapus data");
		if( $this->input->post('id') ){
			$id = (int)$this->input->post('id');

			if( $id == 1 ){
				$response = array("status"=>0,"msg" => "Akses Root tidak bisa dihapus");
				$this->output->set_content_type('application/json')->set_output(json_encode($response));
				exit();
			}

			$this->resources_model->init_data_resources($id);
			$resources = $this->resources_model->get_resources();

			if( $resources ){
				$child = array();
				foreach($resources as $row){
					$child[] = $row['id'];
				}
			}

			$this->db->where("id",$id);
			$delete = $this->db->delete('sys_resources');
			if( $delete ){
				if( $child ){
					$this->db->where_in("id",$child);
					$this->db->delete('sys_resources');
				}
				$response = array("status"=>1,"msg" => "Berhasil hapus data");
			}else{
				$response = array("status"=>0,"msg" => "Gagal hapus data");
			}
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

}