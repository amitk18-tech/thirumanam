
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <title>Thirumanam Matrimony</title>
    <link rel="icon" href="<?php echo base_url('uploads/app-logo.png')?>">    
    <link rel="stylesheet" href="<?php echo base_url('assets/app/')?>css/style.css">
    <script src="<?php echo base_url('assets/app/')?>js/jquery.min.js"></script>
</head>
<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<style type="text/css">
  .login-wrapper
  {
/*      background-color: #31135b;*/
  }
  .login-text h3{
    color: #fff;
  }
  .login-meta-data a{
    color: #fff;
  }
  p{
    color: #eae6ff;
  }
</style>
<style>
   .btn-primary {
      background-color: #ff3763!important;
      border-radius: 7px!important;
      width: 80%!important;
      box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19)!important;

   }



.register-form .form-control
{
   background-color: #ffffff!important;
    border: 0!important;
    border-radius: 7px!important;
    padding-left: 2rem!important;
/*    box-shadow: 1px 1px 1px 1px rgba(16, 13, 209, 0.175)!important;*/
    font-size: 16px!important;
    border: 1px solid #ff3763!important;
    color:black!important;
}

.lni-mobile,.lni-user,.lni-lock
{
  padding-left: 5px;
  color:black!important;
  font-size: 16px!important;
  font-weight: bold!important;
}

::placeholder {
/*   text-align: center; */
padding-left: 5px;
color: black!important;
font-size: 16px!important;
font-weight: bold;
}


</style>
<style>
    div.box-big {
      margin-bottom: 10px;
      text-align: center;
      display:inline-block;
      width: 100%;

    }

    input.box-text {
      width: 50px;
      height: 50px;
      border: 2px solid #ff3763!important;
      border-radius: 10px;
      text-align: center;
      font-weight: bold;
      margin: 5px;
    }
</style>
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
    <!-- Login Wrapper Area-->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
      <!-- Shape-->
      <!-- <div class="login-shape"><img src="<?php echo base_url('assets/app/')?>img/core-img/login.png" alt=""></div> -->
      <!-- <div class="login-shape2"><img src="<?php echo base_url('assets/app/')?>img/core-img/login2.png" alt=""></div> -->
      <?php echo $this->session->flashdata('msg'); ?>
      <div class="container">
        <!-- Login Text-->
        <div class="login-text text-center">
          <img class="login-img" src="<?php echo base_url('uploads/forgot-password.png')?>" alt="">
          <!-- <img class="login-img" src="<?php #echo base_url('assets/app/')?>img/bg-img/12.png" alt=""> -->
          <!-- <h3 class="mb-0 text-dark"><?=translate('login_title')?></h3> -->
          <h3 class="mb-0 text-dark mt-1" style="font-size: 1.3rem;font-weight: bold;"><?php echo translate('otp');?></h3>
          <p class="mb-0 text-dark mt-1"><?php echo translate('sended_otp_phone');?></p>
          <!-- Shapes-->
          <!-- <div class="bg-shapes">
            <div class="shape1"></div>
            <div class="shape2"></div>
            <div class="shape3"></div>
            <div class="shape4"></div>
            <div class="shape5"></div>
            <div class="shape6"></div>
            <div class="shape7"></div>
            <div class="shape8"></div>
          </div> -->
        </div>
        <!-- Register Form-->
        <div class="register-form mt-4 px-3">
          
          <div id="success-alert" 
                style="position: fixed;
                display: none;
                top: 82px;
                z-index: 9999999;
                width: 85%;"
                role="alert">

          </div>
            <form action="<?php echo base_url('LoginController/appcheckPhoneOtp')?>" method="post">
                <div class="form-group">
                    <label ></label>
                    <!-- <input class="form-control" type="password" name="otp" min="4" max="4" placeholder="<?php echo translate('otp')?>"   required> -->
                    <div id="pwdContainer" class="box-big" style="margin-bottom: 20px;">
                      <input type="text" maxlength="1" id="otp1" class="box-text" autocomplete="off">
                      <input type="text" maxlength="1" id="otp2" class="box-text" autocomplete="off">
                      <input type="text" maxlength="1" id="otp3" class="box-text" autocomplete="off">
                      <input type="text" maxlength="1" id="otp4" class="box-text" autocomplete="off">
                    </div>
                </div>
                    <input type="hidden" value="<?php echo $member_id;?>" name="member_id" id="member_id">
                    <input type="hidden" value="<?php echo $remember_me;?>" name="remember_me" id="remember_me">
                <div class="row">
                    <div class="col-md-6">
                        <p class="f-pass text-dark"><?php echo translate('not_recive');?>  <a style="color: #ff3763!important" href="<?php echo base_url('LoginController/appresendOtp/'.$member_id);?>"><?php echo translate('Resend');?></a></p>
                    </div>
                </div>
                <div class="text-center">
                    <!-- <button type="submit" class="btn btn-primary btn-lg w-100"><span><?php echo translate('submit')?></span></button> -->
                </div>
            </form>
      </div>
    </div>
    <!-- All JavaScript Files-->
    <script src="<?php echo base_url('assets/app/')?>js/popper.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/waypoints.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/jquery.easing.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/owl.carousel.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/jquery.animatedheadline.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/wow.min.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/default/date-clock.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/default/dark-mode-switch.js"></script>
    <script src="<?php echo base_url('assets/app/')?>js/default/active.js"></script>
<script>
    
    var pwdInputs = $("#pwdContainer input");
var inputs = pwdInputs.toArray();

pwdInputs.keyup(function(){

  if (this.value.length == this.maxLength) {
    if(inputs.indexOf(this) == inputs.length-1){
      testPassword();
    } else {
      $(this).next('input').focus();
    }
  }
});


function testPassword(){
    

    member_id = $("#member_id").val();
    remember_me = $("#remember_me").val();
    var otp1 = $('#otp1').val();
    var otp2 = $('#otp2').val();
    var otp3 = $('#otp3').val();
    var otp4 = $('#otp4').val();
    var otp = otp1+otp2+otp3+otp4;
     window.location.href = "<?=base_url('LoginController/appcheckPhoneOtp/')?>"+member_id+'/'+remember_me+'/'+otp;
}



     $(document).ready(function(){
        setTimeout(function(){
            $('#app_flash').fadeOut();
          },3000);
        });
</script>

  </body>
</html>