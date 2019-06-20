<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title>Kioslabs Career</title>
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <link rel="icon" type="image/ico" href="#">
        
        <!-- common stylesheets-->
        <!-- bootstrap framework css -->

        <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?=base_url()?>assets/bootstrap/css/bootstrap-responsive.min.css">
        <!-- google web fonts -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Abel">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">

        <!-- aditional stylesheets -->
        <!-- datatables -->
        <link rel="stylesheet" href="<?=base_url()?>assets/js/lib/datatables/css/datatables_beoro.css">

        <!-- datepicker -->
            <link rel="stylesheet" href="<?=base_url()?>assets/js/lib/bootstrap-datepicker/css/datepicker.css">

        <!-- main stylesheet -->
        <link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">

        <!-- aditional stylesheets -->
        

        <!-- main stylesheet -->
            <link rel="stylesheet" href="<?=base_url()?>assets/css/beoro.css">

        <!--[if lte IE 8]><link rel="stylesheet" href="css/ie8.css"><![endif]-->
        <!--[if IE 9]><link rel="stylesheet" href="css/ie9.css"><![endif]-->
            
        <!--[if lt IE 9]>
        <script src="js/ie/html5shiv.min.js"></script>
        <script src="js/ie/respond.min.js"></script>
        <script src="js/lib/flot-charts/excanvas.min.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
               
    </head>

    <body class="bg_e"> 
        <div class="main-wrapper">
            <header>
                <div class="container">
                    <div class="row">
                        <div class="span10">
                            <div class="main-logo"><a href="<?=base_url() ?>home/index">
                            <img width="120" src="<?=base_url()?>assets/img/logo.png" alt="Logo Company"></a>
                            </div>
                        </div>
                        <div class="span2" style="margin-top: 15px;">
                            <h1 style="font-family:arial; color: #999">Join Us</h1>
                        </div>
                    </div>
                </div>
            </header>
            <div class="container" style="margin-top: 100px">
            <?=$this->session->flashdata('notifikasi')?>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Career's List</h4>
                            </div>
                            <div class="w-box-content">
                                <table class="table table-vam table-striped" id="dt_gal">
                                    <thead>
                                        <tr>
                                            <th>Division</th>
                                            <th>Position</th>
                                            <th>Requirements</th>
                                            <th>Recruit Date</th>
                                            <th>Recruit Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; foreach($data_career as $view){?>
                                        <tr>
                                            <td>
                                                <?php $div=$this->db->query("SELECT * FROM division WHERE id_division='$view->id_division'")->result(); echo $div[0]->division_name;?>
                                            </td>
                                            <td>
                                                <?php $pos=$this->db->query("SELECT * FROM jabatan WHERE id_jabatan='$view->position'")->result(); echo $pos[0]->nama_jabatan;?>
                                            </td>
                                            <td><?=$view->requirement;?></td>
                                            <td><?php $tanggal = strtotime($view->recruit_date); $dt = date("d F Y  ", $tanggal); echo $dt;?>                                                
                                            </td>
                                            <td><?=$view->recruit_total;?></td>
                                            <td>
                                                <div style="padding:2px 20px" class="<?php 
                                                    if($view->status=='Waiting'){
                                                        echo 'label label-default';
                                                    }elseif($view->status=='Processing'){
                                                        $status = 'Open';
                                                        echo 'label label-success';
                                                    }elseif($view->status=='Recruit'){
                                                        echo 'label label-success';
                                                    }else { 
                                                        echo 'label label-important';
                                                    }?>"><?=$status;?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="<?=base_url()?>career/apply/<?=$view->id_recruitment_request;?>" class="btn btn-mini" title="Apply"><i class="icon-check"></i></a>
                                                 </div>
                                            </td>
                                        </tr>
                                        <?php $no++;}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br><br><br>
<div class="footer_space"></div>
        </div> 

        <footer style="bottom:0">
            <div class="container">
                <div class="row">
                    <div class="span12">
                        <div>&copy; Kioslabs <?php echo date("Y");?></div>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Common JS -->
        <!-- jQuery framework -->
        <!-- Include SmartWizard JavaScript source -->
    <script type="text/javascript" src="<?=base_url()?>assets/js/jquery.smartWizard.min.js"></script>
        
        <script src="<?=base_url()?>assets/js/bootbox.min.js"></script>
        <script src="<?=base_url()?>assets/js/jquery-migrate.js"></script>
        <!-- bootstrap Framework plugins -->
        <script src="<?=base_url()?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- top menu -->
        <script src="<?=base_url()?>assets/js/jquery.fademenu.js"></script>
        <!-- top mobile menu -->
        <script src="<?=base_url()?>assets/js/selectnav.min.js"></script>
        
        <!-- file upload widget -->
            <script src="<?=base_url()?>assets/js/form/bootstrap-fileupload.min.js"></script>
        
        <!-- Table -->
        <!-- datatables -->
        <script src="<?=base_url()?>assets/js/lib/datatables/js/jquery.dataTables.min.js"></script>
        <script src="<?=base_url()?>assets/js/lib/datatables/js/jquery.dataTables.sorting.js"></script>
        <!-- datatables bootstrap integration -->
        <script src="<?=base_url()?>assets/js/lib/datatables/js/jquery.dataTables.bootstrap.min.js"></script>
        <!-- colorbox -->
        <script src="<?=base_url()?>assets/js/lib/colorbox/jquery.colorbox.min.js"></script>
        <!-- general -->
        <script src="<?=base_url()?>assets/js/pages/beoro_tables.js"></script>
        
        <!-- Dashboard JS -->
        <!-- jQuery UI -->
        <script src="<?=base_url()?>assets/js/lib/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
        <!-- touch event support for jQuery UI -->
        <script src="<?=base_url()?>assets/js/lib/jquery-ui/jquery.ui.touch-punch.min.js"></script>
        <!-- datepicker -->
        <script src="<?=base_url()?>assets/js/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <!-- colorbox -->
        <script src="<?=base_url()?>assets/js/lib/colorbox/jquery.colorbox.min.js"></script>
        <!-- fullcalendar -->
        <script src="<?=base_url()?>assets/js/lib/fullcalendar/fullcalendar.min.js"></script>
         
        <script src="<?=base_url()?>assets/js/pages/beoro_dashboard.js"></script>
        <script src="<?=base_url()?>assets/js/pages/beoro_form_elements.js"></script>
        
        
    </body>
</html>