<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['users'] = 'users/index';

// หน้าแรก
$route['default_controller'] = 'imsystem/index';

$route['(:any)'] = 'imsystem/index';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
