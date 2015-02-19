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

		for( $i=0; $i<count($result); $i++ ){
			$result_desc = $this->announcements_model->get_announcement_desc($result[$i]['announcement_id']);
			if( $result_desc !== FALSE ){
				foreach ($result_desc as $row) {
					$description = $row->description;
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
	 * DISPLAY AANOUNCEMENT PAGE
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

	public function view_artcore($page)
	{
		$data['page_header'] = array('title'=>$page, 'subtitle'=>'News and announcements');
		$view_type = str_replace('/', '', $this->uri->slash_segment(2, 'leading'));

		if( $view_type == 'page' ){
			$page_num = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		}elseif( $view_type == 'title' ){
			$title = str_replace('/', '', $this->uri->slash_segment(3, 'leading'));

		//SHOW ANNOUNCEMENTS
		}else{
			$result = $this->announcements_model->get_announcements();

			if( $result ){

				for ($i=0; $i<count($result); $i++) {
					$result[$i]['description'] = $this->announcements_model->get_announcement_desc(
						$result[$i]['announcement_id']);
				}

				$data['announcement_list'] = $result;
			}

		}

		$this->load->view('templates/pages/content_wrapper_open');
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/pages/content_wrapper_close');
	}
}
?>