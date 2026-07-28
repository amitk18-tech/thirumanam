<!--================Frist Main hader Area =================-->
 <header class="header_menu_area" style="display: none;">
    <nav class="navbar navbar-default">
        <div class="container">
        <!-- Brand and toggle get grouped for better mobile display (selva)-->
        <div class="navbar-header">
            <button id="nav-icon1" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <a class="navbar-brand" style="height: 83px;" href=""><img src="assets/img/logo1.png" alt=""></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling (selva) -->
        <div class="collapse navbar-collapse float" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li id="home"><a href="<?php echo base_url() ?>home">Home</a></li>
                    
                <!-- <li id="reg"><a href="registration">Registration</a></li> -->
                 <li id="search"><a href="<?php echo base_url() ?>search">Search</a></li>
                 <li id="gallery"><a href="<?php echo base_url() ?>gallery">Gallery</a></li>
                 <li id="stories" class="dropdown submenu ">
                    <!-- <a href="">Success Stories</a> -->
                    <a href="<?php echo base_url() ?>success-stories.html" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Success Stories</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url() ?>success_stories">Success Stories</a></li>
                        <li><a href="<?php echo base_url() ?>post_success">Post Your Story</a></li>                                
                    </ul>
                </li>
                <li id="vanniyar"><a href="<?php echo base_url() ?>vanniyar">My Vanniyar</a></li>
                 <li id="payment"><a href="<?php echo base_url() ?>payment">Payment</a></li>
                <li id="contact"><a href="<?php echo base_url() ?>contact">Contact</a></li>

                <li id="test"><a href="<?php echo base_url() ?>contact">test</a></li>
                    
                <li class="dropdown submenu">
                    <?php if(($this->session->userdata('valli_login_status')==1) && ($this->session->userdata('valli_logged_data')['user_id']!='') ){ ?>
                        <a href="success-stories.html" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome,&nbsp&nbsp<?php echo $this->session->userdata('valli_logged_data')['user_name']; ?>&nbsp&nbsp<i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp&nbsp<i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <?php } ?>
                    <ul class="dropdown-menu float-left">
                        <li><a href="<?php echo base_url() ?>myprofile">My Profile</a></li>
                        <li><a href="<?php echo base_url() ?>myprofileview">My Profile View</a></li>
                        <li><a href="<?php echo base_url() ?>manage_photos">Manage Photos</a></li>
                        <!-- <li><a class="dropdown_interest">My Interest</a>
                            <ul class="dropdown-content_int">
                                <li><a href="<?php echo base_url() ?>sent_interest">Sent</a></li>
                                <li><a href="<?php echo base_url() ?>receive_interest">Receive</a></li>
                            </ul>
                        </li> -->

                        <li><a class="dropdown_interest">Matches</a>
                            <ul class="dropdown-content_int">
                                <li><a href="<?php echo base_url() ?>new_matches">New Matches</a></li>
                                <li><a href="<?php echo base_url() ?>viewed_myprofile">who Viewed My Profile</a></li>
                                <li><a href="<?php echo base_url() ?>shortlisted_profile">Shortlisted Profile</a></li>
                                <li><a href="<?php echo base_url() ?>viewed_profile">Viewed Profile</a></li>
                                <li><a href="<?php echo base_url() ?>blocked_profile">Blocked Profile</a></li>
                            </ul>
                        </li>

                        <li><a class="dropdown_interest">Messages</a>
                            <ul class="dropdown-content_int">
                                <li><a href="<?php echo base_url() ?>all_messages">Inbox</a></li>
                                <li><a href="<?php echo base_url() ?>sent_messages">Sent</a></li>
                                <li><a href="<?php echo base_url() ?>trash_messages">Trash</a></li>
                            </ul>
                        </li>
                        <li><a class="dropdown_interest">Search</a>
                            <ul class="dropdown-content_int">
                                <li><a href="<?php echo base_url() ?>regular_search">Regular Search</a></li>
                                <li><a href="<?php echo base_url() ?>advance_search">Advanced Search</a></li>
                            </ul>
                        </li>
                        <li ><a href="<?php echo base_url() ?>plan_upgrade">Upgrade</a></li>
                        <li ><a href="<?php echo base_url() ?>change_password">Change Password</a></li>
                        <li ><a href="<?php echo base_url() ?>user_feedback">Feed Back</a></li>
                        <li id="log"><a href="<?php echo base_url('logout') ?>" onclick="return confirm_logout();">Logout</a></li>
                    </ul>
                </li>
                
                <?php if($this->session->userdata('valli_login_status')==0){ ?>
                <ul class="nav navbar-nav navbar-right">
                    <li id="login"><a class="popup-with-zoom-anim" href="#small-dialog"><i class="mdi mdi-key-variant"></i>Login</a></li>
                    <!-- <li id="register"><a href="registration"><i class="fa fa-user-plus"></i>Registration</a></li> -->
                    <li><a href=""></a></li>
                </ul>    
                <?php  } ?>            
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid  -->
    </nav>
</header>
<!--================Frist Main hader Area =================-->

<!-- menu bar latest  -->
<header class="">
<nav class="navbar navbar-inverse"  data-offset-top="197">      
      <div class="container">
          <div class="floatable-contact">
            <label><i class="fa fa-phone" style="color: #e74c3c;"></i>
            <label>7397734121 / 7397734427</label>
            </label>
          </div>
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
      </button>
       <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo1.png'); ?>" alt=""></a>  
    </div>
    
        
    <!-- <h1 class="logo"><a class="navbar-brand" style="height: 83px;" href=""></a></h1> -->
           <div class="collapse navbar-collapse" id="myNavbar">

    <ul class="nav navbar-nav main-menu">
      <li><a href="<?php echo base_url() ?>home">Home</a></li>
      <li><a href="<?php echo base_url() ?>search">Search</a></li>
      <li><a href="<?php echo base_url() ?>gallery">Gallery</a></li>
      <li><a href="#">Success Stories</a>
        <ul class="submenu-level1">          
          <li><a href="<?php echo base_url() ?>success_stories">Success Stories</a></li>
          <li><a href="<?php echo base_url() ?>post_success">Post Your Story</a></li>                    
        </ul>
      </li>

      <li><a href="<?php echo base_url() ?>vanniyar">My Vanniyar</a></li>
      <li><a href="<?php echo base_url() ?>payment">Payment</a></li>
      <li><a href="<?php echo base_url() ?>contact">Contact</a></li>
    
    <?php if(($this->session->userdata('valli_login_status')==1) && ($this->session->userdata('valli_logged_data')['user_id']!='') ){ ?>

      <li><a href="#">Welcome, <?php echo $this->session->userdata('valli_logged_data')['user_name']; ?></a>
        <ul class="submenu-level1">          
          <li><a href="<?php echo base_url() ?>myprofile">My Profile</a></li>
          <li><a href="<?php echo base_url() ?>myprofileview">My Profile View</a></li>
          <li><a href="<?php echo base_url() ?>manage_photos">Manage Photos</a></li>
          <li><a class="dropdown_interest">Matches</a>  
            <ul class="submenu-level2">
                <li><a href="<?php echo base_url() ?>new_matches">New Matches</a></li>
                <li><a href="<?php echo base_url() ?>viewed_myprofile">who Viewed My Profile</a></li>
                <li><a href="<?php echo base_url() ?>shortlisted_profile">Shortlisted Profile</a></li>
                <li><a href="<?php echo base_url() ?>viewed_profile">Viewed Profile</a></li>
                <li><a href="<?php echo base_url() ?>blocked_profile">Blocked Profile</a></li>
            </ul>
          </li>          
          <li><a>Messages</a>  
            <ul class="submenu-level2">
                <li><a href="<?php echo base_url() ?>all_messages">Inbox</a></li>
                <li><a href="<?php echo base_url() ?>sent_messages_interests">Sent</a></li>
                <!-- <li><a href="<?php echo base_url() ?>trash_messages">Trash</a></li> -->
            </ul>
          </li>          

          <!--<li><a>Search</a>  -->
          <!--  <ul class="submenu-level2">-->
          <!--      <li><a href="<?php echo base_url() ?>regular_search">Regular Search</a></li>-->
          <!--      <li><a href="<?php echo base_url() ?>advance_search">Advanced Search</a></li>-->
          <!--  </ul>-->
          <!--</li>-->
          <li ><a href="<?php echo base_url() ?>plan_upgrade">Upgrade</a></li>
          <li ><a href="<?php echo base_url() ?>change_password">Change Password</a></li>
          <li ><a href="<?php echo base_url() ?>user_feedback">Feed Back</a></li>
          <li id="log"><a href="<?php echo base_url('logout') ?>" onclick="return confirm_logout();">Logout</a></li>
        </ul>
      </li>

      <?php 
        $notification2=get_incoming_notifications($this->session->userdata('valli_logged_data')['user_id']) ;
        $notification1=get_return_notifications($this->session->userdata('valli_logged_data')['user_id']) ;
        $notifications=array_merge($notification1,$notification2);
      ?>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell"></i>
          <span style="background-color: #99ba21;" class="badge badge-danger navbar-badge"><?php echo count($notifications); ?></span>
        </a>
        <div style="color: #212529;background-color: #232321;opacity: 0.97;font-size: 1rem;" class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <?php 
          $i=1;
          if (count($notifications)>0) { 
            foreach ($notifications as $value) {
              if ($value->type==5 || $value->type==7 || $value->type==8 || $value->type==10 || $value->type==11) {
                $user=get_user_details($value->preference_user_id);  
              }
              else{
                $user=get_user_details($value->user_id);
              }

              $images=get_user_profile_image($user->user_id);
              if ($images!='' && $images!=0) {
                if (file_exists("assets/images/users/th_".$images['image'])) {
                  $image="assets/images/users/th_".$images['image'];  
                }else{
                if ($user->gender==1) {
                  $image="assets/uploads/defalt_male.png";  
                }else{
                  $image="assets/uploads/defalt_female.png";         
                }  
              }
              }else{
                if ($user->gender==1) {
                  $image="assets/uploads/defalt_male.png";  
                }else{
                  $image="assets/uploads/defalt_female.png";         
                }  
              }

              

              $date_expire = $value->created_at;    
              $date = new DateTime($date_expire);
              $now = new DateTime();
              // echo $date->diff($now)->format("%d days, %h hours and %i minuts");
              $time='0 Minutes ago';

              if ($date->diff($now)->format('%d')!='0') {
                $time=$date->diff($now)->format("%d Days ago");
              }
              elseif ($date->diff($now)->format('%h')!='0') {
                $time=$date->diff($now)->format("%h Hours ago");
              }
              elseif ($date->diff($now)->format('%i')!='0') {
                $time=$date->diff($now)->format("%i Minutes ago");
              }

              $message=notification_message($value->type);
              $link=notification_link($value->type,$value->user_id,$value->preference_user_id);

          ?>
            <a onclick="change_notification_view_status(<?php echo $value->id; ?>);" href="<?php echo base_url();echo $link; ?>" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img style="width: 50px;" src="<?php echo base_url($image); ?>" alt="Image not loaded" class="img-size-50 mr-3 img-circle" onError="this.onerror=null;this.src='<?php echo base_url($image) ?>';"/>
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    <?php echo $user->username; ?>                    
                  </h3>
                  <p class="text-sm"><?php echo $message; ?></p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?php echo $time; ?></p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
          <?php 
              if ($i==4){
                break;
              } 
              $i++; 
            } 
          }?>          
          <a style="font-size: 12px;" href="<?php echo base_url(); ?>notifications" class="dropdown-item dropdown-footer"><center>See All Notifications</center></a>
        </div>
      </li>

      <?php }else{ ?>

        <li id="login"><a class="popup-with-zoom-anim" href="#small-dialog"><i class="mdi mdi-key-variant"></i>&nbsp;Login</a></li>

      <?php  } ?>  

    </ul>
    </div>
    </div>
  </nav>
</header>


<div style="position: absolute;z-index: 9999;width: 100%;text-align: center;top: 10%;" id="flash-msg-div">
    <?php
        echo $this->session->flashdata('login_msg');
        echo $this->session->flashdata('profile_msg');
        echo $this->session->flashdata('feedback_msg');
    ?>
</div>

<style type="text/css">
  .floatable-contact {
    background-color: #5c74f8;
    position: fixed;
    margin-top: 52px;
    height: 25px!important;
    z-index: 99999;
    left: 72%;
    top: -50px;
    border-radius: 51px;
    align-items: center;
    text-align: center;
    width: 235px;
    overflow: hidden;
    color: #fff;
    border: solid 1px #fff;
  }
</style>
<!-- color: #212529;background-color: #232321;opacity: 0.9;    -->
<style type="text/css">
  .dropdown-menu{  
            
      text-align: left;
      list-style: none;      
      background-clip: padding-box;
      border: 1px solid rgba(0,0,0,.15);
      border-radius: .25rem;
      box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
      transition: background-color .22s ease, color .22s ease;        
  }
  .dropdown, .dropleft, .dropright, .dropup {
      position: relative;
  }
  .dropdown-menu-lg {
      max-width: 300px;
      min-width: 280px;
      padding: 0;
  }
 
  .media {
    
      display: flex;    
      align-items: flex-start;
  }

  .img-size-50 {
      width: 50px;
  }
  .img-size-32, .img-size-50, .img-size-64 {
      height: auto;
  }
  .img-circle {
      border-radius: 50%;
  }
  .mr-3, .mx-3 {
      margin-right: 1rem!important;
  }
  img {
      vertical-align: middle;
      border-style: none;
  }
  .media-body {      
      flex: 1;
  }
  .dropdown-item-title {
      font-size: 15px;
      margin: 0;
  }
  .dropdown-menu-lg p {
      margin: 0;
      white-space: normal;
  }
  .text-sm {
      font-size: 12px;
  }
  .dropdown-menu-lg p {
      padding: 0;
      margin: 0;
      white-space: normal;
  }

  .text-muted {
      color: #bababa!important;
  }
  .dropdown-menu-lg .dropdown-divider {
      margin: 0;
  }
  .dropdown-divider {
      height: 0;
      margin: .5rem 0;
      overflow: hidden;
      border-top: 1px solid #e9ecef;
  }
</style>