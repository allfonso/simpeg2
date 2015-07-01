<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Referensi extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
	}

	public function load_unor_induk()
	{
		$arr = array();
		$unor = $this->application_model->getUnorInduk();
		foreach((array)$unor as $kode=>$nama){
			$arr[] = array('id' => $kode, 'text' => $nama);
		}
		echo json_encode($arr);
		exit();
	}

	public function load_unor_unit( $unorid = '' )
	{
		if( $unorid && $unorid != 'undefined' ){
			$unit = $this->application_model->getUnorUnit($unorid);
			foreach((array)$unit as $kode=>$nama){
				$arr[] = array('id' => $kode, 'text' => $nama);
			}
			echo json_encode($arr);
			exit();
		}
	}

	public function load_jenjang_jabatan()
	{
		$arr = array();
		$this->load->model('riwayat/riwayat_jabatan_model');
		$jenjang_jabatan = $this->riwayat_jabatan_model->getJenjangJabatan();
		foreach((array)$jenjang_jabatan as $kode=>$nama){
			$arr[] = array('id' => $kode, 'text' => $nama);
		}
		echo json_encode($arr);
		exit();
	}

	public function load_data_pendidikan( $id )
	{
		if( $id && $id != 'undefined' )
		{
			$arr = array();
			$this->load->model('riwayat/riwayat_pendidikan_model');
			$jenjang_jabatan = $this->riwayat_pendidikan_model->getNamaPendidikan( $id );
			foreach((array)$jenjang_jabatan as $kode=>$nama){
				$arr[] = array('id' => $kode, 'text' => $nama);
			}
			echo json_encode($arr);
			exit();
		}
	}

	public function load_jenjang_didik()
	{
		$arr = array();
		$this->load->model('referensi/jenjangdidik_model');
		$jenjang_didik = $this->jenjangdidik_model->get_jenjangdidik();
		foreach((array)$jenjang_didik as $kode=>$nama){
			$arr[] = array('id' => $kode, 'text' => $nama);
		}
		echo json_encode($arr);
		exit();
	}

}