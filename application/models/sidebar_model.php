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

class Sidebar_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_sidebar_sub($id)
	{
		$this->db->where('id', $id);
		$this->db->from('cop_sidebar_sub');
		$this->db->order_by("sequence", "asc");
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	/**
	 * GET PARENT TAB
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_sidebar()
	{
		$this->db->from('cop_sidebar');
		$this->db->order_by("sequence", "asc");
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}
}
?>