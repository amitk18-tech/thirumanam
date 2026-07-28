<?php 

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

?>
    <div class="container mt-5" style="margin-top:100px !important">
      <p><?php echo $result_count;?></p>
    </div>
      <!-- Single News Post-->

<?php 
$member=$this->db->get_where('member',array('member_id'=>$this->session->userdata['thirumanam_applogged_data']['member_id']))->row();

// echo "<pre>";
// print_r($preference);
// echo "</pre>";

$aged_from=getPartnerExpectaions($member,'partner_age',1);
$aged_to=getPartnerExpectaions($member,'partner_age',2);
// $aged_to=(getPartnerExpectaions($member,'partner_age',2)!='') ? getPartnerExpectaions($member,'partner_age',2) : $aged_from+10;
$min_height='';
$max_height='';
$marital_status='';
$Type_of_study='';


 ?> 
      <?php foreach($results as $value) {


      $basic_info = get_type_name_by_id('member', $value->member_id, 'basic_info');
      $basic_info_data = json_decode($basic_info, true);

      $education_and_career = get_type_name_by_id('member', $value->member_id, 'education_and_career');
      $education_and_career_data = json_decode($education_and_career, true);

      $physical_attributes = get_type_name_by_id('member', $value->member_id, 'physical_attributes');
      $physical_attributes_data = json_decode($physical_attributes, true);

      $spiritual_and_social_background = get_type_name_by_id('member', $value->member_id, 'spiritual_and_social_background');
      $spiritual_and_social_background_data = json_decode($spiritual_and_social_background, true);

      $language = get_type_name_by_id('member', $value->member_id, 'language');
      $language_data = json_decode($language, true);

      $present_address = get_type_name_by_id('member', $value->member_id, 'present_address');
      $present_address_data = json_decode($present_address, true);
      $calculated_age = (date('Y') - date('Y', $value->date_of_birth));
      //issue one year extra
      // Declare and define two dates
      $date1 = $value->date_of_birth; 
      $date2 = strtotime(date("d-m-Y")); 
        
      // Formulate the Difference between two dates
      $diff = abs($date2 - $date1); 
        
        
      // To get the year divide the resultant date into
      // total seconds in a year (365*60*60*24)
      $years = floor($diff / (365*60*60*24)); 
        
        
      // To get the month, subtract it with years and
      // divide the resultant date into
      // total seconds in a month (30*60*60*24)
      $months = floor(($diff - $years * 365*60*60*24)
             / (30*60*60*24));
       $profile_images = get_type_name_by_id('member', $value->member_id, 'profile_image');
      $profile_image = json_decode($profile_images, true);
      // print_r($profile_image[0]['profile_image']);exit;
       ?>
       <div class="container mb-3">
      <div class="single-news-post d-flex align-items-center bg-gray">
        <div class="post-thumbnail">

          <a href="<?php echo base_url('app/short_view/'.$value->member_id);?>"><?php if($value->gender==1){?>
          <img style="border-radius:15%" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image']) && file_exists('uploads/profile_image/'.$profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
          <?php } ?>
          <?php if($value->gender==2){?>
          <img  style="border-radius:15%" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image']) && file_exists('uploads/profile_image/'.$profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
          <?php } ?></a>

        </div>
        <div class="post-content"><a href="<?php echo base_url('app/short_view/'.$value->member_id);?>"><?php echo $value->first_name;?> </a>
          <div class="post-meta d-flex align-items-center"><span class="text-danger"><?php echo translate('Member ID')?>: <?php echo $value->member_profile_id;?></span></div>
          <div class="row mt-3">
            <div class="col-md-6">
                <p><b><?php echo translate('age')?></b> : <?php echo $years;?></p>
                <?php if($education_and_career_data[0]['Type_of_occupation'] != "OTHERS"){ ?>
                <p><b><?php echo translate('Type_of_occupation')?></b> : <?=dropdownTranslate($education_and_career_data[0]['Type_of_occupation'])?></p>
            <?php } else {?>
                <p><b><?php echo translate('Type_of_occupation')?></b> : <?=dropdownTranslate($education_and_career_data[0]['Other_Occupation_Details'])?></p>
            <?php } ?>
            </div>
            <div class="col-md-6">
                <p><b><?php echo translate('marital_status')?></b> : <?=dropdownTranslate($basic_info_data[0]['marital_status'])?></p>
                <p><b><?php echo translate('STUDY_DETAILS')?></b> : <?=$education_and_career_data[0]['STUDY_DETAILS']?></p>
            </div>
        </div>

          <div class="row mt-3" style="margin-left: -95px;">
                  <div class="col-6 mt-2">
                      <a style="width:100%;font-size:10px;" href="<?php echo base_url('app/short_view/'.$value->member_id);?>" class="mb-1 btn btn-outline-success"><?php echo translate('full_profile')?></a>
                  </div>
                  <?php if($member->is_closed=='yes'){
                      echo "";}else{?>
                   <?php 


               
              if($member->membership!=1 && $member->updateProfileDoneStatus!=0){

              $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest');
              $interest = json_decode($interests, true);
              $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
              if (in_assoc_array($value->member_id, 'id', $interest)) {

                  echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" class="btn btn-xs btn-sm btn-outline-primary btn-border">'.translate('interest_expressed').'</button>
                  </div>';
              }else{

                  if($count_interest == 0){

                      echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" type="button" data-toggle="modal" data-target="#interestModal" class="btn btn-xs btn-sm btn-outline-primary btn-border">'.translate('express_interest').'</button>
                  </div>';
                  }else{

                     echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" onclick="doInterest('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1">'.translate('express_interest').'</button>

                  </div>';

                  } }
                  
              }else{
                  echo'<div class="col-6 mt-2">
                      <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1">'.translate('express_interest').'</a>
                  </div>';
              }?>
              <?php 
              if($member->membership!=1 && $member->updateProfileDoneStatus!=0){

              $shortlist = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'short_list');
              $shortlist = json_decode($shortlist, true);
              
              if (in_array($value->member_id, $shortlist)) {

                  echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" title="'.translate('remove_shortlist').'" onclick="remove_shortlist('.$value->member_id.')" class="btn btn-xs btn-sm btn-outline-dark btn-border mr-1">'.translate('shortlisted').'</button>
                  </div>';
              }else{

                  

                     echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" onclick="do_shortlist('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-dark btn-border mr-1">'.translate('shortlist').'</button>
                  </div>';

                  
                  
              } }else {
                  echo'<div class="col-6 mt-2">
                      <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-dark btn-border mr-1">'.translate('shortlist').'</a>
                  </div>';
              }?>

             
              <?php 
              if($member->membership!=1 && $member->updateProfileDoneStatus!=0){
              $followes = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'followed');
              $followed = json_decode($followes, true);
              
              if (in_array($value->member_id, $followed)) {

                  echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" onclick="do_unfollow('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-info btn-border mr-1">'.translate('unfollow').'</button>
                  </div>';
              }else{

                      echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" onclick="do_follow('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-info btn-border mr-1">'.translate('follow').'</button>
                  </div>';
                  
               }
              }else{
                      echo'<div class="col-6 mt-2">
                      <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-info btn-border mr-1">'.translate('follow').'</a>
                  </div>';
               }   
              ?>
                  <?php if($member->membership!=1 && $member->updateProfileDoneStatus!=0){?>
                  
                  <div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" onclick="confirm_ignore(<?php echo $value->member_id;?>)" class="btn btn-xs btn-sm btn-outline-danger btn-border mr-1"><?php echo translate('ignore')?></button>
                  <?php }else{ ?>
                      <div class="col-6 mt-2">
                      <a style="width:100%;font-size:10px;cursor:pointer;" href="<?php echo base_url('LoginController/verifyMember') ?>" class="btn btn-xs btn-sm btn-outline-danger btn-border mr-1"><?php echo translate('ignore')?></a>
                  <?php } ?>
                  </div>

                 

                  <?php if($member->member_type != 2 && $member->membership != 1 && $member->updateProfileDoneStatus!=0){
                      $report_profiles = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'report_profile');
                      $report_profile = json_decode($report_profiles, true);
                      
                      if (is_array($report_profile) && in_array($value->member_id, $report_profile)) {

                          echo'<div class="col-6 mt-2">
                              <button style="width:100%;font-size:10px;" type="button" data-toggle="modal" data-target="#reportModal" class="btn btn-xs btn-sm btn-outline-secondary btn-border">'.translate('profile_reported').'</button>
                          </div>';
                      }else{

                      echo'<div class="col-6 mt-2">
                      <button style="width:100%;font-size:10px;" onclick="add_report('.$value->member_id.')" class="btn btn-xs btn-sm btn-outline-secondary btn-border mr-1">'.translate('profile_report').'</button>
                  </div>';
                   } } else{
                      echo'<div class="col-6 mt-2">
                      <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/appverifyMember').'"  class="btn btn-xs btn-sm btn-outline-secondary btn-border mr-1">'.translate('profile_report').'</a>
                      </div>';
                   } ?>
                  
                  <?php } ?>
              </div>
          </div>
        </div>

      </div>

       </div>
    <?php } ?>



   
    <div class="container mb-4" style="margin-bottom:100px!important">
      <nav aria-label="Page navigation example">
          <?php echo $links;?>
      </nav>
    </div>
  </div>
</div>

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
        <a href="<?php echo base_url('Subscription');?>" type="button" class="btn btn-primary" id="reopen_btn"><?php echo translate('premium_plans')?></a> 
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 40%;width: 92% !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="interestModalLabel"><?php echo translate('report_profile')?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><span style='color:#DC0330;font-size:11px'>** <?php echo translate('you_already_reported_this_persion')?> **</span></p>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
         
      </div>
    </div>
  </div>
</div>
<div id="edit_output"></div>
    
<p id="shortlist"></p>