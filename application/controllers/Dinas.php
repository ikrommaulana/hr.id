<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dinas extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "dinas"); //mensetting menuKepilih atau menu aktif
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
            'data_dinas' => $this->db->query("SELECT * FROM dinas WHERE id_employee='$user_id' ORDER BY id_dinas DESC")->result()
        );
        $this->template->load('template','dinas/index',$data);
    }

    public function index_($id_employee)//cek by user id
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
            'data_dinas' => $this->db->query("SELECT * FROM dinas WHERE id_employee='$id_employee' ORDER BY id_dinas DESC")->result()
        );
        $this->template->load('template','dinas/index',$data);
    }

    public function print_surat($id_dinas)
    {
        $this->session->set_flashdata("halaman", "dinas"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas")->result();
        $id_employee = $data_dinas[0]->id_employee;
        $id_approver = $data_dinas[0]->id_approver;
        $data_employee = $this->db->query("SELECT * FROM employee a, division b WHERE a.id_employee='$id_employee' AND a.id_division=b.id_division")->result();
        if(empty($data_employee)){
            $data_employee = $this->db->query("SELECT * FROM employee where id_employee='$id_employee'")->result();
        }
        $data_approver = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.id_employee='$id_approver' AND a.id_position=b.id_jabatan")->result();
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_dinas'    => $data_dinas,
            'data_employee' => $data_employee,
            'data_approver' => $data_approver
        );
        //$this->template->load('template','payroll/printpdf',$data);
        $html                   = $this->load->view('dinas/print',$data,true);
        $pdfFilePath            = "suratdinas-".date('y-m-d').".pdf";
        $pdfFilePath            = "suratdinas.pdf";
                                  $this->load->library('m_pdf');
        $pdf                    = $this->m_pdf->load();
        $mpdf                   = new mPDF('c', 'A4-L');
        $pdf->WriteHTML($html);
        $pdf->Output($pdfFilePath, "I"); 
    }

    public function print_dana($id_dinas)
    {
        $this->session->set_flashdata("halaman", "dinas"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_biaya b, dinas_approve c WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas AND c.id_dinas=a.id_dinas")->result();
        $data_dinas_holiday = $this->db->query("SELECT * FROM dinas where id_dinas='$id_dinas'")->result();
        $id_atasan = $data_dinas[0]->id_approver;
        $get_atasan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_atasan'")->result();
        $jumlah_biaya = 0;
        foreach($data_dinas as $view){
            $jumlah_biaya += $view->biaya;
        }

        //new total holiday
        $total_holiday = $data_dinas_holiday[0]->total_days_holiday;

        $cek_biaya_makan_holiday = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas' AND id_biaya_dinas='4'")->result();
        if($cek_biaya_makan_holiday){
            $tot_um_holiday = $cek_biaya_makan_holiday[0]->biaya;
        }else{
            $tot_um_holiday = 0;
        }

        if($total_holiday!=''){
            //if($cek_biaya_makan_holiday){
            //    $um_holiday = $tot_um_holiday * $total_holiday;
            //}else{
                $um_holiday = $total_holiday * 300000; // pengajuan lama/manual
            //}
        }else{
            $um_holiday = 0;
        }

        //new rev
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


        $jumlah_hari = $data_dinas[0]->total_days;
        $id_tujuan = $data_dinas[0]->id_tujuan;
                        
        if($id_tujuan!=0){
            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $jumlah_hari) + $um_holiday;  
            $total_dana_dinas2 = 0;  
        }else{
            $total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport;
            $total_dana_dinas2 = ($biaya_makan * $jumlah_hari) + $um_holiday;
        }
        //$total_dana_dinas = $biaya_telekomunikasi + $biaya_tranport + ($biaya_makan * $jumlah_hari);
        $tot_biaya = $jumlah_biaya * $jumlah_hari;//not use

        $id_employee = $data_dinas[0]->id_employee;
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $id_division = $data_employee[0]->id_division;
        $data_divisi = $this->db->query("SELECT * FROM division WHERE id_division='$id_division'")->result();
        $div_name = (empty($data_divisi)) ? '' : $data_divisi[0]->division_name;

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
            'data_divisi'   => $div_name,
            'data_employee' => $data_employee,
            'data_atasan'   => $get_atasan,
            'data_dir'      => $data_dir,
            'biaya'         => $total_dana_dinas,
            'biaya2'         => $total_dana_dinas2,
            'id_dinas'      => $id_dinas,
            'jumlah_hari'   => $jumlah_hari,
            'biaya_transport' => $biaya_tranport,
            'biaya_makan'   => $biaya_makan,
            'biaya_pulsa'   => $biaya_telekomunikasi,
            'approve_old'   => $approve_irz,
            'total_holiday' => $total_holiday
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

    function dinas(){
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

        $this->template->load('template','dinas/dinas',$data);
    }

    function data_provinsi(){ 
        $user_id = $this->session->userdata('user_id');
        $id_provinsi = $this->input->get('option');
        $data_kota = $this->db->query("SELECT * FROM provinsi_kota WHERE id_provinsi='$id_provinsi'")->result();
        if($data_kota){
            echo '<select class="form-control p-0" id="input155" required name="kota" required>
                    <option value=""></option>'; foreach($data_kota as $view){
                        echo '<option value="'.$view->id_provinsi_kota.'">'.$view->nama_kota.'</option>';
                    }
                    echo '</select><span class="highlight"></span> <span class="bar"></span>
                    <label for="input155" id="input155">Kota</label>';
        }
    }

    function data_jenis(){ 
        $user_id = $this->session->userdata('user_id');
        $id_jenis_perj = $this->input->get('option');
        if($id_jenis_perj=='0'){
            $data_perj = $this->db->query("SELECT * FROM provinsi")->result();
            if($data_perj){
                echo '<select class="form-control p-0" id="input15" name="jenis_perjalanan" required onchange="return provinsi();">
                        <option value=""></option>'; foreach($data_perj as $view){
                            echo '<option value="'.$view->id_provinsi.'">'.$view->nama_provinsi.'</option>';
                        }
                        echo '</select><span class="highlight"></span> <span class="bar"></span>
                        <label for="input155">Provinsi</label>';
            }    
        }elseif($id_jenis_perj=='1'){
            $data_perj = $this->db->query("SELECT * FROM negara")->result();
            if($data_perj){
                echo '<select class="form-control p-0" id="input1555" name="negara" required>
                        <option value=""></option>'; foreach($data_perj as $view){
                            echo '<option value="'.$view->id_negara.'">'.$view->nama_negara.'</option>';
                        }
                        echo '</select><span class="highlight"></span> <span class="bar"></span>
                        <label for="input1555">Negara</label> <style>#input155{display:none;}</style>';
            }
        }else{
            echo '<style>#input155{display:none;}</style>';
        }
        
    }

    function data_tgl(){ 
        $user_id = $this->session->userdata('user_id');
        $tgl = $this->input->get('option');
        $date = explode(' - ', $tgl);
        $start  = date('Y-m-d', strtotime($date[0]));
        $now = date('Y-m-d');

        if($start < $now){
            echo '<input class="form-control" type="text" id="input133" required name="alasan" value="" /><span class="highlight"></span> <span class="bar"></span>
                    <label for="input133">Alasan Back Date</label>';
        }
    }

    public function add_edit_data($id_dinas=''){
        $user_id = $this->session->userdata('user_id');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_division = $this->session->userdata('id_division');
        $daterange = $this->input->post('tanggal');
        $date = explode(' - ', $daterange);
        $start  = date('Y-m-d', strtotime($date[0]));
        $end        = date('Y-m-d', strtotime($date[1]));

        if($id_jabatan==5 || $id_jabatan==11){
            $cek_holiday = $this->db->query("SELECT * FROM hari_libur WHERE tanggal>='$start' AND tanggal<='$end'")->result();
            if ($cek_holiday) {
                $hari_libur = count($cek_holiday);
            }else{
                $hari_libur = 0;
            }
        }else{
            $hari_libur = 0;
        }

        $date1  = date('d/m/y', strtotime($date[0]));
        $date2    = date('d/m/y', strtotime($date[1]));
        $interval = $date2-$date1;
        $libur_weekend = 0;
        for($a=0;$a<=$interval;$a++){
            $hari = date('l', strtotime('+'.$a.' days', strtotime($date1)));
            if(($hari=='Saturday') || ($hari=='Sunday')){
                $libur_weekend =  $libur_weekend+1;
            }
        }

        $tot_hari_libur = $hari_libur + $libur_weekend;

        $s = strtotime($start);
        $e = strtotime($end);
        $timeDiff = abs($e - $s);
        $numberDays = $timeDiff/86400;
        $numberDays1 = intval($numberDays);
        $numberDays2 = $numberDays1 + 1; 
        $skr = date('Y-m-d');
        $cek_available = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_employee='$user_id' AND a.start_date<='$start' AND a.end_date>='$start' AND a.id_dinas=b.id_dinas AND b.status='1' AND a.status='0'")->result();
        $jml_data = count($cek_available);
        if($jml_data>0){    
            echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Anda telah mengajukan perjalanan dinas ditanggal yang sama !')
                        window.location.href='".base_url()."dinas/dinas';
                        </SCRIPT>");
        }else{
            $get_approver_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
            $get_approver = (empty($get_approver_employee)) ? '' : $get_approver_employee[0]->approver;

            $get_level_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
            $level_jabatan_karyawan = $get_level_jabatan[0]->level;
            $level_jabatan = $level_jabatan_karyawan+1;

            if($get_approver!=''){
                $id_approver = $get_approver;
            }else{
                $get_approver = $this->db->query("SELECT * FROM jabatan WHERE level='$level_jabatan'")->result();
                if($get_approver){
                    $get_id_jabatan = $get_approver[0]->id_jabatan;
                    $get_approver2 = $this->db->query("SELECT * FROM employee WHERE id_employee!='$user_id' AND id_position='$get_id_jabatan' AND id_division='$id_division'")->result();
                    if($get_approver2){ //get manager
                        $id_approver = $get_approver2[0]->id_employee;    
                    }else{ //get direktur
                        $get_approver3 = $this->db->query("SELECT * FROM employee WHERE id_employee!='$user_id' AND id_position='$get_id_jabatan'")->result();
                        $id_approver = $get_approver3[0]->id_employee;
                    }
                }
            }

            
            if($id_dinas==''){
                $data_dinas = $this->db->query("SELECT * FROM dinas ORDER BY id_dinas DESC")->result();
                if($data_dinas){
                    $new_id_dinas = $data_dinas[0]->id_dinas + 1;
                }else{
                    $new_id_dinas = 1;
                }

                $id_provinsi_kota = $this->input->post('kota');
                $alasan = $this->input->post('alasan');
                if($alasan){
                    $alasan_backdate = $alasan;
                }else{
                    $alasan_backdate = '';
                }
                if($id_provinsi_kota){
                    $get_kota = $this->db->query("SELECT * FROM provinsi_kota WHERE id_provinsi_kota='$id_provinsi_kota'")->result();    
                    if($get_kota){
                        $tujuan = $get_kota[0]->nama_kota;
                        $id_tujuan = $id_provinsi_kota;
                        $id_tujuan_negara = '';
                        $jabodetabek = $get_kota[0]->jabodetabek;
                    }else{
                        $tujuan = '';
                        $id_tujuan = '';
                        $id_tujuan_negara = '';
                        $jabodetabek = 0;
                    }
                }else{
                    $id_negara = $this->input->post('negara');
                    $get_negara = $this->db->query("SELECT * FROM negara WHERE id_negara='$id_negara'")->result();
                    if($get_negara){
                        $tujuan = $get_negara[0]->nama_negara;
                        $id_tujuan_negara = $id_negara;
                        $id_tujuan = '';
                        $jabodetabek = 0;
                    }else{
                        $tujuan = '';
                        $id_tujuan_negara = '';
                        $id_tujuan = '';
                        $jabodetabek = 0;
                    }
                }

                $data = array(
                    'id_dinas'       => $new_id_dinas,
                    'id_employee'    => $user_id,
                    'keperluan'      => $this->input->post('keperluan'),
                    'start_date'     => $start,
                    'end_date'       => $end,
                    'total_days'     => $numberDays2,
                    'tujuan'         => $tujuan, 
                    'id_tujuan'      => $id_tujuan,
                    'jabodetabek'    => $jabodetabek,
                    'id_tujuan_negara' => $id_tujuan_negara,
                    'alasan_backdate'=> $alasan_backdate,
                    'total_days_holiday'    => $tot_hari_libur,
                    'created_date'   => date('Y-m-d'),
                    'created_by'     => $user_id
                );
                $this->db->insert('dinas', $data);
                $token = md5(date('Ymdhis'));

                if($id_approver!=''){
                    $data_approver = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => $id_approver,
                        'token'         => $token,
                        'status'        => 0
                    );
                    $this->db->insert('dinas_approve',$data_approver);
                }else{
                    $data_approver = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => $id_approver,
                        'token'         => $token,
                        'status'        => 0
                    );
                    $this->db->insert('dinas_approve',$data_approver);
                }

                if($level_jabatan_karyawan==1 && $id_division==7){  //new 11-5-2017 level staff divisi league enterprise
                    //irzan ganti robin 3/7/2018
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1 && $id_division==3){  //new 11-5-2017 level staff divisi marketing
                    //raphael
                    /*$data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10011
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //robin
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==3 && $id_division==3){  //new 18-01-2019 level manager divisi marketing
                    //raphael
                    /*$data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10011
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //robin
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1 && $id_division==8){  //new 11-5-2017 level staff divisi secretary
                    
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1 && $id_division==2){  //new 11-5-2017 level staff divisi IT
                    //marco
                    /*
                    $data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10060 //10055
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);
                    */
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1 && $id_division==10){  //new 11-5-2017 level staff divisi media
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1 && $id_division==4){  //level staff divisi finance
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==3 && $id_division==2){ //new 5-11-2017 level manager IT
                    //marco
                    /*
                    $data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10060 //10055
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);
                    */
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==3 && $id_division==6){ //new 5-11-2017 level manager kompetisi
                    //Tigor
                    /*
                    $data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10060 //10008
                        );    
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);
                    */
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==2 && $id_division==16){ //new 5-11-2017 level senior staff inavation
                    //marco
                    /*
                    $data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10055
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);
                    */
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==3){ //new 5-11-2017 level divisi legal
                    //marco
                    /*
                    $data_approver_dana2 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10060 //10055
                        );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);
                    */
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1){ //new 5-11-2017 level jabatan 1
                    //Finance
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //Direktur
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1){ //new 5-11-2017 level jabatan staff khusus
                    //Finance
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //Direktur
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==1){  //level staff
                    /*$get_level3 = $this->db->query("SELECT * FROM jabatan_sub_dept a, employee b WHERE a.id_division='$id_division' AND a.id_jabatan=b.id_position")->result();
                    $id_approver_level3 = $get_level3[0]->id_employee;
                    $data_approver_dana1 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => $id_approver_level3
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana1);
                    */
                    //new update jika bukan divisi finance & HR
                    if($id_division!=4 && $id_division!=5){
                        //irzan ganti robin
                        $data_approver_dana3 = array(
                            'id_dinas'     => $new_id_dinas,
                            'id_approver'   => 10056 //10050
                        );
                        $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    }
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==2 && $id_division==7){ //new 5-11-2017 level manager league enterprise ryan
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==2 && $id_division==8){ //new 5-11-2017 level manager secretary amalia
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }elseif($level_jabatan_karyawan==2){ //level manager
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/                
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);   
                }else{ //level direktur
                    //teddy
                    /*$data_approver_dana2 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10009
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana2);*/
                    //irzan ganti robin
                    $data_approver_dana3 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10056 //10050
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana3);
                    //risha
                    $data_approver_dana4 = array(
                        'id_dinas'     => $new_id_dinas,
                        'id_approver'   => 10060 //10007
                    );
                    $this->db->insert('dinas_approve_dana',$data_approver_dana4);     
                }

                $data_karyawan = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan and employee.id_employee='$user_id'")->result();
                $data_approver = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan and employee.id_employee='$id_approver'")->result();

                if($data_approver){
                    $email_approver = $data_approver[0]->email;
                }else{
                    $email_approver = 'idam@ligaindonesiabaru.com';
                }

                $tanggal1 = strtotime($start); 
                $dt1 = date("d F Y  ", $tanggal1);
                $tanggal2 = strtotime($end); 
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
                                            <td colspan='3'>: ".$get_kota[0]->nama_kota."</td>
                                        </tr>
                                        <tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Keperluan
                                            </td>
                                            <td colspan='3'>: ".$this->input->post('keperluan')."</td>
                                        </tr>";
                                        if($alasan_backdate!=''){
                                        $message .= "<tr>
                                            <td valign='top' style='padding-left:20px'>
                                                Alasan Backdate
                                            </td>
                                            <td colspan='3'>: ".$alasan_backdate."</td>
                                        </tr>";
                                        }
                                        $message.="<tr height='30'></tr>
                                        <tr>
                                            <td colspan='3' style='padding-left:20px'>
                                                <a href='".base_url()."dinas_approvel/approve_pengajuan_dinas/".$new_id_dinas."/".$token."' class='button'>Setujui</a>
                                                <a href='".base_url()."dinas_approvel/tolak_pengajuan_dinas/".$new_id_dinas."/".$token."' class='button2'>Tolak</a> 
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
                $mail->AddAddress($email_approver);
                $mail->AddBcc('hr@ligaindonesiabaru.com');
                $mail->AddBcc('idam@ligaindonesiabaru.com');
                $mail->Send();
                redirect('index/');
                if($this->db->affected_rows()!=0){
                    
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully added !!</div>");
                    redirect("dinas");
                }
            }else{
                $data = array(
                    'id_employee'    => $user_id,
                    'keperluan'      => $this->input->post('keperluan'),
                    'start_date'     => $start,
                    'end_date'       => $end,
                    'tujuan'         => $this->input->post('tujuan'),
                    'updated_date'  => date('Y-m-d'),
                    'updated_by'    => $user_id
                );
                    
                $this->db->where('id_dinas', $id_dinas);
                $this->db->update('dinas', $data);
        
                if($this->db->affected_rows()!=0){
                    $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
                    redirect("dinas");
                }
            }
        }
    }

    function update_dinas($id_dinas){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        
        $data = array(
            'role_id'           => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'        => $data_dinas,
            'user_id'           => $user_id
         );
        
        $this->template->load('template','dinas/edit_dinas',$data);
    }

    function update_dinas_act($id_dinas){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        
        $data = array(
            'keperluan'      => $this->input->post('keperluan'),
            'updated_date'  => date('Y-m-d'),
            'updated_by'    => $user_id
        );
                    
        $this->db->where('id_dinas', $id_dinas);
        $this->db->update('dinas', $data);
        
        if($this->db->affected_rows()!=0){
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully updated !!</div>");
            redirect("dinas");
        }
    }

    //approve by mail not use
    function approve_pengajuan_dinas($id_dinas){
        $get_employee = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        $id_employee = $get_employee[0]->id_employee;
        //new LN
        $id_tujuan = $get_employee[0]->id_tujuan;
        //LN
        $user_id = $this->session->userdata('user_id');
        $get_jabatan = $this->db->query("SELECT id_position as jabatan FROM employee WHERE id_employee='$id_employee'")->result();
        if($get_jabatan){
            $id_jabatan = $get_jabatan[0]->jabatan;
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

            $get_biaya_dinas = $this->db->query("SELECT * FROM biaya_dinas")->result();
            $tot =0;
            foreach($get_biaya_dinas as $view){
                //$biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan'")->result();
                //New LN
                if($id_tujuan!=0){ //domestik
                    $biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan' AND jenis_perjalanan='0'")->result();
                }else{//LN
                    $biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan' AND jenis_perjalanan='1'")->result();
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
    
        $this->db->where('id_dinas',$id_dinas);
        $this->db->where('id_approver',$user_id);
        $this->db->update('dinas_approve',$data);

        $cek_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='0' ORDER BY id_dinas_approve_dana ASC")->result();
        if($cek_approver_dana){
            $id_approver_dana = $cek_approver_dana[0]->id_approver;
            $id_dinas_approve_dana = $cek_approver_dana[0]->id_dinas_approve_dana;
            $get_email = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver_dana'")->result();
            $emailto = $get_email[0]->email;
            $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
            $get_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND b.id_dinas=a.id_dinas")->result();
            $total_hari = $get_dinas[0]->total_days;
            $tanggal1 = strtotime($get_dinas[0]->start_date); 
            $dt1 = date("d F Y  ", $tanggal1);
            $tanggal2 = strtotime($get_dinas[0]->end_date); 
            $dt2 = date("d F Y  ", $tanggal2);
            $message .= '<html><head>
                          <meta name="viewport" content="width=device-width, initial-scale=1">
                          </head>';
            $message .= '<body><p><img src="'.base_url().'assets/images/logo.jpg" class="lib-logo" width="150px" /></p>';
            $message .= $data_karyawan[0]->firstname. " mengajukan pengajuan dana perjalanan dinas :<br>";
            $message .= "No Surat : ".$get_dinas[0]->no_surat."<br>";
            $message .= "Tanggal : ".$dt1." - ".$dt2."<br>";
            $message .= "Tujuan : ".$get_dinas[0]->tujuan."<br>";
            $message .= "Keperluan : ".$get_dinas[0]->keperluan."<br><br>";
            $message .= "Jumlah Total Dana  : Rp".number_format($tot * $total_hari)."<br><br>";
            $message .= "note  : ini email untuk".$get_email[0]->firstname."<br><br>";
            $message .= '<a href="'.base_url().'approve_pengajuan_dana/'.$id_dinas_approve_dana.'">Setujui</a><a href="'.base_url().'dinas/tolak_pengajuan_dana/'.$id_dinas_approve_dana.'">Tolak</a></body></html>';
     
            $mail = new PHPMailer(); 
            $mail->From     = 'hr@ligaindonesiabaru.com';
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
            $mail->Username = 'hr@ligaindonesiabaru.com'; //username email 
            $mail->Password = 'hrl!B2017'; //password email 
            $mail->SMTPSecure = "ssl";
            $mail->Host ='smtp.gmail.com'; 
            $mail->Port = 465; //port secure ssl email 
            $mail->IsHTML(true);
            $mail->Subject = 'Pengajuan dana perjalanan dinas'; 
            $mail->Body = $message; 
            $mail->AddAddress($emailto);
            $mail->AddBcc('idam@ligaindonesiabaru.com');
            $mail->Send();
        }
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("dinas/approve_status");
    }

    function approve_pengajuan_dana($id_dinas_approve_dana){

        $data = array(
            'status'            => 1,
            'approve_date'      => date('Y-m-d'),
        );

            
        $this->db->where('id_dinas_approve_dana',$id_dinas_approve_dana);
        $this->db->update('dinas_approve_dana',$data);

        $get_id_dinas = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas_approve_dana='$id_dinas_approve_dana'")->result();
        $id_dinas = $get_id_dinas[0]->id_dinas;
        $get_id_employee = $this->db->query("SELECT * From dinas WHERE id_dinas='$id_dinas'")->result();
        $id_employee = $get_id_employee[0]->id_employee;

        $cek_approver_dana = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas' AND status='0' ORDER BY id_dinas_approve_dana ASC")->result();
        if($cek_approver_dana){
            $id_approver_dana = $cek_approver_dana[0]->id_approver;
            $id_dinas_approve_dana = $cek_approver_dana[0]->id_dinas_approve_dana;

            $get_email = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_approver_dana'")->result();
            $emailto = $get_email[0]->email;
            
            $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
            $get_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas='$id_dinas' AND b.id_dinas=a.id_dinas")->result();
            
            $total_hari = $get_dinas[0]->total_days;
            
            $cek_biaya = $this->db->query("SELECT sum(biaya) as tot FROM dinas_biaya WHERE id_dinas='$id_dinas'")->result();
            $tot = $cek_biaya[0]->tot;
            $tanggal1 = strtotime($get_dinas[0]->start_date); 
            $dt1 = date("d F Y  ", $tanggal1);
            $tanggal2 = strtotime($get_dinas[0]->end_date); 
            $dt2 = date("d F Y  ", $tanggal2);
            $message .= '<html><head>
                          <meta name="viewport" content="width=device-width, initial-scale=1">
                          </head>';
            $message .= '<body><p><img src="'.base_url().'assets/images/logo.jpg" class="lib-logo" width="150px" /></p>';
            $message .= $data_karyawan[0]->firstname. " mengajukan pengajuan dana perjalanan dinas :<br>";
            $message .= "No Surat : ".$get_dinas[0]->no_surat."<br>";
            $message .= "Tanggal : ".$dt1." - ".$dt2."<br>";
            $message .= "Tujuan : ".$get_dinas[0]->tujuan."<br>";
            $message .= "Keperluan : ".$get_dinas[0]->keperluan."<br><br>";
            $message .= "Jumlah Total Dana  : Rp".number_format($tot * $total_hari)."<br><br>";
            $message .= "note  : ini email untuk".$get_email[0]->firstname."<br><br>";
            $message .= '<a href="'.base_url().'dinas/approve_pengajuan_dana/'.$id_dinas_approve_dana.'">Setujui</a><a href="'.base_url().'dinas/tolak_pengajuan_dana/'.$id_dinas_approve_dana.'">Tolak</a></body></html>';
     
            $mail = new PHPMailer(); 
            $mail->From     = 'hr@ligaindonesiabaru.com';
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
            $mail->Username = 'hr@ligaindonesiabaru.com'; //username email 
            $mail->Password = 'hrl!B2017'; //password email 
            $mail->SMTPSecure = "ssl";
            $mail->Host ='smtp.gmail.com'; 
            $mail->Port = 465; //port secure ssl email 
            $mail->IsHTML(true);
            $mail->Subject = 'Pengajuan permohonan dinas'; 
            $mail->Body = $message; 
            $mail->AddAddress($emailto);
            $mail->AddBcc('idam@ligaindonesiabaru.com');
            $mail->Send();
        }
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("dinas/approve_status");
    }

    function tolak_pengajuan_dinas($id_dinas){
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
        $this->db->where('id_approver',$user_id);
        $this->db->update('dinas_approve',$data);

        if($this->db->affected_rows()!=0){
            redirect("index");
        }
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("dinas/approve_status2");
    }

    function approve_pengajuan($id_dinas){
        $get_employee = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        $id_employee = $get_employee[0]->id_employee;
        $user_id = $this->session->userdata('user_id');
        $setuju = $this->input->post('setuju');
        $tidak_setuju = $this->input->post('tidak_setuju');
        $get_jabatan = $this->db->query("SELECT id_position as jabatan FROM employee WHERE id_employee='$id_employee'")->result();
        if($get_jabatan){
            $id_jabatan = $get_jabatan[0]->jabatan;
        }else{
            $id_jabatan = 5; //staff
        }

        if(isset($setuju)){
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

            $get_biaya_dinas = $this->db->query("SELECT * FROM biaya_dinas")->result();
            foreach($get_biaya_dinas as $view){
                $biaya_detail = $this->db->query("SELECT * FROM biaya_dinas_detail WHERE id_biaya_dinas='$view->id_biaya_dinas' AND id_jabatan='$id_jabatan'")->result();
                foreach($biaya_detail as $view2){
                    $data2 = array(
                        'id_dinas'            => $id_dinas,
                        'id_biaya_dinas'      => $view2->id_biaya_dinas,
                        'biaya'               => $view2->biaya
                    );    
                    $this->db->insert('dinas_biaya',$data2);
                }
                    
            }    
        }else{
            $data = array(
                'status'            => 2,
                'updated_date'      => date('Y-m-d'),
            );
        }
    
        $this->db->where('id_dinas',$id_dinas);
        $this->db->where('id_approver',$user_id);
        $this->db->update('dinas_approve',$data);

        if($this->db->affected_rows()!=0){
            redirect("index");
        }
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("dinas/approve_status");
    }

    function approve_status(){
        $this->load->view('dinas/email');
    }

    function approve_status2(){
        $this->load->view('dinas/email2');
    }

    function detail($id_dinas){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_division = $this->session->userdata('id_division');//new 12142017
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        
        $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        $data_dinas = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        $data_approve = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
        $id_requestor = $data_dinas[0]->created_by;

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

        if($id_division==5){
            $data_click = array(
                'click_status_hr'    => 1
            );    
        }else{
            $data_click = array(
                'click_status_atasan'    => 1
            );            
        }

        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas_approve',$data_click);

        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'      => $data_dinas,
            'data_requestor'    => $data_requestor,
            'status'            => $status,
            'tgl_diputuskan'    => $tgl_diputuskan,
            'id_employee_login'  => $user_id,
            'id_approver'       => $data_approve,
            'data_approver'     => $data_approve,
            'jabatan'           => $jabatan,
            'division'          => $dept
        );

        $this->template->load('template','dinas/detail',$data);
    }

    public function daftar()
    {
        $this->session->set_flashdata("halaman", "dinas"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $tgl = date('Y-m-d');
        $data = array(
            'user_role_data'    => $user_role_data,
            'setuju'    => 1,
            'user' => $user,
            'data_dinas_hari_ini' =>$this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas=b.id_dinas AND a.start_date<='$tgl' and a.end_date>='$tgl' AND b.status='1' GROUP BY a.id_dinas ASC")->result()
        );
        $this->template->load('template','dinas/list',$data);
    }

    public function daftar2()
    {
        $this->session->set_flashdata("halaman", "dinas"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $tgl = date('Y-m-d');
        $data = array(
            'user_role_data'    => $user_role_data,
            'setuju'    => 0,
            'user' => $user,
            'data_dinas_hari_ini' =>$this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas=b.id_dinas AND b.status='0' GROUP BY a.id_dinas ASC")->result()
        );
        $this->template->load('template','dinas/list',$data);
    }

    function daftar_pengajuan(){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b, dinas_approve_dana c WHERE a.id_dinas=b.id_dinas AND a.id_dinas=c.id_dinas AND (b.id_approver='$user_id' OR c.id_approver='$user_id') group by a.id_dinas order by a.start_date desc")->result();
        
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $data_dinas,
         );

        $this->template->load('template','dinas/daftar',$data);
    }

    function daftar_pengajuan_cek($id_approver){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b, dinas_approve_dana c WHERE a.id_dinas=b.id_dinas AND a.id_dinas=c.id_dinas AND (b.id_approver='$id_approver' OR c.id_approver='$id_approver') group by a.id_dinas order by a.start_date desc")->result();
        
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $data_dinas,
         );

        $this->template->load('template','dinas/daftar',$data);
    }

    function rekap(){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b, dinas_approve_dana c, employee d WHERE a.id_dinas=b.id_dinas AND a.id_dinas=c.id_dinas AND a.id_employee=d.id_employee group by a.id_dinas order by d.firstname ASC")->result();

        
        $data = array(
            'role_id'           => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'        => $data_dinas,
            'user_id'           => $user_id
         );

        $this->template->load('template','dinas/rekap',$data);
    }

    function hitung_ulang($id_dinas=''){
        $this->session->set_flashdata("halaman", "daftar"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_division = $this->session->userdata('id_division');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();

        if($id_dinas){
            $cek_dinas  = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
            $start      = $cek_dinas[0]->start_date;
            $end        = $cek_dinas[0]->end_date;

            $cek_holiday = $this->db->query("SELECT * FROM hari_libur WHERE tanggal>='$start' AND tanggal<='$end'")->result();
            if ($cek_holiday) {
                $hari_libur = count($cek_holiday);
            }else{
                $hari_libur = 0;
            }

            $date1    = date('d/m/y', strtotime($start));
            $date2    = date('d/m/y', strtotime($end));
            $interval = $date2-$date1;
            $libur_weekend = 0;
            for($a=0;$a<=$interval;$a++){
                $hari = date('l', strtotime('+'.$a.' days', strtotime($date1)));
                if(($hari=='Saturday') || ($hari=='Sunday')){
                    $libur_weekend =  $libur_weekend+1;
                }
            }

            $tot_hari_libur = $hari_libur + $libur_weekend;

            $s = strtotime($start);
            $e = strtotime($end);
            $timeDiff = abs($e - $s);
            $numberDays = $timeDiff/86400;
            $numberDays1 = intval($numberDays);
            $numberDays2 = $numberDays1 + 1; 

            $data = array(
                    'total_days'         => $numberDays2,
                    'total_days_holiday' => $tot_hari_libur
                );

            $this->db->where('id_dinas', $id_dinas);
            $this->db->update('dinas', $data);  

        }
        redirect('dinas/rekap');
    }

    function reject_dinas($id_dinas=''){
        $this->session->set_flashdata("halaman", "daftar"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_division = $this->session->userdata('id_division');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();

        if($id_dinas){
            $data = array(
                    'status'        => 3,
                    'updated_by'    => $user_id,
                    'updated_date'  => date('Y-m-d'),
                );
            $this->db->where('id_dinas', $id_dinas);
            $this->db->update('dinas', $data);  

        }
        redirect('dinas/rekap');
    }

    function checklist(){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b, dinas_approve_dana c, employee d WHERE a.id_dinas=b.id_dinas AND a.id_dinas=c.id_dinas AND a.id_employee=d.id_employee group by a.id_dinas order by d.firstname ASC")->result();
        
        $data = array(
            'role_id'           => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'        => $data_dinas,
            'user_id'           => $user_id
         );

        $this->template->load('template','dinas/check_finance',$data);
    }

    function checklist_proses($id_dinas,$token){
        $token_bayar = md5(date('ymd').'bayar'.$id_dinas);
        $token_proses = md5(date('ymd').'proses'.$id_dinas);
        
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
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b, dinas_approve_dana c, employee d WHERE a.id_dinas=b.id_dinas AND a.id_dinas=c.id_dinas AND a.id_employee=d.id_employee group by a.id_dinas order by d.firstname ASC")->result();
        
        $data = array(
            'role_id'           => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'        => $data_dinas,
            'user_id'           => $user_id
         );
        
        if($token_bayar==$token){
            $tanggal = $this->input->post('tanggal');
            $status_bayar = 100;
            $data = array(
                'status_bayar'    => $status_bayar,
                'bayar_date'  => date('Y-m-d'),
                'bayar_by'    => $user_id,
                'bayar_transact_date' => $tanggal
            );
    
            $this->db->where('id_dinas', $id_dinas);
            $this->db->update('dinas', $data);    

            redirect('dinas/checklist');
        }elseif($token_proses==$token){
            $status_bayar = 101;
            $data = array(
                'status_bayar'    => $status_bayar,
                'bayar_by'    => $user_id,
                'proses_transact_date' => date('Y-m-d')
            );
    
            $this->db->where('id_dinas', $id_dinas);
            $this->db->update('dinas', $data);    

            redirect('dinas/checklist');
        }else{
            redirect('error');
        }
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
        $data_dinas = $this->db->query("SELECT * FROM dinas a, dinas_approve b, dinas_approve_dana c, employee d WHERE a.id_dinas=b.id_dinas AND a.id_dinas=c.id_dinas AND a.id_employee=d.id_employee group by a.id_dinas order by d.firstname ASC")->result();
        
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $data_dinas,
            'user_id'           => $user_id
         );

        $this->template->load('template','dinas/rekap_',$data);
    }

    function rekap_dinas($id_employee){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas where id_employee='$id_employee'")->result();
        
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'        => $data_dinas,
            'user_id'           => $user_id
         );

        $this->template->load('template','dinas/rekap_dinas',$data);
    }

    function rekap_dinas_approve($id_dinas){
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
        $data_dinas = $this->db->query("SELECT * FROM dinas_approve where id_dinas='$id_dinas'")->result();
        
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $data_dinas,
            'user_id'           => $user_id
         );

        $this->template->load('template','dinas/rekap_dinas_approve',$data);
    }

    function delete_data($id_dinas){
        $this->db->where('id_dinas', $id_dinas);
        $this->db->delete('dinas');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("dinas");
    }

    

    function approve($id_permit,$jabatan){
        $user_id = $this->session->userdata('user_id');
        if($jabatan==3){
            $status=1;
        }else{
            $status=2;
        }
        $data = array(
            'status'    => $status,
            'approved_date'  => date('Y-m-d'),
            'approved_by'    => $user_id
        );
    
        $this->db->where('id_permit', $id_permit);
        $this->db->update('permit', $data);
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit successfully approved !!</div>");
        redirect("permit");
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

    function list_check($id_dinas){ //list approvel dana
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT * FROM dinas_approve_dana WHERE id_dinas='$id_dinas'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $get_data,
         );

        $this->template->load('template','dinas/check',$data);
    }

    function list_check_dinas($id_dinas){ //list approvel dana
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        //$get_data = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        $get_data = $this->db->query("SELECT * FROM dinas a, dinas_biaya b, dinas_approve c WHERE a.id_dinas='$id_dinas' AND a.id_dinas=b.id_dinas AND c.id_dinas=a.id_dinas")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $get_data,
         );

        $this->template->load('template','dinas/check3',$data);
    }

    function list_check_dinas_biaya($id_dinas){ //list approvel dana
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        //$get_data = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        $get_data = $this->db->query("SELECT * FROM dinas_biaya WHERE id_dinas='$id_dinas'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,  
            'data_dinas'         => $get_data,
         );

        $this->template->load('template','dinas/check4',$data);
    }

    function update_biaya_dinas($id_dinas,$id_dinas_biaya){ 
        $data = array(
            'biaya'             => 0
        );
        $this->db->where('id_dinas_biaya',$id_dinas_biaya);
        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas_biaya',$data); 
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">dinas approval successfully approved !!</div>");
        redirect("dinas");
    }

    function update_tujuan($id_dinas){ 
        $data = array(
            'tujuan'             => 'Yogyakarta'
        );
        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas',$data); 
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">dinas approval successfully approved !!</div>");
        redirect("dinas");
    }

    function list_check_dinas_biaya_detail(){ //list approvel dana
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        //$get_data = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$id_dinas'")->result();
        $get_data = $this->db->query("SELECT * FROM biaya_dinas_detail order by id_jabatan asc")->result();
        $data = array(
            'role_id' => $admin_role, 
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $get_data,
         );

        $this->template->load('template','dinas/check5',$data);
    }

    function list_check_approver($id_dinas){ //list approvel dana
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT * FROM dinas_approve WHERE id_dinas='$id_dinas'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_dinas'         => $get_data,
         );

        $this->template->load('template','dinas/check2',$data);
    }

    function insert_token($id_dinas,$id_approver){ 
        $data = array(
            'token'             => 'fe69814f39f46794c6fc4ef2014c7a46'
        );
        $this->db->where('id_dinas',$id_dinas);
        $this->db->where('id_approver',$id_approver);
        $this->db->update('dinas_approve_dana',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">dinas approval successfully approved !!</div>");
        redirect("dinas");
    }

    function ganti_approver($id_dinas_approve_dana,$id_approver_new){ 
        $data = array(
            'id_approver'             => $id_approver_new
        );
        $this->db->where('id_dinas_approve_dana',$id_dinas_approve_dana);
        $this->db->update('dinas_approve_dana',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("dinas"); 
    }

    function ganti_approver1($id_dinas,$id_approver_new){ 
        $data = array(
            'id_approver'             => $id_approver_new
        );
        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas_approve',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permit approval successfully change !!</div>");
        redirect("dinas"); 
    }

    function update_date($id_dinas){ 
        $data = array(
            'end_date'             => '2018-05-26'
        );
        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">dinas approval successfully approved !!</div>");
        redirect("dinas");
    }

    function update_day($id_dinas){ 
        $data = array(
            'total_days'             => 4
        );
        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">dinas approval successfully approved !!</div>");
        redirect("dinas");
    }

    function update_holiday($id_dinas,$total_days){ 
        $data = array(
            'total_days_holiday'             => $total_days
        );
        $this->db->where('id_dinas',$id_dinas);
        $this->db->update('dinas',$data);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">dinas approval successfully approved !!</div>");
        redirect("dinas");
    }

    function insert_biaya_dinas_approve($id_dinas){ 
       /* $data = array(
            'id_dinas'             => $id_dinas,
            'id_approver'          => 10008
        );
        $this->db->insert('dinas_approve_dana',$data);
		*/
        $data2 = array(
            'id_dinas'             => $id_dinas,
            'id_approver'          => 10056 //10050
        );
        $this->db->insert('dinas_approve_dana',$data2);

        $data3 = array(
            'id_dinas'             => $id_dinas,
            'id_approver'          => 10060 //10007
        );
        $this->db->insert('dinas_approve_dana',$data3);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">insert biaya dinas successfully !!</div>");
        redirect("dinas");
    }

    function delete_dana_approvel($id_dinas_approve_dana){
        $this->db->where('id_dinas_approve_dana', $id_dinas_approve_dana);
        $this->db->delete('dinas_approve_dana');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("dinas");
    }

    function insert_biaya_dinas($id_dinas){ 
        $data = array(
            'id_dinas'             => $id_dinas,
            'id_biaya_dinas'       => 1,
            'biaya'                => 0,
        );
        $this->db->insert('dinas_biaya',$data);

        $data2 = array(
            'id_dinas'             => $id_dinas,
            'id_biaya_dinas'       => 2,
            'biaya'                => 500000,
        );
        $this->db->insert('dinas_biaya',$data2);

        $data3 = array(
            'id_dinas'             => $id_dinas,
            'id_biaya_dinas'       => 3,
            'biaya'                => 250000,
        );
        $this->db->insert('dinas_biaya',$data3);
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">insert biaya dinas successfully !!</div>");
        redirect("dinas");
    }

    function insert_approvel($id_dinas,$id_approver){ 
        $token = md5(date('Ymdhis'));
        $data_approver = array(
            'id_dinas'      => $id_dinas,
            'id_approver'   => $id_approver,
            'token'         => $token,
            'status'        => 0 
        );
        $this->db->insert('dinas_approve',$data_approver);

        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">insert biaya dinas successfully !!</div>");
        redirect("dinas");
    }

    function tambah_kolom(){
        $this->db->query("ALTER TABLE dinas ADD total_days_holiday int (3)")->result();
    }
}