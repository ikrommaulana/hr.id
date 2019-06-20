<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pra_karyawan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "pra_karyawan"); //mensetting menuKepilih atau menu aktif
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
            'data_employee' => $this->db->query("SELECT * FROM calon_karyawan ORDER BY id_calon_karyawan DESC")->result(),
        );
        $this->template->load('template','pra_karyawan/index2',$data);
    }

    public function add_edit_data($id_calon_karyawan=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        if($id_calon_karyawan==''){
            $save = $this->input->post('save');
            if(isset($save)){
                
                $data = array(
                    'firstname'         => $this->input->post('nama'),
                    'gender'            => $this->input->post('jenis_kelamin'),
                    'email'             => $this->input->post('email'),
                    'phone'             => $this->input->post('no_hp'),
                    'id_jabatan'        => $this->input->post('jabatan'),
                    'id_division'       => $this->input->post('departemen'),
                    'status'            => $this->input->post('status'),
                    'created_date'      => date('Y-m-d')
                );
                $this->db->insert('calon_karyawan', $data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("pra_karyawan");
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
                'title'             => 'Tambah Calon Karyawan',
                'data_employee'     => 0,
                'id_employee'       => '',
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_divisi'   => $this->db->query("SELECT * FROM division WHERE status='Enable' ORDER BY division_name ASC")->result(),
                'data_jabatan'   => $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan ASC")->result(),
                'data_privileges'   => $this->db->query("SELECT * FROM privileges WHERE status='1' ORDER BY privileges_name ASC")->result(),
             );
            $this->template->load('template','pra_karyawan/add_employee',$data);
        }else{
            $save = $this->input->post('save');
            $data_calon = $this->db->query("SELECT * FROM calon_karyawan WHERE id_calon_karyawan='$id_calon_karyawan'")->result();
            if(isset($save)){
                $data = array(
                    'firstname'         => $this->input->post('nama'),
                    'gender'            => $this->input->post('jenis_kelamin'),
                    'email'             => $this->input->post('email'),
                    'phone'             => $this->input->post('no_hp'),
                    'id_jabatan'        => $this->input->post('jabatan'),
                    'id_division'       => $this->input->post('departemen'),
                    'status'            => $this->input->post('status'),
                    'created_date'      => date('Y-m-d')
                );
                $this->db->where('id_calon_karyawan', $id_calon_karyawan);
                $this->db->update('calon_karyawan',$data);

                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
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
                    'title'             => 'Perbarui Calon Karyawan',
                    'data_employee'     => $data_calon,
                    'id_calon'       => $id_calon_karyawan,
                    'user_role_data'    => $user_role_data,
                    'user' => $user,
                    'data_divisi'   => $this->db->query("SELECT * FROM division WHERE status='Enable'  ORDER BY division_name ASC")->result(),
                    'data_jabatan'   => $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY id_jabatan ASC")->result(),
                    'data_privileges'   => $this->db->query("SELECT * FROM privileges WHERE status='1' ORDER BY privileges_name ASC")->result(),
                 );
            $this->template->load('template','pra_karyawan/add_employee',$data);
        }
    }

    public function data_status_karyawan(){
        $status_karyawan = $this->input->get('option');
        if($status_karyawan!=0){
            echo '<input type="text" class="form-control mydatepicker" id="input119" name="tgl_akhir_kontrak" required ><span class="highlight"></span> <span class="bar"></span><label for="input119">Tanggal Akhir Kontrak</label>';
        }      
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
}