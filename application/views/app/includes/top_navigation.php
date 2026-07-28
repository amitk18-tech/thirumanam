
<style>
h1
{
  font-size: 16px!important;
}
h3
{
  font-size: 15px!important;
}
h5
{
  font-size: 12px!important;
}
h6
{
  font-size: 10px!important;
}
p,::placeholder {
  font-size: 12px!important;
}
a{
   font-size: 12px!important;
}
.newsten-title
{
   font-size: 14px!important;
}
span,label{
   font-size: 12px;
}

   .btn-primary {
      background-color: #f8587e;
   }
   .page-nav li a {
       background-color: white;
       border:1px solid #f8587e;
   }
   .header-area {

      background-color: white;
      box-shadow: none;
   }
   .navbar--toggler span {

      border:2px solid black;
   }
   .post-thumbnail img {
    border-radius: 3rem;
    height: 3em;
   }
   .editorial-choice-news-wrapper {
/*      background-color: white;*/
      background: white;
      color: black;
/*      border: 1px solid #fe5783;*/
      border-radius: 1rem;

   }
   .top-catagories-wrapper {

      background: none;
   }
   .single-hero-slide .post-catagory 
   {
      background-color: #f8587e;
   }
   .newsten-footer-nav ul li.active a {
      color: #f8587e;
   }
   .newsten-footer-nav ul li a::after {
      background-color: #f8587e;
   }
   .newsten-footer-nav ul li a:hover {
      color: #f8587e;
   }
   .tabs-news-wrapper .nav-tabs .nav-item.nav-link.active {
      background-color: #f8587e;
   }
   .bg-gray {
      background-color: none!important;
   }
  body,.header-area,.footer-nav-area
{
   background-image: url(<?php echo base_url('uploads/'); ?>backgound.jpg);
   color: #000000f0;
   
}

.btn-success {
   background-color: #f8587e;
   border-color: #f8587e;
}
select option
{
/*   background-color: #f8587e;*/
   color: #797494;
}
.form-control
{
   background-color: #ffffff;
    border: 0;
    border-radius: 7px;
    padding-left: 1rem;
    box-shadow: 1px 1px 1px 1px rgba(16, 13, 209, 0.175);
    font-size: 14px;
}
.editorial-choice-news-wrapper {
   padding-top: 20px;
   padding-bottom: 10px;

}

.catagory-card a::after {

   opacity: -0.6;

}
.pagination .page-item.active .page-link {
    background-color: #f8587e;
    border-color: #f8587e;
    color: #ffffff;
}
span
{
   color: #797494;
}
select {
  -webkit-appearance: none !important;
-moz-appearance: none !important;
background-color: #fafafa;
height: 45px;
width: 100%;
background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAUCAMAAACtdX32AAAAdVBMVEUAAAD///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAhMdQaAAAAJ3RSTlMAAAECAwQGBwsOFBwkJTg5RUZ4eYCHkJefpaytrsXGy8zW3+Do8vNn0bsyAAAAYElEQVR42tXROwJDQAAA0Ymw1p9kiT+L5P5HVEi3qJn2lcPjtIuzUIJ/rhIGy762N3XaThqMN1ZPALsZPEzG1x8LrFL77DHBnEMxBewz0fJ6LyFHTPL7xhwzWYrJ9z22AqmQBV757MHfAAAAAElFTkSuQmCC);
background-position: 100%;
background-repeat: no-repeat;
border: 1px solid #ccc;
padding: 0.5rem;
border-radius: 0;
}

.go-home-btn
{
   background-color:#f8587e!important;
}
</style>

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
<?php
$title='';
if ($this->uri->segment(2)=='edit_profile') {
   $title=translate('edit_profile');
}
if ($this->uri->segment(2)=='my_interests') {
   $title=translate('my_interests');
}
if ($this->uri->segment(2)=='shortlist') {   
   $title=translate('shortlist');
   
}
if ($this->uri->segment(2)=='followed_users') {
      $title=translate('followed_users');
   }
if ($this->uri->segment(2)=='ignored_list') {
   $title=translate('ignored_list');
}
if ($this->uri->segment(2)=='profile') {
   $title=translate('profile');
}
if ($this->uri->segment(2)=='profile_viewed_details') {
   $title=translate('profile_viwed_details');
}
if ($this->uri->segment(2)=='messaging') {
   $title=translate('messaging');
}
if ($this->uri->segment(2)=='get_messages') {
   $title=translate('messaging');
}
if ($this->uri->segment(2)=='gallery') {
   $title=translate('gallery');
}
if ($this->uri->segment(2)=='happy_story') {
   $title=translate('happy_story');
}
if ($this->uri->segment(2)=='change_password') {
   $title=translate('change_password');
}
if ($this->uri->segment(2)=='notification') {
   $title=translate('notification');
}
if ($this->uri->segment(2)=='message') {
   $title=translate('message');
}
if($this->uri->segment(2)=='match_seach_list')
{
  $title=translate('matched_members');
}
if ($this->uri->segment(2)=='active_member_search' && $this->uri->segment(3)=="") {
   $title=translate('active_member_search');
}else
{
   if($this->uri->segment(3)=='appearance_search')
   {
      $title=translate('appearance_search');
   }
   if($this->uri->segment(3)=='edupro_search')
   {
      $title=translate('education_profession_search ');
   }
   if($this->uri->segment(3)=='family_search')
   {
      $title=translate('family_search');
   }
   if($this->uri->segment(3)=='astrologic_search')
   {
      $title=translate('astrologic_search');
   }
   if($this->uri->segment(3)=='active_search_all')
   {
      $title=translate('active_search_all');
   }
}
if ($this->uri->segment(2)=='match_member_search' && $this->uri->segment(3)=="") {
   $title=translate('matched_members');
}
if ($this->uri->segment(2)=='active_member_list') {
   $title=translate('active_members');
}
if ($this->uri->segment(2)=='active_seach_list') {
   $title=translate('active_members');
}
if ($this->uri->segment(3)=='match_search_all') {
   $title=translate('match_search_all');
}
if ($this->uri->segment(2)=='short_view') {
   $title=translate('short_view');
}
if ($this->uri->segment(2)=='full_view') {
   $title=translate('full_view');
}
if ($this->uri->segment(2)=='Subscription') {
   $title=translate('plan');
}
if ($this->uri->segment(2)=='contact') {
   $title= translate('contact') ;
}
if ($this->uri->segment(2)=='memories') {
   $title= translate('memories') ;
}
if ($this->uri->segment(2)=='matched_member_search') {
   $title= translate('matched_member_search') ;
}
if ($this->uri->segment(2)=='matched_member_list') {
   $title= translate('matched_members') ;
}
if ($this->uri->segment(2)=='matched_members') {
   $title= translate('matched_members') ;
}
if ($this->uri->segment(2)=='matched_member_lists') {
   $title= translate('matched_members') ;
}
if ($this->uri->segment(2)=='opposite_interests') {
   $title= 'Opposite Interests';
}
if ($this->uri->segment(2)=='profile_viewer_details') {
   $title= translate('Viewers');
}
$member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
$getUser = getData('member','row',array('member_id'=>$member_id));
$profile_images = get_type_name_by_id('member', $getUser->member_id, 'profile_image');
$profile_image = json_decode($profile_images, true);


// print_r($title);exit;
?>


<style>

p, h1 ,h2, h3, h4, h5, h6,input,textarea,label,span {
  -webkit-user-select: none; /* Safari */
  -ms-user-select: none; /* IE 10 and IE 11 */
  user-select: none; /* Standard syntax */
}
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
  background-color: #ff3763;
  box-shadow: none;
  color: white;
}

.switch-field label:first-of-type {
  border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
  border-radius: 0 4px 4px 0;
}





</style>
<!-- Preloader-->
<div class="preloader" id="preloader">
   <div class="spinner-grow text-secondary" role="status">
      <div class="sr-only">Loading...</div>
   </div>
</div>
<!-- Header Area-->

   <?php if ($title=='') { ?>
      <div class="header-area" id="headerArea" style="height:51px!important">
   <div class="container h-100 align-items-center justify-content-between">
      <div class="row">
         <div class="col-1 mt-3">
             <div class="navbar--toggler" id="newstenNavbarToggler"><i class="fas fa-bars" style="font-size:20px;"></i></div>
         </div>
         <div class="col-8 mt-3">
            <h6 class="pl-3 newsten-title" style="font-size: 13px;">Hi, <?php echo getLoggedUser()->first_name; ?></h6>
         </div>
         <div class="col-3"style="margin-top: 1px;">
            
            
            <div class="post-thumbnail">
               
               <?php if($getUser->gender==1){?>
               <img src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>" alt="" id="pimage_preview">
               <?php } ?>
               <?php if($getUser->gender==2){?>

               <img src="<?php echo (!empty($profile_image && $profile_image[0]['profile_image'])) ? base_url('uploads/profile_image/'.$profile_image[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>" alt="" id="pimage_preview">
               <?php } ?>
            </div>
            
         </div>
      </div>
      <!-- Navbar Toggler-->
     </div>
  </div>
      
      

    

   <?php }else { ?>
      <div class="header-area" id="headerArea" style="height: 50px;">
   <div class="container h-100 align-items-center justify-content-between">
      <!-- Back Button-->
      <div class="row mt-2">
         <div class="col-1">
            <div class="back-button"><a href="<?php echo "javascript:history.back()"; ?>"><i class="lni lni-chevron-left text-dark"></i></a>
            </div>
         </div>
         <div class="col-11 mt-1">
            <div class="page-heading">
               <h5 class="mb-0 text-dark"><?php echo $title; ?></h5>
            </div> 
         </div>
      </div>
      
     </div>
  </div>
         
   <?php } ?>
      <!-- Search Form-->
      <?php        
        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        ?>
      <div class="search-form">
         <!-- <a href="<?php #echo $url; ?>"><i class="fa fa-refresh"></i></a> -->
      </div>
<style type="text/css">
   .profile-img img {
      border-radius: 100%;
      width: 120px;
      border: 5px solid white;
   }
</style>
<!-- Sidenav Black Overlay-->
<div class="sidenav-black-overlay"></div>
<!-- Side Nav Wrapper-->
<div class="sidenav-wrapper" id="sidenavWrapper">
   <!-- Time - Weather-->
   <div class="time-date-weather-wrapper text-center py-5" style="background-image: url(<?php echo base_url('assets/app/'); ?>img/bg-img/1.jp)">
      <div class="weather-update mb-4">
        <div class="profile-img">
            <a href="<?php echo base_url('app/my_profile/images'); ?>">
                <!-- <img src="" alt=""> -->
            </a>
        </div>         
         <!-- <l class="icon lni lni-cloudy-sun"></l>
         <h4 class="mb-1">92°F</h4>
         <h6 class="mb-0">Dhaka</h6>
         <p class="mb-0">Mostly sunny</p> -->
      </div>
      <!-- <div class="time-date">
         <div id="dashboardDate"></div>
         <div class="running-time d-flex justify-content-center">
            <div id="hours"></div><span>:</span>
            <div id="min"></div><span>:</span>
            <div id="sec"></div>
         </div>
      </div> -->
   </div>
   <!-- Sidenav Nav-->
   <ul class="sidenav-nav">
      <!-- <li><a href="<?php #echo base_url('app') ?>"><i class="lni lni-play"></i>Live<span class="red-circle ml-2 flashing-effect"></span></a></li> -->
      <li><a href="<?php echo base_url('app/profile') ?>"><i class="lni lni-user"></i><?php echo translate('profile');?></a></li>
      <?php
        if($this->session->userdata('thirumanam_applogged_data')){
         $id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            
        $payed_customer = getMemberCurrentPayment($id);
        // print_r($payed_customer);
        if(!empty($payed_customer)){
      ?>
      <li><a href="<?php echo base_url('app/match_member_search') ?>"><i class="lni lni-users"></i><?php echo translate('matched_members');?></a></li>
      <li><a href="<?php echo base_url('app/active_member_search') ?>"><i class="lni lni-users"></i><?php echo translate('active_members');?></a></li>
      <?php } } ?>
      <li><a href="<?php echo base_url('app/Subscription') ?>"><i class="lni lni-rupee"></i><?php echo translate('membership_subscription');?></a></li>
      <!-- <li><a href="<?php echo base_url('app/memories') ?>"><i class="fab fa-envira"></i><?php echo translate('memories');?></a></li> -->
      <li><a href="<?php echo base_url('app/contact') ?>"><i class="far fa-address-book"></i><?php echo translate('contact');?></a></li>
      <li><a href="#logoutModal" data-toggle="modal" class="close-menu"><i class="lni lni-power-switch"></i><?php echo translate('logout');?></a></li> 
      <form class="form" style="margin-top: 8px;">
              <div class="switch-field">
                <input type="radio" id="choice1" name="choice" value="English" <?php if ($set_lang == "english") { echo "checked"; } ?>>
                <label for="choice1">English</label>
                <input type="radio" id="choice2" name="choice" value="தமிழ்" <?php if ($set_lang == "tamil") { echo "checked"; } ?>>
                <label for="choice2">தமிழ்</label>
              </div>
            </form>     
   </ul>
   <!-- Go Back Button-->
   <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
</div>
<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<!-- <div class="heart-explode"></div> -->

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle"><?php echo translate('are_you_sure_to_logout?');?></h5>
            <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         </div>         
         <div class="modal-footer text-center d-block">
            <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal"><?php echo translate('close');?></button>
            <a class="btn btn-danger btn-sm" href="<?php echo base_url('LoginController/app_do_logout'); ?>"><?php echo translate('confirm');?></a>            
         </div>
      </div>
   </div>
</div>
<?php echo $this->session->flashdata('login_msg');?>
<?php echo $this->session->flashdata('msg');?>
<div id="success-alert" 
      style="position: fixed;
      display: block;
      top: 82px;
      z-index: 9999999;
      width: 100%;"
      role="alert">
</div>
<script>
    document.getElementById("choice2").onclick = function () {
        location.href = "<?=base_url()?>/AppController/setLanguage/tamil";
    };
    document.getElementById("choice1").onclick = function () {
        location.href = "<?=base_url()?>AppController/setLanguage/english";
    };   
</script>


