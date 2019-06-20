<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biaya_ extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "biaya"); //mensetting menuKepilih atau menu aktif
        $this->session->set_flashdata("logas", "admin"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan DESC")->result();
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
            'data_biaya' =>$this->db->query("SELECT * FROM biaya_dinas ORDER BY id_biaya_dinas DESC")->result(),
            'data_jabatan'  => $data_jabatan
        );
        $this->template->load('template','biaya/index2',$data);
    }

    public function add_edit_data($id_biaya_dinas=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan DESC")->result();
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_biaya_dinas==''){
            $save = $this->input->post('save');
            $data_id = $this->db->query("SELECT * FROM biaya_dinas ORDER BY id_biaya_dinas DESC")->result();
            if($data_id){
                $id_biaya_dinas_new = $data_id[0]->id_biaya_dinas + 1;
            }else{
                $id_biaya_dinas_new = 1;
            }
            if(isset($save)){
                $data = array(
                    'id_biaya_dinas'    => $id_biaya_dinas_new,
                    'keterangan'        => $this->input->post('keterangan'),
                    'created_date'      => date('Y-m-d'),
                    'created_by'        => $user_id
                );
                $this->db->insert('biaya_dinas', $data);
                
                foreach($data_jabatan as $view){
                    $biaya = $view->id_jabatan;
                    $data2 = array(
                        'id_biaya_dinas'    => $id_biaya_dinas_new,
                        'id_jabatan'        => $biaya,
                        'biaya'             => $this->input->post("$biaya")
                    );
                    $this->db->insert('biaya_dinas_detail', $data2);    
                }
                
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("biaya");
                }
            }

            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Biaya Perjalanan Dinas',
                'id_biaya_dinas' => $id_biaya_dinas,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_jabatan'      => $data_jabatan,
                'data_biaya' => ''
            );
            $this->template->load('template','biaya/add_biaya',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                foreach($data_jabatan as $view){
                    $biaya = $view->nama_jabatan;
                    $data2 = array(
                        'biaya'             => $this->input->post($biaya)
                    );
                    $this->db->where('id_biaya_dinas', $id_biaya_dinas);
                    $this->db->where('id_jabatan', $view->id_jabatan);
                    $this->db->update('biaya_dinas_detail', $data2);   
                }

                $data = array(
                    'keterangan'        => $this->input->post('keterangan'),
                    'created_date'      => date('Y-m-d'),
                    'created_by'        => $user_id
                );
                    
                $this->db->where('id_biaya_dinas', $id_biaya_dinas);
                $this->db->update('biaya_dinas', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("biaya");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Departemen',
                'id_biaya_dinas' => $id_biaya_dinas,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_jabatan'  => $data_jabatan,
                'data_biaya'  => $this->db->query("SELECT * FROM biaya_dinas a, biaya_dinas_detail b WHERE a.id_biaya_dinas='$id_biaya_dinas' AND b.id_biaya_dinas=a.id_biaya_dinas")->result(),
            );
            $this->template->load('template','biaya/add_biaya',$data);
        }
    }

    function delete_data($id_biaya_dinas){
        $this->db->where('id_biaya_dinas', $id_biaya_dinas);
        $this->db->delete('biaya_dinas');
        
        $this->db->where('id_biaya_dinas', $id_biaya_dinas);
        $this->db->delete('biaya_dinas_detail');
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("biaya");
    }
}