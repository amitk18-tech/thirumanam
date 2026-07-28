<?php

if($this->session->userdata('thirumanam_applogged_data')){

   redirect('app/home');
}


?>

<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<style>
.btn-primary {
    background-color: #ff3763 !important;
    border-radius: 7px !important;
    width: 80% !important;
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19) !important;

}



.register-form .form-control {
    background-color: #ffffff !important;
    border: 0 !important;
    border-radius: 7px !important;
    padding-left: 2rem !important;
    /*    box-shadow: 1px 1px 1px 1px rgba(16, 13, 209, 0.175)!important;*/
    font-size: 13px !important;
    border: 1px solid #ff3763 !important;
    color: black !important;
}

.lni-mobile,
.lni-user,
.lni-lock {
    padding-left: 5px;
    color: black !important;
    font-size: 16px !important;
    font-weight: bold !important;
}

::placeholder {
    /*   text-align: center; */
    padding-left: 5px;
    color: black !important;
    font-size: 14px !important;
    font-weight: bold;
}
</style>







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

.switch-field input:checked+label {
    background-color: #ff3763;
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

h3 {
    font-size: 15px !important;
}

p,
::placeholder {
    font-size: 12px !important;
}
</style>

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
.login-wrapper {

    /*      background-color: #31135b;*/

}

.login-text h3 {

    color: #fff;

}

.login-meta-data a {

    color: #fff;

}
</style>

<?php
 
 if ($this->session->userdata('language')) {
    $set_lang = $this->session->userdata('language');
 }else {
     $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
 }
 $lid = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->site_language_list_id;
 $lnm = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->name;
 // print_r($set_lang);exit;
 ?>

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
                    <div class="back-button"><a href="<?php echo "javascript:history.back()"; ?>"><i
                                class="lni lni-chevron-left text-dark"></i></a>
                    </div>
                </div>
                <div class="col-5 mt-1">
                    <div class="page-heading">
                        <h6 class="mb-0 text-white"><?php echo translate('login');?></h6>
                    </div>
                </div>
                <div class="col-6" style="text-align:left!important;width: 100%;">
                    <form class="form">
                        <div class="switch-field" style="text-align:left!important;">
                            <input type="radio" id="choice1" name="choice" value="English"
                                <?php if ($set_lang == "english") { echo "checked"; } ?>>
                            <label for="choice1">English</label>
                            <input type="radio" id="choice2" name="choice" value="தமிழ்"
                                <?php if ($set_lang == "tamil") { echo "checked"; } ?>>
                            <label for="choice2">தமிழ்</label>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Login Wrapper Area-->

    <div class="login-wrapper d-flex align-items-center justify-content-center">

        <!-- Shape-->

        <!-- <div class="login-shape"><img style="width: 150px;" src="<?php echo base_url('assets/app/')?>img/core-img/login.png" alt=""></div> -->

        <!-- <div class="login-shape2"><img style="height: 95px;" src="<?php echo base_url('assets/app/')?>img/core-img/login2.png" alt=""></div> -->
        <?php echo $this->session->flashdata('msg'); ?>
        <div class="container">

            <!-- Login Text-->

            <div class="login-text text-center">

                <img class="login-img" src="<?php echo base_url('uploads/header_logo/header_logo_1590988136.jpg')?>"
                    alt="">

                <!-- <img class="login-img" src="<?php #echo base_url('assets/app/')?>img/bg-img/12.png" alt=""> -->

                <h3 class="mb-0 text-dark mt-1" style="font-size: 18px;font-weight: bold;">
                    <?php echo translate('login_title');?></h3>

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
                <p class="text-dark"><?php echo translate('please_login_account');?></p>

            </div>

            <!-- Register Form-->

            <div class="register-form mt-3 px-3">



                <form action="<?php echo base_url('LoginController/app_do_login'); ?>" method="post">

                    <div class="form-group text-left mb-4">

                        <label for="phone"><i class="lni lni-mobile"></i></label>

                        <input class="form-control" id="mySelect" type="tel" autocomplete="off" name="phone"
                            placeholder=<?php echo translate('mobile');?> pattern="[6-9]{1}[0-9]{9}" required>

                    </div>
                    <div class="form-group text-left mb-4" id="output" style="display:none;">

                        <label for="gender"><i class="lni lni-user"></i></label>

                        <select name="gender" id="gender" class="form-control">
                            <option value=""><?=translate('choose_one')?></option>
                            <option value="1"><?=translate('Male')?></option>
                            <option value="2"><?=translate('Female')?></option>
                        </select>

                    </div>

                    <div class="form-group text-left mb-3">

                        <label for="password"><i class="lni lni-lock"></i></label>

                        <input class="form-control" id="password" autocomplete="off" type="password" name="password"
                            placeholder=<?php echo translate('password');?> required>

                    </div>
                    <!--  <div class="row ml-2">
              <div class="col-12">
                <input type="checkbox" class="mr-1" name="remember_me" value="checked">
              <label style="font-size: 11px;" ><?php echo translate('remember_me')?></label>
              </div>
            </div> -->
                    <div class="row">
                        <div class="col-12" style="text-align: end;">
                            <p class="f-pass" style="font-size:15px;margin-top: 7px;"> <a
                                    href="<?php echo base_url('app_forget_password');?>"
                                    style="color:#ff3763!important"><?php echo translate('recover_password');?></a></p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg"><?php echo translate('login');?></button>
                    </div>

                </form>

            </div>

            <!-- Login Meta-->

            <div class="login-meta-data text-center mt-3">

                <!-- <a class="forgot-password d-block mt-3 mb-1" href="#">Forgot Password?</a> -->

                <p class="mb-0" style="font-size: 15px;"><span
                        style="color:black"><?php echo translate('new_here?')?></span><a class="ml-2"
                        style="color:#ff3763"
                        href="<?php echo base_url('app/register') ?>"><?php echo translate('create_an_account_from_here!')?></a>
                </p>

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
    $("#mySelect").keyup(function() {
        var mobile = $("#mySelect").val();
        var base_url = $('#base_url').val();
        if (mobile.length == 10) {

            $.ajax({
                type: 'GET',
                url: base_url + 'AppController/getMobile',
                data: '&mobile=' + mobile,
                success: function(html) {
                    // alert(html);
                    console.log(html);
                    if (html == 1) {

                        $('#output').show();
                    } else {
                        $('#output').hide();
                    }

                }
            });

        }

    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#app_flash').fadeOut();
        }, 3000);
    });
    </script>
</body>
<script>
document.getElementById("choice2").onclick = function() {
    location.href = "<?=base_url()?>AppController/setLanguage/tamil";
};
document.getElementById("choice1").onclick = function() {
    location.href = "<?=base_url()?>AppController/setLanguage/english";
};
</script>

</html>