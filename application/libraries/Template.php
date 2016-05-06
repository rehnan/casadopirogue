<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
    function load($template, $view, $data = array())
    {
       $CI = & get_instance();

        // Load template views
       $CI->load->view('templates/'.$template.'/header', $data);
       $CI->load->view($view, $data);
       $CI->load->view('templates/'.$template.'/footer', $data);
   }
}

/* End of file Template.php */