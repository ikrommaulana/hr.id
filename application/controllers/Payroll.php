<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        
    }

    public function index()
    {
        $filter = $this->input->post('filter');
        $excel = $this->input->post('excel');
        if(isset($filter)){
            $id_division = $this->input->post('division');
            $month = $this->input->post('month');
            $year = $this->input->post('year');
            if(!empty($id_division)){
                $data_payroll = $this->db->query("SELECT * FROM employee a, payroll_detail b WHERE a.id_division='$id_division' AND b.payroll_month='$month' AND YEAR(b.created_date)='$year' GROUP BY b.payroll_month ORDER BY b.id_payroll_detail DESC")->result();    
            }else{
                $data_payroll = $this->db->query("SELECT * FROM payroll_detail WHERE payroll_month='$month' AND YEAR(created_date)='$year' GROUP BY payroll_month ORDER BY id_payroll_detail DESC")->result();
            }
        }elseif(isset($excel)){
            redirect('payroll/toexcel');
        }else{
            $id_division = '';
            $month = date('m');
            $year = date('Y');
            $data_payroll = $this->db->query("SELECT * FROM payroll_detail WHERE payroll_month='08' AND YEAR(created_date)='2017' ORDER BY id_payroll_detail DESC")->result();
        }
        $this->session->set_flashdata("halaman", "listp"); //mensetting menuKepilih atau menu aktif
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
            'month' => $month,
            'year'  => $year,
            'id_division' => $id_division,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_payroll' => $data_payroll,
            'data_employee' =>$this->db->query("SELECT * FROM employee ORDER BY id_division DESC")->result()
        );
        $this->template->load('template','payroll/index',$data);
    }

    function toexcel(){
        $id_division = $this->input->post('division');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        
        if(!empty($id_division)){
            $data_payroll = $this->db->query("SELECT * FROM employee a, payroll_detail b WHERE a.id_division='$id_division' AND b.payroll_month='$month' AND YEAR(b.created_date)='$year' GROUP BY b.payroll_month ORDER BY b.id_payroll_detail DESC")->result();    
        }else{
            $data_payroll = $this->db->query("SELECT * FROM employee a, payroll_detail b WHERE b.payroll_month='$month' AND YEAR(b.created_date)='$year' GROUP BY b.payroll_month ORDER BY b.id_payroll_detail DESC")->result(); 
        }
        
        
        $data = array(
            'data_payroll'      => $data_payroll,
            'month'             => $month,
            'year'              => $year
        );
        //$this->load->view('lokasi/excel_view',$data);
        $this->load->view('payroll/excel_view',$data);
    }

    public function create()
    {
        $this->session->set_flashdata("halaman", "create"); //mensetting menuKepilih atau menu aktif
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
            'data_division' =>$this->db->query("SELECT * FROM division ORDER BY id_division DESC")->result(),
            'data_employee' =>$this->db->query("SELECT * FROM employee WHERE employee_status='1' ORDER BY id_division DESC")->result()
        );
        $this->template->load('template','payroll/create',$data);
    }

    public function process($id_employee,$id_payroll_detail)
    {
        $this->session->set_flashdata("halaman", "create"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_division  = $employee[0]->id_division;
        $id_jabatan = $employee[0]->id_position;
        $data_loan = $this->db->query("SELECT * FROM employee_loan WHERE id_employee='$id_employee' and status='0'")->result();
        $data = array(
            'data_loan' => $data_loan,
            'nik'   => $id_employee,
            'id_payroll_detail' => $id_payroll_detail,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_division' =>$this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result(),
            'data_employee' =>$employee,
            'jabatan'   => $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result(),
            'data_payroll'   => $this->db->query("SELECT * FROM payroll WHERE id_employee='$id_employee'")->result()
        );
        $this->template->load('template','payroll/process',$data);
    }

    public function process_salary(){
        $user_id = $this->session->userdata('user_id');
        $id_employee = $this->input->post('id_employee');
        $id_payroll_detail = $this->input->post('id_payroll_detail');
        $id_employee_loan = $this->input->post('cut');
        $data_loan = $this->db->query("SELECT * FROM employee_loan WHERE id_employee_loan='$id_employee_loan'")->result();
        $jml = $data_loan[0]->total_loan;

        $data = array(
            'salary_cuts'           => $jml
        );
        $this->db->where('id_payroll_detail', $id_payroll_detail);
        $this->db->update('payroll_detail', $data);

        $data2 = array(
            'status'           => 1
        );
        $this->db->where('id_employee_loan', $id_employee_loan);
        $this->db->update('employee_loan', $data2);

        if($this->db->affected_rows()!=0){
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully processed !!</div>");
            redirect("payroll/");
        }    
    }

    public function print_slip($id_employee,$month)
    {
        $this->session->set_flashdata("halaman", "create"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_division  = $employee[0]->id_division;
        $id_jabatan = $employee[0]->id_position;
        $data = array(
            'nik'   => $id_employee,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_division' =>$this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result(),
            'data_employee' =>$employee,
            'jabatan'   => $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result(),
            'data_payroll'   => $this->db->query("SELECT * FROM payroll_detail WHERE id_employee='$id_employee' AND payroll_month='$month'")->result()
        );
        //$this->template->load('template','payroll/printpdf',$data);
        $html                   = $this->load->view('payroll/print',$data,true);
        $pdfFilePath            = "slip-".date('y-m-d').".pdf";
        $pdfFilePath            = "slip.pdf";
                                  $this->load->library('m_pdf');
        $pdf                    = $this->m_pdf->load();
        $mpdf                   = new mPDF('c', 'A4-L');
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I"); 
    }

    function delete_data($id_letter_number){
        $this->db->where('id_letter_number', $id_letter_number);
        $this->db->delete('letter_number');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("letter");
    }

    
}