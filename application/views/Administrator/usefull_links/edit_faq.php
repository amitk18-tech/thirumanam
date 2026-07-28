<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>

<div class="card">
    <div class="card-header"></div>
    <div class="card-body mt-4">
           <form action="<?php echo base_url('AdminController/updateFaq')?>" method="post">
            <div class="row gy-4">
            <input type="hidden" name="faq_id" value="<?php echo $faq_ques->id;?>">

            <div class="col-md-6  mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('english')?> <?php echo translate('question')?></label>
                     <textarea type="text" class="form-control" id="basiInput" name="ques_english"><?php echo $faq_ques->ques_english?></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('english')?> <?php echo translate('answer')?></label>
                    <textarea type="text" class="form-control" id="basiInput" name="ans_english"><?php echo $faq_ques->ans_english?></textarea>
                </div>
            </div>
            <div class="col-md-6  mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('tamil')?> <?php echo translate('question')?></label>
                     <textarea type="text" class="form-control" id="basiInput" name="ques_tamil"><?php echo $faq_ques->ques_tamil?></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('tamil')?> <?php echo translate('answer')?></label>
                    <textarea type="text" class="form-control" id="basiInput" name="ans_tamil"><?php echo $faq_ques->ans_tamil?></textarea>
                </div>
            </div>
        </div>
        <!--end row-->
        <div class="row gy-4 mt-1">
            <div class="col-md-12 mb-5 text-center">
                <button type="submit" class="btn btn-xs btn-outline-success btn-border"><?php echo translate('update')?></button>
        </div>
        </div>

        </form>
    </div>
</div>