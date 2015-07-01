<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Golongan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_golongan()
	{
		$this->db->select('GOLONGAN_ID AS KODE');
		$this->db->select('GOLONGAN_KODE AS NAMA');
		$query = $this->db->get('sp_golongan');

		$data = array();
		foreach($query->result() as $row){
			$data[$row->KODE] = $row->NAMA;
		}

		return $data;
	}

	/**
	*tambah untuk ambil data sp_kenaikan_pangkat -> untuk data jenis_kp_id di sp_pegawai
	*/
	public function get_jenis_kenaikan_pangkat()
	{
		$this->db->select('KP_ID AS KODE');
		$this->db->select('KP_NAMA AS NAMA');
		$query = $this->db->get('sp_kenaikan_pangkat');

		$data = array();
		foreach($query->result() as $row){
			$data[$row->KODE] = $row->NAMA;
		}

		return $data;
	}
}