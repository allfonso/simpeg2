<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenis_pegawai_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_jenis_pegawai()
	{
		$this->db->select('JENIS_PEGAWAI_ID AS KODE');
		$this->db->select('JENIS_PEGAWAI_NAMA AS NAMA');
		$query = $this->db->get('sp_jenis_pegawai');
		
		$data = array();
		foreach($query->result() as $row){
			$data[$row->KODE] = $row->NAMA;
		}

		return $data;
	}
}