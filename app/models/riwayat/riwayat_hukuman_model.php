<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_hukuman_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatHukuman( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE r.NIP = '$nip' ";
		}

		$query = "
			SELECT
				r.RIWAYAT_HUKUMAN_ID,
				r.JENIS_HUKUMAN_ID,
				r.NOMOR_SK,
				DATE_FORMAT(r.TANGGAL_SK,'%d-%m-%Y') AS TANGGAL_SK,
				r.TANGGAL_SK AS TANGGAL_SK_EDIT,
				DATE_FORMAT(r.TANGGAL_MULAI_HUKUM,'%d-%m-%Y') AS TANGGAL_MULAI_HUKUM,
				r.TANGGAL_MULAI_HUKUM AS TANGGAL_MULAI_HUKUM_EDIT,
				DATE_FORMAT(r.TANGGAL_AKHIR_HUKUM,'%d-%m-%Y') AS TANGGAL_AKHIR_HUKUM,
				r.TANGGAL_AKHIR_HUKUM AS TANGGAL_AKHIR_HUKUM_EDIT,
				r.MASA_TAHUN,
				r.MASA_BULAN,
				r.NOMOR_PP,
				r.GOLONGAN_ID,
				g.GOLONGAN_NAMA AS GOLONGAN,
				r.NOMOR_SK_BATAL,
				r.TANGGAL_SK_BATAL,
				r.TANGGAL_SK_BATAL AS TANGGAL_SK_BATAL_EDIT
			FROM sp_riwayat_hukuman r
			LEFT JOIN sp_jenis_hukuman j ON r.JENIS_HUKUMAN_ID = j.JENIS_HUKUMAN_ID
			LEFT JOIN sp_golongan g ON r.GOLONGAN_ID = g.GOLONGAN_ID
			$where ORDER BY r.RIWAYAT_HUKUMAN_ID
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function getJenisHukuman()
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT 
										JENIS_HUKUMAN_ID AS KODE,
										JENIS_HUKUMAN_NAMA AS NAMA
									FROM sp_jenis_hukuman",'all',600);
		foreach((array)$query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function saveRiwayatHukuman( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);

			$this->db->set('JENIS_HUKUMAN_ID',$post['jenis_hukuman_id']);
			$this->db->set('NOMOR_SK',$post['no_sk']);
			$this->db->set('TANGGAL_SK',mysql_date($post['tgl_sk']) );
			$this->db->set('TANGGAL_MULAI_HUKUM',mysql_date($post['tanggal_mulai_hukuman']) );
			$this->db->set('TANGGAL_AKHIR_HUKUM',mysql_date($post['tanggal_akhir_hukuman']) );
			$this->db->set('MASA_TAHUN',$post['masa_tahun']);
			$this->db->set('MASA_BULAN',$post['masa_bulan']);
			$this->db->set('NOMOR_PP',$post['nomor_pp']);
			$this->db->set('GOLONGAN_ID',$post['golongan_id']);
			$this->db->set('NOMOR_SK_BATAL',$post['no_sk_batal']);
			$this->db->set('TANGGAL_SK_BATAL',mysql_date($post['tgl_sk_batal']) );

			if( !empty($post['riwayat_hukuman_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_HUKUMAN_ID', $post['riwayat_hukuman_id']);
				$this->db->update('sp_riwayat_hukuman');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_hukuman');
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

	public function deleteRiwayatHukuman( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_HUKUMAN_ID', $id);
			$this->db->delete('sp_riwayat_hukuman');

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