<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "report"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
        $filter = $this->input->post('filter');
        if(isset($filter)){
            $daterange = $this->input->post('tanggal');
            $date   = explode(' - ', $daterange);
            $start  = date('Y-m-d', strtotime($date[0]));
            $end    = date('Y-m-d', strtotime($date[1]));
            $start2  = date('m/d/Y', strtotime($date[0]));
            $end2    = date('m/d/Y', strtotime($date[1]));
            $departemen = $this->input->post('departemen');
        }else{
            $departemen = '';
            $start = date('Y-m-d');
            $end = date('Y-m-d');
            $start2 = date('m/d/Y');
            $end2 = date('m/d/Y');
        }
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
            'user'              => $user,
            'tanggal_start'     => $start,
            'tanggal_end'       => $end,
            'tanggal_start2'    => $start2,
            'tanggal_end2'      => $end2,
            'departemen'        => $departemen
        );
        $this->template->load('template','report/attendance/index',$data);
    }

    public function detail($id_employee,$month,$year)
    {
        $filter = $this->input->post('filter');
        if(isset($filter)){
            $daterange = $this->input->post('tanggal');
            $date   = explode(' - ', $daterange);
            $start  = date('Y-m-d', strtotime($date[0]));
            $end    = date('Y-m-d', strtotime($date[1]));
            $start2  = date('m/d/Y', strtotime($date[0]));
            $end2    = date('m/d/Y', strtotime($date[1]));
            $departemen = $this->input->post('departemen');
        }else{
            $departemen = '';
            $start = date('Y-m-d');
            $end = date('Y-m-d');
            $start2 = date('m/d/Y');
            $end2 = date('m/d/Y');
        }
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
            'user'              => $user,
            'month'     => $month,
            'year'       => $year,
            'tanggal_start2'    => $start2,
            'tanggal_end2'      => $end2,
            'departemen'        => $departemen,
            'id_employee'       => $id_employee
        );
        $this->template->load('template','report/attendance/detail',$data);
    }

    public function index_()
    {
        $filter = $this->input->post('filter');
        if(isset($filter)){
            $daterange = $this->input->post('tanggal');
            $date   = explode(' - ', $daterange);
            $start  = date('Y-m-d', strtotime($date[0]));
            $end    = date('Y-m-d', strtotime($date[1]));
            $start2  = date('m/d/Y', strtotime($date[0]));
            $end2    = date('m/d/Y', strtotime($date[1]));
            $departemen = $this->input->post('departemen');
        }else{
            $departemen = '';
            $start = date('Y-m-d');
            $end = date('Y-m-d');
            $start2 = date('m/d/Y');
            $end2 = date('m/d/Y');
        }
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
            'user'              => $user,
            'tanggal_start'     => $start,
            'tanggal_end'       => $end,
            'tanggal_start2'    => $start2,
            'tanggal_end2'      => $end2,
            'departemen'        => $departemen
        );
        $this->template->load('template','report/attendance/index_',$data);
    }

    public function summary_staf($id_employee='',$tahun='')
    {
        error_reporting(0);
        $data_employee = $this->db->query("SELECT * FROM employee a WHERE id_employee='$id_employee'")->result();
        $now = date('Y-m-d');
        $join_date = (empty($data_employee)) ? $now : $data_employee[0]->join_date;

        $date1 = new DateTime($join_date);
        $date2 = new DateTime($now);
        $interval = date_diff($date1, $date2);
        $masa_kerja = $interval->m + ($interval->y * 12);

        $id_division = $data_employee[0]->id_division;
        $id_jabatan = $data_employee[0]->id_position;
        $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_cuti = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND (id_cuti='2' OR id_cuti='3' OR id_cuti='6' OR id_cuti='7') AND YEAR(start_date)='$tahun'")->num_rows();
        $data_sakit = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND id_cuti='5' AND YEAR(start_date)='$tahun'")->num_rows();
        $data_izin = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND (id_cuti='4' OR id_cuti='8') AND YEAR(start_date)='$tahun'")->num_rows();
        $data_hak_cuti = $this->db->query("SELECT * FROM cuti a, employee_hak_cuti b WHERE a.id_cuti=b.id_cuti AND b.status='1'  AND b.id_employee='$id_employee' GROUP BY b.id_cuti ORDER BY b.id_cuti DESC")->result();
        $tahun = date('Y');
        $bulan = date('m');
        $data = array(
            'role_id' => $admin_role,
            'tahun'             => $tahun,
            'jumlah_cuti'       => $data_cuti,
            'jumlah_sakit'      => $data_sakit,
            'jumlah_izin'      => $data_izin,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_employee'     => $data_employee,
            'division_name'     => $data_division[0]->division_name,
            'jabatan'           => $data_jabatan[0]->nama_jabatan,
            'id_employee'       => $id_employee,
            'id_absensi'        => $data_employee[0]->id_absensi,
            'data_hak_cuti'     => $data_hak_cuti,
            'bulan'             => $bulan,
            'masa_kerja'        => $masa_kerja
        );
        $this->template->load('template','report/attendance/summary_staf',$data);
    }

    public function filt_staf(){
        error_reporting(0);
        $id_employee = $this->input->post('id_employee');
        $tahun = $this->input->post('tahun');

        $data_employee = $this->db->query("SELECT * FROM employee a WHERE id_employee='$id_employee'")->result();
        $now = date('Y-m-d');
        $join_date = (empty($data_employee)) ? $now : $data_employee[0]->join_date;

        $id_division = $data_employee[0]->id_division;
        $id_jabatan = $data_employee[0]->id_position;
        $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_cuti = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND (id_cuti='2' OR id_cuti='3' OR id_cuti='6' OR id_cuti='7') AND YEAR(start_date)='$tahun'")->num_rows();
        $data_sakit = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND id_cuti='5' AND YEAR(start_date)='$tahun'")->num_rows();
        $data_izin = $this->db->query("SELECT * FROM permit WHERE id_employee='$id_employee' AND (id_cuti='4' OR id_cuti='8') AND YEAR(start_date)='$tahun'")->num_rows();
        $data_hak_cuti = $this->db->query("SELECT * FROM cuti a, employee_hak_cuti b WHERE a.id_cuti=b.id_cuti AND b.status='1'  AND b.id_employee='$id_employee' GROUP BY b.id_cuti ORDER BY b.id_cuti DESC")->result();
        $bulan = date('m');
        $data = array(
            'role_id' => $admin_role,
            'tahun'             => $tahun,
            'jumlah_cuti'       => $data_cuti,
            'jumlah_sakit'      => $data_sakit,
            'jumlah_izin'      => $data_izin,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_employee'     => $data_employee,
            'division_name'     => $data_division[0]->division_name,
            'jabatan'           => $data_jabatan[0]->nama_jabatan,
            'id_employee'       => $id_employee,
            'id_absensi'        => $data_employee[0]->id_absensi,
            'data_hak_cuti'     => $data_hak_cuti,
            'bulan'             => $bulan,
            'masa_kerja'        => $masa_kerja
        );
        $this->template->load('template','report/attendance/summary_staf',$data);
    }

    public function summary_div($id_division='')
    {
        error_reporting(0);
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_division='$id_division' AND status_hapus='0'")->result();
        $id_jabatan = $data_employee[0]->id_position;
        $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
        $data_division_all = $this->db->query("SELECT * FROM division")->result();
        if($data_division){
            $division_name = $data_division[0]->division_name;
        }else{
            $division_name = '-';
        }
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
        if($data_jabatan){
            $jabatan = $data_jabatan[0]->nama_jabatan;
        }else{
            $jabatan = '-';
        }
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $tahun = date('Y');
        $bulan = date('m');
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_employee'     => $data_employee,
            'division_name'     => $division_name,
            'jabatan'           => $jabatan,
            'id_division'       => $id_division,
            'data_division_all' => $data_division_all,
            'tahun'             => $tahun,
            'bulan'             => $bulan
        );
        $this->template->load('template','report/attendance/summary_div',$data);
    }

    public function filt_div()
    {
        error_reporting(0);
        $id_division = $this->input->post('id_division');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_division='$id_division' AND status_hapus='0'")->result();
        $id_jabatan = $data_employee[0]->id_position;
        $data_division = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
        $data_division_all = $this->db->query("SELECT * FROM division")->result();
        if($data_division){
            $division_name = $data_division[0]->division_name;
        }else{
            $division_name = '-';
        }
        $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
        if($data_jabatan){
            $jabatan = $data_jabatan[0]->nama_jabatan;
        }else{
            $jabatan = '-';
        }
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
            'user'              => $user,
            'data_employee'     => $data_employee,
            'division_name'     => $division_name,
            'jabatan'           => $jabatan,
            'id_division'       => $id_division,
            'data_division_all' => $data_division_all,
            'tahun'             => $tahun,
            'bulan'             => $bulan
        );
        $this->template->load('template','report/attendance/summary_div',$data);
    }

    public function ob()
    {
        $filter = $this->input->post('filter');
        if(isset($filter)){
            $daterange = $this->input->post('tanggal');
            $date   = explode(' - ', $daterange);
            $start  = date('Y-m-d', strtotime($date[0]));
            $end    = date('Y-m-d', strtotime($date[1]));
            $start2  = date('m/d/Y', strtotime($date[0]));
            $end2    = date('m/d/Y', strtotime($date[1]));
            $departemen = $this->input->post('departemen');
        }else{
            $departemen = 9;
            $start = date('Y-m-d');
            $end = date('Y-m-d');
            $start2 = date('m/d/Y');
            $end2 = date('m/d/Y');
        }
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
            'user'              => $user,
            'tanggal_start'     => $start,
            'tanggal_end'       => $end,
            'tanggal_start2'    => $start2,
            'tanggal_end2'      => $end2,
            'departemen'        => $departemen
        );
        $this->template->load('template','report/attendance/index2',$data);
    }

    function todolist(){
        $this->session->set_flashdata("halaman", "todolist"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_permit = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit=b.id_permit AND b.id_approver='$user_id'")->result();
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_permit'         => $data_permit,
            'data_cuti'         => $data_cuti
        );

        $this->template->load('template','permit/daftar',$data);
    }
    
    function to_excel($bulan,$tahun){
        error_reporting(0);
        $data_division = $this->db->query("SELECT * FROM division")->result();
        $data = array(
            'data_division'     => $data_division,
            'tahun'             => $tahun,
            'bulan'             => $bulan
        );
        //$this->load->view('lokasi/excel_view',$data);
        $this->load->view('report/attendance/excel_view',$data);
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