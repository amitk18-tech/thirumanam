<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><?php echo translate('manage_details')?></h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updateadmin/'.$admin->admin_id)?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                   <label class="form-label" for="name"><b><?php echo translate('name')?> <span class="text-danger">*</span></b></label>
                                    <input type="text" class="form-control" name="name" value="<?php echo $admin->name;?>" placeholder="Your Name" required=>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label class="form-label" for="email"><b><?php echo translate('email')?> <span class="text-danger">*</span></b></label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $admin->email;?>" placeholder="Your Email Address" required>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                   <label class="form-label" for="phone"><b><?php echo translate('phone')?></b></label>
                                    <input type="text" class="form-control" name="phone" value="<?php echo $admin->phone;?>" placeholder="Your Phone Number">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label class="form-label" for="address"><b><?php echo translate('address')?></b></label>
                                    <input type="text" class="form-control" name="address" value="<?php echo $admin->address;?>" placeholder="Your Address">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border mb-3"><?php echo translate('update')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updatePassword/'.$admin->admin_id)?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                   <label class="form-label" for="current_password"><b><?php echo translate('current_password')?> <span class="text-danger">*</span></b></label>
                                    <input type="password" class="form-control" name="current_password" id="current_password" value="" placeholder="<?php echo translate('your_current_password')?>" required="">
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label class="form-label" for="new_password"><b><?php echo translate('new_password')?> <span class="text-danger">*</span></b></label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" value="" placeholder="<?php echo translate('your_new_password')?>" required="">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label class="form-label" for="confirm_password"><b><?php echo translate('confirm_password')?> <span class="text-danger">*</span></b></label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" placeholder="<?php echo translate('confirm_password')?>" required="">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border mb-3"><?php echo translate('update')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><?php echo translate('admin_login_background')?></h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updateloginImage/')?>" method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <?php
                        $image = json_decode($admin_login_image->value);
                        foreach($image as $img){?>
                        <div class="col-sm-12">
                            <figure class="figure mb-0">
                                <img src="<?php echo base_url('uploads/admin_login_image/'.$img->image);?>" class="figure-img img-fluid rounded" alt="...">
                            </figure>
                        </div>
                        <?php } ?>
                         <div class="col-sm-12">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-sm btn-outline-primary btn-border mb-3"><?php echo translate('update')?></button>
                        </div>
                    </div>
                </form>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"><?php echo translate('admin_forget_password_background')?></h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updateForgetImage/')?>" method="post" enctype="multipart/form-data">
                    <div class="row g-3">
                        <?php
                        $image = json_decode($forget_pass_image->value);
                        foreach($image as $img){?>
                        <div class="col-sm-12">
                            <figure class="figure mb-0">
                                <img src="<?php echo base_url('uploads/forget_pass_image/'.$img->image);?>" class="figure-img img-fluid rounded" alt="...">
                            </figure>
                        </div>

                        <?php } ?>
                         <div class="col-sm-12">
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-sm btn-outline-primary btn-border mb-3"><?php echo translate('update')?></button>
                        </div>
                    </div>
                </form>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
<div class="row">

    <?php 

    if($admin->role==1){ ?> 
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updateAdminPassword/'.$admin->admin_id)?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                   <label class="form-label" for="current_password"><b><?php echo translate('all_staffs')?> <span class="text-danger">*</span></b></label>
                                    <select class="form-control" name="admin">
                                        <option value=""><?php echo translate('choose_one');?></option>
                                        <?php if(!empty($all_admins)){
                                            foreach($all_admins as $all_admin){?>

                                                <option value="<?php echo $all_admin->admin_id ?>"><?php echo $all_admin->name;?></option>

                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label class="form-label" for="new_password"><b><?php echo translate('new_password')?> <span class="text-danger">*</span></b></label>
                                    <input type="password" class="form-control" name="new_password" id="new_password" value="" placeholder="<?php echo translate('your_new_password')?>" required="">
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label class="form-label" for="confirm_password"><b><?php echo translate('confirm_password')?> <span class="text-danger">*</span></b></label>
                                    <input type="password" class="form-control" name="confirm_password" id="confirm_password" value="" placeholder="<?php echo translate('confirm_password')?>" required="">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border mb-3"><?php echo translate('update')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


   <?php } ?>
    
 </div>

