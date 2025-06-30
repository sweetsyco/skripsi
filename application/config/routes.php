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
|	https://codeigniter.com/userguide3/general/routing.html
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

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';


$route['distributor/dashboard'] = 'distributor/dashboard';
$route['distributor/test'] = 'distributor/dashboard/test';
$route['distributor/permintaan'] = 'distributor/permintaan';
$route['distributor/permintaan/buat'] = 'distributor/permintaan/create';
$route['distributor/permintaan/simpan'] = 'distributor/permintaan/store';
$route['distributor/permintaan/tutup/(:num)'] = 'distributor/permintaan/close/$1';
$route['distributor/penawaran'] = 'distributor/penawaran';
$route['distributor/penawaran/(:num)'] = 'distributor/penawaran/show/$1';
$route['distributor/penawaran/terima/(:num)'] = 'distributor/penawaran/accept/$1';
$route['distributor/penawaran/tolak/(:num)'] = 'distributor/penawaran/reject/$1';
$route['distributor/penawaran/tugaskan/(:num)'] = 'distributor/penawaran/assign/$1';
$route['distributor/penugasan'] = 'distributor/penugasan/index';
$route['distributor/penugasan/create'] = 'distributor/penugasan/create';
$route['distributor/penugasan/update_status/(:num)/(:any)'] = 'penugasan/update_status/$1/$2';
$route['distributor/kurir'] = 'distributor/kurir';
$route['distributor/kurir/tambah'] = 'distributor/kurir/create';
$route['distributor/kurir/update'] = 'distributor/kurir/proses_update_kurir';
$route['distributor/kurir/simpan'] = 'distributor/kurir/store';
$route['distributor/kurir/nonaktifkan/(:num)'] = 'distributor/kurir/deactivate/$1';
$route['distributor/laporan'] = 'distributor/laporan';


$route['petani/dashboard'] = 'petani/dashboard';
$route['petani/penawaran'] = 'petani/penawaran';
$route['petani/penawaran/buat'] = 'petani/penawaran/create';
$route['petani/profil'] = 'petani/profile';