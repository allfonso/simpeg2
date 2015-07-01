<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_jabatan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	# Get data riwayat jabatan
	public function getRiwayatJabatan( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE R.NIP = '$nip' ";
		}

		$query = "
					SELECT
						RIWAYAT_JABATAN_ID AS ID,
						TRIM(U.UNOR_NAMA) AS INSTANSI,
						TRIM(T.UNOR_NAMA) AS UNIT,
						TRIM(S.UNOR_NAMA) AS SUBUNIT,
						J.JABATAN_NAMA AS JENIS_JABATAN,
						N.NAMA_JENJANG_JABATAN AS JABATAN,
						'' AS ESELON,
						DATE_FORMAT(R.TMT_JABATAN,'%d/%m/%Y') AS TMT_JABATAN,
						R.NOMOR_SK,
						DATE_FORMAT(R.TANGGAL_SK,'%d/%m/%Y') AS TANGGAL_SK,
						DATE_FORMAT(R.TMT_PELANTIKAN,'%d/%m/%Y') AS TMT_PELANTIKAN,
						P.PENETAP_NAMA AS PENETAP
					FROM sp_riwayat_jabatan R
					LEFT JOIN sp_jenis_jabatan J ON J.JABATAN_ID = R.JENIS_JABATAN_ID
					LEFT JOIN sp_jenjang_jabatan N ON N.JENJANG_JABATAN_ID = R.JENJANG_JABATAN_ID
					LEFT JOIN sp_penetap P ON P.PENETAP_ID = R.PENETAP_ID
					LEFT JOIN sp_unor U ON U.UNOR_ID = R.UNOR_ID
					LEFT JOIN sp_unor T ON T.UNOR_ID = R.UNIT_ID
					LEFT JOIN sp_unor S ON S.UNOR_ID = R.SUBUNIT_ID
					$where
					ORDER BY R.RIWAYAT_JABATAN_ID ASC
				";
		$result = $this->dbQueryCache( $query, 'all', 2 );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	# Get detail riwayat jabatan
	public function getRiwayatJabatanById( $id )
	{
		$query = "SELECT RIWAYAT_JABATAN_ID, INSTANSI_ID, UNOR_ID, UNIT_ID, SUBUNIT_ID, JENIS_JABATAN_ID, NOMOR_SK, 
						DATE_FORMAT(TANGGAL_SK,'%d-%m-%Y') AS TANGGAL_SK ,
						DATE_FORMAT(TMT_PELANTIKAN,'%d-%m-%Y') AS TMT_PELANTIKAN, 
						DATE_FORMAT(TMT_JABATAN, '%d-%m-%Y') AS TMT_JABATAN, PENETAP_ID, ESELON_ID, JENJANG_JABATAN_ID
				FROM sp_riwayat_jabatan WHERE RIWAYAT_JABATAN_ID = $id"; 
		$result = $this->dbQueryCache($query, 'row', 100);
		return $result;
	}

	# Get data jenis jabatan
	public function getJenisJabatan()
	{
		$arr = array();
		$query = "SELECT JABATAN_ID AS KODE, JABATAN_NAMA AS NAMA FROM sp_jenis_jabatan ORDER BY JABATAN_NAMA";
		$result = $this->dbQueryCache($query,'all');
		foreach((array)$result as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	# Get data jenjang jabatan
	public function getJenjangJabatan()
	{
		$arr = array();
		$query = "SELECT JENJANG_JABATAN_ID AS KODE, NAMA_JENJANG_JABATAN AS NAMA FROM sp_jenjang_jabatan ORDER BY NAMA_JENJANG_JABATAN";
		$result = $this->dbQueryCache($query,'all');
		foreach((array)$result as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function getDataRiwayatJabatanById( $id )
	{
		$query = "SELECT
						RIWAYAT_JABATAN_ID AS ID,
						TRIM(U.UNOR_NAMA) AS INSTANSI,
						TRIM(T.UNOR_NAMA) AS UNIT,
						TRIM(S.UNOR_NAMA) AS SUBUNIT,
						J.JABATAN_NAMA AS JENIS_JABATAN,
						'' AS ESELON,
						DATE_FORMAT(R.TMT_JABATAN,'%d/%m/%Y') AS TMT_JABATAN,
						R.NOMOR_SK,
						DATE_FORMAT(R.TANGGAL_SK,'%d/%m/%Y') AS TANGGAL_SK,
						DATE_FORMAT(R.TMT_PELANTIKAN,'%d/%m/%Y') AS TMT_PELANTIKAN,
						P.PENETAP_NAMA AS PENETAP
					FROM sp_riwayat_jabatan R
					LEFT JOIN sp_jenis_jabatan J ON J.JABATAN_ID = R.JENIS_JABATAN_ID
					LEFT JOIN sp_jenjang_jabatan N ON N.JENJANG_JABATAN_ID = R.JENJANG_JABATAN_ID
					LEFT JOIN sp_penetap P ON P.PENETAP_ID = R.PENETAP_ID
					LEFT JOIN sp_unor U ON U.UNOR_ID = R.UNOR_ID
					LEFT JOIN sp_unor T ON T.UNOR_ID = R.UNIT_ID
					LEFT JOIN sp_unor S ON S.UNOR_ID = R.SUBUNIT_ID
					WHERE R.RIWAYAT_JABATAN_ID = $id
					ORDER BY R.RIWAYAT_JABATAN_ID ASC";
		$result = $this->dbQueryCache($query,'row',2);
		return $result;
	}

	public function deleteRiwayatJabatan( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_JABATAN_ID', $id);
			$this->db->delete('sp_riwayat_jabatan');

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

	public function saveRiwayatJabatan( $post )
	{

		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			$this->db->set('UNOR_ID', $post['unor_id']);
			$this->db->set('UNIT_ID', $post['unit_id']);
			$this->db->set('SUBUNIT_ID', $post['subunit_id']);
			$this->db->set('JENIS_JABATAN_ID', $post['jabatan_id']);
			$this->db->set('TANGGAL_SK', mysql_date($post['tgl_sk']));
			$this->db->set('TMT_JABATAN', mysql_date($post['tmt_jabatan']));
			$this->db->set('TMT_PELANTIKAN', mysql_date($post['tmt_pelantikan']));
			$this->db->set('ESELON_ID', $post['eselon_id']);
			$this->db->set('PENETAP_ID', $post['penetap_id']);
			$this->db->set('NOMOR_SK', $post['no_sk']);
			$this->db->set('JENJANG_JABATAN_ID', $post['jenjang_jabatan_id']);

			if( !empty($post['riwayat_jabatan_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_JABATAN_ID', $post['riwayat_jabatan_id']);
				$this->db->update('sp_riwayat_jabatan');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_jabatan');
			}

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
}