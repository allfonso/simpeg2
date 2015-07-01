<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kembangkarir_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	/**
	Simpan data ijin belajar
	*/
	# Simpan data ijin belajar
	public function simpanDataIjinBelajarPegawai( $post, $nip = null )
	{
		$success = FALSE;
		if( $post )
		{
			$this->db->trans_begin();

			$this->db->set( 'NIP', $post['current_ijin_nip'] );
			$this->db->set( 'NO_SURAT_IJIN_BELAJAR', $post['inputNoSuratIjinBelajar'] );
			$this->db->set( 'IJIN_TGL_MULAI', mysql_date($post['inputTglMulaiIjinBelajar']) );
			$this->db->set( 'IJIN_TGL_SELESAI', mysql_date($post['inputTglSelesaiIjinBelajar']) );
			$this->db->set( 'JENJANG_DIDIK', $post['jenjang_didik_id'] );
			$this->db->set( 'JURUSAN', $post['inputJurusan'] );
			$this->db->set( 'UNIVERSITAS', $post['inputUniversitas'] );
						
			$insert = $this->db->insert('sp_ijin_belajar');
			
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

	/**
	 * Get data ijin belajar
	 */
	public function getIjinBelajar($nip,$json=true)
	{
		$where = "";
		if( $nip ){
			$where = " WHERE I.NIP = '$nip' ";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	I.IJIN_ID AS IJIN_ID,
					 	I.NO_SURAT_IJIN_BELAJAR AS NO_SURAT_IJIN_BELAJAR,
						DATE_FORMAT(I.IJIN_TGL_MULAI,'%d/%m/%Y') AS IJIN_TGL_MULAI,
						DATE_FORMAT(I.IJIN_TGL_SELESAI,'%d/%m/%Y') AS IJIN_TGL_SELESAI,
						J.JENJANG_DIDIK AS JENJANG_DIDIK,
						I.JURUSAN AS JURUSAN,
						U.NAMA_UNIVERSITAS AS UNIVERSITAS
					 FROM sp_ijin_belajar I
					 LEFT JOIN sp_jenjang_didik J ON J.ID = I.JENJANG_DIDIK 
					 LEFT JOIN sp_universitas U ON U.ID = I.UNIVERSITAS
					 $where
					 ORDER BY I.IJIN_ID ASC
				");
		if( $json ){
			return array('total' => count($query),'rows' => $query);
		}

		return $query;
	}

	public function getIjinBelajarById($ijin_id)
	{
		$query = "SELECT I.IJIN_ID AS IJIN_ID
					   , I.NIP AS NIP
					   , P.NIP_LAMA AS NIP_LAMA
					   , P.NAMA_PEGAWAI AS NAMA_PEGAWAI
					   , I.NO_SURAT_IJIN_BELAJAR AS NO_SURAT_IJIN_BELAJAR
					   , DATE_FORMAT(I.IJIN_TGL_MULAI,'%d-%m-%Y') AS IJIN_TGL_MULAI 
					   , DATE_FORMAT(I.IJIN_TGL_SELESAI,'%d-%m-%Y') AS IJIN_TGL_SELESAI
					   , I.JENJANG_DIDIK AS JENJANG_DIDIK
					   , I.JURUSAN AS JURUSAN
					   , U.NAMA_UNIVERSITAS AS UNIVERSITAS
				FROM sp_ijin_belajar I
				LEFT JOIN sp_pegawai P ON P.NIP = I.NIP 
				LEFT JOIN sp_universitas U ON U.ID = I.UNIVERSITAS
				WHERE IJIN_ID = $ijin_id"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	public function simpanDataEditIjinBelajarPegawai($post)
	{
		$success = FALSE;
		if ($post['current_ijin_id']) {
			$this->db->trans_begin();
			
			$this->db->set( 'NO_SURAT_IJIN_BELAJAR', $post['inputNoSuratIjinBelajar'] );
			$this->db->set( 'IJIN_TGL_MULAI', mysql_date($post['inputTglMulaiIjinBelajar']) );
			$this->db->set( 'IJIN_TGL_SELESAI', mysql_date($post['inputTglSelesaiIjinBelajar']) );
			$this->db->set( 'JENJANG_DIDIK', $post['jenjang_didik_id'] );
			$this->db->set( 'JURUSAN', $post['inputJurusan'] );
			$this->db->set( 'UNIVERSITAS', $post['inputUniversitas'] );
				
			$this->db->where('IJIN_ID', $post['current_ijin_id']);
			$insert = $this->db->update('sp_ijin_belajar');
			
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

	public function deleteIjinBelajar($id)
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('IJIN_ID', $id);
			$this->db->delete('sp_ijin_belajar');

			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			}

			return $success;
		}
	}

	public function getDataijinBelajar($offset,$rows,$search)
	{
		$where = "";
		if( isset($search['nip']) && $search['nip'] != ''){
			$where .= " AND T.NIP = '" .$search['nip']. "'";
		}
		if( isset($search['nama']) && $search['nama'] != ''){
			$where .= " AND LOWER(P.NAMA_PEGAWAI) LIKE '%" .strtolower($search['nama']). "%' ";
		}
		if( isset($search['universitas']) && $search['universitas'] != ''){
			$where .= " AND T.UNIVERSITAS = '" .$search['universitas']. "'";
		}
		if( isset($search['bulantahunmulai']) && $search['bulantahunmulai'] != ''){
			$where .= " AND T.IJIN_TGL_MULAI LIKE '" .$search['bulantahunmulai']. "%'";
		}
		if( isset($search['bulantahunselesai']) && $search['bulantahunselesai'] != ''){
			$where .= " AND T.IJIN_TGL_SELESAI LIKE '" .$search['bulantahunselesai']. "%'";
		}

		$sql = "SELECT T.IJIN_ID AS IJIN_ID
			   		  ,T.NIP AS NIP
			   		  ,T.NO_SURAT_IJIN_BELAJAR AS NO_SURAT_IJIN_BELAJAR
			   		  ,P.NAMA_PEGAWAI AS NAMA
			   		  ,J.JENJANG_DIDIK AS JENJANG_DIDIK
			   		  ,U.NAMA_UNIVERSITAS AS UNIVERSITAS
			   		  , DATE_FORMAT(T.IJIN_TGL_MULAI,'%d-%m-%Y') AS IJIN_TGL_MULAI 
					  , DATE_FORMAT(T.IJIN_TGL_SELESAI,'%d-%m-%Y') AS IJIN_TGL_SELESAI
				FROM sp_ijin_belajar T
				LEFT JOIN sp_jenjang_didik J ON J.ID = T.JENJANG_DIDIK
				LEFT JOIN sp_universitas U ON U.ID = T.UNIVERSITAS
				LEFT JOIN sp_pegawai P ON P.NIP = T.NIP
				WHERE 1 $where ";

		// echo $sql;

		$query = $this->dbQueryCache( $sql,"all",10);
		$total = count($query);

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => $total, 'rows' => $data);
	}

	/**
	* IJIN LUAR NEGRI
	*/
	public function simpanDataIjinLuarNegriPegawai($post)
	{
		$success = FALSE;
		if( $post )
		{
			$this->db->trans_begin();

			$this->db->set( 'NIP', $post['current_ln_nip'] );
			$this->db->set( 'TGL_KEBERANGKATAN', mysql_date($post['inputTglkeberangkatan']) );
			$this->db->set( 'TGL_PULANG', mysql_date($post['inputTglPulang']) );			
			$this->db->set( 'NEGARA_TUJUAN', $post['inputTujuanNegara'] );
						
			$insert = $this->db->insert('sp_ijin_luarnegeri');
			
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

	public function getIjinLuarNegeri($nip,$json=true)
	{
		$where = "";
		if( $nip ){
			$where = " WHERE NIP = '$nip' ";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	IJIN_ID_LN,
						DATE_FORMAT(TGL_KEBERANGKATAN,'%d/%m/%Y') AS TGL_KEBERANGKATAN,
						DATE_FORMAT(TGL_PULANG,'%d/%m/%Y') AS TGL_PULANG,						
						NEGARA_TUJUAN
					 FROM sp_ijin_luarnegeri
					 $where
					 ORDER BY IJIN_ID_LN ASC
				");
		if( $json ){
			return array('total' => count($query),'rows' => $query);
		}

		return $query;
	}

	public function getIjinLuarNegeriById($ijin_id_ln)
	{
		$query = "SELECT I.IJIN_ID_LN AS IJIN_ID_LN
					   , I.NIP AS NIP
					   , P.NIP_LAMA AS NIP_LAMA
					   , P.NAMA_PEGAWAI AS NAMA_PEGAWAI					   
					   , DATE_FORMAT(I.TGL_KEBERANGKATAN,'%d-%m-%Y') AS TGL_KEBERANGKATAN 
					   , DATE_FORMAT(I.TGL_PULANG,'%d-%m-%Y') AS TGL_PULANG
					   , I.NEGARA_TUJUAN AS NEGARA_TUJUAN					   
				FROM sp_ijin_luarnegeri I
				LEFT JOIN sp_pegawai P ON P.NIP = I.NIP 
				WHERE IJIN_ID_LN = $ijin_id_ln"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	public function simpanDataEditIjinLuarNegeriPegawai($post)
	{
		$success = FALSE;
		if ($post['current_ijin_id_ln']) {
			$this->db->trans_begin();
						
			$this->db->set( 'TGL_KEBERANGKATAN', mysql_date($post['inputTglkeberangkatan']) );
			$this->db->set( 'TGL_PULANG', mysql_date($post['inputTglPulang']) );
			$this->db->set( 'NEGARA_TUJUAN', $post['inputTujuanNegara'] );
				
			$this->db->where('IJIN_ID_LN', $post['current_ijin_id_ln']);
			$insert = $this->db->update('sp_ijin_luarnegeri');
			
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

	public function deleteIjinLuarNegeri($id)
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('IJIN_ID_LN', $id);
			$this->db->delete('sp_ijin_luarnegeri');

			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			}

			return $success;
		}
	}

	public function getDataIjinBelajarLn($offset,$rows,$search)
	{
		$where = "";
		if( isset($search['nip']) && $search['nip'] != ''){
			$where .= " AND T.NIP = '" .$search['nip']. "'";
		}
		if( isset($search['nama']) && $search['nama'] != ''){
			$where .= " AND LOWER(P.NAMA_PEGAWAI) LIKE '%" .strtolower($search['nama']). "%' ";
		}
		if( isset($search['negara']) && $search['negara'] != ''){
			$where .= " AND T.NEGARA_TUJUAN LIKE '%" .$search['negara']. "%'";
		}
		if( isset($search['bulantahunberangkat']) && $search['bulantahunberangkat'] != ''){
			$where .= " AND T.TGL_KEBERANGKATAN LIKE '" .$search['bulantahunberangkat']. "%'";
		}
		if( isset($search['bulantahunpulang']) && $search['bulantahunpulang'] != ''){
			$where .= " AND T.TGL_PULANG LIKE '" .$search['bulantahunpulang']. "%'";
		}

		$sql = "SELECT T.IJIN_ID_LN AS IJIN_ID_LN
			   		  ,T.NIP AS NIP
			   		  ,P.NAMA_PEGAWAI AS NAMA
			   		  ,T.NEGARA_TUJUAN AS NEGARA_TUJUAN
			   		  , DATE_FORMAT(T.TGL_KEBERANGKATAN,'%d-%m-%Y') AS TGL_KEBERANGKATAN 
					  , DATE_FORMAT(T.TGL_PULANG,'%d-%m-%Y') AS TGL_PULANG
				FROM sp_ijin_luarnegeri T
				LEFT JOIN sp_pegawai P ON P.NIP = T.NIP
				WHERE 1 $where ";

		// echo $sql;

		$query = $this->dbQueryCache( $sql,"all",10);
		$total = count($query);

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => $total, 'rows' => $data);
	}

	/**
	* TUGAS BELAJAR
	*/
	public function simpanDataTugasBelajarNegriPegawai($post)
	{
		$success = FALSE;
		if( $post )
		{
			$this->db->trans_begin();

			$this->db->set( 'NIP', $post['current_tugas_nip'] );
			$this->db->set( 'TGL_MULAI_TUGAS', mysql_date($post['inputTglMulaiTugas']) );
			$this->db->set( 'TGL_SELESAI_TUGAS', mysql_date($post['inputTglSelesaiTugas']) );			
			$this->db->set( 'JENJANG_DIDIK', $post['jenjang_didik_id'] );
			$this->db->set( 'JURUSAN', $post['inputJurusan'] );
			$this->db->set( 'UNIVERSITAS', $post['inputUniversitas'] );
						
			$insert = $this->db->insert('sp_tugas_belajar');
			
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

	public function gettugasBelajar($nip,$json=true)
	{
		$where = "";
		if( $nip ){
			$where = " WHERE I.NIP = '$nip' ";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	I.TUGAS_ID AS TUGAS_ID,					 	
						DATE_FORMAT(I.TGL_MULAI_TUGAS,'%d/%m/%Y') AS TGL_MULAI_TUGAS,
						DATE_FORMAT(I.TGL_SELESAI_TUGAS,'%d/%m/%Y') AS TGL_SELESAI_TUGAS,
						J.JENJANG_DIDIK AS JENJANG_DIDIK,
						U.NAMA_UNIVERSITAS AS UNIVERSITAS,
						I.JURUSAN AS JURUSAN						
					 FROM sp_tugas_belajar I
					 LEFT JOIN sp_jenjang_didik J ON J.ID = I.JENJANG_DIDIK 
					 LEFT JOIN sp_universitas U ON U.ID = I.UNIVERSITAS
					 $where
					 ORDER BY I.TUGAS_ID ASC
				");
		if( $json ){
			return array('total' => count($query),'rows' => $query);
		}

		return $query;
	}

	public function getTugasBelajarById($id)
	{
		$query = "SELECT I.TUGAS_ID AS TUGAS_ID
					   , I.NIP AS NIP
					   , P.NIP_LAMA AS NIP_LAMA
					   , P.NAMA_PEGAWAI AS NAMA_PEGAWAI
					   , DATE_FORMAT(I.TGL_MULAI_TUGAS,'%d-%m-%Y') AS TGL_MULAI_TUGAS 
					   , DATE_FORMAT(I.TGL_SELESAI_TUGAS,'%d-%m-%Y') AS TGL_SELESAI_TUGAS
					   , I.JENJANG_DIDIK AS JENJANG_DIDIK
					   , I.JURUSAN AS JURUSAN
					   , I.UNIVERSITAS AS UNIVERSITAS
				FROM sp_tugas_belajar I
				LEFT JOIN sp_pegawai P ON P.NIP = I.NIP 
				WHERE TUGAS_ID = $id"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	public function simpanDataEditTugasBelajarPegawai($post)
	{
		$success = FALSE;
		if ($post['current_tugas_id']) {
			$this->db->trans_begin();
			
			$this->db->set( 'TGL_MULAI_TUGAS', mysql_date($post['inputTglMulaitugas']) );
			$this->db->set( 'TGL_SELESAI_TUGAS', mysql_date($post['inputTglselesaitugas']) );
			$this->db->set( 'JENJANG_DIDIK', $post['jenjang_didik_id'] );
			$this->db->set( 'JURUSAN', $post['inputJurusan'] );
			$this->db->set( 'UNIVERSITAS', $post['inputUniversitas'] );
				
			$this->db->where('TUGAS_ID', $post['current_tugas_id']);
			$insert = $this->db->update('sp_tugas_belajar');
			
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

	public function deleteTugasBelajar($id)
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('TUGAS_ID', $id);
			$this->db->delete('sp_tugas_belajar');

			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			}

			return $success;
		}
	}

	public function get_all_nip($json = true)
	{
		// $this->db->select('NIP');
		// $query = $this->db->get('sp_pegawai');

		// $data = array();
		// foreach($query->result() as $row){
		// 	$data[$row->NIP] = $row->NIP;
		// }
		$arr = array();
		$query = $this->dbQueryCache("
					SELECT NIP
					FROM sp_pegawai 
					WHERE KEDUDUKAN_ID NOT IN('04','14','15','16','20','66','70','77','88','99')
				");
		
		// print_r($query);die('asdasd');

		foreach((array)$query as $k=>$v){
			$arr[] = array('id' => $v['NIP'], 'text' => $v['NIP']);
		}
		// echo "<pre>";
		// print_r($arr);
		// echo "</pre>";
		// die('asdasd');
		return $arr;
	}

	public function get_nama_pegawai($id)
	{
		$query = "SELECT NAMA_PEGAWAI
				  FROM sp_pegawai				
				  WHERE NIP = '$id'"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result['NAMA_PEGAWAI'];
	}

	public function get_universitas()
	{
		$arr = array();
		$query = $this->dbQueryCache("
					SELECT ID,NAMA_UNIVERSITAS
					FROM sp_universitas
				");
		
		// print_r($query);die('asdasd');

		foreach((array)$query as $k=>$v){
			$arr[] = array('id' => $v['ID'], 'text' => $v['NAMA_UNIVERSITAS']);
		}
		// echo "<pre>";
		// print_r($arr);
		// echo "</pre>";
		// die('asdasd');
		return $arr;
	}

	public function getDataTugasBelajar($offset,$rows,$search)
	{
		$where = "";
		if( isset($search['nip']) && $search['nip'] != ''){
			$where .= " AND T.NIP = '" .$search['nip']. "'";
		}
		if( isset($search['nama']) && $search['nama'] != ''){
			$where .= " AND LOWER(P.NAMA_PEGAWAI) LIKE '%" .strtolower($search['nama']). "%' ";
		}
		if( isset($search['universitas']) && $search['universitas'] != ''){
			$where .= " AND T.UNIVERSITAS = '" .$search['universitas']. "'";
		}
		if( isset($search['bulantahunmulai']) && $search['bulantahunmulai'] != ''){
			$where .= " AND T.TGL_MULAI_TUGAS LIKE '" .$search['bulantahunmulai']. "%'";
		}
		if( isset($search['bulantahunselesai']) && $search['bulantahunselesai'] != ''){
			$where .= " AND T.TGL_SELESAI_TUGAS LIKE '" .$search['bulantahunselesai']. "%'";
		}

		$sql = "SELECT T.TUGAS_ID AS TUGAS_ID
			   		  ,T.NIP AS NIP
			   		  ,P.NAMA_PEGAWAI AS NAMA
			   		  ,J.JENJANG_DIDIK AS JENJANG_DIDIK
			   		  ,U.NAMA_UNIVERSITAS AS UNIVERSITAS
			   		  , DATE_FORMAT(T.TGL_MULAI_TUGAS,'%d-%m-%Y') AS TGL_MULAI_TUGAS 
					  , DATE_FORMAT(T.TGL_SELESAI_TUGAS,'%d-%m-%Y') AS TGL_SELESAI_TUGAS
				FROM sp_tugas_belajar T
				LEFT JOIN sp_jenjang_didik J ON J.ID = T.JENJANG_DIDIK
				LEFT JOIN sp_universitas U ON U.ID = T.UNIVERSITAS
				LEFT JOIN sp_pegawai P ON P.NIP = T.NIP
				WHERE 1 $where ";

		// echo $sql;

		$query = $this->dbQueryCache( $sql,"all",10);
		$total = count($query);

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => $total, 'rows' => $data);
	}

	public function get_bulan()
	{
		$arrbulan = array("01" => "Januari"
						 ,"02" => "Februari"
						 ,"03" => "Maret"
						 ,"04" => "April"
						 ,"05" => "Mei"
						 ,"06" => "Juni"
						 ,"07" => "Juli"
						 ,"08" => "Agustus"
						 ,"09" => "September"
						 ,"10" => "Oktober"
						 ,"11" => "November"
						 ,"12" => "Desember");
		return $arrbulan;
	}
}