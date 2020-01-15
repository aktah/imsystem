<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$config['email'] =  Array(
    'protocol' => 'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => 587,
    'smtp_crypto' => 'tls',
    'smtp_user' => '',
    'smtp_pass' => '',
    'mailtype'  => 'html', 
    'charset'   => 'utf-8',
    'newline'   => '\r\n'
);