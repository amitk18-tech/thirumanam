<?php

if(!$this->session->userdata('thirumanam_logged_data')){

    redirect('login');
}

if ($set_lang = $this->session->userdata('language')) {
 
 } else {
     $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
 }

?>
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
<style>
.main-wrapper{
  max-width: 1440px;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  height: 50vh;
}
.slider-wrapper{
  width: 100%;
  height: 500px;
  display: flex;
  align-items: center;
  position: relative;
  margin: auto;
  overflow: hidden;
}

.slides{
  width: 100%;
  position: absolute;
  transition: transform .4s ease-in-out;
}
.slides h1{
  
  position: relative;
  top: 5rem;
  left: 1rem;
  backdrop-filter: blur(7px);
  width: 9rem;
  padding: 1rem;

}
.slides img{
  width: 100%;
  object-fit: contain;
  border-radius: .3rem;
}
.slider-btns{
  position: absolute;
  top: 30%;
  z-index: 2;
  width: 100;
  width: 50%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.slider-btns span{
  padding: 1rem 1.2rem;
  font-size: 1.5rem;
  background: rgba(255, 255, 255, 0.151);
  border-radius: 50%;
  color: white;
  cursor: pointer;
}
.dots{
  position: absolute;
  width: 100%;
  top: 85%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  z-index: 1;
}

.dots .dot{
  width: 1rem;
  height: 1rem;
  background-color: white;
  opacity: .2;
  border-radius: 50%;
  transition: opacity .2s ease-in-out;
  cursor: pointer;
}

@media screen and (max-width:950px) {
  .slider-wrapper{
    width: 100%;
  }
  .slider-btns{
    top: 30%;
  }
   .dots{fNot Approved
  position: absolute;
  width: 100%;
  top: 70%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  z-index: 1;
}

@media screen and (max-width:680px) {
  .slider-wrapper{
    width: 100%;
  }
  .slider-btns{
    top: 30%;
  }
  .dots{
  position: absolute;
  width: 100%;
  top: 60%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  z-index: 1;
}
.activity__inner{
    padding: 5px !important;
}

}
  </style>

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

      if(!empty($getUser->membership_date)){
           $expiry = date("Y-m-d", strtotime("+6 months", strtotime($getUser->membership_date)));
       }else{

        $expiry = " ";

       }

    
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
        
        $rasi['f010'] = (isset($raasi->f010) ? $raasi->f010 : '');
        $rasi['f011'] = (isset($raasi->f011) ? $raasi->f011 : '');
        $rasi['f012'] = (isset($raasi->f012) ? $raasi->f012 : '');
        $rasi['f013'] = (isset($raasi->f013) ? $raasi->f013 : '');
        $rasi['f014'] = (isset($raasi->f014) ? $raasi->f014 : '');
        $rasi['f015'] = (isset($raasi->f015) ? $raasi->f015 : ''); 

        $rasi['f020'] = (isset($raasi->f020) ? $raasi->f020 : '');
        $rasi['f021'] = (isset($raasi->f021) ? $raasi->f021 : '');
        $rasi['f022'] = (isset($raasi->f022) ? $raasi->f022 : '');
        $rasi['f023'] = (isset($raasi->f023) ? $raasi->f023 : '');
        $rasi['f024'] = (isset($raasi->f024) ? $raasi->f024 : '');
        $rasi['f025'] = (isset($raasi->f025) ? $raasi->f025 : '');

        $rasi['f030'] = (isset($raasi->f030) ? $raasi->f030 : '');
        $rasi['f031'] = (isset($raasi->f031) ? $raasi->f031 : '');
        $rasi['f032'] = (isset($raasi->f032) ? $raasi->f032 : '');
        $rasi['f033'] = (isset($raasi->f033) ? $raasi->f033 : '');
        $rasi['f034'] = (isset($raasi->f034) ? $raasi->f034 : '');
        $rasi['f035'] = (isset($raasi->f035) ? $raasi->f035 : '');

        $rasi['f040'] = (isset($raasi->f040) ? $raasi->f040 : '');
        $rasi['f041'] = (isset($raasi->f041) ? $raasi->f041 : '');
        $rasi['f042'] = (isset($raasi->f042) ? $raasi->f042 : '');
        $rasi['f043'] = (isset($raasi->f043) ? $raasi->f043 : '');
        $rasi['f044'] = (isset($raasi->f044) ? $raasi->f044 : '');
        $rasi['f045'] = (isset($raasi->f045) ? $raasi->f045 : '');

        $rasi['f110'] = (isset($raasi->f110) ? $raasi->f110 : '');
        $rasi['f111'] = (isset($raasi->f111) ? $raasi->f111 : '');
        $rasi['f112'] = (isset($raasi->f112) ? $raasi->f112 : '');
        $rasi['f113'] = (isset($raasi->f113) ? $raasi->f113 : '');
        $rasi['f114'] = (isset($raasi->f114) ? $raasi->f114 : '');
        $rasi['f115'] = (isset($raasi->f115) ? $raasi->f115 : ''); 

        $rasi['f210'] = (isset($raasi->f210) ? $raasi->f210 : '');
        $rasi['f211'] = (isset($raasi->f211) ? $raasi->f211 : '');
        $rasi['f212'] = (isset($raasi->f212) ? $raasi->f212 : '');
        $rasi['f213'] = (isset($raasi->f213) ? $raasi->f213 : '');
        $rasi['f214'] = (isset($raasi->f214) ? $raasi->f214 : '');
        $rasi['f215'] = (isset($raasi->f215) ? $raasi->f215 : '');

        $rasi['f310'] = (isset($raasi->f310) ? $raasi->f310 : '');
        $rasi['f311'] = (isset($raasi->f311) ? $raasi->f311 : '');
        $rasi['f312'] = (isset($raasi->f312) ? $raasi->f312 : '');
        $rasi['f313'] = (isset($raasi->f313) ? $raasi->f313 : '');
        $rasi['f314'] = (isset($raasi->f314) ? $raasi->f314 : '');
        $rasi['f315'] = (isset($raasi->f315) ? $raasi->f315 : '');

        $rasi['f320'] = (isset($raasi->f320) ? $raasi->f320 : '');
        $rasi['f321'] = (isset($raasi->f321) ? $raasi->f321 : '');
        $rasi['f322'] = (isset($raasi->f322) ? $raasi->f322 : '');
        $rasi['f323'] = (isset($raasi->f323) ? $raasi->f323 : '');
        $rasi['f324'] = (isset($raasi->f324) ? $raasi->f324 : '');
        $rasi['f325'] = (isset($raasi->f325) ? $raasi->f325 : ''); 

        $rasi['f410'] = (isset($raasi->f410) ? $raasi->f410 : '');
        $rasi['f411'] = (isset($raasi->f411) ? $raasi->f411 : '');
        $rasi['f412'] = (isset($raasi->f412) ? $raasi->f412 : '');
        $rasi['f413'] = (isset($raasi->f413) ? $raasi->f413 : '');
        $rasi['f414'] = (isset($raasi->f414) ? $raasi->f414 : '');
        $rasi['f415'] = (isset($raasi->f415) ? $raasi->f415 : '');  

        $rasi['f420'] = (isset($raasi->f420) ? $raasi->f420 : '');
        $rasi['f421'] = (isset($raasi->f421) ? $raasi->f421 : '');
        $rasi['f422'] = (isset($raasi->f422) ? $raasi->f422 : '');
        $rasi['f423'] = (isset($raasi->f423) ? $raasi->f423 : '');
        $rasi['f424'] = (isset($raasi->f424) ? $raasi->f424 : '');
        $rasi['f425'] = (isset($raasi->f425) ? $raasi->f425 : '');

        $rasi['f430'] = (isset($raasi->f430) ? $raasi->f430 : '');
        $rasi['f431'] = (isset($raasi->f431) ? $raasi->f431 : '');
        $rasi['f432'] = (isset($raasi->f432) ? $raasi->f432 : '');
        $rasi['f433'] = (isset($raasi->f433) ? $raasi->f433 : '');
        $rasi['f434'] = (isset($raasi->f434) ? $raasi->f434 : '');
        $rasi['f435'] = (isset($raasi->f435) ? $raasi->f435 : '');

        $rasi['f440'] = (isset($raasi->f440) ? $raasi->f440 : '');
        $rasi['f441'] = (isset($raasi->f441) ? $raasi->f441 : '');
        $rasi['f442'] = (isset($raasi->f442) ? $raasi->f442 : '');
        $rasi['f443'] = (isset($raasi->f443) ? $raasi->f443 : '');
        $rasi['f444'] = (isset($raasi->f444) ? $raasi->f444 : '');
        $rasi['f445'] = (isset($raasi->f445) ? $raasi->f445 : '');


         

        $rasi['f510'] = (isset($raasi->f510) ? $raasi->f510 : '');
        $rasi['f511'] = (isset($raasi->f511) ? $raasi->f511 : '');
        $rasi['f512'] = (isset($raasi->f512) ? $raasi->f512 : '');
        $rasi['f513'] = (isset($raasi->f513) ? $raasi->f513 : '');
        $rasi['f514'] = (isset($raasi->f514) ? $raasi->f514 : '');
        $rasi['f515'] = (isset($raasi->f515) ? $raasi->f515 : ''); 

        $rasi['f520'] = (isset($raasi->f520) ? $raasi->f520 : '');
        $rasi['f521'] = (isset($raasi->f521) ? $raasi->f521 : '');
        $rasi['f522'] = (isset($raasi->f522) ? $raasi->f522 : '');
        $rasi['f523'] = (isset($raasi->f523) ? $raasi->f523 : '');
        $rasi['f524'] = (isset($raasi->f524) ? $raasi->f524 : '');
        $rasi['f525'] = (isset($raasi->f525) ? $raasi->f525 : '');

        $rasi['f530'] = (isset($raasi->f530) ? $raasi->f530 : '');
        $rasi['f531'] = (isset($raasi->f531) ? $raasi->f531 : '');
        $rasi['f532'] = (isset($raasi->f532) ? $raasi->f532 : '');
        $rasi['f533'] = (isset($raasi->f533) ? $raasi->f533 : '');
        $rasi['f534'] = (isset($raasi->f534) ? $raasi->f534 : '');
        $rasi['f535'] = (isset($raasi->f535) ? $raasi->f535 : '');

        $rasi['f540'] = (isset($raasi->f540) ? $raasi->f540 : '');
        $rasi['f541'] = (isset($raasi->f541) ? $raasi->f541 : '');
        $rasi['f542'] = (isset($raasi->f542) ? $raasi->f542 : '');
        $rasi['f543'] = (isset($raasi->f543) ? $raasi->f543 : '');
        $rasi['f544'] = (isset($raasi->f544) ? $raasi->f544 : '');
        $rasi['f545'] = (isset($raasi->f545) ? $raasi->f545 : '');

        $rasi['f610'] = (isset($raasi->f610) ? $raasi->f610 : '');
        $rasi['f611'] = (isset($raasi->f611) ? $raasi->f611 : '');
        $rasi['f612'] = (isset($raasi->f612) ? $raasi->f612 : '');
        $rasi['f613'] = (isset($raasi->f613) ? $raasi->f613 : '');
        $rasi['f614'] = (isset($raasi->f614) ? $raasi->f614 : '');
        $rasi['f615'] = (isset($raasi->f615) ? $raasi->f615 : ''); 

        $rasi['f710'] = (isset($raasi->f710) ? $raasi->f710 : '');
        $rasi['f711'] = (isset($raasi->f711) ? $raasi->f711 : '');
        $rasi['f712'] = (isset($raasi->f712) ? $raasi->f712 : '');
        $rasi['f713'] = (isset($raasi->f713) ? $raasi->f713 : '');
        $rasi['f714'] = (isset($raasi->f714) ? $raasi->f714 : '');
        $rasi['f715'] = (isset($raasi->f715) ? $raasi->f715 : '');

        $rasi['f810'] = (isset($raasi->f810) ? $raasi->f810 : '');
        $rasi['f811'] = (isset($raasi->f811) ? $raasi->f811 : '');
        $rasi['f812'] = (isset($raasi->f812) ? $raasi->f812 : '');
        $rasi['f813'] = (isset($raasi->f813) ? $raasi->f813 : '');
        $rasi['f814'] = (isset($raasi->f814) ? $raasi->f814 : '');
        $rasi['f815'] = (isset($raasi->f815) ? $raasi->f815 : '');

        $rasi['f820'] = (isset($raasi->f820) ? $raasi->f820 : '');
        $rasi['f821'] = (isset($raasi->f821) ? $raasi->f821 : '');
        $rasi['f822'] = (isset($raasi->f822) ? $raasi->f822 : '');
        $rasi['f823'] = (isset($raasi->f823) ? $raasi->f823 : '');
        $rasi['f824'] = (isset($raasi->f824) ? $raasi->f824 : '');
        $rasi['f825'] = (isset($raasi->f825) ? $raasi->f825 : ''); 

        $rasi['f910'] = (isset($raasi->f910) ? $raasi->f910 : '');
        $rasi['f911'] = (isset($raasi->f911) ? $raasi->f911 : '');
        $rasi['f912'] = (isset($raasi->f912) ? $raasi->f912 : '');
        $rasi['f913'] = (isset($raasi->f913) ? $raasi->f913 : '');
        $rasi['f914'] = (isset($raasi->f914) ? $raasi->f914 : '');
        $rasi['f915'] = (isset($raasi->f915) ? $raasi->f915 : '');  

        $rasi['f920'] = (isset($raasi->f920) ? $raasi->f920 : '');
        $rasi['f921'] = (isset($raasi->f921) ? $raasi->f921 : '');
        $rasi['f922'] = (isset($raasi->f922) ? $raasi->f922 : '');
        $rasi['f923'] = (isset($raasi->f923) ? $raasi->f923 : '');
        $rasi['f924'] = (isset($raasi->f924) ? $raasi->f924 : '');
        $rasi['f925'] = (isset($raasi->f925) ? $raasi->f925 : '');

        $rasi['f930'] = (isset($raasi->f930) ? $raasi->f930 : '');
        $rasi['f931'] = (isset($raasi->f931) ? $raasi->f931 : '');
        $rasi['f932'] = (isset($raasi->f932) ? $raasi->f932 : '');
        $rasi['f933'] = (isset($raasi->f933) ? $raasi->f933 : '');
        $rasi['f934'] = (isset($raasi->f934) ? $raasi->f934 : '');
        $rasi['f935'] = (isset($raasi->f935) ? $raasi->f935 : '');

        $rasi['f940'] = (isset($raasi->f940) ? $raasi->f940 : '');
        $rasi['f941'] = (isset($raasi->f941) ? $raasi->f941 : '');
        $rasi['f942'] = (isset($raasi->f942) ? $raasi->f942 : '');
        $rasi['f943'] = (isset($raasi->f943) ? $raasi->f943 : '');
        $rasi['f944'] = (isset($raasi->f944) ? $raasi->f944 : '');
        $rasi['f945'] = (isset($raasi->f945) ? $raasi->f945 : '');
    } }
// print_r($Type_of_study);exit;
?>


<div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2><?php echo translate('profile ')?></h2>
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo translate('profile')?></li>
                </ol>
            </nav> -->
        </div>
    </div>
</div>
<?php if($flag == 1){ ?>
<div class="alert alert-danger" role="alert" style='width:100%'>
    <?=translate('7_days_text')?>
</div>
<?php } ?>
<?php if($pop_up=="ok"){?>

<input type="hidden" name="pop_up" id="pop_up" value="ok">


<?php }?>
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?php echo translate('Expired');?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo translate('your_account_has_been_Expired');?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo translate('close')?></button>
        <a href="<?php echo base_url('Subscription');?>" class="btn btn-primary"><?php echo translate('membership_subscription')?></a>
      </div>
    </div>
  </div>
</div>
<!-- ================> Member section start here <================== -->
<div class="member member--style2 padding-top padding-bottom">
<div class="container">
	<div class="section__wrapper wow fadeInUp" data-wow-duration="1.5s">
		<ul class="nav nav-tabs member__tab" id="myTab" role="tablist">
			<li class="nav-item" role="presentation">
			  	<button class="nav-link active" id="newest-tab" data-bs-toggle="tab" data-bs-target="#newest" type="button" role="tab" aria-controls="newest" aria-selected="true"><?php echo translate('profile')?></button>
			</li>
			<li class="nav-item" role="presentation">
			  	<button class="nav-link" id="activemember-tab" data-bs-toggle="tab" data-bs-target="#activemember" type="button" role="tab" aria-controls="activemember" aria-selected="false"><?php echo translate('my_interests')?></button>
			</li>
			<li class="nav-item" role="presentation">
			  	<button class="nav-link" id="popularmember-tab" data-bs-toggle="tab" data-bs-target="#popularmember" type="button" role="tab" aria-controls="popularmember" aria-selected="false"><?php echo translate('shortlist')?></button>
			</li>

			<li class="nav-item" role="presentation">
			  	<button class="nav-link" id="newest-tab2" data-bs-toggle="tab" data-bs-target="#newest2" type="button" role="tab" aria-controls="newest2" aria-selected="true"><?php echo translate('followed_users')?></button>
			</li>
			<li class="nav-item" role="presentation">
			  	<button class="nav-link" id="activemember-tab2" data-bs-toggle="tab" data-bs-target="#activemember2" type="button" role="tab" aria-controls="activemember2" aria-selected="false"><?php echo translate('messaging')?></button>
			</li>
			<li class="nav-item" role="presentation">
			  	<button class="nav-link" id="popularmember-tab2" data-bs-toggle="tab" data-bs-target="#popularmember2" type="button" role="tab" aria-controls="popularmember2" aria-selected="false"><?php echo translate('ignored_list')?></button>
			</li>
			<li class="nav-item" role="presentation">
			  	<button class="nav-link" id="popularmember-tab3" data-bs-toggle="tab" data-bs-target="#popularmember3" type="button" role="tab" aria-controls="popularmember3" aria-selected="false"><?php echo translate('Viewed')?></button>
			</li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="Viewers-tab3" data-bs-toggle="tab" data-bs-target="#Viewers" type="button" role="tab" aria-controls="Viewers" aria-selected="false"><?php echo translate('Viewers')?></button>
      </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="gallery-tab" data-bs-toggle="tab" data-bs-target="#gallery" type="button" role="tab" aria-controls="gallery" aria-selected="true"><?php echo translate('gallery')?></button>

            </li><!--line no 2677-->
            <li class="nav-item" role="presentation">
            <?php if($getUser->membership == 1 || $getUser->updateProfileDoneStatus == 0){ ?>
            
                <a class="nav-link" style="padding: 15px 20px;
                border: 1px solid rgba(33, 51, 102, 0.1) !important;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                -ms-border-radius: 4px;
                -o-border-radius: 4px;
                border-radius: 4px;color:gray;
                background-color: white" href="<?php echo base_url('LoginController/verifyMember');?>"><?php echo translate('happy_story')?></a>
            <?php } else { ?>
                <button class="nav-link" id="happy_story-tab" data-bs-toggle="tab" data-bs-target="#happy_story" type="button" role="tab" aria-controls="happy_story" aria-selected="false"><?php echo translate('happy_story')?></button>
            <?php } ?>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="change_password-tab" data-bs-toggle="tab" data-bs-target="#change_password" type="button" role="tab" aria-controls="change_password" aria-selected="false"><?php echo translate('change_password')?></button>
            </li>
             <li class="nav-item" role="presentation">
                <button id="notification-tab" data-bs-toggle="tab" data-bs-target="#notification" type="button" role="tab" aria-controls="notification" aria-selected="false"><?php echo translate('notification')?></button>
            </li>
            <li class="nav-item" role="presentation">
            <?php if($this->db->get_where("member", array("member_id" =>$getUser->member_id))->row()->is_closed == 'yes'){?>
                <button class="nav-link" type="button" data-toggle="modal" data-target="#exampleModal"><?php echo translate('re-open_account?')?></button>
            <?php }else{?>
                <button class="nav-link" type="button" data-toggle="modal" data-target="#exampleModalTwo"><?php echo translate('close_account')?></button>
            <?php } ?>
            </li>
           
		</ul>

		<div class="tab-content mx-12-none" id="myTabContent">
            
			<div class="tab-pane fade show active" id="newest" role="tabpanel" aria-labelledby="newest-tab">
				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
                          <a onclick="document.getElementById('profile_image').click();">
                            <div class="member__thumb">
                            <?php if($getUser->gender==1){?>
                            <img id="pimage_preview" style="width: 100%;height: 10em;object-fit: cover;cursor: pointer;" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>" alt="member-img" onError="this.onerror=null;this.src='<?php echo base_url('uploads/profile_image/default.jpg') ?>';">
                            <?php } ?>
                            <?php if($getUser->gender==2){?>
                            <img id="pimage_preview" style="width: 100%;height: 10em;object-fit: cover;cursor: pointer;" src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>" alt="member-img" onError="this.onerror=null;this.src='<?php echo base_url('uploads/profile_image/default_female.jpg') ?>';">
                            <?php } ?>
                                <span class="member__activity"></span>
                            </div>
                          </a>
                          <div id="save_button_section" style="display:none;">
                             <button type="button" id="save_image" class="btn btn-sm btn-block btn-primary "><?php echo translate('save');?></button>
                          </div>
                            <form action="<?=base_url()?>WelcomeController/updateProfileimage" method="POST" enctype="multipart/form-data" id="profile_image_form">
                               <input type='file' name='profile_image' id="profile_image" style="display: none;">
                           </form>
                            <div class="member__content">
                                
                                <a href=""><h6 style="color:white"><?php echo $getUser->first_name; ?></h6></a>
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
                             <?php if($getUser->report_married_status==0) {?>
                            <button class="btn btn-info" onclick="add_married(<?php echo $member_id?>)"><?php echo translate('mariage_fixed');?></button>
                            <?php }else { ?>
                              <button class="btn btn-success"><?php echo translate('match_reported');?></button>
                           <?php } ?>
                        </div>
                    </div>
					<div class="col-lg-9 col-12 mt-3">
					<!-- ================> Activity section start here <================== -->
					<div class="activity">
				            <div class="row g-4">
				                <div class="col-lg-12">
				                	<div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3);">
				                		<div class="row">
				                			<div class="col-md-6 col-6">
				                				<h3><?php echo translate('profile_information')?></h3>
				                			</div>
				                			<div class="col-md-6 text-end">
				                				<a <?php if($getUser->updateProfileDoneStatus == 1 && $flag == 2){ echo "style='display:none'"; } 
			                                         if($flag == 1){ ?> href="<?=base_url()?>Subscription" title="<?=translate('7_days_text')?>" <?php } ?>
			                                      onclick="edit_all()" style="cursor: pointer;" class="default-btn btn-sm"> <?php echo translate('edit_all')?></a>
				                			</div>
				                		</div>
				                		<div class="row mt-2">
				                			<div class="col-md-6	">
				                				<label><?php echo translate('member_id');?></label> <?php echo $getUser->member_profile_id; ?>
				                			</div>
				                			<div class="col-md-6 col-6">
				                				<label><?php echo translate('registration_date');?></label> <?php echo date('d-m-Y',strtotime($getUser->member_since)); ?>
				                			</div>
				                		</div>
                                        <form id="form_All">
				                    <div class="group__bottom--area mt-2"  id="info_introduction">
			                            <div class="group__bottom--group">
                                        <div class="activity__inner">
                                        	<div class="row">
                                        		<div class="col-md-7 col-7">
                                        			<h6><span><?php echo translate('introduction')?></span></h6>
                                        		</div>
                                        		<div class="col-md-5 col-5 text-end">
                                        		<?php if($checkUpdateCompleteProfile == 1){ ?>
								                <button class="default-btn btn-sm" type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> 	onclick="edit_section('introduction')"><?php echo translate('edit')?>
								                </button>
								                 <?php } ?>
                                        		</div>
                                        	</div>
                                        	<div class="row">
                                        		<div class="col-md-12 mt-2" id="introduction_val">
                                        			<?php echo $getUser->introduction;?>
                                        		</div>
                                        	</div>
                                        </div>
                                     </div>
				                	</div><!-- ////start/////// -->
				                	<div class="group__bottom--area mt-2"  id="edit_introduction" style="display:none">
			                            <div class="group__bottom--group">
										<form id="form_introduction">
                                            <input type="hidden" name="member_id" id="member_id" value="<?php echo $getUser->member_id;?>">
                                        <div class="activity__inner">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('introduction')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
												<?php if($checkUpdateCompleteProfile == 1){ ?>
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('introduction')"><?php echo translate('cancel')?>
										        </button>
                                                <?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-12 mt-2">
													<textarea name="introduction" id="introduction" class="form-control"><?php echo $getUser->introduction;?></textarea>
												</div>
											</div>
											
											
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                    <?php if($checkUpdateCompleteProfile == 1){ ?>
										   	 		<button type="button" class="default-btn btn-sm"  onclick="save_introduction('Introduction')"><?php echo translate('update')?>
										        	</button>
                                                    <?php } ?>
										   	 	</div>
										    </div>
										</div>
									</form>
                                     </div>
				                	</div><!-- /////end////// -->
				                    <div class="group__bottom--area mt-2" id="info_basic_information">
				                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                            	<div class="row">
                                            		<div class="col-md-7 col-7">
                                            			<h6><span><?php echo translate('basic_information')?></span></h6>
                                            		</div>
                                            		<div class="col-md-5 col-5 text-end">
                                            		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button class="default-btn btn-sm" type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> onclick="edit_section('basic_information')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
                                            		</div>
                                            	</div>
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
                                                    <label><?php echo translate('marital_status')?>:..  </label>
                                                  </div>
                                                  <div class="col-md-6 col-6">
                                                      <span id="marital_status_val"><?php echo (!empty($basic_info_data[0]['marital_status'])) ? dropdownTranslate($basic_info_data[0]['marital_status']) : ""; ?></span>
                                                  </div>
                                                </div>
                                            			 
                                            		</div>
                                            	</div>
                                            </div>
				                        </div>
				                    </div><!-- /////start////// -->
				                    <div class="group__bottom--area mt-2"  id="edit_basic_information" style="display:none">
			                            <div class="group__bottom--group">
			                            <form id=form_BasicInfo>
			                            	<input type="hidden" name="member_id" id="member_id" value="<?php echo $getUser->member_id;?>">
                                        <div class="activity__inner">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('basic_information')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
												<?php if($checkUpdateCompleteProfile == 1){ ?>
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('basic_information')"><?php echo translate('cancel')?>
                                                <?php } ?>
										        </button>
												</div>
											</div>
											<div class="row">
									      		<div class="col-md-6 col-6">
									      			<div class="form-group">
										        	<label for="message-text" class="col-form-label"><?php echo translate('Name')?></label>
										            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $getUser->first_name;?>">
										        </div>
									      		</div>
									      		<div class="col-md-6 col-6">
									      			<div class="form-group">
										        	<label for="message-text" class="col-form-label"><?php echo translate('email')?></label>
										            <input type="email" name="email" id="email" class="form-control" value="<?php echo $getUser->email;?>">
										        </div>
									      		</div>
									      		<div class="col-md-6 col-6">
									      			<div class="form-group">
										        	<label for="message-text" class="col-form-label"><?php echo translate('marital_status')?></label>
										        	<select class="form-control" name="marital_status" id="marital_status">
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
										        	</select>
										        </div>
									      		</div>
									      		<div class="col-md-6 col-6" style="display: none;" id="no_of_child">
									      			<div class="form-group">
										        	<label for="message-text" class="col-form-label"><?php echo translate('number_of_children')?></label>
										            <input type="number" name="number_of_children" id="number_of_children" class="form-control" value="<?php echo (!empty($basic_info_data[0]['number_of_children'])) ? $basic_info_data[0]['number_of_children'] : 0 ;?>">
										        </div>
									      		</div>
									      		<div class="col-md-6 col-6"  style="display: none;" id="child_live_place">
									      			<div class="form-group">
										        	<label for="message-text" class="col-form-label"><?php echo translate('Child_living_place')?></label>
										        	<select class="form-control" name="Child_living_place" id="Child_living_place">
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
									      	</div>
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>
										   	 		<button type="button" onclick="save_basicInfo('BasicInfo')" class="default-btn btn-sm"><?php echo translate('update')?>
										        	</button>
                                                <?php } ?>
										   	 	</div>
										    </div>
										</div>
									</form>
                                     </div>
				                	</div><!-- /////end////// -->
				                    <div class="group__bottom--area mt-2" id="info_education">
				                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                            	<div class="row">
                                            		<div class="col-md-7 col-7">
                                            			<h6><span><?php echo translate('education_and_career')?></span></h6>
                                            		</div>
                                            		<div class="col-md-5 col-5 text-end">
                                            		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> class="default-btn btn-sm" onclick="edit_section('education')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
                                            		</div>
                                            	</div>
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
				                    <!--////////start-->
									<div class="group__bottom--area mt-2"  id="edit_education" style="display:none">
									    <div class="group__bottom--group">
									    <div class="activity__inner p-3">
									    	<form id=form_Education>
			                            	<input type="hidden" name="member_id" id="member_id" value="<?php echo $getUser->member_id;?>">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('education_and_career')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
											<?php if($checkUpdateCompleteProfile == 1){ ?>
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('education')"><?php echo translate('cancel')?>
										        </button>
                                            <?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mt-2">

                          			<label><?php echo translate('Type_of_study')?>:	</label>
                          			<select class="form-control mt-2" name="Type_of_study" id="Type_of_study">
                          				<option value=""><?php echo translate('choose_one'); ?></option>
                          				<?php if(!empty($Type_of_study)){ foreach ($Type_of_study as $value) {?>
                          					<option data=<?php echo $value->word;?> <?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Type_of_study']))){ if($education_and_career_data[0]['Type_of_study'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($education_and_career_data[0]['Type_of_study'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                          			

                          				<?php } }?>
                          			</select>
                          		</div>
                          		<div class="col-md-6 mt-2" id="study_other" style="display:none;">
                          			<label><?php echo translate('OTHERS')?>:	</label>
                          			<input type="text" class="form-control mt-2" name="other_study" id="other_study" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['other_study']))){echo $education_and_career_data[0]['other_study'];}?>">
                          		</div>
                          		<div class="col-md-6 mt-2">
                          			<label><?php echo translate('STUDY_DETAILS')?>:	</label>
                          			<input type="text" class="form-control mt-2" name="STUDY_DETAILS" id="STUDY_DETAILS" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['STUDY_DETAILS']))){echo $education_and_career_data[0]['STUDY_DETAILS'];}?>">
                          		</div>
                          		<div class="col-md-6 mt-2">
                          			<label><?php echo translate('Type_of_occupation')?>:	</label>
                          			<select class="form-control mt-2" name="Type_of_occupation" id="Type_of_occupation">
                          				<option value=""><?php echo translate('choose_one'); ?></option>
                          				<?php if(!empty($Type_of_occupation)){ foreach ($Type_of_occupation as $value) {?>
                          					<option data="<?php echo $value->word;?>" <?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Type_of_occupation']))){ if($education_and_career_data[0]['Type_of_occupation'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($education_and_career_data[0]['Type_of_occupation'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                          			

                          				<?php } }?>
                          			</select>
                          		</div>
                          		<div class="col-md-6 mt-2" id="occupation_other" style="display:none;">
                          			<label><?php echo translate('Other_Occupation_Details')?>:	</label>
                          			<input type="text" class="form-control mt-2" name="Other_Occupation_Details" id="Other_Occupation_Details" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Other_Occupation_Details']))){echo $education_and_career_data[0]['Other_Occupation_Details'];}?>">
                          		</div>
                          		<div class="col-md-6 mt-2">
                          			<label><?php echo translate('Career_Profile')?>:	</label>
                          			<input type="text" class="form-control mt-2" name="Career_Profile" id="Career_Profile" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Career_Profile']))){echo $education_and_career_data[0]['Career_Profile'];}?>">
                          		</div>
                          		<div class="col-md-6 mt-2">
                          			<label><?php echo translate('Earnings')?>:	</label>
                          			<select class="form-control mt-2" name="Earnings" id="Earnings">
                          				<option value=""><?php echo translate('choose_one'); ?></option>
                          				<?php if(!empty($Earnings)){ foreach ($Earnings as $value) {?>
                          					<option <?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['Earnings']))){ if($education_and_career_data[0]['Earnings'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($education_and_career_data[0]['Earnings'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                          			

                          				<?php } }?>
                          			</select>
                          		</div>
                          		<div class="col-md-6 mt-2">
                          			<label><?php echo translate('annual_income')?>:	</label>
                          			<input type="text" class="form-control mt-2" name="annual_income" id="annual_income" value="<?php if(!empty($education_and_career_data && !empty( $education_and_career_data[0]['annual_income']))){echo $education_and_career_data[0]['annual_income'];}?>">
                          		</div>
                      				</div>
                      				<div class="row mt-2">
                      			   	 	<div class="col-md-6 mt-2 text-end">
                                                        <?php if($checkUpdateCompleteProfile == 1){ ?>
                      			   	 		<button type="button" onclick="save_Education('Education')" class="default-btn btn-sm"><?php echo translate('update')?>
                      			        	</button>
                                                        <?php } ?>
                      			   	 	</div>
                      			    </div>
                      			</form>
                      			</div>
                      		 </div>
                      		</div><!--////////end-->
              <div class="group__bottom--area mt-2" id="info_physical_attributes">
                      <div class="group__bottom--group">
                              <div class="activity__inner">
                              	<div class="row">
                              		<div class="col-md-7 col-7">
                              			<h6><span><?php echo translate('physical_attributes')?></span></h6>
                              		</div>
                              		<div class="col-md-5 col-5 text-end">
                              		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> class="default-btn btn-sm" onclick="edit_section('physical_attributes')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
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
                                                            <span id="eye_color_val"><?php echo (!empty($physical_attributes_data[0]['eye_color'])) ? $physical_attributes_data[0]['eye_color'] : "";?></span>
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
				                    <!--////////start-->
									<div class="group__bottom--area mt-2"  id="edit_physical_attributes" style="display:none">
									    <div class="group__bottom--group">
									    <div class="activity__inner">
									    	<form id=form_Physical>
			                            	<input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('physical_attributes')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
											<?php if($checkUpdateCompleteProfile == 1){ ?>	
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('physical_attributes')"><?php echo translate('cancel')?>
										        </button>
                                            <?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mt-2">
                    			<label><?php echo translate('height')?>:	</label>
                    			<input type="number" class="form-control mt-2" name="height" id="height" value="<?php if(!empty($getUser->height)){echo $getUser->height;}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('weight')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="weight" id="weight" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['weight']))){echo $physical_attributes_data[0]['weight'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('eye_color')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="eye_color" id="eye_color" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['eye_color']))){echo $physical_attributes_data[0]['eye_color'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('hair_color')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="hair_color" id="hair_color" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['hair_color']))){echo $physical_attributes_data[0]['hair_color'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('complexion')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="complexion" id="complexion" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['complexion']))){echo $physical_attributes_data[0]['complexion'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('blood_group')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="blood_group" id="blood_group" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['blood_group']))){echo $physical_attributes_data[0]['blood_group'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('body_type')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="body_type" id="body_type" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['body_type']))){echo $physical_attributes_data[0]['body_type'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('body_art')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="body_art" id="body_art"value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['body_art']))){echo $physical_attributes_data[0]['body_art'];}?>">
                    		</div>
                    		<div class="col-md-6 mt-2">
                    			<label><?php echo translate('any_disability')?>:	</label>
                    			<input type="text" class="form-control mt-2" name="any_disability" id="any_disability" value="<?php if(!empty($physical_attributes_data && !empty( $physical_attributes_data[0]['any_disability']))){echo $physical_attributes_data[0]['any_disability'];}?>">
                    		</div>
											</div>
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>
										   	 		<button type="button" onclick="save_Phisical('Physical')" class="default-btn btn-sm"><?php echo translate('update')?>
										        	</button>
                                                <?php } ?>
										   	 	</div>
										    </div>
										</form>
										</div>
									 </div>
									</div><!--////////end-->
				                    <div class="group__bottom--area mt-2" id="info_astronomic_information">
				                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                            	<div class="row">
                                            		<div class="col-md-7 col-7">
                                            			<h6><span><?php echo translate('astronomic_information')?></span></h6>
                                            		</div>
                                            		<div class="col-md-5 col-5 text-end">
                                            		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> class="default-btn btn-sm" onclick="edit_section('astronomic_information')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
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
                                                    <?php if(!empty($astronomic_information_data[0]['DOSHAM'])){
                                                        if($astronomic_information_data[0]['DOSHAM'] != 'No'){
                                                      ?>
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
                                                    <?php }} ?>
                                                       <?php if(!empty($astronomic_information_data[0]['TYPE_OF_DOSHAM'])){
                                                        if($astronomic_information_data[0]['TYPE_OF_DOSHAM'] == 'OTHERS'){
                                                      ?>
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
                                                    <?php } }?>
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
				                    <!--////////start-->
									<div class="group__bottom--area mt-2"  id="edit_astronomic_information" style="display:none">
									    <div class="group__bottom--group">
									    <div class="activity__inner">
									    	<form id=form_Astronomic>
			                            	<input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('astronomic_information')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
											<?php if($checkUpdateCompleteProfile == 1){ ?>	
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('astronomic_information')"><?php echo translate('cancel')?>
										        </button>
                                            <?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('date_of_birth')?>:	</label>
                                        			<input type="date" class="form-control mt-2" name="date_of_birth" id="date_of_birth" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['date_of_birth']))){echo date('Y-m-d', strtotime($astronomic_information_data[0]['date_of_birth']));}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('birthDay')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="birthDay" id="birthDay" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['birthDay']))){echo dropdownTranslate($astronomic_information_data[0]['birthDay']);}?>" disabled>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('time_of_birth')?>:	</label>
                                        			<input type="text" class="form-control mt-2" name="time_of_birth" id="time_of_birth" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['time_of_birth']))){echo $astronomic_information_data[0]['time_of_birth'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('city_of_birth')?>:	</label>
                                        			<input type="text" class="form-control mt-2" name="city_of_birth"  id="city_of_birth" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['city_of_birth']))){echo $astronomic_information_data[0]['city_of_birth'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('PAKSHA')?>:	</label>
                                        			<select class="form-control mt-2" name="PAKSHA" id="paksha">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($PAKSHA)){ foreach ($PAKSHA as $value) {?>
                                        					<option data="<?php echo $value->word;?>" <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['PAKSHA']))){ if($astronomic_information_data[0]['PAKSHA'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['PAKSHA'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2" id="paksha_other" style="display:none;">
                                        			<label><?php echo translate('Other_Paksha')?>:	</label>
                                        			<input type="text" class="form-control mt-2" name="Other_Paksha" id="Other_Paksha" value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Other_Paksha']))){echo $astronomic_information_data[0]['Other_Paksha'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('star')?>:	</label>
                                        			<select class="form-control mt-2" name="star" id="star">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($star)){ foreach ($star as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['star']))){ if($astronomic_information_data[0]['star'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['star'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('PADAM')?>:	</label>
                                        			<select class="form-control mt-2" name="PADAM" id="PADAM">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($PADAM)){ foreach ($PADAM as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['PADAM']))){ if($astronomic_information_data[0]['PADAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['PADAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('LAKKNAM')?>:	</label>
                                        			<select class="form-control mt-2" name="LAKKNAM" id="LAKKNAM">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($LAKKNAM)){ foreach ($LAKKNAM as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['LAKKNAM']))){ if($astronomic_information_data[0]['LAKKNAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['LAKKNAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('HOROSCOPE_MATCHING')?>:	</label>
                                        			<select class="form-control mt-2" name="HOROSCOPE_MATCHING" id="HOROSCOPE_MATCHING">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($HOROSCOPE_MATCHING)){ foreach ($HOROSCOPE_MATCHING as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['HOROSCOPE_MATCHING']))){ if($astronomic_information_data[0]['HOROSCOPE_MATCHING'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['HOROSCOPE_MATCHING'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('TITHI')?>:	</label>
                                        			<select class="form-control mt-2" name="TITHI" id="TITHI">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($TITHI)){ foreach ($TITHI as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['TITHI']))){ if($astronomic_information_data[0]['TITHI'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['TITHI'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('DOSHAM')?>:	</label>
                                        			<select class="form-control mt-2" name="DOSHAM" id="dosham">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($DOSHAM)){ foreach ($DOSHAM as $value) {?>
                                        					<option data="<?php echo $value->word; ?>" <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['DOSHAM']))){ if($astronomic_information_data[0]['DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2" id="dosham_other" style="display:none;">
                                        			<label><?php echo translate('TYPE_OF_DOSHAM')?>:	</label>
                                        			<select class="form-control mt-2" name="TYPE_OF_DOSHAM" id="TYPE_OF_DOSHAM">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($TYPE_OF_DOSHAM)){ foreach ($TYPE_OF_DOSHAM as $value) {?>
                                        					<option data="<?php echo $value->word;?>" data="<?php echo $value->word;?>" <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['TYPE_OF_DOSHAM']))){ if($astronomic_information_data[0]['TYPE_OF_DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['TYPE_OF_DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2" id="Other_Dosham" style="display:none;">
                                        			<label><?php echo translate('Other_Dosham')?>:	</label>
                                        			<input type="text" class="form-control mt-2"  name="Other_Dosham" id="Other_Dosh" name="Other_Dosham"value="<?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Other_Dosham']))){echo $astronomic_information_data[0]['Other_Dosham'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('DIRECTIONAL_BALANCE')?>:	</label>
                                        			<select class="form-control mt-2" name="DIRECTIONAL_BALANCE" id="DIRECTIONAL_BALANCE">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($DIRECTIONAL_BALANCE)){ foreach ($DIRECTIONAL_BALANCE as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['DIRECTIONAL_BALANCE']))){ if($astronomic_information_data[0]['DIRECTIONAL_BALANCE'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['DIRECTIONAL_BALANCE'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-2 mt-2">
                                        			<label><?php echo translate('year')?>:	</label>
                                        			<select class="form-control mt-2" name="Year" id="Year">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php for($i = 0; $i <=20; $i ++){?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Year']))){ if("$i" === ($astronomic_information_data[0]['Year'])){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        			

                                        				<?php } ?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-2 mt-2">
                                        			<label><?php echo translate('month')?>:	</label>
                                        			<select class="form-control mt-2" name="Month"  id="Month">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php for($i = 0; $i <=12; $i ++){?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Month']))){ if("$i" === ($astronomic_information_data[0]['Month'])){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        			

                                        				<?php } ?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-2 mt-2">
                                        			<label><?php echo translate('day')?>:	</label>
                                        			<select class="form-control mt-2" name="Day" id="Day">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php for($i = 0; $i <=30; $i ++){?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['Day']))){ if("$i" === ($astronomic_information_data[0]['Day'])){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        			

                                        				<?php } ?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('rashi')?>:	</label>
                                        			<select class="form-control mt-2" name="rashi" id="rashi">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($Zodiac)){ foreach ($Zodiac as $value) {?>
                                        					<option <?php if(!empty($astronomic_information_data && !empty( $astronomic_information_data[0]['rashi']))){ if($astronomic_information_data[0]['rashi'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($astronomic_information_data[0]['rashi'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
											</div>
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>
										   	 		<button type="button" onclick="save_Astronomic('Astronomic')" class="default-btn btn-sm"><?php echo translate('update')?>
										        	</button>
                                                <?php } ?>
										   	 	</div>
										    </div>
										</form>
										</div>
									 </div>
									</div><!--////////end-->
				                    <div class="group__bottom--area mt-2" id="info_permanent_address">
				                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                            	<div class="row">
                                            		<div class="col-md-7 col-7">
                                            			<h6><span><?php echo translate('permanent_address')?></span></h6>
                                            		</div>
                                            		<div class="col-md-5 col-5 text-end">
                                            		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> class="default-btn btn-sm" onclick="edit_section('permanent_address')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
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
                                                    <?php if(!empty($permanent_address_data[0]['permanent_state'])){

                                                      if($permanent_address_data[0]['permanent_state'] == 'OTHERS'){

                                                      ?>
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
                                                  <?php }else {?>


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

                                                <?php } }?>
		                                            		
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
                                                           <span id="mobile_val"><?php echo (!empty($getUser->mobile)) ? $getUser->mobile : "";?></span> 
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
				                    <!--////////start-->
									<div class="group__bottom--area mt-2"  id="edit_permanent_address" style="display:none">
									    <div class="group__bottom--group">
									    <div class="activity__inner">
									    	<form id=form_Permanent>
			                            	<input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('permanent_address')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
											<?php if($checkUpdateCompleteProfile == 1){ ?>	
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('permanent_address')"><?php echo translate('cancel')?>
										        </button>
                                            <?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('country')?>:	</label>
                                        			<input type="text" class="form-control mt-2" name="permanent_country" id="permanent_country" value="<?php echo dropdownTranslate('India');?>" disabled>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('state')?>:	</label>
                                        			<select class="form-control mt-2" name="permanent_state" id="permanent_states">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php 
                                                        $i=0; $state_id="";
                                                        if(!empty($permanent_state)){ foreach ($permanent_state as $value) { $i++;?>
                                        					<option  data-id="<?php echo $value->state_id;?>" <?php if(!empty($permanent_address_data && !empty($permanent_address_data[0]['permanent_state']))){  if((dropdownTranslate($value->word)) == dropdownTranslate($permanent_address_data[0]['permanent_state'])){ echo "selected"; } }?> value="<?php echo $value->word; ?>"><?php echo (($set_lang=="english") ? $value->english : $value->tamil); ?></option>
                                        			

                                        				<?php } } ?>
                                        			</select>
                                        		</div>
                                            <div class="col-lg-6 mt-2" style="display:none" id="permanent_city_other">
                                              <label for="basiInput" class="form-label"><?php echo translate('OTHERS');?></label>
                                              <input type="text" name="permanent_city_other" id="permanent_city_others" class="form-control" value="<?php echo (!empty($permanent_address_data[0]['permanent_city_other'])) ? $permanent_address_data[0]['permanent_city_other'] : " "; ?>">
                                          </div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('city')?>:	</label>
                                        			<select class="form-control mt-2" name="permanent_city" id="citys_ajax_output">
                                                <?php 
                                                if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['permanent_city']))){

                                                  // dropdownTranslate($permanent_address_data[0]['permanent_city']
                                                  ?>
                                        				
                                                    <option <?php   if((dropdownTranslate($value->word)) == dropdownTranslate($permanent_address_data[0]['permanent_city'])){ echo "selected"; } ?> value="<?php echo $permanent_address_data[0]['permanent_city']; ?>"><?php echo dropdownTranslate($permanent_address_data[0]['permanent_city']); ?></option>
                                                    <?php }else{ ?>
                                                        <option value=""><?php echo translate('choose_a_city_first'); ?></option>
                                                    <?php }?>
                                        			</select>
                                        		</div>
                                                <div class="col-md-6 mt-2">
                                                    <label><?php echo translate('postal-Code')?>:   </label>

                                                    <input type="text" class="form-control mt-2" name="permanent_postal_code" id="permanent_postal_code" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['permanent_postal_code']))){echo $permanent_address_data[0]['permanent_postal_code'];}?>">
                                                </div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('address')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="address" id="address" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['address']))){echo $permanent_address_data[0]['address'];}?>">
                                        		</div>
                                        		
                                        			

                                        			<input type="hidden" class="form-control mt-2" name="mobile" id="mobile" value="<?php if(!empty( $getUser->mobile)){echo $getUser->mobile;}?>">
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('alternate_number')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="alternate_number" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['alternate_number']))){echo $permanent_address_data[0]['alternate_number'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('landline')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="landline" value="<?php if(!empty($permanent_address_data && !empty( $permanent_address_data[0]['landline']))){echo $permanent_address_data[0]['landline'];}?>">
                                        		</div>
											</div>
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>    
										   	 		<button type="button" onclick="save_Permanent('Permanent')" class="default-btn btn-sm"><?php echo translate('update')?>
										        	</button>
                                                <?php } ?>
										   	 	</div>
										    </div>
										</form>
										</div>
									 </div>
									</div><!--////////end-->
				                    <div class="group__bottom--area mt-2" id="info_family_information">
				                            <div class="group__bottom--group">
                                            <div class="activity__inner">
                                            	<div class="row">
                                            		<div class="col-md-7 col-7">
                                            			<h6><span><?php echo translate('family_information')?></span></h6>
                                            		</div>
                                            		<div class="col-md-5 col-5 text-end">
                                            		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> class="default-btn btn-sm" onclick="edit_section('family_information')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
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
		                                            		<?php if(!empty($family_info_data[0]['father_vangusam'])){ if($family_info_data[0]['father_vangusam'] == "OTHERS"){ ?> 
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
		                                            		<?php if(!empty($family_info_data[0]['mother_vangusam'])){ if($family_info_data[0]['mother_vangusam'] == "OTHERS"){ ?> 
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
                                                        <div class="col-md-6 col-6">
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
                                                        <div class="col-md-6 col-6">
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
                                                        <div class="col-md-6 col-6">
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
		                                            		<?php if(!empty($family_info_data[0]['Property_Description'])){ if(dropdownTranslate($family_info_data[0]['Property_Description']) == "OTHERS"){ ?> 
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
				                    <!--////////start-->
									<div class="group__bottom--area mt-2"  id="edit_family_information" style="display:none">
									    <div class="group__bottom--group">
									    <div class="activity__inner">
									    	<form id=form_Familyinformation>
			                            	<input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('family_information')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end">
											<?php if($checkUpdateCompleteProfile == 1){ ?>	
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('family_information')"><?php echo translate('cancel')?>
										        </button>
                                            <?php } ?>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Surname')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="Surname" id="Surname" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['Surname']))){echo $family_info_data[0]['Surname'];}?>">
                                        		</div>
                                        		 <?php 
						                        $current_plan = $this->db->order_by('package_payment_id','DESC')->limit(1)->get_where('package_payment',array('payment_status'=>'paid','member_id'=>$getUser->member_id,'payment_timestamp >=' => strtotime(date('Y-m-d H:i:s',strtotime('-6 months')))))->row();
						                        $remain_download = $this->db->get_where('member', array('member_id' => $getUser->member_id))->row()->remain_download;
						                        $plan_soveran=0;
						                        if ($remain_download>0 && !empty($current_plan)) {
						                            $plan_details = $this->db->get_where('plan',array('plan_id'=>$current_plan->plan_id))->row();
						                            $plan_soveran=(!empty($plan_details) && $plan_details->soveran) ? $plan_details->soveran : 0;
						                        }

						                        // $language=getLanguage();

						                        ?>
						                        <div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Soveran_Details')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="Soveran_Details" id="Soveran_Details" value="<?php if(!empty($getUser->soveran_detail)){echo $getUser->soveran_detail ;}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('father')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="father" id="father" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['father']))){echo $family_info_data[0]['father'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('mother')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="mother" id="mother" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['mother']))){echo $family_info_data[0]['mother'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('father_vangusam')?>:	</label>
                                        			<select class="form-control mt-2" name="father_vangusam" id="father_vangusam">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($getvangusam)){ foreach ($getvangusam as $value) {?>
                                        					<option data="<?php echo $value->word;?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['father_vangusam']))){ if($family_info_data[0]['father_vangusam'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['father_vangusam'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2" id="father_vangusam_other" style="display:none;">
                                        			<label><?php echo translate('other_vang')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="other_father_vang" id="other_father_vang" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['other_father_vang']))){echo $family_info_data[0]['other_father_vang'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('mother_vangusam')?>:	</label>
                                        			<select class="form-control mt-2" name="mother_vangusam" id="mother_vangusam">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($getvangusam)){ foreach ($getvangusam as $value) {?>
                                        					<option data="<?php echo $value->word;?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['mother_vangusam']))){ if($family_info_data[0]['mother_vangusam'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['mother_vangusam'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2" id="mother_vangusam_other" style="display:none;">
                                        			<label><?php echo translate('other_vang')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="other_mother_vang" id="other_mother_vang" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['other_mother_vang']))){echo $family_info_data[0]['other_mother_vang'];}?>">
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('family_type')?>:	</label>
                                        			<select class="form-control mt-2" name="family_type" id="family_type">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($getFamilyType)){ foreach ($getFamilyType as $value) {?>
                                        					<option <?php if(!empty($family_info_data && !empty( $family_info_data[0]['family_type']))){ if($family_info_data[0]['family_type'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['family_type'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Number_of_brothers')?>:	</label>
                                        			<select class="form-control mt-2" name="Number_of_brothers" id="Number_of_brothers" onchange="brother()">
                                        				<option data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_brothers'])){ if($family_info_data[0]['Number_of_brothers'] == 'no') { echo "selected"; } } ?> value="no"><?php echo translate('no'); ?></option>
                                        				<?php for ($i=1; $i <= 10 ; $i++) { ?>
                                        					<option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_brothers']))){ if($i == $family_info_data[0]['Number_of_brothers']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        				<?php } ?>
                                        					<option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_brothers'])){ if($family_info_data[0]['Number_of_brothers'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                                        				
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Number_of_married_brothers')?>:	</label>
                                        			<select class="form-control mt-2" name="Number_of_married_brothers" id="Number_of_married_brothers" onchange="brother()">
                                        				<option data="0" value=""><?php echo translate('choose_one'); ?></option>
                                        				<option data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_brothers'])){ if($family_info_data[0]['Number_of_married_brothers'] == 'no') { echo "selected"; } } ?> value="no"><?php echo translate('no'); ?></option>
                                        				<?php for ($i=1; $i <= 10 ; $i++) { ?>
                                        					<option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_married_brothers']))){ if($i == $family_info_data[0]['Number_of_married_brothers']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        				<?php } ?>
                                        					<option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_brothers'])){ if($family_info_data[0]['Number_of_married_brothers'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                                        				
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Number_of_Sisters')?>:	</label>
                                        			<select class="form-control mt-2" name="Number_of_Sisters" id="Number_of_Sisters" onchange="sister()">
                                        				<option  data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_Sisters'])){ if($family_info_data[0]['Number_of_Sisters'] == 'no') { echo "selected"; } } ?> value="no"><?php echo translate('no'); ?></option>
                                        				<?php for ($i=1; $i <= 10 ; $i++) { ?>
                                        					<option  data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_Sisters']))){ if($i == $family_info_data[0]['Number_of_Sisters']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        				<?php } ?>
                                        					<option  data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_Sisters'])){ if($family_info_data[0]['Number_of_Sisters'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                                        				
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Number_of_married_sisters')?>:	</label>
                                        			<select class="form-control mt-2" name="Number_of_married_sisters" id="Number_of_married_sisters" onchange="sister()">
                                        				<option data="0" value=""><?php echo translate('choose_one'); ?></option>
                                        				<option data="0" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_sisters'])){ if($family_info_data[0]['Number_of_married_sisters'] == 'no') { echo "selected"; } } ?> value="no"><?php echo translate('no'); ?></option>
                                        				<?php for ($i=1; $i <= 10 ; $i++) { ?>
                                        					<option data="<?php echo $i; ?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Number_of_married_sisters']))){ if($i == $family_info_data[0]['Number_of_married_sisters']){ echo "selected"; } }?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        				<?php } ?>
                                        					<option data="11" <?php if(!empty($family_info_data && $family_info_data[0]['Number_of_married_sisters'])){ if($family_info_data[0]['Number_of_married_sisters'] == 'Above') { echo "selected"; } } ?> value="Above"><?php echo translate('Above'); ?></option>

                                        				
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2">
                                        			<label><?php echo translate('Property_Description')?>:	</label>
                                        			<select class="form-control mt-2" name="Property_Description" id="Property_Description">
                                        				<option value=""><?php echo translate('choose_one'); ?></option>
                                        				<?php if(!empty($Property_Description)){ foreach ($Property_Description as $value) {?>
                                        					<option data="<?php echo $value->word;?>" <?php if(!empty($family_info_data && !empty( $family_info_data[0]['Property_Description']))){ if($family_info_data[0]['Property_Description'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($family_info_data[0]['Property_Description'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        			

                                        				<?php } }?>
                                        			</select>
                                        		</div>
                                        		<div class="col-md-6 mt-2" id="property_other" style="display:none;">
                                        			<label><?php echo translate('Other_property_description')?>:	</label>

                                        			<input type="text" class="form-control mt-2" name="Other_property_description" id="Other_property_description" value="<?php if(!empty($family_info_data && !empty( $family_info_data[0]['Other_property_description']))){echo $family_info_data[0]['Other_property_description'];}?>">
                                        		</div>
											</div>
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>
										   	 		<button type="button" onclick="save_Familyinformation('Familyinformation')" class="default-btn btn-sm"><?php echo translate('update')?>
										        	</button>
                                                <?php } ?>
										   	 	</div>
										    </div>
										</form>
										</div>
									 </div>
									</div><!--////////end-->
									<div class="group__bottom--area mt-2" id="info_partner_expectation">
								    <div class="group__bottom--group">
								    <div class="activity__inner">
										<div class="row">
											<div class="col-md-7 col-7">
												<h6><span><?php echo translate('partner_expectation')?></span></h6>
											</div>
                                            <div class="col-md-5 col-5 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>
                                                <button class="default-btn btn-sm" type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?>  onclick="edit_section('partner_expectation')"><?php echo translate('edit')?>
                                                </button>
                                                 <?php } ?>
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
								<!--////////start-->
								<div class="group__bottom--area mt-2"  id="edit_partner_expectation" style="display:none">
								    <div class="group__bottom--group">
								    <div class="activity__inner">
                                        <form id="form_PartnerExpectation">
                                            <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
										<div class="row">
											<div class="col-md-7 col-7">
												<h6><span><?php echo translate('partner_expectation')?></span></h6>
											</div>
											<div class="col-md-5 col-5 text-end">
										<?php if($checkUpdateCompleteProfile == 1){ ?>	
									        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('partner_expectation')"><?php echo translate('cancel')?>
									        </button>
                                        <?php } ?>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('age')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_age" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_age']))){echo $partner_expectation_data[0]['partner_age'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('height')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_height" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_height']))){echo $partner_expectation_data[0]['partner_height'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('weight')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_weight" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_weight']))){echo $partner_expectation_data[0]['partner_weight'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('any_disability')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_any_disability" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_any_disability']))){echo $partner_expectation_data[0]['partner_any_disability'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('marital_status')?>:	</label>
                                    			<select class="form-control mt-2" name="partner_marital_status" id="mar_status">
                                    				<option value=""><?php echo translate('choose_one'); ?></option>
                                    				<?php if(!empty($marital_status)){ 
                                                        $i=0;
                                                     foreach ($marital_status as $value) { $i++; ?>
                                    					<option data="<?php echo $i;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_marital_status']))){ if($partner_expectation_data[0]['partner_marital_status'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_marital_status'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    			

                                    				<?php } }?>
                                    			</select>
                                    		</div>
                                    		<div class="col-md-6 mt-2" id="children_acceptables" style="display:none;">
                                			<label><?php echo translate('with_children_acceptables')?>:	</label>

                                			<?php 
                                			
			                            	echo select_html('decision', 'with_children_acceptables', 'name', 'edit', 'form-control', $partner_expectation_data[0]['with_children_acceptables'], '', '', '');
			                        		
			                        		?>
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('body_type')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_body_type" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_body_type']))){echo $partner_expectation_data[0]['partner_body_type'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('education')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_education" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_education']))){echo $partner_expectation_data[0]['partner_education'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('profession')?>:	</label>

                                    			<input type="text" class="form-control mt-2" name="partner_profession" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_profession']))){echo $partner_expectation_data[0]['partner_profession'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('DOSHAM')?>:	</label>
                                    			<select class="form-control mt-2" name="partner_DOSHAM" id="partner_DOSHAM">
                                    				<option value=""><?php echo translate('choose_one'); ?></option>
                                    				<?php if(!empty($DOSHAM1)){ foreach ($DOSHAM1 as $value) {?>
                                    					<option data="<?php echo $value->word;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_DOSHAM']))){ if($partner_expectation_data[0]['partner_DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    			

                                    				<?php } }?>
                                    			</select>
                                        	</div>
                                    		<div class="col-md-6 mt-2" id="partner_TYPE_OF_DOSHAM" style="display:none;">
                                    			<label><?php echo translate('TYPE_OF_DOSHAM')?>:	</label>
                                    			<select class="form-control mt-2" name="partner_TYPE_OF_DOSHAM">
                                    				<option value=""><?php echo translate('choose_one'); ?></option>
                                    				<?php if(!empty($TYPE_OF_DOSHAM1)){ foreach ($TYPE_OF_DOSHAM1 as $value) {?>
                                    					<option data="<?php echo $value->word;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_TYPE_OF_DOSHAM']))){ if($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_TYPE_OF_DOSHAM'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    			

                                    				<?php } }?>
                                    			</select>
                                    		</div>
                                    		<div class="col-md-6 mt-2" id="partner_Other_Dosham" style="display:none;">
                                			<label><?php echo translate('Other_Dosham')?>:	</label>

                                			<input type="text" class="form-control mt-2" name="partner_Other_Dosham" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_Other_Dosham']))){echo $partner_expectation_data[0]['partner_Other_Dosham'];}?>">
                                    		</div>
                                    		<div class="col-md-6 mt-2">
                                    			<label><?php echo translate('Expectation')?>:	</label>
                                    			<select class="form-control mt-2" name="partner_Expectation" id="partner_Expectation">
                                    				<option value=""><?php echo translate('choose_one'); ?></option>
                                    				<?php if(!empty($Expectation)){ foreach ($Expectation as $value) {?>
                                    					<option data="<?php echo $value->word;?>" <?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_Expectation']))){ if($partner_expectation_data[0]['partner_Expectation'] != ''){ if((dropdownTranslate($value->word)) == dropdownTranslate($partner_expectation_data[0]['partner_Expectation'])){ echo "selected"; } } }?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    			

                                    				<?php } }?>
                                    			</select>
                                        	</div>
                                        	<div class="col-md-6 mt-2" id="partner_Other_Expectation" style="display: none;">
                                			<label><?php echo translate('OTHERS')?>:	</label>

                                			<input type="text" class="form-control mt-2" name="partner_Other_Expectation" value="<?php if(!empty($partner_expectation_data && !empty( $partner_expectation_data[0]['partner_Other_Expectation']))){echo $partner_expectation_data[0]['partner_Other_Expectation'];}?>">
                                    		</div>
										</div>

										<div class="row mt-2">
									   	 	<div class="col-md-6 mt-2 text-end">
                                            <?php if($checkUpdateCompleteProfile == 1){ ?>
									   	 		<button type="button" onclick="save_Partner('PartnerExpectation')" class="default-btn btn-sm"><?php echo translate('update')?>
									        	</button>
                                            <?php } ?>
									   	 	</div>
									    </div>
                                    </form>
									</div>
								 </div>
								</div><!--////////end-->
				                    <div class="group__bottom--area mt-2" id="info_chart">
				                            <div class="group__bottom--group">
                                            <div class="activity__inner" style="padding:0px">
                                            	<div class="row">
                                            		<div class="col-md-7 col-7">
                                            			<h6><span style="padding-left: 28px;"> <?php echo translate('chart')?></span></h6>
                                            		</div>
                                            		<div class="col-md-5 col-5 text-end">
                                            		<?php if($checkUpdateCompleteProfile == 1){ ?>
									                <button type="button" <?php if($flag == 1) { ?> style="display:none" <?php } ?> class="default-btn btn-sm" onclick="edit_section('chart')"><?php echo translate('edit')?>
									                </button>
									                 <?php } ?>
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
							                                        <span id="f032"><?php echo (!empty($raasi->f032))? dropdownTranslate($raasi->f032).' | ':"" ; ?></span><br>
                                                                    <span id="f033"><?php   
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
							                                        <td id="value19" colspan="2" rowspan="2" style="text-align: center;height:7em;width: 10%;font-size: 15px; background-color: #f3f3cb;padding-top: 10%;"><?php echo translate('ZODIAC');?>
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
							                                       <span id="f441"><?php echo (!empty($raasi->f441))? dropdownTranslate($raasi->f441).' | ':"" ;?></span>
							                                       <span id="f442"><?php echo (!empty($raasi->f442))? dropdownTranslate($raasi->f442).' | ':"" ; ?></span><br><span id="f443"><?php
							                                        echo (!empty($raasi->f443))? dropdownTranslate($raasi->f443).' | ':"" ;?></span>
							                                        <span id="f444"><?php echo (!empty($raasi->f444))? dropdownTranslate($raasi->f444).' | ':"" ;?></span>
							                                       <span id="f445"><?php echo (!empty($raasi->f445))? dropdownTranslate($raasi->f445).' | ':"" ;
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
							                                        <td id="value19" colspan="2" rowspan="2" style="text-align: center;height:7em;width: 10%;font-size: 15px; background-color: #f3f3cb;"><?php echo translate('FEATURE');?>
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
							                                        echo (!empty($raasi->f924))? dropdownTranslate($raasi->f924).' | ':"" ;?></span><span id="f925"><?php
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
				                    <!--////////start-->
									<div class="group__bottom--area mt-2"  id="edit_chart" style="display:none">
									    <div class="group__bottom--group">
									    <div class="activity__inner">
                                            <form id="form_Chart">
                                                <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>">
											<div class="row">
												<div class="col-md-7 col-7">
													<h6><span><?php echo translate('chart')?></span></h6>
												</div>
												<div class="col-md-5 col-5 text-end mb-3">
											<?php if($checkUpdateCompleteProfile == 1){ ?>	
										        <button class="btn btn-danger btn-sm" type="button"  	onclick="load_section('chart')"><?php echo translate('cancel')?>
										        </button>
                                            <?php } ?>
												</div>
											</div>
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
					                                                    <select class="form-select mb-3" name="f0<?php echo $j.$i; ?>" id="f0<?php echo $j.$i; ?>" aria-label="Default select example" required>
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f1<?php echo $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f2<?php echo $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f3<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f4<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f0<?php echo $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f1<?php echo $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f2<?php echo $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f3<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f4<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
												<div class="col-md-12 col-10">
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
					                                                    <select class="form-select mb-3" name="f5<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f6<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f7<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f8<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f9<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f5<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f6<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f7<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f8<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
					                                                    <select class="form-select mb-3" name="f9<?php echo  $j.$i; ?>" aria-label="Default select example">
					                                                    <option value=""></option>
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
											</div>
                                        
											<div class="row mt-2">
										   	 	<div class="col-md-6 mt-2 text-end">
                                                <?php if($checkUpdateCompleteProfile == 1){ ?>
										   	 		<button type="button" onclick="save_Chart('Chart')" class="default-btn btn-sm"><?php echo translate('update')?>
										        	</button>
                                                <?php } ?>
                                                <?php if($checkUpdateCompleteProfile == 0){ ?>
                                                    <button type="button" onclick="save_All('All')" class="default-btn btn-sm"><?php echo translate('update')?>
                                                    </button>
                                                <?php } ?>
										   	 	</div>
										    </div>
                                            </form>
										</div>
									 </div>
									</div><!--////////end-->
                                </form>
				                </div>
				            </div>
				        </div>
				    </div>
					</div>
				</div>	
			</div>
			<div class="tab-pane fade" id="activemember" role="tabpanel" aria-labelledby="activemember-tab">
				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                                                                        <th><?php echo translate('options')?></th>
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
                                    </div>
			<div class="tab-pane fade" id="popularmember" role="tabpanel" aria-labelledby="popularmember-tab">
				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                                                        <div class="card-header"><h4><?php echo translate('shortlist')?></h4></div>
                                                        <div class="card-body">
                                                          <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                      <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                                 <?php }else{ ?>
                                                            <table id="datatable2" class="display table table-bordered dt-responsive" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo translate('s_no')?></th>
                                                                        <th><?php echo translate('image')?></th>
                                                                        <th><?php echo translate('member_id')?></th>
                                                                        
                                                                        <th><?php echo translate('name')?></th>
                                                                        <th><?php echo translate('age')?></th>
                                                                        
                                                                        <th><?php echo translate('options')?></th>
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
                                    </div>
			<div class="tab-pane fade" id="newest2" role="tabpanel" aria-labelledby="newest2-tab">
				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header"><h4><?php echo translate('followed_users')?></h4></div>
                                                        <div class="card-body">
                                                          <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                      <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                                 <?php }else{ ?>
                                                            <table id="datatable3" class="display table table-bordered dt-responsive" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo translate('s_no')?></th>
                                                                        <th><?php echo translate('image')?></th>
                                                                        <th><?php echo translate('member_id')?></th>
                                                                        <th><?php echo translate('name')?></th>
                                                                        <th><?php echo translate('age')?></th>
                                                                        
                                                                        <th><?php echo translate('options')?></th>
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
                                    </div> 
            <div class="tab-pane fade" id="activemember2" role="tabpanel" aria-labelledby="activemember2-tab2">
                <div class="row">
                    <div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                    <div class="activity">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                            <div class="col-md-6 col-6">
                                                <h3><?php echo translate('messaging')?></h3>
                                            </div>
                                        </div>  
                                    <div class="group__bottom--area mt-2">
                                        <div class="group__bottom--group">
                                        <div class="activity__inner">
                                           <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                            <?php } else { ?>
                                            <div class="row">
                                                <div class="col-md-8 col-12">
                                                    
                                    <div class="card" style="padding:0px !important">
                                                        <div class="card-header">
                                                            <h3 class="card-inner-title pull-left c-base-1">
                                                                <i class="fa fa-comments-o"></i> <span id="msg_box_header"><?php echo translate('select_a_member')?></span>
                                                            </h3>
                                                            <div class="pull-right">
                                                                <small id="msg_refresh">
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="card-body" style="overflow-y: scroll;height: 300px;overflow-x: auto;">
                                                            <!-- Conversations are loaded here -->
                                                            <div class="direct-chat-messages" id="msg_body" style="height: 100px">
                                                                <p class="c-base-1 pt-4 text-center">"<?php echo translate('select_a_member_from_the_contact_list_to_start_messaging')?>"</p>
                                                            </div>
                                                            <!-- Contacts are loaded here -->
                                                        </div>
                                                        <div class="card-footer" style="padding: 8px;">
                                                            <form class="form-default" id="message_form" method="post">
                                                                <div class="input-group">
                                                                    <input type="text" id="message_text" name="message_text" placeholder="Type Message ..." value="" class="form-control" style="z-index: 2;" disabled>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="msger-send-btn" id="msg_send_btn" disabled><?php echo translate('send')?></button>
                                                                    </span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4 col-12 mt-3">
                                                    <?php $user_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
                                                    $listed_messaging_members =get_listed_messaging_members($user_id);

                                                                    ?>

                                                    <div class="card" style="padding:0px !important">
                                                        <div class="card-body" style="overflow-y: scroll;height: 300px;overflow-x: auto;">
                                                            <div class="direct-chat-contacts">
                                                            <ul class="contacts-list">
                                                                <div class="pt-3 pb-2 text-center" style="border-bottom: 1px solid rgba(0, 0, 0, .15); margin: 0; width: 90% !important; margin-left: 5%;">
                                                                    <h4 class="card-inner-title c-base-1"><i class="fa fa-users"></i> <?php echo translate('contact_list')?></h4>
                                                                </div>
                                                                <?php foreach ($listed_messaging_members as $listed_member){ ?>
                                                                    <?php if ($this->db->get_where('member', array('member_id' => $listed_member['member_id']))->row()->member_id){
                                                                           
                                                                        $member_info = $this->db->get_where('member', array('member_id' => $listed_member['member_id']))->row();
                                                                        if ($member_info->is_closed=='no') {
                                                                    ?>
                                                                        <li>
                                                                            <a class="img_btn" style='hover :
                                                          background: rgb(0, 180, 50);cursor:pointer; margin-top: 10px; ' onclick="open_message_box(<?=$listed_member['message_thread_id']?>,this)" id="thread_<?=$listed_member['message_thread_id']?>">
                                                                                <?php
                                                                                    $images = json_decode($member_info->profile_image, true);
                                                                                    if (file_exists('uploads/profile_image/'.$images[0]['thumb'])) {
                                                                                    ?>
                                                                                        <img style="width: 10%;" class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/<?=$images[0]['thumb']?>">
                                                                                    <?php
                                                                                    }
                                                                                    else {
                                                                                    if($member_info->gender==1){
                                                                                    ?>
                                                                                        <img style="width: 10%;" class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/default.jpg">
                                                                                    <?php } else { ?>
                                                                                        <img style="width: 10%;" class="contacts-list-img" src="<?=base_url()?>uploads/profile_image/default_female.jpg">
                                                                                    <?php
                                                                                    } }
                                                                                ?>
                                                                                <div class="contacts-list-info">
                                                                                    <span class="contacts-list-name" data-member="<?=$member_info->member_id?>">
                                                                                        <?=$member_info->first_name.' '.$member_info->last_name?>
                                                                                    </span>
                                                                                </div>
                                                                                
                                                                            </a>
                                                                        </li>
                                                                        <hr>
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
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
			
			<div class="tab-pane fade" id="popularmember2" role="tabpanel" aria-labelledby="popularmember2-tab2">
				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header"><h4><?php echo translate('ignored_list')?></h4></div>
                                                        <div class="card-body">
                                                          <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                          <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                                     <?php }else{ ?>
                                                            <table id="datatable4" class="display table table-bordered dt-responsive" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo translate('s_no')?></th>
                                                                        <th><?php echo translate('image')?></th>
                                                                        <th><?php echo translate('member_id')?></th>
                                                                        <th><?php echo translate('name')?></th>
                                                                        <th><?php echo translate('age')?></th>
                                                                        <th><?php echo translate('options')?></th>
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
                                    </div>
			<div class="tab-pane fade" id="popularmember3" role="tabpanel" aria-labelledby="popularmember3-tab3">
				<div class="row">
					<div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header"><h4><?php echo translate('profile_viwed_details')?></h4></div>
                                                        <div class="card-body">
                                                          <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                          <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                                     <?php }else{ ?>
                                                            <table id="datatable5" class="display table table-bordered dt-responsive" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo translate('s_no')?></th>
                                                                        <th><?php echo translate('image')?></th>
                                                                        <th><?php echo translate('member_id')?></th>
                                                                        <th><?php echo translate('name')?></th>
                                                                        <th><?php echo translate('age')?></th>
                                                                        <th><?php echo translate('DOSHAM')?></th>
                                                                        <th><?php echo translate('father_vangusam')?></th>
                                                                        <th><?php echo translate('options')?></th>
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
                                    </div>


    <div class="tab-pane fade" id="Viewers" role="tabpanel" aria-labelledby="Viewers-tab3">
        <div class="row">
          <div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                      <div class="col-lg-12">
                          <div class="card">
                              <div class="card-header"><h4><?php echo translate('profile_viwed_details')?></h4></div>
                              <div class="card-body">
                                <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                           <?php }else{ ?>
                                  <table id="datatable7" class="display table table-bordered dt-responsive" style="width:100%">
                                      <thead>
                                          <tr>
                                              <th><?php echo translate('s_no')?></th>
                                              <th><?php echo translate('image')?></th>
                                              <th><?php echo translate('member_id')?></th>
                                              <th><?php echo translate('name')?></th>
                                              <th><?php echo translate('age')?></th>
                                              <th><?php echo translate('DOSHAM')?></th>
                                              <th><?php echo translate('father_vangusam')?></th>
                                              <th><?php echo translate('options')?></th>
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
          </div>


      <div class="tab-pane fade" id="notification" role="tabpanel" aria-labelledby="notification">
        <div class="row">
          <div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header"><h4><?php echo translate('notification')?></h4></div>
                                                        <div class="card-body">
                                                          <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
                                                          <button type="button" data-toggle="modal" data-target="#exampleModal" class="default-btn"><?php echo translate('re-open_account')?></button>
                                                     <?php }else{ ?>
                                                            <table id="datatable6" class="display table table-bordered dt-responsive" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo translate('s_no')?></th>
                                                                        <th><?php echo translate('image')?></th>
                                                                        <th><?php echo translate('member_id')?></th>
                                                                        <th><?php echo translate('name')?></th>
                                                                        <th><?php echo translate('time')?></th>
                                                                        <th><?php echo translate('message')?></th>
                                                                        <th><?php echo translate('options')?></th>
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
                                    </div>

            <div class="tab-pane fade" id="change_password" role="tabpanel" aria-labelledby="change_password-tab">
                <div class="row">
                    <div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                    <div class="activity">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3);">
                                    <div class="row">
                                            <div class="col-md-6 col-6">
                                                <h3><?php echo translate('change_password')?></h3>
                                            </div>
                                        </div>  
                                    <div class="group__bottom--area mt-2">
                                        <div class="group__bottom--group">
                                        <div class="activity__inner">
                                            <!-- ================> shop section start here <================== -->
                                            <div class="shop-page padding-bottom aside-bg">
                                            <div class="container">
                                            <div class="row justify-content-center">
                                            <div class="col-12 col-lg-9">
                                                <div class="contact-form-wrapper text-center">
                                                    <form class="contact-form" id="myForm" action="<?php echo base_url('LoginController/changePassword');?>" method="POST">
                                                        <div class="form-group w-100">
                                                            <input type="text" placeholder="<?php echo translate('current_password')?>" id="current_password" name="current_password" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="<?php echo translate('new_password');?>" name="new_password" id="new_password" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" placeholder="<?php echo translate('confirm_password')?>" name="confirm_password" id="confirm_password" required>
                                                        </div>
                                                        
                                                        <div class="form-group w-100 text-center">
                                                            <button class="default-btn reverse" type="button" onclick="return Validate()"><span><?php echo translate('submit')?></span></button>
                                                        </div>
                                                    </form>
                                                    <p class="form-message"></p>
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
            </div>
           
            <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                <div class="row">
                    <div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                    <div class="activity">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3);"  id="info_gallery">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <h3><?php echo translate('gallery')?></h3>
                                            </div>
                                        </div>  
                                    <div class="group__bottom--area mt-2">
                                        <div class="group__bottom--group">
                                        <div class="activity__inner">
                            <!-- ================> shop section start here <================== -->
                            <div class="shop-page padding-bottom aside-bg">
                            <div class="container">
                            <div class="row justify-content-center pb-15">
                            <div class="col-lg-12 col-12">
                            <article>
                                
                                <div class="shop-product-wrap grid row justify-content-center g-4" >
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <button type="button" class="default-btn mb-2" onclick="gallery_load('gallery')"><?php echo translate('upload_image')?></button>
                                        </div>
                                    </div>
                                    <div class="story__content--author mt-3 pb-2">
                                        <div class="row g-2">
                                            <?php 
                                            $get_gallery = $this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->gallery;
                                            $gallery_data = json_decode($get_gallery, true);
                                            if (!empty($gallery_data)) { $i=0;
                                                foreach ($gallery_data as $value) {$i++;
                                                ?>
                                                
                                                <?php
                                            if (file_exists('uploads/profile_image/'.$value['image'])) {
                                            ?>
                                            <div class="col-md-4 col-12">
                                            <div class="card">
                                              <div class="card-header">
                                                <div class="row mb-2">
                                                <div class="col-md-3 col-4">
                                                  <a href="<?php echo base_url('WelcomeController/deleteGalleryImage/'.$getUser->member_id.'/'.$value['index']);?>" onclick="return confirm('Are you sure want to delete this?');"><i class="fa fa-trash"></i></a>
                                                </div>
                                                <div class="col-md-6 col-4">
                                                 
                                                <form class="contact-form" action="<?php echo base_url('WelcomeController/saveProfileImage/'.$getUser->member_id); ?>" method="POST" enctype="multipart/form-data"> 
                                                    <button id="save_button" class="btn btn-primary" type="submit"><?php echo translate('add')?> </button>
                                                   
                                                  
                                                  <div style="display: none;">
                                                    <input type="text" name="profile_image" value="<?=base_url()?>/uploads/profile_image/<?=$value['image']?>">
                                                    <input type="text" name="image_name" value="<?=$value['image']?>">
                                                  </div>
                                                </form>
                                                </div>
                                                <div class="col-md-3 col-4">
                                                   <?php if($profile_image[0]['profile_image']==$value['image']){?>
                                                      <i class="fa fa-check text-success"></i>
                                                  <?php } ?>
                                                </div>
                                              </div>
                                              </div>
                                              <div class="card-body">
                                                
                                                  <a href="#groupmodal<?php echo $i;?>" data-rel="lightcase:callection"><img style="width: 100%;height: 160px;object-fit: cover;" src="<?=base_url()?>uploads/profile_image/<?=$value['image']?>" alt="dating thumb" id="profile"></a>
                                              
                                              </div>
                                            </div>
                                          </div>
                                            
                                        <?php } else {   ?>

                                        <?php } ?>
                                            <div class="groupmodal" id="groupmodal<?php echo $i;?>">
                                        <div class="container">
                                            <div class="groupmodal__area">
                                                <div class="post-item">
                                                    <div class="post-content">
                                                        
                                                        
                                                        <div class="post-description">
                                                            
                                                            <div class="post-desc-img">
                                                                <img src="<?=base_url()?>uploads/profile_image/<?=$value['image']?>" alt="dating thumb">
                                                            </div>
                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                        <?php } } ?>
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
    </div>
</div>
    <div class="card" style="display:none;border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3);"  id="edit_gallery">
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <h3><?php echo translate('gallery')?></h3>
                                            </div>
                                        </div>  
                                    <div class="group__bottom--area mt-2">
                                        <div class="group__bottom--group">
                                        <div class="activity__inner">
                                    <!-- ================> shop section start here <================== -->
                                    <div class="shop-page padding-bottom aside-bg">
                                    <div class="container">
                                    <div class="row justify-content-center pb-15">
                                    <div class="col-lg-12 col-12">
                                    <article>
                                        <div class="shop-product-wrap grid row justify-content-center g-4" >
                                           
                                            <div class="col-12 col-lg-12">
                                                <div class="contact-form-wrapper text-center">
                                                    <form class="contact-form" action="<?php echo base_url('WelcomeController/updateGalery');?>" method="POST" enctype="multipart/form-data">   
                                                    <input type="hidden" name="member_id" value="<?php echo $getUser->member_id;?>"> 
                                                        <div class="form-group w-100">
                                                            <input type="text" placeholder="Image Tittle" id="subject" name="title" required>
                                                        </div>
                                                        <div class="form-group">
                                                        <input type="file" name="image" id="image">
                                                        </div>
                                                        <div class="form-group w-100 text-center">
                                                            <div class="row">
                                                                <div class="col-md-6 col-6">
                                                                    <button onclick="gallery_back('gallery')" class="default-btn mt-2" type="button"><span><?php echo translate('go_back')?></span></button>
                                                                </div>
                                                                <div class="col-md-6 col-6">
                                                                     <button class="default-btn mt-2 reverse" type="submit"><span><?php echo translate('upload')?></span></button>
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
            </div>
        </div>
    </div>
</div>
<!-- ================> shop section end here <================== -->
</div>
</div>
</div>
</div>
<div class="tab-pane fade" id="happy_story" role="tabpanel" aria-labelledby="happy_story-tab">
                <div class="row">
                    <div class="col-lg-3 col-12 mt-3" >
                        <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3); background-color: #eb1464e8;">
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
                    <div class="activity">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="card" style="border: none;padding: 30px;box-shadow: 0 20px 30px rgba(136, 136, 136, 0.3);">
                                      
                                    <div class="group__bottom--area mt-2"  id="info_introduction">
                                        <div class="group__bottom--group">
                                        <div class="activity__inner">
                                          <?php 
                                          if ($getUser->membership == 1)
                                          {
                                          ?>
                                            <div class="row">
                                                <div class="col-md-7 col-10">
                                                    <h6><span><?php echo translate('your_story')?></span></h6>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
                                                    <p><?=translate('please_upgrade_to_premium_membership_to_post_your_stories')?></p>
                                                    <a href="<?=base_url()?>Subscription" class="default-btn"><?=translate('get_premium_membership')?></a>
                                                </div>
                                            </div>
                                        <?php }else{ ?>
                                            <?php
                                        $story_exist = $this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->result();
                                    ?>

                                        <div class="row">
                                            <div class="col-md-7 col-10">
                                                <h6><span><?php 
                                                if ($story_exist) {
                                                    echo translate('your_story');
                                                }
                                                else {
                                                    echo translate('upload_your_story');      
                                                }
                                            ?></span></h6>
                                            <?php
                                            if ($story_exist) {
                                                if ($this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->row()->approval_status == "1") {
                                            ?>
                                                    <span class="badge badge-md badge-pill bg-success"><?=translate('approved')?></span>
                                            <?php } else{ ?>
                                                    <span class="badge badge-md badge-pill bg-danger"><?=translate('not_approved')?></span>
                                            <?php } } ?>
                                            </div>
                                        </div>
                                        <?php
                                        $get_story = $this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->result();
                                        if ($story_exist) {
                                        foreach ($get_story as $value) 
                                        {
                                        ?> 
                                        <?php 

                                        $is_approved = $this->db->get_where("happy_story",array("posted_by" => $getUser->member_id))->row()->approval_status;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                        
                                        <div class="row">
                                            <div class="col-md-6 col-6">
                                                <p><?= date_format(date_create($value->post_time),"d, F Y")?></p>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <a class="default-btn mt-2" href="<?php if($is_approved == '1'){echo base_url()?>WelcomeController/storyDetails/<?=$value->posted_by;}else{echo '#';}?>">
                                                <?=$value->title?>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    </div>
                                    <?php 
                                        $images = json_decode($value->image, true);
                                    ?>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="main-wrapper">
                                                <div class="slider-btns">
                                                  <span id="prev-btn"><i class="fa-solid fa-chevron-left"></i></span>
                                                  <span id="next-btn"><i class="fa-solid fa-angle-right"></i></span>
                                                </div>
                                                <div class="slider-wrapper">
                                                  <div class="dots">
                                                    <div class="dot"></div>
                                                    <div class="dot"></div>
                                                    <div class="dot"></div>

                                                  </div>
                                              <?php
                                                $i = 0; 
                                                if(!empty($images)){
                                                foreach ($images as $image){ ?>
                                                  <div class="slides">
                                              <div class="blog__item">
                                                <div class="blog__inner">
                                                    <div class="blog__thumb">
                                                        <a href="blog-single.html">
                                                            <img style="object-fit: contain" src="<?php echo base_url();?>uploads/happy_story_image/<?=$image['img']?>" alt="blog">
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    <?php } }?>
                                    
                                    

                                    </div>

                                    </div>
                                    <p class="mt-2"><?php echo $value->description?></p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="blog__item">
                                        <div class="blog__inner">
                                            <div class="blog__thumb">
                                                <?php
                                                $video_exist = $this->db->get_where("story_video",array("story_video_uploader_id" => $getUser->member_id))->result();
                                                if ($video_exist) {
                                                    $get_video = $this->db->get_where("story_video", array("story_video_uploader_id" => $getUser->member_id))->result_array();
                                                    foreach ($get_video as $video) {?>
                                                    <?php if($video['type'] == 'upload'){?>
                                                <video controls height="450" width="80%">
                                                <source src="<?php echo base_url();?><?php echo $video['video_src'];?>">
                                                </video>
                                                <?php }else{?>
                                                    <iframe controls="2" height="450" width="80%" 
                                                src="<?php echo $video['video_link'];?>" frameborder="0" >
                                                </iframe>
                                            <?php } } } ?>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    <?php } } else{ ?>
                                    <div class="row justify-content-center mt-5">
                                        <div class="col-12 col-lg-9">
                                            <div class="contact-form-wrapper text-center">
                                                <h3 class=" mb-5"><?php echo translate('happy_story')?></h3>
                                                
                                                <form class="contact-form" action="<?php echo base_url('WelcomeController/saveHappyStory/');?>"  method="POST" enctype="multipart/form-data">
                                                    <div class="form-group w-100">
                                                        <input type="text" placeholder="<?php echo translate('story_title')?>" id="title" name="title" required="required">
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <textarea placeholder="<?php echo translate('story_details')?>" class="form-control" name="description" id="" rows="6" required></textarea>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <input type="date" placeholder="<?php echo translate('date')?>" id="post_time" name="post_time" required>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <input type="text" placeholder="<?php echo translate('partner_name')?>" id="partner_name" name="partner_name" required>
                                                    </div>
                                                    <div class="form-group w-100">
                                                        <div class="row">
                                                            <div class="col-md-6 col-6">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <img style="height: 130px;object-fit: contain;" src="<?=base_url()?>uploads/happy_story_image/default_image.jpg" id="pimage_preview3"> 
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="file" class="form-control mt-2" id="pimage" name="image[]" onchange="document.getElementById('pimage_preview3').src = window.URL.createObjectURL(this.files[0])">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-6">
                                                                <div class="row">
                                                                    <div style="height: 130px;object-fit: contain;" class="col-md-12">
                                                                        <img src="<?=base_url()?>uploads/happy_story_image/default_image.jpg" id="pimage_preview2"> 
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <input type="file" class="form-control mt-2" id="pimage" name="image[]" onchange="document.getElementById('pimage_preview2').src = window.URL.createObjectURL(this.files[0])">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                      </div>
                                                    <div class="form-group w-100">
                                                       <div class="col-md-12 select_div" id="vid_main">
                                                        <h6><?php echo translate('upload_video')?></h6> <br>
                                                        <div class="mt-2" id="vid_detail" style="display: none">
                                                            <label class="control-label"><?php echo translate('upload_method')?> <span class="text-danger">*</span></label>
                                                            <select class="form-control mt-2" name="upload_method" onchange="video_sector(this.value)">
                                                                <option selected disabled><?php echo translate('choose_an_option'); ?></option>
                                                                <option value="upload"><?php echo translate('upload_video') ?></option>
                                                                <option value="share"><?php echo translate('share_link'); ?></option>
                                                            </select>
                                                            <div class="mt-1" id="video_upload" style="display:none">
                                                                <label class="btn btn-styled btn-xs btn-base-2 btn-shadow ml-1" for="videoInp" style="margin: 5px 0px !important;cursor: pointer;"><?=translate('select_a_video')?></label><span class="text-danger video_limit_msg" style="margin-left: 10px; font-size: 12px"><?php echo translate("max_limit_25_Mb"); ?></span>
                                                                <input class="form-control videoInp" id="videoInp" type="file" name="upload_video" style="display: none" accept="video/*"/>
                                                                <div id="message"></div>
                                                                <label class="control-label"><?php echo translate('video_preview')?></label><br>
                                                                <video controls id="upload_story_video" width="250">
                                                                </video>
                                                            </div>
                                                            <div id="video_share" style="display:none;">
                                                                <label class="control-label mt-3"><?php echo translate('sharing_site')?></label>
                                                                <select class="form-control site mt-2" name="site">
                                                                    <option selected disabled><?php echo translate('choose_an_option'); ?></option>
                                                                    <option value="youtube"><?php echo translate('youtube') ?></option>
                                                                    <option value="dailymotion"><?php echo translate('dailymotion'); ?></option>
                                                                    <option value="vimeo"><?php echo translate('vimeo'); ?></option>
                                                                </select>
                                                                <label class="control-label mt-3"><?php echo translate('video_link')?></label>
                                                                <input type="text" id="video_link" name="video_link" class="form-control mt-2" onchange="preview(this.value)">                                        
                                                                <label class="control-label mt-3"><?php echo translate('video_preview')?></label>     
                                                                    <div class="text-center mt-2">
                                                                        <div id="video_preview">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" value="" id="vl" name="vl" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="btn_vid" class="form-group w-100 text-center mt-2">
                                                       <button type="button" class="default-btn" onclick="video_section()"><?php echo translate('upload_video')?></button> 
                                                   </div>
                                                    
                                                    <div class="form-group w-100 text-center mt-3">
                                                        <button class="default-btn reverse" type="submit"><span><?php echo translate('save');?></span></button>
                                                    </div>

                                                </form>
                                            </div>
                                                <p class="form-message"></p>
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
            </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 40%;width: 100% !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo translate('re-open_account')?></h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <p class="text-center">
            <?php echo translate('are_you_sure_to_re-open_the_account?');?>
        </p>
        <div class="row">
            <div class="col-md-12" style="margin-left: 40%;">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_yes2" value="yes" style="margin-right: 5px !important;">
                    <label><?php echo translate('yes')?></label>
                </div>
            </div>
            <div class="col-md-12" style="margin-left: 40%;">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_no2" value="no" style="margin-right: 5px !important;">
                    <label><?php echo translate('no')?></label>
                </div>
            </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
        <button type="button" class="btn btn-primary" id="reopen_btn"><?php echo translate('Confirm')?></button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalTwo" tabindex="-1" role="dialog" aria-labelledby="exampleModalTwoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 30%; width: 100% !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalTwoLabel"><?php echo translate('close_account')?></h5>
        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><?php echo translate('to_colse_your_account_we_want_some_informations._please_answer_the_question_below') ?></h6>
        <p class="text-center">
            <?php echo translate('do_you_realy_want_to_close_your_account?');?>
        </p>
        <div class="row">
            <div class="col-md-12" style="margin-left: 40%;">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_yes" value="yes" style="margin-right: 5px !important;">
                    <label><?php echo translate('yes')?></label>
                </div>
            </div>
            <div class="col-md-12" style="margin-left: 40%;">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_no" value="no" style="margin-right: 5px !important;">
                    <label><?php echo translate('no')?></label>
                </div>
            </div>
            <div class="col-md-12 mt-3" style="display: none;" id="close_reason">
                <div class="form-group d-flex">
                    <select class="form-control" name="reason_closed" id="reason_closed">
                      <option value=""><?php echo translate('choose_one');?></option>
                      <option value="fixed">fixed</option>
                      <option value="OTHERS"><?php echo translate('OTHERS');?></option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mt-3" style="display: none;" id="other_close_reason">
                <div class="form-group d-flex">
                    <textarea type="text" name="reason_closed_other" id="reason_closed_other" class="form-control"></textarea>
                </div>
            </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
        <button type="button" class="btn btn-primary" id="confirm_btn"><?php echo translate('Confirm')?></button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="interestModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 40%;width: 100% !important;">
      <div class="modal-header">
        <h5 class="modal-title" id="interestModalLabel"><?php echo translate('express_interest')?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><?php echo translate('you_have_no_express_interests_left. please_buy_any_package_from_premium_plans.')?></p>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo translate('close');?></button>
        <a href="<?php echo base_url('Subscription');?>" type="button" class="btn btn-primary" id="reopen_btn"><?php echo translate('premium_plans')?></a> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="profile_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo translate('image');?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
         $member = getData('member','row',array('member_id'=>$member_id));?>
         <?php if($member->image_count>0){?>
         <h5>Remain profile Upload : <?php echo $member->image_count;?> Of 3</h5>
        <?php }else{ ?>
        <h5>Remain profile Upload  Was Completed</h5>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal"><?php echo translate('close')?></button>
        <?php if($member->image_count>0){?>
        <button type="button" id="save" class="btn btn-primary"><?php echo translate('save')?></button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="matchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo translate('match');?></h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p><?php echo translate('happy_married_life')?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal"><?php echo translate('close')?></button>
        
      </div>
    </div>
  </div>
</div>

<div id="edit_output"></div>
<script>
// $.noConflict();
// $ = jQuery.noConflict();





function deleteShortlist(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/deleteShortlist',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function remove_shortlist(m_id) 
{
$("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
setTimeout(function() {
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>WelcomeController/remove_shortlist/"+m_id,
        cache: false,
        success: function(response) {
            $('#success-alert10').show();
          setTimeout(function(){
            $('#success-alert10').hide();
          },3000);
            location.reload();
        },
        fail: function (error) {
            alert(error);
        }
    });
}, 500); // <-- time in milliseconds
}

function deleteFollow(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/deleteFollow',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

function add_unfollow(m_id) 
{
$("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
setTimeout(function() {
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>WelcomeController/add_unfollow/"+m_id,
        cache: false,
        success: function(response) {
            $('#success-alert8').show();
          setTimeout(function(){
            $('#success-alert8').hide();
          },3000);
            location.reload();
        },
        fail: function (error) {
            alert(error);
        }
    });
}, 500); // <-- time in milliseconds
}

function confirm_unblock(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/confirmUnblock',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

function unblockMember(m_id) 
{
$("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
setTimeout(function() {
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>WelcomeController/unblockMember/"+m_id,
        cache: false,
        success: function(response) {
            $('#success-alert9').show();
          setTimeout(function(){
            $('#success-alert9').hide();
          },3000);
            location.reload();
        },
        fail: function (error) {
            alert(error);
        }
    });
}, 500); // <-- time in milliseconds
}

function Validate() {
            var current_password = document.getElementById("current_password").value;
            var password = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            if(!password.match(passw)){
                $('#success-alert14').show();
                          setTimeout(function(){
                            $('#success-alert14').hide();
                          },5000);
            }else if(password != confirmPassword){
                $('#success-alert13').show();
                          setTimeout(function(){
                            $('#success-alert13').hide();
                          },3000);
            }else{
            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>LoginController/passwordProfileVerify/",
                    data: '&current_password='+current_password,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        if(response==2){
                             $('#success-alert12').show();
                          setTimeout(function(){
                            $('#success-alert12').hide();
                          },3000);
                          // location.reload();
                        }else{
                             document.getElementById("myForm").submit();
                        }
                       
                        
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }
        }


document.getElementById('confirm_password').onkeyup=function(){
    var password = $("#new_password").val();
    var confirm_password = $("#confirm_password").val();
    if(password != confirm_password) {
           $("#confirm_password").css('border-color', "red");
    }else{
           $("#confirm_password").css('border-color', "green");
        }
}



</script>

