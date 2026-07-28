
<style>
.main-wrapper{
  max-width: 1440px;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  height: 50vh;
}
.slider-wrapper{
  width: 100%;
  height: 500px;
  display: flex;
  align-items: center;
  position: relative;
  margin: auto;
  overflow: hidden;
}

.slides{
  width: 100%;
  position: absolute;
  transition: transform .4s ease-in-out;
}
.slides h1{
  
  position: relative;
  top: 5rem;
  left: 1rem;
  backdrop-filter: blur(7px);
  width: 9rem;
  padding: 1rem;

}
.slides img{
  width: 100%;
  object-fit: cover;
  border-radius: .3rem;
}
.slider-btns{
  position: absolute;
  top: 40%;
  z-index: 2;
  width: 100;
  width: 50%;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.slider-btns span{
  padding: 1rem 1.2rem;
  font-size: 1.5rem;
  background: rgba(255, 255, 255, 0.151);
  border-radius: 50%;
  color: white;
  cursor: pointer;
}
.dots{
  position: absolute;
  width: 100%;
  top: 85%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .5rem;
  z-index: 1;
}

.dots .dot{
  width: 1rem;
  height: 1rem;
  background-color: white;
  opacity: .2;
  border-radius: 50%;
  transition: opacity .2s ease-in-out;
  cursor: pointer;
}

@media screen and (max-width:950px) {
  .slider-wrapper{
    width: 100%;
  }
  .slider-btns{
    top: 42%;
  }
  .dots{
    top: 80%;
  }
}

@media screen and (max-width:400px) {
  .slider-wrapper{
    width: 100%;
  }
  .slider-btns{
    top: 60%;
  }
  .dots{
    top: 65%;
  }
}
@media screen and (min-width:400px) and (max-width:500px){
  .slider-wrapper{
    width: 100%;
  }
  .slider-btns{
    top: 50%;
  }
  .dots{
    top: 65%;
  }
}
  </style>
<style>
    .first_name{
    font-size: 15px;
    }

@media (max-width: 820px){
  
    .first_name{
    font-size: 15px;
    }
    .card-footer{
    height: 11em !important;
    }

    
   
  }


@media (max-width: 620px){
 
  .card-footer{
    height: 11em !important;
    }
  .img-slider .slide img{
    height: 250px;
    }
  .first_name{
    font-size: 10px;
}
}

@media (max-width: 420px){
  
  .card-footer{
    height: 11em !important;
    }
  .first_name{
    font-size: 14px;
}

}
</style>

<div class="main-wrapper">
    <div class="slider-btns">
      <span id="prev-btn"><i class="fa-solid fa-chevron-left"></i></span>
      <span id="next-btn"><i class="fa-solid fa-angle-right"></i></span>
    </div>
    <div class="slider-wrapper">
      <div class="dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>

      </div>
      <div class="slides">
        <img src="<?php echo base_url('assets/front');?>/images/ragi/01.jpg" alt="">
      </div>
      <div class="slides">
        <img src="<?php echo base_url('assets/front');?>/images/ragi/02.jpg" alt="">
      </div>
      <!-- <div class="slides">
        <img src="<?php echo base_url('assets/front');?>/images/ragi/03.jpg" alt="">
      </div> -->
    </div>
</div>










<section class="pt-5 pb-5">
<div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="mb-3"><?php echo translate('members')?></h3>
            </div>
            <div class="col-12 text-right">
                <a class="btn btn-info mb-3 mr-1" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <a class="btn btn-info mb-3 " href="#carouselExampleIndicators3" role="button" data-slide="next">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </div>
            <div class="col-12">
                <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        <?php if(!empty($premium_members)){ 
                            $i=0;?>
                        <?php foreach ($premium_members as $premium_member){
                            $i++;
                        $image = json_decode($premium_member->profile_image, true); 
                        $following = json_decode($premium_member->followed, true);
                       ?>
                       <?php if($i==1){?>
                        <div class="carousel-item active">
                            <div class="row">
                        <?php } ?>
                        <?php if($i==5){?>
                        <div class="carousel-item">
                            <div class="row">
                        <?php } ?>
                        <?php if($i==9){?>
                        <div class="carousel-item">
                            <div class="row">
                        <?php } ?>
                            

                                <div class="col-md-3 mb-3 col-6">
                                    <div class="card">
                                        <div class="card-body">

                                        <?php  if (file_exists('uploads/profile_image/'.$image[0]['profile_image'])) { ?>
                                            <a <?php echo (($this->session->userdata('thirumanam_logged_data')) ? 'href="'.base_url('short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"')?>><img src="<?php echo base_url('uploads/profile_image/'.$image[0]['profile_image']);?>" alt="dating thumb" style="width: 100%;height: 140px;object-fit: contain;"></a>
                                        <?php } else{?>
                                            <a <?php echo (($this->session->userdata('thirumanam_logged_data')) ? 'href="'.base_url('short_view/'.$premium_member->member_id).'"' :'data-bs-toggle="modal" href="#exampleModalToggle" role="button"')?>><img src="<?php echo (($premium_member->gender==1) ? base_url('uploads/profile_image/default.jpg') : base_url('uploads/profile_image/default_female.jpg')) ;?>" alt="dating thumb"style="width: 100%;height: 150px;object-fit: contain;"></a>
                                        <?php } ?>
                                        
                                        </div>
                                        <div class="card-footer">
                                            
                                            <h6 style="font-size:11px" class="card-title first_name"><?php echo (strlen($premium_member->first_name)>60) ? substr($premium_member->first_name, 0,60).' ..' : $premium_member->first_name; ?></h6>

                                            <p style="font-size: 12px;margin-bottom: 10px"><?php echo $premium_member->follower;?> <?=translate('follower(s)')?></p>
                                            <p style="font-size: 12px;margin-bottom: 10px"><?php echo count($following);?> <?=translate('following')?></p>
                                            <span style="background: #f24570;border-radius: 10px;padding-bottom: 5px;"><?php if($this->session->userdata('thirumanam_logged_data')){?>
                                               <a style="font-size:11px;color: white;padding: 20px;" href="<?php echo base_url('short_view/'.$premium_member->member_id);?>"><?=translate('full_profile')?></a>
                                            <?php }else{ ?>
                                                <a style="font-size:11px;color: white;padding: 20px;" data-bs-toggle="modal" href="#exampleModalToggle" role="button"><?=translate('full_profile')?></a>
                                            <?php }?></span>
                                            
                                            

                                        </div>

                                    </div>
                                </div>

                            
                            <?php if($i==4){?>
                        </div></div>
                    <?php } ?>
                        <?php if($i==8){?>
                        </div></div>
                    <?php } ?>
                        <?php if($i==13){ $i=4;?>
                        </div></div>
                    <?php } } }?>
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</section>
    <!-- ================> Member section end here <================== -->


    <!-- ================> About section start here <================== -->
    <div class="about about--style4 padding-top padding-bottom bg_img" style="background-image: url(<?php echo base_url('assets/front/');?>images/bg-img/02.jpg);">
        <div class="container">
            <div class="section__header style-2 text-center wow fadeInUp" data-wow-duration="1.5s">
                <!-- <h2>It All Starts With A Date</h2>
                <p>Learn from them and try to make it to this board. This will for sure boost you visibility and increase your chances to find you loved one.</p> -->
            </div>
            <div class="section__wrapper">
                <div class="row g-4 justify-content-center row-cols-xl-4 row-cols-lg-3 row-cols-sm-2 row-cols-1 wow fadeInUp" data-wow-duration="1.5s">
                    <div class="col">
                        <div class="about__item text-center">
                            <div class="about__inner" style="height: 372px;">
                                <div class="about__thumb">
                                    <img src="<?php echo base_url('assets/front/');?>images/about/icon/home3/01.png" alt="dating thumb">
                                </div>
                                <div class="about__content">
                                    <h3><span class="counter" data-to="<?php echo $all_member_count;?>" data-speed="1500"></span></h3>
                                    <p><?=translate('total_members')?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="about__item text-center">
                            <div class="about__inner"  style="height: 372px;">
                                <div class="about__thumb">
                                    <img src="<?php echo base_url('assets/front/');?>images/about/icon/home3/02.png" alt="dating thumb">
                                </div>
                                <div class="about__content">
                                    <h3><span class="counter" data-to="<?php echo $Online_members_datas;?>" data-speed="1500"></span></h3>
                                    <p><?=translate('OnlineRegisteredMembers')?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="about__item text-center">
                            <div class="about__inner"  style="height: 372px;">
                                <div class="about__thumb">
                                    <img src="<?php echo base_url('assets/front/');?>images/about/icon/home3/03.png" alt="dating thumb">
                                </div>
                                <div class="about__content">
                                    <h3><span class="counter" data-to="<?php echo $Online_male_datas;?>" data-speed="1500"></span></h3>
                                    <p><?=translate('male')?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="about__item text-center">
                            <div class="about__inner"  style="height: 372px;">
                                <div class="about__thumb">
                                    <img src="<?php echo base_url('assets/front/');?>images/about/icon/home3/04.png" alt="dating thumb">
                                </div>
                                <div class="about__content">
                                    <h3><span class="counter" data-to="<?php echo $Online_females_datas ;?>" data-speed="1500"></span></h3>
                                    <p><?=translate('female')?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================> About section end here <================== -->


    <!-- ================> Meet section start here <================== -->
    
    <!-- ================> Meet section end here <================== -->


    <!-- ================> Work section start here <================== -->
    <div class="work padding-top padding-bottom bg_img" style="background-image: url(<?php echo base_url('assets/front/');?>images/bg-img/01.jpg);">
        <div class="container">
            <div class="section__header text-center wow fadeInUp" data-wow-duration="1.5s">
                <!-- <h2>Why Choose Ollya</h2> -->
            </div>
            <div class="section__wrapper wow fadeInUp" data-wow-duration="1.5s">
                <div class="d-xl-flex align-items-start work__area">
                    <div class="nav flex-xl-column nav-pills me-xl-4 work__tablist" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="work__tab1-tab" data-bs-toggle="pill" data-bs-target="#work__tab1" type="button" role="tab" aria-controls="work__tab1" aria-selected="true"><img src="<?php echo base_url('assets/front/');?>images/work/01.png" alt="dating thumb" class="me-3"><span><?php echo  translate('about_us');?></span></button>
                        <button class="nav-link" id="work__tab2-tab" data-bs-toggle="pill" data-bs-target="#work__tab2" type="button" role="tab" aria-controls="work__tab2" aria-selected="false"><img src="<?php echo base_url('assets/front/');?>images/work/02.png" alt="dating thumb" class="me-3"><span ><?php echo  translate('what_we_do');?></span></button>
                        <button class="nav-link" id="work__tab3-tab" data-bs-toggle="pill" data-bs-target="#work__tab3" type="button" role="tab" aria-controls="work__tab3" aria-selected="false"><img src="<?php echo base_url('assets/front/');?>images/work/03.png" alt="dating thumb" class="me-3"><span><?php echo  translate('service_information');?></span></button>
                        <button class="nav-link" id="work__tab4-tab" data-bs-toggle="pill" data-bs-target="#work__tab4" type="button" role="tab" aria-controls="work__tab4" aria-selected="false"><img src="<?php echo base_url('assets/front/');?>images/work/04.png" alt="dating thumb" class="me-3"><span><?php echo  translate('other_service');?></span></button>
                        <button class="nav-link" id="work__tab5-tab" data-bs-toggle="pill" data-bs-target="#work__tab5" type="button" role="tab" aria-controls="work__tab5" aria-selected="false"><img src="<?php echo base_url('assets/front/');?>images/work/04.png" alt="dating thumb" class="me-3"><span><?php echo  translate('suyamvaram');?></span></button>
                    </div>
                    <div class="tab-content work__tabcontent" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="work__tab1" role="tabpanel" aria-labelledby="work__tab1-tab">
                            <div class="work__item">
                                <div class="work__inner">
                                    <div class="work__thumb">
                                        <img src="<?php echo base_url('uploads/parallax_image/about-us.png');?>" alt="dating thumb">
                                    </div>
                                    <div class="work__content">
                                        <p><?php echo  translate('abouttab1');?></p>
                                        <p><?php echo  translate('abouttab2');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="work__tab2" role="tabpanel" aria-labelledby="work__tab2-tab">
                            <div class="work__item">
                                <div class="work__inner">
                                    <div class="work__thumb">
                                        <img src="<?php echo base_url('uploads/parallax_image/what-we-do.png');?>" alt="dating thumb">
                                    </div>
                                    <div class="work__content">
                                        <p><?php echo  translate('whatwedotab');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="work__tab3" role="tabpanel" aria-labelledby="work__tab3-tab">
                            <div class="work__item">
                                <div class="work__inner">
                                    <div class="work__thumb">
                                        <img src="<?php echo base_url('uploads/parallax_image/Service-information.png');?>" alt="dating thumb">
                                    </div>
                                    <div class="work__content">
                                        <p><?php echo  translate('service');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="work__tab4" role="tabpanel" aria-labelledby="work__tab4-tab">
                            <div class="work__item">
                                <div class="work__inner">
                                    <div class="work__thumb">
                                        <img src="<?php echo base_url('uploads/parallax_image/other-service.png');?>" alt="dating thumb">
                                    </div>
                                    <div class="work__content">
                                        <p><?php echo  translate('otherService');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="work__tab5" role="tabpanel" aria-labelledby="work__tab5-tab">
                            <div class="work__item">
                                <div class="work__inner">
                                    <div class="work__thumb">
                                        <img src="<?php echo base_url('uploads/parallax_image/Swayamvaram.png');?>" alt="dating thumb">
                                    </div>
                                    <div class="work__content">
                                        <p><?php echo  translate('suyamvaramTab');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ================> Work section end here <================== -->
<div class="app app--style2 padding-top padding-bottom">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-xxl-6 col-12">
                    <div class="app__item wow fadeInUp" data-wow-duration="1.5s">
                        <div class="app__inner">
                            <div class="app__content text-center">
                               <h4><?php echo translate('easy_conect')?></h4>
                                <h3><?php echo translate('download_app')?></h3>
                                <ul class="justify-content-center">
                                    <li><a href="#"><img src="<?php echo base_url('assets/front')?>/images/app/02.jpg" alt="dating thumb"></a></li>
                                     <!-- <li><a href="#"><img style="width: 100%;height: 15em;" src="<?php echo base_url('assets/front')?>/images/app/thirumanam_app.png" alt="dating thumb"></a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-12 wow fadeInUp" data-wow-duration="1.5s">
                    <div class="app__item">
                        <div class="app__inner">
                            <div class="app__thumb">
                                <img src="<?php echo base_url('assets/front')?>/images/app/thirumanam_app.png" alt="dating thumb">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ================> Story section start here <================== -->
    <div class="story padding-top padding-bottom">
        <div class="container">
            <div class="section__header style-2 text-center wow fadeInUp" data-wow-duration="1.5s">
                <h2><?php echo translate('contact_information ')?></h2>
                
            </div>

            <div class="section__wrapper wow fadeInUp" data-wow-duration="2s">
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="footer__content">

                            <p><i class="fas fa-map-marker-alt"></i> <?=translate('address2') ?></p>
                            <p><i class="fas fa-phone-alt"></i> <b><?php echo translate('phone') ;?></b>: (+91) 94878 33674 / (+91) 98942 78185 </p>
                            <p><i class="fas fa-envelope"></i> service@thirumanam.info</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div style="width: 100%;">
                           <iframe style="width:100%;height: 300px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7167.2879293178685!2d78.14167178799589!3d11.623953467429658!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDM3JzI4LjYiTiA3OMKwMDgnNDIuMCJF!5e0!3m2!1sen!2sin!4v1591188739729!5m2!1sen!2sin" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-center mt-5 wow fadeInUp" data-wow-duration="2s">
                            <a href="<?php echo base_url();?>contact" class="default-btn"><span><?php echo translate('contact_us')?></span></a>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
    </div>
    <!-- ================> Story section end here <================== -->

<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalToggleLabel"><?php echo translate('login');?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo translate('please_login_to_view_full_profile_of_this_member');?>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="<?php echo base_url('login');?>"><?php echo translate('login');?></a>
      </div>
    </div>
  </div>
</div>

    <!-- ================> Work section start here <================== -->
    
    <!-- ================> Work section end here <================== -->
<script>
const slides = document.querySelectorAll('.slides');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const dots = document.querySelectorAll('.dot')


let index = 0;

// Adding opacity to first dot on first time

dots[0].style.opacity='1'

// positioning the slides

slides.forEach((slide,index)=>{
  slide.style.left=`${index*100}%`
});


// move slide function

const moveSlide = () =>{
  slides.forEach((slide)=>{
    slide.style.transform=`translateX(-${index*100}%)`;
  });
}

// remove dots opacity 1 from all dots

const removeDotsOpacity = () =>{
  dots.forEach((dot)=>{
    dot.style.opacity='.2';
  });
}

dots.forEach((dot,i)=>{
  dot.addEventListener("click",(e)=>{
    index=i;
    removeDotsOpacity();
    e.target.style.opacity='1'
    moveSlide();
  })
});

// show the previous slide

prevBtn.addEventListener('click',()=>{
  if(index===0) return index;
  index--;
  removeDotsOpacity();
  dots[index].style.opacity='1'
  moveSlide();
});

// show the next slide

nextBtn.addEventListener('click',()=>{
  if(index===slides.length-1) return index;
  index++;
  removeDotsOpacity();
  dots[index].style.opacity='1'
  moveSlide();
});

// auto play slide

const autoPlaySlide = () =>{
  removeDotsOpacity();
  if(index===slides.length-1) index= -1;
  index++;
  dots[index].style.opacity='1'
  moveSlide();
}

window.onload=()=>{
  setInterval(autoPlaySlide,6000);
}
</script>