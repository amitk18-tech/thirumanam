<?php 

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

?>

<?php 
 
$profile_images = get_type_name_by_id('member', $this->session->userdata['thirumanam_applogged_data']['member_id'], 'profile_image');
$profile_image = json_decode($profile_images, true);
$listed_messaging_members = get_listed_messaging_members($this->session->userdata('thirumanam_applogged_data')['member_id']);
sort_array_of_array($listed_messaging_members, 'message_thread_time', SORT_DESC);

 
// print_r($listed_messaging_members);exit;
?>

<div class="page-content-wrapper">
      <!-- Trending News Wrapper-->
      <div class="trending-news-wrapper">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <!-- <h5 class="mb-3 newsten-title">Trending</h5>
            <p class="mb-3 line-height-1">9 Posts</p> -->
          </div>
        </div>
        <div class="container">

           <?php  
              foreach ($listed_messaging_members as $messaging_member) {
              $is_member = $this->db->get_where("member", array("member_id" => $messaging_member['member_id']))->row();
               if(!empty($is_member) && $is_member->is_closed == 'no'){
              if ($this->db->get_where('member', array('member_id' => $messaging_member['member_id']))->row()->member_id) {
              $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
              if(!is_message_thread_seen($messaging_member['message_thread_id'],$member_id)){
              }
              $messaging_member_info = $this->db->get_where('member', array('member_id' => $messaging_member['member_id']))->row();
              $profile_images = get_type_name_by_id('member', $messaging_member_info->member_id, 'profile_image');
              $image = json_decode($profile_images, true);
              ?>


          <!-- Single Trending Post-->
          <div class="single-trending-post d-flex">
            <div class="post-thumbnail">

              <a title="<?php echo translate('view_profile')?>" href="<?php echo base_url('app/short_view/'.$messaging_member_info->member_id);?>">

                  <?php if($messaging_member_info->gender==1){?>
                  <img style="object-fit:contain;height:80px;width: 80%;border-radius: 10px;" alt="dating thumb" src="<?php echo (!empty($image && $image[0]['profile_image']) && file_exists('uploads/profile_image/'.$image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                  <?php } ?>
                  <?php if($messaging_member_info->gender==2){?>
                      <img style="object-fit:contain;height:80px;width: 80%;border-radius: 10px;" alt="dating thumb" src="<?php echo (!empty($image && $image[0]['profile_image']) && file_exists('uploads/profile_image/'.$image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                  <?php } ?>

              </a>

            </div>
            <div class="post-content" style="padding-left: 0px;">
              <?php if(isset($messaging_member['to_id']) == $this->session->userdata('thirumanam_applogged_data')['member_id']){
              if($messaging_member['message_to_seen']==""){

              
              ?>
              <p style="font-weight:normal;margin-bottom: 10px;"><a title="<?php echo translate('message');?>" href="<?php echo base_url('app/messaging');?>"><i class="fas fa-envelope text-danger mr-1"></i><?php echo translate('recieved_message');?></a></p>
                  </a>
              <?php }else{ ?>
                  <p  style="font-weight:normal;margin-bottom: 10px;"><i class="fas fa-envelope-open text-success mr-1"></i><?php echo translate('recieved_message');?></p>
              <?php } }?> 
              <?php if(isset($messaging_member['from_id'])){?>
                  <p  style="font-weight:normal;margin-bottom: 10px;"><?php echo translate('sending_message');?></p>
              <?php } ?>

              <a class="btn btn-sm btn-primary" title="<?php echo translate('message')?>" href="<?php echo base_url('app/messaging')?>"><?= $messaging_member_info->first_name ?></a>
              <div class="text-end" style="font-size: 13px;margin-top: 10px;margin-left: 95px;"><?=date('d M,y - h:i A', $messaging_member['message_thread_time'])?>
            </div>
            </div>
          </div>
          <!-- Single Trending Post-->
          <?php } } } ?>
          <?php 
            if (count($listed_messaging_members) <= 0) {
                ?>
                    <div class="text-center">
                        <small class="sml_txt text-dark">
                            <?php echo translate('no_messages_to_show')?>
                        </small>
                    </div>
                <?php
                }
            ?>
        </div>
      </div>
    </div>