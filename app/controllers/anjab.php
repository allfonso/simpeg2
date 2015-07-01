<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anjab extends Admin_Controller
{
	public function __construct(){
		parent::__construct();		
		$this->load->model('anjab/anjab_model');
	}

	public function index()
	{
		$data = array();
		$data['jabatan'] = $this->anjab_model->getTreeOption($array = array(), $select = '', $name = 'parent_id');
		$data['anjab'] = $this->anjab_model->getAnjabOrder();
		$this->load->view('anjab/layout_add',$data);
	}

	public function save()
	{
		if (isset($_POST)) {
			$post = $_POST;
			$save = $this->anjab_model->simpanDataAnjab( $post );

			if ( $save ) {
				$response = array("status" => 1,"id" => $save['id'],"parent_id" => $save['parent_id'],"name" => $save['nama'],"nominalacuan" => $save['nominal_acuan'],"nominalreal" => $save['nominal_real'],"msg" => "Data pegawai berhasil disimpan.");
			} else {
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}

			echo json_encode($response);
			exit();
		}
	}

	public function updateTreeUl()
	{
		
		include APPPATH."libraries/Tree.php";
		$tree = new Tree;

		$anjab = $this->anjab_model->getAnjabOrder();

		foreach ($anjab as $row) {
			$tree->add_item(
				$row['id'],
				$row['parent_id'],
				sprintf(' id="kategori_%s" data-category_id="%s"', $row['id'], $row['id']),
				$this->get_label($row)
			);
		}

		$kategori = '<script src="'.asset_url('js/kategori.js').'"></script>'.$tree->generate('class="sortable"');

		return $kategori;
	}

	public function get_label($data) {
		$name  = $data['nama'];
		$id    = $data['id'];
		$label =
			'<div class="ns-item">
				<div class="ns-title"><i class="fa fa-arrows"></i>'.$name.'</div>
				<div class="ns-actions">
					<a href="javascript:void(0)" class="easyui-linkbutton"  plain="true" onclick="editAnjab('.$id.')">
						<i class="fa fa-pencil"></i>
					</a>
					<a href="#" class="delete-kategori" title="Delete">
						<i class="fa fa-trash-o"></i>
					</a>
				</div>
			</div>';
		return $label;
	}

	public function update()
	{
		if (isset($_POST)) {
			$post = $_POST;
			$save = $this->anjab_model->simpanDataEditAnjab( $post );

			if ( $save ) {
				$getkategori = $this->updateTreeUl();
				$response = array("status" => 1,"msg" => "Data analisis jabatan berhasil diupdate.","updkat" => $getkategori);
			} else {
				$response = array("status" => 0,"msg" => "Gagal simpan data. Silahkan ulangi.");
			}

			echo json_encode($response);
			exit();
		}
	}

	public function updateOption()
	{
		$jabatan = $this->anjab_model->getTreeOption($array = array(), $select = '', $name = 'parent_id');
		echo $jabatan;
	}

	public function delete()
	{
		if (isset($_POST)) {
			$post = $_POST;

			$delete = $this->anjab_model->hapusDataAnjab( $post );

			if ( $delete ) {
				$getkategori = $this->updateTreeUl();
				$response = array("status" => 1,"msg" => "Data analisis jabatan berhasil dihapus.","updkat" => $getkategori);
			} else {
				$response = array("status" => 0,"msg" => "Gagal hapus data. Silahkan ulangi.");
			}

			echo json_encode($response);
			exit();
		}
	}

	public function saveOrderBy()
	{
		if (isset($_POST['kategori'])) {
		//adodb_pr($kategori);
		
			$kategori2 = array();
			foreach ($_POST['kategori'] as $k => $v) {
				if ($v == 'null') {
					$kategori2[0][] = $k;
				} else {
					$kategori2[$v][] = $k;
				}
			}
			//adodb_pr($kategori2);

			$success = 0;
			if (!empty($kategori2)) {
				foreach ($kategori2 as $k => $v) {
					$i = 1;
					foreach ($v as $v2) {
						$data['parent_id'] = $k;
						$data['urutan'] = $i;
						$data['id'] = $v2;

						$saveupdate =  $this->anjab_model->simpanOrderBy($data);
						if ($saveupdate) {
							$success++;
						}
						$i++;
					}
				}		
			}
		}
	}

	function getDataAnjab()
	{
		if (isset($_POST)) {
			$anjab = $this->anjab_model->getDataAnjabDb($_POST['id']);

			$response = array();
			if ($anjab) {				
				$response = $anjab;
			} else {
				$response = array("status" => 0,"msg" => "Gagal mengambil data.");
			}

			echo json_encode($response);
			exit();
		}
		// $data = array();
		// $data['get'] = $this->uri->segment(2);
		// $data['geta'] = $this->uri->segment(3);
		// $this->load->view('anjab/layout_update',$data);
	}

	function acuan()
	{
		$data = array();
		$this->load->view('anjab/layout_acuan',$data);
	}

	function load_data_anjab()
	{
		$flag_anjab = $this->uri->segment(3);  // 1=acuan ; 0 : real
		$acuan = $this->anjab_model->getDataAnjab($flag_anjab);
		// echo "<pre>";print_r($data);echo "</pre>";
		$this->output->set_content_type('application/json')->set_output(json_encode($acuan));
	}
}