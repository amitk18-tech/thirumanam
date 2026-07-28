<?php 

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}

?>
<style>
  body
  {
    background-image: none;
  }
  
</style>
 <style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body{
    font-family: 'Montserrat', sans-serif;
    font-size: 14px;

}
.wrapper{
    display: grid;
    grid-template-columns: repeat(3,1fr);
    grid-gap: 15px;
/*    margin: 50px;*/
    padding: 0px 20px;
    margin-bottom: 90px!important;
    margin-top: 93px!important;

}
.pricing-table{
   box-shadow: 0px 0px 18px #ccc;
   text-align: center;
   padding: 30px 0px;
   border-radius: 5px;
   position: relative;
 
}
.pricing-table .head {
    border-bottom:1px solid #eee;
    padding-bottom: 50px;
    transition: all 0.5s ease;
}
.pricing-table:hover .head{
   border-bottom:1px solid #8E2DE2;
   
}

.pricing-table .head .title{
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 700;
}

.pricing-table .content .price{
    background:linear-gradient(to right, #8E2DE2 0%, #4A00E0 100%);
    width: 120px;
    height: 120px;
    margin: auto;
    line-height: 90px;
    border-radius: 50%;
    border: 5px solid #fff;
    box-shadow: 0px 0px 10px #ccc;
    margin-top: -50px;
     transition: all 0.5s ease;
}
.pricing-table:hover .content .price{
    transform: scale(1.2);
 
}
.pricing-table .content .price h1{
    color:#fff;
    font-size: 30px;
    font-weight: 700;
}
.pricing-table .content ul{
   list-style-type: none;
   margin-bottom: 20px;
   padding-top: 10px;
}

.pricing-table .content ul li{
    margin: 20px 0px;
    font-size: 14px;
    color:#555;
}

.pricing-table .content .sign-up{
    background:linear-gradient(to right, #8E2DE2 0%, #4A00E0 100%);
    border-radius: 40px;
    font-weight: 500;
    position: relative;
    display: inline-block;
}


.pricing-table .btn {
    color: #fff;
    padding: 10px 10px;
    display: inline-block;
    text-align: center;
    font-weight: 600;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3 linear;
    transition: all 0.3 linear;
    border: none;
    font-size: 14px;
    text-transform: capitalize;
    position: relative;
    text-decoration: none;
    margin: 2px;
    z-index: 9999;
    text-decoration: none;
    border-radius:50px;
 
}

.pricing-table .btn:hover{
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3);
}

.pricing-table .btn.bordered {
    z-index: 50;
    color: #333;
}
.pricing-table:hover .btn.bordered{
    color:#fff !important;
}

.pricing-table .btn.bordered:after {
    background: #fff none repeat scroll 0 0;
    border-radius: 50px;
    content: "";
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    -webkit-transition: all 0.3s linear;
    -moz-transition: all 0.3 linear;
    transition: all 0.3 linear;
    width: 100%;
    z-index: -1;    
    -webkit-transform:scale(1);
    -moz-transform:scale(1);
    transform:scale(1);
}
.pricing-table:hover .btn.bordered:after{
    opacity:0;
    transform:scale(0);
}

@media screen and (max-width:768px){
   .wrapper{
        grid-template-columns: repeat(2,1fr);
    } 
}

@media screen and (max-width:600px){
   .wrapper{
        grid-template-columns: 1fr;
    } 
}

 </style>
<?php 
if($this->session->userdata('thirumanam_applogged_data')){
    $userId = $this->session->userdata('thirumanam_applogged_data')['member_id'];
}
?>
 <div class="wrapper mt-5 mb-5">
        <?php foreach ($all_plans as $value){ ?>
            <?php if ($value->plan_id == 1) { $package_class = "text-line-through"; } else { $package_class = "active"; } ?>
        <div class="pricing-table gprice-single">
            <div class="head">
                 <h4 class="title"><?=$value->name?></h4> 
            </div>
            <div class="content">
                <div class="price">
                    <h1><?php
                    $image = $value->image;
                    $images = json_decode($image, true);
                    // print_r($images[0]['image']);exit;
                    if(!empty($images[0]['image'])){
                    if (file_exists('uploads/plan_image/'.$images[0]['image'])) {
                    ?>
                        <p><img style="width:100%" src="<?=base_url()?>uploads/plan_image/<?=$images[0]['image']?>" class="img-sm"></p>
                    <?php
                    }
                    else {
                    ?>
                       <p><img style="width:100%" src="<?=base_url()?>uploads/plan_image/default_image.png" class="img-sm"></p>
                    <?php
                    } }
                ?></h1>
                </div>
                <p style="font-weight:bold;font-size: 25px;"><?=currency($value->amount)?></p>
                <ul>
                    <li class="<?=$package_class?>"></i> <span><?=translate('express_interests:')?> <?=$value->express_interest?> <?=translate('times')?></span></li>
                    <li class="<?=$package_class?>"></i> <span><?=translate('direct_messages:')?> <?=$value->direct_messages?> <?=translate('times')?></span></li>
                    <li class="<?=$package_class?>"></i> <span><?=translate('photo_gallery:')?> <?=$value->photo_gallery?> </span></li>
                    <li class="<?=$package_class?>"><span><?=translate('Profile_download_text')?> 100 </span></li>

                </ul>
                <div class="sign-up">
                    <?php
                        if ($value->plan_id != 1) {
                            $purchase_link = base_url()."Subscribe/".$value->plan_id;
                        }
                        else {
                            $purchase_link = "#";
                        }
                        ?>
                        <?php if($this->session->userdata('thirumanam_applogged_data')){?>
                        
                        <a onclick="planDetails(<?php echo $value->plan_id;?>)" class="btn bordered radius"><span><?php echo translate('get_this_package')?></span></a>

                        <!-- <a class="btn bordered radius" href="<?=base_url()?>AppController/submitPayment/<?=$userId?>/<?=$value->amount;?>/<?=$value->plan_id?>" class="default-btn reverse"><span><?php echo translate('get_this_package')?></span></a> -->
                    <?php } else{?>
                        <a class="btn bordered radius" href="<?php echo base_url('app/login');?>" class="default-btn reverse"><span><?php echo translate('get_this_package');?></span></a>
                    <?php } ?>
                </div>
            </div>
        </div>
          <?php } ?>  
    </div>
<div id="edit_output"></div>
<script>
function planDetails(m_id) 
{
    
  var base_url=$('#base_url').val();
  // alert(base_url);
  $.ajax({
      type: 'POST',
      url: base_url+'AppController/planDetails',
      data: '&m_id='+m_id,
      success:function(html)
      {
        $('#edit_output').html(html);
        $('#myModal'+m_id).modal('show');
      }
    });
}
</script>