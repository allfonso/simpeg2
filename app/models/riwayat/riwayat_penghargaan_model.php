<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_penghargaan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatPenghargaan( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE r.NIP = '$nip' ";
		}

		$query = "
			SELECT 
				r.RIWAYAT_PENGHARGAAN_ID,
				r.PENGHARGAAN_ID,
				p.PENGHARGAAN_NAMA AS NAMA_PENGHARGAAN,
				r.NOMOR_SK,
				DATE_FORMAT(r.TANGGAL_SK,'%d-%m-%Y') AS TANGGAL_SK,
				r.TANGGAL_SK AS TANGGAL_SK_EDITED	
			FROM sp_riwayat_penghargaan r 
			LEFT JOIN sp_penghargaan p ON r.PENGHARGAAN_ID = p.PENGHARGAAN_ID 
			$where
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function getNamaPenghargaan( $id )
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT PENGHARGAAN_ID AS KODE, PENGHARGAAN_NAMA AS NAMA 
										FROM sp_penghargaan WHERE TINGKAT_PENDIDIKAN_ID = $id",'all',600);
		foreach((array)$query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function saveRiwayatPenghargaan( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			$this->db->set('PENGHARGAAN_ID', $post['jenis_penghargaan_id']);
			$this->db->set('TANGGAL_SK', mysql_date($post['penghargaan_tgl_sk']) );
			$this->db->set('NOMOR_SK', $post['penghargaan_no_sk']);

			if( !empty($post['riwayat_penghargaan_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_PENGHARGAAN_ID', $post['riwayat_penghargaan_id']);
				$this->db->update('sp_riwayat_penghargaan');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_penghargaan');
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

	public function deleteRiwayatPenghargaan( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_PENGHARGAAN_ID', $id);
			$this->db->delete('sp_riwayat_penghargaan');

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