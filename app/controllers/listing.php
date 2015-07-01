<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listing extends Admin_Controller
{
	public function __construct(){
		parent::__construct();	
		$this->load->model('pegawai/listing_model');
	}

	public function nominatif()
	{
		$data = array();
		$this->load->view('listing/layout_listing_nominatif', $data);
	}

	public function duk()
	{
		$data = array();
		$this->load->view('listing/layout_listing_duk', $data);
	}

	public function export_duk()
	{
		$title_subunit = '-';
		$params = $_GET['params'];
		if( strrpos($params, '/') ){
			list($parent_id,$sub_parent_id) = explode('/',$params);
			$title_subunit = $this->listing_model->getUnorByKode( $sub_parent_id );
		}else{
			$parent_id = $_GET['params'];
			$sub_parent_id = null;
		}

		$title_unit = $this->listing_model->getUnorByKode( $parent_id );

		$dataLaporan = array();
		$count = 0;

		$result = $this->listing_model->getListingDUK( $parent_id, $sub_parent_id );
		if( $result )
		{
			foreach($result as $row){
				$dataLaporan[] = array(
					'nip_lama' => $row['NIP_LAMA'],
					'nip' => " ".$row['NIP'],
					'nama' => $row['NAMA'],
					'tempat_tanggal_lahir' => $row['TTL'],
					'pangkat' => $row['PANGKAT'],
					'golongan' => $row['GOLONGAN'],
					'tmt_golongan' => $row['TMT_GOLONGAN'],
					'jabatan' => $row['JABATAN'],
					'pendidikan' => $row['PENDIDIKAN'],
					'masa_kerja' => get_masa_kerja($row['TMT_SK_CPNS']),
					'unit' => $row['UNIT'],
					'sub_unit' => $row['SUB_UNIT']
				);
			}
			$count = ( count($result)+7 );
			$header = array(
						'NIP LAMA',
						'NIP',
						'NAMA',
						'TTL',
						'PANGKAT',
						'GOLONGAN',
						'TMT GOLONGAN',
						'JABATAN',
						'PENDIDIKAN',
						'MASA KERJA',
						'UNIT',
						'SUB UNIT'
	        		);

			$filename = "DAFTAR_URUT_KEPANGKATAN_" . date('d_m_Y') . ".xls";
			$alphas = range('A', 'Z');
			$this->load->library('excel');
			$rangeBorder = 'A7:' . 'L' . ($count);
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			for ($i = 1; $i <= 12; $i++) {
				$koordinatAbjad = $alphas[$i];
				$this->excel->getActiveSheet()->getColumnDimension($koordinatAbjad)->setAutoSize(true);
			}

			$this->excel->getActiveSheet()->setCellValue('A1', 'LAPORAN DAFTAR URUT KEPANGKATAN');
            $this->excel->getActiveSheet()->setCellValue('A3', 'UNIT');
            $this->excel->getActiveSheet()->setCellValue('C3', ": $title_unit");
            $this->excel->getActiveSheet()->setCellValue('A4', 'SUB UNIT');
            $this->excel->getActiveSheet()->setCellValue('C4', ": $title_subunit");
            $this->excel->getActiveSheet()->setCellValue('A5', 'PER TANGGAL');
            $this->excel->getActiveSheet()->setCellValue('C5', ": ".date('d/m/Y'));

            $this->excel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A7:L12')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A7:L12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle($rangeBorder)->applyFromArray($styleArray);
            $this->excel->getActiveSheet()->setTitle('LAPORAN DAFTAR URUT KEPANGKATAN');
            $this->excel->getActiveSheet()->fromArray($header, NULL, 'A7');
            $this->excel->getActiveSheet()->fromArray($dataLaporan, NULL, 'A8');
            header('Set-Cookie: fileDownload=true; path=/');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            die;

		}

	}

	public function load_data_duk($parent_id, $sub_parent = null)
	{
		$result = $this->listing_model->getListingDUK( $parent_id, $sub_parent );
		echo json_encode( $result );
	}

	public function load_data_nominatif($parent_id, $sub_parent = null)
	{
		$result = $this->listing_model->getListingNominatif( $parent_id, $sub_parent );
		echo json_encode( $result );
	}

	public function load_data_listing()
	{
		$unor = $this->listing_model->getListingUnor(NULL);
		echo json_encode($unor);
		exit();
	}

	private function parse_listing_unor( $arr )
	{
		$html = "";
		if( $arr )
		{
			foreach((array)$arr as $r){
				$space = ($r['LEVEL'] > 1)?str_repeat('&nbsp; ', ($r['LEVEL']*2) ) : '';
				$html .= "<tr>";
				$html .= "<td><a href=\"#\" onclick=\"showListingDuk('" .$r['ID']. "','" .$r['PARENT']. "')\">" .$space.$r['NAMA']."</a></td>";
				$html .= "</tr>";
				$html .= $this->parse_listing_unor( $r['CHILD'] );
			}
		}

		return $html;
	}

	function import_hukuman()
	{
		$data = $this->db->get('sp_riwayat_hukumans')->result();
		if( $this->input->get('o') && $this->input->get('o') == 1 ){
			pr($data);
			die;
		}

		$this->db->trans_begin();
		$i=0;
		foreach( $data as $row )
		{
			$i++;
			$nip = $this->get_nip_by_id($row->pns_id);
			$this->db->set('NIP', $nip);

			$this->db->set('JENIS_HUKUMAN_ID', $row->jenis_hukum_id);
			$this->db->set('NOMOR_SK', $row->nomor_sk);
			$this->db->set('TANGGAL_SK', $row->tanggal_sk);
			$this->db->set('TANGGAL_MULAI_HUKUM', $row->tanggal_mulai_hukum);
			$this->db->set('TANGGAL_AKHIR_HUKUM', $row->tanggal_akhir_hukum);
			$this->db->set('MASA_TAHUN', $row->masa_tahun);
			$this->db->set('MASA_BULAN', $row->masa_bulan);
			$this->db->set('NOMOR_PP', $row->nomor_pp);
			$this->db->set('GOLONGAN_ID', $row->golongan_id);
			$this->db->set('NOMOR_SK_BATAL', $row->nomor_sk_batal);
			$this->db->set('TANGGAL_SK_BATAL', $row->tanggal_sk_batal);


			if( $this->db->insert('sp_riwayat_hukuman') ){
				echo "$i == Oke <br>";
			}else{
				echo "Error <br>";
			}
		}

		if( $this->db->trans_status() == TRUE ){
			$this->db->trans_commit();
		}else{
			$this->db->trans_rollback();
		}
	}

	function get_nip_by_id($id)
	{
		$this->db->select('nip');
		$this->db->where('pegawai_id', $id);
		$query = $this->db->get('sp_pegawai_data') -> row();
		return $query->nip;
	}
}