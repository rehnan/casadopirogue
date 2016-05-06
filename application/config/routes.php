<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

//$route['default_controller'] = 'welcome';
$route['default_controller'] = 'LoginController/index';
//$route['teste/(:any)'] = 'welcome/sayHello/$1';

$route['account']['GET'] = 'UserController/new_user/$user ';
$route['account']['POST'] = 'UserController/create_user';

$route['account/([1-9]+)/edit']['GET'] = 'UserController/edit_user';
$route['account/([1-9]+)/edit']['POST'] = 'UserController/update_user';

$route['account/([1-9]+)']['GET'] = 'UserController/get_user';

$route['account/new']['POST'] = 'UserController/find_user';

$route['account/active_account/(:any)']['GET'] = 'UserController/active_account';

$route['login']['GET'] = 'LoginController/sign_in';

$route['login']['POST'] = 'LoginController/authenticate_user/$user';
$route['logout']['GET'] = 'LoginController/sign_out';

$route['login/facebook']['GET'] = 'LoginController/sign_in_facebook';
$route['logout/facebook']['GET'] = 'LoginController/sign_out ';

$route['dashboard']['GET'] = 'DashboardController/index';

$route['order']['GET'] = 'OrderController/new_order';
$route['order/create']['GET'] = 'OrderController/create_order';
$route['order/itens/([a-z]+)']['GET'] = 'OrderController/get_itens';
$route['order/([1-9]+)/itens']['POST'] = 'OrderController/add_item';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;