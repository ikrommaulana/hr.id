<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dinas_approvel extends CI_Controller {
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
    function approve_pengajuan_dinas($id_dinas,$token){
        $validasi = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas' AND token='$token'")->result();
        if(!$validasi){
            redirect('dinas_approvel/no_access');
        }else{
            //add new
            $get_approver = $this->db->query("SELECT id_approver as ap FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
            $id_app = $get_approver[0]->ap; //id atasan
            $nm_approver = $this->db->query("SELECT firstname as nama FROM employee WHERE id_employee='$id_app'")->result();
            $nama_approver = $nm_approver[0]->nama; //nama atasan
            //end add new
            $cek_approved = $validasi[0]->status;
            if($cek_approved==1){
                redirect("dinas_approvel/approve_status3");
            }else{
                $get_employee = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
                $id_employee = $get_employee[0]->id_employee;
                //new LN
                $id_tujuan = $get_employee[0]->id_tujuan;
                $jabodetabek = $get_employee[0]->jabodetabek;
                //LN
                $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                if($data_karyawan){
                    $id_jabatan = $data_karyawan[0]->id_position;
                }else{
                    $id_jabatan = 5; //staff
                }

                $data_dinas = $this->db->query("SELECT * FROM dinas_approve WHERE status='1' ORDER BY approve_date DESC")->result();
                if($data_dinas){
                    $last_no = $data_dinas[0]->no_surat;
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
                
                $no_surat = $nol.''.$no_urut_new.'/ST/LIB/'.date('m').'/'.date('Y');
                $data = array(
                    'no_surat'          => $no_surat,
                    'status'            => 1,
                    'updated_date'      => date('Y-m-d'),
                    'approve_date'      => date('Y-m-d H:i:s')
                );

                $this->db->where('id_dinas',$id_dinas);
                $this->db->update('dinas_approve',$data);

                $get_biaya_dinas = $this->db->query("SELECT * FROM biaya_dinas")->result();
                $tot =0;
                foreach($get_biaya_dinas as $view){
                    //New LN
                    if($jabodetabek==1){//jabodetabek
                        $biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail2 WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan' AND jenis_perjalanan='1'")->result();
                    }else{
                        if($id_tujuan!=0){ //domestik
                            $biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail2 WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan' AND jenis_perjalanan='2'")->result();
                        }else{//LN
                            $biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail2 WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan' AND jenis_perjalanan='3'")->result();
                        }    
                    }
                    
                    
                    foreach($biaya_detail as $view2){
                        $data2 = array(
                            'id_dinas'            => $id_dinas,
                            'id_biaya_dinas'      => $view2->id_biaya_dinas,
                            'biaya'               => $view2->biaya
                        );    
                        $tot += $view2->biaya;
                        $this->db->insert('dinas_biaya',$data2);
                    }
                        
                }  

                $tot_holidays = (empty($get_employee)) ? 0 : $get_employee[0]->total_days_holiday;
                if($tot_holidays!=0){
                    $data_biaya = array(
                        'biaya'          => 0
                    );

                    $this->db->where('id_dinas',$id_dinas);
                    $this->db->where('id_biaya_dinas',1);
                    $this->db->update('dinas_biaya',$data_biaya);
                } 

                $cek_akses_bandara = $this->db->query("SELECT * FROM provinsi_kota WHERE id_provinsi_kota='$id_tujuan'")->result();
                $akses_bandara = $cek_akses_bandara[0]->akses_bandara;
            
                //new LN
                if($id_tujuan!=0){
                    if($akses_bandara==0){
                        $data_update = array(
                            'biaya'     => 0
                        );
                        $this->db->where('id_dinas',$id_dinas);
                        $this->db->where('id_biaya_dinas',2);
                        $this->db->update('dinas_biaya',$data_update);
                    }//new 11/22/2017
                }

                $cek_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='0' ORDER BY id_dinas_approve_dana ASC")->result();
                if($cek_approver_dana){
                    //new total holiday
                    $total_holiday = $get_employee[0]->total_days_holiday;

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
                    $id_approver_dana = $cek_approver_dana[0]->id_approver;
                    $id_dinas_approve_dana = $cek_approver_dana[0]->id_dinas_approve_dana;

                    //create token ke dinas approve dana
                    $token_new = md5(date('Ymdhis'));
                    $data_token = array(
                        'token' => $token_new
                    );
                    $this->db->where('id_dinas_approve_dana',$id_dinas_approve_dana);
                    $this->db->update('dinas_approve_dana',$data_token);

                    $get_email = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE employee.id_employee='$id_approver_dana' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
                    $emailto = $get_email[0]->email;
                    $emailto2 = $data_karyawan[0]->email_test;
                    $get_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND b.id_dinas=a.id_dinas")->result();
                    $alasan_backdate = $get_dinas[0]->alasan_backdate;//new 11/22/2017
                    $total_hari = $get_dinas[0]->total_days;
                    //new LN
                    if($id_tujuan!=0){
                        $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari) + $um_holiday;  
                        $total_dana_dinas2 = 0;  
                    }else{
                        $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport;
                        $total_dana_dinas2 = ($biaya_makan * $total_hari) + $um_holiday;
                    }//end LN
                    //$total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari);
                    $tanggal1 = strtotime($get_dinas[0]->start_date); 
                    $dt1 = date("d F Y  ", $tanggal1);
                    $tanggal2 = strtotime($get_dinas[0]->end_date); 
                    $dt2 = date("d F Y  ", $tanggal2);

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
                                            Kepada Yth, <br>
                                            ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br>
                                            ".$get_email[0]->Title." ".$get_email[0]->firstname."</p>
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
                                       
                                    </tr>";
                                    if($alasan_backdate!=''){//new 11/22/2017
                                        $message .= "<tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Alasan Backdate
                                            </td>
                                            <td colspan='3'>: ".$alasan_backdate."</td>
                                        </tr>";
                                        }
                                    $message.="<tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Telah disetujui oleh 
                                        </td>
                                        <td colspan='3'>: ".$nama_approver."</td>  
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jumlah Total Dana 
                                        </td>
                                        <td colspan='3'>: Rp. ".number_format($total_dana_dinas).""; 
                                        if($id_tujuan==0){ 
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
                                    if($id_tujuan==0){//new 11/22/2017
                                        $message .= "<tr>
                                        <td valign='top' style='text-align:right'>
                                            Uang makan 
                                        </td>
                                        <td colspan='3'>: $. ".number_format($biaya_makan*$total_hari)."</td>
                                       
                                    </tr>";
                                        }
                                    if($id_tujuan!=0){//new 11/22/2017 
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
                                            <a href='".base_url()."dinas_approvel/approve_pengajuan_dana/".$id_dinas_approve_dana."/".$token_new."' class='button'>Setujui</a>
                                            <a href='".base_url()."dinas_approvel/tolak_pengajuan_dana/".$id_dinas_approve_dana."/".$token_new."' class='button2'>Tolak</a> 
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
                    $mail->Subject = 'Pengajuan dana perjalanan dinas'; 
                    $mail->Body = $message; 
                    $mail->AddAddress($emailto);
                    $mail->AddBcc('idam@ligaindonesiabaru.com');
                    $kirim = $mail->Send();
                    
                }
                
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
                redirect("dinas_approvel/approve_status");  
            } 
            
        }
    }

    function approve_pengajuan_dana($id_dinas_approve_dana,$token){
        $validasi = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas_approve_dana='$id_dinas_approve_dana' AND token='$token'")->result();
        if(!$validasi){
            redirect('dinas_approvel/no_access');
        }else{
            $cek_approved = $validasi[0]->status;
            if($cek_approved==1){
                redirect("dinas_approvel/approve_status_dana2");
            }else{
                $data = array(
                        'status'            => 1,
                        'approve_date'      => date('Y-m-d'),
                    );

                        
                    $this->db->where('id_dinas_approve_dana',$id_dinas_approve_dana);
                    $this->db->update('dinas_approve_dana',$data);

                    $get_id_dinas = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas_approve_dana='$id_dinas_approve_dana'")->result();
                    $id_dinas = $get_id_dinas[0]->id_dinas;
                    $get_id_employee = $this->db->query("SELECT * From dinas WHERE id_dinas='$id_dinas'")->result();

                    //start new 21-11-18
                        $total_holiday = $get_id_employee[0]->total_days_holiday;

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
                        //end new 21-11-18

                    $id_employee = $get_id_employee[0]->id_employee;
                    //new LN
                    $id_tujuan = $get_id_employee[0]->id_tujuan;
                    //LN
                    $cek_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='0' ORDER BY id_dinas_approve_dana ASC")->result();
                    if($cek_approver_dana){
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
                        $id_approver_dana = $cek_approver_dana[0]->id_approver;
                        $id_dinas_approve_dana = $cek_approver_dana[0]->id_dinas_approve_dana;

                        //create token ke dinas approve dana
                        $token_new = md5(date('Ymdhis'));
                        $data_token = array(
                            'token' => $token_new
                        );
                        $this->db->where('id_dinas_approve_dana',$id_dinas_approve_dana);
                        $this->db->update('dinas_approve_dana',$data_token);

                        $get_email = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver_dana' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
                        $emailto = $get_email[0]->email;
                        
                        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                        $get_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND b.id_dinas=a.id_dinas")->result();
                        $alasan_backdate = $get_dinas[0]->alasan_backdate;//new 11/22/2017
                        $total_hari = $get_dinas[0]->total_days;
                        //$total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari);
                        if($id_tujuan!=0){
                            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari) + $um_holiday;  
                            $total_dana_dinas2 = 0;  
                        }else{
                            $total_dana_dinas = $biaya_tranport;
                            $total_dana_dinas2 = $biaya_makan * $total_hari;
                        }
                        $cek_biaya = $this->db->query("SELECT sum(biaya) as tot FROM dinas_biaya WHERE id_dinas='$id_dinas'")->result();
                        $tot = $cek_biaya[0]->tot;
                        $tanggal1 = strtotime($get_dinas[0]->start_date); 
                        $dt1 = date("d F Y  ", $tanggal1);
                        $tanggal2 = strtotime($get_dinas[0]->end_date); 
                        $dt2 = date("d F Y  ", $tanggal2);

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
                                            Kepada Yth, <br>
                                            ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br>
                                            ".$get_email[0]->title." ".$get_email[0]->firstname."</p>
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
                                        if($id_tujuan==0){ 
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
                                    if($id_tujuan==0){//new 11/22/2017
                                        $message .= "<tr>
                                        <td valign='top' style='text-align:right'>
                                            Uang makan 
                                        </td>
                                        <td colspan='3'>: $. ".number_format($biaya_makan*$total_hari)."</td>
                                       
                                    </tr>";
                                        }
                                    if($id_tujuan!=0){//new 11/22/2017 
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
                                            <a href='".base_url()."dinas_approvel/approve_pengajuan_dana/".$id_dinas_approve_dana."/".$token_new."' class='button'>Setujui</a>
                                            <a href='".base_url()."dinas_approvel/tolak_pengajuan_dana/".$id_dinas_approve_dana."/".$token_new."' class='button2'>Tolak</a> 
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
                        $mail->AddAddress($emailto);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();
                    }else{
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
                            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $total_hari) + $um_holiday;  
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
                                            Ibu Ismene</p>
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
                                        <td colspan='3'>: Rp. ".number_format($total_dana_dinas).""; 
                                        if($id_tujuan==0){ 
                                            $message.= " + $. ".number_format($total_dana_dinas2)."";

                                        } 
                                    $message.="</td> 
                                       
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
                }
            }
            
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
            redirect("dinas_approvel/approve_status_dana");
    }

    function tolak_pengajuan_dana($id_dinas_approve_dana,$token){
        $validasi = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas_approve_dana='$id_dinas_approve_dana' AND token='$token'")->result();
        if(!$validasi){
            redirect('dinas_approvel/no_access');
        }else{
            $cek_approved = $validasi[0]->status;
            if($cek_approved==1){
                redirect("dinas_approvel/approve_status_dana2");
            }else{
                $data = array(
                        'status'            => 2,
                        'approve_date'      => date('Y-m-d'),
                    );

                        
                    $this->db->where('id_dinas_approve_dana',$id_dinas_approve_dana);
                    $this->db->update('dinas_approve_dana',$data);

                    $get_id_dinas = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas_approve_dana='$id_dinas_approve_dana'")->result();
                    $id_approver = $get_id_dinas[0]->id_approver;
                    $get_approver = $this->db->query("SELECT * From employee WHERE id_employee='$id_approver'")->result();
                    $id_dinas = $get_id_dinas[0]->id_dinas;
                    $get_id_employee = $this->db->query("SELECT * From dinas WHERE id_dinas='$id_dinas'")->result();
                    $id_employee = $get_id_employee[0]->id_employee;
                    //new LN
                    $id_tujuan = $get_id_employee[0]->id_tujuan;
                    //LN
                        
                        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                        $get_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND b.id_dinas=a.id_dinas")->result();
                        $emailto_tes = $data_karyawan[0]->email;
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
                                            ".$data_karyawan[0]->title." ".$data_karyawan[0]->firstname."</p>    
                                            <p>".$get_approver[0]->title." ".$get_approver[0]->firstname." menolak pengajuan dana perjalanan dinas Anda : </p>
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
                                            Tujuan 
                                        </td>
                                        <td colspan='3'>: ".$get_dinas[0]->tujuan."</td>
                                       
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
                        $emailto_tes2 = 'nuri.rahmat@ligaindonesiabaru.com';
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
                        $mail->AddAddress($emailto_tes);
                        $mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail->Send();
                    }
                }
            
            
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
            redirect("dinas_approvel/approve_status_dana3");
    }

    function tolak_pengajuan_dinas($id_dinas,$token){
        $validasi = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas' AND token='$token'")->result();
        if(!$validasi){
            redirect('dinas_approvel/no_access');
        }else{
            $cek_approved = $validasi[0]->status;
            if($cek_approved==1){
                redirect("dinas_approvel/approve_status4");
            }else{
                $get_employee = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
                $id_employee = $get_employee[0]->id_employee;
                $user_id = $this->session->userdata('user_id');
                $get_jabatan = $this->db->query("SELECT id_position as jabatan FROM employee WHERE id_employee='$id_employee'")->result();
                if($get_jabatan){
                    $id_jabatan = $get_jabatan[0]->jabatan;
                }else{
                    $id_jabatan = 5; //staff
                }

                    $data = array(
                        'no_surat'          => '',
                        'status'            => 2,
                        'updated_date'      => date('Y-m-d'),
                    );    
            
                $this->db->where('id_dinas',$id_dinas);
                $this->db->update('dinas_approve',$data);
                
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
                redirect("dinas_approvel/approve_status2");  
            }  
        }
    }

    public function print_dana($id_dinas)
    {
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

        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_biaya b, dinas_approve c WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas AND c.id_dinas=a.id_dinas")->result();
        $id_atasan = $data_dinas[0]->id_approver;
        $get_atasan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_atasan'")->result();
        $jumlah_biaya = 0;
        foreach($data_dinas as $view){
            $jumlah_biaya += $view->biaya;
        }
        $jumlah_hari = $data_dinas[0]->total_days;
        $id_tujuan = $data_dinas[0]->id_tujuan;
        if($id_tujuan!=0){
            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $jumlah_hari);  
            $total_dana_dinas2 = 0;  
        }else{
            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport;
            $total_dana_dinas2 = $biaya_makan * $jumlah_hari;
        }
        //$total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $jumlah_hari);
        $tot_biaya = $jumlah_biaya * $jumlah_hari;

        $id_employee = $data_dinas[0]->id_employee;
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_division = $data_employee[0]->id_division;
        $data_divisi = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();

        //data direktur
        $data_dir = $this->db->query("SELECT * FROM employee a, jabatan b, jabatan_sub_dept c WHERE a.id_position=b.id_jabatan AND b.id_jabatan=c.id_jabatan AND c.id_division='$id_division'")->result();
        $data_approve_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND id_approver='10010' AND status='1'")->result();
        if($data_approve_dana){
            $approve_irz = 1;
        }else{
            $approve_irz = 0;
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_dinas'    => $data_dinas,
            'data_divisi'   => $data_divisi[0]->division_name,
            'data_employee' => $data_employee, 
            'data_atasan'   => $get_atasan,
            'data_dir'      => $data_dir,
            'biaya'         => $total_dana_dinas,
            'biaya2'         => $total_dana_dinas2,
            'id_dinas'      => $id_dinas,
            'terbilang'     => $terbilang,
            'jumlah_hari'   => $jumlah_hari,
            'biaya_transport' => $biaya_tranport,
            'biaya_makan'   => $biaya_makan,
            'biaya_pulsa'   => $biaya_telekomunikasi,
            'approve_old'   => $approve_irz
        );
        //$this->template->load('template','payroll/printpdf',$data);
        $html                   = $this->load->view('dinas/dana',$data,true);
        $pdfFilePath            = "suratpengajuandana-".date('y-m-d').".pdf";
        $pdfFilePath            = "suratpengajuandana.pdf";
                                  $this->load->library('m_pdf');
        $pdf                    = $this->m_pdf->load();
        $mpdf                   = new mPDF('c', 'A4-L');
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I"); 
    }

    function approve_status(){
        $this->load->view('dinas/email');
    }

    function approve_status2(){
        $this->load->view('dinas/email2');
    }

    function approve_status3(){
        $this->load->view('dinas/email3');
    }

    function approve_status4(){
        $this->load->view('dinas/email4');
    }

    function approve_status_dana(){
        $this->load->view('dinas/notif_dana');
    }

    function approve_status_dana2(){
        $this->load->view('dinas/notif_dana2');
    }

    function approve_status_dana3(){
        $this->load->view('dinas/notif_dana3');
    }
}