<div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2><?php echo translate('Common_Quries');?></h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo translate('Common_Quries');?></li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="member member--style2 padding-top padding-bottom">
    <div class="container">
        <div class="section__wrapper wow fadeInUp" data-wow-duration="1.5s">
             <div class="widget shop-widget">
                <!-- <div class="widget-header">
                    <h5>All Categories</h5>
                </div> -->
                <div class="widget-wrapper mb-5">
                    <ul class="shop-menu lab-ul">
                    <?php

                    $CI=& get_instance();
                    $CI->load->database();
                    if($set_lang = $CI->session->userdata('language')){} else {
                        $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
                    }
                    
                    if($set_lang == 'english')
                    {
                        $l ='ques_english';
                        $la ='ans_english';
                        $f = $this->db->select('ques_english,ans_english')->get_where('faq_ques',array('qId'=>0))->result_array();
                       
                       
                    }
                    else{
                        $l ='ques_tamil';
                        $la ='ans_tamil';
                        $f = $this->db->select('ques_tamil,ans_tamil')->get_where('faq_ques',array('qId'=>0))->result_array();
                        
                        
                    }
                    
                
                   $faqs = json_decode($this->db->get_where('general_settings', array('type' => 'faqs'))->row()->value, true);
                   if (!empty($faqs)) {
                       $i = 1;
                      foreach ($f as $faq) {
                        // print_r($faq['ques_english']);exit;
                        ?>
                        <li>
                            <a style="cursor: pointer;"><?php echo $faq[$l]; ?></a>
                            <ul class="shop-submenu lab-ul">
                                <li><a><?php echo $faq[$la]; ?></a></li>
                            </ul>
                        </li>
                         <?php } } else{ ?>
                            <li><h6><?=translate('no_FAQ_posted_yet!')?></h6></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="widget-header">
                    <h5><?php echo translate('Online_Registered_User_Quries')?></h5>
                </div>
                <div class="widget-wrapper mb-5">
                    <ul class="shop-menu lab-ul">
                    <?php

                    $CI=& get_instance();
                    $CI->load->database();
                    if($set_lang = $CI->session->userdata('language')){} else {
                        $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
                    }
                    
                    if($set_lang == 'english')
                    {
                        $l ='ques_english';
                        $la ='ans_english';
                        $f = $this->db->select('ques_english,ans_english')->get_where('faq_ques',array('qId'=>1))->result_array();
                       
                       
                    }
                    else{
                        $l ='ques_tamil';
                        $la ='ans_tamil';
                        $f = $this->db->select('ques_tamil,ans_tamil')->get_where('faq_ques',array('qId'=>1))->result_array();
                        
                        
                    }
                    
                
                   $faqs = json_decode($this->db->get_where('general_settings', array('type' => 'faqs'))->row()->value, true);
                   if (!empty($faqs)) {
                      foreach ($f as $faq) {
                        // print_r($faq['ques_english']);exit;
                        ?>
                        <li>
                            <a  style="cursor: pointer;"><?php echo $faq[$l]; ?></a>
                            <ul class="shop-submenu lab-ul">
                                <li><a><?php echo $faq[$la]; ?></a></li>
                            </ul>
                        </li>
                        <?php } } else{ ?>
                            <li><h6><?=translate('no_FAQ_posted_yet!')?></h6></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="widget-header">
                    <h5><?php echo translate('Offline_Registered_User_Quries')?></h5>
                </div>
                <div class="widget-wrapper mb-5">
                    <ul class="shop-menu lab-ul">
                    <?php

                    $CI=& get_instance();
                    $CI->load->database();
                    if($set_lang = $CI->session->userdata('language')){} else {
                        $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
                    }
                    
                    if($set_lang == 'english')
                    {
                        $l ='ques_english';
                        $la ='ans_english';
                        $f = $this->db->select('ques_english,ans_english')->get_where('faq_ques',array('qId'=>1))->result_array();
                       
                       
                    }
                    else{
                        $l ='ques_tamil';
                        $la ='ans_tamil';
                        $f = $this->db->select('ques_tamil,ans_tamil')->get_where('faq_ques',array('qId'=>1))->result_array();
                        
                        
                    }
                    
                
                   $faqs = json_decode($this->db->get_where('general_settings', array('type' => 'faqs'))->row()->value, true);
                   if (!empty($faqs)) {
                       $i = 1;
                      foreach ($f as $faq) {
                        // print_r($faq['ques_english']);exit;
                        ?>
                        <li>
                            <a  style="cursor: pointer;"><?php echo $faq[$l]; ?></a>
                            <ul class="shop-submenu lab-ul">
                                <li><a><?php echo $faq[$la]; ?></a></li>
                            </ul>
                        </li>
                         <?php } } else{ ?>
                            <li><h6><?=translate('no_FAQ_posted_yet!')?></h6></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>  
        </div>
    </div>
</div>