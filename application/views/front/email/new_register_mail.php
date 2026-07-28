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
  		<img src="<?php echo base_url(); ?>assets/img/logo1.png" class="sitelogo">
  		<!--<img src="http://iclientprojects.com/Twohearts/assets/images/logo.png" class="sitelogo">-->
  	</div>
  	<div class="date" style="float: right; margin: 27px 15px 0 0;"><b><?php echo date('d-M-Y'); ?></b></div>
  </div><!-- mail header div -->

  <div class="mail_body" style="float: left;width: 100%;margin: 6px 0 0;min-height: 200px;">
  	<h4>Hello Admin, Newly registered user information</h4>
    <p>Name : <?php echo $user['name']; ?></p>
    <p>Mobile : <?php echo $user['mobile']; ?></p>
    <p>Email : <?php echo $user['email']; ?></p>
    <p>Profile for : <?php echo $user['profile_for']; ?></p>  	
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
