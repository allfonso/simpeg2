<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model( array('referensi_model','pegawai_model') );
	}

	public function index()
	{
		$data = array();
		$data['agama'] = $this->referensi_model->get_agama();
		$this->load->view('pegawai/grid_pegawai',$data);
	}

	public function get_data_pegawai()
	{
		$data = $this->pegawai_model->get_data_pegawai();
		$response = array('row'=>array(),'total'=>0);

		$array = array();
		if( $data )
		{
			foreach($data->result() as $row)
			{
				array_push($array,$row);
			}
			$response = array('rows'=>$array,'total'=>$data->num_rows());	
		}

		echo json_encode($response);
		exit();		
	}

	public function save()
	{
		$response = array('status'=>0,'msg'=>'Nothing saved');
		if( isset($_POST['nip']) )
		{
			$data['NIP'] = $this->input->post('nip');
			$data['NAMA'] = $this->input->post('nama',TRUE);
			$data['GELAR_DEPAN'] = $this->input->post('gelardepan',TRUE);
			$data['GELAR_BELAKANG'] = $this->input->post('gelarbelakang',TRUE);
			$data['GELAR_LAIN'] = $this->input->post('gelarlain',TRUE);
			$data['JENIS_KELAMIN'] = $this->input->post('gender',TRUE);
			$data['TEMPAT_LAHIR'] = $this->input->post('tempatlahir',TRUE);
			$data['TANGGAL_LAHIR'] = $this->input->post('tanggalahir',TRUE);
			$data['AGAMA_ID'] = $this->input->post('agama',TRUE);
			$data['ALAMAT'] = $this->input->post('alamat1',TRUE).' '.$this->input->post('alamat2',TRUE);
			$data['KODEPOS'] = $this->input->post('kodepos',TRUE);
			$data['NO_HANDPHONE'] = $this->input->post('handphone',TRUE);
			$data['NO_TELEPHONE'] = $this->input->post('telephone',TRUE);
			$data['NO_SK_CPNS'] = $this->input->post('noskcpns',TRUE);
			$data['TANGGAL_SK_CPNS'] = $this->input->post('tglskcpns',TRUE);
			$data['TMT_SK_CPNS'] = $this->input->post('tmtskcpns',TRUE);
			$data['TMT_SP_CPNS'] = $this->input->post('tmtspcpns',TRUE);
			$data['NO_NPWP'] = $this->input->post('nonpwp',TRUE);
			$data['TANGGAL_NPWP'] = $this->input->post('tanggalnpwp',TRUE);
			$data['NO_AKTA_LAHIR'] = $this->input->post('noaktalahir',TRUE);
			$data['NO_BPJS_KESEHATAN'] = $this->input->post('nobpjs',TRUE);
			$data['NO_IDENTITAS'] = $this->input->post('noidentitas',TRUE);
			$data['GOLONGAN_DARAH'] = $this->input->post('golongandarah',TRUE);
			$data['BERAT_BADAN'] = $this->input->post('beratbadan',TRUE);
			$data['TINGGI_BADAN'] = $this->input->post('tinggibadan',TRUE);
			$data['WARNA_KULIT'] = $this->input->post('warnakulit',TRUE);
			$data['STATUS_KEPEMILIKAN_RUMAH'] = $this->input->post('statuskepemilikanrumah',TRUE);

			if( isset($_FILES['photo']) && $_FILES['photo']['name'] != '' )
			{
				$files = $_FILES['photo'];
				$nip = trim($_POST['nip']);
				$time = date('YmdHis');
				$ext = end( explode(".",strtolower($files['name'])));

				if( !in_array($ext,array('jpg','jpeg','png','gif')) )
				{
					$response = array('status'=>0,'msg'=>'Ekstensi foto tidak diizinkan. Hanya gambar ber-ekstensi jpeg,jpg,png dan gif yang diperbolehkan');
					echo json_encode($response);
					exit();
				}

				$path = _ROOT."files/pegawai/";
				$newname = "$nip_$time.$ext";

				if( move_uploaded_file($files['tmp_name'], $path.$newname) ){
					$data['PHOTO'] = $newname;
				}
			}

			$simpan = $this->pegawai_model->simpan_pegawai($data);
			if( $simpan )
			{
				$response = array('status'=>1,'msg'=>'Data pegawai berhasil disimpan');
			}else{
				$response = array('status'=>0,'msg'=>'Data pegawai gagal disimpan');
			}

			echo json_encode($response);
			exit();
			
		}
	}
}