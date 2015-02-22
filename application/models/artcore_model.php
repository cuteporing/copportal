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

class Artcore_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * GET PARENT TAB
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_parenttab()
	{
		$this->db->from('cop_artcore_parenttab');
		$this->db->order_by('sequence', 'asc');
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	/**
	 * GET PARENT'S SUB TAB
	 * @return Integer, $parenttab_id
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_subtab($parenttab_id)
	{
		$this->db->from('cop_artcore_tab_map');
		$this->db->join('cop_artcore_subtab',
			'cop_artcore_tab_map.subtab_id = cop_artcore_subtab.subtab_id', 'left');
		$this->db->where('parenttab_id', $parenttab_id);
		$this->db->order_by('cop_artcore_tab_map.sequence', 'asc');

		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return NULL;
		}
	}

	/**
	 * GET TOP NAVIGATION
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_top_nav()
	{
		$parenttab = $this->get_parenttab();
		$no_of_tabs= count($parenttab);

		if( $parenttab ){
			for ($i = 0; $i < $no_of_tabs; $i++) {
				$parenttab[$i]['subtab'] = $this->get_subtab($parenttab[$i]['parenttab_id']);
			}

			return $parenttab;
		}
	}

}
?>