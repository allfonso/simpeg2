<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

if( !function_exists('array_menu') )
{
	function array_menu( $parent_id = 0, $group_id = 2,$close = array() )
	{
		$ci =& get_instance();	
		
		if( $group_id == 'all' )
		{
			$query = "SELECT 
							sys_menu.*,sys_resources.name AS permission 
						FROM 
							sys_menu 
						LEFT JOIN sys_resources ON(sys_menu.resources_id=sys_resources.id) 
					  	WHERE sys_menu.parent_id = $parent_id 
						ORDER BY sys_menu.id ASC";
		}else{
			$query = "SELECT 
							sys_menu.*,sys_resources.name AS permission 
						FROM 
							sys_menu 
						LEFT JOIN sys_resources ON(sys_menu.resources_id=sys_resources.id) 
					  	WHERE sys_menu.parent_id = $parent_id AND sys_menu.group_id = $group_id 
						ORDER BY sys_menu.id ASC";	
		}
		$result = $ci->db->query($query);
	
		$data = array();
		if( $result->num_rows() > 0 )
		{
			foreach((array)$result->result_array() as $row)
			{
				$allow_menu = check_user($row['permission'],false);
				if( $allow_menu )
				{
					$r['id'] 		= $row['id'];
					$r['parent_id'] = $row['parent_id'];
					$r['text'] 		= strtoupper($row['name']);
					$r['url'] 		= $row['url'];
					$r['state']		= ( $close && in_array($row['id'],$close) )?'closed':'';
					$r['children'] 	= array_menu( $row['id'] ,$group_id,$close);
					$data[] = $r;
				}
			}
		}
		
		return $data;
	}
}