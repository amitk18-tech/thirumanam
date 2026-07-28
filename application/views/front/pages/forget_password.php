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
<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<div id="success-alert11" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 90%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?=translate('phone_number_not_register')?>!!</strong>
    </center>
    
  </div>
  <div id="success-alert13" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 90%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>required!!</strong>
    </center>
    
  </div>
  <div id="success-alert12" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 90%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?=translate('otpMsg')?>!!</strong>
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
                        <a href="<?php echo base_url();?>" class="backto-home"><i class="fas fa-chevron-left"></i><?php echo translate('go_back')?></a>
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
                            <h3 class="title"><?php echo translate('login_title');?></h3>
                        </div>
                        <div class="main-content inloginp">
                            
                                <div class="form-group">
                                    <label><?php echo translate('phone');?></label>
                                    <input  name="phone" id="phone" type="tel" class="my-form-control" pattern="[6-9]{1}[0-9]{9}" required>
                                </div>
                                <div class="form-group"  id="output" style="display:none;">
                                    <label><?php echo translate('gender')?></label>
                                        <select name="gender" id="gender" class="my-form-control" required>
                                            <option value=""><?=translate('choose_one')?></option>
                                            <option value="1"><?=translate('Male')?></option>
                                            <option value="2"><?=translate('Female')?></option>
                                        </select>
                                </div>
                                <div class="form-group" id="otp" style="display:none">
                                    <label><?php echo translate('otp')?></label>
                                    <input type="tel" class="my-form-control" name="phoneOtp"
                                    id= 'phoneOtp' autofocus required>
                                    
                                </div>
                                <div class="text-center">
                                    <button type="button" onclick="checkPhoneNumber()"
                                    id="checkPhone" class="default-btn"><span><?php echo translate('submit')?></span></button>
                                    <button type="button" style='display:none' onclick="checkPhoneOtp()"
                                    id="submitOtp" class="default-btn"><span><?php echo translate('submit')?></span></button>
                                </div>
                        </div>
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
         $("#phone").keyup(function(){
         var mobile =  $("#phone").val();
         var base_url=$('#base_url').val();
         if(mobile.length == 10){
                $.ajax({
                  type: 'GET',
                  url: base_url+'WelcomeController/getMobile',
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
});

function checkPhoneNumber()
    {   
        var phone = $("#phone").val();
        var gender = $("#gender").val();
        if(phone!= ''){
        var otp = '';
        URL = "<?=base_url('LoginController/checkPhone')?>";
        $.ajax({
            url: URL,
            data: {'phone': phone,'gender': gender}, // change this to send js object
            type: "post",
            success: function(data){
             console.log(data);
               if(data == 3)
               {
                // window.location.href = "<?=base_url('home/login/verifyOtp')?>";
                $("#otp").show();
                $("#phone").attr('disabled','disabled');
                $("#gender").attr('disabled','disabled');
                $("#checkPhone").hide();
                $("#submitOtp").show();
               }
              else{
                    $("#success-alert11").show();
                    setTimeout(function(){
                    $('#success-alert11').hide();
                    },3000); 
              }
            }
        });


        return false;


        }
        else{
            $("#success-alert13").show();
            setTimeout(function(){
            $('#success-alert13').hide();
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
                    
                        URL = "<?=base_url('LoginController/checkPhone')?>";
                    $.ajax({
                        url: URL,
                        data: {'phone': phone,"otp":otp,'gender': gender}, // change this to send js object
                        type: "post",
                        success: function(data){
                            console.log(data);
                           if(data == 1)
                           {
                            window.location.href = "<?=base_url('LoginController/forgotChangePassword/')?>"+phone+'/'+gender;
                            // $("#otp").show();
                            // $("#phone").attr('disabled','disabled');
                            // $("#checkPhone").hide();
                            // $("#submitOtp").show();
                           }
                          else{
                            $("#success-alert12").show();
                            setTimeout(function(){
                            $('#success-alert12').hide();
                            },3000);
                               
                          }
                        }
                    });


return false;


                    }
                    else{
                        $("#success-alert12").show();
                        setTimeout(function(){
                        $('#success-alert12').hide();
                        },3000);
                    }
                }
</script>