<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenjangdidik_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_jenjangdidik()
	{
		$this->db->select('ID AS KODE');
		$this->db->select('JENJANG_DIDIK AS NAMA');
		$query = $this->db->get('sp_jenjang_didik');

		$data = array();
		foreach($query->result() as $row){
			$data[$row->KODE] = $row->NAMA;
		}

		return $data;
	}
}