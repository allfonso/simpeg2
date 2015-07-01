<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengadaan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	/**
	Simpan data pengangkatan
	*/
	# Simpan data pegawai
	public function simpanDataPengangkatanPegawai( $post, $nip = null )
	{
		$setangkat = FALSE;
		$success = FALSE;
		if( $post )
		{
			$this->db->trans_begin();

			if (!empty($post['inputNoSuratSehat']) && !empty($post['inputTglSuratSehat'])) {
				$datesuratsehat = date("Y-m-d",strtotime($post['inputTglSuratSehat']));
				// update ke sp_pegawai no dan tanggal surat sehat
				$this->db->set( 'NO_SURAT_SEHAT',$post['inputNoSuratSehat'] );
				$this->db->set( 'TGL_SURAT_SEHAT',$datesuratsehat);
				$this->db->where( 'NIP', $post['current_nip'] );
				$this->db->update('sp_pegawai');

				$setangkat = TRUE;
			} else {
				$setangkat = FALSE;
			}

			if (!empty($post['inputNoSuratPrajab']) && !empty($post['inputTglSuratPrajab'])) {
				$dateprajab = date("Y-m-d",strtotime($post['inputTglSuratPrajab']));

				//cek udah pernah diisi blm
				$querydiklat = "SELECT RIWAYAT_DIKLAT_ID FROM sp_riwayat_diklat WHERE NIP = '".$post['current_nip']."' AND PENGANGKATAN_CPNS = 1";
				$datadiklat = $this->dbQueryCache($querydiklat, 'row', 100);
				
				if (empty($datadiklat)) {
					//insert ke riwayat diklat -> sp_riwayat_diklat
					$this->db->set( 'TANGGAL_MULAI',$dateprajab );
					$this->db->set( 'TANGGAL_SELESAI',$dateprajab );
					$this->db->set( 'NOMOR_SERTIFIKAT',$post['inputNoSuratPrajab']);
					$this->db->set( 'NIP', $post['current_nip'] );
					$this->db->set( 'PENGANGKATAN_CPNS',1 );
					$this->db->insert('sp_riwayat_diklat');
				}
				$setangkat = TRUE;
			} else {
				$setangkat = FALSE;
			}

			// insert ke riwayat golongan -> sp_riwayat_golongan
			// cari data pegawai dulu
			$query = "SELECT * FROM sp_pegawai WHERE nip = '".$post['current_nip']."'";
			$run = $this->dbQueryCache($query,'row',300);

			if (!empty($post['inputSKPengangkatan']) && !empty($post['inputTglSKPengangkatan']) && !empty($post['inputTMTPengangkatan'])) {
				
				//cek udah pernah diisi blm
				$querygol = "SELECT 	RIWAYAT_GOLONGAN_ID FROM sp_riwayat_golongan WHERE NIP = '".$post['current_nip']."' AND PENGANGKATAN_CPNS = 1";
				$datagolongan = $this->dbQueryCache($querygol, 'row', 100);

				if (empty($datagolongan)) {		
					$this->db->set( 'NIP', $post['current_nip'] );
					$this->db->set( 'NOMOR_SK', $post['inputSKPengangkatan'] );
					$this->db->set( 'KODE_JENIS_KP', '211' );
					$this->db->set( 'TANGGAL_SK', mysql_date($post['inputTglSKPengangkatan']) );
					// $this->db->set( 'GOLONGAN_ID', mysql_date($run['CPNS_GOLONGAN_ID']) );
					$this->db->set( 'GOLONGAN_ID', $run['CPNS_GOLONGAN_ID'] );
					$this->db->set( 'TMT_GOLONGAN', mysql_date($post['inputTMTPengangkatan']) );
					$this->db->set( 'INSERTDATE','NOW()',FALSE );
					$this->db->set( 'PENGANGKATAN_CPNS',1 );
								
					$this->db->set( 'INSERTDATE','NOW()',FALSE );
					$insert = $this->db->insert('sp_riwayat_golongan');
				}	
				$setangkat = TRUE;
			} else {
				$setangkat = FALSE;
			}

			if( $setangkat === TRUE )
			{
				// update cpns jadi pns
				$this->db->set( 'STATUS_PEGAWAI',2 );	
				$this->db->set( 'KEDUDUKAN_ID','01' );				
				$this->db->where( 'NIP', $post['current_nip'] );
				$this->db->update('sp_pegawai');
			}
			
			
			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			}
		}
		return $success;
	}

	public function getDetailPengadaan( $nip = null )
	{		
		if( $nip )
		{
			$query = $this->dbQueryCache("
				SELECT peg.NIP AS NIP,
					   peg.NIP_LAMA AS NIP_LAMA,
					   peg.NAMA_PEGAWAI AS NAMA_PEGAWAI,
					   peg.NO_SURAT_SEHAT AS NO_SURAT_SEHAT,
					   DATE_FORMAT(peg.TGL_SURAT_SEHAT,'%d/%m/%Y') AS TGL_SURAT_SEHAT
				FROM sp_pegawai peg				
				WHERE peg.NIP = '$nip'","row");

			// cari data riwayat golongan
			$qgol = $this->dbQueryCache("
				SELECT DATE_FORMAT(gol.TMT_GOLONGAN,'%d/%m/%Y') AS TMT_GOLONGAN,
					   gol.NOMOR_SK AS NOMOR_SK,
					   DATE_FORMAT(gol.TANGGAL_SK,'%d/%m/%Y') AS TANGGAL_SK
					   
				FROM sp_riwayat_golongan gol				
				WHERE gol.NIP = '$nip' AND gol.PENGANGKATAN_CPNS = 1","row");

			// cari data riwayat golongan
			$qdiklat = $this->dbQueryCache("
				SELECT DATE_FORMAT(dik.TANGGAL_SELESAI,'%d/%m/%Y') AS TANGGAL_SELESAI,
					   dik.NOMOR_SERTIFIKAT AS NOMOR_SERTIFIKAT
					   
				FROM sp_riwayat_diklat dik				
				WHERE dik.NIP = '$nip' AND dik.PENGANGKATAN_CPNS = 1","row");
			

			if (isset($query['TGL_SURAT_SEHAT']) && $query['TGL_SURAT_SEHAT'] == '00/00/0000') {
				$query['TGL_SURAT_SEHAT'] = '';
			}

			if (isset($qdiklat['TANGGAL_SELESAI']) && $qdiklat['TANGGAL_SELESAI'] == '00/00/0000') {
				$qdiklat['TANGGAL_SELESAI'] = '';
			}

			if (isset($qgol['TMT_GOLONGAN']) && $qgol['TMT_GOLONGAN'] == '00/00/0000') {
				$qgol['TMT_GOLONGAN'] = '';
			}

			if (isset($qgol['TANGGAL_SK']) && $qgol['TANGGAL_SK'] == '00/00/0000') {
				$qgol['TANGGAL_SK'] = '';
			}


		}

		return $query;
	}

	public function simpanDataCPNSimport($row)
	{
		//simpan ke sp_pegawai dulu
		//cek sudah ada nip itu blm
		$arragama = array("islam" => 1
						 ,"katholik" => 2
						 ,"kristen" => 3
						 ,"hindu" => 4
						 ,"budha" => 5
						 ,"lainya" => 6);

		$nip = trim($row['NIP']);
		$status_pegawai = 1;	// CPNS
		$nama = trim($row['NAMA LENGKAP']);
		$tempatlahir = trim($row['TEMPAT LAHIR']);
		$tanggallahir = date("Y-m-d",strtotime($row['TANGGAL LAHIR']));
		$jeniskelamin = trim($row['JENIS KELAMIN (PRIA/WANITA)']);
		if (strtolower($jeniskelamin) == 'pria') {
			$kelamin = 1;
		} else {
			$kelamin = 2;
		}
		$rowagama = strtolower(trim($row['AGAMA']));
		$agama = $arragama[$rowagama];
		$noktp = trim($row['NO KTP']);
		$alamat = trim($row['ALAMAT']);
		$statuskawin = trim($row['STATUS PERKAWINAN']);
		$rowgolongan = trim($row['GOLONGAN RUANG']);

		// cari golongan ruangan
		$qruang = $this->dbQueryCache("
				SELECT GOLONGAN_ID
				FROM sp_golongan				
				WHERE GOLONGAN_KODE = '$rowgolongan'","row");
		$golongan = $qruang['GOLONGAN_ID'];
		$noskcpns = $row['NO SK CPNS'];
		$tglskcpns = date("Y-m-d",strtotime($row['TGL SK CPNS']));
		$tmtskcpns = date("Y-m-d",strtotime($row['BERLAKU TMT']));



		$this->db->where( 'NIP', $nip );
		$result = $this->db->get( 'sp_pegawai' );

		if( $result->num_rows() <= 0 ){
			$this->db->set( 'NIP', $nip );
			$this->db->set( 'GELAR_DEPAN', '' );
			$this->db->set( 'GELAR_BELAKANG', '' );
			$this->db->set( 'GELAR_LAIN', '' );
			$this->db->set( 'NAMA_PEGAWAI', $nama );
			$this->db->set( 'JENIS_KELAMIN', $kelamin );
			$this->db->set( 'AGAMA_ID', $agama );
			$this->db->set( 'TEMPAT_LAHIR', $tempatlahir );
			$this->db->set( 'TANGGAL_LAHIR',$tanggallahir );
			$this->db->set( 'ALAMAT',$alamat );
			$this->db->set( 'KEDUDUKAN_ID','01' );	
			$this->db->set( 'STATUS_PEGAWAI',$status_pegawai );
			$this->db->set( 'NO_IDENTITAS',$noktp );
			$this->db->set( 'NO_SK_CPNS',$noskcpns );
			$this->db->set( 'TANGGAL_SK_CPNS',$tglskcpns );
			$this->db->set( 'TMT_SK_CPNS',$tmtskcpns );
			$this->db->set( 'CPNS_GOLONGAN_ID',$golongan );
			$this->db->set( 'IS_IMPORT',1 );
			
			$insert = $this->db->insert('sp_pegawai');

			// insert ke riwayat pendidikan
			$rowtktpend = trim($row['TKT PENDIDIKAN']);
			// cari tingkat pendidikan
			$qtkpend = $this->dbQueryCache("
					SELECT TINGKAT_PENDIDIKAN_ID
					FROM sp_tingkat_pendidikan	
					WHERE TINGKAT_PENDIDIKAN_NAMA = '$rowtktpend'","row");
			$tktpend = $qtkpend['TINGKAT_PENDIDIKAN_ID'];

			// cari pendidikan
			$rowpend = trim($row['IJAZAH/STTB JENJANG PENDIDIKAN']);
			$qpend = $this->dbQueryCache("
					SELECT PENDIDIKAN_ID
					FROM sp_pendidikan	
					WHERE PENDIDIKAN_NAMA = '$rowpend'","row");
			if (empty($qpend) ){
				// insert ke sp pendidikan
				$pendid = md5($rowpend);
				$this->db->set( 'PENDIDIKAN_ID',$pendid );
				$this->db->set( 'PENDIDIKAN_NAMA',$rowpend );
				
				$insert = $this->db->insert('sp_pendidikan');
			} else {
				$pendid = $qpend['PENDIDIKAN_ID'];
			}

			$tgllulus = date("Y-m-d",strtotime($row['TGL TAHUN LULUS']));
			$thnlulus = date("Y",strtotime($row['TGL TAHUN LULUS']));
			$noijazah = trim($row['NO IJAZAH']);

			// insert ke sp_riwayat_pendidikan
			$this->db->set( 'NIP',$nip );
			$this->db->set( 'TINGKAT_PENDIDIKAN_ID',$tktpend );
			$this->db->set( 'PENDIDIKAN_ID',$pendid );
			$this->db->set( 'TANGGAL_LULUS',$tgllulus );
			$this->db->set( 'TAHUN_LULUS',$thnlulus );
			$this->db->set( 'NOMOR_IJAZAH',$noijazah );
			$this->db->set( 'IS_IMPORT',1 );
			
			$insert = $this->db->insert('sp_riwayat_pendidikan');

			// insert ke riwayat jabatan
			// cari instansi_id/satuan kerja
			$rowsatker = trim($row['SATUAN KERJA']);
			$qsatker = $this->dbQueryCache("
					SELECT INSTANSI_ID
					FROM sp_instansi	
					WHERE INSTANSI_NAMA = '$rowsatker'","row");
			if (empty($qsatker)) {
				// insert ke sp pendidikan
				$instansiid = md5($rowsatker);
				$this->db->set( 'INSTANSI_ID',$instansiid );
				$this->db->set( 'INSTANSI_NAMA',$rowsatker );
				
				$insert = $this->db->insert('sp_instansi');
			} else {
				$instansiid = $qsatker['INSTANSI_ID'];
			}

			// cari unit kerja/unor
			$rowunor = trim($row['UNIT KERJA']);
			$qsatker = $this->dbQueryCache("
					SELECT UNOR_ID
					FROM sp_unor	
					WHERE UNOR_NAMA = '$rowunor'","row");
			if (empty($qsatker)) {
				// insert ke sp pendidikan
				$unorid = md5($rowunor);
				$this->db->set( 'UNOR_ID',$unorid );
				$this->db->set( 'UNOR_NAMA',$rowunor );
				
				$insert = $this->db->insert('sp_unor');
			} else {
				$unorid = $qsatker['UNOR_ID'];
			}

			// cari jenjang jabatan
			$rowjabatan = trim($row['JABATAN CPNS']);
			$qjabatan = $this->dbQueryCache("
					SELECT JENJANG_JABATAN_ID
					FROM sp_jenjang_jabatan	
					WHERE NAMA_JENJANG_JABATAN = '$rowjabatan'","row");
			if (empty($qjabatan)) {
				// insert ke sp pendidikan
				$jabatanid = md5($rowjabatan);
				$this->db->set( 'JENJANG_JABATAN_ID',$jabatanid );
				$this->db->set( 'NAMA_JENJANG_JABATAN',$rowjabatan );
				
				$insert = $this->db->insert('sp_jenjang_jabatan');
			} else {
				$jabatanid = $qjabatan['JENJANG_JABATAN_ID'];
			}

			// insert riwayat_jabatan
			$this->db->set( 'NIP',$nip );
			$this->db->set( 'INSTANSI_ID',$instansiid );
			$this->db->set( 'UNOR_ID',$unorid );
			$this->db->set( 'JENJANG_JABATAN_ID',$jabatanid );
			$this->db->set( 'NOMOR_SK',$noskcpns );
			$this->db->set( 'TANGGAL_SK',$tglskcpns );
			$this->db->set( 'IS_IMPORT',1 );
			
			$insert = $this->db->insert('sp_riwayat_jabatan');

		}		
	}
	// [NIP] =&gt; 198510122015021001
 //            [STATUS PEGAWAI] =&gt; CPNS
 //            [NAMA LENGKAP] =&gt; YOHANES WAHYU HERMAWAN, A.Md.EM
 //            [TEMPAT LAHIR] =&gt; Semarang
 //            [TANGGAL LAHIR] =&gt; 12-10-1985
 //            [JENIS KELAMIN (PRIA/WANITA)] =&gt; Pria
 //            [AGAMA] =&gt; Katholik
 //            [NO KTP] =&gt; 3374151210850001
 //            [ALAMAT] =&gt; JL.CANDI MAS SELATAN III NO.179 RT.03 RW.07 KALIPANCUR NGALIYAN PASADENA SEMARANG 50183
 //            [STATUS PERKAWINAN] =&gt; Belum Kawin
 //            [GOLONGAN RUANG] =&gt; II/c
 //            [80% GAJI POKOK] =&gt; 1.654.480
 //            [TKT PENDIDIKAN] =&gt; Diploma III/Sarjana Muda
 //            [IJAZAH/STTB JENJANG PENDIDIKAN] =&gt; D-III Teknik Elektromedik
 //            [NO IJAZAH] =&gt; 006/2008
 //            [TGL TAHUN LULUS] =&gt; 10-10-2008
 //            [JABATAN CPNS] =&gt; Teknisi Elektromedis Pelaksana
 //            [SATUAN KERJA] =&gt; Pemerintah Provinsi D I Yogyakarta
 //            [UNIT KERJA] =&gt; Balai Laboratorium Kesehatan Dinas Kesehatan DIY
 //            [KPPN] =&gt; DPPKA
 //            [MASA KERJA GOLONGAN TAHUN] =&gt; 3
 //            [MASA KERJA GOLONGAN BULAN] =&gt; 0
 //            [NO SK CPNS] =&gt; 001/Pem.D/UP/K/D.2
 //            [TGL SK CPNS] =&gt; 06-04-2015
 //            [BERLAKU TMT] =&gt; 01-02-2015
}