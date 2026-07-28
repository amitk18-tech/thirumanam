<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Tamil:wght@100&display=swap" rel="stylesheet">
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
?>
<!DOCTYPE html>
<html lang="ta">
<head>
   
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF from View </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet" />
    <style>
        b {
            font-family: 'Tangerine';
        }

        .table,.th,.td,.tr{

            border: 1px solid black;
            border-collapse: collapse;
            padding: 2px;

        }
        .watermark {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("http://192.168.0.126/ci/thirumanam_new/uploads/profile_image/water_mark.png") no-repeat;
        background-position: center;
        z-index: -99999;
        border: none !important;
        background-size: 100% !important;
        }

       /* @font-face {
            font-family: Bamini;           
            src: url('http://192.168.0.126/ci/thirumanam_new/Baamini.ttf') format("truetype");
            font-weight: normal;
            font-style: normal;

        } */
        
         body{
            font-family: freeserif;            
        }


</style> 
            
    </style>

</head>
<body>
    <div class="watermark"></div>
        <table>
            <thead>
                <td><?php echo 'Date: <b>'.date('d-M-Y');?></b><br><?php echo 'Time: <b>'.date('h:i a');?></b></td>
                <th style="padding-left: 10em;"><div style="text-align:center;font-family: freeserif !important;">भिम कुमारी भट्ट உ ## tamil தமிழ்</div>OM Muruga</th>
            </thead>
        </table>
            
           
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; font-size: 20px;padding-left: 100px;">SRI SOWDESHWARI AMMAN NARPANI MANDRAM</th>
                    
                </tr>
            </thead>
            
                <tr>
                    <?php foreach($images as $image){?>
                    <td style="width:100px" colspan="1" rowspan="5"><img src="<?php echo base_url('uploads/profile_image/print.jpg');?>" style="height: 10%;object-fit: contain;"></td>
                    <?php } ?>
                     <td style="text-align: center;">(Managed By: Alagirisamy Vijayalakshmi Chatitable Trust, Salem 201)</td>
                </tr>
                <tr>
                    <td style="text-align: center;">MATRIMONY INFORMATION CENTRE ( CELL : 94878 33674 )</td>
                    
                </tr>
                <tr>
                    <td style="text-align: center;">Sri Vijayalakshmi Mahal Thirumana Mandapam, 32/1 cinnusamy Nagar Main Road,</td>
                </tr>
                <tr>
                    <td style="text-align: center;">(behind Dharan hospital), seelanaikenpatti bypass, Salem - 636 201.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">www.thirumanam.info</td>
                </tr>
               
        </table>

        <table style="margin-bottom: 10px;">
            <tbody>
                <tr>
                    <td style="width:15%;height: 5%;">Working Days:</td>
                    <td>*Yellow Group:Every Fridays and New Moon Days:<br>*Green Group:Every Mondays,*Blue Group:Every Mondays</td>
                    <td class="td">Member ID: <?php echo $single_member->member_profile_id;?></b></td>
                </tr>
                <tr>
                    <td>Service Time:</td>
                    <td>Allotted Time During Call</td>
                    <td style="width:26%">Registered Date:<b><?php echo date('d-M-Y',strtotime($single_member->member_since));?></b></td>
                </tr>
            </tbody>
        </table>
        <label style="margin-bottom: 10px;">For Time Allocation: Contact 9487833674/9894278185 On Monday/Friday/No Moon Day From 7am - 9am.</label>
        <table class="table">
            <thead>
                <tr>
                    <th class="th" colspan="2" style="text-align: center;">Bride Groom Details</th>
                    
                </tr>
            </thead>
            <?php foreach($astronomic as $astro){?>
                <tr>
                    <?php foreach($images as $image){?>
                    <td  style="width:330px;" class="td"  colspan="1" rowspan="3"><img src="<?php echo base_url('uploads/profile_image/'.$image->profile_image);?>" style="height: 7%;object-fit: contain;"></td>
                    <?php } ?>
                     <td class="td">Age: <?php echo date('Y')-date('Y',strtotime($astro->date_of_birth))?><b></b> </td>
                </tr>
                <tr>
                    <td class="td">Date Of Birth: <b><?php echo $astro->date_of_birth; ?></b></td>
                    
                </tr>
                <tr>
                    <td class="td">Day Of Birth: <b><?php echo $astro->birthDay; ?></b></td>
                </tr>
                <tr>
                    <td class="td">Name: <b><?php echo $single_member->first_name; ?></b></td>
                    <td class="td">Time Of Birth: <b><?php echo $astro->time_of_birth; ?></b></td>
                </tr>
                <tr>
                    <td class="td">height: <b><?php echo $single_member->height;?></b></td>
                    <td class="td">City Of Birth: <b><?php echo $astro->city_of_birth; ?></b></td>
                </tr>
                 <?php foreach($Physics as $physic) { ?>
                <tr>
                    <td class="td">Complexion: <b><?php echo $physic->complexion; ?></b></td>
                    <td class="td">Paksha: <b><?php echo $astro->PAKSHA; ?></b></td>
                </tr>
                <?php foreach($mariage_status as $mariage){?>
                <tr>
                    <td class="td">Martial Status: <b><?php echo $mariage->marital_status;?></b></td>
                    <td class="td">--</td>
                </tr>
                <?php  } ?>
                <?php foreach($educations as $education) { ?>
                <tr>
                    <td class="td">Education: <b><?php echo $education->Type_of_study; ?></b></td>
                    <td class="td">Thithi: <b><?php echo $astro->time_of_birth; ?></b></td>
                </tr>
                <tr>
                    <td class="td">Study Details: <b><?php echo $education->STUDY_DETAILS; ?></b></td>
                    <td class="td">Star: <b><?php echo $astro->TITHI; ?></b></td>
                </tr>
                <tr>
                    <td class="td">Occupation:<b><?php echo $education->Type_of_occupation; ?></b></td>
                    <td class="td">Padam: <b><?php echo $astro->PADAM; ?></b></td>
                </tr>
                <tr>
                    <td class="td">Carrior Profile:<b><?php echo $education->Career_Profile; ?></b></td>
                    <td class="td">Laknam: <b><?php echo $astro->LAKKNAM; ?></b></td>
                </tr>
                <tr>
                    <td class="td">Income: <b><?php echo $education->annual_income; ?></b></td>
                    <td class="td">Zodiac: <b><?php echo $astro->DOSHAM; ?></b></td>
                </tr>
                <tr>
                    <td class="td">Directional Balance: <b><?php echo $astro->DIRECTIONAL_BALANCE; ?></b></td>
                    <td class="td">Dhosham: <b><?php echo $astro->DOSHAM; ?></b></td>
                </tr>

            <?php } } }?>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th class="th"  colspan="2" style="text-align: center;">Family Information</th>
                    
                </tr>
            </thead>
            <?php foreach($family_member as $family) { ?>
                <tr>
                    <td class="td">Sure Name:<b><?php echo $family->Surname;?></b></td>
                    <?php foreach($expectations as $expectation) { ?>
                    <td class="td">Expectations:<b><?php echo (!empty($expectation->partner_Expectation)) ? $expectation->partner_Expectation : "";?></b></td>
                <?php } ?>
                </tr>
                <tr>
                    <td class="td">Father Name:<b><?php echo $family->father;?></b></td>
                    <td class="td">Father Vangusam:<b><?php echo $family->father_vangusam;?></b></td>
                </tr>
                <tr>
                    <td class="td">Mother Name:<b><?php echo $family->mother;?></b></td>
                    <td class="td">Mother vangusam:<b><?php echo $family->mother_vangusam;?></b></td>
                </tr>
                <tr>
                    <td class="td">No Of Brothers:<b><?php echo $family->Number_of_brothers;?></b></td>
                    <td class="td">No Of Maried Brothers<b><?php echo $family->Number_of_married_brothers;?></b></td>
                </tr>
                <tr>
                    <td class="td">No Of Sisters:<b><?php echo $family->Number_of_Sisters;?></b></td>
                    <td class="td">No Of Maried Sisters:<b><?php echo $family->Number_of_married_sisters;?></b></td>
                </tr>
                <tr>
                    <td class="td">Property Description:<b><?php echo (!empty($family->Property_Description)) ? $family->Property_Description : "" ;?></b></td>
                    <td class="td">saveren Detail:<b><?php echo (!empty($family->Soveran_Details)?$family->Soveran_Details:"");?></b></td>
                </tr>
                <?php } ?>
        </table>
        <table class="table" style="margin-bottom:29px;" >
            <thead>
                <tr>
                    <th class="th" style="text-align: center;">Address</th>
                    
                </tr>
            </thead>
            <?php foreach ($permanents as $permanent) {?>
                <tr>
                    <td class="td"><b><?php echo $permanent->address;?></b></td>
                    
                </tr>
                <tr>
                    <td class="td">Phone Cell:<b><?php echo $permanent->mobile;?></b></td>
                    
                </tr>
            <?php } ?>
        </table>
        
        <table class="table mt-5">
            <thead>
                <tr>
                    <th colspan="2" style="text-align: center; font-size: 20px;padding-left: 100px;">SRI SOWDESHWARI AMMAN NARPANI MANDRAM</th>
                    
                </tr>
            </thead>
            
                <tr>
                    <?php foreach($images as $image){?>
                    <td style="width:100px" colspan="1" rowspan="5"><img src="<?php echo base_url('uploads/profile_image/print.jpg');?>" style="height: 10%;object-fit: contain;"></td>
                    <?php } ?>
                     <td style="text-align: center;">(Managed By: Alagirisamy Vijayalakshmi Chatitable Trust, Salem 201)</td>
                </tr>
                <tr>
                    <td style="text-align: center;">MATRIMONY INFORMATION CENTRE ( CELL : 94878 33674 )</td>
                    
                </tr>
                <tr>
                    <td style="text-align: center;">Sri Vijayalakshmi Mahal Thirumana Mandapam, 32/1 cinnusamy Nagar Main Road,</td>
                </tr>
                <tr>
                    <td style="text-align: center;">(behind Dharan hospital), seelanaikenpatti bypass, Salem - 636 201.</td>
                </tr>
                <tr>
                    <td style="text-align: center;">www.thirumanam.info</td>
                </tr>
               
        </table>
        <div class="watermark"></div>
        <table  style="margin-left: 2px;">
            <tbody>
                <tr>
                    <td>
                        <table class="table" style="width:50%" >
                        <?php foreach($raasis as $raasi){?>
                        <thead>
                            <tr>
                                <td class="td" style="height:5%;width: 80px;">
                                <?php
                                    echo (!empty($raasi->f010))? dropdownTranslate($raasi->f010).' | ':"" ;
                                    echo (!empty($raasi->f011))? dropdownTranslate($raasi->f011).' | ':"" ;
                                    echo (!empty($raasi->f012))? dropdownTranslate($raasi->f012).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f013))? dropdownTranslate($raasi->f013).' | ':"" ;
                                    echo (!empty($raasi->f014))? dropdownTranslate($raasi->f014).' | ':"" ;
                                    echo (!empty($raasi->f015))? dropdownTranslate($raasi->f015).' | ':"" ;
                                    ?> 
                                </td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f020))? dropdownTranslate($raasi->f020).' | ':"" ;
                                    echo (!empty($raasi->f021))? dropdownTranslate($raasi->f021).' | ':"" ;
                                    echo (!empty($raasi->f022))? dropdownTranslate($raasi->f022).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f023))? dropdownTranslate($raasi->f023).' | ':"" ;
                                    echo (!empty($raasi->f024))? dropdownTranslate($raasi->f024).' | ':"" ;
                                    echo (!empty($raasi->f025))? dropdownTranslate($raasi->f025).' | ':"" ;
                                    ?>
                                </td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f030))? dropdownTranslate($raasi->f030).' | ':"" ;
                                    echo (!empty($raasi->f031))? dropdownTranslate($raasi->f031).' | ':"" ;
                                    echo (!empty($raasi->f032))? dropdownTranslate($raasi->f032).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f033))? dropdownTranslate($raasi->f033).' | ':"" ;
                                    echo (!empty($raasi->f034))? dropdownTranslate($raasi->f034).' | ':"" ;
                                    echo (!empty($raasi->f035))? dropdownTranslate($raasi->f035).' | ':"" ;
                                    ?>
                                </td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f040))? dropdownTranslate($raasi->f040).' | ':"" ;
                                    echo (!empty($raasi->f041))? dropdownTranslate($raasi->f041).' | ':"" ;
                                    echo (!empty($raasi->f042))? dropdownTranslate($raasi->f042).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f043))? dropdownTranslate($raasi->f043).' | ':"" ;
                                    echo (!empty($raasi->f044))? dropdownTranslate($raasi->f044).' | ':"" ;
                                    echo (!empty($raasi->f045))? dropdownTranslate($raasi->f045).' | ':"" ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td" style="height:5%;width:80px;">
                                 <?php
                                    echo (!empty($raasi->f110))? dropdownTranslate($raasi->f110).' | ':"" ;
                                    echo (!empty($raasi->f111))? dropdownTranslate($raasi->f111).' | ':"" ;
                                    echo (!empty($raasi->f112))? dropdownTranslate($raasi->f112).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f113))? dropdownTranslate($raasi->f113).' | ':"" ;
                                    echo (!empty($raasi->f114))? dropdownTranslate($raasi->f114).' | ':"" ;
                                    echo (!empty($raasi->f115))? dropdownTranslate($raasi->f115).' | ':"" ;
                                    ?> 
                                </td>
                                <td rowspan="2" colspan="2" class="td" style="text-align: center;background-color: #f3f3cb;padding-bottom: 50px;">ZODIAC</td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f210))? dropdownTranslate($raasi->f210).' | ':"" ;
                                    echo (!empty($raasi->f211))? dropdownTranslate($raasi->f211).' | ':"" ;
                                    echo (!empty($raasi->f212))? dropdownTranslate($raasi->f212).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f213))? dropdownTranslate($raasi->f213).' | ':"" ;
                                    echo (!empty($raasi->f214))? dropdownTranslate($raasi->f214).' | ':"" ;
                                    echo (!empty($raasi->f215))? dropdownTranslate($raasi->f215).' | ':"" ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td"style="height:5%;width:80px">
                                <?php
                                    echo (!empty($raasi->f310))? dropdownTranslate($raasi->f310).' | ':"" ;
                                    echo (!empty($raasi->f311))? dropdownTranslate($raasi->f311).' | ':"" ;
                                    echo (!empty($raasi->f312))? dropdownTranslate($raasi->f312).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f313))? dropdownTranslate($raasi->f313).' | ':"" ;
                                    echo (!empty($raasi->f314))? dropdownTranslate($raasi->f314).' | ':"" ;
                                    echo (!empty($raasi->f315))? dropdownTranslate($raasi->f315).' | ':"" ;
                                    ?> 
                                </td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f320))? dropdownTranslate($raasi->f320).' | ':"" ;
                                    echo (!empty($raasi->f321))? dropdownTranslate($raasi->f321).' | ':"" ;
                                    echo (!empty($raasi->f322))? dropdownTranslate($raasi->f322).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f323))? dropdownTranslate($raasi->f323).' | ':"" ;
                                    echo (!empty($raasi->f324))? dropdownTranslate($raasi->f324).' | ':"" ;
                                    echo (!empty($raasi->f325))? dropdownTranslate($raasi->f325).' | ':"" ;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="td"style="height:5%;width:80px">
                                <?php
                                    echo (!empty($raasi->f410))? dropdownTranslate($raasi->f410).' | ':"" ;
                                    echo (!empty($raasi->f411))? dropdownTranslate($raasi->f411).' | ':"" ;
                                    echo (!empty($raasi->f412))? dropdownTranslate($raasi->f412).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f413))? dropdownTranslate($raasi->f413).' | ':"" ;
                                    echo (!empty($raasi->f414))? dropdownTranslate($raasi->f414).' | ':"" ;
                                    echo (!empty($raasi->f415))? dropdownTranslate($raasi->f415).' | ':"" ;
                                    ?>       
                                </td>
                                <td class="td" style="width:80px;">
                                <?php
                                    echo (!empty($raasi->f420))? dropdownTranslate($raasi->f420).' | ':"" ;
                                    echo (!empty($raasi->f421))? dropdownTranslate($raasi->f421).' | ':"" ;
                                    echo (!empty($raasi->f422))? dropdownTranslate($raasi->f422).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f423))? dropdownTranslate($raasi->f423).' | ':"" ;
                                    echo (!empty($raasi->f424))? dropdownTranslate($raasi->f424).' | ':"" ;
                                    echo (!empty($raasi->f425))? dropdownTranslate($raasi->f425).' | ':"" ;
                                    ?>  
                                </td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f430))? dropdownTranslate($raasi->f430).' | ':"" ;
                                    echo (!empty($raasi->f431))? dropdownTranslate($raasi->f431).' | ':"" ;
                                    echo (!empty($raasi->f432))? dropdownTranslate($raasi->f432).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f433))? dropdownTranslate($raasi->f433).' | ':"" ;
                                    echo (!empty($raasi->f434))? dropdownTranslate($raasi->f434).' | ':"" ;
                                    echo (!empty($raasi->f435))? dropdownTranslate($raasi->f435).' | ':"" ;
                                    ?>      
                                </td>
                                <td class="td" style="width:80px">
                                <?php
                                    echo (!empty($raasi->f440))? dropdownTranslate($raasi->f440).' | ':"" ;
                                    echo (!empty($raasi->f441))? dropdownTranslate($raasi->f441).' | ':"" ;
                                    echo (!empty($raasi->f442))? dropdownTranslate($raasi->f442).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f443))? dropdownTranslate($raasi->f443).' | ':"" ;
                                    echo (!empty($raasi->f444))? dropdownTranslate($raasi->f444).' | ':"" ;
                                    echo (!empty($raasi->f445))? dropdownTranslate($raasi->f445).' | ':"" ;
                                    ?>    
                                </td>
                            </tr>
                        </thead>
                    <?php } ?>
                        </table>

                                    </td>
                                    <td>
                        <table class="table" style="width:50%" >
                            <?php foreach($raasis as $raasi){?>
                            <thead>
                                <tr>
                                    <td class="td" style="height:5%;width:80px">
                                    <?php
                                        echo (!empty($raasi->f510))? dropdownTranslate($raasi->f510).' | ':"" ;
                                        echo (!empty($raasi->f511))? dropdownTranslate($raasi->f511).' | ':"" ;
                                        echo (!empty($raasi->f512))? dropdownTranslate($raasi->f512).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f513))? dropdownTranslate($raasi->f513).' | ':"" ;
                                        echo (!empty($raasi->f514))? dropdownTranslate($raasi->f514).' | ':"" ;
                                        echo (!empty($raasi->f515))? dropdownTranslate($raasi->f515).' | ':"" ;
                                        ?> 
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f520))? dropdownTranslate($raasi->f520).' | ':"" ;
                                        echo (!empty($raasi->f521))? dropdownTranslate($raasi->f521).' | ':"" ;
                                        echo (!empty($raasi->f522))? dropdownTranslate($raasi->f522).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f523))? dropdownTranslate($raasi->f523).' | ':"" ;
                                        echo (!empty($raasi->f524))? dropdownTranslate($raasi->f524).' | ':"" ;
                                        echo (!empty($raasi->f525))? dropdownTranslate($raasi->f525).' | ':"" ;
                                        ?>
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f530))? dropdownTranslate($raasi->f530).' | ':"" ;
                                        echo (!empty($raasi->f531))? dropdownTranslate($raasi->f531).' | ':"" ;
                                        echo (!empty($raasi->f532))? dropdownTranslate($raasi->f532).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f533))? dropdownTranslate($raasi->f533).' | ':"" ;
                                        echo (!empty($raasi->f534))? dropdownTranslate($raasi->f534).' | ':"" ;
                                        echo (!empty($raasi->f535))? dropdownTranslate($raasi->f535).' | ':"" ;
                                        ?> 
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f540))? dropdownTranslate($raasi->f540).' | ':"" ;
                                        echo (!empty($raasi->f541))? dropdownTranslate($raasi->f541).' | ':"" ;
                                        echo (!empty($raasi->f542))? dropdownTranslate($raasi->f542).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f543))? dropdownTranslate($raasi->f543).' | ':"" ;
                                        echo (!empty($raasi->f544))? dropdownTranslate($raasi->f544).' | ':"" ;
                                        echo (!empty($raasi->f545))? dropdownTranslate($raasi->f545).' | ':"" ;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td" style="height:5%;width:80px">
                                     <?php
                                        echo (!empty($raasi->f610))? dropdownTranslate($raasi->f610).' | ':"" ;
                                        echo (!empty($raasi->f611))? dropdownTranslate($raasi->f611).' | ':"" ;
                                        echo (!empty($raasi->f612))? dropdownTranslate($raasi->f612).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f613))? dropdownTranslate($raasi->f613).' | ':"" ;
                                        echo (!empty($raasi->f614))? dropdownTranslate($raasi->f614).' | ':"" ;
                                        echo (!empty($raasi->f615))? dropdownTranslate($raasi->f615).' | ':"" ;
                                        ?>   
                                    </td>
                                    <td rowspan="2" colspan="2" class="td" style="text-align: center;background-color: #f3f3cb;padding-bottom: 50px;">FEATURE</td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f710))? dropdownTranslate($raasi->f710).' | ':"" ;
                                        echo (!empty($raasi->f711))? dropdownTranslate($raasi->f711).' | ':"" ;
                                        echo (!empty($raasi->f712))? dropdownTranslate($raasi->f712).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f713))? dropdownTranslate($raasi->f713).' | ':"" ;
                                        echo (!empty($raasi->f714))? dropdownTranslate($raasi->f714).' | ':"" ;
                                        echo (!empty($raasi->f715))? dropdownTranslate($raasi->f715).' | ':"" ;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td"style="height:5%;width:80px">
                                    <?php
                                    echo (!empty($raasi->f810))? dropdownTranslate($raasi->f810).' | ':"" ;
                                    echo (!empty($raasi->f811))? dropdownTranslate($raasi->f811).' | ':"" ;
                                    echo (!empty($raasi->f812))? dropdownTranslate($raasi->f812).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f813))? dropdownTranslate($raasi->f813).' | ':"" ;
                                    echo (!empty($raasi->f814))? dropdownTranslate($raasi->f814).' | ':"" ;
                                    echo (!empty($raasi->f815))? dropdownTranslate($raasi->f815).' | ':"" ;
                                    ?>    
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                    echo (!empty($raasi->f820))? dropdownTranslate($raasi->f820).' | ':"" ;
                                    echo (!empty($raasi->f821))? dropdownTranslate($raasi->f821).' | ':"" ;
                                    echo (!empty($raasi->f822))? dropdownTranslate($raasi->f822).' | ':"" ; ?><br><?php
                                    echo (!empty($raasi->f823))? dropdownTranslate($raasi->f823).' | ':"" ;
                                    echo (!empty($raasi->f824))? dropdownTranslate($raasi->f824).' | ':"" ;
                                    echo (!empty($raasi->f825))? dropdownTranslate($raasi->f825).' | ':"" ;
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="td"style="height:5%;width:80px">
                                    <?php
                                        echo (!empty($raasi->f910))? dropdownTranslate($raasi->f910).' | ':"" ;
                                        echo (!empty($raasi->f911))? dropdownTranslate($raasi->f911).' | ':"" ;
                                        echo (!empty($raasi->f912))? dropdownTranslate($raasi->f912).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f913))? dropdownTranslate($raasi->f913).' | ':"" ;
                                        echo (!empty($raasi->f914))? dropdownTranslate($raasi->f914).' | ':"" ;
                                        echo (!empty($raasi->f915))? dropdownTranslate($raasi->f915).' | ':"" ;
                                        ?>        
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f920))? dropdownTranslate($raasi->f920).' | ':"" ;
                                        echo (!empty($raasi->f921))? dropdownTranslate($raasi->f921).' | ':"" ;
                                        echo (!empty($raasi->f922))? dropdownTranslate($raasi->f922).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f923))? dropdownTranslate($raasi->f923).' | ':"" ;
                                        echo (!empty($raasi->f424))? dropdownTranslate($raasi->f424).' | ':"" ;
                                        echo (!empty($raasi->f925))? dropdownTranslate($raasi->f925).' | ':"" ;
                                        ?>    
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f930))? dropdownTranslate($raasi->f930).' | ':"" ;
                                        echo (!empty($raasi->f931))? dropdownTranslate($raasi->f931).' | ':"" ;
                                        echo (!empty($raasi->f932))? dropdownTranslate($raasi->f932).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f933))? dropdownTranslate($raasi->f933).' | ':"" ;
                                        echo (!empty($raasi->f934))? dropdownTranslate($raasi->f934).' | ':"" ;
                                        echo (!empty($raasi->f935))? dropdownTranslate($raasi->f935).' | ':"" ;
                                        ?>        
                                    </td>
                                    <td class="td" style="width:80px">
                                    <?php
                                        echo (!empty($raasi->f940))? dropdownTranslate($raasi->f940).' | ':"" ;
                                        echo (!empty($raasi->f941))? dropdownTranslate($raasi->f941).' | ':"" ;
                                        echo (!empty($raasi->f942))? dropdownTranslate($raasi->f942).' | ':"" ; ?><br><?php
                                        echo (!empty($raasi->f943))? dropdownTranslate($raasi->f943).' | ':"" ;
                                        echo (!empty($raasi->f944))? dropdownTranslate($raasi->f944).' | ':"" ;
                                        echo (!empty($raasi->f945))? dropdownTranslate($raasi->f945).' | ':"" ;
                                        ?>        
                                    </td>
                                </tr>
                            </thead>
                        <?php } ?>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="width: 100%;float: left;font-size:14px">
            <p><?php echo translate('pdfNote1');?></p>
            <p><?php echo translate('pdfNote2')?></p>
            <p> <?php echo translate('pdfNote3')?></p>
            <p><?php echo translate('pdfNote4')?></p>
            <p><?php echo translate('pdfNote5')?></p>
            <p><?php echo translate('pdfNote6')?></p>
            <p><?php echo translate('pdfNote7')?></p>
            <p><?php echo translate('pdfNote8')?></p>
            <p><?php echo translate('pdfNote9')?></p>
        </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <table class="table">
            <tbody>
                <tr>
                    <td style="width:20%;"><?php echo translate('VENUE_SPONSOR');?>:</td>
                    <td style="text-align:center;"><h3><?php echo translate('heading12');?></h3></td>
                </tr>
                <tr>
                    <td  rowspan="3" style="text-align:center;"><img src="<?php echo base_url('uploads/profile_image/print1.png');?>" style="height: 5%;object-fit: contain;"></td>
                    <td style="text-align:center;"><?php echo translate('heading10');?></td>
                </tr>
                <tr>
                    <td style="text-align:center;"><?php echo translate('heading11');?></td>
                </tr>
                <tr>
                    <td style="text-align:center;"><b><?php echo translate('footer_tag_line');?></b></td>
                </tr>
            </tbody>
        </table>
            <img src="<?php echo base_url('uploads/profile_image/print2.jpg');?>" style="height: 10%;width: 100%;">

        <p style="font-family: tamil-latha, verdana, sans-serif;" >தமிழ்</p>
        </div>

    </body>
</html>