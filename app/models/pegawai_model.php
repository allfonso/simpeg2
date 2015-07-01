<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_data_pegawai($nip=null,$nama=null)
	{
		$query = $this->db->query("
				SELECT
					A.NIP AS NIP,
					TRIM(CONCAT(TRIM(A.GELAR_DEPAN),' ',TRIM(A.NAMA),' ',TRIM(A.GELAR_BELAKANG))) AS NAMA,
					'Golongan' AS GOLONGAN,
					'Jabatan' AS JABATAN,
					'Instansi' AS INSTANSI
				FROM sp_pegawai A 
			");
		return ($query->num_rows() > 0) ? $query:FALSE;
	}

	public function simpan_pegawai($arr,$id=null)
	{
		$this->db->trans_begin();
		foreach((array)$arr as $field=>$value)
		{
			$this->db->set($field,$value);
		}

		if( $id == null )
		{
			$this->db->insert('sp_pegawai');
		}else{
			$this->db->where('NIP',$id);
			$this->db->update('sp_pegawai');
		}

		if ($this->db->trans_status() === FALSE)
		{
		    $this->db->trans_rollback();
		    $success = FALSE;
		}else{
		    $this->db->trans_commit();
		    $success = TRUE;
		}

		return $success;
	}


}