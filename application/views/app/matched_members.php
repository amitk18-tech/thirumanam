<style>
  
 tbody{
  color: white;
 }


body{
  background-image: none;
}
.container
{
    margin-bottom: 6em;
}
nav{
    margin-top: 1em;
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


                


<?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
<button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
<?php }else{ ?>
<div class="container">
<section class="mb-3">      


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
          
          ?>
          <!-- Single News Post-->
          
          <div class="single-news-post d-flex align-items-center bg-gray mt-3" style="border-bottom: 3px solid #00000036;">
            <div class="post-thumbnail image" style="margin-bottom: 10px;"><?php echo $image;?></div>
            <div class="post-content" style="margin-bottom: 10px;">
               
            <a href="<?php echo base_url('app/short_view/'.$member->member_id);?>" class="post-title" style="font-size:15px;font-weight: 700"> <?php echo ((strlen($member->first_name)>50) ? substr($member->first_name,0,50).'..' : $member->first_name); ?></a>
            <a href="<?php echo base_url('app/short_view/'.$member->member_id);?>" class="post-title" style="color: #000000a6"><?php echo $age; ?> Yrs</a>
            <a href="<?php echo base_url('app/short_view/'.$member->member_id);?>" class="post-title" style="color: #000000a6"><?php echo $place; ?></a>
            <a href="<?php echo base_url('app/short_view/'.$member->member_id);?>" class="post-title" style="color: #000000a6"><?php echo $work; ?></a>
              
              
            </div>

          </div>
        </a>
          
          <!-- Single News Post-->
          <?php } } ?>
          <!-- </div> -->
 

        
</section>
    <?php if(!empty($links))
    {?>
    <nav aria-label="Page navigation example" class="pl-2">
          <?php echo $links;?>
      </nav>
    <?php } ?>
</div>
</div>
<div id="edit_output"></div>

<?php } ?>
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


</script>