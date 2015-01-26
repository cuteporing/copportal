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

class Beneficiary_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	/**
	 * COUNT THE NUMBER OF BENEFICIARIES
	 * @return Integer
	 * --------------------------------------------
	 */
	public function count_beneficiaries()
	{
		$this->db->where('deleted', 0);
		$this->db->from('cop_beneficiaries');
		return $this->db->count_all_results();
	}

	/**
	 * CHECK IF THERE IS ALREADY A BENEFICIARY
	 * W/ THE SAME NAME
	 * @param String, $name
	 * @return Boolean
	 * --------------------------------------------
	 */
	public function check_beneficiary($name)
	{
		$this->db->select('id');
		$this->db->from('cop_beneficiaries');
		$this->db->where('first_name', $name['first_name']);
		$this->db->where('last_name', $name['last_name']);
		$this->db->limit(1);

		$query = $this->db->get();

		if( $query->num_rows() == 1 ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	/**
	 * GET BENEFICIARIES
	 * @param String, $search_by
	 * @param String, $data
	 * @return Array | Boolean <FALSE>
	 * --------------------------------------------
	 */
	public function get_beneficiary($search_by='', $data='')
	{
		if( $search_by == '' ){
			$query = $this->db->get('cop_beneficiaries');
			$this->db->order_by("last_name", "asc");
			return $query->result_array();
		}else{
			$this->db->where($search_by, $data);
			$this->db->from('cop_beneficiaries');
			$this->db->limit(1);
			$query = $this->db->get();

			if( $query->num_rows() == 1 ){
				return $query->result();
			}else{
				return FALSE;
			}
		}
		
	}

	/**
	 * DELETE BENEFICIARIES
	 * @param Integer, $id
	 * @return Boolean
	 * --------------------------------------------
	 */
	public function delete_beneficiary($id)
	{
		$id = array('id'=>$id);

		$this->db->trans_begin();
		$this->db->delete('cop_beneficiaries', $id);

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

	/**
	 * CREATES BENEFICIARIES
	 * @param Integer, $id
	 * @return Array
	 * --------------------------------------------
	 */
	public function create_beneficiary($data)
	{
		$this->db->trans_begin();
		$this->db->insert('cop_beneficiaries', $data);

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
				'msg'   =>$data['first_name'].' has been added to the list of beneficiaries'
				);
		}
	}

	/**
	 * UPDATE BENEFICIARY PROFILE
	 * @param Array, $data
	 * @return Array
	 * --------------------------------------------
	 */
	public function update_beneficiary($data)
	{
		return array(
				'status'=>'success',
				'msg'   =>'" profile has been updated'
				);
		// $this->db->trans_begin();
		// $this->db->where('id', $data['id']);
		// $this->db->update('cop_beneficiaries', $data);

		// if( $this->db->trans_status() === FALSE )
		// {
		// 	//TRANSACTION ERROR CATCH
		// 	$this->db->trans_rollback();
		// 	return array(
		// 		'status'=>'error',
		// 		'msg'   =>$this->db->_error_message()
		// 		);
		// }else{
		// 	$this->db->trans_commit();
		// 	return array(
		// 		'status'=>'success',
		// 		'msg'   =>'"'.$data['first_name'].'" profile has been updated'
		// 		);
		// }
	}
}
?>
