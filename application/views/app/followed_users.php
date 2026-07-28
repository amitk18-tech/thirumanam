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

<div class="page-content-wrapper" style="margin-bottom:100px!important">

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
   
   <div class="page-content-wrapper">
      <div class="all-pages-wrapper">
        <div class="container">
          <ul class="page-nav">
            <li><a href="<?php echo base_url('app/profile');?>"><?php echo  translate('profile');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/my_interests');?>"><?php echo  translate('my_interests');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a href="<?php echo base_url('app/shortlist');?>"><?php echo  translate('shortlist');?><i class="lni lni-chevron-right"></i></a></li>
            <li><a style="background-color:#e42f08;color: white;" href="<?php echo base_url('app/followed_users');?>"><?php echo  translate('followed_users');?><i class="lni lni-chevron-right"></i></a></li>
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
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-3 newsten-title"><?php echo translate('followed_users')?></h5>
          </div>
        </div>
        <div class="container">
          <div class="card">
              <div class="card-body p-0">
    <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
          <button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
     <?php }else{ ?>
                
                <div class="user-all-article-wrapper">
                <div class="container">
                  <div class="d-flex align-items-center justify-content-between">
                    <!-- <h6 class="mb-3 newsten-title">My Articles</h6> -->
                    <h6 class="mb-3 line-height-1"><?php echo $result_count;?></h6>
                  </div>
                </div>
                <div class="container"> 
               <?php
               if(!empty($results)){
               foreach($results as $member){
                    // print_r($member->status);exit;
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);
                    $birth = json_decode($member->astronomic_information, true);    
                    // print_r($spiritual_and_social_background);exit;
                if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }   
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }

                
                // $status=getStatusLabel($member[$j]->active_status);
                $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest');
                $interest = json_decode($interests, true);
                $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
                if (in_assoc_array($member->member_id, 'id', $interest)) {

                    $like = '<button title="'.translate('interest_expressed').'" class="btn btn-xs btn-sm btn-danger btn-border" ><i class="fa fa-heart"></i></button>';
                }else{

                    if($count_interest == 0){

                        $like = '<button type="button" title="'.translate('express_interest').'" data-toggle="modal" data-target="#interestModal" class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1"><i class="fa fa-heart"></i></button>';
                    }else{

                        $like = '<button onclick="doInterest('.$member->member_id.')" title="'.translate('express_interest').'"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1"><i class="fa fa-heart"></i></button>';

                    }
                    // print_r($count_interest);exit;

                         // $like = '<a title="'.translate('express_interest').'" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'" class="btn btn-xs btn-sm btn-outline-primary btn-border" ><i class="fa fa-heart"></i></a>';
                }

                    

                
               
                $action='<div class="hstack gap-2 fs-18"> 
                            '.$like.' 
                            <button title="'.translate('remove').'" onclick="deleteFollow('.$member->member_id.')" class="btn btn-xs btn-sm btn-outline-danger btn-border"><i class="fa fa-close"></i></button>
                            <a class="btn btn-success btn-sm" href="'.base_url('app/short_view/'.$member->member_id).'">'. translate('view').'</a>
                        </div>'; 

               ?> 
                    <a class="post-title btn-primary text-white" style="font-size:13px;padding: 3px;"><span  style="font-weight: bold;"><?php echo translate('member_id')?> : </span> <?php echo $member->member_profile_id; ?></a> 
                  <div class="single-news-post d-flex align-items-center bg-gray">
                  <div class="post-thumbnail"><?php echo $image;?></div>
                  <div class="post-content">
                   <a class="post-title"><span  style="font-weight: bold;"><?php echo translate('name')?> :</span> <?php echo $member->first_name; ?></a>
                    <a class="post-title"><span  style="font-weight: bold;"><?php echo translate('age')?> :</span> <?php echo $age; ?></a>
                     <a style="font-size: 14px;"><span  style="font-weight: bold;"><?php echo translate('options')?> : </span> <?php echo $action; ?></a>

                  </div>
                </div>

            <?php } } } ?>
              </div>
                <nav aria-label="Page navigation example" class="pt-2">
                  <?php echo $links;?>
                </nav>
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


