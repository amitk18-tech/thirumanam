<style type="text/css">

 /* whats app button css */

.floating_btn {
  position: fixed;
  height: 130px;
  width: 50px;
  left: 85%;
  bottom: 30px;
  z-index: 9999999999;
}
@media (max-width: 420px){
    .floating_btn {
    left: 75%;
}
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
<!-- <div class="floating_btn">
    <a style="text-decoration: none;" target="_blank" href="https://wa.me/+919487833674?text=Hi, Thirumanam Admin">
      <div class="contact_icon">
       <i class="fab fa-whatsapp"></i>
      </div>
    </a>
    <p class="text_icon">Helpdesk</p>
  
</div> -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="interestModalLabel"><?php echo translate('re-open_account')?></h6>
        <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <h6><?php echo translate('to_colse_your_account_we_want_some_informations._please_answer_the_question_below') ?></h6>
        <p class="text-center">
            <?php echo translate('are_you_sure_to_re-open_the_account?');?>
        </p>
        <div class="row">
            <div class="col-12">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_yes2" value="yes" style="margin-right: 5px !important;">
                    <label><?php echo translate('yes')?></label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_no2" value="no" style="margin-right: 5px !important;">
                    <label><?php echo translate('no')?></label>
                </div>
            </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
        <button type="button" class="btn btn-primary" id="reopen_btn"><?php echo translate('Confirm')?></button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModalTwo" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="interestModalLabel"><?php echo translate('close_account')?></h6>
        <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <h6><?php echo translate('to_colse_your_account_we_want_some_informations._please_answer_the_question_below') ?></h6>
        <p class="text-center">
            <?php echo translate('do_you_realy_want_to_close_your_account?');?>
        </p>
        <div class="row">
            <div class="col-12" style="margin-left: 40%;">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_yes" value="yes" style="margin-right: 5px !important;">
                    <label><?php echo translate('yes')?></label>
                </div>
            </div>
            <div class="col-12" style="margin-left: 40%;">
                <div class="form-group d-flex" style="width:15px">
                    <input type="radio" name="check" id="confirm_no" value="no" style="margin-right: 5px !important;">
                    <label><?php echo translate('no')?></label>
                </div>
            </div>
            <div class="col-12 mt-3" style="display: none;" id="close_reason">
                <div class="form-group d-flex">
                    <select class="form-control" name="reason_closed" id="reason_closed">
                      <option value=""><?php echo translate('choose_one');?></option>
                      <option value="fixed">fixed</option>
                      <option value="OTHERS"><?php echo translate('OTHERS');?></option>
                    </select>
                </div>
            </div>
            <div class="col-12 mt-3" style="display: none;" id="other_close_reason">
                <div class="form-group d-flex">
                    <textarea type="text" name="reason_closed_other" id="reason_closed_other" class="form-control"></textarea>
                </div>
            </div>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo translate('close');?></button>
        <button type="button" class="btn btn-primary" id="confirm_btn"><?php echo translate('Confirm')?></button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="profile_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo translate('image');?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
         $member = getData('member','row',array('member_id'=>$member_id));?>
         <?php if($member->image_count>0){?>
         <h5>Remain profile Upload : <?php echo $member->image_count;?> Of 3</h5>
        <?php }else{ ?>
        <h5>Remain profile Upload  Was Completed</h5>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary"  data-dismiss="modal"><?php echo translate('close')?></button>
        <?php if($member->image_count>0){?>
        <button type="button" id="save" class="btn btn-primary"><?php echo translate('save')?></button>
        <?php } ?>
      </div>
    </div>
  </div>
</div>


<!-- All JavaScript Files-->

<script src="<?php echo base_url('assets/app/')?>js/popper.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/bootstrap.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/waypoints.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/jquery.easing.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/owl.carousel.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/jquery.animatedheadline.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/jquery.counterup.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/wow.min.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/default/date-clock.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/default/dark-mode-switch.js"></script>

<script src="<?php echo base_url('assets/app/')?>js/default/active.js"></script>




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


<script>


$(document).ready(function()
    { 
       $(document).bind("contextmenu",function(e){
              return false;
       }); 
    });



     $(document).ready(function(){
        setTimeout(function(){
            $('#app_flash').fadeOut();
          },3000);
        
   
        var pop = $('#pop_up').val();
        // alert(pop);
           if(pop=='ok'){
                $('#staticBackdrop').modal('show');
           } 
        });
            
        $("#profile_image").change(function () {
            document.getElementById('pimage_preview').src = window.URL.createObjectURL(this.files[0])
            $("#load_image_section").hide();

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
            $('#confirm_btn').click(function() {
        var reason_closed = $('#reason_closed').val();
         var reason_closed_other = $('#reason_closed_other').val();
         // alert(reason_closed_other);
       if($('#confirm_yes').is(':checked')) { 
            $.ajax({
                type: 'GET',
                url: "<?=base_url()?>AppController/closeAccount/yes",
                data: '&reason_closed='+reason_closed+'&reason_closed_other='+reason_closed_other,
                success: function(response) {
                       location.reload(); 
                }
            });
       }
       else if($('#confirm_no').is(':checked')) { 
                $.ajax({
                url: "<?=base_url()?>AppController/closeAccount/no",
                success: function(response) {
                       location.reload(); 
                }
            });
        }
    });

    $('#reopen_btn').click(function() {
        
       if($('#confirm_yes2').is(':checked')) { 
            $.ajax({
                url: "<?=base_url()?>AppController/reOpenAccount/yes",
                success: function(response) {
                       location.reload();
                }
            });
       }
       else if($('#confirm_no2').is(':checked')) { 
                $.ajax({
                url: "<?=base_url()?>AppController/reOpenAccount/no",
                success: function(response) {
                       location.reload(); 
                }
            });
        }
    });

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
    document.addEventListener("DOMContentLoaded", function() {
    var base_url=$('#base_url').val();
    new DataTable("#datatable1", {        
    ajax: base_url+"AppAjaxController/interestMembers",
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
    ajax: base_url+"AppAjaxController/shortlistMembers",
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
    ajax: base_url+"AppAjaxController/followedMembers",
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
    ajax: base_url+"AppAjaxController/ignoreMembers",
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
    ajax: base_url+"AppAjaxController/viewedMembers",
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

	function edit_all()
    {
        location.href = "<?=base_url()?>app/edit_profile";
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
        // if(mobile==""){
        //         $("#mobile").css('border-color', "red");
        // }else{
        //     $("#mobile").css('border-color', "");
        // }
       
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
        
           
        if(Surname=="" || Soveran_Details=="" || father=="" || mother=="" || father_vangusam=="" || mother_vangusam==""  || family_type==""  || Number_of_brothers=="" || Number_of_Sisters=="" || Property_Description=="" || date_of_birth=="" || city_of_birth=="" || paksha=="" || star=="" || PADAM=="" || LAKKNAM=="" || HOROSCOPE_MATCHING=="" || TITHI=="" || dosham=="" || Month=="" || Day=="" || Year==""  || rashi=="" || DIRECTIONAL_BALANCE=="" || time_of_birth=="" || height=="" || first_name=="" || marital_status=="" || STUDY_DETAILS=="" || annual_income=="" || Type_of_study=="" || permanent_states=="" || permanent_postal_code=="" || address=="" ||  city==""){


           

            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);

        }
        else{
 $.ajax({
    type: "GET",
    url: "<?=base_url()?>AppController/update"+section+
            "?introduction="+$('#introduction').val()+
            "&member_id="+$('#member_id').val(), 
    data: $('#form_BasicInfo,#form_Education,#form_Physical,#form_Astronomic,#form_Permanent,#form_PartnerExpectation,#form_Chart,#form_Familyinformation').serialize(),                      
    success: function(response) {  
        console.log(response);
            $('#success-alert').addClass('alert alert-success');
            $('#success-alert').html('Updated Successfully');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);           
   	  	// location.reload();

            location.href = "<?=base_url()?>app/profile";
    }
});

}

}
 function update(section){

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
        if(section == 'BasicInfo' && (first_name=="" || marital_status=="" )){

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

            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);

        }else if(section == 'Education' && (STUDY_DETAILS=="" || annual_income=="" || Type_of_study=="")){

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

            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);


        }else if(section == 'Physical' && (height=="")){

            if(height==""){
            $("#height").css('border-color', "red");
            }else{
                $("#height").css('border-color', "");
            }
            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);

        }else if(section == 'Astronomic' && (date_of_birth=="" || city_of_birth=="" || paksha=="" || star=="" || PADAM=="" || LAKKNAM=="" || HOROSCOPE_MATCHING=="" || TITHI=="" || dosham=="" || Month=="" || Day=="" || Year==""  || rashi=="" || DIRECTIONAL_BALANCE=="" || time_of_birth=="")){

            if(date_of_birth==""){
                $("#date_of_birth").css('border-color', "red");
            }else{
                $("#date_of_birth").css('border-color', "");
            }

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
            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);

        }else if(section == 'Permanent' && (permanent_states=="" || permanent_postal_code=="" || address=="" || city=="")){

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
            // if(mobile==""){
            //         $("#mobile").css('border-color', "red");
            // }else{
            //     $("#mobile").css('border-color', "");
            // }

            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);


        }else if(section == 'Familyinformation' && (Surname=="" || Soveran_Details=="" || father=="" || mother=="" || father_vangusam=="" || mother_vangusam==""  || family_type==""  || Number_of_brothers=="" || Number_of_Sisters=="" || Property_Description=="")){

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
         
            $('#success-alert').addClass('alert alert-danger');
            $('#success-alert').html('Requierd Fields');
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);

        }else{
  
         $.ajax({
            type: "POST",
            url: "<?=base_url()?>AppController/update"+section,
            data: $('#form_'+section).serialize(),                      
            success: function(response) { 
            $('#success-alert').addClass('alert alert-success');
            $('#success-alert').html('Updated Successfully'); 
            $('#success-alert').show();
            setTimeout(function(){
            $('#success-alert').hide();
          },3000);           
           
  			location.href = "<?=base_url()?>app/profile";
            }
        });

    }

  }

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
if($("#partner_Expectation").val()=='OTHERS'){
        $('#partner_Other_Expectation').show();
    }else{

        $('#partner_Other_Expectation').hide();
    }

$("#permanent_states").change(function(){
    var state_id = $(this).find(':selected').attr('data-id');

    console.log(state_id);

  var base_url=$('#base_url').val();
    $.ajax({
      type: 'GET',
      url: base_url+'get_city_of_state_ajax_app',
      data: '&state_id='+state_id,
      success:function(html)
      {            
        $('#citys_ajax_output').html(html);            
      }
  }); 
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

$(document).ready(function(){
    //get it if Status key found
    if(localStorage.getItem("Status"))
    {
        Toaster.show("The record is added");
        localStorage.clear();
    }
});


  function doInterest(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/doInterestMatchMember',
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
                    url: "<?=base_url()?>AppController/addInterestMatchMember/"+m_id,
                    cache: false,
                    success: function(response) {
                        $('#myModal'+m_id).modal('hide');
                        $('#success-alert').addClass('alert alert-success');
                        $('#success-alert').html('<?php echo translate('you_have_expressed_an_interest_on_this_member!')?>');
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
            }, 500); // <-- time in milliseconds
}
function do_shortlist(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>AppController/add_shortlist/"+m_id,
            cache: false,
            success: function(response) {

                $('#success-alert').addClass('alert alert-success');
                $('#success-alert').html('<?php echo translate('you_have_shortlisted_this_member!')?>');
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
            url: "<?=base_url()?>AppController/remove_shortlist/"+m_id,
            cache: false,
            success: function(response) {
                $('#success-alert').addClass('alert alert-success');
                $('#success-alert').html('<?php echo translate('you_have_removed_this_member_from_shortlist!')?>');
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
function do_follow(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>AppController/addfollowMatchMember/"+m_id,
            cache: false,
            success: function(response) {
                $('#success-alert').addClass('alert alert-success');
                $('#success-alert').html('<?php echo translate('you_have_followed_this_member!')?>');
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
function do_unfollow(m_id) 
{
    $("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
    setTimeout(function() {
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>AppController/unfollowMatchMember/"+m_id,
            cache: false,
            success: function(response) {
                // $("#message12").html(<?php echo translate('you_have_followed_this_member!')?>);
                $('#success-alert').addClass('alert alert-success');
                $('#success-alert').html('<?php echo translate('you_have_unfollowed_this_member!')?>');
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
function confirm_ignore(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/confirm_ignoreMatchMember',
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
                    url: "<?=base_url()?>AppController/do_ignoreMatchMember/"+m_id,
                    cache: false,
                    success: function(response) {
                        $('#myModal'+m_id).modal('hide');
                        $('#success-alert').addClass('alert alert-success');
                        $('#success-alert').html('<?php echo translate('you_have_ignored_this_member!')?>');
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
            }, 500); // <-- time in milliseconds
}
function add_report(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/add_reportMatchMember',
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
                    url: "<?=base_url()?>AppController/do_reportMatchMember/"+m_id,
                    data: "details="+details,
                    cache: false,
                    success: function(response) {
                        $('#myModal'+m_id).modal('hide');
                        $('#success-alert').addClass('alert alert-success');
                        $('#success-alert').html('<?php echo translate('you_have_reported_this_member!')?>');
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
            }, 500); // <-- time in milliseconds
} 

function add_married(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/add_reportMarried',
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
                    url: "<?=base_url()?>AppController/do_reportMarried/"+m_id,
                    data: "details="+details,
                    cache: false,
                    success: function(response) {
                        $('#myModal'+m_id).modal('hide');
                        $('#matchModal').modal('show'); 
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }, 500); // <-- time in milliseconds
} 

function deleteShortlist(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/deleteShortlist',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}


function deleteFollow(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/deleteFollow',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

function add_unfollow(m_id) 
{
$("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
setTimeout(function() {
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>AppController/add_unfollow/"+m_id,
        cache: false,
        success: function(response) {
            $('#success-alert').addClass('alert alert-success');
            $('#success-alert').html('<?php echo translate('you_have_unfollowed_this_member!')?>');
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
}, 500); // <-- time in milliseconds
}

function confirm_unblock(m_id) 
{
  var base_url=$('#base_url').val();
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/confirmUnblock',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}

function unblockMember(m_id) 
{
$("#shortlist").html("<i class='fa fa-spinner'></i> <?php echo translate('shortlisting')?>..");
setTimeout(function() {
    $.ajax({
        type: "POST",
        url: "<?=base_url()?>AppController/unblockMember/"+m_id,
        cache: false,
        success: function(response) {
            $('#myModal'+m_id).modal('hide');
            $('#success-alert').addClass('alert alert-success');
            $('#success-alert').html('<?php echo translate('you_have_unblocked_this_member!')?>');
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
}, 500); // <-- time in milliseconds
}

function Validate() {
            var current_password = document.getElementById("current_password").value;
            // alert(current_password);
            var password = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
            if(!password.match(passw)){
                $('#success-alert').addClass('alert alert-danger');
                 $('#success-alert').html('6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },5000);
            }else if(password != confirmPassword){
                $('#success-alert').addClass('alert alert-danger');
                $('#success-alert').html('Password confirmPassword did not match!!');
                $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
            }else{
            $.ajax({
                    type: "POST",
                    url: "<?=base_url()?>LoginController/apppasswordProfileVerify/",
                    data: '&current_password='+current_password,
                    cache: false,
                    success: function(response) {
                        console.log(response);
                        if(response==2){
                            $('#success-alert').addClass('alert alert-danger');
                            $('#success-alert').html('CurrentPassword did not match!!');
                             $('#success-alert').show();
                          setTimeout(function(){
                            $('#success-alert').hide();
                          },3000);
                        }else{
                             document.getElementById("myForm").submit();
                        }
                       
                        
                    },
                    fail: function (error) {
                        alert(error);
                    }
                });
            }
        }


document.getElementById('confirm_password').onkeyup=function(){
    var password = $("#new_password").val();
    var confirm_password = $("#confirm_password").val();
    if(password != confirm_password) {
           $("#confirm_password").css('border-color', "red");
    }else{
           $("#confirm_password").css('border-color', "green");
        }
}

function open_message_box(thread_id, now){

$("#msg_body").html("<div class='text-center' id='payment_loader'><i class='fas fa-redo-alt fa-5x fa-spin'></i></div>");
$("#msg_box_header").html("<a class='c-base-1' target='_blank' href='http://192.168.0.126/ci/thirumanam_new/app/short_view/"+$(now).find('.contacts-list-name').data('member')+"'>"+$(now).find('.contacts-list-name').html()+"</a>");
$("#msg_refresh").html("<a style='cursor:pointer;' onclick='refresh_msg("+thread_id+")'><i class='fas fa-sync-alt'></i> Refresh</a>");
var base_url=$('#base_url').val();
$.ajax({
    type: "POST",
    url: base_url+"AppController/get_messages/"+thread_id,
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

function msg_send(thread, from, to){
        if ($("#message_text").val().length != 0) {
            var form_data = ($("#message_form").serialize());
            $("#message_text").attr('disabled', 'disabled');
            $("#msg_send_btn").attr('disabled', 'disabled');
            $("#msg_send_btn").html("<i class='fa fa-refresh fa-spin'></i>");
            var base_url=$('#base_url').val();
            $.ajax({
                type: "POST",
                url: base_url+"AppController/send_message/"+thread+"/"+from+"/"+to,
                data: form_data,
                success: function(response) {
                    // alert('done');
                    $("#message_text").removeAttr('disabled');
                    $("#message_text").val('');
                    $("#msg_send_btn").html("Send");
                    // $.ajax({
                    //     type: "POST",
                    //     url: base_url+"AppController/get_messages/"+thread,
                    //     cache: false,
                    //     success: function(response) {
                    //         $("#msg_body").html(response);
                    //         location.reload();
                    //     }
                    // });
                    window.location.href = base_url+"AppController/get_messages/"+thread;
                }
            });
        }
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
        $('#video_preview').load('<?php echo base_url();?>AppController/storyVideoPreview/'+site+'/'+video_link);
    }

 
</script>
