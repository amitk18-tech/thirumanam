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
           <form action="<?php echo base_url('AdminController/saveFaq')?>" method="post">
            <div class="row gy-4">
            

            <div class="col-md-6  mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('english')?> <?php echo translate('question')?></label>
                     <textarea type="text" class="form-control" id="basiInput" name="ques_english"></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('english')?> <?php echo translate('answer')?></label>
                    <textarea type="text" class="form-control" id="basiInput" name="ans_english"></textarea>
                </div>
            </div>
            <div class="col-md-6  mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('tamil')?> <?php echo translate('question')?></label>
                     <textarea type="text" class="form-control" id="basiInput" name="ques_tamil"></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('tamil')?> <?php echo translate('answer')?></label>
                    <textarea type="text" class="form-control" id="basiInput" name="ans_tamil"></textarea>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div>
                    <label for="basiInput" class="form-label"><?php echo translate('tamil')?> <?php echo translate('answer')?></label>
                    <select class="form-select" name='qId'>
                        <option value=""><?php echo translate('choose_one')?></option>
                        <option value="0"><?php echo translate('Common_Quries')?></option>
                        <option value="1"><?php echo translate('online_Quries')?></option>
                        <option value="2"><?php echo translate('offline_Quries')?></option>
                    </select>
                </div>
            </div>
        </div>
        <!--end row-->
        <div class="row gy-4 mt-1">
            <div class="col-md-12 mb-5 text-center">
                <button type="submit" class="btn btn-xs btn-outline-success btn-border"><?php echo translate('save')?></button>
        </div>
        </div>

        </form>
    </div>
</div>