<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_golongan_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	# Get riwayat golongan
	public function getRiwayatGolongan( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE R.NIP = '$nip' ";
		}

		$query = $this->dbQueryCache("
					 SELECT
					 	R.RIWAYAT_GOLONGAN_ID AS ID,
						R.KODE_JENIS_KP AS JENIS_KP,
						R.NIP,
						R.NOMOR_SK,
						DATE_FORMAT(R.TANGGAL_SK,'%d/%m/%Y') AS TANGGAL_SK,
						DATE_FORMAT(R.TMT_GOLONGAN,'%d/%m/%Y') AS TMT_GOLONGAN,
						R.TANGGAL_SK AS EDIT_TANGGAL_SK,
						R.TMT_GOLONGAN AS EDIT_TMT_GOLONGAN,
						CONCAT(G.GOLONGAN_KODE,' - ',G.GOLONGAN_NAMA) AS GOLONGAN,
						G.GOLONGAN_ID,
						R.NOMOR_BKN,
						DATE_FORMAT(R.TANGGAL_BKN,'%d/%m/%Y') AS TANGGAL_BKN,
						R.TANGGAL_BKN AS EDIT_TANGGAL_BKN,
						R.ANGKA_KREDIT_UTAMA,
						R.ANGKA_KREDIT_TAMBAHAN,
						R.MASA_KERJA_TAHUN,
						R.MASA_KERJA_BULAN,
						P.PENETAP_NAMA AS PENETAP,
						R.PENETAP_ID
					 FROM sp_riwayat_golongan R
					 LEFT JOIN sp_golongan G ON G.GOLONGAN_ID = R.GOLONGAN_ID
					 LEFT JOIN sp_penetap P ON P.PENETAP_ID = R.PENETAP_ID
					 $where
					 ORDER BY R.RIWAYAT_GOLONGAN_ID ASC
				");
		if( $json ){
			return array('total' => count($query),'rows' => $query);
		}

		return $query;
	}

	# Get Pangkat Golongan
	public function getPangkatGolongan()
	{
		$arr = array();
		$query = "SELECT GOLONGAN_ID AS KODE, CONCAT(GOLONGAN_KODE,' - ',GOLONGAN_NAMA) AS NAMA FROM sp_golongan ORDER BY GOLONGAN_ID";
		$result = $this->dbQueryCache($query,'all');
		foreach((array)$result as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	# Get detail data riwayat golongan
	public function getDetailRiwayatGolongan( $id )
	{
		if($id)
		{
			$query = "SELECT 
						RIWAYAT_GOLONGAN_ID,
						NIP,
						KODE_JENIS_KP,
						NOMOR_SK,
						DATE_FORMAT(TANGGAL_SK,'%d-%m-%Y') AS TANGGAL_SK,
						DATE_FORMAT(TMT_GOLONGAN,'%d-%m-%Y') AS TMT_GOLONGAN,
						DATE_FORMAT(TANGGAL_BKN,'%d-%m-%Y') AS TANGGAL_BKN,
						NOMOR_BKN,
						GOLONGAN_ID,
						MASA_KERJA_TAHUN,
						MASA_KERJA_BULAN,
						ANGKA_KREDIT_UTAMA,
						ANGKA_KREDIT_TAMBAHAN,
						PENETAP_ID
					FROM sp_riwayat_golongan WHERE RIWAYAT_GOLONGAN_ID = ".$id;
			$run = $this->dbQueryCache($query,'row',2);
			return $run;
		}
	}

	# Simpan data riwayat golongan
	public function saveRiwayatGolongan( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			$this->db->set('KODE_JENIS_KP', $post['kode_jenis_kp']);
			$this->db->set('NOMOR_SK', $post['no_sk_gol']);
			$this->db->set('TANGGAL_SK', mysql_date($post['tgl_sk_gol']));
			$this->db->set('TMT_GOLONGAN', mysql_date($post['tmt_golongan']));
			$this->db->set('NOMOR_BKN', $post['no_bkn']);
			$this->db->set('TANGGAL_BKN', mysql_date($post['tgl_bkn']));
			$this->db->set('GOLONGAN_ID', $post['golongan_id']);
			$this->db->set('MASA_KERJA_TAHUN', $post['masa_kerja_tahun']);
			$this->db->set('MASA_KERJA_BULAN', $post['masa_kerja_bulan']);
			$this->db->set('ANGKA_KREDIT_UTAMA', $post['angka_kredit_utama']);
			$this->db->set('ANGKA_KREDIT_TAMBAHAN', $post['angka_kredit_tambahan']);
			$this->db->set('PENETAP_ID', $post['penetap_id']);

			if( isset($post['riwayat_golongan_id']) && !empty($post['riwayat_golongan_id']) )
			{
				$this->db->set('USERUPDATE', user_id() );
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('riwayat_golongan_id', $post['riwayat_golongan_id']);
				$save = $this->db->update('sp_riwayat_golongan');
			}
			else
			{
				$this->db->set('USERINSERT', user_id() );
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$save = $this->db->insert('sp_riwayat_golongan');
			}

			if( $save && $this->db->trans_status() === TRUE )
			{
				$this->setLastGolongan( $post['nip'],$post['golongan_id'] );
				$this->db->trans_commit();
			    $success = TRUE;
			}
			else
			{
				$this->db->trans_rollback();
			    $success = FALSE;
			}
			return $success;
		}
	}

	public function setLastGolongan( $nip, $last_golongan_id )
	{
		$this->db->set('GOLONGAN_ID', $last_golongan_id);
		$this->db->where('NIP', $nip);
		return $this->db->update('sp_pegawai');
	}

	public function updateLastGolongan($nip)
	{
		$query = $this->db->query("SELECT MAX(RIWAYAT_GOLONGAN_ID), GOLONGAN_ID FROM sp_riwayat_golongan WHERE NIP = '$nip' ");
		$result = $query->row();

		if($result->GOLONGAN_ID){
			$this->setLastGolongan($nip,$result->GOLONGAN_ID);
		}
	}

	# Hapus data riwayat golongan
	public function deleteRiwayatGolongan( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_GOLONGAN_ID', $id);
			$this->db->delete('sp_riwayat_golongan');

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