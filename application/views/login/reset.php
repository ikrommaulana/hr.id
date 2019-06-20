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
      
      
      <form class="form-horizontal form-material" id="loginform" action="<?=base_url()?>login/reset_pwd" method="post">
        <input type="hidden" name="token" value="<?=$token;?>">
        <div class="form-group ">
          <div class="col-xs-12">
            <h3>Perbarui Password</h3>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="password" required="" name="password" placeholder="Password baru">
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="password" required="" name="pasword" placeholder="Confirm password baru">
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
