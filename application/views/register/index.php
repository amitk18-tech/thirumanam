<style>
        .floatable-contact
        {
            display:none;
        }
        .floatable-contact{
        left:81% !important;
    }
    @media (max-width : 770px) {
        .registration_form_area {
            /*position: absolute;*/
            top: 0px;
        }
        .registration_form_area .registration_form_s
        {
            margin: 20px auto 0px;
        }
        .registration_form_area .registration_form_s .form-group input
        {
            height:45px;
        }
        .navbar-toggle {
            margin-top: 40px;
            margin-bottom: 10px;
        }
        .form-control
        {
            height:45px;
        }
        .registration_form_area .registration_form_s .form-group{
            margin-bottom:10px;
        }
        .floatable-contact{
            left:55% !important;
        }
    }
    .registration_form_area {
        position: inherit;
        top:0px;
    }
    
    
    

</style>
<div style="display:block;width:130px;" class="floatable-contact ">
    <div class="mob">
        <label><i class="fa fa-phone" style="color: #e74c3c;"></i>
        <label><a style="color:#fff;" href="tel:7397734121">7397734121</a></label>
        </label>
    </div>
</div>
<section class="slider_area scroll_icon">         
   <!--<div class="slider_inner">-->
   <!--   <div class="rev_slider"  data-version="5.3.0.2" id="home-slider">-->
   <!--      <ul> -->
   <!--          <input type="hidden" id="base_url" value="<?php# echo base_url(); ?>">-->
   <!--         <li data-slotamount="7" data-easein="Power4.easeInOut" data-easeout="Power4.easeInOut" data-masterspeed="600" data-rotate="0" data-saveperformance="off">-->
               <!-- MAIN IMAGE -->
   <!--            <img src="<?php #echo base_url(); ?>assets/img/slider-img/slider-2.jpg"  alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>-->

               <!-- LAYERS -->                  
   <!--            <a href="#" class="scroll-down" address="true"></a>                  -->
   <!--         </li>                        -->
   <!--      </ul> -->
   <!--   </div><!-- END REVOLUTION SLIDER -->
   <!--</div>-->

   <div class="registration_form_area" style="background-image:url(<?php echo base_url(); ?>assets/img/slider-img/slider-2.jpg);background-size: cover;padding-bottom: 50px;">
      <div class="container">
      <marquee overflow="hidden"><img src="<?php echo base_url(); ?>assets/img/scroll_text.png"></marquee>
         <div class="row">
            <div class="col-sm-6">
               <div class="registration_form_s" style="background-color:rgba(255,255,255,0.9)">
                  <h4>Registration</h4> 
                     <form method="post" action="<?php echo base_url('WelcomeController/registerUser'); ?>" name="index_reg" id="" class="reg_formss">
                        <p class='val_error val_status'></p>
                            <div class="row">
                              <div class="col-sm-6">
                                  <span data-bind="label" class="text-font">Profile for <i style="color:red;">*</i></span>
                              </div>

                              <div class="col-md-6">  
                                 <div class="form-group">
                                    <select class="form-control customize_plan form_inputs" name="profile_for" id="profile_for" data-message="Registered By"  required placeholder="RegisterBy-Name">
                                      <?php if(count($profile_created_by_datas)==0)
                                      {?>
                                      <option value="">No Data Found</option>
                                      <?php
                                      }
                                      else
                                      {   echo'<option value="">Please Select Profile</option>';
                                      foreach ($profile_created_by_datas as $value) 
                                      { ?>
                                      <option value="<?php echo $value->meta_value_id;?>"><?php echo $value->meta_value; ?></option>
                                      <?php } } ?>                                              
                                    </select>
                                 </div>
                              </div>    
                           </div>
                          <div class="row">
                            <div class="col-sm-6 box">
                                <span data-bind="label" class="text-font">Name <i style="color:red;">*</i></span>
                             </div>
                            <div class="col-md-6">  
                                <div class="form-group">
                                    <input type="text" class="form-control form_inputs" id="name" value="" data-message="User Name" placeholder="Your Name" required name="name" value="">
                                </div>
                            </div>    
                          </div>
                                             
                           <div class="row">
                              <div class="col-sm-6 box">
                                 <span data-bind="label" class="text-font">Mobile <i style="color:red;">*</i></span>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <input type="text" class="form-control form_inputs mob_num mobile_value" id="mobile" required pattern="[6789][0-9]{9}" data-message="Mobile" name="mobile" placeholder="Mobile Number" value="">
                                     
                                 </div>
                              </div>
                           </div>
                          

                          <div class="row">
                              <div class="col-sm-6 box">
                                 <span data-bind="label" class="text-font">Email </span>
                              </div>

                              <div class="col-md-6">
                                 <div class="form-group">
                                    <input type="text" class="form-control form_inputs email_value" id="email" name="email" data-message="Email"  placeholder="Email Id" value="">
                                  </div>
                              </div>   
                           </div>   

                                              

                          <input type="hidden" name="" value="">
                          <div class="reg_chose form-group">                             
                              <button type="submit" value="LogIn" class="btn form-control form_inputs login_btn" href="#reg_form">Register</button>
                          </div>                            
                      </form>
                  </div>                 
              </div>            
          </div>
      </div>
  </div>  
</section>

<!--================End Slider Reg Area =================-->

<!--================Advanced Search Area =================-->
<section class="advanced_search_area search_area2 ok">
  <div class="container">
      <div class="welcome_title">
          <h3>Quick Search</h3>
          <img src="<?php echo base_url(); ?>assets/img/w-title-b.png" alt="">          
      </div>
      <form method="post" class="box basic_search" action="<?php echo base_url() ?>quick_search" id="quick_search" name="quick_search" >
      <div class="row">
        <div class="col-sm-9">
          <div class="search_option">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="home">
                <div class="height_item">
                  <h4>Looking for a</h4>
                  <select class="selectpicker" name="basic_gender" id="basic_gender" >
                    <option value="2">Bride</option>
                    <option value="1">Groom</option>
                  </select>
                </div>
                <div class="height_item">
                  <h4>From (age)</h4>
                  <select class="selectpicker" name="search_age_from" id="basic_search_age_from">
                    <?php 
                    for($i=18;$i<=60;$i++){ ?>
                      <option <?php if($i==18){?> selected="selected" <?php } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php
                    } ?>
                  </select>
                </div>
                <div class="height_item">
                  <h4>To (age)</h4>
                  <select class="selectpicker" name="search_age_to" id="basic_search_age_to">
                    <?php 
                    for($i=18;$i<=60;$i++){
                    ?>
                    <option  <?php if($i==34){?> selected="selected" <?php } ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php
                    }
                    ?>
                  </select>     
                </div>
              </div> 
            </div>
          </div>
        </div>
           <input type="hidden" id="basic_height_in_cms" name="" value="137" />
           <input type="hidden" id="basic_height_in_feets" name="" value="213"/>
              <div class="col-sm-3">
                  <div class="">                                
                      <button type="button" value="" onclick="basic_search_add_url_query();" class="btn form-control login_btn">Search</button>
                  </div>
              </div>
       </div> 
       </form>
  </div>               
</section>
    
<section class="adms_slider_area">
 <div class="container">
  <div class="welcome_title">
         <h3>Success Stories</h3>
         <img src="<?php echo base_url(); ?>assets/img/w-title-b.png" alt="">
     </div>
     <div class="adms_inners">
         <div class="adms_slider_inners">
             <div class="slider_adms_active team_inner_area">                            
                   <?php //print_r($success_stories); 
                      if(!empty($success_story)) :
                      foreach ($success_story as $suc) :
                  ?>
                  <div class="item">
                      <div class="team_items">
                          <div class="product_div">
                              <img src="<?php if(!empty($suc->image)) echo base_url()."assets/images/story/".$suc->image; else echo base_url()."assets/uploads/no_image.jpg" ?>"class="product_div" alt="Image">
                              <div class="overlay">
                                  <div class="success-text"><?php echo $suc->male_name."&". $suc->female_name ?>
                                  </div>
                              </div> 
                          </div>    
                      </div>
                  </div>
                  <?php
                    endforeach;
                    endif;
                  ?>
              </div>
         </div>
     </div>
 </div>
</section>

<section class="adms_slider_area">
  <div class="container">
    <div class="welcome_title">
        <h3>Featured Profiles</h3>
         <img src="<?php echo base_url(); ?>assets/img/w-title-b.png" alt="">
    </div>


    <div class="adms_inners">
      <div class="adms_slider_inners">
        <div class="slider_adms_active team_inner_area">
          <?php 
          if (!isset($this->session->userdata['valli_logged_data'])==null) {
            $user_session =$this->session->userdata['valli_logged_data'];
          }else{
            $user_session =array();
          }
         
    
      if(!empty($user_session)){
        $user_gender = $this->session->userdata['valli_logged_data']['gender'];
        // Bride Profiles
        if ($user_gender==2) {
          if(!empty($grooms_profile_datas)) {                                
            foreach ($grooms_profile_datas as $rec) {
              ?>
              <div class="item">
                <div class="team_items">
                  <div class="product_div">
                    <a href="<?php echo base_url()."viewdetail/".$rec['user_id'];?>"><img class="product_div" src="<?php 
                      if(!empty($rec['image'])): 
                          echo base_url()."assets/images/users/th_".$rec['image']; 
                      else:
                          echo base_url()."assets/uploads/no_image.jpg"; 
                      endif; 
                    ?>" alt="Image not loaded" class ="featured_div">
                    </a>
                    <div class="overlay">
                        <div class="success-text"><?php echo $rec['profile_id']." - ". $rec['username'] ?>
                        </div>
                    </div>
                  </div>    
                </div>
              </div>
        <?php }}} 

        if ($user_gender==1) {
          if(!empty($brides_profile_datas)) {                                
            foreach ($brides_profile_datas as $rec) {
              ?>
              <div class="item">
                <div class="team_items">
                  <div class="product_div">
                    <a href="<?php echo base_url()."viewdetail/".$rec['user_id'];?>"><img class="product_div" src="<?php 
                      if(!empty($rec['image'])): 
                          echo base_url()."assets/images/users/th_".$rec['image']; 
                      else:
                          echo base_url()."assets/uploads/no_image.jpg"; 
                      endif; 
                    ?>" alt="Image not loaded" class ="featured_div">
                    </a>
                    <div class="overlay">
                        <div class="success-text"><?php echo $rec['profile_id']." - ". $rec['username'] ?>
                        </div>
                    </div>
                  </div>    
                </div>
              </div>
        <?php }}} } else {
          if(!empty($grooms_profile_datas)) {                                
            foreach ($grooms_profile_datas as $rec) {
              ?>
              <div class="item">
                <div class="team_items">
                  <div class="product_div">
                    <a href="<?php echo base_url()."viewdetail/".$rec['user_id'];?>"><img class="product_div" src="<?php 
                      if(!empty($rec['image'])): 
                          echo base_url()."assets/images/users/th_".$rec['image']; 
                      else:
                          echo base_url()."assets/uploads/no_image.jpg"; 
                      endif; 
                    ?>" alt="Image not loaded" class ="featured_div">
                    </a>
                    <div class="overlay">
                        <div class="success-text"><?php echo $rec['profile_id']." - ". $rec['username'] ?>
                        </div>
                    </div>
                  </div>    
                </div>
              </div>
        <?php }}}?>

        </div>
      </div>
    </div>    


    <!-- MODIFIED ON 12-8-2020 FOR TOW ROW DISPLAY -->
    <?php if(empty($user_session)) { ?>
    <div class="adms_inners">
      <div class="adms_slider_inners">
        <div class="slider_adms_active team_inner_area">
          <?php 
          if (!isset($this->session->userdata['valli_logged_data'])==null) {
            $user_session =$this->session->userdata['valli_logged_data'];
          }else{
            $user_session =array();
          }
         
    
      if(!empty($user_session)){
        $user_gender = $this->session->userdata['valli_logged_data']['gender'];
        // Bride Profiles
        if ($user_gender==2) {
          if(!empty($grooms_profile_datas)) {                                
            foreach ($grooms_profile_datas as $rec) {
              ?>
              <div class="item">
                <div class="team_items">
                  <div class="product_div">
                    <a href="<?php echo base_url()."viewdetail/".$rec['user_id'];?>"><img class="product_div" src="<?php 
                      if(!empty($rec['image'])): 
                          echo base_url()."assets/images/users/th_".$rec['image']; 
                      else:
                          echo base_url()."assets/uploads/no_image.jpg"; 
                      endif; 
                    ?>" alt="Image not loaded" class ="featured_div">
                    </a>
                    <div class="overlay">
                        <div class="success-text"><?php echo $rec['profile_id']." - ". $rec['username'] ?>
                        </div>
                    </div>
                  </div>    
                </div>
              </div>
        <?php }}} 

        if ($user_gender==1) {
          if(!empty($brides_profile_datas)) {                                
            foreach ($brides_profile_datas as $rec) {
              ?>
              <div class="item">
                <div class="team_items">
                  <div class="product_div">
                    <a href="<?php echo base_url()."viewdetail/".$rec['user_id'];?>"><img class="product_div" src="<?php 
                      if(!empty($rec['image'])): 
                          echo base_url()."assets/images/users/th_".$rec['image']; 
                      else:
                          echo base_url()."assets/uploads/no_image.jpg"; 
                      endif; 
                    ?>" alt="Image not loaded" class ="featured_div">
                    </a>
                    <div class="overlay">
                        <div class="success-text"><?php echo $rec['profile_id']." - ". $rec['username'] ?>
                        </div>
                    </div>
                  </div>    
                </div>
              </div>
        <?php }}} } else {
          if(!empty($brides_profile_datas)) {                                
            foreach ($brides_profile_datas as $rec) {
              ?>
              <div class="item">
                <div class="team_items">
                  <div class="product_div">
                    <a href="<?php echo base_url()."viewdetail/".$rec['user_id'];?>"><img class="product_div" src="<?php 
                      if(!empty($rec['image'])): 
                          echo base_url()."assets/images/users/th_".$rec['image']; 
                      else:
                          echo base_url()."assets/uploads/no_image.jpg"; 
                      endif; 
                    ?>" alt="Image not loaded" class ="featured_div">
                    </a>
                    <div class="overlay">
                        <div class="success-text"><?php echo $rec['profile_id']." - ". $rec['username'] ?>
                        </div>
                    </div>
                  </div>    
                </div>
              </div>
        <?php }}}?>

        </div>
      </div>
    </div>  
    <?php } ?>

  </div>
</section>