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

class gallery_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
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

		//EVENT ALBUM
		}elseif ( $album_type == 'event' ) {

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
			$required_field = array('event_id');
		}

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		}elseif( count($this->validate_album_exist()) > 0 ){
			$error_log = $this->validate_album_exist();
			return common::response_msg(200, $error_log['status'], $error_log['msg']);
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

		if( $this->input->post('album_type') == 'custom' ){
			$data = array(
				'title'        => $this->input->post('title'),
				'description'  => $this->input->post('description'),
				'date_entered' => common::get_today(),
				'date_modified'=> common::get_today(),
				'slug'         => url_title($this->input->post('title'), 'dash', TRUE)
				);
		}else{
			$data = array(
				'event_id'     => $this->input->pos('event_id'),
				// 'title'        => $this->input->post('title'),
				// 'description'  => $this->input->post('description'),
				'date_entered' => common::get_today(),
				'date_modified'=> common::get_today(),
				// 'slug'         => url_title($this->input->post('title'), 'dash', TRUE)
				);
		}

		$result	= $this->gallery_model->create_album($data);

		if( $result['status'] == 'error' ){
			echo common::response_msg(200, $result['status'], $result['msg']);
		}else{
			echo common::response_msg(200, 'refresh', '');
		}
	}

	/**
	 * DELETES AN ALBUM
	 * @return Array, $response
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
}
?>