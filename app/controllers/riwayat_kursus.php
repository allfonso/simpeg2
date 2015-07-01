<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_kursus extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_kursus_model');
	}

	public function load_data_riwayat_kursus()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_kursus_model->getRiwayatKursus( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_riwayat_kursus()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_kursus_model->getDetailRiwayatKursus( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function save_riwayat_kursus($nip)
	{
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_kursus_model->saveRiwayatKursus( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_kursus()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_kursus_model->deleteRiwayatKursus($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

}
