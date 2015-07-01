<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diklat_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getDataJenisDiklat()
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT JENIS_DIKLAT_ID AS KODE,JENIS_DIKLAT_NAMA AS NAMA FROM sp_jenis_diklat",'all',600);
		foreach((array)$query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function getDataDiklatStruktural()
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT DIKLAT_STRUKTURAL_ID AS KODE,DIKLAT_STRUKTURAL_NAMA AS NAMA FROM sp_diklat_struktural",'all',600);
		foreach((array)$query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}
}