<div class="login_form_inner zoom-anim-dialog mfp-hide" id="small-dialog">
   <h4>User Login</h4>
   <form method="post" action="<?php echo base_url('LoginController/do_login'); ?>" name="userlogin" id="userlogin" class="user_login">
      <p class='val_error val_status'></p>
      <p class="admin_status"> </p>
      <input type="text" placeholder="email or phone" name="user_data" data-message="Email" class="form_inputs email_value">
      <input type="password" placeholder="Password" name="password" data-message="password" name="password" class="form_inputs">
      <div class="login_btn_area">
         <button type="submit" value="LogIn" class="btn form-control login_btn" name="user-submit" id="user_submit">LogIn</button>
         <div class="login_social">            
            <!-- <a href="registration">No Account?</a><br> -->
            <a class="popup-with-zoom-anim" href="#forgot_form" style="color: #337ab7;">Forgot Password?</a>               
         </div>
      </div>
       <input type="hidden" name="" />       
   </form>
   <!-- <img class="mfp-close" src="assets/img/close-btn.png" alt=""> -->
</div>

<div class="login_form_inner zoom-anim-dialog mfp-hide" id="forgot_form">
   <h4>Forgot Password</h4>
   <form method="POST" action="<?php echo base_url('ProfileController/forgotpassword'); ?>" name="user_forgot" id="user_forgot" class="forgot_forms">
      <p class='val_error val_status'></p>
      <div class="box">
         <input type="text" placeholder="email" name="email_id" name="email_id" data-message="Email" class="form_inputs email_value">
      </div>   
      <div class="login_btn_area">
         <button type="submit" value="LogIn" class="btn form-control login_btn" name="user-submit" id="user_send">Send</button>
      </div>
   </form>
   <!-- <img class="mfp-close" src="assets/img/close-btn.png" alt=""> -->
</div>       

<div class="register_form_inner zoom-anim-dialog mfp-hide" id="register_form">
   <div class="row">
      <div class="col-md-6"></div>
      <div class="col-md-6">
         <div class="registration_form_s">
            <h4>Registration</h4>
             <form method="post" action="index" name="register_login" id="register_login">
             <input type="hidden">
                 <div class="form-group">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span data-bind="label">Registered By</span>&nbsp;<span class="arrow_carrot-down"><i class="fa fa-sort-asc" aria-hidden="true"></i><i class="fa fa-sort-desc" aria-hidden="true"></i></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Self</a></li>
                            <li><a href="#">Friend</a></li>
                            <li><a href="#">Brother</a></li>
                            <li><a href="#">Sister</a></li>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="reg_Name" placeholder="Name">
                </div>
                    <!--
                <div class="form-group">
                    <input type="password" class="form-control" id="reg_con_pass2" placeholder=" Confirm Password">
                </div>-->
                <div class="form-group">
                    <input type="text" class="form-control" id="reg_Religion" placeholder="Religion">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="reg_Mobile" placeholder="Mobile">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="reg_email" placeholder="Email">
                </div>                                   
                <div class="form-group">
                    <input type="password" class="form-control" id="reg_pass" placeholder="Password">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <span data-bind="label">Gender</span>&nbsp;<span class="arrow_carrot-down"><i class="fa fa-sort-asc" aria-hidden="true"></i><i class="fa fa-sort-desc" aria-hidden="true"></i></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Male</a></li>
                                    <li><a href="#">Female</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="datepicker">
                                <input type='text' class="form-control datetimepicker4" placeholder="Birthday" />
                                <span class="add-on"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reg_chose form-group">
                    <div class="reg_check_box">
                        <input type="radio" id="s-option" name="selector">
                        <label for="s-option">I`m Not Robot</label>
                        <div class="check"><div class="inside"></div></div>
                    </div>
                    <button type="submit" value="LogIn" class="btn form-control login_btn">Register</button>
                </div>
            </form>
            <!-- <img class="mfp-close" src="assets/img/close-btn.png" alt=""> -->
         </div>
      </div>
   </div>
</div>


<div style="position: fixed;background-color: transparent;width: 100%;height: 100%;z-index: 99999;text-align: center;top: 30%;display: none;" id="loading">
  <img src="<?php echo base_url().'assets/img/loading.gif'; ?>" style="width: 100px;height: auto;">
</div>

<div style="position: fixed;background-color: transparent;width: 100%;height: 100%;z-index: 99999;text-align: center;top: 30%;" id="loading1">
  <img src="<?php echo base_url().'assets/img/loading.gif'; ?>" style="width: 100px;height: auto;">
</div>