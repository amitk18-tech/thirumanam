  <?php $member_id = $this->session->userdata['thirumanam_logged_data']['member_id'];
    
    $getUser = getData('member','row',array('member_id'=>$member_id));
    // print_r($getUser);exit;
    $permanent_state = dropdownDatas('all_states','result');
    // print_r($getUser);exit;
     
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

    $expiry = date("Y-m-d", strtotime("+6 months", strtotime($getUser->membership_date)));
        $pop_up='';
        // print_r($flag);exit;
        if($expiry <= date('Y-m-d') && !empty($getUser->membership_date)){

            $flag = 1;
            $pop_up='ok';
        }
 // print_r($pop_up);exit;   

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

$raasis = json_decode($getUser->chart);
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
// print_r($Type_of_study);exit;
?>


				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #ed0d60; ;">
                            <div class="member__thumb">
                            <?php if($getUser->gender==1){?>
                            <img style="width: 100%;height: 10em;object-fit: cover;" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>" alt="member-img">
                            <?php } ?>
                            <?php if($getUser->gender==2){?>
                            <img style="width: 100%;height: 10em;object-fit: cover;" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>" alt="member-img">
                            <?php } ?>
                                <span class="member__activity"></span>
                            </div>
                            <div class="member__content">
                                
                                <a href="member-single.html"><h6 style="color:white"><?php echo $getUser->first_name; ?></h6></a>
                                <div class="row mb-4 mt-4">
                                    <div class="col-12" style="border:1px solid black; padding:10px;border-left-style:none;border-right-style:none;border-color: white;">
                                        <span style="font-size:25px;color: white;"><?php echo $getUser->follower?></span>
                                        <p style="color: white;"><?php echo translate('followers')?> </p>
                                    </div>
                                 </div>
                                
                                 <div class="row mb-4">
                                    <div class="col-12" >
                                         <h6 class="mt-3" style="color:white"><?php echo translate('package_informations')?></h6>
                                    </div>
                                 </div>
                               
                                <div class="row mb-4 mt-3" >
                                    <div class="col-6" style="border:1px solid black; padding:10px;border-left-style:none;border-color: white;">
                                        <span style="font-size:25px;color: white;"><?php echo $getUser->remain_download?></span>
                                        <p style="font-size: 11px;color: white;"><?php echo translate('profile_downloads')?> </p>
                                    </div>
                                    <div class="col-6" style="border:1px solid black; padding:10px;border-right-style:none;border-left-style:none;border-color: white;">
                                        <span style="font-size:25px;color: white;"><?php echo $getUser->express_interest?></span>
                                        <p style="font-size: 11px;color: white;"><?php echo translate('remaining_interest')?> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6"style="border:1px solid black; padding:10px;border-left-style:none;border-right-style:none;border-color: white;">
                                        <span style="font-size:25px;color: white;"><?php echo $getUser->direct_messages?></span>
                                        <p style="font-size: 11px;color: white;"><?php echo translate('remaining_message')?> </p>
                                    </div>
                                    <div class="col-6" style="border:1px solid black; padding:10px;border-right-style:none;border-color: white;">
                                        <span style="font-size:25px;color: white;"><?php echo $getUser->photo_gallery?></span>
                                       <p style="font-size: 11px;color: white;"><?php echo translate('photo_gallery')?> </p>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                <?php

                            $payment= getMemberCurrentPayment($getUser->member_id);                
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
                            <p class="mt-3" style="color:white"><?php echo $msg ;?></p>

                            
                            </div>
                        </div>
                    </div>
					<div class="col-lg-9 col-12 mt-3">
					<!-- ================> Activity section start here <================== -->
					
                                           
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header"><h4><?php echo translate('my_interests')?></h4></div>
                                                        <div class="card-body">
                                                          <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                        <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                                   <?php }else{ ?>
                                                            <table id="datatable1" class="display table table-bordered dt-responsive" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo translate('s_no')?></th>
                                                                        <th><?php echo translate('image')?></th>
                                                                        <th><?php echo translate('member_id')?></th>
                                                                        <th><?php echo translate('name')?></th>
                                                                        <th><?php echo translate('age')?></th>
                                                                        <th><?php echo translate('status')?></th>
                                                                    </tr>
                                                                </thead>                    
                                                            </table>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                           
                                        </div>
                                        </div>