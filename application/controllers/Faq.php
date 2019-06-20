<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "faq"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        

        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_faq' => $this->db->query("SELECT * FROM faq a, faq_detail b WHERE a.id_faq=b.id_faq")->result()
        );
        $this->template->load('template','faq/index',$data);
    }
    
    function delete_data($id_permit){
        $this->db->where('id_permit', $id_permit);
        $this->db->delete('permit');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("permit");
    }

    
}