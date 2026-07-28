<?php

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

if ($set_lang = $this->session->userdata('language')) {
 
 } else {
     $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
 }

?>
<style type="text/css">
table
{
   width: 30em!important;
}
td
{
   width: 25%!important;
   height: 5em!important;
   border: 1px solid black!important;
}
td select
{
   width: 48px!important;
   height: 50px!important;
}
.col-lg-5
{
   width: 50%!important;
   text-align: center;
   padding: 2px!important;
}


.action-icon {

   font-size: 20px;

   margin-bottom: 10px;

}



.text-pink {

   color: #ff00c8;

}



.premium-plan{

   display: block;

}

body{
  background-image: none;
  
}
.card .card-body {

    padding: 0px!important;
}
label
{
/*    width: 50%!important;*/
    margin-bottom: 0px;
    line-height: 1!important;

}
span
{
/*    width: 50%!important;*/
    line-height: 1!important;
    
}
.span
{
   font-size: 9px!important;
}
</style>

<?php $member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
    
    $getUser = getData('member','row',array('member_id'=>$member_id));
    $permanent_state = dropdownDatas('all_states','result');
    $profile_images = get_type_name_by_id('member', $getUser->member_id, 'profile_image');
   $profile_image = json_decode($profile_images, true);
   $basic_info = get_type_name_by_id('member',$getUser->member_id, 'basic_info');
   $basic_info_data = json_decode($basic_info, true);
   $age="";
   $astronomics = get_type_name_by_id('member',$getUser->member_id, 'astronomic_information');
   $astronomic_information_data = json_decode($astronomics, true);
   if(!empty($astronomic_information_data[0]['date_of_birth'])){
   $date1 = date('Y',strtotime(($astronomic_information_data[0]['date_of_birth']))); 
   $date2 = date("Y"); 
   $age= $date2-$date1;
   }

   $martial_status = get_dropdown(19);
   $Child_living_place = get_dropdown(15);
   $Type_of_study = get_dropdown(3);
   $Type_of_occupation = get_dropdown(4);
   $Earnings = get_dropdown(16);
   $PAKSHA = get_dropdown(6);
   $star = get_dropdown(7);
   $PADAM = get_dropdown(8);
   $LAKKNAM = get_dropdown(9);
   $HOROSCOPE_MATCHING = get_dropdown(10);
   $TITHI = get_dropdown(11);
   $DOSHAM = get_dropdown(12);
   $TYPE_OF_DOSHAM = get_dropdown(13);
   $DIRECTIONAL_BALANCE = get_dropdown(14);
   $Zodiac = get_dropdown(18);
   $permanent_city = get_dropdown(21);
   $getvangusam = get_dropdown(1);
   $getFamilyType = get_dropdown(2);
   $Property_Description = get_dropdown(5);
   $Soveran_Details = get_dropdown(17);
   $marital_status = get_dropdown(19);
   $DOSHAM1 = get_dropdown(12);
   $TYPE_OF_DOSHAM1 = get_dropdown(13);
   $Expectation = get_dropdown(26);
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
   $raasis = json_decode($getUser->chart);

   $flag = 0;
    $checkUpdateCompleteProfile = $getUser->updateProfileDoneStatus;
   
      $check_member_date =  strtotime($getUser->member_since_for_edit_profile);
       
       $newDate = date('Y-m-d',strtotime('+7 days',$check_member_date));
      
       if($newDate >= date('Y-m-d'))
       {
           $flag = 2;
       }
       else{
           $flag = 1;
       }

   if(!empty($raasis)){  
     foreach($raasis as $raasi)
    { 
        
        $rasi['f010'] = $raasi->f010;
        $rasi['f011'] = $raasi->f011;
        $rasi['f012'] = $raasi->f012;
        $rasi['f013'] = $raasi->f013;
        $rasi['f014'] = $raasi->f014;
        $rasi['f015'] = $raasi->f015; 

        $rasi['f020'] = $raasi->f020;
        $rasi['f021'] = $raasi->f021;
        $rasi['f022'] = $raasi->f022;
        $rasi['f023'] = $raasi->f023;
        $rasi['f024'] = $raasi->f024;
        $rasi['f025'] = $raasi->f025;

        $rasi['f030'] = $raasi->f030;
        $rasi['f031'] = $raasi->f031;
        $rasi['f032'] = $raasi->f032;
        $rasi['f033'] = $raasi->f033;
        $rasi['f034'] = $raasi->f034;
        $rasi['f035'] = $raasi->f035;

        $rasi['f040'] = $raasi->f040;
        $rasi['f041'] = $raasi->f041;
        $rasi['f042'] = $raasi->f042;
        $rasi['f043'] = $raasi->f043;
        $rasi['f044'] = $raasi->f044;
        $rasi['f045'] = $raasi->f045;

        $rasi['f110'] = $raasi->f110;
        $rasi['f111'] = $raasi->f111;
        $rasi['f112'] = $raasi->f112;
        $rasi['f113'] = $raasi->f113;
        $rasi['f114'] = $raasi->f114;
        $rasi['f115'] = $raasi->f115; 

        $rasi['f210'] = $raasi->f210;
        $rasi['f211'] = $raasi->f211;
        $rasi['f212'] = $raasi->f212;
        $rasi['f213'] = $raasi->f213;
        $rasi['f214'] = $raasi->f214;
        $rasi['f215'] = $raasi->f215;

        $rasi['f310'] = $raasi->f310;
        $rasi['f311'] = $raasi->f311;
        $rasi['f312'] = $raasi->f312;
        $rasi['f313'] = $raasi->f313;
        $rasi['f314'] = $raasi->f314;
        $rasi['f315'] = $raasi->f315;

        $rasi['f320'] = $raasi->f320;
        $rasi['f321'] = $raasi->f321;
        $rasi['f322'] = $raasi->f322;
        $rasi['f323'] = $raasi->f323;
        $rasi['f324'] = $raasi->f324;
        $rasi['f325'] = $raasi->f325; 

        $rasi['f410'] = $raasi->f410;
        $rasi['f411'] = $raasi->f411;
        $rasi['f412'] = $raasi->f412;
        $rasi['f413'] = $raasi->f413;
        $rasi['f414'] = $raasi->f414;
        $rasi['f415'] = $raasi->f415;  

        $rasi['f420'] = $raasi->f420;
        $rasi['f421'] = $raasi->f421;
        $rasi['f422'] = $raasi->f422;
        $rasi['f423'] = $raasi->f423;
        $rasi['f424'] = $raasi->f424;
        $rasi['f425'] = $raasi->f425;

        $rasi['f430'] = $raasi->f430;
        $rasi['f431'] = $raasi->f431;
        $rasi['f432'] = $raasi->f432;
        $rasi['f433'] = $raasi->f433;
        $rasi['f434'] = $raasi->f434;
        $rasi['f435'] = $raasi->f435;

        $rasi['f440'] = $raasi->f440;
        $rasi['f441'] = $raasi->f441;
        $rasi['f442'] = $raasi->f442;
        $rasi['f443'] = $raasi->f443;
        $rasi['f444'] = $raasi->f444;
        $rasi['f445'] = $raasi->f445;


         

        $rasi['f510'] = $raasi->f510;
        $rasi['f511'] = $raasi->f511;
        $rasi['f512'] = $raasi->f512;
        $rasi['f513'] = $raasi->f513;
        $rasi['f514'] = $raasi->f514;
        $rasi['f515'] = $raasi->f515; 

        $rasi['f520'] = $raasi->f520;
        $rasi['f521'] = $raasi->f521;
        $rasi['f522'] = $raasi->f522;
        $rasi['f523'] = $raasi->f523;
        $rasi['f524'] = $raasi->f524;
        $rasi['f525'] = $raasi->f525;

        $rasi['f530'] = $raasi->f530;
        $rasi['f531'] = $raasi->f531;
        $rasi['f532'] = $raasi->f532;
        $rasi['f533'] = $raasi->f533;
        $rasi['f534'] = $raasi->f534;
        $rasi['f535'] = $raasi->f535;

        $rasi['f540'] = $raasi->f540;
        $rasi['f541'] = $raasi->f541;
        $rasi['f542'] = $raasi->f542;
        $rasi['f543'] = $raasi->f543;
        $rasi['f544'] = $raasi->f544;
        $rasi['f545'] = $raasi->f545;

        $rasi['f610'] = $raasi->f610;
        $rasi['f611'] = $raasi->f611;
        $rasi['f612'] = $raasi->f612;
        $rasi['f613'] = $raasi->f613;
        $rasi['f614'] = $raasi->f614;
        $rasi['f615'] = $raasi->f615; 

        $rasi['f710'] = $raasi->f710;
        $rasi['f711'] = $raasi->f711;
        $rasi['f712'] = $raasi->f712;
        $rasi['f713'] = $raasi->f713;
        $rasi['f714'] = $raasi->f714;
        $rasi['f715'] = $raasi->f715;

        $rasi['f810'] = $raasi->f810;
        $rasi['f811'] = $raasi->f811;
        $rasi['f812'] = $raasi->f812;
        $rasi['f813'] = $raasi->f813;
        $rasi['f814'] = $raasi->f814;
        $rasi['f815'] = $raasi->f815;

        $rasi['f820'] = $raasi->f820;
        $rasi['f821'] = $raasi->f821;
        $rasi['f822'] = $raasi->f822;
        $rasi['f823'] = $raasi->f823;
        $rasi['f824'] = $raasi->f824;
        $rasi['f825'] = $raasi->f825; 

        $rasi['f910'] = $raasi->f910;
        $rasi['f911'] = $raasi->f911;
        $rasi['f912'] = $raasi->f912;
        $rasi['f913'] = $raasi->f913;
        $rasi['f914'] = $raasi->f914;
        $rasi['f915'] = $raasi->f915;  

        $rasi['f920'] = $raasi->f920;
        $rasi['f921'] = $raasi->f921;
        $rasi['f922'] = $raasi->f922;
        $rasi['f923'] = $raasi->f923;
        $rasi['f924'] = $raasi->f924;
        $rasi['f925'] = $raasi->f925;

        $rasi['f930'] = $raasi->f930;
        $rasi['f931'] = $raasi->f931;
        $rasi['f932'] = $raasi->f932;
        $rasi['f933'] = $raasi->f933;
        $rasi['f934'] = $raasi->f934;
        $rasi['f935'] = $raasi->f935;

        $rasi['f940'] = $raasi->f940;
        $rasi['f941'] = $raasi->f941;
        $rasi['f942'] = $raasi->f942;
        $rasi['f943'] = $raasi->f943;
        $rasi['f944'] = $raasi->f944;
        $rasi['f945'] = $raasi->f945;
    } }
   // print_r($flag);exit;
?>



<div class="page-content-wrapper">

   <!-- Profile Content Wrapper-->

   <!-- <div class="profile-content-wrapper">


      <div class="container" style="padding-left: 5px!important;">



         <div class="user-meta-data d-flex align-items-center">

            <div class="">

               

                   <?php if($getUser->gender==1){?>
                     <img src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>" alt="member-img" id="pimage_preview">
                   <?php } ?>
                   <?php if($getUser->gender==2){?>

                     <img src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>" alt="member-img" id="pimage_preview">
                   <?php } ?>

                  <form action="<?=base_url()?>AppController/updateProfileimage" method="POST" enctype="multipart/form-data" id="profile_image_form">
                       <input type='file' name='profile_image' id="profile_image" style="display: none;">
                   </form>

                  <div id="load_image_section">
                     <button type="button" onclick="document.getElementById('profile_image').click();" class="btn btn-sm btn-block btn-primary "><?php echo translate('edit');?></button>
                  </div>
                  <div id="save_button_section" style="display:none;">
                     <button type="button" id="save_image" class="btn btn-sm btn-block btn-primary "><?php echo translate('save');?></button>
                  </div> 


            </div>

            <div class="user-content" style="padding-left:5px">
               <h6><?php echo $getUser->first_name?></h6>

               <p></p>
               

               <p></p>

               <div class="user-meta-data d-flex align-items-center justify-content-between">

                  <p class="mx-1"><span class="counter"><?php echo $getUser->remain_download?></span><span class="span"><?php echo translate('package_informations')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->express_interest?></span><span class="span"><?php echo translate('remaining_interest')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->direct_messages?></span><span class="span"><?php echo translate('remaining_message')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->photo_gallery?></span><span class="span"><?php echo translate('photo_gallery')?></span></p>

               </div>

            </div>

         </div>

      </div>

   </div> -->

   <?php echo $this->session->flashdata('msg'); ?>

   <style type="text/css">

   .single-settings .title i {

      font-size: 20px;

      color: #797494;

      width: 20px;

      margin-right: 15px;

   }

   

   .single-settings .title {

      margin-bottom: 20px;

      /*vertical-align: top !important;*/

      align-items: start;

   }

   

   .settings-card {

      border-radius: 0px;

      background: #fff;

      border: none;

   }

   </style>



   <!-- Traffic Source-->

   <!-- <div class="editorial-choice-news-wrapper premium-plan">

    

      <div class="bg-shape1"><img src="<?php echo base_url('assets/app/')?>img/core-img/edito.png" alt=""></div>

      <div class="bg-shape2" style="background-image: url(<?php echo base_url('assets/app/')?>img/core-img/edito2.png)"></div>

      <div class="container">

         <div class="editorial-choice-title text-center mb-3"><i class="lni lni-protection"></i>

            <h6 class="newsten-title" style="line-height: 20px;">Premium members only able<br> To view contact details</h6> </div>

      </div>

      <div class="container text-center">

         <a href="<?php echo base_url('app/plans'); ?>" class="btn btn-sm btn-outline-warning rounded-pill">Buy Now</a>

      </div>

   </div> -->



   <div class="traffic-source-wrapper" >

      <div class="container">

         <div class="mb-3 d-flex align-items-center justify-content-between">

            <h6 class="newsten-title"><?php echo translate('introduction');?></h6>               

         </div>

         <div class="card settings-card">

            
            <!---/////edit start--->
          
             <form id="form_Introduction">
            <div class="card-body"  id="edit_introduction">

               <!-- Single Settings-->

               <div class="single-settings align-items-center justify-content-between">

                   <input type="hidden" name="member_id" id="member_id" value="<?php echo $getUser->member_id;?>">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('introduction');?></label><textarea name="introduction" id="introduction" class="form-control"><?php echo $getUser->introduction;?></textarea></div>
               </div>
                <?php if($checkUpdateCompleteProfile == 1){ ?>
                     <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Introduction')"><?php echo translate('update')?>
                  </button>
                               <?php } ?>
            </div>
              <!---/////edit end--->
           </form>
         </div>

      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>
   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="mb-3 d-flex align-items-center justify-content-between">

            <h6 class="newsten-title"><?php echo translate('basic_information')?></h6>               

         </div>

         <div class="card settings-card">

            

            <!---/////edit start--->
            <form id="form_BasicInfo">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>"> 
            <div class="card-body" id="info_basic_information">

               <div class="single-settings align-items-center justify-content-between">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('name');?></label><input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $getUser->first_name;?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('email');?></label><input type="email" name="email" id="email" class="form-control" value="<?php echo $getUser->email;?>"></div>
                  
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('martial_status');?></label><select class="form-control" name="marital_status" id="marital_status">
                  <option value=""><?php echo translate('choose_one'); ?></option>
                  <?php $i=0; foreach ($martial_status as  $value){ $i++;?>
                     <?php if(!empty($basic_info_data)){?>
                     <option data-id='<?php echo $i;?>' <?php if($basic_info_data[0]['marital_status'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($basic_info_data[0]['marital_status'])) echo "selected"; }?> value="<?php echo $value->word; ?>">
                         <?php echo dropdownTranslate($value->word); ?>
                     </option>
                 <?php }else{?>

                     <option value="<?php echo $value->word; ?>">
                         <?php echo dropdownTranslate($value->word); ?>

                     </option>
                  <?php } }?>
                  </select></div>

                  <div class="mb-3" style="display: none;" id="no_of_child"><label style="color: #797494;margin-right: 10px"><?php echo translate('number_of_children');?></label><input type="number" name="number_of_children" id="number_of_children" class="form-control" value="<?php echo (!empty($basic_info_data[0]['number_of_children'])) ? $basic_info_data[0]['number_of_children'] : "" ;?>"></div>

                  <div class="mb-3" style="display: none;" id="child_live_place"><label style="color: #797494;margin-right: 10px"><?php echo translate('Child_living_place');?></label><select class="form-control" name="Child_living_place" id="Child_living_place">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                     <?php foreach ($Child_living_place as  $value){ ?>
                        <?php if(isset($basic_info_data[0]['Child_living_place'])){?>
                        <option <?php if($basic_info_data[0]['Child_living_place'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($basic_info_data[0]['Child_living_place'])) echo "selected"; }?> value="<?php echo $value->word; ?>">
                            <?php echo dropdownTranslate($value->word); ?>
                        </option>
                    <?php }else{?>

                        <option value="<?php echo $value->word; ?>">
                            <?php echo dropdownTranslate($value->word); ?>

                        </option>
                     <?php } }?>
                  </select>
                  </div>                        

               </div>
               <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('BasicInfo')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>


            <!---/////edit end--->

         </div>

      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('education_and_career')?></h6> </div>

         <div class="card settings-card">

            

         <!---/////edit start--->
         <form id="form_Education">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>"> 
         <div class="card-body">

               <!-- Single Settings-->

               <div class="single-settings align-items-center justify-content-between">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Type_of_study');?></label>
                     <select class="form-control mt-2" name="Type_of_study" id="Type_of_study">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($Type_of_study)){ foreach ($Type_of_study as $value) {?>
                        <option data=<?php echo $value->word;?> <?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Type_of_study']))){ if($education_and_career_data[0]['Type_of_study'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($education_and_career_data[0]['Type_of_study'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?>
                        
                        </option>
                     <?php } }?>
                  </select></div>

                  <div class="mb-3" id="study_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('OTHERS');?></label><input type="text" class="form-control mt-2" name="other_study" id="other_study" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['other_study']))){echo $education_and_career_data[0]['other_study'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('STUDY_DETAILS');?></label><input type="text" class="form-control mt-2" name="STUDY_DETAILS" id="STUDY_DETAILS" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['STUDY_DETAILS']))){echo $education_and_career_data[0]['STUDY_DETAILS'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Type_of_occupation');?></label>
                     <select class="form-control mt-2" name="Type_of_occupation" id="Type_of_occupation">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($Type_of_occupation)){ foreach ($Type_of_occupation as $value) {?>
                        <option data="<?php echo $value->word;?>" <?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Type_of_occupation']))){ if($education_and_career_data[0]['Type_of_occupation'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($education_and_career_data[0]['Type_of_occupation'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>

                  <div class="mb-3" id="occupation_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('Other_Occupation_Details');?></label><input type="text" class="form-control mt-2" name="Other_Occupation_Details" id="Other_Occupation_Details" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Other_Occupation_Details']))){echo $education_and_career_data[0]['Other_Occupation_Details'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Career_Profile');?></label><input type="text" class="form-control mt-2" name="Career_Profile" id="Career_Profile" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Career_Profile']))){echo $education_and_career_data[0]['Career_Profile'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Earnings');?></label>
                     <select class="form-control mt-2" name="Earnings" id="Earnings">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($Earnings)){ foreach ($Earnings as $value) {?>
                        <option <?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Earnings']))){ if($education_and_career_data[0]['Earnings'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($education_and_career_data[0]['Earnings'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                  

                     <?php } }?>
                     </select>
                  </div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('annual_income');?></label><input type="text" class="form-control mt-2" name="annual_income" id="annual_income" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['annual_income']))){echo $education_and_career_data[0]['annual_income'];}?>">
                  </div>


            </div>
            <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Education')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
         </div>
      </form>

            <!---/////edit end--->
      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('physical_attributes')?></h6> </div>

         <div class="card settings-card">

            

            <!---/////edit start--->
            <form id="form_Physical">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
            <div class="card-body">

               <!-- Single Settings-->
               
               <div class="single-settings align-items-center justify-content-between">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('height');?></label><input type="text" class="form-control mt-2" name="height" id="height" value="<?php if(!empty($getUser->height)){echo $getUser->height;}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('weight');?></label><input type="text" class="form-control mt-2" name="weight" id="weight" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['weight']))){echo $physical_attributes_data[0]['weight'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('eye_color');?></label><input type="text" class="form-control mt-2" name="eye_color" id="eye_color" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['eye_color']))){echo $physical_attributes_data[0]['eye_color'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('hair_color');?></label><input type="text" class="form-control mt-2" name="hair_color" id="hair_color" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['hair_color']))){echo $physical_attributes_data[0]['hair_color'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('complexion');?></label><input type="text" class="form-control mt-2" name="complexion" id="complexion" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['complexion']))){echo $physical_attributes_data[0]['complexion'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('blood_group');?></label><input type="text" class="form-control mt-2" name="blood_group" id="blood_group" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['blood_group']))){echo $physical_attributes_data[0]['blood_group'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('body_type');?></label><input type="text" class="form-control mt-2" name="body_type" id="body_type" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['body_type']))){echo $physical_attributes_data[0]['body_type'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('body_art');?></label><input type="text" class="form-control mt-2" name="body_art" id="body_art"value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['body_art']))){echo $physical_attributes_data[0]['body_art'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('any_disability');?></label><input type="text" class="form-control mt-2" name="any_disability" id="any_disability" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['any_disability']))){echo $physical_attributes_data[0]['any_disability'];}?>"></div>

               </div>
               <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Physical')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>
            <!---/////edit end--->

         </div>

      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('astronomic_information')?></h6> </div>

         <div class="card settings-card">

           

            <!---/////edit start--->
            <form id="form_Astronomic">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
            <div class="card-body">

               <!-- Single Settings-->
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
               <div class="single-settings align-items-center justify-content-between">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('date_of_birth');?></label><input type="date" class="form-control mt-2" name="date_of_birth" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['date_of_birth']))){echo date('Y-m-d', strtotime($astronomic_information_data[0]['date_of_birth']));}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('birthDay');?></label><input type="text" class="form-control mt-2" name="birthDay" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['birthDay']))){echo dropdownTranslate($astronomic_information_data[0]['birthDay']);}?>" disabled></div>


                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('time_of_birth');?></label><input type="time" class="form-control mt-2" name="time_of_birth" id="time_of_birth" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['time_of_birth']))){echo $astronomic_information_data[0]['time_of_birth'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('city_of_birth');?></label><input type="text" class="form-control mt-2" name="city_of_birth" id="city_of_birth" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['city_of_birth']))){echo $astronomic_information_data[0]['city_of_birth'];}?>"></div>

                  

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('PAKSHA');?></label>
                     <select class="form-control mt-2" name="PAKSHA" id="paksha">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($PAKSHA)){ foreach ($PAKSHA as $value) {?>
                           <option data="<?php echo $value->word;?>" <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['PAKSHA']))){ if($astronomic_information_data[0]['PAKSHA'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['PAKSHA'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>

                  
                  <div class="mb-3" id="paksha_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('Other_Paksha');?></label><input type="text" class="form-control mt-2" name="Other_Paksha"id="Other_Paksha" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Other_Paksha']))){echo $astronomic_information_data[0]['Other_Paksha'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('star');?></label>
                     <select class="form-control mt-2" name="star" id="star">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($star)){ foreach ($star as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['star']))){ if($astronomic_information_data[0]['star'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['star'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('PADAM');?></label>
                     <select class="form-control mt-2" name="PADAM" id="PADAM">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($PADAM)){ foreach ($PADAM as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['PADAM']))){ if($astronomic_information_data[0]['PADAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['PADAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('LAKKNAM');?></label>
                     <select class="form-control mt-2" name="LAKKNAM" id="LAKKNAM">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($LAKKNAM)){ foreach ($LAKKNAM as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['LAKKNAM']))){ if($astronomic_information_data[0]['LAKKNAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['LAKKNAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('HOROSCOPE_MATCHING');?></label>
                     <select class="form-control mt-2" name="HOROSCOPE_MATCHING" id="HOROSCOPE_MATCHING">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($HOROSCOPE_MATCHING)){ foreach ($HOROSCOPE_MATCHING as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['HOROSCOPE_MATCHING']))){ if($astronomic_information_data[0]['HOROSCOPE_MATCHING'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['HOROSCOPE_MATCHING'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('TITHI');?></label>
                     <select class="form-control mt-2" name="TITHI" id="TITHI">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($TITHI)){ foreach ($TITHI as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['TITHI']))){ if($astronomic_information_data[0]['TITHI'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['TITHI'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('DOSHAM');?></label>
                     <select class="form-control mt-2" name="DOSHAM" id="dosham">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($DOSHAM)){ foreach ($DOSHAM as $value) {?>
                           <option data="<?php echo $value->word; ?>" <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['DOSHAM']))){ if($astronomic_information_data[0]['DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3" id="dosham_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('TYPE_OF_DOSHAM');?></label>
                     <select class="form-control mt-2" name="TYPE_OF_DOSHAM" id="TYPE_OF_DOSHAM">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($TYPE_OF_DOSHAM)){ foreach ($TYPE_OF_DOSHAM as $value) {?>
                           <option data="<?php echo $value->word;?>" data="<?php echo $value->word;?>" <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['TYPE_OF_DOSHAM']))){ if($astronomic_information_data[0]['TYPE_OF_DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['TYPE_OF_DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3" id="Other_Dosham" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('Other_Dosham');?></label><input type="text" class="form-control mt-2" name="Other_Dosham"value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Other_Dosham']))){echo $astronomic_information_data[0]['Other_Dosham'];}?>"></div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('DIRECTIONAL_BALANCE');?></label>
                     <select class="form-control mt-2" name="DIRECTIONAL_BALANCE" id="DIRECTIONAL_BALANCE">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($DIRECTIONAL_BALANCE)){ foreach ($DIRECTIONAL_BALANCE as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['DIRECTIONAL_BALANCE']))){ if($astronomic_information_data[0]['DIRECTIONAL_BALANCE'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['DIRECTIONAL_BALANCE'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Year');?></label>
                     <select class="form-control mt-2" name="Year" id="Year">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php for($i = 0; $i <=20; $i ++){?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Year']))){ if("$i" === ($astronomic_information_data[0]['Year'])){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                     

                        <?php } ?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Month');?></label>
                     <select class="form-control mt-2" name="Month" id="Month">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php for($i = 0; $i <=12; $i ++){?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Month']))){ if("$i" === ($astronomic_information_data[0]['Month'])){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                     

                        <?php } ?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Day');?></label>
                     <select class="form-control mt-2" name="Day" id="Day">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php for($i = 0; $i <=30; $i ++){?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Day']))){ if("$i" === ($astronomic_information_data[0]['Day'])){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                     

                        <?php } ?>
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('rashi');?></label>
                     <select class="form-control mt-2" name="rashi" id="rashi">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($Zodiac)){ foreach ($Zodiac as $value) {?>
                           <option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['rashi']))){ if($astronomic_information_data[0]['rashi'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['rashi'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>


               </div>
               <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Astronomic')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>

            <!---/////edit end--->
         </div>

      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('permanent_address')?></h6> </div>

         <div class="card settings-card">

            

            <!---/////edit start--->
            <form id="form_Permanent">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
            <div class="card-body" id="edit_permanent_address">

               <!-- Single Settings-->
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
               <div class="single-settings align-items-center justify-content-between">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('country');?></label><input type="text" class="form-control mt-2" name="permanent_country" id="permanent_country" value="<?php echo dropdownTranslate('India');?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('state');?></label>
                     <select class="form-control mt-2" name="permanent_state" id="permanent_states">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php 
                             $i=0; $state_id="";
                             if(!empty($permanent_state)){ foreach ($permanent_state as $value) { $i++;?>
                           <option  data-id="<?php echo $i;?>" <?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['permanent_state']))){ if((dropdownTranslate($value->word)) == dropdownTranslate($permanent_address_data[0]['permanent_state'])){ echo "selected"; } }?> value="<?php echo $value->word; ?>"><?php echo (($set_lang=="english") ? $value->english : $value->tamil); ?></option>
                     

                        <?php } }?>
                     </select></div>
                     <div class="mb-3" style="display:none" id="permanent_city_other"><label style="color: #797494;margin-right: 10px"><?php echo translate('OTHERS');?></label><input type="text" class="form-control mt-2" name="permanent_city_other" id="permanent_city_others" value="<?php echo (!empty($permanent_address_data[0]['permanent_city_other'])) ? $permanent_address_data[0]['permanent_city_other'] : " "; ?>"></div>
                     
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('city');?></label>
                     <select class="form-control mt-2" name="permanent_city" id="citys_ajax_output">
                  <!-- <option value=""><?php echo translate('choose_a_city_first'); ?></option> -->
                       <option <?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['permanent_city']))){ if($permanent_address_data[0]['permanent_city'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($permanent_address_data[0]['permanent_city'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
               </select>
                  </div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('postal-Code');?></label><input type="text" class="form-control mt-2" name="permanent_postal_code" id="permanent_postal_code" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['permanent_postal_code']))){echo $permanent_address_data[0]['permanent_postal_code'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('address');?></label><input type="text" class="form-control mt-2" name="address"id="address" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['address']))){echo $permanent_address_data[0]['address'];}?>"></div>


                  <input type="hidden" class="form-control mt-2" name="mobile" id="mobile" value="<?php if(!empty( $getUser->mobile)){echo $getUser->mobile;}?>">
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('alternate_number');?></label><input type="text" class="form-control mt-2" name="alternate_number" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['alternate_number']))){echo $permanent_address_data[0]['alternate_number'];}?>"></div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('landline');?></label><input type="text" class="form-control mt-2" name="landline" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['landline']))){echo $permanent_address_data[0]['landline'];}?>"></div>
                 

               </div>
               <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Permanent')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>

            <!---/////edit end--->

         </div>

      </div>

   </div>

<div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('family_information')?></h6> </div>

         <div class="card settings-card">

            

            <!---/////edit start--->
            <form id="form_Familyinformation">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
            <div class="card-body" id="edit_family_information" >

               <!-- Single Settings-->

               <div class="single-settings align-items-center justify-content-between">

                  <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Surname');?></label><input type="text" class="form-control mt-2" name="Surname" id="Surname" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['Surname']))){echo $family_info_data[0]['Surname'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Soveran_Details');?></label><input type="text" class="form-control mt-2" name="Soveran_Details" id="Soveran_Details" value="<?php if(!empty($getUser->soveran_detail)){echo $getUser->soveran_detail ;}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('father');?></label><input type="text" class="form-control mt-2" name="father" id="father" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['father']))){echo $family_info_data[0]['father'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('mother');?></label><input type="text" class="form-control mt-2" name="mother" id="mother" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['mother']))){echo $family_info_data[0]['mother'];}?>"></div>


                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('father_vangusam');?></label>
                     <select class="form-control mt-2" name="father_vangusam" id="father_vangusam">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($getvangusam)){ foreach ($getvangusam as $value) {?>
                           <option data="<?php echo $value->word;?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['father_vangusam']))){ if($family_info_data[0]['father_vangusam'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['father_vangusam'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>
                  <div class="mb-3" id="father_vangusam_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('other_vang');?></label><input type="text" class="form-control mt-2" name="other_father_vang" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['other_father_vang']))){echo $family_info_data[0]['other_father_vang'];}?>"></div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('mother_vangusam');?></label>
                     <select class="form-control mt-2" name="mother_vangusam" id="mother_vangusam">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($getvangusam)){ foreach ($getvangusam as $value) {?>
                           <option data="<?php echo $value->word;?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['mother_vangusam']))){ if($family_info_data[0]['mother_vangusam'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['mother_vangusam'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select></div>

                  <div class="mb-3" id="mother_vangusam_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('other_vang');?></label><input type="text" class="form-control mt-2" name="other_mother_vang" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['other_mother_vang']))){echo $family_info_data[0]['other_mother_vang'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('family_type');?></label>
                     <select class="form-control mt-2" name="family_type">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($getFamilyType)){ foreach ($getFamilyType as $value) {?>
                           <option <?php if(!empty($family_info_data && !empty( $family_info_data[0]['family_type']))){ if($family_info_data[0]['family_type'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['family_type'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select></div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Number_of_brothers');?></label>
                     <select class="form-control mt-2" name="Number_of_brothers" id="Number_of_brothers" onchange="brother()">
                        <option data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_brothers'])){ if($family_info_data[0]['Number_of_brothers'] == 'No') { echo "selected"; } } ?> value="No"><?php echo translate('no'); ?></option>
                        <?php for ($i=1; $i <= 10 ; $i++) { ?>
                           <option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_brothers']))){ if($i == $family_info_data[0]['Number_of_brothers']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                           <option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_brothers'])){ if($family_info_data[0]['Number_of_brothers'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                        
                     </select>
                  </div>
                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Number_of_married_brothers');?></label>
                     <option data="0" value=""><?php echo translate('choose_one'); ?></option>
                     <select class="form-control mt-2" name="Number_of_married_brothers" id="Number_of_married_brothers" onchange="brother()">
                        <option data="0" value=""><?php echo translate('choose_one'); ?></option>
                        <option <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_brothers'])){ if($family_info_data[0]['Number_of_married_brothers'] == 'No') { echo "selected"; } } ?> value="No"><?php echo translate('no'); ?></option>
                        <?php for ($i=1; $i <= 10 ; $i++) { ?>
                           <option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_married_brothers']))){ if($i == $family_info_data[0]['Number_of_married_brothers']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                           <option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_brothers'])){ if($family_info_data[0]['Number_of_married_brothers'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                        
                     </select>
                  </div>
                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Number_of_Sisters');?></label>
                  <select class="form-control mt-2" name="Number_of_Sisters" id="Number_of_Sisters" onchange="sister()">
                     <option data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_Sisters'])){ if($family_info_data[0]['Number_of_Sisters'] == 'No') { echo "selected"; } } ?> value="No"><?php echo translate('no'); ?></option>
                     <?php for ($i=1; $i <= 10 ; $i++) { ?>
                        <option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_Sisters']))){ if($i == $family_info_data[0]['Number_of_Sisters']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                     <?php } ?>
                        <option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_Sisters'])){ if($family_info_data[0]['Number_of_Sisters'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                     
                  </select>
                </div>

                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Number_of_married_sisters');?></label>
                  <select class="form-control mt-2" name="Number_of_married_sisters" id="Number_of_married_sisters" onchange="sister()">
                        <option data="0" value=""><?php echo translate('choose_one'); ?></option>
                        <option data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_sisters'])){ if($family_info_data[0]['Number_of_married_sisters'] == 'No') { echo "selected"; } } ?> value="No"><?php echo translate('no'); ?></option>
                        <?php for ($i=1; $i <= 10 ; $i++) { ?>
                           <option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_married_sisters']))){ if($i == $family_info_data[0]['Number_of_married_sisters']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php } ?>
                           <option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_sisters'])){ if($family_info_data[0]['Number_of_married_sisters'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                        
                     </select>
                </div>

                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Property_Description');?></label>
                  <select class="form-control mt-2" name="Property_Description" id="Property_Description">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                     <?php if(!empty($Property_Description)){ foreach ($Property_Description as $value) {?>
                        <option data="<?php echo $value->word;?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Property_Description']))){ if($family_info_data[0]['Property_Description'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['Property_Description'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                  

                     <?php } }?>
                  </select></div>
               
                <div class="mb-3" id="property_other" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('Other_Property_Description');?></label><input type="text" class="form-control mt-2" name="Other_property_description" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['Other_property_description']))){echo $family_info_data[0]['Other_property_description'];}?>"></div>
            
                 

               </div>
                <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Familyinformation')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>
            <!---/////edit end--->

         </div>

      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('partner_expectation')?></h6> </div>

         <div class="card settings-card">

            
            <!---/////edit start--->
            <form id="form_PartnerExpectation">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
            <div class="card-body">

               <!-- Single Settings-->
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
               <div class="single-settings align-items-center justify-content-between">

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('age');?></label><input type="text" class="form-control mt-2" name="partner_age" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_age']))){echo $partner_expectation_data[0]['partner_age'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('height');?></label><input type="text" class="form-control mt-2" name="partner_height" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_height']))){echo $partner_expectation_data[0]['partner_height'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('weight');?></label><input type="text" class="form-control mt-2" name="partner_weight" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_weight']))){echo $partner_expectation_data[0]['partner_weight'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('any_disability');?></label><input type="text" class="form-control mt-2" name="partner_any_disability" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_any_disability']))){echo $partner_expectation_data[0]['partner_any_disability'];}?>"></div>

                  <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('martial_status');?></label>
                     <select class="form-control mt-2" name="partner_marital_status" id="mar_status">
                        <option value=""><?php echo translate('choose_one'); ?></option>
                        <?php if(!empty($marital_status)){ 
                                $i=0;
                             foreach ($marital_status as $value) { $i++; ?>
                           <option data="<?php echo $i;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_marital_status']))){ if($partner_expectation_data[0]['partner_marital_status'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_marital_status'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                     

                        <?php } }?>
                     </select>
                  </div>

                  
                  <div class="mb-3" id="children_acceptables" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('with_children_acceptables');?></label>
                     <?php 
                                       
                        echo select_html('decision', 'with_children_acceptables', 'name', 'edit', 'form-control', $partner_expectation_data[0]['with_children_acceptables'], '', '', '');
                        
                        ?>
                  </div>
            
                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('education');?></label><input type="text" class="form-control mt-2" name="partner_education" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_education']))){echo $partner_expectation_data[0]['partner_education'];}?>"></div>
                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('body_type');?></label><input type="text" class="form-control mt-2" name="partner_body_type" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_body_type']))){echo $partner_expectation_data[0]['partner_body_type'];}?>"></div>
                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('profession');?></label><input type="text" class="form-control mt-2" name="partner_profession" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_profession']))){echo $partner_expectation_data[0]['partner_profession'];}?>"></div>
                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('DOSHAM');?></label>
                  <select class="form-control mt-2" name="partner_DOSHAM" id="partner_DOSHAM">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                     <?php if(!empty($DOSHAM1)){ foreach ($DOSHAM1 as $value) {?>
                        <option data="<?php echo $value->word;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_DOSHAM']))){ if($partner_expectation_data[0]['partner_DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                  

                     <?php } }?>
                  </select>
                </div>
                <div class="mb-3"  id="partner_TYPE_OF_DOSHAM" style="display:none;" ><label style="color: #797494;margin-right: 10px"><?php echo translate('TYPE_OF_DOSHAM');?></label>
                  <select class="form-control mt-2" name="partner_TYPE_OF_DOSHAM">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                     <?php if(!empty($TYPE_OF_DOSHAM1)){ foreach ($TYPE_OF_DOSHAM1 as $value) {?>
                        <option data="<?php echo $value->word;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_TYPE_OF_DOSHAM']))){ if($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                  

                     <?php } }?>
                  </select>
                </div>
                <div class="mb-3" id="partner_Other_Dosham" style="display:none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('Other_Dosham');?></label><input type="text" class="form-control mt-2" name="partner_Other_Dosham" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_Other_Dosham']))){echo $partner_expectation_data[0]['partner_Other_Dosham'];}?>"></div>
                <div class="mb-3"><label style="color: #797494;margin-right: 10px"><?php echo translate('Expectation');?></label>
                  <select class="form-control mt-2" name="partner_Expectation" id="partner_Expectation">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                     <?php if(!empty($Expectation)){ foreach ($Expectation as $value) {?>
                        <option data="<?php echo $value->word;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_Expectation']))){ if($partner_expectation_data[0]['partner_Expectation'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_Expectation'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                  

                     <?php } }?>
                  </select>
               </div>
                <div class="mb-3" id="partner_Other_Expectation" style="display: none;"><label style="color: #797494;margin-right: 10px"><?php echo translate('OTHERS');?></label><input type="text" class="form-control mt-2" name="partner_Other_Expectation" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_Other_Expectation']))){echo $partner_expectation_data[0]['partner_Other_Expectation'];}?>"></div>
                
                 

               </div>
               <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('PartnerExpectation')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>
            <!---/////edit end--->

         </div>

      </div>

   </div>



   <div class="container">

      <div class="border-top"></div>

   </div>

   <div class="traffic-source-wrapper" style="padding-bottom: 80px;">

      <div class="container">

         <div class="d-flex align-items-center justify-content-between">

            <h6 class="mb-3 newsten-title"><?php echo translate('chart')?></h6> </div>

         <div class="card settings-card">
            <form id="form_Chart">
               <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>"> 
            <div class="card-body" id="edit_chart">
                  
               <div class="row">
                  <div class="col-md-12">
                     <div class="table-responsive mb-4">
                         <table class="table table-success table-bordered table-nowrap align-middle mb-0">
                             <?php  if(!empty($raasis)) {
                                 foreach($raasis as $raasi){?>
                             <tbody>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                             <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f0<?php echo $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f0'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f1<?php echo $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f1'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                     <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;"><?php echo translate('ZODIAC');?>
                                    </td>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f2<?php echo $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f2'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 3; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f3<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f3'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f4<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f4'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 
                             </tbody>
                         <?php } } else {?>





                             <tbody>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                             <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f0<?php echo $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f1<?php echo $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                     <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;"><?php echo translate('ZODIAC');?>
                                    </td>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f2<?php echo $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 3; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f3<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f4<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 
                             </tbody>


                             <?php } ?>
                         </table>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="table-responsive mb-4">
                         <table class="table table-success table-bordered table-nowrap align-middle mb-0">
                             <?php 
                             if(!empty($raasis)) {
                                 foreach($raasis as $raasi){?>
                             <tbody>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                             <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f5<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f5'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f6<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f6'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                     <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;"><?php echo translate('FEATURE');?>
                                    </td>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f7<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f7'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 3; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f8<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f8'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f9<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option <?php echo ($rasi['f9'.$j.$i]==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 
                             </tbody>
                         <?php } } else {?>



                             <tbody>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                             <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f5<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f6<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                     <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;"><?php echo translate('FEATURE');?>
                                    </td>
                                 <?php for ($j=1; $j < 2; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f7<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 3; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f8<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 <tr>
                                 <?php for ($j=1; $j < 5; $j++) { ?>
                                     <td style="height:7em;width:25%;font-size: 15px">
                                         <div class="row">
                                         <?php for($i=0; $i < 6; $i++){?>
                                                 <div class="col-lg-5">
                                                 <select class="form-select mb-3" style="width: 60px;"name="f9<?php echo  $j.$i; ?>" aria-label="Default select example">
                                                 <option value=""><?php echo translate('choose_one');?></option>
                                                 <?php 
                                                 $drop_down = get_dropdown(24);
                                                 foreach($drop_down as $value){
                                                     ?>
                                                    
                                                 <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                             
                                                 <?php }?>
                                             </select>
                                             </div>
                                         <?php } ?>
                                         </div>
                                     
                                     </td>
                                     
                                 <?php } ?>
                                 </tr>
                                 
                             </tbody>


                             <?php } ?>
                         </table>
                     </div>
                     <?php if($checkUpdateCompleteProfile == 0){ ?>
                         <button type="button" onclick="save_All('All')" class="btn btn-sm float-right btn-info rounded-pill"><?php echo translate('update')?>
                         </button>
                     <?php } ?>
                  </div>
               </div>
                <?php if($checkUpdateCompleteProfile == 1){ ?>
                  <button type="button" class="btn btn-sm float-right btn-info rounded-pill"  onclick="update('Chart')"><?php echo translate('update')?>
                  </button>
               <?php } ?>
            </div>
         </form>
         </div>

      </div>

   </div>

   <div class="container">

      <div class="border-top"></div>

   </div>

  

   <div class="container">

      <div class="border-top"></div>

   </div>

</div>



<!-- Center Modal-->

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

   <div class="modal-dialog modal-dialog-centered" role="document">

      <div class="modal-content">

         <div class="modal-header">

            <h6 class="modal-title" id="exampleModalCenterTitle">Confirmation Alert</h6>

            <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

         </div>

         <div class="modal-body">

            <p>You have <?php echo $user_plan->count_available; ?> profile view counts. If you want to see this profile you will be deducted 1 from the count you have.</p>

         </div>

         <div class="modal-footer">

            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</button>

            <a class="btn btn-info btn-sm" href="<?php echo base_url('app/view_contact_details/'.$user->user_id); ?>">Confirm</a>            

         </div>

      </div>

   </div>

</div>





<script type="text/javascript">

   $(document).ready(function() {});   

</script>