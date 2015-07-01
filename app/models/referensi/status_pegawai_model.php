<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_pegawai_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_status_pegawai()
	{
		$this->db->select('STATUS_ID AS KODE');
		$this->db->select('STATUS_NAMA AS NAMA');
		$query = $this->db->get('sp_status_pegawai');

		$item = array();
		foreach($query->result() as $row){
			$item[$row->KODE] = $row->NAMA;
		}
		return $item;
	}
}