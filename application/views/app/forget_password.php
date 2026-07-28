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
<style>
h3
{
  font-size: 15px!important;
}
p,::placeholder {
  font-size: 12px!important;
}
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
                 <h6 class="mb-0 text-dark"><?php echo translate('recover_password');?></h6>
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

          <img class="login-img" src="<?php echo base_url('uploads/forgot-password.png')?>" alt="">

          <!-- <img class="login-img" src="<?php #echo base_url('assets/app/')?>img/bg-img/12.png" alt=""> -->
        <div id="forget_field">
            <h3 class="mb-0 text-dark mt-1" style="font-size: 1.3rem;font-weight: bold;"><?php echo translate('recover_password');?></h3>
        </div>
        <div id="otp_field" style="display:none">
          <h3 class="mb-0 text-dark mt-1" style="font-size: 1.3rem;font-weight: bold;"><?php echo translate('otp');?></h3>
          <p class="mb-0 text-dark mt-1"><?php echo translate('sended_otp_phone');?></p>
        </div>

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
          <p id="forget_msg" class="content-title text-dark text-center"><?=translate('forget_msg')?></p>
        </div>

        <!-- Register Form-->
        <div class="register-form mt-4 px-3">
          
          <div id="success-alert" 
                style="position: fixed;
                display: none;
                z-index: 9999999;
                width: 85%;"
                role="alert">

          </div>
          <form id="myForm" action="" method="POST">
             
            <div class="form-group" id="phone_field">
                <label for="phone"><i class="lni lni-mobile"></i></label>
                <input type="tel"  name="phone" id="phone"  class="form-control" placeholder="<?php echo translate('phone');?>" pattern="[6-9]{1}[0-9]{9}" required>
            </div>
            <div class="form-group"  id="output" style="display:none;">
                <label for="password"><i class="lni lni-user"></i></label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value=""><?=translate('choose_one')?></option>
                        <option value="1"><?=translate('Male')?></option>
                        <option value="2"><?=translate('Female')?></option>
                    </select>
            </div>


            <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
        <div id="pwdContainer" class="box-big" style="display:none;margin-bottom: 20px;">
          <input type="text" maxlength="1" id="otp1" class="box-text" autocomplete="off">
          <input type="text" maxlength="1" id="otp2" class="box-text" autocomplete="off">
          <input type="text" maxlength="1" id="otp3" class="box-text" autocomplete="off">
          <input type="text" maxlength="1" id="otp4" class="box-text" autocomplete="off">
        </div>



            <!-- <div class="form-group">
                <label for="password"><i class="lni lni-lock"></i></label>
                <input type="tel" class="form-control" name="phoneOtp"
                id= 'phoneOtp' placeholder="<?php echo translate('otp')?>" autofocus required>
                
            </div> -->
                <div class="row" style="display:none" id="otp_resend_field">
                    <div class="col-md-6">
                        <p class="f-pass text-dark"><?php echo translate('not_recive');?>  <a style="color: #ff3763!important" onclick="resendPhoneOtp()"><?php echo translate('Resend');?></a></p>
                    </div>
                </div>
            <div class="text-center">
                <button type="button" onclick="checkPhoneNumber()"
                id="checkPhone" class="btn btn-primary btn-lg w-100"><span><?php echo translate('submit')?></span></button>
                <!-- <button type="button" style='display:none' onclick="checkPhoneOtp()"
                id="submitOtp" class="btn btn-primary btn-lg w-100"><span><?php echo translate('submit')?></span></button> -->
            </div>
          </form>
        </div>

        <!-- Login Meta-->

        <div class="login-meta-data text-center mt-4">

          <!-- <a class="forgot-password d-block mt-3 mb-1" href="#">Forgot Password?</a> -->

           <!-- <p class="mb-0" style="font-size: 15px;"><span style="color:black"><?php echo translate('new_here?')?></span><a class="ml-2" style="color:#ff3763" href="<?php echo base_url('app/register') ?>"><?php echo translate('create_an_account_from_here!')?></a></p> -->

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
    


var password = [1,2,3,4];
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


    gender = $("#gender").val();
                    phone = $("#phone").val();
                    var otp1 = $('#otp1').val();
                    var otp2 = $('#otp2').val();
                    var otp3 = $('#otp3').val();
                    var otp4 = $('#otp4').val();
                    var otp = otp1+otp2+otp3+otp4;
                    
                    if(otp!= ''){
                    
                        URL = "<?=base_url('LoginController/appcheckPhone')?>";
                    $.ajax({
                        url: URL,
                        data: {'phone': phone,"otp":otp,'gender': gender}, // change this to send js object
                        type: "post",
                        success: function(data){
                            console.log(data);
                           if(data == 1)
                           {
                            window.location.href = "<?=base_url('LoginController/appforgotChangePassword/')?>"+phone+'/'+gender;
                            // $("#otp").show();
                            // $("#phone").attr('disabled','disabled');
                            // $("#checkPhone").hide();
                            // $("#submitOtp").show();
                           }
                          else{
                            $('#success-alert').addClass('alert alert-danger');
                            $('#success-alert').html("Please enter correct Otp!!");
                            $("#success-alert").show();
                            setTimeout(function(){
                            $('#success-alert').hide();
                            },3000);
                               
                          }
                        }
                    });


return false;


                    }
                    else{
                        $('#success-alert').addClass('alert alert-danger');
                        $('#success-alert').html("Please enter correct Otp!!");
                        $("#success-alert").show();
                        setTimeout(function(){
                        $('#success-alert').hide();
                        },3000);
                    }





 
}


function resendPhoneOtp()
{
    var phone =  $("#phone").val();
    var gender =  $("#gender").val();
    var base_url=$('#base_url').val();
                $.ajax({
                  type: 'POST',
                  url: base_url+'LoginController/appresendLoginOtp',
                  data: '&phone='+phone+'&gender='+gender,
                  success:function(html)
                  {   
                    
                    alert('sended');         
                         
                  }
              });

}

</script>




    <script>
         $("#phone").keyup(function(){
          console.log('qssqs');
         var mobile =  $("#phone").val();
         var base_url=$('#base_url').val();
         // alert(base_url);
         if(mobile.length == 10){
                $.ajax({
                  type: 'GET',
                  url: base_url+'appController/getMobile',
                  data: '&mobile='+mobile,
                  success:function(html)
                  {   
                    console.log(html);
                    if(html==1){

                        $('#output').show();       
                    }else{
                        $('#output').hide(); 
                    }         
                         
                  }
              }); 
            }
        });


</script>

<script>
         

$(document).ready(function(){
setTimeout(function(){
        $('#app_flash').fadeOut();
      },3000);
});

function checkPhoneNumber()
    {   
        var phone = $("#phone").val();
        var gender = $("#gender").val();
        if(phone!= ''){
        var otp = '';
        URL = "<?=base_url('LoginController/appcheckPhone')?>";
        $.ajax({
            url: URL,
            data: {'phone': phone,'gender': gender}, // change this to send js object
            type: "post",
            success: function(data){
             console.log(data);
               if(data == 3)
               {
                // window.location.href = "<?=base_url('home/login/verifyOtp')?>";
                $('#phone_field').hide();
                $("#pwdContainer").show();
                $("#otp_resend_field").show();
                $("#phone").attr('disabled','disabled');
                $("#gender").attr('disabled','disabled');
                $("#checkPhone").hide();
                // $("#submitOtp").show();
                $('#otp_field').show();
                $('#forget_field').hide();
                $('#output').hide();
                $('#forget_msg').hide();
               }
              else{
                    $("#pwdContainer").hide();
                    $("#otp_resend_field").hide();
                    $('#forget_field').show();
                    $('#otp_field').hide();
                    $('#phone_field').show();
                    $('#success-alert').addClass('alert alert-danger');
                    $('#success-alert').html('phone_number_not_register!!');
                    $("#success-alert").show();
                    setTimeout(function(){
                    $('#success-alert').hide();
                    },3000); 
              }
            }
        });


        return false;


        }
        else{
            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('required!!');
            $("#success-alert").show();
            setTimeout(function(){
            $('#success-alert').hide();
            },3000); 
            return false;
        }
    }
    
    function checkPhoneOtp()
                {   
                    gender = $("#gender").val();
                    phone = $("#phone").val();
                    otp = $("#phoneOtp").val();
                    if(otp!= ''){
                    
                        URL = "<?=base_url('LoginController/appcheckPhone')?>";
                    $.ajax({
                        url: URL,
                        data: {'phone': phone,"otp":otp,'gender': gender}, // change this to send js object
                        type: "post",
                        success: function(data){
                            console.log(data);
                           if(data == 1)
                           {
                            window.location.href = "<?=base_url('LoginController/appforgotChangePassword/')?>"+phone+'/'+gender;
                            // $("#otp").show();
                            // $("#phone").attr('disabled','disabled');
                            // $("#checkPhone").hide();
                            // $("#submitOtp").show();
                           }
                          else{
                            $('#success-alert').addClass('alert alert-danger');
                            $('#success-alert').html("Please enter correct Otp!!");
                            $("#success-alert").show();
                            setTimeout(function(){
                            $('#success-alert').hide();
                            },3000);
                               
                          }
                        }
                    });


return false;


                    }
                    else{
                        $('#success-alert').addClass('alert alert-danger');
                        $('#success-alert').html("Please enter correct Otp!!");
                        $("#success-alert").show();
                        setTimeout(function(){
                        $('#success-alert').hide();
                        },3000);
                    }
                }
</script>
  </body>

</html>