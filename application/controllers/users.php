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

class users extends CI_Controller
{
	private $DEFAULT_PASSWORD_CRYPT_TYPE;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model');
		$this->load->helper('security');
		$this->load->library('form_validation');
	}

	/**
	 * RETURNS ENCRYPTION TYPE BASED ON PHP VERSION
	 * @return String, $DEFAULT_PASSWORD_CRYPT_TYPE
	 * --------------------------------------------------------
	 */
	public function checkPHPVersion(){
		$this->DEFAULT_PASSWORD_CRYPT_TYPE = (version_compare(PHP_VERSION, '5.3.0') >= 0)?
			'PHP5.3MD5': 'MD5';
		return $this->DEFAULT_PASSWORD_CRYPT_TYPE;
	}

	/**
	 * ENCRYPT PASSWORD
	 * @param Array, $user_info
	 * @param String, $user_password
	 * @return String, $encrypted_password
	 * --------------------------------------------------------
	 */
	public function encrypt_password($user_info, $user_password) {

		//GET THE FIRST 2 CHARACTERS FROM THE USERNAME FOR SALT
		$salt = substr($user_info['user_name'], 0, 2);
		//GET ENCRYPTION TYPE
		$crypt_type = $user_info['crypt_type'];

		//IF THERE IS NO ENCRYPTION TYPE DEFINED, THE USE THE
		//DEFAULT ENCRYPTION TYPE
		if($crypt_type == '') {
			$crypt_type = $this->DEFAULT_PASSWORD_CRYPT_TYPE;
		}

		if($crypt_type == 'MD5')
			$salt = '$1$' . $salt . '$';
		elseif($crypt_type == 'BLOWFISH')
			$salt = '$2$' . $salt . '$';
		elseif($crypt_type == 'PHP5.3MD5')
			$salt = '$1$' . str_pad($salt, 9, '0');

		//USES BLOWFISH FOR ENCRYPTION
		$encrypted_password = crypt($user_password, $salt);

		return $encrypted_password;
	}

	/**
	 * LOGIN
	 * @return session user data
	 * --------------------------------------------
	 */
	public function login($page)
	{
		//VALIDATE FIELDS
		$this->form_validation->set_rules('username', 'Student No.', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		//SET AN ERROR MESSAGE
		$data['error_msg'] = common::error_msg($this->lang->line('error_invalid_user'));

		if( $this->form_validation->run() === FALSE ){
			//SHOW VALIDATION MESSAGES
			$data['error_msg'] = '';
			return $this->load->view('pages/'.$page, $data);
		}else{
			$username = $this->input->post('username');

			//GET PHP VERSION TO DETERMINE WHAT KIND OF ENCRYPTION
			//TO BE USED
			$this->checkPHPVersion();

			$user_info = array(
				'user_name' =>$username,
				'crypt_type'=>''
				);

			//GET THE ENCRYPTED PASSWORD W/ SALT
			$encrypt_pass = $this->encrypt_password(
				$user_info, $this->input->post('password'));

			$result = $this->users_model->check_user($username, $encrypt_pass);

			if( $result ){
				//IF INPUTTED PASS AND THE PASSWORD FROM DB IS THE SAME
				$sess_array = array();
				foreach ($result as $row) {
					$sess_array = array(
						'id'          =>$row['id'],
						'user_name'   =>$row['user_name'],
						'first_name'  =>$row['first_name'],
						'last_name'   =>$row['last_name'],
						'user_kbn'    =>$row['user_kbn'],
						'gender'      =>$row['gender'],
						'date_entered'=>$row['date_entered'],
						'imagename'   =>$row['imagename'],
					);
					$this->session->set_userdata('logged_in', $sess_array);
				}
				$session_data = $this->session->userdata('logged_in');

				redirect('account/dashboard', 'refresh');
			}else{
				//IF USERNAME IS NOT FOUND THEN RETURN AN ERROR MESSAGE
				return $this->load->view('pages/'.$page, $data);
			}
		}
	}

	/**
	 * DISPLAYS USER'S PROFILE PICTURE
	 * @return img
	 * --------------------------------------------
	 */
	public function get_user_img($src, $gender = 'male')
	{
		if( $src['src'] == '' ){
			( $gender == 'male' )?
				$src['src'] = 'assets/img/avatar5.png'
			: $src['src'] = 'assets/img/avatar3.png';
		}

		return img($src);
	}

	/**
	 * GET'S THE NO. OF ACTIVE USERS THAT IS ACTIVE
	 * @return img
	 * --------------------------------------------
	 */
	public function get_no_of_user()
	{
		return $this->users_model->get_no_of_user();
	}

	public function get_login_info()
	{
			$session_data = $this->session->userdata('logged_in');
			$result = $this->users_model->get_login_info($session_data['id']);

			if( !$result ){
				$this->logout();
			}
			$this->session->unset_userdata('logged_in');

			$sess_array = array();
			foreach ($result as $row) {
				if( (int)$row->deleted === 1 ){
					$this->logout();
				}

				$sess_array = array(
					'id'          =>$row->id,
					'user_name'   =>$row->user_name,
					'first_name'  =>$row->first_name,
					'last_name'   =>$row->last_name,
					'user_kbn'    =>$row->user_kbn,
					'gender'      =>$row->gender,
					'date_entered'=>$row->date_entered,
					'imagename'   =>$row->imagename,
				);
				$this->session->set_userdata('logged_in', $sess_array);
			}
	}

	/**
	 * DESTROYS LOG IN SESSION DATA
	 * @return redirect
	 * --------------------------------------------
	 */
	public function logout()
	{
		session_start();
		$this->session->unset_userdata('logged_in');
		session_destroy();
		return redirect('home', 'refresh');
	}
}
?>