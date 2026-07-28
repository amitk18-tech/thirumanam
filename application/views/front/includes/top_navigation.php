<style>
.mainmenu ul li a {
    font-size: 15px !important;
}
</style>

<?php
 $uri1 = $this->uri->segment(1);
 // print_r($uri1);exit;
 if ($this->session->userdata('language')) {
    $set_lang = $this->session->userdata('language');
 } else {
     $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
 }
 $lid = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->site_language_list_id;
 $lnm = $this->db->get_where('site_language_list', array('db_field' => $set_lang))->row()->name;
 ?>
<style>
p,
h1,
h2,
h3,
h4,
h5,
h6,
input,
textarea,
label,
span {
    -webkit-user-select: none;
    /* Safari */
    -ms-user-select: none;
    /* IE 10 and IE 11 */
    user-select: none;
    /* Standard syntax */
    font-size: 13px;
}




.dropbtn1 {
    background-color: white;
    padding: 5px;
    font-size: 16px;
    border-radius: 10px;
}

.dropbtn2 {
    background-color: white;
    padding: 5px;
    font-size: 16px;
    border-radius: 10px;
}

.dropdown {
    position: relative;
    display: inline-block;
    padding-right: 15px;
}

.dropdown-content {
    display: none;
    padding: 10px;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 250px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    overflow-y: scroll;
    overflow-x: hidden;
    max-height: 300px;
    overflow-x: auto;

}

.dropdown-content2 {
    display: none;
    padding: 10px;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 250px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    overflow-y: scroll;
    overflow-x: hidden;
    max-height: 300px;
    overflow-x: auto;
}

.dropdown-content a {
    color: black;
    padding: 0px 5px;
    text-decoration: none;
    display: block;
}

.dropdown-content2 a {
    color: black;
    padding: 0px 5px;
    text-decoration: none;
    display: block;
}

.dropdown-content p {
    color: black;
    padding: 0px 5px !important;
    text-decoration: none;
    display: block;
}

.dropdown-content2 p {
    color: black;
    padding: 0px 5px !important;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown-content2 a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropdown-content2 {
    display: block;
}

.dropdown:hover .dropbtn1 {
    background-color: pink;
}

.dropdown:hover .dropbtn2 {
    background-color: pink;
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

.switch-field input:checked+label {
    background-color: #ff0461;
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
<!-- preloader start here -->
<div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- preloader ending here -->


<!-- scrollToTop start here -->
<a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
<!-- scrollToTop ending here -->


<!-- ================> header section start here <================== -->
<header class="header header--style2" id="navbar">
    <div class="header__top d-none d-lg-block" style="display: block !important;">
        <div class="container">
            <div class="header__top--area">
                <div class="header__top--left">
                    <ul>
                        <li>
                            <i class="fa-solid fa-phone"></i> <span>(+91) 94878 33674 / (+91) 98942 78185 </span>
                        </li>
                        <li>
                            <form class="form">
                                <div class="switch-field">
                                    <input type="radio" id="choice1" name="choice" value="English" checked>
                                    <label for="choice1">English</label>
                                    <input type="radio" id="choice2" name="choice" value="தமிழ்"
                                        <?php if ($set_lang == "tamil") { echo "checked"; } ?>>
                                    <label for="choice2">தமிழ்</label>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <div class="header__top--right">
                    <ul>

                        <!-- <li><a href="#"><i class="fa-brands fa-facebook-messenger"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa-brands fa-vimeo-v"></i></a></li> -->
                        <?php if($this->session->userdata('thirumanam_logged_data')){
                            $noti_counter = 0;
                            $msg_counter = 0;
                            $notifications = get_type_name_by_id('member', $this->session->userdata('thirumanam_logged_data')['member_id'], 'notifications');
                            $notification = json_decode($notifications, true);
                            sort_array_of_array($notification, 'time', SORT_DESC);

                            $member=$this->db->get_where("member", array("member_id" => $this->session->userdata('thirumanam_logged_data')['member_id']))->row();

                            $profile_images = get_type_name_by_id('member', $this->session->userdata['thirumanam_logged_data']['member_id'], 'profile_image');
                            $profile_image = json_decode($profile_images, true);
                            $listed_messaging_members = get_listed_messaging_members($this->session->userdata('thirumanam_logged_data')['member_id']);
                            sort_array_of_array($listed_messaging_members, 'message_thread_time', SORT_DESC);

                             $count_messaging_members = count_listed_messaging_members($this->session->userdata('thirumanam_logged_data')['member_id']);

                             // print_r($count_messaging_members);exit;
                           
                               
                        
                            // print_r($notification);exit;
                                ?>
                        <li>
                            <div class="dropdown">
                                <button class="dropbtn1 text_info"><i class="fas fa-bell"></i></button>
                                <div class="dropdown-content">
                                    <?php 
                                    foreach ($notification as $row) {
                                        $is_member = $this->db->get_where("member", array("member_id" => $row['by']))->row();
                                        if(!empty($is_member) && $is_member->is_closed == 'no'){
                                    if ($this->db->get_where('member', array('member_id' => $row['by']))->row()->member_id){
                                    if ($row['is_seen'] == 'no') {
                                    $noti_counter++;
                                     }
                                    if($row['type'] == 'interest_expressed') {
                                    $noti_profile_image = get_type_name_by_id('member', $row['by'], 'profile_image');
                                    $noti_images = json_decode($noti_profile_image, true);
                                    $notify_member = $this->db->get_where('member', array('member_id' => $row['by']))->row()
                                    ?>

                                    <a title="<?php echo translate('view_profile')?>"
                                        href="<?php echo base_url('short_view/'.$row['by']);?>">


                                        <?php if($notify_member->gender==1){?>
                                        <img style="object-fit:contain;height:50px;width: 50%;border-radius: 10px;"
                                            alt="dating thumb"
                                            src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                                        <?php } ?>
                                        <?php if($notify_member->gender==2){?>
                                        <img style="object-fit:contain;height:50px;width: 50%;" alt="dating thumb"
                                            src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                                        <?php } ?>
                                    </a>
                                    <p style="font-size:11px" class="p-2"><i class="c-base-1 fa fa-clock-o"></i>
                                        <?=date('d M,y - h:i A', $row['time'])?></p>
                                    <a class="bg-info" style="border-radius: 5px;font-size: 12px;color: white;"
                                        href="<?=base_url()?>short_view/<?= $row['by']; ?>">
                                        <?= get_type_name_by_id('member', $row['by'], 'first_name'); ?>
                                    </a>
                                    <p><?php echo translate('has_expressed_an_interest_on_you')?></p>

                                    <?php 
                                if($row['status'] == 'pending') {
                                ?>
                                    <div class="text-center pt-1 text_<?=$row['by']?>">
                                        <button type="button" class="btn btn-sm btn-success pt-0 pb-0"
                                            id="accept_<?=$row['by']?>"
                                            onclick="confirm_accept(<?=$row['by']?>)"><?php echo translate('accept')?></button>
                                        <button type="button" class="btn btn-sm btn-danger pt-0 pb-0"
                                            id="reject_<?=$row['by']?>"
                                            onclick="confirm_reject(<?=$row['by']?>)"><?php echo translate('reject')?></button>
                                    </div>
                                    <?php
                                } else if($row['status'] == 'accepted') {
                                ?>
                                    <div class="text-center text-success text_<?=$row['by']?>">
                                        <small class="sml_txt text-success">
                                            <i
                                                class="fa fa-check-circle"></i><?php echo translate('you_have_accepted_the_interest')?>
                                        </small>
                                    </div>
                                    <?php
                                } else if($row['status'] == 'rejected') {
                                ?>
                                    <div class="text-center text-danger text_<?=$row['by']?>">
                                        <small class="sml_txt text-denger">
                                            <i
                                                class="fa fa-times-circle"></i><?php echo translate('you_have_rejected_the_interest')?>
                                        </small>
                                    </div>
                                    <?php
                                }
                            ?>
                                    <hr style="color:black;">
                                    <?php
                                }
                                elseif ($row['type'] == 'accepted_interest') {

                                    $noti_profile_image = get_type_name_by_id('member', $row['by'], 'profile_image');
                                    $noti_images = json_decode($noti_profile_image, true);
                                    $notify_member = $this->db->get_where('member', array('member_id' => $row['by']))->row()
                                    ?>

                                    <a title="<?php echo translate('view_profile')?>"
                                        href="<?php echo base_url('short_view/'.$row['by']);?>">


                                        <?php if($notify_member->gender==1){?>
                                        <img style="object-fit:contain;height: 50px;width: 50%;border-radius: 10px;"
                                            alt="dating thumb"
                                            src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                                        <?php } ?>
                                        <?php if($notify_member->gender==2){?>
                                        <img style="object-fit:contain;height: 50px;width: 50%;" alt="dating thumb"
                                            src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                                        <?php } ?>
                                    </a>
                                    <p style="font-size:11px" class="p-2"><i class="c-base-1 fa fa-clock-o"></i>
                                        <?=date('d M,y - h:i A', $row['time'])?></p>
                                    <a class="bg-info" style="border-radius: 5px;font-size: 12px;color: white;"
                                        href="<?=base_url()?>short_view/<?= $row['by']; ?>">
                                        <?= get_type_name_by_id('member', $row['by'], 'first_name'); ?>
                                    </a>
                                    <div class="text-center text-success">
                                        <small class="sml_txt">
                                            <i
                                                class="fa fa-check-circle"></i><?php echo translate('accepted_your_interest')?>
                                        </small>
                                    </div>
                                    <hr style="color:black;">
                                    <?php  }

                              elseif ($row['type'] == 'rejected_interest') { 
                                    $noti_profile_image = get_type_name_by_id('member', $row['by'], 'profile_image');
                                    $noti_images = json_decode($noti_profile_image, true);
                                    $notify_member = $this->db->get_where('member', array('member_id' => $row['by']))->row()
                                    ?>

                                    <a title="<?php echo translate('view_profile')?>"
                                        href="<?php echo base_url('short_view/'.$row['by']);?>">


                                        <?php if($notify_member->gender==1){?>
                                        <img style="object-fit:contain;height: 50px;width: 50%;border-radius: 10px;"
                                            alt="dating thumb"
                                            src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                                        <?php } ?>
                                        <?php if($notify_member->gender==2){?>
                                        <img style="object-fit:contain;height: 50px;width: 50%;" alt="dating thumb"
                                            src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                                        <?php } ?>
                                    </a>
                                    <p style="font-size:11px" class="p-2"><i class="c-base-1 fa fa-clock-o"></i>
                                        <?=date('d M,y - h:i A', $row['time'])?></p>
                                    <a class="bg-info" style="border-radius: 5px;font-size: 12px;color: white;"
                                        href="<?=base_url()?>short_view/<?= $row['by']; ?>">
                                        <?= get_type_name_by_id('member', $row['by'], 'first_name'); ?>
                                    </a>
                                    <div class="text-center text-danger mt-3">
                                        <small class="sml_txt">
                                            <i
                                                class="fa fa-times-circle"></i><?php echo translate('rejected_your_interest')?>
                                        </small>
                                    </div>

                                    <hr style="color:black;">

                                    <?php }
                            }
                        }else{

                            echo'<div class="text-center">
                                    <small class="sml_txt text-dark">
                                        '.translate('no_messages_to_show').'
                                    </small>
                                </div>';
                        }
                    }?>

                                    <?php
                    if (count($notification) <= 0) {
                    ?>
                                    <div class="text-center">
                                        <small class="sml_txt text-dark">
                                            <?php echo translate('no_notification_to_show')?>
                                        </small>
                                    </div>
                                    <?php
                    }?>

                                </div>
                            </div>

                        </li>
                        <li>
                            <div class="dropdown">

                                <button class="dropbtn2 text-success"><i class="fas fa-comments"><sup
                                            class="text-danger"><?php echo count($count_messaging_members); ?></sup></i></button>
                                <div class="dropdown-content2">

                                    <?php  
                                    foreach ($listed_messaging_members as $messaging_member) {
                                    $is_member = $this->db->get_where("member", array("member_id" => $messaging_member['member_id']))->row();
                                    if(!empty($is_member) && $is_member->is_closed == 'no'){
                                    if ($this->db->get_where('member', array('member_id' => $messaging_member['member_id']))->row()->member_id) {
                                    $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
                                    if(!is_message_thread_seen($messaging_member['message_thread_id'],$member_id)){
                                            $msg_counter++;
                                    }
                                    $messaging_member_info = $this->db->get_where('member', array('member_id' => $messaging_member['member_id']))->row();
                                    $profile_images = get_type_name_by_id('member', $messaging_member_info->member_id, 'profile_image');
                                    $image = json_decode($profile_images, true);
                                    if(isset($messaging_member['to_id']) == $this->session->userdata('thirumanam_logged_data')['member_id']){
                                    if($messaging_member['message_to_seen']==""){

                                    
                                    ?>
                                    <div class="bg-info p-1" style="border-radius: 5px;">
                                        <?php echo translate('recieved_message');?></div>
                                    <a title="<?php echo translate('message');?>"
                                        href="<?php echo base_url('profile');?>" class="text-danger"><i
                                            class="fas fa-envelope"></i></a>
                                    <?php }else{ ?>
                                    <div class="bg-info p-1" style="border-radius: 5px;">
                                        <?php echo translate('recieved_message');?></div>
                                    <a title="Message opened" class="text-success"><i
                                            class="fas fa-envelope-open"></i></a>
                                    <?php } }?>

                                    <?php if(isset($messaging_member['from_id'])){?>
                                    <div class="bg-success p-1 mb-2" style="border-radius: 5px;">
                                        <?php echo translate('sending_message');?></div>
                                    <?php } ?>
                                    <a title="<?php echo translate('view_profile')?>"
                                        href="<?php echo base_url('short_view/'.$messaging_member_info->member_id);?>">


                                        <?php if($messaging_member_info->gender==1){?>
                                        <img style="object-fit:contain;height: 50px;width: 50%;border-radius: 10px;"
                                            alt="dating thumb"
                                            src="<?php echo (!empty($image && $image[0]['profile_image']) && file_exists('uploads/profile_image/'.$image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                                        <?php } ?>
                                        <?php if($messaging_member_info->gender==2){?>
                                        <img style="object-fit:contain;height: 50px;width: 50%;" alt="dating thumb"
                                            src="<?php echo (!empty($image && $image[0]['profile_image']) && file_exists('uploads/profile_image/'.$image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                                        <?php } ?>





                                    </a><a title="<?php echo translate('message')?>"
                                        href="<?php echo base_url('profile')?>">
                                        <p style="font-size: 11px;padding: 0px;style=" color: black>
                                            <?= $messaging_member_info->first_name ?><br><i
                                                class="c-base-1 fa fa-clock-o"></i>
                                            <?=date('d M,y - h:i A', $messaging_member['message_thread_time'])?></p>
                                    </a>
                                    <hr style="color:black;">
                                    <?php
                                 }
                            }else{

                                echo'<div class="text-center">
                                    <small class="sml_txt text-dark">
                                        '.translate('no_messages_to_show').'
                                    </small>
                                </div>';


                            }
                        }?>
                                    <?php 
                        if (count($listed_messaging_members) <= 0) {
                            ?>
                                    <div class="text-center">
                                        <small class="sml_txt text-dark">
                                            <?php echo translate('no_messages_to_show')?>
                                        </small>
                                    </div>
                                    <?php
                            }
                        ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a title="<?php echo translate('profile');?>" href="<?php echo base_url('profile');?>">

                                <?php if($member->gender==1){?>
                                <img style="height: 32px;border-radius: 10px;" alt="dating thumb"
                                    src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>"
                                    onError="this.onerror=null;this.src='<?php echo base_url('uploads/profile_image/default.jpg') ?>';">
                                <?php } ?>
                                <?php if($member->gender==2){?>
                                <img style="height: 32px;border-radius: 10px;" alt="dating thumb"
                                    src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>"
                                    onError="this.onerror=null;this.src='<?php echo base_url('uploads/profile_image/default_female.jpg') ?>';">
                                <?php } ?>

                                <span><?php echo $member->first_name;?></span></a>
                        </li>

                        <li>
                            <a title="<?php echo translate('logout');?>"
                                href="<?php echo base_url('LoginController/do_logout');?>"><span><?php echo translate('logout')?></span></a>
                        </li>
                        <?php }else{ ?>
                        <li>
                            <a title="<?php echo translate('login');?>" href="<?php echo base_url('login');?>"><i
                                    class="fa-solid fa-user"></i><span><?php echo translate('login')?></span></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('register');?>"><i class="fa-solid fa-users"></i>
                                <span><?php echo translate('register')?></span> </a>
                        </li>
                        <?php } ?>

                        <!-- <li><a href="#"><i class="fa-solid fa-rss"></i></a></li> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div>
        <?php $language=getLanguage(); ?>
        <?php $msg = $this->db->get_where("important_note",array("id"=>1))->row_array(); if(!empty($msg) && isset($msg['msg']) && ($msg['tamil_msg']!='' || $msg['msg']!='')){ ?>
        <p
            style="margin-top: 0px;margin-bottom: 0px;padding-top: 0px;padding-left: 40px;    font-size: 14px;line-height: 2;font-weight: bold;">
            <marquee>
                <?php  echo (isset($language) && $language=='tamil') ? $msg['tamil_msg'] : $msg['msg']; ?>
            </marquee>
        </p>
        <?php }else{echo "<span class='mt-1'></span>";} ?>
    </div>
    <div class="header__bottom" style="padding-block: 0px!important">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <?php
                    $header_logo_info = $this->db->get_where('frontend_settings', array('type' => 'header_logo'))->row()->value;
                    $header_logo = json_decode($header_logo_info, true);
                    if (file_exists('uploads/header_logo/'.$header_logo[0]['image'])) {
                    ?>
                <a class="navbar-brand" href="<?php echo base_url();?>"><img
                        src="<?php echo base_url()?>uploads/header_logo/<?=$header_logo[0]['image'];?>" alt="logo"></a>
                <?php } else{?>
                <a class="navbar-brand" href="<?php echo base_url();?>"><img
                        src="<?php echo base_url();?>uploads/header_logo/default_image.png" alt="logo"></a>
                <?php } ?>
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler--icon"></span>
                </button>

                <!--  <center>
                        <div class="switch">
                            <input id="language-toggle" class="check-toggle check-toggle-round-flat" type="checkbox">
                            <label for="language-toggle"></label>
                            <span onclick="javascript:window.location.href-'<?=base_url()?>/home/set_language/english'" <?php if ($set_lang == "english") { echo "checked"; } ?> value="English" class="on">BN</span>
                            <span onclick="javascript:window.location.href-'<?=base_url()?>/home/set_language/tamil'" id="choice2" name="choice" <?php if ($set_lang == "tamil") { echo "checked"; } ?> value="தமிழ்" class="off">EN</span>
                        </div>
                     </center> -->

                <?php $active='style="color:#f51167"'?>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                    <div class="navbar-nav mainmenu">
                        <ul>
                            <li>
                                <a <?php echo ($uri1=='home' || $uri1=='')? $active : '';?>
                                    href="<?php echo base_url();?>"><?php echo translate('home');?></a>
                            </li>

                            <?php
                                if($this->session->userdata('thirumanam_logged_data')){
                                 $id = $this->session->userdata('thirumanam_logged_data')['member_id'];
                                    
                                $payed_customer = getMemberCurrentPayment($id);
                                // print_r($payed_customer);
                                if(!empty($payed_customer)){
                                ?>
                            <!-- <li>
                                    <a <?php echo ($uri1=='matched_members')? $active : '';?> href="<?php echo ($this->session->userdata('thirumanam_logged_data') ? base_url('matched_members') : base_url('login') ) ?>"><?php echo translate('matched_members');?></a>
                                </li> -->
                            <li>
                                <!-- <a <?php echo ($uri1=='active_members')? $active : '';?> href="<?php echo ($this->session->userdata('thirumanam_logged_data') ? base_url('active_members') : base_url('login') ) ?>"><?php echo translate('active_members');?></a> -->
                            </li>
                            <?php } }?>
                            <li>
                                <a <?php echo ($uri1=='matched_members')? $active : '';?>
                                    href="<?php echo ($this->session->userdata('thirumanam_logged_data') ? base_url('matched_members') : base_url('login') ) ?>"><?php echo translate('matched_members');?></a>
                            </li>
                            <li>
                                <a <?php echo ($uri1=='active_members')? $active : '';?>
                                    href="<?php echo ($this->session->userdata('thirumanam_logged_data') ? base_url('active_members') : base_url('login') ) ?>"><?php echo translate('active_members');?></a>
                            </li>
                            <li>
                                <a <?php echo ($uri1=='Subscription')? $active : '';?>
                                    href="<?php echo  base_url('Subscription');?>"><?php echo translate('membership_subscription');?></a>
                            </li>
                            <li>
                                <a <?php echo ($uri1=='memories')? $active : '';?>
                                    href="<?php echo base_url('memories');?>"><?php echo translate('memories ')?></a>
                            </li>
                            <li><a <?php echo ($uri1=='contact')? $active : '';?>
                                    href="<?php echo base_url('contact');?>"><?php echo translate('contact_us ')?></a>
                            </li>
                        </ul>
                    </div>
                    <!-- <ul class="button-group">
                            <li><a href="login.html" class="default-btn login"><i class="fa-solid fa-user"></i> <span>LOG IN</span> </a></li>
                            <li><a href="register.html" class="default-btn signup"><i class="fa-solid fa-users"></i> <span>SIGN UP</span> </a></li>
                        </ul> -->
                </div>
            </nav>
        </div>
    </div>
</header>
<!-- ================> header section end here <================== -->
<style>
@media (max-width: 420px) {

    .pageheader {
        padding-block: 20px;
    }
}

@media (max-width: 820px) {

    #success-alert {
        width: 100% !important;
    }

    #success-alert2 {
        width: 100% !important;
    }

    #success-alert3 {
        width: 100% !important;
    }

    #success-alert4 {
        width: 100% !important;
    }

    #success-alert5 {
        width: 100% !important;
    }

    #success-alert6 {
        width: 100% !important;
    }

    #success-alert7 {
        width: 100% !important;
    }

    #success-alert8 {
        width: 100% !important;
    }

    #success-alert9 {
        width: 100% !important;
    }

    #success-alert10 {
        width: 100% !important;
    }

    #success-alert11 {
        width: 100% !important;
    }

    #success-alert12 {
        width: 100% !important;
    }

    #success-alert13 {
        width: 100% !important;
    }

    #success-alert14 {
        width: 100% !important;
    }

    #success-alert15 {
        width: 100% !important;
    }

    #success-alert16 {
        width: 100% !important;
    }
}
</style>
<?php echo $this->session->flashdata('login_msg');?>
<?php echo $this->session->flashdata('msg');?>
<div id="success-alert" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_shortlisted_this_member!')?></strong>
    </center>

</div>
<div id="success-alert2" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_expressed_an_interest_on_this_member!')?></strong>
    </center>

</div>
<div id="success-alert3" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_removed_this_member_from_shortlist!')?></strong>
    </center>

</div>
<div id="success-alert4" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_followed_this_member!')?></strong>
    </center>

</div>
<div id="success-alert5" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_unfollowed_this_member!')?></strong>
    </center>

</div>
<div id="success-alert6" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_ignored_this_member!')?></strong>
    </center>

</div>
<div id="success-alert7" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_reported_this_member!')?></strong>
    </center>

</div>
<div id="success-alert8" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_unfollowed_this_member!')?></strong>
    </center>

</div>
<div id="success-alert9" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_unblocked_this_member!')?></strong>
    </center>

</div>
<div id="success-alert10" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Updated SuccessFully</strong>
    </center>

</div>
<div id="success-alert11" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Password Already Exist!!</strong>
    </center>

</div>
<div id="success-alert12" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Current password Did Not Match!!</strong>
    </center>

</div>
<div id="success-alert13" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>New Password Confirm Password Did Not Match!!</strong>
    </center>

</div>
<div id="success-alert14" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 60%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase
            letter!!</strong>
    </center>

</div>
<div id="success-alert15" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>reqired field!!</strong>
    </center>

</div>
<div id="success-alert16" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 2px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong><?php echo translate('you_have_enable_messaging_with_this_member!')?></strong>
    </center>

</div>
<div id="edit_output"></div>
<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<script>
$('label').click(function() {
    $(this).children('span').addClass('input-checked');
    $(this).parent('.toggle').siblings('.toggle').children('label').children('span').removeClass(
        'input-checked');
});
</script>
<script type="text/javascript">
document.getElementById("choice2").onclick = function() {
    location.href = "<?=base_url()?>WelcomeController/setLanguage/tamil";
};
document.getElementById("choice1").onclick = function() {
    location.href = "<?=base_url()?>WelcomeController/setLanguage/english";
};
</script>