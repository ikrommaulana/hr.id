<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
<title>HR | System Login</title>
<!-- Bootstrap Core CSS -->
<link href="<?=base_url()?>assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?=base_url()?>assets/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?=base_url()?>assets/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?=base_url()?>assets/css/colors/blue.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
  <div class="login-box login-sidebar">
    <div class="white-box">
      <form class="form-horizontal form-material" id="loginform" action="<?=base_url()?>login/aksi" method="post">
        <a href="javascript:void(0)" class="text-center db"><img width="200" src="<?=base_url()?>assets/img/lib.png" alt="Home" /><br/></a>  
        
        <div class="form-group m-t-40">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" name="email" placeholder="User Email">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control" type="password" required="" name="password" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
              <input id="checkbox-signup" type="checkbox">
              <label for="checkbox-signup"> Remember me </label>
            </div>
            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Lupa Password</a>
             </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
            <?=$this->session->flashdata('notifikasi')?>
          </div>
        </div>
      </form>
      <form class="form-horizontal" method="post" id="recoverform" action="<?=base_url()?>login/reset">
        <div class="form-group ">
          <div class="col-xs-12">
            <h3>Perbarui Password</h3>
            <p class="text-muted">Masukan alamat email Anda ! </p>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" name="email" placeholder="Email">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="<?=base_url()?>plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?=base_url()?>assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?=base_url()?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="<?=base_url()?>assets/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?=base_url()?>assets/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?=base_url()?>assets/js/custom.min.js"></script>
<!--Style Switcher -->
<script src="<?=base_url()?>plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
