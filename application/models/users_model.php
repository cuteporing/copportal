<?php
/*********************************************************************************
** The contents of this file are subject to the ______________________
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: ______________________
 * The Initial Developer of the Original Code is Krishia Valencia.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function get_no_of_user()
	{
		$this->db->where('status', 'Active');
		$this->db->where('is_admin', 'off');
		$this->db->from('cop_users');
		return $this->db->count_all_results();
	}

	public function get_user($search_by='', $data='')
	{
		if( $search_by == '' ){
			$query = $this->db->get('cop_users');
			return $query->result_array();
		}else{
			$this->db->where($search_by, $data);
			$this->db->from('cop_users');
			$this->db->limit(1);
			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result();
			}else{
				return FALSE;
			}
		}
	}


	public function get_announcements($search_by='', $data='')
	{
		if( $search_by == '' ){
			$query = $this->db->get('cop_announcements');
			return $query->result_array();
		}else{
			$this->db->where($search_by, $data);
			$this->db->from('cop_announcements');
			$this->db->limit(1);
			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result();
			}else{
				return FALSE;
			}
		}
	}

	public function get_login_info($id)
	{
		$sql_stmt ='id, user_name, first_name, last_name, ';
		$sql_stmt.='gender, is_admin, date_entered, imagename';

		$this->db->select($sql_stmt);
		$this->db->from('cop_users');
		$this->db->where('id', $id);
		$this->db->limit(1);

		$query = $this->db->get();

		if( $query->num_rows() == 1 ){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function check_user($user_name, $password)
	{
		$sql_stmt ='id, user_name, user_password, first_name, last_name, ';
		$sql_stmt.='gender, is_admin, date_entered, imagename';

		$this->db->select($sql_stmt);
		$this->db->from('cop_users');
		$this->db->where('user_name', $user_name);
		$this->db->where('user_password', $password);
		$this->db->where('status', 'Active');
		$this->db->limit(1);

		$query = $this->db->get();

		if( $query->num_rows() == 1 ){
			return $query->result();
		}else{
			return FALSE;
		}
	}

	public function create_user($data)
	{
		return $this->db->insert('cop_users', $data);
	}
}
?>