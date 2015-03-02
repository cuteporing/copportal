<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['account/(:any)'] = 'account/view/$1';
// $route['upload/(:any)'] = 'upload/$1';
// $route['upload/upload_gallery_photo'] = 'upload/upload_gallery_photo/$1';

//ANNOUNCEMENTS
$route['announcements_ajax/create']             = 'announcements_ajax/create/$1';
$route['announcements_ajax/delete/(:any)']      = 'announcements_ajax/delete/$1';
$route['announcements_ajax/edit']               = 'announcements_ajax/edit/$1';
$route['announcements_ajax/upload_photo']       = 'announcements_ajax/upload_photo/$1';

//BANNER
$route['banner_ajax/delete/(:any)']             = 'banner_ajax/delete/$1';
$route['banner_ajax/upload_photo']              = 'banner_ajax/upload_photo/$1';

//EVENTS
$route['events_ajax/create']                    = 'events_ajax/create/$1';
$route['events_ajax/edit']                      = 'events_ajax/edit/$1';
$route['events_ajax/delete/(:any)']             = 'events_ajax/delete/$1';
$route['events_ajax/close/(:any)']              = 'events_ajax/close/$1';
$route['events_ajax/member_list/(:any)']        = 'events_ajax/member_list/$1';
$route['events_ajax/member_add/(:any)']         = 'events_ajax/member_add/$1';
$route['events_ajax/member_delete/(:any)']      = 'events_ajax/member_delete/$1';
$route['events_ajax/upload_photo']              = 'events_ajax/upload_photo/$1';
$route['events_ajax/calendar/(:any)']           = 'events_ajax/calendar/$1';

//GALLERY
$route['gallery_ajax/create_album']             = 'gallery_ajax/create_album/$1';
$route['gallery_ajax/delete_album/(:any)']      = 'gallery_ajax/delete_album/$1';
$route['gallery_ajax/delete_photo/(:any)']      = 'gallery_ajax/delete_photo/$1';
$route['gallery_ajax/cover_photo/(:any)']       = 'gallery_ajax/cover_photo/$1';
$route['gallery_ajax/upload_gallery_photo']     = 'gallery_ajax/upload_gallery_photo/$1';

//MANAGE BENEFICIARY
$route['manage_beneficiary_ajax/create']        = 'manage_beneficiary_ajax/create/$1';
$route['manage_beneficiary_ajax/edit']          = 'manage_beneficiary_ajax/edit/$1';
$route['manage_beneficiary_ajax/delete/(:any)'] = 'manage_beneficiary_ajax/delete/$1';

//MANAGE USERS
$route['manage_users_ajax/create']              = 'manage_users_ajax/create/$1';
$route['manage_users_ajax/change_password']     = 'manage_users_ajax/change_password/$1';
$route['manage_users_ajax/delete/(:any)']       = 'manage_users_ajax/delete/$1';
$route['manage_users_ajax/edit']                = 'manage_users_ajax/edit/$1';

$route['logout']                                = 'users/logout';
$route['(:any)']                                = 'pages/view/$1';
$route['default_controller']                    = 'pages/view';

/* End of file routes.php */
/* Location: ./application/config/routes.php */