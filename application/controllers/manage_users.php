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

class manage_users extends account
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('city_model');
		$this->load->model('department_model');
		$this->load->model('events_model');
		$this->load->model('users_model');
		$this->load->library('form_validation');
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
					'url'  =>'account/manage_users/edit/',
					),
				1 => array(
					'data_attr' =>array(
						0 => array(
							'data_name' =>'data-ajax',
							'value'=>'delete'),
						1 => array(
							'data_name' =>'data-del-type',
							'value'=>'table'),
						2 => array(
							'data_name' =>'data-toggle',
							'value'=>'tooltip'),
						3 => array(
							'data_name' =>'title',
							'value'=>'Delete')),
					'icon' =>'fa fa-trash-o',
					'title'=>'Delete',
					'type' =>'danger',
					'url'  =>'manage_users_ajax/delete/',
					)
				);
	}


	/**
	 * CREATE A PASSWORD FORM MODAL
	 * @return modal
	 * --------------------------------------------
	 */
	public function change_password_modal($result)
	{
		$data['id']           = $result->id;
		$data['user_name']    = $result->user_name;
		$data['first_name']   = $result->first_name;
		$data['modal_id']     = 'change-password-modal';
		$data['modal_header'] = '<i class="fa fa-key"></i> Change password';
		$this->load->view('templates/modal/modal_header', $data);
		$this->load->view('templates/forms/change_password_form', $data);
		$this->load->view('templates/modal/modal_footer', $data);
	}

	/**
	 * GENDER COMBO BOX
	 * @return Array
	 * --------------------------------------------
	 */
	public function get_gender()
	{
		return array('Female', 'Male', 'Other');
	}

	/**
	 * DISPLAY CREATE USER PAGE
	 * @return table
	 * --------------------------------------------
	 */
	public function create()
	{
		$session_data = $this->session->userdata('logged_in');
		
		if( $session_data['user_kbn'] != 30 ){
				redirect('account/dashboard', 'refresh');
		}

		$data['dept_list']      = $this->department_model->get_department();
		$data['city_list']      = $this->city_model->get_cities();
		$data['gender_list']    = $this->get_gender();
		$data['user_type_list'] = $this->users_model->get_user_kbn();

		$this->load->view('templates/forms/user_form', $data);
	}

	/**
	 * EDIT USER
	 * @return PAGE
	 * --------------------------------------------
	 */
	public function edit()
	{
		$id = str_replace('/', '', $this->uri->slash_segment(4, 'leading'));

		$session_data = $this->session->userdata('logged_in');

		if( $session_data['user_kbn'] != 30 && $session_data['id'] != $id){
				redirect('account/dashboard', 'refresh');
		}

		//IF THERE IS NO BENEFICIARY ID FROM URI, SHOW ERROR RECORD NOT FOUND
		if( $id == '' ){
			return $this->load->view('error/record_not_found');
		}

		//GET BENEFICIARY DETAILS
		$result = $this->users_model->get_user('id', $id);

		//IF THERE IS NO BENEFICIARY, SHOW ERROR RECORD NOT FOUND
		if( $result === FALSE ){
			return $this->load->view('error/record_not_found');
		}

		$selected = array(
			'address_city_id'=>$result[0]->address_city_id,
			'gender' =>$result[0]->gender,
			'dept_id' =>$result[0]->dept_id,
			'user_kbn' =>$result[0]->user_kbn
			);
		$phone_list = json_decode( $result[0]->phone );

		if( !count( $phone_list ) > 0 ){
			$data['phone_list'] = '';
		}else{
			$data['phone_list'] = $phone_list;
		}

		$data['result']         = $result[0];
		$data['selected']       = $selected;
		$data['city_list']      = $this->city_model->get_cities();
		$data['dept_list']      = $this->department_model->get_department();
		$data['gender_list']    = $this->get_gender();
		$data['user_type_list'] = $this->users_model->get_user_kbn();

		if( $session_data['user_kbn'] != 30 && $session_data['id'] == $id){
			$data['restricted']   = 'yes';
		}

		$this->change_password_modal($result[0]);
		$this->load->view('templates/forms/user_form', $data);
	}

	/**
	 * DISPLAY THE LIST OF USERS
	 * @return table
	 * --------------------------------------------
	 */
	public function get_users()
	{
		$session_data = $this->session->userdata('logged_in');
		
		if( $session_data['user_kbn'] != 30 ){
				redirect('account/dashboard', 'refresh');
		}
		$field_name = array('deleted');
		$field_value = array('0');
		$result = $this->users_model->get_user($field_name, $field_value);

		for( $i=0; $i<count($result); $i++ ){
			$result_dept =  $this->department_model->get_department('dept_id', $result[$i]['dept_id']);

			$result[$i]['department'] = $result_dept[0]['department'];
			$result[$i]['name'] =  '<b>'.$result[$i]['last_name'].'</b>, '.$result[$i]['first_name'];
			$result[$i]['result_id'] = $result[$i]['id'];
		}

		$data['action_btn']   = self::action_btn();
		$data['table_name']   = 'List of users';
		$data['fieldname']    = array('name', 'department', 'status', 'action');
		$data['field_label']  = array('Name', 'Department', 'Status', '&nbsp;');
		$data['result']       = $result;

		return $this->load->view('templates/tables/data_tables_full', $data);
	}

	/**
	 * DISPLAY MANAGE USERS PAGE
	 * @param String, $page
	 * @param String, $header
	 * @param String, $sidebar
	 * @param String, $c_header
	 * @return page
	 * --------------------------------------------
	 */
	public function view($page, $header, $sidebar, $c_header)
	{
		$data['header']  = $header;
		$data['sidebar'] = $sidebar;
		$data['content_header'] = $c_header;

		$parameter = $this->uri->slash_segment(3, 'leading');

		//CONTENT HEADER
		$this->load->view('templates/accounts/header', $data);

		switch ($parameter) {
			case '/create': $this->create(); break;
			case '/edit'  : $this->edit();   break;
			default:$this->get_users();     break;
		}
		//CONTENT FOOTER
		$this->load->view('templates/accounts/footer');
	}
}
?>