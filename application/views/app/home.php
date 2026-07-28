<?php

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

?>

<div class="page-content-wrapper">

   <!-- News Today Wrapper-->

   <div class="news-today-wrapper">

      <div class="container">

         <?php echo $this->session->flashdata('msg'); 

       ?>

            <!-- <div class="d-flex align-items-center justify-content-between">

               <h5 class="pl-1 newsten-title">Hi, <?php echo getLoggedUser()->first_name; ?></h5>

               <p class="line-height-1" id="dashboardDate2"></p>

            </div>   -->          

            <!-- <div class="hero-slides owl-carousel">               

            

                  <div class="single-hero-slide" style="background-im<?php echo translate('age')?>: url(<?php #echo $image; ?>);background-size: cover;background-position: top;">                     

                     <div class="background-shape">

                        <div class="circle2"></div>

                        <div class="circle3"></div>

                     </div>

                     <div class="slide-content h-100 d-flex align-items-end">

                        <div class="container-fluid mb-3"> <a class="bookmark-post" href="#"><i class="lni lni-heart"></i></a> <a class="post-title d-block" href="<?php #echo base_url('app/view_details/'.$value->user_id); ?>"><?php #echo $value->username; ?></a>

                           <div class="post-meta d-flex align-items-center"> <span><i class="mr-1 lni lni-calendar"></i><?php #echo $age; ?> Yrs</span> <span><i class="mr-1 lni lni-user"></i><?php #echo $marital_status; ?></span> <span><i class="mr-1 lni lni-postcard"></i><?php #echo $value->gem_id; ?></span> </div>

                        </div>

                     </div>

                  </div>


            </div> -->

      </div>



      <div class="news-today-wrapper" style="opacity: 1px!important;">
        <div class="container">
          <div class="d-flex align-items-center justify-content-between">
            <!-- <h5 class="mb-3 pl-1 newsten-title">News Today</h5> -->
            <!-- <p class="mb-3 line-height-1" id="dashboardDate2"></p> -->
          </div>
          <!-- Hero Slides-->
          <!-- Hero Slides-->
          <div class="hero-slides owl-carousel">

            <?php if(!empty($premium_members)){ 
            $i=0;?>
            <?php foreach ($premium_members as $premium_member){
                $i++;
            $image = json_decode($premium_member->profile_image, true); 
            $following = json_decode($premium_member->followed, true);
            $name = $premium_member->first_name;
            if(strlen($premium_member->first_name)>25){

               $name = substr($premium_member->first_name, 0,25).'...';
            }
           ?>

            <?php 
               $slide_image = "";
             if (file_exists('uploads/profile_image/'.$image[0]['profile_image'])) { 

                  $slide_image =  base_url('uploads/profile_image/'.$image[0]['profile_image']);
                } else{
                  if($premium_member->gender==1)
                  {
                     $slide_image = base_url('uploads/profile_image/default.jpg');
                  }else
                  {
                     $slide_image =  base_url('uploads/profile_image/default_female.jpg');
                  }
                  
             } 

              $action = (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"');
              $place = "";
              if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
               $education = "";
              if(!empty($premium_member->education_and_career))
              {
                  $education_and_career = json_decode($premium_member->education_and_career);
                  $education = $education_and_career[0]->STUDY_DETAILS;
               }
               $age = "";
            if(!empty($premium_member->astronomic_information))
              {
                  $birth = json_decode($premium_member->astronomic_information);
                  $date1 =  date('Y',strtotime($birth[0]->date_of_birth));  
                  $date2 = date("Y");           
                  $age = $date2 - $date1;
               }
              ?>
            <!-- Single Hero Slide-->
            <div class="single-hero-slide" style="background-image: url(<?php echo $slide_image;?>);">
              <!-- Background Shape-->
              <div class="background-shape">
                <div class="circle2"></div>
                <div class="circle3"></div>
              </div>
             
              <div class="slide-content h-150 d-flex align-items-end">
                
                <div class="container-fluid transparent" style="background-color:black;opacity: 0.9;height: 80px;padding-top: 10px;">
                  <a class="bookmark-post" <?php echo $action;?> style="color: black;">View</a>
                  <a style="font-size: 14px" class="post-title d-block" <?php echo $action;?>><?php echo $premium_member->first_name; ?></a>
                  
                  <div class="post-meta d-flex align-items-center">
                  <?php if(!empty($premium_member->member_profile_id))
                  {?>
                     <a style="font-size: 13px;" href="#"><i class="mr-1 lni lni-user"></i><?php echo $premium_member->member_profile_id; ?></a>
                
                  <?php } if(!empty($age))
                  {?>
                     <a style="font-size: 13px;" href="#"><i class="fas fa-birthday-cake" style="margin-right: 5px;"></i><?php echo $age; ?> Yrs</a>

                  <?php } if(!empty($place))
                  {?>
                  <span style="font-size: 13px;"><i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i><?php echo $place;?></span>


                  <?php } ?>
                  <!-- <a class="post-catagory" >View</a> -->
                  </div>
                </div>
              </div>
            </div>
            <?php } } ?>

           
          </div>
        </div>
      </div>



   </div>

   <!-- Top Catagories Wrapper-->
<h5 class="mb-3 ml-3 catagory-title"style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('recommended_for_you');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      

      

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

             <?php if(!empty($premium_members)){ 
            $i=0;?>
            <?php foreach ($premium_members as $premium_member){
                $i++;
            $image = json_decode($premium_member->profile_image, true); 
            $following = json_decode($premium_member->followed, true);
            $name = $premium_member->first_name;
            if(strlen($premium_member->first_name)>25){

               $name = substr($premium_member->first_name, 0,25).'...';
            }

            $action = (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"');
              $place = "";
              if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
                $education = "";
              if(!empty($premium_member->education_and_career))
              {
                  $education_and_career = json_decode($premium_member->education_and_career);
                  $education = $education_and_career[0]->STUDY_DETAILS;
               }
               $age = "";
            if(!empty($premium_member->astronomic_information))
              {
                  $birth = json_decode($premium_member->astronomic_information);
                  $date1 =  date('Y',strtotime($birth[0]->date_of_birth));  
                  $date2 = date("Y");           
                  $age = $date2 - $date1;
               }
           ?>

               <div class="card catagory-card">  
                  <a <?php echo (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"')?>>

                <?php  if (file_exists('uploads/profile_image/'.$image[0]['profile_image'])) { ?>
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo base_url('uploads/profile_image/'.$image[0]['profile_image']);?>" alt="dating thumb">
                
                 
             <?php } else{?>
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo (($premium_member->gender==1) ? base_url('uploads/profile_image/default.jpg') : base_url('uploads/profile_image/default_female.jpg')) ;?>" alt="dating thumb">
                

             <?php } ?>

                

              </a>
              <div class="card-footer" style="padding-top: 5px;padding: 0px;">
                 <h6 style="font-size:13px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo ((strlen($premium_member->first_name)>33) ? substr($premium_member->first_name,0,33).'..' : $premium_member->first_name); ?></h6>
                 <h6 style="font-size:12px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo translate('age')?>: <?php echo $age; ?></h6>
                 <h6 style="font-size:12px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo ((strlen($education)>18) ? substr($education,0,18).'..' : $education); ?></h6>
                 
              </div>
               </div>
              
               <?php } } ?>

         </div>

      </div>

   </div>


 <?php if(!empty($matched_members)){ 
            $i=0;?>
   <h5 class="mb-3 ml-3 catagory-title"style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('today_matched_profiles');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      <div class="bg-shapes">

         <div class="shape1"></div>

         <div class="shape2"></div>

         <div class="shape3"></div>

         <div class="shape4"></div>

         <div class="shape5"></div>

      </div>

      <!-- <h6 class="mb-3 ml-3 catagory-title"><?php echo translate('members');?></h6> -->

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

            
            <?php foreach ($matched_members as $premium_member){
                $i++;
            $image = json_decode($premium_member->profile_image, true); 
            $following = json_decode($premium_member->followed, true);
            $name = $premium_member->first_name;
            if(strlen($premium_member->first_name)>25){

               $name = substr($premium_member->first_name, 0,25).'...';
            }

            $action = (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"');
              $place = "";
              if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
               $age = "";
            if(!empty($premium_member->astronomic_information))
              {
                  $birth = json_decode($premium_member->astronomic_information);
                  $date1 =  date('Y',strtotime($birth[0]->date_of_birth));  
                  $date2 = date("Y");           
                  $age = $date2 - $date1;
               }
                $education = "";
              if(!empty($premium_member->education_and_career))
              {
                  $education_and_career = json_decode($premium_member->education_and_career);
                  $education = $education_and_career[0]->STUDY_DETAILS;
               }
           ?>

               <div class="card catagory-card"> 
                  <a <?php echo (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"')?>>

                <?php  if (file_exists('uploads/profile_image/'.$image[0]['profile_image'])) { ?>
                 <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo base_url('uploads/profile_image/'.$image[0]['profile_image']);?>" alt="dating thumb">
                 
                 
             <?php } else{?>
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo (($premium_member->gender==1) ? base_url('uploads/profile_image/default.jpg') : base_url('uploads/profile_image/default_female.jpg')) ;?>" alt="dating thumb">
                 

             <?php } ?>

                

              </a>
              <div class="card-footer" style="padding-top: 5px;padding: 0px;">
                 <h6 style="font-size:13px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo ((strlen($premium_member->first_name)>33) ? substr($premium_member->first_name,0,33).'..' : $premium_member->first_name); ?></h6>
                 <h6 style="font-size:12px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo translate('age')?>: <?php echo $age; ?></h6>
                 <h6 style="font-size:12px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo ((strlen($education)>18) ? substr($education,0,18).'..' : $education); ?></h6>

              </div>
               </div>
              
               <?php } ?>

         </div>

      </div>

   </div>



<?php }else{ ?>

    <h5 class="mb-3 ml-3 catagory-title"style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('update_matched_profiles');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      

      

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

             <?php if(!empty($premium_members)){ 
            $i=0;?>
            <?php foreach ($premium_members as $premium_member){
                $i++;
            $image = json_decode($premium_member->profile_image, true); 
            $following = json_decode($premium_member->followed, true);
            $name = $premium_member->first_name;
            if(strlen($premium_member->first_name)>25){

               $name = substr($premium_member->first_name, 0,25).'...';
            }

            $action = (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"');
              $place = "";
              if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
                $education = "";
              if(!empty($premium_member->education_and_career))
              {
                  $education_and_career = json_decode($premium_member->education_and_career);
                  $education = $education_and_career[0]->STUDY_DETAILS;
               }
               $age = "";
            if(!empty($premium_member->astronomic_information))
              {
                  $birth = json_decode($premium_member->astronomic_information);
                  $date1 =  date('Y',strtotime($birth[0]->date_of_birth));  
                  $date2 = date("Y");           
                  $age = $date2 - $date1;
               }
           ?>

               <div class="card catagory-card">  
                  

                
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo (($premium_member->gender==1) ? base_url('uploads/profile_image/default.jpg') : base_url('uploads/profile_image/default_female.jpg')) ;?>" alt="dating thumb">
                

              <div class="card-footer mt-1" style="padding-top: 5px;padding: 0px;">
                 <!-- <img src="<?php echo base_url('uploads/blur.jpg')?>" style="width: 110px;height: 100%;"> -->
                 
              </div>
               </div>
              
               <?php } } ?>

         </div>

      </div>

   </div>

<?php } ?>


<?php if(!empty($near_members)){ 
            $i=0;?>
   <h5 class="mb-3 ml-3 catagory-title"style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('near_you');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      <div class="bg-shapes">

         <div class="shape1"></div>

         <div class="shape2"></div>

         <div class="shape3"></div>

         <div class="shape4"></div>

         <div class="shape5"></div>

      </div>

      <!-- <h6 class="mb-3 ml-3 catagory-title"><?php echo translate('members');?></h6> -->

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

             
            <?php foreach ($near_members as $premium_member){
                $i++;
            $image = json_decode($premium_member->profile_image, true); 
            $following = json_decode($premium_member->followed, true);
            $name = $premium_member->first_name;
            if(strlen($premium_member->first_name)>25){

               $name = substr($premium_member->first_name, 0,25).'...';
            }

            $action = (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"');
              $place = "";
              $city = "";
              if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
               if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $city = $permanent_address[0]->permanent_city;
               }
               $age = "";
            if(!empty($premium_member->astronomic_information))
              {
                  $birth = json_decode($premium_member->astronomic_information);
                  $date1 =  date('Y',strtotime($birth[0]->date_of_birth));  
                  $date2 = date("Y");           
                  $age = $date2 - $date1;
               }
                $education = "";
              if(!empty($premium_member->education_and_career))
              {
                  $education_and_career = json_decode($premium_member->education_and_career);
                  $education = $education_and_career[0]->STUDY_DETAILS;
               }
           ?>

               <div class="card catagory-card"> 
                  <a <?php echo (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"')?>>

                <?php  if (file_exists('uploads/profile_image/'.$image[0]['profile_image'])) { ?>
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo base_url('uploads/profile_image/'.$image[0]['profile_image']);?>" alt="dating thumb">
                
                 
             <?php } else{?>
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo (($premium_member->gender==1) ? base_url('uploads/profile_image/default.jpg') : base_url('uploads/profile_image/default_female.jpg')) ;?>" alt="dating thumb">
              
             <?php } ?>

                

              </a>
              <div class="card-footer" style="padding-top: 5px;padding: 0px;">
                 <h6 style="font-size:13px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo ((strlen($premium_member->first_name)>33) ? substr($premium_member->first_name,0,33).'..' : $premium_member->first_name); ?></h6>
                 <h6 style="font-size:12px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo translate('age')?>: <?php echo $age; ?></h6>
                 <h6 style="font-size:12px;font-weight: bold;padding-bottom: 0px;padding-top: 0px;margin-bottom: 1px;"><?php echo ((strlen($city)>20) ? substr($city,0,20).'..' : $city); ?></h6>


              </div>
               </div>
              
               <?php }  ?>

         </div>

      </div>

   </div>
 
<?php }else{ ?>

    <h5 class="mb-3 ml-3 catagory-title"style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('update_near_you');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      

      

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

             <?php if(!empty($premium_members)){ 
            $i=0;?>
            <?php foreach ($premium_members as $premium_member){
                $i++;
            $image = json_decode($premium_member->profile_image, true); 
            $following = json_decode($premium_member->followed, true);
            $name = $premium_member->first_name;
            if(strlen($premium_member->first_name)>25){

               $name = substr($premium_member->first_name, 0,25).'...';
            }

            $action = (($this->session->userdata('thirumanam_applogged_data')) ? 'href="'.base_url('app/short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"');
              $place = "";
              if(!empty($premium_member->permanent_address))
              {
                  $permanent_address = json_decode($premium_member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
                $education = "";
              if(!empty($premium_member->education_and_career))
              {
                  $education_and_career = json_decode($premium_member->education_and_career);
                  $education = $education_and_career[0]->STUDY_DETAILS;
               }
               $age = "";
            if(!empty($premium_member->astronomic_information))
              {
                  $birth = json_decode($premium_member->astronomic_information);
                  $date1 =  date('Y',strtotime($birth[0]->date_of_birth));  
                  $date2 = date("Y");           
                  $age = $date2 - $date1;
               }
           ?>

               <div class="card catagory-card">  
                  

                
                <img style="width: 100%;height: 200px;object-fit: cover;" src="<?php echo (($premium_member->gender==1) ? base_url('uploads/profile_image/default.jpg') : base_url('uploads/profile_image/default_female.jpg')) ;?>" alt="dating thumb">
                
              <div class="card-footer mt-1" style="padding-top: 5px;padding: 0px;">
                 <!-- <img src="<?php echo base_url('uploads/blur.jpg')?>" style="width: 110px;height: 100%;"> -->
                 
              </div>
               </div>
              
               <?php } } ?>

         </div>

      </div>

   </div>

<?php } ?>

   <!-- Editorial Choice News Wrapper-->
<!-- <div class="container">
<div class="row">
   <div class="col-6">
      <div class="editorial-choice-news-wrapper mb-3" style="background-color: #5381f0;height: 90%;">
      <div class="container">
         <div class="editorial-choice-title text-center mb-4">
            <h6 class="newsten-title text-white"><?php echo translate('total');?></h6>
         </div>
      </div>
      <div class="container">
         <div class="single-editorial-slide d-flex">
            <div class="post-thumbnail">
            
              <i class="fas fa-heart text-white" style="font-size: 40px;"></i>
            </div>

            <div class="post-content">
               <h1><span class="counter  text-white" style="font-size: 25px;"><?php echo $all_member_count?></span></h1>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="col-6">
       <div class="editorial-choice-news-wrapper mb-3" style="background-color: #ff6740;height: 90%;">
      <div class="container">
         <div class="editorial-choice-title text-center mb-4">
            <h6 style="line-height: 25px;" class="newsten-title text-white"><?php echo translate('online');?></h6>
         </div>
      </div>
      <div class="container">
         <div class="single-editorial-slide d-flex">
            <div class="post-thumbnail">
              

               <i class="fa fa-globe text-white" style="font-size: 40px;"></i>
            </div>

            <div class="post-content">
               <h1><span class="counter  text-white" style="font-size: 25px;"><?php echo $Online_members_datas?></span></h1>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="col-6">
      <div class="editorial-choice-news-wrapper mb-3" style="background-color: #884bee;height: 90%;">
      <div class="container">
         <div class="editorial-choice-title text-center mb-4">
            <h6 class="newsten-title  text-white"><?php echo translate('male');?></h6>
         </div>
      </div>
      <div class="container">
         <div class="single-editorial-slide d-flex">
            <div class="post-thumbnail">
               
               <i class="fa fa-mars text-white" style="font-size: 40px;"></i>
            </div>

            <div class="post-content">
               <h1><span class="counter  text-white" style="font-size: 25px;"><?php echo $Online_male_datas?></span></h1>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="col-6">
      <div class="editorial-choice-news-wrapper mb-3" style="background-color: #ff4f50;height: 90%;">
      <div class="container">
         <div class="editorial-choice-title text-center mb-4">
            <h6 class="newsten-title  text-white"><?php echo translate('female');?></h6>
         </div>
      </div>
      <div class="container">
         <div class="single-editorial-slide d-flex">
            <div class="post-thumbnail">
              
               <i class="fa fa-venus text-white" style="font-size: 40px;"></i>
            </div>

            <div class="post-content">
               <h1><span class="counter  text-white" style="font-size: 25px;"><?php echo $Online_females_datas?></span></h1>
            </div>
         </div>
      </div>
   </div>
   </div>
</div>
  </div>  -->
  
   
   


 



   





   <!-- Tabs News Wrapper-->

   <!-- <div class="tabs-news-wrapper bg-gray">

      <div class="container">

         <nav>


            <div class="nav nav-tabs" id="nav-tab" role="tablist"> <a class="nav-item nav-link active" id="nav-popular-tab" href="#nav-popular" data-toggle="tab" role="tab" aria-controls="nav-popular" aria-selected="false"><?php echo  translate('about_us');?></a> <a class="nav-item nav-link" id="nav-newest-tab" href="#nav-newest" data-toggle="tab" role="tab" aria-controls="nav-newest" aria-selected="true"><?php echo  translate('what_we_do');?></a><a class="nav-item nav-link" id="nav-newest-tab" href="#nav-newest2" data-toggle="tab" role="tab" aria-controls="nav-newest" aria-selected="true"><?php echo  translate('service_information');?></a>
            <a class="nav-item nav-link" id="nav-newest-tab" href="#nav-newest3" data-toggle="tab" role="tab" aria-controls="nav-newest" aria-selected="true"><?php echo  translate('other_service');?></a>
            <a class="nav-item nav-link" id="nav-newest-tab" href="#nav-newest4" data-toggle="tab" role="tab" aria-controls="nav-newest" aria-selected="true"><?php echo  translate('suyamvaram');?></a> </div>

         </nav>

        

         <div class="tab-content" id="nav-tabContent">

        

            <div class="tab-pane fade show active" id="nav-popular" role="tabpanel" aria-labelledby="nav-popular-tab">

              

                  <div class="single-news-post align-items-center">
                     <img style="width: 50%;margin-left: 25%;" src="<?php echo base_url('uploads/parallax_image/about-us.png');?>" alt="">    <p><?php echo  translate('abouttab1');?></p>
                         <p><?php echo  translate('abouttab2');?></p>


                  </div>

            </div>

          

            <div class="tab-pane fade" id="nav-newest" role="tabpanel" aria-labelledby="nav-newest-tab">

               

                  <div class="single-news-post align-items-center">

                     <img style="width: 50%;margin-left: 25%;" src="<?php echo base_url('uploads/parallax_image/what-we-do.png');?>" alt="">
                        <p><?php echo  translate('whatwedotab');?></p>
                  </div>
               </div>
               <div class="tab-pane fade" id="nav-newest2" role="tabpanel" aria-labelledby="nav-newest-tab">

               

                  <div class="single-news-post align-items-center">

                      <img style="width: 50%;margin-left: 25%;" src="<?php echo base_url('uploads/parallax_image/Service-information.png');?>" alt=""> 
                     <p><?php echo  translate('service');?></p>
                        
                  </div>
               </div>
               <div class="tab-pane fade" id="nav-newest3" role="tabpanel" aria-labelledby="nav-newest-tab">

               

                  <div class="single-news-post align-items-center">

                    <img style="width: 50%;margin-left: 25%;" src="<?php echo base_url('uploads/parallax_image/other-service.png');?>" alt=""> 
                     <p><?php echo  translate('otherService');?></p>
                  </div>
               </div>
               <div class="tab-pane fade" id="nav-newest4" role="tabpanel" aria-labelledby="nav-newest-tab">
                  <div class="single-news-post align-items-center">
                        <img style="width: 50%;margin-left: 25%;" src="<?php echo base_url('uploads/parallax_image/Swayamvaram.png');?>" alt=""> 
                        <p><?php echo  translate('suyamvaramTab');?></p>
                     
                  </div>
               </div>
            </div>

      </div>

   </div> -->

    <!-- Popular Tags -->

  <!--  <div class="popular-tags-wrapper">

      <div class="container">

         <h5 class="mb-3 pl-2 newsten-title">Popular Tags</h5> </div>

      <div class="container">         

         <div class="popular-tags-list"><a class="btn btn-primary btn-sm m-1" href="#">#Politics</a><a class="btn btn-success btn-sm m-1" href="#">#Fashion</a><a class="btn btn-warning btn-sm m-1" href="#">#Tech</a><a class="btn btn-danger btn-sm m-1" href="#">#Lifestyle</a><a class="btn btn-info btn-sm m-1" href="#">#Sports</a><a class="btn btn-success btn-sm m-1" href="#">#World</a><a class="btn btn-warning btn-sm m-1" href="#">#Environment</a><a class="btn btn-danger btn-sm m-1" href="#">#People</a><a class="btn btn-info btn-sm m-1" href="#">#Gadgets</a><a class="btn btn-success btn-sm m-1" href="#">#Health</a><a class="btn btn-primary btn-sm m-1" href="#">#Wildlife</a></div>

      </div>

   </div>  -->

</div>