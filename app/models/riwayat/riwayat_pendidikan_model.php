<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_pendidikan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatPendidikan( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE R.NIP = '$nip' ";
		}

		$query = "
			SELECT
				r.RIWAYAT_PENDIDIKAN_ID AS ID, 
				t.TINGKAT_PENDIDIKAN_NAMA AS JENJANG,
				p.PENDIDIKAN_NAMA AS NAMA_PENDIDIKAN,
				DATE_FORMAT(r.TANGGAL_LULUS,'%d-%m-%Y') AS TANGGAL_LULUS,
				r.TAHUN_LULUS AS TAHUN_LULUS,
				r.NOMOR_IJAZAH AS NOMOR_IJAZAH,
				r.NAMA_SEKOLAH AS NAMA_SEKOLAH,
				r.GELAR_DEPAN AS GELAR_DEPAN,
				r.GELAR_BELAKANG AS GELAR_BELAKANG,
				s.STATUS_PENDIDIKAN_NAMA AS STATUS_PENDIDIKAN
			FROM sp_riwayat_pendidikan r
			LEFT JOIN sp_tingkat_pendidikan t ON t.TINGKAT_PENDIDIKAN_ID = r.TINGKAT_PENDIDIKAN_ID
			LEFT JOIN sp_pendidikan p ON p.PENDIDIKAN_ID = r.PENDIDIKAN_ID
			LEFT JOIN sp_status_pendidikan s ON s.STATUS_PENDIDIKAN_ID = r.STATUS_PENDIDIKAN
			$where
			ORDER BY r.RIWAYAT_PENDIDIKAN_ID
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function getDetailRiwayatPendidikan($id)
	{
		if($id)
		{
			$query = $this->dbQueryCache("
				SELECT
					r.RIWAYAT_PENDIDIKAN_ID,
					r.TINGKAT_PENDIDIKAN_ID,
					r.PENDIDIKAN_ID,
					DATE_FORMAT(r.TANGGAL_LULUS,'%d-%m-%Y') AS TANGGAL_LULUS,
					r.TAHUN_LULUS,
					r.NOMOR_IJAZAH,
					r.NAMA_SEKOLAH,
					r.GELAR_DEPAN,
					r.GELAR_BELAKANG,
					r.STATUS_PENDIDIKAN
				FROM sp_riwayat_pendidikan r
				WHERE r.RIWAYAT_PENDIDIKAN_ID = $id",'row',2);
			return $query;
		}
	}

	public function getNamaPendidikan( $id )
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT PENDIDIKAN_ID AS KODE, PENDIDIKAN_NAMA AS NAMA 
										FROM sp_pendidikan WHERE TINGKAT_PENDIDIKAN_ID = $id",'all',600);
		foreach((array)$query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function saveRiwayatPendidikan( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			$this->db->set('TINGKAT_PENDIDIKAN_ID', $post['tingkat_pendidikan']);
			$this->db->set('PENDIDIKAN_ID', $post['nama_pendidikan']);
			$this->db->set('TANGGAL_LULUS', mysql_date($post['tanggal_lulus']) );
			$this->db->set('TAHUN_LULUS', $post['tahun_lulus']);
			$this->db->set('NOMOR_IJAZAH', $post['nomor_ijazah']);
			$this->db->set('NAMA_SEKOLAH', $post['nama_sekolah']);
			$this->db->set('GELAR_DEPAN', $post['gelar_depan']);
			$this->db->set('GELAR_BELAKANG', $post['gelar_belakang']);
			$this->db->set('STATUS_PENDIDIKAN', $post['status_pendidikan']);

			if( !empty($post['riwayat_pendidikan_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_PENDIDIKAN_ID', $post['riwayat_pendidikan_id']);
				$this->db->update('sp_riwayat_pendidikan');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_pendidikan');
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

	public function deleteRiwayatPendidikan( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_PENDIDIKAN_ID', $id);
			$this->db->delete('sp_riwayat_pendidikan');

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