<p class="mx-1"><span class="counter"><?php echo $getUser->remain_download?></span><span style="font-size: 9px;"><?php echo translate('package_informations')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->express_interest?></span><span style="font-size: 9px;"><?php echo translate('remaining_interest')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->direct_messages?></span><span style="font-size: 9px;"><?php echo translate('remaining_message')?></span></p>

                  <p class="mx-1"><span class="counter"><?php echo $getUser->photo_gallery?></span><span style="font-size: 9px;"><?php echo translate('photo_gallery')?></span></p>

               </div>
               <?php 
               $payment= getMemberCurrentPayment($getUser->member_id);                
                $info = (!empty($payment)) ?  $this->db->get_where('plan',array('plan_id'=>$payment->plan_id))->row() : [];
                $msg='';
                     
                if (!empty($info)) {
                    $language=getLanguage();
                     $info_msg = $info->info;
                     $info_msgs = json_decode($info_msg, true);
                     if ($language=='tamil') {
                        $msg=$info_msgs[0]['tamil'];
                     }
                     else
                     {
                        $msg=$info_msgs[0]['english'];  
                     }
                }

                ?><!--line no 2779-->
                <p class="mt-3 bg-success"><?php echo $msg ;?></p>
                 <?php if($getUser->report_married_status==0) {?>
                  <button onclick="add_married(<?php echo $getUser->member_id;?>)" class="btn btn-xs btn-sm btn-outline-secondary btn-border mr-1 mt-3"><?php echo translate('match');?></button>
               <?php }else { ?>
                  <button class="btn btn-xs btn-sm btn-outline-success btn-border mr-1 mt-3"><?php echo translate('match_reported');?></button>
               <?php } ?>