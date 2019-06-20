<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recruitment extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "recruitment"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
        $this->session->set_flashdata("halaman", "listrec"); //mensetting menuKepilih atau menu aktif
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
            'data_calon_karyawan' =>$this->db->query("SELECT * FROM calon_karyawan ORDER BY id_calon_karyawan ASC")->result(),
            'data_position' =>$this->db->query("SELECT * FROM jabatan ORDER BY id_jabatan ASC")->result(),
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY division_name ASC")->result()
        );
        $this->template->load('template','recruitment/index',$data);
    }

    public function add_edit_data(){
        $user_id = $this->session->userdata('user_id');
        $id_recruitment_request = $this->input->post('id_recruitment_request');
        
        if($id_recruitment_request==''){
            $data = array(
                'requirement'   => $this->input->post('requirement'),
                'recruit_total'   => $this->input->post('recruit_total'),
                'position'   => $this->input->post('position'),
                'id_division'   => $this->input->post('division'),
                'recruit_date'  => date('Y-m-d'),
                'status'   => 'Waiting',
                'created_date'  => date('Y-m-d'),
                'created_by'    => $user_id
            );
            $this->db->insert('recruitment_request', $data);
            if($this->db->affected_rows()!=0){
                
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Request successfully added !!</div>");
                redirect("recruitment/request");
            }
        }else{
            $data = array(
                'requirement'   => $this->input->post('requirement'),
                'recruit_total'   => $this->input->post('recruit_total'),
                'position'   => $this->input->post('position'),
                'id_division'   => $this->input->post('division'),
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => 1
            );
                
            $this->db->where('id_recruitment_request', $id_recruitment_request);
            $this->db->update('recruitment_request', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("recruitment/request");
            }
        }
    }

    public function dokumen($id_recruitment='')
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
            'id_recruitment'    => $id_recruitment,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_recruitment' =>$this->db->query("SELECT * FROM recruitment WHERE id_recruitment='$id_recruitment'")->result(),
            'data_dokumen' =>$this->db->query("SELECT * FROM recruitment_doc WHERE id_recruitment='$id_recruitment' ORDER BY upload_date DESC")->result()
        );
        $this->template->load('template','recruitment/document',$data);
    }

    public function upload_doc($id_recruitment=''){
        $nmfile = "doc_recruit".time(); //nama file saya beri nama langsung dan diikuti fungsi time
        $config['upload_path'] = './assets/document_file_recruit/';
        $config['allowed_types'] = 'xls|doc|pdf';
        $config['file_name'] = $nmfile; //nama yang terupload nantinya

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('docfile'))
            {
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Document failed added !!</div>");
                redirect("recruitment/dokumen/$id_recruitment");
                
            }else{
                $dok    = $this->upload->data();
                $docname  = $dok['file_name'];

                $ext = explode('.',$docname);
                $ext_type = $ext[1];
                
                $data = array(
                    'id_recruitment'    => $id_recruitment,
                    'doc_name'   => $docname,
                    'doc_type'   => $ext_type,
                    'description'   => $this->input->post('description'),
                    'upload_date'   => date('Y-m-d h:i:s')
                );
                $this->db->insert('recruitment_doc', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("recruitment/dokumen/$id_recruitment");
                }
        }
    }

    function delete_doc($id_recruitment_doc=''){
        $data = $this->db->query("SELECT * FROM recruitment_doc WHERE id_recruitment_doc='$id_recruitment_doc'")->result();
        $file_name = $data[0]->doc_name;
        $id_recruitment = $data[0]->id_recruitment;
        if($file_name!==""){
            unlink('./assets/document_file_recruit/'.$file_name);
        }
        
        $this->db->where('id_recruitment_doc', $id_recruitment_doc);
        $this->db->delete('recruitment_doc');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("recruitment/dokumen/$id_recruitment");
    }

    function delete_data($id_recruitment){
        $this->db->where('id_recruitment', $id_recruitment);
        $this->db->delete('recruitment');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("recruitment");
    }

    function process($id_recruitment_request){
        $data = array(
            'status'    => 'Processing'
        );
        $this->db->where('id_recruitment_request', $id_recruitment_request);
        $this->db->update('recruitment_request',$data);
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Request successfully process !!</div>");
        redirect("recruitment/request");
    }

    public function accept($id_calon_karyawan)
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
            'status'    => 'Accept'
        );

        $this->db->where('id_calon_karyawan',$id_calon_karyawan);
        $this->db->update('calon_karyawan',$data);

        $data_employee = $this->db->query("SELECT *FROM employee ORDER BY id_employee DESC")->result();
        if($data_employee){
            $new_id_employee = $data_employee[0]->id_employee + 1;
            $new_nik         = $data_employee[0]->nik + 1;
        }else{
            $new_id_employee = 10000;
            $new_nik         = 1000000000;
        }

        $data_calon = $this->db->query("SELECT * FROM calon_karyawan WHERE id_calon_karyawan='$id_calon_karyawan'")->result();
        $data = array(
            'id_employee'       => $new_id_employee,
            'nik'               => $new_nik,
            'firstname'         => $data_calon[0]->firstname,
            'lastname'          => $data_calon[0]->lastname,
            'email'             => $data_calon[0]->email,
            'id_division'       => $data_calon[0]->id_division,
            'id_position'       => $data_calon[0]->id_jabatan,
            'created_date'      => date('Y-m-d'),
            'created_by'        => $user_id
        );
        $this->db->insert('employee', $data);

        $data2 = array(
            'id_employee'           => $new_id_employee,
            'basic_salary'          => 0,
            'fixed_allowance'       => 0,
            'transport_allowance'   => 0,
            'meal_allowance'        => 0,
            'others_allowance'      => 0,
            'bonus'                 => 0,
            'created_date'          => date('Y-m-d'),
            'created_by'            => $user_id
        );
        $this->db->insert('payroll', $data2);

        $data3 = array(
                    'id_employee'           => $new_id_employee,
                    'payroll_month'         => date('m'),
                    'basic_salary'          => 0,
                    'fixed_allowance'       => 0,
                    'transport_allowance'   => 0,
                    'meal_allowance'        => 0,
                    'other_allowance'      => 0,
                    'bonus'                 => 0,
                    'created_date'          => date('Y-m-d'),
                    'created_by'            => $user_id
                );
                $this->db->insert('payroll_detail', $data3);

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Successfully accept !!</div>");
        redirect("recruitment");
    }

    public function reject($id_calon_karyawan)
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
            'status'    => 'Reject'
        );

        $this->db->where('id_calon_karyawan',$id_calon_karyawan);
        $this->db->update('calon_karyawan',$data);

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Successfully reject !!</div>");
        redirect("recruitment");
    }

    public function request()
    {
        $this->session->set_flashdata("halaman", "request"); //mensetting menuKepilih atau menu aktif
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
            'data_recruitment_request' =>$this->db->query("SELECT * FROM recruitment_request ORDER BY id_recruitment_request DESC")->result(),
            'data_position' =>$this->db->query("SELECT * FROM jabatan ORDER BY id_jabatan ASC")->result(),
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY division_name ASC")->result()
        );
        $this->template->load('template','recruitment/request',$data);
    }
}