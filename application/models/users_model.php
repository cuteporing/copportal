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

class Users_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * GET'S THE NO. OF USER THAT IS ACTIVE
	 * @return Integer
	 * --------------------------------------------
	 */
	public function get_no_of_user()
	{
		$this->db->where('status', 'Active');
		$this->db->from('cop_users');
		return $this->db->count_all_results();
	}

	/**
	 * GET'S DATA
	 * @param String | Array, $search_by
	 * @param String | Array, $data
	 * @return Array | Object | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_user($search_by='', $data='')
	{
		if( $search_by == '' ){
			$query = $this->db->get('cop_users');
			return $query->result_array();
		}else{
			//IF SEARCH PARAMETER IS AN ARRAY RETURN AN ARRAY RESULT
			if( is_array($search_by) ){
				for($i=0; $i < count($search_by); $i++){
					$this->db->where($search_by[$i], $data[$i]);
					$this->db->from('cop_users');
					$query = $this->db->get();
					if( $query->num_rows() > 0 ){
					return $query->result_array();
				}else{
					return FALSE;
				}
				}
			//IF SEARCH PARAMETER IS STRING RETURN AN OBJECT
			}else{
				$this->db->where($search_by, $data);
				$this->db->from('cop_users');
				$query = $this->db->get();
				if( $query->num_rows() > 0 ){
					return $query->result();
				}else{
					return FALSE;
				}
			}
		}
	}

	/**
	 * GET USER KBN
	 * @return Array | Object | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_user_kbn()
	{
			$this->db->from('cop_kbn');
			$query = $this->db->get();

			if( $query->num_rows() > 0 ){
				return $query->result_array();
			}else{
				return FALSE;
			}
	}

	/**
	 * GET LOGIN INFO
	 * @param String | Array, $search_by
	 * @param String | Array, $data
	 * @return Array | Object | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_login_info($id)
	{
		$sql_stmt ='id, user_name, first_name, last_name, user_kbn, ';
		$sql_stmt.='gender, user_kbn, date_entered, imagename, deleted';

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

	public function check_user($user_name='', $password='')
	{
		if( $user_name !== '' && $password == '' ){
			$this->db->select('id');
			$this->db->from('cop_users');
			$this->db->where('user_name', $user_name);
			$this->db->where('deleted', 0);
		}else{
			$sql_stmt ='id, user_name, user_password, first_name, last_name, user_kbn, ';
			$sql_stmt.='gender, user_kbn, date_entered, imagename';

			$this->db->select($sql_stmt);
			$this->db->from('cop_users');
			$this->db->where('user_name', $user_name);
			$this->db->where('user_password', $password);
			$this->db->where('status', 'Active');
		}

		$this->db->limit(1);

		$query = $this->db->get();

		if( $query->num_rows() == 1 ){
			return $query->result_array();
		}else{
			return FALSE;
		}
	}

	public function create_user($data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_users', $data);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return array(
				'status'=>'error',
				'msg'   =>$this->db->_error_message()
				);
		}else{
			$this->db->trans_commit();
			return array(
				'status'=>'success',
				'msg'   =>$data['first_name'].' has been created'
				);
		}
	}

	public function update_user($data)
	{
		$this->db->trans_begin();
		$this->db->where('id', $data['id']);
		$this->db->update('cop_users', $data);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return array(
				'status'=>'error',
				'msg'   =>$this->db->_error_message()
				);
		}else{
			$this->db->trans_commit();
			return array(
				'status'=>'success',
				'msg'   =>$data['first_name'].' has been updated'
				);
		}
	}

	public function delete_user($data)
	{
		$this->db->trans_begin();
		$this->db->where('id', $data['id']);
		$this->db->update('cop_users', $data);

		if( $this->db->trans_status() === FALSE )
		{
			//TRANSACTION ERROR CATCH
			$this->db->trans_rollback();
			return FALSE;
		}else{
			$this->db->trans_commit();
			return TRUE;
		}
	}
}
?>