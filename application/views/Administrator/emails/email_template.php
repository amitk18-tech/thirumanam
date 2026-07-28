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
                    <form action="<?php echo base_url('AdminController/addEmailTemplate')?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12 mb-3">
                                <label><?= translate('name')?></label>
                                <select class="form-control" name="name" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option value="Renewed">Renew Template</option>
                                    <option value="Activated">Activated Template</option>
                                    <option value="Expired">Expiry Template</option>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-md-12 mb-3">
                                <label><?php echo translate('subject');?></label>
                                <textarea class="form-control" name="subject"></textarea>
                            </div>
                            <div class="col-xxl-3 col-md-12 mb-3">
                                    <label><?php echo translate('html_code');?></label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            
                            
                            <div class="col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border"><?php echo translate('save')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

   

</script>