<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_dp3_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatDP3( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE r.NIP = '$nip' ";
		}

		$query = "
			SELECT 
				*
			FROM sp_riwayat_dp3 r
			LEFT JOIN sp_jenis_jabatan j ON r.JENIS_JABATAN_ID = j.JABATAN_ID 
			$where
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function saveRiwayatDP3( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			
			$this->db->set('JENIS_JABATAN_ID',$post['JENIS_JABATAN_ID']);
			$this->db->set('TAHUN',$post['TAHUN']);
			$this->db->set('KESETIAAN',$post['KESETIAAN']);
			$this->db->set('PRESTASI_KERJA',$post['PRESTASI_KERJA']);
			$this->db->set('TANGGUNG_JAWAB',$post['TANGGUNG_JAWAB']);
			$this->db->set('KETAATAN',$post['KETAATAN']);
			$this->db->set('KEJUJURAN',$post['KEJUJURAN']);
			$this->db->set('KERJASAMA',$post['KERJASAMA']);
			$this->db->set('PRAKARSA',$post['PRAKARSA']);
			$this->db->set('KEPEMIMPINAN',$post['KEPEMIMPINAN']);
			$this->db->set('JUMLAH',$post['JUMLAH']);
			$this->db->set('NILAI_RATA_RATA',$post['NILAI_RATA_RATA']);


			if( !empty($post['riwayat_dp3_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_DP3_ID', $post['riwayat_dp3_id']);
				$this->db->update('sp_riwayat_dp3');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_dp3');
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

	public function deleteRiwayatDP3( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_DP3_ID', $id);
			$this->db->delete('sp_riwayat_dp3');

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