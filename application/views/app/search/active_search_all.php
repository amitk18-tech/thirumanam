
<?php 

if(!$this->session->userdata('thirumanam_applogged_data')){

    redirect('app/login');
}


?>
<?php 
$member=$this->db->get_where('member',array('member_id'=>$this->session->userdata['thirumanam_applogged_data']['member_id']))->row();

// echo "<pre>";
// print_r($preference);
// echo "</pre>";

$aged_from=getPartnerExpectaions($member,'partner_age',1);
$aged_to=getPartnerExpectaions($member,'partner_age',2);
// $aged_to=(getPartnerExpectaions($member,'partner_age',2)!='') ? getPartnerExpectaions($member,'partner_age',2) : $aged_from+10;
$min_height='';
$max_height='';
$marital_status='';
$Type_of_study='';


 ?> 

 <style>
     .multiselect-dropdown {
        transition-duration: 500ms;
        
        height: 50px;
        padding: 0.75rem 1rem;
        width: 100%;
        background-color: #ffffff;
       border: 0;
       border-radius: 10px;
       padding-left: 1rem;
       box-shadow: 0 2px 2px 0 rgba(16, 13, 209, 0.175);
       font-size: 13px;
     }
     .multiselect-dropdown span.placeholder {
/*      color:#495057;*/
        color:#f8587e     }
     label{
        margin-top: 15px;
     }
 </style>
<div class="page-content-wrapper">
  <!-- Element Wrapper-->
  <div class="element-wrapper">
    <div class="container mb-3">
      <!-- <h6 class="mb-3 newsten-title">Forms</h6> -->
    </div>  
    <div class="container">
    <form action="<?php echo base_url('app/active_seach_list');?>" method="post">
    <?php if (!empty($this->session->userdata['thirumanam_applogged_data']['member_id'])) { ?>
    <div class="row"  style="display: none;">
     <div class="col-sm-12">
        <div class="form-group has-feedback">
           <label for="" class="text-uppercase"><?php echo translate('looking_for')?></label>
           <div class="radio radio-primary">
              <?php $member_gender = $this->db->get_where('member',array('member_id'=>$this->session->userdata['thirumanam_applogged_data']['member_id']))->row()->gender; ?>
              <?php if($member_gender == '2') { ?>
              <input class="form-control" type="text" name="gender" id="groom" value="1">
              <label for="groom"><?=translate('groom')?></label>
              <?php } elseif ($member_gender == '1') { ?>
              <input class="form-control" type="text" name="gender" id="bride" value="2">
              <label for="bride" class="pr-3"><?=translate('bride')?></label>
              <?php } ?>
           </div>
        </div>
     </div>
  </div>
  <?php } else { ?>
  <div class="row" style="display: none;">
     <div class="col-sm-12">
        <div class="form-group has-feedback">
           <label for="" class="text-uppercase"><?php echo translate('looking_for')?></label>
           <div class="radio radio-primary">
              <input class="form-control" type="text" name="gender" id="bride" value="2" <?php if(!empty($home_gender==2)){ ?>checked<?php }?>>
              <label for="bride" class="pr-3"><?=translate('bride')?></label>
              <input class="form-control" type="text" name="gender" id="groom" value="1" <?php if(!empty($home_gender==1)){ ?>checked<?php }?>>
              <label for="groom"><?=translate('groom')?></label>
           </div>
        </div>
     </div>
  </div>
  <?php } ?>
<div class="banner__list">
    <div class="row align-items-center row-cols-1">
        
        <div class="col">
            <!-- <label>Age</label> -->
            <div class="row g-3">
                <div class="col-6" style="height:40%"> 
                    <label><?php echo translate('age_from')?></label>
                    <div class="banner__inputlist">
                        <select class="form-control" name="aged_from" id="filter_aged_from">
                            <?php for ($i=18; $i < 51; $i++) { 
                                $select = '';
                                if(!empty($this->session->userdata('adv_search')['age_from'])){
                                if($this->session->userdata('adv_search')['age_from'] == $i){
                                $select = 'selected';
                                        }       
                                }
                                ?>
                        <option <?php echo $select;?> value="<?php echo $i ;?>"><?php echo $i;?></option>
                    <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-6" style="height:40%">
                    <label><?php echo translate('to')?></label>
                    <div class="banner__inputlist">
                        <select class="form-control" name="aged_to" id="filter_aged_to">
                            <?php for ($i=51; $i > 18; $i--) { 
                                $select = '';
                                if(!empty($this->session->userdata('adv_search')['age_to'])){
                                if($this->session->userdata('adv_search')['age_to'] == $i){
                                $select = 'selected';
                                        }       
                                }
                        ?><option <?php echo $select;?> value="<?php echo $i?>"><?php echo $i;?></option>
                   <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
            <?php
         if ($this->db->get_where('frontend_settings', array('type' => 'physical_attributes'))->row()->value == "yes") {
         ?>
            <div class="col-lg-6 col-12">
            <label><?php echo translate('min_height_(Feet)')?></label>
            <div class="banner__inputlist">
                 <input class="form-control" type="text" name="min_height" id="min_height">   
            </div>
            </div>
            <div class="col-lg-6 col-12">
            <label><?php echo translate('max_height_(Feet)')?></label>
            <div class="banner__inputlist">
                 <input class="form-control" type="text" name="max_height" id="max_height">   
            </div>
            </div>
        <?php } ?>
        <div class="pt-0" style="display: none;">
             <div class="card-title b-xs-bottom">
                <h3 class="heading heading-sm text-uppercase"><?php echo translate('member_type')?></h3>
             </div>
             <div class="card-body">
                <div class="filter-radio">
                   <div class="radio radio-primary">
                      <input class="form-control" type="radio" name="search_member_type" id="s_all_members" value="all">
                      <label for="s_all_members"><?php echo translate('all_members')?></label>
                   </div>
                   <div class="radio radio-primary">
                      <input class="form-control" type="radio" name="search_member_type" id="s_premium_members" value="premium_members" checked>
                      <label for="s_premium_members"><?php echo translate('premium_members')?></label>
                   </div>
                   <div class="radio radio-primary">
                      <input class="form-control" type="radio" name="search_member_type" id="s_free_members" value="free_members" >
                      <label for="s_free_members"><?php echo translate('free_members')?></label>
                   </div>
                </div>
             </div>

          </div>

          <div class="col">
            <label><?php echo translate('education')?></label>
            <?php  
            $pref_study=getPartnerExpectaions($member,'partner_education',0);
            $Type_of_study1 = get_dropdown(3);
            // print_r($marital_status1);exit;
               ?>
            <div class="banner__inputlist">
                <select class="form-control" name="Type_of_study" id="filter_Type_of_study">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                      <?php foreach ($Type_of_study1 as $key => $value) {
                        $select = '';
                        if(!empty($this->session->userdata('adv_search')['Type_of_study'])){
                        if($this->session->userdata('adv_search')['Type_of_study'] == $value->word){
                        $select = 'selected';
                                }       
                        }
                         ?>
                      <option <?php echo $select;?> value="<?php echo $value->word; ?>">
                         <?php echo dropdownTranslate($value->word); ?>
                      </option>
                      <?php } ?>
                </select>
            </div>
        </div>
        <?php
       if ($this->db->get_where('frontend_settings', array('type' => 'education_and_career'))->row()->value == "yes") {
       ?>
        <div class="col">
            <label><?php echo translate('profession')?></label>
            <?php  
            
            $Type_of_occupation1 = get_dropdown(4);
            // print_r($marital_status1);exit;
               ?>
            <div class="banner__inputlist">
                <select class="form-control" name="Type_of_occupation" id="filter_Type_of_study">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                    <?php foreach ($Type_of_occupation1 as $key => $value) {
                        $select = '';
                        if(!empty($this->session->userdata('adv_search')['occupation'])){
                        if($this->session->userdata('adv_search')['occupation'] == $value->word){
                        $select = 'selected';
                                }       
                        }
                   ?>
                    <option <?php echo $select;?> value="<?php echo $value->word; ?>">
                   <?php echo dropdownTranslate($value->word); ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    <?php } ?>
    <div class="col">
            <label><?php echo translate('marital_status')?></label>
            <?php  
            $pref_marital=getPartnerExpectaions($member,'partner_marital_status',0);
            $marital_status1 = get_dropdown(19);
            // print_r($marital_status1);exit;
               ?>
            <div class="banner__inputlist">
               
                <select class="form-control" name="marital_status" id="filter_marital_status">
                    <option value=""><?php echo translate('choose_one'); ?></option>
                      <?php foreach ($marital_status1 as $value) {
                        $select = '';

                        if(!empty($this->session->userdata('adv_search')['marital_status'])){
                        if($this->session->userdata('adv_search')['marital_status'] == $value->word){
                        $select = 'selected';
                                }       
                        }
                         ?>
                      <option <?php echo $select;?> value="<?php echo $value->word; ?>">
                         <?php echo dropdownTranslate($value->word); ?>
                      </option>
                      <?php } ?>
                </select>
            </div>
        </div>
        
        <div class="col">
            <label><?php echo translate('Soveran_Details')?></label>
            <div class="banner__inputlist">
                <input class="form-control" type="number" id="filter_Soveran_Details"   name="Soveran_Details" value="<?php echo (!empty($this->session->userdata('adv_search')['Soveran_Details'])) ? $this->session->userdata('adv_search')['Soveran_Details'] : '' ;?>">
            </div>
        </div>
        
        
        <div class="col">
            <label><?php echo translate('father_vangusam')?><b>(<?=translate('multiple')?>)</b></label>
            <?php  
            
            $father_vangusam1 = get_dropdown(1);
            // print_r($marital_status1);exit;
               ?>
            <div class="banner__inputlist">
                <select class="form-control" name="father_vangusam[]" id="filter_Type_of_study" multiple>
                    <option value=""><?php echo translate('choose_one')?></option>
                    <?php foreach ($father_vangusam1 as $key => $value) {
                        $select = '';
                        if(!empty($this->session->userdata('adv_search')['father_vangusam'][0])){
                           if($this->session->userdata('adv_search')['father_vangusam'][0] == $value->word){
                                $select = 'selected';
                           }else{

                             $select = '';
                           } 
                        }
                        ?>
                    <option <?php echo $select ;?> value="<?php echo $value->word; ?>">
                       <?php echo dropdownTranslate($value->word); ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            </div>
            <div class="col">
            <label><?php echo translate('star')?><b>(<?=translate('multiple')?>)</b></label>
            <?php  
            
            $star1 = get_dropdown(7);
            // print_r($marital_status1);exit;
               ?>
            <div class="banner__inputlist">
                <select class="form-control" name="star[]" id="filter_star" multiple>
                    <option value=""><?php echo translate('choose_one')?></option>
                     <?php  foreach ($star1 as $key => $value) {
                         $select = '';
                        if(!empty($this->session->userdata('adv_search')['star'][0])){
                        if($this->session->userdata('adv_search')['star'][0] == $value->word){
                        $select = 'selected';
                                }       
                        }
                         ?>
                    <option <?php echo $select;?>  value="<?php echo $value->word; ?>">
                     <?php echo dropdownTranslate($value->word); ?>
                  </option>
                  <?php } ?>
                </select>
            </div>
        </div>
        <div class="col">
            <label><?php echo translate('dosham')?></label>
            <?php  
            
            $dosham1 = get_dropdown(13);
            // print_r($marital_status1);exit;
               ?>
            <div class="banner__inputlist">
                <select class="form-control" name="dosham" id="filter_dosham">
                     <option value=""><?php echo translate('choose_one'); ?></option>
                      <?php foreach ($dosham1 as $key => $value) {
                        $select = '';
                        if(!empty($this->session->userdata('adv_search')['dosham'])){
                        if($this->session->userdata('adv_search')['dosham'] == $value->word){
                        $select = 'selected';
                                }       
                        }
                         ?>
                      <option <?php echo $select; ?> value="<?php echo $value->word; ?>">
                         <?php echo dropdownTranslate($value->word); ?>
                      </option>
                      <?php } ?>
                </select>
            </div>
        </div>
            <div class="col-12 text-center">
            <button type="submit" class="mb-1 btn btn-lg btn-success mt-3 mb-2"><?php echo translate('search')?></button>
            </div>

    </div>
</div>
</form>
<script src="<?php echo base_url('assets/front/') ?>js/multiselect-dropdown.js"></script> 

    </div>
    <?php echo $menu;?>
</div>
</div>


