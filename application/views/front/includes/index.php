<!DOCTYPE html>
<html>
	<!-- header scripts -->
	<?php if($header_scripts){echo $header_scripts;} ?>
    <body>
	<!-- header area -->
	<!-- <?php #if($header){echo $header;} ?> -->

	<!-- navigations -->
	<?php if($top_navigation){echo $top_navigation;} ?>

	<!-- middle area  -->
	<?php if($middle){echo $middle;} ?>

	<!-- footer area -->
	<?php if(isset($footer)){echo $footer;} ?>

	<!-- footer scripts  -->
	<?php if($footer_scripts){echo $footer_scripts;} ?>
	</body>
</html>