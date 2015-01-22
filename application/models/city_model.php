<?php
/*********************************************************************************
** The contents of this file are subject to the ______________________
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: ______________________
 * The Initial Developer of the Original Code is Krishia Valencia.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class City_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_cities($city_id = 0)
	{
		if( $city_id !== 0 ){
			$this->db->where('city_id', $city_id);
			$this->db->from('cop_city');
			$this->db->order_by('city','ASC');
			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result_array();
			}else{
				return FALSE;
			}
		}

		$query = $this->db->get('cop_city');
		return $query->result_array();
	}
}
?>
