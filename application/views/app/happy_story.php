<style>
  
 tbody{
  color: white;
 }
 thead{
  color: white;
 }
</style>

<?php

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

$member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
$getUser = getData('member','row',array('member_id'=>$member_id));
    $profile_images = get_type_name_by_id('member', $getUser->member_id, 'profile_image');
   $profile_image = json_decode($profile_images, true);
?>

<div class="page-content-wrapper">

   <!-- Profile Content Wrapper-->

   <div class="profile-content-wrapper">

      <!-- Settings Option-->

      <!-- <div class="profile-settings-option"><a href="#"><i class="lni lni-cog"></i></a></div> -->

      <div class="container">



         <div class="user-meta-data d-flex align-items-center">

            <div class="">

               <a href="<?php echo base_url('app/my_profile/images'); ?>">

                   <?php if($getUser->gender==1){?>
                     <img src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>" alt="member-img" id="pimage_preview">
                   <?php } ?>
                   <?php if($getUser->gender==2){?>

                     <img src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>" alt="member-img" id="pimage_preview">
                   <?php } ?>

                  <button type="button" class="btn btn-sm btn-block btn-primary ">Edit Image</button>

               </a>

            </div>

            <div class="user-content">
              <h6><?php echo $getUser->first_name?></h6>

               <p></p>


               <div class="user-meta-data d-flex align-items-center justify-content-between">

                  <p class="mx-1"><span class="counter"><?php echo $getUser->remain_download?></span><span style="font-size: 9px;"><?php echo translate('package_informations')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->express_interest?></span><span style="font-size: 9px;"><?php echo translate('remaining_interest')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->direct_messages?></span><span style="font-size: 9px;"><?php echo translate('remaining_message')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->photo_gallery?></span><span style="font-size: 9px;"><?php echo translate('photo_gallery')?></span></p>

               </div>

            </div>

         </div>

      </div>

   </div>
      <div class="all-pages-wrapper">
        <div class="container">
          <ul class="page-nav">
            <li><a href="<?php echo base_url('app/profile');?>"><?php echo  translate('profile');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/my_interests');?>"><?php echo  translate('my_interests');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/shortlist');?>"><?php echo  translate('shortlist');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/followed_users');?>"><?php echo  translate('followed_users');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/messaging');?>"><?php echo  translate('messaging');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/ignored_list');?>"><?php echo  translate('ignored_list');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/profile_viewed_details');?>"><?php echo  translate('Viewed');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/profile_viewer_details');?>"><?php echo  translate('Viewers');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/gallery');?>"><?php echo  translate('gallery');?><i class="lni lni-chevron-right"></i></a></li>
            <li>
            <?php if($getUser->membership == 1 || $getUser->updateProfileDoneStatus == 0){ ?>
               
               <a style="background-color:#e42f08;color: white;" href="<?php echo base_url('LoginController/appverifyMember');?>"><?php echo  translate('happy_story');?><i class="lni lni-chevron-right"></i></a>
                
            <?php } else { ?>
                <a style="background-color:#e42f08;color: white;" href="<?php echo base_url('app/happy_story');?>"><?php echo  translate('happy_story');?><i class="lni lni-chevron-right"></i></a>
                
            <?php } ?>
            </li>
            <li><a href="<?php echo base_url('app/change_password');?>"><?php echo  translate('change_password');?><i class="lni lni-chevron-right"></i></a></li>
            <li><?php if($this->db->get_where("member", array("member_id" =>$getUser->member_id))->row()->is_closed == 'yes'){?>
                <a type="button" data-toggle="modal" data-target="#exampleModal"><?php echo translate('re-open_account?')?><i class="lni lni-chevron-right"></i></a>
            <?php }else{?>
                <a type="button" data-toggle="modal" data-target="#exampleModalTwo"><?php echo translate('close_account')?><i class="lni lni-chevron-right"></i></a>
            <?php } ?>
            </li>
          </ul>
        </div>
      </div>

<!-- Preloader-->
    
    <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Back Button-->
        <div class="back-button"><a href="home.html"><i class="lni lni-chevron-left"></i></a></div>
        <!-- Page Title-->
        <div class="page-heading">
          <h6 class="mb-0"><?php echo translate('happy_story')?></h6>
        </div>
        <!-- Search Form-->
        <div class="search-form"><a href="search.html"><i class="fa fa-search"></i></a></div>
      </div>
    </div>
      <!-- Trending News Wrapper-->
      <div class="trending-news-wrapper">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-3 newsten-title"><?php echo translate('happy_story')?></h5>
          </div>
        </div>
        <div class="container">
          <div class="card">
              <div class="card-body">
    <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
          <button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
     <?php }else{ ?>
                
                <?php if ($getUser->membership == 1)
                  { ?>

                  <div class="row">
                    <div class="col-md-7 col-10">
                        <h6><span><?php echo translate('your_story')?></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 mt-2">
                        <p><?=translate('please_upgrade_to_premium_membership_to_post_your_stories')?></p>
                        <a href="<?=base_url()?>app/Subscription" class="default-btn"><?=translate('get_premium_membership')?></a>
                    </div>
                  </div>

                <?php }else{ ?>

                  <?php
                      $story_exist = $this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->result();
                  ?>

                  <div class="row">
                    <div class="col-md-7 col-10">
                        <h6><span><?php 
                        if ($story_exist) {
                            echo translate('your_story');
                        }
                        else {
                            echo translate('upload_your_story');      
                        }
                    ?></span></h6>
                    <?php
                    if ($story_exist) {
                        if ($this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->row()->approval_status == "1") {
                    ?>
                            <span class="badge badge-pill badge-success"><?=translate('approved')?></span>
                    <?php } else{ ?>
                            <span class="badge badge-pill badge-danger"><?=translate('not_approved')?></span>
                    <?php } } ?>
                    </div>
                </div>

                <?php
                $get_story = $this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->result();
                if ($story_exist) {
                foreach ($get_story as $value) 
                {
                ?> 
                <?php 

                $is_approved = $this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->row()->approval_status;
                ?>
                <div class="row mb-4">
                  <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-6">
                            <p><?= date_format(date_create($value->post_time),"d, F Y")?></p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="mb-1 btn btn-sm btn-success" href="<?php if($is_approved == '1'){echo base_url()?>WelcomeController/storyDetails/<?=$value->posted_by;}else{echo '#';}?>">
                            <?=$value->title?>
                            </a>
                        </div>
                    </div>
                    
                    </div>
                </div>

                <?php $images = json_decode($value->image, true); ?>

                <div class="container">
                  <!-- Owl Carousel-->
                  <div class="newsten-owl-carousel-slides owl-carousel">
                    <?php
                      $i = 0; 
                      if(!empty($images)){
                      foreach ($images as $image){ ?>
                    <div class="single-carousel-item"><img style="height: 180px;object-fit: contain;" src="<?php echo base_url();?>uploads/happy_story_image/<?=$image['img']?>" alt=""></div>
                  <?php } } ?>
                  </div>
                  <p class="mt-2"><?php echo $value->description?></p>
                </div>

                <?php
                  $video_exist = $this->db->get_where("story_video",array("story_video_uploader_id" => $getUser->member_id))->result();
                  if ($video_exist) {
                      $get_video = $this->db->get_where("story_video", array("story_video_uploader_id" => $getUser->member_id))->result_array();
                      foreach ($get_video as $video) {?>
                      <?php if($video['type'] == 'upload'){?>
                  <video controls height="250" width="100%">
                  <source src="<?php echo base_url();?><?php echo $video['video_src'];?>">
                  </video>
                  <?php }else{?>
                    <div class="embed-responsive embed-responsive-16by9 mb-3">
                  <iframe class="embed-responsive-item" src="<?php echo $video['video_link'];?>"></iframe>
                </div>
                      
              <?php } } } ?>

                

                <?php } } else { ?>

                    <form class="contact-form" action="<?php echo base_url('AppController/saveHappyStory/');?>"  method="POST" enctype="multipart/form-data">
                                                    <div class="form-group w-100">
                                                        <input class="form-control" type="text" placeholder="<?php echo translate('story_title')?>" id="title" name="title" required="required">
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <textarea placeholder="<?php echo translate('story_details')?>" class="form-control" name="description" id="" rows="6" required></textarea>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <input class="form-control" type="date" placeholder="<?php echo translate('date')?>" id="post_time" name="post_time" required>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <input class="form-control" type="text" placeholder="<?php echo translate('partner_name')?>" id="partner_name" name="partner_name" required>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <img style="height: 130px;object-fit: cover;" src="<?=base_url()?>uploads/happy_story_image/default_image.jpg" id="pimage_preview3"> 
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input class="form-control" type="file" class="form-control mt-2" id="pimage" name="image[]" onchange="document.getElementById('pimage_preview3').src = window.URL.createObjectURL(this.files[0])">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <img style="height: 130px;object-fit: cover;" src="<?=base_url()?>uploads/happy_story_image/default_image.jpg" id="pimage_preview2"> 
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input class="form-control" type="file" class="form-control mt-2" id="pimage" name="image[]" onchange="document.getElementById('pimage_preview2').src = window.URL.createObjectURL(this.files[0])">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                      </div>
                                                    <div class="form-group w-100">
                                                       <div class="col-md-12 select_div" id="vid_main">
                                                        <h6><?php echo translate('upload_video')?></h6> <br>
                                                        <div class="mt-2" id="vid_detail" style="display: none">
                                                            <label class="control-label"><?php echo translate('upload_method')?> <span class="text-danger">*</span></label>
                                                            <select class="form-control mt-2" name="upload_method" onchange="video_sector(this.value)">
                                                                <option selected disabled><?php echo translate('choose_an_option'); ?></option>
                                                                <option value="upload"><?php echo translate('upload_video') ?></option>
                                                                <option value="share"><?php echo translate('share_link'); ?></option>
                                                            </select>
                                                            <div class="mt-1" id="video_upload" style="display:none">
                                                                <label class="btn btn-styled btn-xs btn-base-2 btn-shadow ml-1" for="videoInp" style="margin: 5px 0px !important;cursor: pointer;"><?=translate('select_a_video')?></label><span class="text-danger video_limit_msg" style="margin-left: 10px; font-size: 12px"><?php echo translate("max_limit_25_Mb"); ?></span>
                                                                <input class="form-control" class="form-control videoInp" id="videoInp" type="file" name="upload_video" style="display: none" accept="video/*"/>
                                                                <div id="message"></div>
                                                                <label class="control-label"><?php echo translate('video_preview')?></label><br>
                                                                <video controls id="upload_story_video" style="width: 100%;">
                                                                </video>
                                                            </div>
                                                            <div id="video_share" style="display:none;">
                                                                <label class="control-label mt-3"><?php echo translate('sharing_site')?></label>
                                                                <select class="form-control site mt-2" name="site">
                                                                    <option selected disabled><?php echo translate('choose_an_option'); ?></option>
                                                                    <option value="youtube"><?php echo translate('youtube') ?></option>
                                                                    <option value="dailymotion"><?php echo translate('dailymotion'); ?></option>
                                                                    <option value="vimeo"><?php echo translate('vimeo'); ?></option>
                                                                </select>
                                                                <label class="control-label mt-3"><?php echo translate('video_link')?></label>
                                                                <input class="form-control" type="text" id="video_link" name="video_link" class="form-control mt-2" onchange="preview(this.value)">                                        
                                                                <label class="control-label mt-3"><?php echo translate('video_preview')?></label>     
                                                                    <div class="mt-2 mb-5">
                                                                        <div style="width: 100%!important;height: 100px;" id="video_preview">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input class="form-control" type="hidden" value="" id="vl" name="vl" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="btn_vid" class="form-group w-100 text-center mt-2 mb-5">
                                                       <button type="button" class="mb-1 btn btn-sm btn-info" onclick="video_section()"><?php echo translate('upload_video')?></button> 
                                                   </div>
                                                    
                                                    <div class="form-group w-100 text-center mt-5">
                                                        <button style="margin-top: 23px;" class="mb-1 btn btn-sm btn-success" type="submit"><span><?php echo translate('save');?></span></button>
                                                    </div>

                                                </form>

               <?php } }?>

            <?php } ?>
              </div>
            </div>
          </div>
          
          
        </div>
    </div>
<div id="edit_output"></div>

<div class="modal fade" id="interestModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="interestModalLabel"><?php echo translate('express_interest')?></h6>
        <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p><?php echo translate('you_have_no_express_interests_left. please_buy_any_package_from_premium_plans.')?></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        <a href="<?php echo base_url('app/Subscription');?>" class="btn btn-primary" type="button"><?php echo translate('premium_plans')?></a>
      </div>
    </div>
  </div>
</div>


