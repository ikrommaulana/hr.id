<?php
class Home extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('m_login');
        $this->load->library('session');
        
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "home"); //mensetting menuKepilih atau menu aktif
        $this->session->set_flashdata("logas", "admin"); //mensetting menuKepilih atau menu aktif
    }
    
    function index(){
        error_reporting(0);
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $month= date('m');
        $days= date('d');
        $week = date('d') + 7;

        $total_karyawan = $this->db->query("SELECT * FROM employee WHERE status_hapus='0' and employee_status!='3' and employee_status!='4'")->result();
        $tot = count($total_karyawan);
        $now = date("2017-11-13");
        $now2 = date("Y-m-d");
        $cuti_today = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit=b.id_permit AND a.start_date>='$now2' AND a.end_date<='$now2' AND b.status='1'")->result();
        $tot_cuti = count($cuti_today);
        $dinas_today = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas=b.id_dinas AND a.start_date<='$now2' and a.end_date>='$now2' AND b.status='1' GROUP BY a.id_dinas ASC")->result();
        $tot_dinas = count($dinas_today);
        $dinas_blm_approve = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas=b.id_dinas AND b.status='0' GROUP BY a.id_dinas ASC")->result();
        $tot_dinas_blm_approve = count($dinas_blm_approve);
        $agenda_today = $this->db->query("SELECT * FROM event WHERE event_date='$now2' AND status='1'")->result();
        $tot_agenda = count($agenda_today);
        $tidak_hadir = $this->db->query("SELECT a.id_employee as id_emp, b.absensi_date , b.id_absensi 
                                        FROM employee a 
                                        LEFT JOIN employee_absensi b 
                                        ON a.id_absensi=b.id_absensi AND b.absensi_date='$now2' 
                                        WHERE b.id_absensi IS NULL
                                        AND a.status_hapus='0'
                                        and a.employee_status!='3' 
                                        and a.employee_status!='4'
                                        GROUP by a.id_employee")->result();
        /*$tidak_hadir = $this->db->query("SELECT a.id_employee as id_emp, b.absensi_date , b.id_absensi 
                                        FROM employee a 
                                        LEFT JOIN employee_absensi b 
                                        ON a.id_absensi=b.id_absensi AND b.absensi_date='$now2' 
                                        WHERE b.id_absensi IS NULL
                                        AND a.id_employee!='10007'
                                        AND a.id_employee!='10009'
                                        AND a.id_employee!='10025'
                                        GROUP by a.id_absensi")->result();*/

        /*$ip = "203.142.70.66";
        $Connect = fsockopen($ip, "8011", $errno, $errstr, 1);
        $Key = 0;
        if($Connect){
            $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while($Response=fgets($Connect, 1024)){
                $buffer=$buffer.$Response;
            }

            $this->db->query("Truncate table employee_absensi");

            $buffer = $this->m_login->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
            $buffer=explode("\r\n",$buffer);
            for($a=0;$a<count($buffer);$a++){
                $data= $this->m_login->Parse_Data($buffer[$a],"<Row>","</Row>");
                $PIN= $this->m_login->Parse_Data($data,"<PIN>","</PIN>");
                $DateTime= $this->m_login->Parse_Data($data,"<DateTime>","</DateTime>");
                $Verified= $this->m_login->Parse_Data($data,"<Verified>","</Verified>");
                $Status= $this->m_login->Parse_Data($data,"<Status>","</Status>");

                $data = array(
                    'id_absensi'    => $PIN,
                    'absensi_date'  => substr($DateTime,0,19),
                    'absensi_time'  => substr($DateTime,11,18)
                );
                $this->db->insert('employee_absensi',$data);
            }
        }*/
        
    	$data = array(
    		'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_birthday_now' => $this->db->query("SELECT * FROM employee WHERE MONTH(date_birth) = '$month' AND DAY(date_birth)='$days'")->result(),
            'data_birthday_week' => $this->db->query("SELECT * FROM employee WHERE MONTH(date_birth) = '$month' AND DAY(date_birth)<='$week'")->result(),
    	//	'dashboard' => $this->db->query("SELECT * FROM dashboard")->result(),
            'data_event'    => $this->db->query("SELECT * FROM event WHERE status='1' ORDER BY id_event DESC")->result(),
    	    'data_attendance' =>$this->db->query("SELECT * FROM attendance a, employee b, division c WHERE a.id_employee=b.id_employee AND b.id_division=c.id_division ORDER BY a.attendance_date DESC")->result(),
            'total_karyawan'    => $tot,
            'total_cuti'        => $tot_cuti,
            'total_dinas'        => $tot_dinas,
            'total_dinas_blm_approve'   => $tot_dinas_blm_approve,
            'total_agenda'        => $tot_agenda,
            'bulan'             => date('m'),
            'tahun'             => date('Y'),
            'tidak_hadir'       => $tidak_hadir,
            'role_id' => $admin_role,
        );
        $this->template->load('template','dashboard/index',$data); 
        
    }

    function sync_absen(){
        error_reporting(0);
        $ip = "203.142.70.66";
        //$ip = "192.168.0.98";
        $Connect = fsockopen($ip, "8011", $errno, $errstr, 1);
        $Key = 0;
        if($Connect){
            $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while($Response=fgets($Connect, 1024)){
                $buffer=$buffer.$Response;
            }

            $this->db->query("Truncate table employee_absensi");

            $buffer = $this->m_login->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
            $buffer=explode("\r\n",$buffer);
            for($a=0;$a<count($buffer);$a++){
                $data= $this->m_login->Parse_Data($buffer[$a],"<Row>","</Row>");
                $PIN= $this->m_login->Parse_Data($data,"<PIN>","</PIN>");
                $DateTime= $this->m_login->Parse_Data($data,"<DateTime>","</DateTime>");
                $Verified= $this->m_login->Parse_Data($data,"<Verified>","</Verified>");
                $Status= $this->m_login->Parse_Data($data,"<Status>","</Status>");

                $data = array(
                    'id_absensi'    => $PIN,
                    'absensi_date'  => substr($DateTime,0,19),
                    'absensi_time'  => substr($DateTime,11,18)
                );
                $this->db->insert('employee_absensi',$data);
            }
           $this->load->view('home/sync_success'); 
        }else{
           $this->load->view('home/sync');
        }
    }

    function sync_absen2(){
        error_reporting(0);
        $ip = "203.142.70.66";
        $Connect = fsockopen($ip, "8011", $errno, $errstr, 1);
        $Key = 0;
        if($Connect){
            $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while($Response=fgets($Connect, 1024)){
                $buffer=$buffer.$Response;
            }

            $this->db->query("Truncate table employee_absensi");

            $buffer = $this->m_login->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
            $buffer=explode("\r\n",$buffer);
            print_r($buffer).die();
            for($a=0;$a<count($buffer);$a++){
                $data= $this->m_login->Parse_Data($buffer[$a],"<Row>","</Row>");
                $PIN= $this->m_login->Parse_Data($data,"<PIN>","</PIN>");
                $DateTime= $this->m_login->Parse_Data($data,"<DateTime>","</DateTime>");
                $Verified= $this->m_login->Parse_Data($data,"<Verified>","</Verified>");
                $Status= $this->m_login->Parse_Data($data,"<Status>","</Status>");

                $data = array(
                    'id_absensi'    => $PIN,
                    'absensi_date'  => substr($DateTime,0,19),
                    'absensi_time'  => substr($DateTime,11,18)
                );
                $this->db->insert('employee_absensi',$data);
            }
           $this->load->view('home/sync_success'); 
        }else{
           $this->load->view('home/sync');
        }
    }

    function detail($bulan,$tahun){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $hari = date('d');
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'hari'              => $hari,
            'bulan'             => $bulan,
            'tahun'             => $tahun
        );
        $this->template->load('template','dashboard/detail',$data);   
    }

    function detail_filter(){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }

        $tanggal = $this->input->post('tgl');
        $new_tgl = str_replace("/","",$tanggal);
        $hari = substr($new_tgl,2,2);
        $bulan = substr($new_tgl,0,2);
        $tahun = substr($new_tgl,4,7);
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'hari'              => $hari,
            'bulan'             => $bulan,
            'tahun'             => $tahun
        );
        $this->template->load('template','dashboard/detail',$data);   
    }

    function filt(){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $month= date('m');
        $days= date('d');
        $week = date('d') + 7;
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        $total_karyawan = $this->db->query("SELECT * FROM employee WHERE status_hapus='0'")->result();
        $tot = count($total_karyawan);
        $now = date("Y-m-d");
        $cuti_today = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit=b.id_permit AND a.start_date>='$now' AND a.end_date<='$now' AND b.status='1'")->result();
        $tot_cuti = count($cuti_today);
        $dinas_today = $this->db->query("SELECT * FROM dinas a, dinas_approve b WHERE a.id_dinas=b.id_dinas AND a.start_date<='$now' or a.end_date>='$now' AND b.status='1'")->result();
        $tot_dinas = count($dinas_today);
        $agenda_today = $this->db->query("SELECT * FROM event WHERE event_date='$now' AND status='1'")->result();
        $tot_agenda = count($agenda_today);
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_birthday_now' => $this->db->query("SELECT * FROM employee WHERE MONTH(date_birth) = '$month' AND DAY(date_birth)='$days'")->result(),
            'data_birthday_week' => $this->db->query("SELECT * FROM employee WHERE MONTH(date_birth) = '$month' AND DAY(date_birth)<='$week'")->result(),
        //  'dashboard' => $this->db->query("SELECT * FROM dashboard")->result(),
            'data_event'    => $this->db->query("SELECT * FROM event WHERE status='1' ORDER BY id_event DESC")->result(),
            'data_attendance' =>$this->db->query("SELECT * FROM attendance a, employee b, division c WHERE a.id_employee=b.id_employee AND b.id_division=c.id_division ORDER BY a.attendance_date DESC")->result(),
            'total_karyawan'    => $tot,
            'total_cuti'        => $tot_cuti,
            'total_dinas'        => $tot_dinas,
            'total_agenda'        => $tot_agenda,
            'bulan'             => $bulan,
            'tahun'             => $tahun
        );
        $this->template->load('template','dashboard/index',$data);
        
    }

    function send_email(){
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
                                <td width='200px'><img src='http://lias.ligaindonesiabaru.com/hr/lib/assets/images/logo.jpg' width='200px'/>
                                </td>
                                <td width='300px'></td>
                            </tr>
                            <tr height='30'></tr>
                            <tr>
                                <td valign='top' colspan='2' style='padding-left:20px'>
                                    <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                    Hai, Idham Yamin
                                    </p>
                                    <p>Nuri Rahmat mengajukan permohonon cuti pada tanggal 10 Januari - 13 Januari</p>
                                </td>
                            </tr>
                            <tr height='30'></tr>
                            <tr>
                                <td colspan='2' style='padding-left:20px'>
                                    <a href='#' class='button'>Setujui</a>
                                    <a href='#' class='button2'>Tolak</a>
                                    <a href='#' class='button3'>History</a>
                                    
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
        $mail->Subject = 'Pengajuan permohonan cuti'; 
        $mail->Body = $message; 
        $mail->AddAddress('nurysmilee@gmail.com');
        $mail->Send();
    }

    function test_mail(){
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
                                        <td width='200px'><img src='http://lias.ligaindonesiabaru.com/hr/lib/assets/images/logo.jpg' width='200px'/>
                                        </td>
                                        <td width='150px'></td>
                                        <td width='150px'></td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td valign='top' colspan='3' style='padding-left:20px'>
                                            <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                            Hai, nuri
                                            </p>
                                            <p>Berikut adalah username dan password Anda untuk login di system HR LIB</p>
                                            <p>Useremail : </p>
                                            <p>Password : </p>
                                        </td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='http://lias.ligaindonesiabaru.com/hr/lib' class='button'>Masuk System</a>
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
            $mail->Subject = 'Akses System HR LIB'; 
            $mail->Body = $message; 
            $mail->AddAddress('nuri.rahmat@ligaindonesiabaru.com');
            $mail->Send();
    }
}
?>