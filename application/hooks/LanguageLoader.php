 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LanguageLoader
{
   function initialize() {

    
       $ci =& get_instance();

       $ci->load->helper('language');
       $siteLang = $ci->session->userdata('site_lang');
       if ($siteLang) {
            $ci->lang->load('content',$siteLang);
            $ci->config->set_item('language', $siteLang);
           
       } else {
            $ci->lang->load('content','thai');
            $ci->config->set_item('language', 'thai');
       }
   }
}