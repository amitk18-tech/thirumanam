<?php 
    $images = json_decode($single_member->profile_image);
    $astronomic = json_decode($single_member->astronomic_information);
    $mariage_status = json_decode($single_member->basic_info);
    $educations = json_decode($single_member->education_and_career);
    $Physics = json_decode($single_member->physical_attributes);
    $permanents = json_decode($single_member->permanent_address);
    $family_member = json_decode($single_member->family_info);
    $expectations = json_decode($single_member->partner_expectation);
    $raasis = json_decode($single_member->chart);
?>
<style>
    th{
        padding-bottom: 20px!important;
    }
</style>

<div class="row">
    <div class="col-lg-4">
        <a title="<?php echo translate('go_back');?>" href="javascript:history.go(-1)"class="btn btn-danger btn-icon btn-sm waves-effect waves-light mb-3"><i class="ri-arrow-left-line"></i></a>
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
                                <?php
                                $admin_role=$this->db->get_where('admin', array('admin_id' => $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id']))->row()->role ;
                                if($admin_role==1){
                                ?>
                                <div class="col text-end dropdown">
                                    <a href="javascript:void(0);" id="dropdownMenuLink2" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ri-more-fill fs-17"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink2">
                                        <?php if($admin_role==1){?>
                            <?php if($single_member->is_blocked=='no'){?>
                                 <li><a class="dropdown-item" onclick="blockMember(<?php echo $single_member->member_id;?>)"><i class="mdi mdi-account-cancel me-2 align-middle"></i><?php echo translate('block');?> </a></li>
                            <?php }else{?>
                                <li><a class="dropdown-item" title="<?php echo translate('unblock');?>" href="<?php echo base_url('administrator/unblockMember/'.$single_member->member_id);?>" onclick="return confirm('Are you sure want to unBlock this?');"><i class="mdi mdi-account-cancel me-2 align-middle"></i><?php echo translate('unblock');?> </a></li>
                            <?php } } ?>
                                        
                                        <li><a class="dropdown-item" href="<?php echo base_url('administrator/deleteMember/'.$single_member->member_id) ;?>" 
                                    onclick="return confirm('Are you sure want to delete this?');"><i class="ri-delete-bin-5-line me-2 align-middle"></i><?php echo translate('delete');?> </a></li>
                                    </ul>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-4 col">
                            <div class="team-profile-img">
                                <div class="avatar-lg img-thumbnail rounded-circle shadow flex-shrink-0">
                                
                                    <?php
                                    if(!empty($images)){
                                    foreach($images as $image){?>

                                <img src="<?php echo (!empty($image)) ? base_url('uploads/profile_image/'.$image->profile_image) : base_url('uploads/profile_image/no_image.jpg') ;?>" class="img-fluid d-block rounded-circle" alt=""/ style="height: 100%;object-fit: contain; cursor: pointer;" onclick="$('#file').click()">
                                 <?php } } else{?>
                                    <img src="<?php echo  base_url('uploads/profile_image/no_image.jpg') ;?>" class="img-fluid d-block rounded-circle" alt=""/ style="height: 100%;object-fit: contain; cursor: pointer;" onclick="$('#file').click()">
                                    <?php } ?>
                                </div>
                                <div class="team-content">
                                    <form action="<?php echo base_url('AdminController/updateProfileimage/');?>" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <input type="hidden" name="member_id" value="<?php echo $single_member->member_id;?>">
                                            <div class="col-lg-9">
                                                <input type="file" id="file" name="profile_image" class="form-control">
                                                <input type="hidden" name="thumb" value="<?php echo (!empty($image->thumb)) ? $image->thumb : "";?>">
                                            </div>
                                            <div class="col-lg-3">
                                                <button type="submit" class="btn btn-info waves-effect waves-light"><?php echo translate('save');?> </button>
                                            </div>
                                        </div>
                                    </form>
                                <h4 class="text-center mt-3"><?php echo $single_member->first_name;?></h4>

                                <?php
                                if(!empty($educations)){
                                     foreach($educations as $education){?>
                                <h6 class="text-center mt-3"><?php echo $education->Type_of_occupation;?></h6>
                            <?php } }?>
                             <?php
                             if(!empty($permanents)){
                                 foreach($permanents as $permanent){ ?>
                                    
                                 
                                <h6 class="text-center mt-3"><?php echo (!empty($permanent->permanent_state)) ? $permanent->permanent_state : "";?></h6>
                             <?php } }  ?>
                             <h6 class="text-center mt-3"><?php echo translate('profile_downloads');?> : <?php echo $single_member->remain_download;?></h6>
                             
                             <div class="text-center mt-2">
                                <?php if($admin_role==1){?>
                            <?php if($single_member->is_blocked=='no'){?>
                                 <button title="<?php echo translate('block');?>" onclick="blockMember(<?php echo $single_member->member_id;?>)" class="btn btn-xs btn-outline-info btn-border"><?php echo translate('block');?> </button>
                            <?php }else{?>
                                <a title="<?php echo translate('unblock');?>" href="<?php echo base_url('administrator/unblockMember/'.$single_member->member_id);?>" onclick="return confirm('Are you sure want to unBlock this?');" class="btn btn-xs btn-outline-info btn-border"><?php echo translate('unblock');?> </a>
                            <?php } ?>
                            <?php if($single_member->is_closed=='no'){?>
                                 <button title="<?php echo translate('close');?>" onclick="closeMember(<?php echo $single_member->member_id;?>)" class="btn btn-xs btn-outline-danger btn-border"><?php echo translate('close');?> </button>
                            <?php }else {  ?>   
                                <a title="<?php echo translate('open');?>" href="<?php echo base_url('administrator/unclosemember/'.$single_member->member_id);?>" onclick="return confirm('Are you sure want to unClose this?');" class="btn btn-xs btn-outline-danger btn-border"><?php echo translate('open');?> </a>
                            <?php } }?>
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
    <?php

    if(!empty($single_member->membership_date)){
           $expiry = date("Y-m-d", strtotime("+6 months", strtotime($single_member->membership_date)));
       }else{

            $expiry = " ";

       }
       // print_r($expiry);
    ?>
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-4">
                <h5><b><?php echo translate('member_id');?> :</b> <?php echo $single_member->member_profile_id;?></h5>
            </div>
            <div class="col-lg-8">
                <div class="mb-3 text-end">

                    <?php if($expiry<=date('Y-m-d') || $admin_role==1)
                    {?>
                    <button title="RENEW PROFILE" type="button" class="btn btn-primary btn-sm btn-label waves-effect waves-light mt-1" data-bs-toggle="modal" data-bs-target="#zoomInModal"><i class="fa fa-inr label-icon align-middle fs-16 me-2"></i> <?php echo translate('renewProfile');?></button>
                   <?php } ?>
                    <a title="PRINT PROFILE" href="<?php echo base_url('administrator/print_admin_Member/'.$single_member->member_id);?>" target="_blank" class="btn btn-secondary btn-sm btn-label waves-effect waves-light mt-1"><i class="fa fa-print label-icon align-middle fs-16 me-2"></i> <?php echo translate('print_profile');?></a>
                    <!-- <a title="PRINT PROFILE" href="<?php echo base_url('administrator/printMember/'.$single_member->member_id);?>" target="_blank" class="btn btn-secondary btn-sm btn-label waves-effect waves-light mt-1"><i class="fa fa-print label-icon align-middle fs-16 me-2"></i> <?php echo translate('print_profile');?></a> -->
                    <?php if($admin_role==1){?>
                    <a title="DELETE PROFILE" href="<?php echo base_url('administrator/deleteMember/'.$single_member->member_id);?>" onclick="return confirm('Are you sure want to delete this?');" type="button" class="btn btn-danger btn-sm btn-label waves-effect waves-light mt-1"><i class="ri-delete-bin-5-line label-icon align-middle fs-16 me-2"></i> <?php echo translate('delete');?></a>
                    <?php } ?>
                    <a title="EDIT PROFILE" href="<?php echo base_url('administrator/all_members/edit_member/'.$single_member->member_id);?>" class="btn btn-success btn-sm btn-label waves-effect waves-light mt-1"><i class="fa fa-edit label-icon align-middle fs-16 me-2"></i> <?php echo translate('edit');?></a>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('introduction');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        
                                        <td class="text-muted"><?php echo $single_member->introduction;?></td>
                                    </tr>
                                    
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
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('name');?> : </th>
                                        <td class="text-muted"><?php echo $single_member->first_name;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('gender');?> : </th>
                                        <td class="text-muted"><?php echo ($single_member->gender==1)?translate('Male'):translate('Female');?></td>
                                    </tr>
                                    <tr><?php
                                    if(!empty($astronomic)){
                                        foreach($astronomic as $astro){?>
                                        <th class="ps-0" scope="row"><?php echo translate('age');?> : </th>
                                        <td class="text-muted"><?php echo date('Y')-date('Y',strtotime($astro->date_of_birth))?></td>
                                   <?php } }?>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('email');?> : </th>
                                        <td class="text-muted"><?php echo $single_member->email;?>
                                        </td>
                                    </tr>
                                    <tr><?php
                                    if(!empty($mariage_status)){
                                        foreach($mariage_status as $mariage){?>
                                        <th class="ps-0" scope="row"><?php echo translate('martial_status');?>: </th>
                                        <td class="text-muted"><?php echo dropdownTranslate($mariage->marital_status);?></td>
                                    <?php } } ?>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('education_and_career');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody><?php

                                    if(!empty($educations)){
                                        foreach($educations as $education){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('Type_of_study');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($education->Type_of_study)) ? dropdownTranslate($education->Type_of_study) : "" ;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('Type_of_occupation');?>  : </th>
                                        <td class="text-muted"><?php echo dropdownTranslate($education->Type_of_occupation);?></td>
                                    </tr>
                                    <tr>
                                         <th class="ps-0" scope="row"><?php echo translate('STUDY_DETAILS');?> : </th>
                                        <td class="text-muted"><?php echo $education->STUDY_DETAILS;?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('Career_Profile');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($education->Career_Profile)) ? dropdownTranslate($education->Career_Profile) : "" ;?></td>
                                    
                                    </tr>
                                    <tr>
                                       
                                        <th class="ps-0" scope="row"><?php echo translate('earnings');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($education->Earnings)) ? dropdownTranslate($education->Earnings) : "" ;?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('annual_income');?> : </th>
                                        <td class="text-muted"><?php echo $education->annual_income;?></td>
                                    </tr>
                                    
                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('physical_attributes');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <?php
                                    if(!empty($Physics)){
                                         foreach($Physics as $physical){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('height');?> : </th>
                                        <td class="text-muted"><?php echo $single_member->height;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('weight');?> : </th>
                                        <td class="text-muted"><?php echo $physical->weight;?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('eye_color');?> : </th>
                                        <td class="text-muted"><?php echo $physical->eye_color;?></td>
                                         <th class="ps-0" scope="row"><?php echo translate('hair_color');?>: </th>
                                        <td class="text-muted"><?php echo $physical->hair_color;?></td> 
                                    </tr>
                                    <tr>
                                         <th class="ps-0" scope="row"><?php echo translate('complexion');?> : </th>
                                        <td class="text-muted"><?php echo $physical->complexion;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('blood_group');?>: </th>
                                        <td class="text-muted"><?php echo $physical->blood_group;?></td>
                                    </tr>
                                    <tr>
                                        
                                        <th class="ps-0" scope="row"><?php echo translate('body_art');?>: </th>
                                        <td class="text-muted"><?php echo $physical->body_art;?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('body_type');?> : </th>
                                        <td class="text-muted"><?php echo $physical->body_type;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                       <th class="ps-0" scope="row"><?php echo translate('any_disability');?>: </th>
                                        <td class="text-muted"><?php echo $physical->any_disability;?></td>
                                    </tr>
                                    
                                    
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('astronomic_information');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <?php
                                    if(!empty($astronomic)){
                                        foreach($astronomic as $astro){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('date_of_birth');?> : </th>
                                        <td class="text-muted"><?php echo date('d-M-y',strtotime($astro->date_of_birth));?></td>
                                   
                                        <th class="ps-0" scope="row"><?php echo translate('city_of_birth');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->city_of_birth)) ? $astro->city_of_birth :"";?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('PAKSHA');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->PAKSHA)) ? dropdownTranslate($astro->PAKSHA) : "";?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('star');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->star)) ? dropdownTranslate($astro->star) : "";?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('LAKKNAM');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->city_of_birth)) ? $astro->city_of_birth : "";?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('TITHI');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->TITHI)) ? dropdownTranslate($astro->TITHI) : "" ;?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('DIRECTIONAL_BALANCE');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->DIRECTIONAL_BALANCE)) ? dropdownTranslate($astro->DIRECTIONAL_BALANCE) : "" ;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('rashi');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->rashi)) ? dropdownTranslate($astro->rashi) : "" ;?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('birthDay');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->birthDay)) ? $astro->birthDay : "" ;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('time_of_birth');?>  : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->time_of_birth)) ? $astro->time_of_birth : "" ;?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('PADAM');?>  : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->PADAM)) ? dropdownTranslate($astro->PADAM) : "" ;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('HOROSCOPE_MATCHING');?>  : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->HOROSCOPE_MATCHING)) ? dropdownTranslate($astro->HOROSCOPE_MATCHING) : "" ;?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('DOSHAM');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->DOSHAM)) ? dropdownTranslate($astro->DOSHAM) : "" ;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('year');?> /<?php echo translate('month');?> /<?php echo translate('day');?>    : </th>
                                        <td class="text-muted"><?php echo (!empty($astro->Year)) ? $astro->Year : "" ;?> /<?php echo (!empty($astro->Month)) ? $astro->Month : "" ;?> /<?php echo (!empty($astro->Day)) ? $astro->Day : "" ;?></td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('permanent_address');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <?php 
                                    if(!empty($permanents)){
                                        foreach($permanents as $permanent){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('country');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->permanent_country)) ? $permanent->permanent_country: "";?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('state');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->permanent_state)) ? dropdownTranslate($permanent->permanent_state): "";?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('city');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->permanent_city)) ? $permanent->permanent_city: "";?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('OTHERS');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->permanent_city_other)) ? $permanent->permanent_city_other: "";?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('address');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->address)) ? $permanent->address: "";?></td>
                                    
                                        
                                    </tr>
                                    <tr>
                                       <th class="ps-0" scope="row"><?php echo translate('postal-Code');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->permanent_postal_code)) ? $permanent->permanent_postal_code: "";?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('alternate_number');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->alternate_number)) ? $permanent->alternate_number: "";?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('mobile');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($single_member->mobile)) ? $single_member->mobile: "";?>
                                        </td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('landline');?>: </th>
                                        <td class="text-muted"><?php echo (!empty($permanent->landline)) ? $permanent->landline: "";?></td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('family_information');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <?php 
                                    if(!empty($family_member)){
                                        foreach($family_member as $family){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('Surname');?> : </th>
                                        <td class="text-muted"><?php echo $family->Surname;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('Soveran_Details');?> : </th>
                                        <td class="text-muted"><?php echo (isset($family->Soveran_Details)) ? $family->Soveran_Details : "";?></td>
                                    </tr>
                                     <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('father');?> : </th>
                                        <td class="text-muted"><?php echo $family->father;?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('father_vangusam');?> : </th>
                                        <td class="text-muted"><?php echo dropdownTranslate($family->father_vangusam);?></td>
                                    </tr>
                                    <?php if($family->father_vangusam=='OTHERS'){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('other_vang');?> : </th>
                                        <td class="text-muted"><?php echo $family->other_father_vang;?>
                                        </td>
                                        
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('mother');?> : </th>
                                        <td class="text-muted"><?php echo dropdownTranslate($family->mother);?>
                                        <th class="ps-0" scope="row"><?php echo translate('mother_vangusam');?> : </th>
                                        <td class="text-muted"><?php echo dropdownTranslate($family->mother_vangusam);?>
                                        </td>
                                        </td>
                                    </tr>
                                    <?php if($family->mother_vangusam=='OTHERS'){?>
                                    <tr>
                                        
                                        <th class="ps-0" scope="row"><?php echo translate('other_vang');?> : </th>
                                        <td class="text-muted"><?php echo $family->other_mother_vang;?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('family_type');?> : </th>
                                        <td class="text-muted"><?php echo dropdownTranslate($family->family_type);?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('Number_of_brothers');?> : </th>
                                        <td class="text-muted"><?php echo $family->Number_of_brothers;?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('Number_of_married_brothers');?>: </th>
                                        <td class="text-muted"><?php echo $family->Number_of_married_brothers;?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('Number_of_sisters');?> : </th>
                                        <td class="text-muted"><?php echo $family->Number_of_Sisters;?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('Number_of_married_sisters');?> : </th>
                                        <td class="text-muted"><?php echo $family->Number_of_married_sisters;?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('Property_Description');?> : </th>
                                        <td class="text-muted"><?php echo (!empty($family->Property_Description)) ? $family->Property_Description: "";?></td>
                                        <?php if(!empty($family->Property_Description)){ if($family->Property_Description=='OTHERS'){?>
                                    
                                        
                                        <th class="ps-0" scope="row"><?php echo translate('Other_Property_Description');?> : </th>
                                        <td class="text-muted"><?php echo $family->Other_property_description;?>
                                        </td>
                                    <?php } } ?>
                                        
                                    </tr>

                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><?php echo translate('partner_Expectation');?></h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <?php 
                                    if(!empty($family_member)){
                                        foreach ($expectations as $expectation){?>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('age');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_age?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('height');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_height?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('weight');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_weight?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('any_disability');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_any_disability?></td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('martial_status');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_marital_status?></td>
                                        <th class="ps-0" scope="row"><?php echo translate('with_children_acceptables');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->with_children_acceptables?></td>
                                        
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('body_type');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_body_type?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('education');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_education?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row"><?php echo translate('profession');?> : </th>
                                        <td class="text-muted"><?php echo $expectation->partner_profession?></td>
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('DOSHAM');?> : </th>
                                        <td class="text-muted"><?php echo (! empty($expectation->partner_DOSHAM))? dropdownTranslate($expectation->partner_DOSHAM) : '';?> </td>
                                    </tr>
                                    <tr>
                                        
                                    
                                        <th class="ps-0" scope="row"><?php echo translate('expectation');?> : </th>
                                        <td class="text-muted"><?php echo (! empty($expectation->partner_Expectation))? dropdownTranslate($expectation->partner_Expectation) : '';?> </td>
                                    </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                 <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Astrological Chart</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-success table-bordered table-nowrap align-middle mb-0">
                                <?php
                                if(!empty($raasis)){
                                     foreach($raasis as $raasi){?>
                                <tbody>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f010))? dropdownTranslate($raasi->f010).' | ':"" ;
                                        echo (!empty($raasi->f011))? dropdownTranslate($raasi->f011).' | ':"" ;
                                        echo (!empty($raasi->f012))? dropdownTranslate($raasi->f012).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f013))? dropdownTranslate($raasi->f013).' | ':"" ;
                                        echo (!empty($raasi->f014))? dropdownTranslate($raasi->f014).' | ':"" ;
                                        echo (!empty($raasi->f015))? dropdownTranslate($raasi->f015).' | ':"" ;
                                        ?> 
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f020))? dropdownTranslate($raasi->f020).' | ':"" ;
                                        echo (!empty($raasi->f021))? dropdownTranslate($raasi->f021).' | ':"" ;
                                        echo (!empty($raasi->f022))? dropdownTranslate($raasi->f022).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f023))? dropdownTranslate($raasi->f023).' | ':"" ;
                                        echo (!empty($raasi->f024))? dropdownTranslate($raasi->f024).' | ':"" ;
                                        echo (!empty($raasi->f025))? dropdownTranslate($raasi->f025).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f030))? dropdownTranslate($raasi->f030).' | ':"" ;
                                        echo (!empty($raasi->f031))? dropdownTranslate($raasi->f031).' | ':"" ;
                                        echo (!empty($raasi->f032))? dropdownTranslate($raasi->f032).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f033))? dropdownTranslate($raasi->f033).' | ':"" ;
                                        echo (!empty($raasi->f034))? dropdownTranslate($raasi->f034).' | ':"" ;
                                        echo (!empty($raasi->f035))? dropdownTranslate($raasi->f035).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f040))? dropdownTranslate($raasi->f040).' | ':"" ;
                                        echo (!empty($raasi->f041))? dropdownTranslate($raasi->f041).' | ':"" ;
                                        echo (!empty($raasi->f042))? dropdownTranslate($raasi->f042).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f043))? dropdownTranslate($raasi->f043).' | ':"" ;
                                        echo (!empty($raasi->f044))? dropdownTranslate($raasi->f044).' | ':"" ;
                                        echo (!empty($raasi->f045))? dropdownTranslate($raasi->f045).' | ':"" ;
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f110))? dropdownTranslate($raasi->f110).' | ':"" ;
                                        echo (!empty($raasi->f111))? dropdownTranslate($raasi->f111).' | ':"" ;
                                        echo (!empty($raasi->f112))? dropdownTranslate($raasi->f112).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f113))? dropdownTranslate($raasi->f113).' | ':"" ;
                                        echo (!empty($raasi->f114))? dropdownTranslate($raasi->f114).' | ':"" ;
                                        echo (!empty($raasi->f115))? dropdownTranslate($raasi->f115).' | ':"" ;
                                        ?>
                                        </td>
                                        <td colspan="2" rowspan="2" style="height:7em;width: 10%;font-size: 15px;text-align: center;background-color: #f3f3cb;"><?php echo translate('ZODIAC');?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f210))? dropdownTranslate($raasi->f210).' | ':"" ;
                                        echo (!empty($raasi->f211))? dropdownTranslate($raasi->f211).' | ':"" ;
                                        echo (!empty($raasi->f212))? dropdownTranslate($raasi->f212).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f213))? dropdownTranslate($raasi->f213).' | ':"" ;
                                        echo (!empty($raasi->f214))? dropdownTranslate($raasi->f214).' | ':"" ;
                                        echo (!empty($raasi->f215))? dropdownTranslate($raasi->f215).' | ':"" ;
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f310))? dropdownTranslate($raasi->f310).' | ':"" ;
                                        echo (!empty($raasi->f311))? dropdownTranslate($raasi->f311).' | ':"" ;
                                        echo (!empty($raasi->f312))? dropdownTranslate($raasi->f312).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f313))? dropdownTranslate($raasi->f313).' | ':"" ;
                                        echo (!empty($raasi->f314))? dropdownTranslate($raasi->f314).' | ':"" ;
                                        echo (!empty($raasi->f315))? dropdownTranslate($raasi->f315).' | ':"" ;
                                        ?>
                                        </td>
                                        <td colspan="2" style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f320))? dropdownTranslate($raasi->f320).' | ':"" ;
                                        echo (!empty($raasi->f321))? dropdownTranslate($raasi->f321).' | ':"" ;
                                        echo (!empty($raasi->f322))? dropdownTranslate($raasi->f322).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f323))? dropdownTranslate($raasi->f323).' | ':"" ;
                                        echo (!empty($raasi->f324))? dropdownTranslate($raasi->f324).' | ':"" ;
                                        echo (!empty($raasi->f325))? dropdownTranslate($raasi->f325).' | ':"" ;
                                        ?>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f410))? dropdownTranslate($raasi->f410).' | ':"" ;
                                        echo (!empty($raasi->f411))? dropdownTranslate($raasi->f411).' | ':"" ;
                                        echo (!empty($raasi->f412))? dropdownTranslate($raasi->f412).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f413))? dropdownTranslate($raasi->f413).' | ':"" ;
                                        echo (!empty($raasi->f414))? dropdownTranslate($raasi->f414).' | ':"" ;
                                        echo (!empty($raasi->f415))? dropdownTranslate($raasi->f415).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f420))? dropdownTranslate($raasi->f420).' | ':"" ;
                                        echo (!empty($raasi->f421))? dropdownTranslate($raasi->f421).' | ':"" ;
                                        echo (!empty($raasi->f422))? dropdownTranslate($raasi->f422).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f423))? dropdownTranslate($raasi->f423).' | ':"" ;
                                        echo (!empty($raasi->f424))? dropdownTranslate($raasi->f424).' | ':"" ;
                                        echo (!empty($raasi->f425))? dropdownTranslate($raasi->f425).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f430))? dropdownTranslate($raasi->f430).' | ':"" ;
                                        echo (!empty($raasi->f431))? dropdownTranslate($raasi->f431).' | ':"" ;
                                        echo (!empty($raasi->f432))? dropdownTranslate($raasi->f432).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f433))? dropdownTranslate($raasi->f433).' | ':"" ;
                                        echo (!empty($raasi->f434))? dropdownTranslate($raasi->f434).' | ':"" ;
                                        echo (!empty($raasi->f435))? dropdownTranslate($raasi->f435).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f440))? dropdownTranslate($raasi->f440).' | ':"" ;
                                        echo (!empty($raasi->f441))? dropdownTranslate($raasi->f441).' | ':"" ;
                                        echo (!empty($raasi->f442))? dropdownTranslate($raasi->f442).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f443))? dropdownTranslate($raasi->f443).' | ':"" ;
                                        echo (!empty($raasi->f444))? dropdownTranslate($raasi->f444).' | ':"" ;
                                        echo (!empty($raasi->f445))? dropdownTranslate($raasi->f445).' | ':"" ;
                                        ?>
                                        </td>
                                    </tr>
                                </tbody>
                            <?php } }?>
                            </table>
                        </div>
                         <div class="table-responsive">
                            <table class="table table-success table-bordered table-nowrap align-middle mb-0">
                                <?php if(!empty($raasis)){
                                    foreach($raasis as $raasi){?>
                                <tbody>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f510))? dropdownTranslate($raasi->f510).' | ':"" ;
                                        echo (!empty($raasi->f511))? dropdownTranslate($raasi->f511).' | ':"" ;
                                        echo (!empty($raasi->f512))? dropdownTranslate($raasi->f512).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f513))? dropdownTranslate($raasi->f513).' | ':"" ;
                                        echo (!empty($raasi->f514))? dropdownTranslate($raasi->f514).' | ':"" ;
                                        echo (!empty($raasi->f515))? dropdownTranslate($raasi->f515).' | ':"" ;
                                        ?> 
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f520))? dropdownTranslate($raasi->f520).' | ':"" ;
                                        echo (!empty($raasi->f521))? dropdownTranslate($raasi->f521).' | ':"" ;
                                        echo (!empty($raasi->f522))? dropdownTranslate($raasi->f522).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f523))? dropdownTranslate($raasi->f523).' | ':"" ;
                                        echo (!empty($raasi->f524))? dropdownTranslate($raasi->f524).' | ':"" ;
                                        echo (!empty($raasi->f525))? dropdownTranslate($raasi->f525).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f530))? dropdownTranslate($raasi->f530).' | ':"" ;
                                        echo (!empty($raasi->f531))? dropdownTranslate($raasi->f531).' | ':"" ;
                                        echo (!empty($raasi->f532))? dropdownTranslate($raasi->f532).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f533))? dropdownTranslate($raasi->f533).' | ':"" ;
                                        echo (!empty($raasi->f534))? dropdownTranslate($raasi->f534).' | ':"" ;
                                        echo (!empty($raasi->f535))? dropdownTranslate($raasi->f535).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f540))? dropdownTranslate($raasi->f540).' | ':"" ;
                                        echo (!empty($raasi->f541))? dropdownTranslate($raasi->f541).' | ':"" ;
                                        echo (!empty($raasi->f542))? dropdownTranslate($raasi->f542).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f543))? dropdownTranslate($raasi->f543).' | ':"" ;
                                        echo (!empty($raasi->f544))? dropdownTranslate($raasi->f544).' | ':"" ;
                                        echo (!empty($raasi->f545))? dropdownTranslate($raasi->f545).' | ':"" ;
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f610))? dropdownTranslate($raasi->f610).' | ':"" ;
                                        echo (!empty($raasi->f611))? dropdownTranslate($raasi->f611).' | ':"" ;
                                        echo (!empty($raasi->f612))? dropdownTranslate($raasi->f612).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f613))? dropdownTranslate($raasi->f613).' | ':"" ;
                                        echo (!empty($raasi->f614))? dropdownTranslate($raasi->f614).' | ':"" ;
                                        echo (!empty($raasi->f615))? dropdownTranslate($raasi->f615).' | ':"" ;
                                        ?>
                                        </td>
                                        <td colspan="2" rowspan="2" style="text-align: center;height:7em;width: 10%;font-size: 15px; background-color: #f3f3cb;"><?php echo translate('FEATURE');?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f710))? dropdownTranslate($raasi->f710).' | ':"" ;
                                        echo (!empty($raasi->f711))? dropdownTranslate($raasi->f711).' | ':"" ;
                                        echo (!empty($raasi->f712))? dropdownTranslate($raasi->f712).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f713))? dropdownTranslate($raasi->f713).' | ':"" ;
                                        echo (!empty($raasi->f714))? dropdownTranslate($raasi->f714).' | ':"" ;
                                        echo (!empty($raasi->f715))? dropdownTranslate($raasi->f715).' | ':"" ;
                                        ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f810))? dropdownTranslate($raasi->f810).' | ':"" ;
                                        echo (!empty($raasi->f811))? dropdownTranslate($raasi->f811).' | ':"" ;
                                        echo (!empty($raasi->f812))? dropdownTranslate($raasi->f812).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f813))? dropdownTranslate($raasi->f813).' | ':"" ;
                                        echo (!empty($raasi->f814))? dropdownTranslate($raasi->f814).' | ':"" ;
                                        echo (!empty($raasi->f815))? dropdownTranslate($raasi->f815).' | ':"" ;
                                        ?>
                                        </td>
                                        <td colspan="2" style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f820))? dropdownTranslate($raasi->f820).' | ':"" ;
                                        echo (!empty($raasi->f821))? dropdownTranslate($raasi->f821).' | ':"" ;
                                        echo (!empty($raasi->f822))? dropdownTranslate($raasi->f822).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f823))? dropdownTranslate($raasi->f823).' | ':"" ;
                                        echo (!empty($raasi->f824))? dropdownTranslate($raasi->f824).' | ':"" ;
                                        echo (!empty($raasi->f825))? dropdownTranslate($raasi->f825).' | ':"" ;
                                        ?>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f910))? dropdownTranslate($raasi->f910).' | ':"" ;
                                        echo (!empty($raasi->f911))? dropdownTranslate($raasi->f911).' | ':"" ;
                                        echo (!empty($raasi->f912))? dropdownTranslate($raasi->f912).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f913))? dropdownTranslate($raasi->f913).' | ':"" ;
                                        echo (!empty($raasi->f914))? dropdownTranslate($raasi->f914).' | ':"" ;
                                        echo (!empty($raasi->f915))? dropdownTranslate($raasi->f915).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f920))? dropdownTranslate($raasi->f920).' | ':"" ;
                                        echo (!empty($raasi->f921))? dropdownTranslate($raasi->f921).' | ':"" ;
                                        echo (!empty($raasi->f922))? dropdownTranslate($raasi->f922).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f923))? dropdownTranslate($raasi->f923).' | ':"" ;
                                        echo (!empty($raasi->f924))? dropdownTranslate($raasi->f924).' | ':"" ;
                                        echo (!empty($raasi->f925))? dropdownTranslate($raasi->f925).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f930))? dropdownTranslate($raasi->f930).' | ':"" ;
                                        echo (!empty($raasi->f931))? dropdownTranslate($raasi->f931).' | ':"" ;
                                        echo (!empty($raasi->f932))? dropdownTranslate($raasi->f932).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f933))? dropdownTranslate($raasi->f933).' | ':"" ;
                                        echo (!empty($raasi->f934))? dropdownTranslate($raasi->f934).' | ':"" ;
                                        echo (!empty($raasi->f935))? dropdownTranslate($raasi->f935).' | ':"" ;
                                        ?>
                                        </td>
                                        <td style="height:7em;width: 10%;font-size: 15px">
                                        <?php
                                        echo (!empty($raasi->f940))? dropdownTranslate($raasi->f940).' | ':"" ;
                                        echo (!empty($raasi->f941))? dropdownTranslate($raasi->f941).' | ':"" ;
                                        echo (!empty($raasi->f942))? dropdownTranslate($raasi->f942).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f943))? dropdownTranslate($raasi->f943).' | ':"" ;
                                        echo (!empty($raasi->f944))? dropdownTranslate($raasi->f944).' | ':"" ;
                                        echo (!empty($raasi->f945))? dropdownTranslate($raasi->f945).' | ':"" ;
                                        ?>
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
</div>

<script>
    function renewProfile(m_id) 
{
var base_url=$('#base_url').val();
$.ajax({
  type: 'POST',
  url: base_url+'administrator/renewMember',
  data: '&m_id='+m_id,
  success:function(html)
  {
    $('#edit_output').html(html);
    $('#myModal'+m_id).modal('show');
  }
});
}

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
<!-- Modal Blur -->
<div id="zoomInModal" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="zoomInModalLabel"><?php echo translate('Alert');?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo base_url('AdminController/renewProfile')?>" method="post">
                <input type="hidden" name="member_id" value="<?php echo $single_member->member_id;?>">
            <div class="modal-body">
                <h5 class="fs-16">
                    <?php echo translate("Are_you_sure_you_would_like_to_renew_the_profile?"); ?>
                </h5>
                <div class="col-xxl-12 col-md-12 mt-4">
                    <div>
                        <label for="basiInput" class="form-label"><?php echo translate('member_type');?> <span class="text-danger">*</span></label>
                        <select class="form-select" name="member_type" aria-label="Default select example" id="member_type" required>
                            <option value=''><?php echo translate('choose_one');?></option>
                            <?php 
                            $i=0;
                            $drop_down = get_dropdown(27);
                            foreach($drop_down as $value){ $i++;
                            ?>

                            <option data-id="<?php echo $i;?>" value="<?php echo $i?>"><?php echo dropdownTranslate($value->word);?></option>
                        <?php } ?>
                        </select>
                    </div>
                </div>
                <!--end col-->
                <div class="col-xxl-12 col-md-12 mt-3">
                    <div>
                        <label for="labelInput" class="form-label"><?php echo translate('membership_plans');?><span class="text-danger">*</span></label>
                        <select class="form-select" name="plan_id" aria-label="Default select example" id="membership_ajax_output" required>
                            <option value=""><?= translate('select_member_type_first')?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary ">Save Changes</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
