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
                    <form action="<?php echo base_url('AdminController/sendUserSms')?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="basiInput" class="form-label"><?php echo translate('select_members')?> </label>
                                    <select class="form-control" name="member" required="">
                                        <option class="form-control" value="all"><?php echo translate('all_members')?></option>
                                        <option class="form-control" value="online"><?php echo translate('online_member')?></option>
                                        <option class="form-control" value="offline"><?php echo translate('offline_member')?></option>
                                        <option class="form-control" value="test"><?php echo translate('Test_message')?></option>
                                    </select>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="labelInput" class="form-label"><?php echo translate('message')?></label>
                                    <textarea placeholder="Message" rows="10" name="msg" class="form-control" required=""></textarea>
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
