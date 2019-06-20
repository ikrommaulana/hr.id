<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "city"); //mensetting menuKepilih atau menu aktif
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
            'data_provinsi' =>$this->db->query("SELECT * FROM provinsi ORDER BY nama_provinsi ASC")->result()
        );
        $this->template->load('template','city/index',$data);
    }

    public function add_edit_data($id_provinsi=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_provinsi==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'nama_provinsi'   => $this->input->post('nama_provinsi'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('provinsi', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Provinsi berhasil ditambah !!</div>");
                    redirect("city");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Provinsi',
                'id_provinsi' => $id_provinsi,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_provinsi' => ''
            );
            $this->template->load('template','city/add_provinsi',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'nama_provinsi'   => $this->input->post('nama_provinsi'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_provinsi', $id_provinsi);
                $this->db->update('provinsi', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Provinsi berhasil diperbarui !!</div>");
                    redirect("city");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Provinsi',
                'id_provinsi' => $id_provinsi,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_provinsi'  => $this->db->query("SELECT * FROM provinsi WHERE id_provinsi='$id_provinsi'")->result(),
            );
            $this->template->load('template','city/add_provinsi',$data);
        }
    }

    public function add_kota($id_provinsi)
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
        $data_provinsi = $this->db->query("SELECT * FROM provinsi WHERE id_provinsi='$id_provinsi'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'id_provinsi'   => $id_provinsi,
            'provinsi'  => $data_provinsi[0]->nama_provinsi,
            'data_kota' =>$this->db->query("SELECT * FROM provinsi_kota WHERE id_provinsi='$id_provinsi' ORDER BY nama_kota ASC")->result()
        );
        $this->template->load('template','city/kota',$data);
    }

    public function add_edit_kota($id_provinsi='',$id_provinsi_kota=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_provinsi_kota==''){
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
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'nama_kota'   => $this->input->post('nama_kota'),
                    'akses_bandara' => $this->input->post('akses_bandara'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_provinsi_kota', $id_provinsi_kota);
                $this->db->update('provinsi_kota', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Kota berhasil diperbarui !!</div>");
                    redirect("city/add_kota/$id_provinsi");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Kota',
                'id_provinsi'   => $id_provinsi,
                'id_provinsi_kota' => $id_provinsi_kota,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_provinsi_kota'  => $this->db->query("SELECT * FROM provinsi_kota WHERE id_provinsi_kota='$id_provinsi_kota'")->result(),
            );
            $this->template->load('template','city/add_kota',$data);
        }
    }

    function delete_data($id_provinsi){
        $this->db->where('id_provinsi', $id_provinsi);
        $this->db->delete('provinsi');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Provinsi berhasil dihapus !!</div>");
        redirect("city");
    }

    function delete_data_kota($id_provinsi,$id_provinsi_kota){
        $this->db->where('id_provinsi_kota', $id_provinsi_kota);
        $this->db->delete('provinsi_kota');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Kota berhasil dihapus !!</div>");
        redirect("city/add_kota/$id_provinsi"); 
    }
}