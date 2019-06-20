<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "event"); //mensetting menuKepilih atau menu aktif
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
            'data_event' =>$this->db->query("SELECT * FROM event ORDER BY id_event DESC")->result()
        );
        $this->template->load('template','event/index2',$data);
    }

    public function daftar()
    {
        $this->session->set_flashdata("halaman", "home"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $tgl = date('Y-m-d');
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_event_hari_ini' =>$this->db->query("SELECT * FROM event WHERE event_date='$tgl' AND status='1'")->result()
        );
        $this->template->load('template','event/list',$data);
    }

    public function add_edit_data($id_event=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_event==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'event_name'   => $this->input->post('event_name'),
                    'event_description'   => $this->input->post('event_description'),
                    'event_date'   => $this->input->post('event_date'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('event', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("event");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Kalender',
                'id_event' => $id_event,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_event' => ''
            );
            $this->template->load('template','event/add_event',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'event_name'   => $this->input->post('event_name'),
                    'event_description'   => $this->input->post('event_description'),
                    'event_date'   => $this->input->post('event_date'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_event', $id_event);
                $this->db->update('event', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("event");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Kalender',
                'id_event' => $id_event,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_event'  => $this->db->query("SELECT * FROM event WHERE id_event='$id_event'")->result(),
            );
            $this->template->load('template','event/add_event',$data);
        }
    }

    function delete_data($id_event){
        $this->db->where('id_event', $id_event);
        $this->db->delete('event');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("event");
    }
}