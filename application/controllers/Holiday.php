<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "holiday"); //mensetting menuKepilih atau menu aktif
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
            'data_holiday' =>$this->db->query("SELECT * FROM hari_libur ORDER BY tanggal ASC")->result()
        );
        $this->template->load('template','holiday/index',$data);
    }

    public function add_edit_data($id_hari_libur=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $tgl = $this->input->post('tanggal');
        $tgl_libur  = date('Y-m-d', strtotime($tgl));
        if($id_hari_libur==''){
            $save = $this->input->post('save');
            if(isset($save)){

                $data = array(
                    'keterangan'   => $this->input->post('keterangan'),
                    'tanggal'   => $tgl_libur 
                );
                $this->db->insert('hari_libur', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("holiday");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Hari Libur',
                'id_hari_libur' => $id_hari_libur,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_holiday' => ''
            );
            $this->template->load('template','holiday/add_holiday',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'keterangan'   => $this->input->post('keterangan'),
                    'tanggal'   => $tgl_libur
                );
                    
                $this->db->where('id_hari_libur', $id_hari_libur);
                $this->db->update('hari_libur', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("holiday");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Hari Libur',
                'id_hari_libur' => $id_hari_libur,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_holiday'  => $this->db->query("SELECT * FROM hari_libur WHERE id_hari_libur='$id_hari_libur'")->result(),
            );
            $this->template->load('template','holiday/add_holiday',$data);
        }
    }

    function delete_data($id_hari_libur){
        $this->db->where('id_hari_libur', $id_hari_libur);
        $this->db->delete('hari_libur');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("holiday");
    }

    function add_hari($hari,$tgl){
        $data = array(
            'keterangan'   => $hari,
            'tanggal'   => $tgl 
        );
        $this->db->insert('hari_libur', $data);
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("holiday");
    }
}