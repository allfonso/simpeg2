<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
		$this->load->library('DX_Auth');
	}

	# Get All data pegawai
	public function getDataPegawai( $offset = 10, $rows = 1, $search = array() )
	{
		$where = "";
		if( isset($search['nip']) && $search['nip'] != ''){
			$where .= " AND A.NIP = '" .$search['nip']. "'";
		}
		if( isset($search['nama']) && $search['nama'] != ''){
			$where .= " AND LOWER(A.NAMA_PEGAWAI) LIKE '%" .strtolower($search['nama']). "%' ";
		}

			// $sql = "SELECT
			// 			A.NIP
			// 			,A.NIP_LAMA
			// 			,A.GELAR_DEPAN
			// 			,A.GELAR_BELAKANG
			// 			,A.GELAR_LAIN
			// 			,A.TEMPAT_LAHIR
			// 			,A.TANGGAL_LAHIR
			// 			,A.NO_AKTA_LAHIR
			// 			,A.JENIS_KELAMIN
			// 			,A.AGAMA_ID
			// 			,A.ALAMAT
			// 			,A.KODEPOS
			// 			,A.NO_HANDPHONE
			// 			,A.NO_TELEPHONE
			// 			,A.NO_IDENTITAS
			// 			,A.GOLONGAN_DARAH
			// 			,A.BERAT_BADAN
			// 			,A.TINGGI_BADAN
			// 			,A.WARNA_KULIT
			// 			,A.NO_SK_CPNS
			// 			,A.TANGGAL_SK_CPNS
			// 			,A.TMT_SK_CPNS
			// 			,A.TMT_SPMT_CPNS
			// 			,A.NO_NPWP
			// 			,A.TANGGAL_NPWP
			// 			,A.NO_BPJS
			// 			,A.STATUS_KEPEMILIKAN_RUMAH
			// 			,A.PHOTO
			// 			,A.KEDUDUKAN_ID
			// 			,TRIM(CONCAT(A.GELAR_DEPAN,' ',A.NAMA_PEGAWAI,' ',A.GELAR_BELAKANG,' ',A.GELAR_LAIN)) AS NAMA
			// 			,B.GOLONGAN
			// 		FROM sp_pegawai A
			// 		INNER JOIN 
			// 		(
			// 			SELECT
			// 				t.NIP,
			// 				t.GOLONGAN_ID,
			// 				u.GOLONGAN_KODE,
			// 				u.GOLONGAN_NAMA,
			// 				CONCAT(u.GOLONGAN_KODE,' - ',u.GOLONGAN_NAMA) AS GOLONGAN,
			// 				MAX(t.RIWAYAT_GOLONGAN_ID)
			// 			FROM ( 
			// 					SELECT
			// 						p.NIP,
			// 						g.RIWAYAT_GOLONGAN_ID,
			// 						g.GOLONGAN_ID
			// 					FROM sp_pegawai p 
			// 					LEFT JOIN sp_riwayat_golongan g ON p.NIP = g.NIP
			// 				) t
			// 			LEFT JOIN sp_golongan u ON u.GOLONGAN_ID = t.GOLONGAN_ID
			// 			GROUP BY t.NIP
			// 		) B ON B.NIP = A.NIP
			// 		WHERE A.KEDUDUKAN_ID = '01' $where
			// 		ORDER BY A.NIP LIMIT $offset,$rows";

		$sql = "
			SELECT 
				A.*,
				CONCAT(C.GOLONGAN_KODE,' - ',C.GOLONGAN_NAMA) AS GOLONGAN,
				IFNULL(E.NAMA_JENJANG_JABATAN,'-') AS JABATAN,
				TRIM(G.UNOR_NAMA) AS INSTANSI,
				G.UNOR_ID,
				B.GOLONGAN_ID,
				CASE 
					WHEN A.PHOTO != '' THEN CONCAT('files/pegawai/',A.PHOTO) 
				ELSE ''
				END PHOTO_URL
			FROM (
				SELECT
					A.NIP
					,A.NAMA_PEGAWAI
					,A.NIP_LAMA
					,A.GELAR_DEPAN
					,A.GELAR_BELAKANG
					,A.GELAR_LAIN
					,A.TEMPAT_LAHIR
					,A.TANGGAL_LAHIR
					,DATE_FORMAT(A.TANGGAL_LAHIR,'%d-%m-%Y') AS TANGGAL_LAHIR_EDIT
					,A.NO_AKTA_LAHIR
					,A.JENIS_KELAMIN
					,A.AGAMA_ID
					,A.ALAMAT
					,A.KODEPOS
					,A.NO_HANDPHONE
					,A.NO_TELEPHONE
					,A.NO_IDENTITAS
					,A.GOLONGAN_DARAH
					,A.BERAT_BADAN
					,A.TINGGI_BADAN
					,A.WARNA_KULIT
					,A.NO_SK_CPNS
					,A.TANGGAL_SK_CPNS
					,DATE_FORMAT(A.TANGGAL_SK_CPNS,'%d-%m-%Y') AS TANGGAL_SK_CPNS_EDIT
					,A.TMT_SK_CPNS
					,DATE_FORMAT(A.TMT_SK_CPNS,'%d-%m-%Y') AS TMT_SK_CPNS_EDIT
					,A.TMT_SPMT_CPNS
					,DATE_FORMAT(A.TMT_SPMT_CPNS,'%d-%m-%Y') AS TMT_SPMT_CPNS_EDIT
					,A.NO_NPWP
					,A.TANGGAL_NPWP
					,DATE_FORMAT(A.TANGGAL_NPWP,'%d-%m-%Y') AS TANGGAL_NPWP_EDIT
					,A.NO_BPJS
					,A.STATUS_KEPEMILIKAN_RUMAH
					,A.PHOTO
					,A.KEDUDUKAN_ID
					,A.JENIS_PEGAWAI_ID
					,CASE WHEN A.KEDUDUKAN_ID = '00' THEN '1' ELSE '2' END STATUS_PEGAWAI
					,TRIM(CONCAT(A.GELAR_DEPAN,' ',A.NAMA_PEGAWAI,' ',A.GELAR_BELAKANG,' ',A.GELAR_LAIN)) AS NAMA
					,(SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = A.NIP ) AS MAX_GOLID
					,(SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = A.NIP ) AS MAX_JABID
					,(SELECT MAX(RIWAYAT_UNOR_ID) FROM sp_riwayat_unor WHERE NIP = A.NIP ) AS MAX_UNORID
				FROM sp_pegawai A
				WHERE A.KEDUDUKAN_ID = '01' 
			) A
			LEFT JOIN sp_riwayat_golongan B ON A.MAX_GOLID = B.RIWAYAT_GOLONGAN_ID
			LEFT JOIN sp_golongan C ON C.GOLONGAN_ID = B.GOLONGAN_ID

			LEFT JOIN sp_riwayat_jabatan D ON D.RIWAYAT_JABATAN_ID = A.MAX_JABID
			LEFT JOIN sp_jenjang_jabatan E ON E.JENJANG_JABATAN_ID = D.JENJANG_JABATAN_ID

			LEFT JOIN sp_riwayat_unor F ON F.RIWAYAT_UNOR_ID = A.MAX_UNORID
			LEFT JOIN sp_unor G ON G.UNOR_ID = F.UNOR_ID

			WHERE A.KEDUDUKAN_ID = '01' AND STATUS_PEGAWAI = 2	$where GROUP BY A.NIP ORDER BY A.NIP LIMIT $offset,$rows";

		$query = $this->dbQueryCache( $sql,"all",10);
		$total = $this->getCountPegawai($search);

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => $total, 'rows' => $data);		
	}

	public function getCountPegawai( $search )
	{
		$where = "";
		if( isset($search['nip']) && $search['nip'] != ''){
			$where .= " AND A.NIP = '" .$search['nip']. "'";
		}
		if( isset($search['nama']) && $search['nama'] != ''){
			$where .= " AND LOWER(A.NAMA_PEGAWAI) LIKE '%" .strtolower($search['nama']). "%' ";
		}

		$sql = "SELECT 
					COUNT(*) AS TOTAL
				FROM (
					SELECT
						A.NIP,
						A.NAMA_PEGAWAI,
						COUNT(*) AS TOTAL,
						A.KEDUDUKAN_ID
						,(SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = A.NIP ) AS MAX_GOLID
						,(SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = A.NIP ) AS MAX_JABID
						,(SELECT MAX(RIWAYAT_UNOR_ID) FROM sp_riwayat_unor WHERE NIP = A.NIP ) AS MAX_UNORID
					FROM sp_pegawai A
					WHERE A.KEDUDUKAN_ID = '01' $where GROUP BY A.NIP ORDER BY A.NIP
				) A
				LEFT JOIN sp_riwayat_golongan B ON A.MAX_GOLID = B.RIWAYAT_GOLONGAN_ID
				LEFT JOIN sp_golongan C ON C.GOLONGAN_ID = B.GOLONGAN_ID

				LEFT JOIN sp_riwayat_jabatan D ON D.RIWAYAT_JABATAN_ID = A.MAX_JABID
				LEFT JOIN sp_jenjang_jabatan E ON E.JENJANG_JABATAN_ID = D.JENJANG_JABATAN_ID

				LEFT JOIN sp_riwayat_unor F ON F.RIWAYAT_UNOR_ID = A.MAX_UNORID
				LEFT JOIN sp_unor G ON G.UNOR_ID = F.UNOR_ID

				WHERE A.KEDUDUKAN_ID = '01'	$where ";
		return $this->dbQueryCache($sql,'one',300);
	}

	# Get All data pegawai yang sedang berkedudukan penjagaan pensiun
	public function getDataPegawaiPenjagaanPensiun( $search = array() )
	{
		$where = "";
		if( $search['key'] ){
			if( $search['type'] == 'nip' ){
				$where .= " AND peg.NIP = '" .$search['key']. "'";
			}
			if( $search['type'] == 'nama' ){
				$where .= " AND LOWER(peg.NAMA_PEGAWAI) LIKE '%" .strtolower($search['key']). "%' ";
			}
		}

		$query = $this->dbQueryCache("
					SELECT
						peg.NIP,
						TRIM(CONCAT(peg.GELAR_DEPAN,' ',peg.GELAR_LAIN,' ', UPPER(peg.NAMA_PEGAWAI),' ', peg.GELAR_BELAKANG)) AS NAMA,
						gol.NAMA_GOLONGAN AS GOLONGAN,
						jab.INSTANSI AS INSTANSI,
						jab.JABATAN AS JABATAN
					FROM sp_pegawai peg
					LEFT JOIN ( SELECT
									srg.NIP,
									CONCAT(sg.GOLONGAN_KODE,' - ',sg.GOLONGAN_NAMA) AS NAMA_GOLONGAN
								FROM sp_riwayat_golongan srg 
								LEFT JOIN sp_golongan sg ON sg.GOLONGAN_ID = srg.GOLONGAN_ID
								WHERE srg.RIWAYAT_GOLONGAN_ID = (SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = srg.NIP )
							) gol ON gol.NIP = peg.NIP
					LEFT JOIN (	SELECT
									srj.NIP,
									TRIM(su.UNOR_NAMA) AS INSTANSI,
									su.UNOR_NAMA_JABATAN AS JABATAN
								FROM sp_riwayat_jabatan srj
								LEFT JOIN sp_unor su ON srj.UNOR_ID = su.UNOR_ID
								WHERE srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = srj.NIP )
							) jab ON jab.NIP = peg.NIP
					WHERE peg.KEDUDUKAN_ID = '20' $where ORDER BY peg.NAMA_PEGAWAI ASC","all",10);
		$data = array();
		foreach((array)$query as $row){
			$data[$row['NIP']] = $row;
		}
		return $data;		
	}

	# Get All data pegawai
	public function getDataPegawaiCPNS( $search = array() )
	{
		$where = "";
		if( $search['key'] ){
			if( $search['type'] == 'nip' ){
				$where .= " AND peg.NIP = '" .$search['key']. "'";
			}
			if( $search['type'] == 'nama' ){
				$where .= " AND LOWER(peg.NAMA_PEGAWAI) LIKE '%" .strtolower($search['key']). "%' ";
			}
		}

		$query = $this->dbQueryCache("
					SELECT
						peg.NIP,
						TRIM(CONCAT(peg.GELAR_DEPAN,' ',peg.GELAR_LAIN,' ', UPPER(peg.NAMA_PEGAWAI),' ', peg.GELAR_BELAKANG)) AS NAMA,
						CASE 
							WHEN peg.JENIS_KELAMIN = '1' THEN 'Laki-laki'
						ELSE 'Perempuan'
						END JENIS_KELAMIN,
						CONCAT(peg.TEMPAT_LAHIR,', ',DATE_FORMAT(peg.TANGGAL_LAHIR,'%d-%m-%Y') ) AS TEMPAT_TANGGAL_LAHIR,
						peg.ALAMAT,
						CONCAT(gol.GOLONGAN_KODE,' - ',gol.GOLONGAN_NAMA) AS GOLONGAN
					FROM sp_pegawai peg
					LEFT JOIN sp_golongan gol ON gol.GOLONGAN_ID = peg.CPNS_GOLONGAN_ID

					WHERE peg.STATUS_PEGAWAI = '1' $where ORDER BY peg.NAMA_PEGAWAI ASC","all",10);
		$data = array();
		foreach((array)$query as $row){
			$data[$row['NIP']] = $row;
		}
		return $data;		
	}

	# Get detail data pegawai
	public function getDetailPegawai( $nip = null )
	{
		if( $nip )
		{
			$query = $this->dbQueryCache("
				SELECT
					peg.NIP,
					peg.NIP_LAMA,
					TRIM(CONCAT(peg.GELAR_DEPAN,' ',peg.GELAR_LAIN,' ', UPPER(peg.NAMA_PEGAWAI),' ', peg.GELAR_BELAKANG)) AS NAMA,
					gol.NAMA_GOLONGAN AS GOLONGAN,
					jab.INSTANSI AS INSTANSI,
					jab.JABATAN AS JABATAN,
					DATE_FORMAT(peg.TMT_SK_CPNS,'%d/%m/%Y') AS TMT_CPNS,
					CASE 
						WHEN jabs.TMT_JABATAN_STRUKTURAL IS NULL THEN '-'
						ELSE DATE_FORMAT(jabs.TMT_JABATAN_STRUKTURAL,'%d/%m/%Y')
					END TMT_JABATAN_STRUKTURAL,
					CASE 
						WHEN jabs.JABATAN_STRUKTURAL IS NULL THEN '-'
						ELSE jabs.JABATAN_STRUKTURAL
					END JABATAN_STRUKTURAL,
					CASE 
						WHEN jabf.TMT_JABATAN_FUNGSIONAL IS NULL THEN '-'
						ELSE DATE_FORMAT(jabf.TMT_JABATAN_FUNGSIONAL,'%d/%m/%Y')
					END TMT_JABATAN_FUNGSIONAL,
					CASE 
						WHEN jabf.JABATAN_FUNGSIONAL IS NULL THEN '-'
						ELSE jabf.JABATAN_FUNGSIONAL
					END JABATAN_FUNGSIONAL,
					DATE_FORMAT(pns.TMT_JABATAN_PNS,'%d/%m/%Y') AS TMT_PNS,
					DATE_FORMAT(peg.TMT_SK_CPNS,'%d/%m/%Y') AS TMT_CPNS,
					CONCAT(peg.TEMPAT_LAHIR,', ',DATE_FORMAT(peg.TANGGAL_LAHIR,'%d/%m/%Y')) AS TEMPAT_TANGGAL_LAHIR,
					CASE 
						WHEN peg.JENIS_KELAMIN = '1' THEN 'Laki-laki'
					ELSE 'Perempuan'
					END JENIS_KELAMIN,
					spa.AGAMA_NAMA AS AGAMA,
					unor.UNOR,
					unor.UNIT,
					unor.SUBUNIT,
					peg.ALAMAT,
					peg.PHOTO
				FROM sp_pegawai peg
				LEFT JOIN sp_agama spa ON spa.AGAMA_ID = peg.AGAMA_ID
				LEFT JOIN 
				(
					SELECT
						sru.NIP,
						TRIM(su1.UNOR_NAMA) AS UNOR,
						TRIM(su2.UNOR_NAMA) AS UNIT,
						TRIM(su3.UNOR_NAMA) AS SUBUNIT,
						DATE_FORMAT(sru.TANGGAL_SK,'%d/%m/%Y') AS TANGGAL_SK,
						sru.NOMOR_SK
					FROM sp_riwayat_unor sru 
					LEFT JOIN sp_unor su1 ON su1.UNOR_ID = sru.UNOR_ID
					LEFT JOIN sp_unor su2 ON su2.UNOR_ID = sru.UNIT_ID
					LEFT JOIN sp_unor su3 ON su3.UNOR_ID = sru.SUBUNIT_ID
					WHERE sru.RIWAYAT_UNOR_ID = (SELECT MAX(RIWAYAT_UNOR_ID) FROM sp_riwayat_unor WHERE NIP = '$nip' ) 
				) unor ON unor.NIP = peg.NIP
				LEFT JOIN 
				( 
					SELECT
						srg.NIP,
						CONCAT(sg.GOLONGAN_KODE,' - ',sg.GOLONGAN_NAMA) AS NAMA_GOLONGAN
					FROM sp_riwayat_golongan srg 
					LEFT JOIN sp_golongan sg ON sg.GOLONGAN_ID = srg.GOLONGAN_ID
					WHERE srg.RIWAYAT_GOLONGAN_ID = (SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = '$nip' )
				) gol ON gol.NIP = peg.NIP
				LEFT JOIN 
				(	
					SELECT
						srj.NIP,
						TRIM(su.UNOR_NAMA) AS INSTANSI,
						su.UNOR_NAMA_JABATAN AS JABATAN
					FROM sp_riwayat_jabatan srj
					LEFT JOIN sp_unor su ON srj.UNOR_ID = su.UNOR_ID
					WHERE srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = '$nip' )
				) jab ON jab.NIP = peg.NIP
				LEFT JOIN
				(
					SELECT
						srj.NIP,
						srj.TMT_JABATAN AS TMT_JABATAN_FUNGSIONAL,
						(SELECT JABATAN_NAMA FROM sp_jenis_jabatan WHERE JABATAN_ID = srj.JENIS_JABATAN_ID) AS JABATAN_FUNGSIONAL	
					FROM sp_riwayat_jabatan srj
					LEFT JOIN sp_jenis_jabatan sjj ON srj.JENIS_JABATAN_ID = sjj.JABATAN_ID
					WHERE srj.JENIS_JABATAN_ID IN(2,4) 
					AND srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = '$nip' )
					
						
				) jabf ON jabf.NIP = peg.NIP
				LEFT JOIN
				(
					SELECT
						srj.NIP,
						srj.TMT_JABATAN AS TMT_JABATAN_STRUKTURAL,
						(SELECT JABATAN_NAMA FROM sp_jenis_jabatan WHERE JABATAN_ID = srj.JENIS_JABATAN_ID) AS JABATAN_STRUKTURAL	
					FROM sp_riwayat_jabatan srj
					LEFT JOIN sp_jenis_jabatan sjj ON srj.JENIS_JABATAN_ID = sjj.JABATAN_ID
					WHERE srj.JENIS_JABATAN_ID = 1 
					AND srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = '$nip' )
						
				) jabs ON jabs.NIP = peg.NIP
				LEFT JOIN 
				(
					SELECT 
						srj.NIP,
						srj.TMT_JABATAN AS TMT_JABATAN_PNS
					FROM sp_riwayat_jabatan srj 
					LEFT JOIN sp_jenis_jabatan sjj ON srj.JENIS_JABATAN_ID = sjj.JABATAN_ID
					WHERE srj.JENIS_JABATAN_ID != 5 
					AND srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = '$nip' )
				) pns ON pns.NIP = peg.NIP
				WHERE peg.NIP = '$nip'
			","row",10);
			
			return $query;
		}
	}

	# Get pegawai tidak Aktif
	public function getDataPegawaiTidakAktif( $search = array() )
	{
		$query = "		
			SELECT
				peg.NIP,
				TRIM(CONCAT(peg.GELAR_DEPAN,' ',peg.GELAR_LAIN,' ', UPPER(peg.NAMA_PEGAWAI),' ', peg.GELAR_BELAKANG)) AS NAMA,
				gol.NAMA_GOLONGAN AS GOLONGAN,
				jab.INSTANSI AS INSTANSI,
				jab.JABATAN AS JABATAN,
				sprp.KEDUDUKAN_NAMA,
				sprp.RIWAYAT_PEMBERHENTIAN_ID,
				concat('<a href=\"#\" onclick=\"aktivasiPegawai(',sprp.RIWAYAT_PEMBERHENTIAN_ID,')\">Aktivasi</a>') AS LINK
			FROM sp_pegawai peg
			LEFT JOIN ( SELECT
							srg.NIP,
							CONCAT(sg.GOLONGAN_KODE,' - ',sg.GOLONGAN_NAMA) AS NAMA_GOLONGAN
						FROM sp_riwayat_golongan srg 
						LEFT JOIN sp_golongan sg ON sg.GOLONGAN_ID = srg.GOLONGAN_ID
						WHERE srg.RIWAYAT_GOLONGAN_ID = (SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = srg.NIP )
					) gol ON gol.NIP = peg.NIP
			LEFT JOIN (	SELECT
							srj.NIP,
							TRIM(su.UNOR_NAMA) AS INSTANSI,
							su.UNOR_NAMA_JABATAN AS JABATAN
						FROM sp_riwayat_jabatan srj
						LEFT JOIN sp_unor su ON srj.UNOR_ID = su.UNOR_ID
						WHERE srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = srj.NIP )
					) jab ON jab.NIP = peg.NIP
			LEFT JOIN (
				SELECT * FROM sp_riwayat_pemberhentian srp 
				LEFT JOIN sp_kedudukan_pegawai skp ON srp.KEDUDUKAN_HUKUM_ID = skp.KEDUDUKAN_ID	 WHERE srp.IS_AKTIF = '1'
			) sprp ON sprp.NIP = peg.NIP
			WHERE sprp.KEDUDUKAN_HUKUM_ID != '01' AND sprp.IS_AKTIF = '1'";

		$run = $this->dbQueryCache($query,'all',300);
		$data = array();
		foreach((array)$run as $row){
			$data[$row['NIP']] = $row;
		}
		return $data;
	}

	# Simpan data pegawai
	public function simpanDataPegawai( $post, $nip = null )
	{
		$success = FALSE;
		if( $post )
		{
			$this->db->trans_begin();
			
			$this->db->set( 'NIP_LAMA', $post['inputNipLama'] );
			$this->db->set( 'NAMA_PEGAWAI', $post['inputNama'] );
			$this->db->set( 'GELAR_DEPAN', $post['inputGelarDepan'] );
			$this->db->set( 'GELAR_BELAKANG', $post['inputGelarBelakang'] );
			$this->db->set( 'GELAR_LAIN', $post['inputGelarLain'] );
			$this->db->set( 'TEMPAT_LAHIR', $post['inputTempatLahir'] );
			$this->db->set( 'TANGGAL_LAHIR', mysql_date($post['inputTanggaLahir']) ); //date
			$this->db->set( 'NO_AKTA_LAHIR', $post['inputNoAktaLahir'] );
			$this->db->set( 'JENIS_KELAMIN', $post['inputJenisKelamin'] );
			$this->db->set( 'AGAMA_ID', $post['inputAgama'] );
			$this->db->set( 'ALAMAT', $post['inputAlamat'] );
			$this->db->set( 'KODEPOS', $post['inputKodepos'] );
			$this->db->set( 'NO_HANDPHONE', $post['inputHandphone'] );
			$this->db->set( 'NO_TELEPHONE', $post['inputTelephone'] );
			$this->db->set( 'NO_IDENTITAS', $post['inputNoIdentitas'] );
			$this->db->set( 'GOLONGAN_DARAH', $post['inputGolonganDarah'] );
			$this->db->set( 'BERAT_BADAN', $post['inputBeratBadan'] );
			$this->db->set( 'TINGGI_BADAN', $post['inputTinggiBadan'] );
			$this->db->set( 'WARNA_KULIT', $post['inputWarnaKulit'] );
			$this->db->set( 'NO_SK_CPNS', $post['inputNoSKCPns'] );
			$this->db->set( 'TANGGAL_SK_CPNS', mysql_date($post['inputTanggalSKCpns']) );
			$this->db->set( 'TMT_SK_CPNS', mysql_date($post['inputTMTSKCpns']) );
			$this->db->set( 'TMT_SPMT_CPNS', mysql_date($post['inputTMTSPCpns']) );
			$this->db->set( 'NO_NPWP', $post['inputNoNpwp'] );
			$this->db->set( 'TANGGAL_NPWP', mysql_date($post['inputTanggalNpwp']) );
			$this->db->set( 'NO_BPJS', $post['inputNoBpjs'] );
			$this->db->set( 'STATUS_KEPEMILIKAN_RUMAH', $post['inputStatusKepemilikanRumah'] );
			$this->db->set( 'PHOTO', $post['inputPhoto'] );
			$this->db->set( 'JENIS_PEGAWAI_ID', $post['inputJenisPegawai'] );


			if( $post['mode'] == 'new' )
			{
				$this->db->set( 'KEDUDUKAN_ID', '01' );
				$this->db->set( 'NIP', $post['inputNip'] );
				$this->db->set( 'USERINSERT',$post['user_id'] );
				$this->db->set( 'INSERTDATE','NOW()',FALSE );
				$insert = $this->db->insert('sp_pegawai');	

				if( $insert )
				{
					# Insert Riwayat Jabatan
					if( !empty($post['inputTanggalSKCpns']) && !empty($post['inputNoSKCPns']) && !empty($post['inputTMTSKCpns']) )
					{
						$this->db->set('NIP', $post['inputNip']);
						$this->db->set('UNOR_ID', $post['inputUnor']);
						$this->db->set('JENIS_JABATAN_ID', '5');
						$this->db->set('NOMOR_SK', $post['inputNoSKCPns'] );
						$this->db->set('TANGGAL_SK', mysql_date($post['inputTanggalSKCpns']));
						$this->db->set('TMT_JABATAN', mysql_date($post['inputTMTSKCpns']) );
						$this->db->set('PENETAP_ID', 'G');
						$this->db->set('INSERTDATE', 'NOW()', FALSE);
						$this->db->set('USERINSERT', $this->dx_auth->get_user_id() );
						$this->db->insert('sp_riwayat_jabatan');
					}

					# Insert Riwayat Golongan
					if( !empty($post['inputGolongan']) )
					{
						$this->db->set('NIP', $post['inputNip']);
						$this->db->set('KODE_JENIS_KP', '211');
						$this->db->set('NOMOR_SK', $post['inputNoSKCPns']);
						$this->db->set('TANGGAL_SK', mysql_date($post['inputTanggalSKCpns']) );
						$this->db->set('TMT_GOLONGAN',mysql_date($post['inputTMTSKCpns']) );
						$this->db->set('GOLONGAN_ID', $post['inputGolongan']);
						$this->db->set('PENETAP_ID', 'G');
						$this->db->set('INSERTDATE', 'NOW()', FALSE);
						$this->db->set('USERINSERT', $this->dx_auth->get_user_id() );
						$this->db->insert('sp_riwayat_golongan');
					}

					# Insert Riwayat Unor
					$this->db->set('NIP', $post['inputNip']);
					$this->db->set('NOMOR_SK', $post['inputNoSKCPns']);
					$this->db->set('TANGGAL_SK', mysql_date( $post['inputTanggalSKCpns']) );
					$this->db->set('UNOR_ID', $post['inputUnor']);
					$this->db->set('INSERTDATE', 'NOW()', FALSE);
					$this->db->set('USERINSERT', $this->dx_auth->get_user_id() );
					$this->db->insert('sp_riwayat_unor');

					#created user
					$this->dx_auth->register( $post['inputNip'], $post['inputNip'], $post['inputNip']."@bkd.jogjaprov.go.id" );
				}

			}else{
				$this->db->set( 'USERUPDATE',$post['user_id'] );
				$this->db->set( 'UPDATEDATE','NOW()',FALSE);
				$this->db->where( 'NIP', $post['inputNip'] );
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

	# Cek duplikasi NIP
	public function cekNip( $nip, $edit = false )
	{
		$this->db->where( 'NIP', $nip );
		$result = $this->db->get( 'sp_pegawai' );
		if( $result->num_rows() > 0 ){
			return TRUE;
		}
		return FALSE;
	}


}