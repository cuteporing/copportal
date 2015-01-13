<?php
/*********************************************************************************
** The contents of this file are subject to the ______________________
 * Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: ______________________
 * The Initial Developer of the Original Code is CodeIgniter.
 * Portions created by KBVCodes are Copyright (C) KBVCodes.
 * All Rights Reserved.
 *
 ********************************************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class status_box extends CI_controller
{
	private $small_status_box;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * AVAILABLE COLORS OF STATUS BOX
	 * @param String, $color
	 * @return Array, $available_colors
	 * --------------------------------------------
	 */
	public function get_available_colors($color)
	{
		$avaialable_colors = array(
			'aqua'   => array('class'=>'small-box bg-aqua'),
			'blue'   => array('class'=>'small-box bg-blue'),
			'green'  => array('class'=>'small-box bg-green'),
			'maroon' => array('class'=>'small-box bg-maroon'),
			'purple' => array('class'=>'small-box bg-purple'),
			'red'    => array('class'=>'small-box bg-red'),
			'teal'   => array('class'=>'small-box bg-teal'),
			'yellow' => array('class'=>'small-box bg-yellow'),
			);

		if( array_key_exists($color,$avaialable_colors) ){
			return $avaialable_colors[$color];
		}else{
			return $avaialable_colors['aqua'];
		}
	}

	/**
	 * AVAILABLE ICONS OF STATUS BOX
	 * @param String, $color
	 * @return Array, $avaialable_icons
	 * --------------------------------------------
	 */
	public function get_available_icons($icon)
	{
		$avaialable_icons = array(
			'bag'              => array('class'=>'ion ion-bag'),
			'stats_bars'       => array('class'=>'ion ion-stats-bars'),
			'person_add'       => array('class'=>'ion ion-android-person-add'),
			'pie_graph'        => array('class'=>'ion ion-pie-graph'),
			'cart_outline'     => array('class'=>'ion ion-ios7-cart-outline'),
			'briefcase_outline'=> array('class'=>'ion ion-ios7-briefcase-outline'),
			'android_calendar' => array('class'=>'ion ion-android-calendar'),
			'pricetag_outline' => array('class'=>'ion ion-ios-pricetag-outline'),
			'people'           => array('class'=>'ion ion-android-people'),
			);

		if( array_key_exists($icon,$avaialable_icons) ){
			return $avaialable_icons[$icon];
		}else{
			return $avaialable_icons['stats_bars'];
		}
	}

	/**
	 * GET DESCRIPTION OF STATUS BOX
	 * @param Array, $details
	 * @return String, <div>
	 * --------------------------------------------
	 */
	public function get_inner($details)
	{
		$inner = heading($details['data'], '3');
		$inner.= p($details['description']);

		return div($inner, array('class'=>'inner'));
	}

	/**
	 * GET ICON OF STATUS BOX
	 * @param Array, $icon_attr
	 * @return String, <div>
	 * --------------------------------------------
	 */
	public function get_icon($icon_attr)
	{
		$icon = common::create_icon($icon_attr);

		return div($icon, array('class'=>'icon'));
	}

	/**
	 * GET FOOTER OF STATUS BOX
	 * @return String, <a>
	 * --------------------------------------------
	 */
	public function get_stat_footer($link)
	{
		$attribute = array(
			'icon'   => array('class'=>'fa fa-arrow-circle-right'),
			'footer' => array('class'=>'small-box-footer')
			);

		$icon = common::create_icon($attribute['icon']);

		return anchor($link, 'More info '.$icon, $attribute['footer']);
	}

	/**
	 * DISPLAY OF STATUS BOX
	 * @return String, <object>
	 * --------------------------------------------
	 */
	public function view($details)
	{
		if( !is_array($details) ){ return ''; }

		$attribute = array('class'=>'col-lg-3 col-xs-6');
		$this->small_status_box = '';

		foreach ($details as $info) {
			$icon_attr = $this->get_available_icons($info['icon']);
			$box_color = $this->get_available_colors($info['color']);

			$box = $this->get_inner($info);
			$box.= $this->get_icon($icon_attr);
			$box.= $this->get_stat_footer($info['link']);
			$box = div($box, $box_color);
			$box = div($box, $attribute);
			$this->small_status_box .= $box;
		}

		return $this->small_status_box;
	}

}
?>