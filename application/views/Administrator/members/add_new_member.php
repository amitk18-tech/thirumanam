<!-- <div id="success-alert12" style="display: none;
     position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 55px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);" class="alert">
    <center><strong>Mobile Number Alredy Exist!!</strong>
    </center>
    
  </div> -->

  <div  id="admin_alert" style="display:none;"  class="alert alert-danger alert-dismissible alert-label-icon label-arrow shadow fade show mb-xl-0 text-end mb-5" role="alert">
    <i class="ri-error-warning-line label-icon"></i><strong>6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter!!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<input type="hidden" id="base_url" value="<?php echo base_url();?>">
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"></h4>
                <div class="flex-shrink-0">
                </div>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                <form id="myForm" action="<?php echo base_url('AdminController/saveMember');?>" method='post'>
                    <div class="row gy-4">
                        
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="basiInput" class="form-label"><?php echo translate('Name');?><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Name" name="first_name" id="first_name" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="labelInput" class="form-label"><?php echo translate('email');?></label>
                                <input type="email" class="form-control" placeholder="Enter Email" name="email">
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="placeholderInput" class="form-label"><?php echo translate('gender');?><span class="text-danger">*</span></label>
                                <select class="form-select" name="gender" id="gender" aria-label="Default select example" required>
                                    <option value = ''><?php echo translate('choose_one');?></option>
                                    <option value = '1'><?php echo translate('Male');?></option>
                                    <option value = '2'><?php echo translate('Female');?></option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label"><?php echo translate('date_of_birth');?><span class="text-danger">*</span></label>
                                <input type="date" onchange="setday(this.value)" class="form-control" placeholder="" name="date_of_birth" id="date_of_birth" required>
                            </div>
                            <input type= "hidden" value="" id="birthDay" name="birthDay" >
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label"><?php echo translate('mobile_no.');?><span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" placeholder="Enter Mobile Number" name="mobile" id="mobile" pattern="[0-9]{5}[0-9]{5}" required>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="basiInput" class="form-label"><?php echo translate('member_type');?> <span class="text-danger">*</span></label>
                                <select class="form-select" name="member_type" aria-label="Default select example" id="member_type" required>
                                    <option value=''><?php echo translate('choose_one');?></option>
                                    <?php 
                                    $i=0;
                                    $drop_down = get_dropdown(27);
                                    foreach($drop_down as $value){ $i++;
                                    ?>

                                    <option data-id="<?php echo $i;?>" value="<?php echo $i?>"><?php echo dropdownTranslate($value->word);?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="labelInput" class="form-label"><?php echo translate('membership_plans');?><span class="text-danger">*</span></label>
                                <select class="form-select" name="current_package" aria-label="Default select example" id="membership_ajax_output" required>
                                    <option value=""><?= translate('select_member_type_first')?></option>
                                </select>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="placeholderInput" class="form-label"><?php echo translate('password');?> <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" placeholder="Enter Password" name="password" id="password" required>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xxl-3 col-md-6">
                            <div>
                                <label for="valueInput" class="form-label"><?php echo translate('confirm_password');?> <span class="text-danger">*</span></label>
                                <input type="Password" class="form-control" placeholder="Enter Confirm Possword" id="cpassword" required>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 text-center mt-5">
                            <div>
                            <button type="button" class="btn btn-success" onclick="return Validate()"><?php echo translate('submit')?></button>
                            </div>
                        </div>
                        
                    </div>
                    <!--end row-->
                </form>
            </div>
                
        </div>

    </div>
</div>
    <!--end col-->
</div>
<!--end row-->
<script>
function setday(day)
{
    
    var d = new Date(day);
    var n = d.getDay()
    var arr = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    $("#birthDay").val(arr[n]);
    console.log(n);
}


function Validate() {
    var first_name = $("#first_name").val();
    var gender = $("#gender").val();
    var date_of_birth = $("#date_of_birth").val();
    var date = new Date($('#date_of_birth').val());
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    var age =  18;
    var mydate = new Date();
    mydate.setFullYear(year, month-1, day);

    var currdate = new Date();
    currdate.setFullYear(currdate.getFullYear() - age);
    var member_type = $("#member_type").val();
    var current_package = $("#membership_ajax_output").val();
    var phone = $("#mobile").val();
    var password = $("#password").val();
    var confirmPassword = $("#cpassword").val();
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    if(first_name ==''){
            $("#first_name").css('border-color', "red");
        }else{
            $("#first_name").css('border-color', "");
        }
        if(gender ==''){
            $("#gender").css('border-color', "red");
        }else{
            $("#gender").css('border-color', "");
        }
        if(phone==""){
             $("#mobile").css('border-color', "red");
        }else{
            $("#mobile").css('border-color', "");
        }
        if(date_of_birth==""){
             $("#date_of_birth").css('border-color', "red");
        }else{
            $("#date_of_birth").css('border-color', "");
        }
        if(member_type==""){
             $("#member_type").css('border-color', "red");
        }else{
            $("#member_type").css('border-color', "");
        }
         if(current_package==""){
             $("#membership_ajax_output").css('border-color', "red");
        }else{
            $("#membership_ajax_output").css('border-color', "");
        }
        if(password==""){
             $("#password").css('border-color', "red");
        }else{
            $("#password").css('border-color', "");
        }
        if(confirmPassword==""){
             $("#cpassword").css('border-color', "red");
        }else{
            $("#cpassword").css('border-color', "");
        }

    if(first_name=="" || gender=="" || date_of_birth=="" || phone=="" || member_type=="" || current_package=="" || password=="" || confirmPassword==""){
        alert("Required Field!!");

    }
    else if(currdate < mydate){
         alert("You must be at least 18 years of age!!");
    }
    // else if(!password.match(passw)){
    //     alert("6 to 20 characters which contain at least one numeric digit, one uppercase and one lowercase letter!!");
    // }
    else if (password != confirmPassword) {
        alert("You Passwords is not similar with Confirmpassword. Please enter same password in both");
        return false;
    }else{
        var phone = $("#mobile").val();
        var gender = $("#gender").val();
        var otp = '';
        URL = "<?=base_url('LoginController/checkAdminPhone')?>";
        $.ajax({
            url: URL,
            data: {'phone': phone,'gender': gender}, // change this to send js object
            type: "post",
            success: function(data){
             console.log(data);
               if(data == 2)
               {
               document.getElementById("myForm").submit();
               }
              else{
                alert('Mobile Number Already Exist!!. Change Mobile Number Or Gender')
                   
              }
            }
        });
    }

}
document.getElementById('cpassword').onkeyup=function(){
            var password = $("#password").val();
            var confirm_password = $("#cpassword").val();
            if(password != confirm_password) {
                   $("#cpassword").css('border-color', "red");
            }
                else{
                   $("#cpassword").css('border-color', "green");
                }
        }
</script>