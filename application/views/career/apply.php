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
                            <h1 style="font-family:cursive; color: #999">Join Us</h1>
                        </div>
                    </div>
                </div>
            </header>
            <div class="container" style="margin-top: 100px">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="w-box">
                            <div class="w-box-header">
                                <h4>Aplication Form :</h4>
                            </div>
                            <form action="<?=base_url() ?>career/submit" method="post" enctype="multipart/form-data" id="form2" class="form-horizontal">
                            <input type="hidden" name="id_recruitment_request" value="<?=$id_recruitment_request;?>">
                            <div class="w-box-content"><br><br>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span4"></div>
                                        <div class="span4">
                                            <label>Firstname</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="firstname" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span4"></div>
                                        <div class="span4">
                                            <label>Lastname</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="lastname" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span4"></div>
                                        <div class="span4">
                                            <label>Email</label>
                                            <div class="input-group">
                                                <input type="email" class="form-control" name="email" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span4"></div>
                                        <div class="span4">
                                            <label>CV</label>
                                            <div class="input-group" style="border:1px solid #dedede; width:103%; border-radius:5px 5px">  
                                                <label class="btn btn-default" for="my-file-selector">
                                                    <input id="my-file-selector" type="file" name="userfile" accept="application/vnd.ms-excel, .pdf" style="display:none; width:200px" onchange="$('#upload-file-info').html($(this).val());" required>
                                                    Search File...
                                                </label>
                                                <span class='label label-info' id="upload-file-info" style="margin-left:10px"></span>
                                            </div>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                </div><br>
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="span4"></div>
                                        <div class="span4">
                                            <button type="submit" name="save" class="btn btn-success" style="width:150px">Apply</button>
                                            <a type="button" class="btn btn-danger" data-dismiss="modal" style="width:150px">Cancel</a>
                                        </div>
                                        <div class="span4"></div>
                                    </div>
                                </div><br><br>
                            </form>
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