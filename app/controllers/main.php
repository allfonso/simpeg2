<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('layout_main');
	}

	public function logout()
	{
		$username = $this->dx_auth->get_username();		
		$this->dx_auth->logout();
		set_log("User ID $username Success LOGOUT");
		redirect( _URL );
		exit();
	}

	private function get_menu( $parent_id = 0, $group_id = 1 )
	{
		$this->db->where('parent_id', $parent_id);
		$this->db->where('active', 1);
		$this->db->order_by('order_by', 'ASC');
		$query = $this->db->get('sys_menu');

		$arr = array();
		if( $query->num_rows() > 0 ){
			foreach ($query->result() as $row) 
			{
				$children = $this->get_menu( $row->id, $group_id );

				$r['id'] = $row->id;
				$r['parent_id'] = $row->parent_id;
				$r['text'] = $row->name;
				if( count($children) == 0 ){
					$r['url'] = $row->url;
				}
				$r['children'] = $children;
				$arr[] = $r;
			}
		}

		return $arr;
	}

	public function menu()
	{
		$menu = $this->get_menu();
		$this->output->set_content_type('application/json')->set_output(json_encode($menu));
	}

	public function access()
	{
		// $this->load->helper('menu');
		// $menu = array_menu(0,2,array(2,5,48));
		// $this->output->set_content_type('application/json')->set_output(json_encode($menu));

		$menu = array(
					array(
						"id" => 1,
						"parent_id" => 0,
						"text" => "Group User",
						"children" => array(
											array(
												"id" => 2,
												"parent_id" => 1,
												"text" => "Data groups",
												"url"=>"cpanel/groups"
											)
										)
					)
			);

		echo json_encode($menu);
		die;

		$this->output->set_content_type('application/json')->set_output(json_encode($menu));
		// echo '[{"id":"1","parent_id":"0","text":"APP SETTINGS","url":"#","state":"","children":[{"id":"2","parent_id":"1","text":"GROUP","url":"#","state":"","children":[{"id":"3","parent_id":"2","text":"DATA GROUP","url":"user\/groups\/index","state":"","children":[]},{"id":"4","parent_id":"2","text":"TAMBAH GROUP","url":"user\/groups\/index\/add","state":"","children":[]}]},{"id":"5","parent_id":"1","text":"RESOURCES","url":"#","state":"","children":[{"id":"6","parent_id":"5","text":"DATA RESOURCES","url":"user\/resources\/index","state":"","children":[]},{"id":"7","parent_id":"5","text":"TAMBAH RESOURCES","url":"user\/resources\/form\/add","state":"","children":[]}]},{"id":"48","parent_id":"1","text":"USER MANAGER","url":"#","state":"","children":[{"id":"49","parent_id":"48","text":"DATA USER","url":"user\/index","state":"","children":[]},{"id":"50","parent_id":"48","text":"UBAH PASSWORD","url":"user\/change_password","state":"","children":[]}]},{"id":"57","parent_id":"1","text":"LOG","url":"#","state":"","children":[{"id":"58","parent_id":"57","text":"DATA LOG","url":"pegawai\/activity_log","state":"","children":[]}]}]}]';
	}

	public function restricted()
	{
		$this->load->view('layout_restricted.php');
	}

	public function add_menu()
	{
		$data = array();
		$this->db->where('parent_id',0);
		$data['menu'] = $this->db->get('sys_menu') -> result_array();

		$this->load->view('main/menu', $data);
	}

	public function save_menu()
	{
		$sql['parent_id'] = $this->input->post('parent_id');
		$sql['name'] = $this->input->post('nama');
		$sql['url'] = $this->input->post('url');

		$insert = $this->db->insert('sys_menu',$sql);
		if($insert){
			$resources['parent_id'] = ($this->input->post('parent_id') == 0)?1:$this->input->post('parent_id');
			$resources['name'] = str_replace(' ', '.',strtolower( trim($this->input->post('nama')) ) );
			$resources['title'] = $this->input->post('nama');
			$this->db->insert('sys_resources',$resources);
			$this->session->set_flashdata('msg','Berhasil simpan menu');
		}else{
			$this->session->set_flashdata('msg','Gagal simpan menu');
		}

		redirect( 'main/add_menu' );
	}

}