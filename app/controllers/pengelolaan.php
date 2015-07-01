<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengelolaan extends Admin_Controller
{
	public function __construct(){
		parent::__construct();
		$model = array(
					'riwayat/riwayat_jabatan_model',
					'pengelolaan/pengelolaan_model'				
				);
		$this->load->model( $model );
	}
	
	public function jabatan()
	{
		$data = array();
		$data['agama'] = $this->riwayat_jabatan_model->getJenjangJabatan();		
		$this->load->view('pengelolaan/layout_grid_jabatan',$data);
	}

	public function get_data_jenjang_jabatan()
	{		
		$search = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;

		if( $this->input->post('jabatan') ){
			$search['jabatan'] = $this->input->post('jabatan', true);;
		}

		
		$data = $this->pengelolaan_model->getDataJenjangJabatan($offset,$rows,$search);

		echo json_encode($data);
	}

	public function load_jabatan()
	{
		$arrjab = array();
		$arrjab = $this->pengelolaan_model->get_all_jabatan();

		echo json_encode($arrjab);
		exit();
	}

	public function savejabatan()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan jabatan');
		$post = $_POST;

		if( $this->input->post('inputJenisJabatan') )
		{
			$save = $this->pengelolaan_model->simpanDataJabatan( $post );
			if( $save['success'] ){
				$response = array("status" => 1,"msg" => $save['msg']);
			}else{
				$response = array("status" => 0,"msg" => $save['msg']);
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function saveeditjabatan()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan jabatan');
		$post = $_POST;

		if( $this->input->post('inputJenisJabatan') )
		{
			$save = $this->pengelolaan_model->updateDataJabatan( $post );
			if( $save['success'] ){
				$response = array("status" => 1,"msg" => $save['msg']);
			}else{
				$response = array("status" => 0,"msg" => $save['msg']);
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function load_detail_jabatan()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('idjab') ){
			$result = $this->pengelolaan_model->getJabatanById( $this->input->post('idjab') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function delete_jabatan()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('idjab') ){
			$id = $this->input->post('idjab');
			$delete = $this->pengelolaan_model->deletejabatan($id);
			if($delete['success']){
				$response = array('status'=>1,'msg' => $delete['msg']);
			} else {
				$response = array('status'=>0,'msg' => $delete['msg']);
			}
		}

		echo json_encode($response);
		exit();
	}

	public function get_data_delete_jabatan()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		if( $this->input->post('idjab') ){
			$idjab = $this->input->post('idjab');
			$data = $this->pengelolaan_model->getDataJabatanByDelete($offset,$rows,$idjab);
		}		

		echo json_encode($data);
	}

	/**
	* Pengelolaan UNOR
	*/

	public function unor()
	{
		$data = array();
		$this->load->view('pengelolaan/layout_grid_unor',$data);
	}

	public function get_data_unor()
	{
		$search = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;

		if( $this->input->post('unor') ){
			$search['unor'] = $this->input->post('unor', true);;
		}

		
		$data = $this->pengelolaan_model->getDataUnor($offset,$rows,$search);

		echo json_encode($data);
	}

	public function load_instansi()
	{
		$arrunor = array();
		$arrunor = $this->pengelolaan_model->get_all_instansi();

		echo json_encode($arrunor);
		exit();
	}

	public function saveunor()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan unor');
		$post = $_POST;

		if( $this->input->post('inputNamaUnor') )
		{
			$save = $this->pengelolaan_model->simpanDataUnor( $post );
			if( $save['success'] ){
				$response = array("status" => 1,"msg" => $save['msg']);
			}else{
				$response = array("status" => 0,"msg" => $save['msg']);
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function load_detail_unor()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('idunor') ){
			$result = $this->pengelolaan_model->getUnorById( $this->input->post('idunor') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function saveeditunor()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan unor');
		$post = $_POST;

		if( $this->input->post('inputNamaUnor') )
		{
			$save = $this->pengelolaan_model->updateDataUnor( $post );
			if( $save['success'] ){
				$response = array("status" => 1,"msg" => $save['msg']);
			}else{
				$response = array("status" => 0,"msg" => $save['msg']);
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function delete_unor()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('idunor') ){
			$id = $this->input->post('idunor');
			$delete = $this->pengelolaan_model->deleteunor($id);
			if($delete['success']){
				$response = array('status'=>1,'msg' => $delete['msg']);
			} else {
				$response = array('status'=>0,'msg' => $delete['msg']);
			}
		}

		echo json_encode($response);
		exit();
	}

	public function get_data_delete_unor()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		if( $this->input->post('idunor') ){
			$idunor = $this->input->post('idunor');
			$data = $this->pengelolaan_model->getDataUnorByDelete($offset,$rows,$idunor);
		}		

		echo json_encode($data);
	}

	/**
	*	Pengelolaan  pendidikan
	*/

	public function pendidikan()
	{
		$data = array();
		$this->load->view('pengelolaan/layout_grid_pendidikan',$data);
	}

	public function get_data_pendidikan()
	{		
		$search = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;

		if( $this->input->post('pendidikan') ){
			$search['pendidikan'] = $this->input->post('pendidikan', true);;
		}

		
		$data = $this->pengelolaan_model->getDataPendidikan($offset,$rows,$search);

		echo json_encode($data);
	}

	public function load_tingkat_pendidikan()
	{
		$arrdidik = array();
		$arrdidik = $this->pengelolaan_model->get_all_tingkat_pendidikan();

		echo json_encode($arrdidik);
		exit();
	}

	public function savependidikan()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan jabatan');
		$post = $_POST;

		if( $this->input->post('inputNamaPendidikan') )
		{
			$save = $this->pengelolaan_model->simpanDataPendidikan( $post );
			if( $save['success'] ){
				$response = array("status" => 1,"msg" => $save['msg']);
			}else{
				$response = array("status" => 0,"msg" => $save['msg']);
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function load_detail_pendidikan()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('iddidik') ){
			$result = $this->pengelolaan_model->getPendidikanById( $this->input->post('iddidik') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function saveeditpendidikan()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan pendidikan');
		$post = $_POST;

		if( $this->input->post('inputNamaPendidikan') )
		{
			$save = $this->pengelolaan_model->updateDataPendidikan( $post );
			if( $save['success'] ){
				$response = array("status" => 1,"msg" => $save['msg']);
			}else{
				$response = array("status" => 0,"msg" => $save['msg']);
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function delete_pendidikan()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('iddidik') ){
			$id = $this->input->post('iddidik');
			$delete = $this->pengelolaan_model->deletependidikan($id);
			if($delete['success']){
				$response = array('status'=>1,'msg' => $delete['msg']);
			} else {
				$response = array('status'=>0,'msg' => $delete['msg']);
			}
		}

		echo json_encode($response);
		exit();
	}

	public function get_data_delete_pendidikan()
	{
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;
		if( $this->input->post('iddidik') ){
			$iddidik = $this->input->post('iddidik');
			$data = $this->pengelolaan_model->getDataPendidikanByDelete($offset,$rows,$iddidik);
		}		

		echo json_encode($data);
	}
}