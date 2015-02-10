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
	 * GET ALBUM
	 * @param String, $search_by
	 * @param String, $data
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_album($search_param=array())
	{
		if( count($search_param) > 0 ){

			foreach ($search_param as $param) {
				$this->db->where(
					$param['fieldname'],
					$param['data']
				);
			}

			$this->db->from('cop_gallery');
			$query = $this->db->get();
				
			if( $query->num_rows() > 0 ){
				return $query->result();
			}else{
				return FALSE;
			}

		}else{
			$query = $this->db->get('cop_gallery');
			return $query->result();
		}
	}

	/**
	 * CREATES A NEW ALBUM
	 * @param Array, $data
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function create_album($data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_gallery', $data);

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return array(
				'status'=>'error',
				'msg'   =>'Cannot create the album'
				);
		}else{
			$this->db->trans_commit();
			return array(
				'status'=>'success',
				'msg'   =>''
				);
		}
	}
}