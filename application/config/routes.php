<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['users'] = 'users/index';
$route['users/changepass'] = 'users/changepass';

$route['instruments'] = 'instruments/index';
$route['booking'] = 'booking/index';
$route['storage'] = 'storage/index';
$route['storage/(:num)'] = 'storage/lookup/$1';

$route['instruments/saveState'] = 'instruments/saveState';

// หน้าแรก
$route['default_controller'] = 'imsystem/index';

$route['(:any)'] = 'imsystem/index';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
