<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function asset_url($str='')
{
	return site_url( "assets/" . $str );
}

function easyui($str='')
{
	return asset_url( "jeasyui/" . $str );
}

function pr( $str = '' )
{
	echo '<pre>'.print_r($str,1).'</pre>';
}

function encrypt($plain_text, $password = 'OuzsPh0dq8', $iv_len = 16)
{
   $plain_text .= "\2008A";
   $n = strlen($plain_text);
   if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
   $i = 0;
   $enc_text = get_random_code($iv_len);
   $iv = substr($password ^ $enc_text, 0, 512);
   while ($i < $n) {
	   $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
	   $enc_text .= $block;
	   $iv = substr($block . $iv, 0, 512) ^ $password;
	   $i += 16;
   }
   return base64_encode($enc_text);
}

function decrypt($enc_text, $password = 'OuzsPh0dq8', $iv_len = 16)
{
   $enc_text = base64_decode($enc_text);
   $n = strlen($enc_text);
   $i = $iv_len;
   $plain_text = '';
   $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
   while ($i < $n) {
	   $block = substr($enc_text, $i, 16);
	   $plain_text .= $block ^ pack('H*', md5($iv));
	   $iv = substr($block . $iv, 0, 512) ^ $password;
	   $i += 16;
   }
   return preg_replace('/\\2008A\\x00*$/', '', $plain_text);
}

function get_random_code($iv_len)
{
   $iv = '';
   while ($iv_len-- > 0) {
	   $iv .= chr(mt_rand() & 0xff);
   }
   return $iv;
}

function set_log($str)
{
	$ci =& get_instance();
	$ci->load->library('user_agent');
		
	$now 		= date('Y-m-d H:i:s');
	$thismonth 	= date('m');
	$thisyear 	= date('Y');
	$tablename 	= "sys_log_".$thismonth."_".$thisyear;
	
	$data = array();
	$data['datetime'] 	= time();
	$data['action'] 	= strip_tags( addslashes($str));
	$data['ip']			= $ci->input->ip_address();
	$data['browser']	= $ci->agent->browser();
	$data['platform']	= $ci->agent->agent_string();
	$data['url']		= $ci->uri->uri_string();	
	$data['postdata']	= isset( $_POST ) ? encrypt(json_encode($_POST)) : "";	
	
	$is_exists = $ci->db->table_exists($tablename);
	if( $is_exists ){
		$ci->db->insert($tablename,$data);
	}else{
		$query = "CREATE TABLE IF NOT EXISTS `$tablename` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `datetime` varchar(255) DEFAULT NULL,
					  `action` text,
					  `ip` varchar(255) DEFAULT NULL,
					  `browser` text,
					  `url` text,
					  `platform` text,
					  `postdata` text,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1";
		$create_table = $ci->db->query($query);
		if($create_table){
			$ci->db->insert($tablename,$data);
		}
	}
}

function check_user( $data, $redirect = true )
{
	$ci =& get_instance();
	if( !$ci->dx_auth->is_logged_in() ){
		redirect(_URL);
		exit();
	}

	if( empty($data) ){
		return FALSE;	
	}

	if( $ci->dx_auth->get_permission_value($data) != NULL && $ci->dx_auth->get_permission_value($data) ){
		return TRUE;	
	}else{
		if( $redirect ){
			$ci->session->set_flashdata("__not_allow","You do not have permission to access this page");
			redirect('main/restricted');
			exit();	
		}else{
			return FALSE;	
		}
	}		
}

function mysql_date($date)
{
	if($date){
		list($tgl,$bln,$thn) = explode('-',$date);
		return "$thn-$bln-$tgl";
	}
	return '0000-00-00';
}

function user_id()
{
	$ci =& get_instance();
	if( !$ci->dx_auth->is_logged_in() ){
		return FALSE;
	}
	return $ci->dx_auth->get_user_id();
}

function get_instansi()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT INSTANSI_ID AS KODE, INSTANSI_NAMA AS NAMA FROM sp_instansi ORDER BY INSTANSI_NAMA");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KODE] = $row->NAMA;
	}

	return $arr;
}

function get_kedudukan_pegawai()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT * FROM sp_kedudukan_pegawai");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KEDUDUKAN_ID] = $row->KEDUDUKAN_NAMA;
	}

	return $arr;
}

function get_masa_kerja($tanggal)
{
		$date = time();
		$y = date('Y',$date);
		$m = date('m',$date);
		$d = date('d',$date);
 
 		$dateusia = strtotime($tanggal);
		// kelahiran dijadikan dalam format tanggal semua
		$y2 = date('Y',$dateusia);
		$m2 = date('m',$dateusia);
		$d2 = date('d',$dateusia);

		$lahir = $d2 + ($m2*30) + ($y2*365);
 	
		// sekarang dijadikan dalam format tanggal semua
		$now = $d + ($m*30) + ($y*365);

		// dari format tanggal jadikan tahun, bulan, hari
		$tahun = ($now - $lahir) / 365;
	   	$bulan = (($now - $lahir) % 365) / 30;
   		$hari  = (($now - $lahir) % 365) % 30;	

   		return floor($tahun).' Tahun, '.floor($bulan).' Bulan';
}

function get_jenis_hukuman()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT JENIS_HUKUMAN_ID AS KODE, JENIS_HUKUMAN_NAMA AS NAMA FROM sp_jenis_hukuman");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KODE] = $row->NAMA;
	}

	return $arr;
}

function get_golongan()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT GOLONGAN_ID AS KODE, CONCAT(GOLONGAN_KODE,' - ',GOLONGAN_NAMA) AS NAMA FROM sp_golongan");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KODE] = $row->NAMA;
	}
	return $arr;
}

function get_jenis_penghargaan()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT PENGHARGAAN_ID AS KODE, PENGHARGAAN_NAMA AS NAMA FROM sp_penghargaan");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KODE] = $row->NAMA;
	}
	return $arr;
}

function get_jenis_jabatan()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT JABATAN_ID AS KODE, JABATAN_NAMA AS NAMA FROM sp_jenis_jabatan");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KODE] = $row->NAMA;
	}
	return $arr;
}

function get_jenjang_jabatan()
{
	$db =& get_instance()->db;
	$query = $db->query("SELECT JENJANG_JABATAN_ID AS KODE, NAMA_JENJANG_JABATAN AS NAMA FROM sp_jenjang_jabatan");

	$arr = array();
	foreach($query->result() as $row){
		$arr[$row->KODE] = $row->NAMA;
	}
	return $arr;
}

function bulan( $int )
{
	$bulan = array(
				'01' => 'Januari',
				'02' => 'Februari',
				'03' => 'Maret',
				'04' => 'April',
				'05' => 'Mei',
				'06' => 'Juni',
				'07' => 'Juli',
				'08' => 'Agustus',
				'09' => 'September',
				'10' => 'Oktober',
				'11' => 'November',
				'12' => 'Desember',
			);
	return $bulan[$int];
}