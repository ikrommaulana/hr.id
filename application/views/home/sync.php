<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html><html lang='en' class=''>
<head><script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script><script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script><meta charset='UTF-8'><meta name="robots" content="noindex">
<title>HR System Syncronize</title>


<style class="cp-pen-styles">body {
  background: #ccc;
  text-align: center;
}
.container li {
  padding: 30px;
  display: table-cell;
}
.button {
  display: block;
  background: #ddd;
  position: relative;
  margin: auto;
  cursor: pointer;
  text-align: center;
  font-family: Arial;
  font-size: 14px;
  line-height: 50px;
  border-radius: 25px;
  color: #333;
  text-shadow: 0px 1px 0px #fff;
  width: 50px;
  height: 50px;
  box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.6), inset 0px 1px 3px #fff;
  -webkit-transition: all 0.1s ease-out;
  -moz-transition: all 0.1s ease-out;
  -o-transition: all 0.1s ease-out;
  transition: all 0.1s ease-out;
}
.button:hover {
  background: #eee;
  box-shadow: 0px 12px 15px rgba(0, 0, 0, 0.6);
}
.button:active {
  color: #555;
  text-shadow: 0px 1px 0px #aaa;
  background: #999;
  box-shadow: inset 0px 10px 15px rgba(0, 0, 0, 0.4), inset 0px -1px 3px rgba(0, 0, 0, 0.7);
}
.button:before {
  display: block;
  content: '';
  position: absolute;
  top: -8px;
  left: -8px;
  z-index: -1;
  text-align: center;
  border: 1px solid #ddd;
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #eee;
  border-radius: 32px;
  width: 64px;
  height: 64px;
  box-shadow: 0 10px 20px #999, inset 0px 1px 5px #000, 0 -10px 20px #fff;
  background: #555;
  background: -webkit-gradient(linear, left bottom, left top, color-stop(0, #555), color-stop(1, #444));
  background: -ms-linear-gradient(bottom, #555, #444);
  background: -moz-linear-gradient(center bottom, #555 0%, #444 100%);
  background: -o-linear-gradient(#444, #555);
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#444', endColorstr='#555', GradientType=0);
}
.button:after {
  display: none;
  content: '';
  position: absolute;
  top: -7px;
  left: -7px;
  width: 64px;
  height: 64px;
  border-radius: 35px;
  background: none;
  box-shadow: 0 0 3px #b4ff00, inset 0 0 20px #b4ff00;
}
.button.large {
  width: auto;
  padding: 0px 30px;
}
.button.large:before {
  padding: 0px 100px;
  content: '';
  width: auto;
}
.button.large:after {
  padding: 0px 100px;
  content: '';
  width: auto;
}
.button.active:before {
  background: #FF0040;
}
.button.active:after {
  display: block;
}
</style></head><body>
<html>
  <body>
    <ul class='container' style="margin-top:240px">
        <center>
      <li>
        <div class='button large'>Mesin absensi tidak terkoneksi ke jaringan, silahkan refresh terlebih dahulu !</div>
      </li>
      </center>
    </ul>
  </body>
</html>
<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script><script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script >$(document).ready( function () {
  $('.button2').on('click', function () {
    $(this).toggleClass('active');
  });
});
//# sourceURL=pen.js
</script>
</body></html>