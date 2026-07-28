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
    </style>
<div class="row">
    <div class="col-lg-12">
        <div class="card" style="position: absolute;">
            <div class="card-header">

            <div class="btn-group">
                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=translate('male')?>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?php echo base_url('administrator/offline_members')?>"><?=translate('all_member')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/offline_members/male')?>"><?=translate('male')?></a>
                    <a class="dropdown-item" href="<?php echo base_url('administrator/offline_members/female')?>"><?=translate('female')?></a>
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
          url :base_url+"administrator/offlineRegisterMale", // json datasource
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
// document.addEventListener("DOMContentLoaded", function() {
//     var base_url=$('#base_url').val();
//     new DataTable("#datatable", {        
//         ajax: base_url+"AjaxController/offlineMale",
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