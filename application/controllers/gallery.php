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

class gallery extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('gallery_model');
		$this->load->library('pagination');
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
					$data['gallery_id']   = $obj['gallery_id'];
					$data['gallery_type'] = ( $obj['event_id'] === null )? 'custom' : 'event';

					//SEARCH PARAMETERS FOR ALBUM PHOTOS
					array_push($photo_params, array(
						'fieldname'=>'gallery_id',
						'data'     =>$data['gallery_id']) );

					//GET ALBUM PHOTOS
					$result_album_photos = $this->gallery_model->get_album_photos(
							$photo_params,
							$data['gallery_type']);

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
			$photo_params = array();

			$result_event_list = $this->gallery_model->get_events();
			$result_album      = $this->gallery_model->get_album();

			for($i=0; $i < count($result_album); $i++) {
				//SEARCH PARAMETERS FOR ALBUM PHOTOS
				array_push($photo_params, array(
					'fieldname'=>'gallery_id',
					'data'     =>$result_album[$i]['gallery_id']) );

				$result_album[$i]['title'] = character_limiter($result_album[$i]['title'], 8);
				$result_photos             = $this->gallery_model->get_album_photos($photo_params, '');
				// $result_album['photos'] = $result_photos;
			}
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

	/**
	 * DISPLAY GALLERY FRONT-SIDE PAGE
	 * @param String, $page
	 * @return page
	 * --------------------------------------------
	 */
	public function view_artcore($page)
	{
		$limit  = 10;
		$filter = array();
		$params = array();
		$search = array();
		$common = new common;

		$offset     = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$slug       = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
		$view_type  = str_replace('/', '', $this->uri->slash_segment(2, 'leading'));

		//PHOTO DISPLAY DISPLAY
		if( $view_type == 'title' ){

			array_push($search, array(
						'fieldname'=>'slug',
						'data'     =>$slug));

			$result_album = $this->gallery_model->get_album($search);

			if( $result_album ){
				//SEARCH PARAMETERS FOR ALBUM PHOTOS
				$search[0]['fieldname'] = 'gallery_id';
				$search[0]['data']      =  $result_album[0]['gallery_id'];

				$result_album[0]['title'] = character_limiter($result_album[0]['title'], 8);
				$result_album[0]['photos']= $this->gallery_model->get_album_photos($search, '');
				$result_album[0]['description'] = character_limiter($result_album[0]['description'], 200);

				$data['album_single'] = $result_album[0];
				$data['page_header'] = array('title'=>'Gallery', 'subtitle'=>$result_album[0]['title']);

			}
		}elseif( 'page' ){
			//GET TOTAL NO. OF ALBUMS
			$total_rows = $this->gallery_model->get_no_of_albums();

			if( $offset > ($total_rows) || $offset > $limit ){
				return $common->show_404();
			}

			if( $total_rows > 0 ){
				$params['offset'] = $offset;
				$params['limit']  = $limit;

				$result_album = $this->gallery_model->get_album();

				for($i=0; $i < count($result_album); $i++) {
					//SEARCH PARAMETERS FOR ALBUM PHOTOS
					array_push($search, array(
						'fieldname'=>'gallery_id',
						'data'     =>$result_album[$i]['gallery_id']) );

					$result_album[$i]['title'] = character_limiter($result_album[$i]['title'], 8);
					$result_album[$i]['photos']= $this->gallery_model->get_album_photos($search, '');
					$result_album[$i]['description'] = character_limiter($result_album[$i]['description'], 200);
				}
				$data['album_list'] = $result_album;
				$config['base_url'] = 'account/gallery/page/';
				$config['uri_segment'] = 3;
				$config['total_rows'] = $total_rows;
				$config['per_page'] = $limit;
				$config['full_tag_open'] = '<div class="row"><div class="col-md-12"><div class="pagination text-center"><ul>';
				$config['full_tag_close'] = '</ul></div></div></div>';
				$config['cur_tag_open'] = '<li><a href="javascript:void(0)" class="active">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';
				$config['first_link'] = '<li>First';
				$config['last_link'] = '<li>Last';
				$config['prev_link'] = FALSE;
				$config['next_link'] = FALSE;
				$this->pagination->initialize($config);

				$data['filter']             = common::sort_month($filter);
				$data['artcore_pagination'] = $this->pagination->create_links();
			}
			$data['page_header'] = array('title'=>'Gallery', 'subtitle'=>'');
		}

		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/pages/content_wrapper_close');
	}
}