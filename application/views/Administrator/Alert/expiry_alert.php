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
                <h4 class="card-title mb-0 flex-grow-1"></h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/sendAlert')?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="basiInput" class="form-label"><?php echo translate('select_members')?>: </label>
                                    <select name="members[]" class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple required>
                                        <option value="">Please select</option>
                                       <?php foreach($members as $member){
                                         // print_r($member);exit;
                                        if(!empty($member->first_name)){?>
                                        <option value="<?php echo $member->member_id;?>"><?php echo $member->first_name;?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="labelInput" class="form-label"><?php echo translate('message_type')?></label>
                                    <select name="type[]" class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple required>
                                        <option value="">Please select</option>
                                       <option value="1">SMS</option>
                                       <option value="2">Mail</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
