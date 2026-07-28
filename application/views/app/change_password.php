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
               
               <a href="<?php echo base_url('LoginController/appverifyMember');?>"><?php echo  translate('happy_story');?><i class="lni lni-chevron-right"></i></a>
                
            <?php } else { ?>
                <a href="<?php echo base_url('app/happy_story');?>"><?php echo  translate('happy_story');?><i class="lni lni-chevron-right"></i></a>
                
            <?php } ?>
            </li>
            <li><a  style="background-color:#e42f08;color: white;"  href="<?php echo base_url('app/change_password');?>"><?php echo  translate('change_password');?><i class="lni lni-chevron-right"></i></a></li>
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
          <h6 class="mb-0"><?php echo translate('my_interests')?></h6>
        </div>
        <!-- Search Form-->
        <div class="search-form"><a href="search.html"><i class="fa fa-search"></i></a></div>
      </div>
    </div>
      <!-- Trending News Wrapper-->
      <div class="trending-news-wrapper">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-3 newsten-title"><?php echo translate('change_password')?></h5>
          </div>
        </div>
        <div class="container">
          <div class="card">
              <div class="card-body">
    <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
          <button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
     <?php }else{ ?>
      <!-- <div id="success-alert" style="display:none" class="alert alert-primary" role="alert">A simple primary alert!</div> -->
                    <div class="row justify-content-center">
                      <div class="col-12 col-lg-9">
                          <div class="contact-form-wrapper text-center">
                              <form class="contact-form" id="myForm" action="<?php echo base_url('LoginController/appchangePassword');?>" method="POST">
                                  <div class="form-group w-100">
                                      <input class="form-control" type="text" placeholder="<?php echo translate('current_password')?>" id="current_password" name="current_password" required>
                                  </div>
                                  <div class="form-group">
                                      <input class="form-control" type="text" placeholder="<?php echo translate('new_password');?>" name="new_password" id="new_password" required>
                                  </div>
                                  <div class="form-group">
                                      <input class="form-control" type="text" placeholder="<?php echo translate('confirm_password')?>" name="confirm_password" id="confirm_password" required>
                                  </div>
                                  
                                  <div class="form-group w-100 text-center">
                                      <button class="mb-1 btn btn-sm btn-success" type="button" onclick="return Validate()"><span><?php echo translate('submit')?></span></button>
                                  </div>
                              </form>
                              <p class="form-message"></p>
                          </div>
                      </div>
                  </div>
            <?php } ?>
              </div>
            </div>
          </div>
            
          
        </div>
    </div>








