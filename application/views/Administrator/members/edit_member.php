<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<?php 
// print_r($states);exit;
    $images = json_decode($single_member->profile_image);
    $astronomic = json_decode($single_member->astronomic_information);
    $mariage_status = json_decode($single_member->basic_info);
    $educations = json_decode($single_member->education_and_career);
    $Physics = json_decode($single_member->physical_attributes);
    $permanents = json_decode($single_member->permanent_address);
    $family_member = json_decode($single_member->family_info);
    $expectations = json_decode($single_member->partner_expectation);
    $raasis = json_decode($single_member->chart);
    // print_r($raasis);exit;
    // foreach($permanents as $permanent){
    // print_r(stateTranslate($permanent->permanent_state));exit();}
    $role = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'];
    // print_r($raasis);exit;
    if(!empty($raasis)){  
     foreach($raasis as $raasi)
    { 
        
        $rasi['f010'] = (isset($raasi->f010)) ? $raasi->f010 : "";
        $rasi['f011'] = (isset($raasi->f011)) ? $raasi->f011 : "";
        $rasi['f012'] = (isset($raasi->f012)) ? $raasi->f012 : "";
        $rasi['f013'] = (isset($raasi->f013)) ? $raasi->f013 : "";
        $rasi['f014'] = (isset($raasi->f014)) ? $raasi->f014 : "";
        $rasi['f015'] = (isset($raasi->f015)) ? $raasi->f015 : ""; 

        $rasi['f020'] = (isset($raasi->f020)) ? $raasi->f020 : "";
        $rasi['f021'] = (isset($raasi->f021)) ? $raasi->f021 : "";
        $rasi['f022'] = (isset($raasi->f022)) ? $raasi->f022 : "";
        $rasi['f023'] = (isset($raasi->f023)) ? $raasi->f023 : "";
        $rasi['f024'] = (isset($raasi->f024)) ? $raasi->f024 : "";
        $rasi['f025'] = (isset($raasi->f025)) ? $raasi->f025 : "";

        $rasi['f030'] = (isset($raasi->f030)) ? $raasi->f030 : "";
        $rasi['f031'] = (isset($raasi->f031)) ? $raasi->f031 : "";
        $rasi['f032'] = (isset($raasi->f032)) ? $raasi->f032 : "";
        $rasi['f033'] = (isset($raasi->f033)) ? $raasi->f033 : "";
        $rasi['f034'] = (isset($raasi->f034)) ? $raasi->f034 : "";
        $rasi['f035'] = (isset($raasi->f035)) ? $raasi->f035 : "";

        $rasi['f040'] = (isset($raasi->f040)) ? $raasi->f040 : "";
        $rasi['f041'] = (isset($raasi->f041)) ? $raasi->f041 : "";
        $rasi['f042'] = (isset($raasi->f042)) ? $raasi->f042 : "";
        $rasi['f043'] = (isset($raasi->f043)) ? $raasi->f043 : "";
        $rasi['f044'] = (isset($raasi->f044)) ? $raasi->f044 : "";
        $rasi['f045'] = (isset($raasi->f045)) ? $raasi->f045 : "";

        $rasi['f110'] = (isset($raasi->f110)) ? $raasi->f110 : "";
        $rasi['f111'] = (isset($raasi->f111)) ? $raasi->f111 : "";
        $rasi['f112'] = (isset($raasi->f112)) ? $raasi->f112 : "";
        $rasi['f113'] = (isset($raasi->f113)) ? $raasi->f113 : "";
        $rasi['f114'] = (isset($raasi->f114)) ? $raasi->f114 : "";
        $rasi['f115'] = (isset($raasi->f115)) ? $raasi->f115 : ""; 

        $rasi['f210'] = (isset($raasi->f210)) ? $raasi->f210 : "";
        $rasi['f211'] = (isset($raasi->f211)) ? $raasi->f211 : "";
        $rasi['f212'] = (isset($raasi->f212)) ? $raasi->f212 : "";
        $rasi['f213'] = (isset($raasi->f213)) ? $raasi->f213 : "";
        $rasi['f214'] = (isset($raasi->f214)) ? $raasi->f214 : "";
        $rasi['f215'] = (isset($raasi->f215)) ? $raasi->f215 : "";

        $rasi['f310'] = (isset($raasi->f310)) ? $raasi->f310 : "";
        $rasi['f311'] = (isset($raasi->f311)) ? $raasi->f311 : "";
        $rasi['f312'] = (isset($raasi->f312)) ? $raasi->f312 : "";
        $rasi['f313'] = (isset($raasi->f313)) ? $raasi->f313 : "";
        $rasi['f314'] = (isset($raasi->f314)) ? $raasi->f314 : "";
        $rasi['f315'] = (isset($raasi->f315)) ? $raasi->f315 : "";

        $rasi['f320'] = (isset($raasi->f320)) ? $raasi->f320 : "";
        $rasi['f321'] = (isset($raasi->f321)) ? $raasi->f321 : "";
        $rasi['f322'] = (isset($raasi->f322)) ? $raasi->f322 : "";
        $rasi['f323'] = (isset($raasi->f323)) ? $raasi->f323 : "";
        $rasi['f324'] = (isset($raasi->f324)) ? $raasi->f324 : "";
        $rasi['f325'] = (isset($raasi->f325)) ? $raasi->f325 : ""; 

        $rasi['f410'] = (isset($raasi->f410)) ? $raasi->f410 : "";
        $rasi['f411'] = (isset($raasi->f411)) ? $raasi->f411 : "";
        $rasi['f412'] = (isset($raasi->f412)) ? $raasi->f412 : "";
        $rasi['f413'] = (isset($raasi->f413)) ? $raasi->f413 : "";
        $rasi['f414'] = (isset($raasi->f414)) ? $raasi->f414 : "";
        $rasi['f415'] = (isset($raasi->f415)) ? $raasi->f415 : "";  

        $rasi['f420'] = (isset($raasi->f420)) ? $raasi->f420 : "";
        $rasi['f421'] = (isset($raasi->f421)) ? $raasi->f421 : "";
        $rasi['f422'] = (isset($raasi->f422)) ? $raasi->f422 : "";
        $rasi['f423'] = (isset($raasi->f423)) ? $raasi->f423 : "";
        $rasi['f424'] = (isset($raasi->f424)) ? $raasi->f424 : "";
        $rasi['f425'] = (isset($raasi->f425)) ? $raasi->f425 : "";

        $rasi['f430'] = (isset($raasi->f430)) ? $raasi->f430 : "";
        $rasi['f431'] = (isset($raasi->f431)) ? $raasi->f431 : "";
        $rasi['f432'] = (isset($raasi->f432)) ? $raasi->f432 : "";
        $rasi['f433'] = (isset($raasi->f433)) ? $raasi->f433 : "";
        $rasi['f434'] = (isset($raasi->f434)) ? $raasi->f434 : "";
        $rasi['f435'] = (isset($raasi->f435)) ? $raasi->f435 : "";

        $rasi['f440'] = (isset($raasi->f440)) ? $raasi->f440 : "";
        $rasi['f441'] = (isset($raasi->f441)) ? $raasi->f441 : "";
        $rasi['f442'] = (isset($raasi->f442)) ? $raasi->f442 : "";
        $rasi['f443'] = (isset($raasi->f443)) ? $raasi->f443 : "";
        $rasi['f444'] = (isset($raasi->f444)) ? $raasi->f444 : "";
        $rasi['f445'] = (isset($raasi->f445)) ? $raasi->f445 : "";


         

        $rasi['f510'] = (isset($raasi->f510)) ? $raasi->f510 : "";
        $rasi['f511'] = (isset($raasi->f511)) ? $raasi->f511 : "";
        $rasi['f512'] = (isset($raasi->f512)) ? $raasi->f512 : "";
        $rasi['f513'] = (isset($raasi->f513)) ? $raasi->f513 : "";
        $rasi['f514'] = (isset($raasi->f514)) ? $raasi->f514 : "";
        $rasi['f515'] = (isset($raasi->f515)) ? $raasi->f515 : ""; 

        $rasi['f520'] = (isset($raasi->f520)) ? $raasi->f520 : "";
        $rasi['f521'] = (isset($raasi->f521)) ? $raasi->f521 : "";
        $rasi['f522'] = (isset($raasi->f522)) ? $raasi->f522 : "";
        $rasi['f523'] = (isset($raasi->f523)) ? $raasi->f523 : "";
        $rasi['f524'] = (isset($raasi->f524)) ? $raasi->f524 : "";
        $rasi['f525'] = (isset($raasi->f525)) ? $raasi->f525 : "";

        $rasi['f530'] = (isset($raasi->f530)) ? $raasi->f530 : "";
        $rasi['f531'] = (isset($raasi->f531)) ? $raasi->f531 : "";
        $rasi['f532'] = (isset($raasi->f532)) ? $raasi->f532 : "";
        $rasi['f533'] = (isset($raasi->f533)) ? $raasi->f533 : "";
        $rasi['f534'] = (isset($raasi->f534)) ? $raasi->f534 : "";
        $rasi['f535'] = (isset($raasi->f535)) ? $raasi->f535 : "";

        $rasi['f540'] = (isset($raasi->f540)) ? $raasi->f540 : "";
        $rasi['f541'] = (isset($raasi->f541)) ? $raasi->f541 : "";
        $rasi['f542'] = (isset($raasi->f542)) ? $raasi->f542 : "";
        $rasi['f543'] = (isset($raasi->f543)) ? $raasi->f543 : "";
        $rasi['f544'] = (isset($raasi->f544)) ? $raasi->f544 : "";
        $rasi['f545'] = (isset($raasi->f545)) ? $raasi->f545 : "";

        $rasi['f610'] = (isset($raasi->f610)) ? $raasi->f610 : "";
        $rasi['f611'] = (isset($raasi->f611)) ? $raasi->f611 : "";
        $rasi['f612'] = (isset($raasi->f612)) ? $raasi->f612 : "";
        $rasi['f613'] = (isset($raasi->f613)) ? $raasi->f613 : "";
        $rasi['f614'] = (isset($raasi->f614)) ? $raasi->f614 : "";
        $rasi['f615'] = (isset($raasi->f615)) ? $raasi->f615 : ""; 

        $rasi['f710'] = (isset($raasi->f710)) ? $raasi->f710 : "";
        $rasi['f711'] = (isset($raasi->f711)) ? $raasi->f711 : "";
        $rasi['f712'] = (isset($raasi->f712)) ? $raasi->f712 : "";
        $rasi['f713'] = (isset($raasi->f713)) ? $raasi->f713 : "";
        $rasi['f714'] = (isset($raasi->f714)) ? $raasi->f714 : "";
        $rasi['f715'] = (isset($raasi->f715)) ? $raasi->f715 : "";

        $rasi['f810'] = (isset($raasi->f810)) ? $raasi->f810 : "";
        $rasi['f811'] = (isset($raasi->f811)) ? $raasi->f811 : "";
        $rasi['f812'] = (isset($raasi->f812)) ? $raasi->f812 : "";
        $rasi['f813'] = (isset($raasi->f813)) ? $raasi->f813 : "";
        $rasi['f814'] = (isset($raasi->f814)) ? $raasi->f814 : "";
        $rasi['f815'] = (isset($raasi->f815)) ? $raasi->f815 : "";

        $rasi['f820'] = (isset($raasi->f820)) ? $raasi->f820 : "";
        $rasi['f821'] = (isset($raasi->f821)) ? $raasi->f821 : "";
        $rasi['f822'] = (isset($raasi->f822)) ? $raasi->f822 : "";
        $rasi['f823'] = (isset($raasi->f823)) ? $raasi->f823 : "";
        $rasi['f824'] = (isset($raasi->f824)) ? $raasi->f824 : "";
        $rasi['f825'] = (isset($raasi->f825)) ? $raasi->f825 : ""; 

        $rasi['f910'] = (isset($raasi->f910)) ? $raasi->f910 : "";
        $rasi['f911'] = (isset($raasi->f911)) ? $raasi->f911 : "";
        $rasi['f912'] = (isset($raasi->f912)) ? $raasi->f912 : "";
        $rasi['f913'] = (isset($raasi->f913)) ? $raasi->f913 : "";
        $rasi['f914'] = (isset($raasi->f914)) ? $raasi->f914 : "";
        $rasi['f915'] = (isset($raasi->f915)) ? $raasi->f915 : "";  

        $rasi['f920'] = (isset($raasi->f920)) ? $raasi->f920 : "";
        $rasi['f921'] = (isset($raasi->f921)) ? $raasi->f921 : "";
        $rasi['f922'] = (isset($raasi->f922)) ? $raasi->f922 : "";
        $rasi['f923'] = (isset($raasi->f923)) ? $raasi->f923 : "";
        $rasi['f924'] = (isset($raasi->f924)) ? $raasi->f924 : "";
        $rasi['f925'] = (isset($raasi->f925)) ? $raasi->f925 : "";

        $rasi['f930'] = (isset($raasi->f930)) ? $raasi->f930 : "";
        $rasi['f931'] = (isset($raasi->f931)) ? $raasi->f931 : "";
        $rasi['f932'] = (isset($raasi->f932)) ? $raasi->f932 : "";
        $rasi['f933'] = (isset($raasi->f933)) ? $raasi->f933 : "";
        $rasi['f934'] = (isset($raasi->f934)) ? $raasi->f934 : "";
        $rasi['f935'] = (isset($raasi->f935)) ? $raasi->f935 : "";

        $rasi['f940'] = (isset($raasi->f940)) ? $raasi->f940 : "";
        $rasi['f941'] = (isset($raasi->f941)) ? $raasi->f941 : "";
        $rasi['f942'] = (isset($raasi->f942)) ? $raasi->f942 : "";
        $rasi['f943'] = (isset($raasi->f943)) ? $raasi->f943 : "";
        $rasi['f944'] = (isset($raasi->f944)) ? $raasi->f944 : "";
        $rasi['f945'] = (isset($raasi->f945)) ? $raasi->f945 : "";
    } }
        
       
?>

<div class="row">
    <div class="col-lg-4">
        <a title="<?php echo translate('go_back');?>" href="<?php echo base_url('administrator/all_members/view_member/'.$single_member
        ->member_id);?>" class="btn btn-danger btn-sm btn-icon waves-effect waves-light mb-3"><i class="ri-arrow-left-line"></i></a>
        <div class="team-list grid-view-filter row">
        <div class="card team-box ribbon-box">
                <div class="team-cover mt-1">
                    <img src="<?php echo base_url('uploads/profile_image/banner.jpg');?>" alt="" class="img-fluid" />
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center team-row">
                        <div class="col team-settings">
                            <div class="row">
                                <div class="col">
                                    <div class="bookmark-icon flex-shrink-0 me-2">
                                        <input type="checkbox" id="favourite1" class="bookmark-input bookmark-hide">
                                        <label for="favourite1" class="btn-star">
                                            <svg width="20" height="20">
                                                <use xlink:href="#icon-star" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>
                                <div class="col text-end dropdown">
                                    <a href="javascript:void(0);" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill fs-17"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                        <li><a class="dropdown-item" onclick="blockMember(<?php echo $single_member->prefixId;?>)"><i class="mdi mdi-account-cancel me-2 align-middle"></i><?php echo translate('block');?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo base_url('administrator/deleteMember/'.$single_member->member_profile_id) ;?>" 
                                    onclick="return confirm('Are you sure want to delete this?');"><i class="ri-delete-bin-5-line me-2 align-middle"></i><?php echo translate('delete');?> </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col">
                            <div class="team-profile-img">
                                <div class="avatar-lg img-thumbnail rounded-circle shadow flex-shrink-0">
                                
                                <?php
                                    if(!empty($images)){
                                    foreach($images as $image){?>

                                <img src="<?php echo (!empty($image)) ? base_url('uploads/profile_image/'.$image->profile_image) : base_url('uploads/profile_image/no_image.jpg') ;?>" class="img-fluid d-block rounded-circle" alt=""/ style="height: 100%;object-fit: contain;">
                                 <?php } } else{?>
                                    <img src="<?php echo  base_url('uploads/profile_image/no_image.jpg') ;?>" class="img-fluid d-block rounded-circle" alt=""/ style="height: 100%;object-fit: contain;">
                                    <?php } ?>
                                </div>
                                <div class="team-content">
                                    <form action="<?php echo base_url('AdminController/updateProfileimage/');?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="member_id" value="<?php echo $single_member->member_id;?>">
                                            <input type="hidden" name="member_profile_id" value="<?php echo $single_member->member_profile_id;?>">
                                            <div class="col-lg-9">
                                                <input type="file" name="profile_image" class="form-control">
                                                <input type="hidden" name="thumb" value="<?php echo (!empty($image->thumb)) ? $image->thumb : "";?>">
                                            </div>
                                            <div class="col-lg-3">
                                                <button title="<?php echo translate('save');?>" type="submit" class="btn btn-info waves-effect waves-light"><?php echo translate('save');?></button>
                                            </div>
                                        </div>
                                    </form>
                                    
                                <h4 class="text-center mt-3"><?php echo $single_member->first_name;?></h4>
                                <?php if(!empty($educations)){ foreach($educations as $education){?>
                                <h6 class="text-center mt-3"><?php echo dropdownTranslate($education->Type_of_occupation);?></h6>
                            <?php } } ?>
                             <?php if(!empty($permanents)){ foreach($permanents as $permanent){?>
                                <h6 class="text-center mt-3"><?php echo (!empty($permanent->permanent_state)) ? dropdownTranslate($permanent->permanent_state):'';?></h6>
                             <?php } } ?>
                             <h6 class="text-center mt-3"><?php echo translate('profile_downloads');?>: <?php echo $single_member->remain_download;?></h6>
                             <div class="text-center mt-2">
                            <?php if($single_member->is_blocked=='no'){?>
                                 <button title="<?php echo translate('block');?>" onclick="blockMember(<?php echo $single_member->prefixId;?>)" class="btn btn-xs btn-outline-info btn-border"><?php echo translate('block');?> </button>
                            <?php }else{?>
                                <a title="<?php echo translate('unblock');?>" href="<?php echo base_url('administrator/unblockMember/'.$single_member->prefixId);?>" onclick="return confirm('Are you sure want to unBlock this?');" class="btn btn-xs btn-outline-info btn-border"><?php echo translate('unblock');?> </a>
                            <?php } ?>
                            <?php if($single_member->is_closed=='no'){?>
                                 <button title="<?php echo translate('close');?>" onclick="closeMember(<?php echo $single_member->prefixId;?>)" class="btn btn-xs btn-outline-danger btn-border"><?php echo translate('close');?> </button>
                            <?php }else {  ?>   
                                <a title="<?php echo translate('open');?>" href="<?php echo base_url('administrator/unclosemember/'.$single_member->prefixId);?>" onclick="return confirm('Are you sure want to unClose this?');" class="btn btn-xs btn-outline-danger btn-border"><?php echo translate('open');?> </a>
                            <?php } ?>
                            </div>
                            <h4 class="text-center mt-3"><?php echo $single_member->follower;?></h4>
                            <h5 class="text-center"><?php echo translate('followers');?></h5>
                            <?php $status=getStatusLabel($single_member->active_status);?>
                            <h5 class="text-center mt-3"><?php echo $status;?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        
            <form method="post" action="<?php echo base_url('AdminController/updateMember/');?>">
        <div class="row">
            <div class="col-lg-4">
                <h5><b><?php echo translate('member_id');?> :</b> <?php echo $single_member->member_profile_id;?></h5>
            </div>
            
            <div class="col-lg-8">
                <div class="mb-3 text-end">
                    <button title="<?php echo translate('update');?>" type="submit" class="btn btn-success btn-sm btn-label waves-effect waves-light"><i class="fa fa-floppy-o label-icon align-middle fs-16 me-2"></i><?php echo translate('update');?></button>
                </div>
            </div>
        </div>
        <div class="row">
            <input type="hidden" name="member_id" value="<?php echo $single_member->member_id;?>">
            <input type="hidden" name="member_profile_id" value="<?php echo $single_member->member_profile_id;?>">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('introduction');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                   <div class="col-lg-12">
                                        <textarea type="text" name="introduction" class="form-control"><?php echo ($single_member->introduction)? $single_member->introduction : "";?></textarea>
                                    </div> 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('basic_information');?></h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('name');?></label>
                                    <input type="text" name="first_name" value="<?php echo $single_member->first_name;?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('email');?></label>
                                    <input type="text" name="email" value="<?php echo $single_member->email;?>" class="form-control">
                            </div>
                            <?php if(!empty($mariage_status)){ 
                                foreach($mariage_status as $mariages){?>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('martial_status');?></label>
                                <select class="form-select mb-3" name="marital_status" id="marital_status" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                <?php $i=0; foreach($mariages_status as $mariage){ $i++;?>
                                    
                                        <option data-id='<?php echo $i;?>' <?php echo ($mariages->marital_status==$mariage->name)? 'selected':'';?> value="<?php echo $mariage->name;?>"><?php echo dropdownTranslate($mariage->name);?></option>
                                <?php } ?>
                                </select>
                            </div>
                            
                            <div class="col-lg-6 mt-2"  style="display: none;" id="no_of_child">
                                <label for="basiInput" class="form-label"><?php echo translate('number_of_children');?></label>
                                    <input type="number" name="number_of_children" value="<?php echo $mariages->number_of_children;?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2"  style="display: none;" id="child_live_place">
                                <label for="basiInput" class="form-label"><?php echo translate('Child_living_place');?></label>
                                <select class="form-select mb-3" name="Child_living_place" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(15);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (isset($mariages->Child_living_place) ? (($mariages->Child_living_place==$value->word)? 'selected':'') : "");?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                             </div>
                            <?php } } else{ ?>
                                <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('martial_status');?></label>
                                <select class="form-select mb-3" name="marital_status" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                <?php foreach($mariages_status as $mariage){?>
                                    
                                    <option value="<?php echo $mariage->name;?>"><?php echo dropdownTranslate($mariage->name);?></option>
                            <?php } ?>
                                </select>
                            </div>
                            
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('number_of_children');?></label>
                                    <input type="number" name="number_of_children" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Child_living_place');?> </label>
                                <select class="form-select mb-3" name="Child_living_place" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(15);
                                    foreach($drop_down as $value){?>
                                    <option value="<?php echo $value->word; ?>"><?php echo $value->word; ?></option>
                                    <?php } ?>
                                </select>
                             </div>
                             <?php }  ?>
                             <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('password');?></label>
                                    <input type="text" name="password" class="form-control">
                            </div>
                        </div>
                </div>
            </div>
        </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('education_and_career');?></h5>
                        <div class="row">
                            <?php if(!empty($educations)) { 
                                foreach($educations as $education){
                                    ?>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Type_of_study');?></label>
                                    <select class="form-select mb-3" name="Type_of_study"
                                    id="Type_of_study" aria-label="Default select example" required>
                                        <?php $drop_down = get_dropdown(3);
                                        foreach($drop_down as $value){?>
                                        <option data="<?php echo $value->word ; ?>" <?php echo ($education->Type_of_study==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-lg-6" id="study_other" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('OTHERS')?></label>
                                    <input type="text" name="other_study" id="other_study" value="<?php if(!empty($education && !empty( $education->other_study))){echo $education->other_study;}?>" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('STUDY_DETAILS');?></label>
                                    <input type="text" name="STUDY_DETAILS" value="<?php echo $education->STUDY_DETAILS;?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Type_of_occupation');?>  </label>
                                    <select class="form-select mb-3" name="Type_of_occupation" id="Type_of_occupation" aria-label="Default select example">
                                        <?php $drop_down = get_dropdown(4);
                                        foreach($drop_down as $value){?>
                                        <option data="<?php echo $value->word ; ?>" <?php echo ($education->Type_of_occupation==$value->word)? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-lg-6" id="occupation_other" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('Other_Occupation_Details')?></label>
                                    <input type="text" name="Other_Occupation_Details" value="<?php if(!empty($education && !empty( $education->Other_Occupation_Details))){echo $education->Other_Occupation_Details;}?>" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Career_Profile');?></label>
                                    <input type="text" name="Career_Profile" value="<?php echo $education->Career_Profile;?>" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('annual_income');?></label>
                                    <input type="text" name="annual_income" value="<?php echo $education->annual_income;?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('earnings');?></label>
                                    <select class="form-select mb-3" name="Earnings" aria-label="Default select example">
                                        <option value=""><?php echo translate('choose_one');?></option>
                                        <?php $drop_down = get_dropdown(16);
                                        foreach($drop_down as $value){?>
                                        <option <?php echo (isset($education->Earnings) ? (($education->Earnings==$value->word)? 'selected':'') : "");?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                             <?php } } else{  ?>

                                <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Type_of_study');?></label>
                                    <select class="form-select mb-3" name="Type_of_study" aria-label="Default select example">
                                        <?php $drop_down = get_dropdown(3);
                                        foreach($drop_down as $value){?>
                                        <option value="<?php echo $value->word; ?>"><?php echo $value->word; ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('STUDY_DETAILS');?></label>
                                    <input type="text" name="STUDY_DETAILS" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Type_of_study');?>  </label>
                                    <select class="form-select mb-3" name="Type_of_occupation" aria-label="Default select example">
                                        <?php $drop_down = get_dropdown(4);
                                        foreach($drop_down as $value){?>
                                        <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Career_Profile');?></label>
                                    <input type="text" name="Career_Profile" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('annual_income');?></label>
                                    <input type="text" name="annual_income" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('earnings');?></label>
                                    <select class="form-select mb-3" name="Earnings" aria-label="Default select example">
                                        <option value=""><?php echo translate('choose_one');?></option>
                                        <?php $drop_down = get_dropdown(16);
                                        foreach($drop_down as $value){?>
                                        <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                        <?php } ?>
                                    </select>
                            </div>
                            <?php } ?>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('physical_attributes');?></h5>
                        <div class="row">
                            <?php if(!empty($Physics)){
                                 foreach($Physics as $physical){?>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('height');?><span><?=translate('feet')?></span></label>
                                <input type="number" name="height" value="<?php echo $single_member->height;?>" class="form-control" step=".01" min="0" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('weight');?></label>
                                <input type="number" name="weight" value="<?php echo $physical->weight;?>" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('eye_color');?></label>
                                    <input type="text" name="eye_color" value="<?php echo $physical->eye_color;?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('hair_color');?></label>
                                
                                    <input type="text" name="hair_color" value="<?php echo $physical->hair_color;?>" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('complexion');?> </label>
                                    <input type="text" name="complexion" value="<?php echo $physical->complexion;?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('blood_group');?></label>
                                
                                    <input type="text" name="blood_group" value="<?php echo $physical->blood_group;?>" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('body_type');?> </label>
                                    <input type="text" name="body_type" value="<?php echo $physical->body_type;?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('body_art');?></label>
                                
                                    <input type="text" name="body_art" value="<?php echo $physical->body_art;?>" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('any_disability');?></label>
                                
                                    <input type="text" name="any_disability" value="<?php echo $physical->any_disability;?>" class="form-control">
                               
                            </div>
                             <?php } } else{ ?>
                                <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('height');?></label>
                                <input type="number" name="height" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('weight');?></label>
                                <input type="number" name="weight" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('eye_color');?></label>
                                    <input type="text" name="eye_color" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('hair_color');?></label>
                                
                                    <input type="text" name="hair_color" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('complexion');?> </label>
                                    <input type="text" name="complexion" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('blood_group');?></label>
                                
                                    <input type="text" name="blood_group" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('body_type');?> </label>
                                    <input type="text" name="body_type" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('body_art');?></label>
                                
                                    <input type="text" name="body_art" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('any_disability');?></label>
                                
                                    <input type="text" name="any_disability" class="form-control">
                               
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('astronomic_information');?></h5>
                        <div class="row">
                            <?php 
                            // print_r($astronomic);
                            if(!empty($astronomic)){

                                foreach($astronomic as $astro) { ?>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('date_of_birth');?></label>
                                <input type="text" name="date_of_birth" value="<?php echo date('d-M-Y',strtotime($astro->date_of_birth));?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('birthDay');?> </label>
                                
                                    <input type="text" name="birthDay" value="<?php echo $astro->birthDay;?>" class="form-control" required>
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('time_of_birth');?></label>
                                
                                    <input type="text" name="time_of_birth" value="<?php echo (!empty($astro->time_of_birth)) ? $astro->time_of_birth :'';?>" class="form-control" required>
                               
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('city_of_birth');?> </label>
                                    <input type="text" name="city_of_birth" value="<?php echo (!empty($astro->city_of_birth)) ? $astro->city_of_birth :'';?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('PAKSHA');?> </label>
                                <select class="form-select mb-3" name="PAKSHA" aria-label="Default select example" id="paksha" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(6);
                                    foreach($drop_down as $value){?>
                                    <option data="<?php echo $value->word; ?>" <?php echo (!empty($astro->PAKSHA)) ? (($astro->PAKSHA==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2" id="paksha_other" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('Other_Paksha');?></label>
                                
                                    <input type="text" name="Other_Paksha" value="<?php echo (!empty($astro->Other_Paksha)) ? $astro->Other_Paksha :'';?>" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('star');?></label>
                                <select class="form-select mb-3" name="star" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(7);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->star)) ? (($astro->star==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('PADAM');?> </label>
                                <select class="form-select mb-3" name="PADAM" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(8);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->PADAM)) ? (($astro->PADAM==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('LAKKNAM');?> </label>
                                <select class="form-select mb-3" name="LAKKNAM" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(9);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->LAKKNAM)) ? (($astro->LAKKNAM==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('HOROSCOPE_MATCHING');?> </label>
                                <select class="form-select mb-3" name="HOROSCOPE_MATCHING" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(10);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->HOROSCOPE_MATCHING)) ? (($astro->HOROSCOPE_MATCHING==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('TITHI');?> </label>
                                <select class="form-select mb-3" name="TITHI" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(11);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->TITHI)) ? (($astro->TITHI==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('DOSHAM');?> </label>
                                <select class="form-select mb-3" name="DOSHAM" aria-label="Default select example" id="dosham" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(12);
                                    foreach($drop_down as $value){?>
                                    <option data="<?php echo $value->word;?>" <?php echo (!empty($astro->DOSHAM)) ? (($astro->DOSHAM==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2"  id="dosham_other" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('TYPE_OF_DOSHAM');?> </label>
                                <select class="form-control mt-2" name="TYPE_OF_DOSHAM" id="TYPE_OF_DOSHAM">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(13);
                                    foreach($drop_down as $value){?>
                                    <option data="<?php echo $value->word;?>" <?php echo (!empty($astro->TYPE_OF_DOSHAM)) ? (($astro->TYPE_OF_DOSHAM==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2" id="Other_Dosham" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('Other_Dosham');?></label>
                                
                                    <input type="text" name="Other_Dosham" value="<?php echo (!empty($astro->Other_Dosham)) ? $astro->Other_Dosham :'';?>" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('DIRECTIONAL_BALANCE');?> </label>
                                <select class="form-select mb-3" name="DIRECTIONAL_BALANCE" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(14);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->DIRECTIONAL_BALANCE)) ? (($astro->DIRECTIONAL_BALANCE==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('rashi');?> </label>
                                <select class="form-select mb-3" name="rashi" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(18);
                                    foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($astro->rashi)) ? (($astro->rashi==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('year');?></label>
                                    <select class="form-select mb-3" name="Year" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option><?php for($i=0;$i<=20;$i++){?>
                                    <option <?php echo (!empty($astro->Year)) ? (($astro->Year==$i)? 'selected':'') : "";?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('month');?></label>
                                    <select class="form-select mb-3" name="Month" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option><?php for($i=0;$i<=12;$i++){?>
                                    <option <?php echo (!empty($astro->Month)) ? (($astro->Month==$i)? 'selected':'') : "";?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-2 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('day');?></label>
                                    <select class="form-select mb-3" name="Day" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option><?php for($i=0;$i<=31;$i++){?>
                                    <option <?php echo (!empty($astro->Day)) ? (($astro->Day==$i)? 'selected':'') : "";?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                             <?php } } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('permanent_address');?></h5>
                        <div class="row">
                            <?php 
                            if(!empty($permanents)){ 
                                foreach($permanents as $permanent){?>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('country');?></label>
                                <input type="text" name="permanent_country" value="<?php echo (!empty($permanent->permanent_country)) ? $permanent->permanent_country :"";?>" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('state');?></label>
                                <select class="form-select mb-3" name="permanent_state" aria-label="Default select example" id="permanent_state" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $states = getDataa('all_states'); 
                                    $i=0; $state_id="";
                                    foreach($states as $value){ $i++;
                                        
                                        ?>
                                    <option data-id="<?php echo$value['state_id'];?>" <?php echo (!empty($permanent->permanent_state)) ? ((stateTranslate($permanent->permanent_state)==stateTranslate($value['word']))? 'selected':'') : "";?> value="<?php echo $value['word']; ?>"><?php echo stateTranslate($value['word']); ?></option>

                                    <?php } ?>
                                    
                                </select>

                            </div>
                            <div class="col-lg-6 mt-2" style="display:none" id="permanent_city_other">
                                <label for="basiInput" class="form-label"><?php echo translate('OTHERS');?></label>
                                <input type="text" name="permanent_city_other" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('city');?></label>
                                <select class="form-select mb-3" name="permanent_city" aria-label="Default select example" id="citys_ajax_output">
                                <?php  $drop_down = get_dropdown(21);
                                foreach($drop_down as $value){?>
                                    <option <?php echo (!empty($permanent->permanent_city)) ? (($permanent->permanent_city == $value->word)?'selected' : "") : "" ;?>><?php echo dropdownTranslate($value->word);?></option>
                                    
                                <?php } ?>    
                                </select>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('address');?> </label>
                                    <input type="text" name="address" value="<?php echo (!empty($permanent->address))? $permanent->address :"";?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('postal-Code');?>  </label>
                                
                                    <input type="text" name="permanent_postal_code" value="<?php echo (!empty($permanent->permanent_postal_code))? $permanent->permanent_postal_code :"";?>" class="form-control" required>
                               
                            </div>
                            <?php if($role==1){?>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('mobile');?></label>
                                
                                    <input type="text" name="mobile" value="<?php echo (!empty($single_member->mobile))? $single_member->mobile :"";?>" class="form-control" readonly>
                               
                            </div>
                            <?php } ?>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('alternate_number');?> </label>
                                    <input type="text" name="alternate_number" value="<?php echo (!empty($permanent->alternate_number))? $permanent->alternate_number :"";?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('landline');?> </label>
                                
                                    <input type="text" name="landline" value="<?php echo (!empty($permanent->landline))? $permanent->landline :"";?>" class="form-control">
                               
                            </div>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('family_information');?></h5>
                        <div class="row">
                            <?php if(!empty($family_member)) {
                              foreach($family_member as $family){?>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('surname');?></label>
                                <input type="text" name="Surname" value="<?php echo $family->Surname;?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Soveran_Details');?></label>
                                
                                    <input type="text" name="Soveran_Details" value="<?php echo (!empty($family->Soveran_Details)?$family->Soveran_Details:"");?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('father');?></label>
                                
                                    <input type="text" name="father" value="<?php echo $family->father;?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('mother');?></label>
                                
                                    <input type="text" name="mother" value="<?php echo $family->mother;?>" class="form-control" required>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('father_vangusam');?> </label>
                                <select class="form-select mb-3" name="father_vangusam" id="father_vangusam" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(1);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option data="<?php echo $value->word;?>" <?php echo (dropdownTranslate($family->father_vangusam)==dropdownTranslate($value->word))? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2" id="father_vangusam_other" style="display: none;">
                                <label><?php echo translate('other_vang')?>:    </label>

                                <input type="text" class="form-control mt-2" name="other_father_vang" value="<?php if(!empty($family && !empty( $family->other_father_vang))){echo $family->other_father_vang;}?>">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('mother_vangusam');?> </label>
                                <select class="form-select mb-3" name="mother_vangusam" id="mother_vangusam" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(1);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option data="<?php echo $value->word;?>" <?php echo (dropdownTranslate($family->mother_vangusam)==dropdownTranslate($value->word))? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2" id="mother_vangusam_other"  style="display: none;">
                                <label><?php echo translate('other_vang')?>:    </label>

                                <input type="text" class="form-control mt-2" name="other_mother_vang" value="<?php if(!empty($family && !empty( $family->other_mother_vang))){echo $family->other_mother_vang;}?>">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('family_type');?> </label>
                                <select class="form-select mb-3" name="family_type" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(2);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option <?php echo (dropdownTranslate($family->family_type)==dropdownTranslate($value->word))? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_brothers');?></label>
                                <select class="form-select mb-3" name="Number_of_brothers" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option <?php echo ($family->Number_of_brothers=='no')? 'selected':'';?> value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option <?php echo ($family->Number_of_brothers==$i)? 'selected':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option <?php echo ($family->Number_of_brothers=='Above')? 'selected':'';?> value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_married_brothers');?></label>
                                <select class="form-select mb-3" name="Number_of_married_brothers" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option <?php echo ($family->Number_of_married_brothers=='no')? 'selected':'';?> value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option <?php echo ($family->Number_of_married_brothers==$i)? 'selected':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option <?php echo ($family->Number_of_married_brothers=='Above')? 'selected':'';?> value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_Sisters');?></label>
                                <select class="form-select mb-3" name="Number_of_Sisters" aria-label="Default select example" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option <?php echo ($family->Number_of_Sisters=='no')? 'selected':'';?> value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option <?php echo ($family->Number_of_Sisters==$i)? 'selected':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option <?php echo ($family->Number_of_Sisters=='Above')? 'selected':'';?> value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_married_sisters');?></label>
                                <select class="form-select mb-3" name="Number_of_married_sisters" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option <?php echo ($family->Number_of_married_sisters=='no')? 'selected':'';?> value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option <?php echo ($family->Number_of_married_sisters==$i)? 'selected':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option <?php echo ($family->Number_of_married_sisters=='Above')? 'selected':'';?> value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Property_Description');?> </label>
                                <select class="form-select mb-3" name="Property_Description" aria-label="Default select example"  id="Property_Description" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(5);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option data="<?php echo $value->word;?>" <?php echo (!empty($family->Property_Description) ? ((dropdownTranslate($family->Property_Description)==dropdownTranslate($value->word))? 'selected':'') : "");?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    

                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2" id="property_other" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('Other_property_description');?></label>
                                    <input type="text" name="Other_property_description" value="<?php echo (!empty($family->Other_property_description)?$family->Other_property_description:"");?>" class="form-control">
                            </div>
                            <?php } } else{?>
                                <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('surname');?></label>
                                <input type="text" name="Surname" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('Soveran_Details');?></label>
                                
                                    <input type="text" name="Soveran_Details" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('father');?></label>
                                
                                    <input type="text" name="father" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('mother');?></label>
                                
                                    <input type="text" name="mother" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('father_vangusam');?> </label>
                                <select class="form-select mb-3" name="father_vangusam" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(1);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('mother_vangusam');?>  </label>
                                <select class="form-select mb-3" name="mother_vangusam" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(1);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('family_type');?> </label>
                                <select class="form-select mb-3" name="family_type" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(2);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_brothers');?></label>
                                <select class="form-select mb-3" name="Number_of_brothers" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_married_brothers');?></label>
                                <select class="form-select mb-3" name="Number_of_married_brothers" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option value="above">Above</option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_Sisters');?></label>
                                <select class="form-select mb-3" name="Number_of_Sisters" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Number_of_married_sisters');?></label>
                                <select class="form-select mb-3" name="Number_of_married_sisters" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option value="no"><?php echo translate('no');?></option>
                                    <?php for($i=0;$i<=10;$i++){?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                    <?php } ?>
                                    <option value="above"><?php echo translate('above');?></option>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Property_Description');?></label>
                                <select class="form-select mb-3" name="Property_Description" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(5);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('Other_Property_Description');?> </label>
                                    <input type="text" name="Other_Property_Description" class="form-control">
                            </div>
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('partner_Expectation');?></h5>
                        <div class="row">
                            <?php if(!empty($expectations)) {
                                foreach ($expectations as $expectation){?>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('age');?></label>
                                <input type="text" name="partner_age" value="<?php echo $expectation->partner_age?>" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('height');?></label>
                                <input type="text" name="partner_height" value="<?php echo $expectation->partner_height?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('weight');?></label>
                                <input type="text" name="partner_weight" value="<?php echo $expectation->partner_weight?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('any_disability');?></label>
                                <input type="text" name="partner_any_disability" value="<?php echo $expectation->partner_any_disability?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('martial_status');?> </label>
                                <select class="form-select mb-3" name="partner_marital_status" aria-label="Default select example" id="mar_status">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(19);
                                    $i=0;
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option data="<?php echo $i;?>" <?php echo (dropdownTranslate($expectation->partner_marital_status)==dropdownTranslate($value->word))? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2" id="children_acceptables" style="display:none;">
                                <label><?php echo translate('with_children_acceptables')?>: </label>

                                <?php 
                                
                                echo select_html('decision', 'with_children_acceptables', 'name', 'edit', 'form-control', $expectation->with_children_acceptables, '', '', '');
                                
                                ?>
                                </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('education');?> </label>
                                <select class="form-select mb-3" name="partner_education" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(3);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option <?php echo (dropdownTranslate($expectation->partner_education)==dropdownTranslate($value->word))? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('profession');?></label>
                                <input type="text" name="partner_profession" value="<?php echo $expectation->partner_profession?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('body_type');?></label>
                                <input type="text" name="partner_body_type" value="<?php echo $expectation->partner_body_type?>" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('dosham');?></label>
                                <select class="form-select mb-3" name="partner_DOSHAM" aria-label="Default select example" id="partner_DOSHAM">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(12);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option  data="<?php echo $value->word;?>" <?php echo (isset($expectation->partner_DOSHAM) ? ((dropdownTranslate($expectation->partner_DOSHAM)==dropdownTranslate($value->word))? 'selected':'') : "" );?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2"  id="partner_TYPE_OF_DOSHAM" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('TYPE_OF_DOSHAM');?> </label>
                                <select class="form-control mt-2" name="partner_TYPE_OF_DOSHAM">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php $drop_down = get_dropdown(13);
                                    foreach($drop_down as $value){?>
                                    <option  data="<?php echo $value->word;?>" data="<?php echo $value->word;?>" <?php echo (!empty($expectation->partner_TYPE_OF_DOSHAM)) ? (($expectation->partner_TYPE_OF_DOSHAM==$value->word)? 'selected':'') : "";?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2" id="partner_Other_Dosham" style="display:none;">
                                <label for="basiInput" class="form-label"><?php echo translate('Other_Dosham');?></label>
                                
                                    <input type="text" name="partner_Other_Dosham" value="<?php echo (!empty($expectation->partner_Other_Dosham)) ? $expectation->partner_Other_Dosham :'';?>" class="form-control">
                               
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('expectation');?> </label>
                                <select class="form-select mb-3" name="partner_Expectation" aria-label="Default select example" id="partner_Expectation">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $drop_down = get_dropdown(26);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                        <?php if(!empty($expectation->partner_Expectation)){?>
                                    <option data="<?php echo $value->word;?>" <?php echo (dropdownTranslate($expectation->partner_Expectation)==dropdownTranslate($value->word))? 'selected':'';?> value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php }else{?>
                                        <option data="<?php echo $value->word;?>" value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2" id="partner_Other_Expectation" style="display: none;">
                                <label><?php echo translate('OTHERS')?>:    </label>

                                <input type="text" class="form-control mt-2" name="partner_Other_Expectation" value="<?php if(!empty($expectation && !empty( $expectation->partner_Other_Expectation))){echo $expectation->partner_Other_Expectation;}?>">
                                </div>
                            <?php } } else{?>

                                <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('age');?> </label>
                                <input type="text" name="partner_age" class="form-control">
                            </div>
                            <div class="col-lg-6">
                                <label for="basiInput" class="form-label"><?php echo translate('height');?> </label>
                                <input type="number" name="partner_height" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('weight');?> </label>
                                <input type="text" name="partner_weight" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('any_disability');?> </label>
                                <input type="text" name="partner_any_disability" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('member_status');?> </label>
                                <select class="form-select mb-3" name="partner_marital_status" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?> </option>
                                    <?php 
                                    $drop_down = get_dropdown(19);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('education');?> </label>
                                <select class="form-select mb-3" name="partner_education" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?> </option>
                                    <?php 
                                    $drop_down = get_dropdown(3);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('profession');?> </label>
                                <input type="text" name="partner_profession" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('body_type');?> </label>
                                <input type="text" name="partner_body_type" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('dosham');?> </label>
                                <select class="form-select mb-3" name="partner_DOSHAM" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?> </option>
                                    <?php 
                                    $drop_down = get_dropdown(12);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                    <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="basiInput" class="form-label"><?php echo translate('expectation');?>  </label>
                                <select class="form-select mb-3" name="partner_Expectation" aria-label="Default select example">
                                    <option value=""><?php echo translate('choose_one');?> </option>
                                    <?php 
                                    $drop_down = get_dropdown(26);
                                    foreach($drop_down as $value){ $i++;
                                        ?>
                                        <?php if(!empty($expectation->partner_Expectation)){?>
                                    <option value="<?php echo $value->word; ?>"><?php echo $value->word; ?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $value->word; ?>"><?php echo dropdownTranslate($value->word); ?></option>
                                    <?php } }?>
                                </select>
                            </div>

                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Astrological Chart</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-success table-bordered table-nowrap align-middle mb-0" style="border-color: black">
                                <?php  if(!empty($raasis)) {
                                    foreach($raasis as $raasi){?>
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
                                        <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;">ZODIAC
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
                                        <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;">ZODIAC
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
                         <div class="table-responsive mb-4">
                            <table class="table table-success table-bordered table-nowrap align-middle mb-0" style="border-color: black">
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
                                        <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;">FEATURE
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
                                        <td class="warning" colspan="2" rowspan="2"  style="text-align: center;vertical-align: middle;center;background-color: #f3f3cb;">FEATURE
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
                        <div class="text-center">
                        <button title="UPDATE" type="submit" class="btn btn-success btn-sm btn-label waves-effect waves-light"><i class="fa fa-floppy-o label-icon align-middle fs-16 me-2"></i> Update</button>
                    </div>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<script>
$("#permanent_state").change(function(){
    var state_id = $(this).find(':selected').attr('data-id');

    console.log(state_id);

  var base_url=$('#base_url').val();
    $.ajax({
      type: 'GET',
      url: base_url+'get_city_of_state_ajax_admin',
      data: '&state_id='+state_id,
      success:function(html)
      {            
        $('#citys_ajax_output').html(html);            
      }
  }); 
});
function blockMember(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'administrator/blockMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function closeMember(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'administrator/closeMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
</script>
<div id="edit_output"></div>