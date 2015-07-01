<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listing_model extends MY_Model
{
	public function __construct(){
		parent::__construct();		
	}

	public function getListingUnor( $parent_id = NULL, $level = 1 )
	{
		if( $parent_id == NULL ){
			$where = " AND UNOR_INDUK = '1'  ";
		}else{
			$where = " AND DIATASAN_ID = '$parent_id' ";
		}
		$query = "
				SELECT 
					UNOR_ID AS ID, 
					TRIM(UNOR_NAMA) AS NAMA,
					DIATASAN_ID AS PARENT
				FROM sp_unor 
				WHERE 
					UNOR_ID NOT IN (
						SELECT 
							UNOR_ID 
						FROM sp_unor 
						WHERE JENIS_UNOR_ID IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F')
						)
					$where ";
		$result = $this->dbQueryCache($query);

		$arr = array();
		foreach((array)$result as $row){
			if( $level < 3 && $parent_id != 'A8ACA73E021F3912E040640A040269BB' )
			{
				$arr[] = array(
					'id' => $row['ID'],
					'name' => $row['NAMA'] ,
					'parent' => $row['PARENT'],
					'url' => ($parent_id) ? "$parent_id/$row[ID]" : "$row[ID]",
					'level' => $level,
					'children' => $this->getListingUnor( $row['ID'],($level+1) )
				);
			}

		}

		return $arr;
	}

	public function getListingDUK( $parent_id, $sub_parent = null )
	{
		$sub = "";
		if( $sub_parent  ){
			$sub = " OR UNOR_ID = '" .$sub_parent. "' ";
		}else{
			$sub = " OR UNOR_ID = '" .$parent_id. "' ";
		}

		$query = "
			SELECT
				peg.NIP,
				peg.NIP_LAMA,
				TRIM(CONCAT(peg.GELAR_DEPAN,' ',peg.GELAR_LAIN,' ', UPPER(peg.NAMA_PEGAWAI),' ', peg.GELAR_BELAKANG)) AS NAMA,
				peg.TEMPAT_LAHIR,
				DATE_FORMAT(peg.TANGGAL_LAHIR,'%d/%m/%Y') AS TANGGAL_LAHIR,
				CONCAT(peg.TEMPAT_LAHIR,', ',DATE_FORMAT(peg.TANGGAL_LAHIR,'%d/%m/%Y')) AS TTL,
				gol.GOLONGAN_NAMA AS PANGKAT,
				gol.GOLONGAN_KODE AS GOLONGAN,
				DATE_FORMAT(gol.TMT_GOLONGAN,'%d/%m/%Y') AS TMT_GOLONGAN,
				jab.JABATAN AS JABATAN,
				run.UNOR,
				run.UNIT,
				run.SUB_UNIT,
				sa.AGAMA_NAMA AS AGAMA,
				pend.PENDIDIKAN,
				peg.TMT_SK_CPNS
			FROM sp_pegawai peg
			LEFT JOIN sp_agama sa ON sa.AGAMA_ID = peg.AGAMA_ID
			LEFT JOIN ( 
						SELECT
							srg.NIP,
							sg.GOLONGAN_ID,
							sg.GOLONGAN_KODE,
							sg.GOLONGAN_NAMA,
							srg.TMT_GOLONGAN
						FROM sp_riwayat_golongan srg 
						LEFT JOIN sp_golongan sg ON sg.GOLONGAN_ID = srg.GOLONGAN_ID
						WHERE srg.RIWAYAT_GOLONGAN_ID = (SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = srg.NIP )
					) gol ON gol.NIP = peg.NIP
			LEFT JOIN (	
						SELECT
							srj.NIP,
							TRIM(su.UNOR_NAMA) AS INSTANSI,
							su.UNOR_NAMA_JABATAN AS JABATAN
						FROM sp_riwayat_jabatan srj
						LEFT JOIN sp_unor su ON srj.UNOR_ID = su.UNOR_ID AND su.JENIS_UNOR_ID NOT IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F')
						WHERE srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = srj.NIP )
					) jab ON jab.NIP = peg.NIP
			LEFT JOIN (
				SELECT 
					sru.NIP,
					su.UNOR_ID,
					TRIM(su.UNOR_NAMA) AS UNOR,
					TRIM(su1.UNOR_NAMA) AS UNIT,
					TRIM(su2.UNOR_NAMA) AS SUB_UNIT
				FROM sp_riwayat_unor sru
				LEFT JOIN sp_unor su ON sru.UNOR_ID = su.UNOR_ID
				LEFT JOIN sp_unor su1 ON sru.UNIT_ID = su1.UNOR_ID
				LEFT JOIN sp_unor su2 ON sru.SUBUNIT_ID = su2.UNOR_ID
				WHERE sru.RIWAYAT_UNOR_ID = (SELECT MAX(RIWAYAT_UNOR_ID) FROM sp_riwayat_unor WHERE NIP = sru.NIP )
				AND su.JENIS_UNOR_ID NOT IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F')
			) run ON run.NIP = peg.NIP
			LEFT JOIN (
				SELECT 
					sp.NIP,
					tp.TINGKAT_PENDIDIKAN_NAMA AS PENDIDIKAN
				FROM sp_riwayat_pendidikan sp
				LEFT JOIN sp_tingkat_pendidikan tp ON tp.TINGKAT_PENDIDIKAN_ID = sp.TINGKAT_PENDIDIKAN_ID
				WHERE sp.RIWAYAT_PENDIDIKAN_ID = (SELECT MAX(RIWAYAT_PENDIDIKAN_ID) FROM sp_riwayat_pendidikan WHERE NIP = sp.NIP )
			) pend ON pend.NIP = peg.NIP
			WHERE 
				peg.KEDUDUKAN_ID = '01'
				AND run.UNOR_ID IN( 
						SELECT 
							UNOR_ID 
						FROM sp_unor 
						WHERE JENIS_UNOR_ID NOT IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F') 
						AND DIATASAN_ID = '" .$parent_id. "'  
						$sub
				)
				
			ORDER BY gol.GOLONGAN_ID DESC
		";

		return $this->dbQueryCache( $query );
	}

	public function getListingNominatif( $parent_id, $sub_parent = null )
	{
		$sub = "";
		if( $sub_parent  ){
			$sub = " OR UNOR_ID = '" .$sub_parent. "' ";
		}else{
			$sub = " OR UNOR_ID = '" .$parent_id. "' ";
		}

		$query = "
				SELECT
						peg.NIP,
						peg.NIP_LAMA,
						TRIM(CONCAT(peg.GELAR_DEPAN,' ',peg.GELAR_LAIN,' ', UPPER(peg.NAMA_PEGAWAI),' ', peg.GELAR_BELAKANG)) AS NAMA,
						peg.TEMPAT_LAHIR,
						DATE_FORMAT(peg.TANGGAL_LAHIR,'%d/%m/%Y') AS TANGGAL_LAHIR,
						CONCAT(peg.TEMPAT_LAHIR,', ',DATE_FORMAT(peg.TANGGAL_LAHIR,'%d/%m/%Y')) AS TTL,
						gol.GOLONGAN_NAMA AS PANGKAT,
						gol.GOLONGAN_KODE AS GOLONGAN,
						DATE_FORMAT(gol.TMT_GOLONGAN,'%d/%m/%Y') AS TMT_GOLONGAN,
						jab.JABATAN AS JABATAN,
						run.UNOR,
						run.UNIT,
						run.SUB_UNIT,
						sa.AGAMA_NAMA AS AGAMA,
						pend.PENDIDIKAN,
						peg.TMT_SK_CPNS
					FROM sp_pegawai peg
					LEFT JOIN sp_agama sa ON sa.AGAMA_ID = peg.AGAMA_ID
					LEFT JOIN ( 
								SELECT
									srg.NIP,
									sg.GOLONGAN_ID,
									sg.GOLONGAN_KODE,
									sg.GOLONGAN_NAMA,
									srg.TMT_GOLONGAN
								FROM sp_riwayat_golongan srg 
								LEFT JOIN sp_golongan sg ON sg.GOLONGAN_ID = srg.GOLONGAN_ID
								WHERE srg.RIWAYAT_GOLONGAN_ID = (SELECT MAX(RIWAYAT_GOLONGAN_ID) FROM sp_riwayat_golongan WHERE NIP = srg.NIP )
							) gol ON gol.NIP = peg.NIP
					LEFT JOIN (	
								SELECT
									srj.NIP,
									TRIM(su.UNOR_NAMA) AS INSTANSI,
									su.UNOR_NAMA_JABATAN AS JABATAN
								FROM sp_riwayat_jabatan srj
								LEFT JOIN sp_unor su ON srj.UNOR_ID = su.UNOR_ID AND su.JENIS_UNOR_ID NOT IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F')
								WHERE srj.RIWAYAT_JABATAN_ID = (SELECT MAX(RIWAYAT_JABATAN_ID) FROM sp_riwayat_jabatan WHERE NIP = srj.NIP )
							) jab ON jab.NIP = peg.NIP
					LEFT JOIN (
						SELECT 
							sru.NIP,
							su.UNOR_ID,
							su1.UNOR_ID AS UNIT_ID,
							su2.UNOR_ID AS SUBUNIT_ID,
							TRIM(su.UNOR_NAMA) AS UNOR,
							TRIM(su1.UNOR_NAMA) AS UNIT,
							TRIM(su2.UNOR_NAMA) AS SUB_UNIT
						FROM sp_riwayat_unor sru
						LEFT JOIN sp_unor su ON sru.UNOR_ID = su.UNOR_ID
						LEFT JOIN sp_unor su1 ON sru.UNIT_ID = su1.UNOR_ID
						LEFT JOIN sp_unor su2 ON sru.SUBUNIT_ID = su2.UNOR_ID
						WHERE sru.RIWAYAT_UNOR_ID = (SELECT MAX(RIWAYAT_UNOR_ID) FROM sp_riwayat_unor WHERE NIP = sru.NIP )
						AND su.JENIS_UNOR_ID NOT IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F')
						ORDER BY su1.UNOR_ID, su2.UNOR_ID ASC
					) run ON run.NIP = peg.NIP
					LEFT JOIN (
						SELECT 
							sp.NIP,
							tp.TINGKAT_PENDIDIKAN_NAMA AS PENDIDIKAN
						FROM sp_riwayat_pendidikan sp
						LEFT JOIN sp_tingkat_pendidikan tp ON tp.TINGKAT_PENDIDIKAN_ID = sp.TINGKAT_PENDIDIKAN_ID
						WHERE sp.RIWAYAT_PENDIDIKAN_ID = (SELECT MAX(RIWAYAT_PENDIDIKAN_ID) FROM sp_riwayat_pendidikan WHERE NIP = sp.NIP )
					) pend ON pend.NIP = peg.NIP
					WHERE 
						peg.KEDUDUKAN_ID = '01'
						AND run.UNOR_ID IN( 
								SELECT 
									UNOR_ID 
								FROM sp_unor 
								WHERE JENIS_UNOR_ID NOT IN('AA9BB59D5863D683E040640A02023F0F','A47C73FB33E93BD5E040640A0402162E','AA9BB59D5865D683E040640A02023F0F') 
								AND DIATASAN_ID = '$parent_id' $sub  
		
						)
						
					ORDER BY run.UNIT, run.SUB_UNIT ASC";
		return $this->dbQueryCache( $query );
	}

	public function getUnorByKode( $kode )
	{
		return $this->dbQueryCache("SELECT TRIM(UNOR_NAMA) AS NAMA FROM sp_unor WHERE UNOR_ID = '$kode'",'one');
	}
}