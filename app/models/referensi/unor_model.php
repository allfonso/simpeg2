<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unor_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function get_unor()
	{
		$query = $this->db->query("
					SELECT 
						UNOR_ID AS KODE,
						TRIM(UNOR_NAMA) AS NAMA 
					FROM sp_unor 
					WHERE unor_induk = '1' 
					ORDER BY UNOR_NAMA ASC");

		$data = array();
		foreach($query->result() as $row){
			$data[$row->KODE] = $row->NAMA;
		}
		return $data;
	}
}