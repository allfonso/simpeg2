<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_diklat_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatDiklat( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE R.NIP = '$nip' ";
		}

		$query = "
			SELECT
				RIWAYAT_DIKLAT_ID AS ID, 
				CASE WHEN R.JENIS_DIKLAT_ID = 0 THEN '-'
				ELSE J.JENIS_DIKLAT_NAMA END JENIS_DIKLAT,
				S.DIKLAT_STRUKTURAL_NAMA AS DIKLAT_STRUKTURAL,
				R.NIP,
				R.NAMA_DIKLAT,
				DATE_FORMAT(R.TANGGAL_MULAI,'%d/%m/%Y') AS TANGGAL_MULAI,
				DATE_FORMAT(R.TANGGAL_SELESAI,'%d/%m/%Y') AS TANGGAL_SELESAI,
				R.NOMOR_SERTIFIKAT,
				R.JUMLAH_PJL,
				R.PENYELENGGARA
			FROM sp_riwayat_diklat R
			LEFT JOIN sp_jenis_diklat J ON J.JENIS_DIKLAT_ID = R.JENIS_DIKLAT_ID
			LEFT JOIN sp_diklat_struktural S ON S.DIKLAT_STRUKTURAL_ID = R.DIKLAT_STRUKTURAL_ID
			$where
			ORDER BY R.RIWAYAT_DIKLAT_ID
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function getDetailRiwayatDiklat( $id )
	{
		if($id)
		{
			$query = $this->dbQueryCache("
				SELECT
					D.RIWAYAT_DIKLAT_ID,
					D.JENIS_DIKLAT_ID AS JENIS_DIKLAT,
					D.DIKLAT_STRUKTURAL_ID AS DIKLAT_STRUKTURAL,
					D.NAMA_DIKLAT,
					DATE_FORMAT(D.TANGGAL_MULAI,'%d-%m-%Y') AS TANGGAL_MULAI,
					DATE_FORMAT(D.TANGGAL_MULAI,'%d-%m-%Y') AS TANGGAL_SELESAI,
					D.NOMOR_SERTIFIKAT,
					D.JUMLAH_PJL,
					D.PENYELENGGARA
				FROM sp_riwayat_diklat D WHERE D.RIWAYAT_DIKLAT_ID = $id
			",'row',2);
			return $query;
		}
	}

	public function saveRiwayatDiklat( $post )
	{
		if($post)
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			$this->db->set('JENIS_DIKLAT_ID', $post['jenis_diklat']);
			$this->db->set('DIKLAT_STRUKTURAL_ID', $post['diklat_struktural']);
			$this->db->set('NAMA_DIKLAT', $post['nama_diklat']);
			$this->db->set('TANGGAL_MULAI', mysql_date($post['tanggal_mulai']));
			$this->db->set('TANGGAL_SELESAI', mysql_date($post['tanggal_selesai']));
			$this->db->set('NOMOR_SERTIFIKAT', $post['no_sertifikat']);
			$this->db->set('JUMLAH_PJL', $post['jumlah_pjl']);
			$this->db->set('PENYELENGGARA', $post['penyelenggara']);

			if( !empty($post['riwayat_diklat_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_DIKLAT_ID', $post['riwayat_diklat_id']);
				$this->db->update('sp_riwayat_diklat');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_diklat');
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

	public function deleteRiwayatDiklat( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_DIKLAT_ID', $id);
			$this->db->delete('sp_riwayat_diklat');

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