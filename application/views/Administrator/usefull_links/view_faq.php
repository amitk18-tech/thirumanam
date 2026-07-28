<input type="hidden" id="base_url" value="<?php echo base_url();?>">
 
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
            <div class="card-header">

            <div class="row">
            <div class="col-md-6">
            <div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=translate('all_queries')?>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url('administrator/view_faq')?>"><?=translate('all_queries')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/Common_faq')?>"><?=translate('Common_Quries')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/online_faq')?>"><?=translate('online_Quries')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/offline_faq')?>"><?=translate('offline_Quries')?></a>
                   
                </div>
            </div>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo base_url('administrator/add_faq');?>" class="btn btn-sm btn-outline-success btn-border text-end" ><?php echo translate('add');?></a>
        </div>
        </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th><?php echo translate('s_no')?></th>
                            <th><?php echo translate('english')?> <?php echo translate('question')?></th>
                            <th><?php echo translate('english')?> <?php echo translate('answer')?></th>
                            <th><?php echo translate('tamil')?> <?php echo translate('question')?></th>
                            <th><?php echo translate('tamil')?> <?php echo translate('answer')?></th>
                            <th><?php echo translate('options')?></th>
                        </tr>
                    </thead>                    
                </table>
            </div>
        </div>
    </div>
</div>



<div id="edit_output"></div>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    var base_url=$('#base_url').val();
    new DataTable("#datatable", {        
        ajax: base_url+"AjaxController/viewFaq",
        success: function(data) {
            console.log(data);
        },
        error: function() {
            alert('Error occured');
        },
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

function blockMember(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'administrator/blockMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
</script>

