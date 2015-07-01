<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends Admin_Controller
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
					'riwayat/riwayat_pendidikan_model'
				);
		$this->load->model( $model );
	}

	public function index()
	{
		$data = array();
		$data['agama'] = $this->agama_model->get_agama();
		$data['golongan'] = $this->golongan_model->get_golongan();
		$data['status_pegawai'] = $this->status_pegawai_model->get_status_pegawai();
		$data['kedudukan_pegawai'] = $this->kedudukan_pegawai_model->get_kedudukan_pegawai();
		$data['jenis_pegawai'] = $this->jenis_pegawai_model->get_jenis_pegawai();
		$data['unor'] = $this->unor_model->get_unor();
		$data['status_rumah'] = $this->status_rumah_model->get_status_rumah();
		$this->load->view('pegawai/layout_grid',$data);
	}

	public function cpns()
	{
		$data = array();
		$this->load->view('pegawai/layout_pegawai_cpns',$data);
	}

	public function pegawai_tidak_aktif()
	{
		$data = array();
		$this->load->view('pegawai/layout_pegawai_tidak_aktif',$data);
	}

	public function penjagaan_pensiun()
	{
		$data = array();
		$this->load->view('pegawai/layout_pegawai_penjagaan_pensiun',$data);
	}

	public function get_data_pegawai()
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

		$data = $this->pegawai_model->getDataPegawai($offset,$rows,$search);

		echo json_encode($data);
	}

	public function aktivasi_pegawai()
	{
		$response = array('status' => 0,'msg' => 'Gagal aktivasi pegawai');
		if( $this->input->post('id') )
		{
			$this->db->trans_begin();

			$this->db->set('IS_AKTIF','0');
			$this->db->where('RIWAYAT_PEMBERHENTIAN_ID', $this->input->post('id'));
			$update = $this->db->update('sp_riwayat_pemberhentian');

			if( $update && $this->db->trans_status() === TRUE ){
				$this->db->trans_commit();
				$response = array('status' => 1,'msg' => 'Aktivasi pegawai berhasil');
			}else{
				$this->db->trans_rollback();
				$response = array('status' => 0,'msg' => 'Gagal aktivasi pegawai');
			}
		}

		echo json_encode($response);
		exit();
	}

	public function load_pegawai_tidak_aktif()
	{
		$search['type'] = null;
		$search['key'] = null;

		if( $this->input->post('key') )
		{
			$search['type'] = $this->input->post('type', true);;
			$search['key'] = $this->input->post('key', true);;
		}

		$data = $this->pegawai_model->getDataPegawaiTidakAktif($search);

		$pegawai = array();
		foreach((array)$data as $row){
			$pegawai[] = $row;
		}

		$response = array('total' => count($pegawai), 'rows' => $pegawai);
		echo json_encode($response);
	}

	public function load_pegawai_cpns()
	{
		$search['type'] = null;
		$search['key'] = null;

		if( $this->input->post('key') )
		{
			$search['type'] = $this->input->post('type', true);;
			$search['key'] = $this->input->post('key', true);;
		}

		$data = $this->pegawai_model->getDataPegawaiCPNS($search);

		$pegawai = array();
		foreach((array)$data as $row){
			$pegawai[] = $row;
		}

		$response = array('total' => count($pegawai), 'rows' => $pegawai);
		echo json_encode($response);
	}

	public function load_pegawai_penjagaan_pensiun()
	{
		$search['type'] = null;
		$search['key'] = null;

		if( $this->input->post('key') )
		{
			$search['type'] = $this->input->post('type', true);;
			$search['key'] = $this->input->post('key', true);;
		}

		$data = $this->pegawai_model->getDataPegawaiPenjagaanPensiun($search);

		$pegawai = array();
		foreach((array)$data as $row){
			$pegawai[] = $row;
		}

		$response = array('total' => count($pegawai), 'rows' => $pegawai);
		echo json_encode($response);
	}

	public function get_detail_pegawai()
	{
		$response = array("status" => 0,"data" => array());
		if( isset($_POST['nip']) && !empty($_POST['nip']) )
		{
			$nip = trim($_POST['nip']);
			$pegawai = $this->pegawai_model->getDetailPegawai( $nip );
			if( $pegawai ){
				$data['profil'] = $pegawai;
				$data['riwayat_golongan'] = $this->riwayat_golongan_model->getRiwayatGolongan( $nip );
				$data['riwayat_jabatan'] = $this->riwayat_jabatan_model->getRiwayatJabatan( $nip );
				$data['riwayat_diklat'] = $this->riwayat_diklat_model->getRiwayatDiklat( $nip );
				$data['riwayat_pendidikan'] = $this->riwayat_pendidikan_model->getRiwayatPendidikan( $nip );
			}
			$response = array("status" => 1,"data" => $data);
		}
		echo json_encode($response);
		exit();
	}

	public function save()
	{
		$response = array("status" => 0, "msg" => "Gagal simpan data");		
		$post = $this->input->post();

		$post['user_id'] = $this->user_id();

		if( $post['mode'] == 'new' && $this->pegawai_model->cekNip( $post['inputNip'] ) ){
			$response = array("status" => 0,"msg" => "Gagal simpan data. Nomor NIP sudah digunakan. Silahkan ulangi.");
		}else{
			$post['inputPhoto'] = "";
			if( isset($_FILES['inputFoto']) && !empty($_FILES['inputFoto']['name']) )
			{
				if( isset($post['photoEdited']) && !empty($post['photoEdited']) )
				{
					if( file_exists(_ROOT."files/pegawai/".$post['photoEdited']) ){
						@unlink( _ROOT."files/pegawai/".$post['photoEdited'] );
					}
				}

				$files = $_FILES['inputFoto'];
				$allowed_extension = array('jpg','png','gif','jpeg');
				$extension = end( explode('.',strtolower( $files['name'] ) ) );

				if( in_array( $extension, $allowed_extension) )
				{
					$newname = trim($_POST['inputNip']) ."_". date('YmdHis') .".jpg";
					if( move_uploaded_file( $files['tmp_name'], _ROOT . "files/pegawai/$newname" ) )
					{
						if( file_exists(_ROOT . "files/pegawai/$newname") )
						{
							$this->load->library('image_moo');
							$this->image_moo->load(_ROOT . "files/pegawai/$newname")->resize(200,300)->save_pa(null,null,TRUE);
							$post['inputPhoto'] = $newname;
						}
					}
				}
			}

			$save = $this->pegawai_model->simpanDataPegawai( $post );
			if( $save ){
				$response = array("status" => 1,"msg" => "Data pegawai berhasil disimpan.");
			}else{
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}	
		}
		echo json_encode($response);
		exit();
	}
}