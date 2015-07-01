<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_jabatan extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_jabatan_model');
	}

	public function index(){

	}

	public function save_riwayat_jabatan( $nip ){
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_jabatan_model->saveRiwayatJabatan( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_jabatan()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_jabatan_model->deleteRiwayatJabatan($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

	public function load_detail_riwayat_jabatan()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_jabatan_model->getRiwayatJabatanById( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function load_data_riwayat_jabatan()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_jabatan_model->getRiwayatJabatan( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}
}