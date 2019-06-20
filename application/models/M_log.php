<?php
Class m_log extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function save_log($nama,$dept,$aktifitas){
        $divisi = $this->db->query("SELECT * FROM division WHERE id_division='$dept'")->result();
        if($divisi){
            $nama_divisi = $divisi[0]->division_name;    
        }else{
            $nama_divisi = '';
        }
        
        $data = array (
            'nama'          => $nama,
            'departemen'    => $nama_divisi,
            'activitas'     => $aktifitas,
            'activitas_date'    => date('Y-m-d H:i:s')
        );      
        $this->db->insert('log',$data); 
    }
}