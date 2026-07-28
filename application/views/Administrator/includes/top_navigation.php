
<?php
$url1=$this->uri->segment(1);
$url2=$this->uri->segment(2);
$url3=$this->uri->segment(3);
$title= translate('dashboard');



if ($url2=='all_members') {
    $title = translate('all_member');

}
if ($url2=='offline_members') {
    $title=translate('offline_member');
}
if ($url2=='pending_renewal') {
    $title=translate('all_pending_renew_member');
}

if ($url2=='incomplete_profile') {
    $title=translate('incompletedProfiles');
}
if ($url2=='without_profile') {
    $title=translate('without_profile_members');
}
if ($url2=='bulk_profile_print') {
    $title=translate('Bluk_Members_Profile_Print');
}
if ($url2=='block_members') {
    $title=translate('blocked_members');
}
if ($url2=='close_members') {
    $title=translate('closed_members');
}
if ($url2=='duplicate_members') {
    $title=translate('duplicate_members');
}
if ($url2=='view_template') {
    $title=translate('email_template');
}
if ($url2=='add_template') {
    $title=translate('email_template');
}



if ($url2=='online_members') {
    $title=translate('online_member');

}
if ($url2=='add_new_member') {
    $title=translate('add_member');
}
if ($url2=='deleted_members') {
    $title=translate('deleted_members');
}

if ($url2=='old_id_of_renewed_members') {
    $title=translate('old_id_of_renewed_members');
}
if ($url2=='reported_members') {
    $title=translate('reported_members');
}
if ($url2=='membership_plans') {
    $title=translate('membership_plans');
}
if ($url2=='stories') {
    $title=translate('stories');
}
if ($url2=='activation') {
    $title=translate('activation');
}
if ($url2=='contact_message') {
    $title=translate('contact_messages');

}
if ($url2=='news_letter') {
    $title=translate('newsletter_subject');
}
if ($url2=='expiry_alert') {
    $title=translate('expiry_alert');
}

if ($url2=='memories') {
    $title=translate('memories');
}
if ($url2=='send_sms') {
    $title=translate('send_sms');
}
if ($url2=='important_notes') {
    $title=translate('message');
}
if ($url2=='reports') {
    $title=translate('reports');
}
if ($url2=='Manage_admin_profile') {
    $title=translate('manage_admin_profile');
}
if ($url2=='all_staffs') {
    $title=translate('all_staffs');
}
if ($url2=='manage_role') {
    $title=translate('manage_role');
}
if ($url3=='view_member') {
    $title = translate('member_details');
}
if ($url3=='edit_member') {
    $title=translate('update');
}
if ($url2=='edit_plan') {
    $title="edit membership plan";
}
if ($url3=='view_story') {
    $title="view story";
}

if ($url2=='edit_admin') {
    $title="edit admin";
}
if ($url3=='view_message') {
    $title="view message";
}
if ($url3=='edit_admin') {
    $title="edit staff";
}
if ($url3=='edit_role') {
    $title="edit role";
}

if ($url2=='member_activity') {
    $title = translate('member_activity');

}
if ($url2=='edit_template') {
    $title = translate('email_template');

}
if ($url2=='emailTemplate') {
    $title = translate('email_template');

}
if ($url2=='searchReport') {
    $title = translate('Reports');

}
if ($url2=='admin_activity') {
    $title = translate('admin_activity');

}
if ($url2=='matched_members') {
    $title = translate('matched_members');

}

?>
<?php
 $uri1 = $this->uri->segment(1);
 // print_r($uri1);exit;
 if ($set_lang = $this->session->userdata('language')) {
 
 } else {
     $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
 }
 $lid = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->site_language_list_id;
 $lnm = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->name;
 ?>
<style type="text/css">
    @media only screen and (max-width: 768px) {
        /* For mobile phones: */
        #admin-alert{
            position: absolute;
            z-index: 9;
        }
    }
</style>
 <style>
.switch-field {
  display: flex;
  overflow: hidden;
}

.switch-field input {
  position: absolute !important;
  clip: rect(0, 0, 0, 0);
  height: 1px;
  width: 1px;
  border: 0;
  overflow: hidden;
}

.switch-field label {
  background-color: #e4e4e4;
  color: black;
  font-size: 14px;
  line-height: 1;
  text-align: center;
  padding: 8px 16px;
  margin-right: -1px;
  border: 1px solid rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
  transition: all 0.1s ease-in-out;
}

.switch-field label:hover {
  cursor: pointer;
}

.switch-field input:checked + label {
  background-color: #212529;
  box-shadow: none;
  color: white;
}

.switch-field label:first-of-type {
  border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
  border-radius: 0 4px 4px 0;
}

/* This is just for CodePen. */




</style>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">                    
                    <a href="<?php echo base_url('admin'); ?>" class="logo logo-dark">
                        <h1><?php echo getSettings()->site_title; ?></h1>
                    </a>

                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                <h5 class="mt-4" style="font-weight: 600;padding-top:2px;color: #747474;"><?php echo 
                $title; ?></h5>
            </div>
            <form class="form">
              <div class="switch-field">
                <input type="radio" id="choice1" name="choice" value="English" <?php if ($set_lang == "english") { echo "checked"; } ?>>
                <label for="choice1">English</label>
                <input type="radio" id="choice2" name="choice" value="தமிழ்" <?php if ($set_lang == "tamil") { echo "checked"; } ?>>
                <label for="choice2">தமிழ்</label>
              </div>
            </form>
            <?php echo $this->session->flashdata('msg'); ?>
            <div class="d-flex align-items-center">
                <a href="<?php echo base_url('home')?>" class="btn btn-sm btn-outline-dark"><?php echo translate('visit_home_page');?></a>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle shadow-none" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode shadow-none">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>  

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php echo base_url('assets/uploads/') ?>user_ava_2.png" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo getLoggedAdmin()->email; ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php echo getLoggedAdmin()->role==1 ? 'ADMIN' : 'SUB ADMIN' ; ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome </h6>
                        <a class="dropdown-item" href="<?php echo base_url('administrator/Manage_admin_profile'); ?>"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle"><?php echo translate('manage_profile');?></span></a>         
                        <a class="dropdown-item" href="<?php echo base_url('administrator/logout'); ?>"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout"><?php echo translate('log_out');?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<style>
    div.dataTables_wrapper div.dataTables_paginate {

        text-align: left!important;
    }
    .navbar-nav {

        margin-bottom: 5em;
    }
    
</style>
