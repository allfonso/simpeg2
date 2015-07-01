<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Resources_model extends CI_Model
{
	var $resources= array();

	public function __construct(){
		parent::__construct();
	}

	public function init_data_resources( $parent_id = 0, $deep = 1, $indent = true)
	{
		$this->db->select('id,name,title,parent_id');
		$this->db->where('parent_id',$parent_id);
		$query = $this->db->get('sys_resources');

		$deep = ($parent_id == 0)?0:$deep;
		$item = array();
		if( $query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$title = ($indent)?str_repeat("&nbsp;",($deep*2) ) . $row->title : $row->title;
				$this->resources[] = array(
							"id" => $row->id,
							"parent_id" => $row->parent_id,
							"name" => $row->name,
							"title" => $title
						);
				$this->init_data_resources($row->id,($deep+1),$indent) ;
			}
		}
	}

	public function tree_resources( $parent_id = 0, $deep = 1)
	{
		$this->db->select('id,name,title,parent_id');
		$this->db->where('parent_id',$parent_id);
		$query = $this->db->get('sys_resources');

		$deep = ($parent_id == 0)?0:$deep;
		$item = array();
		if( $query->num_rows() > 0 ){
			foreach($query->result() as $row){
				$item[] = array(
							"id" => $row->id,
							"parent_id" => $row->parent_id,
							"name" => $row->name,
							"title" => $row->title,
							"children"=> $this->tree_resources($row->id)
						);
			}
		}
		return $item;
	}

	public function get_resources(){
		return $this->resources;
	}

	public function save( $arr,$id = null ){
		$response = array("status"=>0,"msg" => "Gagal simpan data");
		if( $arr )
		{

			$this->db->where('name',$arr['name']);
			$cek = $this->db->get('sys_resources');

			if( $cek->num_rows() > 0 ){
				return array("status"=>0,"msg" => "Gagal simpan data. Nama akses sudah ada");
			}

			foreach($arr as $field=>$value){
				$this->db->set($field,$value);
			}

			if( $id ){
				$this->db->where('id',$id);
				$save = $this->db->update('sys_resources');
			}else{
				$save = $this->db->insert('sys_resources');
			}

			if( $save ){
				$response = array("status"=>1,"msg" => "Berhasil simpan data");
			}else{
				$response = array("status"=>0,"msg" => "Gagal simpan data");
			}
		}
		return $response;
	}
}