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

	public function count_beneficiaries()
	{
		$this->db->where('deleted', 0);
		$this->db->from('cop_beneficiaries');
		return $this->db->count_all_results();
	}

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
				'msg'   =>'Cannot add beneficiary'
				);
		}else{
			$this->db->trans_commit();
			return array(
				'status'=>'success',
				'msg'   =>$data['first_name'].' has been added to the list of beneficiaries'
				);
		}
	}
}
?>
