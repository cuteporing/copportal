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
		$this->load->view('templates/forms/event_album_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
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
		$this->load->view('templates/forms/gallery_upload_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}

	/**
	 * GET GALLERY
	 * @return page
	 * --------------------------------------------
	 */
	public function get_gallery()
	{
		$album_slug = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		if( $album_slug !== '' ){
			// $params
			$album_params = array();
			$photo_params = array();
			array_push($album_params, array('fieldname'=>'slug', 'data'=>$album_slug) );

			$result_album = $this->gallery_model->get_album($album_params);

			if( $result_album ){
				foreach ($result_album as $obj) {
					$data['gallery_id']   = $obj->gallery_id;
					$data['gallery_type'] = ( $obj->event_id === null )? 'custom' : 'event';

					//SEARCH PARAMETERS FOR ALBUM PHOTOS
					array_push($photo_params, array(
						'fieldname'=>'gallery_id',
						'data'     =>$data['gallery_id']) );

					//GET ALBUM PHOTOS
					$result_album_photos = $this->gallery_model->get_album_photos(
							$data['gallery_type'], $photo_params);

					if( $result_album_photos ){
						$data['result_album_photos'] = $result_album_photos;
					}
				}
			}

			$result_event_list = $this->gallery_model->get_events();

			$data['btn_upload'] = 'show';
			$data['event_list'] = $result_event_list;
			$this->load->view('account/gallery', $data);
			$this->custom_album_modal();
			$this->event_album_modal();
			$this->upload_photo_modal();
		}else{
			$result_event_list = $this->gallery_model->get_events();
			$result_album      = $this->gallery_model->get_album();

			$data['btn_upload']   = 'hide';
			$data['event_list']   = $result_event_list;
			$data['result_album'] = $result_album;
			$this->load->view('account/gallery', $data);
			$this->custom_album_modal();
			$this->event_album_modal();
		}
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