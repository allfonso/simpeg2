<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agama_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_agama()
	{
		$this->db->select('AGAMA_ID AS KODE');
		$this->db->select('AGAMA_NAMA AS NAMA');
		$query = $this->db->get('sp_agama');

		$data = array();
		foreach($query->result() as $row){
			$data[$row->KODE] = $row->NAMA;
		}

		return $data;
	}
}