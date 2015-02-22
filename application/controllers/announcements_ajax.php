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
include_once('users.php');

class announcements_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('form_validation');
		$this->load->model('announcements_model');
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
	 * VALIDATES ALL POST DATA NEEDED FOR CREATING AN EVENT
	 * @return Array, $error_log
	 * --------------------------------------------------------
	 */
	public function validate_announcement_create()
	{
		$error_log = array();
		$required_field = array('title');

		//IF THERE ARE MISSING INPUT DATA
		if( count($this->validate_required($required_field)) > 0 ){
			$error_log = $this->validate_required($required_field);
			return common::response_msg(200, 'error_field', '', $error_log);
		}else{
			return FALSE;
		}
	}

	/**
	 * CREATES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function create()
	{
		if( $this->validate_announcement_create() ){
			echo $this->validate_announcement_create();
			exit;
		}
		$session_data = $this->session->userdata('logged_in');

		$announcement_data = array(
			'owner_id'     =>$session_data['id'],
			'title'        =>$this->input->post('title'),
			'date_entered' =>common::get_today(),
			'slug'         =>url_title($this->input->post('title'), 'dash', TRUE)
			);

		$description_data = array();
		$description = str_split($this->input->post('description'), 1000);
		$sequence = 1;

		foreach ($description as $text) {
			array_push($description_data, array(
				'announcement_id' => 0,
				'description'     => $text,
				'sequence'        => $sequence)
			);
			$sequence++;
		}
		$result = $this->announcements_model->create_announcements($announcement_data, $description_data);

		if( $result ){
			$local_storage = array('modal_id'=>$result['msg']);
			echo common::response_msg(200, 'redirect', base_url().'account/announcements/edit/'.$result['msg'],$local_storage);
		}else{
			echo common::response_msg(200, 'error', 'Cannot create announcement');
		}
	}

	/**
	 * CREATES AN EVENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function edit()
	{
		if( $this->validate_announcement_create() ){
			echo $this->validate_announcement_create();
			exit;
		}
		$session_data = $this->session->userdata('logged_in');
		$announcement_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		$announcement_data = array(
			'owner_id'       =>$session_data['id'],
			'announcement_id'=>$this->input->post('announcement_id'),
			'title'          =>$this->input->post('title'),
			'slug'           =>url_title($this->input->post('title'), 'dash', TRUE)
			);

		$description_data = array();
		$description = str_split($this->input->post('description'), 1000);
		$sequence = 1;

		foreach ($description as $text) {
			array_push($description_data, array(
				'announcement_id' => $announcement_id,
				'description'     => $text,
				'sequence'        => $sequence)
			);
			$sequence++;
		}
		$result = $this->announcements_model->update_announcements($announcement_data, $description_data);

		echo common::response_msg(200, $result['status'], $result['msg']);
	}

	/**
	 * DELETES AN ANNOUNCEMENT
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete()
	{
		$announcement_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$announcements   = $this->announcements_model->get_announcements('announcement_id', $announcement_id);

		$file_path  = $announcements[0]['file_path'];
		$file_path .= $announcements[0]['raw_name'];
		$file_path .= $announcements[0]['file_ext'];

		$result = $this->announcements_model->delete_announcement($announcement_id);

		if( $result ){
			@unlink($file_path);
			echo common::response_msg(200, 'success', 'Announcement has been deleted');
		}else{
			echo common::response_msg(200, 'error', 'Cannot delete announcement');
		}
	}

	/**
	 * UPLOADS A PHOTO
	 * @param Array, $params
	 * @return JSON response
	 * --------------------------------------------
	 */
	public function upload_photo()
	{
		$status = "";
		$msg = "";
		$file_element_name = 'userfile';

		if ($status != "error"){
			$upload_path   = ( isset($params['upload_path']) )?   $params['upload_path']   : './'.common::get_constants('imgPath', 'ANNOUNCEMENT');
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
				$msg    =  $this->upload->display_errors('', '');
				echo common::response_msg(200, 'error', $msg);
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
		$announcement_id   = $this->input->post('announcement_id');

		$data = array(
			'announcement_id'  =>$announcement_id,
			'raw_name'  =>$uploaded_photo['raw_name'],
			'file_path' =>common::get_constants('imgPath', 'ANNOUNCEMENT'),
			'file_ext'  =>$uploaded_photo['file_ext'],
			);

		$announcements = $this->announcements_model->get_announcements(
					'announcement_id', $announcement_id);

		$result = $this->announcements_model->update_announcements($data);

		if( $result['status'] == 'success' ){
			if( !is_null($announcements[0]['raw_name']) ){
				$file_path  = $announcements[0]['file_path'];
				$file_path .= $announcements[0]['raw_name'];
				$file_path .= $announcements[0]['file_ext'];
				@unlink($file_path);
			}
			echo common::response_msg(200, 'refresh', '');
		}else{
			echo common::response_msg(200, 'error', 'Something went wrong when saving the file, please try again.');
		}
	}
}
?>