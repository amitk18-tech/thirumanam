<?php
   //die("dfgsdfg sdfgsdfgsd");
        $background_image = $this->db->get_where('frontend_settings', array('type' => 'premium_plans_image'))->row()->value;
       $background_image_data = json_decode($background_image, true);
       $cp_method_3_set =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_set' ))->row()->value;
       $cp_method_3_name =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_name' ))->row()->value;
       $cp_method_3_number =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_number' ))->row()->value;
       $cp_method_3_instruction =  $this->db->get_where('business_settings', array('type' =>'custom_payment_method_3_instruction' ))->row()->value;
   
   
   ?>
    <!-- ================> Page Header section start here <================== -->
   <div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2><?php echo translate('confirm_your_purchase ')?></h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo translate('confirm_your_purchase')?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>
    <!-- ================> Page Header section end here <================== -->

<!-- ===========Info Section Ends Here========== -->
   <div class="membership padding-top padding-bottom">
        <div class="container">
            <div class="section__wrapper">
                <div class="row">
                    <?php foreach ($selected_plan as $value){ ?>
                    <div class="col-md-4 mb-5">
                        <?php if ($value->plan_id == 1) { $package_class = "text-line-through"; } else { $package_class = "active"; } ?>
                        <div class="membership__item">
                            <div class="membership__inner">
                                <div class="membership__head">
                                    <!-- <h4>7 Day Free Trial</h4> -->
                                    <?php
                                    $image = $value->image;
                                    $images = json_decode($image, true);
                                    // print_r($images[0]['image']);exit;
                                    if(!empty($images[0]['image'])){
                                    if (file_exists('uploads/plan_image/'.$images[0]['image'])) {
                                    ?>
                                        <p><img style="width:40%" src="<?=base_url()?>uploads/plan_image/<?=$images[0]['image']?>" class="img-sm"></p>
                                    <?php
                                    }
                                    else {
                                    ?>
                                       <p><img style="width:40%" src="<?=base_url()?>uploads/plan_image/default_image.png" class="img-sm"></p>
                                    <?php
                                    } }
                                ?>
                                    <!-- <p>$15.00 Now And Then $30.00 Per Month.</p> -->
                                </div>
                                <div class="membership__body">
                                    <h4><?=$value->name?></h4>
                                    <h3 class="mt-2"><?=currency($value->amount)?></h3>
                                    <ul>
                                        <li class="<?=$package_class?>"> <span><?=translate('express_interests:')?> <?=$value->express_interest?> <?=translate('times')?></span></li>
                                        <li class="<?=$package_class?>"> <span><?=translate('direct_messages:')?> <?=$value->direct_messages?> <?=translate('times')?></span></li>
                                        <li class="<?=$package_class?>"> <span><?=translate('photo_gallery:')?> <?=$value->photo_gallery?> </span></li>
                                        <li class="<?=$package_class?>"><span><?=translate('Profile_download_text')?> <?=$value->photo_gallery?> </span></li>
                                    </ul>
                                </div>
                                <div class="membership__footer">
               
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-8">
                    <?php if($this->db->get_where("member", array("member_id" => $this->session->userdata('thirumanam_logged_data')['member_id']))->row()->is_closed == 'yes'){?>
                    <div class="text-center py-5">
                       <h5 class="pt-5 pb-4 font_base"><?php echo translate('your_account_is_closed!_please_re-open_the_account_from_your_profile!')?></h5>
                       <div class="text-center pt-2 pb-4">
                          <a  href="<?=base_url()?>profile" class="btn btn-styled btn-sm btn-base-1 z-depth-2-bottom"><?php echo translate('go-to_your_profile')?></a>
                       </div>
                    </div>
                    <?php }else{ ?>
                    <div class="col mb-5">
                        <div class="membership__item">
                            <div class="membership__inner">
                                <div class="membership__head">
                                    <h4><?php echo translate('select_a_payment_method')?></h4>
                                    <p><?php
                                     $language=getLanguage();
                                     $info_msg = $value->info;
                                     $info_msgs = json_decode($info_msg, true);
                                     if ($language=='tamil') {
                                        echo $info_msgs[0]['tamil'];
                                     }
                                     else
                                     {
                                        echo $info_msgs[0]['english'];  
                                     }
                                     ?></p>
                                </div>

                                <div class="membership__body">
                                    <?php 
                                   $userId = $this->session->userdata('thirumanam_logged_data')['member_id'];
                                   
                                   ?>
                                    <div class="row">
                                        <div class="col-md-6 col-6">
                                            <a onclick="payManual()" style="cursor:pointer">
                                        <div class="card">
                                            <div class="card-body">
                                                <?php
                                               if (file_exists('uploads/custom_payment_methods_image/cp_method_2_image.jpg')) {
                                                ?>
                                                <img src="<?=base_url()?>uploads/custom_payment_methods_image/cp_method_2_image.jpg">
                                                <?php
                                                   } else {
                                                   ?>
                                                <img src="<?=base_url()?>uploads/custom_payment_methods_image/custom_payment_dafault.jpg">
                                                <?php
                                                   }
                                                   ?>
                                                <div>
                                                   <span id="select_cp_method_3_text"><?=translate('ManualBankTransfer')?></span>
                                                </div>
                                            </div>
                                        
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <a id="select_cp_method_31" href="<?=base_url()?>WelcomeController/submitPayment/<?=$userId?>/<?=$value->amount;?>/<?=$value->plan_id?>">
                                            <div class="card">
                                                <div class="card-body">
                                                   <img src="<?=base_url()?>uploads/paytm.jpg">
                                                <div >
                                                   <span id="select_cp_method_3_text"><?=translate('onlinePayment')?></span>
                                                </div> 
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="membership__footer" style="padding-bottom: 50px ;">
                                    

                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <form id="payment_form" method="POST" action="<?=base_url()?>WelcomeController/process_payment1" enctype="multipart/form-data" style="display: none;">
                        <?php if($cp_method_3_set == 'ok'){ ?>
    
                        <div class="shop-cart">
                                <div class="section-wrapper">
                                    <div class="cart-bottom">
                                        <div class="shiping-box">
                                            <?php if(count($bank_transfers)==0) { ?>
                                            <div class="row">
                                                <div class="col-md-12 col-12 mt-5">
                                                    <div class="cart-overview">
                                                        <!-- <h3>Cart Totals</h3> -->
                                                        <ul class="codex">
                                                            <li>
                                                                <span class="pull-left"><?php echo translate('account_number'); ?></span>
                                                                <p class="pull-right">60325402081</p>
                                                            </li>
                                                            <li>
                                                                <span class="pull-left"><?php echo translate('name'); ?></span>
                                                                <p class="pull-right">Alagirisamy Vijayalakshmi Charitable Trust</p>
                                                            </li>
                                                            <li>
                                                                <span class="pull-left"><?php echo translate('BankName'); ?></span>
                                                                <p class="pull-right">bank of maharashtra</p>
                                                            </li>
                                                            <li>
                                                                <span class="pull-left"><?php echo translate('branch'); ?></span>
                                                                <p class="pull-right">Gugai branch</p>
                                                            </li>
                                                            <li>
                                                                <span class="pull-left"><?php echo translate('IFSC'); ?></span>
                                                                <p class="pull-right">MAHB0000375</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <p><?= translate('payment_intruction') ?></p>
                                                    <p><?=translate('bank_transfer_note') ?></p>
                                                </div>
                                                <div class="col-md-12 col-12 mt-5">
                                                    <div class="calculate-shiping">
                                                        <!-- <h3>Calculate Shipping</h3> -->
                                                        <input type="hidden" name="cpm_3_name" value="<?= $cp_method_3_name ?>">
                                                        <div class="row">
                                                            <div class="col-md-6 mt-3">
                                                                <input name="cpm_3_transaction_id" type="text" placeholder="<?php echo translate('transaction_id');?>" required class="form-control"/>
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <input id="cpm_3_bill_copy" name="cpm_3_bill_copy" type="file" accept="image/png, image/jpeg, image/jpg, .pdf" required class="form-control"/> 
                                                            </div>
                                                            <div class="col-md-6 mt-3">
                                                                <textarea name="cpm_3_comment"  placeholder="<?php echo translate('Enter additional info/comment');?>" required class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                            
                                                        <input type="hidden" name="payment_type" id="payment_type" value="">
                                                        <input type="hidden" name="plan_id" value="<?=$value->plan_id?>">
                                                        <?php $pay_amount=$value->amount; ?>
                                                        <?php
                                                        $exchange = exchange('usd');
                                                        // $stripe_amount= $value->amount/$exchange;
                                                        $stripe_amount= $pay_amount/$exchange;
                                                        ?>
                                                        <input type="hidden" name="stripe_amount" id="stripe_amount" value="<?=$stripe_amount?>">
                                                        <input type="hidden" name="pay_amount" value="<?=$pay_amount?>">
                                                        <button type="submit" class="default-btn reverse mt-3"><span><?php echo translate('confirm_purchase')?></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }else {?>

                                            <?php
                                            if ($set_lang = $this->session->userdata('language')) {
                             
                                            } else {
                                                $set_lang = $this->db->get_where('general_settings', array('type' => 'language'))->row()->value;
                                            }
                                            if ($set_lang=='english') {
                                               echo "<h6>Your already submitted your bank deposit payment details so wait for admin approval or contact admin.</h6>";
                                            }
                                            else
                                            {
                                               echo "<p>உங்கள் வங்கி டெபாசிட் கட்டண விவரங்களை நீங்கள் ஏற்கனவே சமர்ப்பித்துள்ளீர்கள், எனவே நிர்வாக ஒப்புதலுக்காக காத்திருக்கவும் அல்லது நிர்வாகியைத் தொடர்பு கொள்ளவும்.</p>";
                                            }
                                          ?>
                                         </div>
                                         <input type="hidden" name="cpm_3_name" value="Paytm ">

                                        <?php } ?>
                                        </div>
                                </div>
                            </div>
                        <?php }   ?>
                      </form>
                <?php } ?>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

   <script>
       function payManual(){
           $("#select_cp_method_3_text").html("<?php echo translate('selected')?>");
           $("#payment_form").css('display','block');
           $("#payment_type").val('custom_payment_method_3');
       }
    </script>


      <!-- ================> shop Cart section start here <================== -->

    <!-- ================> shop Cart section end here <================== -->