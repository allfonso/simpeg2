<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap_model extends MY_Model
{
	private $unor;
	public function __construct(){
		parent::__construct();
		$this->getUnor();
	}

	public function getUnor()
	{
		$query = "SELECT s.UNOR_ID, TRIM(s.UNOR_NAMA) AS UNOR FROM sp_unor s WHERE UNOR_INDUK = '1' ORDER BY s.ORDERBY";
		$this->unor = $this->dbQueryCache( $query, 'all', 300);
	}

	public function getRekapPerInstansi()
	{
		$arr = array();
		$total_laki_laki = $total_perempuan = 0;
		foreach((array)$this->unor as $row)
		{
			$lakilaki = $this->countByInstansi($row['UNOR_ID'],1);
			$perempuan = $this->countByInstansi($row['UNOR_ID'],2);

			$arr[] = array('UNOR' => $row['UNOR'], 'TOTAL_LAKI_LAKI' => $lakilaki,'TOTAL_PEREMPUAN' => $perempuan);
			$total_laki_laki += $lakilaki;
			$total_perempuan += $perempuan;
		}

		return array(
						'total' => count($arr), 
						'rows' => $arr, 
						'footer' => array( array(
										'UNOR' => 'TOTAL',
										'TOTAL_LAKI_LAKI' => $total_laki_laki,
										'TOTAL_PEREMPUAN' => $total_perempuan
										)
									)
					);
	}

	public function getRekapPerAgama()
	{
		
		$T_L_ISLAM		= 0;
		$T_L_KATHOLIK	= 0;
		$T_L_KRISTEN	= 0;
		$T_L_HINDU		= 0;
		$T_L_BUDHA		= 0;
		$T_L_LAINYA		= 0;
		$SUM_LAKI_LAKI	= 0;

		$T_P_ISLAM		= 0;
		$T_P_KATHOLIK	= 0;
		$T_P_KRISTEN	= 0;
		$T_P_HINDU		= 0;
		$T_P_BUDHA		= 0;
		$T_P_LAINYA		= 0;
		$SUM_PEREMPUAN	= 0;

		foreach((array)$this->unor as $row)
		{
			$L_ISLAM	 =  (int)$this->countByAgama(1,1,$row['UNOR_ID']);
			$L_KATHOLIK	 =  (int)$this->countByAgama(2,1,$row['UNOR_ID']);
			$L_KRISTEN	 =  (int)$this->countByAgama(3,1,$row['UNOR_ID']);
			$L_HINDU	 =  (int)$this->countByAgama(4,1,$row['UNOR_ID']);
			$L_BUDHA	 =  (int)$this->countByAgama(5,1,$row['UNOR_ID']);
			$L_LAINYA	 =  (int)$this->countByAgama(6,1,$row['UNOR_ID']);

			$P_ISLAM	 =  (int)$this->countByAgama(1,2,$row['UNOR_ID']);
			$P_KATHOLIK	 =  (int)$this->countByAgama(2,2,$row['UNOR_ID']);
			$P_KRISTEN	 =  (int)$this->countByAgama(3,2,$row['UNOR_ID']);
			$P_HINDU	 =  (int)$this->countByAgama(4,2,$row['UNOR_ID']);
			$P_BUDHA	 =  (int)$this->countByAgama(5,2,$row['UNOR_ID']);
			$P_LAINYA	 =  (int)$this->countByAgama(6,2,$row['UNOR_ID']);

			$total_laki_laki = ($L_ISLAM + $L_KATHOLIK + $L_KRISTEN + $L_HINDU + $L_BUDHA + $L_LAINYA);
			$total_perempuan = ($P_ISLAM + $P_KATHOLIK + $P_KRISTEN + $P_HINDU + $P_BUDHA + $P_LAINYA);

			$T_L_ISLAM		+= $L_ISLAM;
			$T_L_KATHOLIK	+= $L_KATHOLIK;
			$T_L_KRISTEN	+= $L_KRISTEN;
			$T_L_HINDU		+= $L_HINDU;
			$T_L_BUDHA		+= $L_BUDHA;
			$T_L_LAINYA		+= $L_LAINYA;

			$T_P_ISLAM		+= $P_ISLAM;
			$T_P_KATHOLIK	+= $P_KATHOLIK;
			$T_P_KRISTEN	+= $P_KRISTEN;
			$T_P_HINDU		+= $P_HINDU;
			$T_P_BUDHA		+= $P_BUDHA;
			$T_P_LAINYA		+= $P_LAINYA;

			$SUM_LAKI_LAKI += $total_laki_laki;
			$SUM_PEREMPUAN += $total_perempuan;

			$arr[] = array(
						'UNOR' 			=> $row['UNOR'],
						'L_ISLAM' 		=>  $L_ISLAM,
						'L_KATHOLIK' 	=>  $L_KATHOLIK,
						'L_KRISTEN' 	=>  $L_KRISTEN,
						'L_HINDU' 		=>  $L_HINDU,
						'L_BUDHA' 		=>  $L_BUDHA,
						'L_LAINYA' 		=>  $L_LAINYA,
						'L_TOTAL' 		=> $total_laki_laki,
						'P_ISLAM' 		=>  $P_ISLAM,
						'P_KATHOLIK' 	=>  $P_KATHOLIK,
						'P_KRISTEN' 	=>  $P_KRISTEN,
						'P_HINDU' 		=>  $P_HINDU,
						'P_BUDHA' 		=>  $P_BUDHA,
						'P_LAINYA' 		=>  $P_LAINYA,
						'P_TOTAL' 		=> $total_perempuan
					);
		}

		return array(
						'total' => count($arr), 
						'rows' => $arr, 
						'footer' => array( array(
										'UNOR' => 'TOTAL',
										'L_ISLAM' 		=>  $T_L_ISLAM,
										'L_KATHOLIK' 	=>  $T_L_KATHOLIK,
										'L_KRISTEN' 	=>  $T_L_KRISTEN,
										'L_HINDU' 		=>  $T_L_HINDU,
										'L_BUDHA' 		=>  $T_L_BUDHA,
										'L_LAINYA' 		=>  $T_L_LAINYA,
										'L_TOTAL' 		=> $SUM_LAKI_LAKI,
										'P_ISLAM' 		=>  $T_P_ISLAM,
										'P_KATHOLIK' 	=>  $T_P_KATHOLIK,
										'P_KRISTEN' 	=>  $T_P_KRISTEN,
										'P_HINDU' 		=>  $T_P_HINDU,
										'P_BUDHA' 		=>  $T_P_BUDHA,
										'P_LAINYA' 		=>  $T_P_LAINYA,
										'P_TOTAL' 		=> $SUM_PEREMPUAN
										)
									)
					);
	}

	public function getRekapPerGolongan()
	{
		$T_L_GOLONGAN_I		= 0; 
		$T_L_GOLONGAN_II	= 0; 
		$T_L_GOLONGAN_III	= 0; 
		$T_L_GOLONGAN_IV	= 0;
		$SUM_LAKI_LAKI		= 0;

		$T_P_GOLONGAN_I		= 0; 
		$T_P_GOLONGAN_II	= 0; 
		$T_P_GOLONGAN_III	= 0; 
		$T_P_GOLONGAN_IV	= 0;
		$SUM_PEREMPUAN		= 0;

		foreach((array)$this->unor as $row)
		{
			$L_GOLONGAN_I 		= $this->countByGolongan(1,1,$row['UNOR_ID']);
			$L_GOLONGAN_II 		= $this->countByGolongan(2,1,$row['UNOR_ID']);
			$L_GOLONGAN_III		= $this->countByGolongan(3,1,$row['UNOR_ID']);
			$L_GOLONGAN_IV 		= $this->countByGolongan(4,1,$row['UNOR_ID']);

			$P_GOLONGAN_I 		= $this->countByGolongan(1,2,$row['UNOR_ID']);
			$P_GOLONGAN_II 		= $this->countByGolongan(2,2,$row['UNOR_ID']);
			$P_GOLONGAN_III		= $this->countByGolongan(3,2,$row['UNOR_ID']);
			$P_GOLONGAN_IV 		= $this->countByGolongan(4,2,$row['UNOR_ID']);

			$total_laki_laki = ($L_GOLONGAN_I + $L_GOLONGAN_II + $L_GOLONGAN_III + $L_GOLONGAN_IV);
			$total_perempuan = ($P_GOLONGAN_I + $P_GOLONGAN_II + $P_GOLONGAN_III + $P_GOLONGAN_IV);

			$T_L_GOLONGAN_I		+= $L_GOLONGAN_I; 
			$T_L_GOLONGAN_II	+= $L_GOLONGAN_II; 
			$T_L_GOLONGAN_III	+= $L_GOLONGAN_III; 
			$T_L_GOLONGAN_IV	+= $L_GOLONGAN_IV; 

			$T_P_GOLONGAN_I		+= $P_GOLONGAN_I; 
			$T_P_GOLONGAN_II	+= $P_GOLONGAN_II; 
			$T_P_GOLONGAN_III	+= $P_GOLONGAN_III; 
			$T_P_GOLONGAN_IV	+= $P_GOLONGAN_IV; 

			$SUM_LAKI_LAKI += $total_laki_laki;
			$SUM_PEREMPUAN += $total_perempuan;

			$arr[] = array(
						'UNOR' 				=> $row['UNOR'],
						'L_GOLONGAN_I' 		=> $L_GOLONGAN_I,
						'L_GOLONGAN_II' 	=> $L_GOLONGAN_II,
						'L_GOLONGAN_III' 	=> $L_GOLONGAN_III,
						'L_GOLONGAN_IV' 	=> $L_GOLONGAN_IV,						
						'L_TOTAL' 			=> $total_laki_laki,
						'P_GOLONGAN_I' 		=> $P_GOLONGAN_I,
						'P_GOLONGAN_II' 	=> $P_GOLONGAN_II,
						'P_GOLONGAN_III' 	=> $P_GOLONGAN_III,
						'P_GOLONGAN_IV' 	=> $P_GOLONGAN_IV,
						'P_TOTAL' 			=> $total_perempuan
					);
		}

		return array(
						'total' => count($arr), 
						'rows' => $arr, 
						'footer' => array( array(
										'UNOR' => 'TOTAL',
										'L_GOLONGAN_I' 		=> $T_L_GOLONGAN_I,
										'L_GOLONGAN_II' 	=> $T_L_GOLONGAN_II,
										'L_GOLONGAN_III' 	=> $T_L_GOLONGAN_III,
										'L_GOLONGAN_IV' 	=> $T_L_GOLONGAN_IV,						
										'L_TOTAL' 			=> $SUM_LAKI_LAKI,
										'P_GOLONGAN_I' 		=> $T_P_GOLONGAN_I,
										'P_GOLONGAN_II' 	=> $T_P_GOLONGAN_II,
										'P_GOLONGAN_III' 	=> $T_P_GOLONGAN_III,
										'P_GOLONGAN_IV' 	=> $T_P_GOLONGAN_IV,
										'P_TOTAL' 			=> $SUM_PEREMPUAN
										)
									)
					);


	}

	public function getRekapPerPendidikan()
	{
		$T_L_SD 			= 0;
		$T_L_SMP 			= 0;
		$T_L_SMPK			= 0;
		$T_L_SMA 			= 0;
		$T_L_SMAKJ 			= 0;
		$T_L_SMAKG 			= 0;
		$T_L_D1 			= 0;
		$T_L_D2 			= 0;
		$T_L_D3 			= 0;
		$T_L_D4 			= 0;
		$T_L_S1 			= 0;
		$T_L_S2 			= 0;
		$T_L_S3				= 0;
		$L_TOTAL_SMP		= 0;
		$L_TOTAL_SMA		= 0;
		$SUM_LAKI_LAKI		= 0;

		$T_P_SD 			= 0;
		$T_P_SMP 			= 0;
		$T_P_SMPK			= 0;
		$T_P_SMA 			= 0;
		$T_P_SMAKJ 			= 0;
		$T_P_SMAKG 			= 0;
		$T_P_D1 			= 0;
		$T_P_D2 			= 0;
		$T_P_D3 			= 0;
		$T_P_D4 			= 0;
		$T_P_S1 			= 0;
		$T_P_S2 			= 0;
		$T_P_S3				= 0;
		$P_TOTAL_SMP		= 0;
		$P_TOTAL_SMA		= 0;
		$SUM_PEREMPUAN		= 0;

		foreach((array)$this->unor as $row)
		{
			$L_SD		= $this->countByPendidikan('sd',1,$row['UNOR_ID']);
			$L_SMP		= $this->countByPendidikan('smp',1,$row['UNOR_ID']);
			$L_SMPK		= $this->countByPendidikan('smpk',1,$row['UNOR_ID']);
			$L_SMA		= $this->countByPendidikan('sma',1,$row['UNOR_ID']);
			$L_SMAKJ	= $this->countByPendidikan('smakj',1,$row['UNOR_ID']);
			$L_SMAKG	= $this->countByPendidikan('smakg',1,$row['UNOR_ID']);
			$L_D1		= $this->countByPendidikan('d1',1,$row['UNOR_ID']);
			$L_D2		= $this->countByPendidikan('d2',1,$row['UNOR_ID']);
			$L_D3		= $this->countByPendidikan('d3',1,$row['UNOR_ID']);
			$L_D4		= $this->countByPendidikan('d4',1,$row['UNOR_ID']);
			$L_S1		= $this->countByPendidikan('s1',1,$row['UNOR_ID']);
			$L_S2		= $this->countByPendidikan('s2',1,$row['UNOR_ID']);
			$L_S3		= $this->countByPendidikan('s3',1,$row['UNOR_ID']);

			$P_SD 		= $this->countByPendidikan('sd',2,$row['UNOR_ID']);
			$P_SMP 		= $this->countByPendidikan('smp',2,$row['UNOR_ID']);
			$P_SMPK		= $this->countByPendidikan('smpk',2,$row['UNOR_ID']);
			$P_SMA 		= $this->countByPendidikan('sma',2,$row['UNOR_ID']);
			$P_SMAKJ 	= $this->countByPendidikan('smakj',2,$row['UNOR_ID']);
			$P_SMAKG 	= $this->countByPendidikan('smakg',2,$row['UNOR_ID']);
			$P_D1 		= $this->countByPendidikan('d1',2,$row['UNOR_ID']);
			$P_D2 		= $this->countByPendidikan('d2',2,$row['UNOR_ID']);
			$P_D3 		= $this->countByPendidikan('d3',2,$row['UNOR_ID']);
			$P_D4 		= $this->countByPendidikan('d4',2,$row['UNOR_ID']);
			$P_S1 		= $this->countByPendidikan('s1',2,$row['UNOR_ID']);
			$P_S2 		= $this->countByPendidikan('s2',2,$row['UNOR_ID']);
			$P_S3		= $this->countByPendidikan('s3',2,$row['UNOR_ID']);


			$T_L_SD 			+= $L_SD;
			$T_L_SMP 			+= ($L_SMP+$L_SMPK);
			//$T_L_SMPK			+= $L_SMPK;
			$T_L_SMA 			+= ($L_SMA+$L_SMAKJ+$L_SMAKG);
			//$T_L_SMAKJ 			+= $L_SMAKJ;
			//$T_L_SMAKG 			+= $L_SMAKG;
			$T_L_D1 			+= $L_D1;
			$T_L_D2 			+= $L_D2;
			$T_L_D3 			+= $L_D3;
			$T_L_D4 			+= $L_D4;
			$T_L_S1 			+= $L_S1;
			$T_L_S2 			+= $L_S2;
			$T_L_S3				+= $L_S3;

			$T_P_SD 			+= $P_SD;
			$T_P_SMP 			+= ($P_SMP+$P_SMPK);
			//$T_P_SMPK			+= $P_SMPK;
			$T_P_SMA 			+= ($P_SMA+$P_SMAKJ+$P_SMAKG);
			//$T_P_SMAKJ 			+= $P_SMAKJ;
			//$T_P_SMAKG 			+= $P_SMAKG;
			$T_P_D1 			+= $P_D1;
			$T_P_D2 			+= $P_D2;
			$T_P_D3 			+= $P_D3;
			$T_P_D4 			+= $P_D4;
			$T_P_S1 			+= $P_S1;
			$T_P_S2 			+= $P_S2;
			$T_P_S3				+= $P_S3;

			$total_laki_laki = ($L_SD + $L_SMP + $L_SMPK + $L_SMA + $L_SMAKJ + $L_SMAKG + $L_D1 + $L_D2 + $L_D3 + $L_D4 + $L_S1 + $L_S2 + $L_S3);
			$total_perempuan = ($P_SD + $P_SMP + $P_SMPK + $P_SMA + $P_SMAKJ + $P_SMAKG + $P_D1 + $P_D2 + $P_D3 + $P_D4 + $P_S1 + $P_S2 + $P_S3);

			$SUM_LAKI_LAKI += $total_laki_laki;
			$SUM_PEREMPUAN += $total_perempuan;

			// $L_SMP = ($T_L_SMP + $T_L_SMPK);
			// $L_SMA = ($T_L_SMA + $T_L_SMAKJ + $T_L_SMAKG);

			// $P_SMP = ($T_P_SMP + $T_P_SMPK);
			// $P_SMA = ($T_P_SMA + $T_P_SMAKJ + $T_P_SMAKG);

			// $L_TOTAL_SMP += $L_SMP;
			// $L_TOTAL_SMA += $L_SMA;

			// $P_TOTAL_SMP += $P_SMP;
			// $P_TOTAL_SMA += $P_SMA;

			$arr[] = array(
						'UNOR' 	=> $row['UNOR'],
						'L_SD' => $L_SD,
						'L_SMP' => $L_SMP,
						//'L_SMPK' => $L_SMPK,
						'L_SMA' => $L_SMA,
						//'L_SMAKJ' => $L_SMAKJ,
						//'L_SMAKG' => $L_SMAKG,
						'L_D1' => $L_D1,
						'L_D2' => $L_D2,
						'L_D3' => $L_D3,
						'L_D4' => $L_D4,
						'L_S1' => $L_S1,
						'L_S2' => $L_S2,
						'L_S3' => $L_S3,
						//'L_ALL_SMP' => $L_SMP,
						//'L_ALL_SMA' => $L_SMA,
						'L_TOTAL' => $total_laki_laki,
						'P_SD' => $P_SD,
						'P_SMP' => $P_SMP,
						//'P_SMPK' => $P_SMPK,
						'P_SMA' => $P_SMA,
						//'P_SMAKJ' => $P_SMAKJ,
						//'P_SMAKG' => $P_SMAKG,
						'P_D1' => $P_D1,
						'P_D2' => $P_D2,
						'P_D3' => $P_D3,
						'P_D4' => $P_D4,
						'P_S1' => $P_S1,
						'P_S2' => $P_S2,
						'P_S3' => $P_S3,
						'P_ALL_SMP' => $P_SMP,
						'P_ALL_SMA' => $P_SMA,
						'P_TOTAL' => $total_perempuan
					);
		}

		return array(
						'total' => count($arr), 
						'rows' => $arr, 
						'footer' => array( 
									array(
												'UNOR' 	=> 'TOTAL',
												'L_SD' => $T_L_SD,
												'L_SMP' => $T_L_SMP,
												//'L_SMPK' => $T_L_SMPK,
												'L_SMA' => $T_L_SMA,
												//'L_SMAKJ' => $T_L_SMAKJ,
												//'L_SMAKG' => $T_L_SMAKG,
												'L_D1' => $T_L_D1,
												'L_D2' => $T_L_D2,
												'L_D3' => $T_L_D3,
												'L_D4' => $T_L_D4,
												'L_S1' => $T_L_S1,
												'L_S2' => $T_L_S2,
												'L_S3' => $T_L_S3,
												//'L_ALL_SMP' => $L_TOTAL_SMP,
												//'L_ALL_SMA' => $L_TOTAL_SMA,
												'L_TOTAL' => $SUM_LAKI_LAKI,
												'P_SD' => $T_P_SD,
												'P_SMP' => $T_P_SMP,
												//'P_SMPK' => $T_P_SMPK,
												'P_SMA' => $T_P_SMA,
												//'P_SMAKJ' => $T_P_SMAKJ,
												//'P_SMAKG' => $T_P_SMAKG,
												'P_D1' => $T_P_D1,
												'P_D2' => $T_P_D2,
												'P_D3' => $T_P_D3,
												'P_D4' => $T_P_D4,
												'P_S1' => $T_P_S1,
												'P_S2' => $T_P_S2,
												'P_S3' => $T_P_S3,
												//'P_ALL_SMP' => $P_TOTAL_SMP,
												//'P_ALL_SMA' => $P_TOTAL_SMA,
												'P_TOTAL' => $SUM_PEREMPUAN
											)
									)
					);
	}

	private function countByInstansi($unor_id, $gender)
	{
		$query = "SELECT COUNT(*) AS TOTAL FROM sp_pegawai p 
				  INNER JOIN sp_riwayat_unor u ON p.NIP = u.NIP 
				  WHERE u.UNOR_ID = '$unor_id' AND p.JENIS_KELAMIN = '$gender'";
		return $this->dbQueryCache($query,'one',300);
	}

	private function countByAgama($agama_id,$gender,$unor_id)
	{
		$query = "SELECT COUNT(*) FROM sp_pegawai p 
					INNER JOIN sp_riwayat_unor u ON p.NIP = u.NIP 
					LEFT JOIN sp_agama a ON p.AGAMA_ID = a.AGAMA_ID
					WHERE a.AGAMA_ID = '$agama_id' AND p.JENIS_KELAMIN = '$gender' AND u.UNOR_ID = '$unor_id' 
					GROUP BY a.AGAMA_ID";
		return $this->dbQueryCache($query,'one',300);
	}

	private function countByGolongan($gol,$gender,$unor_id)
	{
		$golongan['1'] 	= '11,12,13,14';
		$golongan['2'] 	= '21,22,23,24';
		$golongan['3'] 	= '31,32,33,34';
		$golongan['4'] 	= '41,42,43,44,45';

		$query = "SELECT 
						COUNT(*) 
					FROM (
						SELECT
							COUNT(*)
						FROM sp_pegawai p 
						INNER JOIN sp_riwayat_unor u ON p.NIP = u.NIP 
						LEFT JOIN 
						(
							SELECT
								r.NIP,
								MAX(r.GOLONGAN_ID) AS GOLONGAN
							FROM sp_riwayat_golongan r 
							GROUP BY r.NIP
						) g ON g.NIP = p.NIP
						WHERE g.GOLONGAN IN(" .$golongan[$gol]. ") AND p.JENIS_KELAMIN = '$gender' AND u.UNOR_ID = '$unor_id'
						GROUP BY p.NIP,g.GOLONGAN
					) O";
		return $this->dbQueryCache($query,'one',300);
	}

	private function countByPendidikan($tgkt,$gender,$unor_id)
	{
		$pendidikan['sd'] = '05';
		$pendidikan['smp'] = '10';
		$pendidikan['smpk'] = '12';
		$pendidikan['sma'] = '15';
		$pendidikan['smakj'] = '17';
		$pendidikan['smakg'] = '18';
		$pendidikan['d1'] = '20';
		$pendidikan['d2'] = '25';
		$pendidikan['d3'] = '30';
		$pendidikan['d4'] = '35';
		$pendidikan['s1'] = '40';
		$pendidikan['s2'] = '45';
		$pendidikan['s3'] = '50';

		$query = "SELECT 
						COUNT(*) 
					FROM (
						SELECT
							COUNT(*)
						FROM sp_pegawai p 
						INNER JOIN sp_riwayat_unor u ON p.NIP = u.NIP 
						LEFT JOIN 
						(
							SELECT
								p.NIP,
								MAX(p.TINGKAT_PENDIDIKAN_ID) AS TINGKAT_PENDIDIKAN
							FROM sp_riwayat_pendidikan p 
							GROUP BY p.NIP
						) d ON d.NIP = p.NIP
						WHERE d.TINGKAT_PENDIDIKAN = '" .$pendidikan[$tgkt]. "' AND p.JENIS_KELAMIN = '$gender' AND u.UNOR_ID = '$unor_id'
						GROUP BY p.NIP,d.TINGKAT_PENDIDIKAN
					) O";
		return $this->dbQueryCache($query,'one',300);
	}
}
