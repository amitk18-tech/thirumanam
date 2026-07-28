<!DOCTYPE html>
<html  translate="no">
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <meta name="google" content="notranslate">
    <title>Profile Print</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@100&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet" />
    <style>  

     table.fixed { table-layout:fixed;font-size: 15px; }
table.fixed td { overflow: hidden; }
    
    .line2 {
      
    width: 2px;
    height: 46px;
    background-color: black;
    transform: rotate(45deg);
    left: 14px!important;
    top: -7px!important;
    z-index: 99999;
    margin: -3px;
    margin-left: -2px;
    margin-bottom: 7px;


    }
    .line1 {
      
    width: 2px;
    height: 31px;
    background-color: black;
    transform: rotate(45deg);
    left: 9px!important;
    top: -5px!important;
    z-index: 99999;
    margin: -35px;
    margin-left: -6px;
    margin-top: -7px;

    }

    @media print {
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
}

    @media print{
         * {
        -webkit-print-color-adjust: exact;
    }
    }   
    body{
        font-size: 14px;
        font-family: sans-serif;
    }

        .table,.th,.td,.tr{

            border: 1px solid black;
            border-collapse: collapse;

        }
        td,tr,td{
            height: 0px;
            padding:1px!important;

        }
        .table1{

             border: 1px solid black;
             border-collapse: collapse;
        }
        .watermark {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("https://thirumanam.info/uploads/profile_image/water_mark.png") no-repeat;
        background-position: center;
        z-index: -99999;
        border: none !important;
        background-size: 100% !important;
        }

   @media print{     
  .watermark {
    display: block !important;
     position: fixed;
        inset: 0;
  }
}

</style>

</head>

    

<body onload="print_details();"> 
<!-- <body >-->
    
<?php 
$images = json_decode($single_member->profile_image);
$raasis = json_decode($single_member->chart);
$Physics = json_decode($single_member->physical_attributes);
$astronomic = json_decode($single_member->astronomic_information);
$mariage_status = json_decode($single_member->basic_info);
$educations = json_decode($single_member->education_and_career);
$family_member = json_decode($single_member->family_info);
$expectations = json_decode($single_member->partner_expectation);
$permanents = json_decode($single_member->permanent_address);
// print_r($raasis);exit;
if(empty($raasis))
{
    $raasis = array('f010'=>'');
}
?>








<div class="bs-docs-example" id="printableArea">
   <div class="watermark"></div>

        <table>
            <thead>
                
                <th style="padding-left: 350px;"><div style="text-align:center;">உ</div><?=translate('omMurg')?></th>
            </thead>
        </table>
           
           
        <table class="table1" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; font-size: 20px;padding-left: 100px;"><?=translate('heading1')?></th>
                    
                </tr>
            </thead>
            
                <tr>
                    <?php foreach($images as $image){?>
                    <td style="width:100px;padding-bottom:5px" colspan="1" rowspan="5"><img src="<?php echo base_url('uploads/profile_image/print.jpg');?>" style="margin-left: 30px; height: 90px;object-fit: contain;"></td>
                    <?php } ?>
                     <td style="text-align: center;"><?=translate('heading0')?></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><?=translate('heading2')?> ( <?=translate('cell')?> : 94878 33674 )</td>
                    
                </tr>
                <tr>
                    <td style="text-align: center;"><?=translate('heading3')?>,</td>
                </tr>
                <tr>
                    <td style="text-align: center;"><?=translate('heading4')?></td>
                </tr>
                <tr>
                    <td style="text-align: center;">www.thirumanam.info</td>
                </tr>
               
        </table>

        <table style="width: 100%;">
            <tbody>
                <tr>
                    <!-- <td style="width:15%;height: 5%;">Working Days:</td> -->
                    <td>*<?=translate('heading5')?></td>
                    <td class="td" style="padding-left:10px;font-weight: bold;font-size: 15px;"><?php
                        echo translate('registration_no').' : ';
                        if(substr($single_member->member_profile_id,0,1) == 'M')
                            {
                                $one = substr($single_member->member_profile_id,0,4);
                                $trasOne = translate($one);
                                $two = substr($single_member->member_profile_id,4);
                                echo $trasOne.$two;
                            }
                             elseif(substr($single_member->member_profile_id,0,1) == 'F')
                            {
                                $one = substr($single_member->member_profile_id,0,6);
                                $trasOne = translate($one);
                                $two = substr($single_member->member_profile_id,6);
                                echo $trasOne.$two;
                            }
                            else {
                            echo $single_member->member_profile_id;
                            }?></td>
                </tr>
                <tr>
                    <!-- <td>Service Time:</td> -->
                    <td><?=translate('heading6')?></td>
                    <td style="width:35%;padding-left:10px"><?=translate('REGISTERED_DATE')?>: <b><?php echo date('d-m-Y',strtotime($single_member->member_since));?></b></td>


                    
                </tr>   
            </tbody>
        </table>

        <label><?=translate('heading7')?>.</label>
        <table class="table" style="margin-bottom:0px">
            <thead>
                <tr>
                    <th class="th" colspan="2" style="text-align: center; background-color: black;color:white;font-size: 12px;"><?php echo translate('BRIDE_GROOM_DETAILS'); ?></th>
                    
                </tr>
            </thead>
            <?php foreach($astronomic as $astro){?>
                <tr>
                    <?php foreach($images as $image){?>
                    <td  style="width:350px;" class="td"  colspan="1" rowspan="3"><img src="<?php echo base_url('uploads/profile_image/'.$image->profile_image);?>" style="height: 70px;object-fit: contain;"></td>
                    <?php } ?>
                     <td class="td"><?php echo translate('age'); ?>: <?php echo date_diff(date_create($astro->date_of_birth), date_create('today'))->y;?><b></b> </td>
                </tr>
                <tr>
                    <td class="td"><?php echo translate('date_of_birth'); ?>: <b><?php echo date('d-m-Y',strtotime($astro->date_of_birth));?></b></td>
                    
                </tr>
                <tr>
                    <td class="td"><?php echo translate('birthDay'); ?> : <b><?php echo (!empty(dropdownTranslate($astro->birthDay))) ? dropdownTranslate($astro->birthDay) : $astro->birthDay; ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?php echo translate('name'); ?>: <b><?php echo $single_member->first_name; ?></b></td>
                    <td class="td"><?=translate('time_of_birth')?>: <b><?php echo $astro->time_of_birth; ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('height')?>: <b><?php echo $single_member->height;?></b></td>
                    <td class="td"><?=translate('city_of_birth')?>: <b><?php echo $astro->city_of_birth; ?></b></td>
                </tr>
                 <?php foreach($Physics as $physic) { ?>
                <tr>
                    <td class="td"><?=translate('complexion')?> : <b><?php echo $physic->complexion; ?></b></td>
                    <td class="td"><?=translate('PAKSHA')?>: <b><?php echo  ($astro->PAKSHA=='OTHERS' ? $astro->Other_Paksha: dropdownTranslate($astro->PAKSHA)) ; ?></b></td>
                </tr>
                <?php foreach($mariage_status as $mariage){?>
                <tr>
                    <td class="td"><?=translate('marital_status')?> : <b><?php echo dropdownTranslate($mariage->marital_status);?></b></td>
                    <td class="td">--</td>
                </tr>
                <?php  } ?>
                <?php foreach($educations as $education) { ?>
                <tr>
                    <td class="td"><?=translate('education')?>: <b><?php echo  ($education->Type_of_study=='OTHERS' ? $education->other_study: dropdownTranslate($education->Type_of_study )) ; ?></b></td>
                    <td class="td"><?=translate('TITHI')?>: <b><?php echo dropdownTranslate($astro->TITHI); ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('STUDY_DETAILS')?> : <b><?php echo $education->STUDY_DETAILS; ?></b></td>
                    <td class="td"><?=translate('star')?>: <b><?php echo dropdownTranslate($astro->star); ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('occupation')?> :<b><?php echo  ($education->Type_of_occupation=='OTHERS' ? $education->Other_Occupation_Details: dropdownTranslate($education->Type_of_occupation)) ; ?></b></td>
                    <td class="td"><?=translate('PADAM')?> : <b><?php echo dropdownTranslate($astro->PADAM); ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('Career_Profile')?> : <b><?php echo $education->Career_Profile; ?></b></td>
                    <td class="td"><?=translate('LAKKNAM')?>: <b><?php echo dropdownTranslate($astro->LAKKNAM); ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('annual_income')?>: <b><?php echo $education->annual_income.'/'.(isset($education->Earnings) ? dropdownTranslate($education->Earnings) : ""); ?></b></td>
                    <td class="td"><?=translate('rashi')?>: <b><?php echo dropdownTranslate($astro->rashi); ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('DIRECTIONAL_BALANCE')?>: <b><?php echo dropdownTranslate($astro->DIRECTIONAL_BALANCE); ?> <?php echo translate('direction')?> (<?php echo (!empty($astro->Year) ? $astro->Year : "0"); ?> <?php echo translate('year')?> / <?php echo (!empty($astro->Month) ? $astro->Month : "0"); ?> <?php echo translate('month')?> / <?php echo (!empty($astro->Day) ? $astro->Day : "0"); ?> <?php echo translate('day')?>) </b></td>
                    <td class="td"><?=translate('DOSHAM')?>: <b><?php echo ($astro->DOSHAM=='Yes') ? ($astro->TYPE_OF_DOSHAM=='OTHERS' ? $astro->Other_Dosham : dropdownTranslate($astro->TYPE_OF_DOSHAM )) : translate('no'); ?></b></td>
                </tr>

            <?php } } }?>
        </table>

        <table class="table" style="margin-bottom:0px">
            <thead>
                <tr>
                    <th class="th"  colspan="2" style="text-align: center;background-color: black;color:white;font-size: 14px;"><?=translate('family_information')?></th>
                    
                </tr>
            </thead>
            <?php foreach($family_member as $family) { ?>
                <tr>
                    <td class="td"><?=translate('Surname')?> :<b><?php echo $family->Surname;?></b></td>
                    <?php foreach($expectations as $expectation) { ?>
                    <td class="td"><?=translate('Expectation')?>: <b><?php echo  ($expectation->partner_Expectation=='OTHERS' ? $expectation->partner_Other_Expectation: dropdownTranslate($expectation->partner_Expectation)) ; ?></b></td>
                <?php } ?>
                </tr>
                <tr>
                    <td class="td"><?=translate('father')?>: <b><?php echo $family->father;?></b></td>
                    <td class="td"><?=translate("father_vangusam")?>: <b><?php echo  ($family->father_vangusam=='OTHERS' ? $family->other_father_vang: dropdownTranslate($family->father_vangusam)) ; ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('mother')?> :<b><?php echo $family->mother;?></b></td>
                    <td class="td"><?=translate("mother_vangusam")?>: <b><?php echo  ($family->mother_vangusam=='OTHERS' ? $family->other_mother_vang: dropdownTranslate($family->mother_vangusam)) ; ?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('Number_of_brothers')?>:  <b><?php echo $family->Number_of_brothers;?></b></td>
                    <td class="td"><?=translate('Number_of_married_brothers')?>:  <b><?php echo $family->Number_of_married_brothers;?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('Number_of_Sisters')?>:  <b><?php echo $family->Number_of_Sisters;?></b></td>
                    <td class="td"><?=translate('Number_of_married_sisters')?>:  <b><?php echo $family->Number_of_married_sisters;?></b></td>
                </tr>
                <tr>
                    <td class="td"><?=translate('Property_Description')?>: <b><?php echo (!empty($family->Property_Description)) ? ($family->Property_Description=='OTHERS' ? (!empty($family->Other_property_description) ? $family->Other_property_description : "--") : dropdownTranslate($family->Property_Description)) : "--" ;?></b></td>
                    <td class="td"><?=translate('Soveran_Details')?>:<b><?php echo (!empty($single_member->soveran_detail)?$single_member->soveran_detail:"");?></b></td>
                </tr>
                <?php } ?>
        </table>

        <table class="table mb-5">
            <thead>
                <tr>
                    <th class="th" style="text-align: center;background-color: black;color:white;font-size: 14px;"><?=translate('address')?>: </th>
                    
                </tr>
            </thead>
            <?php foreach ($permanents as $permanent) {?>
                <tr>
                    <td class="td"><b><?php echo $permanent->address;?>, <?php echo ($permanent->permanent_state =='OTHERS') ? $permanent->permanent_city_other : dropdownTranslate($permanent->permanent_city)?>, <?php echo $permanent->permanent_postal_code;?> ,<?php echo dropdownTranslate($permanent->permanent_state);?></b></td>
                    
                </tr>
                <tr>
                    <td class="td"><?=translate('PHONE/CELL:')?>: <b><?php echo $single_member->mobile;?> / <?php echo (!empty($permanent->alternate_number)) ? $permanent->alternate_number :"";?></b></td>
                    
                </tr>
            <?php } ?>
        </table>
        <div class="pagebreak"> </div>
        <table>
            <thead>
                
                <th style="padding-left: 350px;"><div style="text-align:center;">உ</div><?=translate('omMurg')?></th>
            </thead>
        </table>
        <table class="table1 mb-3 mt-3" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; font-size: 20px;padding-left: 100px;"><?=translate('heading1')?></th>
                    
                </tr>
            </thead>
            
                <tr>
                    <?php foreach($images as $image){?>
                    <td style="width:100px;padding-bottom:5px" colspan="1" rowspan="5"><img src="<?php echo base_url('uploads/profile_image/print.jpg');?>" style="margin-left: 30px; height: 90px;object-fit: contain;"></td>
                    <?php } ?>
                     <td style="text-align: center;"><?=translate('heading0')?></td>
                </tr>
                <tr>
                    <td style="text-align: center;"><?=translate('heading2')?> ( <?=translate('cell')?> : 94878 33674 )</td>
                    
                </tr>
                <tr>
                    <td style="text-align: center;"><?=translate('heading3')?> </td>
                </tr>
                <tr>
                    <td style="text-align: center;"><?=translate('heading4')?> </td>
                </tr>
               
        </table>
        <table  style="width:100%;">
            <tbody>
                <tr>
                    <td>
                        <table class="table fixed" style="margin-right: 10px;height: 250px;" >
                        <?php
                         foreach($raasis as $raasi){?>
                        
                        <thead>
                            
                            <tr>

                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;">
                                    
                                    <?php 

                                    if(!empty($raasi->f010)){

                                        if($raasi->f010 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f011)){

                                        if($raasi->f011 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f012)){

                                        if($raasi->f012 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f013)){

                                        if($raasi->f013 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f014)){

                                        if($raasi->f014 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f015)){

                                        if($raasi->f015 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>

                                   
                                <?php
                                    echo (!empty($raasi->f010))? dropdownTranslate($raasi->f010).'|':"" ;
                                    echo (!empty($raasi->f011))? dropdownTranslate($raasi->f011).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f012))? dropdownTranslate($raasi->f012).'|':"" ;
                                    echo (!empty($raasi->f013))? dropdownTranslate($raasi->f013).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f014))? dropdownTranslate($raasi->f014).'|':"" ;
                                    echo (!empty($raasi->f015))? dropdownTranslate($raasi->f015).'|':"" ;
                                    ?> 
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f020)){

                                        if($raasi->f020 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f021)){

                                        if($raasi->f021 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f022)){

                                        if($raasi->f022 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f023)){

                                        if($raasi->f023 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f024)){

                                        if($raasi->f024 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f025)){

                                        if($raasi->f025 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                <?php
                                    echo (!empty($raasi->f020))? dropdownTranslate($raasi->f020).'|':"" ;
                                    echo (!empty($raasi->f021))? dropdownTranslate($raasi->f021).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f022))? dropdownTranslate($raasi->f022).'|':"" ;
                                    echo (!empty($raasi->f023))? dropdownTranslate($raasi->f023).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f024))? dropdownTranslate($raasi->f024).'|':"" ;
                                    echo (!empty($raasi->f025))? dropdownTranslate($raasi->f025).'|':"" ;
                                    ?>
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f030)){

                                        if($raasi->f030 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f031)){

                                        if($raasi->f031 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f032)){

                                        if($raasi->f032 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f033)){

                                        if($raasi->f033 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f034)){

                                        if($raasi->f034 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f035)){

                                        if($raasi->f035 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                <?php
                                    echo (!empty($raasi->f030))? dropdownTranslate($raasi->f030).'|':"" ;
                                    echo (!empty($raasi->f031))? dropdownTranslate($raasi->f031).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f032))? dropdownTranslate($raasi->f032).'|':"" ;
                                    echo (!empty($raasi->f033))? dropdownTranslate($raasi->f033).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f034))? dropdownTranslate($raasi->f034).'|':"" ;
                                    echo (!empty($raasi->f035))? dropdownTranslate($raasi->f035).'|':"" ;
                                    ?>
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f040)){

                                        if($raasi->f040 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f041)){

                                        if($raasi->f041 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f042)){

                                        if($raasi->f042 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f043)){

                                        if($raasi->f043 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f044)){

                                        if($raasi->f044 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f045)){

                                        if($raasi->f045 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                <?php
                                    echo (!empty($raasi->f040))? dropdownTranslate($raasi->f040).'|':"" ;
                                    echo (!empty($raasi->f041))? dropdownTranslate($raasi->f041).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f042))? dropdownTranslate($raasi->f042).'|':"" ;
                                    echo (!empty($raasi->f043))? dropdownTranslate($raasi->f043).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f044))? dropdownTranslate($raasi->f044).'|':"" ;
                                    echo (!empty($raasi->f045))? dropdownTranslate($raasi->f045).'|':"" ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f110)){

                                        if($raasi->f110 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f111)){

                                        if($raasi->f111 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f112)){

                                        if($raasi->f112 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f113)){

                                        if($raasi->f113 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f114)){

                                        if($raasi->f114 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f115)){

                                        if($raasi->f115 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                 <?php
                                    echo (!empty($raasi->f110))? dropdownTranslate($raasi->f110).'|':"" ;
                                    echo (!empty($raasi->f111))? dropdownTranslate($raasi->f111).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f112))? dropdownTranslate($raasi->f112).'|':"" ;
                                    echo (!empty($raasi->f113))? dropdownTranslate($raasi->f113).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f114))? dropdownTranslate($raasi->f114).'|':"" ;
                                    echo (!empty($raasi->f115))? dropdownTranslate($raasi->f115).'|':"" ;
                                    ?> 
                                </td>
                                <td rowspan="2" colspan="2" class="td" style="text-align: center;background-color: #f3f3cb;padding-bottom: 80px!important;"><?php echo translate('ZODIAC');?></td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f210)){

                                        if($raasi->f210 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f211)){

                                        if($raasi->f211 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f212)){

                                        if($raasi->f212 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f213)){

                                        if($raasi->f213 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f214)){

                                        if($raasi->f214 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f215)){

                                        if($raasi->f215 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                <?php
                                    echo (!empty($raasi->f210))? dropdownTranslate($raasi->f210).'|':"" ;
                                    echo (!empty($raasi->f211))? dropdownTranslate($raasi->f211).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f212))? dropdownTranslate($raasi->f212).'|':"" ;
                                    echo (!empty($raasi->f213))? dropdownTranslate($raasi->f213).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f214))? dropdownTranslate($raasi->f214).'|':"" ;
                                    echo (!empty($raasi->f215))? dropdownTranslate($raasi->f215).'|':"" ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f310)){

                                        if($raasi->f310 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f311)){

                                        if($raasi->f311 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f312)){

                                        if($raasi->f312 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f313)){

                                        if($raasi->f313 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f314)){

                                        if($raasi->f314 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f315)){

                                        if($raasi->f315 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                <?php
                                    echo (!empty($raasi->f310))? dropdownTranslate($raasi->f310).'|':"" ;
                                    echo (!empty($raasi->f311))? dropdownTranslate($raasi->f311).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f312))? dropdownTranslate($raasi->f312).'|':"" ;
                                    echo (!empty($raasi->f313))? dropdownTranslate($raasi->f313).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f314))? dropdownTranslate($raasi->f314).'|':"" ;
                                    echo (!empty($raasi->f315))? dropdownTranslate($raasi->f315).'|':"" ;
                                    ?> 
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f320)){

                                        if($raasi->f320 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f321)){

                                        if($raasi->f321 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f322)){

                                        if($raasi->f322 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f323)){

                                        if($raasi->f323 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f324)){

                                        if($raasi->f324 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f325)){

                                        if($raasi->f325 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                <?php
                                    echo (!empty($raasi->f320))? dropdownTranslate($raasi->f320).'|':"" ;
                                    echo (!empty($raasi->f321))? dropdownTranslate($raasi->f321).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f322))? dropdownTranslate($raasi->f322).'|':"" ;
                                    echo (!empty($raasi->f323))? dropdownTranslate($raasi->f323).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f324))? dropdownTranslate($raasi->f324).'|':"" ;
                                    echo (!empty($raasi->f325))? dropdownTranslate($raasi->f325).'|':"" ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td"style="width:100px;height:80px;padding-bottom:15px!important;">
                                   <?php 

                                    if(!empty($raasi->f410)){

                                        if($raasi->f410 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f411)){

                                        if($raasi->f411 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f412)){

                                        if($raasi->f412 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f413)){

                                        if($raasi->f413 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f414)){

                                        if($raasi->f414 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f415)){

                                        if($raasi->f415 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                <?php
                                    echo (!empty($raasi->f410))? dropdownTranslate($raasi->f410).'|':"" ;
                                    echo (!empty($raasi->f411))? dropdownTranslate($raasi->f411).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f412))? dropdownTranslate($raasi->f412).'|':"" ;
                                    echo (!empty($raasi->f413))? dropdownTranslate($raasi->f413).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f414))? dropdownTranslate($raasi->f414).'|':"" ;
                                    echo (!empty($raasi->f415))? dropdownTranslate($raasi->f415).'|':"" ;
                                    ?>       
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f420)){

                                        if($raasi->f420 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f421)){

                                        if($raasi->f421 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f422)){

                                        if($raasi->f422 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f423)){

                                        if($raasi->f423 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f424)){

                                        if($raasi->f424 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f425)){

                                        if($raasi->f425 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                <?php
                                    echo (!empty($raasi->f420))? dropdownTranslate($raasi->f420).'|':"" ;
                                    echo (!empty($raasi->f421))? dropdownTranslate($raasi->f421).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f422))? dropdownTranslate($raasi->f422).'|':"" ;
                                    echo (!empty($raasi->f423))? dropdownTranslate($raasi->f423).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f424))? dropdownTranslate($raasi->f424).'|':"" ;
                                    echo (!empty($raasi->f425))? dropdownTranslate($raasi->f425).'|':"" ;
                                    ?>  
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f430)){

                                        if($raasi->f430 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f431)){

                                        if($raasi->f431 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f432)){

                                        if($raasi->f432 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f433)){

                                        if($raasi->f433 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f434)){

                                        if($raasi->f434 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f435)){

                                        if($raasi->f435 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                <?php
                                    echo (!empty($raasi->f430))? dropdownTranslate($raasi->f430).'|':"" ;
                                    echo (!empty($raasi->f431))? dropdownTranslate($raasi->f431).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f432))? dropdownTranslate($raasi->f432).'|':"" ;
                                    echo (!empty($raasi->f433))? dropdownTranslate($raasi->f433).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f434))? dropdownTranslate($raasi->f434).'|':"" ;
                                    echo (!empty($raasi->f435))? dropdownTranslate($raasi->f435).'|':"" ;
                                    ?>      
                                </td>
                                <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f440)){

                                        if($raasi->f440 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f441)){

                                        if($raasi->f441 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f442)){

                                        if($raasi->f442 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f443)){

                                        if($raasi->f443 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f444)){

                                        if($raasi->f444 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f445)){

                                        if($raasi->f445== 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                <?php
                                    echo (!empty($raasi->f440))? dropdownTranslate($raasi->f440).'|':"" ;
                                    echo (!empty($raasi->f441))? dropdownTranslate($raasi->f441).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f442))? dropdownTranslate($raasi->f442).'|':"" ;
                                    echo (!empty($raasi->f443))? dropdownTranslate($raasi->f443).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f444))? dropdownTranslate($raasi->f444).'|':"" ;
                                    echo (!empty($raasi->f445))? dropdownTranslate($raasi->f445).'|':"" ;
                                    ?>    
                                </td>
                            </tr>
                        </thead>
                    <?php } ?>
                        </table>

                                    </td>
                                    <td>
                        <table class="table fixed" style="margin-right: 10px;height: 250px;">
                            <?php
                             foreach($raasis as $raasi){?>
                            <thead>
                                <tr>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f510)){

                                        if($raasi->f510 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f511)){

                                        if($raasi->f511 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f512)){

                                        if($raasi->f512 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f513)){

                                        if($raasi->f513 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f514)){

                                        if($raasi->f514 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f515)){

                                        if($raasi->f515 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                    <?php
                                        echo (!empty($raasi->f510))? dropdownTranslate($raasi->f510).'|':"" ;
                                        echo (!empty($raasi->f511))? dropdownTranslate($raasi->f511).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f512))? dropdownTranslate($raasi->f512).'|':"" ;
                                        echo (!empty($raasi->f513))? dropdownTranslate($raasi->f513).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f514))? dropdownTranslate($raasi->f514).'|':"" ;
                                        echo (!empty($raasi->f515))? dropdownTranslate($raasi->f515).'|':"" ;
                                        ?> 
                                    </td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f520)){

                                        if($raasi->f520 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f521)){

                                        if($raasi->f521 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f522)){

                                        if($raasi->f522 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f523)){

                                        if($raasi->f523 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f524)){

                                        if($raasi->f524 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php
                                    if(!empty($raasi->f525)){

                                        if($raasi->f525 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                    <?php
                                        echo (!empty($raasi->f520))? dropdownTranslate($raasi->f520).'|':"" ;
                                        echo (!empty($raasi->f521))? dropdownTranslate($raasi->f521).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f522))? dropdownTranslate($raasi->f522).'|':"" ;
                                        echo (!empty($raasi->f523))? dropdownTranslate($raasi->f523).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f524))? dropdownTranslate($raasi->f524).'|':"" ;
                                        echo (!empty($raasi->f525))? dropdownTranslate($raasi->f525).'|':"" ;
                                        ?>
                                    </td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f530)){

                                        if($raasi->f530 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f531)){

                                        if($raasi->f531 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f532)){

                                        if($raasi->f532 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f533)){

                                        if($raasi->f533 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f534)){

                                        if($raasi->f534 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f535)){

                                        if($raasi->f535 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                    <?php
                                        echo (!empty($raasi->f530))? dropdownTranslate($raasi->f530).'|':"" ;
                                        echo (!empty($raasi->f531))? dropdownTranslate($raasi->f531).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f532))? dropdownTranslate($raasi->f532).'|':"" ;
                                        echo (!empty($raasi->f533))? dropdownTranslate($raasi->f533).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f534))? dropdownTranslate($raasi->f534).'|':"" ;
                                        echo (!empty($raasi->f535))? dropdownTranslate($raasi->f535).'|':"" ;
                                        ?> 
                                    </td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f540)){

                                        if($raasi->f540 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f541)){

                                        if($raasi->f541 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f542)){

                                        if($raasi->f542 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f543)){

                                        if($raasi->f543 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f544)){

                                        if($raasi->f544 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f545)){

                                        if($raasi->f545 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                    <?php
                                        echo (!empty($raasi->f540))? dropdownTranslate($raasi->f540).'|':"" ;
                                        echo (!empty($raasi->f541))? dropdownTranslate($raasi->f541).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f542))? dropdownTranslate($raasi->f542).'|':"" ;
                                        echo (!empty($raasi->f543))? dropdownTranslate($raasi->f543).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f544))? dropdownTranslate($raasi->f544).'|':"" ;
                                        echo (!empty($raasi->f545))? dropdownTranslate($raasi->f545).'|':"" ;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f610)){

                                        if($raasi->f610 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f611)){

                                        if($raasi->f611 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f612)){

                                        if($raasi->f612 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f613)){

                                        if($raasi->f613 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f614)){

                                        if($raasi->f614 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f615)){

                                        if($raasi->f615 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                     <?php
                                        echo (!empty($raasi->f610))? dropdownTranslate($raasi->f610).'|':"" ;
                                        echo (!empty($raasi->f611))? dropdownTranslate($raasi->f611).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f612))? dropdownTranslate($raasi->f612).'|':"" ;
                                        echo (!empty($raasi->f613))? dropdownTranslate($raasi->f613).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f614))? dropdownTranslate($raasi->f614).'|':"" ;
                                        echo (!empty($raasi->f615))? dropdownTranslate($raasi->f615).'|':"" ;
                                        ?>   
                                    </td>
                                    <td rowspan="2" colspan="2" class="td" style="text-align: center;background-color: #f3f3cb;padding-bottom: 80px!important;"><?php echo translate('FEATURE');?></td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f710)){

                                        if($raasi->f710 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f711)){

                                        if($raasi->f711 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f712)){

                                        if($raasi->f712 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f713)){

                                        if($raasi->f713 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f714)){

                                        if($raasi->f714 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f715)){

                                        if($raasi->f715 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                    <?php
                                        echo (!empty($raasi->f710))? dropdownTranslate($raasi->f710).'|':"" ;
                                        echo (!empty($raasi->f711))? dropdownTranslate($raasi->f711).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f712))? dropdownTranslate($raasi->f712).'|':"" ;
                                        echo (!empty($raasi->f713))? dropdownTranslate($raasi->f713).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f714))? dropdownTranslate($raasi->f714).'|':"" ;
                                        echo (!empty($raasi->f715))? dropdownTranslate($raasi->f715).'|':"" ;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td"style="width:100px;height:80px;padding-bottom:15px!important;">
                                      <?php 

                                    if(!empty($raasi->f810)){

                                        if($raasi->f810 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f811)){

                                        if($raasi->f811 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f812)){

                                        if($raasi->f812 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f813)){

                                        if($raasi->f813 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f814)){

                                        if($raasi->f814 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f815)){

                                        if($raasi->f815 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>  
                                    <?php
                                    echo (!empty($raasi->f810))? dropdownTranslate($raasi->f810).'|':"" ;
                                    echo (!empty($raasi->f811))? dropdownTranslate($raasi->f811).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f812))? dropdownTranslate($raasi->f812).'|':"" ;
                                    echo (!empty($raasi->f813))? dropdownTranslate($raasi->f813).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f814))? dropdownTranslate($raasi->f814).'|':"" ;
                                    echo (!empty($raasi->f815))? dropdownTranslate($raasi->f815).'|':"" ;
                                    ?>    
                                    </td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;">
                                    <?php 

                                    if(!empty($raasi->f820)){

                                        if($raasi->f820 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f821)){

                                        if($raasi->f821 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f822)){

                                        if($raasi->f822 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f823)){

                                        if($raasi->f823 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f824)){

                                        if($raasi->f824 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f825)){

                                        if($raasi->f825 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php
                                    echo (!empty($raasi->f820))? dropdownTranslate($raasi->f820).'|':"" ;
                                    echo (!empty($raasi->f821))? dropdownTranslate($raasi->f821).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f822))? dropdownTranslate($raasi->f822).'|':"" ;
                                    echo (!empty($raasi->f823))? dropdownTranslate($raasi->f823).'|':"" ;?><br><?php
                                    echo (!empty($raasi->f824))? dropdownTranslate($raasi->f824).'|':"" ;
                                    echo (!empty($raasi->f825))? dropdownTranslate($raasi->f825).'|':"" ;
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td"style="width:100px;height:80px;padding-bottom:15px!important;">
                                         <?php 

                                    if(!empty($raasi->f910)){

                                        if($raasi->f910 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f911)){

                                        if($raasi->f911 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f912)){

                                        if($raasi->f912 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f913)){

                                        if($raasi->f913 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f914)){

                                        if($raasi->f914 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f915)){

                                        if($raasi->f915 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php
                                        echo (!empty($raasi->f910))? dropdownTranslate($raasi->f910).'|':"" ;
                                        echo (!empty($raasi->f911))? dropdownTranslate($raasi->f911).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f912))? dropdownTranslate($raasi->f912).'|':"" ; 
                                        echo (!empty($raasi->f913))? dropdownTranslate($raasi->f913).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f914))? dropdownTranslate($raasi->f914).'|':"" ;
                                        echo (!empty($raasi->f915))? dropdownTranslate($raasi->f915).'|':"" ;
                                        ?>        
                                    </td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f920)){

                                        if($raasi->f920 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f921)){

                                        if($raasi->f921 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f922)){

                                        if($raasi->f922 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f923)){

                                        if($raasi->f923 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f924)){

                                        if($raasi->f924 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f925)){

                                        if($raasi->f925 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                   
                                    <?php
                                        echo (!empty($raasi->f920))? dropdownTranslate($raasi->f920).'|':"" ;
                                        echo (!empty($raasi->f921))? dropdownTranslate($raasi->f921).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f922))? dropdownTranslate($raasi->f922).'|':"" ; 
                                        echo (!empty($raasi->f923))? dropdownTranslate($raasi->f923).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f924))? dropdownTranslate($raasi->f924).'|':"" ;
                                        echo (!empty($raasi->f925))? dropdownTranslate($raasi->f925).'|':"" ;
                                        ?>    
                                    </td>
                                    <td class="td"   style="width:100px;height:80px;padding-bottom:15px!important;">
                                       <?php 

                                    if(!empty($raasi->f930)){

                                        if($raasi->f930 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f931)){

                                        if($raasi->f931 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f932)){

                                        if($raasi->f932 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f933)){

                                        if($raasi->f933 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f934)){

                                        if($raasi->f934 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f935)){

                                        if($raasi->f935 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php
                                        echo (!empty($raasi->f930))? dropdownTranslate($raasi->f930).'|':"" ;
                                        echo (!empty($raasi->f931))? dropdownTranslate($raasi->f931).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f932))? dropdownTranslate($raasi->f932).'|':"" ; 
                                        echo (!empty($raasi->f933))? dropdownTranslate($raasi->f933).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f934))? dropdownTranslate($raasi->f934).'|':"" ;
                                        echo (!empty($raasi->f935))? dropdownTranslate($raasi->f935).'|':"" ;
                                        ?>        
                                    </td>
                                    <td class="td"  style="width:100px;height:80px;padding-bottom:15px!important;"><?php 

                                    if(!empty($raasi->f940)){

                                        if($raasi->f940 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f941)){

                                        if($raasi->f941 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f942)){

                                        if($raasi->f942 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f943)){

                                        if($raasi->f943 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f944)){

                                        if($raasi->f944 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    <?php 

                                    if(!empty($raasi->f945)){

                                        if($raasi->f945 == 'LAKKNAM'){?>
                                            <div class="line1"></div>
                                            <div class="line2"></div>

                                       <?php  }
                                    }

                                    ?>
                                    
                                    <?php
                                        echo (!empty($raasi->f940))? dropdownTranslate($raasi->f940).'|':"" ;
                                        echo (!empty($raasi->f941))? dropdownTranslate($raasi->f941).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f942))? dropdownTranslate($raasi->f942).'|':"" ;
                                        echo (!empty($raasi->f943))? dropdownTranslate($raasi->f943).'|':"" ;?><br><?php
                                        echo (!empty($raasi->f944))? dropdownTranslate($raasi->f944).'|':"" ;
                                        echo (!empty($raasi->f945))? dropdownTranslate($raasi->f945).'|':"" ;
                                        ?>        
                                    </td>
                                </tr>
                            </thead>
                        <?php }  ?>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="width: 100%;float: left;font-size:14px;line-height: 16px;">
            <p style="margin-bottom:4px"><?php echo translate('pdfNote1');?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote2')?></p>
            <p style="margin-bottom:4px"> <?php echo translate('pdfNote3')?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote4')?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote5')?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote6')?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote7')?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote8')?></p>
            <p style="margin-bottom:4px"><?php echo translate('pdfNote9')?></p>
        </div>
        <table class="table1" style="width:100%">
            <tbody>
                    
                    
                
                <tr>
                    
                    <td  rowspan="4" style="text-align:center;padding:1px!important;"><img src="<?php echo base_url('uploads/profile_image/print1.png');?>" style="object-fit: contain;"></td>
                    <td style="text-align:center;" colspan="2"><h6><b><?php echo translate('heading12');?></b></h6></td>
                </tr>
                <tr>
                    <td style="padding:0px!important;"><?php echo translate('heading10');?></td>
                </tr>
                <tr>
                    <td style="padding:0px!important;"><?php echo translate('heading11');?></td>
                </tr>
                <tr>
                    <td style="padding:0px!important;"><b><?php echo translate('footer_tag_line');?></b></td>
                </tr>
            </tbody>
        </table>
            <img src="<?php echo base_url('uploads/profile_image/print2.jpg');?>" style="height: 10%;width: 100%;">

        
        </div>

                                            


          
 
  
  
 
 

    </div>
<div class="pagebreak"> </div>
<input type="hidden" id="print_status" value="1">
</body>
</html>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>



<script>
   
function print_details()
    {
        // print paper begin
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = "<html><head><title></title></head><body>" + printContents + "</body>";
        window.print();
        document.body.innerHTML = originalContents;
    }

    (function() {
      if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
            mediaQueryList.addListener(function(mql) {
              if (mql.matches) {
              } else {
                  document.getElementById('print_status').value=2;
              }
            });
      }
    }()); 


    window.setInterval(function(){
        var print_status=document.getElementById('print_status').value; 
        if(print_status==2){
            //completed
            window.close();
        }else{
            console.log("waiting for print close status");
        }
    }, 1000);

</script>