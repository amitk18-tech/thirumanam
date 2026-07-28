<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>
<div class="row">
    <div class="col-lg-12">
        <a href="<?php echo base_url('administrator/manage_role');?>" class="btn btn-danger btn-icon btn-sm waves-effect waves-light mb-3"><i class="ri-arrow-left-line"></i></a>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"></h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/updateRole/'.$admin['role_id']);?>" method="post">
                    <div class="row gy-4">
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="basiInput" class="form-label"><?php echo translate('name')?><i class="text-danger">*</i> </label>
                                <input type="text" class="form-control" id="basiInput" value="<?php echo $admin['name'];?>" name="name" required>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="basiInput" class="form-label"><?php echo translate('description')?> </label>
                                <textarea type="text" class="form-control" id="basiInput" name="description"><?php echo $admin['description'];?></textarea>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="labelInput" class="form-label"><?php echo translate('role')?> </label>
                                <select class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="permission[]" multiple>
                                    <option value="" ><?php echo translate('choose_one')?></option>
                                    <?php if(!empty($permissions)){
                                        $roles = json_decode($admin['permission']);
                                        foreach($permissions as $permission){ 
                                            ?>

                                    <option <?php echo (in_array($permission['permission_id'],$roles)) ? 'selected' : "";?> value="<?php echo $permission['permission_id'];?>"><?php echo $permission['codename'];?></option> 
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                       
                        <div class="col-xxl-3 col-md-12 text-center">
                               <button type="submit" class="btn btn-xs btn-outline-success btn-border"><?php echo translate('update')?></button>
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