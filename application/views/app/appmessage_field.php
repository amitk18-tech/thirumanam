<style>
  
 tbody{
  color: white;
 }
 body{
  background-image: none;
}

</style>
<style>
    .modal-body label {
    margin-bottom: 0px !important;
    }
    .card{
        padding: 15px !important;
    }
    .msger-send-btn {
  margin-left: 10px;
  background: rgb(0, 196, 65);
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.23s;
  height: 100%;
  padding: 5px;
}
.msger-send-btn:hover {
  background: rgb(0, 180, 50);
}
@media only screen and (min-width: 360px) and (max-width: 400px) {
.search-page-form
{
  margin-top: 583px;
 
}
}

@media only screen and (min-width: 412px) and (max-width: 915px) {
.search-page-form
{
  margin-top: 735px;
 
}
}
@media only screen and (min-width: 768px) and (max-width: 1024px) {
.search-page-form
{
  margin-top: 865px;
 
}
}
@media only screen and (min-width: 820px) and (max-width: 1180px) {
.search-page-form
{
  margin-top: 1015px;
 
}
}
input
{
  margin-left: 10px;
  margin-right: -7px;
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


<div class="page-content-wrapper" style="margin-bottom: 150px;">
 
   
    
        
    <?php if($this->db->get_where("member", array("member_id" => $getUser->member_id))->row()->is_closed == 'yes'){?>
          <button type="button" data-toggle="modal" data-target="#exampleModal" class="mb-1 btn btn-sm btn-primary"><?php echo translate('re-open_account')?></button>
     <?php }else{ ?>
                
            <div class="row">
             
              <div class="col-12">
                  <div class="direct-chat direct-chat-warning mt-3">
                      
                      <div style="overflow-y: scroll;height: 100%;overflow-x: auto;background-color: white;" id="msg_body">
                          <!-- Conversations are loaded here -->
                          <?php echo $message_field;?>
                      </div>
                     
                     
                  </div>
              </div>
                 <div class="search-page-form" style="position: fixed;width: 100%;">
                        <form class="form-default" id="message_form" method="post">
                      <!-- Search via Voice--><a class="search-via-voice" id="msg_send_btn"><i class="far fa-paper-plane" style="font-size:25px;color:#f8587e"></i></a>
                      
                        <input class="form-control" type="search" id="message_text" name="message_text" placeholder="Type Message ..." value="">
                        <button type="submit"><i class="far fa-smile" style="font-size:25px;color:#f8587e"></i></button>
                      </form>
                    </div>
              
                  </div>

            <?php } ?>
          </div>





<script>
    // $(document).ready(function(){
    //     $("#msg_send_btn").attr("onclick", "msg_send(<?=$thread_info->message_thread_id?>, <?=$from_info->member_id?>, <?=$to_info->member_id?>)");
        
    //     $('#msg_body').animate({
    //         scrollTop: $('#msg_body').get(0).scrollHeight
    //     }, 1); 
    // });

function loadContent(url) {
  const xhttp = new XMLHttpRequest();
  xhttp.open("GET", url);
  xhttp.send();
  xhttp.onreadystatechange = (e) => {
    document.getElementById("demo").innerHTML = xhttp.responseText;
  }
}

</script>
