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

class gallery extends account
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('gallery_model');
	}

	/**
	 * CREATE A CUSTOM ALBUM MODAL
	 * @return modal
	 * --------------------------------------------
	 */
	public function custom_album_modal()
	{
		$data['modal_id']     = 'custom-album-modal';
		$data['modal_header'] = '<i class="fa fa-edit"></i> Create an album';
		$this->load->view('templates/modal/modal_header', $data);
		$this->load->view('templates/forms/custom_album_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}

	/**
	 * CREATE AN EVENT ALBUM MODAL
	 * @return modal
	 * --------------------------------------------
	 */
	public function event_album_modal()
	{
		$data['modal_id']     = 'event-album-modal';
		$data['modal_header'] = '<i class="fa fa-calendar-o"></i> Create an event album';
		$this->load->view('templates/modal/modal_header', $data);
		// $this->load->view('templates/forms/album_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}

	/**
	 * GET GALLERY
	 * @return page
	 * --------------------------------------------
	 */
	public function get_gallery()
	{
		$album_id = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		if( $album_id !== '' ){

		}else{
			$data['result_album'] = $this->gallery_model->get_album();
		}
		$this->load->view('account/gallery', $data);
		$this->custom_album_modal();
		$this->event_album_modal();
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
			case '/create': $this->create(); break;
			case '/edit'  : $this->edit();   break;
			case '/manage': $this->manage(); break;
			default:$this->get_gallery();    break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}
}