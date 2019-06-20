<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "home"); //mensetting menuKepilih atau menu aktif
        $this->session->set_flashdata("logas", "staff"); //mensetting menuKepilih atau menu aktif
    }

    public function index($tab='')
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_division = $this->session->userdata('id_division');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $nama_jabatan = $this->session->userdata('position');
        $data_divisi = $this->db->query("SELECT * FROM division WHERE id_division!='$id_division' ORDER BY division_name ASC")->result();
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        if($data_employee){
            $id_division = $data_employee[0]->id_division;
            $jabatan = $data_employee[0]->id_position;
            $jumlah_permit = $data_employee[0]->total_permit;    
            $permit_terpakai = $this->db->query("SELECT sum(total_days) as td FROM permit WHERE id_employee='$user_id' and status='1'")->result();
            if($permit_terpakai){
                $total_terpakai = $permit_terpakai[0]->td;
            }else{
                $total_terpakai = 0;
            }
            
        }else{
            $id_division = '';
            $jabatan = 3;
            $jumlah_permit = 0;
            $total_terpakai = 0;
        }

        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_cuti = $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' ORDER BY id_permit DESC")->result();
        //jika staff
        $get_level = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
        $level = $get_level[0]->level;
        /*if($id_jabatan==5){
            $data_tugas = $this->db->query("SELECT * FROM tugas WHERE untuk_bawahan='$user_id' ORDER BY id_tugas DESC")->result();   
        }elseif($id_jabatan==4){ //jika manager
            $data_tugas = $this->db->query("SELECT * FROM tugas WHERE untuk_divisi_lain='$id_division' ORDER BY id_tugas DESC")->result();   
        }*/
        if($level==1){
            $today = date('Y-m-d');
            $data_tugas = $this->db->query("SELECT * FROM tugas WHERE untuk_bawahan='$user_id' ORDER BY id_tugas DESC")->result();
            $todolist_on = $this->db->query("SELECT * FROM todolist WHERE id_employee='$user_id' AND status='0' AND created_date!='$today' GROUP BY keterangan")->result();
            $upmanager = '0';   
        }elseif($level==2){ //jika manager
            $data_tugas = $this->db->query("SELECT * FROM tugas WHERE untuk_divisi_lain='$id_division' ORDER BY id_tugas DESC")->result();
            $todolist_on = $this->db->query("SELECT * FROM todolist WHERE id_employee='$user_id' AND status='0' GROUP BY keterangan")->result();  
            $upmanager = '0'; 
        }else{
            $data_tugas='';
            $todolist_on = '';
            $upmanager = '1';
        }
        
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'id_division'   => $id_division,
            'nama_jabatan'   => $nama_jabatan,
            'id_jabatan'     => $id_jabatan,   
            'id_employee'   => $user_id,
            'data_divisi'   => $data_divisi,
            'data_tugas'    => $data_tugas,
            'user_id'       => $user_id,
            'todolist_on'   => $todolist_on,
            'tab'   => $tab,
            'upmanager'     => $upmanager
        );
        $this->template->load('template','index/index',$data);
    }

    public function hapus_todolist($id_todo){

        $this->db->where('id_todolist',$id_todo);
        $this->db->delete('todolist');

        redirect('index/');
    }

    function data_todo(){
        $jum = $this->input->get('option');
        if($jum > 0){
            for($i=1;$i<$jum;$i++){
                $no=$i+1;
            echo '<br>
                    <input type="hidden" value="'.$no.'" name="jum_todolist">
                    <div class="input-group">
                    <input style="margin:0 20px 0 0" type="text" class="form-control" name="todo'.$no.'" id="exampleInputuname">
                    <div class="input-group-addon"><i class="ti">'.$no.'</i></div>
                    </div>';
              }
        }
    }

    function data_todo_dalam(){
        $keterangan = $this->input->get('option');
        $data = array(
            'status'    => 0,
            'updated_date'  => date('Y-m-d')
        );
        $this->db->where('id_todolist',$keterangan);
        $this->db->update('todolist',$data);
    }

    function data_todo_selesai(){
        $keterangan = $this->input->get('option');
        $data = array(
            'status'    => 1,
            'updated_date'  => date('Y-m-d')
        );
        $this->db->where('id_todolist',$keterangan);
        $this->db->update('todolist',$data);
    }

    function data_tugas_dalam(){
        $tugas = $this->input->get('option');
        $data = array(
            'status'    => 0,
            'updated_date'  => date('Y-m-d'),
            'finished_date'  => '0000-00-00'
        );
        $this->db->where('id_tugas',$tugas);
        $this->db->update('tugas',$data);
    }

    function data_tugas_selesai(){
        $tugas = $this->input->get('option');
        $data = array(
            'status'    => 1,
            'updated_date'  => date('Y-m-d'),
            'finished_date'  => date('Y-m-d')
        );
        $this->db->where('id_tugas',$tugas);
        $this->db->update('tugas',$data);

        $data_tugas = $this->db->query("SELECT * FROM tugas WHERE id_tugas='$tugas'")->result();
        $id_atasan = $data_tugas[0]->created_by;
        $id_bawahan = $data_tugas[0]->untuk_bawahan;
        $get_atasan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_atasan'")->result();
        $get_bawahan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_bawahan'")->result();
        $email_atasan = $get_atasan[0]->email_test;
        $message .= '<html><head>
                          <meta name="viewport" content="width=device-width, initial-scale=1">
                          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                        </head>';
        $message .= '<body><p><img src="http://lias.ligaindonesiabaru.com/hr/lib/assets/images/logo.jpg" class="lib-logo" width="150px" /></p>';
        $message .= $get_bawahan[0]->firstname. " telah tugas dari anda :<br>";
        $message .= "Nama tugas : ".$data_tugas[0]->tugas."<br>";
            require_once('phpmailer/class.phpmailer.php');
     
        $mail = new PHPMailer(); 
        $mail->From     = 'admin@ligaindonesiabaru.com';
        $mail->FromName = 'PT. LIGA INDONESIA BARU';
        $mail->IsSMTP(); 
        $mail->SMTPAuth = true; 
        $mail->Username = 'admin@ligaindonesiabaru.com'; //username email 
        $mail->Password = 'admlib2017'; //password email 
        $mail->SMTPSecure = "ssl";
        $mail->Host ='smtp.gmail.com'; 
        $mail->Port = 465; //port secure ssl email 
        $mail->IsHTML(true);
        $mail->Subject = 'Penyelesain tugas'; 
        $mail->Body = $message; 
        $mail->AddAddress($email_atasan);
        $mail->Send();
    }

    public function add_todo($id_employee,$jumlah_todo_on){

        $jum = $this->input->post('jum_todolist');
        if($jum==''){
            $jm = 1;
        }else{
            $jm = $jum;
        }
        for($i=1; $i<=$jm; $i++){
            $todo[$i] = $this->input->post("todo$i");
            $data[$i] = array(
                'id_employee'   => $id_employee,
                'keterangan'    => $todo[$i],
                'status'        => 0,
                'created_date'  => date('Y-m-d')
            );
            if($todo[$i]!=''){
                $this->db->insert('todolist',$data[$i]);
            }    
        }

        if($jumlah_todo_on>0){
            for($i=1; $i<=$jumlah_todo_on; $i++){
                if(isset($_POST["$i"])){
                    $data2[$i] = array(
                        'id_employee'   => $id_employee,
                        'keterangan'    => $this->input->post("$i"),
                        'status'        => 0,
                        'created_date'  => date('Y-m-d')
                    );

                    $this->db->insert('todolist',$data2[$i]);           
                }
            }
        }
        redirect('index/');
    }

    public function todo($status,$id_todo){
        $data = array(
            'status'    => $status
        );

        $this->db->where('id_todolist',$id_todo);
        $this->db->update('todolist',$data);

        redirect('index/');
    }

    public function tugas($status,$id_tugas){
        $data = array(
            'status'    => $status,
            'updated_date' => date('Y-m-d'),
        );

        $this->db->where('id_tugas',$id_tugas);
        $this->db->update('tugas',$data);

        redirect('index/');
    }

    public function see_tugas($id_tugas){
        $data = array(
            'click_status'    => 1
        );

        $this->db->where('id_tugas',$id_tugas);
        $this->db->update('tugas',$data);

        redirect('index/');
    }

    public function see_tugas2($id_tugas){
        $data = array(
            'click_status2'    => 1
        );

        $this->db->where('id_tugas',$id_tugas);
        $this->db->update('tugas',$data);

        redirect('index/');
    }

    public function joblist($status,$id_joblist){
        $data = array(
            'status'    => $status
        );

        $this->db->where('id_joblist',$id_joblist);
        $this->db->update('joblist',$data);

        redirect('index/index/2');
    }

    public function update_profile($id_employee){
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
        $data = array(
            'firstname'    => $this->input->post('nama'),
            'email'    => $this->input->post('email'),
            'phone'    => $this->input->post('handphone'),
            'marital_status'    => $this->input->post('status_perkawinan'),
            'religion'    => $this->input->post('agama'),
            'address'    => $this->input->post('alamat'),
            'image'             => $image,
        );

        $this->db->where('id_employee',$id_employee);
        $this->db->update('employee',$data);

        redirect('index/index/4');
    }

    public function add_edit_tugas($id_tugas=''){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_tugas==''){
            $save = $this->input->post('save');
            if(isset($save)){
                $division = $this->input->post('division');
                $bawahan = $this->input->post('bawahan');
                $batas_waktu = date("Y-m-d", strtotime($this->input->post('batas_waktu')));

                if(empty($division) && empty($bawahan)){
                    redirect('index');
                }else{
                    $data = array(
                        'tugas'               => $this->input->post('tugas'),
                        'batas_waktu'         => $batas_waktu,
                        'untuk_bawahan'       => $bawahan,
                        'untuk_divisi_lain'   => $division,
                        'created_by'          => $user_id,
                        'created_date'        => date('Y-m-d'),
                    );
                    $this->db->insert('tugas', $data);
                    if($this->db->affected_rows()!=0){
                        
                        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                        redirect("index");
                    }
                }
            }
        }else{
            $save = $this->input->post('save');
            if(isset($save)){
                $data = array(
                    'nama_jabatan'   => $this->input->post('nama_jabatan'),
                    'level'   => $this->input->post('level'),
                    'status'   => $this->input->post('status'),
                );
                    
                $this->db->where('id_jabatan', $id_jabatan);
                $this->db->update('jabatan', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("jabatan");
                }
            }
            $data = array(
                'title' => 'Perbarui Jabatan',
                'id_jabatan' => $id_jabatan,
                'user_role_data'    => $user_role_data,
                'user' => $user,
                'data_jabatan'  => $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result(),
            );
            $this->template->load('template','jabatan/add_jabatan',$data);
        }
    }
}