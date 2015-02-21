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
	 * GET NO. OF EVENTS PER STATUS
	 * - ongoing
	 * - closed
	 * @return Integer
	 * --------------------------------------------
	 */
	public function get_no_of_albums($fieldname='', $data='')
	{
		if( $fieldname !== '' ){
			$this->db->where($fieldname, $data);
		}
		$this->db->from('cop_gallery');
		return $this->db->count_all_results();
	}

	/**
	 * GET ALL EVENT ID LINK TO GALLERY ALBUM
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_event_album_id()
	{
		$event_id = array();

		$this->db->select('event_id');
		$this->db->from('cop_gallery');
		$this->db->where('event_id !=', 'NULL');
		$query = $this->db->get();

		$result = $query->result();

		if( count($result) > 0 ){
			foreach ($result as $obj) {
				array_push($event_id, $obj->event_id);
			}

			return $event_id;
		}else{
			return FALSE;
		}

	}

	/**
	 * GET EVENT LIST THAT IS NOT ON THE GALLERY
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_events()
	{
		$event_id = $this->get_event_album_id();

		$this->db->select('event_id, title');
		$this->db->from('cop_events');
		if( $event_id !== FALSE ){
			$this->db->where_not_in('event_id', $event_id);
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
			$sql = ' cop_gallery.gallery_id,';
			$sql.= ' cop_gallery.event_id,';
			$sql.= ' cop_gallery.cover_photo_id,';
			$sql.= ' cop_gallery.title,';
			$sql.= ' cop_gallery.description,';
			$sql.= ' cop_gallery.date_entered,';
			$sql.= ' cop_gallery.date_modified,';
			$sql.= ' cop_gallery.slug,';
			$sql.= ' cop_gallery_photos.gallery_photos_id,';
			$sql.= ' cop_gallery_photos.raw_name,';
			$sql.= ' cop_gallery_photos.file_path,';
			$sql.= ' cop_gallery_photos.file_ext';

			$this->db->select($sql);
			$this->db->from('cop_gallery');
			$this->db->join('cop_gallery_photos',
			'cop_gallery.cover_photo_id = cop_gallery_photos.gallery_photos_id', 'left');

			foreach ($search_param as $param) {
				$this->db->where(
					$param['fieldname'],
					$param['data']
				);
			}

			$query = $this->db->get();

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}

		}else{
			$sql = ' cop_gallery.gallery_id,';
			$sql.= ' cop_gallery.event_id,';
			$sql.= ' cop_gallery.cover_photo_id,';
			$sql.= ' cop_gallery.title,';
			$sql.= ' cop_gallery.description,';
			$sql.= ' cop_gallery.date_entered,';
			$sql.= ' cop_gallery.date_modified,';
			$sql.= ' cop_gallery.slug,';
			$sql.= ' cop_gallery_photos.gallery_photos_id,';
			$sql.= ' cop_gallery_photos.raw_name,';
			$sql.= ' cop_gallery_photos.file_path,';
			$sql.= ' cop_gallery_photos.file_ext';

			$this->db->select($sql);
			$this->db->from('cop_gallery');
			$this->db->join('cop_gallery_photos',
			'cop_gallery.cover_photo_id = cop_gallery_photos.gallery_photos_id', 'left');

			$query = $this->db->get();

			return $query->result_array();
		}
	}

	/**
	 * GET ALL PHOTOS IN AN ALBUM
	 * @param String, $type -- ['custom', 'event']
	 * @param Array, $search_param
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_album_photos($search_param=array(), $type='custom', $limit=false)
	{
		if( count($search_param) > 0 ){

			foreach ($search_param as $param) {
				$this->db->where(
					$param['fieldname'],
					$param['data']
				);
			}

			$this->db->from('cop_gallery_photos');

			if( $limit ){
				$limit = (Int) $limit;
				$this->db->limit( $limit );
			}

			$query = $this->db->get();

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}

		}else{
			$query = $this->db->get('cop_gallery_photos');
			return $query->result_array();
		}
	}

	public function get_remaining_photos($gallery_id, $gallery_photos_id)
	{
		$this->db->select('gallery_photos_id');
		$this->db->from('cop_gallery_photos');
		$this->db->where('gallery_id', $gallery_id);
		$this->db->where('gallery_photos_id !=', $gallery_photos_id);
		$query = $this->db->get();

		if( count($query) > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
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
		$insert_id = $this->db->insert_id();

		if( $this->db->trans_status() === FALSE ){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return $insert_id;
		}
	}

	/**
	 * DELETES A PHOTO
	 * @param Integer, $gallery_photos_id
	 * @return Boolean
	 * --------------------------------------------
	 */
	public function delete_photo($gallery_photos_id)
	{
		$this->db->trans_begin();
		$this->db->where('gallery_photos_id', $gallery_photos_id);
		$this->db->delete('cop_gallery_photos');

		if( $this->db->trans_status() === FALSE )
		{
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function get_default_cover_photo($gallery_id)
	{
		$this->db->select('cover_photo_id');
		$this->db->from('cop_gallery');
		$this->db->where('gallery_id', $gallery_id);
		$query = $this->db->get();

		if( count($query) > 0 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function default_cover_photo($gallery_id, $photo_id)
	{
		$gallery_data = array('cover_photo_id' => $photo_id);

		$this->db->trans_begin();
		$this->db->where('gallery_id', $gallery_id);
		$this->db->update('cop_gallery', $gallery_data);

		if( $this->db->trans_status() === FALSE ){
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}
}