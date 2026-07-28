<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>

<?php

$CI=& get_instance();
$CI->load->database();
if($set_lang = $CI->session->userdata('language')){} else {
    $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
}

if($set_lang == 'english')
{
    $l ='ques_english';
    $la ='ans_english';
    $f = $this->db->select('ques_english,ans_english,id')->get_where('faq_ques',array('qId'=>0))->result_array();
   
   
}
else{
    $l ='ques_tamil';
    $la ='ans_tamil';
    $f = $this->db->select('ques_tamil,ans_tamil,id')->get_where('faq_ques',array('qId'=>0))->result_array();
    
    
}


$faqs = json_decode($this->db->get_where('general_settings', array('type' => 'faqs'))->row()->value, true); ?>
<div class="mt-2">
     

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
            <div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=translate('Common_Quries')?>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url('administrator/all_faq')?>"><?=translate('Common_Quries')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/Common_faq')?>"><?=translate('Common_Quries')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/online_faq/offline')?>"><?=translate('online_Quries')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/offline_faq/online')?>"><?=translate('offline_Quries')?></a>
                   
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo base_url('administrator/add_faq');?>" class="btn btn-sm btn-outline-success btn-border text-end" ><?php echo translate('add');?></a>
        </div>
        </div>
        
        
                
            
    </div>
    <?php if (!empty($faqs)){ $i=0;
    foreach ($f as $faq) { $i++;
    // print_r($faq);exit;
    ?>
        <div class="card-body mt-4">
            <form action="<?php echo base_url('AdminController/updateFaq')?>" method="post">
                <div class="row gy-4">
    
                <input type="hidden" name="faq_id" value="<?php echo $faq['id'] ?>">
                <div class="col-md-6  mt-2">
                    <div>
                        <label for="basiInput" class="form-label"><?php echo translate('question')?> <?php echo $i ;?></label>
                         <textarea type="text" class="form-control" id="basiInput" name="question"><?php echo $faq[$l]?></textarea>
                    </div>
                </div>
                <div class="col-md-6 mt-2">
                    <div>
                        <label for="basiInput" class="form-label"><?php echo translate('answer')?> <?php echo $i ;?> </label>
                        <textarea type="text" class="form-control" id="basiInput" name="answer"><?php echo $faq[$la]?></textarea>
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
    <?php } } ?>
</div>


 </div>                   
<h3><?php echo translate('Online_Registered_User_Quries')?></h3>
<?php

$CI=& get_instance();
$CI->load->database();
if($set_lang = $CI->session->userdata('language')){} else {
    $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
}

if($set_lang == 'english')
{
    $l ='ques_english';
    $la ='ans_english';
    $f = $this->db->select('ques_english,ans_english,id')->get_where('faq_ques',array('qId'=>1))->result_array();
   
   
}
else{
    $l ='ques_tamil';
    $la ='ans_tamil';
    $f = $this->db->select('ques_tamil,ans_tamil,id')->get_where('faq_ques',array('qId'=>1))->result_array();
    
    
}


$faqs = json_decode($this->db->get_where('general_settings', array('type' => 'faqs'))->row()->value, true); ?>

<?php if (!empty($faqs)){ $i=0;
    foreach ($f as $faq) { $i++;
    // print_r($faq);exit;
    ?>
    <form action="<?php echo base_url('AdminController/saveFaq')?>" method="post">
    <div class="row gy-4">
    

    <input type="hidden" name="faq_id" value="<?php echo $faq['id'] ?>">
    <div class="col-md-6  mt-2">
        <div>
            <label for="basiInput" class="form-label"><?php echo translate('question')?> <?php echo $i ;?></label>
             <textarea type="text" class="form-control" id="basiInput" name="question"><?php echo $faq[$l]?></textarea>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div>
            <label for="basiInput" class="form-label"><?php echo translate('answer')?> <?php echo $i ;?> </label>
            <textarea type="text" class="form-control" id="basiInput" name="answer"><?php echo $faq[$la]?></textarea>
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


<?php } } ?>

<h5><?php echo translate('Offline_Registered_User_Quries')?></h5>
<?php

$CI=& get_instance();
$CI->load->database();
if($set_lang = $CI->session->userdata('language')){} else {
    $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
}

if($set_lang == 'english')
{
    $l ='ques_english';
    $la ='ans_english';
    $f = $this->db->select('ques_english,ans_english,id')->get_where('faq_ques',array('qId'=>2))->result_array();
   
   
}
else{
    $l ='ques_tamil';
    $la ='ans_tamil';
    $f = $this->db->select('ques_tamil,ans_tamil,id')->get_where('faq_ques',array('qId'=>2))->result_array();
    
    
}


$faqs = json_decode($this->db->get_where('general_settings', array('type' => 'faqs'))->row()->value, true); ?>

<?php if (!empty($faqs)){ $i=0;
    foreach ($f as $faq) { $i++;
    // print_r($faq);exit;
    ?>
    <form action="<?php echo base_url('AdminController/saveFaq')?>" method="post">
    <div class="row gy-4">
    

    <input type="hidden" name="faq_id" value="<?php echo $faq['id'] ?>">
    <div class="col-md-6  mt-2">
        <div>
            <label for="basiInput" class="form-label"><?php echo translate('question')?> <?php echo $i ;?></label>
             <textarea type="text" class="form-control" id="basiInput" name="question"><?php echo $faq[$l]?></textarea>
        </div>
    </div>
    <div class="col-md-6 mt-2">
        <div>
            <label for="basiInput" class="form-label"><?php echo translate('answer')?> <?php echo $i ;?> </label>
            <textarea type="text" class="form-control" id="basiInput" name="answer"><?php echo $faq[$la]?></textarea>
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


<?php } } ?>