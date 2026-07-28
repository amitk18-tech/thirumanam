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
?>
<?php
$noti_counter = 0;
$msg_counter = 0;
$notifications = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'notifications');
$notification = json_decode($notifications, true);
sort_array_of_array($notification, 'time', SORT_DESC);

$member=$this->db->get_where("member", array("member_id" => $this->session->userdata('thirumanam_applogged_data')['member_id']))->row();


?>

<div class="page-content-wrapper" style="margin-bottom:5em!important">
</div>

                


<section>
<div class="tabs">
    <ul class="tab-links">
        <li class="active" style="width: 50%;"><a href="#tab1"> Accept & reject</a></li>
        <li><a href="#tab2" style="width: 50%;"> New Interests</a></li>
        
    </ul>
 
    <div class="tab-content">
        <div id="tab1" class="tab active">
            <div class="user-all-article-wrapper">
        

         <?php

          foreach ($notification as $row) {
            $is_member = $this->db->get_where("member", array("member_id" => $row['by']))->row();
              if(!empty($is_member) && $is_member->is_closed == 'no'){
            if ($this->db->get_where('member', array('member_id' => $row['by']))->row()->member_id){
            if ($row['is_seen'] == 'no') {
            $noti_counter++;
             }
            
            $noti_profile_image = get_type_name_by_id('member', $row['by'], 'profile_image');
            $noti_images = json_decode($noti_profile_image, true);
            $notify_member = $this->db->get_where('member', array('member_id' => $row['by']))->row();
             $first_name = get_type_name_by_id('member', $row['by'], 'first_name');
            if($row['status'] == 'accepted' || $row['status'] == 'rejected' ||  $row['type'] == 'accepted_interest' || $row['type'] == 'rejected_interest') {
            ?>
          <!-- Single News Post-->
          <div class="single-news-post d-flex align-items-center bg-gray mt-3"  style="    height: 50px;">
            <div class="post-thumbnail image">
              
              <?php if($notify_member->gender==1){?>
                    <img style="object-fit:contain;height:100px;width: 80%;" alt="dating thumb" src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                    <?php } ?>
                    <?php if($notify_member->gender==2){?>
                        <img style="object-fit:contain;height:100px;width: 80%;" alt="dating thumb" src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                    <?php } ?>

            </div>
            <div class="post-content">
               
            <a class="post-title" style="font-size:15px;font-weight: 700"> <?php echo ((strlen($first_name)>50) ? substr($first_name,0,50).'..' : $first_name); ?></a>
            <?php

            if($row['type'] == 'interest_expressed') {

            if($row['status'] == 'accepted') {
            ?>
            <a class="post-title" style="color: #000000a6"><?php echo translate('you_have_accepted_the_interest')?></a>
            <?php
            } else if($row['status'] == 'rejected') {
            ?>
            <a class="post-title" style="color: #000000a6"><?php echo translate('you_have_rejected_the_interest')?></a>
       
              
            <?php } } elseif ($row['type'] == 'accepted_interest') {  ?>

            <a class="post-title" style="color: #000000a6"><?php echo translate('accepted_your_interest')?></a>

          <?php } elseif ($row['type'] == 'rejected_interest') { ?>

            <a class="post-title" style="color: #000000a6"><?php echo translate('rejected_your_interest')?></a>
          <?php } ?> 
            <div style="text-align: end;">
                <p style="margin-bottom: 0px;"><?=date('d M,y - h:i A', $row['time'])?></p>
            </div>
            </div>

          </div>
          <hr>

          <?php  } }  } } ?>
          <!-- Single News Post-->
        
          
      </div>
        </div>
 
        <div id="tab2" class="tab">
            <div class="user-all-article-wrapper">
        
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
            $notify_member = $this->db->get_where('member', array('member_id' => $row['by']))->row();
            $first_name = get_type_name_by_id('member', $row['by'], 'first_name');
            if($row['status'] == 'pending') {
            
            ?>
          <!-- Single News Post-->
          <div class="single-news-post d-flex align-items-center bg-gray" style="    height: 65px;">
            <div class="post-thumbnail image">
                
                <?php if($notify_member->gender==1){?>
                    <img style="object-fit:contain;height:100px;width: 80%;" alt="dating thumb" src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default.jpg') ;?>">
                    <?php } ?>
                    <?php if($notify_member->gender==2){?>
                      <img style="object-fit:contain;height:100px;width: 80%;" alt="dating thumb" src="<?php echo (!empty($noti_images && $noti_images[0]['profile_image']) && file_exists('uploads/profile_image/'.$noti_images[0]['profile_image'])) ? base_url('uploads/profile_image/'.$noti_images[0]['profile_image']) : base_url('uploads/profile_image/default_female.jpg') ;?>">
                <?php } ?>

            </div>
            <div class="post-content">
               
            <a class="post-title" style="font-size:15px;font-weight: 700"><?php echo ((strlen($first_name)>50) ? substr($first_name,0,50).'..' : $first_name); ?> </a>
            <a class="post-title" style="color: #000000a6"><?php echo translate('has_expressed_an_interest_on_you')?></a>
              
            <div style="text-align: end;">
                <p style="margin-bottom: 0px;"><?=date('d M,y - h:i A', $row['time'])?></p>
            </div>
            </div>

          </div>
          <div class="row mb-2">
              <div class="col-4" style="width:100%;">
                   <a class="btn btn-success px-1" style="padding: 7px;border-radius: 8px;background: white;color:#f8587e;box-shadow: 0 2px 2px 0 rgba(16, 13, 209, 0.175);border: none;font-size: 14px;width:100%" href="<?php echo base_url('app/short_view/'.$row['by']);?>">More Info</a>
              </div>
              <div class="col-4" style="width:100%;text-align: end;">
                   <a class="btn btn-success px-3 bg-danger text-white" style="padding: 7px;border-radius: 8px;background: white;box-shadow: 0 2px 2px 0 rgba(16, 13, 209, 0.175);border: none;font-size: 14px;width:100%" onclick="confirm_reject(<?=$row['by']?>)"><?php echo translate('reject')?></a>
              </div>
              <div class="col-4" style="width:100%;text-align: center;">
                   <a class="btn btn-success px-2 bg-success" style="border-radius: 8px;font-size: 14px;color:white;border :1px solid #00b894;width:100%" onclick="confirm_accept(<?=$row['by']?>)"><?php echo translate('accept')?></a>
              </div>
            </div>
          <?php } } } } } ?>
      </div>
        </div>
 
        

    </div>
    <?php if(!empty($links))
    {?>
    <nav aria-label="Page navigation example" class="pl-2">
          <?php echo $links;?>
      </nav>
    <?php } ?>

</div>
<div id="edit_output"></div>
</section>

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
    <script>
        
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
function confirm_reject(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/confirm_reject',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

    </script>