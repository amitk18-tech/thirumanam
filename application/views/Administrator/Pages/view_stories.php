
 
<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}

?>

<div class="row">
    <div class="col-xl-1">
    </div>
    <div class="col-xl-10">
    <div class="card">
        <div class="card-header align-items-center d-flex">

        </div><!-- end card header -->

        <div class="card-body">

            <div class="live-preview">
                <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></li>
                        <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" class="active" aria-current="true"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">

                         <?php 
                         // print_r($story);exit;
                        $images = json_decode($story->image);
                        // print_r($stories);exit;
                          
                        $i=0;
                        foreach($images as $image){ $i++; ?>
                        <div class="carousel-item <?php echo($i==1)?'active':'';?>">
                            <img class="d-block img-fluid mx-auto" src="<?php echo base_url('uploads/happy_story_image/'.$image->img);?>" alt="Second slide">
                        </div>
                        <?php ($i==3)? $i=0 :'' ?>
                        <?php }  ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" style="color:green;" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div><br>
            <p><?php echo translate('posted_by')?> <?php echo $story->first_name;?></p>
            <p><?php echo translate('post_time:')?> <?php echo date('H:i:sa',strtotime($story->post_time));?></p>
            <p><?php echo translate('description')?>: <?php echo $story->description;?></p>
            <!-- Ratio Video 16:9 -->
            <div class="ratio ratio-16x9">
                <iframe src="<?php echo $story->video_src;?>" title="YouTube video" allowfullscreen></iframe>
            </div>
        </div><!-- end card-body -->
    </div><!-- end card -->
</div>
<!--end col-->
</div>


