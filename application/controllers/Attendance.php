<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        
        $this->session->set_flashdata("halaman", "attendance"); //mensetting menuKepilih atau menu aktif
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
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_attendance' =>$this->db->query("SELECT * FROM attendance a, employee b, division c WHERE a.id_employee=b.nik AND b.id_division=c.id_division ORDER BY a.id_attendance ASC")->result(),
            'data_employee' =>$this->db->query("SELECT * FROM employee a,division b WHERE a.id_division=b.id_division ORDER BY a.id_employee DESC")->result()
        );
        $this->template->load('template','attendance/index',$data);
    }

    public function add_edit_data(){
        $user_id = $this->session->userdata('user_id');
        $id_attendance = $this->input->post('id_attendance');
        
        if($id_attendance==''){
            $id_employee = $this->input->post('id_employee');
            $jml_employee = count($id_employee);

            $data=array();
            for($i=1; $i<=$jml_employee; $i++){
                $total[$i] = $_POST['out'][$i] - $_POST['in'][$i];
                $data[] = array(
                    'id_employee'   => $_POST['id_employee'][$i],
                    'attendance_date'   => $this->input->post('tanggal'),
                    'actual_in'   => $_POST['in'][$i],
                    'actual_out'   => $_POST['out'][$i],
                    'total_time'   => $total[$i],
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
            }
            
            $this->db->insert_batch('attendance',$data);
            //$this->db->insert('attendance', $data);
            if($this->db->affected_rows()!=0){
                
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                redirect("attendance");
            }
        }else{
            $in = $this->input->post('actual_in');
            $out = $this->input->post('actual_out');
            $total = $out - $in;
            $data = array(
                'attendance_date'   => $this->input->post('tanggal'),
                'actual_in'   => $this->input->post('actual_in'),
                'actual_out'   => $this->input->post('actual_out'),
                'total_time'   => $total,
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => $user_id
            );
                
            $this->db->where('id_attendance', $id_attendance);
            $this->db->update('attendance', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("attendance");
            }
        }
    }

    public function import_data(){
        $user_id = $this->session->userdata('user_id');
        $config['upload_path'] = './temp_upload/';
        $config['allowed_types'] = 'xls';
        $tanggal = $this->input->post('tanggal', TRUE);
                
        $this->load->library('upload', $config); 

        if ( ! $this->upload->do_upload('userfile'))
        {
            redirect(base_url().'attendance');
            
        }
        else
        {
            $data = array('error' => false);
            $upload_data = $this->upload->data();

            $this->load->library('excel_reader');
            $this->load->helper('file');
            $this->excel_reader->setOutputEncoding('CP1251');

            $file =  $upload_data['full_path'];
            $this->excel_reader->read($file);

            // Sheet 1
            $data = $this->excel_reader->sheets[0] ;
            $dataexcel = Array();
            for ($i = 1; $i <= $data['numRows']; $i++) {
                if($data['cells'][$i][1] == '') break;
                $dataexcel[$i-1]['nik'] = $data['cells'][$i][1];
                $dataexcel[$i-1]['actual_in'] = $data['cells'][$i][2];
                $dataexcel[$i-1]['actual_out'] = $data['cells'][$i][3];
            }
                        
                        
            delete_files($upload_data['file_path']);
            
            $data_import = array();
            for($i=0;$i<count($dataexcel);$i++){
                $data_import[] = array(
                    'id_employee'=>$dataexcel[$i]['nik'],
                    'attendance_date'=>$tanggal,
                    'actual_in'=>$dataexcel[$i]['actual_in'],
                    'actual_out'=>$dataexcel[$i]['actual_out'],
                    'total_time'    => $dataexcel[$i]['actual_out'] - $dataexcel[$i]['actual_in'],
                    'created_by'=> $user_id,
                    'created_date'  => date('Y-m-d')
                );  
                
            }
            $this->db->insert_batch('attendance',$data_import); 
            $this->session->set_flashdata("notifikasi", "<div class=\"col-md-4\"><div class=\"alert alert-success\" id=\"alert\">Data successfully import !!</div></div>");
            redirect(base_url().'attendance');
        } 
    }

    function delete_data($id_attendance){
        $this->db->where('id_attendance', $id_attendance);
        $this->db->delete('attendance');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("attendance");
    }
}