<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
    function load($view, $data = array())
    {
        // Get current CI Instance
        $CI = & get_instance();

        // Load template views
        $CI->load->view('layouts/header', $data);
        $CI->load->view($view, $data);
        $CI->load->view('layouts/footer', $data);
    }

   /* function menu($view)
    {
        // Get current CI Instance
        $CI = & get_instance();

        // Load menu template
        $CI->load->view('template/menu', array('view' => $view));
    }
*/
}

/* End of file Template.php */