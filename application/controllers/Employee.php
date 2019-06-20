<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "employee"); //mensetting menuKepilih atau menu aktif
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
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4' ORDER BY firstname ASC")->result(),
        );
        $this->template->load('template','employee/index2',$data);
    }

    public function non()
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
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee WHERE status_hapus='1' or employee_status='3' or employee_status='4' ORDER BY firstname ASC")->result(),
        );
        $this->template->load('template','employee/index2',$data);
    }

    public function approver($id_employee='')
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
            'id_employee' => $id_employee,
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee WHERE status_hapus='0' ORDER BY firstname ASC")->result(),
        );
        $this->template->load('template','employee/approver',$data);
    }

    public function set_approvel_dana($id_employee='')
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
            'id_employee' => $id_employee,
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_approval_division' =>$this->db->query("SELECT * FROM division a,employee_approval_dana b WHERE b.id_employee='$id_employee' AND b.is_delete='0' AND b.id_division=a.id_division ORDER BY a.division_name ASC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result(),
        );
        $this->template->load('template','employee/approvel_dana',$data);
    }

    public function add_approval_dana($id_employee)
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
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $data = array(
            'role_id' => $admin_role,
            'id_employee' =>$id_employee,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'nama_employee'     => $data_employee[0]->firstname,
            'data_departemen' =>$this->db->query("SELECT * FROM division WHERE status='Enable'")->result()
        );
        $this->template->load('template','employee/add_approval_dana',$data);
    }

    public function add_approval_dana_departemen()
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_employee = $this->input->post('id_employee');
        $id_division = $this->input->post('division');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $cek_available = $this->db->query("SELECT * FROM employee_approval_dana WHERE id_employee='$id_employee' AND is_delete='0' AND id_division='$id_division'")->result();
        if($cek_available){
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-warning\" id=\"alert\">Departemen sudah terdaftar !!</div>");
            redirect("employee/set_approvel_dana/$id_employee");
        }else{
            $data = array(
                'id_employee'  => $id_employee,
                'id_division'  => $id_division,
                'is_delete'    => 0,
                'created_by'   => $user_id,
                'created_date' => date('Y-m-d')
            );
            $this->db->insert('employee_approval_dana',$data);

            redirect("employee/set_approvel_dana/$id_employee");
        }
    }

    public function del_approval_dana_departemen($id_employee_approval_dana,$id_employee)
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_employee = $this->input->post('id_employee');
        $id_division = $this->input->post('division');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data = array(
            'is_delete'  => 1,
            'updated_date' => date('Y-m-d'),
            'updated_by'   => $user_id
        );
        $this->db->where('id_employee_approval_dana', $id_employee_approval_dana);
        $this->db->update('employee_approval_dana', $data);

        redirect("employee/set_approvel_dana/$id_employee");
    }

    public function sign($id_employee='')
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
            'id_employee' => $id_employee,
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee WHERE status_hapus='0' ORDER BY firstname ASC")->result(),
            'data_sign' => $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result()
        );
        $this->template->load('template','employee/sign',$data);
    }

    public function add_sign($id_employee=''){ 
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_employee!=''){
            $save = $this->input->post('save');
            if(isset($save)){
                $nmfile = "document".time(); //nama file saya beri nama langsung dan diikuti fungsi time
                $config['upload_path'] = './assets/images/sign/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['file_name'] = $nmfile; //nama yang terupload nantinya

                $this->load->library('upload', $config); 

                if ( ! $this->upload->do_upload('input-file-preview'))
                {
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Document failed added !!</div>");
                    redirect('employee');
                    
                }else{
                    $dok    = $this->upload->data();
                    $docname  = $dok['file_name'];

                    $ext = explode('.',$docname);
                    $ext_type = $ext[1];
                    
                    $data = array(
                        'sign_dig'   => $docname
                    );
                    $this->db->where('id_employee', $id_employee);
                    $this->db->update('employee', $data);
                    if($this->db->affected_rows()!=0){
                        
                        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                        redirect("employee");
                    }
                }
            }
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

    public function buat_password($id_employee){
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
        $pass_new = implode($pass);
        redirect("employee/add_edit_data/$id_employee/$pass_new");
              
    }

    public function add_edit_cuti_karyawan($id_employee){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');

        $data_cuti = $this->db->query("SELECT * FROM cuti ORDER BY jenis_cuti ASC")->result();
        if($data_cuti){
            foreach($data_cuti as $view){
                $cek_hak_cuti = $this->db->query("SELECT * FROM employee_hak_cuti WHERE id_employee='$id_employee' AND id_cuti='$view->id_cuti'")->result();
                if($cek_hak_cuti){
                    $data = array(
                        'id_employee'   => $id_employee,
                        'id_cuti'       => $view->id_cuti,
                        'status'        => $this->input->post("cuti$view->id_cuti"),
                        'jumlah'        => $this->input->post("jumlah$view->id_cuti"),
                        'updated_by'    => $user_id,
                        'updated_date'  => date('Y-m-d h:i:s')
                    );
                    $this->db->where('id_employee', $id_employee);
                    $this->db->where('id_cuti', $view->id_cuti);
                    $this->db->update('employee_hak_cuti',$data);
                }else{
                    $data = array(
                        'id_employee'   => $id_employee,
                        'id_cuti'       => $view->id_cuti,
                        'status'        => $this->input->post("cuti$view->id_cuti"),
                        'jumlah'        => $this->input->post("jumlah$view->id_cuti"),
                        'created_by'    => $user_id,
                        'created_date'  => date('Y-m-d h:i:s')
                    );
                    $this->db->insert('employee_hak_cuti', $data);
                }
            }
        }
        redirect("employee");
    }

    public function add_edit_data($id_employee='',$pass=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        if($id_employee==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $this->load->library('upload');
                $nmfile = "user".time(); //nama file saya beri nama langsung dan diikuti fungsi time
                $config['upload_path'] = './assets/images/'; //path folder
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
                $config['max_size'] = '10096'; //maksimum besar file 5M
                $config['file_name'] = $nmfile; //nama yang terupload nantinya
         
                $this->upload->initialize($config);
                 
                if ($this->upload->do_upload('image')){
                    $gbr    = $this->upload->data();
                    $image  = $gbr['file_name'];
                }else{
                    $image = '';
                }
                $data_employee = $this->db->query("SELECT *FROM employee ORDER BY id_employee DESC")->result();
                if($data_employee){
                    $new_id_employee = $data_employee[0]->id_employee + 1;
                }else{
                    $new_id_employee = 10000;
                }
                $exit_date = $this->input->post('tgl_akhir_kontrak');
                if($exit_date){
                    $ed = date("Y-m-d", strtotime($exit_date));
                }else{
                    $ed = '';
                }
                $expired_date = $this->input->post('tgl_ktp');
                if($expired_date){
                    $ex = date("Y-m-d", strtotime($this->input->post('tgl_ktp')));
                }else{
                    $ex = '';
                }
                $join_date = $this->input->post('tgl_bergabung');
                if($join_date){
                    $jd = date("Y-m-d", strtotime($this->input->post('tgl_bergabung')));
                }else{
                    $jd = '';
                }
                $date_birth = $this->input->post('tanggal_lahir');
                if($date_birth){
                    $db = date("Y-m-d", strtotime($this->input->post('tanggal_lahir')));
                }else{
                    $db = '';
                }
                $sandi = '2017'.$this->input->post('password').'CoEG11';
                $data = array(
                    'id_employee'       => $new_id_employee,
                    'nik'               => $this->input->post('nik'),
                    'firstname'         => $this->input->post('nama'),
                    'gender'            => $this->input->post('jenis_kelamin'),
                    'religion'          => $this->input->post('agama'),
                    'no_kk'             => $this->input->post('no_kk'),
                    'identity_no'       => $this->input->post('no_ktp'),
                    'expired_date'      => $ex,
                    'mobile_phone'      => $this->input->post('no_hp'),
                    'address'           => $this->input->post('alamat'),
                    'id_position'       => $this->input->post('jabatan'),
                    'id_division'       => $this->input->post('departemen'),
                    'id_absensi'       => $this->input->post('id_absensi'),
                    'join_date'         => $jd,
                    'exit_date'         => $ed,
                    'email'             => $this->input->post('email'),
                    'id_privileges'     => $this->input->post('hak_akses'),
                    'nama_bank'         => $this->input->post('nama_bank'),
                    'no_rek'            => $this->input->post('no_rek'),
                    'place_birth'       => $this->input->post('tempat_lahir'),
                    'employee_status'   => $this->input->post('status_karyawan'),
                    'date_birth'        => $db,
                    'password'          => md5($sandi),
                    'account_status'    => 1,
                    'image'             => $image,
                    'created_date'      => date('Y-m-d'),
                    'created_by'        => $user_id
                );
                $this->db->insert('employee', $data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("employee");
                }
            }
            $nik = $this->db->query("SELECT nik as nk FROM employee order by nik desc")->result();
            if($nik){
                $new_nik = $nik[0]->nk + 1;
            }else{
                $new_nik = 1000000000;
            }
            $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
            if($cek_user){
                $user = $cek_user;
            }else{
                $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
            }
            $data = array(
                'role_id' => $admin_role,
                'title'             => 'Tambah Karyawan',
                'data_employee'     => 0,
                'id_employee'       => '',
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_divisi'   => $this->db->query("SELECT * FROM division WHERE status='Enable' ORDER BY division_name ASC")->result(),
                'data_jabatan'   => $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan ASC")->result(),
                'data_privileges'   => $this->db->query("SELECT * FROM privileges WHERE status='1' ORDER BY privileges_name ASC")->result(),
                'new_nik'   => $new_nik,
                'pass'          => ''
            );
            $this->template->load('template','employee/add_employee',$data);
        }else{
            $save = $this->input->post('save');
            $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
            $email = $data_employee[0]->email;
            $data_payroll = $this->db->query("SELECT * FROM payroll WHERE id_employee='$id_employee'")->result();
            if(isset($save)){
                $this->load->library('upload');
                $nmfile = "user".time(); //nama file saya beri nama langsung dan diikuti fungsi time
                $config['upload_path'] = './assets/images/'; //path folder
                $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
                $config['max_size'] = '10096'; //maksimum besar file 5M
                $config['file_name'] = $nmfile; //nama yang terupload nantinya
         
                $this->upload->initialize($config);
                 
                if ($this->upload->do_upload('image')){
                    $gbr    = $this->upload->data();
                    $image  = $gbr['file_name'];
                }else{
                    $image = $data_employee[0]->image;
                }

                if($this->input->post('password')=='**********'){
                    $password = $data_employee[0]->password;
                }else{
                    $sandi = '2017'.$this->input->post('password').'CoEG11';
                    $password = md5($sandi);
                }
                $exit_date = $this->input->post('tgl_akhir_kontrak');
                if($exit_date){
                    $ed = date("Y-m-d", strtotime($exit_date));
                }else{
                    $ed = '';
                }
                $expired_date = $this->input->post('tgl_ktp');
                if($expired_date){
                    $ex = date("Y-m-d", strtotime($this->input->post('tgl_ktp')));
                }else{
                    $ex = '';
                }
                $join_date = $this->input->post('tgl_bergabung');
                if($join_date){
                    $jd = date("Y-m-d", strtotime($this->input->post('tgl_bergabung')));
                }else{
                    $jd = '';
                }
                $date_birth = $this->input->post('tanggal_lahir');
                if($date_birth){
                    $db = date("Y-m-d", strtotime($this->input->post('tanggal_lahir')));
                }else{
                    $db = '';
                }
                $data = array(
                    'nik'               => $this->input->post('nik'),
                    'firstname'         => $this->input->post('nama'),
                    'gender'            => $this->input->post('jenis_kelamin'),
                    'religion'          => $this->input->post('agama'),
                    'no_kk'             => $this->input->post('no_kk'),
                    'identity_no'       => $this->input->post('no_ktp'),
                    'expired_date'      => $ex,
                    'mobile_phone'      => $this->input->post('no_hp'),
                    'address'           => $this->input->post('alamat'),
                    'id_position'       => $this->input->post('jabatan'),
                    'id_division'       => $this->input->post('departemen'),
                    'id_absensi'       => $this->input->post('id_absensi'),
                    'join_date'         => $jd,
                    'exit_date'         => $ed,
                    'email'             => $this->input->post('email'),
                    'id_privileges'     => $this->input->post('hak_akses'),
                    'nama_bank'         => $this->input->post('nama_bank'),
                    'no_rek'            => $this->input->post('no_rek'),
                    'place_birth'       => $this->input->post('tempat_lahir'),
                    'employee_status'   => $this->input->post('status_karyawan'),
                    'date_birth'        => $db,
                    'password'          => $password,
                    'account_status'    => 1,
                    'image'             => $image,
                    'updated_date'      => date('Y-m-d'),
                    'updated_by'        => $user_id
                );
                $this->db->where('id_employee', $id_employee);
                $this->db->update('employee',$data);

                $message = "<html>
                            <head>
                            <title></title>
                            <style>
                            .button, .button2,.button3 {
                                border: none;
                                color: white;
                                padding: 15px 32px;
                                text-align: center;
                                text-decoration: none;
                                display: inline-block;
                                font-size: 16px;
                                margin: 4px 2px;
                                cursor: pointer;
                            }
                            .button {
                                background-color: #4CAF50;
                            }
                            .button2 {
                                background-color: #F78181;
                            }
                            .button3 {
                                background-color: #58FAF4;
                            }
                            </style>
                            </head>
                            <body style='background:#f5f5f5;'>
                                <table align='center' width='800px' cellpadding='0' cellspacing='1' bgcolor='#ffffff' border='0' style='font-family:Verdana,Geneva,Sans-serif;'>
                                    <tr height='50'>
                                        <td width='150px'></td>
                                        <td width='150px'></td>
                                        <td width='200px'><img src='".base_url()."assets/images/logo.jpg' width='200px'/>
                                        </td>
                                        <td width='150px'></td>
                                        <td width='150px'></td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td valign='top' colspan='3' style='padding-left:20px'>
                                            <p>Berikut adalah username dan password Anda untuk login di system HR LIB</p>
                                            <p>Username : ".$email."</p>
                                            <p>Password : ".$this->input->post('password')."</p>
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."' class='button'>Masuk Ke System</a>
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <p>Terimakasih,</p>
                                            <p>Tim HR</p>
                                        </td>
                                    </tr>
                                </table>
                            </body>";
            require_once("PHPMailer/PHPMailerAutoload.php");
     

                    $mail = new PHPMailer(); 
                    $mail->From     = 'noreply@ligaindonesiabaru.com';
                    $mail->FromName = 'HR';
                    $mail->IsSMTP(); 
                    $mail->SMTPOptions = array(
                            'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ) 
                    );
                    $mail->SMTPAuth = true; 
                    $mail->Username = 'noreply@ligaindonesiabaru.com'; //username email 
                    $mail->Password = '@DM1nNOR3plY'; //password email 
                    $mail->SMTPSecure = "ssl";
                    $mail->Host ='smtp.gmail.com'; 
                    $mail->Port = 465; //port secure ssl email 
                    $mail->IsHTML(true);
                    $mail->Subject = 'Akses System HR LIB'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($email);

                    if($this->input->post('password')!='**********'){
                        $kirim = $mail->Send();
                    }
                     

                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data telah diperbarui !!</div>");
                    redirect("employee");
                }
                }
                $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
                if($cek_user){
                    $user = $cek_user;
                }else{
                    $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
                }
                $data = array(
                    'role_id' => $admin_role,
                    'title'             => 'Perbarui Karyawan',
                    'data_employee'     => $data_employee,
                    'id_employee'       => $id_employee,
                    'data_payroll'     => $data_payroll,
                    'user_role_data'    => $user_role_data,
                    'user' => $user,
                    'data_divisi'   => $this->db->query("SELECT * FROM division WHERE status='Enable'  ORDER BY division_name ASC")->result(),
                    'data_jabatan'   => $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan ASC")->result(),
                    'data_privileges'   => $this->db->query("SELECT * FROM privileges WHERE status='1' ORDER BY privileges_name ASC")->result(),
                    'new_nik'       => $data_employee[0]->nik,
                    'pass'          => $pass
                );
            $this->template->load('template','employee/add_employee',$data);
        }
    }

    public function data_status_karyawan(){
        $status_karyawan = $this->input->get('option');
        if($status_karyawan==1){
            echo '<input type="text" class="form-control mydatepicker" id="input119" name="tgl_akhir_kontrak" required ><span class="highlight"></span> <span class="bar"></span><label for="input119">Tanggal Akhir Kontrak</label>';
        }elseif($status_karyawan==2){
            echo '<input type="text" class="form-control mydatepicker" id="input119" name="tgl_akhir_kontrak" required ><span class="highlight"></span> <span class="bar"></span><label for="input119">Tanggal Akhir Probation</label>';
        }elseif($status_karyawan==3){
            echo '<input type="text" class="form-control mydatepicker" id="input119" name="tgl_akhir_kontrak" required ><span class="highlight"></span> <span class="bar"></span><label for="input119">Tanggal Resign</label>';
        }elseif($status_karyawan==4){
            echo '<input type="text" class="form-control mydatepicker" id="input119" name="tgl_akhir_kontrak" required ><span class="highlight"></span> <span class="bar"></span><label for="input119">Tanggal Diberhentikan</label>';
        }      
    }

    
    

    public function check_pass_lama(){
        $pass = $this->input->get('option');
        $sandi = '2017'.$pass.'CoEG11';
        $password = md5($sandi);
        $id_employee = $this->session->userdata('user_id');
        $check = $this->db->query("SELECT password as password_lama FROM employee WHERE id_employee='$id_employee'")->result();
        $password_lama = $check[0]->password_lama;

        if($password_lama!=$password){
            echo 'Password lama salah !';
        }else{
            echo '';
        }      
    }

    public function ganti_password($id_employee)
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
        $sandi = '2017'.$this->input->post('password').'CoEG11';
        $password_baru = md5($sandi);
        $page_now = substr($this->input->post('pg'),8);
        $data = array(
            'password'  => $password_baru
        );
        $this->db->where('id_employee',$id_employee);
        $this->db->update('employee',$data);

        redirect('index');
    }

    public function add_id_absensi($id_employee,$id_absensi)
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
            'id_absensi'  => $id_absensi
        );
        $this->db->where('id_employee',$id_employee);
        $this->db->update('employee',$data);

        redirect('employee');
    }

    public function add_approver($id_employee)
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
        $id_approver = $this->input->post('approver');
        $data = array(
            'approver'  => $id_approver
        );
        $this->db->where('id_employee',$id_employee);
        $this->db->update('employee',$data);

        redirect('employee');
    }

    public function detail($id_employee)
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
            'id_employee'   => $id_employee,
            'user_role_data'    => $user_role_data,
            'user' => $user,
           
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee a, division b WHERE a.id_division=b.id_division ORDER BY a.id_employee DESC")->result(),
            'data_add' =>$this->db->query("SELECT * FROM attendance_add WHERE id_employee='$id_employee'")->result()
        );
        $this->template->load('template','employee/add',$data);
    }

    public function karir($id_employee)
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
        $data_karir = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.nik='$id_employee' and a.id_position=b.id_jabatan")->result();
        $data = array(
            'data_karir'   => $data_karir,
            'id_employee'   => $id_employee,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_jabatan' =>$this->db->query("SELECT * FROM jabatan ORDER BY id_jabatan DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee a, division b WHERE a.id_division=b.id_division ORDER BY a.id_employee DESC")->result(),
            'data_add' =>$this->db->query("SELECT * FROM attendance_add WHERE id_employee='$id_employee'")->result()
        );
        $this->template->load('template','employee/karir',$data);
    }

    public function job($id_employee)
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
            'id_employee'   => $id_employee,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' => $this->db->query("SELECT * FROM employee a, division b WHERE a.id_division=b.id_division ORDER BY a.id_employee DESC")->result(),
            'data_job' =>$this->db->query("SELECT * FROM target_pekerjaan WHERE id_employee='$id_employee'")->result()
        );
        $this->template->load('template','employee/job',$data);
    }

    public function kpi(){
        $id_kpi = $this->input->post('id_kpi');
        $id_employee = $this->input->post('id_employee');
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        if($id_kpi==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'id_employee'       => $id_employee,
                    'attendance'        => $this->input->post('attendance'),
                    'attitude'          => $this->input->post('attitude'),
                    'team_work'         => $this->input->post('team_work'),
                    'discipline'        => $this->input->post('discipline'),
                    'job_target'        => $this->input->post('job_target'),
                    'created_date'      => date('Y-m-d'),
                    'created_by'        => $user_id
                );
                $this->db->insert('employee_kpi', $data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("employee");
                }
            }
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'id_employee'       => $id_employee,
                    'attendance'        => $this->input->post('attendance'),
                    'attitude'          => $this->input->post('attitude'),
                    'team_work'         => $this->input->post('team_work'),
                    'discipline'        => $this->input->post('discipline'),
                    'job_target'        => $this->input->post('job_target'),
                    'updated_date'      => date('Y-m-d'),
                    'updated_by'        => $user_id
                );
                $this->db->where('id_kpi', $id_kpi);
                $this->db->update('employee_kpi',$data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("employee");
                }
            }
        }
    }

    public function kpilist()
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
            'data_kpi' => $this->db->query("SELECT * FROM employee_kpi ORDER BY id_kpi DESC")->result(),
        );
        $this->template->load('template','employee/kpi_list',$data);
    }

    public function loan()
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
            'data_loan' => $this->db->query("SELECT * FROM employee_loan ORDER BY id_employee_loan DESC")->result(),
        );
        $this->template->load('template','employee/loan',$data);
    }

    public function add_info()
    {
        $user_id = $this->session->userdata('user_id');
        $id_employee = $this->input->post('id_employee');
        $data = array(
            'id_employee'    => $id_employee,
            'description'       => $this->input->post('description'),
            'attendance_date'   => $this->input->post('tanggal')
        );

        $this->db->insert('attendance_add',$data);

        redirect("employee/detail/$id_employee");
    }

    public function add_karir()
    {
        $user_id = $this->session->userdata('user_id');
        $id_employee = $this->input->post('id_employee');
        $data = array(
            'id_employee'    => $id_employee,
            'id_jabatan'       => $this->input->post('jabatan'),
            'start_date'   => $this->input->post('start_date'),
            'end_date'   => $this->input->post('end_date')
        );

        $this->db->insert('jenjang_karir',$data);

        redirect("employee/karir/$id_employee");
    }

    public function add_job()
    {
        $user_id = $this->session->userdata('user_id');
        $id_employee = $this->input->post('id_employee');
        $data = array(
            'id_employee'    => $id_employee,
            'jenis_pekerjaan'       => $this->input->post('jenis_pekerjaan'),
            'start_date'   => $this->input->post('start_date'),
            'end_date'   => $this->input->post('end_date'),
        );

        $this->db->insert('target_pekerjaan',$data);

        redirect("employee/job/$id_employee");
    }

    public function create_loan(){
        $id_employee_loan = $this->input->post('id_employee_loan');
        $id_employee = $this->input->post('id_employee');
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $description = $this->input->post('description');
        $total_loan = $this->session->userdata('loan');
        $loan_date=$this->session->userdata('tanggal');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        if($id_employee_loan==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'id_employee'       => $id_employee,
                    'total_loan'        => $this->input->post('loan'),
                    'note'              => $this->input->post('description'),
                    'loan_date'         => $this->input->post('tanggal'),
                    'created_date'      => date('Y-m-d'),
                    'created_by'        => $user_id
                );
                $this->db->insert('employee_loan', $data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Loan successfully added !!</div>");
                    redirect("employee");
                }
            }
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'id_employee'       => $id_employee,
                    'attendance'        => $this->input->post('attendance'),
                    'attitude'          => $this->input->post('attitude'),
                    'team_work'         => $this->input->post('team_work'),
                    'discipline'        => $this->input->post('discipline'),
                    'job_target'        => $this->input->post('job_target'),
                    'updated_date'      => date('Y-m-d'),
                    'updated_by'        => $user_id
                );
                $this->db->where('id_kpi', $id_kpi);
                $this->db->update('employee_kpi',$data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("employee");
                }
            }
        }
    }

    function loan_lunas($id_employee_loan){
        $data  = array(
            'status'    => 1
        );
        $this->db->where('id_employee_loan', $id_employee_loan);
        $this->db->update('employee_loan',$data);

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Loan successfully pay !!</div>");
        redirect("employee/loan");
    }

    function loan_hapus($id_employee_loan){
        $this->db->where('id_employee_loan', $id_employee_loan);
        $this->db->delete('employee_loan');

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Loan successfully deleted !!</div>");
        redirect("employee/loan");
    }

    function add_hapus($id_attendance_add,$id_employee){
        $this->db->where('id_attendance_add', $id_attendance_add);
        $this->db->delete('attendance_add');

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("employee/detail/$id_employee");
    }

    function job_hapus($id_target_pekerjaan,$id_employee){
        $this->db->where('id_target_pekerjaan', $id_target_pekerjaan);
        $this->db->delete('target_pekerjaan');

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("employee/job/$id_employee");
    }

    function delete_kpi($id_kpi){
        $this->db->where('id_kpi', $id_kpi);
        $this->db->delete('employee_kpi');

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">KPI successfully deleted !!</div>");
        redirect("employee/kpilist");
    }

    function delete_data($id_employee){
        $data = array(
            'status_hapus'          => 1, 
            'updated_date'          => date('Y-m-d'),
            'updated_by'            => $user_id
        );
        $this->db->where('id_employee',$id_employee);
        $this->db->update('employee', $data);

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("employee");
    }

    function create_table(){
        $this->db->query("CREATE TABLE IF NOT EXISTS reset_password (
            id_reset_password int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            email varchar(150) NOT NULL,
            token varchar(32) NOT NULL,
            expired_date date NOT NULL
        )")->result();
    }

    function tambah_kolom(){
        $this->db->query("ALTER TABLE employee ADD approver varchar (50)")->result();
    }

    function tambah_kolom2(){
        $this->db->query("ALTER TABLE reset_password ADD is_tag int(1)")->result();
    }
}