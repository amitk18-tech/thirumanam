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
                    <form action="<?php echo base_url('AdminController/sendMail')?>" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="basiInput" class="form-label"><?php echo translate('e-mails_(users)')?>: </label>
                                     
                                       <?php foreach ($news as $row ) { 
                                        if(!empty($row->email)){
                                            $emails[] = $row->email;
                                            $email=join(',',$emails);
                                    } } ?>
                                    <input class="form-control" id="choices-text-remove-button" data-choices data-choices-limit="100000" data-choices-removeItem type="text" value="<?php echo $email;?>" name="email">
                                    <!-- <select name="email" class="form-control" id="choices-multiple-remove-button" data-choices data-choices-removeItem name="choices-multiple-remove-button" multiple>
                                       
                                        <option value="kumar" selected>kumar</option>
                                        <option value="thhh" selected>thhh</option>
                                        <option value="tjjj" selected>tjjj</option>
                                    </select> -->
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-xxl-3 col-md-12">
                                <div>
                                    <label for="labelInput" class="form-label"><?= translate('newsletter_subject')?></label>
                                    <textarea type="text" class="form-control" placeholder="<?= translate('newsletter_subject')?>" name="subject"></textarea>
                                </div>
                            </div>
                            <div class="col-xxl-3 col-md-12 mb-5">
                                <label><?= translate('email_template')?></label>
                                <select class="form-control" id="change_template">
                                    <option value=""><?php echo translate('choose_one');?></option>
                                    <?php if(!empty($templates)){

                                        foreach($templates as $template){?>
                                        <option value="<?php echo $template->id?>"><?php echo $template->temp_name?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-xxl-3 col-md-12 mb-5">
                                <label><?= translate('description')?></label>
                                <!-- <div id="edit" class="bubble-editor template_output" style="height: 300px;"></div> -->
                                <div id="edit" class="snow-editor template_output"></div>
                            </div>
                            <input type="hidden" id="p" name="description">
                            <div class="col-md-12 text-center mt-5">
                                <button type="submit" class="btn btn-sm btn-outline-primary btn-border"><?php echo translate('send')?></button>
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
        $(".ql-editor").attr("contenteditable", false);
        $(".ql-clipboard").attr("contenteditable", false);
        var txt = $('#edit').html();
                $('#p').val(txt);
    })

    $("#change_template").change(function(){
    var id = $(this).find(':selected').attr('value');

    console.log(id);

  var base_url=$('#base_url').val();
    $.ajax({
      type: 'GET',
      url: base_url+'get_email_templates',
      data: '&id='+id,
      success:function(html)
      {         
        $('.template_output').html(html);            
      }
  }); 
});
</script>