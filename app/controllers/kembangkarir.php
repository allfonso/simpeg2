<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kembangkarir extends Admin_Controller
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
					'riwayat/riwayat_golongan_model',
					'riwayat/riwayat_jabatan_model',
					'riwayat/riwayat_diklat_model',
					'riwayat/riwayat_pendidikan_model',
					'kembangkarir/kembangkarir_model'
				);
		$this->load->model( $model );
	}

	public function ijinbelajar()
	{
		$data = array();
		$data['agama'] = $this->agama_model->get_agama();
		$data['golongan'] = $this->golongan_model->get_golongan();
		$data['status_pegawai'] = $this->status_pegawai_model->get_status_pegawai();
		$data['kedudukan_pegawai'] = $this->kedudukan_pegawai_model->get_kedudukan_pegawai();
		$data['jenis_pegawai'] = $this->jenis_pegawai_model->get_jenis_pegawai();
		$data['unor'] = $this->unor_model->get_unor();
		$data['status_rumah'] = $this->status_rumah_model->get_status_rumah();
		$data['bulan'] = $this->kembangkarir_model->get_bulan();
		$this->load->view('kembangkarir/layout_grid',$data);
	}

	public function saveijinbelajar()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan ijin belajar');
		$post = $_POST;

		if( $this->input->post('current_ijin_nip') )
		{
			$save = $this->kembangkarir_model->simpanDataIjinBelajarPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data ijin belajar berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}

		echo json_encode($response);
		exit();
	}

	public function load_data_ijin_belajar()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->kembangkarir_model->getIjinBelajar( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_ijin_belajar()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('ijin_id') ){
			$result = $this->kembangkarir_model->getIjinBelajarById( $this->input->post('ijin_id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function edit_ijin_belajar()
	{
		$response = array('status'=>0,'data'=>array());
		$post = $_POST;

		if( $this->input->post('current_ijin_id') )
		{
			$save = $this->kembangkarir_model->simpanDataEditIjinBelajarPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data ijin belajar berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}

		echo json_encode($response);
		exit();
	}

	public function delete_ijin_belajar()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('ijin_id') ){
			$id = $this->input->post('ijin_id');
			$delete = $this->kembangkarir_model->deleteIjinBelajar($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

	public function get_data_ijin_belajar()
	{
		$search = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;

		if( $this->input->post('nip') ){
			$search['nip'] = $this->input->post('nip', true);;
		}

		if( $this->input->post('nama') ){
			$search['nama'] = $this->input->post('nama', true);;
		}

		if( $this->input->post('universitas') ){
			$search['universitas'] = $this->input->post('universitas', true);;
		}

		if( $this->input->post('bulanmulai') != '' && $this->input->post('tahunmulai') != '' ){
			$search['bulantahunmulai'] = $this->input->post('tahunmulai', true)."-".$this->input->post('bulanmulai');;
		}

		if( $this->input->post('bulanselesai') != '' && $this->input->post('tahunselesai') != '' ){
			$search['bulantahunselesai'] = $this->input->post('tahunselesai', true)."-".$this->input->post('bulanselesai');;
		}
		// print_r($search);
		$data = $this->kembangkarir_model->getDataijinBelajar($offset,$rows,$search);

		echo json_encode($data);
	}

	/**
	* IJIN LUAR NEGERI
	*/

	public function ijinluarnegri()
	{
		$data = array();
		$data['agama'] = $this->agama_model->get_agama();
		$data['golongan'] = $this->golongan_model->get_golongan();
		$data['status_pegawai'] = $this->status_pegawai_model->get_status_pegawai();
		$data['kedudukan_pegawai'] = $this->kedudukan_pegawai_model->get_kedudukan_pegawai();
		$data['jenis_pegawai'] = $this->jenis_pegawai_model->get_jenis_pegawai();
		$data['unor'] = $this->unor_model->get_unor();
		$data['status_rumah'] = $this->status_rumah_model->get_status_rumah();
		$data['bulan'] = $this->kembangkarir_model->get_bulan();
		$this->load->view('kembangkarir/layout_grid_ln',$data);
	}

	public function saveijinluarnegri()
	{
		$response = array('status' => 0,'msg' => 'Gagal simpan ijin belajar');
		$post = $_POST;

		if( $this->input->post('current_ln_nip') )
		{
			$save = $this->kembangkarir_model->simpanDataIjinLuarNegriPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data ijin luar negeri berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}

		echo json_encode($response);
		exit();
	}

	public function load_data_ijin_luar_negeri()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->kembangkarir_model->getIjinLuarNegeri( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_ijin_belajar_ln()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('ijin_id_ln') ){
			$result = $this->kembangkarir_model->getIjinLuarNegeriById( $this->input->post('ijin_id_ln') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function edit_ijin_luarnegeri()
	{
		$response = array('status'=>0,'data'=>array());
		$post = $_POST;

		if( $this->input->post('current_ijin_id_ln') )
		{
			$save = $this->kembangkarir_model->simpanDataEditIjinLuarNegeriPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data ijin luar negri berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}

		echo json_encode($response);
		exit();
	}

	public function delete_ijin_luarnegri()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('ijin_id_ln') ){
			$id = $this->input->post('ijin_id_ln');
			$delete = $this->kembangkarir_model->deleteIjinLuarNegeri($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}

	public function get_data_ijin_belajar_ln()
	{
		$search = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;

		if( $this->input->post('nip') ){
			$search['nip'] = $this->input->post('nip', true);;
		}

		if( $this->input->post('nama') ){
			$search['nama'] = $this->input->post('nama', true);;
		}

		if( $this->input->post('negara') ){
			$search['negara'] = $this->input->post('negara', true);;
		}

		if( $this->input->post('bulanberangkat') != '' && $this->input->post('tahunberangkat') != '' ){
			$search['bulantahunberangkat'] = $this->input->post('tahunberangkat', true)."-".$this->input->post('bulanberangkat');;
		}

		if( $this->input->post('bulanpulang') != '' && $this->input->post('tahunpulang') != '' ){
			$search['bulantahunpulang'] = $this->input->post('tahunpulang', true)."-".$this->input->post('bulanpulang');;
		}
		// print_r($search);
		$data = $this->kembangkarir_model->getDataIjinBelajarLn($offset,$rows,$search);

		echo json_encode($data);
	}

	/**
	* TUGAS BELAJAR
	*/
	public function tugasbelajar()
	{
		$data = array();
		$data['agama'] = $this->agama_model->get_agama();
		$data['golongan'] = $this->golongan_model->get_golongan();
		$data['status_pegawai'] = $this->status_pegawai_model->get_status_pegawai();
		$data['kedudukan_pegawai'] = $this->kedudukan_pegawai_model->get_kedudukan_pegawai();
		$data['jenis_pegawai'] = $this->jenis_pegawai_model->get_jenis_pegawai();
		$data['unor'] = $this->unor_model->get_unor();
		$data['status_rumah'] = $this->status_rumah_model->get_status_rumah();
		$data['bulan'] = $this->kembangkarir_model->get_bulan();
		$this->load->view('kembangkarir/layout_grid_tugas',$data);
	}	

	public function savetugasbelajar()
	{
		// print_r($_POST);
		$response = array('status' => 0,'msg' => 'Gagal simpan ijin belajar');
		$post = $_POST;

		if( $this->input->post('current_tugas_nip') )
		{
			$save = $this->kembangkarir_model->simpanDataTugasBelajarNegriPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data tugas belajar berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}
		echo json_encode($response);
		exit();
	}

	public function load_data_tugas_belajar()
	{
		if( $this->input->post('nip') )
		{
			$result = $this->kembangkarir_model->gettugasBelajar( $this->input->post('nip') );
			echo json_encode($result);
		}
		exit();
	}

	public function load_detail_tugas_belajar()
	{
		$response = array('status'=>0,'data'=>array());
		if( $this->input->post('tugas_id') ){
			$result = $this->kembangkarir_model->getTugasBelajarById( $this->input->post('tugas_id') );
			$response = array('status'=>1,'data'=>$result);
		}
		echo json_encode($response);
		exit();
	}

	public function edit_tugas_belajar()
	{
		$response = array('status'=>0,'data'=>array());
		$post = $_POST;

		if( $this->input->post('current_tugas_id') )
		{
			$save = $this->kembangkarir_model->simpanDataEditTugasBelajarPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data tugas belajar berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}

		echo json_encode($response);
		exit();
	}

	public function delete_tugas_belajar()
	{
		$response = array('status'=>0,'msg' => 'Data gagal dihapus');
		if( $this->input->post('ijin_tugas_id') ){
			$id = $this->input->post('ijin_tugas_id');
			$delete = $this->kembangkarir_model->deleteTugasBelajar($id);
			if($delete){
				$response = array('status'=>1,'msg' => 'Data berhasil dihapus');
			}
		}

		echo json_encode($response);
		exit();
	}


	public function load_nip()
	{
		$arrnip = array();
		$arrnip = $this->kembangkarir_model->get_all_nip();
		// foreach((array)$nip as $kode=>$nama){
		// 	$arr[] = array('id' => $kode, 'text' => $nama);
		// }
		echo json_encode($arrnip);
		exit();
	}

	public function load_nama_pegawai()
	{
		if( $this->input->post('niprec') ){
			$nama = $this->kembangkarir_model->get_nama_pegawai($this->input->post('niprec'));

			echo $nama;
		}
	}

	public function load_universitas()
	{
		$arruniv = array();
		$arruniv = $this->kembangkarir_model->get_universitas();
		// foreach((array)$nip as $kode=>$nama){
		// 	$arr[] = array('id' => $kode, 'text' => $nama);
		// }
		echo json_encode($arruniv);
		exit();
	}

	public function get_data_tugas_belajar()
	{
		$search = array();
		$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		$offset = ($page-1)*$rows;

		if( $this->input->post('nip') ){
			$search['nip'] = $this->input->post('nip', true);;
		}

		if( $this->input->post('nama') ){
			$search['nama'] = $this->input->post('nama', true);;
		}

		if( $this->input->post('universitas') ){
			$search['universitas'] = $this->input->post('universitas', true);;
		}

		if( $this->input->post('bulanmulai') != '' && $this->input->post('tahunmulai') != '' ){
			$search['bulantahunmulai'] = $this->input->post('tahunmulai', true)."-".$this->input->post('bulanmulai');;
		}

		if( $this->input->post('bulanselesai') != '' && $this->input->post('tahunselesai') != '' ){
			$search['bulantahunselesai'] = $this->input->post('tahunselesai', true)."-".$this->input->post('bulanselesai');;
		}
		// print_r($search);
		$data = $this->kembangkarir_model->getDataTugasBelajar($offset,$rows,$search);

		echo json_encode($data);
	}
}
?>