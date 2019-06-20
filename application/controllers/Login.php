<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->model('m_login');
        $this->load->model('m_log');
        $this->load->helper(array('form','url'));
        $this->load->library('session');
        $this->session->set_flashdata("halaman", ""); //mensetting menuKepilih atau menu aktif
    }

	function index(){
		$data['showWarning'] = 'default_show';
		$this->load->view('login/login',$data);
	}

	function aksi(){
		$data = array(
			'email' =>$this->input->post('email'),
			'password' =>md5($this->input->post('password')),
			'status' => 1
        );
        $email = $this->input->post('email');
        $sandi = '2017'.$this->input->post('password').'CoEG11';
        $password = md5($sandi);
        $cek = $this->db->query("SELECT * FROM administrator WHERE email='$email' AND password='$password'")->result();
		
		
		if($cek){
			$data_user = array(
				'user_id'		=> $cek[0]->id_administrator,
				'firstname'	=> $cek[0]->firstname,
				'admin_role' 	=> $cek[0]->id_privileges,
				'image'			=> $cek[0]->image,
				'position'		=> 'Administrator'
			);
			
			$this->session->set_userdata($data_user);
			$this->session->set_userdata('admin_role',$cek[0]->id_privileges);
			$this->session->set_userdata('logged_in',$cek);			
			redirect('home');
		}else{
			$cek2 = $this->db->query("SELECT * FROM employee WHERE email='$email' AND password='$password'")->result();
			if($cek2){
				$id_jabatan = $cek2[0]->id_position;
				$jabatan = $this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$id_jabatan'")->result();
				$data_user = array(
					'user_id'		=> $cek2[0]->id_employee,
					'firstname'	=> $cek2[0]->firstname,
					'admin_role' 	=> $cek2[0]->id_privileges,
					'image'			=> $cek2[0]->image,
					'position'		=> $jabatan[0]->nama_jabatan,
					'id_jabatan'	=> $id_jabatan,
					'id_division'	=> $cek2[0]->id_division,
					'gender'		=> $cek2[0]->gender
				);
				
				$data_login = array(
					'id_employee'	=> $cek2[0]->id_employee,
					'login_date'	=> date('Y-m-d'),
				);

				$this->db->insert('login_log',$data_login);
				$nama = $cek2[0]->firstname;
				$dep = $cek2[0]->id_division;
				$akt = 'Login';
				$this->m_log->save_log($nama,$dep,$akt);

				$this->session->set_userdata($data_user);
				$this->session->set_userdata('admin_role',$cek2[0]->id_privileges);
				$this->session->set_userdata('logged_in',$cek2);
				if($cek2[0]->id_privileges==1){
					redirect('home');	
				}else{
					redirect('index');
				}			
				
			}else{
				$data['showWarning']='w3-container w3-center w3-animate-zoom';
				$this->load->view('login/login',$data);
			}
		}
    }

    function logout() {		
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login');
	}

	function reset(){
		$email = $this->input->post('email');
		$cek_email = $this->db->query("SELECT * FROM employee WHERE email='$email'")->result();
		$available = (isset($cek_email[0]->email))? $cek_email[0]->email : set_value('email');
		if($available){
			$tgl = date('Ymdhis');
			$token = md5($email.'-'.$tgl);
			$data_reset = array(
				'email'			=> $email,
				'token'			=> $token,
				'expired_date'	=> date('Y-m-d'),
				'is_tag'		=> 0
			);

			$this->db->insert('reset_password',$data_reset);
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
	                                            <p>Baru baru ini Anda mencoba mereset password, jika benar klik tautan / tombol di bawah ini, jika tidak abaikan email ini</p>
	                                        </td>
	                                    </tr>
	                                    <tr height='30'></tr>
	                                    <tr>
	                                        <td colspan='3' style='padding-left:20px'>
	                                            <a href='".base_url()."login/reset_password/".$token."' class='button'>Reset Password</a>
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
	            $mail->Subject = 'Reset Password HR System';  
	            $mail->Body = $message; 
	            $mail->AddAddress($email);
	            $kirim = $mail->Send();	
		
				$this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Email reset password telah terkirim !!</div>");
            	redirect("login");
		}else{
			$this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Email tidak terdaftar !!</div>");
			redirect("login");
		}
	}

	function reset_password($token){
		$cek_token = $this->db->query("SELECT * FROM reset_password WHERE token='$token'")->result();
		$available = (isset($cek_token[0]->token))? $cek_token[0]->token : set_value('token');
		$data = array(
			'token'		=> $token
		);
		if($available){
			$expired_date = (isset($cek_token[0]->expired_date))? $cek_token[0]->expired_date : set_value('expired_date');
			$is_tag = (isset($cek_token[0]->is_tag))? $cek_token[0]->is_tag : set_value('is_tag');
			$now = date('Y-m-d');
			if($expired_date < $now || $is_tag==1){
				$this->load->view('login/expired',$data);
			}else{
				$this->load->view('login/reset',$data);
			}	
		}else{
			$this->load->view('login/login');
		}	
	}

	function reset_pwd(){
		$token = $this->input->post('token');
		$cek_token = $this->db->query("SELECT * FROM reset_password WHERE token='$token'")->result();
		$available = (isset($cek_token[0]->token))? $cek_token[0]->token : set_value('token');
		$data = array(
			'token'		=> $token
		);
		if($available){
			$email = (isset($cek_token[0]->email))? $cek_token[0]->email : set_value('email');
			$sandi = '2017'.$this->input->post('password').'CoEG11';
	        $password_baru = md5($sandi);
	        $datanew = array(
	            'password'  => $password_baru
	        );
	        $this->db->where('email',$email);
	        $this->db->update('employee',$datanew);

	        $datanew2 = array(
	            'is_tag'  => 1
	        );
	        $this->db->where('token',$token);
	        $this->db->update('reset_password',$datanew2);

	        if($this->db->affected_rows()!=0){
                $this->session->set_flashdata("notifikasi", "<div class=\"alert alert-success\" id=\"alert\">Password berhasil diperbarui, silahkan login !!</div>");
                redirect("login");
            }
		}else{
			$this->session->set_flashdata("notifikasi", "<div class=\"alert alert-danger\" id=\"alert\">Password gagal diperbarui !!</div>");
			redirect("login");
		}	
	}

	function list_reset(){
		$getdata = $this->db->query("SELECT * FROM reset_password")->result();
		$data = array(
			'data' 	=> $getdata
		);
		$this->load->view('login/list',$data);
	}
}
