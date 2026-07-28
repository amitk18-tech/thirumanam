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
        <div class="card" style="position: absolute;">
            <div class="card-header">

            <div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <?=translate('profile_report')?>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url('administrator/all_members')?>"><?=translate('all_member')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/all_members/offline')?>"><?=translate('offline_member')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/all_members/online')?>"><?=translate('OnlineRegisteredMembers')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/all_members/report')?>"><?=translate('profile_report')?></a>
                </div>
            </div>
                <!-- <a class="float-end btn btn-sm btn-outline-primary btn-border" href="<?php echo base_url('AdminController/addCustomer'); ?>">Add New Member</a> -->
            </div>
            <div class="card-body" style="margin-bottom: 50px;">
                <table id="datatable" class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th><?php echo translate('s_no')?></th>
                            <th><?php echo translate('user_image')?></th>
                            <th><?php echo translate('Member ID')?></th>
                            <th><?php echo translate('name')?></th>
                            <th><?php echo translate('plan')?></th>
                            <th><?php echo translate('profile_reported')?></th>
                            <th><?php echo translate('profile_downloads')?></th>
                            <th><?php echo translate('mobile')?></th>
                            <th><?php echo translate('member_since')?></th>
                            <th><?php echo translate('member_status')?></th>
                            <th><?php echo translate('options')?></th>
                        </tr>
                    </thead>                    
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    var base_url=$('#base_url').val();
    new DataTable("#datatable", {        
        ajax: base_url+"AjaxController/reportMembers",
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