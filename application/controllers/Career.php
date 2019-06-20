<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Career extends CI_Controller {

    public function index()
    {
        $data = array(
            'data_career' =>$this->db->query("SELECT * FROM recruitment_request WHERE status='Processing' ORDER BY id_recruitment_request DESC")->result()
        );
        $this->load->view('career/index',$data);
    }

    public function apply($id_recruitment_request)
    {
        $data = array(
            'id_recruitment_request' =>$id_recruitment_request
        );
        $this->load->view('career/apply',$data);
    }

    public function submit()
    {
        $email = $this->input->post('email');
        $id_recruitment_request = $this->input->post('id_recruitment_request');
        $getData = $this->db->query("SELECT * FROM recruitment_request WHERE id_recruitment_request='$id_recruitment_request'")->result();
        $id_division = $getData[0]->id_division;
        $id_position = $getData[0]->position;
        $cek_available = $this->db->query("SELECT * FROM calon_karyawan WHERE email='$email' and id_division='$id_division' and id_jabatan='$id_position'")->result();
        if(!$cek_available){
            $this->load->library('upload');
            $nmfile = "cv".time(); //nama file saya beri nama langsung dan diikuti fungsi time
            $config['upload_path'] = './cv/'; //path folder
            $config['allowed_types'] = 'xls|pdf'; //type yang dapat diakses bisa anda sesuaikan
            $config['max_size'] = '10096'; //maksimum besar file 5M
            $config['file_name'] = $nmfile; //nama yang terupload nantinya
             
            $this->upload->initialize($config);
            if ($this->upload->do_upload('userfile')){
                $gbr    = $this->upload->data();
                $cv  = $gbr['file_name'];
            }else{
                $cv = '';
            }

            
            $data = array(
                'firstname' =>$this->input->post('firstname'),
                'lastname' =>$this->input->post('lastname'),
                'email' =>$this->input->post('email'),
                'id_jabatan' =>$getData[0]->position,
                'id_division' =>$getData[0]->id_division,
                'cv'    => $cv,
                'status'    => 'Waiting',
                'created_date'  => date('Y-m-d')
            );
            $this->db->insert('calon_karyawan',$data);
            if($this->db->affected_rows()!=0){        
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Your CV successfully submit !!</div>");
                redirect("career");
            }
        }else{
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Your CV already submit !!</div>");
                redirect("career");
        }
    }
}