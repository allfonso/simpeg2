<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_angka_kredit extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model('riwayat/riwayat_angka_kredit_model');
	}

	public function load_data_riwayat_angka_kredit()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->riwayat_angka_kredit_model->getRiwayatAngkaKredit( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_riwayat_angka_kredit()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('id') ){
			$result = $this->riwayat_angka_kredit_model->getDetailRiwayatAngkaKredit( $this->input->post('id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function save_riwayat_angka_kredit($nip)
	{
		$response = array('status'=>0,'msg' => 'Data gagal disimpan');
		$_POST['nip'] = $nip;
		$save = $this->riwayat_angka_kredit_model->saveRiwayatAngkaKredit( $_POST );
		if($save){
			$response = array('status'=>1,'msg' => 'Data berhasil disimpan');
		}
		echo json_encode($response);
		exit();
	}

	public function delete_riwayat_angka_kredit()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('id') ){
			$id = $this->input->post('id');
			$delete = $this->riwayat_angka_kredit_model->deleteRiwayatAngkaKredit($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

}
