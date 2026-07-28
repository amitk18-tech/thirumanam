 <?php  $system_name = get_type_name_by_id('general_settings', '1', 'value'); ?>
    <!-- ================> Footer section start here <================== -->
    <footer class="footer footer--style3">
        <div class="footer__top bg_img wow fadeInUp" data-wow-duration="1.5s" style="background-image: url(<?php echo base_url('assets/front/');?>images/footer/bg-2.jpg)">
            <div class="footer__toparea padding-top padding-bottom">
                <div class="container">
                    <div class="row g-4">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="footer__item footer--about">
                                <div class="footer__inner">
                                    <div class="footer__content">
                                        <?php
                                            $footer_logo_info = $this->db->get_where('frontend_settings', array('type' => 'footer_logo'))->row()->value;
                                            $footer_logo = json_decode($footer_logo_info, true);?>
                                        <img  src="<?=base_url()?>uploads/footer_logo/<?=$footer_logo[0]['image']?>" class="img-responsive" width="60%">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="footer__item footer--support">
                                <div class="footer__inner">
                                    <div class="footer__content">
                                        <div class="footer__content--title">
                                            <h4><?php echo translate('main_menu')?></h4>
                                        </div>
                                        <div class="footer__content--desc">
                                            <ul>
                                                <li><a href="<?php echo base_url('home');?>" title="HOME"><i class="fa-solid fa-angle-right"></i> <?php echo translate('home')?></a></li>
                                                <li><a href="<?php echo base_url('contact');?>" title="CONTACT US"><i class="fa-solid fa-angle-right"></i> <?php echo translate('contact_us')?></a></li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="footer__item footer--support">
                                <div class="footer__inner">
                                    <div class="footer__content">
                                        <div class="footer__content--title">
                                            <h4><?php echo translate('tags')?></h4>
                                        </div>
                                        <div class="footer__content--desc">
                                            <ul>
                                                <li><a href="<?php echo base_url('memories');?>" title="MEMORIES"><i class="fa-solid fa-angle-right"></i> <?php echo translate('Memories')?></a></li>
                                                <!--<li><a href="https://nimmathi.in" title="OLD AGE HOME"><i class="fa-solid fa-angle-right"></i> <?php echo translate('Old_Age_Home')?></a></li>-->
                                                <!--<li><a href="https://asvlct.org/" title="TRUST"><i class="fa-solid fa-angle-right"></i> <?php echo translate('Trust')?></a></li>-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="footer__item footer--support">
                                <div class="footer__inner">
                                    <div class="footer__content">
                                        <div class="footer__content--title">
                                            <h4><?php echo translate('useful_links')?></h4>
                                        </div>
                                        <div class="footer__content--desc">
                                            <ul>
                                                 <li>
                                                    <a href="<?php echo base_url('faq');?>" title="FAQ"><i class="fa-solid fa-angle-right"></i>
                                                    <?=translate('FAQ')?> </a>
                                                    </li>
                                                    <li>
                                                    <a href="<?php echo base_url('terms_and_conditions');?>" title="Terms & Conditions"><i class="fa-solid fa-angle-right"></i>
                                                    <?php echo translate('terms_and_conditions')?></a>
                                                    </li>
                                                    <li>
                                                    <a href="<?php echo base_url('privacy_policy');?>" title="Prvacy Policy"><i class="fa-solid fa-angle-right"></i>
                                                    <?php echo translate('privacy_policy')?></a>
                                                    </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer__bottom wow fadeInUp" data-wow-duration="1.5s">
            <div class="container">
                <div class="footer__content text-center">
                     <p class="mb-0"> <?php echo translate('copyright');?> 2012 <?php echo translate('to');?> <?=date("Y")?> &copy; <a href="<?php echo base_url();?>"><?php echo translate($system_name);?></a> || <?php echo translate('all_rights_reserved')?></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- ================> Footer section end here <================== -->