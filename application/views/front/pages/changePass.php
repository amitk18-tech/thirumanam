<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demos.codexcoder.com/themeforest/html/ollya/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Dec 2022 12:21:18 GMT -->
<head>
    <meta charset="utf-8">
    <title>Thirumanam Matrimany</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- site favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url('uploads/favicon_1587796983.png'); ?>">
    <!-- Place favicon.ico in the root directory -->

    <!-- All stylesheet and icons css  -->
    <link rel="stylesheet" href="<?php echo base_url("assets/front");?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/front");?>/css/animate.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/front");?>/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/front");?>/css/swiper.min.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/front");?>/css/lightcase.css">
    <link rel="stylesheet" href="<?php echo base_url("assets/front");?>/css/style.css">

</head>
<div id="success-alert1" style="display: none;
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
<div id="success-alert" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Password Alredy Exist!!</strong>
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
    <center><strong>New Password or Confirm Password is empty!!</strong>
    </center>
    
  </div>
  <div id="success-alert4" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>password And Confirm Password Did Not Match!!</strong>
    </center>
    
  </div>
<?php echo $this->session->flashdata('login_msg');?>
<?php echo $this->session->flashdata('msg');?>
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
                        <a href="<?php echo base_url();?>" class="backto-home"><i class="fas fa-chevron-left"></i> <?php echo translate('go_back')?></a>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->session->flashdata('login_msg');?>
        <div class="container">
            <div class="row">
                <div class="image image-log"></div>
                <div class="col-lg-7">
                    <div class="log-reg-inner">
                        <div class="section-header inloginp">
                            <h2 class="title"> <?php echo translate('login_title')?></h2>
                        </div>
                        <div class="main-content inloginp">
                            <form class="contact-form" id="myForm" action="<?php echo base_url('LoginController/changeNewPassword/');?>" method="POST">
                                <div class="form-group w-100">
                                    <input type="hidden" id="phone" name="phone" value="<?php echo $phone;?>">
                                    <input type="hidden" id="gender" name="gender" value="<?php echo $gender;?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="<?php echo translate('new_password');?>" name="new_password" id="new_password" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" placeholder="<?php echo translate('confirm_password')?>" name="confirm_password" id="confirm_password" required>
                                </div>
                                
                                <div class="form-group w-100 text-center">
                                    <button class="default-btn reverse" type="button" onclick="return Validate()"><span><?php echo translate('submit')?></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================> login section end here <================== -->

    
    

    <!-- All Needed JS -->
    <script src="<?php echo base_url("assets/front");?>/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/isotope.pkgd.min.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/swiper.min.js"></script>
    <!-- <script src="<?php echo base_url("assets/front");?>/js/all.min.js"></script> -->
    <script src="<?php echo base_url("assets/front");?>/js/wow.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/counterup.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/jquery.countdown.min.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/lightcase.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/waypoints.min.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/plugins.js"></script>
    <script src="<?php echo base_url("assets/front");?>/js/main.js"></script>


    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
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

<!-- Mirrored from demos.codexcoder.com/themeforest/html/ollya/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Dec 2022 12:21:18 GMT -->
</html>

<script>
$(document).ready(function(){
setTimeout(function(){
        $('#flash').fadeOut();
      },3000);
})

    function Validate() {
            var password = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            // alert(month);
            if(!password.match(passw)){
                $('#success-alert1').show();
                          setTimeout(function(){
                            $('#success-alert1').hide();
                          },5000);
            }
            else if(password != confirmPassword){
                $('#success-alert4').show();
                          setTimeout(function(){
                            $('#success-alert4').hide();
                          },3000);
            }else if(password=="" || confirmPassword==""){
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