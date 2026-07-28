<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>
<style>
    [data-layout=vertical][data-sidebar=dark] .navbar-nav .nav-link {

        color: #a3a6b7 !important;
        }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"></h4>
                
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    
                        <div class="row gy-4">
                            
                            <form id="myForm" action="<?php echo base_url('AdminController/updateEmailTemplate/'.$template->id)?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $template->id;?>">
                                
                                <div class="col-xxl-3 col-md-12 mb-3">
                                    <label><?php echo translate('name');?></label>
                                    <select class="form-control" name="name" id="name" required>
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <option value="Renewed" <?php echo ($template->temp_name == 'Renewed' ? 'selected' : "")?>>Renew Template</option>
                                    <option value="Activated" <?php echo ($template->temp_name == 'Activated' ? 'selected' : "")?>>Activated Template</option>
                                    <option value="Expired" <?php echo ($template->temp_name == 'Expired' ? 'selected' : "")?>>Expiry Template</option>
                                </select>
                                </div>
                                <div class="col-xxl-3 col-md-12 mb-3">
                                    <label><?php echo translate('subject');?></label>
                                    <textarea class="form-control" name="subject"><?php echo $template->subject;?></textarea>
                                </div>
                               
                                <div class="col-xxl-3 col-md-12 mb-5">
                                     <label><?php echo translate('email_template');?></label>
                                    <div id="edit" contenteditable><?php echo $template->template;?></div> 
                                </div>
                                <input type="hidden" name="description" id="p">
                                <div class="col-md-12 text-center mt-5">
                                    <button type="submit" class="btn btn-sm btn-outline-primary btn-border"><?php echo translate('update')?></button>
                                    
                                </div>
                            </form>
                            
                            
                            
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   
    $('button').click(function () {
        // $("#edit :input").attr("hidden", true);
        // $(".snow-editor").attr("contenteditable", false);
        // $(".snow-clipboard").attr("contenteditable", false);
        // $(".ql-editor").attr("contenteditable", false);
        var txt = $('#edit').html();
                $('#p').val(txt);
                // alert(txt);
        
    })

    
</script>