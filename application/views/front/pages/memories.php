<div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
    <div class="container">
        <div class="pageheader__content text-center">
            <h2><?php echo translate('memories ')?></h2>
            <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo translate('memories')?></li>
                </ol>
            </nav> -->
        </div>
    </div>
</div>



<div class="blog padding-top padding-bottom">
        <div class="container">
            <div class="section-wrapper">
                <div class="row g-4 justify-content-center">
                   <?php
                            if (!empty($memories)) {
                                // print_r($memories);exit;
                                foreach ($memories as $value) {?>
                    <div class="col-lg-6 col-12">
                        <div class="blog__item">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <img src="<?php echo base_url('uploads/memories/'.$value->name)?>" alt="blog-thumb" class="w-100" style="height: 25em;object-fit: cover;">
                                </div>
                                <div class="blog__content px-3 py-4">
                                    <!-- <a href="#"><h3>Compellingly productivate innovative niches rather.</h3></a> -->
                                    <div class="blog__metapost">
                                        <!-- <a href="#">Admin</a> -->
                                        <a href="#"><?php echo date('d-M-Y', strtotime($value->created_date))?></a>
                                    </div>
                                    <!-- <p>Uniquely conceptuaze visionary process ariwith tactical ramatica centered qualitys vectoris with outofthebox scenario is ompelling uthoritatively generate front-end niches after one</p>
                                    <a href="blog-single.html" class="default-btn reverse"><span>read more</span> -->
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
        </div>
    </div>