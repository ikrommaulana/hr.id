<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "user"); //mensetting menuKepilih atau menu aktif
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
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_privileges' =>$this->db->query("SELECT * FROM privileges WHERE status=1 ORDER BY id_privileges DESC")->result(),
            'data_administrator' => $this->db->query("SELECT * FROM administrator a, privileges b WHERE a.id_privileges=b.id_privileges ORDER BY a.id_privileges DESC")->result(),
        );
        $this->template->load('template','user/admin/index',$data);
    }

    public function add_edit_data(){
        $user_id = $this->session->userdata('user_id');
        $id_administrator = $this->input->post('id_administrator');
        
        if($id_administrator==''){
            $data = array(
                'firstname'   => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email'   => $this->input->post('email'),
                'status'   => $this->input->post('status'),
                'id_privileges'   => $this->input->post('id_privileges'),
                'password'   => md5($this->input->post('password')),
                'created_date'  => date('Y-m-d'),
                'created_by'    => $user_id
            );
            $this->db->insert('administrator', $data);
            if($this->db->affected_rows()!=0){
                
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                redirect("user");
            }
        }else{
            $data = array(
                'firstname'   => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email'   => $this->input->post('email'),
                'status'   => $this->input->post('status'),
                'id_privileges'   => $this->input->post('id_privileges'),
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => $user_id
            );
                
            $this->db->where('id_administrator', $id_administrator);
            $this->db->update('administrator', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("user");
            }
        }
    }

    function delete_data($id_administrator){
        $this->db->where('id_administrator', $id_administrator);
        $this->db->delete('administrator');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("user");
    }
}