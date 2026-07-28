<!DOCTYPE html>
<html>
<head>
	<title>Vallikodi Matrimony</title>
</head>
<body style="margin: 0 auto;width: 80%;">

<div class="mail" style="margin: 20px 0px 18px; width: 100%; float: left; border: 1px solid #CBCBCB; padding: 10px 20px;">
<div class="mail_cover" style="">
 
 <div class="main_cover" style="margin: 0 auto;width: 100%;">

  <div class="mail_header" style="float: left;width: 100%; background-color: #e3e3e3;">
  	<div class="logo_image" style="float: left;">
  		<img src="<?php echo base_url(); ?>assets/images/logo.png" class="sitelogo">
  		<!--<img src="http://iclientprojects.com/Twohearts/assets/images/logo.png" class="sitelogo">-->
  	</div>
  	<div class="date" style="float: right; margin: 27px 15px 0 0;"><b><?php echo date('d-M-Y'); ?></b></div>
  </div><!-- mail header div -->

  <div class="mail_body" style="float: left;width: 100%;margin: 6px 0 0;min-height: 200px;">
  	<h4>Hello Admin,</h4>
    <p>Profile ID : <?php echo $user_datas['profile_id']; ?></p>
  	<p><?php echo $user_datas['username']; ?> Profile Verification Request Has been Sent.</p>
  </div><!-- mail body div -->

  <div class="mail_footer" style="float: left;width: 100%;border-top: 1px solid #cbcbcb; background-color: #e3e3e3; background-color: #e3e3e3;">
  	<h5><center> Team - Vallikodi Matrimony </center></h5>
    <p><center>Copyright &#169; <?php echo date('Y'); ?>. Vallikodi Matrimony</center></p>
  </div><!-- mail footer div -->

  </div><!-- main_cover div closed --> 

</div><!-- mail_cover div closed -->
</div>

</body>
</html>
