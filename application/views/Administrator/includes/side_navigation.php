
<?php
$show_members=$view_customer=$allmembers=$offlinemembers=$pendingrenewal=$incompleteprofile=$withoutprofile=$bulkprint=$blockmembers=$closemembers=$duplicatemembers=$onlinemembers=$addmembers=$deletemembers=$oldidmembers=$reportedmembers=$matchedmembers=$membersactive=$deactivatemembers='';
$uri1=$this->uri->segment(1);
$uri2=$this->uri->segment(2);
$uri3=$this->uri->segment(3);
$uri4=$this->uri->segment(4);
$uri5=$this->uri->segment(5);



 

if ($uri2=='all_members') {
    $allmembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}
if ($uri2=='offline_members') {
    $offlinemembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}

if ($uri2=='pending_renewal') {
    $pendingrenewal="active";
    $show_members = 'show';
    $membersactive = 'active';
}
if ($uri2=='incomplete_profile') {
    $incompleteprofile="active";
    $show_members = 'show';
    $membersactive = 'active';
}
if ($uri2=='without_profile') {
    $withoutprofile="active";
    $show_members = 'show';
    $membersactive = 'active';
}
if ($uri2=='bulk_profile_print') {
    $bulkprint="active";
    $show_members = 'show';
    $membersactive = 'active';
}
if ($uri2=='block_members') {
    $blockmembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='close_members') {
    $closemembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='duplicate_members') {
    $duplicatemembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='online_members') {
    $onlinemembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='add_new_member') {
    $addmembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='deleted_members') {
    $deletemembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='old_id_of_renewed_members') {
    $oldidmembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}  
if ($uri2=='reported_members') {
    $reportedmembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}
if ($uri2=='matched_members') {
    $matchedmembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}

if ($uri2=='deactivated_members') {
    $deactivatemembers="active";
    $show_members = 'show';
    $membersactive = 'active';
}

    

 


$show_message=$contact_message=$news_letter=$expiry_alert=$messageactive="";

if ($uri2=='contact_message' || $uri3=='view_message' ) {
    $contact_message="active";
    $show_message = 'show';
    $messageactive = 'active';
}
if ($uri2=='news_letter') {
    $news_letter="active";
    $show_message = 'show';
    $messageactive = 'active';
}
if ($uri2=='expiry_alert') {
    $expiry_alert="active";
    $show_message = 'show';
    $messageactive = 'active';
}

$show_admin=$all_staffs=$manage_role=$adminactive="";

if ($uri2=='all_staffs' || $uri3=='edit_admin') {
    $all_staffs="active";
    $show_admin = 'show';
    $adminactive = 'active';
}
if ($uri2=='manage_role' || $uri3=='edit_role') {
    $manage_role="active";
    $show_admin = 'show';
    $adminactive = 'active';
}

$usefull_links=$edit_faq=$edit_t_condition=$edit_p_policy=$usefull_active="";

if ($uri2=='view_faq') {
    $edit_faq="active";
    $usefull_links = 'show';
    $usefull_active = 'active';
}
if ($uri2=='edit_terms_and_conditions'){
    $edit_t_condition="active";
    $usefull_links = 'show';
    $usefull_active = 'active';
}
if ($uri2=='edit_privacy_policy') {
    $edit_p_policy="active";
    $usefull_links = 'show';
    $usefull_active = 'active';
}


$admin_role=$this->db->get_where('admin', array('admin_id' => $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id']))->row()->role ;

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
   <!-- LOGO -->
   <div class="navbar-brand-box">
    <?php
        $favicon = $this->db->get_where('frontend_settings', array('type' => 'favicon'))->row()->value;
        $favicon = json_decode($favicon, true);
        if (!empty($favicon) && file_exists('uploads/'.$favicon[0]['image'])) {
    ?>
        <img src="<?=base_url()?>uploads/favicon/<?=$favicon[0]['image']?>" alt="Active Matrimony Logo" class="brand-icon" style="padding: 5px">
    <?php }else { ?>
        <img src="<?=base_url()?>uploads/default_image.png" alt="Active Matrimony Logo" class="brand-icon" style="padding: 5px">
                <!-- <link href="<?=base_url()?>uploads/favicon/default_image.png" rel="icon" type="image/png"> -->
    <?php } ?>
      <a href="<?php echo base_url('administrator'); ?>" class="m-1">
         <h2 class="text-white" style="overflow: hidden;"><?php echo getSettings()->site_title; ?></h2>
      </a>      
      <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
      <i class="ri-record-circle-line"></i>
      </button>
   </div>
   <div id="scrollbar">
      <div class="container-fluid">
         <div id="two-column-menu">
         </div>
         <ul class="navbar-nav" id="navbar-nav">
            <li class="menu-title"><span data-key="t-menu">Menu</span></li>
            <li class="nav-item">
               <a class="nav-link menu-link <?php if($uri2=='home' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/home'); ?>">
                  <i class="mdi mdi-home"></i> <span data-key="t-dashboard"><?php echo translate('dashboard');?></span>
               </a>
            </li>

            <ul class="navbar-nav" id="navbar-nav">
                       <?php if (admin_permission('members')) { ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo $membersactive;?>" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="mdi mdi-account-group-outline"></i> <span data-key="t-dashboards"><?php echo translate('members');?></span>
                            </a>
                            <div class="collapse menu-dropdown <?php echo $show_members;?>" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                <?php if (admin_permission('free_members')){ ?>
                                    <?php if ($admin_role==1){ ?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/all_members')?>"  class="nav-link <?php echo $allmembers;?>" data-key="t-analytics"><?php echo translate('all_member');?></a>
                                    </li>
                                    <?php } ?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/offline_members')?>" class="nav-link <?php echo $offlinemembers;?>" data-key="t-crm"> <?php echo translate('offline_member')?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/pending_renewal')?>" class="nav-link <?php echo $pendingrenewal;?>" data-key="t-ecommerce"><?php echo translate('all_pending_renew_member')?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/incomplete_profile')?>" class="nav-link <?php echo $incompleteprofile;?>" data-key="t-crypto"><?php echo translate('incompletedProfiles')?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/without_profile')?>" class="nav-link <?php echo $withoutprofile;?>" data-key="t-projects"> <?php echo translate('without_profile_members')?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/bulk_profile_print')?>"  class="nav-link <?php echo $bulkprint;?>" data-key="t-analytics"> <?php echo translate('Bluk_Members_Profile_Print'); ?> </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/block_members')?>" class="nav-link <?php echo $blockmembers;?>" data-key="t-crm"> <?php echo translate('blocked_members'); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/close_members')?>" class="nav-link <?php echo $closemembers;?>" data-key="t-ecommerce"> <?php echo translate('closed_members'); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/duplicate_members')?>" class="nav-link <?php echo $duplicatemembers;?>" data-key="t-crypto"><?php echo translate('duplicate_members'); ?></a>
                                    </li>
                                    <?php } if (admin_permission('premium_members')){?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/online_members')?>" class="nav-link <?php echo $onlinemembers;?>" data-key="t-projects"> <?php echo translate('OnlineRegisteredMembers');?></a>
                                    </li>
                                <?php } if (admin_permission('add_members')){?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/add_new_member')?>"  class="nav-link <?php echo $addmembers;?>" data-key="t-analytics"> <?php echo translate('add_member')?> </a>
                                    </li>
                                <?php }  if (admin_permission('deleted_members')){?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/deleted_members')?>" class="nav-link <?php echo $deletemembers;?>" data-key="t-crm"> <?php echo translate('deleted_members')?> </a>
                                    </li>
                                <?php } ?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/old_id_of_renewed_members')?>" class="nav-link <?php echo $oldidmembers;?>" data-key="t-ecommerce"><?php echo translate('old_id_of_renewed_members')?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/reported_members')?>" class="nav-link <?php echo $reportedmembers;?>" data-key="t-crypto"><?php echo translate('reported_members')?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/matched_members')?>" class="nav-link <?php echo $matchedmembers;?>" data-key="t-crypto"><?php echo translate('matched_members')?></a>
                                    </li>
                                    <?php if($admin_role==1){?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/deactivated_members')?>" class="nav-link <?php echo $deactivatemembers;?>" data-key="t-crypto"><?php echo translate('deactivated_members')?></a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li> 
                    <?php } ?>
                    <?php if ($admin_role==1){
                            ?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='membership_plans' || $uri2=='edit_plan'){ echo 'active';} ?>" href="<?php echo base_url('administrator/membership_plans'); ?>">
                              <i class="fa fa-newspaper-o"></i><span data-key="t-dashboard"><?php echo translate('membership_plans')?></span>
                           </a>
                        </li>
                    <?php } ?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='stories' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/stories'); ?>">
                              <i class="fa fa-book"></i><span data-key="t-dashboard"><?php echo translate('stories')?></span>
                           </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo $usefull_active;?>" href="#sidebaremail" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebaremail">
                                <i class="fas fa-users-cog"></i> <span data-key="t-dashboards"> <?php echo translate('edit_usefull_links'); ?></span>
                            </a>
                            <div class="collapse menu-dropdown <?php echo $usefull_links;?>" id="sidebaremail">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/view_faq')?>"  class="nav-link  <?php echo $edit_faq;?>" data-key="t-analytics"> <?php echo translate('faq'); ?> </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/edit_terms_and_conditions')?>" class="nav-link <?php echo $edit_t_condition;?>" data-key="t-crm"><?php echo translate('terms_and_conditions'); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/edit_privacy_policy')?>" class="nav-link <?php echo $edit_p_policy;?>" data-key="t-crm"><?php echo translate('privacy_policy'); ?></a>
                                    </li>
                                </ul>
                            </div>
                        </li><!-- end menu assignation Menu -->
                    <?php if (admin_permission('earnings')){ ?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='activation' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/activation'); ?>">
                              <i class="fa fa-rupee"></i></i><span data-key="t-dashboard"><?php echo translate('activation')?></span>
                           </a>
                        </li>
                    <?php } if ($admin_role==1){ ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo $messageactive;?>" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="fas fa-envelope"></i> <span data-key="t-dashboards"><?php echo translate('messaging')?></span>
                            </a>
                            <div class="collapse menu-dropdown <?php echo $show_message;?>" id="sidebarApps">
                                <ul class="nav nav-sm flex-column">
                                <?php if (admin_permission('contact_messages')){ ?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/contact_message')?>"  class="nav-link  <?php echo $contact_message;?>" data-key="t-analytics"> <?php echo translate('contact_messages')?> </a>
                                    </li>
                                <?php } ?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/news_letter')?>" class="nav-link <?php echo $news_letter;?>" data-key="t-crm"><?php echo translate('newsletter')?> </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/expiry_alert')?>" class="nav-link <?php echo $expiry_alert;?>" data-key="t-crm"> <?php echo translate('expiry_alert')?> </a>
                                    </li>
                                   
                                    
                                </ul>
                            </div>
                        </li> <!-- end Images Menu -->
                    <?php } ?>
                    <?php if ($admin_role == 1){ ?>
                         <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='memories' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/memories'); ?>">
                              <i class="far fa-images"></i><span data-key="t-dashboard"><?php echo translate('memories')?></span>
                           </a>
                        </li><!-- end listalladmin_users Menu -->
                    
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='send_sms' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/send_sms'); ?>">
                              <i class="fas fa-sms"></i><span data-key="t-dashboard"><?php echo translate('send_SMS')?></span>
                           </a>
                        </li><!-- end menu assignation Menu -->
                    <?php } ?>
                    <?php if (admin_permission('Information_Page')){ ?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='important_notes' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/important_notes'); ?>">
                              <i class="far fa-sticky-note"></i><span data-key="t-dashboard"><?php echo translate('Information_Page')?></span>
                           </a>
                        </li><!-- end menu assignation Menu -->
                    <?php } if($admin_role == 1 || $admin_role == 12 ){ ?> 
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='reports' || $uri2=='searchReport'){ echo 'active';} ?>" href="<?php echo base_url('administrator/reports'); ?>">
                              <i class="fas fa-list"></i><span data-key="t-dashboard"><?php echo translate('reports')?></span>
                           </a>
                        </li><!-- end menu assignation Menu -->
                    <?php } if($admin_role == 1){?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='member_activity' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/member_activity'); ?>">
                              <i class="fas fa-user"></i><span data-key="t-dashboard"><?php echo translate('member_activity')?></span>
                           </a>
                        </li>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='admin_activity' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/admin_activity'); ?>">
                              <i class="fas fa-crown"></i><span data-key="t-dashboard"><?php echo translate('admin_activity')?></span>
                           </a>
                        </li>
                    <?php } ?>
                    <?php if ($admin_role == 1){ ?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='view_template' || $uri2=='add_template' || $uri2=='edit_template'){ echo 'active';} ?>" href="<?php echo base_url('administrator/view_template'); ?>">
                              <i class="fas fa-envelope"></i><span data-key="t-dashboard"><?php echo translate('email_template')?></span>
                           </a>
                        </li>
                    <?php } ?>
                        
                    <?php  if (admin_permission('manage_admin')){?>
                        <li class="nav-item">
                           <a class="nav-link menu-link <?php if($uri2=='Manage_admin_profile' || $uri2==''){ echo 'active';} ?>" href="<?php echo base_url('administrator/Manage_admin_profile'); ?>">
                              <i class="fas fa-tools"></i><span data-key="t-dashboard"><?php echo translate('manage_admin_profile')?></span>
                           </a>
                        </li><!-- end menu assignation Menu -->

                    <?php } if (admin_permission('staffs_panel')){?>
                        <li class="nav-item">
                            <a class="nav-link menu-link <?php echo $adminactive;?>" href="#sidebaremailTemplates" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebaremailTemplates">
                                <i class="fas fa-users-cog"></i> <span data-key="t-dashboards"> <?php echo translate('staffs_panel'); ?></span>
                            </a>
                            <div class="collapse menu-dropdown <?php echo $show_admin;?>" id="sidebaremailTemplates">
                                <ul class="nav nav-sm flex-column">
                                <?php if (admin_permission('all_staffs')){?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/all_staffs')?>"  class="nav-link  <?php echo $all_staffs;?>" data-key="t-analytics"> <?php echo translate('all_staffs'); ?> </a>
                                    </li>
                                <?php } if (admin_permission('manage_roles')){?>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url('administrator/manage_role')?>" class="nav-link <?php echo $manage_role;?>" data-key="t-crm"><?php echo translate('manage_roles'); ?></a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
                        </li><!-- end menu assignation Menu -->

                    <?php } ?>

            <li class="nav-item">
               <a class="nav-link menu-link" href="<?php echo base_url('administrator/logout'); ?>">
                  <i class="mdi mdi-logout "></i> <span data-key="t-logout"><?php echo translate('logout'); ?></span>
               </a>
            </li>
         </ul>
      </div>
      <!-- Sidebar -->
   </div>
   <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">
<div class="page-content">
<div class="container-fluid">
<!-- start page title -->
<?php
$title='Dashboard';
$breadcrumbs=[];
if ($uri1=='home') {
   $title='Dashboard';
}
if ($uri1=='students') {
   $title='Students';
   $breadcrumbs[]='<li class="breadcrumb-item active">Students</li>';
}
?>

<div class="row d-none">
   <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
         <h4 class="mb-sm-0"><?php echo $title; ?></h4>
         <div class="page-title-right">
            <ol class="breadcrumb m-0">
               <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboardd</a></li>
               <?php
               if (!empty($breadcrumbs)) {
                  foreach ($breadcrumbs as $value) {
                     echo $value;
                  }
               }
               ?>               
            </ol>
         </div>
      </div>
   </div>
</div>
<!-- end page title -->
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">