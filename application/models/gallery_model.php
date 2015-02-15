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
	 * GET EVENT LIST THAT IS NOT ON THE GALLERY
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_events()
	{
		// SELECT event_id, title FROM cop_events WHERE event_id NOT IN (SELECT event_id FROM cop_gallery WHERE event_id != NULL)
		$event_id = array();
		$event_sql   = 'event_id, title';
		$gallery_sql = 'event_id';

		$this->db->select($gallery_sql);
		$this->db->from('cop_gallery');
		$this->db->where('event_id !=', 'NULL');
		$query_gallery  = $this->db->get();
		$result_gallery = $query_gallery->result();

		foreach ($result_gallery as $obj) {
			array_push($event_id, $obj->event_id);
		}

		$this->db->select($event_sql);
		$this->db->from('cop_events');
		if( count($event_id) > 0 ){
			$this->db->where_not_in('event_id', array());
		}
		$query = $this->db->get();

		return $query->result_array();
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

	public function get_album_photos($type='custom', $search_param=array())
	{
		if( count($search_param) > 0 ){

			foreach ($search_param as $param) {
				$this->db->where(
					$param['fieldname'],
					$param['data']
				);
			}

			$this->db->from('cop_gallery_photos');
			$query = $this->db->get();

			if( $query->num_rows() > 0 ){
				return $query->result();
			}else{
				return FALSE;
			}

		}else{
			$query = $this->db->get('cop_gallery_photos');
			return $query->result();
		}
	}

	/**
	 * CHECKS IF THE GALLERY HAS NO PHOTO
	 * @param Integer, $gallery_id
	 * @return Boolean
	 * --------------------------------------------
	 */
	public function check_album_empty($gallery_id)
	{
		$this->db->where('gallery_id', $gallery_id);
		$this->db->from('cop_gallery_photos');
		if( $this->db->count_all_results() > 0 ){
			return false;
		}else{
			return true;
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

	/**
	 * DELETES AN ALBUM
	 * @param Integer, $gallery_id
	 * @return Boolean
	 * --------------------------------------------
	 */
	public function delete_album($gallery_id)
	{
		$is_empty = $this->check_album_empty($gallery_id);
		if( $is_empty ){
			$this->db->trans_begin();

			$this->db->where('gallery_id', $gallery_id);
			$this->db->delete('cop_gallery');

			if( $this->db->trans_status() === FALSE )
			{
				$this->db->trans_rollback();
				return FALSE;
			}else{
				$this->db->trans_commit();
				return TRUE;
			}
		}else{
			return FALSE;
		}
	}

	/**
	 * SAVE PHOTO
	 * @param Array, $data
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function save_photo($data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_gallery_photos', $data);

		if( $this->db->trans_status() === FALSE )
			{
				$this->db->trans_rollback();
				return FALSE;
			}else{
				$this->db->trans_commit();
				return TRUE;
			}
	}
}