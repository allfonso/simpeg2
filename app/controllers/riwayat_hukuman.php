<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_hukuman extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_hukuman_model');
	}

	public function load_data_riwayat_hukuman()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_hukuman_model->getRiwayatHukuman( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_riwayat_hukuman()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_hukuman_model->getDetailRiwayatHukuman( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function save_riwayat_hukuman($nip)
	{
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_hukuman_model->saveRiwayatHukuman( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_hukuman()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_hukuman_model->deleteRiwayatHukuman($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

}
