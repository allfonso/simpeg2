<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengelolaan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getDataJenjangJabatan($offset,$rows,$search)
	{
		$where = "";
		if( isset($search['jabatan']) && $search['jabatan'] != ''){
			$where .= " AND J.NAMA_JENJANG_JABATAN LIKE '%" .$search['jabatan']. "%'";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	J.ID AS ID,
					 	J.NAMA_JENJANG_JABATAN AS NAMA_JENJANG_JABATAN,
						K.JABATAN_NAMA AS JENIS_JABATAN
					 FROM sp_jenjang_jabatan J
					 LEFT JOIN sp_jenis_jabatan K ON K.JABATAN_ID = J.JENIS_JABATAN_ID					
					 WHERE 1 $where
					 ORDER BY J.ID ASC
				");

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => count($query),'rows' => $data);
		
	}

	public function get_all_jabatan(){
		$arr = array();
		$query = $this->dbQueryCache("
					SELECT JABATAN_ID, JABATAN_NAMA
					FROM sp_jenis_jabatan
				");


		foreach((array)$query as $k=>$v){
			$arr[] = array('id' => $v['JABATAN_ID'], 'text' => $v['JABATAN_NAMA']);
		}

		return $arr;
	}

	public function simpanDataJabatan($post)
	{
		$result = array();
		$success = FALSE;
		if( $post )
		{
			$post['inputJabatan'] = trim($post['inputJabatan']);
			// ada data jabatan yang sama atau tidak
			$query['ID'] = '';
			$query = $this->dbQueryCache("
					 SELECT ID					
					 FROM sp_jenjang_jabatan
					 WHERE NAMA_JENJANG_JABATAN = '".$post['inputJabatan']."'
				", "row");

			if (empty($query['ID'])) {
				//get hexa
				$hexa = md5($post['inputJabatan'].rand(1,1000));
				$this->db->trans_begin();

				$this->db->set( 'JENJANG_JABATAN_ID', $hexa );
				$this->db->set( 'NAMA_JENJANG_JABATAN', $post['inputJabatan'] );
				$this->db->set( 'JENIS_JABATAN_ID', $post['inputJenisJabatan'] );
							
				$insert = $this->db->insert('sp_jenjang_jabatan');
				
				if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				    $success = FALSE;
				    $msg = "Gagal simpan jabatan.";
				}else{
				    $this->db->trans_commit();
				    $success = TRUE;
				    $msg = "Data jabatan berhasil disimpan.";
				}
			} else {
				$success = FALSE;
				$msg = "Data jabatan sudah ada.";
			}			
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function updateDataJabatan($post)
	{
		$result = array();
		$success = FALSE;
		if( $post )
		{
			$post['inputJabatan'] = trim($post['inputJabatan']);
			// ada data jabatan yang sama atau tidak
			$query['ID'] = '';
			$query = $this->dbQueryCache("
					 SELECT ID					
					 FROM sp_jenjang_jabatan
					 WHERE NAMA_JENJANG_JABATAN = '".$post['inputJabatan']."'
					 AND ID != ".trim($post['current_jabatan_id'])."
				", "row");

			if (empty($query['ID'])) {
				$this->db->trans_begin();

				$this->db->set( 'NAMA_JENJANG_JABATAN', $post['inputJabatan'] );
				$this->db->set( 'JENIS_JABATAN_ID', $post['inputJenisJabatan'] );
							
				$this->db->where('ID', $post['current_jabatan_id']);
				$insert = $this->db->update('sp_jenjang_jabatan');
				
				if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				    $success = FALSE;
				    $msg = "Gagal simpan jabatan.";
				}else{
				    $this->db->trans_commit();
				    $success = TRUE;
				    $msg = "Data jabatan berhasil disimpan.";
				}
			} else {
				$success = FALSE;
				$msg = "Data jabatan sudah ada.";
			}			
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function getJabatanById($idjab)
	{
		$query = "SELECT ID, NAMA_JENJANG_JABATAN, JENIS_JABATAN_ID
				FROM sp_jenjang_jabatan
				WHERE ID = $idjab"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	public function deletejabatan($id){
		$result = array();
		$success = FALSE;
		// cek di riwayat jabatan ada jenis jabatan ini atau tidak
		$datajabatan = "SELECT JENJANG_JABATAN_ID
				FROM sp_jenjang_jabatan
				WHERE ID = $id"; 
		$resultjabatan = $this->dbQueryCache($datajabatan, 'row', 100);
		$hexa_id = $resultjabatan['JENJANG_JABATAN_ID'];

		$data = $this->dbQueryCache("
					 SELECT RIWAYAT_JABATAN_ID					
					 FROM sp_riwayat_jabatan
					 WHERE JENJANG_JABATAN_ID = '".$hexa_id."'", "row");

		if (empty($data)) {
			$this->db->trans_begin();
			$this->db->where('ID', $id);
			$this->db->delete('sp_jenjang_jabatan');

			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			    $msg = "Gagal hapus jabatan.";
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			    $msg = "Data jabatan berhasil dihapus.";
			}
		} else {
			$success = FALSE;
			$msg = "Data jabatan tidak bisa di hapus karena masih ada yang memakai.";
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function getDataJabatanByDelete($offset,$rows,$id)
	{
		$where = "";
		if( isset($search['jabatan']) && $search['jabatan'] != ''){
			$where .= " AND J.NAMA_JENJANG_JABATAN LIKE '%" .$search['jabatan']. "%'";
		}

		$datajabatan = "SELECT JENJANG_JABATAN_ID
				FROM sp_jenjang_jabatan
				WHERE ID = $id"; 
		$resultjabatan = $this->dbQueryCache($datajabatan, 'row', 100);
		$hexa_id = $resultjabatan['JENJANG_JABATAN_ID'];

		$query = $this->dbQueryCache("
					 SELECT
					 	DISTINCT(J.NIP) AS NIP,
					 	P.NAMA_PEGAWAI AS NAMA_PEGAWAI,
						P.ALAMAT AS ALAMAT
					 FROM sp_riwayat_jabatan J
					 LEFT JOIN sp_pegawai P ON P.NIP = J.NIP
					 WHERE JENJANG_JABATAN_ID = '$hexa_id'	
					 GROUP BY NIP				
					 ORDER BY J.RIWAYAT_JABATAN_ID ASC
				");

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => count($query),'rows' => $data);
	}

	/**
	* UNOR
	*/
	public function getDataUnor($offset,$rows,$search)
	{
		$where = "";
		if( isset($search['unor']) && $search['unor'] != ''){
			$where .= " AND J.UNOR_NAMA LIKE '%" .$search['unor']. "%'";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	J.ID AS ID,
					 	J.UNOR_NAMA AS UNOR_NAMA,
					 	J.UNOR_NAMA_JABATAN AS UNOR_NAMA_JABATAN,
						I.INSTANSI_NAMA AS INSTANSI_NAMA
					 FROM sp_unor J
					 LEFT JOIN sp_instansi I ON I.INSTANSI_ID = J.INSTANSI_ID					
					 WHERE 1 $where
					 ORDER BY J.ORDERBY ASC
				");

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => count($query),'rows' => $data);
		
	}

	public function get_all_instansi()
	{
		$arr = array();
		$query = $this->dbQueryCache("
					SELECT INSTANSI_ID, INSTANSI_NAMA
					FROM sp_instansi
				");


		foreach((array)$query as $k=>$v){
			$arr[] = array('id' => $v['INSTANSI_ID'], 'text' => $v['INSTANSI_NAMA']);
		}

		return $arr;
	}

	public function simpanDataUnor($post)
	{
		$result = array();
		$success = FALSE;
		if( $post )
		{
			$post['inputNamaUnor'] = trim($post['inputNamaUnor']);
			// ada data jabatan yang sama atau tidak
			$query['ID'] = '';
			$query = $this->dbQueryCache("
					 SELECT ID					
					 FROM sp_unor
					 WHERE UNOR_NAMA = '".$post['inputNamaUnor']."'
				", "row");

			if (empty($query['ID'])) {

				//cari order by tertinggi
				$queryoby = $this->dbQueryCache("
					 SELECT MAX(ORDERBY)+1 AS ORDERBY					
					 FROM sp_unor", "row");
				$orderby = $queryoby['ORDERBY'];

				//get hexa
				$hexa = md5($post['inputNamaUnor'].rand(1,1000));
				$this->db->trans_begin();

				$this->db->set( 'UNOR_ID', $hexa );
				$this->db->set( 'UNOR_NAMA', $post['inputNamaUnor'] );
				$this->db->set( 'UNOR_NAMA_JABATAN', $post['inputNamaJabatan'] );
				$this->db->set( 'INSTANSI_ID', $post['inputInstansi'] );
				$this->db->set( 'ORDERBY', $orderby );
							
				$insert = $this->db->insert('sp_unor');
				
				if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				    $success = FALSE;
				    $msg = "Gagal simpan unor.";
				}else{
				    $this->db->trans_commit();
				    $success = TRUE;
				    $msg = "Data unor berhasil disimpan.";
				}
			} else {
				$success = FALSE;
				$msg = "Data unor sudah ada.";
			}			
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function getUnorById($idunor)
	{
		$query = "SELECT
				 	J.ID AS ID,
				 	J.UNOR_NAMA AS UNOR_NAMA,
				 	J.UNOR_NAMA_JABATAN AS UNOR_NAMA_JABATAN,					
					J.INSTANSI_ID AS INSTANSI_ID
				 FROM sp_unor J				 				
				 WHERE J.ID = $idunor"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	public function updateDataUnor($post)
	{
		$result = array();
		$success = FALSE;
		if( $post )
		{
			// $post['inputNamaUnor'] = trim($post['inputNamaUnor']);
			// ada data jabatan yang sama atau tidak
			$query['ID'] = '';
			$query = $this->dbQueryCache("
					 SELECT ID					
					 FROM sp_unor
					 WHERE UNOR_NAMA = '".$post['inputNamaUnor']."'
					 AND ID != ".trim($post['current_unor_id'])."
				", "row");

			if (empty($query['ID'])) {
				$this->db->trans_begin();

				$this->db->set( 'UNOR_NAMA', $post['inputNamaUnor'] );
				$this->db->set( 'UNOR_NAMA_JABATAN', $post['inputNamaJabatan'] );
				$this->db->set( 'INSTANSI_ID', $post['inputInstansi'] );
							
				$this->db->where('ID', $post['current_unor_id']);
				$insert = $this->db->update('sp_unor');
				
				if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				    $success = FALSE;
				    $msg = "Gagal simpan unor.";
				}else{
				    $this->db->trans_commit();
				    $success = TRUE;
				    $msg = "Data unor berhasil disimpan.";
				}
			} else {
				$success = FALSE;
				$msg = "Data unor sudah ada.";
			}			
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function deleteunor($id){
		$result = array();
		$success = FALSE;
		// cek di riwayat jabatan ada jenis jabatan ini atau tidak
		$dataunor = "SELECT UNOR_ID
				FROM sp_unor
				WHERE ID = $id"; 
		$resultunor = $this->dbQueryCache($dataunor, 'row', 100);
		$hexa_id = $resultunor['UNOR_ID'];

		$data = $this->dbQueryCache("
					 SELECT RIWAYAT_UNOR_ID					
					 FROM sp_riwayat_unor
					 WHERE UNOR_ID = '".$hexa_id."'", "row");

		if (empty($data)) {
			$this->db->trans_begin();
			$this->db->where('ID', $id);
			$this->db->delete('sp_unor');

			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			    $msg = "Gagal hapus unor.";
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			    $msg = "Data unor berhasil dihapus.";
			}
		} else {
			$success = FALSE;
			$msg = "Data unor tidak bisa di hapus karena masih ada yang memakai.";
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function getDataUnorByDelete($offset,$rows,$id)
	{
		$dataunor = "SELECT UNOR_ID
				FROM sp_unor
				WHERE ID = $id"; 
		$resultunor = $this->dbQueryCache($dataunor, 'row', 100);
		$hexa_id = $resultunor['UNOR_ID'];

		$query = $this->dbQueryCache("
					 SELECT
					 	DISTINCT(J.NIP) AS NIP,
					 	P.NAMA_PEGAWAI AS NAMA_PEGAWAI,
						P.ALAMAT AS ALAMAT
					 FROM sp_riwayat_unor J
					 LEFT JOIN sp_pegawai P ON P.NIP = J.NIP
					 WHERE UNOR_ID = '$hexa_id'	
					 GROUP BY NIP				
					 ORDER BY J.RIWAYAT_UNOR_ID ASC
				");

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => count($query),'rows' => $data);
	}

	/**
	* Pengelolaan pendidikan
	*/
	public function getDataPendidikan($offset,$rows,$search)
	{
		$where = "";
		if( isset($search['pendidikan']) && $search['pendidikan'] != ''){
			$where .= " AND J.PENDIDIKAN_NAMA LIKE '%" .$search['pendidikan']. "%'";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	J.PENDIDIKAN_ID AS PENDIDIKAN_ID,
					 	J.PENDIDIKAN_NAMA AS PENDIDIKAN_NAMA,
						K.TINGKAT_PENDIDIKAN_NAMA AS TINGKAT_PENDIDIKAN_NAMA
					 FROM sp_pendidikan J
					 LEFT JOIN sp_tingkat_pendidikan K ON K.TINGKAT_PENDIDIKAN_ID = J.TINGKAT_PENDIDIKAN_ID					
					 WHERE 1 $where
					 ORDER BY J.TINGKAT_PENDIDIKAN_ID ASC
				");

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => count($query),'rows' => $data);
		
	}

	public function get_all_tingkat_pendidikan(){
		$arr = array();
		$query = $this->dbQueryCache("
					SELECT TINGKAT_PENDIDIKAN_ID, TINGKAT_PENDIDIKAN_NAMA
					FROM sp_tingkat_pendidikan
					ORDER BY TINGKAT_PENDIDIKAN_ID
				");

		foreach((array)$query as $k=>$v){
			$arr[] = array('id' => $v['TINGKAT_PENDIDIKAN_ID'], 'text' => $v['TINGKAT_PENDIDIKAN_NAMA']);
		}

		return $arr;
	}

	public function simpanDataPendidikan($post)
	{
		$result = array();
		$success = FALSE;
		if( $post )
		{
			$post['inputNamaPendidikan'] = trim($post['inputNamaPendidikan']);
			// ada data jabatan yang sama atau tidak
			$query['PENDIDIKAN_ID'] = '';
			$query = $this->dbQueryCache("
					 SELECT PENDIDIKAN_ID					
					 FROM sp_pendidikan
					 WHERE PENDIDIKAN_NAMA = '".$post['inputNamaPendidikan']."'
				", "row");

			if (empty($query['PENDIDIKAN_ID'])) {
				//get hexa
				$hexa = md5($post['inputNamaPendidikan'].rand(1,1000));
				$this->db->trans_begin();

				$this->db->set( 'PENDIDIKAN_ID', $hexa );
				$this->db->set( 'PENDIDIKAN_NAMA', $post['inputNamaPendidikan'] );
				$this->db->set( 'TINGKAT_PENDIDIKAN_ID', $post['inputTingkatPendidikan'] );
							
				$insert = $this->db->insert('sp_pendidikan');
				
				if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				    $success = FALSE;
				    $msg = "Gagal simpan pendidikan.";
				}else{
				    $this->db->trans_commit();
				    $success = TRUE;
				    $msg = "Data pendidikan berhasil disimpan.";
				}
			} else {
				$success = FALSE;
				$msg = "Data pendidikan sudah ada.";
			}			
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function getPendidikanById($iddidik)
	{
		$query = "SELECT PENDIDIKAN_ID, TINGKAT_PENDIDIKAN_ID, PENDIDIKAN_NAMA
				FROM sp_pendidikan
				WHERE PENDIDIKAN_ID = '$iddidik'"; 

		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	public function updateDataPendidikan($post)
	{
		$result = array();
		$success = FALSE;
		if( $post )
		{
			$post['inputNamaPendidikan'] = trim($post['inputNamaPendidikan']);
			// ada data jabatan yang sama atau tidak
			$query['PENDIDIKAN_ID'] = '';
			$query = $this->dbQueryCache("
					 SELECT PENDIDIKAN_ID					
					 FROM sp_pendidikan
					 WHERE PENDIDIKAN_NAMA = '".$post['inputNamaPendidikan']."'
					 AND PENDIDIKAN_ID != '".trim($post['current_pendidikan_id'])."'", "row");

			if (empty($query['PENDIDIKAN_ID'])) {
				$this->db->trans_begin();

				$this->db->set( 'PENDIDIKAN_NAMA', $post['inputNamaPendidikan'] );
				$this->db->set( 'TINGKAT_PENDIDIKAN_ID', $post['inputTingkatPendidikan'] );
							
				$this->db->where('PENDIDIKAN_ID', $post['current_pendidikan_id']);
				$insert = $this->db->update('sp_pendidikan');
				
				if ($this->db->trans_status() === FALSE){
				    $this->db->trans_rollback();
				    $success = FALSE;
				    $msg = "Gagal simpan pendidikan.";
				}else{
				    $this->db->trans_commit();
				    $success = TRUE;
				    $msg = "Data pendidikan berhasil disimpan.";
				}
			} else {
				$success = FALSE;
				$msg = "Data pendidikan sudah ada.";
			}			
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function deletependidikan($id){
		$result = array();
		$success = FALSE;
		// cek di riwayat pendidikan ada pendidikan ini atau tidak
		$data = $this->dbQueryCache("
					 SELECT RIWAYAT_PENDIDIKAN_ID					
					 FROM sp_riwayat_pendidikan
					 WHERE PENDIDIKAN_ID = '".$id."'", "row");

		if (empty($data)) {
			$this->db->trans_begin();
			$this->db->where('PENDIDIKAN_ID', $id);
			$this->db->delete('sp_riwayat_pendidikan');

			if ($this->db->trans_status() === FALSE){
			    $this->db->trans_rollback();
			    $success = FALSE;
			    $msg = "Gagal hapus pendidikan.";
			}else{
			    $this->db->trans_commit();
			    $success = TRUE;
			    $msg = "Data pendidikan berhasil dihapus.";
			}
		} else {
			$success = FALSE;
			$msg = "Data pendidikan tidak bisa di hapus karena masih ada yang memakai.";
		}

		$result['success'] = $success;
		$result['msg']	= $msg;
		return $result;
	}

	public function getDataPendidikanByDelete($offset,$rows,$id)
	{
		$query = $this->dbQueryCache("
					 SELECT
					 	DISTINCT(J.NIP) AS NIP,
					 	P.NAMA_PEGAWAI AS NAMA_PEGAWAI,
						P.ALAMAT AS ALAMAT
					 FROM sp_riwayat_pendidikan J
					 LEFT JOIN sp_pegawai P ON P.NIP = J.NIP
					 WHERE PENDIDIKAN_ID = '$id'	
					 GROUP BY NIP				
					 ORDER BY J.RIWAYAT_PENDIDIKAN_ID ASC
				");

		$data = array();
		foreach((array)$query as $row){
			$data[] = $row;
		}
		return array('total' => count($query),'rows' => $data);
	}
}