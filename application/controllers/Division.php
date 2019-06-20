<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Division extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "division"); //mensetting menuKepilih atau menu aktif
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
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result()
        );
        $this->template->load('template','division/index2',$data);
    }

    public function add_edit_data($id_division=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_division==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'division_name'   => $this->input->post('division_name'),
                    'status'   => $this->input->post('status'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('division', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("division");
                }
            }

            $data = array(
                'title' => 'Tambah Departemen',
                'id_division' => $id_division,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_divisi' => ''
            );
            $this->template->load('template','division/add_division',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'division_name'   => $this->input->post('division_name'),
                    'status'   => $this->input->post('status'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => 1
                );
                    
                $this->db->where('id_division', $id_division);
                $this->db->update('division', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("division");
                }
            }
            $data = array(
                'title' => 'Perbarui Departemen',
                'id_division' => $id_division,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_divisi'  => $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result(),
            );
            $this->template->load('template','division/add_division',$data);
        }
    }

    function delete_data($id_division){
        $this->db->where('id_division', $id_division);
        $this->db->delete('division');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("division");
    }
}