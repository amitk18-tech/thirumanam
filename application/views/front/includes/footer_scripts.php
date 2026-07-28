  <style type="text/css">

 /* whats app button css */

.floating_btn {
 position: fixed;
  height: 130px;
  width: 50px;
  left: 58px;
  bottom: 5px;
  z-index: 9999999999;
}

@keyframes pulsing {
  to {
    box-shadow: 0 0 0 30px rgba(232, 76, 61, 0);
  }
}

.contact_icon {
  background-color: #42db87;
  color: #fff;
  width: 60px;
  height: 60px;
  font-size:30px;
  border-radius: 50px;
  text-align: center;
  box-shadow: 2px 2px 3px #999;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: translatey(0px);
  animation: pulse 1.5s infinite;
  box-shadow: 0 0 0 0 #42db87;
  -webkit-animation: pulsing 1.25s infinite cubic-bezier(0.66, 0, 0, 1);
  -moz-animation: pulsing 1.25s infinite cubic-bezier(0.66, 0, 0, 1);
  -ms-animation: pulsing 1.25s infinite cubic-bezier(0.66, 0, 0, 1);
  animation: pulsing 1.25s infinite cubic-bezier(0.66, 0, 0, 1);
  font-weight: normal;
  font-family: sans-serif;
  text-decoration: none !important;
  transition: all 300ms ease-in-out;
}


.text_icon {
  margin-top: 4px;
    color: #707070;
    font-size: 13px;
    width: 64px;
}


.thankyou
{
  padding: 130px 0;
}

</style>

  <!-- All Needed JS -->
  <script src="<?php echo base_url('assets/front/');?>js/vendor/jquery-3.6.0.min.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/vendor/modernizr-3.11.2.min.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/isotope.pkgd.min.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/swiper.min.js"></script>
  <!-- <script src="<?php echo base_url('assets/front/');?>js/all.min.js"></script> -->
  <script src="<?php echo base_url('assets/front/');?>js/wow.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/counterup.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/jquery.countdown.min.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/lightcase.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/waypoints.min.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/vendor/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/plugins.js"></script>
  <script src="<?php echo base_url('assets/front/');?>js/main.js"></script>
  <script type='text/javascript' src=''></script>
  <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
  <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>


<script src="<?php echo base_url('assets/admin/') ?>js/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/buttons/2.2.2/js/dataTables.buttons.min.js"></script>

<script src="<?php echo base_url('assets/admin/') ?>js/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/buttons/2.2.2/js/buttons.html5.min.js"></script>

<script src="<?php echo base_url('assets/admin/') ?>js/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="<?php echo base_url('assets/admin/') ?>js/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/summernote-bs4.min.js"></script>

<script src="<?php echo base_url('assets/admin/') ?>js/pages/datatables.init.js"></script>
<div class="floating_btn">
    <a style="text-decoration: none;" target="_blank" href="https://wa.me/+919487833674?text=Hi, Thirumanam Admin">
      <div class="contact_icon">
       <i class="fab fa-whatsapp"></i>
      </div>
    </a>
    <p class="text_icon">Helpdesk</p>
  
</div>


  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>


$(document).ready(function(){

  var partner_Expectation = $('#partner_Expectation').val();
   if(partner_Expectation=='OTHERS')
   {
      $('#partner_Other_Expectation').show();
   }else
   {
      $('#partner_Other_Expectation').hide();
   }
});

    $(document).ready(function()
{ 
       $(document).bind("contextmenu",function(e){
              return false;
       }); 
});



 $('#confirm_btn').click(function() {
        var reason_closed = $('#reason_closed').val();
         var reason_closed_other = $('#reason_closed_other').val();
         // alert(reason_closed_other);
       if($('#confirm_yes').is(':checked')) { 
            $.ajax({
                type: 'GET',
                url: "<?=base_url()?>WelcomeController/closeAccount/yes",
                data: '&reason_closed='+reason_closed+'&reason_closed_other='+reason_closed_other,
                success: function(response) {
                    setTimeout(
                    function() 
                    {
                       location.reload();
                    }, 0001); 
                }
            });
       }
       else if($('#confirm_no').is(':checked')) { 
                $.ajax({
                url: "<?=base_url()?>WelcomeController/closeAccount/no",
                success: function(response) {
                setTimeout(
                    function() 
                    {
                       location.reload();
                    }, 0001); 
                }
            });
        }
    });

    $('#reopen_btn').click(function() {
       if($('#confirm_yes2').is(':checked')) { 
            $.ajax({
                url: "<?=base_url()?>WelcomeController/reOpenAccount/yes",
                success: function(response) {
                    setTimeout(
                    function() 
                    {
                       location.reload();
                    }, 0001); 
                }
            });
       }
       else if($('#confirm_no2').is(':checked')) { 
                $.ajax({
                url: "<?=base_url()?>WelcomeController/reOpenAccount/no",
                success: function(response) {
                setTimeout(
                    function() 
                    {
                       location.reload();
                    }, 0001); 
                }
            });
        }
    });


function confirm_accept(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/confirm_accept',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function confirm_reject(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/confirm_reject',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

$("input[name$='check']").click(function() {
        var test = $(this).val();
        // alert(test);
        if(test=='yes'){
            $("#close_reason").show();
        }else{
            $("#close_reason").hide();
            $('#other_close_reason').hide();
        }
        
    });

    $("#reason_closed").change(function(){
    var reason = $(this).find(':selected').attr('value');

    console.log(reason);
    if(reason=='OTHERS'){
        $('#other_close_reason').show();
    }else{

         $('#other_close_reason').hide();
    }
  
});

    $(document).ready(function(){
var pop = $('#pop_up').val();
// alert(pop);
   if(pop=='ok'){
        $('#staticBackdrop').modal('show');
   } 
});
    
$("#profile_image").change(function () {
    document.getElementById('pimage_preview').src = window.URL.createObjectURL(this.files[0])
    $("#save_button_section").show();
});

$("#save_image").click(function(e) {
    e.preventDefault();
    // alert('asdas');
    $('#profile_image_form').submit();
    // $('#profile_model').modal('show');
})
$("#save").click(function(e) {
    e.preventDefault();
    // alert('asdas');
    $('#profile_image_form').submit();
})
</script>
<script>

$("#permanent_states").change(function(){
    var state_id = $(this).find(':selected').attr('data-id');

    console.log(state_id);

  var base_url=$('#base_url').val();
    $.ajax({
      type: 'GET',
      url: base_url+'get_city_of_state_ajax_front',
      data: '&state_id='+state_id,
      success:function(html)
      {            
        $('#citys_ajax_output').html(html);            
      }
  }); 
});

$("#marital_status").change(function(){
    var marital = $(this).find(':selected').attr('data-id');

    console.log(marital);
    if(marital==2 || marital==3 || marital==4)
    {
    $("#no_of_child").show();
    $("#child_live_place").show();
    }
    if(marital==1)
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

$("#permanent_states").change(function(){
    var state = $(this).find(':selected').attr('value');

    console.log(state);
    if(state=='OTHERS'){
        $('#permanent_city_other').show();
    }else{

        $('#permanent_city_other').hide();
    }
  
});
if($("#permanent_states").val()=='OTHERS'){
        $('#permanent_city_other').show();
    }else{

        $('#permanent_city_other').hide();
    }

// $("#Number_of_married_brothers").change(function(){
    
// var brother_maried = $(this).find(':selected').attr('data');
// var no_brother = $('#Number_of_brothers').find(':selected').attr('data');
// // var no_brother = $('#Number_of_brothers').val();
// console.log(brother_maried);
// // console.log(no_brother);
//    // alert(no_brother);
//     if(no_brother >= brother_maried){
//     }else{
//          alert('invalid Married  Brothers');
//          $('#Number_of_married_brothers').prop('selectedIndex',0)
//     }
    
// });

// $("#Number_of_married_sisters").change(function(){
    
// var brother_maried = $(this).find(':selected').attr('data');
// var no_brother = $('#Number_of_Sisters').find(':selected').attr('data');
// // var no_brother = $('#Number_of_brothers').val();
// console.log(brother_maried);
// // console.log(no_brother);
//    // alert(no_brother);
//     if(no_brother >= brother_maried){
//     }else{
//          alert('invalid Married  Brothers');
//          $('#Number_of_married_sisters').prop('selectedIndex',0)
//     }
    
// });

function brother()
{
    var no_brother = $('#Number_of_brothers').find(':selected').attr('data');
    var brother_maried = $('#Number_of_married_brothers').find(':selected').attr('data');

   
    
    // var no_brother = $('#Number_of_brothers').val();
    console.log(brother_maried);
    // console.log(no_brother);
       // alert(no_brother);
    if(no_brother >= brother_maried){


    }else{
         alert('invalid Married sister detailes');
         $('#Number_of_married_brothers').prop('selectedIndex',0)
    }

} 

function sister()
{
    

    var no_sister = $('#Number_of_Sisters').find(':selected').attr('data');
    var sister_maried = $('#Number_of_married_sisters').find(':selected').attr('data');
    
    // var no_brother = $('#Number_of_brothers').val();
    console.log(sister_maried);
    // console.log(no_brother);
       // alert(no_brother);
    if(no_sister >= sister_maried){


    }else{
         alert('invalid Married sister detailes');
         $('#Number_of_married_sisters').prop('selectedIndex',0)
    }

}   

    function load_all_msg(thread_id){
        $("#msg_body").html("<div class='text-center' id='payment_loader'><i class='fas fa-redo-alt fa-5x fa-spin'></i></div>");
        $("#message_text").attr('disabled', true);
        $("#msg_send_btn").attr('disabled', true);
        var base_url=$('#base_url').val();
        $.ajax({
            type: "POST",
            url: base_url+"WelcomeController/get_messages/"+thread_id+"/all_msg",
            cache: false,
            success: function(response) {
                $("#message_text").removeAttr('disabled');
                $("#msg_send_btn").removeAttr('disabled');
                $("#msg_body").html(response);
            }
        });
    }

    function msg_send(thread, from, to){
        if ($("#message_text").val().length != 0) {
            var form_data = ($("#message_form").serialize());
            $("#message_text").attr('disabled', 'disabled');
            $("#msg_send_btn").attr('disabled', 'disabled');
            $("#msg_send_btn").html("<i class='fa fa-refresh fa-spin'></i>");
            var base_url=$('#base_url').val();
            $.ajax({
                type: "POST",
                url: base_url+"WelcomeController/send_message/"+thread+"/"+from+"/"+to,
                data: form_data,
                success: function(response) {
                    // alert('done');
                    $("#message_text").removeAttr('disabled');
                    $("#message_text").val('');
                    $("#msg_send_btn").html("Send");
                    $.ajax({
                        type: "POST",
                        url: base_url+"WelcomeController/get_messages/"+thread,
                        cache: false,
                        success: function(response) {
                            $("#msg_body").html(response);
                        }
                    });
                }
            });
        }
    }


function open_message_box(thread_id, now){

$("#msg_body").html("<div class='text-center' id='payment_loader'><i class='fas fa-redo-alt fa-5x fa-spin'></i></div>");
$("#msg_box_header").html("<a class='c-base-1' target='_blank' href='http://192.168.0.126/ci/thirumanam_new/short_view/"+$(now).find('.contacts-list-name').data('member')+"'>"+$(now).find('.contacts-list-name').html()+"</a>");
$("#msg_refresh").html("<a style='cursor:pointer;' onclick='refresh_msg("+thread_id+")'><i class='fas fa-sync-alt'></i> Refresh</a>");
var base_url=$('#base_url').val();
$.ajax({
    type: "POST",
    url: base_url+"WelcomeController/get_messages/"+thread_id,
    cache: false,
    success: function(response) {
        /*clearInterval(message_interval);
        var message_interval =  setInterval(function(){
                                    $("#msg_body").load('https://thirumanam.info/home/get_messages/'+thread_id);
                                }, 4000);*/
        $("#msg_body").removeAttr("style");
        $("#message_text").removeAttr('disabled');
        $("#msg_send_btn").removeAttr('disabled');
        $("#message_text").val('');
        $("#msg_body").html(response);
    }
});
}

 function refresh_msg(thread_id){
        $(".contacts-list").find("#thread_"+thread_id).click();
    }
document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable1", {        
    ajax: base_url+"FrontAjaxController/interestMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});


document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable2", {        
    ajax: base_url+"FrontAjaxController/shortlistMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable3", {        
    ajax: base_url+"FrontAjaxController/followedMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable4", {        
    ajax: base_url+"FrontAjaxController/ignoreMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable5", {        
    ajax: base_url+"FrontAjaxController/viewedMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable6", {        
    ajax: base_url+"FrontAjaxController/notifyMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

document.addEventListener("DOMContentLoaded", function() {
var base_url=$('#base_url').val();
new DataTable("#datatable7", {        
    ajax: base_url+"FrontAjaxController/viewedmeMembers",
    success: function(data) {
        console.log(data);
    },
    error: function() {
        alert('Error occured');
    },
    // dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "print", "pdf"]
    })
});

   
    $(document).ready(function(){
        //$('.swiper-container').swiper();
        $("#vid_main :input").prop("disabled", true);
        load_swiper();
    });
    function video_section()
    {
        $("#btn_vid").hide();
        $("#vid_detail").show();
        $("#vid_main :input").prop("disabled", false);
        /*$("#image_extra").prop('disabled', false);
        $("#image_extra").prop('required', true);*/
    }
    function video_sector(upload_type) {
        if (upload_type == 'upload') {
            $('#video_share').hide('slow');
            $('#video_upload').show('slow');
            $('#video_link').removeAttr('required');
        } else if (upload_type == 'share') {
            $('#video_upload').hide('slow');
            $('#video_share').show('slow');
            $('#video_link').attr("required", true);
        }
    }

    function preview(v_link) {
        var site = $('.site').val();
        // alert(site);
        if (site == 'youtube') {
            var x = v_link.split('=');
            var video_link = x[1];
        } else if (site == 'dailymotion') {
            var temp = v_link.split('/');
            var x = temp[4].split('_');
            var video_link = x[0];
        } else if (site == 'vimeo') {
            var x = v_link.split('/');
            var video_link = x[3];
        }
        //alert(video_link);
        $('#vl').val(video_link);
        $('#video_preview').load('<?php echo base_url();?>WelcomeController/storyVideoPreview/'+site+'/'+video_link);
    }

    function edit_section(section)
    {
        $('#info_'+section).hide();
        $('#edit_'+section).show();
    }
    function load_section(section)
    {

        $('#info_'+section).show();
        $('#edit_'+section).hide();
    }
    function gallery_load(section)
    {

        $('#info_'+section).hide();
        $('#edit_'+section).show();
    }
    function gallery_back(section)
    {

        $('#info_'+section).show();
        $('#edit_'+section).hide();
    }




</script>
<script>
const slides = document.querySelectorAll('.slides');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');
const dots = document.querySelectorAll('.dot')


let index = 0;

// Adding opacity to first dot on first time

dots[0].style.opacity='1'

// positioning the slides

slides.forEach((slide,index)=>{
  slide.style.left=`${index*100}%`
});


// move slide function

const moveSlide = () =>{
  slides.forEach((slide)=>{
    slide.style.transform=`translateX(-${index*100}%)`;
  });
}

// remove dots opacity 1 from all dots

const removeDotsOpacity = () =>{
  dots.forEach((dot)=>{
    dot.style.opacity='.2';
  });
}

dots.forEach((dot,i)=>{
  dot.addEventListener("click",(e)=>{
    index=i;
    removeDotsOpacity();
    e.target.style.opacity='1'
    moveSlide();
  })
});

// show the previous slide

prevBtn.addEventListener('click',()=>{
  if(index===0) return index;
  index--;
  removeDotsOpacity();
  dots[index].style.opacity='1'
  moveSlide();
});

// show the next slide

nextBtn.addEventListener('click',()=>{
  if(index===slides.length-1) return index;
  index++;
  removeDotsOpacity();
  dots[index].style.opacity='1'
  moveSlide();
});

// auto play slide

const autoPlaySlide = () =>{
  removeDotsOpacity();
  if(index===slides.length-1) index= -1;
  index++;
  dots[index].style.opacity='1'
  moveSlide();
}

window.onload=()=>{
  setInterval(autoPlaySlide,6000);
}
</script>

  
  <script>
    $(document).ready(function(){
  setTimeout(function(){
            $('#flash').fadeOut();
          },3000);
    });

    window.ga = function () {
      ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('set', 'anonymizeIp', true);
    ga('set', 'transport', 'beacon');
    ga('send', 'pageview')
  </script>
  <script src="www.google-analytics.com/analytics.js" async></script>


  <script>

    function save_introduction(section){
 $('#info_introduction').show();   
                   $('#edit_introduction').hide();
  
         $.ajax({
            type: "GET",
            url: "<?=base_url()?>WelcomeController/update"+section+
            "?introduction="+$('#introduction').val()+
            "&member_id="+$('#member_id').val(), 
            // data: $('#form_'+section).serialize(),                     
            success: function(response) { 
            $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);              
           

           var obj = JSON.parse(response);   
            
            
              

              $('#introduction_val').html(obj['introduction']);  
              
                  $('#info_introduction').show();   
                   $('#edit_introduction').hide();
  
            }
        });

    }
    function save_basicInfo(section){

        var first_name = $('#first_name').val();
        var marital_status = $('#marital_status').val();
        if(first_name==""){
                $("#first_name").css('border-color', "red");
            }else{
                $("#first_name").css('border-color', "");
            }
        if(marital_status==""){
            $("#marital_status").css('border-color', "red");
            
        }else{
          $("#marital_status").css('border-color', "");  
        }
        if(first_name=="" || marital_status==""){


           
            $('#success-alert15').show();
                  setTimeout(function(){
                        $('#success-alert15').hide();
                      },3000);
        }
        else{


         $.ajax({
            type: "GET",
            url: "<?=base_url()?>WelcomeController/update"+section+"?first_name="+$('#first_name').val()+"&email="+$('#email').val()+"&marital_status="+$('#marital_status').val()+"&number_of_children="+$('#number_of_children').val()+"&Child_living_place="+$('#Child_living_place').val()+
            "&member_id="+$('#member_id').val(),                      
            success: function(response) { 
            $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);            
           var obj = JSON.parse(response);   
                  $('#first_name_val').html(obj['first_name']);
                  $('#email_val').html(obj['email']);
                  $('#marital_status_val').html(obj['marital_status']); 
                  $('#info_basic_information').show();   
                  $('#edit_basic_information').hide();
  
            }
        });
     }
    }
    function save_Education(section){
    
        var Type_of_study = $('#Type_of_study').val();
        var STUDY_DETAILS = $('#STUDY_DETAILS').val();
        var annual_income = $('#annual_income').val();
        
        if(Type_of_study==""){
            $("#Type_of_study").css('border-color', "red");
        }else{
                $("#Type_of_study").css('border-color', "");
            }
        if(STUDY_DETAILS==""){
                $("#STUDY_DETAILS").css('border-color', "red");
            }else{
                $("#STUDY_DETAILS").css('border-color', "");
            }
        if(annual_income==""){
            $("#annual_income").css('border-color', "red");
            
        }else{
          $("#annual_income").css('border-color', "");  
        }
        if(STUDY_DETAILS=="" || annual_income=="" || Type_of_study==""){


           
            $('#success-alert15').show();
                  setTimeout(function(){
                        $('#success-alert15').hide();
                      },3000);
        }
        else{
         $.ajax({
            type: "GET",
            url: "<?=base_url()?>WelcomeController/update"+section+"?Type_of_study="+$('#Type_of_study').val()+"&other_study="+$('#other_study').val()+"&STUDY_DETAILS="+$('#STUDY_DETAILS').val()+"&Type_of_occupation="+$('#Type_of_occupation').val()+"&Other_Occupation_Details="+$('#Other_Occupation_Details').val()+"&Career_Profile="+$('#Career_Profile').val()+"&Earnings="+$('#Earnings').val()+"&annual_income="+$('#annual_income').val()+"&member_id="+$('#member_id').val(),                      
            success: function(response) {  
            $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);           
           var obj = JSON.parse(response);   
                  $('#Type_of_study_val').html(obj['Type_of_study']);
                  $('#Type_of_occupation_val').html(obj['Type_of_occupation']);
                  $('#STUDY_DETAILS_val').html(obj['STUDY_DETAILS']);
                  $('#Career_Profile_val').html(obj['Career_Profile']);
                  $('#Earnings_val').html(obj['Earnings']);
                  $('#annual_income_val').html(obj['annual_income']); 
                  $('#info_education').show();   
                  $('#edit_education').hide();
  
            }
        });

     }
    }

    function save_Phisical(section){
            

        var height = $('#height').val();
        if(height==""){
            $("#height").css('border-color', "red");
        }else{
            $("#height").css('border-color', "");
        }
           
        if(height==""){


           
            $('#success-alert15').show();
                  setTimeout(function(){
                        $('#success-alert15').hide();
                      },3000);
        }
        else{

         $.ajax({
            type: "POST",
            url: "<?=base_url()?>WelcomeController/update"+section,
            data: $('#form_'+section).serialize(),                      
            success: function(response) {  
            $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);           
           var obj = JSON.parse(response);   
                  $('#height_val').html(obj['height']);
                  $('#weight_val').html(obj['weight']);
                  $('#eye_color_val').html(obj['eye_color']);
                  $('#hair_color_val').html(obj['hair_color']);
                  $('#complexion_val').html(obj['complexion']);
                  $('#blood_group_val').html(obj['blood_group']); 
                  $('#body_type_val').html(obj['body_type']); 
                  $('#body_art_val').html(obj['body_art']);
                  $('#any_disability_val').html(obj['any_disability']); 
                  $('#info_physical_attributes').show();   
                  $('#edit_physical_attributes').hide();
  
            }
        });

    }
}

function save_Astronomic(section){

    var date_of_birth = $('#date_of_birth').val();
    var birthDay = $('#birthDay').val();
    var city_of_birth = $('#city_of_birth').val();
    var paksha = $('#paksha').val();
    var paksha_other = $('#paksha_other').val();
    var star = $('#star').val();
    var PADAM = $('#PADAM').val();
    var LAKKNAM = $('#LAKKNAM').val();
    var HOROSCOPE_MATCHING = $('#HOROSCOPE_MATCHING').val();
    var TITHI = $('#TITHI').val();
    var dosham = $('#dosham').val();
    var TYPE_OF_DOSHAM = $('#TYPE_OF_DOSHAM').val();
    var Other_Dosh = $('#Other_Dosh').val();
    var Year = $('#Year').val();
    var Month = $('#Month').val();
    var Day = $('#Day').val();
    var rashi = $('#rashi').val();
    var DIRECTIONAL_BALANCE = $('#DIRECTIONAL_BALANCE').val();
    var time_of_birth = $('#time_of_birth').val();
        if(date_of_birth==""){
                $("#date_of_birth").css('border-color', "red");
        }else{
            $("#date_of_birth").css('border-color', "");
        }

        // if(birthDay==""){
        //     $("#birthDay").css('border-color', "red");
        // }else{
        //     $("#birthDay").css('border-color', "");
        // }
        if(city_of_birth==""){
            $("#city_of_birth").css('border-color', "red");
        }else{
            $("#city_of_birth").css('border-color', "");
        }

        if(paksha==""){
            $("#paksha").css('border-color', "red");
        }else{
            $("#paksha").css('border-color', "");
        }

        // if(paksha_other==""){
        //     $("#paksha_other").css('border-color', "red");
        // }else{
        //     $("#paksha_other").css('border-color', "");
        // }

        if(star==""){
            $("#star").css('border-color', "red");
        }else{
            $("#star").css('border-color', "");
        }
        if(PADAM==""){
            $("#PADAM").css('border-color', "red");
        }else{
            $("#PADAM").css('border-color', "");
        }
        if(LAKKNAM==""){
            $("#LAKKNAM").css('border-color', "red");
        }else{
            $("#LAKKNAM").css('border-color', "");
        }

        if(HOROSCOPE_MATCHING==""){
            $("#HOROSCOPE_MATCHING").css('border-color', "red");
        }else{
            $("#HOROSCOPE_MATCHING").css('border-color', "");
        }

        if(TITHI==""){
            $("#TITHI").css('border-color', "red");
        }else{
            $("#TITHI").css('border-color', "");
        }

        if(dosham==""){
            $("#dosham").css('border-color', "red");
        }else{
            $("#dosham").css('border-color', "");
        }
        // if(TYPE_OF_DOSHAM==""){
        //     $("#TYPE_OF_DOSHAM").css('border-color', "red");
        // }else{
        //     $("#TYPE_OF_DOSHAM").css('border-color', "");
        // }
        // if(Other_Dosh==""){
        //     $("#Other_Dosh").css('border-color', "red");
        // }else{
        //     $("#Other_Dosh").css('border-color', "");
        // }

        if(Year==""){
            $("#Year").css('border-color', "red");
        }else{
            $("#Year").css('border-color', "");
        }

        if(Month==""){
            $("#Month").css('border-color', "red");
        }else{
            $("#Month").css('border-color', "");
        }

        if(Day==""){
            $("#Day").css('border-color', "red");
        }else{
            $("#Day").css('border-color', "");
        }
        if(rashi==""){
            $("#rashi").css('border-color', "red");
        }else{
            $("#rashi").css('border-color', "");
        }
         if(DIRECTIONAL_BALANCE==""){
            $("#DIRECTIONAL_BALANCE").css('border-color', "red");
        }else{
            $("#DIRECTIONAL_BALANCE").css('border-color', "");
        }
         if(time_of_birth==""){
            $("#time_of_birth").css('border-color', "red");
        }else{
            $("#time_of_birth").css('border-color', "");
        }
           
        if(date_of_birth=="" || city_of_birth=="" || paksha=="" || star=="" || PADAM=="" || LAKKNAM=="" || HOROSCOPE_MATCHING=="" || TITHI=="" || dosham=="" || Month=="" || Day=="" || Year==""  || rashi=="" || DIRECTIONAL_BALANCE=="" || time_of_birth==""){


           
            $('#success-alert15').show();
                  setTimeout(function(){
                        $('#success-alert15').hide();
                      },3000);
        }
        else{

 $.ajax({
    type: "POST",
    url: "<?=base_url()?>WelcomeController/update"+section,
    data: $('#form_'+section).serialize(),                      
    success: function(response) { 
        $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);
            console.log(response);       
   var obj = JSON.parse(response);   
          $('#date_of_birth_val').html(obj['date_of_birth']);
          $('#birthDay_val').html(obj['birthDay']);
          $('#time_of_birth_val').html(obj['time_of_birth']);
          $('#city_of_birth_val').html(obj['city_of_birth']);
          $('#PAKSHA_val').html(obj['PAKSHA']);
          $('#Other_Paksha_val').html(obj['Other_Paksha']); 
          $('#star_val').html(obj['star']); 
          $('#PADAM_val').html(obj['PADAM']);
          $('#LAKKNAM_val').html(obj['LAKKNAM']);
          $('#HOROSCOPE_MATCHING_val').html(obj['HOROSCOPE_MATCHING']);
          $('#TITHI_val').html(obj['TITHI']);
          $('#DOSHAM_val').html(obj['DOSHAM']);
          $('#TYPE_OF_DOSHAM_val').html(obj['TYPE_OF_DOSHAM']);
          $('#Other_Dosham_val').html(obj['Other_Dosham']);
          $('#Year_val').html(obj['Year']);
          $('#Month_val').html(obj['Month']);
          $('#Day_val').html(obj['Day']);
          $('#rashi_val').html(obj['rashi']); 
          $('#info_astronomic_information').show();   
          $('#edit_astronomic_information').hide();

    }
});

}
}
function save_Permanent(section){


    var permanent_states = $('#permanent_states').val();
    var citys_ajax_output = $('#citys_ajax_output').val();
    var permanent_city_others = $('#permanent_city_others').val();
    var permanent_postal_code = $('#permanent_postal_code').val();
    var address = $('#address').val();
    var mobile = $('#mobile').val();
    
    if(permanent_states=='OTHERS'){

        if(permanent_city_others==""){
                $("#permanent_city_others").css('border-color', "red");
                var city = "";
        }else{
            $("#permanent_city_others").css('border-color', "");
                var city = permanent_city_others;
        } 

    }else{

        if(citys_ajax_output==""){
                $("#citys_ajax_output").css('border-color', "red");
                var city = "";
        }else{
            $("#citys_ajax_output").css('border-color', "");
                var city = citys_ajax_output;
        } 

    }
    
        if(permanent_states==""){
                $("#permanent_states").css('border-color', "red");
        }else{
            $("#permanent_states").css('border-color', "");
        }
        if(permanent_postal_code==""){
                $("#permanent_postal_code").css('border-color', "red");
        }else{
            $("#permanent_postal_code").css('border-color', "");
        }
        if(address==""){
                $("#address").css('border-color', "red");
        }else{
            $("#address").css('border-color', "");
        }
        

    if(permanent_states=="" || permanent_postal_code=="" || address=="" || city==""){


       
        $('#success-alert15').show();
              setTimeout(function(){
                    $('#success-alert15').hide();
                  },3000);
    }
    else{

 $.ajax({
    type: "POST",
    url: "<?=base_url()?>WelcomeController/update"+section,
    data: $('#form_'+section).serialize(),                      
    success: function(response) { 
    $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);            
   var obj = JSON.parse(response); 
            // if(obj['permanent_state']=='OTHERS'){
            //     $('#permanent_city_other').show();
            // }else{

            //     $('#permanent_city_other').hide();
            // }  
          $('#permanent_country_val').html(obj['permanent_country']);
          $('#permanent_state_val').html(obj['permanent_state']);
          $('#permanent_city_other_val').html(obj['permanent_city_other']);
          $('#permanent_city_val').html(obj['permanent_city']);
          $('#permanent_address_val').html(obj['address']);
          $('#permanent_postal_val').html(obj['permanent_postal']);
          $('#mobile_val').html(obj['mobile']);
          $('#alternate_number_val').html(obj['alternate_number']); 
          $('#landline_val').html(obj['landline']); 
          $('#info_permanent_address').show();   
          $('#edit_permanent_address').hide();

    }
});

}
}

function save_Familyinformation(section){
    var Surname = $('#Surname').val();
    var Soveran_Details = $('#Soveran_Details').val();
    var father = $('#father').val();
    var mother = $('#mother').val();
    var father_vangusam = $('#father_vangusam').val();
    var mother_vangusam = $('#mother_vangusam').val();
    var family_type = $('#family_type').val();
    var Number_of_brothers = $('#Number_of_brothers').val();
    var Number_of_married_brothers = $('#Number_of_married_brothers').val();
    var Number_of_Sisters = $('#Number_of_Sisters').val();
    var Number_of_married_sisters = $('#Number_of_married_sisters').val();
    var Property_Description = $('#Property_Description').val();
    
        if(Surname==""){
                $("#Surname").css('border-color', "red");
        }else{
            $("#Surname").css('border-color', "");
        }

        if(Soveran_Details==""){
            $("#Soveran_Details").css('border-color', "red");
        }else{
            $("#Soveran_Details").css('border-color', "");
        }
        if(father==""){
            $("#father").css('border-color', "red");
        }else{
            $("#father").css('border-color', "");
        }

        if(mother==""){
            $("#mother").css('border-color', "red");
        }else{
            $("#mother").css('border-color', "");
        }

        if(father_vangusam==""){
            $("#father_vangusam").css('border-color', "red");
        }else{
            $("#father_vangusam").css('border-color', "");
        }
        if(mother_vangusam==""){
            $("#mother_vangusam").css('border-color', "red");
        }else{
            $("#mother_vangusam").css('border-color', "");
        }
        if(family_type==""){
            $("#family_type").css('border-color', "red");
        }else{
            $("#family_type").css('border-color', "");
        }
        if(Number_of_brothers==""){
            $("#Number_of_brothers").css('border-color', "red");
        }else{
            $("#Number_of_brothers").css('border-color', "");
        }

        // if(Number_of_married_brothers==""){
        //     $("#Number_of_married_brothers").css('border-color', "red");
        // }else{
        //     $("#Number_of_married_brothers").css('border-color', "");
        // }

        if(Number_of_Sisters==""){
            $("#Number_of_Sisters").css('border-color', "red");
        }else{
            $("#Number_of_Sisters").css('border-color', "");
        }

        // if(Number_of_married_sisters==""){
        //     $("#Number_of_married_sisters").css('border-color', "red");
        // }else{
        //     $("#Number_of_married_sisters").css('border-color', "");
        // }
        if(Property_Description==""){
            $("#Property_Description").css('border-color', "red");
        }else{
            $("#Property_Description").css('border-color', "");
        }
        
           
        if(Surname=="" || Soveran_Details=="" || father=="" || mother=="" || father_vangusam=="" || mother_vangusam==""  || family_type==""  || Number_of_brothers=="" ||  Number_of_Sisters=="" || Property_Description==""){


           
            $('#success-alert15').show();
                  setTimeout(function(){
                        $('#success-alert15').hide();
                      },3000);
        }
        else{
 $.ajax({
    type: "POST",
    url: "<?=base_url()?>WelcomeController/update"+section,
    data: $('#form_'+section).serialize(),                      
    success: function(response) {  
    $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);           
   var obj = JSON.parse(response);   
          $('#Surname_val').html(obj['Surname']);
          $('#Soveran_Details_val').html(obj['Soveran_Details']);
          $('#father_val').html(obj['father']);
          $('#mother_val').html(obj['mother']);
          $('#father_vangusam_val').html(obj['father_vangusam']);
          $('#other_father_vang_val').html(obj['other_father_vang']);
          $('#mother_vangusam_val').html(obj['mother_vangusam']); 
          $('#other_mother_vang_val').html(obj['other_mother_vang']);
          $('#family_type_val').html(obj['family_type']);
          $('#Number_of_brothers_val').html(obj['Number_of_brothers']);
          $('#Number_of_married_brothers_val').html(obj['Number_of_married_brothers']);
          $('#Number_of_Sisters_val').html(obj['Number_of_Sisters']);
          $('#Number_of_married_sisters_val').html(obj['Number_of_married_sisters']); 
          $('#Property_Description_val').html(obj['Property_Description']); 
          $('#Other_property_description_val').html(obj['Other_property_description']); 
          $('#info_family_information').show();   
          $('#edit_family_information').hide();

    }
});

}
}

function save_Partner(section){

 $.ajax({
    type: "POST",
    url: "<?=base_url()?>WelcomeController/update"+section,
    data: $('#form_'+section).serialize(),                      
    success: function(response) { 
    $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);            
   var obj = JSON.parse(response);   
          if(obj['with_children_acceptables']==1){
            var with_child = 'yes';
          }else if(obj['with_children_acceptables']==2){
            var with_child = 'no';
          }else if(obj['with_children_acceptables']==3){

            var with_child = "Doesn't Matter";
          }else{
            var with_child = "";
          }
          $('#partner_age_val').html(obj['partner_age']);
          $('#partner_height_val').html(obj['partner_height']);
          $('#partner_weight_val').html(obj['partner_weight']);
          $('#partner_any_disability_val').html(obj['partner_any_disability']);
          $('#partner_marital_status_val').html(obj['partner_marital_status']);
          $('#with_children_acceptables_val').html(with_child);
          $('#partner_body_type_val').html(obj['partner_body_type']); 
          $('#partner_education_val').html(obj['partner_education']);
          $('#partner_profession_val').html(obj['partner_profession']);
          $('#partner_DOSHAM_val').html(obj['partner_DOSHAM']);
          $('#partner_TYPE_OF_DOSHAM_val').html(obj['partner_TYPE_OF_DOSHAM']);
          $('#partner_Other_Dosham_val').html(obj['partner_Other_Dosham']);
          $('#partner_Expectation_val').html(obj['partner_Expectation']); 
          $('#partner_Other_Expectation_val').html(obj['partner_Other_Expectation']); 
          $('#info_partner_expectation').show();   
          $('#edit_partner_expectation').hide();

    }
});

}

function save_Chart(section){
    
 $.ajax({
    type: "POST",
    url: "<?=base_url()?>WelcomeController/update"+section,
    data: $('#form_'+section).serialize(),                      
    success: function(response) {  
    $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);           
   var obj = JSON.parse(response);   
          $('#f010').html(obj['f011']);
          $('#f011').html(obj['f011']);
          $('#f012').html(obj['f012']);
          $('#f013').html(obj['f013']);
          $('#f014').html(obj['f014']);
          $('#f015').html(obj['f015']);
          $('#f020').html(obj['f020']);
          $('#f021').html(obj['f021']);
          $('#f022').html(obj['f022']);
          $('#f023').html(obj['f023']);

          $('#f024').html(obj['f024']);
          $('#f025').html(obj['f025']);
          $('#f030').html(obj['f030']);
          $('#f031').html(obj['f031']);
          $('#f032').html(obj['f032'])
          $('#f033').html(obj['f033']);
          $('#f034').html(obj['f034']);
          $('#f035').html(obj['f035']);
          $('#f040').html(obj['f040']);
          $('#f041').html(obj['f041']);

          $('#f042').html(obj['f042']);
          $('#f043').html(obj['f043']);
          $('#f044').html(obj['f044']);
          $('#f045').html(obj['f045']);
          $('#f110').html(obj['f110']);
          $('#f111').html(obj['f111']);
          $('#f112').html(obj['f112']);
          $('#f113').html(obj['f113']);
          $('#f114').html(obj['f114']);
          $('#f115').html(obj['f115']);

          $('#f210').html(obj['f210']);
          $('#f211').html(obj['f211']);
          $('#f212').html(obj['f212']);
          $('#f213').html(obj['f213']);
          $('#f214').html(obj['f214']);
          $('#f215').html(obj['f215']);

          $('#f310').html(obj['f310']);
          $('#f311').html(obj['f311']);
          $('#f312').html(obj['f312']);
          $('#f313').html(obj['f313']);
          $('#f314').html(obj['f314']);
          $('#f315').html(obj['f315']);

          $('#f320').html(obj['f320']);
          $('#f321').html(obj['f321']);
          $('#f322').html(obj['f322']);
          $('#f323').html(obj['f323']);
          $('#f324').html(obj['f324']);
          $('#f325').html(obj['f325']);

          $('#f410').html(obj['f410']);
          $('#f411').html(obj['f411']);
          $('#f412').html(obj['f412']);
          $('#f413').html(obj['f413']);
          $('#f414').html(obj['f414']);
          $('#f415').html(obj['f415']);

          $('#f420').html(obj['f420']);
          $('#f421').html(obj['f421']);
          $('#f422').html(obj['f422']);
          $('#f423').html(obj['f423']);
          $('#f424').html(obj['f424']);
          $('#f425').html(obj['f425']);

          $('#f430').html(obj['f430']);
          $('#f431').html(obj['f431']);
          $('#f432').html(obj['f432']);
          $('#f433').html(obj['f433']);
          $('#f434').html(obj['f434']);
          $('#f435').html(obj['f435']);

          $('#f440').html(obj['f440']);
          $('#f441').html(obj['f441']);
          $('#f442').html(obj['f442']);
          $('#f443').html(obj['f443']);
          $('#f444').html(obj['f444']);
          $('#f445').html(obj['f445']);

          $('#f510').html(obj['f510']);
          $('#f511').html(obj['f511']);
          $('#f512').html(obj['f512']);
          $('#f513').html(obj['f513']);
          $('#f514').html(obj['f514']);
          $('#f515').html(obj['f515']);

          $('#f520').html(obj['f520']);
          $('#f521').html(obj['f521']);
          $('#f522').html(obj['f522']);
          $('#f523').html(obj['f523']);
          $('#f524').html(obj['f524']);
          $('#f525').html(obj['f525']);

          $('#f530').html(obj['f530']);
          $('#f531').html(obj['f531']);
          $('#f532').html(obj['f532']);
          $('#f533').html(obj['f533']);
          $('#f534').html(obj['f534']);
          $('#f535').html(obj['f535']);

          $('#f540').html(obj['f540']);
          $('#f541').html(obj['f541']);
          $('#f542').html(obj['f542']);
          $('#f543').html(obj['f543']);
          $('#f544').html(obj['f544']);
          $('#f545').html(obj['f545']);

          $('#f610').html(obj['f610']);
          $('#f611').html(obj['f611']);
          $('#f612').html(obj['f612']);
          $('#f613').html(obj['f613']);
          $('#f614').html(obj['f614']);
          $('#f615').html(obj['f615']);

          $('#f710').html(obj['f710']);
          $('#f711').html(obj['f711']);
          $('#f712').html(obj['f712']);
          $('#f713').html(obj['f713']);
          $('#f714').html(obj['f714']);
          $('#f715').html(obj['f715']);

          $('#f810').html(obj['f810']);
          $('#f811').html(obj['f811']);
          $('#f812').html(obj['f812']);
          $('#f813').html(obj['f813']);
          $('#f814').html(obj['f814']);
          $('#f815').html(obj['f815']);

          $('#f820').html(obj['f820']);
          $('#f821').html(obj['f821']);
          $('#f822').html(obj['f822']);
          $('#f823').html(obj['f823']);
          $('#f824').html(obj['f824']);
          $('#f825').html(obj['f825']);

          $('#f910').html(obj['f910']);
          $('#f911').html(obj['f911']);
          $('#f912').html(obj['f912']);
          $('#f913').html(obj['f913']);
          $('#f914').html(obj['f914']);
          $('#f915').html(obj['f915']);

          $('#f920').html(obj['f920']);
          $('#f921').html(obj['f921']);
          $('#f922').html(obj['f922']);
          $('#f923').html(obj['f923']);
          $('#f924').html(obj['f924']);
          $('#f925').html(obj['f925']);

          $('#f930').html(obj['f930']);
          $('#f931').html(obj['f931']);
          $('#f932').html(obj['f932']);
          $('#f933').html(obj['f933']);
          $('#f934').html(obj['f934']);
          $('#f935').html(obj['f935']);

          $('#f940').html(obj['f940']);
          $('#f941').html(obj['f941']);
          $('#f942').html(obj['f942']);
          $('#f943').html(obj['f943']);
          $('#f944').html(obj['f944']);
          $('#f945').html(obj['f945']);
          $('#info_chart').show();   
          $('#edit_chart').hide();


    }
});

}

function save_All(section){

    var first_name = $('#first_name').val();
    var marital_status = $('#marital_status').val();
   
   var Type_of_study = $('#Type_of_study').val();
    var STUDY_DETAILS = $('#STUDY_DETAILS').val();
    var annual_income = $('#annual_income').val();
    

    var date_of_birth = $('#date_of_birth').val();
    var birthDay = $('#birthDay').val();
    var city_of_birth = $('#city_of_birth').val();
    var paksha = $('#paksha').val();
    var paksha_other = $('#paksha_other').val();
    var star = $('#star').val();
    var PADAM = $('#PADAM').val();
    var LAKKNAM = $('#LAKKNAM').val();
    var HOROSCOPE_MATCHING = $('#HOROSCOPE_MATCHING').val();
    var TITHI = $('#TITHI').val();
    var dosham = $('#dosham').val();
    var TYPE_OF_DOSHAM = $('#TYPE_OF_DOSHAM').val();
    var Other_Dosh = $('#Other_Dosh').val();
    var Year = $('#Year').val();
    var Month = $('#Month').val();
    var Day = $('#Day').val();
    var rashi = $('#rashi').val();
    var DIRECTIONAL_BALANCE = $('#DIRECTIONAL_BALANCE').val();
    var time_of_birth = $('#time_of_birth').val();
        
           

    var Surname = $('#Surname').val();
    var Soveran_Details = $('#Soveran_Details').val();
    var father = $('#father').val();
    var mother = $('#mother').val();
    var father_vangusam = $('#father_vangusam').val();
    var mother_vangusam = $('#mother_vangusam').val();
    var family_type = $('#family_type').val();
    var Number_of_brothers = $('#Number_of_brothers').val();
    var Number_of_married_brothers = $('#Number_of_married_brothers').val();
    var Number_of_Sisters = $('#Number_of_Sisters').val();
    var Number_of_married_sisters = $('#Number_of_married_sisters').val();
    var Property_Description = $('#Property_Description').val();

    var permanent_states = $('#permanent_states').val();
    var citys_ajax_output = $('#citys_ajax_output').val();
    var permanent_city_others = $('#permanent_city_others').val();
    var permanent_postal_code = $('#permanent_postal_code').val();
    var address = $('#address').val();
    var mobile = $('#mobile').val();
    var height = $('#height').val();
    if(permanent_states=='OTHERS'){

        if(permanent_city_others==""){
                $("#permanent_city_others").css('border-color', "red");
                var city = "";
        }else{
            $("#permanent_city_others").css('border-color', "");
                var city = permanent_city_others;
        } 

    }else{

        if(citys_ajax_output==""){
                $("#citys_ajax_output").css('border-color', "red");
                var city = "";
        }else{
            $("#citys_ajax_output").css('border-color', "");
                var city = citys_ajax_output;
        } 

    }
    
        if(permanent_states==""){
                $("#permanent_states").css('border-color', "red");
        }else{
            $("#permanent_states").css('border-color', "");
        }
        if(permanent_postal_code==""){
                $("#permanent_postal_code").css('border-color', "red");
        }else{
            $("#permanent_postal_code").css('border-color', "");
        }
        if(address==""){
                $("#address").css('border-color', "red");
        }else{
            $("#address").css('border-color', "");
        }
        
       
         if(first_name==""){
            $("#first_name").css('border-color', "red");
        }else{
            $("#first_name").css('border-color', "");
        }
        if(marital_status==""){
            $("#marital_status").css('border-color', "red");
            
        }else{
          $("#marital_status").css('border-color', "");  
        }

        if(Type_of_study==""){
            $("#Type_of_study").css('border-color', "red");
        }else{
            $("#Type_of_study").css('border-color', "");
        }

        if(STUDY_DETAILS==""){
            $("#STUDY_DETAILS").css('border-color', "red");
        }else{
            $("#STUDY_DETAILS").css('border-color', "");
        }
        if(annual_income==""){
            $("#annual_income").css('border-color', "red");
            
        }else{
          $("#annual_income").css('border-color', "");  
        }

        var height = $('#height').val();
        if(height==""){
            $("#height").css('border-color', "red");
        }else{
            $("#height").css('border-color', "");
        }

        if(date_of_birth==""){
                $("#date_of_birth").css('border-color', "red");
        }else{
            $("#date_of_birth").css('border-color', "");
        }

        // if(birthDay==""){
        //     $("#birthDay").css('border-color', "red");
        // }else{
        //     $("#birthDay").css('border-color', "");
        // }
        if(city_of_birth==""){
            $("#city_of_birth").css('border-color', "red");
        }else{
            $("#city_of_birth").css('border-color', "");
        }

        if(paksha==""){
            $("#paksha").css('border-color', "red");
        }else{
            $("#paksha").css('border-color', "");
        }

        // if(paksha_other==""){
        //     $("#paksha_other").css('border-color', "red");
        // }else{
        //     $("#paksha_other").css('border-color', "");
        // }

        if(star==""){
            $("#star").css('border-color', "red");
        }else{
            $("#star").css('border-color', "");
        }
        if(PADAM==""){
            $("#PADAM").css('border-color', "red");
        }else{
            $("#PADAM").css('border-color', "");
        }
        if(LAKKNAM==""){
            $("#LAKKNAM").css('border-color', "red");
        }else{
            $("#LAKKNAM").css('border-color', "");
        }

        if(HOROSCOPE_MATCHING==""){
            $("#HOROSCOPE_MATCHING").css('border-color', "red");
        }else{
            $("#HOROSCOPE_MATCHING").css('border-color', "");
        }

        if(TITHI==""){
            $("#TITHI").css('border-color', "red");
        }else{
            $("#TITHI").css('border-color', "");
        }

        if(dosham==""){
            $("#dosham").css('border-color', "red");
        }else{
            $("#dosham").css('border-color', "");
        }
        // if(TYPE_OF_DOSHAM==""){
        //     $("#TYPE_OF_DOSHAM").css('border-color', "red");
        // }else{
        //     $("#TYPE_OF_DOSHAM").css('border-color', "");
        // }
        // if(Other_Dosh==""){
        //     $("#Other_Dosh").css('border-color', "red");
        // }else{
        //     $("#Other_Dosh").css('border-color', "");
        // }

        if(Year==""){
            $("#Year").css('border-color', "red");
        }else{
            $("#Year").css('border-color', "");
        }

        if(Month==""){
            $("#Month").css('border-color', "red");
        }else{
            $("#Month").css('border-color', "");
        }

        if(Day==""){
            $("#Day").css('border-color', "red");
        }else{
            $("#Day").css('border-color', "");
        }
        if(rashi==""){
            $("#rashi").css('border-color', "red");
        }else{
            $("#rashi").css('border-color', "");
        }
         if(DIRECTIONAL_BALANCE==""){
            $("#DIRECTIONAL_BALANCE").css('border-color', "red");
        }else{
            $("#DIRECTIONAL_BALANCE").css('border-color', "");
        }
         if(time_of_birth==""){
            $("#time_of_birth").css('border-color', "red");
        }else{
            $("#time_of_birth").css('border-color', "");
        }

        if(Surname==""){
                $("#Surname").css('border-color', "red");
        }else{
            $("#Surname").css('border-color', "");
        }

        if(Soveran_Details==""){
            $("#Soveran_Details").css('border-color', "red");
        }else{
            $("#Soveran_Details").css('border-color', "");
        }
        if(father==""){
            $("#father").css('border-color', "red");
        }else{
            $("#father").css('border-color', "");
        }

        if(mother==""){
            $("#mother").css('border-color', "red");
        }else{
            $("#mother").css('border-color', "");
        }

        if(father_vangusam==""){
            $("#father_vangusam").css('border-color', "red");
        }else{
            $("#father_vangusam").css('border-color', "");
        }
        if(mother_vangusam==""){
            $("#mother_vangusam").css('border-color', "red");
        }else{
            $("#mother_vangusam").css('border-color', "");
        }
        if(family_type==""){
            $("#family_type").css('border-color', "red");
        }else{
            $("#family_type").css('border-color', "");
        }
        if(Number_of_brothers==""){
            $("#Number_of_brothers").css('border-color', "red");
        }else{
            $("#Number_of_brothers").css('border-color', "");
        }

        // if(Number_of_married_brothers==""){
        //     $("#Number_of_married_brothers").css('border-color', "red");
        // }else{
        //     $("#Number_of_married_brothers").css('border-color', "");
        // }

        if(Number_of_Sisters==""){
            $("#Number_of_Sisters").css('border-color', "red");
        }else{
            $("#Number_of_Sisters").css('border-color', "");
        }

        // if(Number_of_married_sisters==""){
        //     $("#Number_of_married_sisters").css('border-color', "red");
        // }else{
        //     $("#Number_of_married_sisters").css('border-color', "");
        // }
        if(Property_Description==""){
            $("#Property_Description").css('border-color', "red");
        }else{
            $("#Property_Description").css('border-color', "");
        }
        
           
        if(Surname=="" || Soveran_Details=="" || father=="" || mother=="" || father_vangusam=="" || mother_vangusam==""  || family_type==""  || Number_of_brothers=="" || Number_of_Sisters=="" || Property_Description=="" || date_of_birth=="" || city_of_birth=="" || paksha=="" || star=="" || PADAM=="" || LAKKNAM=="" || HOROSCOPE_MATCHING=="" || TITHI=="" || dosham=="" || Month=="" || Day=="" || Year==""  || rashi=="" || DIRECTIONAL_BALANCE=="" || time_of_birth=="" || height=="" || first_name=="" || marital_status=="" || STUDY_DETAILS=="" || annual_income=="" || Type_of_study=="" || permanent_states=="" || permanent_postal_code=="" || address=="" || city==""){


           
            $('#success-alert15').show();
                  setTimeout(function(){
                        $('#success-alert15').hide();
                      },3000);
        }
        else{

 $.ajax({
    type: "GET",
    url: "<?=base_url()?>WelcomeController/update"+section+
            "?introduction="+$('#introduction').val()+
            "&member_id="+$('#member_id').val(), 
    data: $('#form_BasicInfo,#form_Education,#form_Physical,#form_Astronomic,#form_Permanent,#form_PartnerExpectation,#form_Chart,#form_Familyinformation').serialize(),                      
    success: function(response) {  
        console.log(response);
    $('#success-alert10').show();
            setTimeout(function(){
            $('#success-alert10').hide();
          },3000);           
   var obj = JSON.parse(response);
          $('#introduction_val').html(obj['introduction']);  
          $('#info_introduction').show();   
          $('#edit_introduction').hide();
    
          $('#first_name_val').html(obj['first_name']);
          $('#email_val').html(obj['email']);
          $('#marital_status_val').html(obj['marital_status']); 
          $('#info_basic_information').show();   
          $('#edit_basic_information').hide();


          $('#Type_of_study_val').html(obj['Type_of_study']);
          $('#Type_of_occupation_val').html(obj['Type_of_occupation']);
          $('#STUDY_DETAILS_val').html(obj['STUDY_DETAILS']);
          $('#Career_Profile_val').html(obj['Career_Profile']);
          $('#Earnings_val').html(obj['Earnings']);
          $('#annual_income_val').html(obj['annual_income']); 
          $('#info_education').show();   
          $('#edit_education').hide();


          $('#height_val').html(obj['height']);
          $('#weight_val').html(obj['weight']);
          $('#eye_color_val').html(obj['eye_color']);
          $('#hair_color_val').html(obj['hair_color']);
          $('#complexion_val').html(obj['complexion']);
          $('#blood_group_val').html(obj['blood_group']); 
          $('#body_type_val').html(obj['body_type']); 
          $('#body_art_val').html(obj['body_art']);
          $('#any_disability_val').html(obj['any_disability']); 
          $('#info_physical_attributes').show();   
          $('#edit_physical_attributes').hide();


          $('#date_of_birth_val').html(obj['date_of_birth']);
          $('#birthDay_val').html(obj['birthDay']);
          $('#time_of_birth_val').html(obj['time_of_birth']);
          $('#city_of_birth_val').html(obj['city_of_birth']);
          $('#PAKSHA_val').html(obj['PAKSHA']);
          $('#Other_Paksha_val').html(obj['Other_Paksha']); 
          $('#star_val').html(obj['star']); 
          $('#PADAM_val').html(obj['PADAM']);
          $('#LAKKNAM_val').html(obj['LAKKNAM']);
          $('#HOROSCOPE_MATCHING_val').html(obj['HOROSCOPE_MATCHING']);
          $('#TITHI_val').html(obj['TITHI']);
          $('#DOSHAM_val').html(obj['DOSHAM']);
          $('#TYPE_OF_DOSHAM_val').html(obj['TYPE_OF_DOSHAM']);
          $('#Other_Dosham_val').html(obj['Other_Dosham']);
          $('#Year_val').html(obj['Year']);
          $('#Month_val').html(obj['Month']);
          $('#Day_val').html(obj['Day']);
          $('#rashi_val').html(obj['rashi']); 
          $('#info_astronomic_information').show();   
          $('#edit_astronomic_information').hide();

          

          $('#permanent_country_val').html(obj['permanent_country']);
          $('#permanent_state_val').html(obj['permanent_state']);
          $('#permanent_city_other_val').html(obj['permanent_city_other']);
          $('#permanent_city_val').html(obj['permanent_city']);
          $('#permanent_address_val').html(obj['address']);
          $('#permanent_postal_val').html(obj['permanent_postal']);
          $('#mobile_val').html(obj['mobile']);
          $('#alternate_number_val').html(obj['alternate_number']); 
          $('#landline_val').html(obj['landline']); 
          $('#info_permanent_address').show();   
          $('#edit_permanent_address').hide();


          $('#Surname_val').html(obj['Surname']);
          $('#Soveran_Details_val').html(obj['Soveran_Details']);
          $('#father_val').html(obj['father']);
          $('#mother_val').html(obj['mother']);
          $('#father_vangusam_val').html(obj['father_vangusam']);
          $('#other_father_vang_val').html(obj['other_father_vang']);
          $('#mother_vangusam_val').html(obj['mother_vangusam']); 
          $('#other_mother_vang_val').html(obj['other_mother_vang']);
          $('#family_type_val').html(obj['family_type']);
          $('#Number_of_brothers_val').html(obj['Number_of_brothers']);
          $('#Number_of_married_brothers_val').html(obj['Number_of_married_brothers']);
          $('#Number_of_Sisters_val').html(obj['Number_of_Sisters']);
          $('#Number_of_married_sisters_val').html(obj['Number_of_married_sisters']); 
          $('#Property_Description_val').html(obj['Property_Description']); 
          $('#Other_property_description_val').html(obj['Other_property_description']); 
          $('#info_family_information').show();   
          $('#edit_family_information').hide();

          if(obj['with_children_acceptables']==1){
            var with_child = 'yes';
          }else if(obj['with_children_acceptables']==2){
            var with_child = 'no';
          }else{

            var with_child = "Doesn't Matter";
          }

          $('#partner_age_val').html(obj['partner_age']);
          $('#partner_height_val').html(obj['partner_height']);
          $('#partner_weight_val').html(obj['partner_weight']);
          $('#partner_any_disability_val').html(obj['partner_any_disability']);
          $('#partner_marital_status_val').html(obj['partner_marital_status']);
          $('#with_children_acceptables_val').html(with_child);
          $('#partner_body_type_val').html(obj['partner_body_type']); 
          $('#partner_education_val').html(obj['partner_education']);
          $('#partner_profession_val').html(obj['partner_profession']);
          $('#partner_DOSHAM_val').html(obj['partner_DOSHAM']);
          $('#partner_TYPE_OF_DOSHAM_val').html(obj['partner_TYPE_OF_DOSHAM']);
          $('#partner_Other_Dosham_val').html(obj['partner_Other_Dosham']);
          $('#partner_Other_Expectation_val').html(obj['partner_Other_Expectation']); 
          $('#info_partner_expectation').show();   
          $('#edit_partner_expectation').hide();


          $('#f010').html(obj['f010']);
          $('#f011').html(obj['f011']);
          $('#f012').html(obj['f012']);
          $('#f013').html(obj['f013']);
          $('#f014').html(obj['f014']);
          $('#f015').html(obj['f015']);
          $('#f020').html(obj['f020']);
          $('#f021').html(obj['f021']);
          $('#f022').html(obj['f022']);
          $('#f023').html(obj['f023']);

          $('#f024').html(obj['f024']);
          $('#f025').html(obj['f025']);
          $('#f030').html(obj['f030']);
          $('#f031').html(obj['f031']);
          $('#f032').html(obj['f032'])
          $('#f033').html(obj['f033']);
          $('#f034').html(obj['f034']);
          $('#f035').html(obj['f035']);
          $('#f040').html(obj['f040']);
          $('#f041').html(obj['f041']);

          $('#f042').html(obj['f042']);
          $('#f043').html(obj['f043']);
          $('#f044').html(obj['f044']);
          $('#f045').html(obj['f045']);
          $('#f110').html(obj['f110']);
          $('#f111').html(obj['f111']);
          $('#f112').html(obj['f112']);
          $('#f113').html(obj['f113']);
          $('#f114').html(obj['f114']);
          $('#f115').html(obj['f115']);

          $('#f210').html(obj['f210']);
          $('#f211').html(obj['f211']);
          $('#f212').html(obj['f212']);
          $('#f213').html(obj['f213']);
          $('#f214').html(obj['f214']);
          $('#f215').html(obj['f215']);

          $('#f310').html(obj['f310']);
          $('#f311').html(obj['f311']);
          $('#f312').html(obj['f312']);
          $('#f313').html(obj['f313']);
          $('#f314').html(obj['f314']);
          $('#f315').html(obj['f315']);

          $('#f320').html(obj['f320']);
          $('#f321').html(obj['f321']);
          $('#f322').html(obj['f322']);
          $('#f323').html(obj['f323']);
          $('#f324').html(obj['f324']);
          $('#f325').html(obj['f325']);

          $('#f410').html(obj['f410']);
          $('#f411').html(obj['f411']);
          $('#f412').html(obj['f412']);
          $('#f413').html(obj['f413']);
          $('#f414').html(obj['f414']);
          $('#f415').html(obj['f415']);

          $('#f420').html(obj['f420']);
          $('#f421').html(obj['f421']);
          $('#f422').html(obj['f422']);
          $('#f423').html(obj['f423']);
          $('#f424').html(obj['f424']);
          $('#f425').html(obj['f425']);

          $('#f430').html(obj['f430']);
          $('#f431').html(obj['f431']);
          $('#f432').html(obj['f432']);
          $('#f433').html(obj['f433']);
          $('#f434').html(obj['f434']);
          $('#f435').html(obj['f435']);

          $('#f440').html(obj['f440']);
          $('#f441').html(obj['f441']);
          $('#f442').html(obj['f442']);
          $('#f443').html(obj['f443']);
          $('#f444').html(obj['f444']);
          $('#f445').html(obj['f445']);

          $('#f510').html(obj['f510']);
          $('#f511').html(obj['f511']);
          $('#f512').html(obj['f512']);
          $('#f513').html(obj['f513']);
          $('#f514').html(obj['f514']);
          $('#f515').html(obj['f515']);

          $('#f520').html(obj['f520']);
          $('#f521').html(obj['f521']);
          $('#f522').html(obj['f522']);
          $('#f523').html(obj['f523']);
          $('#f524').html(obj['f524']);
          $('#f525').html(obj['f525']);

          $('#f530').html(obj['f530']);
          $('#f531').html(obj['f531']);
          $('#f532').html(obj['f532']);
          $('#f533').html(obj['f533']);
          $('#f534').html(obj['f534']);
          $('#f535').html(obj['f535']);

          $('#f540').html(obj['f540']);
          $('#f541').html(obj['f541']);
          $('#f542').html(obj['f542']);
          $('#f543').html(obj['f543']);
          $('#f544').html(obj['f544']);
          $('#f545').html(obj['f545']);

          $('#f610').html(obj['f610']);
          $('#f611').html(obj['f611']);
          $('#f612').html(obj['f612']);
          $('#f613').html(obj['f613']);
          $('#f614').html(obj['f614']);
          $('#f615').html(obj['f615']);

          $('#f710').html(obj['f710']);
          $('#f711').html(obj['f711']);
          $('#f712').html(obj['f712']);
          $('#f713').html(obj['f713']);
          $('#f714').html(obj['f714']);
          $('#f715').html(obj['f715']);

          $('#f810').html(obj['f810']);
          $('#f811').html(obj['f811']);
          $('#f812').html(obj['f812']);
          $('#f813').html(obj['f813']);
          $('#f814').html(obj['f814']);
          $('#f815').html(obj['f815']);

          $('#f820').html(obj['f820']);
          $('#f821').html(obj['f821']);
          $('#f822').html(obj['f822']);
          $('#f823').html(obj['f823']);
          $('#f824').html(obj['f824']);
          $('#f825').html(obj['f825']);

          $('#f910').html(obj['f910']);
          $('#f911').html(obj['f911']);
          $('#f912').html(obj['f912']);
          $('#f913').html(obj['f913']);
          $('#f914').html(obj['f914']);
          $('#f915').html(obj['f915']);

          $('#f920').html(obj['f920']);
          $('#f921').html(obj['f921']);
          $('#f922').html(obj['f922']);
          $('#f923').html(obj['f923']);
          $('#f924').html(obj['f924']);
          $('#f925').html(obj['f925']);

          $('#f930').html(obj['f930']);
          $('#f931').html(obj['f931']);
          $('#f932').html(obj['f932']);
          $('#f933').html(obj['f933']);
          $('#f934').html(obj['f934']);
          $('#f935').html(obj['f935']);

          $('#f940').html(obj['f940']);
          $('#f941').html(obj['f941']);
          $('#f942').html(obj['f942']);
          $('#f943').html(obj['f943']);
          $('#f944').html(obj['f944']);
          $('#f945').html(obj['f945']);
          $('#info_chart').show();   
          $('#edit_chart').hide();


    }
});
}
}

$(document).ready(function(){
        profile_load('','');
    });
    function profile_load(page,sp){
        //alert('here');
        if (typeof message_interval !== 'undefined') {
            clearInterval(message_interval);
        }
        if(page !== '')
        {
            $.ajax({
                url: "<?php echo base_url();?>profile/"+page,
                success: function(response) {
                    $("#profile_load").html(response);
                    if(page == 'messaging'){
                        $('body').find('#thread_'+sp).click();
                    }
                    // window.scrollTo(0, 0);
                    if ($(window).width() < 992 && sp == 'alt-sm') {
                        $("html, body").animate({
                          scrollTop: $('.sidebar.sidebar-inverse').offset().top + $('.sidebar.sidebar-inverse').outerHeight(true) - 100
                        }, 500);
                    }else if (sp != 'no') {
                        $(".btn-back-to-top").click();
                    }
                }
            });
            $('.p_nav').removeClass("active");
            $('.l_nav').removeClass("li_active");
            $('.m_nav').removeClass("m_nav_active");

            if (page!='gallery'||page!='happy_story'||page!='my_packages'||page!='payments' ||page=='change_pass'||page=='picture_privacy') {
                $('.'+page).addClass("active");
                $('.m_'+page).addClass("m_nav_active");
            } 
            if (page=='gallery'||page=='happy_story'||page=='my_packages'||page=='payments' ||page=='change_pass'||page=='picture_privacy') {
                $('.'+page).addClass("li_active");
            }
            
        }
    }



  function confirm_message(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/confirm_message',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

function enable_message(m_id) 
{
            $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>WelcomeController/enableMessage/"+m_id,
                    cache: false,
                    success: function(response) {
                        $('#success-alert16').show();
                      setTimeout(function(){
                        $('#success-alert16').hide();
                      },3000);
                        location.reload();
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }, 500); // <-- time in milliseconds
}

  function doInterest(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/doInterestMatchMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function addInterest(m_id) 
{
            $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>WelcomeController/addInterestMatchMember/"+m_id,
                    cache: false,
                    success: function(response) {
                        $('#myModal'+m_id).modal('hide');
                        $('#success-alert2').show();
                      setTimeout(function(){
                        $('#success-alert2').hide();
                      },3000);
                    // location.reload();
                      location.reload()
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }, 500); // <-- time in milliseconds
}
function do_shortlist(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>WelcomeController/add_shortlist/"+m_id,
            cache: false,
            success: function(response) {
                $('#success-alert').show();
              setTimeout(function(){
                $('#success-alert').hide();
              },3000);
                location.reload();
            },
            fail: function (error) {
                alert(error);
            }
        });
    }, 500);
}
function remove_shortlist(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>WelcomeController/remove_shortlist/"+m_id,
            cache: false,
            success: function(response) {
                $('#success-alert3').show();
              setTimeout(function(){
                $('#success-alert3').hide();
              },3000);
                location.reload();
            },
            fail: function (error) {
                alert(error);
            }
        });
    }, 500);
}
function do_follow(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>WelcomeController/addfollowMatchMember/"+m_id,
            cache: false,
            success: function(response) {
                // $("#message12").html(<?php echo translate('you_have_followed_this_member!')?>);
                $('#success-alert4').show();
              setTimeout(function(){
                $('#success-alert4').hide();
              },3000);
                location.reload();
            },
            fail: function (error) {
                alert(error);
            }
        });
    }, 500);
}
function do_unfollow(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>WelcomeController/unfollowMatchMember/"+m_id,
            cache: false,
            success: function(response) {
                // $("#message12").html(<?php echo translate('you_have_followed_this_member!')?>);
                $('#success-alert5').show();
              setTimeout(function(){
                $('#success-alert5').hide();
              },3000);
                location.reload();
            },
            fail: function (error) {
                alert(error);
            }
        });
    }, 500);
}
function confirm_ignore(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/confirm_ignoreMatchMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function do_ignore(m_id) 
{
            $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>WelcomeController/do_ignoreMatchMember/"+m_id,
                    cache: false,
                    success: function(response) {
                        $('#success-alert6').show();
                      setTimeout(function(){
                        $('#success-alert6').hide();
                      },3000);
                location.reload();
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }, 500); // <-- time in milliseconds
}
function add_report(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/add_reportMatchMember',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function do_report(m_id) 
{
        var id = $("#report_id").val();
        var details = $("#report_details").val();
            $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>WelcomeController/do_reportMatchMember/"+m_id,
                    data: "details="+details,
                    cache: false,
                    success: function(response) {
                        $('#success-alert7').show();
                      setTimeout(function(){
                        $('#success-alert7').hide();
                      },3000);
                    location.reload();
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }, 500); // <-- time in milliseconds
} 

function add_married(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'WelcomeController/add_reportMarried',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
function do_married(m_id) 
{
        var id = $("#report_id").val();
        var details = $("#report_details").val();
            $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>WelcomeController/do_reportMarried/"+m_id,
                    data: "details="+details,
                    cache: false,
                    success: function(response) {
                        $('#myModal2').modal('hide');
                        $('#matchModal').modal('show');
                        location.reload();  
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }, 500); // <-- time in milliseconds
} 
            
function edit_all()
    {
        $('#info_introduction').hide();
        $('#edit_introduction').show();
        $('#info_basic_information').hide();
        $('#edit_basic_information').show();
        $('#info_education').hide();
        $('#edit_education').show();
        $('#info_physical_attributes').hide();
        $('#edit_physical_attributes').show();
        $('#info_astronomic_information').hide();
        $('#edit_astronomic_information').show();
        $('#info_permanent_address').hide();
        $('#edit_permanent_address').show();
        $('#info_family_information').hide();
        $('#edit_family_information').show();
        $('#info_partner_expectation').hide();
        $('#edit_partner_expectation').show();
        $('#info_chart').hide();
        $('#edit_chart').show();
    }
</script>