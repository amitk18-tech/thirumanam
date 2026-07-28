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
                <a class="float-end btn btn-sm btn-outline-primary btn-border" href="<?php echo base_url('administrator/add_role'); ?>"><?= translate('create_new')?></a>
            </div>
            <div class="card-body">
                <table id="datatable" class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th><?php echo translate('name')?></th>
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
        ajax: base_url+"AjaxController/mangeRole",
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

</script>

