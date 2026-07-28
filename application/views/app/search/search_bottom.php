<?php if(!empty($total_views_member))
{?>
         <h5 class="mb-3 ml-3 catagory-title" style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('most_viewed_profile');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      

      

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

             <?php if(!empty($total_views_member)){ 
            $i=0;?>
            <?php foreach ($total_views_member as $premium_member){
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

               <div class="card catagory-card"> <a href="<?php echo base_url('app/view_details/'.$premium_member->member_id); ?>">
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
      <?php } ?>


   <?php if(!empty($total_viewer_member))
{?>
         <h5 class="mb-3 ml-3 catagory-title" style="font-weight: bold;font-size: 14px;margin-top:13px"><?php echo translate('most_viewer_profile');?></h5>
   <div class="top-catagories-wrapper mb-2" style="padding-top: 0px!important;">

      

      

      <div class="container">

         <!-- Catagory Slides-->

         <div class="catagory-slides owl-carousel">

            <!-- Catagory Card-->

             <?php if(!empty($total_viewer_member)){ 
            $i=0;?>
            <?php foreach ($total_viewer_member as $premium_member){
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
      <?php } ?>
  
