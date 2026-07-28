<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>
<div class="row">
    <div class="col-12">
        <div class="text-end">
            <a href="<?php echo base_url('administrator/add_plan')?>" class="btn btn-outline-success btn-border btn-sm mb-4">Add Plan</a>
        </div>
        <div class="row">
            <?php
            if(!empty($plans)){
                foreach($plans as $plan){
                    $images = json_decode($plan->image);
                    foreach($images as $image){
            ?>
            <div class="col-xxl-4 col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <a href="<?php echo base_url("AdminController/deletePlan/".$plan->plan_id);?>"type="button" onclick="return confirm('Are You Sure Want To Delete This');" class="btn-close float-end fs-11" aria-label="Close"></a>
                        <h6 class="card-title mb-0"><?php echo $plan->name;?></h6>
                    </div>
                    <div class="card-body p-4 text-center">
                        <div class="mx-auto avatar-md mb-3">
                            <img src="<?php echo base_url('uploads/plan_image/'.$image->image);?>" alt="" class="img-fluid rounded-circle">
                        </div>
                        <h5 class="card-title mb-1">₹ <?php echo $plan->amount;?></h5>
                        <p class="text-muted text-center mb-0"><?php echo translate('express_interest:')?> <?php echo $plan->express_interest;?> <?php echo translate('times')?></p>
                        <p class="text-muted text-center mb-0"><?php echo translate('direct_messages:')?> <?php echo $plan->direct_messages;?> <?php echo translate('times')?></p>
                        <p class="text-muted text-center mb-0"><?php echo translate('photo_gallery:')?>: <?php echo $plan->photo_gallery;?> <?php echo translate('images')?></p>
                    </div>
                    <div class="card-footer text-center">
                        <ul class="list-inline mb-0">
                          <a href="<?php echo base_url('administrator/edit_plan/'.$plan->plan_id)?>" class="btn btn-outline-primary btn-border btn-sm"><?php echo translate('edit')?></a>
                        </ul>
                    </div>
                </div>
            </div><!-- end col -->
        <?php } } }?>
        </div><!-- end row -->
    </div><!-- end col -->
</div><!-- end row -->