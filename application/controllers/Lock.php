<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lock extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "lock"); //mensetting menuKepilih atau menu aktif
        $this->session->set_flashdata("logas", "admin"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
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
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_lock' =>$this->db->query("SELECT * FROM lock_pengajuan ORDER BY lock_id DESC")->result()
        );
        $this->template->load('template','lock/index',$data);
    }

    function lock($lock_id){
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'status'    => 1,
            'updated_date'  => date('Y-m-d'),
            'updated_by'    => $user_id
        );
        $this->db->where('lock_id', $lock_id);
        $this->db->update('lock_pengajuan',$data);
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success letak\" id=\"alert\">Successfully Locked !!</div>");
        redirect("lock");
    }

    function unlock($lock_id){
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'status'    => 0,
            'updated_date'  => date('Y-m-d'),
            'updated_by'    => $user_id
        );
        $this->db->where('lock_id', $lock_id);
        $this->db->update('lock_pengajuan',$data);
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success letak\" id=\"alert\">Successfully Unlocked !!</div>");
        redirect("lock");
    }
}