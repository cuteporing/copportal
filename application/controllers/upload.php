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

//INCLUDE CONTROLLERS
include_once('common.php');

class upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->helper('url');
	}
	public function index()
	{
		$this->load->view('pages/upload');
	}
	/**
	 * UPLOADS A PHOTO
	 * @param Array, $params
	 * @return Array
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
					$status = "success";
					$msg = "File successfully uploaded";
				}else{
					$status = "error";
					$msg = "Something went wrong when saving the file, please try again.";
				}
			}
			@unlink($_FILES[$file_element_name]);
		}
		foreach ($data as $row=>$val) {
			print_r('<b>'.$row.'</b>: '.$val.'<br>');
		}
		// echo json_encode(array('status' => $status, 'msg' => $msg, 'img_data'=>$data));
	}
}
?>