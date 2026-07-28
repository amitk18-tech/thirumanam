<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}
$admin_role=$this->db->get_where('admin', array('admin_id' => $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id']))->row()->role ;
?>
<div class="row project-wrapper">
<div class="col-xxl-8 col-md-12">
    <div class="row">
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/all_members">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="mdi mdi-account-group-outline"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('total_members')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $all_customer_count; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/all_members/online">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fa fa-globe"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('OnlineRegisteredMembers')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Online_members_datas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/all_members/offline">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                              <i class="fas fa-store-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('offline_member')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Offline_members_datas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/block_members">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fas fa-ban"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('blocked_members')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Blocked_members_datas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
    
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/all_members/report">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fas fa-list"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('report_profile')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Report_members_datas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/incomplete_profile">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                               <i class="fa fa-battery-half"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('incompletedProfiles')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Incompelte_members_datas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/pending_renewal">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fa fa-pause-circle"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('all_pending_renew_member')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $getPendingDatas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/without_profile">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fas fa-user-alt-slash"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('without_profile_members')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $getWithoutProfileDatas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
    </div><!-- end row -->
     <div class="row">
        <?php if($admin_role == 1){ ?>
        <div class="col-xl-6 col-md-6">
          <div class="card card-animate">
            <div class="card-body"  style="height: 70em;">
                <h5 class="card-title mb-3"><?php echo translate('member_activity');?></h5>
                <a href="<?php echo base_url('administrator/member_activity');?>">
                <div class="acitivity-timeline">
                    <?php foreach($members as $member){
                        $images = json_decode($member->profile_image);
                       $profileimage = "";
                        if(!empty($images)){
                            foreach($images as $image){
                                $profileimage = $image->profile_image;
                
                               }
                        }
                        if($member->gender==1)
                        {
                            $err_image = 'uploads/profile_image/default.jpg';

                        }else
                        {
                            $err_image = 'uploads/profile_image/default_female.jpg';
                        }
                        ?>

                    <div class="acitivity-item d-flex">
                        <div class="flex-shrink-0">
                            <img src="<?php echo base_url('uploads/profile_image/'.$profileimage)?>" alt="" class="avatar-xs rounded-circle acitivity-avatar shadow" onError="this.onerror=null;this.src='<?php echo base_url($err_image) ?>';" />
                        </div>
                        <div class="flex-grow-1 mb-4">
                            <h6 class="mb-1"><?php echo $member->first_name;?> <span class="badge bg-soft-primary text-primary align-middle"><?php echo (date('d',strtotime($member->date)) == date('d') ? 'new': "");?></span></h6>
                            <p class="text-muted mb-2"><?php echo $member->activity;?></p>
                            <p class="text-muted mb-2"><?php echo translate('location');?> : <?php echo $member->location;?></p>
                            
                            <small class="mb-0 text-muted"><?php echo ' Date: '.date('d-M-y',strtotime($member->date)).' time: '.date('h:i:sa',strtotime($member->date));?></small><br>
                            <small class="mb-0 text-muted"><?php echo (date('d',strtotime($member->date)) == date('d') ? 'today': "");?></small>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
            </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-6 col-md-6">
            <div class="card card-animate">
                <div class="card-body" style="height: 70em;">
                    <h5 class="card-title mb-3"><?php echo translate('admin_activity');?></h5>

                <a href="<?php echo base_url('administrator/admin_activity');?>">
                    <div class="acitivity-timeline">
                        <?php foreach($admins as $admin){
                           ?>

                        <div class="acitivity-item d-flex">
                            <div class="flex-shrink-0">
                            <?php if($admin->admin_id==1){?>
                                <img src="<?php echo base_url('uploads/profile_image/admin-with-gold-crown.jpg')?>" alt="" class="avatar-xs rounded-circle acitivity-avatar shadow" />
                            <?php }else{ ?>
                                <img src="<?php echo base_url('uploads/profile_image/admin-with-black-crown.png')?>" alt="" class="avatar-xs rounded-circle acitivity-avatar shadow" />
                            <?php } ?>
                                
                            </div>
                            <div class="flex-grow-1 mb-4">
                                <h6 class="mb-1"><?php echo $admin->name;?> <span class="badge bg-soft-primary text-primary align-middle"><?php echo (date('d',strtotime($admin->date)) == date('d') ? 'new': "");?></span></h6>
                                <p class="text-muted mb-2"><?php echo $admin->activity;?></p>
                                
                                
                                <small class="mb-0 text-muted"><?php echo ' Date: '.date('d-M-y',strtotime($admin->date)).' time: '.date('h:i:sa',strtotime($admin->date));?></small><br>
                                <small class="mb-0 text-muted"><?php echo (date('d',strtotime($admin->date)) == date('d') ? 'today': "");?></small>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                </a>
                </div>
                <!--end card-body-->
            </div>
        </div>
    <?php } ?>
        <h5><?php echo translate('matched_members');?></h5>
        <div class="col-xl-6 col-md-6">
        <div class="card card-animate">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><?php echo translate('male');?></h4>
                <div class="flex-shrink-0">
                    
                </div>
            </div><!-- end card header -->
            <a href="<?php echo base_url('administrator/matched_members/male');?>">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;"><?php echo translate('Member ID');?></th>
                                <th scope="col" style="width: 50%;"><?php echo translate('name');?></th>
                                <th scope="col" style="width: 20%;"><?php echo translate('mobile');?></th>
                                <th scope="col" style="width: 20%;"><?php echo translate('date');?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(!empty($matchesMales))
                             foreach($matchesMales as $matchesMale){
                            ?>
                            <tr>
                                <td><?php echo $matchesMale->member_profile_id;?></td>
                                <td><?php echo $matchesMale->first_name;?>
                                </td>
                                <td><?php echo $matchesMale->mobile;?></td>
                                <td><?php echo $matchesMale->matched_date;?></td>
                            </tr>
                        <?php } ?>
                            
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div><!-- end table responsive -->
                <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
            </div><!-- end card body -->
        </a>
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-6 col-md-6">
        <div class="card card-animate">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><?php echo translate('female');?></h4>
                <div class="flex-shrink-0">
                    
                </div>
            </div><!-- end card header -->
            <a href="<?php echo base_url('administrator/matched_members/female');?>">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 10%;"><?php echo translate('Member ID');?></th>
                                <th scope="col" style="width: 50%;"><?php echo translate('name');?></th>
                                <th scope="col" style="width: 20%;"><?php echo translate('mobile');?></th>
                                <th scope="col" style="width: 20%;"><?php echo translate('date');?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(!empty($matchesFemales))
                             foreach($matchesFemales as $matchesFemale){
                            ?>
                            <tr>
                                <td><?php echo $matchesFemale->member_profile_id;?></td>
                                <td><?php echo $matchesFemale->first_name;?>
                                </td>
                                <td><?php echo $matchesFemale->mobile;?></td>
                                <td><?php echo $matchesFemale->matched_date;?></td>
                            </tr>
                        <?php } ?>
                            
                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div><!-- end table responsive -->
                <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
            </div><!-- end card body -->
        </a>
        </div><!-- end card -->
    </div><!-- end col -->
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-height-100">

                <div class="card-body">
                    <a href="<?php echo base_url(); ?>administrator/online_members">
                        <div id="chartContainer" style="height: 180px; width: 100%;"></div>
                        <div>
                            <p class="text-muted text-truncate mb-0 text-center"><?=translate('online_member')?> </p>
                        </div>
                    </a>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
        <div class="col-md-3">
            <div class="card card-height-100">

                <div class="card-body">
                    <a href="<?php echo base_url(); ?>administrator/offline_members">
                        <div id="chartContainer1" style="height: 180px; width: 100%;"></div>
                        <div>
                            <p class="text-muted text-truncate mb-0 text-center"><?=translate('offline_member')?> </p>
                        </div>
                    </a>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
        <div class="col-md-3">
            <div class="card card-height-100">

                <div class="card-body">
                    <a href="<?php echo base_url(); ?>administrator/pending_renewal">
                        <div id="chartContainer2" style="height: 180px; width: 100%;"></div>
                        <div>
                            <p class="text-muted text-truncate mb-0 text-center"><?=translate('incompleted_member')?></p>
                        </div>
                    </a>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
        <div class="col-md-3">
            <div class="card card-height-100">

                <div class="card-body">
                    <a href="<?php echo base_url(); ?>administrator/block_members">
                        <div id="chartContainer3" style="height: 180px; width: 100%;"></div>
                        <div>
                            <p class="text-muted text-truncate mb-0 text-center"><?=translate('blocked_members')?></p>
                        </div>
                    </a>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
        <div class="col-md-3">
            <div class="card card-height-100">

                <div class="card-body">
                    <a href="<?php echo base_url(); ?>administrator/block_members">
                        <div id="chartContainer4" style="height: 180px; width: 100%;"></div>
                        <div>
                            <p class="text-muted text-truncate mb-0 text-center"><?=translate('matched_members')?></p>
                        </div>
                    </a>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
    </div>

    <?php if($admin_role == 1){?>
    <div class="row">
        <h5><?=translate('total_earnings')?></h5>
         <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fas fa-rupee-sign"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('total_earnings')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Earning_members_datas; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                               <i class="fas fa-rupee-sign"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('online_earnings')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Earning_members_online; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fas fa-rupee-sign"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('offline_earnings')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $Earning_members_offline; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
    </div><!-- end row-->
<?php } ?>
<?php if (admin_permission('dashboard_earnings')) { ?>
    <div class="row">
        <h5><?=translate('online_earnings')?></h5>
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-dark rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('today')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $online_today_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
       <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('last_week')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $online_lastweek_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('last_month')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $online_lastmonth_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-secondary rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('last_3_months')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $online_quarterly_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('half_yearly')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $online_halfyearly_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('yearly')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $online_lastyear_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
    </div><!-- end row-->

    <div class="row">
        <h5><?=translate('offline_earnings')?></h5>
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-dark rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('today')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $offline_today_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
       <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-warning rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('last_week')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $offline_lastweek_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-danger rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('last_month')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $offline_lastmonth_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-secondary rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('last_3_months')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $offline_quarterly_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('half_yearly')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $offline_halfyearly_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/earnings">
                    
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success rounded-2 fs-2">
                                <i class="fas fa-money-bill-alt"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted mb-3"><?=translate('yearly')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $offline_lastyear_earnings; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
    </div><!-- end row-->
    <?php } ?>
    <div class="row">
        <h5><?=translate('stories_informations')?></h5>
         <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/stories">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                               <i class="fa fa-book"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('total_stories')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $total_stories; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/stories">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fas fa-book-reader"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('approved_stories')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $approved_stories; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
        <div class="col-xl-4 col-md-4">
            <div class="card card-animate">
                <div class="card-body">
                  <a href="<?php echo base_url(); ?>administrator/stories">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-primary rounded-2 fs-2">
                                <i class="fa fa-pause-circle"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 overflow-hidden ms-3">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=translate('pending_stories')?></p>
                            <div class="d-flex align-items-center mb-3">
                                <h4 class="fs-4 flex-grow-1 mb-0"><span class="counter-value" data-target="<?php echo $pending_stories; ?>"></span></h4>
                                <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                            </div>
                            <p class="text-muted text-truncate mb-0"><?=translate('Member_Overview')?></p>
                        </div>
                    </div>
                 </a>
                </div><!-- end card body -->
            </div>
        </div><!-- end col -->
    </div><!-- end row-->
    <?php if($admin_role == 1){?>
    <div class="row">
        <h5><?=translate('manage_role')?></h5>
        <?php

        if(!empty($roles)){
            // print_r($roles);exit;
            foreach($roles as $role){

             ?>

                <div class="col-xl-4 col-md-4">
                    <div class="card card-animate">
                        <div class="card-body">
                          <a href="<?php echo base_url(); ?>administrator/manage_role">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    
                                   <?php if($role->role_id==1){ ?>
                                    <span class="avatar-title bg-success rounded-2 fs-2">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                   <?php }else{ ?>
                                    <span class="avatar-title bg-secondary rounded-2 fs-2">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                <?php } ?>
                                    
                                </div>
                                <div class="flex-grow-1 overflow-hidden ms-3">
                                    <p style="height: 100%;" class="text-uppercase fw-medium text-muted text-truncate mb-3"><?=$role->name?></p>
                                    <div class="d-flex align-items-center mb-3">

                                        <select class="form-control" id="choices-multiple" data-choices name="permission[]" multiple>
                                    
                                    <?php if(!empty($permissions) && !empty($role->permission) && $role->role_id!=1){
                                        $rol = json_decode($role->permission);

                                        foreach($permissions as $permission){ 
                                        
                                            if($role->role_id==1){ ?>

                                            <option selected><?php echo $permission['codename'];?></option> 
                                            
                                       <?php } ?>
                                    <option <?php echo (in_array($permission['permission_id'],$rol)) ? 'selected' : "";?> value="<?php echo $permission['permission_id'];?>"><?php echo $permission['codename'];?></option> 
                                    <?php } }?>
                                </select>

                                        
                                        <!-- <span class="badge badge-soft-danger fs-12"><i class="ri-arrow-down-s-line fs-13 align-middle me-1"></i>5.02 %</span> -->
                                    </div>
                                    <p class="text-muted text-truncate mb-0"><?=translate('view')?></p>
                                </div>
                            </div>
                         </a>
                        </div><!-- end card body -->
                    </div>
                </div><!-- end col -->


         <?php  } } ?>
         

    </div>
<?php } ?>
   </div>
</div>
<style type="text/css">
    .canvasjs-chart-credit{
        display: none !important;
    }
</style>
<?php 
    
    $onlineMaleMember = 0;
    $onlineFemaleMember = 0;

    $offlineMaleMember = 0;
    $offlineFemaleMember = 0;


    $onlineIncompleteMaleMember = 0;
    $onlineIncompleteFemaleMember = 0;


    $blockMaleMember = 0;
    $blockFemaleMember = 0;

    $matchedMaleMember = 0;
    $matchedFemaleMember = 0;

    foreach ($all_member as $key => $value) {
$d = date('Y-m-d', strtotime('-6 months'));
        if($value['member_type'] == 1 && $value['gender'] == 1 && $value['is_blocked']=='no' && $value['member_since'] >= $d)
        {
            $onlineMaleMember += 1;
        }
        if($value['member_type'] == 1 && $value['gender'] == 2 && $value['is_blocked']=='no' && $value['member_since'] >= $d)
        {
            $onlineFemaleMember +=1;
        }


        if($value['member_type'] == 2 && $value['gender'] == 1 && $value['is_blocked']=='no' && $value['member_since'] >= $d)
        {
            $offlineMaleMember += 1;
        }
        if($value['member_type'] == 2 && $value['gender'] == 2 && $value['is_blocked']=='no' && $value['member_since'] >= $d)
        {
            $offlineFemaleMember +=1;
        }



        if($value['gender'] == 1 && $value['updateProfileDoneStatus'] == 0 && $value['is_blocked']=='no' && $value['member_since'] >= $d)
        {
            $onlineIncompleteMaleMember += 1;
        }
        if($value['gender'] == 2 && $value['updateProfileDoneStatus'] == 0 && $value['is_blocked']=='no' && $value['member_since'] >= $d)
        {
            $onlineIncompleteFemaleMember +=1;
        }

        if($value['gender'] == 1 && $value['is_blocked'] == 'yes')
        {
            $blockMaleMember += 1;
        }
        if($value['gender'] == 2 && $value['is_blocked'] == 'yes')
        {
            $blockFemaleMember +=1;
        }

        
        
    }

    foreach ($matchesMales as $matchesMale) {

        if($matchesMale->gender == 1 && $matchesMale->is_married==1)
        {
            $matchedMaleMember += 1;
        }
    }

    foreach ($matchesFemales as $matchesFemale) {

        if($matchesFemale->gender == 2 && $matchesFemale->is_married==1)
        {
            $matchedFemaleMember += 1;
        }
    }


 ?>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
window.onload = function() {

    // First Chart ==================================
CanvasJS.addColorSet("greenShades",
                [//colorSet Array

                "#2E8B57",
                "#3CB371",
                              
                ]);
var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    colorSet: "greenShades",
    data: [{
        type: "doughnut",
        indexLabelPlacement: "inside",
        startAngle: 300,
        indexLabelFontSize: 15,
        
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: <?=$onlineMaleMember?>, label: "<?=translate('male')?>"},
            {y: <?=$onlineFemaleMember?>, label: "<?=translate('female')?>"},




            
        ]
    }]
});
chart.render();



// Sencond Chartn ================================================

CanvasJS.addColorSet("greenShades1",
                [//colorSet Array

                "#af7c3b",
                "#ff930a",
                              
                ]);
var chart1 = new CanvasJS.Chart("chartContainer1", {
    animationEnabled: true,
    colorSet: "greenShades1",
    data: [{
        type: "doughnut",
        indexLabelPlacement: "inside",
        startAngle: 300,
        indexLabelFontSize: 15,
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: <?=$offlineMaleMember?>, label: "<?=translate('male')?>"},
            {y: <?=$offlineFemaleMember?>, label: "<?=translate('female')?>"},
            
        ]
    }]
});
chart1.render();




// Third Chart ====================================
CanvasJS.addColorSet("greenShades2",
                [//colorSet Array

                "#2e6381",
                "#13aaff",
                               
                ]);
var chart2 = new CanvasJS.Chart("chartContainer2", {
    animationEnabled: true,
    colorSet: "greenShades2",
    data: [{
        type: "doughnut",
indexLabelPlacement: "inside",
        startAngle: 300,
        indexLabelFontSize: 15,     
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: <?=$onlineIncompleteMaleMember?>, label: "<?=translate('male')?>"},
            {y: <?=$onlineIncompleteFemaleMember?>, label: "<?=translate('female')?>"},
            
        ]
    }]
});
chart2.render();




// Fourth Chart ======================================
CanvasJS.addColorSet("greenShades3",
                [//colorSet Array

                "#909233",
                "#faff00",
                               
                ]);
var chart3 = new CanvasJS.Chart("chartContainer3", {
    animationEnabled: true,
    colorSet: "greenShades3",
    data: [{
        type: "doughnut",
indexLabelPlacement: "inside",
        startAngle: 350,
        indexLabelFontSize: 15,     
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: <?=$blockMaleMember?>, label: "<?=translate('male')?>"},
            {y: <?=$blockFemaleMember?>, label: "<?=translate('female')?>"},
            
        ]
    }]
});
chart3.render();

// Fourth Chart ======================================
CanvasJS.addColorSet("greenShades3",
                [//colorSet Array

                "#909233",
                "#faff00",
                               
                ]);
var chart4 = new CanvasJS.Chart("chartContainer4", {
    animationEnabled: true,
    colorSet: "greenShades3",
    data: [{
        type: "doughnut",
indexLabelPlacement: "inside",
        startAngle: 350,
        indexLabelFontSize: 15,     
        indexLabel: "{label} {y}",
        dataPoints: [
            {y: <?=$matchedMaleMember?>, label: "<?=translate('male')?>"},
            {y: <?=$matchedFemaleMember?>, label: "<?=translate('female')?>"},
            
        ]
    }]
});
chart4.render();

}





</script>