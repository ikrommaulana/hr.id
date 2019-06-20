<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privileges extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "privileges"); //mensetting menuKepilih atau menu aktif
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
            'data_privileges' =>$this->db->query("SELECT * FROM privileges ORDER BY id_privileges DESC")->result(),
            
        );
        $this->template->load('template','user/privileges/index',$data);
    }

    public function add_edit_data($id_privileges){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }

        if($id_privileges==0){
            $save = $this->input->post('save');
            if(isset($save)){
                $data_privileges = $this->db->query("SELECT * FROM privileges ORDER BY id_privileges DESC")->result();
                if($data_privileges){
                    $id_privileges_new = $data_privileges[0]->id_privileges + 1;    
                }else{
                    $id_privileges_new = 1;
                }
                
                $data = array(
                    'id_privileges' => $id_privileges_new,
                    'privileges_name'   => $this->input->post('privileges_name'),
                    'status'   => $this->input->post('status'),
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );

                $data2 = array(
                    'id_privileges'             => $id_privileges_new,
                    'view_employee'             => $this->input->post('view_employee'),
                    'create_employee'           => $this->input->post('create_employee'),
                    'update_employee'           => $this->input->post('update_employee'),
                    'delete_employee'           => $this->input->post('delete_employee'),
                    'view_division'             => $this->input->post('view_division'),
                    'create_division'           => $this->input->post('create_division'),
                    'update_division'           => $this->input->post('update_division'),
                    'delete_division'           => $this->input->post('delete_division'),
                    'view_permit'               => $this->input->post('view_permit'),
                    'create_permit'             => $this->input->post('create_permit'),
                    'update_permit'             => $this->input->post('update_permit'),
                    'delete_permit'             => $this->input->post('delete_permit'),
                    'view_event'                => $this->input->post('view_event'),
                    'create_event'              => $this->input->post('create_event'),
                    'update_event'              => $this->input->post('update_event'),
                    'delete_event'              => $this->input->post('delete_event'),
                    'view_document'             => $this->input->post('view_document'),
                    'create_document'           => $this->input->post('create_document'),
                    'update_document'           => $this->input->post('update_document'),
                    'delete_document'           => $this->input->post('delete_document'),
                    'download_document'         => $this->input->post('download_document'),
                    'view_recruitment'             => $this->input->post('view_recruitment'),
                    'create_recruitment'           => $this->input->post('create_recruitment'),
                    'update_recruitment'           => $this->input->post('update_recruitment'),
                    'delete_recruitment'           => $this->input->post('delete_recruitment'),
                    'download_recruitment'         => $this->input->post('download_recruitment'),
                    'view_payroll'               => $this->input->post('view_payroll'),
                    'create_payroll'             => $this->input->post('create_payroll'),
                    'update_payroll'             => $this->input->post('update_payroll'),
                    'delete_payroll'             => $this->input->post('delete_payroll'),
                    'view_room'                 => $this->input->post('view_room'),
                    'create_room'               => $this->input->post('create_room'),
                    'update_room'               => $this->input->post('update_room'),
                    'delete_room'               => $this->input->post('delete_room'),
                    'booking_room'              => $this->input->post('booking_room'),
                    'view_user'                 => $this->input->post('view_user'),
                    'create_user'               => $this->input->post('create_user'),
                    'update_user'               => $this->input->post('update_user'),
                    'delete_user'               => $this->input->post('delete_user'),
                    'view_attendance'           => $this->input->post('view_attendance'),
                    'view_detail_attendance'    => $this->input->post('view_detail_attendance'),
                    'create_attendance'         => $this->input->post('create_attendance'),
                    'update_attendance'         => $this->input->post('update_attendance'),
                    'delete_attendance'         => $this->input->post('delete_attendance'),
                    'import_attendance'         => $this->input->post('import_attendance'),
                    'export_attendance'         => $this->input->post('export_attendance'),
                );

                $this->db->insert('privileges', $data);
                $this->db->insert('privileges_status', $data2);
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("privileges");
                }else{
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Data failed added !!</div>");
                    redirect("privileges");
                }
            }

            $data = array(
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'id_privileges' => ''
                
            );
            $this->template->load('template','user/privileges/add_privileges',$data);    
        }else{
            $edit= $this->input->post('edit');

            if(isset($edit)){
                $data = array(
                    'privileges_name'   => $this->input->post('privileges_name'),
                    'status'   => $this->input->post('status'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => 1
                );

                $data2 = array(
                        'view_employee'             => $this->input->post('view_employee'),
                        'create_employee'           => $this->input->post('create_employee'),
                        'update_employee'           => $this->input->post('update_employee'),
                        'delete_employee'           => $this->input->post('delete_employee'),
                        'view_division'             => $this->input->post('view_division'),
                        'create_division'           => $this->input->post('create_division'),
                        'update_division'           => $this->input->post('update_division'),
                        'delete_division'           => $this->input->post('delete_division'),
                        'view_permit'               => $this->input->post('view_permit'),
                        'create_permit'             => $this->input->post('create_permit'),
                        'update_permit'             => $this->input->post('update_permit'),
                        'delete_permit'             => $this->input->post('delete_permit'),
                        'view_event'                => $this->input->post('view_event'),
                        'create_event'              => $this->input->post('create_event'),
                        'update_event'              => $this->input->post('update_event'),
                        'delete_event'              => $this->input->post('delete_event'),
                        'view_document'             => $this->input->post('view_document'),
                        'create_document'           => $this->input->post('create_document'),
                        'update_document'           => $this->input->post('update_document'),
                        'delete_document'           => $this->input->post('delete_document'),
                        'download_document'         => $this->input->post('download_document'),
                        'view_recruitment'             => $this->input->post('view_recruitment'),
                        'create_recruitment'           => $this->input->post('create_recruitment'),
                        'update_recruitment'           => $this->input->post('update_recruitment'),
                        'delete_recruitment'           => $this->input->post('delete_recruitment'),
                        'download_recruitment'         => $this->input->post('download_recruitment'),
                        'view_payroll'               => $this->input->post('view_payroll'),
                        'create_payroll'             => $this->input->post('create_payroll'),
                        'update_payroll'             => $this->input->post('update_payroll'),
                        'delete_payroll'             => $this->input->post('delete_payroll'),
                        'view_room'                 => $this->input->post('view_room'),
                        'create_room'               => $this->input->post('create_room'),
                        'update_room'               => $this->input->post('update_room'),
                        'delete_room'               => $this->input->post('delete_room'),
                        'booking_room'              => $this->input->post('booking_room'),
                        'view_user'                 => $this->input->post('view_user'),
                        'create_user'               => $this->input->post('create_user'),
                        'update_user'               => $this->input->post('update_user'),
                        'delete_user'               => $this->input->post('delete_user'),
                        'view_attendance'           => $this->input->post('view_attendance'),
                        'view_detail_attendance'    => $this->input->post('view_detail_attendance'),
                        'create_attendance'         => $this->input->post('create_attendance'),
                        'update_attendance'         => $this->input->post('update_attendance'),
                        'delete_attendance'         => $this->input->post('delete_attendance'),
                        'import_attendance'         => $this->input->post('import_attendance'),
                        'export_attendance'         => $this->input->post('export_attendance'),
                    );
                    
                $this->db->where('id_privileges', $id_privileges);
                $this->db->update('privileges', $data);
                if($this->db->affected_rows()!=0){
                    $status_update1 = 1;
                }
                $this->db->where('id_privileges', $id_privileges);
                $this->db->update('privileges_status', $data2);
                if($this->db->affected_rows()!=0){
                    $status_update2 = 1;
                }
                if($status_update1!=0 || $status_update2!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("privileges");
                }else{
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Data failed updated !!</div>");
                    redirect("privileges");
                }
            }
            $data = array(
                'data_privileges' => $this->db->query("SELECT * FROM privileges a, privileges_status b WHERE a.id_privileges='$id_privileges' and a.id_privileges=b.id_privileges")->result(),
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'id_privileges' => $id_privileges
            );

                $this->template->load('template','user/privileges/add_privileges',$data);
        }
    }

    function delete_data($id_privileges){
        $this->db->where('id_privileges', $id_privileges);
        $this->db->delete('privileges');

        $this->db->where('id_privileges', $id_privileges);
        $this->db->delete('privileges_status');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("privileges");
    }
}