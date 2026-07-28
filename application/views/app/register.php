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

.lni-mobile,.lni-user,.lni-lock,.lni-envelope,.fa-calendar-alt
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
  <body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      <div class="spinner-grow text-secondary" role="status">
        <div class="sr-only">Loading...</div>
      </div>
    </div>
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
                 <h6 class="mb-0 text-dark"><?php echo translate('register');?></h6>
              </div> 
           </div>
        </div>
        
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
          <img class="login-img" src="<?php echo base_url('uploads/register.png')?>" alt="">
          <!-- <img class="login-img" src="<?php #echo base_url('assets/app/')?>img/bg-img/12.png" alt=""> -->
          <h3 class="content-title mb-0 text-dark mt-1" style="font-size: 1.3rem;font-weight: bold;"><?=translate('let_started')?></h3>
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
          <!-- <p class="text-dark">Please create an account to continue</p> -->
        </div>
        <!-- Register Form-->
        <div class="register-form mt-2 px-3">
          
          <div id="success-alert" 
                style="position: fixed;
                display: none;
                z-index: 9999999;
                width: 85%;"
                role="alert">

          </div>
          <form id="myForm" action="<?php echo base_url('LoginController/appsaveRegister')?>" method="POST">
                <p class="content-title text-dark text-center"><?=translate('registrationNote')?></p>
                <div class="form-group">
                    <label for="username"><i class="lni lni-user"></i></label>
                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="<?php echo translate('Name')?>" required>
                </div>
                <div class="form-group">
                  <label for="gender"><i class="lni lni-user"></i></label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value=""><?=translate('choose_one')?></option>
                        <option value="1"><?=translate('Male')?></option>
                        <option value="2"><?=translate('Female')?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email"><i class="lni lni-envelope"></i></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo translate('email')?>" required>
                </div>
                <?php $member_approval = $this->db->get_where('general_settings', array('type' => 'member_approval_by_admin'))->row()->value;
                        if($member_approval == 'yes'){ ?>
                            <input name="approval_status" value="pending" hidden="">
                        <?php } else { ?>
                            <input name="approval_status" value="approved" hidden="">
                    <?php } ?>
                <div class="form-group">
                    <label><i class="fas fa-calendar-alt"></i></label>
                    <input type="date" onchange="setday(this.value)" name="date_of_birth" placeholder="<?php echo translate('date_of_birth')?>" id="date_of_birth" class="form-control" required>
                    <input type= "hidden" value="" id="birthDay" name="birthDay" >
                </div>
                <div class="form-group">
                    <label for="mobile_number"><i class="lni lni-mobile"></i></label>
                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="<?php echo translate('mobile')?>" pattern="[6-9]{1}[0-9]{9}">
                </div>
                <!-- <h4 class="content-title mt-5">Profile Details</h4> -->
                <div class="form-group">
                    <label for="username"><i class="lni lni-user"></i></label>
                    <input type="text" name="father" id="father" class="form-control" placeholder="<?php echo translate('father')?>" required>
                </div>
                <div class="form-group">
                    <label for="username"><i class="lni lni-user"></i></label>
                    <input type="text" name="mother" id="mother" class="form-control" placeholder="<?php echo translate('mother')?>" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="lni lni-lock"></i></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo translate('password')?>" required>
                </div>
                <div class="form-group">
                    <label for="password"><i class="lni lni-lock"></i></label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="<?php echo translate('confirm_password')?>" required>
                </div>
                <div class="text-center">
                    <button class="btn btn-primary btn-lg w-100" type="button" onclick="return Validate()"><span><?php echo translate('register')?></span></button>
                </div>
            </form>
        </div>
        <!-- Login Meta-->
        <div class="login-meta-data text-center mt-3" style="margin-bottom: 65px!important;">
          <!-- <a class="forgot-password d-block mt-3 mb-1" href="#">Forgot Password?</a> -->
           <p class="mb-0"><a class="ml-2" href="<?php echo base_url('app/login'); ?>"><?php echo translate('go_back')?></a></p> 
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
      });

        function setday(day)
        {
            
            var d = new Date(day);
            var n = d.getDay()
            var arr = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
            $("#birthDay").val(arr[n]);
            
        }
        function Validate() {
            var first_name = document.getElementById("first_name").value;
            var gender = document.getElementById("gender").value;
            var email = document.getElementById("email").value;
            var father = document.getElementById("father").value;
            var mother = document.getElementById("mother").value;
            var date_of_birth = document.getElementById("date_of_birth").value;
            var mobile = document.getElementById("mobile").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var date = new Date($('#date_of_birth').val());
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            var age =  18;
            var mydate = new Date();
            mydate.setFullYear(year, month-1, day);

            var currdate = new Date();
            currdate.setFullYear(currdate.getFullYear() - age);
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            // alert(month);
            if(mobile ==''){
                    $("#mobile").css('border-color', "red");
                }else{
                    $("#mobile").css('border-color', "");
                }
                if(gender==""){
                     $("#gender").css('border-color', "red");
                }else{
                    $("#gender").css('border-color', "");
                }
                if(password==""){
                     $("#password").css('border-color', "red");
                }else{
                    $("#password").css('border-color', "");
                }
                if(date_of_birth==""){
                     $("#date_of_birth").css('border-color', "red");
                }else{
                    $("#date_of_birth").css('border-color', "");
                }
                if(confirmPassword==""){
                     $("#confirm_password").css('border-color', "red");
                }else{
                    $("#confirm_password").css('border-color', "");
                }
                if(first_name==""){
                     $("#first_name").css('border-color', "red");
                }else{
                    $("#first_name").css('border-color', "");
                }
                if(email==""){
                     $("#email").css('border-color', "red");
                }else{
                    $("#email").css('border-color', "");
                }
                if(father==""){
                     $("#father").css('border-color', "red");
                }else{
                    $("#father").css('border-color', "");
                }
                if(mother==""){
                     $("#mother").css('border-color', "red");
                }else{
                    $("#mother").css('border-color', "");
                }
            if(mobile =='' || gender=="" || password=='' || date_of_birth=='' || confirmPassword=='' || first_name=='' || email=='' || father=='' || mother==''){
            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('reqired field!!');
            $('#success-alert').show();
                  setTimeout(function(){
                        $('#success-alert').hide();
                      },3000);
            }
            else if(!password.match(passw)){
              $('#success-alert').addClass('alert alert-danger');
              $('#success-alert').html('6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },5000);
            }
            else if(currdate < mydate){
              $('#success-alert').addClass('alert alert-danger');
              $('#success-alert').html('You must be at least 18 years of age!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
            }
            else if(password != confirmPassword){
              $('#success-alert').addClass('alert alert-danger');
              $('#success-alert').html('password And Confirm Password Did Not Match!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
            }else if(mobile.length != 10){
              $('#success-alert').addClass('alert alert-danger');
              $('#success-alert').html('Mobile Number Not Match!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
            }else{
            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>LoginController/apppasswordVerify/"+gender+'/'+mobile,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        if(response==4){
                            document.getElementById("myForm").submit();
                        }else if(response==2){
                          $('#success-alert').addClass('alert alert-danger');
                          $('#success-alert').html('Mobile Number Already exist!!');
                          $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
                        }
                       
                        
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }
        }

        document.getElementById('confirm_password').onkeyup=function(){
            var password = $("#password").val();
            var confirm_password = $("#confirm_password").val();
            if(password != confirm_password) {
                   $("#confirm_password").css('border-color', "red");
            }
                else{
                   $("#confirm_password").css('border-color', "green");
                }
        }
    window.ga = function () {
      ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('set', 'anonymizeIp', true);
    ga('set', 'transport', 'beacon');
    ga('send', 'pageview')
  </script>
  </body>
</html>