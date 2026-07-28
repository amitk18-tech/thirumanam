<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form method="post" action="<?php echo base_url('AdminController/savePlan');?>" enctype="multipart/form-data">
                    <div class="row gy-4">
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="basiInput" class="form-label"><?php echo translate('package_name')?></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="labelInput" class="form-label"><?php echo translate('online_member_payment')?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?=currency('', 'def')?></span>
                                    <input type="text" class="form-control" name="amount" required>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="placeholderInput" class="form-label"><?php echo translate('offline_member_payment')?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?=currency('', 'def')?></span>
                                    <input type="text" class="form-control" name="offline_amount" required>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label"><?php echo translate('express_interest')?></label>
                                <input type="text" class="form-control" name="express_interest">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="readonlyInput" class="form-label"><?php echo translate('direct_messages')?></label>
                                <input type="text" class="form-control" name="direct_messages">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="disabledInput" class="form-label"><?php echo translate('photo_gallery')?></label>
                                <input type="text" class="form-control" name="photo_gallery">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="disabledInput" class="form-label"><?php echo translate('tamil')?> <?php echo translate('info')?></label>
                                <input type="text" class="form-control" name="tamil_info">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="disabledInput" class="form-label"><?php echo translate('english')?> <?php echo translate('info')?></label>
                                <input type="text" class="form-control" name="english_info">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-3">
                            <div>
                                <div class="form-group">
                                    <label for="pimage"><?php echo translate('package_image')?></label>
                                    <input type="file" name="image" class="form-control"onchange="document.getElementById('pimage_preview').src = window.URL.createObjectURL(this.files[0])">
                                 </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-3">
                            <div>
                                <div class="form-group">                        
                                    <img src="<?php echo base_url('uploads/plan_image/plan_1.png'); ?>" id="pimage_preview" height="150" width="150">
                                    <input type="hidden" name="images" value="plan_1.png">   
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-12 text-center">
                            <div>
                                <a href="<?php  echo base_url('administrator/membership_plans');?>" class="btn btn-outline-danger btn-border btn-sm"><?php echo translate('go_back')?></a>
                                <button type="submit" class="btn btn-outline-primary btn-border btn-sm"><?php echo translate('submit')?></button>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </form>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
