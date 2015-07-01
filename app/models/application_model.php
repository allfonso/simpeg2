<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Application_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getUnorInduk()
	{
		$query = "SELECT UNOR_ID AS KODE,TRIM(UNOR_NAMA) AS NAMA FROM sp_unor WHERE UNOR_INDUK = '1' ORDER BY ORDERBY, UNOR_NAMA";
		$result = $this->dbQueryCache($query,'all',3600);

		$arr = array();
		foreach((array)$result as $row) {
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function getUnorUnit( $unorid = '' )
	{
		$query = "SELECT UNOR_ID AS KODE,TRIM(UNOR_NAMA) AS NAMA FROM sp_unor WHERE DIATASAN_ID = '$unorid' ORDER BY ORDERBY, UNOR_NAMA";
		$result = $this->dbQueryCache($query,'all',3600);

		$arr = array();
		foreach((array)$result as $row) {
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function getPejabatPenetap()
	{
		$query = "SELECT PENETAP_ID AS KODE, PENETAP_NAMA AS NAMA FROM sp_penetap ORDER BY PENETAP_ID";
		$result = $this->dbQueryCache($query,'all',3600);

		$arr = array();
		foreach((array)$result as $row) {
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}
}