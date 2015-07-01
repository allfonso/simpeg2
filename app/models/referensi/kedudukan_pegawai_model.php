<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kedudukan_pegawai_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_kedudukan_pegawai()
	{
		$this->db->select('KEDUDUKAN_ID AS KODE');
		$this->db->select('KEDUDUKAN_NAMA AS NAMA');
		$query = $this->db->get('sp_kedudukan_pegawai');

		$arr = array();
		foreach($query->result() as $row){
			$arr[$row->KODE] = $row->NAMA;
		}

		return $arr;
	}
}