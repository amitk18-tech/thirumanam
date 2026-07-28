<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>

<script type="text/javascript" src="<?php echo base_url('assets/admin/dropzone/image-uploader.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/admin/dropzone/image-uploader.min.css'); ?>">  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/dropzone/css/dropzone.css'); ?>" />
  <script type="text/javascript" src="<?php echo base_url('assets/admin/dropzone/js/dropzone.js'); ?>"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
           <div class="card-body">
              <div class="file_upload">
                  <form action="<?php echo base_url('AdminController/saveMemories') ?>" class="dropzone">
                      <div class="dz-message needsclick">
                          <strong>Drop files here or click to upload.</strong><br />
                          <!-- <span class="note needsclick">(This is just a demo. The selected files are <strong>not</strong> actually uploaded.)</span> -->
                      </div>
                  </form>     
              </div>  
              <br>
              <div class="row">
                  <div class="col-md-11"></div>
                  <div class="col-md-1">
                      <a href="<?php echo base_url('administrator/memories') ?>" class="btn btn-success float-right" ><?=translate('save')?></a>        
                  </div>
                  
              </div>
              <hr>
              <div class="row">
                 <ul class="list-unstyled mb-0" id="dropzone-preview">
                    <li class="mt-2" id="dropzone-preview-list">
                        <!-- This is used as the file preview template -->
                        <div class="border rounded">
                         <?php
                              if (!empty($memories)) {                        
                                  $sno=1;
                                  foreach ($memories as $memory) {
                         ?>
                            <div class="d-flex p-2">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar-sm bg-light rounded">
                                        <img data-dz-thumbnail class="img-fluid rounded d-block" src="<?php echo base_url('uploads/memories/'.$memory->name);?>" alt="Dropzone-Image" style="height: 100%;">
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="pt-1">
                                        <h5 class="fs-14 mb-1" data-dz-name>&nbsp;</h5>
                                        <p class="fs-13 text-muted mb-0" data-dz-size></p>
                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ms-3">
                                    <a href="<?php echo base_url('AdminController/deleteMemoryImage/'.$memory->id); ?>" onclick="return confirm('Are you sure want to delete this?');"  data-dz-remove class="btn btn-sm btn-danger"><?=translate('delete')?></a>
                                </div>
                            </div>
                            <?php } } else { ?>
                                <div class="col-sm-12 p-2 bg-info" style="box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;padding:2px 6px 6px 6px;">
                        <h5 style="color: white;"><center>No Images Found..</center></h5>
                     </div>                     
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                </ul>
                </div>
              <br>               
           </div>
        </div>
    </div>
</div>


