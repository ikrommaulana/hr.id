<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piket extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "piket"); //mensetting menuKepilih atau menu aktif
        require_once("PHPMailer/PHPMailerAutoload.php");
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
            'data_piket' => $this->db->query("SELECT * FROM piket WHERE id_employee='$user_id'")->result(),
            'jumlah_piket' => $this->db->query("SELECT sum(total_days) as jml FROM piket a, piket_approve b WHERE a.id_employee='$user_id' AND b.id_piket=a.id_piket AND b.status='1' AND b.status_batal='0'")->result()
        );
        $this->template->load('template','piket/index',$data);
    }

    function daftar(){
        $this->session->set_flashdata("halaman", "daftar"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $gender = $this->session->userdata('gender');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket=b.id_piket AND b.id_approver='$user_id' order by a.start_date desc")->result();
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_piket'         => $data_piket
        ); 

        $this->template->load('template','piket/daftar',$data);
    }

    function rekap_(){
        $this->session->set_flashdata("halaman", "daftar"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b, piket_approve_dana c, employee d WHERE a.id_piket=b.id_piket AND a.id_piket=c.id_piket AND a.id_employee=d.id_employee group by a.id_piket order by d.firstname ASC")->result();
        //approved dana all
        //$data_piket = $this->db->query("SELECT * FROM piket a,piket_approve b,piket_approve_dana c,employee d WHERE a.id_piket=b.id_piket and b.status='1' and a.id_piket=c.id_piket and a.id_employee=d.id_employee group by a.id_piket")->result();  
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_piket'         => $data_piket,
            'user_id'           => $user_id
         );

        $this->template->load('template','piket/rekap',$data);
    }

    function rekap(){
        $filter = $this->input->post('filter');
        if(isset($filter)){
            $daterange = $this->input->post('tanggal');
            $date   = explode(' - ', $daterange);
            $start  = date('Y-m-d', strtotime($date[0]));
            $end    = date('Y-m-d', strtotime($date[1]));
            $start2  = date('m/d/Y', strtotime($date[0]));
            $end2    = date('m/d/Y', strtotime($date[1]));
            $status = $this->input->post('status');

            if($status==0){//smua data piket
                $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b, piket_approve_dana c, employee d WHERE a.id_piket=b.id_piket AND a.id_piket=c.id_piket AND (a.start_date>='$start' AND a.end_date<='$end') AND a.id_employee=d.id_employee group by a.id_piket order by d.firstname ASC")->result();    
            }elseif($status==1){//data piket belum diapprove dana
                $data_piket_blm_approve = $this->db->query("SELECT * FROM piket a, piket_approve b, piket_approve_dana c, employee d WHERE a.id_piket=b.id_piket AND a.id_piket=c.id_piket AND c.status='0' AND (a.start_date>='$start' AND a.end_date<='$end') AND a.id_employee=d.id_employee group by a.id_piket order by d.firstname ASC")->result();
                if($data_piket_blm_approve){
                    $data_piket = $data_piket_blm_approve;
                }else{
                    $data_piket = '';
                }
            }else{//data piket sudah diaprove dana
                $data_piket_blm_approve = $this->db->query("SELECT * FROM piket a, piket_approve b, piket_approve_dana c, employee d WHERE a.id_piket=b.id_piket AND a.id_piket=c.id_piket AND c.status='0' AND (c.approve_date>='$start' AND c.approve_date<='$end') AND a.id_employee=d.id_employee group by a.id_piket order by d.firstname ASC")->result();
                $data_piket_sdh_approve = $this->db->query("SELECT * FROM piket a, piket_approve b, piket_approve_dana c, employee d WHERE NOT EXISTS(SELECT * FROM piket_approve_dana e where a.id_piket=e.id_piket and e.status='0' group by e.status desc) AND a.id_piket=b.id_piket AND a.id_piket=c.id_piket AND c.status='1' AND (c.approve_date>='$start' AND c.approve_date<='$end') AND a.id_employee=d.id_employee group by a.id_piket order by d.firstname ASC")->result();
                if($data_piket_blm_approve){
                    $data_piket = $data_piket_sdh_approve; 
                }else{
                    $data_piket = $data_piket_sdh_approve;
                }
            }
            
        }else{
            $status = '';
            $start = date('Y-m-d');
            $end = date('Y-m-d');
            $start2 = date('m/d/Y');
            $end2 = date('m/d/Y');

            $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b, piket_approve_dana c, employee d WHERE a.id_piket=b.id_piket AND a.id_piket=c.id_piket AND a.id_employee=d.id_employee group by a.id_piket order by d.firstname ASC")->result();
        }
        $this->session->set_flashdata("halaman", "daftar"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        
        //approved dana all
        //$data_piket = $this->db->query("SELECT * FROM piket a,piket_approve b,piket_approve_dana c,employee d WHERE a.id_piket=b.id_piket and b.status='1' and a.id_piket=c.id_piket and a.id_employee=d.id_employee group by a.id_piket")->result();  
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_piket'         => $data_piket,
            'tanggal_start'    => $start,
            'tanggal_end'      => $end,
            'tanggal_start2'    => $start2,
            'tanggal_end2'      => $end2,
            'status'            => $status,
            'user_id'           => $user_id
         );

        $this->template->load('template','piket/rekap',$data);
    }

    function piket(){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_division = $this->session->userdata('id_division');
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
            'data_piket'        => '',
            'id_division'       => $id_division,
            'id_jabatan'        => $id_jabatan,
            'user_id'       => $user_id,
        );

        $this->template->load('template','piket/piket',$data);
    }

    function uraian(){
        $jum = $this->input->get('option');
        echo 'test';
    }

    function edit($id_piket){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_piket = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'id_jabatan'        => $id_jabatan,
            'data_piket'         => $data_piket,
            'user_id'           => $user_id
        );

        $this->template->load('template','piket/piket',$data);
    }

    function batal($id_piket){
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
            'status_batal'    => 1,
            'batal_by'        => $user_id,
            'batal_date'      => date('Y-m-d')
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket_approve',$data);

        if($this->db->affected_rows()!=0){
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permohonan berhasil dibatalkan</div>");
            redirect("piket");
        }
    }

    public function print_surat($id_piket)
    {
        $this->session->set_flashdata("halaman", "piket"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND a.id_piket=b.id_piket")->result();
        $id_employee = $data_piket[0]->id_employee;
        $id_approver = $data_piket[0]->id_approver;
        $data_employee = $this->db->query("SELECT * FROM employee a, division b WHERE a.id_employee='$id_employee' AND a.id_division=b.id_division")->result();
        $data_approver = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.id_employee='$id_approver' AND a.id_position=b.id_jabatan")->result();
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_piket'    => $data_piket,
            'data_employee' => $data_employee,
            'data_approver' => $data_approver
        );
        //$this->template->load('template','payroll/printpdf',$data);
        $html                   = $this->load->view('piket/print',$data,true);
        $pdfFilePath            = "suratpiket-".date('y-m-d').".pdf";
        $pdfFilePath            = "suratpiket.pdf";
                                  $this->load->library('m_pdf');
        $pdf                    = $this->m_pdf->load();
        $mpdf                   = new mPDF('c', 'A4-L');
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I"); 
    }

    function report($id_piket){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $token = md5(date('Ymdhis'));
        $data = array(
            'report'    => $this->input->post('report'),
            'report_date'      => date('Y-m-d'),
            'token'             => $token
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket',$data);
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND a.id_piket=b.id_piket")->result();
        $id_employee = $data_piket[0]->id_employee;
        $id_approver = $data_piket[0]->id_approver;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver'")->result();
        $email_approver = $data_approver[0]->email;
        $tanggal1 = strtotime($data_piket[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_piket[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);
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
                                    <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                        Hai, ".$data_approver[0]->firstname."
                                    </p>
                                    <p>".$data_karyawan[0]->firstname." mengajukan laporan hasil piket : </p>
                                </td>
                            </tr>
                            <tr>
                                <td valign='top' style='padding-left:20px'>
                                Tanggal
                                </td>
                                <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                            </tr>
                            <tr>
                                <td valign='top' style='padding-left:20px'>
                                Laporan
                                </td>
                                <td colspan='3'>: ".$data_piket[0]->report."</td>
                            </tr>
                            <tr height='30'></tr>
                            <tr>
                                <td colspan='3' style='padding-left:20px'>
                                    <a href='".base_url()."piket_approvel/approve_pengajuan_laporan/".$id_piket."/".$token."' class='button'>Terima Laporan</a>
                                    <a href='".base_url()."piket_approvel/tolak_pengajuan_laporan/".$id_piket."/".$token."' class='button2'>Tolak Laporan</a> 
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
                $mail->Subject = 'Laporan Hasil Piket'; 
                $mail->Body = $message; 
                $mail->AddAddress($email_approver);
                $mail->Send();

        if($this->db->affected_rows()!=0){
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Laporan berhasil disimpan</div>");
            redirect("piket");
        }
    }

    public function add_edit_data($id_piket=''){
        $user_id = $this->session->userdata('user_id');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_division = $this->session->userdata('id_division');
        $daterange = $this->input->post('tanggal');
        $date = explode(' - ', $daterange);
        $start  = date('Y-m-d', strtotime($date[0]));
        $end        = date('Y-m-d', strtotime($date[1]));

        $tanggal1 = strtotime($start); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($end); 
        $dt2 = date("d F Y  ", $tanggal2);

        $s = strtotime($start);
        $e = strtotime($end);
        $timeDiff = abs($e - $s);
        $numberDays = $timeDiff/86400;
        $numberDays1 = intval($numberDays);
        $numberDays2 = $numberDays1 + 1;

        $cek_hari_libur1 = date('D', strtotime($start));
        $cek_hari_libur2 = date('D', strtotime($end));
        $cek_tgl_merah = $this->db->query("SELECT * FROM hari_libur WHERE tanggal='$start' AND tanggal='$end'")->result();
        if($cek_tgl_merah){
            $libur = 'y';
        }else{
            $libur = 'y';
        }

        $id_employee = $this->input->post('nama');
        
        $get_approver_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_approver = (empty($get_approver_employee[0]->approver)) ? '' : $get_approver_employee[0]->approver;
        
        if($id_piket==''){
            $date_now = date('Y-m-d');
            $cek_available = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_employee='$id_employee' AND a.start_date<='$start' AND a.end_date>='$start' AND a.id_piket=b.id_piket AND b.status!='2'")->result();
            $jml_data = count($cek_available);
            if($jml_data>0){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                            window.alert('Anda telah mengajukan piket ditanggal yang sama !')
                            window.location.href='".base_url()."piket/piket';
                            </SCRIPT>");
            }elseif($libur=='n'){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Piket hanya bisa diambil dihari libur')
                        window.location.href='".base_url()."piket/piket';
                        </SCRIPT>");
            /*}elseif($date_now>$start){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Piket tidak bisa backdate !!!')
                        window.location.href='".base_url()."piket/piket';
                        </SCRIPT>");
                        */
            }else{
                $data_piket = $this->db->query("SELECT * FROM piket ORDER BY id_piket DESC")->result();
                if($data_piket){
                    $new_id_piket = $data_piket[0]->id_piket + 1;
                }else{
                    $new_id_piket = 1;
                }
                $data = array(
                    'id_piket'      => $new_id_piket,
                    'id_employee'   => $id_employee,
                    'jenis_piket'   => $this->input->post('jenis_piket'),
                    'keperluan'     => $this->input->post('keperluan'),
                    'start_date'    => $start,
                    'end_date'      => $end,
                    'total_days'    => $numberDays2,
                    'created_date'  => date('Y-m-d'),
                    'created_by'    => $user_id
                );

                if($id_employee==$user_id){
                    $status_pengajuan = 1;
                    $status_perintah = 0;
                }else{
                    $status_pengajuan = 0;
                    $status_perintah = 1;
                }

                $this->db->insert('piket', $data);
                $token = md5(date('Ymdhis'));
                if($id_approver!=''){
                    $data_approver = array(
                        'id_piket'          => $new_id_piket,
                        'id_approver'   => $id_approver,
                        'status'        => 0,
                        'status_perintah'   => $status_perintah,
                        'status_pengajuan'  => $status_pengajuan,
                        'token'         => $token
                    );
                    $this->db->insert('piket_approve',$data_approver);
                }

                if($id_employee=='10000' || $id_employee=='10006' || $id_employee=='10014' || $id_employee=='10015' || $id_employee=='10016' || $id_employee=='10018' || $id_employee=='10020' || $id_employee=='10021' || $id_employee=='10022' || $id_employee=='10023' || $id_employee=='10040'){ //IT & Kompetisi
                    $id_approver_dana1 = '10008';
                    //tigor
                    /*
                    $data_approver_dana1 = array(
                            'id_piket'     => $new_id_piket,
                            'id_approver'   => 10008
                        );
                    $this->db->insert('piket_approve_dana',$data_approver_dana1);
                    */
                    //irzan ganti robin 3/7/2018
                    $data_approver_dana2 = array(
                            'id_piket'     => $new_id_piket,
                            'id_approver'   => 10056
                        );
                    $this->db->insert('piket_approve_dana',$data_approver_dana2);
                    //teddy
                    /*$data_approver_dana3 = array(
                        'id_piket'     => $new_id_piket,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('piket_approve_dana',$data_approver_dana3);
                    //risha
                    $data_approver_dana4 = array(
                        'id_piket'     => $new_id_piket,
                        'id_approver'   => 10007
                    );
                    $this->db->insert('piket_approve_dana',$data_approver_dana4);*/
                }else{
                    $id_approver_dana1 = '10056';
                    //irzan ganti robin
                    $data_approver_dana2 = array(
                            'id_piket'     => $new_id_piket,
                            'id_approver'   => 10056
                        );
                    $this->db->insert('piket_approve_dana',$data_approver_dana2);
                    //teddy
                    /*$data_approver_dana3 = array(
                        'id_piket'     => $new_id_piket,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('piket_approve_dana',$data_approver_dana3);
                    //risha
                    $data_approver_dana4 = array(
                        'id_piket'     => $new_id_piket,
                        'id_approver'   => 10007
                    );
                    $this->db->insert('piket_approve_dana',$data_approver_dana4);*/
                }

                $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver'")->result();
                //$data_approver2 = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver_dana1'")->result();
                $email1 = $data_approver[0]->email;
                //$email2 = $data_approver2[0]->email;
                $email3 = $data_karyawan[0]->email;
                $total_dana_piket = 500000;

                if($id_employee==$user_id){
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
                                                <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                                Hai, ".$data_approver[0]->firstname."
                                                </p>
                                                <p>".$data_karyawan[0]->firstname." mengajukan permohonan piket : </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Tanggal
                                            </td>
                                            <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Keperluan
                                            </td>
                                            <td colspan='3'>: ".$this->input->post('keperluan')."</td>
                                        </tr>
                                        <tr>
                                            <td colspan='3' style='padding-left:20px'>
                                                <a href='".base_url()."piket_approvel/approve_pengajuan_piket/".$new_id_piket."/".$token."' class='button'>Setujui</a>
                                                <a href='".base_url()."piket_approvel/tolak_pengajuan_piket/".$new_id_piket."/".$token."' class='button2'>Tolak</a> 
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
                    $mail->Subject = 'Pengajuan permohonan piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($email1);
                    $mail->Send();
                 }else{
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
                                                <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                                Hai, ".$data_karyawan[0]->firstname."
                                                </p>
                                                <p>".$data_approver[0]->firstname." memerintahkan Anda piket :  </p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Tanggal
                                            </td>
                                            <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Keperluan
                                            </td>
                                            <td colspan='3'>: ".$this->input->post('keperluan')."</td>
                                        </tr>
                                        <tr>
                                            <td colspan='3' style='padding-left:20px'>
                                                <a href='".base_url()."piket_approvel/approve_perintah_piket/".$new_id_piket."/".$token."' class='button'>Setujui</a>
                                                <a href='".base_url()."piket_approvel/tolak_perintah_piket/".$new_id_piket."/".$token."' class='button2'>Tolak</a> 
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
                    $mail->Subject = 'Perintah piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($email3);
                    $mail->Send();
                 }
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("piket");
            }
        }else{
            if($cek_hari_libur1=='Mon' || $cek_hari_libur1=='Tue' || $cek_hari_libur1=='Wed' || $cek_hari_libur1=='Thu' || $cek_hari_libur1=='Fri' || $cek_hari_libur2=='Mon' || $cek_hari_libur2=='Tue' || $cek_hari_libur2=='Wed' || $cek_hari_libur2=='Thu' || $cek_hari_libur2=='Fri'){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Piket hanya bisa diambil dihari libur')
                        window.location.href='".base_url()."piket/edit/".$id_piket."';
                        </SCRIPT>");
            }else{
                $data = array(
                    'jenis_piket'   => $this->input->post('jenis_piket'),
                    'keperluan'   => $this->input->post('keperluan'),
                    'start_date'   => $start,
                    'end_date'   => $end,
                    'total_days'    => $numberDays2+1,
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_piket', $id_piket);
                $this->db->update('piket', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("piket");
                }
            }
        }
    }

    function delete_data($id_permit){
        $this->db->where('id_permit', $id_permit);
        $this->db->delete('permit');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("permit");
    }

    function detail($id_piket){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        $data_piket = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
        $data_approve = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
        $id_requestor = $data_piket[0]->created_by;

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
            'data_piket'      => $data_piket,
            'data_requestor'    => $data_requestor,
            'status'            => $status,
            'tgl_diputuskan'    => $tgl_diputuskan,
            'id_employee_login'  => $user_id,
            'id_approver'       => $data_approve,
            'data_approver'     => $data_approve,
            'jabatan'           => $jabatan,
            'division'          => $dept
        );

        $this->template->load('template','piket/detail',$data);
    }

    function approve_pengajuan($id_piket){
        $user_id = $this->session->userdata('user_id');
        $setuju = $this->input->post('setuju');
        $tidak_setuju = $this->input->post('tidak_setuju');
        if(isset($setuju)){
            //create no surat
            $data_piket = $this->db->query("SELECT * FROM piket_approve WHERE status='1' ORDER BY approve_date DESC")->result();
            if($data_piket){
                $last_no = $data_piket[0]->no_piket;
                $no_urut = substr($last_no, 0,3);
                $no_urut_new = $no_urut + 1;
                $jml = strlen($no_urut_new);
                if($jml==1){
                    $nol = '00';
                }elseif($jml==2){
                    $nol = '0';
                }else{
                    $nol = '';
                }    
            }else{
                $nol = '00';
                $no_urut_new = '1';
            }
                
            $no_piket = $nol.''.$no_urut_new.'/HR/FPP/'.date('m').'/'.date('Y');
            $data = array(
                'no_piket'          => $no_piket,
                'status'            => 1,
                'updated_date'      => date('Y-m-d'),
                'approve_date'      => date('Y-m-d H:i:s')
            );   
        }else{
            $data = array(
                'status'            => 2,
                'updated_date'      => date('Y-m-d'),
            );
        }
    
        $this->db->where('id_piket',$id_piket);
        $this->db->where('id_approver',$user_id);
        $this->db->update('piket_approve',$data);

        if($this->db->affected_rows()!=0){
            redirect("piket");
        }
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("piket");
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

    function list_check($id_piket){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_piket'         => $get_data,
         );

        $this->template->load('template','piket/check',$data);
    }

    function list_check2($id_piket){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_piket'         => $get_data,
         );

        $this->template->load('template','piket/check2',$data); 
    }

    function list_check3($id_employee){  //check by user
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT * FROM piket WHERE id_employee='$id_employee'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_piket'         => $get_data,
         );

        $this->template->load('template','piket/check3',$data); 
    }


    function insert_token($id_piket){ 
        $token = md5(date('Ymdhis'));
        $data = array(
            'token'             => $token
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket_approve',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Piket approval successfully added !!</div>");
        redirect("piket");
    }

    function insert_token2($id_piket,$id_approver){ 
        $data = array(
            'token'             => 'fe69814f39f46794c6fc4ef2014c7a46'
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->where('id_approver',$id_approver);
        $this->db->update('piket_approve_dana',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully approved !!</div>");
        redirect("piket");
    }

    function insert_approver($id_piket,$id_approver){ 
        $data = array(
            'id_piket'             => $id_piket,
            'id_approver'          => $id_approver
        );
        $this->db->insert('piket_approve',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Piket approval successfully added !!</div>");
        redirect("piket");
    }

    function change_approver($id_piket_approve_dana,$id_approver_new){ 
        $data = array(
            'id_approver'             => $id_approver_new
        );
        $this->db->where('id_piket_approve_dana',$id_piket_approve_dana);
        $this->db->update('piket_approve_dana',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("piket"); 
    }

    function change_approver1($id_piket,$id_approver_new){ 
        $data = array(
            'id_approver'             => $id_approver_new
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket_approve',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("piket"); 
    }

    function change_status($id_piket){ 
        $data = array(
            'status'             => 0
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket_approve',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("piket"); 
    }

    function change_hari($id_piket,$hari){ 
        $data = array(
            'total_days'             => $hari
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("piket"); 
    }

    function change_jenis($id_piket){ 
        $data = array(
            'jenis_piket'             => 0
        );
        $this->db->where('id_piket',$id_piket);
        $this->db->update('piket',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("piket"); 
    }

    public function check_piket_user($id_employee)
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
            'data_piket' => $this->db->query("SELECT * FROM piket WHERE id_employee='$id_employee'")->result(),
            'jumlah_piket' => $this->db->query("SELECT sum(total_days) as jml FROM piket a, piket_approve b WHERE a.id_employee='$user_id' AND b.id_piket=a.id_piket AND b.status='1' AND b.status_batal='0'")->result()
        );
        $this->template->load('template','piket/index',$data);
    }
} 