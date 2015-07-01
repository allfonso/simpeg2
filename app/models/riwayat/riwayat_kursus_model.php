<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat_kursus_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	public function getRiwayatKursus( $nip = null, $json = true )
	{
		$where = "";
		if( $nip ){
			$where = " WHERE r.NIP = '$nip' ";
		}

		$query = "
			SELECT 
				r.RIWAYAT_KURSUS_ID AS ID,
				i.INSTANSI_NAMA,
				i.INSTANSI_ID,
				r.NAMA_KURSUS,
				r.JUMLAH_JAM,
				DATE_FORMAT(r.TANGGAL_KURSUS,'%d-%m-%Y') AS TANGGAL_KURSUS,
				r.TAHUN_KURSUS,
				r.INSTITUSI_PENYELENGGARA,
				r.NOMOR_SERTIFIKAT,
				CASE 
					WHEN r.TIPE_KURSUS = 'K' THEN 'Kursus'
					WHEN r.TIPE_KURSUS = 'S' THEN 'Sertifikat'
				ELSE '-'
				END TIPE_KURSUS				
			FROM sp_riwayat_kursus r LEFT JOIN sp_instansi i ON i.INSTANSI_ID = r.INSTANSI_ID 
			$where
		";
		$result = $this->dbQueryCache( $query );
		if( $json ){
			return array('total' => count($result),'rows' => $result);
		}
		return $result;
	}

	public function getDetailRiwayatKursus($id)
	{
		if($id)
		{
			$query = $this->dbQueryCache("
				SELECT *, DATE_FORMAT(TANGGAL_KURSUS,'%d-%m-%Y') AS TGL_KURSUS FROM sp_riwayat_kursus WHERE RIWAYAT_KURSUS_ID = $id",'row',2);
			return $query;
		}
	}

	public function getNamaKursus( $id )
	{
		$arr = array();
		$query = $this->dbQueryCache("SELECT PENDIDIKAN_ID AS KODE, PENDIDIKAN_NAMA AS NAMA 
										FROM sp_pendidikan WHERE TINGKAT_PENDIDIKAN_ID = $id",'all',600);
		foreach((array)$query as $row){
			$arr[$row['KODE']] = $row['NAMA'];
		}
		return $arr;
	}

	public function saveRiwayatKursus( $post )
	{
		if( $post )
		{
			$this->db->trans_begin();
			$this->db->set('NIP', $post['nip']);
			//$this->db->set('KURSUS_ID', $post['tingkat_pendidikan']);
			$this->db->set('NAMA_KURSUS', $post['nama_kursus']);
			$this->db->set('TANGGAL_KURSUS', mysql_date($post['tanggal_kursus']) );
			$this->db->set('JUMLAH_JAM', $post['jumlah_jam']);
			$this->db->set('TAHUN_KURSUS', $post['tahun_kursus']);
			$this->db->set('INSTANSI_ID', $post['instansi']);
			$this->db->set('INSTITUSI_PENYELENGGARA', $post['institusi_penyelenggara']);
			$this->db->set('TIPE_KURSUS', $post['tipe_kursus']);
			$this->db->set('NOMOR_SERTIFIKAT', $post['nomor_sertifikat']);

			if( !empty($post['riwayat_kursus_id']) )
			{
				$this->db->set('USERUPDATE', user_id());
				$this->db->set('UPDATEDATE', 'NOW()', FALSE);
				$this->db->where('RIWAYAT_KURSUS_ID', $post['riwayat_kursus_id']);
				$this->db->update('sp_riwayat_kursus');
			}
			else
			{
				$this->db->set('USERINSERT', user_id());
				$this->db->set('INSERTDATE', 'NOW()', FALSE);
				$this->db->insert('sp_riwayat_kursus');
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

	public function deleteRiwayatKursus( $id )
	{
		if($id){
			$this->db->trans_begin();
			$this->db->where('RIWAYAT_KURSUS_ID', $id);
			$this->db->delete('sp_riwayat_kursus');

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