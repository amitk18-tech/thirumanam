<?php

if(empty($_SERVER['HTTP_REFERER'])){

    redirect('active_members');
}

$member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
$rem_download = get_type_name_by_id('member', $member_id, 'remain_download');
$view_data= checkAlreadyViewed($member_id,$getUser->member_id); 

$getmember= getData('member','row',array('member_id'=>$member_id));
$education_and_career = get_type_name_by_id('member', $getUser->member_id, 'education_and_career');
$education_and_career_data = json_decode($education_and_career, true);
$physical_attributes = get_type_name_by_id('member', $getUser->member_id, 'physical_attributes');
$physical_attributes_data = json_decode($physical_attributes, true);
$permanent_address = get_type_name_by_id('member', $getUser->member_id, 'permanent_address');
$permanent_address_data = json_decode($permanent_address, true);
$family_info = get_type_name_by_id('member', $getUser->member_id, 'family_info');
$family_info_data = json_decode($family_info, true);
$partner_expectation = get_type_name_by_id('member', $getUser->member_id, 'partner_expectation');
$partner_expectation_data = json_decode($partner_expectation, true);
$profile_images = get_type_name_by_id('member', $getUser->member_id, 'profile_image');
$profile_image = json_decode($profile_images, true);
$basic_info = get_type_name_by_id('member',$getUser->member_id, 'basic_info');
$basic_info_data = json_decode($basic_info, true);
$astronomics = get_type_name_by_id('member',$getUser->member_id, 'astronomic_information');
$astronomic_information_data = json_decode($astronomics, true);
$age="";
if(!empty($astronomic_information_data[0]['date_of_birth'])){
    $date1 = date('Y',strtotime(($astronomic_information_data[0]['date_of_birth']))); 
    $date2 = date("Y"); 
    $age= $date2-$date1;
}
$raasis = json_decode($getUser->chart);
?>
<style>
    .member__content {
    padding: 24px 0px 20px!important;
}
</style>

    <div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
        <div class="container">
            <div class="pageheader__content text-center">
                <h2><?php echo translate('profile ')?></h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0" style="background-color:transparent!important">
                      <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?php echo translate('profile')?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="activity member--style2 mt-5">
        <div class="container">
    <div class="row mt-5">
        <div class="col-md-4 col-12 mb-5" >
            <div class="card" style="border: none;padding: 10px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
                <div class="member__thumb">
                <?php if($getUser->gender==1){?>
                <img  style="width: 100%;height: 10em;object-fit: contain;" src="<?php echo ((file_exists('uploads/profile_image/'.$profile_image[0]['profile_image'])) && !empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>" alt="member-img">
                <?php } ?>
                <?php if($getUser->gender==2){?>
                <img  style="width: 100%;height: 10em;object-fit: contain;" src="<?php echo ((file_exists('uploads/profile_image/'.$profile_image[0]['profile_image'])) && !empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>" alt="member-img">
                <?php } ?>
                    <span class="member__activity"></span>
                </div>
                <div class="member__content">
                    <a href="member-single.html"><h5  style="color:white"><?php echo $getUser->first_name; ?></h6></a>
                    <div class="row mt-3">
                             
                            <?php if($getmember->is_closed=='yes'){
                                echo "";}else{?>
                             <?php 


                         
                        if($getmember->membership!=1 && $getmember->updateProfileDoneStatus!=0){

                        $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'interest');
                        $interest = json_decode($interests, true);
                        $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'express_interest');
                        if (in_assoc_array($getUser->member_id, 'id', $interest)) {

                            echo'<div class="col-md-12 mt-2">
                                <button  class="default-btn btn-sm p-3" style="width:100%">'.translate('interest_expressed').'</button>
                            </div>';
                        }else{

                            if($count_interest == 0){

                                echo'<div class="col-12 mt-2">
                                <button type="button" data-toggle="modal" data-target="#interestModal" class="default-btn btn-sm p-3" style="width:100%">'.translate('express_interest').'</button>
                            </div>';
                            }else{

                               echo'<div class="col-12 mt-2">
                                <button onclick="doInterest('.$getUser->member_id.')"  class="default-btn btn-sm p-3" style="width:100%">'.translate('express_interest').'</button>

                            </div>';

                            } }
                            
                        }else{
                            echo'<div class="col-md-12 mt-12">
                                <a style="cursor:pointer;width: 100%;" href="'.base_url('LoginController/verifyMember').'"  class="default-btn btn-sm p-3">'.translate('express_interest').'</a>
                            </div>';
                        }?>


                        <?php 
                        if($getmember->membership!=1 && $getmember->updateProfileDoneStatus!=0 && $getmember->member_type!=2){

                        $shortlist = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'short_list');
                        $shortlist = json_decode($shortlist, true);
                        
                        if (in_array($getUser->member_id, $shortlist)) {

                            echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <button title="'.translate('remove_shortlist').'" onclick="remove_shortlist('.$getUser->member_id.')" class="default-btn btn-sm p-3" style="width:100%">'.translate('shortlisted').'</button>
                            </div>';
                        }else{

                            

                               echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <button onclick="do_shortlist('.$getUser->member_id.')"  class="default-btn btn-sm p-3" style="width:100%">'.translate('shortlist').'</button>
                            </div>';

                            
                            
                        } }else {
                            echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <a style="cursor:pointer;width: 100%;" href="'.base_url('LoginController/verifyMember').'"  class="default-btn btn-sm p-3">'.translate('shortlist').'</a>
                            </div>';
                        }?>

                       
                        <?php 
                        if($getmember->membership!=1 && $getmember->updateProfileDoneStatus!=0){
                        $followes = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'followed');
                        $followed = json_decode($followes, true);
                        
                        if (in_array($getUser->member_id, $followed)) {

                            echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <button onclick="do_unfollow('.$getUser->member_id.')"  class="default-btn btn-sm p-3" style="width:100%">'.translate('unfollow').'</button>
                            </div>';
                        }else{

                                echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <button onclick="do_follow('.$getUser->member_id.')"  class="default-btn btn-sm p-3" style="width:100%">'.translate('follow').'</button>
                            </div>';
                            
                         }
                        }else{
                                echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <a style="cursor:pointer;width: 100%;" href="'.base_url('LoginController/verifyMember').'"  class="default-btn btn-sm p-3">'.translate('follow').'</a>
                            </div>';
                         }   
                        ?>


                       

                            <?php if($getmember->membership!=1 && $getmember->updateProfileDoneStatus!=0){?>
                            
                            <div class="col-6 mt-2" style="padding: 11px;">
                                <button onclick="confirm_ignore(<?php echo $getUser->member_id;?>)" class="default-btn btn-sm p-3" style="width:100%"><?php echo translate('ignore')?></button>
                            </div>
                            <?php }else{ ?>
                                <div class="col-6 mt-2" style="padding: 11px;">
                                <a style="cursor:pointer;width: 100%;" href="<?php echo base_url('LoginController/verifyMember') ?>" class="default-btn btn-sm p-3" ><?php echo translate('ignore')?></a>
                                </div>
                            <?php } ?>
                            

                           

                            <?php if($getmember->member_type != 2 && $getmember->membership != 1 && $getmember->updateProfileDoneStatus!=0){
                                $report_profiles = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'report_profile');
                                if(!empty($report_profiles))
                                  {
                                    $report_profile = json_decode($report_profiles, true);
                                  }else{

                                      $report_profile = "";
                                  }
                                
                                if (is_array($report_profile) && in_array($getUser->member_id, $report_profile)) {

                                    echo'<div class="col-6 mt-2" style="padding: 11px;">
                                        <button type="button" data-toggle="modal" data-target="#reportModal" class="default-btn btn-sm p-3" style="width:100%">'.translate('profile_reported').'</button>
                                    </div>';
                                }else{

                                echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <button onclick="add_report('.$getUser->member_id.')" class="default-btn btn-sm p-3" style="width:100%">'.translate('profile_report').'</button>
                            </div>';
                             } } else{
                                echo'<div class="col-6 mt-2" style="padding: 11px;">
                                <a style="cursor:pointer;width: 100%;" href="'.base_url('LoginController/verifyMember').'"  class="default-btn btn-sm p-3">'.translate('profile_report').'</a>
                                </div>';
                             } ?>
                            
                            <?php } ?>

                             <?php
                        $if_message = $this->db->get_where('message_thread', array('message_thread_from' => $getUser->member_id, 'message_thread_to' => $this->session->userdata('thirumanam_logged_data')['member_id']))->row();
                        if (!$if_message) {
                            $if_message = $this->db->get_where('message_thread', array('message_thread_from' => $this->session->userdata('thirumanam_logged_data')['member_id'], 'message_thread_to' => $getUser->member_id))->row();
                        }

                        if ($if_message) {
                            $message_onclick = 0;
                            $message_text = translate('messaging_enabled');
                            $message_class = "btn btn-styled btn-block btn-sm btn-white z-depth-2-bottom li_active";
                        }
                        else {
                            $message_onclick = 1;
                            $message_text = translate('enable_messaging');
                            $message_class = "btn btn-styled btn-block btn-sm btn-white z-depth-2-bottom";
                        }
                     $rem_message = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'direct_messages');?>
                        <div class="col-12 mt-2">
                            <?php if($rem_message == 0){?>

                                <button type="button" data-toggle="modal" data-target="#messageModal" class="default-btn btn-sm p-3" style="width:100%"> <?=$message_text?></button>

                           <?php }else{ ?>

                                 <?php if($message_onclick==1){?>

                                <button onclick="return confirm_message(<?=$getUser->member_id?>)" class="default-btn btn-sm p-3" style="width:100%"> <?=$message_text?></button>
                            <?php }else{ ?>

                                <button class="default-btn btn-sm p-3" style="width:100%"> <?=$message_text?></button>

                          <?php } }
                                ?>
                                
                            </div>

                        </div>
                    </div>
                    <hr  style="color:white;">
                    <div class="text-center">
                        <span  style="color:white;font-size:25px;"><?php echo $getUser->follower;?></span>
                        <p style="color:white"><?php echo translate('followers')?></p>
                    </div>
                    <hr  style="color:white;">
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <label style="color:white;"><?php echo translate('age')?> :</label>
                        </div>
                        <div class="col-md-6 col-6">
                            <span style="color:white;"><?php echo $age;?></span>
                        </div>
                         <hr  style="color:white;">
                        <div class="col-md-6 col-6">
                            <label style="color:white;"><?php echo translate('martial_status')?> :</label>
                        </div>
                        <div class="col-md-6 col-6">
                             <span style="color:white;"><?php echo $basic_info_data[0]['marital_status'];?></span>
                        </div>
                         <hr  style="color:white;">
                        <div class="col-md-6 col-6">
                            <label style="color:white;"><?php echo translate('education')?> :</label>
                        </div>
                        <div class="col-md-6 col-6">
                            <span style="color:white;"><?php echo ($education_and_career_data[0]['Type_of_study']=='OTHERS') ? $education_and_career_data[0]['other_study'] : dropdownTranslate($education_and_career_data[0]['Type_of_study']) ;?></span>
                        </div>
                         <hr  style="color:white;">
                        <div class="col-md-6 col-6">
                            <label style="color:white;"><?php echo translate('occupation')?> :</label>
                        </div>
                        <div class="col-md-6 col-6">
                            <span style="color:white;"><?php echo ($education_and_career_data[0]['Type_of_occupation']=='OTHERS') ? $education_and_career_data[0]['Other_Occupation_Details'] : dropdownTranslate($education_and_career_data[0]['Type_of_occupation']) ;?></span>
                        </div>
                         <hr  style="color:white;">
                        <div class="col-md-6 col-6">
                            <label style="color:white;"><?php echo translate('height')?> :</label>
                        </div>
                        <div class="col-md-6 col-6">
                            <span style="color:white;"><?php echo $getUser->height;?></span>
                        </div>
                    </div>

                    <hr  style="color:white;">
                    <?php

                $payment= getMemberCurrentPayment($getmember->member_id);                
                $info = (!empty($payment)) ?  $this->db->get_where('plan',array('plan_id'=>$payment->plan_id))->row() : [];
                $msg='';
                     
                if (!empty($info)) {
                    $language=getLanguage();
                     $info_msg = $info->info;
                     $info_msgs = json_decode($info_msg, true);
                     if ($language=='tamil') {
                        $msg=$info_msgs[0]['tamil'];
                     }
                     else
                     {
                        $msg=$info_msgs[0]['english'];  
                     }
                }

                ?><!--line no 2779-->
                <p class="mt-3 text-white"><?php echo $msg ;?></p>

                
                </div>
            </div>
        <div class="col-md-8 col-12">
        <!-- ================> Activity section start here <================== -->
        <div class="activity">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-5" style="border: none;padding: 10px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3);">
                        <div class="row">
                                <div class="col-md-6 col-6">
                                    
                                </div>
                                <div class="col-md-12 col-12 text-end">
                                    <?php
                                    
                                    if($short!='fullview'){ ?>

                                        <button onclick="history.back();" class="default-btn btn-sm"><?php echo translate('go_back')?></button>

                                  
                                   <?php if($getmember->updateProfileDoneStatus == 0) { ?>

                                        <a href="<?php echo base_url('LoginController/verifyMember');?>" class="default-btn btn-sm"><?php echo translate('full_profile')?></a>
                                    <?php } elseif($getmember->membership == 1){ ?>

                                    
                                    <a href="<?php echo base_url('Subscription');?>" class="default-btn btn-sm"><?php echo translate('full_profile')?></a>
                                    
                                     <?php } else{ 

                                            if (!empty($view_data)) {
                                                ?>
                                                <button onclick="goto_profile_view(<?php echo $getUser->member_id;?>)" class="default-btn btn-sm"><?php echo translate('full_profile')?></button>
                                    <?php } else {?>
                                         
                                        <button class="default-btn btn-sm" type="button" onclick='goto_profile(<?php echo $getUser->member_id;?>,<?php echo $rem_download;?>)'><?php echo translate('full_profile')?></button>
                                    <?php } }  ?>
                                    
                                    
                                <?php }else{ ?>
                                    <button onclick="history.back();" class="default-btn btn-sm"><?php echo translate('go_back')?></button>
                                    <a target="_blank" href="<?php echo base_url('printMember/'.$getUser->member_id);?>" class="default-btn btn-sm"><?php echo translate('print_profile')?></a>
                                <?php } ?>
                                </div>
                                
                            </div>  
                        
                               <?php if($short=='shortview'){?>
                                <div class="group__bottom--area mt-2"  id="info_introduction">
                                        <div class="group__bottom--group">
                                        <div class="activity__inner">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row mb-2">
                                                <div class="col-md-7 col-10">
                                                    <h6><span><?php echo translate('quick_information')?></span></h6>
                                                </div>
                                                <div class="col-md-5 col-2 text-end">
                                                
                                                </div>
                                            </div>
                                                <div class="row">
                                                    <div class="col-md-6 mt-2">
                                                        <div class="row">
                                                          <div class="col-md-6 col-6">
                                                            <label><?php echo translate('Member_ID')?> :</label>
                                                          </div>
                                                          <div class="col-md-6 col-6">
                                                            <span>
                                                              <?php 
                                                                if($getUser->membership == 1 && $getUser->member_type == 1)
                                                                {

                                                                }
                                                                else
                                                                {
                                                                   if(substr($getUser->member_profile_id,0,1) == 'M')
                                                                            {
                                                                                $one = substr($getUser->member_profile_id,0,4);
                                                                                $trasOne = translate($one);
                                                                                $two = substr($getUser->member_profile_id,4);
                                                                                echo $trasOne.$two;
                                                                            }
                                                                             elseif(substr($getUser->member_profile_id,0,1) == 'F')
                                                                            {
                                                                                $one = substr($getUser->member_profile_id,0,6);
                                                                                $trasOne = translate($one);
                                                                                $two = substr($getUser->member_profile_id,6);
                                                                                echo $trasOne.$two;
                                                                            }else {
                                                                                echo $getUser->member_profile_id;
                                                                            } 
                                                                }
                                                                ?>
                                                                </span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                           
                                                          <div class="row">
                                                          <div class="col-md-6 col-6">
                                                            <label><?php echo translate('Name')?> : </label> 
                                                          </div>
                                                          <div class="col-md-6 col-6">
                                                              <span><?=$getUser->first_name?></span>
                                                          </div>
                                                        </div>   
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <div class="row">
                                                              <div class="col-md-6 col-6">
                                                                <label><?php echo translate('date_of_birth')?> :</label>
                                                              </div>
                                                              <div class="col-md-6 col-6">
                                                                  <span><?=date("d-m-Y", strtotime($astronomic_information_data[0]['date_of_birth']));?></span>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    <div class="col-md-6 mt-2">
                                                        <div class="row">
                                                          <div class="col-md-6 col-6">
                                                            <label><?php echo translate('star')?> :</label> 
                                                          </div>
                                                          <div class="col-md-6 col-6">
                                                              <span><?=dropdownTranslate($astronomic_information_data[0]['star'])?></span>
                                                          </div>
                                                        </div>
                                                        
                                                        <?php if(!empty($astronomic_information_data[0]['TYPE_OF_DOSHAM'])){?>
                                                    </div>   
                                                    <div class="col-md-6 mt-2">  
                                                    <div class="row">
                                                          <div class="col-md-6 col-6">
                                                            <label><?php echo translate('DOSHAM')?> : </label>
                                                          </div>
                                                          <div class="col-md-6 col-6">
                                                             <span><?php if($astronomic_information_data[0]['DOSHAM']== 'No'){ echo dropdownTranslate($astronomic_information_data[0]['DOSHAM']); } elseif($astronomic_information_data[0]['TYPE_OF_DOSHAM'] != 'OTHERS') { echo dropdownTranslate($astronomic_information_data[0]['TYPE_OF_DOSHAM']); } elseif($astronomic_information_data[0]['TYPE_OF_DOSHAM'] == 'OTHERS') { echo $astronomic_information_data[0]['Other_Dosham']; }   ?></span>
                                                          </div>
                                                        </div> 
                                                        
                                                    <?php } ?>
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                        <div class="row">
                                                          <div class="col-md-6 col-6">
                                                            <label><?php echo translate('father_vangusam')?> : </label>
                                                          </div>
                                                          <div class="col-md-6 col-6">
                                                              <span><?php if($family_info_data[0]['father_vangusam'] != 'OTHERS'){ echo dropdownTranslate($family_info_data[0]['father_vangusam']); } else { echo $family_info_data[0]['other_father_vang']; }  ?></span>
                                                          </div>
                                                        </div>

                                                         
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                               
                            </div>
                        <?php } ?>

                           <div class="group__bottom--area mt-2"  id="info_introduction">
                                <div class="group__bottom--group">
                                    <div class="activity__inner">
                                        <div class="row">
                                            <div class="col-md-7 col-10">
                                            <h6><span><?php echo translate('introduction')?></span></h6>
                                            </div>
                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-2" id="introduction_val">
                                                <?php echo $getUser->introduction;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($short=='fullview'){?>

                                <div class="group__bottom--area mt-2" id="info_basic_information">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                                <div class="row">
                                                    <div class="col-md-6 mt-2">
                                                  <div class="row">
                                                  <div class="col-md-6 col-6">
                                                    <label><?php echo translate('Name')?>:  </label>
                                                  </div>
                                                  <div class="col-md-6 col-6">
                                                       <span id="first_name_val"><?php echo $getUser->first_name?></span>
                                                  </div>
                                                </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                  <div class="row">
                                                  <div class="col-md-6 col-6">
                                                    <label><?php echo translate('email')?>: </label>
                                                  </div>
                                                  <div class="col-md-6 col-6">
                                                       <span id="email_val"><?php echo $getUser->email?></span>
                                                  </div>
                                                </div>
                                                        
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                  <div class="row">
                                                  <div class="col-md-6 col-6">
                                                    <label><?php echo translate('age')?>: </label>
                                                  </div>
                                                  <div class="col-md-6 col-6">
                                                      <span><?php echo $age?></span>
                                                  </div>
                                                </div>
                                                         
                                                    </div>
                                                    <div class="col-md-6 mt-2">
                                                  <div class="row">
                                                  <div class="col-md-6 col-6">
                                                    <label><?php echo translate('marital_status')?>:  </label>
                                                  </div>
                                                  <div class="col-md-6 col-6">
                                                      <span id="marital_status_val"><?php echo (!empty($basic_info_data[0]['marital_status'])) ? $basic_info_data[0]['marital_status'] : ""; ?></span>
                                                  </div>
                                                </div>
                                                         
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group__bottom--area mt-2" id="info_education">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                                <div class="row">
                                                    <div class="col-md-7 col-10">
                                                        <h6><span><?php echo translate('education_and_career')?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Type_of_study')?>: </label> 
                                                        </div>
                                                          <div class="col-md-6 col-6">
                                                            <span id="Type_of_study_val"><?php echo (!empty($education_and_career_data[0]['Type_of_study'])) ? dropdownTranslate($education_and_career_data[0]['Type_of_study']) : "";?></span>
                                                          </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                            <label><?php echo translate('Type_of_occupation')?>:  </label>
                                                        </div>
                                                          <div class="col-md-6 col-6">
                                                            <span id="Type_of_occupation_val"><?php echo (!empty($education_and_career_data[0]['Type_of_occupation'])) ? dropdownTranslate($education_and_career_data[0]['Type_of_occupation']) : "";?></span>
                                                          </div>
                                                      </div>
                                                             
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('STUDY_DETAILS')?>: </label> 
                                                        </div>
                                                          <div class="col-md-6 col-6">
                                                            <span id="STUDY_DETAILS_val"><?php echo (!empty($education_and_career_data[0]['STUDY_DETAILS'])) ? $education_and_career_data[0]['STUDY_DETAILS'] : "";?></span>
                                                          </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Career_Profile')?>:  </label>
                                                        </div>
                                                          <div class="col-md-6 col-6">
                                                            <span id="Career_Profile_val"><?php echo (!empty($education_and_career_data[0]['Career_Profile'])) ? $education_and_career_data[0]['Career_Profile'] : "";?></span>
                                                          </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Earnings')?>:  </label>
                                                        </div>
                                                          <div class="col-md-6 col-6">
                                                             <span id="Earnings_val"><?php echo (!empty($education_and_career_data[0]['Earnings'])) ? dropdownTranslate($education_and_career_data[0]['Earnings']) : "";?></span>
                                                          </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('annual_income')?>: </label> 
                                                        </div>
                                                          <div class="col-md-6 col-6">
                                                            <span id="annual_income_val"><?php echo (!empty($education_and_career_data[0]['annual_income'])) ? $education_and_career_data[0]['annual_income'] : "";?></span>
                                                          </div>
                                                      </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="group__bottom--area mt-2" id="info_physical_attributes">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                                <div class="row">
                                                    <div class="col-md-7 col-10">
                                                        <h6><span><?php echo translate('physical_attributes')?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('height')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="height_val"><?php echo (!empty($getUser->height)) ? $getUser->height : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('eye_color')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('hair_color')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="hair_color_val"><?php echo (!empty($physical_attributes_data[0]['hair_color'])) ? $physical_attributes_data[0]['hair_color'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('complexion')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="complexion_val"><?php echo (!empty($physical_attributes_data[0]['complexion'])) ? $physical_attributes_data[0]['complexion'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('blood_group')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="blood_group_val"><?php echo (!empty($physical_attributes_data[0]['blood_group'])) ? $physical_attributes_data[0]['blood_group'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('body_type')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="body_type_val"><?php echo (!empty($physical_attributes_data[0]['body_type'])) ? $physical_attributes_data[0]['body_type'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('body_art')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="body_art_val"><?php echo (!empty($physical_attributes_data[0]['body_art'])) ? $physical_attributes_data[0]['body_art'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('any_disability')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="any_disability_val"><?php echo (!empty($physical_attributes_data[0]['any_disability'])) ? $physical_attributes_data[0]['any_disability'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group__bottom--area mt-2" id="info_astronomic_information">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                                <div class="row">
                                                    <div class="col-md-7 col-10">
                                                        <h6><span><?php echo translate('astronomic_information')?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('date_of_birth')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="date_of_birth_val"><?php echo (!empty($astronomic_information_data[0]['date_of_birth'])) ? date('d-m-Y', strtotime($astronomic_information_data[0]['date_of_birth'])) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('birthDay')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="birthDay_val"><?php echo (!empty($astronomic_information_data[0]['birthDay'])) ? dropdownTranslate($astronomic_information_data[0]['birthDay']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('city_of_birth')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="city_of_birth_val"><?php echo (!empty($astronomic_information_data[0]['city_of_birth'])) ? $astronomic_information_data[0]['city_of_birth'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('time_of_birth')?>: </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="time_of_birth_val"><?php echo (!empty($astronomic_information_data[0]['time_of_birth'])) ? $astronomic_information_data[0]['time_of_birth'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('PAKSHA')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="PAKSHA_val"><?php echo (!empty($astronomic_information_data[0]['PAKSHA'])) ? dropdownTranslate($astronomic_information_data[0]['PAKSHA']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <?php if(!empty($astronomic_information_data[0]['PAKSHA'])){ if(dropdownTranslate($astronomic_information_data[0]['PAKSHA']) == dropdownTranslate("OTHERS"))  { ?> 
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Other_Paksha')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Other_Paksha_val"><?php echo (!empty($astronomic_information_data[0]['Other_Paksha'])) ? $astronomic_information_data[0]['Other_Paksha'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                        <?php } } ?>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('star')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="star_val"><?php echo (!empty($astronomic_information_data[0]['star'])) ? dropdownTranslate($astronomic_information_data[0]['star']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('PADAM')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="PADAM_val"><?php echo (!empty($astronomic_information_data[0]['PADAM'])) ? dropdownTranslate($astronomic_information_data[0]['PADAM']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('LAKKNAM')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="LAKKNAM_val"><?php echo (!empty($astronomic_information_data[0]['LAKKNAM'])) ? dropdownTranslate($astronomic_information_data[0]['LAKKNAM']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('HOROSCOPE_MATCHING')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="HOROSCOPE_MATCHING_val"><?php echo (!empty($astronomic_information_data[0]['HOROSCOPE_MATCHING'])) ? dropdownTranslate($astronomic_information_data[0]['HOROSCOPE_MATCHING']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('TITHI')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="TITHI_val"><?php echo (!empty($astronomic_information_data[0]['TITHI'])) ? dropdownTranslate($astronomic_information_data[0]['TITHI']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('DOSHAM')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="DOSHAM_val"><?php echo (!empty($astronomic_information_data[0]['DOSHAM'])) ? dropdownTranslate($astronomic_information_data[0]['DOSHAM']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('TYPE_OF_DOSHAM')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                           <span id="TYPE_OF_DOSHAM_val"><?php echo (!empty($astronomic_information_data[0]['TYPE_OF_DOSHAM'])) ? dropdownTranslate($astronomic_information_data[0]['TYPE_OF_DOSHAM']) : "";?></span> 
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Other_Dosham')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Other_Dosham_val"><?php echo (!empty($astronomic_information_data[0]['Other_Dosham'])) ? $astronomic_information_data[0]['Other_Dosham'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                            <label><?php echo translate('DIRECTIONAL_BALANCE')?>: </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="DIRECTIONAL_BALANCE_val"><?php echo (!empty($astronomic_information_data[0]['DIRECTIONAL_BALANCE'])) ? dropdownTranslate($astronomic_information_data[0]['DIRECTIONAL_BALANCE']) : "";?></span>
                                                        </div>
                                                      </div>
                                                            
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Year')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="Year_val"><?php echo (!empty($astronomic_information_data[0]['Year'])) ? $astronomic_information_data[0]['Year'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Month')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="Month_val"><?php echo (!empty($astronomic_information_data[0]['Month'])) ? $astronomic_information_data[0]['Month'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Day')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                          <span id="Day_val"><?php echo (!empty($astronomic_information_data[0]['Day'])) ? $astronomic_information_data[0]['Day'] : "";?></span>  
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('rashi')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="rashi_val"><?php echo (!empty($astronomic_information_data[0]['rashi'])) ? dropdownTranslate($astronomic_information_data[0]['rashi']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group__bottom--area mt-2" id="info_permanent_address">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                                <div class="row">
                                                    <div class="col-md-7 col-10">
                                                        <h6><span><?php echo translate('permanent_address')?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('country')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="permanent_country_val"><?php echo dropdownTranslate('India'); ?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('state')?>: </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                           <span id="permanent_state_val"><?php echo (!empty($permanent_address_data[0]['permanent_state'])) ? dropdownTranslate($permanent_address_data[0]['permanent_state']) : "";?></span> 
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                    <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('OTHERS')?>: </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="permanent_city_other_val"><?php echo (!empty($permanent_address_data[0]['permanent_city_other'])) ? $permanent_address_data[0]['permanent_city_other'] : "";?></span>
                                                        </div>
                                                      </div>
                                                      
                                                    </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('city')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="permanent_city_val"><?php echo (!empty($permanent_address_data[0]['permanent_city'])) ? dropdownTranslate($permanent_address_data[0]['permanent_city']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('postal-Code')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                           <span id="permanent_postal_val"><?php echo (!empty($permanent_address_data[0]['permanent_postal_code'])) ? $permanent_address_data[0]['permanent_postal_code'] : "";?></span> 
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('address')?>: </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="permanent_address_val"><?php echo (!empty($permanent_address_data[0]['address'])) ? $permanent_address_data[0]['address'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('mobile')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                           <span id="mobile_val"><?php echo (!empty($permanent_address_data[0]['mobile'])) ? $permanent_address_data[0]['mobile'] : "";?></span> 
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('alternate_number')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="alternate_number_val"><?php echo (!empty($permanent_address_data[0]['alternate_number'])) ? $permanent_address_data[0]['alternate_number'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('landline')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="landline_val"><?php echo (!empty($permanent_address_data[0]['landline'])) ? $permanent_address_data[0]['landline'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="group__bottom--area mt-2" id="info_family_information">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                                <div class="row">
                                                    <div class="col-md-7 col-10">
                                                        <h6><span><?php echo translate('family_information')?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Surname')?>: </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                              <span id="Surname_val"
                                                                ><?php echo (!empty($family_info_data[0]['Surname'])) ? $family_info_data[0]['Surname'] : "";?></span>
                                                        </div>
                                                      </div>
                                                            
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Soveran_Details')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Soveran_Details_val"><?php echo (!empty($family_info_data[0]['Soveran_Details'])) ? $family_info_data[0]['Soveran_Details'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('father')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="father_val"><?php echo (!empty($family_info_data[0]['father'])) ? $family_info_data[0]['father'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('mother')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="mother_val"><?php echo (!empty($family_info_data[0]['mother'])) ? $family_info_data[0]['mother'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('father_vangusam')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="father_vangusam_val"><?php echo (!empty($family_info_data[0]['father_vangusam'])) ? dropdownTranslate($family_info_data[0]['father_vangusam']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <?php if(!empty($family_info_data[0]['father_vangusam'])){ if(dropdownTranslate($family_info_data[0]['father_vangusam']) == dropdownTranslate("OTHERS")){ ?> 
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('other_vang')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="other_father_vang_val"><?php echo (!empty($family_info_data[0]['other_father_vang'])) ? $family_info_data[0]['other_father_vang'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                        <?php } } ?>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('mother_vangusam')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="mother_vangusam_val"><?php echo (!empty($family_info_data[0]['mother_vangusam'])) ? dropdownTranslate($family_info_data[0]['mother_vangusam']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <?php if(!empty($family_info_data[0]['mother_vangusam'])){ if(dropdownTranslate($family_info_data[0]['mother_vangusam']) == dropdownTranslate("OTHERS")){ ?> 
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('other_vang')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="other_mother_vang_val"><?php echo (!empty($family_info_data[0]['other_mother_vang'])) ? $family_info_data[0]['other_mother_vang'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                        <?php } } ?>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('family_type')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                           <span id="family_type_val"><?php echo (!empty($family_info_data[0]['family_type'])) ? dropdownTranslate($family_info_data[0]['family_type']) : "";?></span>  
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6 pr-3">
                                                          <label><?php echo translate('Number_of_brothers')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Number_of_brothers_val"><?php if(!empty($family_info_data[0]['Number_of_brothers'])){ 

                                                        if(is_numeric($family_info_data[0]['Number_of_brothers'])){
                                
                                                    echo $family_info_data[0]['Number_of_brothers'];
                                                }else { echo dropdownTranslate($family_info_data[0]['Number_of_brothers']); }}?></span>
                                                        </div>
                                                      </div>
                                                                
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6 pr-3">
                                                          <label><?php echo translate('Number_of_married_brothers')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="Number_of_married_brothers_val"><?php if(!empty($family_info_data[0]['Number_of_married_brothers'])){ 

                                                        if(is_numeric($family_info_data[0]['Number_of_married_brothers'])){
                                
                                                    echo $family_info_data[0]['Number_of_married_brothers'];
                                                }else { echo dropdownTranslate($family_info_data[0]['Number_of_married_brothers']); }}?></span>
                                                        </div>
                                                      </div>
                                                                
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6 pr-3">
                                                          <label><?php echo translate('Number_of_Sisters')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Number_of_Sisters_val"><?php if(!empty($family_info_data[0]['Number_of_Sisters'])){ 

                                                        if(is_numeric($family_info_data[0]['Number_of_Sisters'])){
                                
                                                    echo $family_info_data[0]['Number_of_Sisters'];
                                                }else { echo dropdownTranslate($family_info_data[0]['Number_of_Sisters']); }}?></span>
                                                        </div>
                                                      </div>
                                                                
                                                                 
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Number_of_married_sisters')?>: </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                             <span id="Number_of_married_sisters_val"><?php if(!empty($family_info_data[0]['Number_of_married_sisters'])){ 

                                                        if(is_numeric($family_info_data[0]['Number_of_married_sisters'])){
                                
                                                    echo $family_info_data[0]['Number_of_married_sisters'];
                                                }else { echo dropdownTranslate($family_info_data[0]['Number_of_married_sisters']); }}?></span>
                                                        </div>
                                                      </div>
                                                                
                                                                
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Property_Description')?>:  </label>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Property_Description_val"><?php echo (!empty($family_info_data[0]['Property_Description'])) ? dropdownTranslate($family_info_data[0]['Property_Description']) : "";?></span>
                                                        </div>
                                                      </div>
                                                                 
                                                            </div>
                                                            <?php if(!empty($family_info_data[0]['Property_Description'])){ if(dropdownTranslate($family_info_data[0]['Property_Description']) == dropdownTranslate("OTHERS")){ ?> 
                                                            <div class="col-md-6 mt-2">
                                                      <div class="row">
                                                        <div class="col-md-6 col-6">
                                                          <label><?php echo translate('Other_Property_Description')?>:  </label> 
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <span id="Other_property_description_val"><?php echo (!empty($family_info_data[0]['Other_property_description'])) ? $family_info_data[0]['Other_property_description'] : "";?></span>
                                                        </div>
                                                      </div>
                                                                
                                                            </div>
                                                        <?php } } ?>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="group__bottom--area mt-2" id="info_chart">
                                            <div class="group__bottom--group">
                                            <div class="activity__inner" style="padding:0px">
                                                <div class="row">
                                                    <div class="col-md-7 col-10">
                                                        <h6><span style="padding-left: 28px;"> <?php echo translate('chart')?></span></h6>
                                                    </div>
                                                </div>
                                                <div class="row" style="--bs-gutter-x: 0.5rem !important;">
                                                    <div class="col-md-12 col-12">
                                                     <div class="table-responsive mb-4">
                                                        <table class="table table-success table-bordered">
                                                            <?php
                                                            if(!empty($raasis)){
                                                                 foreach($raasis as $raasi){?>
                                                            <tbody>
                                                                <tr>
                                                                    <td  style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f010"><?php
                                                                    echo (!empty($raasi->f010))? dropdownTranslate($raasi->f010).'| ':"" ;?></span>
                                                                   <span id="f011"><?php echo (!empty($raasi->f011))? dropdownTranslate($raasi->f011).' | ':"" ;?></span>
                                                                    <span id="f012"><?php echo (!empty($raasi->f012))? dropdownTranslate($raasi->f012).' | ':"" ; ?></span><br><span id="f013"><?php
                                                                    echo (!empty($raasi->f013))? dropdownTranslate($raasi->f013).' | ':"" ;?></span>
                                                                    <span id="f014"><?php echo (!empty($raasi->f014))? dropdownTranslate($raasi->f014).' | ':"" ; ?></span>
                                                                    <span id="f015"><?php echo (!empty($raasi->f015))? dropdownTranslate($raasi->f015).' | ':"" ;
                                                                    ?> </span>
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f020"><?php
                                                                    echo (!empty($raasi->f020))? dropdownTranslate($raasi->f020).' | ':"" ;?></span>
                                                                    <span id="f021"><?php echo (!empty($raasi->f021))? dropdownTranslate($raasi->f021).' | ':"" ;?></span>
                                                                    <span id="f022"><?php echo (!empty($raasi->f022))? dropdownTranslate($raasi->f022).' | ':"" ; ?></span><br><span id="f023"><?php
                                                                    echo (!empty($raasi->f023))? dropdownTranslate($raasi->f023).' | ':"" ;?></span>
                                                                   <span id="f024"><?php echo (!empty($raasi->f024))? dropdownTranslate($raasi->f024).' | ':"" ;?></span>
                                                                   <span id="f025"><?php echo (!empty($raasi->f025))? dropdownTranslate($raasi->f025).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f030"><?php
                                                                    echo (!empty($raasi->f030))? dropdownTranslate($raasi->f030).' | ':"" ;?></span>
                                                                    <span id="f031"><?php echo (!empty($raasi->f031))? dropdownTranslate($raasi->f031).' | ':"" ;?></span>
                                                                    <span id="f032"><?php echo (!empty($raasi->f032))? dropdownTranslate($raasi->f032).' | ':"" ; ?></span><br><span id="f033"><?php
                                                                    echo (!empty($raasi->f033))? dropdownTranslate($raasi->f033).' | ':"" ;?></span>
                                                                   <span id="f034"><?php echo (!empty($raasi->f034))? dropdownTranslate($raasi->f034).' | ':"" ;?></span>
                                                                   <span id="f035"><?php echo (!empty($raasi->f035))? dropdownTranslate($raasi->f035).' | ':"" ;?></span>
                                                                    
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f040"> <?php
                                                                    echo (!empty($raasi->f040))? dropdownTranslate($raasi->f040).' | ':"" ;?></span>
                                                                   <span id="f041"><?php echo (!empty($raasi->f041))? dropdownTranslate($raasi->f041).' | ':"" ;?></span>
                                                                   <span id="f042"><?php echo (!empty($raasi->f042))? dropdownTranslate($raasi->f042).' | ':"" ; ?></span><br><span id="f043"><?php
                                                                    echo (!empty($raasi->f043))? dropdownTranslate($raasi->f043).' | ':"" ;?></span>
                                                                   <span id="f044"><?php echo (!empty($raasi->f044))? dropdownTranslate($raasi->f044).' | ':"" ;?></span>
                                                                   <span id="f045"><?php echo (!empty($raasi->f045))? dropdownTranslate($raasi->f045).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td id="value5" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f110"><?php
                                                                    echo (!empty($raasi->f110))? dropdownTranslate($raasi->f110).' | ':"" ;?>
                                                                   <span id="f111"><?php echo (!empty($raasi->f111))? dropdownTranslate($raasi->f111).' | ':"" ;?></span>
                                                                   <span id="f112"><?php echo (!empty($raasi->f112))? dropdownTranslate($raasi->f112).' | ':"" ; ?></span><br><span id="f113"><?php
                                                                    echo (!empty($raasi->f113))? dropdownTranslate($raasi->f113).' | ':"" ;?></span>
                                                                   <span id="f114"><?php echo (!empty($raasi->f114))? dropdownTranslate($raasi->f114).' | ':"" ;?></span>
                                                                    <span id="f115"><?php echo (!empty($raasi->f115))? dropdownTranslate($raasi->f115).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value6" colspan="2" rowspan="2" style="height:7em;width: 30%;font-size: 15px;text-align: center;background-color: #f3f3cb;padding-top: 10%;"><?php echo translate('ZODIAC');?>
                                                                    </td>
                                                                    <td id="value7" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f210"><?php
                                                                    echo (!empty($raasi->f210))? dropdownTranslate($raasi->f210).' | ':"" ;?>
                                                                    <span id="f211"><?php echo (!empty($raasi->f211))? dropdownTranslate($raasi->f211).' | ':"" ;?></span>
                                                                    <span id="f212"><?php echo (!empty($raasi->f212))? dropdownTranslate($raasi->f212).' | ':"" ; ?></span><br><span id="f213"><?php
                                                                    echo (!empty($raasi->f213))? dropdownTranslate($raasi->f213).' | ':"" ;?></span>
                                                                   <span id="f214"><?php echo (!empty($raasi->f214))? dropdownTranslate($raasi->f214).' | ':"" ;?></span>
                                                                   <span id="f215"><?php echo (!empty($raasi->f215))? dropdownTranslate($raasi->f215).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td id="value8" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f310"><?php
                                                                    echo (!empty($raasi->f310))? dropdownTranslate($raasi->f310).' | ':"" ;?></span>
                                                                   <span id="f311"><?php echo (!empty($raasi->f311))? dropdownTranslate($raasi->f311).' | ':"" ;?></span>
                                                                    <span id="f312"><?php echo (!empty($raasi->f312))? dropdownTranslate($raasi->f312).' | ':"" ; ?></span><br><span id="f313"><?php
                                                                    echo (!empty($raasi->f313))? dropdownTranslate($raasi->f313).' | ':"" ;?></span>
                                                                   <span id="f314"><?php echo (!empty($raasi->f314))? dropdownTranslate($raasi->f314).' | ':"" ;?></span>
                                                                   <span id="f315"><?php echo (!empty($raasi->f315))? dropdownTranslate($raasi->f315).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value9" colspan="2" style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f320"><?php
                                                                    echo (!empty($raasi->f320))? dropdownTranslate($raasi->f320).' | ':"" ;?></span>
                                                                   <span id="f321"><?php echo (!empty($raasi->f321))? dropdownTranslate($raasi->f321).' | ':"" ;?></span>
                                                                   <span id="f322"><?php echo (!empty($raasi->f322))? dropdownTranslate($raasi->f322).' | ':"" ; ?></span><br><span id="f323"><?php
                                                                    echo (!empty($raasi->f323))? dropdownTranslate($raasi->f323).' | ':"" ;?></span>
                                                                   <span id="f324"><?php echo (!empty($raasi->f324))? dropdownTranslate($raasi->f324).' | ':"" ;?></span>
                                                                    <span id="f325"><?php echo (!empty($raasi->f325))? dropdownTranslate($raasi->f325).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f410"><?php
                                                                    echo (!empty($raasi->f410))? dropdownTranslate($raasi->f410).' | ':"" ;?></span>
                                                                   <span id="f411"><?php echo (!empty($raasi->f411))? dropdownTranslate($raasi->f411).' | ':"" ;?></span>
                                                                   <span id="f412"><?php echo (!empty($raasi->f412))? dropdownTranslate($raasi->f412).' | ':"" ; ?></span><br><span id="f413"><?php
                                                                    echo (!empty($raasi->f413))? dropdownTranslate($raasi->f413).' | ':"" ;?></span>
                                                                   <span id="f414"><?php echo (!empty($raasi->f414))? dropdownTranslate($raasi->f414).' | ':"" ;?></span>
                                                                    <span id="f415"><?php echo (!empty($raasi->f415))? dropdownTranslate($raasi->f415).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value11" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f420"><?php
                                                                    echo (!empty($raasi->f420))? dropdownTranslate($raasi->f420).' | ':"" ;?></span>
                                                                   <span id="f421"><?php echo (!empty($raasi->f421))? dropdownTranslate($raasi->f421).' | ':"" ;?></span>
                                                                    <span id="f422"><?php echo (!empty($raasi->f422))? dropdownTranslate($raasi->f422).' | ':"" ; ?></span><br><span id="f423"><?php
                                                                    echo (!empty($raasi->f423))? dropdownTranslate($raasi->f423).' | ':"" ;?></span>
                                                                    <span id="f424"><?php echo (!empty($raasi->f424))? dropdownTranslate($raasi->f424).' | ':"" ;?></span>
                                                                   <span id="f425"><?php echo (!empty($raasi->f425))? dropdownTranslate($raasi->f425).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f430"><?php 
                                                                    echo (!empty($raasi->f430))? dropdownTranslate($raasi->f430).' | ':"" ;?></span>
                                                                    <span id="f431"><?php echo (!empty($raasi->f431))? dropdownTranslate($raasi->f431).' | ':"" ;?></span>
                                                                    <span id="f432"><?php echo (!empty($raasi->f432))? dropdownTranslate($raasi->f432).' | ':"" ; ?></span><br><span id="f433"><?php
                                                                    echo (!empty($raasi->f433))? dropdownTranslate($raasi->f433).' | ':"" ;?></span>
                                                                   <span id="f434"><?php  echo (!empty($raasi->f434))? dropdownTranslate($raasi->f434).' | ':"" ;?></span>
                                                                    <span id="f435"><?php echo (!empty($raasi->f435))? dropdownTranslate($raasi->f435).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f440"><?php
                                                                    echo (!empty($raasi->f440))? dropdownTranslate($raasi->f440).' | ':"" ;?></span>
                                                                   <span id="f440"><?php echo (!empty($raasi->f441))? dropdownTranslate($raasi->f441).' | ':"" ;?></span>
                                                                   <span id="f440"><?php echo (!empty($raasi->f442))? dropdownTranslate($raasi->f442).' | ':"" ; ?></span><br><span id="f440"><?php
                                                                    echo (!empty($raasi->f443))? dropdownTranslate($raasi->f443).' | ':"" ;?></span>
                                                                    <span id="f440"><?php echo (!empty($raasi->f444))? dropdownTranslate($raasi->f444).' | ':"" ;?></span>
                                                                   <span id="f440"><?php echo (!empty($raasi->f445))? dropdownTranslate($raasi->f445).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        <?php } } ?>
                                                        </table>
                                                    </div>
                                                    </div>

                                                    <div class="col-md-12 col-12">
                                                        <div class="table-responsive">
                                                        <table class="table table-success table-bordered table-nowrap align-middle mb-0">
                                                            <?php 
                                                            if(!empty($raasis)){
                                                                foreach($raasis as $raasi){?>
                                                            <tbody>
                                                                <tr>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f510"> <?php
                                                                    echo (!empty($raasi->f510))? dropdownTranslate($raasi->f510).' | ':"" ;?></span>
                                                                    <span id="f511"><?php echo (!empty($raasi->f511))? dropdownTranslate($raasi->f511).' | ':"" ;?></span>
                                                                   <span id="f512"><?php echo (!empty($raasi->f512))? dropdownTranslate($raasi->f512).' | ':"" ; ?></span><br><span id="f513"><?php
                                                                    echo (!empty($raasi->f513))? dropdownTranslate($raasi->f513).' | ':"" ;?></span>
                                                                   <span id="f514"><?php echo (!empty($raasi->f514))? dropdownTranslate($raasi->f514).' | ':"" ;?></span>
                                                                   <span id="f515"><?php echo (!empty($raasi->f515))? dropdownTranslate($raasi->f515).' | ':"" ;
                                                                    ?> </span>
                                                                    </td>
                                                                    <td id="value15" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f520"><?php
                                                                    echo (!empty($raasi->f520))? dropdownTranslate($raasi->f520).' | ':"" ;?></span>
                                                                   <span id="f521"><?php echo (!empty($raasi->f521))? dropdownTranslate($raasi->f521).' | ':"" ;?></span>
                                                                   <span id="f522"><?php echo (!empty($raasi->f522))? dropdownTranslate($raasi->f522).' | ':"" ; ?></span><br><span id="f523"><?php
                                                                    echo (!empty($raasi->f523))? dropdownTranslate($raasi->f523).' | ':"" ;?></span>
                                                                   <span id="f524"><?php echo (!empty($raasi->f524))? dropdownTranslate($raasi->f524).' | ':"" ;?></span>
                                                                   <span id="f525"><?php echo (!empty($raasi->f525))? dropdownTranslate($raasi->f525).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value16" style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f530"> <?php
                                                                    echo (!empty($raasi->f530))? dropdownTranslate($raasi->f530).' | ':"" ;?></span>
                                                                   <span id="f531"><?php echo (!empty($raasi->f531))? dropdownTranslate($raasi->f531).' | ':"" ;?></span>
                                                                   <span id="f532"><?php echo (!empty($raasi->f532))? dropdownTranslate($raasi->f532).' | ':"" ; ?></span><br><span id="f533"><?php
                                                                    echo (!empty($raasi->f533))? dropdownTranslate($raasi->f533).' | ':"" ;?></span>
                                                                   <span id="f534"><?php echo (!empty($raasi->f534))? dropdownTranslate($raasi->f534).' | ':"" ;?></span>
                                                                   <span id="f535"><?php echo (!empty($raasi->f535))? dropdownTranslate($raasi->f535).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f540"><?php
                                                                    echo (!empty($raasi->f540))? dropdownTranslate($raasi->f540).' | ':"" ;?></span>
                                                                    <span id="f541"><?php echo (!empty($raasi->f541))? dropdownTranslate($raasi->f541).' | ':"" ;?></span>
                                                                    <span id="f542"><?php echo (!empty($raasi->f542))? dropdownTranslate($raasi->f542).' | ':"" ; ?></span><br><span id="f543"><?php
                                                                    echo (!empty($raasi->f543))? dropdownTranslate($raasi->f543).' | ':"" ;?></span>
                                                                    <span id="f544"><?php echo (!empty($raasi->f544))? dropdownTranslate($raasi->f544).' | ':"" ;?></span>
                                                                   <span id="f545"><?php echo (!empty($raasi->f545))? dropdownTranslate($raasi->f545).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td id="value18" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f610"><?php 
                                                                    echo (!empty($raasi->f610))? dropdownTranslate($raasi->f610).' | ':"" ;?></span>
                                                                    <span id="f611"><?php echo (!empty($raasi->f611))? dropdownTranslate($raasi->f611).' | ':"" ;?></span>
                                                                    <span id="f612"><?php echo (!empty($raasi->f612))? dropdownTranslate($raasi->f612).' | ':"" ; ?></span><br><span id="f613"><?php
                                                                    echo (!empty($raasi->f613))? dropdownTranslate($raasi->f613).' | ':"" ;?></span>
                                                                    <span id="f614"><?php echo (!empty($raasi->f614))? dropdownTranslate($raasi->f614).' | ':"" ;?></span>
                                                                    <span id="f615"><?php echo (!empty($raasi->f615))? dropdownTranslate($raasi->f615).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value19" colspan="2" rowspan="2" style="text-align: center;height:7em;width: 30%;font-size: 15px; background-color: #f3f3cb;"><?php echo translate('FEATURE');?>
                                                                    </td>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f710"><?php
                                                                    echo (!empty($raasi->f710))? dropdownTranslate($raasi->f710).' | ':"" ;?></span>
                                                                    <span id="f711"><?php echo (!empty($raasi->f711))? dropdownTranslate($raasi->f711).' | ':"" ;?></span>
                                                                   <span id="f712"><?php echo (!empty($raasi->f712))? dropdownTranslate($raasi->f712).' | ':"" ; ?></span><br><span id="f713"><?php
                                                                    echo (!empty($raasi->f713))? dropdownTranslate($raasi->f713).' | ':"" ;?></span>
                                                                   <span id="f714"><?php echo (!empty($raasi->f714))? dropdownTranslate($raasi->f714).' | ':"" ;?></span>
                                                                   <span id="f715"><?php echo (!empty($raasi->f715))? dropdownTranslate($raasi->f715).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f810"><?php
                                                                    echo (!empty($raasi->f810))? dropdownTranslate($raasi->f810).' | ':"" ;?></span>
                                                                   <span id="f811"><?php echo (!empty($raasi->f811))? dropdownTranslate($raasi->f811).' | ':"" ;?></span><span id="f812"><?php
                                                                    echo (!empty($raasi->f812))? dropdownTranslate($raasi->f812).' | ':"" ; ?></span><br><span id="f813"><?php
                                                                    echo (!empty($raasi->f813))? dropdownTranslate($raasi->f813).' | ':"" ;?></span><span id="f814"><?php
                                                                    echo (!empty($raasi->f814))? dropdownTranslate($raasi->f814).' | ':"" ;?></span>
                                                                    <span id="f815"><?php echo (!empty($raasi->f815))? dropdownTranslate($raasi->f815).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value22" colspan="2" style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f820"><?php
                                                                    echo (!empty($raasi->f820))? dropdownTranslate($raasi->f820).' | ':"" ;?></span><span id="f821"><?php
                                                                    echo (!empty($raasi->f821))? dropdownTranslate($raasi->f821).' | ':"" ;?></span><span id="f822"><?php
                                                                    echo (!empty($raasi->f822))? dropdownTranslate($raasi->f822).' | ':"" ; ?></span><br><span id="f823"><?php
                                                                    echo (!empty($raasi->f823))? dropdownTranslate($raasi->f823).' | ':"" ;?></span><span id="f824"><?php
                                                                    echo (!empty($raasi->f824))? dropdownTranslate($raasi->f824).' | ':"" ;?></span><span id="f825"><?php
                                                                    echo (!empty($raasi->f825))? dropdownTranslate($raasi->f825).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    
                                                                </tr>
                                                                <tr>
                                                                    <td id="value23" style="height:7em;width: 10%;font-size: 15px">
                                                                   <span id="f910"><?php
                                                                    echo (!empty($raasi->f910))? dropdownTranslate($raasi->f910).' | ':"" ;?></span><span id="f911"><?php
                                                                    echo (!empty($raasi->f911))? dropdownTranslate($raasi->f911).' | ':"" ;?></span><span id="f912"><?php
                                                                    echo (!empty($raasi->f912))? dropdownTranslate($raasi->f912).' | ':"" ; ?></span><br><span id="f913"><?php
                                                                    echo (!empty($raasi->f913))? dropdownTranslate($raasi->f913).' | ':"" ;?></span><span id="f914"><?php
                                                                    echo (!empty($raasi->f914))? dropdownTranslate($raasi->f914).' | ':"" ;?></span><span id="f915"><?php
                                                                    echo (!empty($raasi->f915))? dropdownTranslate($raasi->f915).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value24" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f920"><?php
                                                                    echo (!empty($raasi->f920))? dropdownTranslate($raasi->f920).' | ':"" ;?></span><span id="f921"><?php
                                                                    echo (!empty($raasi->f921))? dropdownTranslate($raasi->f921).' | ':"" ;?></span><span id="f922"><?php
                                                                    echo (!empty($raasi->f922))? dropdownTranslate($raasi->f922).' | ':"" ; ?></span><br><span id="f923"><?php
                                                                    echo (!empty($raasi->f923))? dropdownTranslate($raasi->f923).' | ':"" ;?></span><span id="f924"><?php
                                                                    echo (!empty($raasi->f424))? dropdownTranslate($raasi->f424).' | ':"" ;?></span><span id="f925"><?php
                                                                    echo (!empty($raasi->f925))? dropdownTranslate($raasi->f925).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value25" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f930"><?php
                                                                    echo (!empty($raasi->f930))? dropdownTranslate($raasi->f930).' | ':"" ;?></span><span id="f931"><?php
                                                                    echo (!empty($raasi->f931))? dropdownTranslate($raasi->f931).' | ':"" ;?></span><span id="f932"><?php
                                                                    echo (!empty($raasi->f932))? dropdownTranslate($raasi->f932).' | ':"" ; ?></span><br><span id="f933"><?php
                                                                    echo (!empty($raasi->f933))? dropdownTranslate($raasi->f933).' | ':"" ;?></span><span id="f934"><?php
                                                                    echo (!empty($raasi->f934))? dropdownTranslate($raasi->f934).' | ':"" ;?></span><span id="f935"><?php
                                                                    echo (!empty($raasi->f935))? dropdownTranslate($raasi->f935).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                    <td id="value26" style="height:7em;width: 10%;font-size: 15px">
                                                                    <span id="f940"><?php
                                                                    echo (!empty($raasi->f940))? dropdownTranslate($raasi->f940).' | ':"" ;?></span><span id="f941"><?php
                                                                    echo (!empty($raasi->f941))? dropdownTranslate($raasi->f941).' | ':"" ;?></span><span id="f942"><?php
                                                                    echo (!empty($raasi->f942))? dropdownTranslate($raasi->f942).' | ':"" ; ?></span><br><span id="f943"><?php
                                                                    echo (!empty($raasi->f943))? dropdownTranslate($raasi->f943).' | ':"" ;?></span><span id="f944"><?php
                                                                    echo (!empty($raasi->f944))? dropdownTranslate($raasi->f944).' | ':"" ;?></span><span id="f945"><?php
                                                                    echo (!empty($raasi->f945))? dropdownTranslate($raasi->f945).' | ':"" ;
                                                                    ?></span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        <?php } } ?>
                                                        </table>
                                                    </div>

                                                    </div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            <?php } ?>
                                <div class="group__bottom--area mt-2" id="info_partner_expectation">
                                    <div class="group__bottom--group">
                                    <div class="activity__inner">
                                        <div class="row">
                                            <div class="col-md-7 col-7">
                                                <h6><span><?php echo translate('partner_expectation')?></span></h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-2">
                        <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('age')?>: </label>
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_age_val"><?php echo (!empty($partner_expectation_data[0]['partner_age'])) ? $partner_expectation_data[0]['partner_age'] : "";?></span>
                          </div>
                        </div>
                                 
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('height')?>:  </label> 
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_height_val"><?php echo (!empty($partner_expectation_data[0]['partner_height'])) ? $partner_expectation_data[0]['partner_height'] : "";?></span>
                          </div>
                        </div>
                                
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('weight')?>:  </label>
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_weight_val"><?php echo (!empty($partner_expectation_data[0]['partner_weight'])) ? $partner_expectation_data[0]['partner_weight'] : "";?></span>
                          </div>
                        </div>
                                 
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('any_disability')?>:  </label>
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_any_disability_val"><?php echo (!empty($partner_expectation_data[0]['partner_any_disability'])) ? $partner_expectation_data[0]['partner_any_disability'] : "";?></span>
                          </div>
                        </div>
                                 
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('marital_status')?>:  </label> 
                          </div>
                          <div class="col-md-6 col-6">
                             <span id="partner_marital_status_val"><?php echo (!empty($partner_expectation_data[0]['partner_marital_status'])) ? dropdownTranslate($partner_expectation_data[0]['partner_marital_status']) : "";?></span> 
                          </div>
                        </div>
                                
                            </div>
                            <?php if($partner_expectation_data[0]['partner_marital_status']!='Never Married'){?>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('with_children_acceptables')?>: </label>
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="with_children_acceptables_val"><?php echo (!empty($partner_expectation_data[0]['with_children_acceptables'])) ? get_type_name_by_id('decision', $partner_expectation_data[0]['with_children_acceptables']): "";?></span>
                          </div>
                        </div>
                                 
                            </div>
                        <?php } ?>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('education')?>: </label>
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_education_val"><?php echo (!empty($partner_expectation_data[0]['partner_education'])) ? $partner_expectation_data[0]['partner_education'] : "";?></span>
                          </div>
                        </div>
                                 
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('body_type')?>: </label> 
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_body_type_val"><?php echo (!empty($partner_expectation_data[0]['partner_body_type'])) ? $partner_expectation_data[0]['partner_body_type'] : "";?></span>
                          </div>
                        </div>
                                
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('profession')?>:  </label> 
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_profession_val"><?php echo (!empty($partner_expectation_data[0]['partner_profession'])) ? $partner_expectation_data[0]['partner_profession'] : "";?></span>
                          </div>
                        </div>
                                
                            </div>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('DOSHAM')?>:  </label> 
                          </div>
                          <div class="col-md-6 col-6">
                             <span id="partner_DOSHAM_val"><?php echo (!empty($partner_expectation_data[0]['partner_DOSHAM'])) ? dropdownTranslate($partner_expectation_data[0]['partner_DOSHAM']) : "";?></span> 
                          </div>
                        </div>
                                
                            </div>
                        <?php if($partner_expectation_data[0]['partner_DOSHAM']=='Yes'){?>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('TYPE_OF_DOSHAM')?>:  </label> 
                          </div>
                          <div class="col-md-6 col-6">
                            <span id="partner_TYPE_OF_DOSHAM_val"><?php echo (!empty($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM'])) ? dropdownTranslate($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM']) : "";?></span>  
                          </div>
                        </div>
                                
                            </div>
                        <?php }  if($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM']=='OTHERS'){?>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('Other_Dosham')?>:  </label>
                          </div>
                          <div class="col-md-6 col-6">
                            <span id="partner_Other_Dosham_val"><?php echo (!empty($partner_expectation_data[0]['partner_Other_Dosham'])) ? $partner_expectation_data[0]['partner_Other_Dosham'] : "";?></span>  
                          </div>
                        </div>
                                 
                            </div>
                      <?php } ?>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('Expectation')?>: </label> 
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_Expectation_val"><?php echo (isset($partner_expectation_data[0]['partner_Expectation']) && !empty($partner_expectation_data[0]['partner_Expectation'])) ? dropdownTranslate($partner_expectation_data[0]['partner_Expectation']) : "";?></span>
                          </div>
                        </div>
                                
                            </div>
                        <?php if(isset($partner_expectation_data[0]['partner_Expectation']) && $partner_expectation_data[0]['partner_Expectation']=='OTHERS'){?>
                            <div class="col-md-6 mt-2">
                          <div class="row">
                          <div class="col-md-6 col-6">
                            <label><?php echo translate('OTHERS')?>:  </label>
                          </div>
                          <div class="col-md-6 col-6">
                              <span id="partner_Other_Expectation_val"><?php echo (!empty($partner_expectation_data[0]['partner_Other_Expectation'])) ? $partner_expectation_data[0]['partner_Other_Expectation'] : "";?></span>
                          </div>
                        </div>
                                 
                            </div>
                      <?php } ?>
                                        </div>
                                    </div>
                                 </div>
                                </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</div>
</div>
<div id="edit_output"></div>
<script type="text/javascript">
function goto_profile(id,rem_download)
{
    var base_url=$('#base_url').val();
    console.log(rem_download);    
    if(rem_download == 0)
    {
       
      window.location.href = base_url+'full_view/'+id; 
    }else
    {
        $.ajax({
          type: 'POST',
          url: base_url+'WelcomeController/memberProfile/',
          data: '&m_id='+id+'&rem_download='+rem_download,
          success:function(html)
          {
            $('#edit_output').html(html);
            $('#myModal'+id).modal('show');
          }
        });
    }
   
}

function goto_profile_view(id) 
{
    window.location.href = "<?=base_url()?>full_view/"+id;            
}




</script>       

<div class="modal fade" id="interestModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 40%;width: 92% !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="interestModalLabel"><?php echo translate('express_interest')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?php echo translate('you_have_no_express_interests_left. please_buy_any_package_from_premium_plans.')?></p>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
        <a href="<?php echo base_url('app/Subscription');?>" type="button" class="btn btn-primary" id="reopen_btn"><?php echo translate('premium_plans')?></a> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 40%;width: 92% !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="interestModalLabel"><?php echo translate('buy_premium_packages');?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class='text-center'><b><?php echo translate('remaining_direct_message(s): ') ;?><?php echo $rem_message;?><?php echo translate('times');?></b><br><?php echo translate('please_buy_packages_from_the_premium_plans.');?></p>
        
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
        <a href="<?php echo base_url('Subscription');?>" type="button" class="btn btn-primary" id="reopen_btn"><?php echo translate('premium_plans')?></a> 
      </div>
    </div>
  </div>
</div>