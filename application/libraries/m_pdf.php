<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class m_pdf {
    
    function m_pdf()
    {
        $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
    }
 
    function load($param=NULL)
    {
        include_once APPPATH.'third_party/mpdf60/mpdf.php';
         
        if ($params == NULL)
        {
            $param = '"A4","utf-8"';          
        }
         
        return new mPDF($param);
    }
}