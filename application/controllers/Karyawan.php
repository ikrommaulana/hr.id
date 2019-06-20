<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "karyawan"); //mensetting menuKepilih atau menu aktif
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_request' => $this->db->query("SELECT * FROM recruitment_request WHERE created_by='$user_id'")->result()
        );
        $this->template->load('template','karyawan/index',$data);
    }

    function karyawan(){
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
            'user'              => $user
        );

        $this->template->load('template','karyawan/karyawan',$data);
    }

    function detail($id_request){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        $data_request = $this->db->query("SELECT * FROM recruitment_request WHERE id_recruitment_request='$id_request'")->result();
        $data_approve = $this->db->query("SELECT * FROM recrutment_request_approve WHERE id_recruitment_request='$id_request'")->result();
        $id_requestor = $data_request[0]->created_by;
        $id_position_request = $data_request[0]->position;
        $data_posisi = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_position_request'")->result();

        $data_requestor = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_requestor'")->result();
        if($data_requestor){
            $id_jabatan_requestor = $data_requestor[0]->id_position;
            $id_division = $data_requestor[0]->id_division;
        }else{
            $id_jabatan_requestor = 0;
            $id_division = 0;
        }
        $jabatan_requestor = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan_requestor'")->result();
        if($jabatan_requestor){
            $jabatan = $jabatan_requestor[0]->nama_jabatan;
        }else{
            $jabatan = '-';
        }
        $dept_requestor = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
        if($dept_requestor){
            $dept = $dept_requestor[0]->division_name;
        }else{
            $dept = '-';
        }
        if($data_approve[0]->status==0){
            $status = 'Menunggu Persetujuan';
            $tgl_diputuskan = 0;
        }elseif($data_approve[0]->status==2){
            $status = 'Tidak Disetujui';
            $tgl_diputuskan = $data_approve[0]->updated_date;
        }else{
            $status = 'Telah Disetujui';
            $tgl_diputuskan = $data_approve[0]->updated_date;
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_request'      => $data_request,
            'data_requestor'    => $data_requestor,
            'status'            => $status,
            'tgl_diputuskan'    => $tgl_diputuskan,
            'id_employee_login'  => $user_id,
            'id_approver'       => $data_approve,
            'data_approver'     => $data_approve,
            'jabatan'           => $jabatan,
            'division'          => $dept,
            'posisi'            => $data_posisi[0]->nama_jabatan
        );

        $this->template->load('template','karyawan/detail',$data);
    }

    public function add_edit_data($id_recruitment_request=''){
        $user_id = $this->session->userdata('user_id');
        
        if($id_recruitment_request==''){
            $get_id_request = $this->db->query("SELECT * FROM recruitment_request ORDER BY id_recruitment_request DESC")->result();
            if($get_id_request){
                $new_id_recruitment_request = $get_id_request[0]->id_recruitment_request + 1;    
            }else{
                $new_id_recruitment_request = 1;
            }
            
            $data = array(
                'id_recruitment_request'    => $new_id_recruitment_request,
                'recruit_total'     => $this->input->post('jumlah'),
                'requirement'       => $this->input->post('persyaratan'),
                'position'          => $this->input->post('posisi'),
                'id_division'       => $this->input->post('departemen'),
                'status_kerja'      => $this->input->post('status_kerja'),
                'budget'            => $this->input->post('budget'),
                'salary'            => $this->input->post('salary'),
                'created_date'      => date('Y-m-d'),
                'created_by'        => $user_id
            );
            $this->db->insert('recruitment_request', $data);

            $data_jabatan = $this->db->query("SELECT * FROM jabatan WHERE status='1' ORDER BY level DESC")->result();
            $id_jabatan_last = $data_jabatan[0]->id_jabatan;
            $get_approver = $this->db->query("SELECT * FROM employee WHERE id_position='$id_jabatan_last'")->result();

            foreach($get_approver as $view){
                $data_approve = array(
                    'id_recruitment_request'    => $new_id_recruitment_request,
                    'id_approver'               => $view->id_employee,
                    'status'                    => 0
                );
                $this->db->insert('recrutment_request_approve', $data_approve);                
            }
            if($this->db->affected_rows()!=0){
                
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                redirect("karyawan");
            }
        }else{
            $data = array(
                'recruit_total'     => $this->input->post('jumlah'),
                'requirement'       => $this->input->post('persyaratan'),
                'position'          => $this->input->post('posisi'),
                'id_division'       => $this->input->post('departemen'),
                'status_kerja'      => $this->input->post('status_kerja'),
                'budget'            => $this->input->post('budget'),
                'salary'            => $this->input->post('salary'),
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => $user_id
            );
                
            $this->db->where('id_recruitment_request', $id_recruitment_request);
            $this->db->update('recruitment_request', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("karyawan");
            }
        }
    }

    function delete_data($id_recruitment_request){
        $this->db->where('id_recruitment_request', $id_recruitment_request);
        $this->db->delete('recruitment_request');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("recruitment_request");
    }

    function approve_pengajuan($id_recruitment_request){
        $user_id = $this->session->userdata('user_id');
        $setuju = $this->input->post('setuju');
        $tidak_setuju = $this->input->post('tidak_setuju');
        if(isset($setuju)){
            $data = array(
                'status'            => 1,
                'updated_date'      => date('Y-m-d'),
            );    
        }else{
            $data = array(
                'status'            => 2,
                'updated_date'      => date('Y-m-d'),
            );
        }
    
        $this->db->where('id_recruitment_request',$id_recruitment_request);
        $this->db->where('id_approver',$user_id);
        $this->db->update('recrutment_request_approve',$data);

        if($this->db->affected_rows()!=0){
            redirect("karyawan");
        }
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("karyawan");
    }

    function setup(){
        $this->session->set_flashdata("halaman", "setup"); //mensetting menuKepilih atau menu aktif
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
            'user'              => $user
        );

        $this->template->load('template','permit/setup',$data);
    }

    function data_approval(){
        $jum = $this->input->get('option');
        $data_approve = $this->db->query("SELECT * FROM jabatan ORDER BY nama_jabatan ASC")->result();
        if($jum > 0){
                //echo $jum;
                echo "<div class='row-fluid'>";
                echo "<div class='span3'></div>
                      <div class='span6'>";
                            for($i=1;$i<=$jum;$i++){
                                    echo "<label>Level ".$i."</label>
                                        <select name='approv[]' id='app_$i' style='width:100%'>
                                        <option value=''>- Choose Approve by -</option>";
                                        foreach($data_approve as $view){
                                            echo "<option value='".$view->id_jabatan."'>".$view->nama_jabatan."</option>";
                                        }
                                    echo "</select>";
                            }
                echo "</div>
                      <div class='span3'></div>";
            
            echo "</div>
                  <div class='row-fluid'>
                      <div class='span3'></div>
                      <div class='span9'>
                            <button type='submit' name='save' class='btn btn-success' style='width:150px'>Save</button>
                      </div>
                  </div><br><br>";
        }
    }

    function set_approval(){
        $user_id      = $this->session->userdata('user_id');
        $approv       = $this->input->post('approv');
        $jum          = $this->input->post('approval');
        for($i=0;$i<$jum;$i++){
            $data = array(
                'id_jabatan'        => $approv[1],
                'level'             => $i+1
            );
            $this->db->insert('permit_approval', $data);
        }
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully approved !!</div>");
        redirect("permit");
    }
}