<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home/view';
$route['(:any)'] = 'home/view/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
