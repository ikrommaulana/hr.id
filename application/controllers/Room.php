<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Room extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "room"); //mensetting menuKepilih atau menu aktif
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
            'data_meeting_room' =>$this->db->query("SELECT * FROM meeting_room ORDER BY id_meeting_room DESC")->result()
        );
        $this->template->load('template','room/index',$data);
    }

    public function add_edit_data($id_meeting_room=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        if($id_meeting_room==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'room_name'   => $this->input->post('room_name'),
                    'capacity'   => $this->input->post('capacity'),
                    'facility'   => $this->input->post('facility'),
                    'status'   => 1,
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );
                $this->db->insert('meeting_room', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("room");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Tambah Ruang Meeting',
                'id_meeting_room' => $id_meeting_room,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_room' => ''
            );
            $this->template->load('template','room/booking',$data);
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'room_name'   => $this->input->post('room_name'),
                    'capacity'   => $this->input->post('capacity'),
                    'facility'   => $this->input->post('facility'),
                    'status'   => $this->input->post('status'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_meeting_room', $id_meeting_room);
                $this->db->update('meeting_room', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("room");
                }
            }
            $data = array(
                'role_id' => $admin_role,
                'title' => 'Perbarui Ruang Meeting',
                'id_meeting_room' => $id_meeting_room,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_room' => $this->db->query("SELECT * FROM meeting_room WHERE id_meeting_room='$id_meeting_room'")->result()
            );
            $this->template->load('template','room/booking',$data);
        }
    }

    public function delete_data($id_meeting_room){
        $this->db->where('id_meeting_room', $id_meeting_room);
        $this->db->delete('meeting_room');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("room");
    }

    public function booking()
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
            'data_meeting_room_booking' =>$this->db->query("SELECT * FROM meeting_room_booking a, division b, meeting_room c WHERE a.id_division=b.id_division AND a.id_meeting_room=c.id_meeting_room ORDER BY a.id_meeting_room_booking DESC")->result(),
            'room_data' => $this->db->query("SELECT * FROM meeting_room ORDER BY room_name ASC")->result(),
        );
        $this->template->load('template','room/booking',$data);
    }

    public function add_edit_data_booking($id_meeting_room){
        $user_id = $this->session->userdata('user_id');
        $id_meeting_room_booking = $this->input->post('id_meeting_room_booking');
        
        if($id_meeting_room_booking==''){
            $meeting_date = $this->input->post('meeting_date');
            $meeting_start = $this->input->post('meeting_start');
            $meeting_end = $this->input->post('meeting_end');
            $meeting_room = $this->input->post('id_meeting_room');
            $data = array(
                'id_meeting_room' => $meeting_room,
                'id_division'   => $this->input->post('id_division'),
                'meeting_date'   => $meeting_date,
                'meeting_start'   => $meeting_start,
                'meeting_end'   => $meeting_end,
                'created_date'  => date('Y-m-d'),
                'created_by'    => $user_id
            );

            $cek_available = $this->db->query("SELECT * FROM meeting_room_booking WHERE meeting_date='$meeting_date' AND meeting_start<='$meeting_start' AND meeting_end>='$meeting_start' or meeting_start<='$meeting_end' AND meeting_end>='$meeting_end'")->result();
            if(!$cek_available){
                $this->db->insert('meeting_room_booking', $data);
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("room/booking/$id_meeting_room");
                }    
            }else{
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Data failed added, meeting room unavailable !!</div>");
                redirect("room/booking/$id_meeting_room");
            }
            
        }else{
            $data = array(
                'id_division'   => $this->input->post('id_division'),
                'meeting_date'   => $this->input->post('meeting_date'),
                'meeting_start'   => $this->input->post('meeting_start'),
                'meeting_end'   => $this->input->post('meeting_end'),
                'updated_date'  => date('Y-m-d'),
                'updated_by'    => 1
            );
                
            $this->db->where('id_meeting_room_booking', $id_meeting_room_booking);
            $this->db->update('meeting_room_booking', $data);
    
            if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                redirect("room/booking/$id_meeting_room");
            }
        }
    }

    public function delete_data_booking($id_meeting_room_booking,$id_meeting_room){
        $this->db->where('id_meeting_room_booking', $id_meeting_room_booking);
        $this->db->delete('meeting_room_booking');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("room/booking/$id_meeting_room");
    }
}