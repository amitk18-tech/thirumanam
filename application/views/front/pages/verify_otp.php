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
                                <a class="navbar-brand" href=""><img src="<?php echo base_url();?>uploads/header_logo/default_image.png" alt="logo"></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-5">
                        <a href="<?php echo base_url();?>" class="backto-home"><i class="fas fa-chevron-left"></i><?php echo translate('go_back');?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="image image-log"></div>
                <div class="col-lg-7">
                    <div class="log-reg-inner">
                        <div class="section-header inloginp">
                            <h3 class="title"><?php echo translate('login_title');?></h3>
                        </div>
                        <div class="main-content inloginp">
                            <form action="<?php echo base_url('LoginController/checkPhoneOtp')?>" method="post">
                                <div class="form-group">
                                    <label ><?php echo translate('otp')?></label>
                                    <input class="my-form-control" type="password" name="otp" min="4" max="4"   required>
                                </div>
                                    <input type="hidden" value="<?php echo $member_id;?>" name="member_id">
                                    <input type="hidden" value="<?php echo $remember_me;?>" name="remember_me">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="f-pass"> <a href="<?php echo base_url('LoginController/resendOtp/'.$member_id);?>"><?php echo translate('Resend');?></a></p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="default-btn"><span><?php echo translate('submit')?></span></button>
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