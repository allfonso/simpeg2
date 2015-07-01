<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengadaan extends Admin_Controller
{
	public function __construct(){
		parent::__construct();		
		$model = array(
					'referensi/status_pegawai_model',
					'referensi/agama_model',
					'referensi/kedudukan_pegawai_model',
					'referensi/jenis_pegawai_model',
					'referensi/golongan_model',
					'referensi/unor_model',
					'referensi/status_rumah_model',
					'referensi/diklat_model',
					'referensi/pendidikan_model',
					'pegawai/pegawai_model',
					'pengadaan/pengadaan_model',
					'riwayat/riwayat_golongan_model',
					'riwayat/riwayat_jabatan_model',
					'riwayat/riwayat_diklat_model',
					'riwayat/riwayat_pendidikan_model',
					'riwayat/riwayat_jabatan_model'
				);
		$this->load->model( $model );
	}

	public function index()
	{
		// $data = array();
		// $data['jabatan'] = $this->anjab_model->getTreeOption($array = array(), $select = '', $name = 'parent_id');
		// $data['anjab'] = $this->anjab_model->getAnjabOrder();
		// $this->load->view('anjab/layout_add',$data);
		$data = array();
		$this->load->view('pengadaan/layout_pegawai_cpns',$data);
	}

	public function save()
	{
		// print_r($_POST);die;
		// return true;
		$response = array('status' => 0,'msg' => 'Gagal aktivasi pegawai');
		$post = $_POST;

		if( $this->input->post('current_nip') )
		{
			$save = $this->pengadaan_model->simpanDataPengangkatanPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data pegawai berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}

		echo json_encode($response);
		exit();
	}

	public function import()
	{
		// $data = array();
		// $data['jabatan'] = $this->anjab_model->getTreeOption($array = array(), $select = '', $name = 'parent_id');
		// $data['anjab'] = $this->anjab_model->getAnjabOrder();
		// $this->load->view('anjab/layout_add',$data);
		$data = array();
		$this->load->view('pengadaan/layout_import',$data);
	}

	public function saveimport()
	{
		$response = array("status" => 0, "msg" => "Gagal simpan data");

		include APPPATH."libraries/parsecsv.lib.php";
		// echo "<pre>";
		// print_r($_FILES);
		// echo "</pre>";

		if( isset($_FILES['inputFile']) && !empty($_FILES['inputFile']['name']) )
		{
			$files = $_FILES['inputFile'];
			$allowed_extension = array('csv');
			$extension = end( explode('.',strtolower( $files['name'] ) ) );

			if( in_array( $extension, $allowed_extension) )
			{
				$newname = date('YmdHis') . "_import_cpns.csv";
				if( move_uploaded_file( $files['tmp_name'], _ROOT . "files/import/$newname" ) )
				{
					if( file_exists(_ROOT . "files/import/$newname") )
					{
						$response = array("status" => 0, "msg" => "sukses simpan data");
						$destination = _ROOT . "files/import/$newname";
						$csv = new parseCSV();
						$data = $csv->auto($destination);

						$datashipping = array();

						foreach ((array)$csv->data as $index => $row) {
							
							$save = $this->pengadaan_model->simpanDataCPNSimport( $row );
							
						}

						$response = array("status" => 1, "msg" => "Sukses import file");
					}
				}
			} else {
				$response = array("status" => 0, "msg" => "Ekstensi file harus .csv");
			}
		}

		// echo "<pre>";
		// print_r($response);
		// echo "</pre>";
		echo json_encode($response);
		exit();
	}

	public function get_detail_pengadaan(){
		$response = array("status" => 0,"data" => array());
		if( isset($_POST['nip']) && !empty($_POST['nip']) )
		{
			$nip = trim($_POST['nip']);
			$pegawai = $this->pengadaan_model->getDetailPengadaan( $nip );

			if( $pegawai ){
				$data['profil'] = $pegawai;				
			}
			$response = array("status" => 1,"data" => $data);
		}
		echo json_encode($response);
		exit();
	}
}