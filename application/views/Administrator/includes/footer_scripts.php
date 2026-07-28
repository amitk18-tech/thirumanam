<!-- JAVASCRIPT -->
<script src="<?php echo base_url('assets/admin/') ?>libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>libs/simplebar/simplebar.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>libs/node-waves/waves.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>libs/feather-icons/feather.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/pages/plugins/lord-icon-2.1.0.js"></script>

<script src="<?php echo base_url('assets/admin/') ?>js/form-wizard.init.js"></script>
<!-- <script src="<?php #echo base_url('assets/admin/') ?>js/plugins.js"></script> -->
<script type="text/javascript">
    (document.querySelectorAll("[toast-list]") || document.querySelectorAll("[data-choices]") || document.querySelectorAll("[data-provider]")) && (document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'><\/script>"), document.writeln("<script type='text/javascript' src='<?php echo base_url('assets/admin/') ?>/libs/choices.js/public/assets/scripts/choices.min.js'><\/script>"), document.writeln("<script type='text/javascript' src='<?php echo base_url('assets/admin/') ?>/libs/flatpickr/flatpickr.min.js'><\/script>"));
</script>

<script src="<?php echo base_url('assets/admin/') ?>dist/js/select2.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/pages/select2.init.js"></script>
<script src="<?php echo base_url() ?>assets/admin/js/select2.full.min.js"></script>
<!-- App js -->
<script src="<?php echo base_url('assets/admin/') ?>js/app.js"></script>





<script src="<?php echo base_url('assets/admin/') ?>js/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/libs/%40ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>

    <!-- quill js -->
    <script src="<?php echo base_url() ?>assets/admin/libs/quill/quill.min.js"></script>

    <!-- init js -->
    <script src="<?php echo base_url() ?>assets/admin/js/pages/form-editor.init.js"></script>
<!-- sortablejs -->
<script src="<?php echo base_url(); ?>assets/admin/js/summernote-bs4.min.js"></script>

<!-- apexcharts -->
<script src="<?php echo base_url('assets/admin/') ?>libs/apexcharts/apexcharts.min.js"></script>

<!-- Dashboard init -->
<script src="<?php echo base_url('assets/admin/') ?>js/pages/dashboard-ecommerce.init.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>



<script src="<?php echo base_url('assets/admin/') ?>js/pages/datatables.init.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<!-- <script src="<?php echo base_url('assets/admin/') ?>js/responsive/2.2.9/js/dataTables.responsive.min.js"></script> -->
<script src="<?php echo base_url('assets/admin/') ?>js/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.21/pagination/select.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.21/pagination/input.js"></script>
<script type="text/javascript">


document.getElementById("choice2").onclick = function () {
        location.href = "<?=base_url()?>AdminController/setLanguage/tamil";
    };
document.getElementById("choice1").onclick = function () {
        location.href = "<?=base_url()?>AdminController/setLanguage/english";
    };




$("#member_type").change(function(){
var type_id = $(this).find(':selected').attr('data-id');

console.log(type_id);
var base_url=$('#base_url').val();
$.ajax({
  type: 'GET',
  url: base_url+'get_membership_data_ajax_admin',
  data: '&id='+type_id,
  success:function(html)
  {            
    $('#membership_ajax_output').html(html);            
  }
}); 
});





$("#marital_status").change(function(){
    var marital = $(this).find(':selected').attr('data-id');

    console.log(marital);
    if(marital==1 || marital==2 || marital==3)
    {
    $("#no_of_child").show();
    $("#child_live_place").show();
    }
    if(marital==4)
    {
    $("#no_of_child").hide();
    $("#child_live_place").hide();
    }
  
});

if($("#marital_status").val()=='Divorced ' || $("#marital_status").val()=='Separated ' || $("#marital_status").val()=='Widowed'){
        $("#no_of_child").show();
        $("#child_live_place").show();
    }else{

       $("#no_of_child").hide();
        $("#child_live_place").hide();
    }


$("#Type_of_study").change(function(){
    var study = $(this).find(':selected').attr('data');

    console.log(study);
    if(study=='OTHERS'){
        $('#study_other').show();
    }else{

        $('#study_other').hide();
    }
  
});
if($("#Type_of_study").val()=='OTHERS'){
        $('#study_other').show();
    }else{

        $('#study_other').hide();
    }

$("#Type_of_occupation").change(function(){
    var occupation = $(this).find(':selected').attr('data');

    console.log(occupation);
    if(occupation=='OTHERS'){
        $('#occupation_other').show();
    }else{

        $('#occupation_other').hide();
    }
  
});
if($("#Type_of_occupation").val()=='OTHERS'){
        $('#occupation_other').show();
    }else{

        $('#occupation_other').hide();
    }
$("#paksha").change(function(){
    var paksha = $(this).find(':selected').attr('data');

    console.log(paksha);
    if(paksha=='OTHERS'){
        $('#paksha_other').show();
    }else{

        $('#paksha_other').hide();
    }
  
});
if($("#paksha").val()=='OTHERS'){
        $('#paksha_other').show();
    }else{

        $('#paksha_other').hide();
    }

$("#dosham").change(function(){
    var dosham = $(this).find(':selected').attr('data');

    console.log(dosham);
    if(dosham=='Yes'){
        $('#dosham_other').show();
    }else{

        $('#dosham_other').hide();
        $('#Other_Dosham').hide();
    }
  
});

    
    if($("#dosham").val()=='Yes'){
        $('#dosham_other').show();
    }else{

        $('#dosham_other').hide();
        $('#Other_Dosham').hide();
    }
$("#TYPE_OF_DOSHAM").change(function(){
    var dosham = $(this).find(':selected').attr('data');

    console.log(dosham);
    if(dosham=='OTHERS'){
        $('#Other_Dosham').show();
    }else{

        $('#Other_Dosham').hide();
    }
  
});

if($("#TYPE_OF_DOSHAM").val()=='OTHERS'){
        $('#Other_Dosham').show();
    }else{

        $('#Other_Dosham').hide();
    }

$("#Property_Description").change(function(){
    var property = $(this).find(':selected').attr('data');

    console.log(property);
    if(property=='OTHERS'){
        $('#property_other').show();
    }else{

        $('#property_other').hide();
    }
  
});
if($("#Property_Description").val()=='OTHERS'){
        $('#property_other').show();
    }else{

        $('#property_other').hide();
    }

$("#mar_status").change(function(){
    var marital = $(this).find(':selected').attr('data');

    console.log(marital);
    if(marital==2 || marital==3 || marital==4)
    {
    $("#children_acceptables").show();
    }
    if(marital==1)
    {
    $("#children_acceptables").hide();
    }
  
});
if($("#mar_status").val()=='Divorced ' || $("#mar_status").val()=='Separated ' || $("#mar_status").val()=='Widowed'){
        $("#children_acceptables").show();
    }else{

       $("#children_acceptables").hide();
    }  
 $("#partner_DOSHAM").change(function(){
    var DOSHAM = $(this).find(':selected').attr('data');

    console.log(DOSHAM);
    if(DOSHAM=='Yes'){
        $('#partner_TYPE_OF_DOSHAM').show();
    }else{

        $('#partner_TYPE_OF_DOSHAM').hide();
        $('#partner_Other_Dosham').hide();
    }
  
});
if($("#partner_DOSHAM").val()=='Yes'){
        $('#partner_TYPE_OF_DOSHAM').show();
    }else{

        $('#partner_TYPE_OF_DOSHAM').hide();
        $('#partner_Other_Dosham').hide();
    }


$("#partner_TYPE_OF_DOSHAM").change(function(){
    var DOSHAM = $(this).find(':selected').attr('data');

    console.log(DOSHAM);
    if(DOSHAM=='OTHERS'){
        $('#partner_Other_Dosham').show();
    }else{

        $('#partner_Other_Dosham').hide();
    }
  
});
if($("#partner_TYPE_OF_DOSHAM").val()=='OTHERS'){
        $('#partner_Other_Dosham').show();
    }else{

        $('#partner_Other_Dosham').hide();
    }

$("#partner_Expectation").change(function(){
    var property = $(this).find(':selected').attr('data');

    console.log(property);
    if(property=='OTHERS'){
        $('#partner_Other_Expectation').show();
    }else{

        $('#partner_Other_Expectation').hide();
    }
  
});
if($("#partner_Expectation").val()=='OTHERS'){
        $('#partner_Other_Expectation').show();
    }else{

        $('#partner_Other_Expectation').hide();
    }

$("#father_vangusam").change(function(){
var property = $(this).find(':selected').attr('data');

console.log(property);
if(property=='OTHERS'){
    $('#father_vangusam_other').show();
}else{

    $('#father_vangusam_other').hide();
}
  
});
if($("#father_vangusam").val()=='OTHERS'){
        $('#father_vangusam_other').show();
    }else{

        $('#father_vangusam_other').hide();
    }


$("#mother_vangusam").change(function(){
var property = $(this).find(':selected').attr('data');

console.log(property);
if(property=='OTHERS'){
    $('#mother_vangusam_other').show();
}else{

    $('#mother_vangusam_other').hide();
}
  
});
if($("#mother_vangusam").val()=='OTHERS'){
        $('#mother_vangusam_other').show();
    }else{

        $('#mother_vangusam_other').hide();
    }

$("#permanent_state").change(function(){
    var state = $(this).find(':selected').attr('value');

    console.log(state);
    if(state=='OTHERS'){
        $('#permanent_city_other').show();
    }else{

        $('#permanent_city_other').hide();
    }
  
});
if($("#permanent_state").val()=='OTHERS'){
        $('#permanent_city_other').show();
    }else{

        $('#permanent_city_other').hide();
    }




    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({         
          "ordering": false,
        });
        $('#example3').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        $("#example4").DataTable();
        $("#filter_table").DataTable();        
        $("#example5").DataTable();
        $("#example6").DataTable();
        $('#start_date').datepicker({format:'yyyy-mm-dd'}).datepicker("setDate", new Date());
        $('#end_date').datepicker({format:'yyyy-mm-dd'}).datepicker("setDate", new Date());
        $('#edit_end_date').datepicker({format:'yyyy-mm-dd'});
        $('#edit_start_date').datepicker({format:'yyyy-mm-dd'});
        
        
      });

      // DataTable for All Customers
      $(document).ready(function() {
      var base_url=$('#base_url').val();  
      var dataTable = $('#all_customers').DataTable( {
        "processing": true,
        "serverSide": true,

        // "sPaginationType": "listbox",
        // "pagingType": "full_numbers",
        "pagingType": "input",
        "ajax":{
          url :base_url+"administrator/customer_server_table", // json datasource
          type: "post",
      <?php $star=(isset($_REQUEST['star'])) ? $_REQUEST['star'] :'';?>
          data: '&star='+ "<?php echo $star; ?>",  // method  , by default get
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
    } );

    
    
    $( document ).ready(function() {
        $('#admin-alert').delay(5000).fadeOut('slow');



    });

    function getIssuedFunds(customer_id)
    {
        var base_url=$('#base_url').val();
        $.ajax({
            type:'POST',            
            url:base_url+'AjaxController/getIssuedFunds',
            data:'customer_id='+customer_id,
            dataType: 'json',
            success : function(response){
                $('#funds_issued').html(response.html);
                $('#total').val(response.total);
                $('#balance').val(response.balance);
                $('#collection').val(response.collection);
                console.log(response);
            }
        });
    }

    function getIssuedFundDetails(issued_id)
    {
        var base_url=$('#base_url').val();
        $.ajax({
            type:'POST',            
            url:base_url+'AjaxController/getIssuedFundDetails',
            data:'issued_id='+issued_id,
            dataType: 'json',
            success : function(response){                
                $('#total').val(response.total);
                $('#balance').val(response.balance);
                $('#collection').val(response.collection);
                // console.log(response);
            }
        });
    }

    function getCollectionEndDate(amount)
    {
        var date=$('#date').val();
    }

     function change_height_feet(h)
    {
        var base_url=$('#base_url').val();
        $.ajax({
            type: 'POST',
            url: base_url+'change_height_feet',
            data: '&height_id='+h,
            success:function(html)
            {
               $('#height_convert_ajax_1').html(html);
            }
        });
    }
    function change_height_cms(h)
    {
        var base_url=$('#base_url').val();
        $.ajax({
            type: 'POST',
            url: base_url+'change_height_cms',
            data: '&height_id='+h,
            success:function(html)
            {
               $('#height_convert_ajax_2').html(html);
            }
        });
    }

    function get_states_ajax(country_id)
    {   
        var base_url=$('#base_url').val();
        $.ajax({
          type: 'GET',
          url: base_url+'get_states_of_country_ajax_admin',
          data: '&country_id='+country_id,
          success:function(html)
          {            
            $('#states_ajax_output').html(html);            
          }
      });
    }
    function get_city_ajax(state_id)
    {
        var base_url=$('#base_url').val();
        $.ajax({
          type: 'GET',
          url: base_url+'get_city_of_state_ajax_admin',
          data: '&state_id='+state_id,
          success:function(html)
          {            
            $('#citys_ajax_output').html(html);            
          }
      });
    }


    function add_new_rasi_to_kattam()
    {
      var user_id=$('#user_id').val();
      var available_rasi=$('#available_rasi').val();      
      var available_rasi_text=$('#available_rasi option:selected').text();
      var selected_position=$('#selected_rasi_place').val();
      var base_url=$('#base_url').val();      
      
      if(available_rasi_text==''){return;}

      //insert this info in table and get true postion
      $.ajax({
        type:'GET',
        url:base_url+'ajax_horoscope_temp_operation?operation=insert&for_what=rasi&position='+selected_position+'&selcted_rasi='+available_rasi+'&user_id='+user_id,
        dataType:'json',
        success: function(data){
          //find and display rasi in position
          var true_position=getTruePosition(selected_position);
          document.getElementById('inner_'+true_position+'_rasi_img_'+available_rasi).style.display='block';

          //transfer this option to remove select
          $('#selected_rasi').append('<option value="'+available_rasi+'">'+available_rasi_text+'</option>');
          $("#available_rasi option[value='"+available_rasi+"']").remove();          
        }
      })  
    }

    function remove_new_rasi_from_kattam()
    {
        var base_url=$('#base_url').val();
        var user_id=$('#user_id').val();
        var selected_rasi=$('#selected_rasi').val();        
        var selected_rasi_text=$('#selected_rasi option:selected').text();
        if(selected_rasi_text==''){return;}

        console.log("Selected Rasi: "+selected_rasi);
        console.log("Selected Rasi Text : "+selected_rasi_text);  

        //remove from database
        $.ajax({
        type:'GET',
        url:base_url+'ajax_horoscope_temp_operation?operation=remove&for_what=rasi&position=&selcted_rasi='+selected_rasi+'&user_id='+user_id,
        dataType:'json',
        success: function(data){          
          //find and display rasi in position          
          var true_position=getTruePosition(data.box_remove_position);          
          document.getElementById('inner_'+true_position+'_rasi_img_'+selected_rasi).style.display='none';

          //remove from selected rasi list
          $("#selected_rasi option[value='"+selected_rasi+"']").remove();                      

          //add to available rasi list          
          $('#available_rasi').append('<option value="'+selected_rasi+'">'+selected_rasi_text+'</option>');
        }
      }) 
    }

     function add_new_amsam_to_kattam()
    {
      var user_id=$('#user_id').val();
      var available_rasi=$('#available_amsam').val();
      var available_rasi_text=$('#available_amsam option:selected').text();
      if(available_rasi_text==''){return;}
      var selected_position=$('#selected_amsam_place').val();
      var base_url=$('#base_url').val();      

      //insert this info in table and get true postion
      $.ajax({
        type:'GET',
        url:base_url+'ajax_horoscope_temp_operation?operation=insert&for_what=amsam&position='+selected_position+'&selcted_rasi='+available_rasi+'&user_id='+user_id,
        dataType:'json',
        success: function(data){
          //find and display rasi in position
          var true_position=getTruePosition(selected_position);
          document.getElementById('inner_'+true_position+'_amsam_img_'+available_rasi).style.display='block';

          //transfer this option to remove select
          $('#selected_amsam').append('<option value="'+available_rasi+'">'+available_rasi_text+'</option>');
          $("#available_amsam option[value='"+available_rasi+"']").remove();          
        }
      })  
    }
    function remove_new_amsam_from_kattam()
    {
        var base_url=$('#base_url').val();
        var user_id=$('#user_id').val();
        var selected_rasi=$('#selected_amsam').val();
        var selected_rasi_text=$('#selected_amsam option:selected').text();
        if(selected_rasi_text==''){return;}

        console.log("Selected Rasi: "+selected_rasi);
        console.log("Selected Rasi Text : "+selected_rasi_text);  

        //remove from database
        $.ajax({
        type:'GET',
        url:base_url+'ajax_horoscope_temp_operation?operation=remove&for_what=amsam&position=&selcted_rasi='+selected_rasi+'&user_id='+user_id,
        dataType:'json',
        success: function(data){          
          //find and display rasi in position          
          var true_position=getTruePosition(data.box_remove_position);     
          console.log('inner_'+true_position+'_amsam_img_'+selected_rasi);     
          document.getElementById('inner_'+true_position+'_amsam_img_'+selected_rasi).style.display='none';

          //remove from selected rasi list
          $("#selected_amsam option[value='"+selected_rasi+"']").remove();                      

          //add to available rasi list          
          $('#available_amsam').append('<option value="'+selected_rasi+'">'+selected_rasi_text+'</option>');
        }
      }) 
    }

    function change_payment_plan_details(p_id)
    {
        
        var base_url=$('#base_url').val();
        var payment_start_date=$('.payment_start_date').val();

        $('.ajax_loader').show();
        $.ajax({
            type: 'POST',
            url: base_url+'get_payment_profile_count',
            data: '&plan_id='+p_id,
            success:function(html)
            {
               $('#no_of_profiles_ajax').html(html);
               $('#no_of_profiles_ajax').html(html);
               $.ajax({
                    type: 'POST',
                    url: base_url+'get_payment_end_date',
                    data: '&plan_id='+p_id+'&start_date='+payment_start_date,
                    success:function(html)
                    {
                       $('#payment_end_date_ajax').html(html);
                       $('#edit_end_date').datepicker({format:'yyyy-mm-dd'});
                       $('.ajax_loader').hide();
                    }
                });
            }
        });
    }


    function getTruePosition(position)
{
  if(position==1){ return 1; }
  if(position==2){ return 2; }
  if(position==3){ return 3; }
  if(position==4){ return 4; }
  if(position==5){ return 8; }
  if(position==6){ return 12; }
  if(position==7){ return 16; }
  if(position==8){ return 15; }
  if(position==9){ return 14; }
  if(position==10){ return 13; }
  if(position==11){ return 9; }
  if(position==12){ return 5; }

  return position;
}


function check_simple_or_online(){
      var base_url=$('#base_url').val();
      var user_type=$('#user_type').val();
       console.log(user_type);
      $.ajax({
          type: 'POST',
          url: base_url+'get_payment_plan_ajax_admin',
          data: '&user_type='+user_type,
          success:function(html)
          {  
            console.log(html);
            $('#payment_plan_id').html(html);            
          }
        });
      if (user_type==0) {        
        $("#password_div").css("display","none");
        
      }
      if (user_type==1 || user_type==2) {
        $("#password_div").css("display","block");
      }
    }

    function change_feature_image_admin(i,user_id)
    {
        var base_url=$('#base_url').val();
        $.ajax({
            type: 'POST',
            url: base_url+'change_feature_image_admin',
            data: '&image_id='+i+'&user_id='+user_id,
            success:function(html)
            {
                
            }
        });
    }

   
 

</script>


    
