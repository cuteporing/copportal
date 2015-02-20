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

class artcore_pagination extends CI_controller
{
	public $artcore_config = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function initialize($artcore_config_param)
	{
		$this->artcore_config['base_url']       = '';
		$this->artcore_config['total_rows']     = 0;
		$this->artcore_config['per_page']       = 1;
		$this->artcore_config['cur_page']       = 1;
		$this->artcore_config['uri_segment']    = 3;
		$this->artcore_config['link']           = $this->artcore_config['base_url'].$this->artcore_config['cur_page'];
		$this->artcore_config['full_tag_open']  = '<div class="row"><div class="col-md-12"><div class="pagination text-center"><ul>';
		$this->artcore_config['full_tag_close'] = '</ul></div></div></div>';
		$this->artcore_config['cur_tag_open']   = '<li><a href="javascript:void(0)" class="active">';
		$this->artcore_config['cur_tag_close']  = '</a></li>';
		$this->artcore_config['num_tag_open']   = '<li><a href="'.$this->artcore_config['link'].'">';
		$this->artcore_config['num_tag_close']  = '</a></li>';

		foreach ($artcore_config_param as $key => $value) {
			$this->artcore_config[$key]  = $value;
		}
		return $this->artcore_config;
	}

	public function display($artcore_config_param)
	{
		$this->initialize($artcore_config_param);

		$cur_page = str_replace('/', '', $this->uri->slash_segment(
			$this->artcore_config['uri_segment'], 'leading') );

		$total = $this->artcore_config['total_rows'] / $this->artcore_config['per_page'];
		$artcore_pagination = $this->artcore_config['full_tag_open'];

		if($counter > 4){
			$counter= 1;
			for($i=1; $i <= $total; $i++){
				if($counter > 4){
					$this->artcore_config['cur_page'] = $i;
					$this->artcore_config['link']= $this->artcore_config['base_url'].$this->artcore_config['cur_page'];
					$this->artcore_config['num_tag_open']   = '<li><a href="'.$this->artcore_config['link'].'">';

					$artcore_pagination.= $this->artcore_config['num_tag_open'];
					$artcore_pagination.= '...';
					$artcore_pagination.= $this->artcore_config['num_tag_close'];
					break;
				}else{
						$this->artcore_config['cur_page'] = $i;

						$this->artcore_config['link']= $this->artcore_config['base_url'].$this->artcore_config['cur_page'];
						$this->artcore_config['num_tag_open']   = '<li><a href="'.$this->artcore_config['link'].'">';

					( $cur_page == $i )?
						$artcore_pagination.= $this->artcore_config['cur_tag_open']
					: $artcore_pagination.= $this->artcore_config['num_tag_open'];
						$artcore_pagination.= $i;
						$artcore_pagination.= $this->artcore_config['num_tag_close'];
				}
				$counter++;
			}
		}
		$artcore_pagination.= $this->artcore_config['full_tag_open'];

		return $artcore_pagination;
	}

	public function create_links($artcore_config_param)
	{
		return $this->display($artcore_config_param);
	}
}
