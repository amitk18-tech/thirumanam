<?php echo $this->session->flashdata('login_msg');?>
<?php echo $this->session->flashdata('msg');?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demos.codexcoder.com/themeforest/html/ollya/register.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Dec 2022 12:21:18 GMT -->
<head>
	<meta charset="utf-8">
	<title>Thirumanam Matrimany</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- site favicon -->
	<link rel="icon" type="image/png" href="<?php echo base_url('uploads/favicon_1587796983.png'); ?>">
	<!-- Place favicon.ico in the root directory -->

	<!-- All stylesheet and icons css  -->
	<link rel="stylesheet" href="<?php echo base_url('assets/front');?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/front');?>/css/animate.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/front');?>/css/all.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/front');?>/css/swiper.min.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/front');?>/css/lightcase.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/front');?>/css/style.css">
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<div id="success-alert8" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 60%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter!!</strong>
    </center>
    
  </div>
<div id="success-alert6" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Mobile Number Not Match!!</strong>
    </center>
    
  </div>
  <div id="success-alert7" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>You must be at least 18 years of age!!</strong>
    </center>
    
  </div>
<div id="success-alert1" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Password Already exist!!</strong>
    </center>
    
  </div>
  <div id="success-alert2" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Mobile Number Already exist!!</strong>
    </center>
    
  </div>
  <div id="success-alert5" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>reqired field!!</strong>
    </center>
    
  </div>
  <div id="success-alert3" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Password,Mobile Number Already exist!!</strong>
    </center>
    
  </div>
  <div id="success-alert4" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 65px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>password And Confirm Password Did Not Match!!</strong>
    </center>
    
  </div>

<body>
	<!-- preloader start here -->
    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
	<!-- preloader ending here -->

	<!-- scrollToTop start here -->
    <a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
    <!-- scrollToTop ending here -->


    <!-- ================> login section start here <================== -->
    <section class="log-reg">
        <div class="top-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-7">
                        <div class="logo">
                            <?php
                                $header_logo_info = $this->db->get_where('frontend_settings', array('type' => 'header_logo'))->row()->value;
                                $header_logo = json_decode($header_logo_info, true);
                                if (file_exists('uploads/header_logo/'.$header_logo[0]['image'])) {
                                ?>
                                <a class="navbar-brand" href="index.html"><img src="<?php echo base_url()?>uploads/header_logo/<?=$header_logo[0]['image'];?>" alt="logo"></a>
                            <?php } else{?>
                                <a class="navbar-brand" href="index.html"><img src="<?php echo base_url();?>uploads/header_logo/default_image.png" alt="logo"></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-5">
                        <a href="<?php echo base_url();?>" class="backto-home"><i class="fas fa-chevron-left"></i><?=translate('home')?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="image">
                </div>
                <div class="col-lg-7">
                    <div class="log-reg-inner">
                        <div class="section-header">
                            <h2 class="title"><?=translate('create_your_account')?></h2>
                            <!-- <p><?=translate('registrationNote')?></p> -->
                        </div>
                        <div class="main-content">
                            <form id="myForm" action="<?php echo base_url('LoginController/saveRegister')?>" method="POST">
                                <h4 class="content-title"><?=translate('registrationNote')?></h4>
                                <div class="form-group">
                                    <label><?php echo translate('Name')?></label>
                                    <input type="text" name="first_name" id="first_name" class="my-form-control" placeholder="Enter Your Name" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo translate('gender')?></label>
                                            <select name="gender" id="gender" class="my-form-control" required>
                                                <option value=""><?=translate('choose_one')?></option>
                                                <option value="1"><?=translate('Male')?></option>
                                                <option value="2"><?=translate('Female')?></option>
                                            </select>
                                </div>
                                <div class="form-group">
                                    <label><?php echo translate('email')?></label>
                                    <input type="email" name="email" id="email" class="my-form-control" placeholder="Enter Your Email" required>
                                </div>
                                <?php $member_approval = $this->db->get_where('general_settings', array('type' => 'member_approval_by_admin'))->row()->value;
                                        if($member_approval == 'yes'){ ?>
                                            <input name="approval_status" value="pending" hidden="">
                                        <?php } else { ?>
                                            <input name="approval_status" value="approved" hidden="">
                                    <?php } ?>
                                <div class="form-group">
                                    <label><?php echo translate('date_of_birth')?></label>
                                    <input type="date" onchange="setday(this.value)" name="date_of_birth" id="date_of_birth" class="my-form-control" required>
                                    <input type= "hidden" value="" id="birthDay" name="birthDay" >
                                </div>
                                <div class="form-group">
                                    <label><?php echo translate('mobile')?></label>
                                    <input type="text" name="mobile" id="mobile" class="my-form-control" placeholder="Enter Your mobile number" pattern="[6-9]{1}[0-9]{9}">
                                </div>
                                <!-- <h4 class="content-title mt-5">Profile Details</h4> -->
                                <div class="form-group">
                                    <label><?php echo translate('father')?></label>
                                    <input type="text" name="father" id="father" class="my-form-control" placeholder="Enter Your Father Name" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo translate('mother')?></label>
                                    <input type="text" name="mother" id="mother" class="my-form-control" placeholder="Enter Your Mother Name" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo translate('password')?></label>
                                    <input type="password" name="password" id="password" class="my-form-control" placeholder="Enter password" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo translate('confirm_password')?></label>
                                    <input type="password" name="confirm_password" id="confirm_password" class="my-form-control" placeholder="re enter password" required>
                                </div>
                                <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Ldj7ygrAAAAAEFs8A2RjAbjW3HG2M6nqpF2UduJ"></div>
                                </div>
                                <button class="default-btn reverse" type="button" onclick="return Validate()"><span><?php echo translate('register')?></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================> login section end here <================== -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	

	<!-- All Needed JS -->
	<script src="<?php echo base_url('assets/front');?>/js/vendor/jquery-3.6.0.min.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/vendor/modernizr-3.11.2.min.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/isotope.pkgd.min.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/swiper.min.js"></script>
	<!-- <script src="<?php echo base_url('assets/front');?>/js/all.min.js"></script> -->
	<script src="<?php echo base_url('assets/front');?>/js/wow.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/counterup.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/jquery.countdown.min.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/lightcase.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/waypoints.min.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/vendor/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/plugins.js"></script>
	<script src="<?php echo base_url('assets/front');?>/js/main.js"></script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>

	<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->]
	<script>
// var onloadCallback = function() {
//     alert("grecaptcha is ready!");
//   };

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
            
            $('#success-alert5').show();
                  setTimeout(function(){
                        $('#success-alert5').hide();
                      },3000);
            }
            else if(!password.match(passw)){
                $('#success-alert8').show();
                          setTimeout(function(){
                            $('#success-alert8').hide();
                          },5000);
            }
            else if(currdate < mydate){
                $('#success-alert7').show();
                          setTimeout(function(){
                            $('#success-alert7').hide();
                          },3000);
            }
            else if(password != confirmPassword){
                $('#success-alert4').show();
                          setTimeout(function(){
                            $('#success-alert4').hide();
                          },3000);
            }else if(mobile.length != 10){
                $('#success-alert6').show();
                          setTimeout(function(){
                            $('#success-alert6').hide();
                          },3000);
            }else{
            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>LoginController/passwordVerify/"+gender+'/'+mobile,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        if(response==4){
                            document.getElementById("myForm").submit();
                        }else if(response==2){
                             $('#success-alert2').show();
                          setTimeout(function(){
                            $('#success-alert2').hide();
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
	<script src="../../../../www.google-analytics.com/analytics.js" async></script>

</body>


</html>