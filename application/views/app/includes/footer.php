<?php

$menu1=$menu2=$menu3=$menu4=$menu5='';

if ($this->uri->segment(2)=='home' || $this->uri->segment(2)=='') {

   $menu1='active';

}

if ($this->uri->segment(2)=='active_member_search') {

   $menu2='active';

}

if ($this->uri->segment(2)=='message') {

   $menu3='active';

}

if ($this->uri->segment(2)=='notification') {

   $menu4='active';

}

if ($this->uri->segment(2)=='profile') {

   $menu5='active';

}


$count_messaging_members = count_listed_messaging_members($this->session->userdata('thirumanam_applogged_data')['member_id']);
$notifications = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'notifications');
$notification = json_decode($notifications, true); 

?>

<!-- Footer Nav-->

<div class="footer-nav-area" id="footerNav">

   <div class="newsten-footer-nav h-100">

      <ul class="h-100 d-flex align-items-center justify-content-between">

         <li class="<?php echo $menu1; ?>"><a href="<?php echo base_url('app') ?>"><i class="lni lni-home"></i></a></li>
         <?php
        if($this->session->userdata('thirumanam_applogged_data')){
         $id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            
        $payed_customer = getMemberCurrentPayment($id);
        // print_r($payed_customer);
        if(!empty($payed_customer)){
         ?>
         <li class="<?php echo $menu2; ?>"><a href="<?php echo base_url('app/active_member_search') ?>"><i class="lni lni-search-alt"></i></a></li>         
         <?php } } ?>
         <li class="<?php echo $menu3; ?>"><a href="<?php echo base_url('app/message') ?>"><i class="fas fa-envelope"></i> <sup style="top: -1.5em;"><?php echo count($count_messaging_members);?></sup></a></li>

         <li class="<?php echo $menu4; ?>"><a href="<?php echo base_url('app/notification') ?>"><i class="lni lni-alarm"></i><sup style="top: -1.5em;"><?php echo count($notification);?></sup></a></li>      

         <li class="<?php echo $menu5; ?>"><a href="<?php echo base_url('app/profile') ?>"><i class="lni lni-user"></i></a></li>

         

      </ul>

   </div>

</div>