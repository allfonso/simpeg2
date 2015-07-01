<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_pendidikan extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_pendidikan_model');
	}

	public function load_data_riwayat_pendidikan()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_pendidikan_model->getRiwayatPendidikan( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function save_riwayat_pendidikan($nip)
	{
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_pendidikan_model->saveRiwayatPendidikan( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_pendidikan()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_pendidikan_model->deleteRiwayatPendidikan($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

	public function load_detail_riwayat_pendidikan()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_pendidikan_model->getDetailRiwayatPendidikan( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}
}