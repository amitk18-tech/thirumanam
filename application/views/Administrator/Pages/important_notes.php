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
                    <form action="<?php echo base_url('AdminController/updateNote')?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="basiInput" class="form-label"><?php echo translate('english') .' '. translate('Information_Page')?>: </label>
                                    <textarea name="msg" class="form-control" placeholder="<?=translate('message')?>" data-role="tagsinput" required><?php echo ($message->msg!="") ? $message->msg: "";?></textarea>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="labelInput" class="form-label"><?php echo translate('tamil') .' '. translate('Information_Page')?>: </label>
                                    <textarea type="text" class="form-control" placeholder="<?=translate('message')?>" name="tamil_msg" required><?php echo ($message->tamil_msg!="") ? $message->tamil_msg: "";?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border mb-3"><?=translate('save')?></button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-6">                                      
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="" style="    font-size: 19px;background-color: #80808014;width: 100%;padding: 11px;"><b><?php echo translate('english')." ". translate('message')?></b></label>
                                <div class="col-sm-12" style="padding: 15px">
                                    <marquee><p><?php echo ($message->msg!="") ? $message->msg: "";?></p></marquee>
                                </div>
                            </div>                               
                        </div>
                        <div class="col-md-6">                                      
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="" style="    font-size: 19px;background-color: #80808014;width: 100%;padding: 11px;"><b><?php echo translate('tamil')." ".translate('message')?></b></label>
                                <div class="col-sm-12" style="padding: 15px">
                                    <marquee><p><?php echo ($message->tamil_msg!="") ? $message->tamil_msg: "";?></p></marquee>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

