<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "document"); //mensetting menuKepilih atau menu aktif
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
            'data_dokumen' =>$this->db->query("SELECT * FROM document ORDER BY id_document DESC")->result()
        );
        $this->template->load('template','document/index',$data);
    }

    public function add_edit_data($id_document=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_document==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $nmfile = "document".time(); //nama file saya beri nama langsung dan diikuti fungsi time
                $config['upload_path'] = './assets/document_file/';
                $config['allowed_types'] = 'xls|doc|pdf';
                $config['file_name'] = $nmfile; //nama yang terupload nantinya

                $this->load->library('upload', $config); 

                if ( ! $this->upload->do_upload('docfile'))
                {
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Document failed added !!</div>");
                    redirect('document');
                    
                }else{
                    $dok    = $this->upload->data();
                    $docname  = $dok['file_name'];

                    $ext = explode('.',$docname);
                    $ext_type = $ext[1];
                    
                    $data = array(
                        'document_no'   => $this->input->post('document_no'),
                        'document_name'   => $this->input->post('document_name'),
                        'file_name'   => $docname,
                        'document_type'   => $ext_type,
                        'created_date'  => date('Y-m-d'),
                        'created_by'    => $user_id
                    );
                    $this->db->insert('document', $data);
                    if($this->db->affected_rows()!=0){
                        
                        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                        redirect("document");
                    }
                }
            }
            $data = array(
                'title' => 'Tambah Dokumen',
                'id_document' => $id_document,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_dokumen' => '',
                'role_id' => $admin_role,
            );
            $this->template->load('template','document/add_document',$data);
        }else{
            $data = array(
                'document_no'   => $this->input->post('document_no'),
                'document_name'   => $this->input->post('document_name'),
                'document_type'   => $this->input->post('document_type'),
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => 1
            );
                
            $this->db->where('id_document', $id_document);
            $this->db->update('document', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("document");
            }
        }
    }

    public function add_edit_datadev($id_document=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_document==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $nmfile = "document".time(); //nama file saya beri nama langsung dan diikuti fungsi time
                $config['upload_path'] = './assets/document_file/';
                $config['allowed_types'] = 'xls|doc|pdf';
                $config['file_name'] = $nmfile; //nama yang terupload nantinya

                $this->load->library('upload', $config); 

                if ( ! $this->upload->do_upload('docfile'))
                {
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Document failed added !!</div>");
                    redirect('document');
                    
                }else{
                    $dok    = $this->upload->data();
                    $docname  = $dok['file_name'];

                    $ext = explode('.',$docname);
                    $ext_type = $ext[1];
                    
                    $data = array(
                        'document_no'   => $this->input->post('document_no'),
                        'document_name'   => $this->input->post('document_name'),
                        'file_name'   => $docname,
                        'document_type'   => $ext_type,
                        'created_date'  => date('Y-m-d'),
                        'created_by'    => $user_id
                    );
                    $this->db->insert('document', $data);
                    if($this->db->affected_rows()!=0){
                        
                        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                        redirect("document");
                    }
                }
            }
            $data = array(
                'title' => 'Tambah Dokumen',
                'id_document' => $id_document,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_dokumen' => ''
            );
            $this->template->load('template','document/add_document2',$data);
        }else{
            $data = array(
                'document_no'   => $this->input->post('document_no'),
                'document_name'   => $this->input->post('document_name'),
                'document_type'   => $this->input->post('document_type'),
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => 1
            );
                
            $this->db->where('id_document', $id_document);
            $this->db->update('document', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("document");
            }
        }
    }

    function delete_data($id_document){
        $data = $this->db->query("SELECT * FROM document WHERE id_document='$id_document'")->result();
        $file_name = $data[0]->file_name;
        if($file_name!==""){
            unlink('./assets/document_file/'.$file_name);
        }
        
        $this->db->where('id_document', $id_document);
        $this->db->delete('document');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("document");
    }
}