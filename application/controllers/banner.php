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

class banner extends CI_Controller
{
	private $banner;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('artcore_model');
		$this->load->model('banner_model');
	}

	/**
	 * CREATE AN EVENT ALBUM MODAL
	 * @return modal
	 * --------------------------------------------
	 */
	public function upload_photo_modal()
	{
		$data['modal_id']     = 'upload-photo-modal';
		$data['modal_header'] = '<i class="fa fa-upload"></i> Upload photos';
		$this->load->view('templates/modal/modal_header', $data);
		$this->load->view('templates/forms/banner_upload_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}

	public function get_artcore_banner()
	{
		return $this->banner_model->get_banner();
	}

	/**
	 * GET BANNER
	 * @return page
	 * --------------------------------------------
	 */
	public function get_banner()
	{
			$banner_list = $this->banner_model->get_banner();
			if( $banner_list ){
				$data['banner_list']   = $banner_list;
				$this->load->view('account/banner', $data);
			}else{
				$this->load->view('account/banner');
			}

			$this->upload_photo_modal();
	}

	/**
	 * DISPLAY GALLERY PAGE
	 * @param String, $page
	 * @param String, $header
	 * @param String, $sidebar
	 * @param String, $c_header
	 * @return page
	 * --------------------------------------------
	 */
	public function view($page, $header, $sidebar, $c_header)
	{
		$session_data = $this->session->userdata('logged_in');
		$data['header']  = $header;
		$data['sidebar'] = $sidebar;
		$data['content_header'] = $c_header;

		$parameter = $this->uri->slash_segment(3, 'leading');

		//CONTENT HEADER
		$this->load->view('templates/accounts/header', $data);

		switch ($parameter) {
			case '/edit'  : $this->edit();   break;
			default:$this->get_banner();     break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}

}