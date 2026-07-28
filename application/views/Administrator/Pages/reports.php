
<?php

$this->load->library('session');
if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
{
    redirect('administrator');
}

// print_r($Month1);exit;
?>

<?php
 if(isset($count1)){

    $count1=$count1;
 }else{
    $count1=0;
 }

  if(isset($count2)){

    $count2=$count2;
 }else{
    $count2=0;
 }

  if(isset($count3)){

    $count3=$count3;
 }else{
    $count3=0;
 }

  if(isset($count4)){

    $count4=$count4;
 }else{
    $count4=0;
 }
  if(isset($count5)){

    $count5=$count5;
 }else{
    $count5=0;
 }
  if(isset($count6)){

    $count6=$count6;
 }else{
    $count6=0;
 }
  if(isset($count7)){

    $count7=$count7;
 }else{
    $count7=0;
 }
  if(isset($count8)){

    $count8=$count8;
 }else{
    $count8=0;
 }
  if(isset($count9)){

    $count9=$count9;
 }else{
    $count9=0;
 }
  if(isset($count10)){

    $count10=$count10;
 }else{
    $count10=0;
 }
  if(isset($count11)){

    $count11=$count11;
 }else{
    $count11=0;
 }
  if(isset($count12)){

    $count12=$count12;
 }else{
    $count12=0;
 }


 if(isset($activecount1)){

    $activecount1=$activecount1;
 }else{
    $activecount1=0;
 }

  if(isset($activecount2)){

    $activecount2=$activecount2;
 }else{
    $activecount2=0;
 }

  if(isset($activecount3)){

    $activecount3=$activecount3;
 }else{
    $activecount3=0;
 }

  if(isset($activecount4)){

    $activecount4=$activecount4;
 }else{
    $activecount4=0;
 }
  if(isset($activecount5)){

    $activecount5=$activecount5;
 }else{
    $activecount5=0;
 }
  if(isset($activecount6)){

    $activecount6=$activecount6;
 }else{
    $activecount6=0;
 }
  if(isset($activecount7)){

    $activecount7=$activecount7;
 }else{
    $activecount7=0;
 }
  if(isset($activecount8)){

    $activecount8=$activecount8;
 }else{
    $activecount8=0;
 }
  if(isset($activecount9)){

    $activecount9=$activecount9;
 }else{
    $activecount9=0;
 }
  if(isset($activecount10)){

    $activecount10=$activecount10;
 }else{
    $activecount10=0;
 }
  if(isset($activecount11)){

    $activecount11=$activecount11;
 }else{
    $activecount11=0;
 }
  if(isset($activecount12)){

    $activecount12=$activecount12;
 }else{
    $activecount12=0;
 }


  if(isset($inactivecount1)){

    $inactivecount1=$inactivecount1;
 }else{
    $inactivecount1=0;
 }

  if(isset($inactivecount2)){

    $inactivecount2=$inactivecount2;
 }else{
    $inactivecount2=0;
 }

  if(isset($inactivecount3)){

    $inactivecount3=$inactivecount3;
 }else{
    $inactivecount3=0;
 }

  if(isset($inactivecount4)){

    $inactivecount4=$inactivecount4;
 }else{
    $inactivecount4=0;
 }
  if(isset($inactivecount5)){

    $inactivecount5=$inactivecount5;
 }else{
    $inactivecount5=0;
 }
  if(isset($inactivecount6)){

    $inactivecount6=$inactivecount6;
 }else{
    $inactivecount6=0;
 }
  if(isset($inactivecount7)){

    $inactivecount7=$inactivecount7;
 }else{
    $inactivecount7=0;
 }
  if(isset($inactivecount8)){

    $inactivecount8=$inactivecount8;
 }else{
    $inactivecount8=0;
 }
  if(isset($inactivecount9)){

    $inactivecount9=$inactivecount9;
 }else{
    $inactivecount9=0;
 }
  if(isset($inactivecount10)){

    $inactivecount10=$inactivecount10;
 }else{
    $inactivecount10=0;
 }
  if(isset($inactivecount11)){

    $inactivecount11=$inactivecount11;
 }else{
    $inactivecount11=0;
 }
  if(isset($inactivecount12)){

    $inactivecount12=$inactivecount12;
 }else{
    $inactivecount12=0;
 }




if(isset($month1)){

    $month1=$month1;
 }else{
    $month1='';
 }

if(isset($month2)){

    $month2=$month2;
 }else{
    $month2='';
 }

  if(isset($month3)){

    $month3=$month3;
 }else{
    $month3='';
 }

  if(isset($month4)){

    $month4=$month4;
 }else{
    $month4='';
 }
  if(isset($month5)){

    $month5=$month5;
 }else{
    $month5='';
 }
  if(isset($month6)){

    $month6=$month6;
 }else{
    $month6='';
 }
  if(isset($month7)){

    $month7=$month7;
 }else{
    $month7='';
 }
  if(isset($month8)){

    $month8=$month8;
 }else{
    $month8='';
 }
  if(isset($month9)){

    $month9=$month9;
 }else{
    $month9='';
 }
  if(isset($month10)){

    $month10=$month10;
 }else{
    $month10='';
 }
  if(isset($month11)){

    $month11=$month11;
 }else{
    $month11='';
 }
  if(isset($month12)){

    $month12=$month12;
 }else{
    $month12='';
 }

$total_members_chart = $count1+$count2+$count3+$count4+$count5+$count6+$count7+$count8+$count9+$count10+$count11+$count12;

$total_active_chart = $activecount1+$activecount2+$activecount3+$activecount4+$activecount5+$activecount6+$activecount7+$activecount8+$activecount9+$activecount10+$activecount11+$activecount12;

$total_inactive_chart = $inactivecount1+$inactivecount2+$inactivecount3+$inactivecount4+$inactivecount5+$inactivecount6+$inactivecount7+$inactivecount8+$inactivecount9+$inactivecount10+$inactivecount11+$inactivecount12;
?>
<style>
    .print_button
    {
        position: relative;
    display: inline-block;
    box-sizing: border-box;
    margin-left: 0.167em;
    margin-right: 0.167em;
    margin-bottom: 0.333em;
    padding: 0.5em 1em;
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 2px;
    cursor: pointer;
    font-size: .88em;
    line-height: 1.6em;
    color: black;
    white-space: nowrap;
    overflow: hidden;
    border-color: var(--vz-border-color);
    background: var(--vz-light);
    margin-right: 7px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1"></h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div class="live-preview">
                    <form action="<?php echo base_url('AdminController/searchReport')?>" method="post">
                        <div class="row">
                            <div class="col-lg-3">
                                <label><?=translate('filter_with_member_type')?></label>
                                <select class="form-select mb-3" name="member_type" aria-label="Default select example">
                                    <option value="all" <?php echo ($member_type=='all') ? 'selected' : '';?>><?=translate('all_member')?></option>
                                    <option  <?php echo ($member_type=='offline') ? 'selected' : '';?> value="offline"><?=translate('offline_member')?></option>
                                    <option <?php echo ($member_type=='online') ? 'selected' : '';?> value="online"><?=translate('OnlineRegisteredMembers')?></option>
                                    <option <?php echo ($member_type=='closed') ? 'selected' : '';?> value="closed"><?=translate('closed_members')?></option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><?=translate('filter_by_date')?></label>
                                <select class="form-select mb-3" onchange="changeFilterDates(this.value)" name="filter_by" aria-label="Default select example">
                                    <option <?php echo ($filter_by=='today') ? 'selected' : '';?> value="today" selected><?=translate('today')?> </option>
                                    <option <?php echo ($filter_by=='last_week') ? 'selected' : '';?> value="last_week"><?=translate('last_week')?></option>
                                    <option <?php echo ($filter_by=='last_month') ? 'selected' : '';?> value="last_month"><?=translate('last_month')?></option>
                                    <option <?php echo ($filter_by=='last_3_months') ? 'selected' : '';?> value="last_3_months"><?=translate('last_3_months')?></option>
                                    <option <?php echo ($filter_by=='half_yearly') ? 'selected' : '';?> value="half_yearly"><?=translate('half_yearly')?></option>
                                    <option <?php echo ($filter_by=='yearly') ? 'selected' : '';?> value="yearly"><?=translate('yearly')?></option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label><?=translate('from_date')?></label>
                                <input type="date" class="form-control" value="<?php echo ($from_date=='') ? date('Y-m-d') : $from_date ; ?>" name="from_date" id="from_date">
                            </div>
                            <div class="col-lg-3">
                                <label><?=translate('to_date')?></label>
                                <input type="date"  value="<?php echo ($to_date=='') ? date('Y-m-d') : $to_date ; ?>" class="form-control" id="to_date" name="to_date">
                            </div>
                            <div class="col-lg-12 text-center">
                              <button type="submit" class="btn btn-xs btn-outline-success btn-border"><?=translate('search')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
    <div class="col-xxl-9 order-xxl-0">
        <div class="d-flex flex-column h-100">
            <div class="row h-100">
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle shadow fs-3">
                                        <i class="fa fa-male"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        <?=translate('male')?></p>
                                    <h4 class=" mb-0"><span class="counter-value" data-target="<?php echo $male_count;?>">0</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle shadow fs-3">
                                        <i class="fa fa-female"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        <?=translate('female')?></p>
                                    <h4 class=" mb-0"><span class="counter-value" data-target="<?php echo $female_count;?>">0</span></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle shadow fs-3">
                                        <i class="fa fa-male"></i><i class="fa fa-female"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1"><?=translate('total_members')?></p>
                                    <h4 class=" mb-0"><span class="counter-value" data-target="<?php echo ($male_count!='' && $female_count!='') ? $male_count+$female_count : 0 ;?>"></span></h4>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->
        </div>
    </div><!-- end col -->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-0 align-items-center d-flex">
                <!-- <h4 class="card-title mb-0 flex-grow-1">Revenue</h4> -->
                <!-- <div>
                    <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                        ALL
                    </button>
                    <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                        1M
                    </button>
                    <button type="button" class="btn btn-soft-secondary btn-sm shadow-none">
                        6M
                    </button>
                    <button type="button" class="btn btn-soft-primary btn-sm shadow-none">
                        1Y
                    </button>
                </div> -->
            </div><!-- end card header -->

            <div class="card-header p-0 border-0 bg-soft-light">
                <div class="row g-0 text-center">
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1  text-success"><span class="counter-value" data-target="<?php echo $total_members_chart;?>">0</span></h5>
                            <p class="text-muted mb-0"><?=translate('total_members')?></p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0">
                            <h5 class="mb-1"><span class="counter-value" data-target="<?php echo $total_active_chart;?>">0</span></h5>
                            <p class="text-muted mb-0"><?=translate('active_members')?></p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-3">
                        <div class="p-3 border border-dashed border-start-0 border-end-0">
                            <h5 class="mb-1"><span class="counter-value" data-target="<?php echo $total_inactive_chart;?>">">0</span></h5>
                            <p class="text-muted mb-0"><?=translate('in_active')?></p>
                        </div>
                    </div>

                    <!--end col-->
                </div>
            </div><!-- end card header -->

            <div class="card-body p-0 pb-2">
                <div class="w-100">
                    <div id="customer_impression_charts" data-colors='["--vz-success", "--vz-primary", "--vz-danger"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-lg-12">
        <div class="card" style="position: absolute;">
            <div class="card-header">
                <!-- <a class="float-end btn btn-sm btn-outline-primary btn-border" href="<?php echo base_url('AdminController/addCustomer'); ?>">Add New Member</a> -->
                <a href="#" id="print" class="print_button">Print</a>
            </div>
            <div class="card-body" style="margin-bottom: 50px;" id="printableArea">
                <?php if($member_type!=='' && $from_date!=='' && $to_date!=='' && $male_count!=='' ){?>
                    
                    
                <table id="datatable" class="display table table-bordered dt-responsive" style="width:100%"  data-paging='false'>
                    <thead>
                       <tr>
                            <th><?php echo translate('s_no');?></th>
                            <th><?php echo translate('user_image')?></th>
                            <th><?php echo translate('Member ID')?></th>
                            <th><?php echo translate('name')?></th>
                            <th><?php echo translate('mobile')?></th>
                            <th><?php echo translate('Transaction_Txn_Id')?></th>
                            <th><?php echo translate('plan')?></th>
                            <th><?php echo translate('activated_date')?></th>
                            <th><?php echo translate('member_since')?></th>
                            <th><?php echo translate('member_status')?></th>
                        </tr>
                    </thead>                    
                </table>
                <?php } else { ?>
                    <table class="display table table-bordered dt-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">table is empty</th>
                        </tr>
                    </thead>                    
                </table>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?php echo$member_type ?>" id="member_type">
<input type="hidden" value="<?php echo$from_date ?>" id="from_date">
<input type="hidden" value="<?php echo$to_date ?>" id="to_date">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<div id="edit_output"></div>
<script>
   


    document.addEventListener("DOMContentLoaded", () => {
    let printLink = document.getElementById("print");
    let container = document.getElementById("container");

    printLink.addEventListener("click", event => {
        event.preventDefault();
        // printLink.style.display = "none";
        window.print();
    }, false);

    container.addEventListener("click", event => {
        // printLink.style.display = "none";
    }, false);

}, false);

</script>
<script>

    function changeFilterDates(value)
    {
        var from_date='';
        var to_date='';
        to_date='<?php echo date('Y-m-d'); ?>';     
        if (value=='last_week') {
            from_date='<?php echo date('Y-m-d',strtotime('-6 days')); ?>';
        }
        else if (value=='last_month') {
            from_date='<?php echo date('Y-m-d',strtotime('-1 months')); ?>';
        }
        else if (value=='last_3_months') {
            from_date='<?php echo date('Y-m-d',strtotime('-3 months')); ?>';
        }
        else if (value=='half_yearly') {
            from_date='<?php echo date('Y-m-d',strtotime('-6 months')); ?>';
        }
        else if (value=='yearly') {
            from_date='<?php echo date('Y-m-d',strtotime('-12 months')); ?>';
        }
        else {
            from_date='<?php echo date('Y-m-d'); ?>';
        }
        console.log(from_date);
        $('#from_date').val(from_date);
        $('#to_date').val(to_date);
    }

document.addEventListener("DOMContentLoaded", function() {
    var base_url=$('#base_url').val();
    var member_type=$('#member_type').val();
    var from_date=$('#from_date').val();
    var to_date=$('#to_date').val();

    new DataTable("#datatable", {        
        ajax: base_url+'AjaxController/reports/'+member_type+'/'+from_date+'/'+to_date,
        success: function(data) {
            console.log(data);
        },
        error: function() {
            alert('Error occured');
        },
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel"]
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

     

function getChartColorsArray(e) {
    if (null !== document.getElementById(e)) {
        var r = document.getElementById(e).getAttribute("data-colors");
        if (r) return (r = JSON.parse(r)).map(function(e) {
            var r = e.replace(" ", "");
            if (-1 === r.indexOf(",")) {
                var t = getComputedStyle(document.documentElement).getPropertyValue(r);
                return t || r
            }
            e = e.split(",");
            return 2 != e.length ? r : "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")"
        });
        console.warn("data-colors atributes not found on", e)
    }
}
var linechartcustomerColors = getChartColorsArray("customer_impression_charts");
linechartcustomerColors && (options = {
    series: [{
        name: "<?=translate('active_members');?>",
        type: "bar",
        data: [<?=$activecount1?>, <?=$activecount2?>, <?=$activecount3?>, <?=$activecount4?>, <?=$activecount5?>, <?=$activecount6?>, <?=$activecount7?>, <?=$activecount8?>, <?=$activecount9?>, <?=$activecount10?>, <?=$activecount11?>, <?=$activecount12?>]
    },{
        name: "<?=translate('total_members');?>",
        type: "bar",
        data: [<?=$count1?>, <?=$count2?>, <?=$count3?>, <?=$count4?>, <?=$count5?>, <?=$count6?>, <?=$count7?>, <?=$count8?>, <?=$count9?>, <?=$count10?>, <?=$count11?>, <?=$count12?>]
    },{
        name: "<?=translate('in_active');?>",
        type: "bar",
        data: [<?=$inactivecount1?>, <?=$inactivecount2?>, <?=$inactivecount3?>, <?=$inactivecount4?>, <?=$inactivecount5?>, <?=$inactivecount6?>, <?=$inactivecount7?>, <?=$inactivecount8?>, <?=$inactivecount9?>, <?=$inactivecount10?>, <?=$inactivecount11?>, <?=$inactivecount12?>]
    }],
    chart: {
        height: 370,
        type: "line",
        toolbar: {
            show: !1
        }
    },
    stroke: {
        curve: "straight",
        dashArray: [0, 0, 8],
        width: [2, 0, 2.2]
    },
    fill: {
        opacity: [.1, .9, 1]
    },
    markers: {
        size: [0, 0, 0],
        strokeWidth: 2,
        hover: {
            size: 4
        }
    },
    xaxis: {
        categories: ['<?=$month1?>', "<?=$month2?>", "<?=$month3?>", "<?=$month4?>", "<?=$month5?>", "<?=$month6?>", "<?=$month7?>", "<?=$month8?>", "<?=$month9?>", "<?=$month10?>", "<?=$month11?>", "<?=$month12?>"],
        axisTicks: {
            show: !1
        },
        axisBorder: {
            show: !1
        }
    },
    grid: {
        show: !0,
        xaxis: {
            lines: {
                show: !0
            }
        },
        yaxis: {
            lines: {
                show: !1
            }
        },
        padding: {
            top: 0,
            right: -2,
            bottom: 15,
            left: 10
        }
    },
    legend: {
        show: !0,
        horizontalAlign: "center",
        offsetX: 0,
        offsetY: -5,
        markers: {
            width: 9,
            height: 9,
            radius: 6
        },
        itemMargin: {
            horizontal: 10,
            vertical: 0
        }
    },
    plotOptions: {
        bar: {
            columnWidth: "30%",
            barHeight: "70%"
        }
    },
    colors: linechartcustomerColors,
    tooltip: {
        shared: !0,
        y: [{
            formatter: function(e) {
                return void 0 !== e ? e.toFixed(0) : e
            }
        }, {
            formatter: function(e) {
                return void 0 !== e ? "" + e.toFixed(0) + "" : e
            }
        }, {
            formatter: function(e) {
                return void 0 !== e ? "" + e.toFixed(0) + "" : e
            }
        }, {
            formatter: function(e) {
                return void 0 !== e ? e.toFixed(0) + " Sales" : e
            }
        }]
    }
}, (chart = new ApexCharts(document.querySelector("#customer_impression_charts"), options)).render());
var options, chart, chartDonutBasicColors = getChartColorsArray("store-visits-source");
chartDonutBasicColors && (options = {
    series: [44, 55, 41, 17, 15],
    labels: ["Direct", "Social", "Email", "Other", "Referrals"],
    chart: {
        height: 333,
        type: "donut"
    },
    legend: {
        position: "bottom"
    },
    stroke: {
        show: !1
    },
    dataLabels: {
        dropShadow: {
            enabled: !1
        }
    },
    colors: chartDonutBasicColors
}, (chart = new ApexCharts(document.querySelector("#store-visits-source"), options)).render());
var worldemapmarkers, vectorMapWorldMarkersColors = getChartColorsArray("sales-by-locations");
vectorMapWorldMarkersColors && (worldemapmarkers = new jsVectorMap({
    map: "world_merc",
    selector: "#sales-by-locations",
    zoomOnScroll: !1,
    zoomButtons: !1,
    selectedMarkers: [0, 5],
    regionStyle: {
        initial: {
            stroke: "#9599ad",
            strokeWidth: .25,
            fill: vectorMapWorldMarkersColors[0],
            fillOpacity: 1
        }
    },
    markersSelectable: !0,
    markers: [{
        name: "Palestine",
        coords: [31.9474, 35.2272]
    }, {
        name: "Russia",
        coords: [61.524, 105.3188]
    }, {
        name: "Canada",
        coords: [56.1304, -106.3468]
    }, {
        name: "Greenland",
        coords: [71.7069, -42.6043]
    }],
    markerStyle: {
        initial: {
            fill: vectorMapWorldMarkersColors[1]
        },
        selected: {
            fill: vectorMapWorldMarkersColors[2]
        }
    },
    labels: {
        markers: {
            render: function(e) {
                return e.name
            }
        }
    }
}));
var overlay, swiper = new Swiper(".vertical-swiper", {
        slidesPerView: 2,
        spaceBetween: 10,
        mousewheel: !0,
        loop: !0,
        direction: "vertical",
        autoplay: {
            delay: 2500,
            disableOnInteraction: !1
        }
    }),
    layoutRightSideBtn = document.querySelector(".layout-rightside-btn");
layoutRightSideBtn && (Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function(e) {
    var r = document.querySelector(".layout-rightside-col");
    e.addEventListener("click", function() {
        r.classList.contains("d-block") ? (r.classList.remove("d-block"), r.classList.add("d-none")) : (r.classList.remove("d-none"), r.classList.add("d-block"))
    })
}), window.addEventListener("resize", function() {
    var e = document.querySelector(".layout-rightside-col");
    e && Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function() {
        window.outerWidth < 1699 || 3440 < window.outerWidth ? e.classList.remove("d-block") : 1699 < window.outerWidth && e.classList.add("d-block")
    })
}), (overlay = document.querySelector(".overlay")) && document.querySelector(".overlay").addEventListener("click", function() {
    1 == document.querySelector(".layout-rightside-col").classList.contains("d-block") && document.querySelector(".layout-rightside-col").classList.remove("d-block")
})), window.addEventListener("load", function() {
    var e = document.querySelector(".layout-rightside-col");
    e && Array.from(document.querySelectorAll(".layout-rightside-btn")).forEach(function() {
        window.outerWidth < 1699 || 3440 < window.outerWidth ? e.classList.remove("d-block") : 1699 < window.outerWidth && e.classList.add("d-block")
    })
});
</script>