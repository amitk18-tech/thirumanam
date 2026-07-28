
    <!-- ================> Page Header section start here <================== -->
   <div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2><?php echo translate('premium_plans ')?></h2>
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo translate('premium_plans')?></li>
                </ol>
            </nav> -->
        </div>
    </div>
</div>
    <!-- ================> Page Header section end here <================== -->

<?php 
if($this->session->userdata('thirumanam_logged_data')){
    $userId = $this->session->userdata('thirumanam_logged_data')['member_id'];
}
?>


    <!-- ================> Membership start here <================== -->
    <div class="membership padding-top padding-bottom">
        <div class="container">
            <div class="section__header style-2 text-center">
				<h3><?php echo translate('premium_plans')?></h3>
				<!-- <p>Our dating platform is like a breath of fresh air. Clean and trendy design with ready to use features we are sure you will love.</p> -->
			</div>
            <div class="section__wrapper">
				<div class="row g-4 justify-content-center row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-1">
                    <?php foreach ($all_plans as $value){ ?>
					<div class="col">
                        <?php if ($value->plan_id == 1) { $package_class = "text-line-through"; } else { $package_class = "active"; } ?>
						<div class="membership__item">
                            <div class="membership__inner">
                                <div class="membership__head">
                                    <!-- <h4>7 Day Free Trial</h4> -->
                                    <?php
                                    $image = $value->image;
                                    $images = json_decode($image, true);
                                    // print_r($images[0]['image']);exit;
                                    if(!empty($images[0]['image'])){
                                    if (file_exists('uploads/plan_image/'.$images[0]['image'])) {
                                    ?>
                                        <p><img style="width:40%" src="<?=base_url()?>uploads/plan_image/<?=$images[0]['image']?>" class="img-sm"></p>
                                    <?php
                                    }
                                    else {
                                    ?>
                                       <p><img style="width:40%" src="<?=base_url()?>uploads/plan_image/default_image.png" class="img-sm"></p>
                                    <?php
                                    } }
                                ?>
                                    <!-- <p>$15.00 Now And Then $30.00 Per Month.</p> -->
                                </div>
                                <div class="membership__body">
                                    <h4><?=$value->name?></h4>
                                    <h3 class="mt-2"><?=currency($value->amount)?></h3>
                                    <ul>
                                        <li class="<?=$package_class?>"></i> <span><?=translate('express_interests:')?> <?=$value->express_interest?> <?=translate('times')?></span></li>
                                        <li class="<?=$package_class?>"></i> <span><?=translate('direct_messages:')?> <?=$value->direct_messages?> <?=translate('times')?></span></li>
                                        <li class="<?=$package_class?>"></i> <span><?=translate('photo_gallery:')?> <?=$value->photo_gallery?> </span></li>
                                        <li class="<?=$package_class?>"><span><?=translate('Profile_download_text')?> : 100 </span></li>
                                    </ul>
                                    
                                </div>
                                <div class="membership__footer">
                                    <?php
                                    if ($value->plan_id != 1) {
                                        $purchase_link = base_url()."Subscribe/".$value->plan_id;
                                    }
                                    else {
                                        $purchase_link = "#";
                                    }
                                    ?>
                                    <?php if($this->session->userdata('thirumanam_logged_data')){?>
                                    <!-- <a href="<?php echo $purchase_link;?>" class="default-btn reverse"><span>Select Plan</span></a> -->
                                    <a type="button" onclick="planDetails(<?php echo $value->plan_id;?>)" class="default-btn reverse"><span><?php echo translate('get_this_package')?></span></a>
                                    <!-- <a href="<?=base_url()?>WelcomeController/submitPayment/<?=$userId?>/<?=$value->amount;?>/<?=$value->plan_id?>" class="default-btn reverse"><span><?php echo translate('get_this_package')?></span></a> -->
                                <?php } else{?>
                                    <a href="<?php echo base_url('login');?>" class="default-btn reverse"><span><?php echo translate('get_this_package');?></span></a>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
					</div>
                <?php } ?>
				</div>
			</div>
        </div>
    </div>
    <!-- ================> Membership end here <================== -->
<div id="edit_output"></div>
<script>
        
function planDetails(m_id) 
{
    
  var base_url=$('#base_url').val();
  // alert(base_url);
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/planDetails',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}


    </script>