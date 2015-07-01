<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendidikan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getDataTingkatPendidikan()
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT TINGKAT_PENDIDIKAN_ID AS KODE, TINGKAT_PENDIDIKAN_NAMA AS NAMA FROM sp_tingkat_pendidikan",'all',600);
		foreach($query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function getNamaPendidikan( $id )
	{
		$query = "SELECT PENDIDIKAN_ID AS KODE, PENDIDIKAN_NAMA AS NAMA FROM sp_pendidikan WHERE TINGKAT_PENDIDIKAN_ID = '$id'";
		$result = $this->dbQueryCache($query,'all',3600);

		$arr = array();
		foreach((array)$result as $row) {
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function getStatusPendidikan()
	{
		$query = "SELECT STATUS_PENDIDIKAN_ID AS KODE, STATUS_PENDIDIKAN_NAMA AS NAMA FROM sp_status_pendidikan";
		$result = $this->dbQueryCache($query,'all',3600);

		$arr = array();
		foreach((array)$result as $row) {
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}
}