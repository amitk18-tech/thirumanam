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
                    <form action="<?php echo base_url('AdminController/updateTermsCondition')?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12 mb-5">
                                <label><?= translate('description')?></label>
                                <div id="edit" class="snow-editor"><?=translate('terms_condition1')?></div> 
                            </div>
                            <input type="hidden" id="p" name="description">
                            
                            <div class="col-xxl-3 col-md-12 mb-5">
                                <label><?= translate('description')?></label>
                                <div id="edit2" class="snow-editor"><?=translate('term_condition2')?></div> 
                            </div>
                            <input type="hidden" id="p2" name="description2">
                            
                            <div class="col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border"><?php echo translate('update')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('button').click(function () {
        $("#edit :input").attr("hidden", true);
        $(".snow-editor").attr("contenteditable", false);
        $(".snow-clipboard").attr("contenteditable", false);
        var txt = $('#edit').html();
                $('#p').val(txt);

        $("#edit2 :input").attr("hidden", true);
        $(".snow-editor").attr("contenteditable", false);
        $(".snow-clipboard").attr("contenteditable", false);
        var txt = $('#edit2').html();
                $('#p2').val(txt);
    })

</script>