<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_angka_kredit_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatAngkaKredit( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE r.NIP = '$nip' ";
		}

		$query = "
			SELECT 
				r.*,
				j.*
			FROM sp_riwayat_angka_kredit r
			LEFT JOIN sp_jenjang_jabatan j ON r.JABATAN_ID = j.JENJANG_JABATAN_ID
			$where
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function saveRiwayatAngkaKredit( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);

			$this->db->set('ANGKA_KREDIT_PERTAMA',$post['AK_ANGKA_KREDIT_PERTAMA']);
			$this->db->set('JABATAN_ID',$post['AK_JABATAN_ID']);
			$this->db->set('NOMOR_SK',$post['AK_NOMOR_SK']);
			$this->db->set('TANGGAL_SK',mysql_date($post['AK_TANGGAL_SK']) );
			$this->db->set('BULAN_MULAI_PENILAIAN',$post['AK_BULAN_MULAI_PENILAIAN']);
			$this->db->set('TAHUN_MULAI_PENILAIAN',$post['AK_TAHUN_MULAI_PENILAIAN']);
			$this->db->set('BULAN_SELESAI_PENILAIAN',$post['AK_BULAN_SELESAI_PENILAIAN']);
			$this->db->set('TAHUN_SELESAI_PENILAIAN',$post['AK_TAHUN_SELESAI_PENILAIAN']);
			$this->db->set('KREDIT_UTAMA_BARU',$post['AK_KREDIT_UTAMA_BARU']);
			$this->db->set('KREDIT_PENUNJANG_BARU',$post['AK_KREDIT_PENUNJANG_BARU']);
			$this->db->set('KREDIT_BARU_TOTAL',$post['AK_KREDIT_BARU_TOTAL']);

			if( !empty($post['riwayat_angka_kredit_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_ANGKA_KREDIT_ID', $post['riwayat_angka_kredit_id']);
				$this->db->update('sp_riwayat_angka_kredit');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_angka_kredit');
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

	public function deleteRiwayatAngkaKredit( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_ANGKA_KREDIT_ID', $id);
			$this->db->delete('sp_riwayat_angka_kredit');

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