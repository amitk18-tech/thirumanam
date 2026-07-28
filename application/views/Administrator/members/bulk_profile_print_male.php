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
            <div class="card-header" >
                <div class="row">
                    <div class="col-lg-6">
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?=translate('male')?>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="<?php echo base_url('administrator/bulk_profile_print/')?>"><?=translate('all_member')?></a>
                                <a class="dropdown-item" href="<?php echo base_url('administrator/bulk_profile_print/male')?>"><?=translate('male')?></a>
                                <a class="dropdown-item" href="<?php echo base_url('administrator/bulk_profile_print/female')?>"><?=translate('female')?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-end">
                            <a href="#" id="select_check" style='display:none' class="btn btn-info btn-sm"  target="_blank">Print</a>
                        </div>
                    </div>
                </div>
                <!-- <a class="float-end btn btn-sm btn-outline-primary btn-border" href="<?php echo base_url('AdminController/addCustomer'); ?>">Add New Member</a> -->
            </div>
            <div class="card-body" style="margin-bottom: 50px;">
                <form target="_blank" action="<?php echo base_url('administrator/print_bulk_member/0');?>" id="submit_form" method="post">
                        <input type="hidden" name="selected_ids" id="selected_ids">
                <table id="datatable" class="display table table-bordered dt-responsive" style="width:100%" data-paging='false'>
                    <thead>
                        <tr>
                            <th><?php echo translate('s_no')?></th>
                            <th><?php echo translate('Select')?></th>
                            <th><?php echo translate('user_image')?></th>
                            <th><?php echo translate('Member ID')?></th>
                            <th><?php echo translate('name')?></th>
                                <th>
                                    <?php echo translate('approval_status')?>
                                </th>

                            <th><?php echo translate('plan')?></th>
                            <th><?php echo translate('profile_reported')?></th>
                            
                            <th><?php echo translate('block_user')?></th>

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



<div id="edit_output"></div>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    var base_url=$('#base_url').val();
    new DataTable("#datatable", {        
        ajax: base_url+"AjaxController/bulkPrintMale",
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

<script>

function func(){

        if ($("input:checkbox:checked").length > 0)
        {
             $("#select_check").show();
        }
        else
        {
            $("#select_check").hide();
        }
}
$(document).ready(function() {
        $("#select_check").click(function(){
            var favorite = [];
            $.each($("input[name='select']:checked"), function(){
                favorite.push($(this).val());
            });
             var all = favorite.join(", ");
            $("#selected_ids").val(all);
            $("#submit_form").submit();
        });
    });
</script>