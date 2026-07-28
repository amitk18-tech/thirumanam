<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxController extends MY_Controller{

    function __construct()
    {
        parent :: __construct();        
        $this->load->model('HomeModel');
        $this->load->model('Customers_model');
        $this->load->model('MetaModel');
              
    }

   public function listMembers()
    {
        $members =$this->HomeModel->getAllDatas('member','result');
        
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                    

               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                

               $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                
                $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download, $member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function offlineMembers()
    {
        $members =$this->HomeModel->getOfflineDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }

                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }


    public function onlineMembers()
    {
        $members =$this->HomeModel->getOnlineDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function reportMembers()
    {
        $members =$this->HomeModel->getReportDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }


    public function offlineMale()
    {
        $members =$this->HomeModel->getOfflineMale('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function offlineFemale()
    {
        $members =$this->HomeModel->getOfflineFemale('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function pendingRenewal()
    {
        $members =$this->HomeModel->getPendingDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  

    public function pendingRenewalOffline()
    {
        $members =$this->HomeModel->getPendingOfflineDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  
    public function pendingRenewalOnline()
    {
        $members =$this->HomeModel->getPendingOnlineDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  

    public function pendingOnlineUnpaid()
    {
        $members =$this->HomeModel->getPendingOnlineUnpaid('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  
    public function incompleteProfile()
    {
        $members =$this->HomeModel->getincompleteProfileDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;

               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  
    public function incompleteOnlinePaid()
    {
        $members =$this->HomeModel->getincompleteOnlinePaid('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  
    public function incompleteOnlineUnpaid()
    {
        $members =$this->HomeModel->getincompleteOnlineUnpaid('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }  
    public function incompleteOffline()
    {
        $members =$this->HomeModel->getincompleteOffline('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    } 

    public function withoutProfile()
    {
        
        $members =$this->HomeModel->getWithoutProfileDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }

                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    } 
     public function withoutProfileOffline()
    {
        $profile_image[] = array(
            'profile_image' => 'default.jpg',
            'thumb' =>  'default_thumb.jpg',
        );
        $profile['profile_image'] = json_encode($profile_image);
        $members =$this->HomeModel->getWithoutProfileOffline('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    } 
    public function withoutProfileOnline()
    {
        $profile_image[] = array(
            'profile_image' => 'default.jpg',
            'thumb' =>  'default_thumb.jpg',
        );
        $profile['profile_image'] = json_encode($profile_image);
        $members =$this->HomeModel->getWithoutProfileOnline('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function bulkPrint()
    {
        $members =$this->HomeModel->getAllPrintDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               $select = '<input type="checkbox" name="select" onclick="func()" value="'.$member->member_id.'" id="'.$member->member_id.'">';
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$select,$profile, $profile_id, $member->first_name, $member->status,$plan,$report, $member->is_blocked,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function bulkPrintMale()
    {
        $members =$this->HomeModel->getAllPrintDatas('member','result',1);

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               $select = '<input type="checkbox" name="select" onclick="func()" value="'.$member->member_id.'" id="'.$member->member_id.'">';
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$select,$profile, $profile_id, $member->first_name, $member->status,$plan,$report, $member->is_blocked,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function bulkPrintFemale()
    {
        $members =$this->HomeModel->getAllPrintDatas('member','result',2);

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                $images = json_decode($member->profile_image);
                $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                        }
                 }
                 
 
                $packages = json_decode($member->package_info);
                $plan="";
                if(!empty($packages)){
                foreach($packages as $package){
                 $plan = $package->current_package;
 
                }
             }
               $select = '<input type="checkbox" name="select" onclick="func()" value="'.$member->member_id.'" id="'.$member->member_id.'">';
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
               
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$select,$profile, $profile_id, $member->first_name,$member->status,$plan,$report, $member->is_blocked,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function blockMembers()
    {
        $members =$this->HomeModel->getblockDatas();

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }

               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }   
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $status=getBlockLabel($member->is_blocked);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->reason,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function blockMembersOffline()
    {
        $members =$this->HomeModel->getblockOfflineDatas();

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }

               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $status=getBlockLabel($member->is_blocked);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->reason,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

public function blockMembersOnline()
    {
        $members =$this->HomeModel->getblockOnlineDatas();

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }

               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }

               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $status=getBlockLabel($member->is_blocked);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->reason,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function closeMembers()
    {
        $members =$this->HomeModel->getCloseDatas();

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $status=getCloseLabel($member->is_closed);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->reason,$member->other_reason,$member->follower,$report,$member->mobile,$member->remain_download,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function closeMembersOffline()
    {
        $members =$this->HomeModel->getCloseOfflineDatas();

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $status=getCloseLabel($member->is_closed);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->reason,$member->other_reason,$member->follower,$report,$member->mobile,$member->remain_download,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function closeMembersOnline()
    {
        $members =$this->HomeModel->getCloseOnlineDatas();

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $status=getCloseLabel($member->is_closed);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->reason,$member->other_reason,$member->follower,$report,$member->mobile,$member->remain_download,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function duplicateMembers()
    {
        $mem =$this->HomeModel->getDuplicateDatas();

        $members = json_decode($mem);
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function duplicateOffline()
    {
        $mem =$this->HomeModel->getDuplicateOffline();

        $members = json_decode($mem);
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function duplicateOnline()
    {
        $mem =$this->HomeModel->getDuplicateOnline();

        $members = json_decode($mem);
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->follower,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineRegisterMembers()
    {
        $members =$this->HomeModel->getOnlineDatas('member','result');
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               $packages = json_decode($member->package_info);
               $plan = '';
               if(!empty($packages)){
                
               

                foreach($packages as $package){
                $plan = $package->current_package;
               
               

               }
               }
                
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $BlockUser=getBlockLabel($member->is_blocked);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->status,$member->follower,$plan,$BlockUser,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineRegisterMale()
    {
        $members =$this->HomeModel->getOnlineMaleDatas('member','result');
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                $images = json_decode($member->profile_image);
                $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                        }
                }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               $packages = json_decode($member->package_info);
                $plan= "";
               if(!empty($packages)){

                foreach($packages as $package){
                $plan = $package->current_package;
               
               }

               }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $BlockUser=getBlockLabel($member->is_blocked);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,  $member->status, $member->follower,$plan,$BlockUser,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineRegisterFemale()
    {
        $members =$this->HomeModel->getOnlineFemaleDatas('member','result');
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                         }
                 }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               $packages = json_decode($member->package_info);
                $plan= "";
               if(!empty($packages)){

                foreach($packages as $package){
                $plan = $package->current_package;
               
               }

               }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                $BlockUser=getBlockLabel($member->is_blocked);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,  $member->status, $member->follower,$plan,$BlockUser,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineRegisterRenew()
    {
        $members =$this->HomeModel->getOnlineRenewDatas('member','result');
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                         }
                 }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
               $packages = json_decode($member->package_info);

               $plan= "";
               if(!empty($packages)){

               

                foreach($packages as $package){
                $plan = $package->current_package;
               
               }

               }
                
               // print_r($renew);exit;

                
                $report=getReportLabel($member->reported_by);
                $BlockUser=getBlockLabel($member->is_blocked);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,  $member->status, $member->follower,$plan,$BlockUser,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineRegisterUnpaid()
    {
    $package_info[] = array(
            'current_package' => 'Default',
            'package_price' =>  '0',
            'payment_type' =>  'None',
        );
        $data['package_info'] = json_encode($package_info);
    
        $members =$this->HomeModel->getOnlineUnpaidDatas('member','result');
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                 if(!empty($images)){
                     foreach($images as $image){
                         $profileimage = $image->profile_image;
         
                         }
                 }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
               $packages = json_decode($member->package_info);
                $plan= "";
               if(!empty($packages)){

                foreach($packages as $package){
                $plan = $package->current_package;
               
               }

               }
               // print_r($renew);exit;

                
                $report=getReportLabel($member->reported_by);
                $BlockUser=getBlockLabel($member->is_blocked);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,  $member->status, $member->follower,$plan,$BlockUser,$report,$member->remain_download,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function deletedMembers()
    {
        $members =$this->HomeModel->getDeletedDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                // if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                //     $delete = '<a title="DELETE PERMANANT" href="'.base_url('administrator/deleteMemberPermanant/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete Permanantly this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                // }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a title="RESTORE" href="'.base_url('administrator/restoreMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to Restore this?\');" class="btn btn-xs btn-outline-success btn-border">Restore</a><br>                         
                            
                            '.$delete.'
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->status, $member->follower,$report,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function oldIdMembers()
    {
        $members =$this->HomeModel->getOldRenewedDatas('deactivated_member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->profile_image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->profile_image;
          
                         }
                  }
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               // $packages = json_decode($member->package_info);
               //  foreach($packages as $package){
               //  $plan = $package->current_package;
               
               // }
               // print_r($plan);exit;

                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                // if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                //     $delete = '<a title="DELETE PERMANANT" href="'.base_url('administrator/deleteMemberPermanantly/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete Permanantly this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                // }

                $action='<div class="hstack gap-2 fs-18">                         
                            
                            '.$delete.'
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->status, $member->follower,$report,$member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
     
     public function reportedMembers()
    {
        $members =$this->HomeModel->getreportedDatas('member','result');

        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                // print_r($members);exit;
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
             
            $member2 =$this->HomeModel->getSingleData('member',$member->reported_member_id); 
            $reportstatus = "";
            if(!empty($member2->member_profile_id)){
                $reportstatus=getReportedLabel($member2->prefixId,$member2->member_profile_id,$member2->first_name);
            }
            
              
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }

                
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('AdminController/deletereportedMember/'.$member->report_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>
                            '.$delete.'
                             <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$member->details,$member->created_date,$reportstatus,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function listStories()
    {
        $members =$this->HomeModel->getstoryDatas();
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                 // print_r($member->package_info);exit;
                 $images = json_decode($member->image);
                 $profileimage = "";
                  if(!empty($images)){
                      foreach($images as $image){
                          $profileimage = $image->img;
                            break;
                         }
                  }
               if($member->approval_status==0){

                $aprove = '<a title="APROVE" href="'.base_url('administrator/aprove/').$member->happy_story_id .'" class="btn btn-xs btn-outline-info btn-border" onclick="return confirm(\'Are you sure want to aprove this?\');">aprove</a>';
                }else{
                    $aprove = '<a title="APROVE" href="'.base_url('administrator/disaprove/').$member->happy_story_id .'" class="btn btn-xs btn-outline-danger btn-border" onclick="return confirm(\'Are you sure want to disaprove this?\');">disaprove</a>';
                }
               // print_r($profileimage);exit;

                
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/happy_story_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                
                $report=getReportLabel($member->reported_by);
                $status=getCloseLabel($member->is_blocked);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteStory/'.$member->happy_story_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            
                            <a title="VIEW" href="'.base_url('administrator/stories/view_story/'.$member->happy_story_id ).'">'.translate('view').'</a><br>                         
                            '.$aprove.'
                            '.$delete.'
                        </div>';                
                $data[]= array($no,$profile, $member->title, $member->created_date,$member->first_name,$member->partner_name,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
     public function totalEarnings()
    {
        $members =$this->HomeModel->getearningDatas();
        
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                // print_r($member);exit;
                
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                

               $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }
               // print_r($plan);exit;
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                $date = date('d-m-Y H:i:s' , $member->purchase_datetime);
                $status=getPaidLabel($member->payment_status);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deletepayment/'.$member->package_payment_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" onclick="acceptMember('.$member->package_payment_id.')"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>';                
                $data[]= array($no,$profile, $profile_id,$member->custom_payment_method_transaction_id, $member->first_name,$plan,$date,$member->payment_type,$member->amt,$member->mobile,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineEarnings()
    {
        $members =$this->HomeModel->getonlineearningDatas();
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                

               $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }
               // print_r($plan);exit;
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                $date = date('d-m-Y H:i:s' , $member->purchase_datetime);
                $status=getPaidLabel($member->payment_status);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deletepayment/'.$member->package_payment_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" onclick="acceptMember('.$member->package_payment_id.')"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                           '.$delete.' 
                        </div>';                
                $data[]= array($no,$profile, $profile_id,$member->custom_payment_method_transaction_id, $member->first_name,$plan,$date,$member->payment_type,$member->amt,$member->mobile,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function offlineEarnings()
    {
        $members =$this->HomeModel->getofflineearningDatas();
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                

               $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }
               // print_r($plan);exit;
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                $status=getPaidLabel($member->payment_status);
                $date = date('d-m-Y H:i:s' , $member->purchase_datetime);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deletepayment/'.$member->package_payment_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" onclick="acceptMember('.$member->package_payment_id.')"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>';                
                $data[]= array($no,$profile, $profile_id,$member->custom_payment_method_transaction_id, $member->first_name,$plan,$date,$member->payment_type,$member->amt,$member->mobile,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function contactMessages()
    {
        $members =$this->HomeModel->getcontactDatas('contact_message','result');
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                if ($member->reply != '') { $status = "<center><span class='badge badge-soft-success badge-border'>".translate('replied')."</span></center>"; } else { $status = "<center><span class='badge badge-soft-danger badge-border'>".translate('not_replied')."</span></center>"; }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMessage/'.$member->contact_message_id ).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" href="'.base_url('administrator/contact_message/view_message/'.$member->contact_message_id ).'"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>';               
                $data[]= array($no,$member->name,$member->subject,date('d/m/Y h:i A', $member->timestamp),$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function allStaffs()
    {
        $members =$this->HomeModel->getAdminDatas('admin','result','admin_id');
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                $roles =getData('role','row',array('role_id'=>$member->role));
                $role="";
                if($roles->name=='Master'){
                    $role = '<span class="badge badge-soft-success badge-border">master</span>';
                }
                elseif($roles->name=='Enabler'){
                    $role = '<span class="badge badge-soft-warning badge-border">enabler</span>';
                }
                elseif($roles->name=='Accountant'){
                    $role = '<span class="badge badge-soft-primary badge-border">Accountant</span>';
                }

                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteAdmin/'.$member->admin_id ).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" href="'.base_url('administrator/all_staffs/edit_admin/'.$member->admin_id ).'"><i class="fa fa-edit label-icon align-middle fs-16 me-2" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>';               
                $data[]= array($no,$member->name,$member->email,$role,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function mangeRole()
    {
        $members =$this->HomeModel->getAdminDatas('role','result','role_id');
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }

                if($member->role_id == 1){
                    $action='';
                }else{
                    $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteRole/'.$member->role_id ).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" href="'.base_url('administrator/manage_role/edit_role/'.$member->role_id ).'"><i class="fa fa-edit label-icon align-middle fs-16 me-2" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>'; 
                }

                              
                $data[]= array($no,$member->name,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }



     function reportss()
    {  
        
            $member_approval = $this->db->get_where('general_settings', array('type' => 'member_approval_by_admin'))->row()->value;
            if ($this->session->flashdata('alert') == "block") {
                $page_data['danger_alert'] = translate("you_have_successfully_blocked_this_member!");
            } elseif ($this->session->flashdata('alert') == "unblock") {
                $page_data['success_alert'] = translate("you_have_successfully_unlocked_this_member!");
            } elseif ($this->session->flashdata('alert') == "delete") {
                $page_data['success_alert'] = translate("this_member_is_moved_to_deleted_member_list!");
            } elseif ($this->session->flashdata('alert') == "failed_delete") {
                $page_data['danger_alert'] = translate("failed_to_delete_this_member!");
            } elseif ($this->session->flashdata('alert') == "member_approval") {
                $page_data['success_alert'] = translate("you_have_successfully_approved_this_member!");
            } elseif ($this->session->flashdata('alert') == "demo_msg") {
                $page_data['danger_alert'] = translate("this_operation_is_disabled_in_demo!");
            }

    
            $columns = array(
                0 =>'',
                1 =>'member_profile_id',
                2 =>'first_name',
                3 =>'follower',
                4 =>'reported_by',
                5 =>'profile_downloads',
                6 =>'mobile',
                7 =>'member_since',
            );
            
             
            $limit = $this->input->post('length');
            $start = $this->input->post('start');
            
            $member_type = $this->input->post('member_type');
            
             
            if($this->input->post('order')[0]['column'] == 0){
                $order = 'member_id';
                $dir = 'desc';
            }else{
                $order = $columns[$this->input->post('order')[0]['column']];
                $dir = $this->input->post('order')[0]['dir'];
            }
             
            if ($member_type == 'online') {
                $filterBy = 'online';
            }
            elseif($member_type == "offline")
            {
                $filterBy = 'offline';                 
            }
            elseif($member_type == "closed")
            {
                $filterBy = 'closed';                 
            }
            else
            {
                $filterBy = '';
            }
            $from_date=$this->input->post('from_date');
            $to_date=$this->input->post('to_date');
            // ===================
            $member_type = '';
            $totalDataWithOutPic = '';
            $totalData = $this->Customers_model->reportTotal($filterBy,$from_date,$to_date);
            
            $totalFiltered = count($totalData);

            if(empty($this->input->post('search')['value']))
            {

                $members = $this->Customers_model->allReportmembers($limit,$start,$order,$dir,$filterBy,$from_date,$to_date);
            }
            else {
                $search = $this->input->post('search')['value'];

                $members =  $this->Customers_model->reports_members_search($limit,$start,$search,$order,$dir,$filterBy,$from_date,$to_date);

                $totalFiltered = $this->Customers_model->reports_members_search_count($search,$filterBy,$from_date,$to_date);
            }

            $data = array();
            //SMS sending Code
            $arr = '';
            if(isset($totalData) && $totalData != ''){
                foreach($totalData as $value)
                {
                    $arr .= $value->mobile.',';
                    
                }
            }
            // =========================
            
            if(!empty($members))
            {
                $no=1;
                foreach($members as $member)
                
                   {    
                    $images = json_decode($member->profile_image);
                       $profileimage = "";
                        if(!empty($images)){
                            foreach($images as $image){
                                $profileimage = $image->profile_image;
                
                               }
                        }
                   if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                    }
                    else
                    {
                        $profile = '
                        <div class="card ribbon-box border mb-lg-0">
                                        <div class="card-body text-muted">
                                            <div class="ribbon-two ribbon-two-danger">registered</div>
                                            <p><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                        </div>
                                    </div>';
                    }   

                if(substr($member->member_profile_id,0,1) == 'M')
                 {
                     $one = substr($member->member_profile_id,0,4);
                     $trasOne = translate($one);
                     $two = substr($member->member_profile_id,4);
                     $id= $trasOne.$two;
                 }
                 else if(substr($member->member_profile_id,0,1) == 'F')
                 {
                     $one = substr($member->member_profile_id,0,6);
                     $trasOne = translate($one);
                     $two = substr($member->member_profile_id,6);
                     $id = $trasOne.$two;
                 }
                 else if ($member->member_profile_id=='') {
                    $id=translate('temporary');
                 }
                 else
                 {
                    $id=$member->member_profile_id;
                 }            
               
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }       

                
               
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
               $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>'; 
                $nestedData['sno'] = $no;  
                $nestedData['image'] = $profile;                   
                $nestedData['member_id'] = $id;
                $nestedData['name'] = $member->first_name;
                $nestedData['follower'] = $member->follower;
                    
                $nestedData['profile_reported'] = $member->reported_by;
                          
                $nestedData['profile_downloads'] = $member->remain_download;
                $nestedData['mobile'] = $member->mobile;
                $nestedData['member_since'] = date('d/m/Y h:i:s A', strtotime($member->member_since));
                $nestedData['member_status'] = $status;
                $nestedData['options'] = $action;
                                $data[] = $nestedData;
                    // if ($dir == 'asc') { $i++; } elseif ($dir == 'desc') { $i--; }
                $no++;
                }
               
            }

            $json_data = array(
                        "draw"            => intval($this->input->post('draw')),
                        "recordsTotal"    => intval($totalData),
                        "recordsFiltered" => intval($totalFiltered),
                        "data"            => $data,
                        
                        );

            echo json_encode($json_data);

        }
    

        function reports($member_type,$from_date,$to_date)
        {
            $members=$this->Customers_model->reportsTotal($member_type,$from_date,$to_date);

            if(!empty($members)){
                $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                

               $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            
                        </div>'; 

                $txn_id = "";        
                $payment = getMemberCurrentPayment($member->member_id); 
                if(!empty($payment)){

                    $txn_id = $payment->custom_payment_method_transaction_id;
                }


                $data[]= array($no,$profile, $profile_id, $member->first_name, $member->mobile,$txn_id, $plan, $member->membership_date, $member->created_date,$status);
                $no++;
            }
            
            }
            $datas['data']=$data;
            echo json_encode($datas);
        }


    public function memberActivity()
    {
        $members =$this->HomeModel->getMemberActiveDatas();
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                // print_r($member);exit;
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }

                
                $location = '<span class="badge rounded-pill badge-outline-info">'.$member->location.'</span>';
               
               // print_r($plan);exit;
              
                
                          
                $data[]= array($no, $profile_id, $member->first_name, $member->mobile, $member->activity, $location, $member->date);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function adminActivity()
    {
        $admin_activity =$this->HomeModel->getAdminActiveDatas();

        $data=[];        
        if (!empty($admin_activity)) {
            $no=1;
            foreach ($admin_activity as $activity) {
                // print_r($activity);exit;
               
                
            $data[]= array($no, $activity->name, $activity->phone, $activity->activity, $activity->date);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function matchedMembers()
    {
        $members =$this->HomeModel->getMatchedDatas('member','result');
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                // print_r($activity);exit;
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                if($member->isRenewed==1){

                                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                                    <div class="card-body text-muted">
                                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                                    </div>
                                                </div>
                                                ';
                                }
                                else
                                {
                                    $profile = '
                                    <div class="card ribbon-box border mb-lg-0">
                                                    <div class="card-body text-muted">
                                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                                    </div>
                                                </div>';
                                }
                // $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                //$status=getStatusLabel($member->is_closed);

                    $action = '<a title="ACTIVATE" href="'.base_url('administrator/matchMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to active this?\');" class="btn btn-xs btn-outline-success btn-border">'.translate('active').'</a>';
                
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }    
                
            $data[]= array($no, $profile, $profile_id,$member->first_name, $member->mobile, $member->matched_date, $status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function matchedMembersMale()
    {
        $members =$this->HomeModel->getMatchedDatas('member','result',1);
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                // print_r($activity);exit;
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                if($member->isRenewed==1){

                                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                                    <div class="card-body text-muted">
                                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                                    </div>
                                                </div>
                                                ';
                                }
                                else
                                {
                                    $profile = '
                                    <div class="card ribbon-box border mb-lg-0">
                                                    <div class="card-body text-muted">
                                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                                    </div>
                                                </div>';
                                }
                // $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                //$status=getStatusLabel($member->is_closed);
                                $action = '<a title="ACTIVATE" href="'.base_url('administrator/matchMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to active this?\');" class="btn btn-xs btn-outline-success btn-border">'.translate('active').'</a>';
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }    
                
            $data[]= array($no, $profile, $profile_id,$member->first_name, $member->mobile, $member->matched_date, $status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function matchedMembersFemale()
    {
        $members =$this->HomeModel->getMatchedDatas('member','result',2);
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                // print_r($activity);exit;
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                if($member->isRenewed==1){

                                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                                    <div class="card-body text-muted">
                                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                                    </div>
                                                </div>
                                                ';
                                }
                                else
                                {
                                    $profile = '
                                    <div class="card ribbon-box border mb-lg-0">
                                                    <div class="card-body text-muted">
                                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                                    </div>
                                                </div>';
                                }
                // $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                //$status=getStatusLabel($member->is_closed);
                                $action = '<a title="ACTIVATE" href="'.base_url('administrator/matchMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to active this?\');" class="btn btn-xs btn-outline-success btn-border">'.translate('active').'</a>';
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }    
                
            $data[]= array($no, $profile, $profile_id,$member->first_name, $member->mobile, $member->matched_date, $status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }


    public function viewFaq()
    {
        $faq_datas = $this->HomeModel->getfaqDatas('faq_ques','result','');
        // print_r($faq_datas);exit;
        $data=[];        
        if (!empty($faq_datas)) {
            $no=1;
            foreach ($faq_datas as $faq_data) {
                
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('AdminController/deleteFaq/'.$faq_data->id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a title="EDIT" href="'.base_url('administrator/edit_faq/'.$faq_data->id).'"><i class="fa fa-edit label-icon align-middle fs-16 me-2"></i></a><br>                         
                            '.$delete.'
                            
                            
                        </div>';   
                
            $data[]= array($no, $faq_data->ques_english,$faq_data->ques_tamil, $faq_data->ans_english, $faq_data->ans_tamil, $action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function commonFaq()
    {
        $faq_datas = $this->HomeModel->getcommonfaqDatas('faq_ques','result');
        // print_r($faq_datas);exit;
        $data=[];        
        if (!empty($faq_datas)) {
            $no=1;
            foreach ($faq_datas as $faq_data) {
                
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = ' <a title="DELETE" href="'.base_url('AdminController/deleteFaq/'.$faq_data->id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a title="EDIT" href="'.base_url('administrator/edit_faq/'.$faq_data->id).'"><i class="fa fa-edit label-icon align-middle fs-16 me-2"></i></a><br>                         
                            
                             '.$delete.'
                            
                        </div>';   
                
            $data[]= array($no, $faq_data->ques_english,$faq_data->ques_tamil, $faq_data->ans_english, $faq_data->ans_tamil, $action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function onlineFaq()
    {
        $faq_datas = $this->HomeModel->getfaqDatas('faq_ques','result',1);
        // print_r($faq_datas);exit;
        $data=[];        
        if (!empty($faq_datas)) {
            $no=1;
            foreach ($faq_datas as $faq_data) {
                
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = ' <a title="DELETE" href="'.base_url('AdminController/deleteFaq/'.$faq_data->id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a title="EDIT" href="'.base_url('administrator/edit_faq/'.$faq_data->id).'"><i class="fa fa-edit label-icon align-middle fs-16 me-2"></i></a><br>                         
                            '.$delete.'
                            
                            
                        </div>';   
                
            $data[]= array($no, $faq_data->ques_english,$faq_data->ques_tamil, $faq_data->ans_english, $faq_data->ans_tamil, $action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function offlineFaq()
    {
        $faq_datas = $this->HomeModel->getfaqDatas('faq_ques','result',2);
        // print_r($faq_datas);exit;
        $data=[];        
        if (!empty($faq_datas)) {
            $no=1;
            foreach ($faq_datas as $faq_data) {
                
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('AdminController/deleteFaq/'.$faq_data->id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a> ';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a title="EDIT" href="'.base_url('administrator/edit_faq/'.$faq_data->id).'"><i class="fa fa-edit label-icon align-middle fs-16 me-2"></i></a><br>                         
                            '.$delete.'
                             
                            
                        </div>';   
                
            $data[]= array($no, $faq_data->ques_english,$faq_data->ques_tamil, $faq_data->ans_english, $faq_data->ans_tamil, $action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }
    public function viewTemplate()
    {
        $Datas = $this->HomeModel->getTemplateDatas('email_templates','result');
        // print_r($Datas);exit;
        $data=[];        
        if (!empty($Datas)) {
            $no=1;
            foreach ($Datas as $Data) {
                
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('AdminController/deleteTemplate/'.$Data->id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a title="PREVIEW" href="'.base_url('administrator/preview_template/'.$Data->id).'"><i class="fas fa-eye"></i></a><br> 
                            <a title="EDIT" href="'.base_url('administrator/edit_template/'.$Data->id).'"><i class="fas fa-edit text-info"></i></a><br>                         
                            
                            '.$delete.'
                            
                        </div>';   
                
            $data[]= array($no, $Data->temp_name, $Data->subject, $action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }


    public function deactivatedMembers()
    {
        $members =$this->HomeModel->getDeactivateDatas('member','result');
        // print_r($members);exit;
        $data=[];        
        if (!empty($members)) {
            $no=1;
            foreach ($members as $member) {
                    
                if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
                
                
               $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
                

               $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }
               // print_r($plan);exit;
               $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
                if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
                
                $first_name = (strlen($member->first_name)>20) ?substr($member->first_name,0,20).'<br>': $member->first_name;
                $report=getReportLabel($member->reported_by);
                //$status=getStatusLabel($member->is_closed);
                if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                            <a title="DELETE" href="'.base_url('administrator/activateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to deactive this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('active').'</a>
                            
                        </div>';                
                $data[]= array($no,$profile, $profile_id, $member->first_name,$plan,$report,$member->remain_download, $member->mobile,$member->created_date,$status,$action);
                $no++;
            }
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }


public function all_customers_server_data_table()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'member_id',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getAllDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0";


        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }



public function offline_customer_server_table()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'member_id',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOfflineDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function online_customer_server_table()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'member_id',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOnlineDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function offlineRegisterMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOfflineDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function offlineRegisterMale()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOfflineMale('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=2 AND gender=1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function offlineRegisterFemale()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOfflineFemale('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=2 AND gender=2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }



    public function pendingRenewalMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getPendingDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND isRenewed=0";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

   


    public function pendingRenewalOfflineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getPendingOfflineDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND isRenewed=0 AND member_type=2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function pendingRenewalOnlineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getPendingOnlineDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND isRenewed=0 AND member_type=1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function pendingRenewalUnpaidMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getPendingOnlineUnpaid('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND isRenewed=0 AND member_type=1 AND membership=1 AND updateProfileDoneStatus=0";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            
            $BlockUser=getBlockLabel($member->is_blocked);
           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $plan;
            $nestedData[] = $BlockUser;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function incompleteMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getincompleteProfileDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=0 AND member_since >= CURDATE() - INTERVAL 6 MONTH";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function incompleteOnlinePaidMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getincompleteOnlinePaid('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=0 AND member_type=1 AND membership = 2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }


    public function incompleteOnlineUnPaidMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getincompleteOnlineUnpaid('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=0 AND member_type=1 AND membership = 1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function incompleteOfflineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getincompleteOffline('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=0 AND member_type=2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function withoutProfileMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getWithoutProfileDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=1 AND is_closed ='no' AND member_since >= CURDATE() - INTERVAL 6 MONTH AND membership_date >= CURDATE() - INTERVAL 6 MONTH";
        $sql.= " AND (`profile_image` LIKE '%\"profile!_image\":\"default.jpg\"%' ESCAPE '!' OR `profile_image` LIKE '%\"profile!_image\":\"default!_female.jpg\"%' ESCAPE '!')";
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function withoutProfileOfflineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getWithoutProfileOffline('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=1 AND is_closed ='no' AND member_type=2 AND member_since >= CURDATE() - INTERVAL 6 MONTH AND membership_date >= CURDATE() - INTERVAL 6 MONTH";
        $sql.= " AND (`profile_image` LIKE '%\"profile!_image\":\"default.jpg\"%' ESCAPE '!' OR `profile_image` LIKE '%\"profile!_image\":\"default!_female.jpg\"%' ESCAPE '!')";
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }
    public function withoutProfileOnlineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getWithoutProfileOnline('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND updateProfileDoneStatus=1 AND is_closed ='no' AND member_type=1 AND member_since >= CURDATE() - INTERVAL 6 MONTH AND membership_date >= CURDATE() - INTERVAL 6 MONTH";
        $sql.= " AND (`profile_image` LIKE '%\"profile!_image\":\"default.jpg\"%' ESCAPE '!' OR `profile_image` LIKE '%\"profile!_image\":\"default!_female.jpg\"%' ESCAPE '!')";
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function blockedMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getblockDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM blocked_members LEFT JOIN member ON blocked_members.blocked_member_id = member.member_id WHERE member.is_blocked='yes' AND blocked_members.delete_status=0 AND member.date_of_birth !=0";
        // print_r($sql);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY member.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->reason;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function blockedOfflineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getblockOfflineDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM blocked_members LEFT JOIN member ON blocked_members.blocked_member_id = member.member_id WHERE member.is_blocked='yes' AND blocked_members.delete_status=0 AND member.date_of_birth !=0 AND member.member_type=2";
        // print_r($sql);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY member.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->reason;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function blockedOnlineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getblockOnlineDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM blocked_members LEFT JOIN member ON blocked_members.blocked_member_id = member.member_id WHERE member.is_blocked='yes' AND blocked_members.delete_status=0 AND member.member_type=1 AND member.date_of_birth !=0";
        // print_r($sql);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY member.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->reason;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }


public function closedMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getCloseDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM closed_members LEFT JOIN member ON closed_members.member_id = member.member_id WHERE member.is_closed='yes' AND closed_members.delete_status=0 AND member.date_of_birth !=0";
        // print_r($sql);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY member.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->reason;
            $nestedData[] = $member->other_reason;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function closedOfflineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getCloseOfflineDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM closed_members LEFT JOIN member ON closed_members.member_id = member.member_id WHERE member.is_closed='yes' AND closed_members.delete_status=0 AND member.member_type=2 AND member.date_of_birth !=0";
        // print_r($sql);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY member.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->reason;
            $nestedData[] = $member->other_reason;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function closedOnlineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getCloseOnlineDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM closed_members LEFT JOIN member ON closed_members.member_id = member.member_id WHERE member.is_closed='yes' AND closed_members.delete_status=0 AND member.member_type=1 AND member.date_of_birth !=0";
        // print_r($sql);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY member.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->reason;
            $nestedData[] = $member->other_reason;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function duplicatedMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getDuplicateDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql = "SELECT mem.* FROM member AS mem INNER JOIN (SELECT mobile FROM member WHERE mobile != '' GROUP BY (mobile) HAVING COUNT(mobile) > 2) AS mem1 ON mem.mobile = mem1.mobile WHERE mem.mobile!='' AND mem.is_closed='no' AND mem.date_of_birth !=0 AND mem.deactivate_status=0 AND mem.isRenewed=0";
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY mem.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

     public function duplicatedOnlineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getDuplicateOnline());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql = "SELECT mem.* FROM member AS mem INNER JOIN (SELECT mobile FROM member WHERE mobile != '' GROUP BY (mobile) HAVING COUNT(mobile) > 2) AS mem1 ON mem.mobile = mem1.mobile WHERE mem.mobile!='' AND mem.is_closed='no' AND mem.date_of_birth !=0 AND mem.deactivate_status=0 AND mem.isRenewed=0 AND mem.member_type=1";
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY mem.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function duplicatedOfflineMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getDuplicateOffline());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql = "SELECT mem.* FROM member AS mem INNER JOIN (SELECT mobile FROM member WHERE mobile != '' GROUP BY (mobile) HAVING COUNT(mobile) > 2) AS mem1 ON mem.mobile = mem1.mobile WHERE mem.mobile!='' AND mem.is_closed='no' AND mem.date_of_birth !=0 AND mem.deactivate_status=0 AND mem.isRenewed=0 AND mem.member_type=2";
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY mem.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }


    public function onlineRegisterMember()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOnlineDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);
           $BlockUser=getBlockLabel($member->is_blocked);
            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $plan;
            $nestedData[] = $BlockUser;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function onlineRegistermaleMember()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOnlineMaleDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=1 AND gender=1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);
           $BlockUser=getBlockLabel($member->is_blocked);
            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $plan;
            $nestedData[] = $BlockUser;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function onlineRegisterfemaleMember()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOnlineFemaleDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=1 AND gender=2";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);
           $BlockUser=getBlockLabel($member->is_blocked);
            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $plan;
            $nestedData[] = $BlockUser;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function onlineRegisterRenewedMember()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOnlineRenewDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=0 AND deactivate_status=0 AND date_of_birth !=0 AND member_type=1 AND isRenewed=1 AND membership=2 AND updateProfileDoneStatus=1 AND is_closed='no' AND membership_date >= CURDATE() - INTERVAL 6 MONTH";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);
           $BlockUser=getBlockLabel($member->is_blocked);
            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $plan;
            $nestedData[] = $BlockUser;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function deleteMembers()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getDeletedDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=1";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);
           $BlockUser=getBlockLabel($member->is_blocked);
            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function oldRenewedMember()
    {
      
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'profile_id',2=> 'username',3=> 'email',4=> 'mobile_number',5=> 'dob',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        $totalData = count($this->HomeModel->getOldRenewedDatas('deactivated_member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM deactivated_member WHERE `delete_status`=0";

        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($_REQUEST);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);
           $BlockUser=getBlockLabel($member->is_blocked);
            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->follower;
            $nestedData[] = $report;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function matchedProfileMember()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getMatchedDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=1 AND is_married=1 AND deactivate_status=0  AND date_of_birth !=0 ";


        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($sql);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function matchedProfileMaleMember()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getMatchedDatas('member','result',1));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=1 AND is_married=1 AND deactivate_status=0  AND date_of_birth !=0 AND gender =1 ";


        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($sql);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

public function matchedProfileFeMaleMember()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getMatchedDatas('member','result',2));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=1 AND is_married=1 AND deactivate_status=0  AND date_of_birth !=0 AND gender =2 ";


        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($sql);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function deactivatedMember()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'prefixId',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getDeactivateDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        $sql="SELECT * FROM member WHERE `delete_status`=1 AND deactivate_status=1  AND date_of_birth !=0 ";


        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($sql);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $report;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $member->mobile;
            $nestedData[] = $registered_date;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }


    public function reportProfileMember()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'member_id',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getreportedDatas('member','result'));
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        // $sql="SELECT * FROM member WHERE `delete_status`=1 AND deactivate_status=1  AND date_of_birth !=0 ";

        $sql="SELECT * FROM members_report LEFT JOIN member ON member.member_id = members_report.member_id WHERE member.delete_status=0 AND members_report.delete_status=0 AND member.date_of_birth !=0";

        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY members_report.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($sql);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
            $member2 =$this->HomeModel->getSingleData('member',$member->reported_member_id); 
            $reportstatus = "";
            if(!empty($member2->member_profile_id)){
                $reportstatus=getReportedLabel($member2->prefixId,$member2->member_profile_id,$member2->first_name);
            }
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deleteMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18"> 
                            <a  class="btn btn-xs btn-outline-primary btn-border" title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'">'.translate('view').'</a><br>                         
                            '.$block.'
                            '.$delete.'
                            <a title="MATCH" href="'.base_url('AdminController/deactivateMember/'.$member->member_id).'" onclick="return confirm(\'Are you sure want to match this?\');" class="btn btn-xs btn-outline-dark btn-border">'.translate('match').'</a>
                          
                            
                            
                        </div>';  
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->details;
            $nestedData[] = $member->remain_download;
            $nestedData[] = $registered_date;
            $nestedData[] = $reportstatus;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function total_earnings()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'package_payment_id',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getearningDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        // $sql="SELECT * FROM member WHERE `delete_status`=1 AND deactivate_status=1  AND date_of_birth !=0 ";

        $sql="SELECT * FROM package_payment LEFT JOIN member ON member.member_id = package_payment.member_id LEFT JOIN plan ON plan.plan_id = package_payment.plan_id WHERE member.delete_status=0 AND package_payment.delete_status=0 AND member.date_of_birth !=0";

        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY package_payment.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($allcustomers_data);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
           
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           // if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
           //      {
           //          $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
           //      }else{
           //          $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
           //      }
                $status=getPaidLabel($member->payment_status);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deletepayment/'.$member->package_payment_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" onclick="acceptMember('.$member->package_payment_id.')"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>'; 
            $date = date('d-m-Y H:i:s' , $member->purchase_datetime);   
            if($member->member_type==1)
            {
                $amount = $member->amount;
            }else
            {
                $amount = $member->offline_amount;
            }
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->custom_payment_method_transaction_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $date;
            $nestedData[] = $member->payment_type;
            $nestedData[] = $amount;
            $nestedData[] = $member->mobile;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function total_earnings_online()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'package_payment_id',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getonlineearningDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        // $sql="SELECT * FROM member WHERE `delete_status`=1 AND deactivate_status=1  AND date_of_birth !=0 ";

        $sql="SELECT * FROM package_payment LEFT JOIN member ON member.member_id = package_payment.member_id LEFT JOIN plan ON plan.plan_id = package_payment.plan_id WHERE member.delete_status=0 AND member.member_type=1 AND package_payment.delete_status=0 AND member.date_of_birth !=0";

        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY package_payment.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($allcustomers_data);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
           
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           // if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
           //      {
           //          $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
           //      }else{
           //          $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
           //      }
                $status=getPaidLabel($member->payment_status);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deletepayment/'.$member->package_payment_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" onclick="acceptMember('.$member->package_payment_id.')"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>'; 
            $date = date('d-m-Y H:i:s' , $member->purchase_datetime);     
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->custom_payment_method_transaction_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $date;
            $nestedData[] = $member->payment_type;
            $nestedData[] = $member->amount;
            $nestedData[] = $member->mobile;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }
     public function total_earnings_offline()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'package_payment_id',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getofflineearningDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        // $sql="SELECT * FROM member WHERE `delete_status`=1 AND deactivate_status=1  AND date_of_birth !=0 ";

        $sql="SELECT * FROM package_payment LEFT JOIN member ON member.member_id = package_payment.member_id LEFT JOIN plan ON plan.plan_id = package_payment.plan_id WHERE member.delete_status=0 AND member.member_type=2 AND package_payment.delete_status=0 AND member.date_of_birth !=0";

        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY package_payment.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($allcustomers_data);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
           
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            

           // if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
           //      {
           //          $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
           //      }else{
           //          $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
           //      }
                $status=getPaidLabel($member->payment_status);
                $delete = "";
                if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){

                    $delete = '<a title="DELETE" href="'.base_url('administrator/deletepayment/'.$member->package_payment_id).'" onclick="return confirm(\'Are you sure want to delete this?\');" class="btn btn-xs btn-outline-danger btn-border">'.translate('delete').'</a>';
                }

                $action='<div class="hstack gap-2 fs-18">  
                            <a title="VIEW" onclick="acceptMember('.$member->package_payment_id.')"><i class="mdi mdi-eye text-primary" style="cursor:pointer"></i></a><br>
                            '.$delete.'
                        </div>'; 
            $date = date('d-m-Y H:i:s' , $member->purchase_datetime);     
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->custom_payment_method_transaction_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $plan;
            $nestedData[] = $date;
            $nestedData[] = $member->payment_type;
            $nestedData[] = $member->offline_amount;
            $nestedData[] = $member->mobile;
            $nestedData[] = $status;
            $nestedData[] = $action;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }

    public function member_activities()
    {
      // print_r('nkbjb');exit;
        $columns = array( 
        // datatable column index  => database column name
            0 =>'created_date',1=>'member_profile_id',2=> 'prefixId',3=> 'first_name',4=> 'mobile',5=> 'date_of_birth',);

        // storing  request (ie, get/post) global array to a variable  
        $requestData= $_REQUEST;
        
        $totalData = count($this->HomeModel->getMemberActiveDatas());
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        // print_r($totalData);exit;
        // $sql="SELECT * FROM users WHERE `user_role`=2 AND delete_status=0";

        
        // $sql="SELECT * FROM member WHERE `delete_status`=1 AND deactivate_status=1  AND date_of_birth !=0 ";

        $sql="SELECT *,user_activity.created_date AS date FROM user_activity LEFT JOIN member ON member.member_id = user_activity.member_id WHERE member.delete_status=0 AND member.date_of_birth !=0";

        if( !empty($requestData['search']['value']) ) {   
        // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND (member.member_id LIKE '%".$requestData['search']['value']."%'";    
             $sql.=" OR member.member_profile_id LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.prefixId LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.first_name LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.mobile LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.date_of_birth LIKE '%".$requestData['search']['value']."%'";
            $sql.=" OR member.email = '%".$requestData['search']['value']."%'";     
            $sql.=" OR member.created_date LIKE '%".$requestData['search']['value']."%'";    
            $sql.=" OR member.soveran_detail LIKE '%".$requestData['search']['value']."' )";
        }
        // print_r($requestData);exit;
        // when there is a search parameter then we have to modify total number filtered rows as per search result. 
      $totalFiltered = count($this->HomeModel->process_custom_query($sql));  

        $sql.=" ORDER BY user_activity.". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        // print_r($totalFiltered);exit;
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
         
        $allcustomers_data=$this->HomeModel->process_custom_query($sql); 
        // print_r($allcustomers_data);exit;
        $data = array();

        $sno=1;
        if($requestData['draw']==1){
            $sno=1;
        }else{
            $sno=$requestData['start']+1;
        }
        $viewed_count=0;
        foreach ($allcustomers_data as $member) {
            $registered_date=explode(' ',$member->created_date);
            $nestedData=array();            
            
            $images = json_decode($member->profile_image);
               $profileimage = "";
                if(!empty($images)){
                    foreach($images as $image){
                        $profileimage = $image->profile_image;
        
                       }
                }
            if($member->isRenewed==1){

                    $profile = '<div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger"><span>'.translate('renewed').'</span></div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>
                                ';
                }
                else
                {
                    $profile = '
                    <div class="card ribbon-box border mb-lg-0">
                                    <div class="card-body text-muted">
                                        <div class="ribbon-two ribbon-two-danger">registered</div>
                                        <p class="mb-0"><img src="'.base_url('uploads/profile_image/').$profileimage.'" style="width: 60px;height: 60px;"></p>
                                    </div>
                                </div>';
                }
            

            if(empty($member->member_profile_id)){

                    $profile_id = translate('temporary');
                }else{

                    $profile_id = $member->member_profile_id;
                }
            

            $packages = json_decode($member->package_info);
               $plan="";
               if(!empty($packages)){
               foreach($packages as $package){
                $plan = $package->current_package;

               }
            }          
            
           
            

           $report=getReportLabel($member->reported_by);

            if(!empty($member->membership_date)){
                   $expired = date("Y-m-d", strtotime("+6 months", strtotime($member->membership_date))); 
               }else{

                $expired = " ";

               }
                    
            $block = "";
               if($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] == 1){
               if($member->is_blocked=='no'){

                $block = '<a title="BLOCK" onclick="blockMember('.$member->member_id.')" class="btn btn-xs btn-outline-info btn-border">'.translate('block').'</a>';
                }else{
                    $block = '<a title="BLOCK" href="'.base_url().'administrator/unblockMember/'.$member->member_id.'" onclick="return confirm(\'Are you sure want to unBlock this?\');" class="btn btn-xs btn-outline-info btn-border">'.translate('unblock').'</a>';
                }
            }
            
             if(getStatusLabel($member->is_closed)==1 || $expired <= date('Y-m-d') || $member->updateProfileDoneStatus==0)
                {
                    $status = '<span class="badge badge-soft-danger badge-border">'.translate('in_active').'</span>';
                }else{
                    $status = '<span class="badge badge-soft-success badge-border">'.translate('active').'</span>';  
                }
                 
                $location = '<span class="badge rounded-pill badge-outline-info">'.$member->location.'</span>';
    
            $nestedData[] = $sno;
            $nestedData[] = $profile;
            $nestedData[] = $profile_id;
            $nestedData[] = $member->first_name;
            $nestedData[] = $member->mobile;
            $nestedData[] = $member->activity;
            $nestedData[] = $location;
            $nestedData[] = $member->date;
            $nestedData[] = $status;

            $data[] = $nestedData;
            $sno++;
            
        }

        $json_data = array(
                    "draw"            => intval( $requestData['draw'] ),   
                    "recordsTotal"    => intval( $totalData ), 
                    "recordsFiltered" => intval( $totalFiltered ), 
                    "data"            => $data 
                    );
        echo json_encode($json_data); 
    }


}

