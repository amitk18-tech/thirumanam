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
 <style>
.switch-field {
  display: flex;
  overflow: hidden;
}

.switch-field input {
  position: absolute !important;
  clip: rect(0, 0, 0, 0);
  height: 1px;
  width: 1px;
  border: 0;
  overflow: hidden;
}

.switch-field label {
  background-color: #e4e4e4;
  color: black;
  font-size: 14px;
  line-height: 1;
  text-align: center;
  padding: 8px 16px;
  margin-right: -1px;
  border: 1px solid rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
  transition: all 0.1s ease-in-out;
}

.switch-field label:hover {
  cursor: pointer;
}

.switch-field input:checked + label {
  background-color: #ff0461;
  box-shadow: none;
  color: white;
}

.switch-field label:first-of-type {
  border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
  border-radius: 0 4px 4px 0;
}

/* This is just for CodePen. */




</style>
<?php echo $this->session->flashdata('login_msg');?>
<?php echo $this->session->flashdata('msg');?>
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
                                <a class="navbar-brand" href=""><img src="<?php echo base_url()?>uploads/header_logo/<?=$header_logo[0]['image'];?>" alt="logo"></a>
                            <?php } else{?>
                                <a class="navbar-brand" href="index.html"><img src="<?php echo base_url();?>uploads/header_logo/default_image.png" alt="logo"></a>
                            <?php } ?>
                        </div>
                        <form class="form">
                          <div class="switch-field">
                            <input type="radio" id="choice1" name="choice" value="English" <?php if ($set_lang == "english") { echo "checked"; } ?>>
                            <label for="choice1">English</label>
                            <input type="radio" id="choice2" name="choice" value="தமிழ்" <?php if ($set_lang == "tamil") { echo "checked"; } ?>>
                            <label for="choice2">தமிழ்</label>
                          </div>
                        </form>
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
                            <h3 class="title"><?php echo translate('login_title');?></h3>
                        </div>
                        <div class="main-content inloginp">
                            <form action="<?php echo base_url('LoginController/do_login')?>" method="post">
                                <div class="form-group">
                                    <label ><?php echo translate('phone');?></label>
                                    <input  name="phone" type="tel" class="my-form-control" autofocus pattern="[6-9]{1}[0-9]{9}" id="mySelect">
                                </div>
                                <div class="form-group"  id="output" style="display:none;">
                                    <label><?php echo translate('gender')?></label>
                                        <select name="gender" id="gender" class="my-form-control">
                                            <option value=""><?=translate('choose_one')?></option>
                                            <option value="1"><?=translate('Male')?></option>
                                            <option value="2"><?=translate('Female')?></option>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label ><?php echo translate('password');?></label>
                                    <input name="password" type="password" class="my-form-control"required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-5">
                                        <div class="row">
                                            <div class="col-md-2 col-2" style="padding: 0px;">
                                                <input type="checkbox" name="remember_me" value="checked">
                                            </div>
                                            <div class="col-md-10 col-10" style="padding: 0px;">
                                                 <label ><?php echo translate('remember_me')?></label>
                                                
                                            </div>
                                            </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="f-pass"> <a href="<?php echo base_url('forget_password');?>"><?php echo translate('recover_password');?></a></p>
                                    </div>
                                </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="default-btn"><span><?=translate('sign_in')?></span></button>
                                </div>
                                <div class="text-center mt-3">
                                <?php echo translate('new_here?')?><a href="<?php echo base_url('register');?>"><?php echo translate('create_an_account_from_here!')?></a>
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
        
        $("#mySelect").keyup(function(){
         var mobile =  $("#mySelect").val();
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


        document.getElementById("choice2").onclick = function () {
        location.href = "<?=base_url()?>AppController/setLanguage/tamil";
        };
        document.getElementById("choice1").onclick = function () {
            location.href = "<?=base_url()?>AppController/setLanguage/english";
        };
    
        $(document).ready(function(){
  setTimeout(function(){
            $('#flash').fadeOut();
          },3000);
    })
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
