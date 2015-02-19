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

class banner extends CI_Controller
{
	private $banner;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('artcore_model');
	}

	public function get_banner()
	{
		return $this->artcore_model->get_banner();
	}
}