<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Anjab_model extends MY_Model
{
	public function __construct(){
		parent::__construct();
	}

	/**
	get query anjab
	*/
	public function getAnjabOrder()
	{

		$query = $this->GetDataFromDB("SELECT * FROM sp_anjab ORDER BY id,urutan","all");
		// echo "<pre>";print_r($query);echo "</pre>";
		return $query;
	}

	/**
	get query anjab tertentu
	*/
	public function getAnjabById($id)
	{

		$query = $this->GetDataFromDB("SELECT * FROM sp_anjab WHERE id = $id","row");
		// echo "<pre>";print_r($query);echo "</pre>";
		return $query;
	}

	/**
	get query anjab
	*/
	public function getAnjab()
	{

		$query = $this->GetDataFromDB("SELECT * FROM sp_anjab ORDER BY id,urutan","all");
		// echo "<pre>";print_r($query);echo "</pre>";
		return $query;
	}

	/**
	get tree option
	*/
	public function getTreeOption($array = array(), $select = '', $name = 'parent_id')
	{
		if (empty($array)) {
			$category = $this->getAnjab();
			$arr = $this->array_path($category);
		}
		// $output = "<select id=\"optionjabatan\" class=\"form-control\" name=\"".$name."\">\n";
		$output = "";
	    if( $select == 0 ){
	        $sel = ' selected="selected"';
	    }else{
	        $sel = '';
	    }
	    $output .= "<option value=\"0\"".$sel."><b>| No Parent</b></option>\n";
	    $valueiskey = $check_first = false;
	    foreach((array)$arr AS $key => $dt){
	        if(is_array($dt)){
	            list($value, $caption) = array_values($dt);
	            if(empty($caption)) $caption = $value;
	        }else{
	            if(!$check_first) {
	                if((is_numeric($key) && $key != 0) || (is_string($key) && !is_numeric($key)))
	                    $valueiskey = true;
	                $check_first = true;
	            }
	            if(empty($dt) && !empty($key)) $dt = $key;
	            $value = $valueiskey ? $key : $dt;
	            $caption = $dt;
	        }
	        if(isset($select)){
	            if(is_array($select)) $selected = (in_array($value, $select)) ? ' selected="selected"':'';
	            else    $selected = ($value==$select) ? ' selected="selected"':'';
	        }else{
	            $selected = '';
	        }
	        $output .= "<option value=\"$value\"$selected>|$caption</option>\n";
	    }
	    // $output .= "</select>\n";
	    return $output;
	}

	/**
	arraypath
	*/
	public function array_path($data, $par_id = 0, $separate = '#', $prefix = '&nbsp;')
	{
	    $output = array();
	    $count = 1;
	    foreach((array)$data AS $dt)
	    {
	        if($dt['parent_id'] == $par_id)
	        {
	            $text = ($par_id==0) ? $prefix.$dt['nama'] : $prefix.$separate.' '.$dt['nama'];
	            $to_replace = $dt['nama'];
	            $output[$dt['id']] = $text;
	            $r = $this->array_path($data, $dt['id'], $separate, $text);
	            if(!empty($r)) {
	                foreach($r AS $i => $j){

	                    if( strpos($j,$separate) ){
	                        $ex = explode($separate,$j);
	                        $count = count($ex);
	                        $j = $ex[$count-1];
	                    }

	                    $output[$i] = str_repeat('-',$count).''.str_replace($separate,'',$j);
	                }
	            }
	        }
	    }
	    return $output;
	}

	/**
	simpan data anjab
	*/
	function simpanDataAnjab($post)
	{
		$success = FALSE;
		if( $post )
		{
			$parent_id = (int)$post['parent_id'];
			$defurutan = $this->dbQueryCache("SELECT MAX(urutan) AS urutan FROM sp_anjab WHERE parent_id = 0 LIMIT 1","one");
			$defurutan = intval($defurutan);
			$urutan    = $defurutan + 1;
			
			$this->db->set( 'nama', $post['namajabatan'] );
			$this->db->set( 'nominal_acuan', $post['nominalacuan'] );
			$this->db->set( 'nominal_real', $post['nominalreal'] );
			$this->db->set( 'parent_id', $post['parent_id'] );
			$this->db->set( 'urutan', $urutan );

			$insert = $this->db->insert('sp_anjab');
			$insert_id = $this->db->insert_id();

			if ( $insert ) {
				$data = $this->getAnjabById($insert_id);
				return $data;
			} else {
				return false;
			}
		}
	}

	/**
	simpan data edit anjab
	*/
	function simpanDataEditAnjab($post)
	{
		$success = FALSE;
		if ( $post ) {
			$data = array(
               'nama'             => $post['editnamajabatan'],
               'nominal_acuan'    => $post['editnominalacuan'],
               'nominal_real'     => $post['editnominalreal']
            );

			$this->db->where('id', $post['anjab_id']);
			$update = $this->db->update('sp_anjab', $data); 

			if ($update) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	delete data anjab
	*/
	function hapusDataAnjab($post)
	{
		$success = FALSE;
		if( $post )
		{
			$id = (int)$post['anjab_id'];

			$this->db->where('id', $id);
			$delparent = $this->db->delete('sp_anjab');

			if ($delparent) {
				$this->db->where('parent_id', $id);
				$this->db->delete('sp_anjab');
			}			 

			if ( $delparent ) {				
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	simpan data orderby sp_anjab
	*/
	function simpanOrderBy($dataorderby)
	{
		$success = FALSE;
		if ( $dataorderby ) {
			$data = array(
               'parent_id' => $dataorderby['parent_id'],
               'urutan'    => $dataorderby['urutan']
            );

			$this->db->where('id', $dataorderby['id']);
			$update = $this->db->update('sp_anjab', $data); 

			if ($update) {
				return true;
			} else {
				return false;
			}
		}
	}

	/**
	get data anjab by id
	*/
	function getDataAnjabDb($id)
	{
		$query = $this->GetDataFromDB("SELECT * FROM sp_anjab WHERE id = $id","row");
		// echo "<pre>";print_r($query);echo "</pre>";
		if ($query) {
			$query['status'] = 1;
		}
		return $query;
	}

	/**
	get data anjab by id
	*/
	function getDataAnjab($flag,$parent_id = 0,$arr_anjab = array())
	{
		// $query = $this->GetDataFromDB("SELECT * FROM sp_anjab WHERE parent_id = $parent_id ORDER BY id,urutan","all");
		
		
		// $arr = array();
		// foreach ($query as $key => $value) {
		// 	$children = $this->getDataAnjab( $flag,$value['id'] );
		// 	$r['id'] = $value['id'];
		// 	$r['parent_id'] = $value['parent_id'];
		// 	$r['text'] = $value['nama'];
		// 	if (!empty($children)) {
		// 		$r['children'] = $children;
		// 	}
		// 	$arr[] = $r;
		// 	echo "<pre>";print_r($arr);echo "</pre>";
		// }

		$this->db->where('parent_id', $parent_id);
		$this->db->order_by('id', 'ASC');
		$this->db->order_by('urutan', 'ASC');
		$query = $this->db->get('sp_anjab');

		$arr = array();
		if( $query->num_rows() > 0 ){
			foreach ($query->result() as $row) 
			{
				$children = $this->getDataAnjab($flag, $row->id );

				$r['id'] = $row->id;
				$r['parent_id'] = $row->parent_id;
				if ($flag == 1) {
					// pakai data acuan
					$acuan = " (".$row->nominal_acuan.")";
				} else {
					// pakai data acuan
					$acuan = " (".$row->nominal_real.")";
				}
				$r['text'] = $row->nama . $acuan;				
				$r['children'] = $children;
				$arr[] = $r;
			}
		}

		return $arr;
	}
}