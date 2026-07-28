<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>
<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo base_url('administrator/all_staffs');?>" class="btn btn-danger btn-icon btn-sm waves-effect waves-light mb-3"><i class="ri-arrow-left-line"></i></a>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"></h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updateStaff/'.$admin->admin_id);?>" method="post">
                    <div class="row gy-4">
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="basiInput" class="form-label"><?= translate('name')?><i class="text-danger">*</i> </label>
                                <input type="text" class="form-control" id="basiInput" value="<?php echo $admin->name;?>" name="name" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="labelInput" class="form-label"><?= translate('email')?><i class="text-danger">*</i> </label>
                                <input type="email" class="form-control" id="labelInput" value="<?php echo $admin->email;?>" name="email" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="placeholderInput" class="form-label"><?= translate('phone_no.')?><i class="text-danger">*</i> 
                                  </label>
                                <input type="text" class="form-control" id="placeholderInput" placeholder="Placeholder" value="<?php echo $admin->phone;?>" name="phone" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label"><?= translate('address')?> </label>
                                <input type="text" class="form-control" id="valueInput" value="<?php echo $admin->address;?>" name="address">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="readonlyPlaintext" class="form-label"><?= translate('role')?><i class="text-danger">*</i> </label>
                                <select class="form-select mb-3" aria-label="Default select example" name="role" required>
                                    <option value=""><?= translate('choose_one')?></option>
                                    <?php
                                    if(!empty($roles)){
                                        foreach($roles as $role){?>
                                            <option <?php echo ($admin->role==$role->role_id) ? 'selected' : ""?> value="<?php echo $role->role_id?>"><?php echo $role->name;?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 text-center">
                               
                        </div>
                        <div class="col-xxl-3 col-md-12 text-center">
                               <button type="submit" class="btn btn-xs btn-outline-success btn-border"><?= translate('update')?></button>
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