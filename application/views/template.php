<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<meta http-equiv="refresh" content="300">-->
    <link rel="icon" type="image/png" sizes="16x16" href="<?=base_url()?>assets/images/favicon.png">
    <title>Liga Indonesia Baru</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url()?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="<?=base_url()?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/bower_components/dropify/dist/css/dropify.min.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="<?=base_url()?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Popup CSS -->
    <link href="<?=base_url()?>plugins/bower_components/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">
    <!-- Color picker plugins css -->
    <link href="<?=base_url()?>plugins/bower_components/jquery-asColorPicker-master/css/asColorPicker.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="<?=base_url()?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="<?=base_url()?>plugins/bower_components/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="<?=base_url()?>plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="<?=base_url()?>plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- Wizard CSS -->
    <link href="<?=base_url()?>plugins/bower_components/jquery-wizard-master/css/wizard.css" rel="stylesheet">
    <!--alerts CSS -->
    <link href="<?=base_url()?>plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- chartist CSS -->
    <link href="<?=base_url()?>plugins/bower_components/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?=base_url()?>plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="<?=base_url()?>plugins/bower_components/calendar/dist/fullcalendar.css" rel="stylesheet" />
    <!-- animation CSS -->
    <link href="<?=base_url()?>assets/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="<?=base_url()?>assets/css/colors/megna-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
    .jq-toast-wrap{
        display: none
    }

    body::-webkit-scrollbar {
        width: 6px;
    }
     
    body::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    }
     
    body::-webkit-scrollbar-thumb {
      background-color: darkgrey;
      outline: 1px solid slategrey;
    }
</style>
</head>

<body class="fix-header">


    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="index.html">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="<?=base_url()?>assets/images/lib.png" alt="home" class="dark-logo" width="25px" /><!--This is light logo icon--><img src="<?=base_url()?>assets/images/lib.png" alt="home" class="light-logo"  width="25px"/>
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="<?=base_url()?>assets/images/text.png" alt="home" class="dark-logo" /><!--This is light logo text--><img src="<?=base_url()?>assets/images/text.png" alt="home" class="light-logo" />
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                    <li class="dropdown">
                        <?php
                            $logas = $this->session->userdata('logas');
                            $role = $this->session->userdata('admin_role');
                            $id_employee = $this->session->userdata('user_id');
                            $id_division = $this->session->userdata('id_division');
                            $data_user = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_employee'")->result();
                            if($data_user){
                                $gbr = $data_user[0]->image;
                            }else{
                                $gbr = '';
                            }
                            $get_notif = $this->db->query("SELECT * FROM permit_approve WHERE id_approver='$id_employee' AND status='0' AND click_status_atasan='0' ORDER BY id_permit DESC")->result();
                            $jml_notif = count($get_notif);
                            $get_notif2 = $this->db->query("SELECT * FROM recrutment_request_approve WHERE id_approver='$id_employee' AND status='0' ORDER BY id_recruitment_request_approve DESC")->result();
                            $jml_notif2 = count($get_notif2);
                            $get_notif3 = $this->db->query("SELECT * FROM dinas_approve WHERE id_approver='$id_employee' AND status='0' AND click_status_atasan='0' ORDER BY id_dinas_approve DESC")->result();
                            $jml_notif3 = count($get_notif3);
                            $get_notif4 = $this->db->query("SELECT * FROM piket_approve WHERE id_approver='$id_employee' AND status='0' ORDER BY id_piket_approve DESC")->result();
                            $jml_notif4 = count($get_notif4);
                            $get_notif5 = $this->db->query("SELECT * FROM tugas WHERE untuk_bawahan='$id_employee' AND status='0' AND click_status='0' ORDER BY id_tugas DESC")->result();
                            $jml_notif5 = count($get_notif5);
                            $get_notif6 = $this->db->query("SELECT * FROM tugas WHERE created_by='$id_employee' AND status='1' AND click_status2='0' ORDER BY id_tugas DESC")->result();
                            $jml_notif6 = count($get_notif6);
                            //notif telah disetujui atau ditolak
                            $get_notif7 = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$id_employee' AND b.id_permit=a.id_permit AND  b.status='1' AND b.click_status='0' ORDER BY b.id_permit DESC")->result();
                            $jml_notif7 = count($get_notif7);
                            $get_notif8 = $this->db->query("SELECT * FROM permit a, permit_approve b WHERE a.id_employee='$id_employee' AND b.id_permit=a.id_permit AND  b.status='2' AND b.click_status='0' ORDER BY b.id_permit DESC")->result();
                            $jml_notif8 = count($get_notif8);
                            $total_notif = $jml_notif + $jml_notif2 + $jml_notif3 + $jml_notif4 + $jml_notif5 + $jml_notif6 + $jml_notif7 + $jml_notif8;

                            if($id_division==5){
                                $get_notif_hr = $this->db->query("SELECT * FROM permit_approve WHERE status='0' AND click_status_hr='0' ORDER BY id_permit DESC")->result();
                                $jml_notif_hr = count($get_notif_hr);
                                $get_notif2_hr = $this->db->query("SELECT * FROM recrutment_request_approve WHERE status='0' ORDER BY id_recruitment_request_approve DESC")->result();
                                $jml_notif2_hr = count($get_notif2_hr);
                                $get_notif3_hr = $this->db->query("SELECT * FROM dinas_approve WHERE status='0' AND click_status_hr='0' ORDER BY id_dinas_approve DESC")->result();
                                $jml_notif3_hr = count($get_notif3_hr);
                                $get_notif4_hr = $this->db->query("SELECT * FROM piket_approve WHERE status='0' ORDER BY id_piket_approve DESC")->result();
                                $jml_notif4_hr = count($get_notif4_hr);
                                $get_notif5_hr = $this->db->query("SELECT * FROM tugas WHERE click_status='0' ORDER BY id_tugas DESC")->result();
                                $jml_notif5_hr = count($get_notif5_hr);
                                $total_notif_hr = $jml_notif_hr + $jml_notif2_hr + $jml_notif3_hr + $jml_notif4_hr + $jml_notif5_hr;
                                $total_notif = '';
                            }else{
                                $jml_notif_hr = $jml_notif2_hr = $jml_notif3_hr = $jml_notif4_hr = $jml_notif5_hr = 0;
                                $total_notif_hr = '';
                            }


                            if($id_division==5){ //untuk HR
                                $notif1 = $get_notif_hr;
                                $msg1   = 'Menunggu persetujuan cuti !';
                                $notif2 = $get_notif2_hr;
                                $msg2   = 'Menunggu persetujuan pengajuan karyawan !';
                                $notif3 = $get_notif3_hr;
                                $msg3   = 'Menunggu persetujuan perjalanan dinas !';
                                $notif4 = $get_notif4_hr;
                                $msg4   = 'Menunggu persetujuan piket !';
                                $notif5 = $get_notif5_hr;
                                $msg5   = 'Memberikan tugas !';
                                $notif6 = '';
                                $msg6   = '';
                                $notif7 = '';
                                $msg7   = '';
                                $notif8 = '';
                                $msg8   = '';
                            }else{ // untuk atasan
                                $notif1 = $get_notif;
                                $msg1   = 'Menunggu persetujuan cuti dari Anda!';
                                $notif2 = $get_notif2;
                                $msg2   = 'Menunggu persetujuan pengajuan karyawan dari Anda !';
                                $notif3 = $get_notif3;
                                $msg3   = 'Menunggu persetujuan perjalanan dinas dari Anda !';
                                $notif4 = $get_notif4;
                                $msg4   = 'Menunggu persetujuan piket dari Anda!';
                                $notif5 = $get_notif5;
                                $msg5   = 'Memberikan tugas untuk Anda!';
                                $notif6 = $get_notif6;
                                $msg6   = 'Telah menyelesaikan tugas yang diberikan';
                                $notif7 = $get_notif7;
                                $msg7   = ' menyetujui permintaan izin anda';
                                $notif8 = $get_notif8;
                                $msg8   = ' menolak permintaan izin anda';
                            }
                        ?>
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-gmail"></i>
                            <div class="<?php if($jml_notif!=0 || $jml_notif2!=0 || $jml_notif3!=0 || $jml_notif4!=0 || $jml_notif5!=0 || $jml_notif6!=0 || $jml_notif7!=0 || $jml_notif_hr!=0 || $jml_notif2_hr!=0 || $jml_notif3_hr!=0 || $jml_notif4_hr!=0 || $jml_notif5_hr!=0){echo 'notify';}?>"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <ul class="dropdown-menu mailbox animated bounceInDown" style="width: 300px; overflow-x: hidden; overflow-y: <?php if($total_notif > 5 || $total_notif_hr > 5){echo 'scroll';}?>; max-height: 500px" >
                            <li style="width: 300px">
                                <div class="drop-title" style="font-weight: normal;">Anda memiliki <?=$total_notif;?><?=$total_notif_hr;?> notifications</div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php 
                                    if($notif1){foreach($notif1 as $view){
                                    $data_permit = $this->db->query("SELECT * FROM permit WHERE id_permit='$view->id_permit'")->result();
                                    $tanggal1 = strtotime($data_permit[0]->start_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $id_karyawan = $data_permit[0]->id_employee;
                                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_karyawan'")->result();
                                    $gbr2 = $data_karyawan[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>permit/detail/<?=$view->id_permit;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_karyawan[0]->firstname;?></h5> <span class="mail-desc"><?=$msg1;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php if($notif2){foreach($notif2 as $view){
                                    $data_request = $this->db->query("SELECT * FROM recruitment_request WHERE id_recruitment_request='$view->id_recruitment_request'")->result();
                                    $tanggal1 = strtotime($data_request[0]->created_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $id_karyawan = $data_request[0]->created_by;
                                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_karyawan'")->result();
                                    $gbr2 = $data_karyawan[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>karyawan/detail/<?=$view->id_recruitment_request_approve;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_karyawan[0]->firstname;?></h5> <span class="mail-desc"><?=$msg2;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php if($notif3){foreach($notif3 as $view){
                                    $data_dinas = $this->db->query("SELECT * FROM dinas WHERE id_dinas='$view->id_dinas'")->result();
                                    $tanggal1 = strtotime($data_dinas[0]->created_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $id_karyawan = $data_dinas[0]->created_by;
                                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_karyawan'")->result();
                                    $gbr2 = $data_karyawan[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>dinas/detail/<?=$view->id_dinas;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_karyawan[0]->firstname;?></h5> <span class="mail-desc"><?=$msg3;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php if($notif4){foreach($notif4 as $view){
                                    $data_piket = $this->db->query("SELECT * FROM piket WHERE id_piket='$view->id_piket'")->result();
                                    $tanggal1 = strtotime($data_piket[0]->created_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $id_karyawan = $data_piket[0]->created_by;
                                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_karyawan'")->result();
                                    $gbr2 = $data_karyawan[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>piket/detail/<?=$view->id_piket;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_karyawan[0]->firstname;?></h5> <span class="mail-desc"><?=$msg4;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php if($notif5){foreach($notif5 as $view){
                                    $data_tugas = $this->db->query("SELECT * FROM tugas WHERE id_tugas='$view->id_tugas'")->result();
                                    $tanggal1 = strtotime($data_tugas[0]->created_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $id_karyawan = $data_tugas[0]->created_by;
                                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_karyawan'")->result();
                                    $gbr2 = $data_karyawan[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>index/see_tugas/<?=$view->id_tugas;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_karyawan[0]->firstname;?></h5> <span class="mail-desc"><?=$msg5;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php if($notif6){foreach($notif6 as $view){
                                    $data_tugas = $this->db->query("SELECT * FROM tugas WHERE id_tugas='$view->id_tugas'")->result();
                                    $tanggal1 = strtotime($data_tugas[0]->updated_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $id_karyawan = $data_tugas[0]->untuk_bawahan;
                                    $data_karyawan = $this->db->query("SELECT * FROM employee WHERE id_employee='$id_karyawan'")->result();
                                    $gbr2 = $data_karyawan[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>index/see_tugas2/<?=$view->id_tugas;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_karyawan[0]->firstname;?></h5> <span class="mail-desc"><?=$msg6;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php 
                                    if($notif7){foreach($notif7 as $view){
                                    $data_permit = $this->db->query("SELECT * FROM permit WHERE id_permit='$view->id_permit'")->result();
                                    $tanggal1 = strtotime($data_permit[0]->start_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_approver'")->result();
                                    $gbr2 = $data_approver[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>permit/see_permit/<?=$view->id_permit;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_approver[0]->firstname;?></h5> <span class="mail-desc"><?=$msg7;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <li style="width: 300px">
                                <div class="message-center">
                                <?php 
                                    if($notif8){foreach($notif8 as $view){
                                    $data_permit = $this->db->query("SELECT * FROM permit WHERE id_permit='$view->id_permit'")->result();
                                    $tanggal1 = strtotime($data_permit[0]->start_date); 
                                    $dt = date("d F Y  ", $tanggal1);
                                    $data_approver = $this->db->query("SELECT * FROM employee WHERE id_employee='$view->id_approver'")->result();
                                    $gbr2 = $data_approver[0]->image;
                                    ?>
                                    <a href="<?=base_url()?>permit/detail/<?=$view->id_permit;?>">
                                        <div class="user-img"> <img src="<?=base_url()?>assets/images/<?php if($gbr2){echo $gbr2;}else{echo 'admin.png';}?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5><?=$data_approver[0]->firstname;?></h5> <span class="mail-desc"><?=$msg8;?></span> <span class="time"><?=$dt;?></span> </div>
                                    </a>
                                <?php }}?>
                                </div>
                            </li>
                            <!--<li>
                                <a class="text-center" href="javascript:void(0);"> <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>-->
                        </ul>
                        <!-- /.dropdown-messages -->
                    </li>
                    <!-- .Task dropdown -->
                    <!--<li class="dropdown">
                        <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"> <i class="mdi mdi-check-circle"></i>
                            <div class=""><span class="heartbit"></span><span class="point"></span></div>
                        </a>
                        <ul class="dropdown-menu dropdown-tasks animated slideInUp">
                            <li>
                                <a href="javascript:void(0)">
                                    <div>
                                        <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0)">
                                    <div>
                                        <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0)">
                                    <div>
                                        <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="javascript:void(0)">
                                    <div>
                                        <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="javascript:void(0)"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </li>-->
                    <!-- .Megamenu -->
                    <?php if($logas=='admin'){?>
                    <!--<li class="mega-dropdown"> <a class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="javascript:void(0)"><span class="hidden-xs">Setup</span> <i class="icon-options-vertical"></i></a>
                        <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown">
                            <!--<li class="col-sm-2">
                                <ul>
                                    <li class="dropdown-header" style="font-weight: normal;">
                                    <a href=""><i class="icon-key"></i> Hak Akses</li></a>
                                </ul>
                            </li>
                            <li class="col-sm-2">
                                <ul>
                                    <li class="dropdown-header" style="font-weight: normal;">
                                    <a href="<?=base_url()?>payroll"><i class="icon-note"></i> Payroll</li></a>
                                </ul>
                            </li>
                            <li class="col-sm-2">
                                <ul>
                                    <li class="dropdown-header" style="font-weight: normal;">
                                    <a href=""><i class="icon-bag"></i> Piket</li></a>
                                </ul>
                            </li>
                            <li class="col-sm-2">
                                <ul>
                                    <li class="dropdown-header"></li>
                                </ul>
                            </li>
                            <li class="col-sm-2">
                                <ul>
                                    <li class="dropdown-header"></li>
                                </ul>
                            </li>
                            <li class="col-sm-2">
                                <ul>
                                    <li class="dropdown-header"></li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <?php }?>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> <img src="<?=base_url()?>assets/images/<?php if($gbr!=''){echo $gbr;}else{echo 'admin.png';}?>" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?=substr($data_user[0]->firstname,0,10);?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="<?=base_url()?>assets/images/<?php if($gbr){echo $gbr;}else{echo 'admin.png';}?>" alt="user" /></div>
                                    <div class="u-text">
                                        <h4><?=$data_user[0]->firstname;?></h4>
                                        <p class="text-muted"><?=$data_user[0]->email;?></p>
                                        <p>Log as <?php if($role==1){?><a href="<?=base_url()?>home" >Admin</a> |<?php }?> <a href="<?=base_url()?>index">User</a></p>
                                        <p><a href="#" data-toggle="modal" data-target="#mymodal3" style="font-size: 10px">Ganti password</a></p>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <!--<li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-wallet"></i> My Balance</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-email"></i> Inbox</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings"></i> Account Setting</a></li>-->
                            <li role="separator" class="divider"></li>
                            <li><a href="<?=base_url()?>login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php $page=$this->session->flashdata('halaman');?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                <ul class="nav" id="side-menu">
                    <!--<li class="user-pro">
                        <a href="javascript:void(0)" class="waves-effect"><img src="<?=base_url()?>plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span class="hide-menu"> Steve Gection<span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a href="javascript:void(0)"><i class="ti-user"></i> <span class="hide-menu">My Profile</span></a></li>
                            <!--<li><a href="javascript:void(0)"><i class="ti-wallet"></i> <span class="hide-menu">My Balance</span></a></li>
                            <li><a href="javascript:void(0)"><i class="ti-email"></i> <span class="hide-menu">Inbox</span></a></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Account Setting</span></a></li>
                            <li><a href="javascript:void(0)"><i class="fa fa-power-off"></i> <span class="hide-menu">Logout</span></a></li>
                        </ul>
                    </li>-->
                    <?php if($logas=='admin'){
                            $hm = 'home';
                        }else{
                            $hm = 'index';
                        }
                    ?>
                    <li> <a href="<?=base_url()?><?=$hm;?>" class="waves-effect <?php if($page=='home'){echo 'active';}?>"><i class="mdi mdi-av-timer fa-chart" data-icon="v"></i> <span class="hide-menu"> Dashboard <span class="fa arrow"></span> <span class="label label-rouded label-inverse pull-right">4</span></span></a>
                        <!--<ul class="nav nav-second-level">
                            <li> <a href="index.html"><i class=" fa-fw">1</i><span class="hide-menu">Dashboard 1</span></a> </li>
                            <li> <a href="index2.html"><i class=" fa-fw">2</i><span class="hide-menu">Dashboard 2</span></a> </li>
                            <li> <a href="index3.html"><i class=" fa-fw">3</i><span class="hide-menu">Dashboard 3</span></a> </li>
                        </ul>-->
                    </li>
                    <?php if($logas=='admin'){
                        if($role==1){?>
                    <li><a href="javascript:void(0)" class="waves-effect <?php if($page=='employee' || $page=='division' || $page=='event' || $page=='jabatan' || $page=='cuti' || $page=='pra_karyawan' || $page=='room' || $page=='city' || $page=='holiday'){echo 'active';}?>"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu"> Data Master <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>pra_karyawan"><i class="icon-user fa-fw"></i><span class="hide-menu"> Calon Karyawan</span></a></li>
                            <li><a href="<?=base_url()?>employee"><i class="icon-people fa-fw"></i><span class="hide-menu"> Karyawan</span></a></li>
                            <li><a href="<?=base_url()?>division"><i class="ti-layers fa-fw"></i><span class="hide-menu"> Departemen</span></a></li>
                            <li><a href="<?=base_url()?>jabatan"><i class="ti-medall fa-fw"></i><span class="hide-menu"> Jabatan</span></a></li>
                            <li><a href="<?=base_url()?>cuti"><i class="ti-briefcase fa-fw"></i><span class="hide-menu"> Cuti</span></a></li>
                            <li><a href="<?=base_url()?>event"><i class="mdi mdi-calendar-check fa-fw"></i><span class="hide-menu"> Kalender</span></a></li>
                            <li><a href="<?=base_url()?>city"><i class="mdi mdi-book fa-fw"></i><span class="hide-menu"> Kota</span></a></li>
                            <li><a href="<?=base_url()?>room"><i class="mdi mdi-domain fa-fw"></i><span class="hide-menu"> Ruang Meeting</span></a></li>
                            <li><a href="<?=base_url()?>biaya"><i class="mdi mdi-domain fa-money"></i><span class="hide-menu"> Biaya Perjalanan Dinas</span></a></li>
                            <li><a href="<?=base_url()?>holiday"><i class="mdi mdi-airplane"></i><span class="hide-menu"> Holiday</span></a></li>
                            <li><a href="<?=base_url()?>lock"><i class="mdi mdi-key"></i><span class="hide-menu"> Lock Backdate</span></a></li>
                        </ul>
                    </li>
                    <?php }}?>
                    <li><a href="javascript:void(0)" class="waves-effect <?php if($page=='permit' || $page=='piket' || $page=='dinas' || $page=='karyawan'){echo 'active';}?>"><i class="mdi mdi-book fa-fw"></i> <span class="hide-menu"> Pengajuan <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?=base_url()?>permit_"><i class="ti-briefcase fa-fw"></i><span class="hide-menu"> Cuti </span></a></li>
                            <li><a href="<?=base_url()?>piket"><i class="ti-layout fa-fw"></i><span class="hide-menu"> Piket </span></a></li>
                            <li><a href="<?=base_url()?>dinas"><i class="mdi mdi-airplane fa-fw"></i><span class="hide-menu"> Perjalanan Dinas </span></a></li>
                            <li><a href="<?=base_url()?>karyawan"><i class="ti-user fa-fw"></i><span class="hide-menu"> Karyawan Baru </span></a></li>
                        </ul>
                    </li>
                    <?php 
                    $permit_approvel = $this->db->query("SELECT * FROM permit_approve WHERE id_approver='$id_employee'")->result(); 
                    $dinas_approvel = $this->db->query("SELECT * FROM dinas_approve WHERE id_approver='$id_employee'")->result();
                    $piket_approvel = $this->db->query("SELECT * FROM piket_approve WHERE id_approver='$id_employee'")->result();
                    if(($permit_approvel) || ($dinas_approvel) || ($piket_approvel)){?>
                    <li> <a href="<?=base_url()?>permit/daftar" class="waves-effect <?php if($page=='daftar'){echo 'active';}?>"><i  class="mdi mdi-clipboard-text fa-fw"></i> <span class="hide-menu">Daftar Pengajuan</span></a> </li>
                    <?php }?>
                    <li class="devider"></li>
                    <li> <a href="<?=base_url()?>document" class="waves-effect"><i  class="mdi mdi-application fa-fw"></i> <span class="hide-menu">Dokumen</span></a> </li>
                    

                    <!--new 12-07-2017 -->
                    <?php if($logas=='admin' || $role==1 || $id_employee==10039 || $id_employee==10027){?>
                    <li><a href="javascript:void(0)" class="waves-effect <?php if($page=='kehadiran' || $page=='rekap'){echo 'active';}?>"><i class="mdi mdi-animation fa-fw"></i> <span class="hide-menu"> Laporan <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <?php if($logas=='admin'){if($role==1){?>
                            <li><a href="<?=base_url()?>report"><i class="mdi mdi-bell fa-fw"></i><span class="hide-menu"> Kehadiran</span></a></li>
                            <li><a href="<?=base_url()?>#"><i class="mdi mdi-briefcase-check fa-fw"></i><span class="hide-menu"> Uraian Pekerjaan</span></a></li>
                            <?php }}?>
                            <?php if($id_employee==10000 || $id_employee==10039){?>
                            <li><a href="<?=base_url()?>report/ob"><i class="mdi mdi-bell fa-fw"></i><span class="hide-menu"> Kehadiran OB</span></a></li>
                            <?php }?>
                            <?php if($logas=='admin' || $role==1 || $id_employee==10027){?>
                            <li><a href="javascript:void(0)" class="waves-effect"><i class="mdi mdi-clipboard fa-fw"></i><span class="hide-menu"> Rekap Pengajuan</span><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li><a href="<?=base_url()?>dinas/rekap"><i class="mdi mdi-airplane fa-fw"></i><span class="hide-menu">Dinas</span></a></li>
                                    <li><a href="<?=base_url()?>dinas/checklist"><i class="mdi mdi-check-circle fa-fw"></i><span class="hide-menu">Checklist Dinas</span></a></li>
                                    <li><a href="<?=base_url()?>piket/rekap"><i class="ti-layout fa-fw"></i> <span class="hide-menu">Piket</span></a></li>
                                    <li><a href="<?=base_url()?>permit_/rekap"><i class="ti-briefcase fa-fw"></i> <span class="hide-menu">Cuti / Izin</span></a></li>
                                </ul>
                            </li>
                            <?php }?>
                        </ul>
                    </li>
                    <?php }?>
                    <!-- end new -->
                    <?php if($logas=='admin'){if($role==1){?>
                    <li> <a href="<?=base_url()?>home/sync_absen" class="waves-effect" target='1'><i  class="mdi mdi-access-point-network"></i> <span class="hide-menu">Sync Absen</span></a> </li>
                    <?php }}?>
                    <li> <a href="<?=base_url()?>absensi" class="waves-effect"><i  class="mdi mdi-alarm fa-fw"></i> <span class="hide-menu">Absensi Saya</span></a> </li>
                    <li> <a href="<?=base_url()?>booking" class="waves-effect"><i  class="mdi mdi-domain fa-fw"></i> <span class="hide-menu">Ruang Meeting</span></a> </li>
                    <li> <a href="<?=base_url()?>faq" class="waves-effect"><i  class="mdi mdi-comment-question-outline"></i> <span class="hide-menu">Faq</span></a> </li>
                    <li> <a href="<?=base_url()?>setup" class="waves-effect"><i  class="mdi mdi-cog"></i> <span class="hide-menu">Setup</span></a> </li>
                    </li>
                </ul>
            </div>
        </div>
            
            <?= $contents ?>
            <!-- ============================================================== -->
                <!-- start right sidebar -->
                <!-- ============================================================== -->
                <!--<div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="gray" class="yellow-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="full-width"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="gray-dark" class="yellow-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme working">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/ritesh.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/john.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="../plugins/images/users/pawandeep.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                <!-- ============================================================== -->
                <!-- end right sidebar -->
                <!-- ============================================================== -->

                <div class="row" style="z-index: 9000">
                    <div class="col-md-4">
                            <!-- sample modal content -->
                            <!-- /.modal -->
                            <?php
                            $url=$_SERVER['REQUEST_URI'];
                            ?>
                            <div id="mymodal3" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <form method="post" action="<?=base_url()?>employee/ganti_password/<?=$id_employee;?>">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="padding:30px">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title" id="info" style="color:#999">Ganti Password</h4> 
                                        </div>
                                        <div class="modal-body">
                                                <input type="hidden" name="pg" value="<?=$url;?>">
                                                <div class="form-group">
                                                    <label for="recipient-name" class="control-label">Password lama :</label>
                                                    <input type="password" id="password_lama" onkeyup="return check2()" name="password_lama" class="form-control room-name" id="recipient-name" required> 
                                                    <span id='check_data' style="color: red" ></span>
                                                </div>
                                                    
                                                <div class="form-group">
                                                    <label class="control-label">Password baru :</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" class="form-control password" id="password" required> <span class="input-group-addon"><i class="icon-key"></i></span>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Confirm password baru :</label>
                                                    <div class="input-group">
                                                        <input type="password" id="confirm_password" class="form-control" onkeyup="check(this)" name="confirm" required> <span class="input-group-addon"> <i class="icon-key"></i> </span>
                                                    </div>
                                                    <span id='message' style="position: absolute;"></span>
                                                    <script type="text/javascript">
                                                  $('#confirm_password').on('keyup', function () {
                                                      if ($(this).val() == $('#password').val()) {
                                                          $('#message').html('').css('color', 'red');
                                                          document.getElementById('submit').disabled = false;
                                                      } else {
                                                          $('#message').html('password tidak sama').css('color', 'red');
                                                          document.getElementById('submit').disabled = true;
                                                      } 
                                                  });
                                              </script>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batal</button>
                                            <button type="submit" id="submit" name="booking" class="btn btn-danger waves-effect waves-light">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                    function check2(){
                        id = $("#password_lama").val();
                        $.get( "<?= base_url(); ?>employee/check_pass_lama" , { option : id } , function ( data ) {
                            $( '#check_data' ) . html ( data ) ;
                            salah = data;
                            if(salah=='Password lama salah !'){
                                document.getElementById('submit').disabled = true;
                            }else{
                                document.getElementById('submit').disabled = false;
                            }
                          } ) ;
                    }
                </script>
            <!-- /.container-fluid -->
            
            <footer class="footer text-center"> <?=date('Y');?> &copy; Liga Indonesia Baru </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?=base_url()?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url()?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?=base_url()?>assets/js/waves.js"></script>
    <!--Counter js -->
    <script src="<?=base_url()?>plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/morrisjs/morris.js"></script>
    <!-- chartist chart -->
    <script src="<?=base_url()?>plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!-- Sweet-Alert  -->
    <script src="<?=base_url()?>plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <!-- Calendar JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/moment/moment.js"></script>
    <!-- Magnific popup JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>
    <!-- Clock Plugin JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!-- Color Picker Plugin JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src='<?=base_url()?>plugins/bower_components/calendar/dist/fullcalendar.min.js'></script>
    <script src="<?=base_url()?>plugins/bower_components/calendar/dist/cal-init.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?=base_url()?>assets/js/custom.min.js"></script>
    <script src="<?=base_url()?>assets/js/dashboard1.js"></script>
    <!-- Custom tab JavaScript -->
    <script src="<?=base_url()?>assets/js/cbpFWTabs.js"></script>
    <!-- Form Wizard JavaScript -->
    <script src="<?=base_url()?>plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js"></script>
    <script type="text/javascript">
    (function() {
        [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) {
            new CBPFWTabs(el);
        });
    })();
    </script>
    <script src="<?=base_url()?>plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="<?=base_url()?>plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <!-- jQuery file upload -->
    <script src="<?=base_url()?>plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>
    <?php $minDate = date('m/d/Y');?>
    <script>
    // Clock pickers
    $('.clockpicker').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Selesai',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
    // Colorpicker
    $(".colorpicker").asColorPicker();
    $(".complex-colorpicker").asColorPicker({
        mode: 'complex'
    });
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'YYYY-MM-DD h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'Y-m-d',
        minDate: "<?=$minDate;?>",
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 6
        }
    });
    </script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
    </script>
    <script type="text/javascript">
    (function() {
        $('#exampleBasic').wizard({
            onFinish: function() {
                swal("Message Finish!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat eleifend ex semper, lobortis purus sed.");
            }
        });
        $('#exampleBasic2').wizard({
            
        });
        $('#exampleValidator').wizard({
            onInit: function() {
                $('#validation').formValidation({
                    framework: 'bootstrap',
                    fields: {
                        username: {
                            validators: {
                                notEmpty: {
                                    message: 'The username is required'
                                },
                                stringLength: {
                                    min: 6,
                                    max: 30,
                                    message: 'The username must be more than 6 and less than 30 characters long'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9_\.]+$/,
                                    message: 'The username can only consist of alphabetical, number, dot and underscore'
                                }
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required'
                                },
                                emailAddress: {
                                    message: 'The input is not a valid email address'
                                }
                            }
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: 'The password is required'
                                },
                                different: {
                                    field: 'username',
                                    message: 'The password cannot be the same as username'
                                }
                            }
                        }
                    }
                });
            },
            validator: function() {
                var fv = $('#validation').data('formValidation');
                var $this = $(this);
                // Validate the container
                fv.validateContainer($this);
                var isValidStep = fv.isValidContainer($this);
                if (isValidStep === false || isValidStep === null) {
                    return false;
                }
                return true;
            },
            onFinish: function() {
                $('#validation').submit();
                swal("Message Finish!");
            }
        });
        $('#accordion').wizard({
            step: '[data-toggle="collapse"]',
            buttonsAppendTo: '.panel-collapse',
            templates: {
                buttons: function() {
                    var options = this.options;
                    return '<div class="panel-footer"><ul class="pager">' + '<li class="previous">' + '<a href="#' + this.id + '" data-wizard="back" role="button">' + options.buttonLabels.back + '</a>' + '</li>' + '<li class="next">' + '<a href="#' + this.id + '" data-wizard="next" role="button">' + options.buttonLabels.next + '</a>' + '<a href="#' + this.id + '" data-wizard="finish" role="button">' + options.buttonLabels.finish + '</a>' + '</li>' + '</ul></div>';
                }
            },
            onBeforeShow: function(step) {
                step.$pane.collapse('show');
            },
            onBeforeHide: function(step) {
                step.$pane.collapse('hide');
            },
            onFinish: function() {
                swal("Message Finish!");
            }
        });
    })();
    </script>
    <!--Style Switcher -->
    <script src="<?=base_url()?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>