<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
	/**
	 * Splits an insert ignore query into smaller batches
	 * @param  [type] $table 
	 * @param  [type] $keys  
	 * @param  [type] $data  
	 * @return void       
	 */
	function batch_ignore($table, $keys, $data)
	{
		$ci =& get_instance();
		$ci->load->database();

		$data = array_chunk($data, 50);

	    foreach ($data as $row) {
	    	$values = array();
		    foreach ($row as $array) {
		        array_push($values, "(" . implode(',', $array) . ")");
		    }
		    $sql = "INSERT IGNORE INTO " . $table . " (" . implode(', ', $keys) . ")
				VALUES " . implode(', ', $values);
		    
		    $q = $ci->db->query($sql);
		}
	}
