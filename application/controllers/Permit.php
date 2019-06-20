<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permit extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->model('m_employee');
        $this->session->set_userdata('logged_in',1);//buka sementara untuk approve by mail
        if ($this->session->userdata('logged_in')=="") {
            redirect('login');
        }
        $this->session->set_flashdata("halaman", "permit"); //mensetting menuKepilih atau menu aktif
    }

    public function index_old($id_cuti='')
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
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
        if($jabatan==3 || $jabatan==4){
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee=b.id_employee AND b.id_division='$id_division' ORDER BY a.id_permit DESC")->result();
        }else{
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee='$user_id' AND a.id_employee=b.id_employee ORDER BY a.id_permit DESC")->result();
        }

        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_cuti==''){
            $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();   
            $summary ='All'; 
        }else{
            $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();
            $jenis_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
            $summary =$jenis_cuti[0]->jenis_cuti;
        }
        $data = array(
            'summary'  => $summary,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_permit' => $data_permit,
            'data_cuti'     => $data_cuti,
            'cuti_tahunan'  => $this->db->query("SELECT sum(a.total_days) as jml FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND b.id_permit=a.id_permit AND b.status='1'  AND b.status_batal='0' AND id_cuti='6'")->result(),
            'cuti_sakit'    => $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='5' AND a.id_permit=b.id_permit AND b.status!='2' AND b.status_batal!='1'")->result(),
            'cuti_izin'     => $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' AND id_cuti='4'")->result(),
            'cuti_haid'     => $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' AND id_cuti='3'")->result(),
            'cuti_menikah'  => $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' AND id_cuti='2'")->result(),
            'jumlah_permit' => $jumlah_permit,
            'jabatan'       => $jabatan,
            'sisa_permit'   => $jumlah_permit - $total_terpakai
        );
        $this->template->load('template','permit/index2',$data);
    }

    public function index($id_cuti='')
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
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
        if($jabatan==3 || $jabatan==4){
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee=b.id_employee AND b.id_division='$id_division' ORDER BY a.id_permit DESC")->result();
        }else{
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee='$user_id' AND a.id_employee=b.id_employee ORDER BY a.id_permit DESC")->result();
        }

        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_cuti==''){
            $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();   
            $summary ='All'; 
        }else{
            $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();
            $jenis_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
            $summary =$jenis_cuti[0]->jenis_cuti;
        }
        
        $data = array(
            'summary'  => $summary,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_permit' => $data_permit,
            'data_cuti'     => $data_cuti,
            'cuti_tahunan'  => $this->db->query("SELECT sum(a.total_days) as jml FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND b.id_permit=a.id_permit AND b.status!='2'  AND b.status_batal='0' AND id_cuti='6'")->result(),
            'cuti_sakit'    => $this->db->query("SELECT sum(a.total_days) as jml  FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='5' AND a.id_permit=b.id_permit AND b.status!='2' AND b.status_batal!='1'")->result(),
            'cuti_izin'     => $this->db->query("SELECT sum(total_days) as jml  FROM permit WHERE id_employee='$user_id' AND id_cuti='4'")->result(),
            'cuti_haid'     => $this->db->query("SELECT sum(total_days) as jml  FROM permit WHERE id_employee='$user_id' AND id_cuti='3'")->result(),
            'cuti_menikah'  => $this->db->query("SELECT sum(total_days) as jml  FROM permit WHERE id_employee='$user_id' AND id_cuti='2'")->result(),
            'jumlah_permit' => $jumlah_permit,
            'jabatan'       => $jabatan,
            'sisa_permit'   => $jumlah_permit - $total_terpakai
        );
        $this->template->load('template','permit/index',$data);
    }

    public function index_($id_cuti='')
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
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
        if($jabatan==3 || $jabatan==4){
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee=b.id_employee AND b.id_division='$id_division' ORDER BY a.id_permit DESC")->result();
        }else{
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee='$user_id' AND a.id_employee=b.id_employee ORDER BY a.id_permit DESC")->result();
        }

        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        if($id_cuti==''){
            $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();   
            $summary ='All'; 
        }else{
            $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();
            $jenis_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
            $summary =$jenis_cuti[0]->jenis_cuti;
        }
        
        $data = array(
            'summary'  => $summary,
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_permit' => $data_permit,
            'data_cuti'     => $data_cuti,
            'cuti_tahunan'  => $this->db->query("SELECT sum(a.total_days) as jml FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND b.id_permit=a.id_permit AND b.status!='2'  AND b.status_batal='0' AND id_cuti='6'")->result(),
            'cuti_sakit'    => $this->db->query("SELECT sum(a.total_days) as jml  FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='5' AND a.id_permit=b.id_permit AND b.status!='2' AND b.status_batal!='1'")->result(),
            'cuti_izin'     => $this->db->query("SELECT sum(total_days) as jml  FROM permit WHERE id_employee='$user_id' AND id_cuti='4'")->result(),
            'cuti_haid'     => $this->db->query("SELECT sum(total_days) as jml  FROM permit WHERE id_employee='$user_id' AND id_cuti='3'")->result(),
            'cuti_menikah'  => $this->db->query("SELECT sum(total_days) as jml  FROM permit WHERE id_employee='$user_id' AND id_cuti='2'")->result(),
            'jumlah_permit' => $jumlah_permit,
            'jabatan'       => $jabatan,
            'sisa_permit'   => $jumlah_permit - $total_terpakai
        );
        $this->template->load('template','permit/index2',$data);
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
        $data_cuti = $this->db->query("SELECT a.id_permit,a.id_employee,a.total_days,a.reason,a.start_date,a.end_date,a.id_cuti,b.status,a.created_date FROM permit a, permit_approve b, employee c WHERE a.id_permit=b.id_permit AND a.id_employee=c.id_employee group by a.id_permit order by c.firstname ASC")->result();
        //approved dana all
        //$data_piket = $this->db->query("SELECT * FROM piket a,piket_approve b,piket_approve_dana c,employee d WHERE a.id_piket=b.id_piket and b.status='1' and a.id_piket=c.id_piket and a.id_employee=d.id_employee group by a.id_piket")->result();  
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_cuti'         => $data_cuti,
         );

        $this->template->load('template','permit/rekap',$data);
    }

    public function detail_izin()
    {
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
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
        if($jabatan==3 || $jabatan==4){
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee=b.id_employee AND b.id_division='$id_division' ORDER BY a.id_permit DESC")->result();
        }else{
            $data_permit = $this->db->query("SELECT * FROM permit a, employee b WHERE a.id_employee='$user_id' AND a.id_employee=b.id_employee ORDER BY a.id_permit DESC")->result();
        }

        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_cuti = $this->db->query("SELECT * FROM permit a,permit_approve b WHERE a.id_employee='$user_id' AND a.id_permit=b.id_permit ORDER BY a.id_permit DESC")->result();
        $data = array(
            'user_role_data'    => $user_role_data,
            'user' => $user,
            'data_permit' => $data_permit,
            'data_cuti'     => $data_cuti,
            'cuti_tahunan'  => $this->db->query("SELECT sum(a.total_days) as jml FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND b.id_permit=a.id_permit AND b.status='1'  AND b.status_batal='0' AND id_cuti='6'")->result(),
            'cuti_sakit'    => $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='5' AND a.id_permit=b.id_permit AND b.status!='2' AND b.status_batal!='1'")->result(),
            'cuti_izin'     => $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' AND id_cuti='4'")->result(),
            'cuti_haid'     => $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' AND id_cuti='3'")->result(),
            'cuti_menikah'  => $this->db->query("SELECT * FROM permit WHERE id_employee='$user_id' AND id_cuti='2'")->result(),
            'jumlah_permit' => $jumlah_permit,
            'jabatan'       => $jabatan,
            'sisa_permit'   => $jumlah_permit - $total_terpakai
        );
        $this->template->load('template','permit/index2',$data);
    }

    function cuti(){
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
        if($gender==0){
            $data_cuti = $this->db->query("SELECT * FROM cuti a, employee_hak_cuti b WHERE a.id_cuti=b.id_cuti AND b.status='1' AND b.id_employee='$user_id' GROUP BY b.id_cuti ORDER BY b.id_cuti DESC")->result();
        }else{
            $data_cuti = $this->db->query("SELECT * FROM cuti a, employee_hak_cuti b WHERE a.id_cuti=b.id_cuti AND b.status='1'  AND b.id_employee='$user_id' GROUP BY b.id_cuti ORDER BY b.id_cuti DESC")->result();
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_cuti'         => $data_cuti,
            'data_permit'       => ''
        );

        $this->template->load('template','permit/cuti',$data);
    }

    function edit($id_permit){
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
        $data_permit = $this->db->query("SELECT * FROM permit WHERE id_permit='$id_permit'")->result();
        if($gender==0){
            $data_cuti = $this->db->query("SELECT * FROM cuti ORDER BY id_cuti DESC")->result();
        }else{
            $data_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti !='3' ORDER BY id_cuti DESC")->result();
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_permit'         => $data_permit,
            'data_cuti'         => $data_cuti
        );

        $this->template->load('template','permit/cuti',$data);
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
        $data_permit = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit=b.id_permit AND b.id_approver='$user_id' order by a.start_date desc")->result();
        if($gender==0){
            $data_cuti = $this->db->query("SELECT * FROM cuti ORDER BY id_cuti DESC")->result();
        }else{
            $data_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti !='3' ORDER BY id_cuti DESC")->result();
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_permit'         => $data_permit,
            'data_cuti'         => $data_cuti
        );

        $this->template->load('template','permit/daftar',$data);
    }

    function daftar_test($user_id2=''){
        $this->session->set_flashdata("halaman", "daftar"); //mensetting menuKepilih atau menu aktif
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $gender = $this->session->userdata('gender');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id2'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id2'")->result();
        }
        $data_permit = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit=b.id_permit AND b.id_approver='$user_id2'")->result();
        if($gender==0){
            $data_cuti = $this->db->query("SELECT * FROM cuti ORDER BY id_cuti DESC")->result();
        }else{
            $data_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti !='3' ORDER BY id_cuti DESC")->result();
        }
        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_permit'         => $data_permit,
            'data_cuti'         => $data_cuti
        );

        $this->template->load('template','permit/daftar',$data);
    }

    function batal(){
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
        $data_permit = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();
        $approver = $data_permit[0]->id_approver;
        $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$approver'")->result();
        $approver_email = $data_approver[0]->email;
        $id_permit = $this->input->post('id_permit');
        $data = array(
            'status_batal'    => 1,
            'batal_by'        => $user_id,
            'alasan_batal'    => $this->input->post('alasan'), 
            'batal_date'      => date('Y-m-d')
        );
        $this->db->where('id_permit',$id_permit);   
        $this->db->update('permit_approve',$data);   

        if($this->db->affected_rows()!=0){
            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Permohonan berhasil dibatalkan</div>");
            redirect("permit"); 
        }
    }

    public function add_edit_data($id_permit=''){
        $user_id = $this->session->userdata('user_id');
        $id_employee = $user_id;
        //cal total hak cuti
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        $tgl_join = $data_employee[0]->join_date;
        $tgl_now = date('Y-m-d');
        $d1 = new DateTime($tgl_now);
        $d2 = new DateTime($tgl_join);

        $diff = $d2->diff($d1);
        $th = $diff->y;
        $lama_kerja = $th + 1;
        //end cal
        $id_jabatan = $this->session->userdata('id_jabatan');
        $id_division = $this->session->userdata('id_division');
        $daterange = $this->input->post('tanggal');
        $date = explode(' - ', $daterange);
        $start  = date('Y-m-d', strtotime($date[0]));
        $end        = date('Y-m-d', strtotime($date[1]));

        //COUNT JUMLAH HARI ALL + HARI LIBUR
        $s = strtotime($start);
        $e = strtotime($end);
        $timeDiff = abs($e - $s);
        $numberDays = $timeDiff/86400;
        $numberDays2 = intval($numberDays);

        //COUNT JUMLAH HARI TANPA HARI LIBUR
        $begin = new DateTime($start);
        $end2 = new DateTime($end);

        $daterange2     = new DatePeriod($begin, new DateInterval('P1D'), $end2);
        //mendapatkan range antara dua tanggal dan di looping
        $i=0;
        $x     =    0;
        $end2     =    1;
        $j=0;
        foreach($daterange2 as $date2){
            $daterange2     = $date2->format("Y-m-d");
            $datetime     = DateTime::createFromFormat('Y-m-d', $daterange2);

            //Convert tanggal untuk mendapatkan nama hari
            $day         = $datetime->format('D');

            //Check untuk menghitung yang bukan hari sabtu dan minggu
            if($day!="Sun" && $day!="Sat") {
                //echo $i;
                $x    +=    $end2-$i;
                
            }
            $end2++;
            $i++;
           $j = $x + 1;
        }

        $cek_hari_libur1 = date('D', strtotime($start));
        $cek_hari_libur2 = date('D', strtotime($end));

        $data_hari_libur = $this->db->query("SELECT * FROM hari_libur WHERE tanggal BETWEEN '$start' AND '$end'")->result();
        $jml_hari_libur = count($data_hari_libur);
        $tot_days = $j - $jml_hari_libur;
        if($tot_days==0){
            $tot_days2 = $tot_days + 1; 
        }else{
            $tot_days2 = $tot_days;
        }

        $data_permit = $this->db->query("SELECT * FROM permit ORDER BY id_permit DESC")->result();
        if($data_permit){
            $new_id_permit = $data_permit[0]->id_permit + 1;
        }else{
            $new_id_permit = 1;
        }
        
        $id_cuti = $this->input->post('jenis_cuti');
        if($id_cuti==4 || $id_cuti==8){
            $jns = 'izin';
        }else{
            $jns = 'cuti';
        }
        $data_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
        $data_cuti2 = $this->db->query("SELECT * FROM employee_hak_cuti WHERE id_employee='$user_id' AND id_cuti='$id_cuti'")->result();
        $jumlah_cuti = $data_cuti2[0]->jumlah * $lama_kerja;
        $data_cuti_sama = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit AND b.status!='2' AND a.start_date<='$start' AND a.end_date>='$end'")->result();
        $data_sisa_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit AND b.status='1' AND b.status_batal='0'")->result();
        $jumlah_cuti_terpakai = count($data_sisa_cuti);
        if($jumlah_cuti!=0){
            $sisa_cuti = $jumlah_cuti - $jumlah_cuti_terpakai;    
        }else{
            $sisa_cuti = 366; //satu tahun
        }
        $batas = $data_cuti[0]->batas_pengajuan;
        $dt = date("Y-m-d");
        $minDate = date( "d/m/Y", strtotime( "$dt +$batas day" ) );
        $start2  = date("Y-m-d", strtotime($date[0]));

        if($id_permit==''){
            if($cek_hari_libur1=='Sat' || $cek_hari_libur1=='Sun' || $cek_hari_libur2=='Sat' || $cek_hari_libur2=='Sun'){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Tidak dapat mengambil cuti dihari libur')
                        window.location.href='".base_url()."permit/cuti';
                        </SCRIPT>");
            }elseif($sisa_cuti<1){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Sisa cuti telah habis')
                        window.location.href='".base_url()."permit/cuti';
                        </SCRIPT>");
            }elseif($data_cuti_sama){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Anda sudah mengambil cuti ditanggal yang sama')
                        window.location.href='".base_url()."permit/cuti';
                        </SCRIPT>");
                }else{
                    if($start2 == 0){
                        echo ("<SCRIPT LANGUAGE='JavaScript'>
                                window.alert('Tanggal Pengajuan Cuti Melewati Batas')
                                window.location.href='".base_url()."permit/cuti';
                                </SCRIPT>");
                    }else{
                        //new 04-12-2017
                        if($id_employee=='10000' || $id_employee=='10006'){ //IT
                            $id_approver ='10005';
                        }elseif($id_employee=='10026' || $id_employee=='10033' || $id_employee=='10032' || $id_employee=='10034' || $id_employee=='10035' || $id_employee=='10045' || $id_employee=='10046'){ // league enterprise
                            $id_approver ='10024'; //bang rian
                        }elseif($id_employee=='10014' || $id_employee=='10015' || $id_employee=='10016' || $id_employee=='10018' || $id_employee=='10020' || $id_employee=='10021' || $id_employee=='10022' || $id_employee=='10023' || $id_employee=='10037' || $id_employee=='10040'){ // kompetisi
                            $id_approver = '10012'; //kang asep
                        }elseif($id_employee=='10017' || $id_employee=='10019' || $id_employee=='10027' || $id_employee=='10030' || $id_employee=='10031'){//finance
                            $id_approver = '10050'; //pa robin
                        }elseif($id_employee=='10001'){//HR
                            $id_approver = '10007'; //pa risa
                        }elseif($id_employee=='10029' || $id_employee=='10003'){//marketing
                            $id_approver = '10011'; //raphael
                        }elseif($id_employee=='10028'){//secretary
                            $id_approver = '10013'; //amalia
                        }elseif($id_employee=='10005' || $id_employee=='10012'){
                            $id_approver = '10008'; //pa tigor
                        }elseif($id_employee=='10008' || $id_employee=='10024' || $id_employee=='10010' || $id_employee=='10013' || $id_employee=='10044' || $id_employee=='10047'){
                            $id_approver = '10007'; //pa risha
                        }elseif($id_employee=='10011'){
                            $id_approver = '10009'; //pa tedi
                        }elseif($id_employee=='10050'){//pa robin
                            $id_approver = '10007'; //pa risha
                        }elseif($id_employee=='10049'){//bahtiar
                            $id_approver = '10044'; //pa hanif
                        }elseif($id_employee=='10039' || $id_employee=='10051'){//hr
                            $id_approver = '10001'; //frizka
                        }

                        $data = array(
                            'id_permit'     => $new_id_permit,
                            'id_employee'   => $user_id,
                            'start_date'    => $start,
                            'end_date'      => $end,
                            'reason'        => $this->input->post('keperluan'),
                            'total_days'    => $tot_days2,
                            'keterangan'    => $this->input->post('keterangan'),
                            'id_cuti'       => $id_cuti,
                            'created_date'  => date('Y-m-d'),
                            'created_by'    => $user_id
                        );
                        $this->db->insert('permit', $data);


                        $get_level = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
                        $level_cuti = $get_level[0]->approval_level;
                        $get_level_jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
                        $level_jabatan = $get_level_jabatan[0]->level;
                        $level_start = $level_jabatan+1;
                        $level_end = $level_jabatan + $level_cuti;

                        $data_approver = array(
                            'id_permit'     => $new_id_permit,
                            'id_approver'   => $id_approver,
                            'status'        => 0
                        );
                        $this->db->insert('permit_approve',$data_approver);
                        
                        $get_email = $this->db->query("SELECT employee.*, division.init_division_name, jabatan.nama_jabatan FROM employee,division,jabatan WHERE id_employee='$id_approver' and employee.id_division = division.id_division and employee.id_position = jabatan.id_jabatan")->result();
                        if($get_email){
                            $email_to = $get_email[0]->email; 
                            $untuk = $get_email[0]->firstname;
                        }else{
                            $email_to ='idam@ligaindonesiabaru.com';
                            $untuk = '';
                        }

                        $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();

                        $tanggal1 = strtotime($start); 
                        $dt1 = date("d F Y  ", $tanggal1);
                        $tanggal2 = strtotime($end); 
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
                                        <td valign='top' colspan='2' style='padding-left:20px'>
                                            <p style='font-family:Verdana,Geneva,Sans-serif;''>
                                            Kepada Yth, <br>
                                            ".$get_email[0]->nama_jabatan." ".$get_email[0]->init_division_name."<br> 
                                            ".$get_email[0]->title." ".$untuk."
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
                                        <td colspan='3'>: ".$this->input->post('keperluan')."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Jenis Pengajuan
                                        </td>
                                        <td colspan='3'>: ".$data_cuti[0]->jenis_cuti."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keterangan
                                        </td>
                                        <td colspan='3'>: ".$this->input->post('keterangan')."</td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='3' style='padding-left:20px'>
                                            <a href='".base_url()."permit/approve_cuti_mail/".$new_id_permit."' class='button'>Setujui</a>
                                            <a href='".base_url()."permit/tolak_cuti_mail/".$new_id_permit."' class='button2'>Tolak</a>
                                            <a href='".base_url()."permit/history/".$user_id."' class='button3'>History</a>
                                            
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
                        $mail->AddAddress($email_to);
                        //$mail->AddBcc('idam@ligaindonesiabaru.com');
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
                                            Hai, 
                                            </p>
                                            <p>".$data_karyawan[0]->firstname." mengajukan permohonon ".$jns." :</p>
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
                                        <td valign='top' style='padding-left:20px'>
                                            Jenis Pengajuan
                                        </td>
                                        <td colspan='3'>: ".$data_cuti[0]->jenis_cuti."</td>
                                    </tr>
                                    <tr>
                                        <td valign='top' style='padding-left:20px'>
                                            Keterangan
                                        </td>
                                        <td colspan='3'>: ".$this->input->post('keterangan')."</td>
                                    </tr>
                                    <tr height='30'></tr>
                                    <tr>
                                        <td colspan='2' style='padding-left:20px'>
                                            <a href='".base_url()."permit/history/".$user_id."' class='button3'>History</a>
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
                        $mail2->Subject = 'Pengajuan permohonan cuti'; 
                        $mail2->Body = $message2; 
                        $mail2->AddAddress($mail_hr);
                        //$mail->AddBcc('idam@ligaindonesiabaru.com');
                        $mail2->Send();

                        if($this->db->affected_rows()!=0){
                            
                            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Cuti berhasil diajukan !!</div>");
                            redirect("permit_");
                        }
                    }
                }
            }else{
                if($sisa_cuti<1){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                        window.alert('Sisa cuti telah habis')
                        window.location.href='".base_url()."permit/cuti';
                        </SCRIPT>");
            }elseif($start2 < $minDate){
                        echo ("<SCRIPT LANGUAGE='JavaScript'>
                                window.alert('Tanggal Pengajuan Cuti Melewati Batas')
                                window.location.href='".base_url()."permit/cuti';
                                </SCRIPT>");
                    }else{
                        $data = array(
                            'start_date'    => $start,
                            'end_date'      => $end,
                            'reason'        => $this->input->post('keperluan'),
                            'total_days'    => $tot_days +1,
                            'keterangan'    => $this->input->post('keterangan'),
                            'id_cuti'       => $id_cuti,
                            'updated_date'  => date('Y-m-d'),
                            'updated_by'    => $user_id
                        );
                        $this->db->where('id_permit',$id_permit);
                        $this->db->update('permit', $data);

                        if($this->db->affected_rows()!=0){
                            
                            $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data berhasil diperbarui !!</div>");
                            redirect("permit_");
                        }
                    }
            }
        }

    function approve_cuti($id_permit){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $setuju = $this->input->post('setuju');
        $tidak_setuju = $this->input->post('tidak_setuju');
        if(isset($setuju)){
            $data = array(
                'status'            => 1,
                'updated_date'      => date('Y-m-d'),
            );    
        }else{
            $data = array(
                'status'            => 2,
                'updated_date'      => date('Y-m-d'),
            );
        }
        $this->db->where('id_permit',$id_permit);
        $this->db->where('id_approver',$user_id);
        $this->db->update('permit_approve',$data);

        if($this->db->affected_rows()!=0){
            redirect("permit_/detail/$id_permit");
        }
    }

    function detail($id_permit){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $id_division = $this->session->userdata('id_division');//new 12142017
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_cuti = $this->db->query("SELECT * FROM permit WHERE id_permit='$id_permit'")->result();
        $start_date = $data_cuti[0]->start_date;
        $end_date = $data_cuti[0]->end_date;

        $data_cuti_sama = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee!='$user_id' AND (a.start_date>='$start_date' AND a.start_date<='$end_date') OR (a.end_date>='$start_date' AND a.end_date<='$end_date') AND a.id_permit=b.id_permit AND b.status='1' group by a.id_permit")->result();

        $id_employee = $data_cuti[0]->id_employee;
        $data_employee = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.id_employee='$id_employee' AND b.id_jabatan=a.id_position")->result();
        $status_cuti = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();
        $status_batal = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status_batal=1")->result();
        $status_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=1")->result();
        if($status_batal){
            $status = 'Telah Dibatalkan';
            $tgl_diputuskan = 0;
        }elseif($status_cuti){
            $jml_approver = count($status_cuti);
            $status_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=1 ORDER BY updated_date DESC")->result();
            if($status_approve){
                $jml_approve = count($status_approve);
                if($jml_approver==$jml_approve){
                    $status = 'Telah Disetujui';
                    $tgl_diputuskan = $status_approve[0]->updated_date;
                }else{
                    $status = 'Menunggu Persetujuan';
                    $tgl_diputuskan = 0;
                }
            }else{
                $tgl_diputuskan = 0;
                $status_not_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=2")->result();
                if($status_not_approve){
                    $status = 'Tidak Disetujui';
                }else{
                    $status = 'Menunggu Persetujuan';   
                }
            }
        }
        $id_cuti = $data_cuti[0]->id_cuti;
        //$data_cuti2 = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
        $data_cuti2 = $this->db->query("SELECT * FROM employee_hak_cuti WHERE id_employee='$user_id' AND id_cuti='$id_cuti'")->result();
        $jumlah_cuti = $data_cuti2[0]->jumlah;
        $data_sisa_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit='$id_permit' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit AND b.status='1'")->result();
        $jumlah_cuti_terpakai = count($data_sisa_cuti);
        $sisa_cuti = $jumlah_cuti - $jumlah_cuti_terpakai;

        $data_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();

        if($id_division==5){
            $data_click = array(
                'click_status_hr'    => 1
            );    
        }else{
            $data_click = array(
                'click_status_atasan'    => 1
            );            
        }

        $this->db->where('id_permit',$id_permit);
        $this->db->update('permit_approve',$data_click);

        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'id_employee_cuti'  => $user_id,
            'data_cuti'         => $data_cuti,
            'id_employee2'      => $id_employee,
            'data_employee'     => $data_employee,
            'status_cuti'       => $status,
            'tgl_diputuskan'    => $tgl_diputuskan,
            'data_cuti_sama'    => $data_cuti_sama,
            'sisa_cuti'         => $sisa_cuti,
            'id_employee_login'  => $user_id,
            'limit_cuti'        => $jumlah_cuti,  
            'data_approver'     => $data_approve
        );

        $this->template->load('template','permit/detail',$data);
    }

    public function see_permit($id_permit){
        $data = array(
            'click_status'    => 1
        );

        $this->db->where('id_permit',$id_permit);
        $this->db->update('permit_approve',$data);

        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_cuti = $this->db->query("SELECT * FROM permit WHERE id_permit='$id_permit'")->result();
        $start_date = $data_cuti[0]->start_date;
        $end_date = $data_cuti[0]->end_date;

        $data_cuti_sama = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee!='$user_id' AND a.start_date>='$start_date' AND a.end_date<='$end_date' AND a.id_permit=b.id_permit AND b.status='1'")->result();

        $id_employee = $data_cuti[0]->id_employee;
        $data_employee = $this->db->query("SELECT * FROM employee a, jabatan b WHERE a.id_employee='$id_employee' AND b.id_jabatan=a.id_position")->result();
        $status_cuti = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();
        if($status_cuti){
            $jml_approver = count($status_cuti);
            $status_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=1 ORDER BY updated_date DESC")->result();
            if($status_approve){
                $jml_approve = count($status_approve);
                if($jml_approver==$jml_approve){
                    $status = 'Telah Disetujui';
                    $tgl_diputuskan = $status_approve[0]->updated_date;
                }else{
                    $status = 'Menunggu Persetujuan';
                    $tgl_diputuskan = 0;
                }
            }else{
                $tgl_diputuskan = 0;
                $status_not_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit' AND status=2")->result();
                if($status_not_approve){
                    $status = 'Tidak Disetujui';
                }else{
                    $status = 'Menunggu Persetujuan';   
                }
            }
        }
        $id_cuti = $data_cuti[0]->id_cuti;
        //$data_cuti2 = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
        $data_cuti2 = $this->db->query("SELECT * FROM employee_hak_cuti WHERE id_employee='$user_id' AND id_cuti='$id_cuti'")->result();
        $jumlah_cuti = $data_cuti2[0]->jumlah;
        $data_sisa_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_permit='$id_permit' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit AND b.status='1'")->result();
        $jumlah_cuti_terpakai = count($data_sisa_cuti);
        $sisa_cuti = $jumlah_cuti - $jumlah_cuti_terpakai;

        $data_approve = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();

        $data = array(
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'id_employee_cuti'  => $user_id,
            'data_cuti'         => $data_cuti,
            'id_employee2'      => $id_employee,
            'data_employee'     => $data_employee,
            'status_cuti'       => $status,
            'tgl_diputuskan'    => $tgl_diputuskan,
            'data_cuti_sama'    => $data_cuti_sama,
            'sisa_cuti'         => $sisa_cuti,
            'id_employee_login'  => $user_id,
            'data_approver'     => $data_approve,
            'limit_cuti'        => $jumlah_cuti
        );

        $this->template->load('template','permit_/detail',$data);
    }

    function data_cuti(){
        $user_id = $this->session->userdata('user_id');
        //cal total hak cuti
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        $tgl_join = $data_employee[0]->join_date;
        $tgl_now = date('Y-m-d');
        $d1 = new DateTime($tgl_now);
        $d2 = new DateTime($tgl_join);

        $diff = $d2->diff($d1);
        $th = $diff->y;
        $lama_kerja = $th + 1;
        //end cal
        $id_cuti = $this->input->get('option');
        $data_cuti = $this->db->query("SELECT * FROM cuti WHERE id_cuti='$id_cuti'")->result();
        $data_cuti2 = $this->db->query("SELECT * FROM employee_hak_cuti WHERE id_employee='$user_id' AND id_cuti='$id_cuti'")->result();
        $jumlah_cuti = $data_cuti2[0]->jumlah * $lama_kerja;
        //$data_sisa_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit AND b.status='1'")->result();
        //$jumlah_cuti_terpakai = count($data_sisa_cuti);
        $data_sisa_cuti = $this->db->query("SELECT sum(a.total_days) as jml FROM permit a, permit_approve b WHERE a.id_employee='$user_id' AND a.id_cuti='$id_cuti' AND a.id_permit=b.id_permit AND b.status='1'")->result();
        if($data_sisa_cuti){
            $jumlah_cuti_terpakai = $data_sisa_cuti[0]->jml;    
        }else{
            $jumlah_cuti_terpakai = 0;
        }
        
        $sisa_cuti = $jumlah_cuti - $jumlah_cuti_terpakai;
        $batas = $data_cuti[0]->batas_pengajuan;
        $dt = date("d/m/Y");
        $minDate = date( "d/m/Y", strtotime( "$dt +'".$batas."' day" ) );
        $this->session->set_userdata('minDate',$minDate);
        if($batas!=0){
            if($id_cuti==3){
                echo '2 hari dalam sebulan';
            }else{
                echo 'Batas Pengajuan H-'.$batas.' sisa cuti '.$sisa_cuti;
            }
        }

        if($id_cuti==4){ //izin
            $this->session->set_userdata('sehari','1');
        }else{
            $this->session->set_userdata('sehari','0');
        }
    }

    function jumlah_cuti(){
        $tgl_cuti = $this->input->get('option');
        $date = explode(' - ', $tgl_cuti);
        $start  = date('Y-m-d', strtotime($date[0]));
        $end        = date('Y-m-d', strtotime($date[1]));
        $jumlah = $start->diff($end);
        echo 'Jumlah cuti '.$jumlah->days;              
    }

    function approve_cuti_mail($id_permit){
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
            'status'            => 1,
            'updated_date'      => date('Y-m-d'),
        );    
        
        $this->db->where('id_permit',$id_permit);
        $this->db->update('permit_approve',$data);

        if($this->db->affected_rows()!=0){
            redirect("permit/approve_status");
        }
    }

    function tolak_cuti_mail($id_permit){
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
            'status'            => 2,
            'updated_date'      => date('Y-m-d'),
        );    

        $cek_status = $this->db->query("SELECT * from permit_approve where id_permit='$id_permit'")->result();
        if($cek_status[0]->status=='1'){
            redirect("permit/approve_status3");
        }else{
            $this->db->where('id_permit',$id_permit);
            $this->db->where('id_approver',$user_id);
            $this->db->update('permit_approve',$data);

            if($this->db->affected_rows()!=0){
                redirect("permit/approve_status2");
            }
        }
    }

    function history($id_employee){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $data_employee = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
        $data_cuti = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$id_employee' AND a.id_permit=b.id_permit AND b.status!='2' ORDER BY a.start_date DESC")->result();
        $data = array(
            'data_cuti'            => $data_cuti,
            'data_karyawan'        => $data_employee
        );

        $this->load->view('permit/history',$data);    
    }

    function approve_status(){
        $this->load->view('permit/email');
    }

    function approve_status2(){
        $this->load->view('permit/email2');
    }

    function approve_status3(){
        $this->load->view('permit/email3');
    }

    function delete_data($id_permit){
        $this->db->where('id_permit', $id_permit);
        $this->db->delete('permit');
        
        $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Data successfully deleted !!</div>");
        redirect("permit");
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

    function update_hari($id_permit,$jml){
        $data  = array(
            'total_days'    => $jml
        );
        $this->db->where('id_permit', $id_permit);
        $this->db->update('permit',$data);
        redirect("permit");
    }

    function list_check($id_employee){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT a.id_permit,a.id_employee,b.id_approver,a.id_cuti,a.reason,a.start_date,a.end_date,b.status FROM permit a, permit_approve b WHERE a.id_employee='$id_employee' and a.id_permit=b.id_permit")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_permit'         => $get_data,
         );

        $this->template->load('template','permit/check',$data);
    }

    function list_approve_table($id_permit){
        $user_id = $this->session->userdata('user_id');
        $admin_role=$this->session->userdata('admin_role');
        $user_role_data = $this->db->query("SELECT * FROM privileges_status WHERE id_privileges='$admin_role'")->result();
        $cek_user = $this->db->query("SELECT * FROM administrator WHERE id_administrator='$user_id'")->result();
        if($cek_user){
            $user = $cek_user;
        }else{
            $user = $this->db->query("SELECT * FROM employee WHERE id_employee='$user_id'")->result();
        }
        $get_data = $this->db->query("SELECT * FROM permit_approve WHERE id_permit='$id_permit'")->result();
        $data = array(
            'role_id' => $admin_role,
            'user_role_data'    => $user_role_data,
            'user'              => $user,
            'data_permit'         => $get_data,
         );

        $this->template->load('template','permit/check2',$data);
    }

    function tambah_kolom_(){
        $this->db->query("ALTER TABLE permit_approve ADD alasan_batal varchar (250)")->result();
    }
}