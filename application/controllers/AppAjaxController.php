<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppAjaxController extends MY_Controller{

    function __construct()
    {
        parent :: __construct();        
        $this->load->model('HomeModel');
        $this->load->model('Customers_model');
        $this->load->model('MetaModel');
              
    }

   public function interestMembers()
    {
        
        $total_interests = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest'), true);
               
        if (!empty($total_interests)) {
            
            $j=0;
            $no=1;
        $total_interests_ids = array();
        foreach ($total_interests as $total_interest) {
            array_push($total_interests_ids ,$total_interest['id']);
        }
        if (count($total_interests) != 0) {
            $express_interest_members = $this->db->from('member')->where_in('member_id', $total_interests_ids)->get()->result();
            $array_total_interests = $total_interests;
        }
        else{
            $express_interest_members = NULL;
        }

        // print_r($express_interest_members);exit;

          
                foreach($express_interest_members as $member){
                    // print_r($member->status);exit;
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);  
                    $birth = json_decode($member->astronomic_information, true);  

                    // print_r($spiritual_and_social_background);exit;
                 if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }    
                
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));  
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }
                if($total_interest['status']!='pending'){

                    $status = '<span class="badge badge-pill badge-success">approved</span>';
                }else{

                    $status = '<span class="badge badge-pill badge-danger">Not approved</span>';
                }


                $data[]= array($no, $image, $member->first_name, $age,$religion, $address, $language, $status);
                $no++;
                $j++;
                }
            
        
        
        }
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function shortlistMembers()
    {
        $total_shortlists = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'short_list'), true);
        
        $data=[];        
        if (!empty($total_shortlists)) {
            
            $j=0;
            $no=1;
           foreach($total_shortlists as $total_shortlist){

                $members = $this->MetaModel->getMemberData('member','result',array('member_id'=>$total_shortlist));
                foreach($members as $member){
                    // print_r($member->status);exit;
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);
                    $birth = json_decode($member->astronomic_information, true);    
                    // print_r($spiritual_and_social_background);exit;
                if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }

                
                // $status=getStatusLabel($member[$j]->active_status);
                $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest');
                $interest = json_decode($interests, true);
                $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
                if (in_assoc_array($member->member_id, 'id', $interest)) {

                    $like = '<a title="'.translate('interest_expressed').'" class="btn btn-xs btn-sm btn-outline-primary btn-border" ><i class="fa fa-heart"></i></a>';
                }else{

                    if($count_interest == 0){

                        $like = '<button type="button" title="'.translate('express_interest').'" data-toggle="modal" data-target="#interestModal" class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1"><i class="fa fa-heart"></i></button>';
                    }else{

                        $like = '<button onclick="doInterest('.$member->member_id.')" title="'.translate('express_interest').'"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1"><i class="fa fa-heart"></i></button>';

                    }
                    // print_r($count_interest);exit;

                         // $like = '<a title="'.translate('express_interest').'" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'" class="btn btn-xs btn-sm btn-outline-primary btn-border" ><i class="fa fa-heart"></i></a>';
                }

                    

                
               
                $action='<div class="hstack gap-2 fs-18"> 
                            '.$like.' 
                            <a title="'.translate('remove').'" onclick="deleteShortlist('.$member->member_id.')" class="btn btn-xs btn-sm btn-outline-danger btn-border"><i class="fa fa-close"></i></a>
                        </div>'; 


                $data[]= array($no, $image, $member->first_name, $age,$religion, $address, $language, $action,);
                $no++;
                $j++;
                }
                }
            
        }
        
        
        $datas['data']=$data;
        echo json_encode($datas);
    }


    public function followedMembers()
    {
        $total_followers = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'followed'), true);
        
        $data=[];        
        if (!empty($total_followers)) {
            
            $j=0;
            $no=1;
           foreach($total_followers as $total_follower){

                $members = $this->MetaModel->getMemberData('member','result',array('member_id'=>$total_follower));
                foreach($members as $member){
                    // print_r($member->status);exit;
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);
                    $birth = json_decode($member->astronomic_information, true);    
                    // print_r($spiritual_and_social_background);exit;
                if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }   
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }

                
                // $status=getStatusLabel($member[$j]->active_status);
                $interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest');
                $interest = json_decode($interests, true);
                $count_interest = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
                if (in_assoc_array($member->member_id, 'id', $interest)) {

                    $like = '<a title="'.translate('interest_expressed').'" class="btn btn-xs btn-sm btn-outline-primary btn-border" ><i class="fa fa-heart"></i></a>';
                }else{

                    if($count_interest == 0){

                        $like = '<button type="button" title="'.translate('express_interest').'" data-toggle="modal" data-target="#interestModal" class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1"><i class="fa fa-heart"></i></button>';
                    }else{

                        $like = '<a onclick="doInterest('.$member->member_id.')" title="'.translate('express_interest').'"  class="btn btn-xs btn-sm btn-outline-primary btn-border mr-1"><i class="fa fa-heart"></i></button>';

                    }
                    // print_r($count_interest);exit;

                         // $like = '<a title="'.translate('express_interest').'" href="'.base_url('administrator/all_members/view_member/'.$member->member_id).'" class="btn btn-xs btn-sm btn-outline-primary btn-border" ><i class="fa fa-heart"></i></a>';
                }

                    

                
               
                $action='<div class="hstack gap-2 fs-18"> 
                            '.$like.' 
                            <a title="'.translate('remove').'" onclick="deleteFollow('.$member->member_id.')" class="btn btn-xs btn-sm btn-outline-danger btn-border"><i class="fa fa-close"></i></a>
                        </div>'; 


                $data[]= array($no, $image, $member->first_name, $age,$religion, $address, $language, $action,);
                $no++;
                $j++;
                }
                }
            
        }
        
        
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function ignoreMembers()
    {
        $total_ignores = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'ignored'), true);
        
        $data=[];        
        if (!empty($total_ignores)) {
            
            $j=0;
            $no=1;
           foreach($total_ignores as $total_ignore){

                $members = $this->MetaModel->getMemberData('member','result',array('member_id'=>$total_ignore));
                foreach($members as $member){
                    // print_r($member->status);exit;
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);
                    $birth = json_decode($member->astronomic_information, true);    
                    // print_r($spiritual_and_social_background);exit;
                if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }   
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }

                
                

                    

                
               
                $action='<div class="hstack gap-2 fs-18"> 
                            
                            <a title="'.translate('unblock').'" onclick="confirm_unblock('.$member->member_id.')" class="btn btn-xs btn-sm btn-outline-success btn-border"><i class="fa fa-check"></i></a>
                        </div>'; 


                $data[]= array($no, $image, $member->first_name, $age,$religion, $address, $language, $action,);
                $no++;
                $j++;
                }
                }
            
        }
        
        
        $datas['data']=$data;
        echo json_encode($datas);
    }

    public function viewedMembers()
    {
        $view_Profile_management = $this->db->get_where("view_profile_management", array("user_id" =>$this->session->userdata('thirumanam_applogged_data')['member_id']))->result();
        $total_views = array_column($view_Profile_management,"member_user_id");
        // print_r($total_ignored);exit;
        
        $data=[];        
        if (!empty($total_views)) {
            
            $j=0;
            $no=1;
           foreach($total_views as $total_view){

                $members = $this->MetaModel->getMemberData('member','result',array('member_id'=>$total_view));
                // print_r($members);exit;
                foreach($members as $member){
                    
                $image = json_decode($member->profile_image, true);
                $language = json_decode($member->language, true);
                $spiritual_and_social_background = json_decode($member->spiritual_and_social_background, true);
                    $present_address = json_decode($member->present_address, true);
                    $birth = json_decode($member->astronomic_information, true); 
                    $astronomic_information = json_decode($member->astronomic_information, true);
                    $family_info = json_decode($member->family_info, true);   
                    // print_r($spiritual_and_social_background);exit;
                if(!empty($image[0]['thumb'])){

                   if (file_exists('uploads/profile_image/'.$image[0]['thumb'])) {
                
                    $image = '<img src="'.base_url('uploads/profile_image/').$image[0]['thumb'].'" alt="">';
                
                }
                else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                } 
                 }else {
                    if($member->gender==1){
                        $image = '<img src="'.base_url('uploads/profile_image/default.jpg').'" alt="">';
                    }else{
                        $image = '<img src="'.base_url('uploads/profile_image/default_female.jpg').'" alt=""> ';
                    }
                
                    
                }   
                $date1 =  date('Y',strtotime($birth[0]['date_of_birth']));
                $date2 = date("Y");           
                $age = $date2 - $date1; 

                $religion ="";
                if(!empty($spiritual_and_social_background[0]['religion'])){
                    $religion = get_type_name_by_id('religion', $spiritual_and_social_background[0]['religion']);
                }
                
                
                $address = "";
                if(!empty($present_address[0]['country']) || !empty($present_address[0]['state'])){ $address =  $present_address[0]['country'].','.$present_address[0]['state'];}

                $language = "";
                if(!empty($language[0]['mother_tongue'])){
                    $language = get_type_name_by_id('language', $language[0]['mother_tongue']);
                }

                
                

                    

                
               
                $action='<div class="hstack gap-2 fs-18"> 
                            
                            <a title="'.translate('unblock').'" onclick="confirm_unblock('.$member->member_id.')" class="btn btn-xs btn-sm btn-outline-success btn-border"><i class="fa fa-check"></i></a>
                        </div>'; 


                $data[]= array($no, $image, $member->member_profile_id, $member->first_name, $age,$astronomic_information[0]['DOSHAM'], $family_info[0]['father_vangusam'],);
                $no++;
                $j++;
                }
                }
            
        }
        
        
        $datas['data']=$data;
        echo json_encode($datas);
    }


}