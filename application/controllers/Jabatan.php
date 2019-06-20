<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "jabatan"); //mensetting menuKepilih atau menu aktif
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
            'data_jabatan' =>$this->db->query("SELECT * FROM jabatan ORDER BY level ASC")->result()
        );
        $this->template->load('template','jabatan/index',$data);
    }

    public function add_edit_data($id_jabatan=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_jabatan==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'nama_jabatan'   => $this->input->post('nama_jabatan'),
                    'level'   => $this->input->post('level'),
                    'status'   => 1,
                );
                $this->db->insert('jabatan', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("jabatan");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Jabatan',
                'id_jabatan' => $id_jabatan,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_jabatan' => ''
            );
            $this->template->load('template','jabatan/add_jabatan',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'nama_jabatan'   => $this->input->post('nama_jabatan'),
                    'level'   => $this->input->post('level'),
                    'status'   => $this->input->post('status'),
                );
                    
                $this->db->where('id_jabatan', $id_jabatan);
                $this->db->update('jabatan', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("jabatan");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Jabatan',
                'id_jabatan' => $id_jabatan,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_jabatan'  => $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result(),
            );
            $this->template->load('template','jabatan/add_jabatan',$data);
        }
    }

    public function add_departemen($id_jabatan)
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
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'id_jabatan'   => $id_jabatan,
            'jabatan'  => $data_jabatan[0]->nama_jabatan,
            'data_departemen' =>$this->db->query("SELECT * FROM jabatan_departemen a,division b WHERE a.id_jabatan='$id_jabatan' AND b.id_division=a.id_departemen")->result()
        );
        $this->template->load('template','jabatan/departemen',$data);
    }

    public function add_departemen2($id_jabatan){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'id_provinsi'  => $id_provinsi,
                    'nama_kota'   => $this->input->post('nama_kota'),
                    'akses_bandara' => $this->input->post('akses_bandara'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('provinsi_kota', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Kota berhasil ditambah !!</div>");
                    redirect("city/add_kota/$id_provinsi");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Kota',
                'id_provinsi'   => $id_provinsi,
                'id_provinsi_kota' => $id_provinsi_kota,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_provinsi_kota' => ''
            );
            $this->template->load('template','city/add_kota',$data);
            }

    function delete_data($id_jabatan){
        $this->db->where('id_jabatan', $id_jabatan);
        $this->db->delete('jabatan');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("jabatan");
    }

    function create_table(){
        
        $this->db->query("CREATE TABLE IF NOT EXISTS employee_approval_dana (
            id_employee_approval_dana int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_employee int(11) NOT NULL,
            id_division int(11) NOT NULL,
            created_by int(11) NOT NULL,
            created_date date NOT NULL,
            updated_by int(11) NOT NULL,
            updated_date date NOT NULL
        )")->result();
    }

    function tambah_kolom(){
        $this->db->query("ALTER TABLE employee_approval_dana ADD is_delete int (2)")->result();
    }
}