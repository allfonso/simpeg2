<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rekap extends Admin_Controller
{
	var $bulan;

	public function __construct(){
		parent::__construct();	
		$this->load->model('rekap/rekap_model');

		$bulan = strtoupper(bulan( date('m') ))." ".date('Y');
		$this->bulan = $bulan;
	}

	public function per_instansi()
	{
		$data = array();
		$data['bulan'] = $this->bulan;
		$this->load->view('rekap/layout_rekap_per_instansi', $data);
	}

	public function per_agama()
	{
		$data = array();
		$data['bulan'] = $this->bulan;
		$this->load->view('rekap/layout_rekap_per_agama', $data);
	}

	public function per_golongan()
	{
		$data = array();
		$data['bulan'] = $this->bulan;
		$this->load->view('rekap/layout_rekap_per_golongan', $data);
	}

	public function per_pendidikan()
	{
		$data = array();
		$data['bulan'] = $this->bulan;
		$this->load->view('rekap/layout_rekap_per_pendidikan', $data);
	}

	public function load_rekap_per_instansi()
	{
		$data = $this->rekap_model->getRekapPerInstansi();
		echo json_encode($data);
		exit();
	}

	public function load_rekap_per_agama()
	{
		$data = $this->rekap_model->getRekapPerAgama();
		echo json_encode($data);
		exit();
	}

	public function load_rekap_per_golongan()
	{
		$data = $this->rekap_model->getRekapPerGolongan();
		echo json_encode($data);
		exit();
	}

	public function load_rekap_per_pendidikan()
	{
		$data = $this->rekap_model->getRekapPerPendidikan();
		echo json_encode($data);
		exit();
	}

	public function export_per_instansi()
	{
		$result = $this->rekap_model->getRekapPerInstansi();
		if( $result )
		{
			foreach($result['rows'] as $row){
				$dataLaporan[] = array(
					'unor' => $row['UNOR'],
					'total_laki_laki' => " ".$row['TOTAL_LAKI_LAKI'],
					'total_perempuan' => $row['TOTAL_PEREMPUAN']
				);
			}
			$count = ( count($result['rows'])+4 );
			$header = array(
						'UNOR',
						'LAKI-LAKI',
						'PEREMPUAN'
	        		);

			$filename = "REKAP_PEGAWAI_PER_INSTANSI_" . date('d_m_Y') . ".xls";
			$alphas = range('A', 'Z');
			$this->load->library('excel');
			$rangeBorder = 'A4:' . 'C' . ($count);
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			for ($i = 1; $i <= 3; $i++) {
				$koordinatAbjad = $alphas[$i];
				$this->excel->getActiveSheet()->getColumnDimension($koordinatAbjad)->setAutoSize(true);
			}

			$keadaan = strtoupper( bulan( date('m') ) ) ." ".date('Y');
			$this->excel->getActiveSheet()->setCellValue('A1', 'REKAP PEGAWAI PER INSTANSI');
            $this->excel->getActiveSheet()->setCellValue('A2', 'KEADAAN BULAN : '.$keadaan);

            $this->excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A4:C3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A4:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle($rangeBorder)->applyFromArray($styleArray);
            $this->excel->getActiveSheet()->setTitle('REKAP PEGAWAI PER INSTANSI');
            $this->excel->getActiveSheet()->fromArray($header, NULL, 'A4');
            $this->excel->getActiveSheet()->fromArray($dataLaporan, NULL, 'A5');
            header('Set-Cookie: fileDownload=true; path=/');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            die;
		}
	}

	public function export_per_agama()
	{
		$result = $this->rekap_model->getRekapPerAgama();

		if( $result )
		{
			foreach($result['rows'] as $row){
				$dataLaporan[] = array(
					'UNOR' => $row['UNOR'],
                    'L_ISLAM' 		=> (string)$row['L_ISLAM'],
                    'L_KATHOLIK' 	=> (string)$row['L_KATHOLIK'],
                    'L_KRISTEN' 	=> (string)$row['L_KRISTEN'],
                    'L_HINDU' 		=> (string)$row['L_HINDU'],
                    'L_BUDHA' 		=> (string)$row['L_BUDHA'],
                    'L_LAINYA' 		=> (string)$row['L_LAINYA'],
                    'L_TOTAL' 		=> (string)$row['L_TOTAL'],
                    'P_ISLAM' 		=> (string)$row['P_ISLAM'],
                    'P_KATHOLIK' 	=> (string)$row['P_KATHOLIK'],
                    'P_KRISTEN' 	=> (string)$row['P_KRISTEN'],
                    'P_HINDU' 		=> (string)$row['P_HINDU'],
                    'P_BUDHA' 		=> (string)$row['P_BUDHA'],
                    'P_LAINYA' 		=> (string)$row['P_LAINYA'],
                    'P_TOTAL' 		=> (string)$row['P_TOTAL']
				);
			}

			foreach((array)$result['footer'] as $foot){
				$dataLaporan[] = array(
					'UNOR' => 'TOTAL',
                    'L_ISLAM' 		=> (string)$foot['L_ISLAM'],
                    'L_KATHOLIK' 	=> (string)$foot['L_KATHOLIK'],
                    'L_KRISTEN' 	=> (string)$foot['L_KRISTEN'],
                    'L_HINDU' 		=> (string)$foot['L_HINDU'],
                    'L_BUDHA' 		=> (string)$foot['L_BUDHA'],
                    'L_LAINYA' 		=> (string)$foot['L_LAINYA'],
                    'L_TOTAL' 		=> (string)$foot['L_TOTAL'],
                    'P_ISLAM' 		=> (string)$foot['P_ISLAM'],
                    'P_KATHOLIK' 	=> (string)$foot['P_KATHOLIK'],
                    'P_KRISTEN' 	=> (string)$foot['P_KRISTEN'],
                    'P_HINDU' 		=> (string)$foot['P_HINDU'],
                    'P_BUDHA' 		=> (string)$foot['P_BUDHA'],
                    'P_LAINYA' 		=> (string)$foot['P_LAINYA'],
                    'P_TOTAL' 		=> (string)$foot['P_TOTAL']
				);
			}

			

			$filename = "REKAP_PEGAWAI_PER_AGAMA_" . date('d-m-Y') . ".xls";

			$count = ( count($result['rows'])+6 );

			$header = array(
						'UNOR',
						'ISLAM',
						'KATHOLIK',
						'KRISTEN',
						'HINDU',
						'BUDHA',
						'LAINYA',
						'TOTAL',
						'ISLAM',
						'KATHOLIK',
						'KRISTEN',
						'HINDU',
						'BUDHA',
						'LAINYA',
						'TOTAL'
	        		);


			$alphas = range('A', 'Z');
			$this->load->library('excel');
			$rangeBorder = 'A4:' . 'O' . ($count);
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			for ($i = 0; $i <= 3; $i++) {
				$koordinatAbjad = $alphas[$i];
				$this->excel->getActiveSheet()->getColumnDimension($koordinatAbjad)->setAutoSize(true);
			}

			$keadaan = strtoupper( bulan( date('m') ) ) ." ".date('Y');
			$this->excel->getActiveSheet()->setCellValue('A1', 'REKAP PEGAWAI PER AGAMA');
            $this->excel->getActiveSheet()->setCellValue('A2', 'KEADAAN BULAN : '.$keadaan);

            $this->excel->setActiveSheetIndex(0)->mergeCells('A4:A5');
            $this->excel->setActiveSheetIndex(0)->mergeCells('B4:G4');
            $this->excel->setActiveSheetIndex(0)->mergeCells('I4:N4');
            $this->excel->setActiveSheetIndex(0)->mergeCells('O4:O5');
            $this->excel->setActiveSheetIndex(0)->mergeCells('H4:H5');

            $this->excel->getActiveSheet()->getStyle('B4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A5:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->setCellValue('A4', 'UNOR');
            $this->excel->getActiveSheet()->setCellValue('B4', 'LAKI LAKI');
            $this->excel->getActiveSheet()->setCellValue('I4', 'PEREMPUAN');
            $this->excel->getActiveSheet()->setCellValue('H4', 'TOTAL');
            $this->excel->getActiveSheet()->setCellValue('O4', 'TOTAL');

            $max = $count;
            $cell_bold = "A".$max.":O".$max;
            $this->excel->getActiveSheet()->getStyle($cell_bold)->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A4:O4')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A5:O5')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A5:O3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A5:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle($rangeBorder)->applyFromArray($styleArray);
            $this->excel->getActiveSheet()->setTitle('REKAP PEGAWAI PER AGAMA');

            $this->excel->getActiveSheet()->fromArray($header, NULL, 'A5');
            $this->excel->getActiveSheet()->fromArray($dataLaporan, NULL, 'A6');

            #Footer


            header('Set-Cookie: fileDownload=true; path=/');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            die;
		}
	}

	public function export_per_golongan()
	{
		$result = $this->rekap_model->getRekapPerGolongan();
		if($result)
		{
			foreach($result['rows'] as $row){
				$dataLaporan[] = array(
					'UNOR' 				=> $row['UNOR'],
					'L_GOLONGAN_I' 		=> (string)$row['L_GOLONGAN_I'],
					'L_GOLONGAN_II' 	=> (string)$row['L_GOLONGAN_II'],
					'L_GOLONGAN_III' 	=> (string)$row['L_GOLONGAN_III'],
					'L_GOLONGAN_IV' 	=> (string)$row['L_GOLONGAN_IV'],						
					'L_TOTAL' 			=> (string)$row['L_TOTAL'],
					'P_GOLONGAN_I' 		=> (string)$row['P_GOLONGAN_I'],
					'P_GOLONGAN_II' 	=> (string)$row['P_GOLONGAN_II'],
					'P_GOLONGAN_III' 	=> (string)$row['P_GOLONGAN_III'],
					'P_GOLONGAN_IV' 	=> (string)$row['P_GOLONGAN_IV'],
					'P_TOTAL' 			=> (string)$row['P_TOTAL']
				);
			}

			foreach((array)$result['footer'] as $foot){
				$dataLaporan[] = array(
					'UNOR' 				=> 'TOTAL',
					'L_GOLONGAN_I' 		=> (string)$foot['L_GOLONGAN_I'],
					'L_GOLONGAN_II' 	=> (string)$foot['L_GOLONGAN_II'],
					'L_GOLONGAN_III' 	=> (string)$foot['L_GOLONGAN_III'],
					'L_GOLONGAN_IV' 	=> (string)$foot['L_GOLONGAN_IV'],						
					'L_TOTAL' 			=> (string)$foot['L_TOTAL'],
					'P_GOLONGAN_I' 		=> (string)$foot['P_GOLONGAN_I'],
					'P_GOLONGAN_II' 	=> (string)$foot['P_GOLONGAN_II'],
					'P_GOLONGAN_III' 	=> (string)$foot['P_GOLONGAN_III'],
					'P_GOLONGAN_IV' 	=> (string)$foot['P_GOLONGAN_IV'],
					'P_TOTAL' 			=> (string)$foot['P_TOTAL']
				);
			}

			

			$filename = "REKAP_PEGAWAI_PER_GOLONGAN_" . date('d-m-Y') . ".xls";

			$count = ( count($result['rows'])+6 );

			$header = array(
						'UNOR',
						'GOLONGAN I',
						'GOLONGAN II',
						'GOLONGAN III',
						'GOLONGAN IV',						
						'TOTAL',
						'GOLONGAN I',
						'GOLONGAN II',
						'GOLONGAN III',
						'GOLONGAN IV',
						'TOTAL'
	        		);


			$alphas = range('A', 'Z');
			$this->load->library('excel');
			$rangeBorder = 'A4:' . 'K' . ($count);
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			for ($i = 0; $i <= 3; $i++) {
				$koordinatAbjad = $alphas[$i];
				$this->excel->getActiveSheet()->getColumnDimension($koordinatAbjad)->setAutoSize(true);
			}

			$keadaan = strtoupper( bulan( date('m') ) ) ." ".date('Y');
			$this->excel->getActiveSheet()->setCellValue('A1', 'REKAP PEGAWAI PER GOLONGAN');
            $this->excel->getActiveSheet()->setCellValue('A2', 'KEADAAN BULAN : '.$keadaan);

            $this->excel->setActiveSheetIndex(0)->mergeCells('A4:A5');
            $this->excel->setActiveSheetIndex(0)->mergeCells('B4:E4');
            $this->excel->setActiveSheetIndex(0)->mergeCells('G4:J4');
            $this->excel->setActiveSheetIndex(0)->mergeCells('F4:F5');
            $this->excel->setActiveSheetIndex(0)->mergeCells('K4:K5');

            $this->excel->getActiveSheet()->getStyle('B4:H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('I4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('A5:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->setCellValue('A4', 'UNOR');
            $this->excel->getActiveSheet()->setCellValue('B4', 'LAKI LAKI');
            $this->excel->getActiveSheet()->setCellValue('G4', 'PEREMPUAN');
            $this->excel->getActiveSheet()->setCellValue('F4', 'TOTAL');
            $this->excel->getActiveSheet()->setCellValue('K4', 'TOTAL');

            $max = $count;
            $cell_bold = "A".$max.":K".$max;
            $this->excel->getActiveSheet()->getStyle($cell_bold)->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A4:K4')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A5:K5')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A5:K3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A5:K3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle($rangeBorder)->applyFromArray($styleArray);
            $this->excel->getActiveSheet()->setTitle('REKAP PEGAWAI PER GOLONGAN');

            $this->excel->getActiveSheet()->fromArray($header, NULL, 'A5');
            $this->excel->getActiveSheet()->fromArray($dataLaporan, NULL, 'A6');

            #Footer


            header('Set-Cookie: fileDownload=true; path=/');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            die;
		}
	}

	public function export_per_pendidikan()
	{
		$result = $this->rekap_model->getRekapPerPendidikan();
		if($result)
		{
			foreach($result['rows'] as $row){


				$dataLaporan[] = array(
					'UNOR' 	=> $row['UNOR'],
					'L_SD' => (string)$row['L_SD'],
					'L_SMP' => (string)$row['L_SMP'],
					//'L_SMPK' => (string)$row['L_SMPK'],
					'L_SMA' => (string)$row['L_SMA'],
					//'L_SMAKJ' => (string)$row['L_SMAKJ'],
					//'L_SMAKG' => (string)$row['L_SMAKG'],
					'L_D1' => (string)$row['L_D1'],
					'L_D2' => (string)$row['L_D2'],
					'L_D3' => (string)$row['L_D3'],
					'L_D4' => (string)$row['L_D4'],
					'L_S1' => (string)$row['L_S1'],
					'L_S2' => (string)$row['L_S2'],
					'L_S3' => (string)$row['L_S3'],
					'L_TOTAL' => (string)$row['L_TOTAL'],
					'P_SD' => (string)$row['P_SD'],
					'P_SMP' => (string)$row['P_SMP'],
					//'P_SMPK' => (string)$row['P_SMPK'],
					'P_SMA' => (string)$row['P_SMA'],
					//'P_SMAKJ' => (string)$row['P_SMAKJ'],
					//'P_SMAKG' => (string)$row['P_SMAKG'],
					'P_D1' => (string)$row['P_D1'],
					'P_D2' => (string)$row['P_D2'],
					'P_D3' => (string)$row['P_D3'],
					'P_D4' => (string)$row['P_D4'],
					'P_S1' => (string)$row['P_S1'],
					'P_S2' => (string)$row['P_S2'],
					'P_S3' => (string)$row['P_S3'],
					'P_TOTAL' => (string)$row['P_TOTAL']
				);
			}

			foreach((array)$result['footer'] as $foot){

				$dataLaporan[] = array(
					'UNOR' 	=> 'TOTAL',
					'L_SD' => (string)$foot['L_SD'],
					'L_SMP' => (string)$foot['L_SMP'],
					//'L_SMPK' => (string)$foot['L_SMPK'],
					'L_SMA' => (string)$foot['L_SMA'],
					//'L_SMAKJ' => (string)$foot['L_SMAKJ'],
					//'L_SMAKG' => (string)$foot['L_SMAKG'],
					'L_D1' => (string)$foot['L_D1'],
					'L_D2' => (string)$foot['L_D2'],
					'L_D3' => (string)$foot['L_D3'],
					'L_D4' => (string)$foot['L_D4'],
					'L_S1' => (string)$foot['L_S1'],
					'L_S2' => (string)$foot['L_S2'],
					'L_S3' => (string)$foot['L_S3'],
					'L_TOTAL' => (string)$foot['L_TOTAL'],
					'P_SD' => (string)$foot['P_SD'],
					'P_SMP' => (string)$foot['P_SMP'],
					//'P_SMPK' => (string)$foot['P_SMPK'],
					'P_SMA' => (string)$foot['P_SMA'],
					//'P_SMAKJ' => (string)$foot['P_SMAKJ'],
					//'P_SMAKG' => (string)$foot['P_SMAKG'],
					'P_D1' => (string)$foot['P_D1'],
					'P_D2' => (string)$foot['P_D2'],
					'P_D3' => (string)$foot['P_D3'],
					'P_D4' => (string)$foot['P_D4'],
					'P_S1' => (string)$foot['P_S1'],
					'P_S2' => (string)$foot['P_S2'],
					'P_S3' => (string)$foot['P_S3'],
					'P_TOTAL' => (string)$foot['P_TOTAL']
				);
			}

			$filename = "REKAP_PEGAWAI_PER_PENDIDIKAN_" . date('d-m-Y') . ".xls";

			$count = ( count($result['rows'])+6 );

			$header = array(
						'UNOR',
						'SD',
						'SMP',
						//'SMPK',
						'SMA',
						//'SMAKJ',
						//'SMAKG',
						'D1',
						'D2',
						'D3',
						'D4',
						'S1',
						'S2',
						'S3',
						'TOTAL',
						'SD',
						'SMP',
						//'SMPK',
						'SMA',
						//'SMAKJ',
						//'SMAKG',
						'D1',
						'D2',
						'D3',
						'D4',
						'S1',
						'S2',
						'S3',
						'TOTAL'
	        		);


			$alphas = range('A', 'Z');
			$this->load->library('excel');
			$rangeBorder = 'A4:' . 'AC' . ($count);
			$styleArray = array(
				'borders' => array(
					'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
					)
				)
			);

			// for ($i = 0; $i <= 3; $i++) {
			// 	$koordinatAbjad = $alphas[$i];
			// 	$this->excel->getActiveSheet()->getColumnDimension($koordinatAbjad)->setAutoSize(true);
			// }

			$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

			$keadaan = strtoupper( bulan( date('m') ) ) ." ".date('Y');
			$this->excel->getActiveSheet()->setCellValue('A1', 'REKAP PEGAWAI PER PENDIDIKAN');
            $this->excel->getActiveSheet()->setCellValue('A2', 'KEADAAN BULAN : '.$keadaan);

            $this->excel->setActiveSheetIndex(0)->mergeCells('A4:A5');
            $this->excel->setActiveSheetIndex(0)->mergeCells('B4:N4');
            $this->excel->setActiveSheetIndex(0)->mergeCells('P4:AB4');
            $this->excel->setActiveSheetIndex(0)->mergeCells('O4:O5');
            $this->excel->setActiveSheetIndex(0)->mergeCells('AC4:AC5');

           $this->excel->getActiveSheet()->getStyle('B4:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $this->excel->getActiveSheet()->getStyle('P4:AB4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $this->excel->getActiveSheet()->getStyle('B5:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('P5:AB5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $this->excel->getActiveSheet()->setCellValue('A4', 'UNOR');
            $this->excel->getActiveSheet()->setCellValue('B4', 'LAKI LAKI');
            $this->excel->getActiveSheet()->setCellValue('P4', 'PEREMPUAN');
            $this->excel->getActiveSheet()->setCellValue('O4', 'TOTAL');
            $this->excel->getActiveSheet()->setCellValue('AC4', 'TOTAL');

            $max = $count;
            $cell_bold = "A".$max.":K".$max;
            $this->excel->getActiveSheet()->getStyle($cell_bold)->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A4:AC4')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A5:AC5')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A2:C2')->getFont()->setBold(true);

            $this->excel->getActiveSheet()->getStyle('A5:AC3')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A5:AC3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle($rangeBorder)->applyFromArray($styleArray);
            $this->excel->getActiveSheet()->setTitle('REKAP PEGAWAI PER PENDIDIKAN');

            $this->excel->getActiveSheet()->fromArray($header, NULL, 'A5');
            $this->excel->getActiveSheet()->fromArray($dataLaporan, NULL, 'A6');

            #Footer


            header('Set-Cookie: fileDownload=true; path=/');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
            die;
		}
	}
}