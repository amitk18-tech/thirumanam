<style>
  
 tbody{
  color: white;
 }
 thead{
  color: white;
 }
 .modal-backdrop.show {
  opacity: 0;
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
            <li><a style="background-color:#e42f08;color: white;" href="<?php echo base_url('app/gallery');?>"><?php echo  translate('gallery');?><i class="lni lni-chevron-right"></i></a></li>
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

<!-- Preloader-->
    
    <!-- Header Area-->
   
      <!-- Trending News Wrapper-->
      <div class="trending-news-wrapper mb-5">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <h5 class="mb-3 newsten-title"><?php echo translate('gallery')?></h5>
          </div>
        </div>
        <div class="container">
          <div class="card" id="info_gallery">
              <div class="card-body" style="background-color: #dcebfd;
    color: white;">
    <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
          <button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
     <?php }else{ ?>
      <!-- For You News Wrapper-->
      <div class="for-you-news-wrapper">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <!-- <h5 class="mb-0 newsten-title"></h5> -->
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
                <button type="button" class="mb-1 btn btn-sm btn-primary" onclick="gallery_load('gallery')"><?php echo translate('upload_image')?></button>
            </div>
          </div>
            <div class="row">
                <?php 
                $get_gallery = $this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->gallery;
                $gallery_data = json_decode($get_gallery, true);
                if (!empty($gallery_data)) { $i=0;
                    foreach ($gallery_data as $value) {$i++;
                    ?>
                    
                    <?php
                if (file_exists('uploads/gallery_image/'.$value['image'])) {
                ?>

            <!-- Single Recommended Post-->
            <div class="col-12 mt-3">
              <div class="card">
                <div class="card-header p-2">
                  <div class="row">
                    <div class="col-6">
                      <form class="contact-form" action="<?php echo base_url('AppController/saveProfileImage/'.$getUser->member_id); ?>" method="POST" enctype="multipart/form-data"> 
                        <button id="save_button" class="btn btn-info" type="submit"><?php echo translate('add')?> </button>
                        <div style="display: none;">
                          <input type="text" name="profile_image" value="<?=base_url()?>/uploads/profile_image/<?=$value['image']?>">
                          <input type="text" name="image_name" value="<?=$value['image']?>">
                        </div>
                      </form>
                    </div>
                    <div class="col-6" style="text-align: end;">
                      <?php if($profile_image[0]['profile_image']==$value['image']){?>
                          <i class="fa fa-check text-success" style="font-size: 23px;"></i>
                      <?php } ?>
                    </div>
                  </div>
                  
                       
                </div>
                <div class="card-body">
                  <div class="single-recommended-post mt-3">
                    <div class="bookmark-customize-option">
                      <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModalCenter"><i style="color: #e42f08;" class="lni lni-cut"></i></button>
                  
                    </div>
                      <img style="width: 100%;height: 200px;object-fit: cover;" src="<?=base_url()?>uploads/gallery_image/<?=$value['image']?>" alt="">
                      <div class="post-content" style="color:#e42f08;; font-weight: bold;"><?php echo $value['title'];?></div>
                  </div>
              </div>
            </div>
          </div>
          <?php } } }  ?>

           </div>
        </div>
      </div>
            <?php } ?>
              </div>
            </div>
          </div>





<div class="card" style="display:none;border: none;padding: 10px;"  id="edit_gallery">
  <div class="card-body" style="background-color: #dcebfd;border-radius: 5px;"> 
      <div class="row justify-content-center pb-15">
      <div class="col-lg-12 col-12">
      <article>
          <div class="shop-product-wrap grid row justify-content-center g-4" >
             
              <div class="col-12 col-lg-12">
                  <div class="contact-form-wrapper text-center">
                      <form class="contact-form" action="<?php echo base_url('AppController/updateGalery');?>" method="POST" enctype="multipart/form-data">   
                      <input class="form-control" type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>"> 
                          <div class="form-group w-100">
                              <input class="form-control" style="border: 1px solid rgba(33, 51, 102, 0.1);" type="text" placeholder="Image Tittle" id="subject" name="title" required>
                          </div>
                          <div class="form-group">
                          <input class="form-control" style="border: 1px solid rgba(33, 51, 102, 0.1);" type="file" name="image" id="image">
                          </div>
                          <div class="form-group w-100 text-center">
                              <div class="row">
                                  <div class="col-md-6">
                                      <button onclick="gallery_back('gallery')" class="mb-1 btn btn-sm btn-secondary mt-2" type="button"><span><?php echo translate('go_back')?></span></button>
                                  </div>
                                  <div class="col-md-6">
                                       <button class="mb-1 btn btn-sm btn-success mt-2 reverse" type="submit"><span><?php echo translate('upload')?></span></button>
                                  </div>
                              </div>
                              </div>
                              </form>
                              <p class="form-message"></p>
                          </div>
                      </div>
                  </div>
              </article>
              </div>
          </div>
      </div>
  </div>
</div>
</div>

  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" id="exampleModalCenterTitle"><?php echo translate('delete')?></h6>
            <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this!!!</p>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo translate('close')?></button>
            <a href="<?php echo base_url('AppController/deleteGalleryImage/'.$getUser->member_id.'/'.$value['index']);?>" class="btn btn-primary" type="button"><?php echo translate('delete')?></a>
          </div>
        </div>
      </div>
    </div>

