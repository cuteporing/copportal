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

include_once('common.php');
include_once('upload.php');

class gallery_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->helper('url');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('events_model');
		$this->load->model('gallery_model');
	}

	/**
	 * CHECKS IF THE POST DATA IS NOT NULL AND RETURNS AN
	 * ARRAY OF ERROR MSG
	 * @param Array, $input_field
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_required($input_field)
	{
		$error_log  = array();
		foreach ($input_field as $field) {
			if( $this->input->post($field) == '' ){
				$label = str_replace('_', ' ', ucfirst($field));
				array_push($error_log, array(
					'input'=>$field,
					'error_msg'=>$label.' is required')
				);
			}
		}
		return $error_log;
	}

	/**
	 * CHECK IF ALBUM ALREADY EXISTED
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_album_exist()
	{
		$error_log    = array();
		$search_param = array();
		$album_type   = $this->input->post('album_type');
		//CUSTOM ALBUM
		if( $album_type == 'custom' ){

			//SEARCH PARAMETER FOR ALBUM
			array_push($search_param, array(
					'fieldname'=> 'title',
					'data'     => $this->input->post('title')
					));
			//CHECK IF ALBUM ALREADY EXISTED
			$result = $this->gallery_model->get_album($search_param);

			//RETURN AN ERROR IF ALREADY EXISTED
			if( $result !== false ){
				$error_log = array(
					'status'=>'error',
					'msg'   =>'Album already existed',
				);
			}
		}

		return $error_log;
	}

	/**
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_album_create()
	{
		$error_log = array();
		if( $this->input->post('album_type') == 'custom' ){
			$required_field = array('title');
		}else{
			$required_field = array('event');
		}

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		// }elseif( count($this->validate_album_exist()) > 0 ){
		// 	$error_log = $this->validate_album_exist();
		// 	return common::response_msg(200, $error_log['status'], $error_log['msg']);
		//IF EVENT DATE IS NOT CORRECT
		}else{
			return FALSE;
		}
	}

	/**
	 * CREATES AN ALBUM
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function create_album()
	{
		if( $this->validate_album_create() ){
			echo $this->validate_album_create();
			exit;
		}

		$slug = '';

		if( $this->input->post('album_type') == 'custom' ){
			$slug = url_title($this->input->post('title'), 'dash', TRUE);

			$data = array(
				'title'        => $this->input->post('title'),
				'description'  => $this->input->post('description'),
				'date_entered' => common::get_today(),
				'date_modified'=> common::get_today(),
				'slug'         => $slug
				);
		}else{

			$result_event = $this->events_model->get_events(
				'event_id', $this->input->post('event'));

			foreach ($result_event as $obj) {
				$data = array(
					'event_id'     => $this->input->post('event'),
					'title'        => $obj->title,
					'description'  => $this->input->post('description'),
					'date_entered' => common::get_today(),
					'date_modified'=> common::get_today(),
					'slug'         => $obj->slug
					);
				$slug = $obj->slug;
			}
		}

		$result	= $this->gallery_model->create_album($data);

		if( $result['status'] == 'error' ){
			echo common::response_msg(200, $result['status'], $result['msg']);
		}
		else{
			echo common::response_msg(200, 'refresh', base_url().'account/gallery/'.$slug);
		}
	}

	/**
	 * DELETES AN ALBUM
	 * @return JSON response
	 * --------------------------------------------------------
	 */
	public function delete_album()
	{
		$gallery_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		$result = $this->gallery_model->delete_album($gallery_id);
		if( $result ){
			echo common::response_msg(200, 'success', '');
		}else{
			echo common::response_msg(200, 'error', 'The album contains photos');
		}
	}

	/**
	 * UPLOADS A PHOTO
	 * @param Array, $params
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function upload_gallery_photo($params = array())
	{
		$status = "";
		$msg = "";
		$file_element_name = 'userfile';
		
		if ($status != "error"){
			$upload_path   = ( isset($params['upload_path']) )?   $params['upload_path']   : common::get_constants('imgPath',   'GALLERY');
			$allowed_types = ( isset($params['allowed_types']) )? $params['allowed_types'] : common::get_constants('imgConfig', 'ALLOWED_TYPES');
			$max_size      = ( isset($params['max_size']) )?      $params['max_size']      : common::get_constants('imgConfig', 'MAX_SIZE');
			$max_width     = ( isset($params['max_width']) )?     $params['max_width']     : common::get_constants('imgConfig', 'MAX_WIDTH');
			$max_height    = ( isset($params['max_height']) )?    $params['max_height']    : common::get_constants('imgConfig', 'MAX_HEIGHT');

			$config['upload_path']   = $upload_path;
			$config['allowed_types'] = $allowed_types;
			$config['max_size']	     = $max_size;
			$config['max_width']     = $max_width;
			$config['max_height']    = $max_height;
			$config['encrypt_name'] = FALSE;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload($file_element_name)){
				$status = 'error';
				$msg = $this->upload->display_errors('', '');
			}else{
				$data = $this->upload->data();
				$image_path = $data['full_path'];
				if(file_exists($image_path)){
					//SAVE GALLERY PHOTO TO DATABASE
					$this->save_photo($data);
				}else{
					echo common::response_msg(200, 'error', 'Something went wrong when saving the file, please try again.');
				}
			}
			@unlink($_FILES[$file_element_name]);
		}
	}


	/**
	 * SAVE UPLOADED IMAGE INFO ON DATABASE
	 * @param Array, $uploaded_photo
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function save_photo($uploaded_photo)
	{
		$gallery_id = $this->input->post('gallery_id');
		$is_empty   = $this->gallery_model->check_album_empty($gallery_id);
		$data = array(
			'gallery_id'=>$gallery_id,
			'raw_name'  =>$uploaded_photo['raw_name'],
			'file_path' =>common::get_constants('imgPath', 'GALLERY'),
			'file_ext'  =>$uploaded_photo['file_ext'],
			);

		$last_insert_id = $this->gallery_model->save_photo($data);
		$result         = ( $last_insert_id !== FALSE )? true : false;

		if( $last_insert_id !== FALSE && $is_empty === TRUE){
			$default_cover = $this->gallery_model->default_cover_photo($gallery_id, $last_insert_id);
			echo common::response_msg(200, 'refresh', $default_cover);
			exit;
		}

		if( $result ){
			echo common::response_msg(200, 'refresh', '');
		}else{
			echo common::response_msg(200, 'error', 'Something went wrong when saving the file, please try again.');
		}
	}

	public function cover_photo()
	{
		$photo_params = array();
		$gallery_photos_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		//SEARCH PARAMETERS FOR ALBUM PHOTOS
		array_push($photo_params,
			array('fieldname'=>'gallery_photos_id',
				  'data'     =>$gallery_photos_id )
		);

		//GET ALBUM PHOTOS
		$result_album_photos = $this->gallery_model->get_album_photos(
				$photo_params, '', 1);

		foreach ($result_album_photos as $photo) {
			$gallery_id = $photo->gallery_id;

			$result     = $this->gallery_model->default_cover_photo()

		}
	}

	/**
	 * DELETES A PHOTO
	 * @return JSON response
	 * --------------------------------------------------------
	 */
	public function delete_photo()
	{
		$photo_params = array();

		$gallery_photos_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		//SEARCH PARAMETERS FOR ALBUM PHOTOS
		array_push($photo_params,
			array('fieldname'=>'gallery_photos_id',
				  'data'     =>$gallery_photos_id )
		);

		//GET ALBUM PHOTOS
		$result_album_photos = $this->gallery_model->get_album_photos(
				$photo_params, '', 1);

		foreach ($result_album_photos as $photo) {
			$gallery_id         = $photo->gallery_id;
			$result_album_cover = $this->gallery_model->get_default_cover_photo($gallery_id);
			$file_path          = $photo->file_path.$photo->raw_name.$photo->file_ext;

			foreach ($result_album_cover as $album) {
				$cover_id = $album->cover_photo_id;

				// if( $gallery_photos_id == $cover_id ){
				// 	$update =
				// }

				$result = $this->gallery_model->delete_photo($gallery_photos_id);
				if( $result ){
					@unlink($file_path);
					echo common::response_msg(200, 'refresh', '');
				}else{
					echo common::response_msg(200, 'error', 'The album contains photos');
				}

			}
		}

		

		
	}

}
?>