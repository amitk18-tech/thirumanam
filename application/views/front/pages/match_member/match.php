<?php 

// $pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ||  $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 
// if($pageRefreshed == 1){
//     $this->session->set_userdata('adv_search', array());
// }
$member=$this->db->get_where('member',array('member_id'=>$this->session->userdata['thirumanam_logged_data']['member_id']))->row();

// echo "<pre>";
// print_r($this->session->userdata('adv_search')['father_vangusam']);exit;
// echo "</pre>";

$aged_from=getPartnerExpectaions($member,'partner_age',1);
$aged_to=getPartnerExpectaions($member,'partner_age',2);
// $aged_to=(getPartnerExpectaions($member,'partner_age',2)!='') ? getPartnerExpectaions($member,'partner_age',2) : $aged_from+10;
$min_height='';
$max_height='';
$marital_status='';
$Type_of_study='';


 ?>
 <style>
     .multiselect-dropdown{
     width: 100% !important;
 }
     .banner__inputlist{
        border:none;
        width: 100%!important;
        padding-inline: 0px;
     }

     .banner__inputlist select {
    padding-inline: 10px;
}

 </style>
<div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
        <div class="container">
            <div class="pageheader__content text-center">
                <h2><?php echo translate('matched_members ')?></h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0" style="background-color:transparent!important">
                      <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?php echo translate('matched_members')?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- ================> Page Header section end here <================== -->
<!-- ================> Activity section start here <================== -->
	<div class="activity mt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="group__bottom--right">
                        <div class="modal-content border-0 mb-4">
                            <div class="card" style="border: none;padding: 10px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
                            <div class="card-header">
                                <h4 style="color: white;" class="modal-title" id="exampleModalLabel1"><?php echo translate('search');?></h4>
                            </div>
                            <div class="card-body">
                                <form id="my_form" action="<?php echo base_url('match_member_search');?>" method="post">
                                    <?php if (!empty($this->session->userdata['thirumanam_logged_data']['member_id'])) { ?>
                                      <div class="row"  style="display: none;">
                                         <div class="col-sm-12">
                                            <div class="form-group has-feedback">
                                               <label style="color:white;" for="" class="text-uppercase"><?php echo translate('looking_for')?></label>
                                               <div class="radio radio-primary">
                                                  <?php $member_gender = $this->db->get_where('member',array('member_id'=>$this->session->userdata['thirumanam_logged_data']['member_id']))->row()->gender; ?>
                                                  <?php if($member_gender == '2') { ?>
                                                  <input type="text" name="gender" id="groom" value="1">
                                                  <label style="color:white;" for="groom"><?=translate('groom')?></label>
                                                  <?php } elseif ($member_gender == '1') { ?>
                                                  <input type="text" name="gender" id="bride" value="2">
                                                  <label style="color:white;" for="bride" class="pr-3"><?=translate('bride')?></label>
                                                  <?php } ?>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <?php } else { ?>
                                      <div class="row" style="display: none;">
                                         <div class="col-sm-12">
                                            <div class="form-group has-feedback">
                                               <label style="color:white;" for="" class="text-uppercase"><?php echo translate('looking_for')?></label>
                                               <div class="radio radio-primary">
                                                  <input type="text" name="gender" id="bride" value="2" <?php if(!empty($home_gender==2)){ ?>checked<?php }?>>
                                                  <label style="color:white;" for="bride" class="pr-3"><?=translate('bride')?></label>
                                                  <input type="text" name="gender" id="groom" value="1" <?php if(!empty($home_gender==1)){ ?>checked<?php }?>>
                                                  <label style="color:white;" for="groom"><?=translate('groom')?></label>
                                               </div>
                                            </div>
                                         </div>
                                      </div>
                                      <?php } ?>
                                    <div class="banner__list">
                                        <div class="row align-items-center row-cols-1">
                                            
                                            <div class="col">
                                                <!-- <label style="color:white;">Age</label> -->
                                                <div class="row g-3">
                                                    <div class="col-6"> 
                                                        <label style="color:white;"><?php echo translate('age_from')?></label>
                                                        <div class="banner__inputlist">
                                                            <select name="aged_from" id="filter_aged_from">
                                                                <?php for ($i=18; $i < 51; $i++) { 
                                                                    $select = '';
                                                                    if(!empty($this->session->userdata('adv_search')['age_from'])){
                                                                    if($this->session->userdata('adv_search')['age_from'] == $i){
                                                                    $select = 'selected';
                                                                            }       
                                                                    }
                                                                    ?>
                                                            <option <?php echo $select;?> value="<?php echo $i ;?>"><?php echo $i;?></option>
                                                        <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <label style="color:white;"><?php echo translate('to')?></label>
                                                        <div class="banner__inputlist">
                                                            <select name="aged_to" id="filter_aged_to">
                                                                <?php for ($i=51; $i > 18; $i--) { 
                                                                    $select = '';
                                                                    if(!empty($this->session->userdata('adv_search')['age_to'])){
                                                                    if($this->session->userdata('adv_search')['age_to'] == $i){
                                                                    $select = 'selected';
                                                                            }       
                                                                    }
                                                            ?><option <?php echo $select;?> value="<?php echo $i?>"><?php echo $i;?></option>
                                                       <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('member_id')?></label>
                                                <div class="banner__inputlist">
                                                    <input  style="background-color: white;width: 100%;" type="text" name="member_id" id="filter_member_id" value="<?php echo (!empty($this->session->userdata('adv_search')['member_profile_id'])) ? $this->session->userdata('adv_search')['member_profile_id'] : '' ;?>">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('marital_status')?></label>
                                                <?php  
                                                $pref_marital=getPartnerExpectaions($member,'partner_marital_status',0);
                                                $marital_status1 = get_dropdown(19);
                                                // print_r($marital_status1);exit;
                                                   ?>
                                                <div class="banner__inputlist">
                                                   
                                                    <select name="marital_status" id="filter_marital_status">
                                                        <option value=""><?php echo translate('choose_one'); ?></option>
                                                          <?php foreach ($marital_status1 as $value) {
                                                            $select = '';

                                                            if(!empty($this->session->userdata('adv_search')['marital_status'])){
                                                            if($this->session->userdata('adv_search')['marital_status'] == $value->word){
                                                            $select = 'selected';
                                                                    }       
                                                            }
                                                             ?>
                                                          <option <?php echo $select;?> value="<?php echo $value->word; ?>">
                                                             <?php echo dropdownTranslate($value->word); ?>
                                                          </option>
                                                          <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('star')?><b>(<?=translate('multiple')?>)</b></label>
                                                <?php  
                                                
                                                $star1 = get_dropdown(7);
                                                // print_r($marital_status1);exit;
                                                   ?>
                                                <div class="banner__inputlist">
                                                    <select class="select2-control select text_field search_select select2" name="star[]" id="filter_star" multiple>
                                                        <option value=""><?php echo translate('choose_one')?></option>
                                                         <?php  foreach ($star1 as $key => $value) {
                                                             $select = '';
                                                            if(!empty($this->session->userdata('adv_search')['star'])){
                                                            if(in_array($value->word,$this->session->userdata('adv_search')['star'])){
                                                            $select = 'selected';
                                                                    }       
                                                            }
                                                             ?>
                                                        <option <?php echo $select;?>  value="<?php echo $value->word; ?>">
                                                         <?php echo dropdownTranslate($value->word); ?>
                                                      </option>
                                                      <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('dosham')?></label>
                                                <?php  
                                                
                                                $dosham1 = get_dropdown(13);
                                                // print_r($marital_status1);exit;
                                                   ?>
                                                <div class="banner__inputlist">
                                                    <select name="dosham" id="filter_dosham">
                                                         <option value=""><?php echo translate('choose_one'); ?></option>
                                                          <?php foreach ($dosham1 as $key => $value) {
                                                            $select = '';
                                                            if(!empty($this->session->userdata('adv_search')['dosham'])){
                                                            if($this->session->userdata('adv_search')['dosham'] == $value->word){
                                                            $select = 'selected';
                                                                    }       
                                                            }
                                                             ?>
                                                          <option <?php echo $select; ?> value="<?php echo $value->word; ?>">
                                                             <?php echo dropdownTranslate($value->word); ?>
                                                          </option>
                                                          <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('Soveran_Details')?></label>
                                                <div class="banner__inputlist">
                                                    <input style="background-color: white;width: 100%;" type="number" id="filter_Soveran_Details"   name="Soveran_Details" value="<?php echo (!empty($this->session->userdata('adv_search')['Soveran_Details'])) ? $this->session->userdata('adv_search')['Soveran_Details'] : '' ;?>">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('education')?></label>
                                                <?php  
                                                $pref_study=getPartnerExpectaions($member,'partner_education',0);
                                                $Type_of_study1 = get_dropdown(3);
                                                // print_r($marital_status1);exit;
                                                   ?>
                                                <div class="banner__inputlist">
                                                    <select name="Type_of_study" id="filter_Type_of_study">
                                                         <option value=""><?php echo translate('choose_one'); ?></option>
                                                          <?php foreach ($Type_of_study1 as $key => $value) {
                                                            $select = '';
                                                            if(!empty($this->session->userdata('adv_search')['Type_of_study'])){
                                                            if($this->session->userdata('adv_search')['Type_of_study'] == $value->word){
                                                            $select = 'selected';
                                                                    }       
                                                            }
                                                             ?>
                                                          <option <?php echo $select;?> value="<?php echo $value->word; ?>">
                                                             <?php echo dropdownTranslate($value->word); ?>
                                                          </option>
                                                          <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                           if ($this->db->get_where('frontend_settings', array('type' => 'education_and_career'))->row()->value == "yes") {
                                           ?>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('profession')?></label>
                                                <?php  
                                                
                                                $Type_of_occupation1 = get_dropdown(4);
                                                // print_r($marital_status1);exit;
                                                   ?>
                                                <div class="banner__inputlist">
                                                    <select name="Type_of_occupation" id="filter_Type_of_study">
                                                         <option value=""><?php echo translate('choose_one'); ?></option>
                                                        <?php foreach ($Type_of_occupation1 as $key => $value) {
                                                            $select = '';
                                                            if(!empty($this->session->userdata('adv_search')['occupation'])){
                                                            if($this->session->userdata('adv_search')['occupation'] == $value->word){
                                                            $select = 'selected';
                                                                    }       
                                                            }
                                                       ?>
                                                        <option <?php echo $select;?> value="<?php echo $value->word; ?>">
                                                       <?php echo dropdownTranslate($value->word); ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                                            <div class="col">
                                                <label style="color:white;"><?php echo translate('father_vangusam')?><b>(<?=translate('multiple')?>)</b></label>
                                                <?php  
                                                
                                                $father_vangusam1 = get_dropdown(1);
                                               // print_r($this->session->userdata('adv_search')['father_vangusam']);
                                                //exit;
                                                   ?>
                                                <div class="banner__inputlist" style="border:none;width: 100%;padding: 0;">
                                                    <select class="select2-control select text_field search_select select2" name="father_vangusam[]" id="filter_Type_of_study" multiple>
                                                        <option value=""><?php echo translate('choose_one')?></option>
                                                        <?php
                                                        $i=0;
                                                         foreach ($father_vangusam1 as $key => $value) {
                                                            $i++;
                                                            $select = '';
                                                            
                                                          
                                                            
                                                            ?>
                                                        <option <?php  


                                                            if(!empty($this->session->userdata('adv_search')['father_vangusam'])){
                                                                $vangusam = $this->session->userdata('adv_search')['father_vangusam'];

                                                                foreach($vangusam as $key=>$vang){
                                                               if($vang== $value->word){
                                                                   echo ' selected="selected" ';
                                                                    
                                                               }
                                                               }
                                                           }

                                                         ?>  value="<?php echo $value->word; ?>">
                                                           <?php 
                    
                                                           echo dropdownTranslate($value->word); ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                </div>
                                                <?php
                                             if ($this->db->get_where('frontend_settings', array('type' => 'physical_attributes'))->row()->value == "yes") {
                                             ?>
                                                <div class="col-lg-6 col-6">

                                                <label style="color:white;"><?php echo translate('min_height_(Feet)')?></label>
                                                <div class="banner__inputlist">
                                                     <input  style="background-color: white;width: 100%;" type="text" name="min_height" id="min_height" value="<?php echo (!empty($this->session->userdata('adv_search')['height_from'])) ? $this->session->userdata('adv_search')['height_from'] : '' ;?>">   
                                                </div>
                                                </div>
                                                <div class="col-lg-6 col-6">
                                                <label style="color:white;"><?php echo translate('max_height_(Feet)')?></label>
                                                <div class="banner__inputlist">
                                                     <input  style="background-color: white;width: 100%;" type="text" name="max_height" id="max_height"
                                                     value="<?php echo (!empty($this->session->userdata('adv_search')['height_to'])) ? $this->session->userdata('adv_search')['height_to'] : '' ;?>">   
                                                </div>

                                                </div>
                                                <div class="col-lg-12 col-12 mb-4">
                                                    <label style="color:white;">(<?php echo translate('example')?> : 150-160)</label>
                                                </div>
                                            <?php } ?>
                                            <div class="pt-0" style="display: none;">
                                                 <div class="card-title b-xs-bottom">
                                                    <h3 class="heading heading-sm text-uppercase"><?php echo translate('member_type')?></h3>
                                                 </div>
                                                 <div class="card-body">
                                                    <div class="filter-radio">
                                                       <div class="radio radio-primary">
                                                          <input type="radio" name="search_member_type" id="s_all_members" value="all">
                                                          <label style="color:white;" for="s_all_members"><?php echo translate('all_members')?></label>
                                                       </div>
                                                       <div class="radio radio-primary">
                                                          <input type="radio" name="search_member_type" id="s_premium_members" value="premium_members" checked>
                                                          <label style="color:white;" for="s_premium_members"><?php echo translate('premium_members')?></label>
                                                       </div>
                                                       <div class="radio radio-primary">
                                                          <input type="radio" name="search_member_type" id="s_free_members" value="free_members" >
                                                          <label style="color:white;" for="s_free_members"><?php echo translate('free_members')?></label>
                                                       </div>
                                                    </div>
                                                 </div>
                                              </div>
                                                <div class="col">
                                                <button type="submit" class="btn btn-info d-block w-100 search_load"><?php echo translate('search')?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                       
                        
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="group__bottom--area postList">
                        <div class="text-right" id="total1">
                            <h6><?php echo translate('members');?> : <span class="text-success" style="font-weight: lighter;"><?php echo $total_data;?></span></h6>
                        </div>
                        <div class="group__bottom--body bg-white p-0">
                            <div class="group__bottom--group">
                                <div class="row g-4 justify-content-center mx-12-none row-cols-1">
                                    <?php
                                    if(!empty($results)){
                                     foreach($results as $value) {
                                    


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

                                     ?>

                                    <div class="col">
                                        <div class="activity__item">
                                            <div class="activity__inner">
                                                <div class="">
                                                    <a href="<?php echo base_url('short_view/'.$value->member_id);?>"><?php if($value->gender==1){?>
                            <img style="height: 100px;width: 100%;" alt="dating thumb" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image']) && file_exists('uploads/profile_image/'.$profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                            <?php } ?>
                            <?php if($value->gender==2){?>
                            <img style="height: 100px;width: 100%;" alt="dating thumb" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image']) && file_exists('uploads/profile_image/'.$profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                            <?php } ?></a>
                                                </div>
                                                <div class="activity__content" style="width: 80%;">
                                                    <h5><a href="<?php echo base_url('short_view/'.$value->member_id);?>"><?php echo ((strlen( $value->first_name)>45)) ? substr($value->first_name,0,45).'...': $value->first_name; ?></a><span class="text-danger"><?php echo translate('Member ID')?>:


                                                        <?php 
                                                    if($value->membership == 1 && $value->member_type == 1)
                                                    {

                                                    }
                                                    else
                                                    {
                                                        if(substr($value->member_profile_id,0,1) == 'M')
                                                        {
                                                            $one = substr($value->member_profile_id,0,4);
                                                            $trasOne = translate($one);
                                                            $two = substr($value->member_profile_id,4);
                                                            echo $trasOne.$two;
                                                        }
                                                        elseif(substr($value->member_profile_id,0,1) == 'F')
                                                        {
                                                            $one = substr($value->member_profile_id,0,6);
                                                            $trasOne = translate($one);
                                                            $two = substr($value->member_profile_id,6);
                                                            echo $trasOne.$two;
                                                        }
                                                        elseif($value->member_profile_id=='')
                                                        {
                                                            echo translate('temporary');
                                                        }
                                                        else {
                                                        echo $value->member_profile_id;
                                                        } 
                                                    } 
                                                    ?> </span></h5>
                                                    
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <p><b><?php echo translate('age')?></b> : <?php echo $years;?></p>
                                                        </div>
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <?php if($education_and_career_data[0]['Type_of_occupation'] != "OTHERS"){ ?>
                                                            <p><b><?php echo translate('Type_of_occupation')?></b> : <?=dropdownTranslate($education_and_career_data[0]['Type_of_occupation'])?></p>
                                                        <?php } else {?>
                                                            <p><b><?php echo translate('Type_of_occupation')?></b> : <?=dropdownTranslate($education_and_career_data[0]['Other_Occupation_Details'])?></p>
                                                        <?php } ?>
                                                        </div>
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <p><b><?php echo translate('marital_status')?></b> : <?=dropdownTranslate($basic_info_data[0]['marital_status'])?></p>
                                                        </div>
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <p><b><?php echo translate('STUDY_DETAILS')?></b> : <?=$education_and_career_data[0]['STUDY_DETAILS']?></p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-2 mt-2">
                                                        <a target="_blank" style="width:100%;font-size:10px;" href="<?php echo base_url('short_view/'.$value->member_id);?>" class="btn btn-xs btn-sm btn-outline-success btn-border mr-1"><?php echo translate('full_profile')?></a>
                                                    </div>
                                                    <?php if($member->is_closed=='yes'){
                                                        echo "";}else{?>
                                                     <?php 


                                                 
                                                if($member->membership!=1 && $member->updateProfileDoneStatus!=0){

                                                $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'interest');
                                                $interest = json_decode($interests, true);
                                                $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'express_interest');
                                                if (in_assoc_array($value->member_id, 'id', $interest)) {

                                                    echo'<div class="col-md-2 mt-2">
                                                        <button style="padding:3px;width:100%;font-size:10px;" class="btn btn-xs btn-sm btn-outline-primary btn-border">'.translate('interest_expressed').'</button>
                                                    </div>';
                                                }else{

                                                    if($count_interest == 0){

                                                        echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" type="button" data-toggle="modal" data-target="#interestModal" class="btn btn-xs btn-sm btn-outline-primary btn-border">'.translate('express_interest').'</button>
                                                    </div>';
                                                    }else{

                                                       echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" onclick="doInterest('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1">'.translate('express_interest').'</button>

                                                    </div>';

                                                    } }
                                                    
                                                }else{
                                                    echo'<div class="col-md-2 mt-2">
                                                        <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1">'.translate('express_interest').'</a>
                                                    </div>';
                                                }?>
                                                <?php 
                                                if($member->membership!=1 && $member->updateProfileDoneStatus!=0){

                                                $shortlist = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'short_list');
                                                $shortlist = json_decode($shortlist, true);
                                                
                                                if (in_array($value->member_id, $shortlist)) {

                                                    echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" title="'.translate('remove_shortlist').'" onclick="remove_shortlist('.$value->member_id.')" class="btn btn-xs btn-sm btn-outline-dark btn-border mr-1">'.translate('shortlisted').'</button>
                                                    </div>';
                                                }else{

                                                    

                                                       echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" onclick="do_shortlist('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-dark btn-border mr-1">'.translate('shortlist').'</button>
                                                    </div>';

                                                    
                                                    
                                                } }else {
                                                    echo'<div class="col-md-2 mt-2">
                                                        <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-dark btn-border mr-1">'.translate('shortlist').'</a>
                                                    </div>';
                                                }?>

                                               
                                                <?php 
                                                if($member->membership!=1 && $member->updateProfileDoneStatus!=0){
                                                $followes = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'followed');
                                                $followed = json_decode($followes, true);
                                                
                                                if (in_array($value->member_id, $followed)) {

                                                    echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" onclick="do_unfollow('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-info btn-border mr-1">'.translate('unfollow').'</button>
                                                    </div>';
                                                }else{

                                                        echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" onclick="do_follow('.$value->member_id.')"  class="btn btn-xs btn-sm btn-outline-info btn-border mr-1">'.translate('follow').'</button>
                                                    </div>';
                                                    
                                                 }
                                                }else{
                                                        echo'<div class="col-md-2 mt-2">
                                                        <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-info btn-border mr-1">'.translate('follow').'</a>
                                                    </div>';
                                                 }   
                                                ?>
                                                    <?php if($member->membership!=1 && $member->updateProfileDoneStatus!=0){?>
                                                    
                                                    <div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" onclick="confirm_ignore(<?php echo $value->member_id;?>)" class="btn btn-xs btn-sm btn-outline-danger btn-border mr-1"><?php echo translate('ignore')?></button>
                                                    <?php }else{ ?>
                                                        <div class="col-md-2 mt-2">
                                                        <a style="width:100%;font-size:10px;cursor:pointer;" href="<?php echo base_url('LoginController/verifyMember') ?>" class="btn btn-xs btn-sm btn-outline-danger btn-border mr-1"><?php echo translate('ignore')?></a>
                                                    <?php } ?>
                                                    </div>

                                                   

                                                    <?php if($member->member_type != 2 && $member->membership != 1 && $member->updateProfileDoneStatus!=0){
                                                        $report_profiles = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'report_profile');
                                                        if(!empty($report_profiles)){
                                                            $report_profile = json_decode($report_profiles, true);
                                                        }else{

                                                            $report_profile = "";
                                                        }
                                                        
                                                        
                                                        if (is_array($report_profile) && in_array($value->member_id, $report_profile)) {

                                                            echo'<div class="col-md-2 mt-2">
                                                                <button style="width:100%;font-size:10px;" type="button" data-toggle="modal" data-target="#reportModal" class="btn btn-xs btn-sm btn-outline-secondary btn-border">'.translate('profile_reported').'</button>
                                                            </div>';
                                                        }else{

                                                        echo'<div class="col-md-2 mt-2">
                                                        <button style="width:100%;font-size:10px;" onclick="add_report('.$value->member_id.')" class="btn btn-xs btn-sm btn-outline-secondary btn-border mr-1">'.translate('profile_report').'</button>
                                                    </div>';
                                                     } } else{
                                                        echo'<div class="col-md-2 mt-2">
                                                        <a style="width:100%;font-size:10px;cursor:pointer" href="'.base_url('LoginController/verifyMember').'"  class="btn btn-xs btn-sm btn-outline-secondary btn-border mr-1">'.translate('profile_report').'</a>
                                                        </div>';
                                                     } ?>
                                                    
                                                    <?php } ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>

                              
                            </div>
                                <div class="show_more_main text-center mt-4 mb-5" id="show_more_main<?php echo $value->member_id; ?>">
                                    <input type="hidden" id="member_id" value="<?php echo $value->member_id; ?>">
                                    <!-- <button  id="<?php echo $value->member_id; ?>" class="default-btn show_more" title="Load more posts"><?php echo translate('show_more')?></button> -->
                                    <input type="hidden" id="total_data" value="<?php echo $total_data;?>">
                                </div>
                                <div class="text-center">
                                    <span class="loding" style="display: none;"><span class="loding_txt"><?php echo translate('loading')?>...</span></span>
                                </div>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>

                    <p class="text-center"><?php echo translate('update_matched_profiles')?></p>

                <?php } ?>
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

<script src="<?php echo base_url('assets/front/') ?>js/multiselect-dropdown.js"></script>   
                        <!-- Loads List Data with Ajax Pagination -->

    <!-- ================> Activity section end here <================== -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
// $(document).ready(function(){

//     $(window).scroll(function() {
//     if($(window).scrollTop() == $(document).height() - $(window).height() || $("html, body").animate({ scrollTop: $(".postList")}, 1000);) {
//         var ID = $('#member_id').val();
//         var base_url=$('#base_url').val();
//         var total_data = $('#total_data').val();
//         $('#show_more_main'+ID).remove();
        
//         console.log(total_data);
//         if(total_data>5){
//         $('.loding').show();
//         }
//         $.ajax({
//             type:'POST',
//             url: base_url+"WelcomeController/active",
//             data:'id='+ID,
//             success:function(html){
//                 $('.loding').hide();
                
//                 $('.postList').append(html);
//             }
//         });
//     }
//     });

$(document).ready(function(){
    $('body').on('touchmove', onScroll);
    $(window).on('scroll', onScroll);
    function onScroll(){
        // alert('kkk');
        var base_url=$('#base_url').val();
        var total_data = $('#total_data').val();
        var lastID = $('#member_id').val();
        // alert(lastID);
        if ($(window).scrollTop() >  $(document).height() - $(window).height() - 100 && (lastID != 0)) {
             
           $('#show_more_main'+lastID).remove();
           // alert(lastID);
            $.ajax({
                type:'POST',
                url: base_url+"WelcomeController/match",
                data:'id='+lastID,
                beforeSend:function(){
                    $('.loding').show();
                },
                success:function(html){
                    // console.log(html);
                    // $('.load-more').remove();
                    
                    $('.loding').hide();
                    $('.postList').append(html);
                }
            });
        }
    };
});

    // $(document).on('click','.show_more',function(){
    //     var ID = $(this).attr('id');
    //     var base_url=$('#base_url').val();
    //     console.log(ID);
    //     $('.show_more').hide();
    //     $('.loding').show();
    //     $.ajax({
    //         type:'POST',
    //         url: base_url+"WelcomeController/active",
    //         data:'id='+ID,
    //         success:function(html){
    //             $('#show_more_main'+ID).remove();
    //             $('.postList').append(html);
    //         }
    //     });
    // });



</script>


