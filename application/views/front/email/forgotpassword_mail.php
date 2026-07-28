<!DOCTYPE html>
<html>
<head>
	<title>Vallikodi Matrimony</title>
</head>
<body style="margin: 0 auto;width: 80%;">

<div class="mail" style="margin: 20px 0px 18px; width: 100%; float: left; border: 1px solid #CBCBCB; padding: 10px 20px;">
<div class="mail_cover" style="">
 
 <div class="main_cover" style="margin: 0 auto;width: 100%;">

  <div class="mail_header" style="float: left;width: 100%; background-color: #5c7500;">
  	<div class="logo_image" style="float: left;padding: 5px 0px 0px 5px;">
    <img src="<?php echo base_url(); ?>assets/img/logo1.png" class="sitelogo">      
  	</div>
  	<div class="date" style="float: right; margin: 27px 15px 0 0;color:#fff;"><b><?php echo date('d-M-Y'); ?></b></div>
  </div><!-- mail header div -->

  
  <div class="mail_body" style="float: left;width: 100%;margin: 6px 0 0;min-height: 200px;">
  	<h4>Hello <?php echo $user_datas['username']; ?>,</h4>
  	<h5>Forgot Your Password?</h5>
	<!-- <p>Please click this link to change password your account:
 	<a href="<?php #echo base_url('newpassword');?><?php #echo '?u_id='.base64_encode($user_datas['user_id']); ?>">Click Here</a></p> -->

    <p >Kindly Use This Temporary Password: <span style="background-color: yellow"><?php echo $random_password; ?></span></p>
    
    <p style="font-size: 12px;">Note : <span style="color: red;">please change temporary password after logged in</span></p>

  </div><!-- mail body div -->


  <div class="mail_footer" style="float: left;width: 100%;border-top: 1px solid #cbcbcb; background-color: #5c7500; background-color: #5c7500;">
  	<h5 style="color: #fff;"><center> Team - Vallikodi Matrimony </center></h5>
    <p><center style="color:#fff;">Copyright &#169; <?php echo date('Y'); ?>. Vallikodi Matrimony</center></p>
  </div><!-- mail footer div -->

  </div><!-- main_cover div closed --> 

</div><!-- mail_cover div closed -->
</div>

</body>
</html>
 