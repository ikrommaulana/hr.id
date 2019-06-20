<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resend extends CI_Controller {
    public function __construct(){
        parent::__construct();
        require_once("PHPMailer/PHPMailerAutoload.php");
    }

    
    

    public function send_approvel(){
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
                                            Kepada Yth, 
                                            </p>
                                            <p> Idham Yamin mengajukan pengajuan dana perjalanan dinas : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: 045/ST/LIB/11/2017</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tanggal
                                        </td>
                                        <td colspan='3'>: 12 November 2017 - 17 November 2017</td>
                                        
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tujuan 
                                        </td>
                                        <td colspan='3'>: Bekasi</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keperluan 
                                        </td>
                                        <td colspan='3'>: Panpel Pertand 3-6 Babak 8 Besar Liga 2 2017 Group X</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. 1.500.000</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."dinas_approvel/approve_pengajuan_dana/237/123456bbb' class='button'>Setujui</a>
                                            <a href='".base_url()."dinas_approvel/tolak_pengajuan_dana/237/123456bbb' class='button2'>Tolak</a> 
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
                    $mail->Subject = 'Pengajuan dana perjalanan dinas'; 
                    $mail->Body = $message; 
                    $mail->AddAddress('tigor@ligaindonesiabaru.com');
                    $mail->AddBcc('idam@ligaindonesiabaru.com');
                    $kirim = $mail->Send();
    }

    /*public function send_approvel_auto(){
        require_once('phpmailer/class.phpmailer.php');
        $cek_belum_approve = $this->db->query("SELECT * FROM dinas_approve_dana WHERE token!='' AND status='0'")->result();
        if($cek_belum_approve){
            foreach($cek_belum_approve as $view){
                $id_dinas_approve_dana = $view->id_dinas_approve_dana;
                $token = $view->token;
                $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_approver'")->result();
                $nama_approver = $data_approver[0]->firstname;
                $email_approver = $data_approver[0]->email;

                $data_dinas = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$view->id_dinas'")->result();
                $id_employee = $data_dinas[0]->id_employee;
                $total_hari = $data_dinas[0]->total_days;
                $alasan_backdate = $data_dinas[0]->alasan_backdate;

                $tanggal1 = strtotime($data_dinas[0]->start_date); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($data_dinas[0]->end_date); 
                $dt2 = date("d F Y  ", $tanggal2);

                $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                $nama_pemohon = $data_employee[0]->firstname;

                $data_dinas_approve = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$view->id_dinas'")->result();
                $no_surat = $data_dinas_approve[0]->no_surat;

                $cek_sudah_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$view->id_dinas' AND status='1' ORDER BY id_dinas_approve_dana ASC")->result();
                if($cek_sudah_approver_dana){
                    $row = count($cek_sudah_approver_dana);
                    for($i=0; $i<$row; $i++){
                        $id_approver_nya[$i] = $cek_sudah_approver_dana[$i]->id_approver;    
                        $data_yg_approve[$i] = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$id_approver_nya[$i]'")->result();
                        $nama_approver2[$i]=$data_yg_approve[$i][0]->nama;
                    }
                }

                $cek_biaya_telekomunikasi = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$view->id_dinas' AND id_biaya_dinas='1'")->result();
                if($cek_biaya_telekomunikasi){
                    $biaya_telekomunikasi = $cek_biaya_telekomunikasi[0]->biaya;
                }else{
                    $biaya_telekomunikasi = 0;
                }
                $cek_biaya_makan = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$view->id_dinas' AND id_biaya_dinas='3'")->result();
                if($cek_biaya_makan){
                    $biaya_makan = $cek_biaya_makan[0]->biaya;
                }else{
                    $biaya_makan = 0;
                }
                $cek_biaya_transport = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$view->id_dinas' AND id_biaya_dinas='2'")->result();
                if($cek_biaya_transport){
                    $biaya_tranport = $cek_biaya_transport[0]->biaya;
                }else{
                    $biaya_tranport = 0;
                }

                $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari);

                $message .= "<html>
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
                                            Hai, ".$nama_approver."
                                            </p>
                                            <p>".$nama_pemohon." mengajukan pengajuan dana perjalanan dinas : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: ".$no_surat."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tanggal
                                        </td>
                                        <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                                        
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tujuan 
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->tujuan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keperluan 
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->keperluan."</td>
                                    </tr>";
                                    if($alasan_backdate!=''){//new 11/22/2017
                                        $message .= "<tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Alasan Backdate
                                            </td>
                                            <td colspan='3'>: ".$alasan_backdate."</td>
                                        </tr>";
                                        }
                                    $message .="<tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver2[0].'  '.$nama_approver2[1].'  '.$nama_approver2[2].'  '.$nama_approver2[3]."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($total_dana_dinas)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."dinas_approvel/approve_pengajuan_dana/".$id_dinas_approve_dana."/".$token."' class='button'>Setujui</a>
                                            <a href='".base_url()."dinas_approvel/tolak_pengajuan_dana/".$id_dinas_approve_dana."/".$token."' class='button2'>Tolak</a> 
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
                        $mail->From     = 'admin@ligaindonesiabaru.com';
                        $mail->FromName = 'HR';
                        $mail->IsSMTP(); 
                        $mail->SMTPAuth = true; 
                        $mail->Username = 'admin@ligaindonesiabaru.com'; //username email 
                        $mail->Password = 'admlib2017'; //password email 
                        $mail->SMTPSecure = "ssl";
                        $mail->Host ='smtp.gmail.com'; 
                        $mail->Port = 465; //port secure ssl email 
                        $mail->IsHTML(true);
                        $mail->Subject = 'Pengajuan permohonan dana'; 
                        $mail->Body = $message; 
                        $mail->AddAddress($email_approver);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();
            }
        }
        
    }*/

    public function send_cuti($id_cuti){
        $data_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit='$id_cuti' AND a.id_permit=b.id_permit AND b.status='0'")->result();
        $keterangan = $data_cuti[0]->keterangan;
        $jenis_cuti = $data_cuti[0]->id_cuti;
        if($jenis_cuti==4 || $jenis_cuti==8){
            $jns = 'izin';
        }else{
            $jns = 'cuti';
        }
        $subjek = 'Pengajuan permohonan '.$jns;
        $master_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$jenis_cuti'")->result();
        $keperluan = $data_cuti[0]->reason;
        $tanggal_pengajuan = strtotime($data_cuti[0]->created_date);
        $tanggal1 = strtotime($data_cuti[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_cuti[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);
        $dt3 = date("d F Y  ", $tanggal_pengajuan);

        $id_employee = $data_cuti[0]->id_employee;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_approver = $data_cuti[0]->id_approver;
        $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver 'and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
        $emailto = $data_approver[0]->email;
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
                                        <td valign='top' colspan='2' style='padding-left:20px'>
                                            <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                            Kepada Yth,<br> 
                                            ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                            ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan permohonon ".$jns." :</p>
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
                                        <td colspan='3'>: ".$keperluan."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jenis Pengajuan
                                        </td>
                                        <td colspan='3'>: ".$master_cuti[0]->jenis_cuti."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keterangan
                                        </td>
                                        <td colspan='3'>: ".$keterangan."</td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."permit_/approve_cuti_mail/".$id_cuti."' class='button'>Setujui</a>
                                            <a href='".base_url()."permit_/tolak_cuti_mail/".$id_cuti."' class='button2'>Tolak</a>
                                            <a href='".base_url()."permit_/history/".$id_employee."' class='button3'>History</a>
                                            
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <p>Terimakasih,</p>
                                            <p>Tim HR</p>
                                        </td>
                                    </tr>
                                </table>
                            </body>";
                        require_once("PHPMailer/PHPMailerAutoload.php");
                 
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
                        $mail->Subject = $subjek; 
                        $mail->Body = $message; 
                        $mail->AddAddress($emailto);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();

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
                                        <td valign='top' colspan='2' style='padding-left:20px'>
                                            <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                            Kepada Yth, 
                                            </p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan permohonon ".$jns." :</p>
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
                                        <td colspan='3'>: ".$keperluan."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jenis Pengajuan
                                        </td>
                                        <td colspan='3'>: ".$master_cuti[0]->jenis_cuti."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keterangan
                                        </td>
                                        <td colspan='3'>: ".$keterangan."</td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <a href='".base_url()."permit/history/".$id_employee."' class='button3'>History</a>
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <p>Terimakasih,</p>
                                            <p>Tim HR</p>
                                        </td>
                                    </tr>
                                </table>
                            </body>";
                        require_once("PHPMailer/PHPMailerAutoload.php");
                        $mail_hr = 'idam@ligaindonesiabaru.com';
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
                        $mail2->Subject = $subjek; 
                        $mail2->Body = $message2; 
                        $mail2->AddAddress($mail_hr);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail2->Send();
                        redirect("resend/success_resend_cuti");
    }

    public function send_cuti_($id_cuti){
        $data_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit='$id_cuti' AND a.id_permit=b.id_permit AND b.status='0'")->result();
        $tanggal_pengajuan = strtotime($data_cuti[0]->created_date);
        $tanggal1 = strtotime($data_cuti[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_cuti[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);
        $dt3 = date("d F Y  ", $tanggal_pengajuan);

        $id_employee = $data_cuti[0]->id_employee;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_approver = $data_cuti[0]->id_approver;
        $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
        $emailto = $data_approver[0]->email;
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
                                        <td width='300px'></td>
                                        <td width='200px'><img src='".base_url()."assets/images/logo.jpg' width='200px'/>
                                        </td>
                                        <td width='300px'></td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td valign='top' colspan='2' style='padding-left:20px'>
                                            <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                            Kepada Yth,<br> 
                                            ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                            ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>    
                                            <p> ".$data_karyawan[0]->firstname." mengajukan permohonon cuti pada tanggal ".$dt1." - ".$dt2." untuk ".$data_cuti[0]->reason."</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tanggal Pengajuan : ".$dt3."
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <a href='".base_url()."permit/approve_cuti_mail/".$id_cuti."' class='button'>Setujui</a>
                                            <a href='".base_url()."permit/tolak_cuti_mail/".$id_cuti."' class='button2'>Tolak</a>
                                            <a href='".base_url()."permit/history/".$id_employee."' class='button3'>History</a>
                                            
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <p>Terimakasih,</p>
                                            <p>Tim HR</p>
                                        </td>
                                    </tr>
                                </table>
                            </body>";
                 
                        require_once("PHPMailer/PHPMailerAutoload.php");
                 
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
                        $mail->Subject = 'Pengajuan permohonan cuti'; 
                        $mail->Body = $message; 
                        $mail->AddAddress($emailto);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();
    }
    
    public function send_piket($id_piket){
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND a.id_piket=b.id_piket AND b.status='0'")->result();
        
            $tanggal1 = strtotime($data_piket[0]->start_date); 
            $dt1 = date("d F Y  ", $tanggal1);
            $tanggal2 = strtotime($data_piket[0]->end_date); 
            $dt2 = date("d F Y  ", $tanggal2);

            $total_hari = $data_piket[0]->total_days;
            $biaya = 500000 * $total_hari;
            
            $id_employee = $data_piket[0]->id_employee;
            $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
            $id_approver = $data_piket[0]->id_approver;
            $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
            $emailto = $data_approver[0]->email;
            
            $token = $data_piket[0]->token;
            if($token){
                $token = $data_piket[0]->token;
            }else{
                $token = md5(date('Ymdhis'));
                $data_approver = array(
                    'token'         => $token
                );
                $this->db->where('id_piket',$id_piket);
                $this->db->update('piket_approve',$data_approver);
            }

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
                                        <td width='300px'></td>
                                        <td width='200px'><img src='".base_url()."assets/images/logo.jpg' width='200px'/>
                                        </td>
                                        <td width='300px'></td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td valign='top' colspan='2' style='padding-left:20px'>
                                            <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                            Kepada Yth,<br> 
                                            ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                            ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>
                                            <p> ".$data_karyawan[0]->firstname." mengajukan permohonon piket pada ".$dt1." - ".$dt2." untuk ".$data_piket[0]->keperluan."</p>
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <a href='".base_url()."piket_approvel/approve_pengajuan_piket/".$id_piket."/".$token."' class='button'>Setujui</a>
                                            <a href='".base_url()."piket_approvel/tolak_pengajuan_piket/".$id_piket."/".$token."' class='button2'>Tolak</a>
                                            
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
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
                        $mail->Subject = 'Pengajuan piket'; 
                        $mail->Body = $message; 
                        $mail->AddAddress($emailto);
                        $mail->Send();  
            redirect("resend/success_resend_dana_piket");
    }

    function send_pengajuan_dana_piket($id_piket){
        $data_piket = $this->db->query("SELECT * FROM piket a, piket_approve b WHERE a.id_piket='$id_piket' AND a.id_piket=b.id_piket")->result();
        $tanggal1 = strtotime($data_piket[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_piket[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);

        $total_hari = $data_piket[0]->total_days;
        $biaya = 500000 * $total_hari;
        
        $id_employee = $data_piket[0]->id_employee;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
    
        $get_approver = $this->db->query("SELECT * FROM piket_approve_dana WHERE id_piket='$id_piket' AND token!='' AND status='0'")->result();
        if($get_approver){
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
            $id_approver = $get_approver[0]->id_approver;
            $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
            $emailto = $data_approver[0]->email;
            $token = $get_approver[0]->token;
            $id_piket_approve_dana = $get_approver[0]->id_piket_approve_dana;

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
                                            Kepada Yth,<br> 
                                            ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                            ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan dana piket : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Piket
                                        </td>
                                        <td colspan='3'>: ".$data_piket[0]->no_piket."</td>
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
                                        <td colspan='3'>: ".$data_piket[0]->keperluan."</td>
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
                                            <a href='".base_url()."piket_approvel/approve_pengajuan_dana/".$id_piket_approve_dana."/".$token."' class='button'>Setujui</a>
                                            <a href='".base_url()."piket_approvel/tolak_pengajuan_dana/".$id_piket_approve_dana."/".$token."' class='button2'>Tolak</a> 
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
                    $mail->AddBcc('idam@ligaindonesiabaru.com');
                    $mail->Send();

                    redirect("resend/success_resend_dana_piket");
        }else{
            redirect("resend/success_resend_dana_piket2");
        }
         
    }

    function success_resend_dana_piket(){
        $this->load->view('piket/notif_resend1');
    }

    function success_resend_cuti(){
        $this->load->view('permit/email4');
    }

    function success_resend_dana_piket2(){
        $this->load->view('piket/notif_resend2');
    }

    function send_pengajuan_dana_dinas($id_dinas){
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas")->result();
        $alasan_backdate = $data_dinas[0]->alasan_backdate;
        $tanggal1 = strtotime($data_dinas[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_dinas[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);

        $total_hari = $data_dinas[0]->total_days;
        
        $id_employee = $data_dinas[0]->id_employee;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
    
        $get_approver = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND token!='' AND status='0'")->result();
        if($get_approver){
            $cek_sudah_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='1' ORDER BY id_dinas_approve_dana ASC")->result();
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
            $id_approver = $get_approver[0]->id_approver;
            $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
            $emailto = $data_approver[0]->email;
            $token = $get_approver[0]->token;
            $id_dinas_approve_dana = $get_approver[0]->id_dinas_approve_dana;

            //new total holiday
                    $data_dinas_holiday = $this->db->query("SELECT * FROM dinas where id_dinas='$id_dinas'")->result();
                    $total_holiday = $data_dinas_holiday[0]->total_days_holiday;
                    $luar_negri = $data_dinas_holiday[0]->id_tujuan;

                    $cek_biaya_makan_holiday = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='4'")->result();
                    if($cek_biaya_makan_holiday){
                        $tot_um_holiday = $cek_biaya_makan_holiday[0]->biaya;
                    }else{
                        $tot_um_holiday = 0;
                    }

                    if($total_holiday!=''){
                        if($cek_biaya_makan_holiday){
                            $um_holiday = $tot_um_holiday * $total_holiday;
                        }else{
                            $um_holiday = $total_holiday * 300000; // pengajuan lama/manual
                        }
                    }else{
                        $um_holiday = 0;
                    }

            $cek_biaya_telekomunikasi = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='1'")->result();
            if($cek_biaya_telekomunikasi){
                $biaya_telekomunikasi = $cek_biaya_telekomunikasi[0]->biaya;
            }else{
                $biaya_telekomunikasi = 0;
            }
            $cek_biaya_makan = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='3'")->result();
            if($cek_biaya_makan){
                $biaya_makan = $cek_biaya_makan[0]->biaya;
            }else{
                $biaya_makan = 0;
            }
            $cek_biaya_transport = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='2'")->result();
            if($cek_biaya_transport){
                $biaya_tranport = $cek_biaya_transport[0]->biaya;
            }else{
                $biaya_tranport = 0;
            }

            if($luar_negri==0){
                $total_dana_dinas = $biaya_tranport; 
                $total_dana_dinas2 = $biaya_makan * $total_hari;
            }else{
                $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari) + $um_holiday;
                $total_dana_dinas2 = 0;
            }
            

            $message .= "<html>
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
                                            ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                            ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>
                                            <p>".$data_karyawan[0]->firstname." mengajukan pengajuan dana perjalanan dinas : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->no_surat."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tanggal
                                        </td>
                                        <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                                        
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tujuan 
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->tujuan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keperluan 
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->keperluan."</td>
                                    </tr>";
                                    if($alasan_backdate!=''){//new 11/22/2017
                                        $message .= "<tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Alasan Backdate
                                            </td>
                                            <td colspan='3'>: ".$alasan_backdate."</td>
                                        </tr>";
                                        }
                                    $message .="<tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver[0].'  '.$nama_approver[1].'  '.$nama_approver[2].'  '.$nama_approver[3]."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($total_dana_dinas).""; 
                                        if($luar_negri==0){ 
                                            $message.= " + $. ".number_format($total_dana_dinas2)."";

                                        } 
                                    $message.="</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Rincian Dana 
                                        </td>
                                        <td colspan='3'></td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='text-align:right'>
                                            Telekomunikasi 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya_telekomunikasi)."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='text-align:right'>
                                            Transport 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya_tranport)."</td>
                                       
                                    </tr>";
                                    if($luar_negri==0){//new 11/22/2017
                                        $message .= "<tr>
                                        <td valign='top' style='text-align:right'>
                                            Uang makan 
                                        </td>
                                        <td colspan='3'>: $. ".number_format($biaya_makan*$total_hari)."</td>
                                       
                                    </tr>";
                                        }
                                    if($luar_negri!=0){//new 11/22/2017 
                                        $message .= "<tr>
                                        <td valign='top' style='text-align:right'>
                                            Uang makan 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($biaya_makan*$total_hari)."</td>
                                       
                                    </tr>";
                                        }
                                    $message .= "
                                    <tr>
                                        <td valign='top' style='text-align:right'>
                                            Uang makan hari libur
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($um_holiday)."</td>
                                       
                                    </tr> 
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."dinas_approvel/approve_pengajuan_dana/".$id_dinas_approve_dana."/".$token."' class='button'>Setujui</a>
                                            <a href='".base_url()."dinas_approvel/tolak_pengajuan_dana/".$id_dinas_approve_dana."/".$token."' class='button2'>Tolak</a> 
                                            <a href='".base_url()."dinas_approvel/print_dana/".$id_dinas."' class='button'>Lihat Detail</a>
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
                        $emailtes = 'nuri.rahmat@ligaindonesiabaru.com';
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
                        $mail->Subject = 'Pengajuan permohonan dana dinas'; 
                        $mail->Body = $message; 
                        $mail->AddAddress($emailto);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();

                    redirect("resend/success_resend_dana_dinas");
        }else{
            redirect("resend/success_resend_dana_dinas2");
        }
        
    }

    function send_pengajuan_dana_dinas_manual($id_dinas,$id_approver){
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas")->result();
        $alasan_backdate = $data_dinas[0]->alasan_backdate;
        $tanggal1 = strtotime($data_dinas[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_dinas[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);

        $total_hari = $data_dinas[0]->total_days;
        
        $id_employee = $data_dinas[0]->id_employee;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
    
        $get_approver = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND id_approver='$id_approver' AND token!='' AND status='0'")->result();
        if($get_approver){
            $cek_sudah_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='1' ORDER BY id_dinas_approve_dana ASC")->result();
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
            $id_approver = $get_approver[0]->id_approver;
            $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
            $emailto = $data_approver[0]->email;
            $token = $get_approver[0]->token;
            $id_dinas_approve_dana = $get_approver[0]->id_dinas_approve_dana;

            $cek_biaya_telekomunikasi = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='1'")->result();
            if($cek_biaya_telekomunikasi){
                $biaya_telekomunikasi = $cek_biaya_telekomunikasi[0]->biaya;
            }else{
                $biaya_telekomunikasi = 0;
            }
            $cek_biaya_makan = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='3'")->result();
            if($cek_biaya_makan){
                $biaya_makan = $cek_biaya_makan[0]->biaya;
            }else{
                $biaya_makan = 0;
            }
            $cek_biaya_transport = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='2'")->result();
            if($cek_biaya_transport){
                $biaya_tranport = $cek_biaya_transport[0]->biaya;
            }else{
                $biaya_tranport = 0;
            }

            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari);

            $message .= "<html>
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
                                            ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                            ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan pengajuan dana perjalanan dinas : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->no_surat."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tanggal
                                        </td>
                                        <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                                        
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tujuan 
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->tujuan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keperluan 
                                        </td>
                                        <td colspan='3'>: ".$data_dinas[0]->keperluan."</td>
                                    </tr>";
                                    if($alasan_backdate!=''){//new 11/22/2017
                                        $message .= "<tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Alasan Backdate
                                            </td>
                                            <td colspan='3'>: ".$alasan_backdate."</td>
                                        </tr>";
                                        }
                                    $message .="<tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver[0].'  '.$nama_approver[1].'  '.$nama_approver[2].'  '.$nama_approver[3]."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($total_dana_dinas)."</td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."dinas_approvel/approve_pengajuan_dana/".$id_dinas_approve_dana."/".$token."' class='button'>Setujui</a>
                                            <a href='".base_url()."dinas_approvel/tolak_pengajuan_dana/".$id_dinas_approve_dana."/".$token."' class='button2'>Tolak</a> 
                                            <a href='".base_url()."dinas_approvel/print_dana/".$id_dinas."' class='button'>Lihat Detail</a>
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
                        $mail->Subject = 'Pengajuan permohonan dana dinas'; 
                        $mail->Body = $message; 
                        $mail->AddAddress($emailto);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();

                    redirect("resend/success_resend_dana_dinas");
        }else{
            redirect("resend/success_resend_dana_dinas2");
        }
        
    }

    public function send_pengajuan_dinas($id_dinas){
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas")->result();
        $alasan_backdate = $data_dinas[0]->alasan_backdate;
        $tanggal1 = strtotime($data_dinas[0]->start_date); 
        $dt1 = date("d F Y  ", $tanggal1);
        $tanggal2 = strtotime($data_dinas[0]->end_date); 
        $dt2 = date("d F Y  ", $tanggal2);
        $token = $data_dinas[0]->token;

        $total_hari = $data_dinas[0]->total_days;
        
        $id_employee = $data_dinas[0]->id_employee;
        $id_approver = $data_dinas[0]->id_approver;
        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
        $emailto = $data_approver[0]->email;

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
                                                Kepada Yth,<br> 
                                                ".$data_approver[0]->nama_jabatan." ".$data_approver[0]->init_division_name."<br>      
                                                ".$data_approver[0]->title." ".$data_approver[0]->firstname."</p>
                                                <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan permohonan perjalanan dinas : </p>
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
                                                Tujuan
                                            </td>
                                            <td colspan='3'>: ".$data_dinas[0]->tujuan."</td>
                                            
                                        </tr>
                                        <tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Keperluan
                                            </td>
                                            <td colspan='3'>: ".$data_dinas[0]->keperluan."</td>
                                           
                                        </tr>
                                        <tr height='30'></tr>
                                        <tr>
                                            <td colspan='3' style='padding-left:20px'>
                                                <a href='".base_url()."dinas_approvel/approve_pengajuan_dinas/".$id_dinas."/".$token."' class='button'>Setujui</a>
                                                <a href='".base_url()."dinas_approvel/tolak_pengajuan_dinas/".$id_dinas."/".$token."' class='button2'>Tolak</a> 
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
                        $mail->Subject = 'Pengajuan permohonan dinas'; 
                        $mail->Body = $message; 
                        $mail->AddAddress($emailto);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();
                        redirect("resend/success_resend_dana_dinas");
    }

    function dinas_to_ismene($id_dinas){
        $get_id_employee = $this->db->query("SELECT * From dinas WHERE id_dinas='$id_dinas'")->result();
        $id_employee = $get_id_employee[0]->id_employee;
        $cek_biaya_telekomunikasi = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='1'")->result();
                        if($cek_biaya_telekomunikasi){
                            $biaya_telekomunikasi = $cek_biaya_telekomunikasi[0]->biaya;
                        }else{
                            $biaya_telekomunikasi = 0;
                        }
                        $cek_biaya_makan = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='3'")->result();
                        if($cek_biaya_makan){
                            $biaya_makan = $cek_biaya_makan[0]->biaya;
                        }else{
                            $biaya_makan = 0;
                        }
                        $cek_biaya_transport = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='2'")->result();
                        if($cek_biaya_transport){
                            $biaya_tranport = $cek_biaya_transport[0]->biaya;
                        }else{
                            $biaya_tranport = 0;
                        }
                        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                        $get_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND b.id_dinas=a.id_dinas")->result();
                        $id_tujuan = $get_dinas[0]->id_tujuan;
                        
                        $total_hari = $get_dinas[0]->total_days;
                        //$total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari);
                        if($id_tujuan!=0){
                            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari);  
                            $total_dana_dinas2 = 0;  
                        }else{
                            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport;
                            $total_dana_dinas2 = $biaya_makan * $total_hari;
                        }
                        $cek_biaya = $this->db->query("SELECT sum(biaya) as tot FROM dinas_biaya WHERE id_dinas='$id_dinas'")->result();
                        $tot = $cek_biaya[0]->tot;
                        $tanggal1 = strtotime($get_dinas[0]->start_date); 
                        $dt1 = date("d F Y  ", $tanggal1);
                        $tanggal2 = strtotime($get_dinas[0]->end_date); 
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
                                            Ibu Ismene
                                            </p>
                                            <p>".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname." mengajukan pengajuan dana perjalanan dinas : </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            No Surat
                                        </td>
                                        <td colspan='3'>: ".$get_dinas[0]->no_surat."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tanggal
                                        </td>
                                        <td colspan='3'>: ".$dt1." - ".$dt2."</td>
                                        
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Tujuan 
                                        </td>
                                        <td colspan='3'>: ".$get_dinas[0]->tujuan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keperluan 
                                        </td>
                                        <td colspan='3'>: ".$get_dinas[0]->keperluan."</td>
                                       
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($total_dana_dinas)."<?php if($id_tujuan==1){?> + $ ".number_format($total_dana_dinas2)."<?php }?></td>
                                       
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."dinas_approvel/print_dana/".$id_dinas."' class='button'>Download Form</a>
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
                        $mail->Subject = 'Pengajuan permohonan dana'; 
                        $mail->Body = $message; 
                        $mail->AddAddress('ismene.manurung@ligaindonesiabaru.com');
                        $mail->AddCc('robin.suparto@ligaindonesiabaru.com');
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();
    }

    function success_resend_dana_dinas(){
        $this->load->view('piket/notif_resend1');
    }

    function success_resend_dana_dinas2(){
        $this->load->view('piket/notif_resend2');
    }

    public function tes_mail(){
        $this->Kirim_email->sendEmail();
    }

    function tes_mail2(){
        $fromEmail = "noreply@ligaindonesiabaru.com"; //ganti dg alamat email kamu di sini
        $isiEmail = "tes mail"; //ini isi emailnya

        $mail = new PHPMailer();
        $mail->IsHTML(true);    //ini agar email bisa mengirim dalam format HTML
        $mail->IsSMTP();   //kita akan menggunakan SMTP
        $mail->SMTPOptions = array(
                'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ) 
        );
        $mail->SMTPAuth   = true; //Autentikasi SMTP: enabled
        $mail->SMTPSecure = "ssl";  //jenis keamanan SMTP
        $mail->Host       = "smtp.gmail.com"; //setting GMail sebagai SMTP server
        $mail->Port       = 465; // SMTP port to connect to GMail
        $mail->Username   = $fromEmail;  
        $mail->Password   = "@DM1nNOR3plY"; //ganti dg password GMail kamu
        $mail->SetFrom('noreply@ligaindonesiabaru.com', 'noreply');  //Siapa yg mengirim email
        $mail->Subject    = "HR"; //ini subjek emailnya
        $mail->Body       = $isiEmail;
        $toEmail = "idam@ligaindonesiabaru.com"; // siapa yg menerima email ini
        $mail->AddAddress($toEmail);
       
        if(!$mail->Send()) {
            echo "Eror: ".$mail->ErrorInfo;
        } else {
            echo "Email berhasil dikirim";
        }
    }
}