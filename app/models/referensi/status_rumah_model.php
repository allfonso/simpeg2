<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Status_rumah_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_status_rumah()
	{
		$this->db->select('STATUS_RUMAH_ID AS KODE');
		$this->db->select('STATUS_RUMAH_NAMA AS NAMA');
		$query = $this->db->get('sp_status_rumah');

		$arr = array();
		foreach($query->result() as $row){
			$arr[$row->KODE] = $row->NAMA;
		}

		return $arr;
	}
}