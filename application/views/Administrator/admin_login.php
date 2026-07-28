
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>

    <meta charset="utf-8" />
    <title><?php echo getSettings()->site_title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('uploads'); ?>/favicon_1587796983.png">

    <!-- Layout config Js -->
    <script src="<?php echo base_url('assets/admin/'); ?>js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('assets/admin/'); ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('assets/admin/'); ?>css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('assets/admin/'); ?>css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?php echo base_url('assets/admin/'); ?>css/custom.min.css" rel="stylesheet" type="text/css" />


</head>
<?php echo $this->session->flashdata('msg');?>

<body>
    <?php 
    $data=getData('general_settings','row',array('type'=>'admin_login_image'));
    $images = json_decode($data->value);
    foreach($images as $image){

    }
    $img = base_url('uploads/admin_login_image/'.$image->image);

    // print_r($img);exit;
    ?>
    <div class="auth-page-wrapper pt-5"  style="background-image: url(<?php echo $img;?>);background-position: center;background-size: cover;background-repeat: no-repeat;" >
        <!-- auth page bg 
        <div class="auth-one-bg-position" id="auth-particles">
            <div></div>

            
        </div>-->

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-3 mb-2 text-white-50">
                            <div>
                                <!--<h1 class="text-white"><?php echo getSettings()->site_title; ?></h1>-->
                                <!-- <a href="<?php #echo base_url('admin'); ?>" class="d-inline-block auth-logo">
                                    <img src="<?php #echo base_url('uploads/logo/'.getSettings()->logo); ?>" alt="" height="20">
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-3" style="border-radius:20px;">
                            <form action="<?php echo base_url('LoginController/isValidAdmin'); ?>" method="post">
                                <div class="card-body p-4">
                                    <div class="text-center mt-2">
                                        <h1 class="text-primary"><?php echo getSettings()->site_title; ?></h1>
                                        <p class="text-muted">Sign in to continue.</p>
                                        <?php echo $this->session->flashdata('login_msg'); ?>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username / Email / Mobile</label>
                                            <input type="text" class="form-control" id="username" name="username" autofocus="" placeholder="Enter Username / Email / Mobile" required>
                                        </div>

                                        <div class="mb-3">
                                            <!-- <div class="float-end">
                                                <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                                            </div> -->
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5" name="password" placeholder="Enter password" id="password-input" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                        </div> -->

                                        <div class="mt-4">
                                            <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                        </div>
                                       <!-- <div class="mt-4 text-center">
                                        <a href="<?php echo base_url('AdminController/adminForgetPassword'); ?>">Forget Password</a>
                                        </div>-->
                                         <div class="text-center mt-4">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> <?php echo strtoupper(getSettings()->site_title); ?>.<br> Crafted with <i class="mdi mdi-heart text-danger"></i> by <a target="_blank" href="http://iclient.tech/">iCLIENTTECH</a>
                            </p>
                        </div>
                                        <!-- <div class="mt-4 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                            <div class="mt-4 text-center">
                                                <p class="mb-0">Don't have an account ? <a href="<?php echo base_url('staff/login'); ?>" class="fw-semibold text-primary text-decoration-underline"> Staff/Login </a> </p>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- end card body -->
                            </form>
                        </div>
                        <!-- end card -->

                        <!-- <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account ? <a href="auth-signup-basic.html" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
                        </div> -->

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                       
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('assets/admin/'); ?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('assets/admin/'); ?>libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url('assets/admin/'); ?>libs/node-waves/waves.min.js"></script>
    <script src="<?php echo base_url('assets/admin/'); ?>libs/feather-icons/feather.min.js"></script>
    <script src="<?php echo base_url('assets/admin/'); ?>js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="<?php echo base_url('assets/admin/'); ?>js/plugins.js"></script>

    <!-- particles js -->
    <script src="<?php echo base_url('assets/admin/'); ?>libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="<?php echo base_url('assets/admin/'); ?>js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="<?php echo base_url('assets/admin/'); ?>js/pages/password-addon.init.js"></script>
</body>

</html>