<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "setup"); //mensetting menuKepilih atau menu aktif
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
            'data_role' => $this->db->query("SELECT * FROM access_role where status !='1003' ORDER BY access_id DESC")->result()
        );
        $this->template->load('template','setup/index2',$data);
    }

    public function add_edit_data($access_id=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($access_id==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'access_name'   => $this->input->post('access_name'),
                    'status'   => $this->input->post('status'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('access_role', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("setup");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Access',
                'access_id' => $access_id,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_role' => ''
            );
            $this->template->load('template','setup/add_edit',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'access_name'   => $this->input->post('access_name'),
                    'status'   => $this->input->post('status'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('access_id', $access_id);
                $this->db->update('access_role', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("setup");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Access',
                'access_id' => $access_id,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_role'  => $this->db->query("SELECT * FROM access_role WHERE access_id='$access_id'")->result(),
            );
            $this->template->load('template','setup/add_edit',$data);
        }
    }

    function delete_data($access_id){
        $data = array(
            'status'    => 1003
        );
        $this->db->where('access_id', $access_id);
        $this->db->update('access_role', $data);
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("setup");
    }
}