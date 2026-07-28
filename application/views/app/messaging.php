<style>
  
 tbody{
  color: white;
 }
  body{
  background-image: none;
}
</style>
<style>
    .modal-body label {
    margin-bottom: 0px !important;
    }
    .card{
        padding: 15px !important;
    }
    .msger-send-btn {
  margin-left: 10px;
  background: rgb(0, 196, 65);
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.23s;
  height: 100%;
  padding: 5px;
}
.msger-send-btn:hover {
  background: rgb(0, 180, 50);
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

    
  
    
      <!-- Trending News Wrapper-->
      <div class="trending-news-wrapper">
        
        
    <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
          <button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
     <?php }else{ ?>
                
            <div class="row">
              <div class="container">
              <div class="col-12">
                  <?php $user_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
                  $listed_messaging_members =get_listed_messaging_members($user_id);

                                  ?>

                      <div>
                          <div class="direct-chat-contacts mt-3">
                          <ul class="contacts-list">
                              <!-- <div class="pt-3 pb-2 text-center" style="border-bottom: 1px solid rgba(0, 0, 0, .15); margin: 0; width: 90% !important; margin-left: 5%;">
                                  <h4 class="card-inner-title c-base-1"><i class="fa fa-users"></i> <?php echo translate('contact_list')?></h4>
                              </div> -->
                              <?php
                              // print_r($listed_messaging_members);exit;
                               foreach ($listed_messaging_members as $listed_member){ ?>
                                  <?php if (!empty($this->db->get_where('member', array('member_id' => $listed_member['member_id']))->row()->member_id)){
                                         
                                      $member_info = $this->db->get_where('member', array('member_id' => $listed_member['member_id']))->row();
                                      if ($member_info->is_closed=='no') {
                                  ?>
                                      <li class="d-flex mb-3">
                                          <!-- <a class="img_btn" style='hover :
                        background: rgb(0, 180, 50);cursor:pointer; margin-top: 10px; ' onclick="open_message_box(<?=$listed_member['message_thread_id']?>,this)" id="thread_<?=$listed_member['message_thread_id']?>"> -->
                         <a class="img_btn" style='hover :
                        background: rgb(0, 180, 50);cursor:pointer; margin-top: 10px; ' href="<?php echo base_url('AppController/get_messages/'.$listed_member['message_thread_id'])?>" id="thread_<?=$listed_member['message_thread_id']?>">

                        <div class="row">
                          <div class="col-2">
                              <?php
                                $images = json_decode($member_info->profile_image, true);
                                if (file_exists('uploads/profile_image/'.$images[0]['thumb']) && !empty($images[0]['thumb'])) {
                                ?>
                                    <img style="width: 100%;border-radius: 30px;" class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/<?=$images[0]['thumb']?>">
                                <?php
                                }
                                else {
                                if($member_info->gender==1){
                                ?>
                                    <img style="width: 100%;border-radius: 30px;" class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/default.jpg">
                                <?php } else { ?>
                                    <img style="width: 100%;border-radius: 30px;" class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/default_female.jpg">
                                <?php
                                } }
                            ?>
                          </div>
                           <div class="col-10">
                            <div class="contacts-list-info">
                                <span class="contacts-list-name" data-member="<?=$member_info->member_id?>">
                                    <?=$member_info->first_name.' '.$member_info->last_name?>
                                </span>
                            </div>
                          </div>
                        </div>
                                              
                                              
                                              
                                          </a>
                                      </li>
                                      <!-- <hr> -->
                                  <?php } } } ?>
                              </ul>
                          </div>
                          </div>
                  
                      </div>
                    </div>
              
              
              
                  </div>

            <?php } ?>
          </div>
          
          
        </div>
    </div>







