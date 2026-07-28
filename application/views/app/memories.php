<?php 

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

?>

<style>
  .catagory-card a::after {

    opacity: 0.1;
  }
  .catagory-slides {
    margin-left: 0px;
  }
</style>
<div class="page-content-wrapper">
      <!-- Top Catagories Wrapper-->
      <div class="top-catagories-wrapper">
        <div class="bg-shapes">
          <div class="shape1"></div>
          <div class="shape2"></div>
          <div class="shape3"></div>
          <div class="shape4"></div>
          <div class="shape5"></div>
        </div>
        <!-- <h6 class="mb-3 catagory-title">Top Catagories</h6> -->
        <div class="container">
          <!-- Catagory Slides-->
          <div class="catagory-slides owl-carousel">
            <!-- Catagory Card-->
            <?php
                if (!empty($memories)) {
                    // print_r($memories);exit;
                    foreach ($memories as $value) {?>
            <div class="card catagory-card"><a><img style="width: 100%;height: 10em;object-fit: cover;" src="<?php echo base_url('uploads/memories/'.$value->name)?>"  alt="">
                <h6><?php echo date('d-M-Y', strtotime($value->created_date))?></h6></a></div>
              <?php }  }?>
            <!-- Catagory Card-->
            
        </div>
      </div>
    </div>
      <!-- All Catagory Wrapper-->
      <div class="all-catagory-wrapper">
        <div class="container">
          <!-- <h5 class="mb-3 newsten-title">All Catagory</h5> -->
        </div>
        <div class="container">
          <div class="row">
            <!-- Catagory Card-->
             <?php
                if (!empty($memories)) {
                    // print_r($memories);exit;
                    foreach ($memories as $value) {?>
            <div class="col-6 col-sm-4">
              <div class="card catagory-card mb-3"><a><img style="width: 100%;height: 10em;object-fit: contain;" src="<?php echo base_url('uploads/memories/'.$value->name)?>" alt="">
                  <h6><?php echo date('d-M-Y', strtotime($value->created_date))?></h6></a></div>
            </div>
          <?php } } ?>
            <!-- Catagory Card-->
            
          </div>
        </div>
      </div>
    </div>