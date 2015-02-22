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

class Banner_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * GET BANNER
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_banner($search_by= '', $data='')
	{
		if( $search_by != '' ){
			$this->db->where($search_by, $data);
		}

		$this->db->from('cop_banner');
		$this->db->order_by('sequence', 'asc');
		$query = $this->db->get();

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function get_max_sequence()
	{
		$this->db->select_max('sequence');
		$query = $this->db->get('cop_banner');

		if( $query->num_rows() > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	/**
	 * CREATE BANNER
	 * @param Array, $data
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function create($data)
	{
		$this->db->trans_begin();

		$max_sequence = $this->get_max_sequence();

		( $max_sequence[0]['sequence'] === null || $max_sequence[0]['sequence'] == '' )?
			 $max_sequence[0]['sequence'] = 1
		:  $max_sequence[0]['sequence'] = $max_sequence[0]['sequence']++;

		$data['sequence'] = $max_sequence[0]['sequence'];

		$this->db->insert('cop_banner', $data);

		if( $this->db->trans_status() === FALSE ){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	/**
	 * DELETE BANNER
	 * @param Integer, $event_id
	 * --------------------------------------------
	 */
	public function delete($banner_id)
	{
		$id = array('banner_id'=>$banner_id);

		$this->db->trans_begin();
		$this->db->delete('cop_banner', $id);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}
}