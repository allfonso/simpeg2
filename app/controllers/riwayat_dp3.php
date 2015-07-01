<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_dp3 extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_dp3_model');
	}

	public function load_data_riwayat_dp3()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_dp3_model->getRiwayatDP3( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_riwayat_dp3()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_dp3_model->getDetailRiwayatDP3( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function save_riwayat_dp3($nip)
	{
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_dp3_model->saveRiwayatDP3( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_dp3()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_dp3_model->deleteRiwayatDP3($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

}
