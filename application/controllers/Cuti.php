<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuti extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "cuti"); //mensetting menuKepilih atau menu aktif
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
            'data_cuti' =>$this->db->query("SELECT * FROM cuti ORDER BY id_cuti DESC")->result()
        );
        $this->template->load('template','cuti/index',$data);
    }

    public function add_edit_data($id_cuti=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_cuti==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'jenis_cuti'   => $this->input->post('jenis_cuti'),
                    'description'   => $this->input->post('description'),
                    'parent'   => $this->input->post('parent'),
                    'batas_pengajuan'   => $this->input->post('batas_pengajuan'),
                    'jumlah'   => $this->input->post('jumlah'),
                    'approval_level'   => $this->input->post('approval_level'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('cuti', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("cuti");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Cuti',
                'id_cuti' => $id_cuti,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_cuti' => ''
            );
            $this->template->load('template','cuti/add_cuti',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'jenis_cuti'   => $this->input->post('jenis_cuti'),
                    'description'   => $this->input->post('description'),
                    'parent'   => $this->input->post('parent'),
                    'batas_pengajuan'   => $this->input->post('batas_pengajuan'),
                    'jumlah'   => $this->input->post('jumlah'),
                    'approval_level'   => $this->input->post('approval_level'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_cuti', $id_cuti);
                $this->db->update('cuti', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("cuti");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Cuti',
                'id_cuti' => $id_cuti,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_cuti'  => $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result(),
            );
            $this->template->load('template','cuti/add_cuti',$data);
        }
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
            'data_cuti_hari_ini' =>$this->db->query("SELECT * FROM permit a, permit_approve b, cuti c WHERE a.start_date>='$tgl' and a.end_date<='$tgl' AND a.id_permit=b.id_permit AND b.status='1' AND a.id_cuti=c.id_cuti ORDER BY a.id_permit DESC")->result()
        );
        $this->template->load('template','cuti/list',$data);
    }

    function delete_data($id_cuti){
        $this->db->where('id_cuti', $id_cuti);
        $this->db->delete('cuti');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("cuti");
    }

    function tambah_kolom(){
        $this->db->query("ALTER TABLE cuti ADD parent varchar (150)")->result(); 
    }
}