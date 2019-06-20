<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piket_approvel extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->session->set_userdata('logged_in',1);
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        require_once("PHPMailer/PHPMailerAutoload.php");
    }
    //approve by mail
    function no_access(){
        $this->load->view('errors/html/error_404.php');
    }
    function approve_pengajuan_piket($id_piket,$token){
        $validasi = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND token='$token'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            $data = array(
                'status'            => 1,
                'updated_date'      => date('Y-m-d'),
            );

            $this->db->where('id_piket',$id_piket);
            $this->db->where('token',$token);
            $this->db->update('piket_approve',$data);

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

            $this->db->where('id_piket',$id_piket);
            $this->db->update('piket_approve',$data);

            $approver_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
            if($approver_piket){
                $id_approver = $approver_piket[0]->id_approver;
                $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver'")->result();
                $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $data_karyawan = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_employee' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan ")->result();

                $emailto = $data_karyawan[0]->email;
                $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                $tanggal1 = strtotime($get_piket[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            ".$data_karyawan[0]->Title." ".$data_karyawan[0]->firstname."</p>
                                            <p>".$data_approver[0]->Title." ".$data_approver[0]->firstname." telah menyetujui pengajuan piket Anda</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
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
                    $mail->Subject = 'Pengajuan dana piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $kirim = $mail->Send();
            }

            $cek_approver_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND status='0' ORDER BY id_piket_approve_dana ASC")->result();
            if($cek_approver_dana){
                $get_approver = $this->db->query("SELECT id_approver as ap FROM piket_approve WHERE id_piket='$id_piket'")->result();
                $id_app = $get_approver[0]->ap;
                $nm_approver = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$id_app'")->result();
                $nama_approver = $nm_approver[0]->nama;

                $id_approver_dana = $cek_approver_dana[0]->id_approver;
                $id_piket_approve_dana = $cek_approver_dana[0]->id_piket_approve_dana;

                $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();

                $jumlah_hari = $get_employee[0]->total_days;
                $biaya = 500000 * $jumlah_hari;

                //create token ke piket approve dana
                $token_new = md5(date('Ymdhis'));
                $data_token = array(
                    'token' => $token_new
                );
                $this->db->where('id_piket_approve_dana',$id_piket_approve_dana);
                $this->db->update('piket_approve_dana',$data_token);

                $get_email = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE employee.id_employee='$id_approver_dana' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
                $emailto2 = $get_email[0]->email;
                $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                $tanggal1 = strtotime($get_piket[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($get_piket[0]->end_date); 
                $dt2 = date("d F Y  ", $tanggal2);
                $message2 = "<html>
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
                                            Kepada Yth,<br> 
                                            ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br>      
                                            ".$get_email[0]->title." ".$get_email[0]->firstname."</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."piket_approvel/approve_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button'>Setujui</a>
                                            <a href='".base_url()."piket_approvel/tolak_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button2'>Tolak</a> 
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
             
                    $mail2 = new PHPMailer(); 
                    $mail2->From     = 'noreply@ligaindonesiabaru.com';
                    $mail2->FromName = 'HR';
                    $mail2->IsSMTP(); 
                    $mail2->SMTPOptions = array(
                            'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ) 
                    );
                    $mail2->SMTPAuth = true; 
                    $mail2->Username = 'noreply@ligaindonesiabaru.com'; //username email 
                    $mail2->Password = '@DM1nNOR3plY'; //password email 
                    $mail2->SMTPSecure = "ssl";
                    $mail2->Host ='smtp.gmail.com'; 
                    $mail2->Port = 465; //port secure ssl email 
                    $mail2->IsHTML(true);
                    $mail2->Subject = 'Pengajuan dana piket'; 
                    $mail2->Body = $message2; 
                    $mail2->AddAddress($emailto2);
                    $kirim = $mail2->Send();

                    redirect("piket_approvel/approve_status");
            }  
        }
    }

    function approve_pengajuan_piket_($id_piket,$token){
        $validasi = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND token='$token'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            $data = array(
                'status'            => 1,
                'updated_date'      => date('Y-m-d'),
            );

            $this->db->where('id_piket',$id_piket);
            $this->db->where('token',$token);
            $this->db->update('piket_approve',$data);

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

            $this->db->where('id_piket',$id_piket);
            $this->db->update('piket_approve',$data);

            $approver_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
            if($approver_piket){
                $id_approver = $approver_piket[0]->id_approver;
                $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver'")->result();
                $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $data_karyawan = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_employee' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();

                $emailto = $data_karyawan[0]->email;
                $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                $tanggal1 = strtotime($get_piket[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            ".$data_karyawan[0]->Title." ".$data_karyawan[0]->firstname."</p>
                                            <p>".$data_approver[0]->title." ".$data_approver[0]->firstname." telah menyetujui pengajuan piket Anda</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
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
                    $mail->Subject = 'Pengajuan dana piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $kirim = $mail->Send();

                    redirect("piket_approvel/approve_status");
            }  
        }
    }

    function approve_perintah_piket($id_piket,$token){
        $validasi = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND token='$token'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            $data = array(
                'status'            => 1,
                'updated_date'      => date('Y-m-d'),
            );

            $this->db->where('id_piket',$id_piket);
            $this->db->where('token',$token);
            $this->db->update('piket_approve',$data);

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

            $this->db->where('id_piket',$id_piket);
            $this->db->update('piket_approve',$data);

            $cek_approver_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND status='0' ORDER BY id_piket_approve_dana ASC")->result();
            if($cek_approver_dana){
                $get_approver = $this->db->query("SELECT id_approver as ap FROM piket_approve WHERE id_piket='$id_piket'")->result();
                $id_app = $get_approver[0]->ap;
                $nm_approver = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$id_app'")->result();
                $nama_approver = $nm_approver[0]->nama;

                $id_approver_dana = $cek_approver_dana[0]->id_approver;
                $id_piket_approve_dana = $cek_approver_dana[0]->id_piket_approve_dana;

                $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();

                $jumlah_hari = $get_employee[0]->total_days;
                $biaya = 500000 * $jumlah_hari;

                //create token ke piket approve dana
                $token_new = md5(date('Ymdhis'));
                $data_token = array(
                    'token' => $token_new
                );
                $this->db->where('id_piket_approve_dana',$id_piket_approve_dana);
                $this->db->update('piket_approve_dana',$data_token);

                $get_email = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver_dana'")->result();
                $emailto = $get_email[0]->email;
                $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                $tanggal1 = strtotime($get_piket[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br>
                                            ".$get_email[0]->Title." ".$get_email[0]->firstname."
                                            </p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."piket_approvel/approve_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button'>Setujui</a>
                                            <a href='".base_url()."piket_approvel/tolak_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button2'>Tolak</a> 
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
                    $mail->Subject = 'Pengajuan dana piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $kirim = $mail->Send();

                    redirect("piket_approvel/approve_status");
            }  
        }
    }

    function approve_pengajuan_dana($id_piket_approve_dana,$token){
        $validasi = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket_approve_dana='$id_piket_approve_dana' AND token='$token'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            //new
            $id_ap = $validasi[0]->id_approver;
            $get_approver_awal = $this->db->query("SELECT firstname as nm FROM employee WHERE id_employee='$id_ap'")->result();
            $nama_approver_awal = $get_approver_awal[0]->nm;
            //end new
            $cek_approved = $validasi[0]->status;
            if($cek_approved==1){
                redirect("piket_approvel/approve_status2");
            }else{
                $data = array(
                    'status'            => 1,
                    'approve_date'      => date('Y-m-d'),
                );
           
                $this->db->where('id_piket_approve_dana',$id_piket_approve_dana);
                $this->db->update('piket_approve_dana',$data);

                $get_id_piket = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket_approve_dana='$id_piket_approve_dana'")->result();
                $id_piket = $get_id_piket[0]->id_piket;
                $get_id_employee = $this->db->query("SELECT * From piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_id_employee[0]->id_employee;

                $cek_approver_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND status='0' ORDER BY id_piket_approve_dana ASC")->result();
                if($cek_approver_dana){
                    $cek_sudah_approver_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND status='1' ORDER BY id_piket_approve_dana ASC")->result();
                    if($cek_sudah_approver_dana){
                        $row = count($cek_sudah_approver_dana);
                        for($i=0; $i<$row; $i++){
                            $id_approver_nya[$i] = $cek_sudah_approver_dana[$i]->id_approver;    
                            $data_yg_approve[$i] = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$id_approver_nya[$i]'")->result();
                            $nama_approver[$i]=$data_yg_approve[$i][0]->nama;
                        }
                    }else{
                        $jml_sudah_approve = 0;
                    }
                    
                    $id_approver_dana = $cek_approver_dana[0]->id_approver;
                    $id_piket_approve_dana = $cek_approver_dana[0]->id_piket_approve_dana;

                    //create token ke dinas approve dana
                    $token_new = md5(date('Ymdhis'));
                    $data_token = array(
                        'token' => $token_new
                    );
                    $this->db->where('id_piket_approve_dana',$id_piket_approve_dana);
                    $this->db->update('piket_approve_dana',$data_token);

                    $get_email = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver_dana' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
                    $emailto = $get_email[0]->email;
                        
                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                    $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                    $total_hari = $get_piket[0]->total_days;
                    $biaya = 500000 * $total_hari;
                    $tanggal1 = strtotime($get_piket[0]->start_date); 
                    $dt1 = date("d F Y  ", $tanggal1);
                    $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br>
                                            ".$get_email[0]->title." ".$get_email[0]->firstname."</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver[0].'  '.$nama_approver[1].'  '.$nama_approver[2].'  '.$nama_approver[3]."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."piket_approvel/approve_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button'>Setujui</a>
                                            <a href='".base_url()."piket_approvel/tolak_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button2'>Tolak</a> 
                                            <a href='".base_url()."piket_approvel/print_dana/".$id_piket."' class='button3'>Lihat Detail</a>
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
                    $mail->Subject = 'Pengajuan dana piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $mail->Send();
                }else{
                    $cek_approve_report = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND report_approve='1'")->result();
                    if($cek_approve_report){
                        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                        $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                        
                        $total_hari = $get_piket[0]->total_days;
                        $biaya = 500000 * $total_hari;
                        $tanggal1 = strtotime($get_piket[0]->start_date); 
                        $dt1 = date("d F Y  ", $tanggal1);
                        $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br> 
                                            Ibu Ismene</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."piket_approvel/print_dana/".$id_piket."' class='button'>Download Form</a>
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
                        $mail->Subject = 'Pengajuan dana piket'; 
                        $mail->Body = $message; 
                        $mail->AddAddress('ismene.manurung@ligaindonesiabaru.com');
                        $mail->Send();
                    }
                    }
                }
            }
            
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
            redirect("piket_approvel/approve_status");
    }

    function approve_pengajuan_laporan($id_piket,$token){
        $validasi = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND a.token='$token' AND b.id_piket='$id_piket'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            //new
            $id_employee = $validasi[0]->id_employee;
            $cek_approved = $validasi[0]->report_approve;
            if($cek_approved==1){
                redirect("piket_approvel/approve_status_laporan2");//dobel approve
            }else{
                $data = array(
                    'report_approve'        => 1,
                    'report_approve_date'   => date('Y-m-d')
                );
                $this->db->where('id_piket',$id_piket);
                $this->db->update('piket_approve',$data);

                $cek_approve_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND status='0'")->result();
                    if(!$cek_approve_dana){
                        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                        $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                        
                        $total_hari = $get_piket[0]->total_days;
                        $biaya = 500000 * $total_hari;
                        $tanggal1 = strtotime($get_piket[0]->start_date); 
                        $dt1 = date("d F Y  ", $tanggal1);
                        $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            Ibu Ismene</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."piket_approvel/print_dana/".$id_piket."' class='button'>Download Form</a>
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
                        $mail->Subject = 'Pengajuan dana piket'; 
                        $mail->Body = $message; 
                        $mail->AddAddress('ismene.manurung@ligaindonesiabaru.com');
                        $mail->Send();
                    }else{
                        $cek_approver_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND status='0' ORDER BY id_piket_approve_dana ASC")->result();
                        if($cek_approver_dana){
                            $get_approver = $this->db->query("SELECT id_approver as ap FROM piket_approve WHERE id_piket='$id_piket'")->result();
                            $id_app = $get_approver[0]->ap;
                            $nm_approver = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$id_app'")->result();
                            $nama_approver = $nm_approver[0]->nama;

                            $id_approver_dana = $cek_approver_dana[0]->id_approver;
                            $id_piket_approve_dana = $cek_approver_dana[0]->id_piket_approve_dana;

                            $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                            $id_employee = $get_employee[0]->id_employee;
                            $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();

                            $jumlah_hari = $get_employee[0]->total_days;
                            $biaya = 500000 * $jumlah_hari;

                            //create token ke piket approve dana
                            $token_new = md5(date('Ymdhis'));
                            $data_token = array(
                                'token' => $token_new
                            );
                            $this->db->where('id_piket_approve_dana',$id_piket_approve_dana);
                            $this->db->update('piket_approve_dana',$data_token);

                            $get_email = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver_dana' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
                            $emailto = $get_email[0]->email;
                            $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                            $tanggal1 = strtotime($get_piket[0]->start_date); 
                            $dt1 = date("d F Y  ", $tanggal1);
                            $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                                        Kepada Yth, <br>
                                                        ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br>
                                                        ".$get_email[0]->title." ".$get_email[0]->firstname."</p>
                                                        <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign='top' style='padding-left:20px'>
                                                        No Piket
                                                    </td>
                                                    <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                                    <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
                                                </tr>
                                                <tr>
                                                    <td valign='top' style='padding-left:20px'>
                                                        Telah disetujui oleh 
                                                    </td>
                                                    <td colspan='3'>: ".$nama_approver."</td>  
                                                </tr>
                                                <tr>
                                                    <td valign='top' style='padding-left:20px'>
                                                        Jumlah Total Dana 
                                                    </td>
                                                    <td colspan='3'>: Rp. ".number_format($biaya)."</td>
                                                   
                                                </tr>
                                                <tr height='30'></tr>
                                                <tr>
                                                    <td colspan='3' style='padding-left:20px'>
                                                        <a href='".base_url()."piket_approvel/approve_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button'>Setujui</a>
                                                        <a href='".base_url()."piket_approvel/tolak_pengajuan_dana/".$id_piket_approve_dana."/".$token_new."' class='button2'>Tolak</a> 
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
                                $mail->Subject = 'Pengajuan dana piket'; 
                                $mail->Body = $message; 
                                $mail->AddAddress($emailto);
                                $kirim = $mail->Send();

                                redirect("piket_approvel/approve_status");
                        }
                    }
                }
            }
            
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
            redirect("piket_approvel/approve_status_laporan");
    }

    function tolak_pengajuan_piket($id_piket,$token){
        $validasi = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND token='$token'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            $data = array(
                'status'            => 2,
                'updated_date'      => date('Y-m-d'),
            );

            $this->db->where('id_piket',$id_piket);
            $this->db->where('token',$token);
            $this->db->update('piket_approve',$data);

            $approver_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
            if($approver_piket){
                $id_approver = $approver_piket[0]->id_approver;
                $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver'")->result();
                $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $data_karyawan = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_employee' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();

                $emailto = $data_karyawan[0]->email;
                $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                $tanggal1 = strtotime($get_piket[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            ".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname."</p>    
                                            <p>".$data_approver[0]->title." ".$data_approver[0]->firstname." menolak pengajuan piket Anda : </p>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
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
                    $mail->Subject = 'Pengajuan dana piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $kirim = $mail->Send();

                    redirect("piket_approvel/approve_status");
            }  
        }
    }

    function tolak_pengajuan_laporan($id_piket,$token){
        $validasi = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket' AND token='$token'")->result();
        if(!$validasi){
            redirect('piket_approvel/no_access');
        }else{
            $data = array(
                    'report_approve'        => 2,
                    'report_approve_date'   => date('Y-m-d')
                );
                $this->db->where('id_piket',$id_piket);
                $this->db->update('piket_approve',$data);

                $approver_piket = $this->db->query("SELECT * FROM piket_approve WHERE id_piket='$id_piket'")->result();
            if($approver_piket){
                $id_approver = $approver_piket[0]->id_approver;
                $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver'")->result();
                $get_employee = $this->db->query("SELECT * FROM piket WHERE id_piket='$id_piket'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $data_karyawan = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_employee' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();

                $emailto = $data_karyawan[0]->email;
                $get_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND b.id_piket=a.id_piket")->result();
                $tanggal1 = strtotime($get_piket[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($get_piket[0]->end_date); 
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
                                            Kepada Yth, <br>
                                            ".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname."</p>      
                                            <p>".$data_approver[0]->title." ".$data_approver[0]->firstname." telah menolak laporan piket Anda, silahkan buat kembali laporan piket agar pengajuan dana bisa diproses : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$get_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$get_piket[0]->keperluan."</td>
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
                    $mail->Subject = 'Pengajuan dana piket'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $kirim = $mail->Send();

                    redirect("piket_approvel/tolak_status_laporan");
            }
        }
    }

    public function print_dana($id_piket)
    {
        
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND a.id_piket=b.id_piket")->result();
        $id_atasan = $data_piket[0]->id_approver;
        $get_atasan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_atasan'")->result();
        
        $jumlah_hari = $data_piket[0]->total_days;
        $tot_biaya = 500000 * $jumlah_hari;

        $id_employee = $data_piket[0]->id_employee;
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_division = $data_employee[0]->id_division;
        $data_divisi = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();

        //data direktur
        $data_dir = $this->db->query("SELECT * FROM employee a, jabatan b, jabatan_sub_dept c WHERE a.id_position=b.id_jabatan AND b.id_jabatan=c.id_jabatan AND c.id_division='$id_division'")->result();
        $data_approve_dana = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND id_approver='10010' AND status='1'")->result();
        if($data_approve_dana){
            $approve_irz = 1;
        }else{
            $approve_irz = 0;
        }
        $start_date = $data_piket[0]->start_date;
        if($start_date<'2018-09-01'){
            $app_new = 0;
        }else{
            $app_new = 1;
        }
        $data = array(
            'data_piket'    => $data_piket,
            'data_divisi'   => $data_divisi[0]->division_name,
            'data_employee' => $data_employee,
            'data_atasan'   => $get_atasan,
            'data_dir'      => $data_dir,
            'biaya'         => $tot_biaya,
            'id_piket'      => $id_piket,
            'jumlah_hari'   => $jumlah_hari,
            'approve_old'   => $approve_irz,
            'app_new'    => $app_new
        );
        //$this->template->load('template','payroll/printpdf',$data);
        $html                   = $this->load->view('piket/dana',$data,true);
        $pdfFilePath            = "suratpengajuandana-".date('y-m-d').".pdf";
        $pdfFilePath            = "suratpengajuandana.pdf";
                                  $this->load->library('m_pdf');
        $pdf                    = $this->m_pdf->load();
        $mpdf                   = new mPDF('c', 'A4-L');
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I"); 
    }

    function approve_status(){
        $this->load->view('piket/notif');
    }

    function approve_status_laporan(){
        $this->load->view('piket/notif_laporan');
    }

    function approve_status_laporan2(){
        $this->load->view('piket/notif_laporan2');
    }

    function tolak_status(){
        $this->load->view('piket/notif_tolak');
    }

    function tolak_status_laporan(){
        $this->load->view('piket/notif_tolak2');
    }

    function approve_status2(){
        $this->load->view('piket/notif2');
    }

    function approve_status4(){
        $this->load->view('dinas/email4');
    }
}