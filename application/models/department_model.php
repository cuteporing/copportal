<?php
/*********************************************************************************
** The contents of this file are subject to the COPPortal
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: KBVCodes
 * The Initial Developer of the Original Code is CodeIgniter.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_department($search_by='', $value='')
	{
		if( $search_by != '' ){
			$this->db->where($search_by, $value);
		}
		$this->db->from('cop_department');
		$this->db->order_by('department','ASC');
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}
}
?>
