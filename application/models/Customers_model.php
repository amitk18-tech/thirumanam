<?php
class Customers_model extends CI_Model 
{
	public function __construct()
  {
     	parent::__construct();
  }

  public function get_all_memberdatas()
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result();
     return $query;
  }
  public function get_all_memberdatasarray()
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result_array();
     return $query;
  }

  public function get_single_member($id)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('member_id',$id);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->row();
     return $query;
  }


    public function get_single_members($data)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('member_id',$data);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->row();
     return $query;
  }

  public function get_currentplan($id,$date_validity)
  {
      $this->db->select('*');
      $this->db->from('package_payment');
      $this->db->where('payment_status','paid');
      $this->db->where('member_id',$id);
      $this->db->where('payment_timestamp',$date_validity);
      $this->db->order_by('package_payment_id','DESC');
      $this->db->limit(1);
      $query=$this->db->get()->row();
      return $query;
  }
   public function get_payment_detail($member_id,$date_validity)
  {
      $this->db->select('*');
      $this->db->from('package_payment');
      $this->db->where('member_id',$member_id);
      $this->db->where('payment_timestamp>=',$date_validity);
      $query=$this->db->get()->row();
      return $query;
  }
  public function get_plan()
  {
      $this->db->select('*');
      $this->db->from('plan');
      $this->db->where('active_status',1);
      $this->db->where('delete_status',0);
      $query=$this->db->get()->result();
      return $query;
  }
  public function planDetails($plan_id)
  {
      $this->db->select('*');
      $this->db->from('plan');
      $this->db->where('plan_id',$plan_id);
      $this->db->where('delete_status',0);
      $query=$this->db->get()->row();
      return $query;
  }
 
  public function updateInfo($table,$data,$where)
  {
      $this->db->where($where);
      $this->db->update($table,$data);
      // echo $this->db->last_query();exit;
  }

  public function get_singlemember($data)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('member_profile_id',$data);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->row_array();
     return $query;
  }

  public function get_martial_status()
  {
     $this->db->select('*');
     $this->db->from('marital_status');
     $query=$this->db->get()->result();
     return $query;
  }
  public function get_states()
  {
     $this->db->select('*');
     $this->db->from('all_states');
     $this->db->limit(41);
     $query=$this->db->get()->result();
     return $query;
  }
  public function get_cities()
  {
     $this->db->select('*');
     $this->db->from('city');
     $query=$this->db->get()->result();
     return $query;
  }
   public function getCitiesofState($state_id)
   {
      $this->db->select('*');
      $this->db->from('all_cities');
      $this->db->where('state_id',$state_id);      
      $result=$this->db->get()->result();
      return $result;
   }
   public function getTemplates($id)
   {
      $this->db->select('*');
      $this->db->from('email_templates');
      $this->db->where('id',$id);      
      $result=$this->db->get()->result();
      return $result;
   }
   public function getmembershipData()
   {
      $this->db->select('*');
      $this->db->from('plan');        
      $result=$this->db->get()->result();
      return $result;
   }

   public function update_single_member($table,$id,$data)
   {
      $this->db->where('member_id',$id);
      $this->db->update($table,$data);
   }
   public function delete_single_member($table,$id)
   {
      $this->db->where('member_id',$id);
      $this->db->delete($table);
   }
   public function block_single_member($table,$id,$data)
   {
      $this->db->where('member_id',$id);
      $this->db->update($table,$data);
   }
   public function add_info($table,$data)
   {
      $this->db->insert($table,$data);
      $insert_id=$this->db->insert_id();
      return $insert_id;
   }
   public function update_member($table,$id,$data)
   {
      $this->db->where('member_id',$id);
      return $this->db->update($table,$data);

   }
   public function delete_member($table,$id)
   {
      $this->db->where('member_id',$id);
      $this->db->delete($table);

   }
   public function update_block($table,$id,$data)
   {
      $this->db->where('blocked_member_id',$id);
      return $this->db->update($table,$data);

   }
   public function update_close($table,$id,$data)
   {
      $this->db->where('member_id',$id);
      return $this->db->update($table,$data);

   }
   public function update_report_member($table,$id,$data)
   {
      $this->db->where($id);
      $this->db->update($table,$data);
   }
   public function getstoryDatas($id)
    {
        $this->db->select('happy_story.*,member.*,story_video.*');
        $this->db->from('happy_story');
        $this->db->join('member','member.member_id = happy_story.posted_by','left');
        $this->db->join('story_video','story_video.story_id = happy_story.happy_story_id ','left');
        $this->db->where('happy_story.active_status',1);
        $this->db->where('happy_story.delete_status',0);
        $this->db->where('happy_story.happy_story_id',$id);
        $this->db->limit(50); 
        $query=$this->db->get()->row();
        return $query;
    }
    public function getData($table,$result,$where)
   {
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where($where);
      $this->db->where("delete_status",0);      
      $result=$this->db->get()->$result();
      return $result;
   }
    public function getfaqData($table,$result,$where)
   {
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where($where);      
      $result=$this->db->get()->$result();
      return $result;
   }
  
   

   public function getDatas($table,$result)
   {
      $this->db->select('*');
      $this->db->from($table);
      $this->db->where("delete_status",0);     
      $result=$this->db->get()->$result();
      return $result;
   }
   
public function sendSms($mobile,$smsBody){
    
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.smsgatewayhub.com/api/mt/SendSms?APIKey=oU1GjEXUgUOX8W0uoTB3GQ&senderid=SSANPM&channel=2&DCS=0&flashsms=0&number=".$mobile."&text=".rawurlencode($smsBody)."&route=1",CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => false,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,CURLOPT_CUSTOMREQUEST => "POST",));
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Length: 0'));
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
//     print_r($response);die;
if ($err) {
return 0;
} 
else {
return 1;
}


}
    public function getOnlineDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOfflineDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',2);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0); 
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    function reportTotal($filterBy= "",$from_date="",$to_date="",$gender="")
    {
        if($filterBy == "online") {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline") {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed") {
            $this->db->where('is_closed','yes');            
        }
        if ($from_date!='')
        {
            $this->db->where('member_since >=',$from_date);
        }
        if ($to_date!='')
        {
            $this->db->where('member_since <=',$to_date);
        }
        if ($gender!='')
        {
        $this->db->where('gender',$gender);
        }
        $this->db->order_by("member_id","desc");
        // $this->db->where('active_status',1);
        $this->db->where('delete_status',0); 
        $this->db->where('deactivate_status',0);
        $query = $this->db->get('member')->result();
        return $query;
    }
    function reportTotalchart($filterBy= "",$from_date="")
    {
        if($filterBy == "online") {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline") {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed") {
            $this->db->where('is_closed','yes');            
        }
        
        $this->db->where("DATE_FORMAT(member_since,'%Y-%m')", $from_date);
        
        // $this->db->order_by("member_id","desc");
        // $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0); 
        // echo $this->db->last_query(); exit;
        $query = $this->db->get('member')->result();
        return $query;
    }
    function activereportTotalchart($filterBy= "",$from_date="")
    {
        if($filterBy == "online") {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline") {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed") {
            $this->db->where('is_closed','yes');            
        }
        
        $this->db->where("DATE_FORMAT(member_since,'%Y-%m')", $from_date);
        
        // $this->db->order_by("member_id","desc");
        // $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        $this->db->where('updateProfileDoneStatus',1);  
        // echo $this->db->last_query(); exit;
        $query = $this->db->get('member')->result();
        return $query;
    }

    function inactivereportTotalchart($filterBy= "",$from_date="")
    {
        if($filterBy == "online") {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline") {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed") {
            $this->db->where('is_closed','yes');            
        }
        
        $this->db->where("DATE_FORMAT(member_since,'%Y-%m')", $from_date);
        
        // $this->db->order_by("member_id","desc");
        // $this->db->where('active_status',1);
        // $this->db->where('delete_status',0);
        $this->db->where("membership_date <= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        // $this->db->where('membership_date',NULL);
        // $this->db->where('updateProfileDoneStatus',1);  
        // echo $this->db->last_query(); exit;
        $query = $this->db->get('member')->result();
        return $query;
    }

    function earningreportTotalchart($from_date="")
    {
        
        
        $this->db->where("payment_timestamp", $from_date);
        $this->db->where('payment_status','paid');
        // $this->db->where('updateProfileDoneStatus',1);  
        // echo $this->db->last_query(); exit;
        $query = $this->db->get('package_payment')->result();
        return $query;
    }

   

    function reportsTotal($filterBy= "",$from_date="",$to_date="")
    {
        if($filterBy == "online") {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline") {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed") {
            $this->db->where('is_closed','yes');            
        }
        if ($from_date!='')
        {
            $this->db->where('member_since >=',$from_date);
        }
        if ($to_date!='')
        {
            $this->db->where('member_since <=',$to_date);
        }
        $this->db->order_by("member_id","desc");
        // $this->db->where('active_status',1);
        $this->db->where('delete_status',0); 
        $this->db->where('deactivate_status',0); 
        $query = $this->db->get('member')->result();
        return $query;
    }
    function allReportmembers($limit,$start,$col,$dir,$filterBy = "",$from_date="",$to_date="")
    {       
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);

        if($filterBy == "online")
        {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline")
        {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed")
        {
            $this->db->where('is_closed','yes');            
        }
        if ($from_date!='')
        {
            $this->db->where('member_since >=',$from_date);
        }
        if ($to_date!='')
        {
            $this->db->where('member_since <=',$to_date);
        }
         $this->db->order_by("member_id","desc");  
         $this->db->where('deactivate_status',0);       
        $query = $this->db->get('member');
            
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }
    }

    function reports_members_search($limit,$start,$search,$col,$dir,$filterBy = "",$from_date="",$to_date="")
    {
        $this->db->limit($limit,$start);
        $this->db->order_by($col,$dir);
       
        if($filterBy == "online")
        {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline")
        {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed")
        {
            $this->db->where('is_closed','yes');            
        }
        if ($from_date!='')
        {
            $this->db->where('member_since >=',$from_date);
        }
        if ($to_date!='')
        {
            $this->db->where('member_since <=',$to_date);
        }            
        
        $this->db->order_by("member_id","desc");
        // $this->db->where('is_blocked','no');
        $this->db->where("(member_id LIKE '%$search%' OR mobile LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR member_profile_id LIKE '%$search%' OR member_since LIKE '%$search%')");
        $query = $this->db->get('member');
        $this->db->where('deactivate_status',0);
        if($query->num_rows()>0)
        {
            return $query->result();
        }
        else
        {
            return null;
        }
    }

    function reports_members_search_count($search,$filterBy = "",$from_date="",$to_date="")
    {
        if($filterBy == "online")
        {
            $this->db->where('member_type',1);
        }
        if($filterBy == "offline")
        {
            $this->db->where('member_type',2);
        }
        if($filterBy == "closed")
        {
            $this->db->where('is_closed','yes');            
        }
        if ($from_date!='')
        {
            $this->db->where('member_since >=',$from_date);
        }
        if ($to_date!='')
        {
            $this->db->where('member_since <=',$to_date);
        }
        $this->db->order_by("member_id","desc");
        // $this->db->where('is_blocked','no');
        $this->db->where("(member_id LIKE '%$search%' OR mobile LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR member_profile_id LIKE '%$search%' OR member_since LIKE '%$search%')");
        $query = $this->db->get('member');
        $this->db->where('deactivate_status',0);
        return $query->num_rows();
    }

    public function getMemDatas($table,$mobile,$gender="",$phoneOtp="",$result="")
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('mobile',$mobile);
        if(!empty($gender)){
            $this->db->where('gender',$gender);
        }
        if(!empty($phoneOtp)){
            $this->db->where('phoneOtp',$phoneOtp);
        }
        $this->db->where('delete_status',0); 
        $this->db->where('deactivate_status',0);
        $data=$this->db->get()->row();
        //echo $this->db->last_query(); exit;
        return $data;
    }

    public function ifIntroUpdateorNot($member_id,$data){

        $member = get_allmembers($member_id);
        // print_r($data); echo '<br>';
        // print_r($member->partner_expectation);exit;
        $return_data="";
        if(!empty($member))
        {
            if($member->introduction!=$data['introduction'])
            {
                $return_data.=' Introduction('.$member->introduction.' -to- '.$data['introduction'].')';
            }
            
        }

        return $return_data;
    }

    public function ifBasicUpdateorNot($member_id,$data){

        $member = get_allmembers($member_id);
        $return_data="";
        if(!empty($member))
        {
        if(!empty($member->basic_info))
        {
            $basic_info = json_decode($member->basic_info);
            if(!empty($basic_info))
            {
                foreach($basic_info as $value)
                {

                    if(isset($value->marital_status))
                    {
                        if($value->marital_status!=$data['marital_status'])
                        {
                            $return_data.=' Martial Status('.$value->marital_status.' -to- '.$data['marital_status'].')';
                        }

                    }else
                    {
                        $return_data.=' Martial Status( -to- '.$data['marital_status'].')';
                    }
                    if(isset($value->number_of_children))
                    {
                        if($value->number_of_children!=$data['number_of_children'])
                        {


                            $return_data.=' Number Of Children('.$value->number_of_children.' -to- '.$data['number_of_children'].')';
                        }
                    }else
                    {
                        $return_data.=' Number Of Children( -to- '.$data['number_of_children'].')';
                    }
                    if(isset($value->Child_living_place))
                    {
                        if($value->Child_living_place!=$data['Child_living_place'])
                        {
                            $return_data.=' Child Living Place('.$value->Child_living_place.' -to- '.$data['Child_living_place'].')';
                        }
                    }else
                    {
                         $return_data.=' Child Living Place( -to- '.$data['Child_living_place'].')';
                    }

                }
            }
            }
            if($member->first_name!=$data['first_name'])
            {
                $return_data.=' Name('.$member->first_name.' -to- '.$data['first_name'].')';
            }
            if($member->email!=$data['email'])
            {
                $return_data.=' Email('.$member->email.' -to- '.$data['email'].')';
            }
        }

        return $return_data;
    }

    public function ifEducationUpdateorNot($member_id,$data){



        $member = get_allmembers($member_id);
        $return_data="";
         // print_r($data); echo '<br>';
         // print_r($member->education_and_career);exit;
        if(!empty($member))
        {
        if(!empty($member->education_and_career))
        {
            $education_and_career = json_decode($member->education_and_career);
            if(!empty($education_and_career))
            {
                foreach($education_and_career as $value)
                {

                    if(isset($value->Type_of_study))
                    {
                        if($value->Type_of_study!=$data['Type_of_study'])
                        {
                            $return_data.=' Type Of Study('.$value->Type_of_study.' -to- '.$data['Type_of_study'].')';
                        }
                    }
                    else
                    {
                         $return_data.=' Type Of Study( -to- '.$data['Type_of_study'].')';
                    }

                    if(isset($value->other_study))
                    {
                        if($value->other_study!=$data['other_study'])
                        {


                            $return_data.=' Other Study('.$value->other_study.' -to- '.$data['other_study'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Study( -to- '.$data['other_study'].')';
                    }

                    if(isset($value->STUDY_DETAILS))
                    {
                        if($value->STUDY_DETAILS!=$data['STUDY_DETAILS'])
                        {
                            $return_data.=' Study Details('.$value->STUDY_DETAILS.' -to- '.$data['STUDY_DETAILS'].')';
                        }
                    }else
                    {
                        $return_data.=' Study Details( -to- '.$data['STUDY_DETAILS'].')';
                    }

                    if(isset($value->Type_of_occupation))
                    {
                        if($value->Type_of_occupation!=$data['Type_of_occupation'])
                        {
                            $return_data.=' Type Of Occupation('.$value->Type_of_occupation.' -to- '.$data['Type_of_occupation'].')';
                        }
                    }else
                    {
                        $return_data.=' Type Of Occupation( -to- '.$data['Type_of_occupation'].')';
                    }
                    if(isset($value->Other_Occupation_Details))
                    {
                        if($value->Other_Occupation_Details!=$data['Other_Occupation_Details'])
                        {
                            $return_data.=' Other Occupation Details('.$value->Other_Occupation_Details.' -to- '.$data['Other_Occupation_Details'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Occupation Details( -to- '.$data['Other_Occupation_Details'].')';
                    }
                    if(isset($value->Career_Profile))
                    {
                        if($value->Career_Profile!=$data['Career_Profile'])
                        {
                            $return_data.=' Career Profile('.$value->Career_Profile.' -to- '.$data['Career_Profile'].')';
                        }
                    }else
                    {
                        $return_data.=' Career Profile( -to- '.$data['Career_Profile'].')';
                    }
                    if(isset($value->Earnings))
                    {
                        if($value->Earnings!=$data['Earnings'])
                        {
                            $return_data.=' Earnings('.$value->Earnings.' -to- '.$data['Earnings'].')';
                        }
                    }else
                    {
                        $return_data.=' Earnings( -to- '.$data['Earnings'].')';
                    }
                    if(isset($value->annual_income))
                    {
                        if($value->annual_income!=$data['annual_income'])
                        {
                            $return_data.=' Career Profile('.$value->annual_income.' -to- '.$data['annual_income'].')';
                        }
                    }else
                    {
                        $return_data.=' Career Profile( -to- '.$data['annual_income'].')';
                    }

                }
            }
            }
            
        }

        
        return $return_data;
    }


    public function ifPhysicalUpdateorNot($member_id,$data){



        $member = get_allmembers($member_id);
        $return_data="";
         // print_r($data); echo '<br>';
         // print_r($member->physical_attributes);exit;
        if(!empty($member))
        {
        if(!empty($member->physical_attributes))
        {
            $physical_attributes = json_decode($member->physical_attributes);
            if(!empty($physical_attributes))
            {
                foreach($physical_attributes as $value)
                {

                    if(isset($value->height))
                    {
                        if($value->height!=$data['height'])
                        {
                            $return_data.=' Height('.$value->height.' -to- '.$data['height'].')';
                        }
                    }elseif(!empty($member->height))
                    {
                        if($member->height!=$data['height'])
                        {
                            $return_data.=' Height('.$member->height.' -to- '.$data['height'].')';
                        }
                    }else
                    {
                        $return_data.=' Height( -to- '.$data['height'].')';
                    }
                    if(isset($value->weight))
                    {
                        if($value->weight!=$data['weight'])
                        {


                            $return_data.=' weight('.$value->weight.' -to- '.$data['weight'].')';
                        }
                    }else
                    {
                         $return_data.=' weight( -to- '.$data['weight'].')';
                    }
                    if(isset($value->eye_color))
                    {
                        if($value->eye_color!=$data['eye_color'])
                        {
                            $return_data.=' Eye Color('.$value->eye_color.' -to- '.$data['eye_color'].')';
                        }
                    }else
                    {
                         $return_data.=' Eye Color( -to- '.$data['eye_color'].')';
                    }
                    if(isset($value->hair_color))
                    {
                        if($value->hair_color!=$data['hair_color'])
                        {
                            $return_data.=' Hair Color('.$value->hair_color.' -to- '.$data['hair_color'].')';
                        }
                    }else
                    {
                        $return_data.=' Hair Color( -to- '.$data['hair_color'].')';
                    }
                     if(isset($value->complexion))
                    {
                        if($value->complexion!=$data['complexion'])
                        {
                            $return_data.=' Complexion('.$value->complexion.' -to- '.$data['complexion'].')';
                        }
                    }else
                    {
                        $return_data.=' Complexion( -to- '.$data['complexion'].')';
                    }
                     if(isset($value->blood_group))
                    {
                        if($value->blood_group!=$data['blood_group'])
                        {
                            $return_data.=' Blood Group('.$value->blood_group.' -to- '.$data['blood_group'].')';
                        }
                    }else
                    {
                        $return_data.=' Blood Group( -to- '.$data['blood_group'].')';
                    }
                     if(isset($value->body_type))
                    {
                        if($value->body_type!=$data['body_type'])
                        {
                            $return_data.=' Body Type('.$value->body_type.' -to- '.$data['body_type'].')';
                        }
                    }else
                    {
                        $return_data.=' Body Type( -to- '.$data['body_type'].')';
                    }
                    if(isset($value->body_art))
                    {
                        if($value->body_art!=$data['body_art'])
                        {
                            $return_data.=' Body Art('.$value->body_art.' -to- '.$data['body_art'].')';
                        }
                    }else
                    {
                        $return_data.=' Body Art( -to- '.$data['body_art'].')';
                    }
                    if(isset($value->any_disability))
                    {
                        if($value->any_disability!=$data['any_disability'])
                        {
                            $return_data.=' Any Disability('.$value->any_disability.' -to- '.$data['any_disability'].')';
                        }
                    }else
                    {
                        $return_data.=' Any Disability( -to- '.$data['any_disability'].')';
                    }

                }
            }
            }
            
        }
        
        return $return_data;
    }



    public function ifAstronomicUpdateorNot($member_id,$data){



        $member = get_allmembers($member_id);
        $return_data="";
         // print_r($data); echo '<br>';
         // print_r($member->astronomic_information);exit;
        if(!empty($member))
        {
        if(!empty($member->astronomic_information))
        {
            $astronomic_information = json_decode($member->astronomic_information);
            if(!empty($astronomic_information))
            {
                foreach($astronomic_information as $value)
                {

                    if(isset($value->date_of_birth))
                    {
                        if($value->date_of_birth!=$data['date_of_birth'])
                        {
                            $return_data.=' Date Of Birth('.$value->date_of_birth.' -to- '.$data['date_of_birth'].')';
                        }
                    }else
                    {

                            $return_data.=' Date Of Birth( -to- '.$data['date_of_birth'].')';
                        
                    }
                    if(isset($value->time_of_birth))
                    {
                        if($value->time_of_birth!=$data['time_of_birth'])
                        {


                            $return_data.=' Time Of Birth('.$value->time_of_birth.' -to- '.$data['time_of_birth'].')';
                        }
                    }else
                    {
                         $return_data.=' Time Of Birth( -to- '.$data['time_of_birth'].')';
                    }
                    if(isset($value->city_of_birth))
                    {
                        if($value->city_of_birth!=$data['city_of_birth'])
                        {
                            $return_data.=' City Of Birth('.$value->city_of_birth.' -to- '.$data['city_of_birth'].')';
                        }
                    }else
                    {
                         $return_data.=' City Of Birth( -to- '.$data['city_of_birth'].')';
                    }
                    if(isset($value->PAKSHA))
                    {
                        if($value->PAKSHA!=$data['PAKSHA'])
                        {
                            $return_data.=' Paksha('.$value->PAKSHA.' -to- '.$data['PAKSHA'].')';
                        }
                    }else
                    {
                        $return_data.=' Paksha( -to- '.$data['PAKSHA'].')';
                    }
                     if(isset($value->Other_Paksha))
                    {
                        if($value->Other_Paksha!=$data['Other_Paksha'])
                        {
                            $return_data.=' Other Paksha('.$value->Other_Paksha.' -to- '.$data['Other_Paksha'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Paksha( -to- '.$data['Other_Paksha'].')';
                    }
                     if(isset($value->star))
                    {
                        if($value->star!=$data['star'])
                        {
                            $return_data.=' Star('.$value->star.' -to- '.$data['star'].')';
                        }
                    }else
                    {
                        $return_data.=' Star( -to- '.$data['star'].')';
                    }
                     if(isset($value->PADAM))
                    {
                        if($value->PADAM!=$data['PADAM'])
                        {
                            $return_data.=' Padam('.$value->PADAM.' -to- '.$data['PADAM'].')';
                        }
                    }else
                    {
                        $return_data.=' Padam( -to- '.$data['PADAM'].')';
                    }
                    if(isset($value->LAKKNAM))
                    {
                        if($value->LAKKNAM!=$data['LAKKNAM'])
                        {
                            $return_data.=' Laknam('.$value->LAKKNAM.' -to- '.$data['LAKKNAM'].')';
                        }
                    }else
                    {
                        $return_data.=' Laknam( -to- '.$data['LAKKNAM'].')';
                    }
                    if(isset($value->HOROSCOPE_MATCHING))
                    {
                        if($value->HOROSCOPE_MATCHING!=$data['HOROSCOPE_MATCHING'])
                        {
                            $return_data.=' Horoscope Matching('.$value->HOROSCOPE_MATCHING.' -to- '.$data['HOROSCOPE_MATCHING'].')';
                        }
                    }else
                    {
                        $return_data.=' Horoscope Matching( -to- '.$data['HOROSCOPE_MATCHING'].')';
                    }

                    if(isset($value->TITHI))
                    {
                        if($value->TITHI!=$data['TITHI'])
                        {
                            $return_data.=' Tithi('.$value->TITHI.' -to- '.$data['TITHI'].')';
                        }
                    }else
                    {
                        $return_data.=' Tithi( -to- '.$data['TITHI'].')';
                    }

                    if(isset($value->DOSHAM))
                    {
                        if($value->DOSHAM!=$data['DOSHAM'])
                        {
                            $return_data.=' Dosham('.$value->DOSHAM.' -to- '.$data['DOSHAM'].')';
                        }
                    }else
                    {
                        $return_data.=' Dosham( -to- '.$data['DOSHAM'].')';
                    }

                    if(isset($value->TYPE_OF_DOSHAM))
                    {
                        if($value->TYPE_OF_DOSHAM!=$data['TYPE_OF_DOSHAM'])
                        {
                            $return_data.=' Type Of Dosham('.$value->TYPE_OF_DOSHAM.' -to- '.$data['TYPE_OF_DOSHAM'].')';
                        }
                    }else
                    {
                        $return_data.=' Type Of Dosham( -to- '.$data['TYPE_OF_DOSHAM'].')';
                    }

                    if(isset($value->Other_Dosham))
                    {
                        if($value->Other_Dosham!=$data['Other_Dosham'])
                        {
                            $return_data.=' Other Dosham('.$value->Other_Dosham.' -to- '.$data['Other_Dosham'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Dosham( -to- '.$data['Other_Dosham'].')';
                    }

                    if(isset($value->DIRECTIONAL_BALANCE))
                    {
                        if($value->DIRECTIONAL_BALANCE!=$data['DIRECTIONAL_BALANCE'])
                        {
                            $return_data.=' Directional Balance('.$value->DIRECTIONAL_BALANCE.' -to- '.$data['DIRECTIONAL_BALANCE'].')';
                        }
                    }else
                    {
                        $return_data.=' Directional Balance( -to- '.$data['DIRECTIONAL_BALANCE'].')';
                    }

                    if(isset($value->rashi))
                    {
                        if($value->rashi!=$data['rashi'])
                        {
                            $return_data.=' Rashi('.$value->rashi.' -to- '.$data['rashi'].')';
                        }
                    }else
                    {
                        $return_data.=' Rashi( -to- '.$data['rashi'].')';
                    }

                     if(isset($value->Year))
                    {
                        if($value->Year!=$data['Year'])
                        {
                            $return_data.=' Year('.$value->Year.' -to- '.$data['Year'].')';
                        }
                    }else
                    {
                        $return_data.=' Year( -to- '.$data['Year'].')';
                    }

                     if(isset($value->Month))
                    {
                        if($value->Month!=$data['Month'])
                        {
                            $return_data.=' Month('.$value->Month.' -to- '.$data['Month'].')';
                        }
                    }else
                    {
                        $return_data.=' Month( -to- '.$data['Month'].')';
                    }

                     if(isset($value->Day))
                    {
                        if($value->Day!=$data['Day'])
                        {
                            $return_data.=' Day('.$value->Day.' -to- '.$data['Day'].')';
                        }
                    }else
                    {
                        $return_data.=' Day( -to- '.$data['Day'].')';
                    }

                }
            }
            }
            
        }
        
        return $return_data;
    }


    public function ifPermanantUpdateorNot($member_id,$data){



        $member = get_allmembers($member_id);
        $return_data="";
         // print_r($data); echo '<br>';
         // print_r($member->permanent_address);exit;
        if(!empty($member))
        {
        if(!empty($member->permanent_address))
        {
            $permanent_address = json_decode($member->permanent_address);
            if(!empty($permanent_address))
            {
                foreach($permanent_address as $value)
                {

                    if(isset($value->permanent_state))
                    {
                        if($value->permanent_state!=$data['permanent_state'])
                        {
                            $return_data.=' Permanent State('.$value->permanent_state.' -to- '.$data['permanent_state'].')';
                        }
                    }else
                    {

                            $return_data.=' Permanent State( -to- '.$data['permanent_state'].')';
                        
                    }
                    if(isset($value->permanent_city_other))
                    {
                        if($value->permanent_city_other!=$data['permanent_city_other'])
                        {


                            $return_data.=' Permanent City Other('.$value->permanent_city_other.' -to- '.$data['permanent_city_other'].')';
                        }
                    }else
                    {
                         $return_data.=' Permanent City Other( -to- '.$data['permanent_city_other'].')';
                    }
                    if(isset($value->permanent_city))
                    {
                        if($value->permanent_city!=$data['permanent_city'])
                        {
                            $return_data.=' Permanent City('.$value->permanent_city.' -to- '.$data['permanent_city'].')';
                        }
                    }else
                    {
                         $return_data.=' Permanent City( -to- '.$data['permanent_city'].')';
                    }
                    if(isset($value->permanent_postal_code))
                    {
                        if($value->permanent_postal_code!=$data['permanent_postal_code'])
                        {
                            $return_data.=' Permanent Postal Code('.$value->permanent_postal_code.' -to- '.$data['permanent_postal_code'].')';
                        }
                    }else
                    {
                        $return_data.=' Permanent Postal Code( -to- '.$data['permanent_postal_code'].')';
                    }
                     if(isset($value->address))
                    {
                        if($value->address!=$data['address'])
                        {
                            $return_data.=' Address('.$value->address.' -to- '.$data['address'].')';
                        }
                    }else
                    {
                        $return_data.=' Address( -to- '.$data['address'].')';
                    }
                     if(isset($value->alternate_number))
                    {
                        if($value->alternate_number!=$data['alternate_number'])
                        {
                            $return_data.=' Alternate Number('.$value->alternate_number.' -to- '.$data['alternate_number'].')';
                        }
                    }else
                    {
                        $return_data.=' Alternate Number( -to- '.$data['alternate_number'].')';
                    }
                     if(isset($value->landline))
                    {
                        if($value->landline!=$data['landline'])
                        {
                            $return_data.=' Landline('.$value->landline.' -to- '.$data['landline'].')';
                        }
                    }else
                    {
                        $return_data.=' Landline( -to- '.$data['landline'].')';
                    }
                    

                }
            }
            }
            
        }
        
        return $return_data;
    }

    public function ifFamilyUpdateorNot($member_id,$data){



        $member = get_allmembers($member_id);
        $return_data="";
         // print_r($data); echo '<br>';
         // print_r($member->family_info);exit;
        if(!empty($member))
        {
        if(!empty($member->family_info))
        {
            $family_info = json_decode($member->family_info);
            if(!empty($family_info))
            {
                foreach($family_info as $value)
                {

                    if(isset($value->Surname))
                    {
                        if($value->Surname!=$data['Surname'])
                        {
                            $return_data.=' Surname('.$value->Surname.' -to- '.$data['Surname'].')';
                        }
                    }else
                    {

                            $return_data.=' Surname( -to- '.$data['Surname'].')';
                        
                    }
                    if(isset($value->Soveran_Details))
                    {
                        if($value->Soveran_Details!=$data['Soveran_Details'])
                        {


                            $return_data.=' Soveran Details('.$value->Soveran_Details.' -to- '.$data['Soveran_Details'].')';
                        }
                    }else
                    {
                         $return_data.=' Soveran Details( -to- '.$data['Soveran_Details'].')';
                    }
                    if(isset($value->father))
                    {
                        if($value->father!=$data['father'])
                        {
                            $return_data.=' Father Name('.$value->father.' -to- '.$data['father'].')';
                        }
                    }else
                    {
                         $return_data.=' Father Name( -to- '.$data['father'].')';
                    }
                    if(isset($value->mother))
                    {
                        if($value->mother!=$data['mother'])
                        {
                            $return_data.=' Mother Name('.$value->mother.' -to- '.$data['mother'].')';
                        }
                    }else
                    {
                        $return_data.=' Mother Name( -to- '.$data['mother'].')';
                    }
                     if(isset($value->father_vangusam))
                    {
                        if($value->father_vangusam!=$data['father_vangusam'])
                        {
                            $return_data.=' Father Vangusam('.$value->father_vangusam.' -to- '.$data['father_vangusam'].')';
                        }
                    }else
                    {
                        $return_data.=' Father Vangusam( -to- '.$data['father_vangusam'].')';
                    }
                     if(isset($value->other_father_vang))
                    {
                        if($value->other_father_vang!=$data['other_father_vang'])
                        {
                            $return_data.=' Other Father Vangusam('.$value->other_father_vang.' -to- '.$data['other_father_vang'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Father Vangusam( -to- '.$data['other_father_vang'].')';
                    }
                     if(isset($value->mother_vangusam))
                    {
                        if($value->mother_vangusam!=$data['mother_vangusam'])
                        {
                            $return_data.=' Mother Vangusam('.$value->mother_vangusam.' -to- '.$data['mother_vangusam'].')';
                        }
                    }else
                    {
                        $return_data.=' Mother Vangusam( -to- '.$data['mother_vangusam'].')';
                    }
                    if(isset($value->other_mother_vang))
                    {
                        if($value->other_mother_vang!=$data['other_mother_vang'])
                        {
                            $return_data.=' Other Mother Vangusam('.$value->other_mother_vang.' -to- '.$data['other_mother_vang'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Mother Vangusam( -to- '.$data['other_mother_vang'].')';
                    }
                    if(isset($value->family_type))
                    {
                        if($value->family_type!=$data['family_type'])
                        {
                            $return_data.=' Family Type('.$value->family_type.' -to- '.$data['family_type'].')';
                        }
                    }else
                    {
                        $return_data.=' Family Type( -to- '.$data['family_type'].')';
                    }
                    if(isset($value->Number_of_brothers))
                    {
                        if($value->Number_of_brothers!=$data['Number_of_brothers'])
                        {
                            $return_data.=' Number Of Brothers('.$value->Number_of_brothers.' -to- '.$data['Number_of_brothers'].')';
                        }
                    }else
                    {
                        $return_data.=' Number Of Brothers( -to- '.$data['Number_of_brothers'].')';
                    }
                    if(isset($value->Number_of_married_brothers))
                    {
                        if($value->Number_of_married_brothers!=$data['Number_of_married_brothers'])
                        {
                            $return_data.=' Number Of Married Brothers('.$value->Number_of_married_brothers.' -to- '.$data['Number_of_married_brothers'].')';
                        }
                    }else
                    {
                        $return_data.=' Number Of Married Brothers( -to- '.$data['Number_of_married_brothers'].')';
                    }
                    if(isset($value->Number_of_Sisters))
                    {
                        if($value->Number_of_Sisters!=$data['Number_of_Sisters'])
                        {
                            $return_data.=' Number Of Sisters('.$value->Number_of_Sisters.' -to- '.$data['Number_of_Sisters'].')';
                        }
                    }else
                    {
                        $return_data.=' Number Of Sisters( -to- '.$data['Number_of_Sisters'].')';
                    }

                    if(isset($value->Number_of_married_sisters))
                    {
                        if($value->Number_of_married_sisters!=$data['Number_of_married_sisters'])
                        {
                            $return_data.=' Number Of Married Sisters('.$value->Number_of_married_sisters.' -to- '.$data['Number_of_married_sisters'].')';
                        }
                    }else
                    {
                        $return_data.=' Number Of Married Sisters( -to- '.$data['Number_of_married_sisters'].')';
                    }

                    if(isset($value->Property_Description))
                    {
                        if($value->Property_Description!=$data['Property_Description'])
                        {
                            $return_data.=' Property Description('.$value->Property_Description.' -to- '.$data['Property_Description'].')';
                        }
                    }else
                    {
                        $return_data.=' Property Description( -to- '.$data['Property_Description'].')';
                    }
                    if(isset($value->Other_property_description))
                    {
                        if($value->Other_property_description!=$data['Other_property_description'])
                        {
                            $return_data.=' Other Property Description('.$value->Other_property_description.' -to- '.$data['Other_property_description'].')';
                        }
                    }else
                    {
                        $return_data.=' Other Property Description( -to- '.$data['Other_property_description'].')';
                    }
                    

                }
            }
            }
            
        }
        
        return $return_data;
    }



    public function ifPartnerUpdateorNot($member_id,$data){



        $member = get_allmembers($member_id);
        $return_data="";
         // print_r($data); echo '<br>';
         // print_r($member->partner_expectation);exit;
        if(!empty($member))
        {
        if(!empty($member->partner_expectation))
        {
            $partner_expectation = json_decode($member->partner_expectation);
            if(!empty($partner_expectation))
            {
                foreach($partner_expectation as $value)
                {

                    if(isset($value->partner_age))
                    {
                        if($value->partner_age!=$data['partner_age'])
                        {
                            $return_data.=' Partner Age('.$value->partner_age.' -to- '.$data['partner_age'].')';
                        }
                    }else
                    {

                            $return_data.=' Partner Age( -to- '.$data['partner_age'].')';
                        
                    }
                    if(isset($value->partner_height))
                    {
                        if($value->partner_height!=$data['partner_height'])
                        {


                            $return_data.=' Partner Height('.$value->partner_height.' -to- '.$data['partner_height'].')';
                        }
                    }else
                    {
                         $return_data.=' Partner Height( -to- '.$data['partner_height'].')';
                    }
                    if(isset($value->partner_weight))
                    {
                        if($value->partner_weight!=$data['partner_weight'])
                        {
                            $return_data.=' Partner Weight('.$value->partner_weight.' -to- '.$data['partner_weight'].')';
                        }
                    }else
                    {
                         $return_data.=' Partner Weight( -to- '.$data['partner_weight'].')';
                    }
                    if(isset($value->partner_any_disability))
                    {
                        if($value->partner_any_disability!=$data['partner_any_disability'])
                        {
                            $return_data.=' Partner Disability('.$value->partner_any_disability.' -to- '.$data['partner_any_disability'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Disability( -to- '.$data['partner_any_disability'].')';
                    }
                     if(isset($value->partner_marital_status))
                    {
                        if($value->partner_marital_status!=$data['partner_marital_status'])
                        {
                            $return_data.=' Partner Marital Status('.$value->partner_marital_status.' -to- '.$data['partner_marital_status'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Marital Status( -to- '.$data['partner_marital_status'].')';
                    }

                    if($value->with_children_acceptables==1)
                    {
                        $with_children_acceptables_data = 'Yes';
                    }elseif($value->with_children_acceptables==2)
                    {
                        $with_children_acceptables_data = 'No';
                    }else
                    {
                        $with_children_acceptables_data = "Doesn't Matter";
                    }

                    if($data['with_children_acceptables']==1)
                    {
                        $with_children_acceptables = 'Yes';
                    }elseif($data['with_children_acceptables']==2)
                    {
                        $with_children_acceptables = 'No';
                    }else
                    {
                        $with_children_acceptables = "Doesn't Matter";
                    }


                     if(isset($value->with_children_acceptables))
                    {
                        if($value->with_children_acceptables!=$data['with_children_acceptables'])
                        {
                            $return_data.=' With Children Acceptables('.$with_children_acceptables_data.' -to- '.$with_children_acceptables.')';
                        }
                    }else
                    {
                        $return_data.=' With Children Acceptables( -to- '.$with_children_acceptables.')';
                    }
                     if(isset($value->partner_body_type))
                    {
                        if($value->partner_body_type!=$data['partner_body_type'])
                        {
                            $return_data.=' Partner Body Type('.$value->partner_body_type.' -to- '.$data['partner_body_type'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Body Type( -to- '.$data['partner_body_type'].')';
                    }
                    if(isset($value->partner_education))
                    {
                        if($value->partner_education!=$data['partner_education'])
                        {
                            $return_data.=' Partner Education('.$value->partner_education.' -to- '.$data['partner_education'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Education( -to- '.$data['partner_education'].')';
                    }
                    if(isset($value->partner_profession))
                    {
                        if($value->partner_profession!=$data['partner_profession'])
                        {
                            $return_data.=' Partner Profession('.$value->partner_profession.' -to- '.$data['partner_profession'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Profession( -to- '.$data['partner_profession'].')';
                    }
                    if(isset($value->partner_DOSHAM))
                    {
                        if($value->partner_DOSHAM!=$data['partner_DOSHAM'])
                        {
                            $return_data.=' Partner Dosham('.$value->partner_DOSHAM.' -to- '.$data['partner_DOSHAM'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Dosham( -to- '.$data['partner_DOSHAM'].')';
                    }
                    if(isset($value->partner_TYPE_OF_DOSHAM))
                    {
                        if($value->partner_TYPE_OF_DOSHAM!=$data['partner_TYPE_OF_DOSHAM'])
                        {
                            $return_data.=' Partner Type Of Dosham('.$value->partner_TYPE_OF_DOSHAM.' -to- '.$data['partner_TYPE_OF_DOSHAM'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Type Of Dosham( -to- '.$data['partner_TYPE_OF_DOSHAM'].')';
                    }
                    if(isset($value->partner_Other_Dosham))
                    {
                        if($value->partner_Other_Dosham!=$data['partner_Other_Dosham'])
                        {
                            $return_data.=' Partner Other Dosham('.$value->partner_Other_Dosham.' -to- '.$data['partner_Other_Dosham'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Other Dosham( -to- '.$data['partner_Other_Dosham'].')';
                    }

                    if(isset($value->partner_Expectation))
                    {
                        if($value->partner_Expectation!=$data['partner_Expectation'])
                        {
                            $return_data.=' Partner Expectation('.$value->partner_Expectation.' -to- '.$data['partner_Expectation'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Expectation( -to- '.$data['partner_Expectation'].')';
                    }

                    if(isset($value->partner_Other_Expectation))
                    {
                        if($value->partner_Other_Expectation!=$data['partner_Other_Expectation'])
                        {
                            $return_data.=' Partner Other Expectation('.$value->partner_Other_Expectation.' -to- '.$data['partner_Other_Expectation'].')';
                        }
                    }else
                    {
                        $return_data.=' Partner Other Expectation( -to- '.$data['partner_Other_Expectation'].')';
                    }
                    
                    

                }
            }
            }
            
        }
        
        return $return_data;
    }

}