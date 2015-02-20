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

class announcements extends CI_controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('announcements_model');
		$this->load->library('pagination');
		$this->load->helper('file');
	}

	/**
	 * SET OF ACTION BUTTON FOR TABLE DISPLAY
	 * @return Array
	 * --------------------------------------------
	 */
	static function action_btn()
	{
		return array(
				0 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						1 => array(
							'data_name' =>'title',
							'value'=>'Edit')
						),
					'icon' =>'fa fa-edit',
					'title'=>'Edit',
					'type' =>'info',
					'url'  =>'account/announcements/edit/',
					),
				1 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-ajax',
							'value'=>'delete'),
						1 => array(
							'data_name' =>'data-del-type',
							'value'=>'table'),
						3 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						4 => array(
							'data_name' =>'title',
							'value'=>'Delete')
						),
					'icon' =>'fa fa-trash-o',
					'title'=>'Delete',
					'type' =>'danger',
					'url'  =>'announcements_ajax/delete/',
					)
				);
	}

	/**
	 * DISPLAY CREATE ANNOUNCEMENT PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function create()
	{
		return $this->load->view('templates/forms/announcement_form');
	}

	/**
	 * DISPLAY ANNOUNCEMENT EDIT PAGE
	 * @return page
	 * --------------------------------------------
	 */
	public function edit()
	{
		$session_data = $this->session->userdata('logged_in');

		$announcement_id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		//IF THERE IS NO EVENT ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $announcement_id == '' ){
			return $this->load->view('error/record_not_found');
		}

		//GET EVENT DETAILS
		$result = $this->announcements_model->get_announcements('announcement_id', $announcement_id);
		//GET EVENT DESCRIPTION
		$result_desc = $this->announcements_model->get_announcement_desc($announcement_id);

		//IF THERE IS NO EVENT, SHOW ERROR RECORD NOT FOUND
		if( $result === FALSE ){
			return $this->load->view('error/record_not_found');
		}

		$data['result']      = $result[0];
		$data['result_desc'] = ($result_desc)? $result_desc : array();

		return $this->load->view('templates/forms/announcement_form', $data);
	}

	/**
	 * DISPLAY THE LIST OF ANNOUNCEMENTS
	 * @return table
	 * --------------------------------------------
	 */
	public function get_announcements()
	{
		$result = $this->announcements_model->get_announcements();
		$description = '';
		for( $i=0; $i<count($result); $i++ ){
			$result[$i]['title'] = character_limiter($result[$i]['title'], 20);

			$result_desc = $this->announcements_model->get_announcement_desc($result[$i]['announcement_id']);
			if( $result_desc !== FALSE ){
				foreach ($result_desc as $row) {
					$description = character_limiter($row['description'], 60);
				}
			}else{
				$description = '';
			}

			$result[$i]['date_entered']  = common::format_date($result[$i]['date_entered'], 'M d, Y');
			$result[$i]['result_id']     = $result[$i]['announcement_id'];
			$result[$i]['description']   = $description;
		}

		$data['action_btn']   = self::action_btn();
		$data['table_name']   = 'Announcements';
		$data['fieldname']    = array('title', 'description', 'date_entered', 'action');
		$data['field_label']  = array('Title', 'Description', 'Date', '&nbsp;');
		$data['result']       = $result;

		return $this->load->view('templates/tables/data_tables_full', $data);
	}


	/**
	 * DISPLAY ANNOUNCEMENT PAGE
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
			default:$this->get_announcements();     break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}


	/**
	 * DISPLAY ANNOUNCEMENT FRONT-SIDE PAGE
	 * @param String, $page
	 * @return page
	 * --------------------------------------------
	 */
	public function view_artcore($page)
	{
		$view_type  = str_replace('/', '', $this->uri->slash_segment(2, 'leading'));

		//VIEW ANNOUNCEMENTS PER PAGE
		if( $view_type == 'page' ){
			$total_rows = $this->announcements_model->get_no_anouncements();
			$limit      = 10;
			if( $total_rows > 0 ){
				//GET THE OFFSET VIA URI SEGMENT
				$offset = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

				//SEARCH PARAMETERS FOR GETTING THE ANNOUNCEMENT LIST
				$params = array();
				$params['offset'] = $offset;
				$params['limit']  = $limit;

				//GET ANNOUNCEMENT LIST
				$result = $this->announcements_model->get_announcements_list($params);

				for ($i=0; $i<count($result); $i++) {
					//GET DESCRIPTION
					$description = $this->announcements_model->get_announcement_desc(
						$result[$i]['announcement_id']);
					//FORMAT DATE
					$result[$i]['date_entered'] = common::format_date(
						$result[$i]['date_entered'], 'd F Y');

					$result[$i]['title'] = character_limiter($result[$i]['title'], 29);
					//GET THE ANNOUNCEMENT DESCRIPTION
					$result[$i]['description']  = word_limiter($description[0]['description'], 40);
				}

				//SET UP PAGINATION
				$config['base_url'] = 'http://localhost/copportal/announcement/page/';
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

				//DATAS
				$data['announcement_list']  = $result;
				$data['artcore_pagination'] = $this->pagination->create_links();
			}

		//SHOW ANNOUNCEMENT PER TITLE
		}elseif( $view_type == 'title' ){
			$slug = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));
			
			$result                   = $this->announcements_model->get_announcements('slug', $slug);
			$result[0]['date_entered']= common::format_date(
						$result[0]['date_entered'], 'd F Y');
			$result[0]['description'] = $this->announcements_model->get_announcement_desc(
						$result[0]['announcement_id']);

			$data['announcement_single']  = $result[0];
		}

		$data['page_header'] = array('title'=>$page, 'subtitle'=>'News and announcements');

		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/pages/content_wrapper_close');
	}
}
?>