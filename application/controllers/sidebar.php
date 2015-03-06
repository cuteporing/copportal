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

class sidebar extends account
{

	private $links;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('sidebar_model');
	}

	public function get_links()
	{
		$result = $this->sidebar_model->get_sidebar();

		for ($i=0; $i < count($result); $i++) {
			$result[$i]['class'] = json_decode($result[$i]['class'], true);
			$result[$i]['icon']  = json_decode($result[$i]['icon'], true);
			$result[$i]['icon2'] = json_decode($result[$i]['icon2'], true);
			$result[$i]['drop']  = json_decode($result[$i]['drop'], true);
		}
		$this->links = $result;
		// $this->links = array(
		// 	0 => array(
		// 		'admin'=>'both',
		// 		'title'=>'Dashboard',
		// 		'link' =>'account/dashboard',
		// 		'class'=> array('class'=>'active'),
		// 		'icon' => array('class'=>'fa fa-dashboard'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> 'none',
		// 		'drop' => 'none'
		// 		),
		// 	1 => array(
		// 		'admin'=>'on',
		// 		'title'=>'Announcements',
		// 		'link' =>'account/announcements',
		// 		'class'=> array('class'=>'treeview'),
		// 		'icon' => array('class'=>'fa fa-th'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> array(
		// 								'text' => 'new',
		// 								'class'=> array(
		// 										'class'=>'badge pull-right bg-green'
		// 									)
		// 							),
		// 		'drop' => array(
		// 							0 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'Create announcements',
		// 								'link' =>'account/announcements/create',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								),
		// 							1 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'View announcements',
		// 								'link' =>'account/announcements/',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								)
		// 							)
		// 		),
		// 	2 => array(
		// 		'admin'=>'on',
		// 		'title'=>'Banner',
		// 		'link' =>'account/banner',
		// 		'class'=> array('class'=>''),
		// 		'icon' => array('class'=>'fa fa-flag-o'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> 'none',
		// 		'drop' => 'none'
		// 		),
		// 	3 => array(
		// 		'admin'=>'on',
		// 		'title'=>'Events',
		// 		'link' =>'account/events',
		// 		'class'=> array('class'=>'treeview'),
		// 		'icon' => array('class'=>'fa fa-calendar'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> 'none',
		// 		'drop' => array(
		// 							0 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'Create event',
		// 								'link' =>'account/events/create',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								),
		// 							1 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'View events',
		// 								'link' =>'account/events/',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								)
		// 							)
		// 		),
		// 	4 => array(
		// 		'admin'=>'on',
		// 		'title'=>'Gallery',
		// 		'link' =>'account/gallery',
		// 		'class'=> array('class'=>''),
		// 		'icon' => array('class'=>'fa fa-picture-o'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> 'none',
		// 		'drop' => 'none'
		// 		),
		// 	5 => array(
		// 		'admin'=>'on',
		// 		'title'=>'Manage Beneficiary',
		// 		'link' =>'account/manage_beneficiary',
		// 		'class'=> array('class'=>'treeview'),
		// 		'icon' => array('class'=>'fa fa-users'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> 'none',
		// 		'drop' => array(
		// 							0 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'Add beneficiary',
		// 								'link' =>'account/manage_beneficiary/create',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								),
		// 							1 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'View beneficiary',
		// 								'link' =>'account/manage_beneficiary/view',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								)
		// 							)
		// 		),
		// 	6 => array(
		// 		'admin'=>'on',
		// 		'title'=>'Manage Users',
		// 		'link' =>'account/manage_users',
		// 		'class'=> array('class'=>'treeview'),
		// 		'icon' => array('class'=>'fa fa-user'),
		// 		'icon2'=> array('class'=>'fa fa-angle-left pull-right'),
		// 		'badge'=> 'none',
		// 		'drop' => array(
		// 							0 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'Add user',
		// 								'link' =>'account/manage_users/create',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								),
		// 							1 =>array(
		// 								'admin'=>'on',
		// 								'title'=>'View Users',
		// 								'link' =>'account/manage_users/view',
		// 								'icon' =>array('class'=>'fa fa-angle-double-right'),
		// 								)
		// 							)
		// 		)
		// 	);
	}

	/**
	 * CREATES BADGE
	 * @param Array, $badge
	 * @return String, <small>
	 * --------------------------------------------------------
	 */
	public function create_badge($badge)
	{
		if( ! is_array($badge) ){ return ''; }

		return create_tag('small', $badge['text'], $badge['class']);
	}

	/**
	 * CREATES TITLE FOR THE LINK
	 * @param String, $icon
	 * @return String, <span>
	 * --------------------------------------------------------
	 */
	public function create_title($title)
	{
		if( $title == '' ){ return $title; }
		$data_title = str_replace(' ', '_', $title);
		return span($title, array( 'data-page'=>strtolower($data_title) ));
	}

	/**
	 * CREATES ANCHOR TAG LINK
	 * @param String, $icon
	 * @return String, <i>
	 * --------------------------------------------------------
	 */
	public function create_link($icon, $title, $link='')
	{
		return anchor($link, $icon.$title);
	}

	/**
	 * CREATES USER PANEL
	 * @return String, <div>
	 * --------------------------------------------------------
	 */
	public function create_user_panel()
	{
		$users = new users;
		$session_data = $this->session->userdata('logged_in');

		$attribute = array(
				'img'      =>array(
											'class'=>'img-circle',
											'src'  =>$session_data['imagename'],
											'alt'  =>'User Image'),
				'icon'     =>array('class'=>'fa fa-circle text-success'),
				'panel'    =>array('class'=>'user-panel'),
				'pull_img' =>array('class'=>'pull-left image'),
				'pull_info'=>array('class'=>'pull-left info')
			);

		$icon = common::create_icon($attribute['icon']);
		$user_image = $users->get_user_img(
										$attribute['img'], $session_data['gender']
									);
		$user_name  = p($session_data['first_name'].' '.$session_data['last_name']);
		$user_info  = $user_name.anchor('&nbsp', $icon.' Online');

		$img_panel  = div($user_image, $attribute['pull_img']);
		$info_panel = div($user_info, $attribute['pull_info']);
		$user_panel = div($img_panel.$info_panel, $attribute['panel']);

		return $user_panel;
	}

	public function create_dropdown($details)
	{
		$li = '';
		$session_data = $this->session->userdata('logged_in');

		foreach ($details as $row) {
			// if( $session_data['is_admin'] !== $row['admin'] &&
			// 		$row['admin'] !== 'both'){
			// 	break;
			// }

			$icon = common::create_icon($row['icon']);
			$link = anchor($row['link'], $icon.$row['title']);

			$li.= li($link);
		}

		$ul = create_tag('ul', $li, array('class'=>'treeview-menu'));

		return $ul;
	}

	/**
	 * CREATES SIDEBAR NAVIGATION
	 * @return String, <ul>
	 * --------------------------------------------------------
	 */
	public function view_sidebar()
	{
		$li = '';
		$session_data = $this->session->userdata('logged_in');

		$this->links = '';
		$this->get_links();

		foreach ($this->links as $content) {
			// if( $session_data['is_admin'] !== $content['admin'] &&
			// 		$content['admin'] !== 'both'){
			// 	break;
			// }

			if( is_array($content['drop']) ){
				$icon  = common::create_icon($content['icon']);
				$title = $this->create_title($content['title']);
				$drop_icon = common::create_icon($content['icon2']);
				$link  = $this->create_link(
									$icon, $title.$drop_icon, $content['link']
								);
				$link .= $this->create_dropdown($content['drop']);
			}else{
				$icon  = common::create_icon($content['icon']);
				$title = $this->create_title($content['title']);
				$link  = $this->create_link(
									$icon, $title, $content['link']
								);
			}


			$li.= li($link, $content['class']);
		}

		$ul         = create_tag('ul', $li, array('class'=>'sidebar-menu'));
		$user_panel = $this->create_user_panel();

		$sidebar    = create_tag('section', $user_panel.$ul,
										array('class'=>'sidebar'));

		return $sidebar;
	}
}
?>