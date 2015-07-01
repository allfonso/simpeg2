<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_penghargaan extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_penghargaan_model');
	}

	public function load_data_riwayat_penghargaan()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_penghargaan_model->getRiwayatPenghargaan( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_riwayat_penghargaan()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_penghargaan_model->getDetailRiwayatPenghargaan( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function save_riwayat_penghargaan($nip)
	{
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_penghargaan_model->saveRiwayatPenghargaan( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_penghargaan()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_penghargaan_model->deleteRiwayatPenghargaan($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

}
