<div class="page-content-wrapper">

  <div class="element-wrapper">

      <div class="container">
         <div class="row">
           
            <div class="col-10">
               <div class="search-page-form mb-5">
                  <!-- Search via Voice-->
                  <form id="form1" action="<?php echo base_url('app/match_seach_list');?>" method="post">
                     <a type="submit" class="search-via-voice"  onclick="document.getElementById('form1').submit();"><i class="far fa-paper-plane text-dark"></i></a>
                    <input class="form-control" type="search" placeholder="<?php echo translate('search_based')?>" style="background-image: url(<?php echo base_url('uploads/'); ?>backgound.jpg);border: 1px solid #f8587e85;" name="member_id">
                    <button type="submit"><i class="fa fa-search text-dark"></i></button>
                  </form>
               </div>
            </div>
            <div class="col-2">
               <div class="search-page-form bg-secondary text-center" style="border-radius: 10px;padding: 11px;padding-right: 36px;">
                  <a href="<?php echo base_url('app/match_member_search/match_search_all')?>">
                     <i class="fas fa-sliders-h text-white" style="font-size: 25px;"></i>
                  </a>
               </div>
            </div>
         </div>
         
      


      <div class="row">
         <div class="col-6" style="height:40%">
         <a href="<?php echo base_url('app/match_member_search/appearance_search')?>">
            <div class="editorial-choice-news-wrapper mb-3" style="background-color: #5381f0;height: 8em;">
          
            <div class="container">
               <div class="single-editorial-slide">
                  <div class="post-thumbnail">
                  <i class="far fa-user text-white" style="font-size: 20px;"></i>
                  </div>

                  <div class="post-content">
                     <h5 class="text-white" style="font-size: 15px;margin-top: 5px;text-align: center;"><?php echo translate('filter_by_appearance')?></h5>
                  </div>
               </div>
            </div>
         </div>
      </a>
         </div>
         <div class="col-6" style="height:40%">
            <a href="<?php echo base_url('app/match_member_search/edupro_search')?>">
             <div class="editorial-choice-news-wrapper mb-3" style="background-color: #ff6740;height: 8em;">
           <!--  <div class="container">
               <div class="editorial-choice-title text-center mb-4">
                  <h6 style="line-height: 25px;" class="newsten-title text-white"><?php echo translate('online');?></h6>
               </div>
            </div> -->
            <div class="container">
               <div class="single-editorial-slide">
                  <div class="post-thumbnail">
                    
                     <i class="fas fa-user-tie text-white" style="font-size: 20px;"></i>
                    
                  </div>

                  <div class="post-content">
                     <h5 class="text-white" style="font-size: 15px;margin-top: 5px;text-align: center;"><?php echo translate('filter_by_education_profession')?></h5>
                  </div>
               </div>
            </div>
         </div>
      </a>
         </div>
         <div class="col-6" style="height:40%">
            <a href="<?php echo base_url('app/match_member_search/family_search')?>">
            <div class="editorial-choice-news-wrapper mb-3" style="background-color: #884bee;height: 8em;">
           <!--  <div class="container">
               <div class="editorial-choice-title text-center mb-4">
                  <h6 class="newsten-title  text-white"><?php echo translate('male');?></h6>
               </div>
            </div> -->
            <div class="container">
               <div class="single-editorial-slide">
                  <div class="post-thumbnail">
                     <i class="fas fa-users text-white" style="font-size: 20px;"></i>
                    
                  </div>

                  <div class="post-content">
                      <h5 class="text-white" style="font-size: 15px;margin-top: 5px;text-align: center;"><?php echo translate('filter_by_family')?></h5>
                  </div>
               </div>
            </div>
         </div>
      </a>
         </div>
         <div class="col-6" style="height:40%">
            <a href="<?php echo base_url('app/match_member_search/astrologic_search')?>">
            <div class="editorial-choice-news-wrapper mb-3" style="background-color: #ff4f50;height: 8em;">
            <!-- <div class="container">
               <div class="editorial-choice-title text-center mb-4">
                  <h6 class="newsten-title  text-white"><?php echo translate('female');?></h6>
               </div>
            </div> -->
            <div class="container">
               <div class="single-editorial-slide">
                  <div class="post-thumbnail">
                    <i class="fas fa-gopuram text-white" style="font-size: 20px;"></i>
                  </div>

                  <div class="post-content">
                      <h5 class="text-white" style="font-size: 15px;margin-top: 5px;text-align: center;"><?php echo translate('filter_by_astrology')?></h5>
                  </div>
               </div>
            </div>
         </div>
      </a>
         </div>
      </div>
      </div> 

 <?php echo $menu;?>
    </div>
</div>