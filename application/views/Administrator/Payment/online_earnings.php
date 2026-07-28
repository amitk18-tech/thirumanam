<input type="hidden" id="base_url" value="<?php echo base_url();?>">
 
<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}


?>
<style type="text/css">
   div.dataTables_wrapper div.dataTables_paginate {

    margin-right: 600px;
   }
   .paginate_button{ 
      /*border: 1px solid #d2d2d2;*/
      border-radius: 3px;
/*      background-color: #3986b3;*/
      color: var(--vz-link-color);
/*      padding: 5px 10px 5px 10px;*/
      margin-right: 5px;
      margin-left: 5px;
    }
    .paginate_button:hover{
      
      background-color: var(--vz-link-color);
      color: #fff;      
      cursor: pointer;
      padding: 5px 10px 5px 10px;
    }
    .paginate_input{
      height: 28px;
      padding: 5px 10px 5px 10px;
      border: 1px solid #d2d2d2;
      border-radius: 3px;
      width: 50px;

    }
    .dataTables_info{

        margin-bottom: 5em;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="position: absolute;">
            <div class="card-header">
                <div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=translate('OnlineRegisteredMembers')?>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url('administrator/activation')?>"><?=translate('all_members')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/activation/online')?>"><?=translate('OnlineRegisteredMembers')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/activation/offline')?>"><?=translate('offline_member')?></a>
                    
                </div>
            </div>
                <!-- <a class="float-end btn btn-sm btn-outline-primary btn-border" href="<?php echo base_url('AdminController/addCustomer'); ?>">Add New Member</a> -->
            </div>
            <div class="card-body">
                <table id="datatable" class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th><?php echo translate('s_no')?></th>
                            <th><?php echo translate('user_image')?></th>
                            <th><?php echo translate('member_id')?></th>
                            <th><?php echo translate('Transaction_Txn_Id')?></th>
                            <th><?php echo translate('user_name')?></th>
                            <th><?php echo translate('plan')?></th>
                            <th><?php echo translate('payment_date')?></th>
                            <th><?php echo translate('payment_type')?></th>
                            <th><?php echo translate('amount')?></th>
                             <th><?php echo translate('mobile')?></th>
                            <th><?php echo translate('status')?></th>
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
// document.addEventListener("DOMContentLoaded", function() {
//     var base_url=$('#base_url').val();
//     new DataTable("#datatable", {        
//         ajax: base_url+"AjaxController/onlineEarnings",
//         success: function(data) {
//             console.log(data);
//         },
//         error: function() {
//             alert('Error occured');
//         },
//         dom: "Bfrtip",
//         buttons: ["copy", "csv", "excel", "print", "pdf"]
//     })
// });

    $(document).ready(function() {

var base_url=$('#base_url').val(); 
// alert(base_url); 
      var dataTable = $('#datatable').DataTable( {
        
        "processing": true,
        "serverSide": true,

        // "sPaginationType": "listbox",
        // "pagingType": "full_numbers",
        "pagingType": "input",
        "ajax":{
          url :base_url+"administrator/total_earnings_online", // json datasource
          type: "POST",
        
          // method  , by default get
          error: function(){  // error handling
            
            $(".all_customers-error").html("");
            $("#all_customers").append('<tbody class="employee-grid-error"><tr><th colspan="10"><center>No data found in the server</center></th></tr></tbody>');
            $("#all_customers_processing").css("display","none");
            
          }
        },
        "columnDefs": [       
         {
              "targets": 0,
              "className": "text-center",
         },
         {
              "targets": 4,
              "className": "text-center",
         },
         {
              "targets": 5,
              "className": "text-center",
         },
         {
              "targets": 6,
              "className": "text-center",
         },
         {
              "targets": 7,
              "className": "text-center",
         },
         {
              "targets": 8,
              "className": "text-center",
         }],
         "order": [[ 0, "desc" ]]

      } );

});

function acceptMember (m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'administrator/acceptMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
</script>


