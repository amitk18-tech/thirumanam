<?php

if($this->session->userdata('thirumanam_applogged_data')){

   redirect('app/home');
}


?>
<input type="hidden" id="base_url" value="<?php echo base_url();?>">
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
h3
{
  font-size: 15px!important;
}
p,::placeholder {
  font-size: 12px!important;
}
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
    font-size: 13px!important;
    border: 1px solid #ff3763!important;
    color:black!important;
}

.lni-mobile,.lni-user,.lni-lock,.lni-envelope
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
/*font-size: 16px!important;*/
font-weight: bold;
}
option
{
    background-color: white;
    color: black;
}
.login-wrapper {
    
/*  min-height: 85vh!important;*/
}
</style>
<?php
 // print_r($uri1);exit;
 if ($set_lang = $this->session->userdata('language')) {
 
 } else {
     $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
 }
 $lid = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->site_language_list_id;
 $lnm = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->name;
 ?>
  <body>

    <!-- Preloader-->

    <div class="preloader" id="preloader">

      <div class="spinner-grow text-secondary" role="status">

        <div class="sr-only">Loading...</div>

      </div>

    </div>

    <!-- Login Wrapper Area-->
    <div class="header-area" id="headerArea" style="height: 50px;">
     <div class="container h-100 align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="row mt-2">
           <div class="col-1">
              <div class="back-button"><a href="<?php echo "javascript:history.back()"; ?>"><i class="lni lni-chevron-left text-dark"></i></a>
              </div>
           </div>
           <div class="col-11 mt-1">
              <div class="page-heading">
                 <h6 class="mb-0 text-dark"><?php echo translate('reset_password');?></h6>
              </div> 
           </div>
        </div>
        
       </div>
    </div>
    <div class="login-wrapper d-flex align-items-center justify-content-center">

      <!-- Shape-->

      <!-- <div class="login-shape"><img style="width: 170px;" src="<?php echo base_url('assets/app/')?>img/core-img/login.png" alt=""></div> -->

      <!-- <div class="login-shape2"><img src="<?php echo base_url('assets/app/')?>img/core-img/login2.png" alt=""></div> -->

      <?php echo $this->session->flashdata('msg'); ?>
      <div class="container">
        <?php echo $this->session->flashdata('msg'); ?>
              <div id="success-alert" 
                    style="position: fixed;
                    display: none;
                    z-index: 9999999;
                    width: 93%;"
                    role="alert">

              </div>
        <!-- Login Text-->

        <div class="login-text text-center">

          <img class="login-img" src="<?php echo base_url('uploads/change.png')?>" alt="">

          <!-- <img class="login-img" src="<?php #echo base_url('assets/app/')?>img/bg-img/12.png" alt=""> -->

          <h3 class="mb-0 text-dark" style="font-size: 1.3rem;font-weight: bold;"><?php echo translate('reset_password');?></h3>

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
          <form class="contact-form" id="myForm" action="<?php echo base_url('LoginController/appchangeNewPassword/');?>" method="POST">
            <div class="form-group w-100">
                <input type="hidden" id="phone" name="phone" value="<?php echo $phone;?>">
                <input type="hidden" id="gender" name="gender" value="<?php echo $gender;?>">
            </div>
            <div class="form-group">
              <label for="phone"><i class="lni lni-lock"></i></label>
                <input class="form-control" type="text" placeholder="<?php echo translate('new_password');?>" name="new_password" id="new_password" required>
            </div>
            <div class="form-group">
              <label for="phone"><i class="lni lni-lock"></i></label>
                <input class="form-control" type="text" placeholder="<?php echo translate('confirm_password')?>" name="confirm_password" id="confirm_password" required>
            </div>
            
            <div class="form-group w-100 text-center">
                <button class="btn btn-primary btn-lg w-100" type="button" onclick="return Validate()"><span><?php echo translate('submit')?></span></button>
            </div>
        </form>
                
        </div>

        <!-- Login Meta-->

        <div class="login-meta-data text-center mt-4">

          <!-- <a class="forgot-password d-block mt-3 mb-1" href="#">Forgot Password?</a> -->

          
        </div>

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
$(document).ready(function(){
setTimeout(function(){
        $('#app_flash').fadeOut();
      },3000);
})

    function Validate() {
            var password = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            // alert(month);
            if(!password.match(passw)){
                $('#success-alert').addClass('alert alert-danger');
                $('#success-alert').html('6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },5000);
            }
            else if(password != confirmPassword){
                $('#success-alert').addClass('alert alert-danger');
                $('#success-alert').html('password And Confirm Password Did Not Match!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
            }else if(password=="" || confirmPassword==""){
                $('#success-alert').addClass('alert alert-danger');
                $('#success-alert').html('New Password or Confirm Password is empty!!');
                $('#success-alert2').show();
                setTimeout(function(){
                $('#success-alert2').hide();
                },3000);
            }
            else{
            document.getElementById("myForm").submit();
            }
        }


document.getElementById('confirm_password').onkeyup=function(){
    var password = $("#new_password").val();
    var confirm_password = $("#confirm_password").val();
    if(password != confirm_password) {
           $("#confirm_password").css('border-color', "red");
    }
        else{
           $("#confirm_password").css('border-color', "green");
        }
}
</script>
  </body>

</html>