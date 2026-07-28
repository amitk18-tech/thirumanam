<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Vallikodi || Register</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="<?php echo base_url('assets/register/'); ?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="<?php echo base_url('assets/register/'); ?>css/style.css">
	</head>

	<body>
    <style type="text/css">
    .img-div{
       text-align:center;width:55%;
   }
   @media (max-width : 770px) {
        .inner{
            width:100% !important;
        }
        .img-div{
            text-align:center;width:100%;
        }
        .form-control{
            height:45px;
        }
   }
   

  /*@media (max-width : 320px) {*/
  /* ...*/
  /*}*/
  
</style>
    
		<div class="wrapper" style="background-image: url('<?php echo base_url('assets/register/'); ?>images/bg-registration-form-2.jpg');">
		    <!--<div style="top:0;right:0;z-index:99">0</div>-->
		    
			<div class="inner" >
			    <div class="img-div" style="">
			        <a href="<?php echo base_url('home'); ?>">
			            <img style="padding: 10px 25px;width: 200px;border-radius:14%;" src="<?php echo base_url('assets/register/images/logo.jpg'); ?>" class="" >    
			        </a>
			    </div>
			    
				<form action="<?php echo base_url('WelcomeController/registerUser'); ?>" method="post">
				    <input type="hidden" name="back_url" value="<?php echo (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : 'No Url Found'; ?>">
				    
					<h3 style="text-shadow:  0px 0px 10px #000;">Registration Form</h3>
					<div class="form-wrapper">
						<label for="">Profile for <span style="color:red;">*</span></label>
						<select class="form-control" name="profile_for" required>
						    
						    <?php if(count($profile_created_by_datas)==0)
                            {?>
                            <option value="">No Data Found</option>
                            <?php
                            }
                            else
                            {   echo'<option value="">Please Select Profile</option>';
                            foreach ($profile_created_by_datas as $value) 
                            { ?>
                            <option value="<?php echo $value->meta_value_id;?>"><?php echo $value->meta_value; ?></option>
                            <?php } } ?>
						</select>
					</div>
					<div class="form-wrapper">
						<label for="">Name <span style="color:red;">*</span></label>
						<input type="text" placeholder="Enter Name" name="name" required class="form-control">
					</div>
					<div class="form-wrapper">
						<label for="">Mobile Number <span style="color:red;">*</span></label>
						<input required type="text" placeholder="Enter Mobile Number" name="mobile" class="form-control">
					</div>
					<div class="form-wrapper">
						<label for="">Email</label>
						<input type="email" placeholder="Enter Email" name="email" class="form-control">
					</div>
					<!--<div class="checkbox">-->
					<!--	<label>-->
					<!--		<input type="checkbox"> I caccept the Terms of Use & Privacy Policy.-->
					<!--		<span class="checkmark"></span>-->
					<!--	</label>-->
					<!--</div>-->
					<button>Register Now</button>
				</form>
			</div>
		</div>
		
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>