<style>
  
 tbody{
  color: white;
 }


body{
  background-image: none;
}


section{
/*  font-family: Calibri, sans-serif;*/
  max-width: 1024px;
  width:100%;
  height:100%;
/*  background-color:#DEDEDE;*/
  margin:auto;
/*  padding:20px;*/
  overflow:hidden;
}
/*----- Tabs -----*/
.tabs {
    width: 100%;
    display:inline-block;
}
 
    /*----- Tab Links -----*/
    .tab-links:after {
        display:block;
        clear:both;
        content:'';
    }
    
 
    .tab-links li {
        margin: 0;
        float:left;
        list-style:none;
    }
 
        .tab-links a {
            padding:9px 24px 5px 30px;
/*            display:inline-block;*/
/*            border-radius:2px 2px 0px 0px;*/
/*            background:#2E5C8A;*/
            font-size:16px;
            font-weight:600;
/*            color:#FFAD5C;*/
            transition:all linear 0.3s;
            width: 150px;
            text-align: center;
            text-decoration:none;

        }
 
        .tab-links a:hover {
            background:#FF3333;
            color: #EBEBEB;
            text-decoration:none;

        }
 
    li.active a, li.active a:hover {
        background:white;
        color:black;
        border-bottom: 2px solid #f8587e;
    }
 
    /*----- Content of Tabs -----*/
    .tab-content {
/*        width:960px;*/
/*        border-radius:3px;*/
/*        box-shadow:0px 10px 10px rgba(0,0,0,0.45);*/
/*        background:#fff;*/
        margin-top:-16px;
        padding:15px;
    }
 
.tab {
    display:none;
}

.tab.active {
    display:block;
}

.image img {

  border-radius: 0px!important;
  height: 5em;
  object-fit: cover;
}
.single-news-post {
margin-bottom: 0px!important;
padding: 0px!important;
}
.container
{
    margin-bottom: 6em;
}
nav{
    margin-top: 1em;
}
</style>

<?php

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

$member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
$getUser = getData('member','row',array('member_id'=>$member_id));
    $profile_images = get_type_name_by_id('member', $getUser->member_id, 'profile_image');
   $profile_image = json_decode($profile_images, true);
?>

<div class="page-content-wrapper" style="margin-bottom:5em!important">
</div>

                


<?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
<button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
<?php }else{ ?>
<section>
<div class="container">
    
 
   
        

          <?php 
          
                if(!empty($results)){
                foreach($results as $member){
                    // print_r($member->status);exit;
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);  
                    $birth = json_decode($member->astronomic_information, true);  

                    // print_r($spiritual_and_social_background);exit;
                 if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }    
                
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));  
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }
                
              $place = "";
              if(!empty($member->permanent_address))
              {
                  $permanent_address = json_decode($member->permanent_address);
                  $place = $permanent_address[0]->permanent_state;
               }
              $work = "";
              if(!empty($member->education_and_career))
              {
                  $education_and_career = json_decode($member->education_and_career);
                  $work = $education_and_career[0]->Type_of_occupation;
              }

              $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
              $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest');
                $interest = json_decode($interests, true);
              if (!in_assoc_array($member->member_id, 'id', $interest)) {
                // print_r($count_interest);
          ?>
          <!-- Single News Post-->
          <div class="single-news-post d-flex align-items-center bg-gray mt-1">
            <div class="post-thumbnail image"><?php echo $image;?></div>
            <div class="post-content">
             <div class="row">
                <div class="col-12">
                    <a class="post-title" style="font-size:15px;font-weight: 700"> <?php echo $member->first_name; ?></a>
                </div>
                <!-- <div class="col-2">
                    <a href="<?php echo base_url('AppController/deleteView/')?>" class="post-title text-center" style="font-weight: 700;border:1px solid #f8587e;border-radius: 20px;color:#f8587e;font-size: 17px!important;">x</a>
                </div> -->
             </div>  
            <a class="post-title" style="color: #000000a6"><?php echo $age; ?> Yrs</a>
            <a class="post-title" style="color: #000000a6"><?php echo $place; ?></a>
            <a class="post-title" style="color: #000000a6"><?php echo $work; ?></a>
              
            
              
            </div>

          </div>
          <div class="row p-2">
              <div class="col-6" style="width:100%;">
                   <a class="btn btn-success px-4" style="padding: 7px;border-radius: 8px;background: white;color:#f8587e;box-shadow: 0 2px 2px 0 rgba(16, 13, 209, 0.175);border: none;font-size: 14px;margin-top: 2px" href="<?php echo base_url('app/short_view/'.$member->member_id);?>">More Info</a>
              </div>
              <?php 

                if($count_interest == 0){

                     echo '<a class="btn btn-success px-4" style="border-radius: 8px;font-size: 14px;color:white;margin-top: 2px"  data-toggle="modal" data-target="#interestModal">'.translate('express_interest').'</a>';
                    }else{

                       echo '<a class="btn btn-success px-4" style="border-radius: 8px;font-size: 14px;color:white;margin-top: 2px" onclick="doInterest('.$member->member_id.')">'.translate('express_interest').'</a>';

                    }

              ?>
            </div>
          <!-- Single News Post-->
          <?php } } }?>
          <!-- </div> -->
      
        
    <?php if(!empty($links))
    {?>
    <nav aria-label="Page navigation example" class="pl-2">
          <?php echo $links;?>
      </nav>
    <?php } ?>
</div>

</div>
<div id="edit_output"></div>
</section>
<?php } ?>



<div class="modal fade" id="interestModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="interestModalLabel"><?php echo translate('express_interest')?></h6>
        <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p><?php echo translate('you_have_no_express_interests_left. please_buy_any_package_from_premium_plans.')?></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
        <a href="<?php echo base_url('app/Subscription');?>" class="btn btn-primary" type="button"><?php echo translate('premium_plans')?></a>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="script.js"></script>




<script>
  $(document).ready(function() {
    $('.tabs .tab-links a').on('click', function(e)  {
        var currentAttrValue = $(this).attr('href');
 
        // Show/Hide Tabs
        $('.tabs ' + currentAttrValue).fadeIn(400).siblings().hide();
        // Change/remove current tab to active
        $(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
        
        
    });
});

function confirm_accept(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/confirm_accept',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
</script>