 <div class="pageheader bg_img" style="background-image: url(<?php echo base_url('assets/front');?>/images/bg-img/pageheader.jpg);">
        <div class="container">
            <div class="pageheader__content text-center">
                <h2><?php echo translate('story_details ')?></h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                      <li class="breadcrumb-item"><a href="<?php echo base_url();?>"><?php echo translate('home ')?></a></li>
                      <li class="breadcrumb-item active" aria-current="page"><?php echo translate('story_details')?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- ================> Blog section start here <================== -->
    <div class="blog blog--style2 padding-top padding-bottom aside-bg">
		<div class="container">
			<div class="section-wrapper">
				<div class="row justify-content-center pb-15">
					<div class="col-lg-12 col-12">
						<article>

							<div class="blog__item">
								<div class="blog__inner">
									<?php if(!empty($story_datas)){
											foreach($story_datas as $story){?>
									<div class="blog__thumb blog__slider">
										<div class="swiper-wrapper">
											
												<?php
											        $images = json_decode($story->image, true);
											        foreach ($images as $image){
											    ?>
											<div class="swiper-slide">
												<div class="blog__img">
													<img src="<?=base_url()?>uploads/happy_story_image/<?=$image['img']?>" alt="blog" class="w-100">
												</div>
											</div>
										<?php }  ?>
										</div>

										<div class="thumb-next thumb-nav"><i class="fa-solid fa-angle-right"></i></div>
										<div class="thumb-prev thumb-nav"><i class="fa-solid fa-angle-left"></i></div>

									</div>
									<div class="blog__content">
										<h2><?php echo $story->title;?></h2>
										<ul class="blog__date">
											<li><span><i class="fa-solid fa-calendar-days"></i><?= date_format(date_create($story->post_time),"d, F Y")?></span></li>
										</ul>
										<p><?php echo $story->description;?></p>
										
										<?php if(!empty($story_videos)){
											foreach($story_videos as $story_video ){?>

										<div class="blog__thumb mb-4">
											<?php if($story_video->type == 'upload'){?>
						                        <video controls height="450" width="80%">
						                            <source src="<?php echo base_url();?><?php echo $story_video->video_src;?>">
						                        </video>
						                    <?php }else{?>
						                        <iframe controls="2" height="450" width="80%"
						                            src="<?php echo $story_video->video_link;?>" frameborder="0" >
						                        </iframe>
						                    <?php }?>
										</div>
									<?php } } ?>
									</div>
								<?php } } ?>
								</div>
							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- ================> Blog section end here <================== -->