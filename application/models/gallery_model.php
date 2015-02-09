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

class Gallery_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}


	/**
	 * GET BENEFICIARIES
	 * @param String, $search_by
	 * @param String, $data
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_beneficiary($search_by = array())
	{
		if( count($search_by) > 0 ){
			foreach ($search_by as $row) {
				$this->db->where($row['fieldname'], $row['data']);
			}
			$this->db->from('cop_gallery');
			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result();
			}else{
				return FALSE;
			}
		}else{
			$query = $this->db->get('cop_gallery');
			return $query->result();
		}
	}
}