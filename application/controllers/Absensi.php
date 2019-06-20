<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "absensi"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
        $filter = $this->input->post('filter');
        if(isset($filter)){
            $daterange = $this->input->post('tanggal');
            $date   = explode(' - ', $daterange);
            $start  = date('Y-m-d', strtotime($date[0]));
            $end    = date('Y-m-d', strtotime($date[1]));
            $start2  = date('m/d/Y', strtotime($date[0]));
            $end2    = date('m/d/Y', strtotime($date[1]));
        }else{
            $start = date('Y-m-d');
            $end = date('Y-m-d');
            $start2 = date('m/d/Y');
            $end2 = date('m/d/Y');
        }
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data = array(
            'id_user'   => $user_id,
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'tanggal_start'     => $start,
            'tanggal_end'       => $end,
            'tanggal_start2'    => $start2,
            'tanggal_end2'      => $end2,
            'departemen'        => ''
        );
        $this->template->load('template','absensi/index',$data);
    }
}