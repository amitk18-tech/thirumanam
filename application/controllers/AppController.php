<?php
defined ('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . "libraries/lib/config_paytm.php");
require_once(APPPATH . "libraries/lib/encdec_paytm.php");
class AppController extends MY_Controller 
{
	public function __construct()
  {
     	parent::__construct();
        $this->load->model('AppModel');         
        $this->load->helper('common_helper');
        $this->load->model('LoginModel');
        
  } 



    public function index()
    { 
      $this->load->view ($this->middle = 'app/login');
    }
    public function home()
    { 
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        if($this->session->userdata('thirumanam_applogged_data'))
        {
            $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
            // print_r($member);exit;
            $gender = $member->gender;
            if($gender==1){
                $opposite_gender = 2;
            }else{
                $opposite_gender = 1;
            }
           


            $memberplan = $this->AppModel->getMemberPlan($member->member_id);
            $soveran = 25;
            if(!empty($memberplan)){
                $plan = $this->AppModel->getPlan($memberplan->plan_id);
                $soveran = $plan->soveran;
            }
            $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
            $ignored_ids = json_decode($ignored_ids, true);
            $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
            $ignored_by_ids = json_decode($ignored_by_ids, true);
            if (empty($ignored_by_ids)) {
                array_push($ignored_by_ids, 0);
            }

            if (empty($ignored_ids)) {
                array_push($ignored_ids, 0);
            }
           
            $expectation = json_decode($member->partner_expectation);
            $exist = 0;
            $partner_age=$partner_height=$partner_weight=$with_children_acceptables=$partner_any_disability=$partner_marital_status=$partner_education=$partner_body_type=$partner_DOSHAM=$partner_TYPE_OF_DOSHAM=$partner_Other_Dosham=$partner_Expectation=$partner_Other_Expectation="";
            if(!empty($expectation[0]->partner_age) && isset($expectation[0]->partner_age))
            {

                $partner_age = $expectation[0]->partner_age;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_height) && isset($expectation[0]->partner_height))
            {

                $partner_height = $expectation[0]->partner_height;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_weight) && isset($expectation[0]->partner_weight))
            {

                $partner_weight = $expectation[0]->partner_weight;
                $exist = 1;
            }
            if(!empty($expectation[0]->with_children_acceptables) && isset($expectation[0]->with_children_acceptables))
            {

                $with_children_acceptables = $expectation[0]->with_children_acceptables;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_any_disability) && isset($expectation[0]->partner_any_disability))
            {

                $partner_any_disability = $expectation[0]->partner_any_disability;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_marital_status) && isset($expectation[0]->partner_marital_status))
            {

                $partner_marital_status = $expectation[0]->partner_marital_status;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_education) && isset($expectation[0]->partner_education))
            {

                $partner_education = $expectation[0]->partner_education;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_body_type) && isset($expectation[0]->partner_body_type))
            {

                $partner_body_type = $expectation[0]->partner_body_type;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_DOSHAM) && isset($expectation[0]->partner_DOSHAM))
            {

                $partner_DOSHAM = $expectation[0]->partner_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_TYPE_OF_DOSHAM) && isset($expectation[0]->partner_TYPE_OF_DOSHAM))
            {

                $partner_TYPE_OF_DOSHAM = $expectation[0]->partner_TYPE_OF_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_Other_Dosham) && isset($expectation[0]->partner_Other_Dosham))
            {

                $partner_Other_Dosham = $expectation[0]->partner_Other_Dosham;
                $exist = 1;
            }
            // if(!empty($expectation[0]->partner_Expectation) && isset($expectation[0]->partner_Expectation))
            // {

            //     $partner_Expectation = $expectation[0]->partner_Expectation;
            //     $exist = 1;
            // }
            // if(!empty($expectation[0]->partner_Other_Expectation) && isset($expectation[0]->partner_Other_Expectation))
            // {

            //     $partner_Other_Expectation = $expectation[0]->partner_Other_Expectation;
            //     $exist = 1;
            // }
             
            // print_r($expectation[0]->partner_Expectation);exit;
            $datas['matched_members'] ="";
            if($exist==1)
            {
            $datas['matched_members'] = $this->AppModel->get_matched_members($opposite_gender,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids);
            }
            // print_r($datas['matched_members']);exit;

        $permanent_address = json_decode($member->permanent_address);
        $permanent_city="";
        $exist2 = 0;
        if(!empty($permanent_address[0]->permanent_city) && isset($permanent_address[0]->permanent_city))
        {

            $permanent_city = $permanent_address[0]->permanent_city;
            $exist2 = 1;
        }
        $datas['near_members'] ="";
        if($exist2==1)
        {
            $datas['near_members'] = $this->AppModel->get_near_members($opposite_gender,$permanent_city,$soveran,$ignored_ids,$ignored_by_ids);
        }
         $datas['premium_members'] = $this->AppModel->get_random_members($opposite_gender,$soveran,$ignored_ids,$ignored_by_ids);
        }

        // print_r($datas['near_members']);exit;
        $all_customers_datas=$this->AppModel->get_all_memberdatas();
        $Online_members_datas=$this->AppModel->getMemberDatas('member','result','');
        $Online_male_datas=$this->AppModel->getMemberDatas('member','result',1);
        $Online_females_datas=$this->AppModel->getMemberDatas('member','result',2);
        $datas['all_member_count']=count($all_customers_datas);
        $datas['Online_members_datas']=count($Online_members_datas);
        $datas['Online_male_datas']=count($Online_male_datas);
        $datas['Online_females_datas']=count($Online_females_datas);
      $this->load->view ($this->middle = 'app/home', $datas, true);
      $this->getAppLayout();
    }


    function setLanguage($lang) {
        
        $this->session->set_userdata('language', $lang);
        // print_r('hhh');exit;
        // recache();
        // redirect($_SERVER['HTTP_REFERER']);
        redirect('app/login');
    }
    function faq() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='front/pages/faq',$datas,true);
        $this->getAppLayout(); 
    }
    function myInterests($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $total_interests = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interest'), true);
        $express_interest_members=array();
        if(!empty($total_interests)){    
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
    }

        $per_page=5;        
        
        // print_r($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/my_interests";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($express_interest_members);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        if (count($total_interests) != 0) {
            $express_interest_members = $this->db->from('member')->where_in('member_id', $total_interests_ids)->limit($per_page, $start)->get()->result();
            $array_total_interests = $total_interests;
        }
        else{
            $express_interest_members = NULL;
        }
        
        // $profile_viewed_details=$this->AppModel->get_interest_pagination_datas($total_interests_ids,$per_page,$start);

        // print_r($express_interest_members);exit;
        $datas['results']=$express_interest_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($express_interest_members);exit;
        $datas['profile_viewed_count']=count($total_interests);
        $datas['total_interests'] = $total_interests;
        $this->template['middle']=$this->load->view($this->middle='app/my_interests',$datas,true);
        $this->getAppLayout(); 
    }

    function oppositeInterests($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $total_interests = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'interested_by'), true);
        $express_interest_members=array();
        if(!empty($total_interests)){    
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
    }

        $per_page=5;        
        
        // print_r(count($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/my_interests";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($express_interest_members);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        if (count($total_interests) != 0) {
            $express_interest_members = $this->db->from('member')->where_in('member_id', $total_interests_ids)->limit($per_page, $start)->get()->result();
            $array_total_interests = $total_interests;
        }
        else{
            $express_interest_members = NULL;
        }
        
        // $profile_viewed_details=$this->AppModel->get_interest_pagination_datas($total_interests_ids,$per_page,$start);

        // print_r($express_interest_members);exit;
        $datas['results']=$express_interest_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($express_interest_members);exit;
        $datas['profile_viewed_count']=count($total_interests);
        $datas['total_interests'] = $total_interests;
        $this->template['middle']=$this->load->view($this->middle='app/opposite_interests',$datas,true);
        $this->getAppLayout(); 
    }



    function shortlist($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $total_shortlists = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'short_list'), true);
            
           $shortlist_member = array(); 
         if (!empty($total_shortlists)) {
            
        $shortlist_member = $this->AppModel->find_topping($total_shortlists);
        
         }
              // print_r($shortlist_member);exit;

                 // $members = $this->AppModel->getMemberData('member','result',array('member_id'=>$total_shortlists_ids));

        
        $per_page=5;        
        
        // print_r(count($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/shortlist";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($shortlist_member);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 
        
          $express_shortlist_members = ""; 
       if (!empty($total_shortlists)) { 
        $express_shortlist_members = $this->AppModel->find_topping_pagination($total_shortlists,$per_page,$start);
        
         }

        // print_r($express_shortlist_members);exit;

        
        
        // $profile_viewed_details=$this->AppModel->get_interest_pagination_datas($total_interests_ids,$per_page,$start);

        // print_r($express_interest_members);exit;
        $datas['results']=$express_shortlist_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($express_interest_members);exit;
        $this->template['middle']=$this->load->view($this->middle='app/shortlist',$datas,true);
        $this->getAppLayout();
         
    }

    function viewlist($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $gender = $member->gender;
        if($gender==1){
            $opposite_gender = 2;
        }else{
            $opposite_gender = 1;
        }


        $view_Profile_management = $this->db->get_where("view_profile_management", array("user_id" =>$this->session->userdata('thirumanam_applogged_data')['member_id']))->result();
        $total_views = array_column($view_Profile_management,"member_user_id");
        $total_ids = array_column($view_Profile_management,"id");

        $total_views_member = array();
        if (!empty($total_views)) {
            
        $total_views_member = $this->AppModel->find_topping($total_views,$opposite_gender);
              // print_r($total_views_member);exit;
        }
                 // $members = $this->AppModel->getMemberData('member','result',array('member_id'=>$total_shortlists_ids));

        
        $per_page=5;        
        
        // print_r($total_ids);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/viewlist";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($total_views_member);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 
        
          $viewed_members = ""; 
       if (!empty($total_views)) { 
        $viewed_members = $this->AppModel->find_topping_pagination($total_views,$per_page,$start,$opposite_gender);
        
         }

        // print_r(count($viewed_members));exit;

        
        
        // $profile_viewed_details=$this->AppModel->get_interest_pagination_datas($total_interests_ids,$per_page,$start);

        // print_r($express_interest_members);exit;
        $datas['results']=$viewed_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($express_interest_members);exit;
        $this->template['middle']=$this->load->view($this->middle='app/viewed_member',$datas,true);
        $this->getAppLayout();
         
    }


    function followedUsers($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $total_followed = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'followed'), true);
            
            $total_followed_member = array();
         if (!empty($total_followed)) {
            
        $total_followed_member = $this->AppModel->find_topping($total_followed);
        
         }
              // print_r($shortlist_member);exit;

                 // $members = $this->AppModel->getMemberData('member','result',array('member_id'=>$total_shortlists_ids));

        
        $per_page=5;        
        
        // print_r(count($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/followed_users";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($total_followed_member);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 
        $express_followed_members = "";
       if (!empty($total_followed)) {
            
        $express_followed_members = $this->AppModel->find_topping_pagination($total_followed,$per_page,$start);
        
         }

        // print_r($express_interest_members);exit;
        $datas['results']=$express_followed_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        $this->template['middle']=$this->load->view($this->middle='app/followed_users',$datas,true);
        $this->getAppLayout(); 
    }
    function ignoredList($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $total_ignored = json_decode(get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'ignored'), true);
            
           $total_ignored_member = array(); 
         if (!empty($total_ignored)) {
            
        $total_ignored_member = $this->AppModel->find_topping($total_ignored);
        
         }
              // print_r($total_ignored_member);exit;

                 // $members = $this->AppModel->getMemberData('member','result',array('member_id'=>$total_shortlists_ids));

        
        $per_page=5;        
        
        // print_r(count($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/ignored_list";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($total_ignored_member);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 
        $express_ignored_members = "";
       if (!empty($total_ignored)) {
            
        $express_ignored_members = $this->AppModel->find_topping_pagination($total_ignored,$per_page,$start);
        
         }

        // print_r($express_ignored_members);exit;
        $datas['results']=$express_ignored_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        $this->template['middle']=$this->load->view($this->middle='app/ignored_list',$datas,true);
        $this->getAppLayout(); 
    }
    function profileViewedDetails($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $gender = $member->gender;
        if($gender==1){
            $opposite_gender = 2;
        }else{
            $opposite_gender = 1;
        }
        $view_Profile_management = $this->db->get_where("view_profile_management", array("user_id" =>$this->session->userdata('thirumanam_applogged_data')['member_id']))->result();
        $total_views = array_column($view_Profile_management,"member_user_id");

        $total_views_member = array();
        if (!empty($total_views)) {
            
        $total_views_member = $this->AppModel->find_topping($total_views,$opposite_gender);
        
         }
              // print_r($shortlist_member);exit;

                 // $members = $this->AppModel->getMemberData('member','result',array('member_id'=>$total_shortlists_ids));

        
        $per_page=5;        
        
        // print_r(count($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/profile_viewed_details";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($total_views_member);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        $express_views_members = "";
       if (!empty($total_views)) {
            
        $express_views_members = $this->AppModel->find_topping_pagination($total_views,$per_page,$start,$opposite_gender);
        
         }

        // print_r($express_interest_members);exit;
        $datas['results']=$express_views_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        $this->template['middle']=$this->load->view($this->middle='app/profile_viewed_details',$datas,true);
        $this->getAppLayout(); 
    }

    function profileViewerDetails($page) {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $view_Profile_management = $this->db->get_where("view_profile_management", array("member_user_id" =>$this->session->userdata('thirumanam_applogged_data')['member_id']))->result();
        $total_views = array_column($view_Profile_management,"user_id");

        $total_views_member = array();
        if (!empty($total_views)) {
            
        $total_views_member = $this->AppModel->find_topping($total_views);
        
         }
              // print_r($shortlist_member);exit;

                 // $members = $this->AppModel->getMemberData('member','result',array('member_id'=>$total_shortlists_ids));

        
        $per_page=5;        
        
        // print_r(count($total_interests);exit;
        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/profile_viewer_details";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($total_views_member);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        $express_views_members = "";
       if (!empty($total_views)) {
            
        $express_views_members = $this->AppModel->find_topping_pagination($total_views,$per_page,$start);
        
         }

        // print_r($express_interest_members);exit;
        $datas['results']=$express_views_members;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        $this->template['middle']=$this->load->view($this->middle='app/profile_viewer_details',$datas,true);
        $this->getAppLayout(); 
    }
    function messaging() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/messaging',$datas,true);
        $this->getAppLayout(); 
    }
    function gallery() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/gallery',$datas,true);
        $this->getAppLayout(); 
    }
    function happyStory() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/happy_story',$datas,true);
        $this->getAppLayout(); 
    }
    function changePassword() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/change_password',$datas,true);
        $this->getAppLayout(); 
    }
    function notification() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/notification',$datas,true);
        $this->getAppLayout(); 
    }
    function message() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/message',$datas,true);
        $this->getAppLayout(); 
    }
    function activeSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_viewer_member']);exit;
         $datas['menu'] = $this->load->view('app/search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/search/active_search',$datas,true);
        $this->getAppLayout(); 
    }



    function appearanceSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/search/appearance_search',$datas,true);
        $this->getAppLayout(); 
    }
    function eduProSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/search/edupro_search',$datas,true);
        $this->getAppLayout(); 
    }
    function familySearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/search/family_search',$datas,true);
        $this->getAppLayout(); 
    }
    function astrologicSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/search/astrologic_search',$datas,true);
        $this->getAppLayout(); 
    }
    function activeSearchAll() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/search/active_search_all',$datas,true);
        $this->getAppLayout(); 
    }





    function matchSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_viewer_member']);exit;
         $datas['menu'] = $this->load->view('app/match_search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/match_search/match_search',$datas,true);
        $this->getAppLayout(); 
    }



    function matchappearanceSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/match_search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/match_search/matchappearance_search',$datas,true);
        $this->getAppLayout(); 
    }
    function matcheduProSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/match_search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/match_search/matchedupro_search',$datas,true);
        $this->getAppLayout(); 
    }
    function matchfamilySearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/match_search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/match_search/matchfamily_search',$datas,true);
        $this->getAppLayout(); 
    }
    function matchastrologicSearch() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/match_search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/match_search/matchastrologic_search',$datas,true);
        $this->getAppLayout(); 
    }
    function matchSearchAll() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['total_views_member'] = $this->totalViews();
        $datas['total_viewer_member'] = $this->totalViewers();
        // print_r($datas['total_views_member']);exit;
        $datas['menu'] = $this->load->view('app/match_search/search_bottom', $datas, true);
        $this->template['middle']=$this->load->view($this->middle='app/match_search/match_search_all',$datas,true);
        $this->getAppLayout(); 
    }






    function totalViews()
    {
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $gender = $member->gender;
        if($gender==1){
            $opposite_gender = 2;
        }else{
            $opposite_gender = 1;
        }


        $view_Profile_management = $this->db->get_where("view_profile_management", array("user_id" =>$this->session->userdata('thirumanam_applogged_data')['member_id']))->result();
        $total_views = array_column($view_Profile_management,"member_user_id");

        $total_views_member = array();
        if (!empty($total_views)) {
            
        $total_views_member = $this->AppModel->find_topping($total_views,$opposite_gender,6);
        
        }
        return $total_views_member;
    }

    function totalViewers()
    {
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $gender = $member->gender;
        if($gender==1){
            $opposite_gender = 2;
        }else{
            $opposite_gender = 1;
        }


        $view_Profile_management = $this->db->get_where("view_profile_management", array("member_user_id" =>$this->session->userdata('thirumanam_applogged_data')['member_id']))->result();
        $total_viewer = array_column($view_Profile_management,"user_id");

        $total_viewer_member = array();
        if (!empty($total_viewer)) {
            
        $total_viewer_member = $this->AppModel->find_topping($total_viewer,$opposite_gender,6);
        
        }
        return $total_viewer_member;
    }



    function matchedSearch() {

        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='app/matched_search',$datas,true);
        $this->getAppLayout(); 
    }
    function termsAndConditions() {

        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='front/pages/terms_and_conditions',$datas,true);
        $this->getAppLayout(); 
    }
    function checkPhoneOtp()
    {
        $id = $this->input->post('member_id');
        $otp = $this->input->post('otp');
        $check = $this->db->get_where('member',array('member_id'=>$id,"phoneOtp"=>$otp))->row_array();
        if($check)
        {
            $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
            echo 1;
        }
        else
        {
            echo 2;
        }
    }
    function privacyPolicy() {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        $datas['']="";
        $this->template['middle']=$this->load->view($this->middle='front/pages/privacy_policy',$datas,true);
        $this->getAppLayout(); 
    }
    public function profileView()
    {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        // print_r($this->session->userdata('thirumanam_applogged_data'));exit;
        $datas['']='';
        $this->template['middle']=$this->load->view($this->middle='app/profile_view',$datas,true);
        $this->getAppLayout();
    }
    public function editProfile()
    {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        // print_r($this->session->userdata('thirumanam_applogged_data'));exit;
        $datas['']='';
        $this->template['middle']=$this->load->view($this->middle='app/edit_profile',$datas,true);
        $this->getAppLayout();
    }
     public function updateAll()
    {
        
        $inputs=$this->input->get();
        // print_r($inputs['introduction']);exit;
        if($inputs['marital_status']=='Never Married'){

            $inputs['number_of_children'] = "";
            $inputs['Child_living_place'] = "";
        }
        if($inputs['Type_of_study']=='OTHERS')
        {
            $inputs['other_study'] = $inputs['other_study'];
        }else{

            $inputs['other_study'] = '';
        }
        if($inputs['Type_of_occupation']=='OTHERS')
        {
            $inputs['Other_Occupation_Details'] = $inputs['Other_Occupation_Details'];
        }else{

            $inputs['Other_Occupation_Details'] = '';
        }
        
       if($inputs['PAKSHA']=='OTHERS'){

            $inputs['Other_Paksha'] = $inputs['Other_Paksha'];
        }else{

            $inputs['Other_Paksha']='';
        }

        
        if($inputs['TYPE_OF_DOSHAM']=='OTHERS'){

            $inputs['Other_Dosham']=$inputs['Other_Dosham'];
        }else{

            $inputs['Other_Dosham']='';
        }
        if($inputs['DOSHAM']=='Yes'){

            $inputs['TYPE_OF_DOSHAM']=$inputs['TYPE_OF_DOSHAM'];
        }else{

            $inputs['TYPE_OF_DOSHAM']='';
            $inputs['Other_Dosham']='';
        } 
        if($inputs['Property_Description']=='OTHERS'){

            $inputs['Other_property_description'] = $inputs['Other_property_description'];
        }else{

            $inputs['Other_property_description']='';
        }

        if($inputs['father_vangusam']=='OTHERS'){

            $inputs['other_father_vang'] = $inputs['other_father_vang'];
        }else{

            $inputs['other_father_vang']='';
        }

        if($inputs['mother_vangusam']=='OTHERS'){

            $inputs['other_mother_vang'] = $inputs['other_mother_vang'];
        }else{

            $inputs['other_mother_vang']='';
        }


        if($inputs['partner_marital_status']=='Never Married'){

            $inputs['with_children_acceptables']='';
        }

        
        if($inputs['partner_TYPE_OF_DOSHAM']=='OTHERS'){

            $inputs['partner_Other_Dosham']=$inputs['partner_Other_Dosham'];
        }else{

            $inputs['partner_Other_Dosham']='';
        }
        if($inputs['partner_Expectation']=='OTHERS'){

            $inputs['partner_Other_Expectation'] = $inputs['partner_Other_Expectation'];
        }else{

            $inputs['partner_Other_Expectation']='';
        }

        if($inputs['partner_DOSHAM']=='Yes'){

            $inputs['partner_TYPE_OF_DOSHAM'] = $inputs['partner_TYPE_OF_DOSHAM'];
        }else{

            $inputs['partner_TYPE_OF_DOSHAM']='';
            $inputs['partner_Other_Dosham']='';
        }

        if($inputs['permanent_state']=='OTHERS'){

            $inputs['permanent_city_other'] = $inputs['permanent_city_other'];
            $inputs['permanent_city'] = '';
        }else{

            $inputs['permanent_city_other'] = '';
        }


        // print_r($inputs['member_id']);exit;
        $id = array(
            'member_id' => $inputs['member_id'],
        );
        
        

        $input = array(
            'introduction' => $inputs['introduction'],
            'first_name' => $inputs['first_name'],
            'email' => $inputs['email'],
            'date_of_birth' =>  strtotime($inputs['date_of_birth']),
            'height'=>$inputs['height'],
            'soveran_detail' => $inputs['Soveran_Details'],
            // 'mobile' => $inputs['mobile']
        );
        $basic_info[] = array(
            'marital_status' => $inputs['marital_status'],
            'number_of_children' => $inputs['number_of_children'],
            'Child_living_place' => $inputs['Child_living_place'],
        );
        $input['basic_info'] = json_encode($basic_info,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);

        $education_and_career[]= array(
            'Type_of_study'=>$inputs['Type_of_study'],
            'other_study'=>$inputs['other_study'],
            'STUDY_DETAILS'=>$inputs['STUDY_DETAILS'],
            'Type_of_occupation'=>$inputs['Type_of_occupation'],
            'Career_Profile'=>$inputs['Career_Profile'],
            'annual_income'=>$inputs['annual_income'],
            'Earnings'=>$inputs['Earnings'],
            'Other_Occupation_Details'=>$inputs['Other_Occupation_Details'],
        );
        $input['education_and_career'] = json_encode($education_and_career,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);

       
        $physical_attributes[]= array(
            'height'=>$inputs['height'],
            'weight'=>$inputs['weight'],
            'eye_color'=>$inputs['eye_color'],
            'hair_color'=>$inputs['hair_color'],
            'complexion'=>$inputs['complexion'],
            'blood_group'=>$inputs['blood_group'],
            'body_type'=>$inputs['body_type'],
            'body_art'=>$inputs['body_art'],
            'any_disability'=>$inputs['any_disability'],
        );
        $mydate = $inputs['date_of_birth'];
        // print_r(date('l', strtotime($mydate)));exit;

        $inputs['birthDay'] = date('l', strtotime($mydate));
        $input['physical_attributes'] = json_encode($physical_attributes,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);
        $astronomic_information[]= array(
            'date_of_birth'=>$inputs['date_of_birth'],
            'birthDay'=>$inputs['birthDay'],
            'time_of_birth'=>$inputs['time_of_birth'],
            'city_of_birth'=>$inputs['city_of_birth'],
            'PAKSHA'=>$inputs['PAKSHA'],
            'Other_Paksha'=>$inputs['Other_Paksha'],
            'star'=>$inputs['star'],
            'PADAM'=>$inputs['PADAM'],
            'LAKKNAM'=>$inputs['LAKKNAM'],
            'HOROSCOPE_MATCHING'=>$inputs['HOROSCOPE_MATCHING'],
            'TITHI'=>$inputs['TITHI'],
            'DOSHAM'=>$inputs['DOSHAM'],
            'TYPE_OF_DOSHAM'=>$inputs['TYPE_OF_DOSHAM'],
            'Other_Dosham'=>$inputs['Other_Dosham'],
            'DIRECTIONAL_BALANCE'=>$inputs['DIRECTIONAL_BALANCE'],
            'rashi'=>$inputs['rashi'],
            'Year'=>$inputs['Year'],
            'Month'=>$inputs['Month'],
            'Day'=>$inputs['Day'],
        );
        $input['astronomic_information'] = json_encode($astronomic_information,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);
        $permanent_address[]= array(
            'permanent_country'=>$inputs['permanent_country'],
            'permanent_state'=>$inputs['permanent_state'],
            'permanent_city'=>$inputs['permanent_city'],
            'permanent_city_other'=>$inputs['permanent_city_other'],
            'address'=>$inputs['address'],
            'permanent_postal_code'=>$inputs['permanent_postal_code'],
            // 'mobile'=>$inputs['mobile'],
            'alternate_number'=>$inputs['alternate_number'],
            'landline'=>$inputs['landline'],
        );
        $input['permanent_address'] = json_encode($permanent_address,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);
        
        $family_info[]= array(
            'Surname'=>$inputs['Surname'],
            'Soveran_Details'=>$inputs['Soveran_Details'],
            'father'=>$inputs['father'],
            'mother'=>$inputs['mother'],
            'father_vangusam'=>$inputs['father_vangusam'],
            'other_father_vang'=>$inputs['other_father_vang'],
            'mother_vangusam'=>$inputs['mother_vangusam'],
            'other_mother_vang'=>$inputs['other_mother_vang'],
            'family_type'=>$inputs['family_type'],
            'Number_of_brothers'=>$inputs['Number_of_brothers'],
            'Number_of_married_brothers'=>$inputs['Number_of_married_brothers'],
            'Number_of_Sisters'=>$inputs['Number_of_Sisters'],
            'Number_of_married_sisters'=>$inputs['Number_of_married_sisters'],
            'Property_Description'=>$inputs['Property_Description'],
            'Other_property_description'=>$inputs['Other_property_description'],
        );
        $input['family_info'] = json_encode($family_info,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);
        $partner_expectation[]= array(
            'partner_age'=>$inputs['partner_age'],
            'partner_height'=>$inputs['partner_height'],
            'partner_weight'=>$inputs['partner_weight'],
            'with_children_acceptables'=>$inputs['with_children_acceptables'],
            'partner_any_disability'=>$inputs['partner_any_disability'],
            'partner_marital_status'=>$inputs['partner_marital_status'],
            'partner_education'=>$inputs['partner_education'],
            'partner_profession'=>$inputs['partner_profession'],
            'partner_body_type'=>$inputs['partner_body_type'],
            'partner_DOSHAM'=>$inputs['partner_DOSHAM'],
            'partner_TYPE_OF_DOSHAM'=>$inputs['partner_TYPE_OF_DOSHAM'],
            'partner_Other_Dosham'=>$inputs['partner_Other_Dosham'],
            'partner_Expectation'=>$inputs['partner_Expectation'],
            'partner_Other_Expectation'=>$inputs['partner_Other_Expectation'],
        );
        $input['partner_expectation'] = json_encode($partner_expectation,JSON_UNESCAPED_UNICODE);
        // $this->AppModel->updateMemberDatas('member',$id,$input);
        $chart[]= array(

            
            'f010'=>$inputs['f010'],
            'f011'=>$inputs['f011'],
            'f012'=>$inputs['f012'],
            'f013'=>$inputs['f013'],
            'f014'=>$inputs['f014'],
            'f015'=>$inputs['f015'],
            'f020'=>$inputs['f020'],
            'f021'=>$inputs['f021'],
            'f022'=>$inputs['f022'],
            'f023'=>$inputs['f023'],

            'f024'=>$inputs['f024'],
            'f025'=>$inputs['f025'],
            'f030'=>$inputs['f030'],
            'f031'=>$inputs['f031'],
            'f032'=>$inputs['f032'],
            'f033'=>$inputs['f033'],
            'f034'=>$inputs['f034'],
            'f035'=>$inputs['f035'],
            'f040'=>$inputs['f040'],
            'f041'=>$inputs['f041'],

            'f042'=>$inputs['f042'],
            'f043'=>$inputs['f043'],
            'f044'=>$inputs['f044'],
            'f045'=>$inputs['f045'],
            'f110'=>$inputs['f110'],
            'f111'=>$inputs['f111'],
            'f112'=>$inputs['f112'],
            'f113'=>$inputs['f113'],
            'f114'=>$inputs['f114'],
            'f115'=>$inputs['f115'],

            'f210'=>$inputs['f210'],
            'f211'=>$inputs['f211'],
            'f212'=>$inputs['f212'],
            'f213'=>$inputs['f213'],
            'f214'=>$inputs['f214'],
            'f215'=>$inputs['f215'],

            'f310'=>$inputs['f310'],
            'f311'=>$inputs['f311'],
            'f312'=>$inputs['f312'],
            'f313'=>$inputs['f313'],
            'f314'=>$inputs['f314'],
            'f315'=>$inputs['f315'],

            'f320'=>$inputs['f320'],
            'f321'=>$inputs['f321'],
            'f322'=>$inputs['f322'],
            'f323'=>$inputs['f323'],
            'f324'=>$inputs['f324'],
            'f325'=>$inputs['f325'],

            'f410'=>$inputs['f410'],
            'f411'=>$inputs['f411'],
            'f412'=>$inputs['f412'],
            'f413'=>$inputs['f413'],
            'f414'=>$inputs['f414'],
            'f415'=>$inputs['f415'],

            'f420'=>$inputs['f420'],
            'f421'=>$inputs['f421'],
            'f422'=>$inputs['f422'],
            'f423'=>$inputs['f423'],
            'f424'=>$inputs['f424'],
            'f425'=>$inputs['f425'],

            'f430'=>$inputs['f430'],
            'f431'=>$inputs['f431'],
            'f432'=>$inputs['f432'],
            'f433'=>$inputs['f433'],
            'f434'=>$inputs['f434'],
            'f435'=>$inputs['f435'],

            'f440'=>$inputs['f440'],
            'f441'=>$inputs['f441'],
            'f442'=>$inputs['f442'],
            'f443'=>$inputs['f443'],
            'f444'=>$inputs['f444'],
            'f445'=>$inputs['f445'],

            'f510'=>$inputs['f510'],
            'f511'=>$inputs['f511'],
            'f512'=>$inputs['f512'],
            'f513'=>$inputs['f513'],
            'f514'=>$inputs['f514'],
            'f515'=>$inputs['f515'],

            'f520'=>$inputs['f520'],
            'f521'=>$inputs['f521'],
            'f522'=>$inputs['f522'],
            'f523'=>$inputs['f523'],
            'f524'=>$inputs['f524'],
            'f525'=>$inputs['f525'],

            'f530'=>$inputs['f530'],
            'f531'=>$inputs['f531'],
            'f532'=>$inputs['f532'],
            'f533'=>$inputs['f533'],
            'f534'=>$inputs['f534'],
            'f535'=>$inputs['f535'],

            'f540'=>$inputs['f540'],
            'f541'=>$inputs['f541'],
            'f542'=>$inputs['f542'],
            'f543'=>$inputs['f543'],
            'f544'=>$inputs['f544'],
            'f545'=>$inputs['f545'],

            'f610'=>$inputs['f610'],
            'f611'=>$inputs['f611'],
            'f612'=>$inputs['f612'],
            'f613'=>$inputs['f613'],
            'f614'=>$inputs['f614'],
            'f615'=>$inputs['f615'],

            'f710'=>$inputs['f710'],
            'f711'=>$inputs['f711'],
            'f712'=>$inputs['f712'],
            'f713'=>$inputs['f713'],
            'f714'=>$inputs['f714'],
            'f715'=>$inputs['f715'],

            'f810'=>$inputs['f810'],
            'f811'=>$inputs['f811'],
            'f812'=>$inputs['f812'],
            'f813'=>$inputs['f813'],
            'f814'=>$inputs['f814'],
            'f815'=>$inputs['f815'],

            'f820'=>$inputs['f820'],
            'f821'=>$inputs['f821'],
            'f822'=>$inputs['f822'],
            'f823'=>$inputs['f823'],
            'f824'=>$inputs['f824'],
            'f825'=>$inputs['f825'],

            'f910'=>$inputs['f910'],
            'f911'=>$inputs['f911'],
            'f912'=>$inputs['f912'],
            'f913'=>$inputs['f913'],
            'f914'=>$inputs['f914'],
            'f915'=>$inputs['f915'],

            'f920'=>$inputs['f920'],
            'f921'=>$inputs['f921'],
            'f922'=>$inputs['f922'],
            'f923'=>$inputs['f923'],
            'f924'=>$inputs['f924'],
            'f925'=>$inputs['f925'],

            'f930'=>$inputs['f930'],
            'f931'=>$inputs['f931'],
            'f932'=>$inputs['f932'],
            'f933'=>$inputs['f933'],
            'f934'=>$inputs['f934'],
            'f935'=>$inputs['f935'],

            'f940'=>$inputs['f940'],
            'f941'=>$inputs['f941'],
            'f942'=>$inputs['f942'],
            'f943'=>$inputs['f943'],
            'f944'=>$inputs['f944'],
            'f945'=>$inputs['f945'],
        );
        $input['chart'] = json_encode($chart,JSON_UNESCAPED_UNICODE);

        // $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');

        // $input['updateProfileDoneStatus'] = 1;


        // print_r($data);exit;
        $this->AppModel->updateMemberDatas('member',$id,$input);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Updated All',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity);  
        echo json_encode($inputs);
    }
    public function updateIntroduction()
    {
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];

        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile introduction Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        
        $inputs=$this->input->post();
        $id = array(
            'member_id' => $inputs['member_id']
        );
        $data = array(
            'introduction' => $inputs['introduction']
        );
        // $data['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$data);
        
        echo json_encode($inputs);
        
    }
    public function updateBasicInfo()
    {
        
        $inputs=$this->input->post();
        
        if($inputs['marital_status']=='Never Married'){

            $inputs['number_of_children']='';
            $inputs['Child_living_place']='';
        }
        $id = array(
            'member_id' => $inputs['member_id']
        );
        
        
        $data = array(
            'first_name' => $inputs['first_name'],
            'email' => $inputs['email'],
            
        );
        $basic_info[] = array(
            'marital_status' => $inputs['marital_status'],
            'number_of_children' => $inputs['number_of_children'],
            'Child_living_place' => $inputs['Child_living_place'],
        );
        $data['basic_info'] = json_encode($basic_info,JSON_UNESCAPED_UNICODE);
        // $data['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$data);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Basic info Updated ',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }
    public function updateEducation()
    {
        $inputs=$this->input->post();
        
        if($inputs['Type_of_study']=='OTHERS'){

            $other_study = $inputs['other_study'];
        }else{

            $other_study='';
        }

        if($inputs['Type_of_occupation']=='OTHERS'){

            $Other_Occupation_Details=$inputs['Other_Occupation_Details'];
        }else{

            $Other_Occupation_Details='';
        }
        // print_r($inputs);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        
        
        $education_and_career[]= array(
            'Type_of_study'=>$inputs['Type_of_study'],
            'other_study'=>$other_study,
            'STUDY_DETAILS'=>$inputs['STUDY_DETAILS'],
            'Type_of_occupation'=>$inputs['Type_of_occupation'],
            'Career_Profile'=>$inputs['Career_Profile'],
            'annual_income'=>$inputs['annual_income'],
            'Earnings'=>$inputs['Earnings'],
            'Other_Occupation_Details'=>$Other_Occupation_Details,
        );
        $data['education_and_career'] = json_encode($education_and_career,JSON_UNESCAPED_UNICODE);
        // $data['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$data);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Education Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }
    public function updatePhysical()
    {
        $inputs=$this->input->post();
        // print_r($inputs);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        
        $data = array(
            'height'=>$inputs['height']
        );
        $physical_attributes[]= array(
            'height'=>$inputs['height'],
            'weight'=>$inputs['weight'],
            'eye_color'=>$inputs['eye_color'],
            'hair_color'=>$inputs['hair_color'],
            'complexion'=>$inputs['complexion'],
            'blood_group'=>$inputs['blood_group'],
            'body_type'=>$inputs['body_type'],
            'body_art'=>$inputs['body_art'],
            'any_disability'=>$inputs['any_disability'],
        );
        $data['physical_attributes'] = json_encode($physical_attributes,JSON_UNESCAPED_UNICODE);
        // $data['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$data);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Physical attributes Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }
    public function updateAstronomic()
    {

        $inputs=$this->input->post();
        
        if($inputs['PAKSHA']=='OTHERS'){

            $inputs['Other_Paksha'] = $inputs['Other_Paksha'];
        }else{

            $inputs['Other_Paksha']='';
        }

        
        if($inputs['TYPE_OF_DOSHAM']=='OTHERS'){

            $inputs['Other_Dosham']=$inputs['Other_Dosham'];
        }else{

            $inputs['Other_Dosham']='';
        }
        if($inputs['DOSHAM']=='Yes'){

            $inputs['TYPE_OF_DOSHAM']=$inputs['TYPE_OF_DOSHAM'];
        }else{

            $inputs['TYPE_OF_DOSHAM']='';
            $inputs['Other_Dosham']='';
        }
       // print_r($Other_Dosham);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        $mydate = $inputs['date_of_birth'];
        // print_r(date('l', strtotime($mydate)));exit;

        $inputs['birthDay'] = date('l', strtotime($mydate));
       // print_r($inputs);exit;
       $astronomic_information[]= array(
            'date_of_birth'=>$inputs['date_of_birth'],
            'birthDay'=>$inputs['birthDay'],
            'time_of_birth'=>$inputs['time_of_birth'],
            'city_of_birth'=>$inputs['city_of_birth'],
            'PAKSHA'=>$inputs['PAKSHA'],
            'Other_Paksha'=>$inputs['Other_Paksha'],
            'star'=>$inputs['star'],
            'PADAM'=>$inputs['PADAM'],
            'LAKKNAM'=>$inputs['LAKKNAM'],
            'HOROSCOPE_MATCHING'=>$inputs['HOROSCOPE_MATCHING'],
            'TITHI'=>$inputs['TITHI'],
            'DOSHAM'=>$inputs['DOSHAM'],
            'TYPE_OF_DOSHAM'=>$inputs['TYPE_OF_DOSHAM'],
            'Other_Dosham'=>$inputs['Other_Dosham'],
            'DIRECTIONAL_BALANCE'=>$inputs['DIRECTIONAL_BALANCE'],
            'rashi'=>$inputs['rashi'],
            'Year'=>$inputs['Year'],
            'Month'=>$inputs['Month'],
            'Day'=>$inputs['Day'],
        );
        $input['astronomic_information'] = json_encode($astronomic_information,JSON_UNESCAPED_UNICODE);
        // $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$input);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Astronomic information Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }
    public function updatePermanent()
    {
        $inputs=$this->input->post();
        // print_r($inputs);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        
       if($inputs['permanent_state']=='OTHERS'){

            $inputs['permanent_city_other'] = $inputs['permanent_city_other'];
            $inputs['permanent_city'] = '';
        }else{

            $inputs['permanent_city_other'] = '';
        }
       $permanent_address[]= array(
            'permanent_country'=>$inputs['permanent_country'],
            'permanent_state'=>$inputs['permanent_state'],
            'permanent_city'=>$inputs['permanent_city'],
            'permanent_city_other'=>$inputs['permanent_city_other'],
            'address'=>$inputs['address'],
            'permanent_postal_code'=>$inputs['permanent_postal_code'],
            // 'mobile'=>$inputs['mobile'],
            'alternate_number'=>$inputs['alternate_number'],
            'landline'=>$inputs['landline'],
        );
        $input['permanent_address'] = json_encode($permanent_address,JSON_UNESCAPED_UNICODE);
        // $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$input);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Permanent address Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }
    public function updateFamilyinformation()
    {
        $inputs=$this->input->post();
        // print_r($inputs);exit;
        if($inputs['Property_Description']=='OTHERS'){

            $inputs['Other_property_description'] = $inputs['Other_property_description'];
        }else{

            $inputs['Other_property_description']='';
        }

        if($inputs['father_vangusam']=='OTHERS'){

            $inputs['other_father_vang'] = $inputs['other_father_vang'];
        }else{

            $inputs['other_father_vang']='';
        }

        if($inputs['mother_vangusam']=='OTHERS'){

            $inputs['other_mother_vang'] = $inputs['other_mother_vang'];
        }else{

            $inputs['other_mother_vang']='';
        }

        // print_r($inputs);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        
        $input = array(
            'soveran_detail' => $inputs['Soveran_Details']
        );
       
        $family_info[]= array(
            'Surname'=>$inputs['Surname'],
            'Soveran_Details'=>$inputs['Soveran_Details'],
            'father'=>$inputs['father'],
            'mother'=>$inputs['mother'],
            'father_vangusam'=>$inputs['father_vangusam'],
            'other_father_vang'=>$inputs['other_father_vang'],
            'mother_vangusam'=>$inputs['mother_vangusam'],
            'other_mother_vang'=>$inputs['other_mother_vang'],
            'family_type'=>$inputs['family_type'],
            'Number_of_brothers'=>$inputs['Number_of_brothers'],
            'Number_of_married_brothers'=>$inputs['Number_of_married_brothers'],
            'Number_of_Sisters'=>$inputs['Number_of_Sisters'],
            'Number_of_married_sisters'=>$inputs['Number_of_married_sisters'],
            'Property_Description'=>$inputs['Property_Description'],
            'Other_property_description'=>$inputs['Other_property_description'],
        );
         // print_r($inputs);exit;
        $input['family_info'] = json_encode($family_info,JSON_UNESCAPED_UNICODE);
        // $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$input);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Family information Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }
    public function updatePartnerExpectation()
    {
        $inputs=$this->input->post();
        
        if($inputs['partner_marital_status']=='Never Married'){

            $inputs['with_children_acceptables']='';
        }

        
        if($inputs['partner_TYPE_OF_DOSHAM']=='OTHERS'){

            $inputs['partner_Other_Dosham']=$inputs['partner_Other_Dosham'];
        }else{

            $inputs['partner_Other_Dosham']='';
        }
        if($inputs['partner_Expectation']=='OTHERS'){

            $inputs['partner_Other_Expectation'] = $inputs['partner_Other_Expectation'];
        }else{

            $inputs['partner_Other_Expectation']='';
        }

        if($inputs['partner_DOSHAM']=='Yes'){

            $inputs['partner_TYPE_OF_DOSHAM'] = $inputs['partner_TYPE_OF_DOSHAM'];
        }else{

            $inputs['partner_TYPE_OF_DOSHAM']='';
            $inputs['partner_Other_Dosham']='';
        }
        // print_r($inputs);exit;
        // print_r($partner_Other_Dosham);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        $partner_expectation[]= array(
            'partner_age'=>$inputs['partner_age'],
            'partner_height'=>$inputs['partner_height'],
            'partner_weight'=>$inputs['partner_weight'],
            'partner_any_disability'=>$inputs['partner_any_disability'],
            'partner_marital_status'=>$inputs['partner_marital_status'],
            'with_children_acceptables'=>$inputs['with_children_acceptables'],
            'partner_education'=>$inputs['partner_education'],
            'partner_profession'=>$inputs['partner_profession'],
            'partner_body_type'=>$inputs['partner_body_type'],
            'partner_DOSHAM'=>$inputs['partner_DOSHAM'],
            'partner_TYPE_OF_DOSHAM'=>$inputs['partner_TYPE_OF_DOSHAM'],
            'partner_Other_Dosham'=>$inputs['partner_Other_Dosham'],
            'partner_Expectation'=>$inputs['partner_Expectation'],
            'partner_Other_Expectation'=>$inputs['partner_Other_Expectation'],
        );
        $input['partner_expectation'] = json_encode($partner_expectation,JSON_UNESCAPED_UNICODE);
        // $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$input);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Partner expectation Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity); 
        echo json_encode($inputs);
    }

    public function updateChart()
    {
        $inputs=$this->input->post();
        // print_r($inputs['member_id']);exit;
        $id = array(
            'member_id' => $inputs['member_id']
        );
        $chart[]= array(

            
            'f010'=>$inputs['f010'],
            'f011'=>$inputs['f011'],
            'f012'=>$inputs['f012'],
            'f013'=>$inputs['f013'],
            'f014'=>$inputs['f014'],
            'f015'=>$inputs['f015'],
            'f020'=>$inputs['f020'],
            'f021'=>$inputs['f021'],
            'f022'=>$inputs['f022'],
            'f023'=>$inputs['f023'],

            'f024'=>$inputs['f024'],
            'f025'=>$inputs['f025'],
            'f030'=>$inputs['f030'],
            'f031'=>$inputs['f031'],
            'f032'=>$inputs['f032'],
            'f033'=>$inputs['f033'],
            'f034'=>$inputs['f034'],
            'f035'=>$inputs['f035'],
            'f040'=>$inputs['f040'],
            'f041'=>$inputs['f041'],

            'f042'=>$inputs['f042'],
            'f043'=>$inputs['f043'],
            'f044'=>$inputs['f044'],
            'f045'=>$inputs['f045'],
            'f110'=>$inputs['f110'],
            'f111'=>$inputs['f111'],
            'f112'=>$inputs['f112'],
            'f113'=>$inputs['f113'],
            'f114'=>$inputs['f114'],
            'f115'=>$inputs['f115'],

            'f210'=>$inputs['f210'],
            'f211'=>$inputs['f211'],
            'f212'=>$inputs['f212'],
            'f213'=>$inputs['f213'],
            'f214'=>$inputs['f214'],
            'f215'=>$inputs['f215'],

            'f310'=>$inputs['f310'],
            'f311'=>$inputs['f311'],
            'f312'=>$inputs['f312'],
            'f313'=>$inputs['f313'],
            'f314'=>$inputs['f314'],
            'f315'=>$inputs['f315'],

            'f320'=>$inputs['f320'],
            'f321'=>$inputs['f321'],
            'f322'=>$inputs['f322'],
            'f323'=>$inputs['f323'],
            'f324'=>$inputs['f324'],
            'f325'=>$inputs['f325'],

            'f410'=>$inputs['f410'],
            'f411'=>$inputs['f411'],
            'f412'=>$inputs['f412'],
            'f413'=>$inputs['f413'],
            'f414'=>$inputs['f414'],
            'f415'=>$inputs['f415'],

            'f420'=>$inputs['f420'],
            'f421'=>$inputs['f421'],
            'f422'=>$inputs['f422'],
            'f423'=>$inputs['f423'],
            'f424'=>$inputs['f424'],
            'f425'=>$inputs['f425'],

            'f430'=>$inputs['f430'],
            'f431'=>$inputs['f431'],
            'f432'=>$inputs['f432'],
            'f433'=>$inputs['f433'],
            'f434'=>$inputs['f434'],
            'f435'=>$inputs['f435'],

            'f440'=>$inputs['f440'],
            'f441'=>$inputs['f441'],
            'f442'=>$inputs['f442'],
            'f443'=>$inputs['f443'],
            'f444'=>$inputs['f444'],
            'f445'=>$inputs['f445'],

            'f510'=>$inputs['f510'],
            'f511'=>$inputs['f511'],
            'f512'=>$inputs['f512'],
            'f513'=>$inputs['f513'],
            'f514'=>$inputs['f514'],
            'f515'=>$inputs['f515'],

            'f520'=>$inputs['f520'],
            'f521'=>$inputs['f521'],
            'f522'=>$inputs['f522'],
            'f523'=>$inputs['f523'],
            'f524'=>$inputs['f524'],
            'f525'=>$inputs['f525'],

            'f530'=>$inputs['f530'],
            'f531'=>$inputs['f531'],
            'f532'=>$inputs['f532'],
            'f533'=>$inputs['f533'],
            'f534'=>$inputs['f534'],
            'f535'=>$inputs['f535'],

            'f540'=>$inputs['f540'],
            'f541'=>$inputs['f541'],
            'f542'=>$inputs['f542'],
            'f543'=>$inputs['f543'],
            'f544'=>$inputs['f544'],
            'f545'=>$inputs['f545'],

            'f610'=>$inputs['f610'],
            'f611'=>$inputs['f611'],
            'f612'=>$inputs['f612'],
            'f613'=>$inputs['f613'],
            'f614'=>$inputs['f614'],
            'f615'=>$inputs['f615'],

            'f710'=>$inputs['f710'],
            'f711'=>$inputs['f711'],
            'f712'=>$inputs['f712'],
            'f713'=>$inputs['f713'],
            'f714'=>$inputs['f714'],
            'f715'=>$inputs['f715'],

            'f810'=>$inputs['f810'],
            'f811'=>$inputs['f811'],
            'f812'=>$inputs['f812'],
            'f813'=>$inputs['f813'],
            'f814'=>$inputs['f814'],
            'f815'=>$inputs['f815'],

            'f820'=>$inputs['f820'],
            'f821'=>$inputs['f821'],
            'f822'=>$inputs['f822'],
            'f823'=>$inputs['f823'],
            'f824'=>$inputs['f824'],
            'f825'=>$inputs['f825'],

            'f910'=>$inputs['f910'],
            'f911'=>$inputs['f911'],
            'f912'=>$inputs['f912'],
            'f913'=>$inputs['f913'],
            'f914'=>$inputs['f914'],
            'f915'=>$inputs['f915'],

            'f920'=>$inputs['f920'],
            'f921'=>$inputs['f921'],
            'f922'=>$inputs['f922'],
            'f923'=>$inputs['f923'],
            'f924'=>$inputs['f924'],
            'f925'=>$inputs['f925'],

            'f930'=>$inputs['f930'],
            'f931'=>$inputs['f931'],
            'f932'=>$inputs['f932'],
            'f933'=>$inputs['f933'],
            'f934'=>$inputs['f934'],
            'f935'=>$inputs['f935'],

            'f940'=>$inputs['f940'],
            'f941'=>$inputs['f941'],
            'f942'=>$inputs['f942'],
            'f943'=>$inputs['f943'],
            'f944'=>$inputs['f944'],
            'f945'=>$inputs['f945'],
        );
        $input['chart'] = json_encode($chart,JSON_UNESCAPED_UNICODE);
        // print_r($input);exit();
        // $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');
        $this->AppModel->updateMemberDatas('member',$id,$input);
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'Member Profile Chart Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity);
            echo json_encode($inputs);
        
        
    }


    public function updateGalery()
    {

        $inputs = $this->input->post();
        
        $id = array(
            'member_id' => $inputs['member_id']
        );
        $member_id = $inputs['member_id'];
        $photo_gallery_amount = $this->db->get_where('member', array('member_id' => $member_id))->row()->photo_gallery;
        if ($photo_gallery_amount > 0) {

            $get_gallery = $this->db->get_where('member', array('member_id' => $member_id))->row()->gallery;
            $gallery_data = json_decode($get_gallery, true);
            //print_r($gallery_data);
            $max_index = 0;
            $new_index = 0;
            if (!empty($gallery_data)) {
                foreach ($gallery_data as $gallery_val) {
                    if($gallery_val['index'] > $max_index) {
                    $max_index = $gallery_val['index'];
                }
            }
            $new_index = $max_index + 1;
        }

        if ($_FILES['image']['name'] !== '') {

        $path = $_FILES['image']['name'];
        $ext = '.' . pathinfo($path, PATHINFO_EXTENSION);
    if ($ext==".jpg" || $ext==".JPG" || $ext==".jpeg" || $ext==".JPEG" || $ext==".png" || $ext==".PNG") {

        move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/profile_image/gallery_'.$member_id.'_'.$new_index.$ext);

        $file_name = 'gallery_'.$member_id.'_'.$new_index.$ext;

        if (!empty($gallery_data)) {
          $gallery_data[] = array( 'index'    =>  $new_index,
                                  'title'     =>  $this->input->post('title'),
                                  'image'     =>  $file_name
                          );
          // print_r($gallery_data);
          $data['gallery'] = json_encode($gallery_data);
          // echo 'in if';
                                    } else {
          $gallery[] = array( 'index'     =>  $new_index,
                          'title'     =>  $this->input->post('title'),
                          'image'     =>  $file_name
                  );
          $data['gallery'] = json_encode($gallery);
          // print_r($data['gallery']);
          // echo '<br>in else';
        }
        $this->db->where('member_id', $member_id);
        $result = $this->db->update('member', $data);
        $this->session->set_flashdata('login_msg',getappAlert('success','Saved Succefully'));
        $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity=array(

            'member_id'=>$single->member_id,
            'activity' =>'gallery Updated',
            'location'=>$decode['city'],
            'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity);
            // print_r($result);exit;
            
        }else {
            $this->session->set_flashdata('login_msg',getappAlert('danger','Failed'));
        }
    }

    if ($result) {
        // print_r($result);exit;
        $photo_gallery = $photo_gallery_amount - 1;
        $data1 = array(
            'photo_gallery' => $photo_gallery
        );
        $this->db->where('member_id', $member_id);
        $this->db->update('member', $data1);
        recache();
        $this->session->set_flashdata('login_msg',getappAlert('success','Saved Succefully'));
    }
    else {
        $this->session->set_flashdata('login_msg',getappAlert('danger','Failed'));
    }
    $this->session->set_flashdata('login_msg',getappAlert('success','Saved Succefully'));
    redirect(base_url().'app/gallery');


}else {
        redirect(base_url().'app/gallery');
    }


        // $id = array(
        //     'member_id' => $inputs['member_id']
        // );
        // if($_FILES["profile_image"]['name']!='')
        // {   
        //     $new_name = time().$_FILES["profile_image"]['name'];

        //     $config['upload_path'] = FCPATH ."uploads/gallery_image/gallery/";
        //     $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //     $config['file_name'] = $new_name;
        //     $this->load->library('upload', $config);
        //     $this->upload->initialize($config);
        //     if (!$this->upload->do_upload('profile_image'))
        //     {}
        //     else
        //     {
        //       $data = $this->upload->data();
        //     }
        // }
        // else
        // {
        //     $new_name='';
        // }
        // $profile_image[]=array(
        //     'profile_image' => $new_name,
        //     'title'         => $inputs['title']
        // );
        // $datas['profile_image'] = json_encode($profile_image);
        // $this->AppModel->updateMemberDatas('member',$id,$datas);
    }
    public function deleteGalleryImage($id,$index)
    {
        $member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
        $gallery_json = get_type_name_by_id('member', $id, 'gallery');
        
        // print_r($gallery_json);exit;
            $gallery_arrya = json_decode($gallery_json, true);
            if (empty($gallery_arrya)) {
                $gallery_arrya = array();
            }
            $new_array = array();
            $image_name = "";
            foreach ($gallery_arrya as $value) {
                if ($value['index'] != $index) {
                    array_push($new_array, $value);
                }
                if ($value['index'] == $index) {
                    $image_name = $value['image'];
                }
            }
            $gallery_arrya = $new_array;
            $this->db->where('member_id', $id);
            $this->db->update('member', array('gallery' => json_encode($gallery_arrya)));
            $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
            $ip = get_IP_address();
            $loc = file_get_contents("http://ip-api.com/json/$ip");
            $decode = json_decode($loc, true);
            $activity=array(

                'member_id'=>$single->member_id,
                'activity' =>'gallery gallery Updated',
                'location'=>$decode['city'],
                'server' => json_encode($_SERVER)

            );
            $this->AppModel->add_info('user_activity',$activity);
            recache();
            unlink('uploads/profile_image/'.$image_name);
            redirect('app/gallery');

    }
  public function contact()
  {  

    if($this->member_permission() == FALSE){

            redirect('app/login');
        }   
        $datas[''] = "";
    if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') {
      $this->load->library('recaptcha');
            $datas['recaptcha_html'] = $this->recaptcha->render();
            }
    $this->template['middle']=$this->load->view($this->middle='app/contact',$datas,true);
    $this->getAppLayout();
  }
  public function contactUs()
  {
    
    

        $captcha_response = trim($this->input->post('g-recaptcha-response'));
        // print_r($captcha_response);exit;
        if($captcha_response != '')
        {
            $keySecret = '6Le1sDUdAAAAAOfM3ap0KgAZam_5U6Jsb3a7zMc1';

            $check = array(
                'secret'        =>  $keySecret,
                'response'      =>  $this->input->post('g-recaptcha-response')
            );

            $startProcess = curl_init();

            curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

            curl_setopt($startProcess, CURLOPT_POST, true);

            curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

            curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

            curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

            $receiveData = curl_exec($startProcess);

            $finalResponse = json_decode($receiveData, true);
             // print_r($finalResponse);exit;
            if($finalResponse['success'])
            {
                $safe = 'yes';
                $char = '';
                foreach ($_POST as $row) {
                    if (preg_match('/[\'^":()}{#~><>|=+¬]/', $row, $match)) {
                        $safe = 'no';
                        $char = $match[0];
                    }
                }
                    // print_r($safe);exit;
                    if ($safe == 'yes') {
                        if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') {
                            $captcha_answer = $this->input->post('g-recaptcha-response');
                            $response = $this->recaptcha->verifyResponse($captcha_answer);
                            if ($response['success']) {
                                $data['name'] = $this->input->post('name', true);
                                $data['subject'] = $this->input->post('subject');
                                $data['email'] = $this->input->post('email');
                                $data['message'] = $this->security->xss_clean(($this->input->post('message')));
                                $data['view'] = 'no';
                                $data['timestamp'] = time();
                                $this->db->insert('contact_message', $data);
                                $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
                                $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
                                $ip = get_IP_address();
                                $loc = file_get_contents("http://ip-api.com/json/$ip");
                                $decode = json_decode($loc, true);
                                $activity=array(

                                    'member_id'=>$single->member_id,
                                    'activity' =>'Contact message send',
                                    'location'=>$decode['city'],'server' => json_encode($_SERVER)

                                );
                                $this->AppModel->add_info('user_activity',$activity);
                                $this->session->set_flashdata('login_msg',getappAlert('success','Send Successfully'));
                          redirect('app/contact');
                            } else {
                          redirect('app/contact');
                            }
                        } else {
                            $data['name'] = $this->input->post('name', true);
                            $data['subject'] = $this->input->post('subject');
                            $data['email'] = $this->input->post('email');
                            $data['message'] = $this->security->xss_clean(($this->input->post('message')));
                            $data['view'] = 'no';
                            $data['timestamp'] = time();
                            $this->db->insert('contact_message', $data);
                            $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
                            $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
                            $ip = get_IP_address();
                            $loc = file_get_contents("http://ip-api.com/json/$ip");
                            $decode = json_decode($loc, true);
                            $activity=array(

                                'member_id'=>$single->member_id,
                                'activity' =>'Contact message send',
                                'location'=>$decode['city'],'server' => json_encode($_SERVER)

                            );
                            $this->AppModel->add_info('user_activity',$activity);
                            $this->session->set_flashdata('login_msg',getappAlert('success','Send Successfully'));
                        redirect('app/contact');

                        }
                    } else {
                        echo 'Disallowed charecter : " ' . $char . ' " in the POST';
                    }
                
            }
            else
            {
                $this->session->set_flashdata('login_msg',getappAlert('danger','failed'));
                redirect('app/contact');
            }
        }else{

            $this->session->set_flashdata('login_msg',getappAlert('danger','Capcha Response Error'));
                redirect('app/contact');
        }
  }

  public function memories()
  {
    $max_story_num = $this->db->get_where('frontend_settings', array('type' => 'max_story_num'))->row()->value;
    $datas['memories'] = $this->db->get_where('memories', array('active_status' => 1,'delete_status' => 0), $max_story_num)->result();
    // print_r($datas);exit;
    $this->template['middle']=$this->load->view($this->middle='app/memories',$datas,true);
    $this->getAppLayout();
  }

    // public function matchedMembers()
    // {
    //     $max_story_num = $this->db->get_where('frontend_settings', array('type' => 'max_story_num'))->row()->value;
    //     $datas['memories'] = $this->db->get_where('memories', array('active_status' => 1,'delete_status' => 0), $max_story_num)->result();
    //     $datas['home_search'] = "true";
    //     // print_r($datas);exit;
    //     $this->template['middle']=$this->load->view($this->middle='front/pages/matched_members',$datas,true);
    //     $this->getAppLayout();
    // }

     public function matchedMembers($page)
    {
        $member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        if($member->gender==1){
            $opposite_gender=2;
        }else{
            $opposite_gender=1;
        }

        $memberplan = $this->AppModel->getMemberPlan($member->member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }

        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }

        $expectation = json_decode($member->partner_expectation);
            $exist = 0;
            $partner_age=$partner_height=$partner_weight=$with_children_acceptables=$partner_any_disability=$partner_marital_status=$partner_education=$partner_body_type=$partner_DOSHAM=$partner_TYPE_OF_DOSHAM=$partner_Other_Dosham=$partner_Expectation=$partner_Other_Expectation="";
            if(!empty($expectation[0]->partner_age) && isset($expectation[0]->partner_age))
            {

                $partner_age = $expectation[0]->partner_age;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_height) && isset($expectation[0]->partner_height))
            {

                $partner_height = $expectation[0]->partner_height;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_weight) && isset($expectation[0]->partner_weight))
            {

                $partner_weight = $expectation[0]->partner_weight;
                $exist = 1;
            }
            if(!empty($expectation[0]->with_children_acceptables) && isset($expectation[0]->with_children_acceptables))
            {

                $with_children_acceptables = $expectation[0]->with_children_acceptables;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_any_disability) && isset($expectation[0]->partner_any_disability))
            {

                $partner_any_disability = $expectation[0]->partner_any_disability;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_marital_status) && isset($expectation[0]->partner_marital_status))
            {

                $partner_marital_status = $expectation[0]->partner_marital_status;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_education) && isset($expectation[0]->partner_education))
            {

                $partner_education = $expectation[0]->partner_education;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_body_type) && isset($expectation[0]->partner_body_type))
            {

                $partner_body_type = $expectation[0]->partner_body_type;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_DOSHAM) && isset($expectation[0]->partner_DOSHAM))
            {

                $partner_DOSHAM = $expectation[0]->partner_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_TYPE_OF_DOSHAM) && isset($expectation[0]->partner_TYPE_OF_DOSHAM))
            {

                $partner_TYPE_OF_DOSHAM = $expectation[0]->partner_TYPE_OF_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_Other_Dosham) && isset($expectation[0]->partner_Other_Dosham))
            {

                $partner_Other_Dosham = $expectation[0]->partner_Other_Dosham;
                $exist = 1;
            }
            // if(!empty($expectation[0]->partner_Expectation) && isset($expectation[0]->partner_Expectation))
            // {

            //     $partner_Expectation = $expectation[0]->partner_Expectation;
            //     $exist = 1;
            // }
            // if(!empty($expectation[0]->partner_Other_Expectation) && isset($expectation[0]->partner_Other_Expectation))
            // {

            //     $partner_Other_Expectation = $expectation[0]->partner_Other_Expectation;
            //     $exist = 1;
            // }
             

            if (!empty($partner_age)) {
                $from_year = date('Y') - $partner_age;
                $from_date = $from_year."-01-01";
                $partner_age = strtotime($from_date);
            }
             
            // print_r($expectation[0]->partner_Expectation);exit;
            $get_all_memberdatas =array();
            if($exist==1)
            {
            $get_all_memberdatas = $this->AppModel->get_matched_members($opposite_gender,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids);
            }
        $per_page=5;        
        

        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/matched_members/";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($get_all_memberdatas);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        
        $profile_viewed_details ="";
        if($exist==1)
        {
        $profile_viewed_details = $this->AppModel->get_matched_members($opposite_gender,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids,$per_page,$start);
        }
        $datas['results']=$profile_viewed_details;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($profile_viewed_details);exit;
        $datas['star']='';
        $datas['user_id']=$member_id;
        $datas['login_user_datas']=$this->LoginModel->get_login_user_datas($member_id);
        $datas['profile_viewed_count']=count($get_all_memberdatas);
        $this->template['middle'] = $this->load->view ($this->middle = 'app/matched_members',$datas, true);
        $this->getAppLayout();  
    }
     public function activeMembers($page)
    {
        $member_id = $this->session->userdata['thirumanam_applogged_data']['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        if($member->gender==1){
            $gender=2;
        }else{
            $gender=1;
        }
        
        $memberplan = $this->AppModel->getMemberPlan($member->member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        // print_r($soveran);exit;
       $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }
        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
        // print_r($ignored_by_ids);exit;
        $get_all_memberdatas=$this->AppModel->get_activememberdatas($gender,$soveran,$ignored_ids,$ignored_by_ids);

        $per_page=5;        
        

        // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."active_members/";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($get_all_memberdatas);           
        $config['uri_segment'] = 2;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="default-pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li><a href="#" class="active">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<i class="fas fa-chevron-right"></i>';
        $config['prev_link'] = '<i class="fas fa-chevron-left"></i>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => '');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        
        
        $profile_viewed_details=$this->AppModel->get_activepagination_datas($gender,$soveran,$ignored_ids,$ignored_by_ids,$per_page,$start);
        $datas['results']=$profile_viewed_details;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($profile_viewed_details);exit;
        $datas['star']='';
        $datas['user_id']=$member_id;
        $datas['login_user_datas']=$this->LoginModel->get_login_user_datas($member_id);
        $datas['profile_viewed_count']=count($get_all_memberdatas);
        $this->template['middle'] = $this->load->view ($this->middle = 'front/pages/active_members',$datas, true);
        $this->getAppLayout();  
    }

    function member_permission()
    {
        
            $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            if ($member_id == NULL) {
                return FALSE;
            }
            else {
                return TRUE;
            }
        
    }

    public function matched_member_list($page)
    {

        $per_page=5;
        $session = $this->session->userdata("thirumanam_applogged_data");                   
        $member_id = $session['member_id'];
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $age_from=$this->input->post('aged_from');
        $age_to=$this->input->post('aged_to');
        $height_from=$this->input->post('min_height');
        $height_to=$this->input->post('max_height_');
        $marital_status=$this->input->post('marital_status');
        $occupation=$this->input->post('Type_of_occupation');
        $father_vangusam   = $this->input->post('father_vangusam');
        $member_profile_id   = $this->input->post('member_id');
        $gender   = $this->input->post('gender');
        $star   = $this->input->post('star');
        $dosham   = $this->input->post('dosham');
        $Soveran_Details   = $this->input->post('Soveran_Details');
        $Type_of_study   = $this->input->post('Type_of_study');
        
        $aged_from = (int)$this->input->post('aged_from') - 1;
        $sql_aged_from = "";
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->input->post('aged_to');
        $sql_aged_to = '';
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        $min_height = "";
        $max_height = "";
        if($this->input->post('min_height')>=0) 
        {
            $min_height = $this->input->post('min_height');
        }
        if($this->input->post('max_height')>=0) 
        {
            $max_height = $this->input->post('max_height');
        }
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        
            $search_member_type = $this->input->post('search_member_type');
       // print_r($this->input->post());exit;
        $session_data=array(
            'age_from'=>$age_from,
            'age_to'=>$age_to,
            'height_from'=>$min_height,
            'height_to'=>$max_height,           
            'marital_status'=>$marital_status,
            'occupation'=>$occupation,
            'father_vangusam'=>$father_vangusam,
            'member_profile_id'=>$member_profile_id,
            'gender'=>$gender,
            'star'=>$star,
            'dosham'=>$dosham,
            'Soveran_Details'=>$Soveran_Details,
            'Type_of_study'=>$Type_of_study,
            
            );
        
        

        $this->session->set_userdata('adv_search', $session_data);

        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }

        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
        
    
        // print_r($father_vangusam);exit;
        // print_r($session_data);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($father_vangusam);
        $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids);
        // print_r($sql_aged_from);exit;
       // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/matched_member_list";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($advanced_search_datas);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        
        
        $profile_viewed_details=$this->AppModel->get_advanced_search_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$per_page,$start,$soveran,$ignored_ids,$ignored_by_ids);
        $datas['results']=$profile_viewed_details;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($profile_viewed_details);exit;
        $datas['star']='';
        $datas['user_id']=$member_id;
        $datas['login_user_datas']=$this->LoginModel->get_login_user_datas($member_id);
        $datas['profile_viewed_count']=count($advanced_search_datas);

        // print_r($this->session->userdata('adv_search'));exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'app/matched_members',$datas, true);
        $this->getAppLayout();  
         
    }
    public function matched_member_lists($page)
    {
        // print_r($this->session->userdata('adv_search'));exit;
        $per_page=5;
        $session = $this->session->userdata("thirumanam_applogged_data");                   
        $member_id = $session['member_id'];
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $member_profile_id ='';
        $occupation ="";
        $dosham = "";
        $Soveran_Details ="";
        $Type_of_study = "";
        $sql_aged_from ="";
        $sql_aged_to = "";
        $min_height = "";
        $max_height = "";
        $marital_status = "";
        $education = "";
        $father_vangusam = "";
        $star = "";
        $gender = "";
        $aged_from = (int)$this->session->userdata('adv_search')['age_from'] - 1;
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->session->userdata('adv_search')['age_to'];
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        // print_r($soveran);exit;

       if(!empty($sql_aged_from)){

        $sql_aged_from=$sql_aged_from;
        }
        if(!empty($sql_aged_to)){
            $sql_aged_to=$sql_aged_to;
             }
        if(!empty($this->session->userdata('adv_search')['height_from'])){
            $min_height=$this->session->userdata('adv_search')['height_from'];
             }
        if(!empty($this->session->userdata('adv_search')['height_to'])){
            $max_height=$this->session->userdata('adv_search')['height_to'];
             }
        if(!empty($this->session->userdata('adv_search')['marital_status'])){
            $marital_status=$this->session->userdata('adv_search')['marital_status'];
             }
        if(!empty($this->session->userdata('adv_search')['education'])){
            $education=$this->session->userdata('adv_search')['education'];
             }
        if(!empty($this->session->userdata('adv_search')['occupation'])){
            $occupation   = $this->session->userdata('adv_search')['occupation'];
             }
        if(!empty($this->session->userdata('adv_search')['father_vangusam'])){
            $father_vangusam   = $this->session->userdata('adv_search')['father_vangusam'];
             }
        if(!empty($this->session->userdata('adv_search')['member_profile_id'])){
            $member_profile_id   = $this->session->userdata('adv_search')['member_profile_id'];
             }
        if(!empty($this->session->userdata('adv_search')['gender'])){
            $gender   = $this->session->userdata('adv_search')['gender'];
             }
        if(!empty($this->session->userdata('adv_search')['star'])){
            $star   = $this->session->userdata('adv_search')['star'];
             }
        if(!empty($this->session->userdata('adv_search')['dosham'])){
            $dosham   = $this->session->userdata('adv_search')['dosham'];
             }
        if(!empty($this->session->userdata('adv_search')['Soveran_Details'])){
            $Soveran_Details   = $this->session->userdata('adv_search')['Soveran_Details'];
             }
        if(!empty($this->session->userdata('adv_search')['Type_of_study'])){
            $Type_of_study   = $this->session->userdata('adv_search')['Type_of_study'];
             }
        
        
        

        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }

        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        } 

    
        // print_r($father_vangusam);exit;
        // print_r($session_data);exit;
        $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids);
       // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/matched_member_lists";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($advanced_search_datas);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles o ".$config['total_rows']." Profiles )"; 

        
        
        $profile_viewed_details=$this->AppModel->get_advanced_search_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$per_page,$start,$soveran,$ignored_ids,$ignored_by_ids);
        $datas['results']=$profile_viewed_details;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($profile_viewed_details);exit;
        $datas['star']='';
        $datas['user_id']=$member_id;
        $datas['login_user_datas']=$this->LoginModel->get_login_user_datas($member_id);
        $datas['profile_viewed_count']=count($advanced_search_datas);
        $this->template['middle'] = $this->load->view ($this->middle = 'app/matched_members',$datas, true);
        $this->getAppLayout();  
         
    }


    public function active_member_list($page)
    {

        $per_page=5;
        $session = $this->session->userdata("thirumanam_applogged_data");                   
        $member_id = $session['member_id'];
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $age_from=$this->input->post('aged_from');
        $age_to=$this->input->post('aged_to');
        $height_from=$this->input->post('min_height');
        $height_to=$this->input->post('max_height_');
        $marital_status=$this->input->post('marital_status');
        $occupation=$this->input->post('Type_of_occupation');
        $father_vangusam   = $this->input->post('father_vangusam');
        $member_profile_id   = $this->input->post('member_id');
        $gender   = $this->input->post('gender');
        $star   = $this->input->post('star');
        $dosham   = $this->input->post('dosham');
        $Soveran_Details   = $this->input->post('Soveran_Details');
        $Type_of_study   = $this->input->post('Type_of_study');
        
        $aged_from = (int)$this->input->post('aged_from') - 1;
        $sql_aged_from = "";
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->input->post('aged_to');
        $sql_aged_to = '';
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        $min_height = "";
        $max_height = "";
        if($this->input->post('min_height')>=0) 
        {
            $min_height = $this->input->post('min_height');
        }
        if($this->input->post('max_height')>=0) 
        {
            $max_height = $this->input->post('max_height');
        }
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        
            $search_member_type = $this->input->post('search_member_type');
       // print_r($this->input->post());exit;
        $session_data=array(
            'age_from'=>$age_from,
            'age_to'=>$age_to,
            'height_from'=>$min_height,
            'height_to'=>$max_height,           
            'marital_status'=>$marital_status,
            'occupation'=>$occupation,
            'father_vangusam'=>$father_vangusam,
            'member_profile_id'=>$member_profile_id,
            'gender'=>$gender,
            'star'=>$star,
            'dosham'=>$dosham,
            'Soveran_Details'=>$Soveran_Details,
            'Type_of_study'=>$Type_of_study,
            
            );
        
        

        $this->session->set_userdata('adv_search', $session_data);


        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }
        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
        // print_r($father_vangusam);exit;
        // print_r($session_data);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($father_vangusam);
        $advanced_search_datas=$this->AppModel->get_advanced_activesearch_datas_old($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids);
        // print_r($advanced_search_datas);exit;
       // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
      //   <nav aria-label="Page navigation example">
      //   <ul class="pagination">
      //     <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
      //     <li class="page-item"><a class="page-link" href="#">1</a></li>
      //     <li class="page-item active"><a class="page-link" href="#">2</a></li>
      //     <li class="page-item"><a class="page-link" href="#">3</a></li>
      //     <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
      //   </ul>
      // </nav>
        $config["base_url"] = base_url()."app/active_member_list";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($advanced_search_datas);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles of ".$config['total_rows']." Profiles )"; 

        
        
        $profile_viewed_details=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$per_page,$start,$soveran,$ignored_ids,$ignored_by_ids);
        $datas['results']=$profile_viewed_details;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($profile_viewed_details);exit;
        $datas['star']='';
        $datas['user_id']=$member_id;
        $datas['login_user_datas']=$this->LoginModel->get_login_user_datas($member_id);
        $datas['profile_viewed_count']=count($advanced_search_datas);

        // print_r($this->session->userdata('adv_search'));exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'app/active_members',$datas, true);
        $this->getAppLayout();  
         
    }
    public function active_member_lists($page)
    {
        // print_r($this->session->userdata('adv_search'));exit;
        $per_page=5;
        $session = $this->session->userdata("thirumanam_applogged_data");                   
        $member_id = $session['member_id'];
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $member_profile_id ='';
        $occupation ="";
        $dosham = "";
        $Soveran_Details ="";
        $Type_of_study = "";
        $sql_aged_from ="";
        $sql_aged_to = "";
        $min_height = "";
        $max_height = "";
        $marital_status = "";
        $education = "";
        $father_vangusam = "";
        $star = "";
        $gender = "";
        $aged_from = (int)$this->session->userdata('adv_search')['age_from'] - 1;
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->session->userdata('adv_search')['age_to'];
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        // print_r($soveran);exit;

       if(!empty($sql_aged_from)){

        $sql_aged_from=$sql_aged_from;
        }
        if(!empty($sql_aged_to)){
            $sql_aged_to=$sql_aged_to;
             }
        if(!empty($this->session->userdata('adv_search')['height_from'])){
            $min_height=$this->session->userdata('adv_search')['height_from'];
             }
        if(!empty($this->session->userdata('adv_search')['height_to'])){
            $max_height=$this->session->userdata('adv_search')['height_to'];
             }
        if(!empty($this->session->userdata('adv_search')['marital_status'])){
            $marital_status=$this->session->userdata('adv_search')['marital_status'];
             }
        if(!empty($this->session->userdata('adv_search')['education'])){
            $education=$this->session->userdata('adv_search')['education'];
             }
        if(!empty($this->session->userdata('adv_search')['occupation'])){
            $occupation   = $this->session->userdata('adv_search')['occupation'];
             }
        if(!empty($this->session->userdata('adv_search')['father_vangusam'])){
            $father_vangusam   = $this->session->userdata('adv_search')['father_vangusam'];
             }
        if(!empty($this->session->userdata('adv_search')['member_profile_id'])){
            $member_profile_id   = $this->session->userdata('adv_search')['member_profile_id'];
             }
        if(!empty($this->session->userdata('adv_search')['gender'])){
            $gender   = $this->session->userdata('adv_search')['gender'];
             }
        if(!empty($this->session->userdata('adv_search')['star'])){
            $star   = $this->session->userdata('adv_search')['star'];
             }
        if(!empty($this->session->userdata('adv_search')['dosham'])){
            $dosham   = $this->session->userdata('adv_search')['dosham'];
             }
        if(!empty($this->session->userdata('adv_search')['Soveran_Details'])){
            $Soveran_Details   = $this->session->userdata('adv_search')['Soveran_Details'];
             }
        if(!empty($this->session->userdata('adv_search')['Type_of_study'])){
            $Type_of_study   = $this->session->userdata('adv_search')['Type_of_study'];
             }
        
        
        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }

        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
        

    
        // print_r($father_vangusam);exit;
        // print_r($session_data);exit;
        $advanced_search_datas=$this->AppModel->get_advanced_activesearch_datas_old($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids);
       // Pagination Code Start //
        $this->load->library('pagination');
        $config = array();
        // $config=paginationCustomConfig();
        $config["base_url"] = base_url()."app/active_member_lists";      
        $config["per_page"] = $per_page;
        $config["total_rows"] = count($advanced_search_datas);           
        $config['uri_segment'] = 3;
        $config['num_links'] = 4;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['display_pages'] = true;
        $config['reuse_query_string'] = true;
        $config['attributes'] = array('class' => 'page-link');
        

        $this->pagination->initialize($config);     
        
        $str_links = $this->pagination->create_links();     
        $datas["links"] = $str_links;

        // Pagination Code End //

        if ($page==0) {
            $page=1;
        }
        $start=($page-1)*$per_page;
        

       

        $end=$page*$config['per_page'];
        if ($end>$config['total_rows']) 
        {
            $end=$config['total_rows'];
        }

        $datas['result_count']= "Showing ( ".($start+1)." - ".$end." Profiles o ".$config['total_rows']." Profiles )"; 

        
        
        $profile_viewed_details=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$per_page,$start,$soveran,$ignored_ids,$ignored_by_ids);
        $datas['results']=$profile_viewed_details;
        $str_links = $this->pagination->create_links();
        $datas["page_links"] = explode('&nbsp;',$str_links);
        // Pagination Code End //   
        // print_r($profile_viewed_details);exit;
        $datas['star']='';
        $datas['user_id']=$member_id;
        $datas['login_user_datas']=$this->LoginModel->get_login_user_datas($member_id);
        $datas['profile_viewed_count']=count($advanced_search_datas);
        $this->template['middle'] = $this->load->view ($this->middle = 'app/active_members',$datas, true);
        $this->getAppLayout();  
         
    }

   
    
     

    public function saveHappyStory()
    {

        $inputs = $this->input->post();
        // print_r($inputs);exit;
        
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $data['title'] = $this->input->post('title');
            $data['description'] = $this->input->post('description');
            $data['post_time'] = strtotime($this->input->post('post_time'));
            $data['partner_name'] = $this->input->post('partner_name');
            $data['posted_by'] = $member_id;
            $data['approval_status'] = "0";
            $data['image'] = '[]';

            $this->db->insert('happy_story', $data);
            $id = $this->db->insert_id();

            $images = array();
            if(!demo()){
                foreach ($_FILES['image']['name'] as $i => $row) {
                    if ($_FILES['image']['name'][$i] !== '') {
                        $ib = $i + 1;
                        $path = $_FILES['image']['name'][$i];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        $img = 'happy_story_' . $id . '_' . $ib . '.jpg';
                        $img_thumb = 'happy_story_' . $id . '_' . $ib . '_thumb.jpg';
                        $images[] = array('index' => $i, 'img' => $img, 'thumb' => $img_thumb);
                    }
                }
                $this->AppModel->file_up("image", "happy_story", $id, 'multi');
            }
            $data1['image'] = json_encode($images);
            $this->db->where('happy_story_id', $id);
            $result = $this->db->update('happy_story', $data1);
            recache();

            if(!demo()){
                if ($this->input->post('upload_method') == 'upload') {
                    $data_v['timestamp'] = time();
                    $data_v['story_video_uploader_id'] = $member_id;
                    $data_v['story_id'] = $id;
                    $data_v['type'] = 'upload';
                    $data_v['from'] = 'local';
                    $data_v['video_link'] = '';
                    $data_v['video_src'] = '';
                    $this->db->insert('story_video', $data_v);
                    $v_id = $this->db->insert_id();
                    $video = $_FILES['upload_video']['name'];
                    $ext = pathinfo($video, PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['upload_video']['tmp_name'], 'uploads/story_video/story_video_' . $v_id . '.' . $ext);
                    $data_v['video_src'] = 'uploads/story_video/story_video_' . $v_id . '.' . $ext;
                    $this->db->where('story_video_id', $v_id);
                    $this->db->update('story_video', $data_v);
                    recache();
                }
                elseif ($this->input->post('upload_method') == 'share') {
                    $data_v['timestamp'] = time();
                    $data_v['story_video_uploader_id'] = $member_id;
                    $data_v['story_id'] = $id;
                    $data_v['type'] = 'share';
                    $data_v['from'] = $this->input->post('site');
                    $data_v['video_link'] = $this->input->post('video_link');
                    $code = $this->input->post('vl');
                    if ($this->input->post('site') == 'youtube') {
                        $data_v['video_src'] = 'https://www.youtube.com/embed/' . $code;
                    } else if ($this->input->post('site') == 'dailymotion') {
                        $data_v['video_src'] = '//www.dailymotion.com/embed/video/' . $code;
                    } else if ($this->input->post('site') == 'vimeo') {
                        $data_v['video_src'] = 'https://player.vimeo.com/video/' . $code;
                    }
                    $this->db->insert('story_video', $data_v);
                    recache();
                }
            }


            if ($result) {
                $member =  $this->session->userdata('thirumanam_applogged_data')['member_id'];
                $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member));
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $activity=array(

                    'member_id'=>$single->member_id,
                    'activity' =>'Save Happy Story',
                    'location'=>$decode['city'],'server' => json_encode($_SERVER)

                );
                $this->AppModel->add_info('user_activity',$activity);
                $this->session->set_flashdata('login_msg',getappAlert('success','Saved Succefully'));
                redirect(base_url().'profile', 'refresh');
            }
            else {
                $this->session->set_flashdata('login_msg',getappAlert('danger','Failed To Save'));
                redirect(base_url().'profile', 'refresh');
            }
        }

  public function storyVideoPreview($para2,$para3)
    {
        if ($para2 == 'youtube') {
            echo '<iframe width="300" height="150" src="https://www.youtube.com/embed/' . $para3 . '" frameborder="0"></iframe>';
        } else if ($para2 == 'dailymotion') {
            echo '<iframe width="300" height="200" src="//www.dailymotion.com/embed/video/' . $para3 . '" frameborder="0"></iframe>';
        } else if ($para2 == 'vimeo') {
            echo '<iframe src="https://player.vimeo.com/video/' . $para3 . '" width="200" height="300" frameborder="0"></iframe>';
        }
    }

    public function storyDetails($story_id)
    {
        $story_videos = $this->AppModel->getMemberData('story_video','result',array("story_video_uploader_id" => $story_id));
        $story_datas = $this->AppModel->getMemberData('happy_story','result',array("posted_by" => $story_id, "approval_status" => 1));
        // print_r($story_datas);exit;
        $datas['story_datas']=$story_datas;
        $datas['story_videos']=$story_videos;
        $this->template['middle']=$this->load->view($this->middle='front/pages/storydetails',$datas,true);
        $this->getAppLayout();
    }
    public function HappyStoryVerify()
    {
        $member = $this->db->get_where('member', array("member_id"=>$this->session->userdata('thirumanam_applogged_data')['member_id']))->row_array();
        if($member->membership==1){
            redirect('Subscription');
        }

        if($member->membership==2){
            redirect('profile');
        }

        if($member->updateProfileDoneStatus==0){
            redirect('profile');
        }
    }

    

    public function closeAccount($para2)
    {
        $id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $inputs = $this->input->get();
        // print_r($inputs);exit;
        if($para2=='no'){
            $inputs['reason_closed'] = '';
            $inputs['reason_closed_other'] = '';
        }
        if($para2=="yes"){
                $data['is_closed']=$para2;
                $data['reason_closed']=$inputs['reason_closed'];
                $data['reason_closed_other']=$inputs['reason_closed_other'];
                $this->db->where('member_id', $this->session->userdata('thirumanam_applogged_data')['member_id']);

                $result = $this->db->update('member', $data);
                $datas = array(
                     'member_id' => $id,
                     'reason'    => $inputs['reason_closed'],
                     'other_reason'    => $inputs['reason_closed_other'],

                );
                $this->AppModel->add_info('closed_members',$datas);
            }elseif($para2=="no"){
                $data['is_closed']=$para2;
                $this->db->where('member_id', $this->session->userdata('thirumanam_applogged_data')['member_id']);
                $result = $this->db->update('member', $data);
            }else{
                 $this->load->view('app/profile');
            }
    }

     public function reOpenAccount($para2)
    {
        $id = $this->session->userdata('thirumanam_applogged_data')['member_id'];  
        if($para2=="yes"){
                $data['is_closed']= 'no';
                $data['reason_closed']='';
                $data['reason_closed_other']='';
                $this->db->where('member_id', $this->session->userdata('thirumanam_applogged_data')['member_id']);
                $result = $this->db->update('member', $data);
                $this->AppModel->update_member('closed_members',$id,array('delete_status' => '1'));
            }elseif($para2=="no"){
                $data['is_closed']='yes';
                $this->db->where('member_id', $this->session->userdata('thirumanam_applogged_data')['member_id']);
                $result = $this->db->update('member', $data);
            }else{
                 $this->load->view('app/profile');
            }
    }

    
    public function doInterestMatchMember()
    {
        $rem_interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
        $meta_value_id=$this->input->post('m_id');
        
        echo'

        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="interestModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title" id="interestModalLabel">'.translate('confirm_express_interest').'</h6>
                <button class="close close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <p class="text-center"><b>'.translate("remaining_express_interest(s): ").'"'.$rem_interests.'"'.translate("times").'</b><br><span style="color:#DC0330;font-size:11px">**N.B.'. translate('expressing_an_interest_will_cost_1_from_your_remaining_interests').'**</span></p>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">'.translate('close').'</button>
                 <a href="'.base_url('AppController/addInterestMatchMember/').$meta_value_id.'" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>';
  }

   public function addInterestMatchMember($member_id)
    {
    
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $express_interest = get_type_name_by_id('member', $member, 'express_interest');
        // print_r($express_interest);exit;
        if ($express_interest > 0) {
            $interests = get_type_name_by_id('member', $member, 'interest');
            $interest = json_decode($interests, true);
            if (empty($interest)) {
                $interest = array();
                $interest[] = array('id'=>$member_id,'status'=>'pending','time'=>time());
            }
            if (!in_assoc_array($member_id, 'id', $interest)) {
                $interest[] = array('id'=>$member_id,'status'=>'pending','time'=>time());
            }
            $this->db->where('member_id', $member);
            $this->db->update('member', array('interest' => json_encode($interest)));

            // Subtracting a Remaining Interest
            $express_interest = $express_interest - 1;
            $this->db->where('member_id', $member);
            $this->db->update('member', array('express_interest' => $express_interest));
            recache();
            $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
            $ip = get_IP_address();
            $loc = file_get_contents("http://ip-api.com/json/$ip");
            $decode = json_decode($loc, true);
            $data=array(

                'member_id'=>$member,
                'activity' =>'interested Profile Id: '.$single->member_profile_id.' name : '.$single->first_name.' remain interest: '.$express_interest,
                'location'=>$decode['city'],'server' => json_encode($_SERVER)

            );
            $this->AppModel->add_info('user_activity',$data);  


            // Updating the interest into the chosen Member
            $member_interests = get_type_name_by_id('member', $member_id, 'interested_by');
            $member_interest = json_decode($member_interests, true);

            $notifications = get_type_name_by_id('member', $member_id, 'notifications');
            $notification = json_decode($notifications, true);

            if (empty($member_interest)) {
                $member_interest = array();
                $member_interest[] = array('id'=>$member, 'status'=>'pending', 'time'=>time());
                $notification[] = array('by'=>$member, 'type'=>'interest_expressed', 'status'=>'pending', 'is_seen'=>'no', 'time'=>time());
            }
            if (!in_assoc_array($member, 'id',$member_interest)) {
                $member_interest[] = array('id'=>$member, 'status'=>'pending', 'time'=>time());
                $notification[] = array('by'=>$member, 'type'=>'interest_expressed', 'status'=>'pending', 'is_seen'=>'no', 'time'=>time());
            }

            $this->db->where('member_id', $member_id);
            $this->db->update('member', array('interested_by' => json_encode($member_interest), 'notifications' => json_encode($notification)));
           $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_have_expressed_an_interest_on_this_member!')));
        redirect('app/my_interests');
        }
    }

    function add_shortlist($member_id)
    {
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $shortlists = get_type_name_by_id('member', $member, 'short_list');
        $shortlisted = json_decode($shortlists, true);
        if (empty($shortlisted)) {
            $shortlisted = array();
            array_push($shortlisted, $member_id);
        }
        if (!in_array($member_id, $shortlisted)) {
            array_push($shortlisted, $member_id);
        }
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Added To ShortList Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data); 
        $this->db->where('member_id', $member);
        $this->db->update('member', array('short_list' => json_encode($shortlisted)));
        recache();
    }
     public function deleteShortlist()
    {
        $rem_interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
        $meta_value_id=$this->input->post('m_id');
        
        echo'
<div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_remove').'</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-center"><b>'.translate("Are_you_sure_that_you_want_to_Remove this_Member_from_Shortlist?").'</b></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
        <a href="'.base_url('AppController/remove_shortlist/').$meta_value_id.'" type="button" class="btn btn-primary">'.translate('confirm').'</a>
      </div>
    </div>
  </div>
</div>

';
  }
  function remove_shortlist($member_id)
    {
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $shortlists = get_type_name_by_id('member', $member, 'short_list');
        $shortlisted = json_decode($shortlists, true);
        // $key = array_search($member_id, $shortlisted);
        if (empty($shortlisted)) {
            $shortlisted = array();
        }
        // unset($shortlisted[$key]);
        $new_array = array();
        foreach ($shortlisted as $value) {
            if ($value != $member_id) {
                array_push($new_array, $value);
            }
        }
        $shortlisted = $new_array;
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Remove From ShortList Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data); 
        $this->db->where('member_id', $member);
        $this->db->update('member', array('short_list' => json_encode($shortlisted)));
        $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_have_removed_this_member_from_shortlist!')));
        redirect('app/shortlist');
        recache();
    }
    public function add_reportMatchMember()
    {
        $meta_value_id=$this->input->post('m_id');
        
        echo'
        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('profile_report').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group" style="padding: 15px">
            <label>'.translate('Detailed_information').'</label>
            <input type="hidden" id="report_id" value="">
            <textarea class="form-control" rows="4" id="report_details"></textarea>
        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <button onclick="do_report('.$meta_value_id.')" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>

        ';
          }
    function do_reportMatchMember($member_id)
    {
        // print_r($_REQUEST);exit;
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];

        $report_data = array('member_id' => $member,'reported_member_id' => $member_id,'details' => $_REQUEST['details'] );        
        $this->db->insert('members_report',$report_data);

        $reports = get_type_name_by_id('member', $member, 'report_profile');
        $reported = json_decode($reports, true);
        if (empty($reported))
        {
            $reported = array();
            array_push($reported, $member_id);
        }
        if (!in_array($member_id, $reported))
        {
            array_push($reported, $member_id);
        }
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Reported Profile Id: '.$single->member_profile_id.' name :'.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data); 

        $this->db->where('member_id', $member);
        $this->db->update('member', array('report_profile' => json_encode($reported)));

        $reported_persion =  $this->db->get_where('member',array('member_id' => $member_id))->row()->reported_by;
        $report_count = $reported_persion + 1;
        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('reported_by' => $report_count));

        // Email send
        $from =  $this->db->get_where('member',array('member_id' => $member))->row()->email;
        $from_name =  $this->db->get_where('member',array('member_id' => $member))->row()->first_name.' '.$this->db->get_where('member',array('member_id' => $member))->row()->last_name;
        $reported_person = $member_id;

        $this->AppModel->profile_report($from,$from_name,$reported_person);


        recache();
    }

    public function add_reportMarried()
    {
        $meta_value_id=$this->input->post('m_id');
        
        echo'
        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('match').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group" style="padding: 15px">
            <span>'.translate('marriage_msg').'</span>
            
        </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <button onclick="do_married('.$meta_value_id.')" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>

        ';
          }

    function do_reportMarried($member_id)
    {
        // print_r($member_id);exit;
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];

        $report_data = array('member_id' => $member_id,'details' => 'married' );        
        $this->db->insert('members_report',$report_data);

        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('report_married_status' => 1));
        
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Reported for married Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data); 


        recache();
        
    }
   public function addfollowMatchMember($member_id)
    {
        
        // session member = $member
        // to whome follow = $member_id
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $follows = get_type_name_by_id('member', $member, 'followed');
        $followed = json_decode($follows, true);
        if (empty($followed)) {
            $followed = array();
            array_push($followed, $member_id);

            $follower = get_type_name_by_id('member', $member_id, 'follower');
            $follower = $follower + 1;
            $this->db->where('member_id', $member_id);
            $this->db->update('member', array('follower' => $follower));
        }
        if (!in_array($member_id, $followed)) {
            array_push($followed, $member_id);

            $follower = get_type_name_by_id('member', $member_id, 'follower');
            $follower = $follower + 1;
            $this->db->where('member_id', $member_id);
            $this->db->update('member', array('follower' => $follower));
        }
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Followed Profile Id: '.$single->member_profile_id.' name :'.$single->first_name.' total followers: '.$follower,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data); 
        $this->db->where('member_id', $member);
        $this->db->update('member', array('followed' => json_encode($followed)));
        recache();
    }
    function unfollowMatchMember($member_id)
    {
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $follows = get_type_name_by_id('member', $member, 'followed');
        $followed = json_decode($follows, true);
        // $key = array_search($member_id, $followed);
        if (empty($followed)) {
            $followed = array();
        }
        // unset($followed[$key]);
        $new_array = array();
        foreach ($followed as $value) {
            if ($value != $member_id) {
                array_push($new_array, $value);
            }
        }
        $followed = $new_array;
        $this->db->where('member_id', $member);
        $this->db->update('member', array('followed' => json_encode($followed)));

        $follower = get_type_name_by_id('member', $member_id, 'follower');
        $follower = $follower - 1;
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Unfollow Match Member Profile Id: '.$single->member_profile_id.' name: '.$single->first_name.' total followers: '.$follower,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);

        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('follower' => $follower));
        recache();
    }

    public function confirm_ignoreMatchMember()
    {
        
        $meta_value_id=$this->input->post('m_id');
        
        echo'
            <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_ignore').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center"><b>'.translate("are_you_sure_that_you_want_to_ignore_this_member?").'</b></p>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <button onclick="do_ignore('.$meta_value_id.')" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
            </div>
            </div>';
  }

  function do_ignoreMatchMember($member_id)
    {
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $ignores = get_type_name_by_id('member', $member, 'ignored');
        $ignored_bys = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored = json_decode($ignores, true);
        $ignored_by = json_decode($ignored_bys, true);
        // FOR Logged in USER
        if (empty($ignored)) {
            $ignored = array();
            array_push($ignored, $member_id);
        }
        elseif (!empty($ignored)) {
            if (!in_array($member_id, $ignored)) {
                array_push($ignored, $member_id);
            }
        }
        $this->db->where('member_id', $member);
        $this->db->update('member', array('ignored' => json_encode($ignored)));

        // FOR IGNORED USER
        if (empty($ignored_by)) {
            $ignored_by = array();
            array_push($ignored_by, $member);
        }
        elseif (!empty($ignored_by)) {
            if (!in_array($member, $ignored_by)) {
                array_push($ignored_by, $member);
            }
        }
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Ignored Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);

        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('ignored_by' => json_encode($ignored_by)));
        recache();
    }
  function removeShortlist($member_id)
    {
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $shortlists = get_type_name_by_id('member', $member, 'short_list');
        $shortlisted = json_decode($shortlists, true);
        // $key = array_search($member_id, $shortlisted);
        if (empty($shortlisted)) {
            $shortlisted = array();
        }
        // unset($shortlisted[$key]);
        $new_array = array();
        foreach ($shortlisted as $value) {
            if ($value != $member_id) {
                array_push($new_array, $value);
            }
        }
        $shortlisted = $new_array;
        $this->db->where('member_id', $member);
        $this->db->update('member', array('short_list' => json_encode($shortlisted)));
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Remove from Short List Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
        $this->session->set_flashdata('login_msg',getappAlert('success','Deleted Succefully'));
        redirect('profile');
    }


     public function deleteFollow()
    {
        $rem_interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
        $meta_value_id=$this->input->post('m_id');
        
        echo'
        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_unfollow').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center"><b>'.translate("are_you_sure_that_you_want_to_unfollow_this_member?").'</b></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <a onclick="add_unfollow('.$meta_value_id.')" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>';
  }

    function add_unfollow($member_id)
    {
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $follows = get_type_name_by_id('member', $member, 'followed');
        $followed = json_decode($follows, true);
        // $key = array_search($member_id, $followed);
        if (empty($followed)) {
            $followed = array();
        }
        // unset($followed[$key]);
        $new_array = array();
        foreach ($followed as $value) {
            if ($value != $member_id) {
                array_push($new_array, $value);
            }
        }
        $followed = $new_array;
        $this->db->where('member_id', $member);
        $this->db->update('member', array('followed' => json_encode($followed)));
        
        $follower = get_type_name_by_id('member', $member_id, 'follower');
        $follower = $follower - 1;
        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('follower' => $follower));
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Unfollow Profile Id: '.$single->member_profile_id.' name: '.$single->first_name.' total followers: '.$follower,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
    }

    public function confirmUnblock()
    {
        $rem_interests = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'express_interest');
        $meta_value_id=$this->input->post('m_id');
        
        echo'
        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_unblock').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center"><b>'.translate("are_you_sure_that_you_want_to_unblock_this_member_from_ignored_list?").'</b></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <a href="'.base_url('AppController/unblockMember/').$meta_value_id.'" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>';
  }

  function unblockMember($member_id)
    {
        
        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $ignores = get_type_name_by_id('member', $member, 'ignored');
        $ignored = json_decode($ignores, true);
        if (empty($ignored)) {
            $ignored = array();
        }
        $new_array = array();
        foreach ($ignored as $value) {
            if ($value != $member_id) {
                array_push($new_array, $value);
            }
        }
        $ignored = $new_array;
        $this->db->where('member_id', $member);
        $this->db->update('member', array('ignored' => json_encode($ignored)));
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'UnBlock Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
       $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_have_unblocked_this_member!')));
        redirect('app/ignored_list');
    }

    public function get_messages($message_thread_id, $get_all='')
    {
       
        if ($get_all == "") {
            $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $member_position = message_thread_member_position($message_thread_id,$member);
            $this->db->where('message_thread_id', $message_thread_id);
            $this->db->update('message_thread', array('message_'.$member_position.'_seen' => 'yes'));
            recache();

            $page_data['message_thread_id'] = $message_thread_id;
            $messages_query = $this->db->order_by('message_time')->get_where('message', array('message_thread_id' => $message_thread_id));
            $page_data['message_count'] = $messages_query->num_rows();
            if ($page_data['message_count'] <= 50) {
                $page_data['messages'] = $messages_query->result();
            } else {
                $limit_from = $page_data['message_count'] - 50;
                $limit_amount = 50;
                $page_data['messages'] = $this->db->order_by('message_time')->limit($limit_amount, $limit_from)->get_where('message', array('message_thread_id' => $message_thread_id))->result();
            }
        }
        elseif ($get_all == "all_msg") {
            $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $member_position = message_thread_member_position($message_thread_id,$member);
            $this->db->where('message_thread_id', $message_thread_id);
            $this->db->update('message_thread', array('message_'.$member_position.'_seen' => 'yes'));
            recache();

            $page_data['message_thread_id'] = $message_thread_id;
            $messages_query = $this->db->order_by('message_time')->get_where('message', array('message_thread_id' => $message_thread_id));
            $page_data['messages'] = $messages_query->result();
            $page_data['message_count'] = 0; // to set the frontend variable for not displaying SHOW ALL MSG
        }
        // print_r($page_data);exit;
        $datas['message_field'] = $this->load->view('app/appmessages', $page_data, true);
        $this->template['middle']=$this->load->view($this->middle='app/appmessage_field',$datas,true);
        $this->getAppLayout(); 
    }


    function send_message ($message_thread_id, $message_from, $message_to) {
        $data['message_thread_id'] = $message_thread_id;
        $data['message_from'] = $message_from;
        $data['message_to'] = $message_to;
        $data['message_text'] = $this->input->post('message_text');
        $data['message_time'] = time();
        $this->db->insert('message', $data);

        $member_position = message_thread_member_position($message_thread_id,$message_to);
       
        $this->db->where('message_thread_id', $message_thread_id);
        $this->db->update('message_thread', array('message_'.$member_position.'_seen' => '','message_thread_time' => time()));
        recache();
    }

    public function Subscription()
    { 
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }

      $datas['all_plans'] = $this->AppModel->getPlans(); 
        // print_r($datas['all_plans']);exit;
        $this->template['middle']=$this->load->view($this->middle='app/plans',$datas,true);
        $this->getAppLayout();
    }

     public function Subscribe($id)
    {
         // print_r($this->session->userdata('thirumanam_applogged_data'));exit;
       $datas['selected_plan'] = $this->db->get_where("plan", array("plan_id" => $id))->result();
       if($this->session->userdata('thirumanam_applogged_data')){

            $datas['bank_transfers'] = $this->db->get_where("package_payment", array("member_id" => $this->session->userdata('thirumanam_applogged_data')['member_id'],"payment_status" => "due","plan_id" => $id,"payment_type" => "custom_payment_method_3"))->result();
       }else{
        $datas['bank_transfers'] = array();
       }     
        
       
        $this->template['middle']=$this->load->view($this->middle='front/pages/payment',$datas,true);
        $this->getAppLayout();
    }

    public function submitPayment()
    {
            $cust_id = $this->uri->segment(3);
            $plan_id = ($this->uri->segment(5)!='') ? $this->uri->segment(5) : 5;
            
                if($this->session->userdata('member_id') == 1813)//1813 3335 3402 3403
                $fee = 1;
                else
                $fee = $this->uri->segment(4);
                // $fee = $this->db->get_where('plan',array('plan_id'=>$fees_id))->row()->amount;
          // print_r($fee);exit;
            $this->session->set_userdata('log',['userId'=>$cust_id,'fee'=>$fee,'plan_id'=>$plan_id]);
            $this->startPayment($cust_id,$fee,$plan_id);
  
    }
     public function startPayment($cust_id="",$fee="",$plan_id="")
     {
        if ($cust_id=="") {
          $session = $this->session->userdata('log');  
          $cust_id = $session['userId'];
          $fee = $session['fee'];
          $plan_id = $session['plan_id'];
        }
          // $this->load->model('HomeModel');
          $paramList["MID"] = PAYTM_MERCHANT_MID;
          $paramList["ORDER_ID"] = "ORD".rand(100000,999999);
          $paramList["CUST_ID"] = $cust_id;
          $paramList["INDUSTRY_TYPE_ID"] = "Retail";
          $paramList["CHANNEL_ID"] = "WEB";
          $paramList["TXN_AMOUNT"] = $fee;
          $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
    
          $id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
          $paramList["CALLBACK_URL"] = base_url("AppController/process_payment/".$id."/".$plan_id."/".$fee);
         
          $paramList["VERIFIED_BY"] = "EMAIL"; //
          $paramList["IS_USER_VERIFIED"] = "YES"; //
      
          
    
          //Here checksum string will return by getChecksumFromArray() function.
          $checkSum = $this->getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);

          echo"<html>
            <head>
            <title>Merchant Check Out Page</title>
            </head>
            <body>
                <center><h1>Please do not refresh this page...</h1></center>
                    <form method='post' action='".PAYTM_TXN_URL."' name='f1'>
            <table border='1'>
             <tbody>";
             foreach($paramList as $name => $value) {
             echo '<input type="hidden" name="' . $name .'" value="' . $value .'">';
             }
             echo "<input type='hidden' name='CHECKSUMHASH' value='". $checkSum ."'>
             </tbody>
            </table>
            <script type='text/javascript'>
             document.f1.submit();
            </script>
            </form>
            </body>
            </html>";
      }

    public function process_payment($userId = '',$planid = '',$amount = '')
    {
        // session_start();
        $datase = array();
        $result = $this->db->get_where('member',array('member_id'=>$userId))->row();
        $datase['login_state'] = 'yes';
        $datase['member_id'] = $result->member_id;
        $datase['member_name'] = $result->first_name;
        $datase['member_email'] = $result->email;
        // if ($this->member_permission() == FALSE) {
        //     redirect(base_url().'login', 'refresh');
        // }
        // $this->session->set_userdata($datase);
        // $this->session->set_userdata(array('login_state','yes'));
        // $this->session->set_userdata(array("member_id"=>$userId));
         $session_data = array(
          'member_id' => $result->member_id,
          'member_name'=>$result->first_name,
          'member_email'=> $result->email,
          'mobile'=> $result->mobile,
          'password'=> $result->password,
          );
         $this->session->set_userdata('thirumanam_applogged_data', $session_data);
        $paramList = array();
        $paramList = $this->input->post();

        // print_r($session_data);exit;
        if($userId==3335)
        {
            // echo "<pre>";
            // print_r($paramList);
            // die();
        }
        ;
        if($paramList['STATUS'] == 'TXN_FAILURE')
        {
            $this->session->set_flashdata('login_msg',getappAlert('danger','payment Error'));
            redirect('app/profile');
        } 
 
            $plan_details=$this->db->get_where('plan',array('plan_id'=>$planid))->row();
            $plan_amount=$plan_details->amount;
            $member_id  = $userId;
            $plan_id    = $planid;
            // $plan_id    = 5;
            //$amount     = 1536;
            $amount     = ($amount!='') ? $amount : $plan_amount;
            // $amount     = $plan_amount;
            // $amount     = 2048;
            $member_type=$result->member_type;


            // $this->db->where('package_payment_id', $payment_id);
            // $result1 = $this->db->update('package_payment', $data2);

            $data['plan_id']  = $plan_id;
            $data['member_id']= $member_id;
            $data['member_type']= $member_type;
            $data['payment_type']= $paramList['PAYMENTMODE'] ;
            $data['currency']= $paramList['CURRENCY'] ;
            $data['paymentId']= $paramList['ORDERID'] ;
            $data['response_msg']= $paramList['RESPMSG'] ;
            $data['paymentGatewayName']= $paramList['GATEWAYNAME'] ;
            $data['bankTxnId']= $paramList['BANKTXNID'] ;
            // $data['BankName']= $paramList['BANKNAME'] ;
            $data['payment_status'] = 'due';
            $data['payment_details'] = 'none';
            $data['payment_response'] = json_encode($paramList);
             
            $data['custom_payment_method_transaction_id']   = $paramList['TXNID'];
             
            $data['amount']   = $amount;
            $data['plan_amount']   = $plan_amount;
            $data['purchase_datetime']                      = time();
            $data['payment_timestamp']                      = time();
            $data['expire']   = 'no';

            $payment_data = getData('package_payment','row',array('member_id'=>$member_id));
            // print_r($payment_data);exit;
            if(!empty($payment_data)){
                $payment_id = $payment_data->plan_id;
                $this->AppModel->updateInfo('package_payment', $data,array('member_id'=>$member_id,'active_status'=>1,'delete_status'=>0,));

            }else{

                $insert =    $this->db->insert('package_payment', $data);
                $payment_id = $this->db->insert_id();
            }

            
            
            
            $payment_details = $this->db->get_where('package_payment', array('package_payment_id' => $payment_id))->row();
            // print_r($payment_id);exit;
            $member_details = $this->db->get_where('member', array('member_id' => $payment_details->member_id))->row();
            $plan_details = $this->db->get_where('plan', array('plan_id' => $payment_details->plan_id))->row();


           // if($paramList['STATUS'] == 'TXN_SUCCESS')
           //  {
           //      $data2['payment_status'] = "paid";
           //      $data2['active_status'] = 1;
           //      $data1['membership'] = 2;
           //      $data1['active_status'] = 1;
           //  }
           //  else
           //  {
           //      $data2['payment_status'] = "due";
           //      $data2['active_status'] = 0;
           //      $data1['membership'] = 1;
           //      $data1['active_status'] = 0;
           //  }
            

            $data2['payment_status'] = "paid";
            $data2['active_status'] = 1;
            $data1['membership'] = 2;
            $data1['active_status'] = 1;  
             
            if ($plan_amount==$amount || $member_details->remain_download==0) {
                $data1['express_interest'] = $member_details->express_interest + $plan_details->express_interest;
                $data1['remain_download'] = 100;
                $data1['membership_date'] = date('Y-m-d');
                $data1['member_since_for_edit_profile'] = date('Y-m-d');
                $data1['direct_messages'] = $member_details->direct_messages + $plan_details->direct_messages;
                $data1['photo_gallery'] = $member_details->photo_gallery + $plan_details->photo_gallery;
                 $data1['member_type'] = 1;
                // $data1['soveran_detail'] = ($result->soveran_detail=='') ? $plan_details->soveran : $result->soveran_detail;
                $package_info[] = array('current_package'   => $plan_details->name,
                                'package_price'             => $payment_details->amount,
                                'payment_type'              => $payment_details->custom_payment_method_name
                                );
                $data1['package_info'] = json_encode($package_info);    
            }
            else
            {            
                $data1['membership_date'] = date('Y-m-d');
                $data1['member_since_for_edit_profile'] = date('Y-m-d');                
                $data1['member_type'] = 1;            
                $package_info[] = array('current_package'   => $plan_details->name,
                            'package_price'             => $payment_details->amount,
                            'payment_type'              => $payment_details->custom_payment_method_name
                            );
                $data1['package_info'] = json_encode($package_info);
            }
            

            $this->db->where('member_id', $payment_details->member_id);
            $result = $this->db->update('member', $data1);
            recache();
                
            //$data2['payment_status'] = "paid";
            //when the payment is failed in payment gate way, account is getting activated without payment
                    
            $this->db->where('package_payment_id', $payment_id);
            $result1 = $this->db->update('package_payment', $data2);
                    
                    
            //  New Code for New Member If=d Generation
            // $member_id=3975;
            $memberData = $this->db->get_where('member', array('member_id' => $member_id))->row_array();
            // print_r($memberData);exit;

            // if($memberData['member_profile_id']=='')
            // {                
            //     $newMenberId = "";
            //     $t = 0;
            //     if($memberData['gender'] == '1')
            //     {
            //         $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1,'prefixId !='=>0))->row_array();

            //         $getId  = $u['prefixId'];
            //         if($getId < 5131)
            //         {
            //             $t = 5131;
            //             $newMenberId = 'Male5131';
            //         }
            //         else
            //         {
            //             $t = $getId +1;
            //             $newMenberId = 'Male'.$t;
            //         }
            //     }else{
            //         $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2,'prefixId !='=>0))->row_array();
                                             
            //         $getId  = $u['prefixId'];
            //         if($getId < 2677)
            //         {
            //             $t = 2677;
            //             $newMenberId = 'Female2677';
            //         }
            //         else
            //         {
            //             $t = $getId +1;
            //             $newMenberId = 'Female'.$t;
            //         }

            //     }
            //     $prefixIdData = array("member_profile_id"=>$newMenberId,"prefixId"=>$t);
            //     $this->db->update("member",$prefixIdData,array("member_id"=>$member_id));
            // }

            

            $checkRegisDate = date('Y-m-d');
            // $checkRegisDate = date('Y-m-d', strtotime("+6 months", strtotime($memberData['member_since'])));

            if($checkRegisDate <= date("Y-m-d"))
            {   
                // $checkRegisDate = date('Y-m-d');
                $newMenberIdRenew = "";
                $tRenew = 0;
                // echo $memberData['gender'];
                if($memberData['gender'] == '1')
                {
                    $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1,'prefixId !='=>0))->row_array();

                    $getId  = $u['prefixId'];
                    if($getId < 5131)
                    {
                        $tRenew = 5131;
                        $newMenberIdRenew = 'Male5131';
                    }
                    else
                    {
                        $tRenew = $getId +1;
                        $newMenberIdRenew = 'Male'.$tRenew;
                    }
                }else{
                    $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2,'prefixId !='=>0))->row_array();
                                             
                    $getId  = $u['prefixId'];
                    if($getId < 2677)
                    {
                        $tRenew = 2677;
                        $newMenberIdRenew = 'Female2677';
                    }
                    else
                    {
                        $tRenew = $getId +1;
                        $newMenberIdRenew = 'Female'.$tRenew;
                    }

                }
                $prefixIdDataRenew = array("member_profile_id"=>$newMenberIdRenew,"prefixId"=>$tRenew);
                $this->db->update("member",$prefixIdDataRenew,array("member_id"=>$member_id));
                // print_r($prefixIdDataRenew);
                
                unset($memberData['member_id']); 
                $insertMember = $this->db->insert('deactivated_member',$memberData);
       

                $updateData = array('member_since'=>date("Y-m-d H:i:s"),"isRenewed"=>1);
                $this->db->update("member",$updateData,array("member_id"=>$member_id));
        
                

                $SMSTEXT = "Dear ".$memberData['first_name'].", your account has been renewed with Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$newMenberIdRenew.".  ";

            

                $mobile = "91".$memberData['mobile'];
                $this->AppModel->sendSms($mobile,$SMSTEXT);



                $email_template = getData('email_templates','row',array('temp_name'=>'Renewed'));
            
            
                $subject = $email_template->subject;
                $emailText['text']="";
                if(!empty($email_template)){


                $image = '<img width="50" src="'.base_url().'/uploads/footer_logo/footer_logo_1590990739.jpg" title="logo" alt="logo">';
                   $subscribe = ' 
                   <a style="display: inline-block;
                   text-decoration:none;
                      background-color: #7b38d8;
                      width: 200px;
                      color: #ffffff;
                      text-align: center;
                      border: 4px double #cccccc;
                      border-radius: 10px;
                      font-size: 17px;
                      cursor: pointer;
                      margin: 5px;
                      -webkit-transition: all 0.5s; /* add this line, chrome, safari, etc */
                      -moz-transition: all 0.5s; /* add this line, firefox */
                      -o-transition: all 0.5s; /* add this line, opera */
                      transition: all 0.5s;"
                       href="http://192.168.0.126/ci/thirumanam_new/Subscription">Renew Now
                    </a>';
                   $link = '&copy; <strong><a style="font-family:Lucida Console" href="https://thirumanam.info/" target="_blank">www.thirumanam.info</a></strong>';
                   $email_template  = $email_template->template;
                   $name = ["[[logo]]", "[[name]]", "[[member_id]]", "[[mobile]]", "[[email]]", "[[link]]"];
                   $value   = [$image, $memberData['first_name'], $memberData['member_profile_id'], $memberData['mobile'], $memberData['email'], $link];
                   $emailText['text'] = str_replace($name, $value, $email_template);
                  
                
               } 
               // $this->load->view('Administrator/emails/renewmail',$emailText);

               $from=$this->AppModel->getData('general_settings','row',array('type' => 'system_email'));
                    $smtp_host=$this->AppModel->getData('general_settings','row',array('type' => 'smtp_host'));
                    $smtp_user=$this->AppModel->getData('general_settings','row',array('type' => 'smtp_user'));
                    $smtp_pass=$this->AppModel->getData('general_settings','row',array('type' => 'smtp_pass'));
                    $smtp_port=$this->AppModel->getData('general_settings','row',array('type' => 'smtp_port'));
                    $toemail = $memberData['email'];
                    // print_r($smtp_port->value);exit;
                    // $msg=$this->load->view('Administrator/emails/expirymail',$emailText);
                    $this->load->library('email');   
                    $config['protocol']  = 'sendmail';
                    $config['mailpath']  = '/usr/sbin/sendmail';
                    $config['charset']   = 'iso-8859-1';
                    $config['wordwrap']  = TRUE;
                    $config['useragent'] = 'CodeIgniter';
                    $config['smtp_host'] = $smtp_host->value; 
                    $config['smtp_user'] = $smtp_user->value;
                    $config['smtp_pass'] = $smtp_pass->value;
                    $config['smtp_port'] = $smtp_port->value;
                    $config['mailtype']  = 'html';
                    $config['newline']   = "\r\n";

                    $this->load->library('email');
                    $this->email->initialize($config);

                    $this->email->from($from->value);
                    $this->email->to($toemail);
                    $this->email->subject($subject);
                    $msg=$this->load->view('Administrator/emails/renewmail',$emailText, true);
                    $this->email->message($msg);

                    if($this->email->send())
                    {
                        $mail_status='send';
                        
                    }
                    else
                    {
                        echo $this->email->print_debugger();exit;
                        $mail_status='not-send';
                    }

            }
            $ip = get_IP_address();
            $loc = file_get_contents("http://ip-api.com/json/$ip");
            $decode = json_decode($loc, true);
            $data=array(

            'member_id'=>$member_id,
            'activity' =>'Payment Profile Id: '.$newMenberIdRenew.' name: '.$memberData['first_name'].' status: '.$data2['payment_status'],
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
            // print_r($data);
            $this->session->set_flashdata('login_msg',getappAlert('success','Payment Successfully'));
            redirect('app/profile');
        }


       public function getChecksumFromArray($arrayList, $key, $sort=1) {
        if ($sort != 0) {
            ksort($arrayList);
        }
        $str = $this->getArray2Str($arrayList);
        $salt = $this->generateSalt_e(4);
        $finalString = $str . "|" . $salt;
        $hash = hash("sha256", $finalString);
        $hashString = $hash . $salt;
        $checksum = $this->encrypt_e($hashString, $key);
        return $checksum;
    }
    public function getArray2Str($arrayList) {
        $findme   = 'REFUND';
        $findmepipe = '|';
        $paramStr = "";
        $flag = 1;  
        foreach ($arrayList as $key => $value) {
            $pos = strpos($value, $findme);
            $pospipe = strpos($value, $findmepipe);
            if ($pos !== false || $pospipe !== false) 
            {
                continue;
            }
            
            if ($flag) {
                $paramStr .= $this->checkString_e($value);
                $flag = 0;
            } else {
                $paramStr .= "|" . $this->checkString_e($value);
            }
        }
        return $paramStr;
    }

    public function generateSalt_e($length) {
        $random = "";
        srand((double) microtime() * 1000000);

        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
        $data .= "0FGH45OP89";

        for ($i = 0; $i < $length; $i++) {
            $random .= substr($data, (rand() % (strlen($data))), 1);
        }

        return $random;
    }

    public function encrypt_e($input, $ky) {
        $key   = html_entity_decode($ky);
        $iv = "@@@@&&&&####$$$$";
        $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
        return $data;
    }

    public function checkString_e($value) {
        if ($value == 'null')
            $value = '';
        return $value;
    }

    public function process_payment1()
    {
        // print_r($this->input->post('cpm_3_name'));exit;
        if ($this->input->post('payment_type') == 'custom_payment_method_3') {
            $member_id  = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $member_type = $this->db->get_where('member',array('member_id'=>$member_id))->row()->member_type;
            // $member_type  = $this->session->userdata('member_type');
            $plan_id    = $this->input->post('plan_id');
            $amount     = $this->input->post('pay_amount');
            $plan_amount= $this->db->get_where('plan', array('plan_id' => $plan_id))->row()->amount;

            $data['plan_id']                                = $plan_id;
            $data['member_id']                              = $member_id;
            $data['member_type']                            = $member_type;
            $data['payment_type']                           = $this->input->post('payment_type');
            $data['payment_status']                         = 'due';
            $data['payment_details']                        = 'none';
            $data['custom_payment_method_name']             = $this->input->post('cpm_3_name');
            $data['custom_payment_method_transaction_id']   = $this->input->post('cpm_3_transaction_id');
            $data['custom_payment_method_comment']          = $this->input->post('cpm_3_comment');
            $data['amount']                                 = $amount;
            $data['plan_amount']                            = $plan_amount;
            $data['purchase_datetime']                      = time();
            $data['payment_timestamp']                      = time();
            $data['expire']                                 = 'no';
            
            $this->db->insert('package_payment', $data);
            $payment_id = $this->db->insert_id();
            $this->db->update("member",array("paymentReq"=>1),array("member_id"=>$member_id));
            if (!demo() && $_FILES['cpm_3_bill_copy']['name'] !== '') {
                $path = $_FILES['cpm_3_bill_copy']['name'];
                $ext = '.' . pathinfo($path, PATHINFO_EXTENSION);
                $img_file_name = "cpm_3_bill_copy_".time().$ext;
                if ($ext==".jpg" || $ext==".JPG" || $ext==".jpeg" || $ext==".JPEG" || $ext==".png" || $ext==".PNG" || $ext==".pdf") {
                    move_uploaded_file($_FILES['cpm_3_bill_copy']['tmp_name'], 'uploads/custom_payment_method_bill_image/'.$img_file_name);
                    $forget_pass_image[] = array('image' => $img_file_name);

                    $bill_copy['custom_payment_method_bill_copy']        = $img_file_name;

                    $this->db->where('package_payment_id',$payment_id);
                    $this->db->update('package_payment', $bill_copy);
                    recache();
                }
            }

        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Payment Details Send',
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
            // $this->Email_model->subscruption_email('member', $member_id, $plan_id);
            $this->session->set_flashdata('login_msg',getappAlert('success','Payment Details send Succefully'));
            redirect('profile');
        }
       
       

}
public function shortView($id)
{ 
    if($this->member_permission() == FALSE){

            redirect('app/login');
        }
    $datas['short'] = 'shortview';
    $datas['getUser'] = getData('member','row',array('member_id'=>$id));
    $this->template['middle']=$this->load->view($this->middle='app/short_view',$datas,true);
    $this->getAppLayout();
}

 public function fullView($para1="")
    {
        if($this->member_permission() == FALSE){

            redirect('app/login');
        }
       if ($para1 != "" || $para1 != NULL) {
            $is_valid = $this->db->get_where("member", array("member_id" => $para1))->row()->member_id;
            if (!$is_valid) {
                redirect('app/home');
            }
            if ($this->db->get_where("member", array("member_id" => $para1))->row()->is_closed == 'yes') {
                redirect('app/home');
            }
            $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
            $ignored_ids = json_decode($ignored_ids, true);

            if (!in_array($para1, $ignored_ids) && $para1 != $member_id) {

                $get_memberShip = $this->db->get_where("member", array("member_id" => $member_id))->row()->membership;

                if($get_memberShip == 2)
                {
                     $get_date = $this->db->get_where("member", array("member_id" => $member_id))->row()->membership_date;
                    $getViewProfileData = $this->db->get_where("view_profile_management", array("user_id" => $member_id))->result_array();
                    $getMemebrData = $this->db->get_where("member", array("member_id" => $member_id))->result_array();
                     $getCount = $getMemebrData[0]['remain_download'];
                    $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($get_date)));
                    
                  

                    if(($getCount <= 100 && $getCount >= 1)  && $sixDate >= date('Y-m-d')) {
                        $checkViewMember = $this->db->get_where("view_profile_management", array("member_user_id" => $para1,"user_id"=>$member_id))->row_array();
                        if($checkViewMember)
                        {

                        }
                        else
                        {

                            $checkDownload = $getMemebrData[0]['remain_download'];
                            $final =$checkDownload - 1;
                            $update  = $this->db->update('member',array('remain_download'=>$final),array('member_id'=>$member_id));

                      
                            $arr = array(
                            "user_id"=>$member_id,
                            "member_user_id"=>$para1,
                            "date"=>date('Y-m-d')
                            );
                            $this->db->insert('view_profile_management',$arr);

                              
                        
                        }
                    }
                    else
                    {
                        
                        $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
                        $this->db->update("member",$arr1,array("member_id"=>$member_id));


                        $this->db->delete('view_profile_management',array('user_id'=>$member_id));

                        $this->session->set_flashdata('error_msg', 'renew_profile');
                        setcookie("cookie_member_id", "", time() - 3600, "/");
                        setcookie("cookie_member_name", "", time() - 3600, "/");
                        setcookie("cookie_member_email", "", time() - 3600, "/");

                        $this->session->unset_userdata('login_state');
                        $this->session->unset_userdata('member_id');
                        $this->session->unset_userdata('member_name');
                        $this->session->unset_userdata('member_email');
                        redirect(base_url().'app/login');
                    }
                }
                $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $checkDownload = $getMemebrData[0]['remain_download'];
                $final =$checkDownload - 1;
                $data=array(

                'member_id'=>$member_id,
                'activity' =>'viewed profile ID: '.$single->member_profile_id.' name: '.$single->first_name.' remain download '.$final,
                'location'=>$decode['city'],'server' => json_encode($_SERVER)

                );
                $this->AppModel->add_info('user_activity',$data);
                $datas['short'] = 'fullview';
                
                $datas['getUser'] = getData('member','row',array('member_id'=>$para1));
                $this->template['middle']=$this->load->view($this->middle='app/short_view',$datas,true);
                $this->getAppLayout();



                
            }
            else {
                redirect(base_url().'app/matched_members', 'refresh');
            }
        } else {
            redirect(base_url().'app/matched_members', 'refresh');
        }

    }

    public function memberProfile()
    {
        $rem_download=$this->input->post('rem_download');
        $meta_value_id=$this->input->post('m_id');
        
        echo'
            <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('profile_view_alert').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center"><b>'. translate('see_only').': "'.$rem_download.'"'.translate('profile').'</b><br>'. translate('see_only_note').'<br><b><span style="color:#DC0330;font-size:11px">'. "*".translate('note').': '.translate('ignore_note').'</b></span></p>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <a href="'.base_url('app/full_view/'.$meta_value_id).'" type="button" class="btn btn-primary">'.translate('ok').'</a>
              </div>
            </div>
            </div>
            </div>';
  }

  public function confirm_accept()
    {
        $meta_value_id=$this->input->post('m_id');
        
        echo'
        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_accept_request').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">'. translate("are_you_sure_that_you_want_to_accept_this_request").'?</p>
       
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <a href="'.base_url('AppController/accept_interest/'.$meta_value_id).'" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>

        ';
          }

    public function accept_interest($member_id)
    {
        

        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        // print_r($member);exit;
        // For Updating User's interested_by
        $interested_by = get_type_name_by_id('member', $member, 'interested_by');
        $interested_by = json_decode($interested_by, true);
        $new_interested_by = array();
        if (!empty($interested_by)) {
            foreach ($interested_by as $value1) {
                // print_r($value1)."<br>";
                if ($value1['id'] != $member_id) {
                    array_push($new_interested_by, $value1);
                }
                elseif ($value1['id'] == $member_id) {
                    array_push($new_interested_by, array('id'=>$value1['id'], 'status'=>'accepted', 'time'=>time()));
                }
                // print_r($new_interested_by)."<br>";
            }
        }
        // For Updating User's notifications
        $user_notifications = get_type_name_by_id('member', $member, 'notifications');
        $user_notifications = json_decode($user_notifications, true);
        $new_user_notification = array();
        if (empty($user_notifications)) {
            // print_r($user_notifications)."<br>";
            array_push($new_user_notification, array('by'=>$member_id, 'type'=>'accepted_interest', 'status'=>'accepted', 'is_seen'=>'no', 'time'=>time()));
            // print_r($new_user_notification);
        }
        if (!empty($user_notifications)) {
            foreach ($user_notifications as $value2) {
                // print_r($value2)."<br>";
                if ($value2['by'] != $member_id) {
                    array_push($new_user_notification, $value2);
                }
                elseif ($value2['by'] == $member_id) {
                    array_push($new_user_notification, array('by'=>$value2['by'], 'type'=>'interest_expressed', 'status'=>'accepted', 'is_seen'=>'no', 'time'=>time()));
                }
                // print_r($new_user_notification);
            }
        }
        $this->db->where('member_id', $member);
        $this->db->update('member', array('interested_by' => json_encode($new_interested_by), 'notifications' => json_encode($new_user_notification)));

        // For Updating Member's interest
        $interest = get_type_name_by_id('member', $member_id, 'interest');
        $interest = json_decode($interest, true);
        $new_interest = array();
        if (!empty($interest)) {
            foreach ($interest as $value3) {
                // print_r($value3)."<br>";
                if ($value3['id'] != $member) {
                    array_push($new_interest, $value3);
                }
                elseif ($value3['id'] == $member) {
                    array_push($new_interest, array('id'=>$value3['id'], 'status'=>'accepted', 'is_seen'=>'no', 'time'=>time()));
                }
                // print_r($new_interest)."<br>";
            }
        }
        // For Updating Member's notifications
        $member_notifications = get_type_name_by_id('member', $member_id, 'notifications');
        $member_notifications = json_decode($member_notifications, true);
        // print_r($member_notifications)."<br>";
        array_push($member_notifications, array('by'=>$member, 'type'=>'accepted_interest', 'status'=>'accepted', 'is_seen'=>'no', 'time'=>time()));
        // print_r($member_notifications);

        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('interest' => json_encode($new_interest), 'notifications' => json_encode($member_notifications)));

        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'interested Accepted Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
        $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_have_accepted_the_request')));
        redirect('app/home');
    }

    public function confirm_reject()
    {
        $meta_value_id=$this->input->post('m_id');
        
        echo'
        <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_reject_request').'</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center">'.translate("are_you_sure_that_you_want_to_reject_this_request?").'?</p>
       
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <a href="'.base_url('AppController/reject_interest/'.$meta_value_id).'" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
          </div>
        </div>

        ';
          }


    function reject_interest($member_id)
    {
       

        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        // For Updating User's interested_by
        $interested_by = get_type_name_by_id('member', $member, 'interested_by');
        $interested_by = json_decode($interested_by, true);
        $new_interested_by = array();
        if (!empty($interested_by)) {
            foreach ($interested_by as $value1) {
                // print_r($value1)."<br>";
                if ($value1['id'] != $member_id) {
                    array_push($new_interested_by, $value1);
                }
                /*elseif ($value1['id'] == $member_id) {
                    array_push($new_interested_by, array('id'=>$value1['id'], 'status'=>'rejected', 'time'=>time()));
                }*/
                // print_r($new_interested_by)."<br>";
            }
        }
        // For Updating User's notifications
        $user_notifications = get_type_name_by_id('member', $member, 'notifications');
        $user_notifications = json_decode($user_notifications, true);
        $new_user_notification = array();
        if (empty($user_notifications)) {
            // print_r($user_notifications)."<br>";
            array_push($new_user_notification, array('by'=>$member_id, 'type'=>'rejected_interest', 'status'=>'rejected', 'is_seen'=>'no', 'time'=>time()));
            // print_r($new_user_notification);
        }
        if (!empty($user_notifications)) {
            foreach ($user_notifications as $value2) {
                // print_r($value2)."<br>";
                if ($value2['by'] != $member_id) {
                    array_push($new_user_notification, $value2);
                }
                elseif ($value2['by'] == $member_id) {
                    array_push($new_user_notification, array('by'=>$value2['by'], 'type'=>'interest_expressed', 'status'=>'rejected', 'is_seen'=>'no', 'time'=>time()));
                }
                // print_r($new_user_notification);
            }
        }
        $this->db->where('member_id', $member);
        $this->db->update('member', array('interested_by' => json_encode($new_interested_by), 'notifications' => json_encode($new_user_notification)));

        // For Updating Member's interest
        $interest = get_type_name_by_id('member', $member_id, 'interest');
        $interest = json_decode($interest, true);
        $new_interest = array();
        if (!empty($interest)) {
            foreach ($interest as $value3) {
                // print_r($value3)."<br>";
                if ($value3['id'] != $member) {
                    array_push($new_interest, $value3);
                }
                /*elseif ($value3['id'] == $member) {
                    array_push($new_interest, array('id'=>$value3['id'], 'status'=>'rejected', 'time'=>time()));
                }*/
                // print_r($new_interest)."<br>";
            }
        }
        // For Updating Member's notifications
        $member_notifications = get_type_name_by_id('member', $member_id, 'notifications');
        $member_notifications = json_decode($member_notifications, true);
        // print_r($member_notifications)."<br>";
        array_push($member_notifications, array('by'=>$member, 'type'=>'rejected_interest', 'status'=>'rejected', 'is_seen'=>'no', 'time'=>time()));
        // print_r($member_notifications);

        $this->db->where('member_id', $member_id);
        $this->db->update('member', array('interest' => json_encode($new_interest), 'notifications' => json_encode($member_notifications)));
        $single = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member,
            'activity' =>'Reject Interest Profile Id: '.$single->member_profile_id.' name: '.$single->first_name,
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
        $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_have_rejected_this_request!')));
        redirect('app/home');
    }

    public function updateProfileimage()
    {
        $inputs = $this->input->post();
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        
        if($_FILES["profile_image"]['name']!='')
        {   
            $new_name = time().$_FILES["profile_image"]['name'];

            $config['upload_path'] = FCPATH ."uploads/profile_image/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('profile_image'))
            {}
            else
            {
              $data = $this->upload->data();
            }
        }
        else
        {
            $new_name='';
        }
        $profile_image[]=array(
            'profile_image' => $new_name,
            'thumb'         => '',
        );
        
        $datas['profile_image'] = json_encode($profile_image);
        // print_r($datas);exit;
        $this->AppModel->updateMemberDatas('member',array('member_id'=>$member_id),$datas);
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $data=array(

            'member_id'=>$member_id,
            'activity' =>'Profile Image Updated. ',
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$data);
        $this->session->set_flashdata('login_msg',getappAlert('success','Profile Image Updated Successfully'));
        
        redirect('app/profile');
    }
    public function getMobile()
    {
        $mobile=$this->input->get('mobile');
        // print_r($mobile);exit;
        $data = $this->AppModel->getData('member','result',array('mobile'=>$mobile));
        // print_r(count($data));exit;
        if(!empty($data)){
           if(count($data)>1){
            echo 1;
        } 
        }
        
        
        
    }

    public function saveProfileImage($id)
    {
        $inputs = $this->input->post();
     
        $profile_image[]=array(
            'profile_image' => $inputs['image_name'],
            'thumb'         => '',
        );
        
        $datas['profile_image'] = json_encode($profile_image);
        // print_r($datas);exit;
        
        $this->AppModel->updateMemberDatas('member',array('member_id'=>$id),$datas);
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        $activity_data=array(

            'member_id'=>$member_id,
            'activity' =>'Profile Image Updated.',
            'location'=>$decode['city'],'server' => json_encode($_SERVER)

        );
        $this->AppModel->add_info('user_activity',$activity_data);
        $this->session->set_flashdata('login_msg',getAlert('success','Profile Image Updated Successfully'));
        
        redirect('app/gallery');
    }


    public function active_seach_list()
    {
       
       if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        // print_r(member_permission());exit;

        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        if($member->gender==1){
            $gender=2;
        }else{
            $gender=1;
        }

        $per_page=5;
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $age_from=$this->input->post('aged_from');
        $age_to=$this->input->post('aged_to');
        $height_from=$this->input->post('min_height');
        $height_to=$this->input->post('max_height_');
        $marital_status=$this->input->post('marital_status');
        $occupation=$this->input->post('Type_of_occupation');
        $father_vangusam   = $this->input->post('father_vangusam');
        $member_profile_id   = $this->input->post('member_id');
        $star   = $this->input->post('star');
        $dosham   = $this->input->post('dosham');
        $Soveran_Details   = $this->input->post('Soveran_Details');
        $Type_of_study   = $this->input->post('Type_of_study');
        
        $aged_from = (int)$this->input->post('aged_from') - 1;
        $sql_aged_from = "";
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->input->post('aged_to');
        $sql_aged_to = '';
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        $min_height = "";
        $max_height = "";
        if($this->input->post('min_height')>=0) 
        {
            $min_height = $this->input->post('min_height');
        }
        if($this->input->post('max_height')>=0) 
        {
            $max_height = $this->input->post('max_height');
        }
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        
            $search_member_type = $this->input->post('search_member_type');
       // print_r($this->input->post());exit;
        $session_data=array(
            'age_from'=>$age_from,
            'age_to'=>$age_to,
            'height_from'=>$min_height,
            'height_to'=>$max_height,           
            'marital_status'=>$marital_status,
            'occupation'=>$occupation,
            'father_vangusam'=>$father_vangusam,
            'member_profile_id'=>$member_profile_id,
            'gender'=>$gender,
            'star'=>$star,
            'dosham'=>$dosham,
            'Soveran_Details'=>$Soveran_Details,
            'Type_of_study'=>$Type_of_study,
            
            );
        // print_r($session_data);exit;
        

        $this->session->set_userdata('adv_search', $session_data);


        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }
        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
        // print_r($ignored_by_ids);exit;
        // print_r($session_data);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($father_vangusam);

        $total_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids);
        $advanced_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,10);
        // print_r(count($total_search_datas));
         // print_r($advanced_search_datas);exit;
        $datas['results']=$advanced_search_datas;
        $datas['total_count']=count($total_search_datas);
        $datas['total_data']=count($total_search_datas);

        $this->template['middle']=$this->load->view($this->middle='app/active_search_result',$datas,true);
        $this->getAppLayout(); 
        
         
    }

    public function active_search_more()
    {
        $view_id = $this->input->get('id');
       if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        // print_r($this->input->post());exit;

        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        if($member->gender==1){
            $gender=2;
        }else{
            $gender=1;
        }

        $per_page=5;
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $age_from=$this->input->post('aged_from');
        $age_to=$this->input->post('aged_to');
        $height_from=$this->input->post('min_height');
        $height_to=$this->input->post('max_height_');
        $marital_status=$this->input->post('marital_status');
        $occupation=$this->input->post('Type_of_occupation');
        $father_vangusam   = $this->input->post('father_vangusam');
        $member_profile_id   = $this->input->post('member_id');
        $star   = $this->input->post('star');
        $dosham   = $this->input->post('dosham');
        $Soveran_Details   = $this->input->post('Soveran_Details');
        $Type_of_study   = $this->input->post('Type_of_study');
        
        $aged_from = (int)$this->input->post('aged_from') - 1;
        $sql_aged_from = "";
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->input->post('aged_to');
        $sql_aged_to = '';
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        $min_height = "";
        $max_height = "";
        if($this->input->post('min_height')>=0) 
        {
            $min_height = $this->input->post('min_height');
        }
        if($this->input->post('max_height')>=0) 
        {
            $max_height = $this->input->post('max_height');
        }
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        
            $search_member_type = $this->input->post('search_member_type');
       


        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }
        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
       
        // print_r($session_data);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($father_vangusam);
        $total_advanced_search_count="";
        $total_advanced_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,$view_id);
        // print_r($total_advanced_search_datas);exit;
        $advanced_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,10,$view_id);
        $datas['results']=$advanced_search_datas;
        $datas['total_data']=count($total_advanced_search_datas);
        $datas['total_count']=$total_advanced_search_count;
        $datas['inputs']=$this->input->post();
        // echo $occupation;
        echo $this->load->view('app/active_search_load',$datas,true);
        
         
    }







    public function match_seach_list()
    {
       
       if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        // print_r(member_permission());exit;

        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        if($member->gender==1){
            $gender=2;
        }else{
            $gender=1;
        }

        $per_page=5;
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $age_from=$this->input->post('aged_from');
        $age_to=$this->input->post('aged_to');
        $height_from=$this->input->post('min_height');
        $height_to=$this->input->post('max_height_');
        $marital_status=$this->input->post('marital_status');
        $occupation=$this->input->post('Type_of_occupation');
        $father_vangusam   = $this->input->post('father_vangusam');
        $member_profile_id   = $this->input->post('member_id');
        $star   = $this->input->post('star');
        $dosham   = $this->input->post('dosham');
        $Soveran_Details   = $this->input->post('Soveran_Details');
        $Type_of_study   = $this->input->post('Type_of_study');
        
        $aged_from = (int)$this->input->post('aged_from') - 1;
        $sql_aged_from = "";
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->input->post('aged_to');
        $sql_aged_to = '';
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        $min_height = "";
        $max_height = "";
        if($this->input->post('min_height')>=0) 
        {
            $min_height = $this->input->post('min_height');
        }
        if($this->input->post('max_height')>=0) 
        {
            $max_height = $this->input->post('max_height');
        }
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        
            $search_member_type = $this->input->post('search_member_type');
       // print_r($this->input->post());exit;
        $session_data=array(
            'age_from'=>$age_from,
            'age_to'=>$age_to,
            'height_from'=>$min_height,
            'height_to'=>$max_height,           
            'marital_status'=>$marital_status,
            'occupation'=>$occupation,
            'father_vangusam'=>$father_vangusam,
            'member_profile_id'=>$member_profile_id,
            'gender'=>$gender,
            'star'=>$star,
            'dosham'=>$dosham,
            'Soveran_Details'=>$Soveran_Details,
            'Type_of_study'=>$Type_of_study,
            
            );
        // print_r($session_data);exit;
        

        $this->session->set_userdata('adv_search', $session_data);


        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }
        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }


        $expectation = json_decode($member->partner_expectation);
            $exist = 0;
            $partner_age=$partner_height=$partner_weight=$with_children_acceptables=$partner_any_disability=$partner_marital_status=$partner_education=$partner_body_type=$partner_DOSHAM=$partner_TYPE_OF_DOSHAM=$partner_Other_Dosham=$partner_Expectation=$partner_Other_Expectation="";
            if(!empty($expectation[0]->partner_age) && isset($expectation[0]->partner_age))
            {

                $partner_age = $expectation[0]->partner_age;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_height) && isset($expectation[0]->partner_height))
            {

                $partner_height = $expectation[0]->partner_height;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_weight) && isset($expectation[0]->partner_weight))
            {

                $partner_weight = $expectation[0]->partner_weight;
                $exist = 1;
            }
            if(!empty($expectation[0]->with_children_acceptables) && isset($expectation[0]->with_children_acceptables))
            {

                $with_children_acceptables = $expectation[0]->with_children_acceptables;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_any_disability) && isset($expectation[0]->partner_any_disability))
            {

                $partner_any_disability = $expectation[0]->partner_any_disability;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_marital_status) && isset($expectation[0]->partner_marital_status))
            {

                $partner_marital_status = $expectation[0]->partner_marital_status;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_education) && isset($expectation[0]->partner_education))
            {

                $partner_education = $expectation[0]->partner_education;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_body_type) && isset($expectation[0]->partner_body_type))
            {

                $partner_body_type = $expectation[0]->partner_body_type;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_DOSHAM) && isset($expectation[0]->partner_DOSHAM))
            {

                $partner_DOSHAM = $expectation[0]->partner_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_TYPE_OF_DOSHAM) && isset($expectation[0]->partner_TYPE_OF_DOSHAM))
            {

                $partner_TYPE_OF_DOSHAM = $expectation[0]->partner_TYPE_OF_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_Other_Dosham) && isset($expectation[0]->partner_Other_Dosham))
            {

                $partner_Other_Dosham = $expectation[0]->partner_Other_Dosham;
                $exist = 1;
            }
            if (!empty($partner_age)) {
                $from_year = date('Y') - $partner_age;
                $from_date = $from_year."-01-01";
                $partner_age = strtotime($from_date);
            }
            
            $datas['results'] ="";
            $datas['total_data'] ="";
            $advanced_search_datas= array();
            $total_search_datas = array();
            if($exist==1)
            {
            $total_search_datas = $this->AppModel->get_advanced_matchsearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids);

            $advanced_search_datas = $this->AppModel->get_advanced_matchsearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids,10);
            }



        // print_r($ignored_by_ids);exit;
        // print_r($session_data);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($father_vangusam);

        // $total_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids);
        // $advanced_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,5);
        // print_r(count($total_search_datas));
         // print_r($advanced_search_datas);exit;
        $datas['results']=$advanced_search_datas;
        $datas['total_count']=count($total_search_datas);
        $datas['total_data']=count($total_search_datas);

        $this->template['middle']=$this->load->view($this->middle='app/match_search/match_search_result',$datas,true);
        $this->getAppLayout(); 
        
         
    }

    public function match_search_more()
    {
        $view_id = $this->input->get('id');
       if($this->member_permission() == FALSE){

            redirect('app/login');
        }
        // print_r($this->input->post());exit;

        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $member = $this->AppModel->getMemberData('member','row',array('member_id'=>$member_id));
        if($member->gender==1){
            $gender=2;
        }else{
            $gender=1;
        }

        $per_page=5;
        $login_user_data=$this->LoginModel->get_login_user_datas($member_id);
        $age_from=$this->input->post('aged_from');
        $age_to=$this->input->post('aged_to');
        $height_from=$this->input->post('min_height');
        $height_to=$this->input->post('max_height_');
        $marital_status=$this->input->post('marital_status');
        $occupation=$this->input->post('Type_of_occupation');
        $father_vangusam   = $this->input->post('father_vangusam');
        $member_profile_id   = $this->input->post('member_id');
        $star   = $this->input->post('star');
        $dosham   = $this->input->post('dosham');
        $Soveran_Details   = $this->input->post('Soveran_Details');
        $Type_of_study   = $this->input->post('Type_of_study');
        
        $aged_from = (int)$this->input->post('aged_from') - 1;
        $sql_aged_from = "";
        if (!empty($aged_from)) {
            $from_year = date('Y') - $aged_from;
            $from_date = $from_year."-01-01";
            $sql_aged_from = strtotime($from_date);
        }

        $aged_to = $this->input->post('aged_to');
        $sql_aged_to = '';
        if (!empty($aged_to)) {
            $to_year = date('Y') - $aged_to;
            $to_date = $to_year."-01-01";
            $sql_aged_to = strtotime($to_date);
        }
        $min_height = "";
        $max_height = "";
        if($this->input->post('min_height')>=0) 
        {
            $min_height = $this->input->post('min_height');
        }
        if($this->input->post('max_height')>=0) 
        {
            $max_height = $this->input->post('max_height');
        }
        $memberplan = $this->AppModel->getMemberPlan($member_id);
        $soveran = 25;
        if(!empty($memberplan)){
            $plan = $this->AppModel->getPlan($memberplan->plan_id);
            $soveran = $plan->soveran;
        }
        
            $search_member_type = $this->input->post('search_member_type');
       


        $ignored_ids = get_type_name_by_id('member', $member_id, 'ignored');
        $ignored_ids = json_decode($ignored_ids, true);
        $ignored_by_ids = get_type_name_by_id('member', $member_id, 'ignored_by');
        $ignored_by_ids = json_decode($ignored_by_ids, true);
        if (empty($ignored_by_ids)) {
            array_push($ignored_by_ids, 0);
        }
        if (empty($ignored_ids)) {
            array_push($ignored_ids, 0);
        }
        


        $expectation = json_decode($member->partner_expectation);
            $exist = 0;
            $partner_age=$partner_height=$partner_weight=$with_children_acceptables=$partner_any_disability=$partner_marital_status=$partner_education=$partner_body_type=$partner_DOSHAM=$partner_TYPE_OF_DOSHAM=$partner_Other_Dosham=$partner_Expectation=$partner_Other_Expectation="";
            if(!empty($expectation[0]->partner_age) && isset($expectation[0]->partner_age))
            {

                $partner_age = $expectation[0]->partner_age;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_height) && isset($expectation[0]->partner_height))
            {

                $partner_height = $expectation[0]->partner_height;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_weight) && isset($expectation[0]->partner_weight))
            {

                $partner_weight = $expectation[0]->partner_weight;
                $exist = 1;
            }
            if(!empty($expectation[0]->with_children_acceptables) && isset($expectation[0]->with_children_acceptables))
            {

                $with_children_acceptables = $expectation[0]->with_children_acceptables;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_any_disability) && isset($expectation[0]->partner_any_disability))
            {

                $partner_any_disability = $expectation[0]->partner_any_disability;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_marital_status) && isset($expectation[0]->partner_marital_status))
            {

                $partner_marital_status = $expectation[0]->partner_marital_status;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_education) && isset($expectation[0]->partner_education))
            {

                $partner_education = $expectation[0]->partner_education;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_body_type) && isset($expectation[0]->partner_body_type))
            {

                $partner_body_type = $expectation[0]->partner_body_type;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_DOSHAM) && isset($expectation[0]->partner_DOSHAM))
            {

                $partner_DOSHAM = $expectation[0]->partner_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_TYPE_OF_DOSHAM) && isset($expectation[0]->partner_TYPE_OF_DOSHAM))
            {

                $partner_TYPE_OF_DOSHAM = $expectation[0]->partner_TYPE_OF_DOSHAM;
                $exist = 1;
            }
            if(!empty($expectation[0]->partner_Other_Dosham) && isset($expectation[0]->partner_Other_Dosham))
            {

                $partner_Other_Dosham = $expectation[0]->partner_Other_Dosham;
                $exist = 1;
            }
            if (!empty($partner_age)) {
                $from_year = date('Y') - $partner_age;
                $from_date = $from_year."-01-01";
                $partner_age = strtotime($from_date);
            }
            $total_advanced_search_count="";
            $datas['results'] ="";
            $datas['total_data'] ="";
            $datas['total_count'] ="";
            $total_advanced_search_datas= array();
            $advanced_search_datas = array();
            if($exist==1)
            {
            $total_advanced_search_datas = $this->AppModel->get_advanced_matchsearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids,'',$view_id);

            $advanced_search_datas = $this->AppModel->get_advanced_matchsearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids,10,$view_id);
            }

        // print_r($session_data);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_search_datas_old($father_vangusam);
        
        // $total_advanced_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,$view_id);
        // // print_r($total_advanced_search_datas);exit;
        // $advanced_search_datas=$this->AppModel->get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$min_height,$max_height,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,5,$view_id);
        $datas['results']=$advanced_search_datas;
        $datas['total_data']=count($total_advanced_search_datas);
        $datas['total_count']=$total_advanced_search_count;
        $datas['inputs']=$this->input->post();
        // echo $occupation;
        echo $this->load->view('app/match_search/match_search_load',$datas,true);
        
         
    }







    public function planDetails()
        {
            $userId = $this->session->userdata('thirumanam_applogged_data')['member_id'];
            $meta_value_id=$this->input->post('m_id');
            $value = $this->AppModel->getPlan($meta_value_id);
            $language=getLanguage();

             $info_msg = $value->info;
             $info_msgs = json_decode($info_msg, true);
             if ($language=='tamil') {
                $message = $info_msgs[0]['tamil'];
             }
             else
             {
                 $message = $info_msgs[0]['english'];  
             }
            // print_r(translate('member_notifications'));exit;
            echo'
    <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!--<p class="text-center"><b>'.$message.'</b></p>-->
            <!--<p class="text-center"><b>Please, Contact Administrator.. Note: online payment Temporarily disabled. sorry for the inconvenience...</b></p>-->
            <p class="text-center"><b>Scan the QR code for payment. After completion, please call and share transaction details.</b></p>
            <img src="'.base_url('assets/front/images/payment_scanner.png').'" style="margin-left:0">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
            <!--<a  href="'.base_url('AppController/submitPayment/'.$userId.'/'.$value->amount.'/'.$value->plan_id).'" type="button" class="btn btn-primary">'.translate('confirm').'</a>-->
          </div>
        </div>
      </div>
    </div>

    ';
      }

      public function confirm_message()
    {
        $rem_message = get_type_name_by_id('member', $this->session->userdata('thirumanam_applogged_data')['member_id'], 'direct_messages');

        $meta_value_id=$this->input->post('m_id');
        
        echo'
            <div class="modal fade" id="myModal'.$meta_value_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLongTitle">'.translate('confirm_enable_messaging').'</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p class="text-center"><b><?php echo translate("remaining_direct_message(s):"");?>'.$rem_message.''.translate("times").'</b><br><span style="color:#DC0330;font-size:11px">**N.B. '.translate("enable_messaging_will_cost_1_from_your_remaining_direct_messages").'**</span></p>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">'.translate('close').'</button>
                <a href="'.base_url('AppController/enableMessage/'.$meta_value_id).'" type="button" class="btn btn-primary">'.translate('confirm').'</a>
              </div>
            </div>
            </div>
            </div>';
  }

  public function enableMessage($member_id)
    {


        $member = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $direct_messages = get_type_name_by_id('member', $member, 'direct_messages');
         // print_r($direct_messages);exit;
        if ($direct_messages > 0) {
            $data['message_thread_from'] = $member;
            $data['message_thread_to'] = $member_id;
            $data['message_thread_time'] = time();
            $this->db->insert('message_thread', $data);

            // Subtracting a Direct Message
            $direct_messages = $direct_messages - 1;
            $this->db->where('member_id', $member);
            $this->db->update('member', array('direct_messages' => $direct_messages));
        $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_have_enable_messaging_with_this_member!')));
        redirect('app/full_view/'.$member_id);
        }

    }


public function get_city_of_state_ajax_app()
    {
        $state_id=$this->input->get('state_id');
        $result=$this->AppModel->getCitiesofState($state_id);
        // print_r($result);exit();
        $html='';

        if(empty($result)){
            $html.='<option>No Data Found</option>';
        }
        else
        {
            foreach ($result as $value) {

                $html.='<option value="'.$value->word.'">'.dropdownTranslate($value->word).'</option>';   
            }            
        }

        echo $html;
        
    }

    function deleteView($id,$type)
    {
        $this->AppModel->updateMemberDatas('view_profile_management',array('id'=>$id),array('status'=>1));

        if($type==1)
        {
            $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_deleted_this_view_member!')));
            redirect('app/viewlist');
        }else
        {
            $this->session->set_flashdata('login_msg',getappAlert('success',translate('you_deleted_this_viewed_member!')));
            redirect('app/profile_viewer_details');
        }
    }

  }