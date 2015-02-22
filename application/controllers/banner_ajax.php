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


class banner_ajax extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->library('form_validation');
		$this->load->model('banner_model');
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
			$upload_path   = ( isset($params['upload_path']) )?   $params['upload_path']   : './'.common::get_constants('imgPath', 'BANNER');
			$allowed_types = ( isset($params['allowed_types']) )? $params['allowed_types'] : common::get_constants('imgConfig', 'ALLOWED_TYPES');
			$max_size      = '800';
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
		$upload_type = $this->input->post('upload_type');

		if( $upload_type == 'create' ){
			$data = array(
				'title'      => $this->input->post('banner_title'),
				'subtitle'   => $this->input->post('banner_subtitle'),
				'sequence'   => 0,
				'link'       => $this->input->post('banner_link'),
				'link_title' => 'See more',
				'raw_name'   => $uploaded_photo['raw_name'],
				'file_path'  => common::get_constants('imgPath', 'BANNER'),
				'file_ext'   => $uploaded_photo['file_ext'],
				'slug'       => url_title($this->input->post('banner_title'), 'dash', TRUE)
				);

			$result = $this->banner_model->create($data);

			if( $result ){
				echo common::response_msg(200, 'refresh', '');
			}else{
				echo common::response_msg(200, 'error', 'Something went wrong when saving the file, please try again.');
			}
		}
	}

	/**
	 * DELETE A BANNER
	 * @return Array, $response
	 * --------------------------------------------------------
	 */
	public function delete()
	{
		$banner_id  = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$banners    = $this->banner_model->get_banner('banner_id', $banner_id);

		$file_path  = $banners[0]['file_path'];
		$file_path .= $banners[0]['raw_name'];
		$file_path .= $banners[0]['file_ext'];

		$result = $this->banner_model->delete($banner_id);
		if( $result ){
			@unlink($file_path);
			echo common::response_msg(200, 'refresh', '');
		}else{
			echo common::response_msg(200, 'error', 'Cannot delete banner');
		}
	}
}