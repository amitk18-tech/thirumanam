<?php
class MetaModel extends CI_Model 
{
	public function __construct()
   {
     	parent::__construct();
   }

   public function premiumMembers($meta_key)
   {
    	$this->db->select('*');
    	$this->db->from('meta_keys');
    	$this->db->join('meta_value','meta_value.meta_key_id = meta_keys.meta_key_id','left');
    	$this->db->where('meta_keys.meta_key',$meta_key);
    	$this->db->where('meta_keys.delete_status',0);
    	$this->db->where('meta_keys.status',1);
    	$this->db->where('meta_value.delete_status',0);
    	$this->db->where('meta_value.status',1);
    	$query=$this->db->get()->result();      
    	return $query;
   }
  
  public function getPlans()
   {
        $this->db->select('*');
        $this->db->from('plan');
        $this->db->order_by('amount','ASC');
        $this->db->where("amount !=",0);
        $query=$this->db->get()->result();      
        return $query;
   }
   public function getMemberPlan($id)
   {
        $this->db->select('*');
        $this->db->from('package_payment');
        $this->db->where("member_id",$id);
        $this->db->where("payment_status",'paid');
        $this->db->order_by('package_payment_id ','desc');
        $this->db->where("active_status",1);
        $this->db->where("delete_status",0);
        $query=$this->db->get()->row();      
        return $query;
   }
   public function getPlan($plan_id)
   {
        $this->db->select('*');
        $this->db->from('plan');
        $this->db->where("plan_id",$plan_id);
        $this->db->where("active_status",1);
        $this->db->where("delete_status",0);
        $query=$this->db->get()->row();      
        return $query;
   }
    function get_random_members($gender)
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->limit(12);
        $this->db->order_by('rand()');
        $this->db->where_not_in('date_of_birth',0);
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
        $this->db->where('gender',$gender);
        $this->db->where('is_blocked','no');
        $this->db->where('is_closed','no');
        $query=$this->db->get()->result();      
        return $query;
    }
    
    function get_random_member()
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->limit(12);
        $this->db->order_by('rand()');
        $this->db->where_not_in('date_of_birth',0);
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        $this->db->where('is_blocked','no');
        $this->db->where('is_closed','no');
        $query=$this->db->get()->result();      
        return $query;
    }
    public function get_all_memberdatas()
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('active_status',1);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result();
     return $query;
  }
  public function get_memberdatas($gender,$soveran,$ignored_ids,$ignored_by_ids)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where_not_in('member_id',$ignored_ids);
     $this->db->where_not_in('member_id',$ignored_by_ids);
     $this->db->where('gender',$gender);
     $this->db->where('soveran_detail<=',$soveran);
     $this->db->where('is_blocked','no');
     $this->db->where('is_closed','no');
     $this->db->where('active_status',1);
     $this->db->where('email_verification_status',1);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result();
     return $query;
  }
  
  public function get_interest_pagination_datas($id,$limit,$start)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where_not_in('member_id',$id);
     $this->db->limit($limit, $start);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result();
     return $query;
  }

    public  function find_topping_pagination($per_page,$start,$idArr = array()){ 
     $query = $this->db->where_in("member_id", $idArr)->where('is_blocked','no')->where('is_closed','no')->limit($per_page,$start)->get("member");
         return $query->result();
    }

    public  function find_topping($idArr = array()){ 
      $this->db->where_in("member_id", $idArr);
      $this->db->where('is_closed','no');
      $this->db->where('is_blocked','no');
      $query = $this->db->get("member");
         return $query->result();
    }

   public function get_pagination_datas($gender,$soveran,$ignored_ids,$ignored_by_ids,$limit,$start)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where_not_in('member_id',$ignored_ids);
     $this->db->where_not_in('member_id',$ignored_by_ids);
     $this->db->limit($limit, $start);
     $this->db->where('gender',$gender);
     $this->db->where('soveran_detail<=',$soveran);
     $this->db->where('is_blocked','no');
     $this->db->where('is_closed','no');
     $this->db->where('email_verification_status',1);
     $this->db->where('active_status',1);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result();
     return $query;
  }
   public function get_activememberdatas($gender,$soveran,$ignored_ids,$ignored_by_ids,$limit="")
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('gender',$gender);
     $this->db->where('soveran_detail<=',$soveran);
     $this->db->where('updateProfileDoneStatus',1);
     $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
     $this->db->where('membership_date!=',NULL);
     $this->db->where_not_in('member_id',$ignored_ids);
     $this->db->where_not_in('member_id',$ignored_by_ids);
     $this->db->where('is_blocked','no');
     $this->db->where('is_closed','no');
     // $this->db->where('email_verification_status',1);
     $this->db->order_by('member_id','desc');
     $this->db->where('is_married',0);
     $this->db->where('active_status',1);
     $this->db->where('delete_status',0);
     if(!empty($limit)){
        $this->db->limit($limit);
     }
     
     $query=$this->db->get()->result();
     return $query;
  }

  public function get_activememberloaddatas($gender,$soveran,$ignored_ids,$ignored_by_ids,$id,$limit="")
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('member_id<',$id);
     $this->db->where('gender',$gender);
     $this->db->where('soveran_detail<=',$soveran);
     $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
     $this->db->where('membership_date!=',NULL);
     $this->db->where('updateProfileDoneStatus',1);
     $this->db->where_not_in('member_id',$ignored_ids);
     $this->db->where_not_in('member_id',$ignored_by_ids);
     $this->db->where('is_blocked','no');
     $this->db->where('is_closed','no');
     // $this->db->where('email_verification_status',1);
     $this->db->order_by('member_id','desc');
     $this->db->where('is_married',0);
     $this->db->where('active_status',1);
     $this->db->where('delete_status',0);
     if(!empty($limit)){
     $this->db->limit($limit);
     }
     $query=$this->db->get()->result();
     return $query;
  }
   public function get_activepagination_datas($gender,$soveran,$ignored_ids,$ignored_by_ids,$limit,$start)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->limit($limit, $start);
     $this->db->where('gender',$gender);
     $this->db->where('soveran_detail<=',$soveran);
     $this->db->where('updateProfileDoneStatus',1);
     $this->db->where_not_in('member_id',$ignored_ids);
     $this->db->where_not_in('member_id',$ignored_by_ids);
     $this->db->where('is_blocked','no');
     $this->db->where('is_closed','no');
     // $this->db->where('email_verification_status',1);
     $this->db->order_by('member_id','desc');
     $this->db->where('active_status',1);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->result();
     return $query;
  }
  public function getMemberDatas($table,$result,$gender)
    {
        $this->db->select('*');
        $this->db->from($table);
        if(!empty($gender)){
            $this->db->where('gender',$gender);
        }
        // $this->db->where('active_status',1);
        $this->db->where('is_blocked','no');
        // $this->db->where('is_closed','no');
        $this->db->where('delete_status',0);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getMemberData($table,$result,$where)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        // $this->db->where('is_blocked','no');
        // $this->db->where('is_closed','no');
        $this->db->where('delete_status',0);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function updateMemberDatas($table,$where,$data)
    {
        $this->db->where($where);
        $this->db->update($table,$data);
        // echo $this->db->last_query(); exit;
    }
    public function deleteMemberDatas($table,$where)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function file_up($name, $type, $id, $multi = '', $no_thumb = '', $ext = '.jpg')
    {
        if ($multi == '') {
            move_uploaded_file($_FILES[$name]['tmp_name'], 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext);
            if ($no_thumb == '') {
                $this->Crud_model->img_thumb($type, $id, $ext);
            }
        } elseif ($multi == 'multi') {
            $ib = 1;
            foreach ($_FILES[$name]['name'] as $i => $row) {
                $ib = $this->file_exist_ret($type, $id, $ib);
                move_uploaded_file($_FILES[$name]['tmp_name'][$i], 'uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $ib . $ext);
                if ($no_thumb == '') {
                    $this->img_thumb($type, $id . '_' . $ib, $ext);
                }
            }
        }
    }

    function file_exist_ret($type, $id, $ib, $ext = '.jpg')
    {
        if (file_exists('uploads/' . $type . '_image/' . $type . '_' . $id . '_' . $ib . $ext)) {
            $ib = $ib + 1;
            $ib = $this->file_exist_ret($type, $id, $ib);
            return $ib;
        } else {
            return $ib;
        }
    }

    function img_thumb($type, $id, $ext = '.jpg', $width = '400', $height = '400')
    {
        $this->load->library('image_lib');
        ini_set("memory_limit", "-1");

        $config1['image_library']  = 'gd2';
        $config1['create_thumb']   = TRUE;
        $config1['maintain_ratio'] = TRUE;
        $config1['width']          = $width;
        $config1['height']         = $height;
        $config1['source_image']   = 'uploads/' . $type . '_image/' . $type . '_' . $id . $ext;

        $this->image_lib->initialize($config1);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
    
    public function get_advanced_search_datas_oldd($user_id,$age_from,$age_to,$height_from,$height_to,$marital_status,$education,$father_vangusam,$member_profile_id,$gender,$star,$dosham,$Soveran_Details,$Type_of_study)
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where("age BETWEEN '$age_from' AND '$age_to'");
        $this->db->where("height BETWEEN '$height_from' AND '$height_to'");
        // if(count($who_blocked_loginuser)!=0)
        // {
        //   $this->db->where_not_in('users.user_id',$who_blocked_loginuser);
        // }
        $this->db->like('family_info','"father_vangusam":"'.trim($father_vangusam[0]).'"','both');
        if(count($marital_status)!=0)
        {
           $this->db->where_in('user_details.marital_status_meta',$marital_status);
        }
        if(count($mother_tongue)!=0)
        {
           $this->db->where_in('user_details.mother_tongue_id',$mother_tongue);
        }
        if(count($country_id)!=0)
        {
            $this->db->where_in('user_details.country_id',$country_id);
        }
        if(count($state_id)!=0)
        {
            $this->db->where_in('user_details.state_id',$state_id);
        }
        if(count($city_id)!=0)
        {
            $this->db->where_in('user_details.city_id',$city_id);
        }
        if(count($preference_food_type)!=0)
        {
            $this->db->where_in('user_details.food_type_meta',$preference_food_type);
        }
        if(count($preference_drink_type)!=0)
        {
            $this->db->where_in('user_details.drinking_type_meta',$preference_drink_type);
        }
        if(count($preference_smoking_type)!=0)
        {
            $this->db->where_in('user_details.smoking_type_meta',$preference_smoking_type);
        }
        if(count($education)!=0)
        {
           $this->db->where_in('user_professional_details.education_id',$education);
        }        
        if(count($preference_occupation)!=0)
        {
            $this->db->where_in('user_professional_details.occupation_id',$preference_occupation);
        }
        if($income_from==0&&$income_to!=0)
        {
            $this->db->where('user_professional_details.annual_income <=',$income_to);
        }
        elseif($income_from!=0&&$income_to==0)
        {
            $this->db->where('user_professional_details.annual_income >=',$income_from);
        }
        elseif($income_from!=0&&$income_to!=0)
        {
            $this->db->where("user_professional_details.annual_income BETWEEN '$income_from' AND '$income_to'");
        }
        else
        {
        }
        if($user_id!='')
        {
          $this->db->where('users.user_id !=',$user_id);
        }
        if($gender==1)
        {
          $this->db->where('users.gender',2);
        }
        elseif($gender==2)
        {
          $this->db->where('users.gender',1);
        }
        else
        {}
        $this->db->where('users.status',1);
        $this->db->where('users.delete_status',0);
        $this->db->order_by('users.user_id','ASC');
        return $query=$this->db->get()->result();
    }

    public function get_advanced_search_datas_old($member_profile_id,$sql_aged_from,$sql_aged_to,$height_from,$height_to,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids)
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('gender',$gender);
        $this->db->where_not_in('member_id',$ignored_ids);
        $this->db->where_not_in('member_id',$ignored_by_ids);
        $this->db->where('soveran_detail<=',$soveran);
        $this->db->where(array('date_of_birth <=' => $sql_aged_from, 'date_of_birth >=' => $sql_aged_to));
        if(!empty($height_from && $height_to))
        {
        $this->db->where(array('height >=' => $height_from, 'height <=' => $height_to));
        }
        
        if(!empty($member_profile_id))
        {
           $this->db->where('member_profile_id',$member_profile_id);
        }
        if(!empty($marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$marital_status.'"','both');
        }
        if(!empty($occupation))
        {
           $this->db->like('education_and_career','"Type_of_occupation":"'.$occupation.'"','both');
        }
        if(!empty($father_vangusam[0]))
        {
           $this->db->like('family_info','"father_vangusam":"'.trim($father_vangusam[0]).'"','both');
           if(isset($father_vangusam[1])){
              $this->db->group_start();
                foreach ($father_vangusam as $key => $value) {
                   $this->db->or_like('family_info','"father_vangusam":"'.trim($value).'"','both');
                }
            $this->db->group_end();
            }
        }
        // if(!empty($gender))
        // {
        //    $this->db->where('gender',$gender);
        // }
        if(!empty($star[0]))
        {
           $this->db->like('astronomic_information','"star":"'.trim($star[0]).'"','both');
        }
        if(!empty($dosham))
        {
            
            if($dosham=='clean horoscope')
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.''.'"','both');
            }else
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.$dosham.'"','both');
            }
        }
        if(!empty($Soveran_Details))
        {
           $this->db->where('soveran_detail<=',$Soveran_Details);
        }
        if(!empty($Type_of_study))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$Type_of_study.'"','both');
        }
        $this->db->where('is_blocked','no');
        $this->db->where('is_closed','no');
        // $this->db->where('email_verification_status',1);
        $this->db->where('is_married',0);
        $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('member_id','ASC');
        return $query=$this->db->get()->result();
    }

    public function get_advanced_search_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$height_from,$height_to,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$limit,$start,$soveran,$ignored_ids,$ignored_by_ids)
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('gender',$gender);
        $this->db->where_not_in('member_id',$ignored_ids);
        $this->db->where_not_in('member_id',$ignored_by_ids);
        $this->db->where('soveran_detail<=',$soveran);
        $this->db->limit($limit, $start);
        $this->db->where(array('date_of_birth <=' => $sql_aged_from, 'date_of_birth >=' => $sql_aged_to));
        if(!empty($height_from && $height_to))
        {
        $this->db->where(array('height >=' => $height_from, 'height <=' => $height_to));
        }
        


        if(!empty($member_profile_id))
        {
           $this->db->where('member_profile_id',$member_profile_id);
        }
        if(!empty($marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$marital_status.'"','both');
        }
        if(!empty($occupation))
        {
           $this->db->like('education_and_career','"Type_of_occupation":"'.$occupation.'"','both');
        }
        if(!empty($father_vangusam[0]))
        {
           $this->db->like('family_info','"father_vangusam":"'.trim($father_vangusam[0]).'"','both');
           if(isset($father_vangusam[1])){
              $this->db->group_start();
                foreach ($father_vangusam as $key => $value) {
                   $this->db->or_like('family_info','"father_vangusam":"'.trim($value).'"','both');
                }
            $this->db->group_end();
            }
        }
        // if(!empty($gender))
        // {
        //    $this->db->where('gender',$gender);
        // }
        if(!empty($star[0]))
        {
           $this->db->like('astronomic_information','"star":"'.trim($star[0]).'"','both');
        }
        if(!empty($dosham))
        {
            if($dosham=='clean horoscope')
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.''.'"','both');
            }else
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.$dosham.'"','both');
            }
        }
        if(!empty($Soveran_Details))
        {
           $this->db->where('soveran_detail<=',$Soveran_Details);
        }
        if(!empty($Type_of_study))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$Type_of_study.'"','both');
        }
        $this->db->where('is_blocked','no');
        $this->db->where('is_married',0);
        $this->db->where('is_closed','no');
        $this->db->where('is_married',0);
        // $this->db->where('email_verification_status',1);
        $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('member_id','ASC');
        return $query=$this->db->get()->result();
    }

    public function get_advanced_activesearch_datas_old($member_profile_id,$sql_aged_from,$sql_aged_to,$height_from,$height_to,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,$limit="",$id="")
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('gender',$gender);
        if(!empty($id)){
           $this->db->where('member_id<',$id); 
        }
        $this->db->where_not_in('member_id',$ignored_ids);
        $this->db->where_not_in('member_id',$ignored_by_ids);
        $this->db->where('soveran_detail<=',$soveran);
        $this->db->where(array('date_of_birth <=' => $sql_aged_from, 'date_of_birth >=' => $sql_aged_to));
        if(!empty($height_from && $height_to))
        {
        $this->db->where(array('height >=' => $height_from, 'height <=' => $height_to));
        }
        
        if(!empty($member_profile_id))
        {
           $this->db->where('member_profile_id',$member_profile_id);
        }
        if(!empty($marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$marital_status.'"','both');
        }
        if(!empty($occupation))
        {
           $this->db->like('education_and_career','"Type_of_occupation":"'.$occupation.'"','both');
        }
        if(!empty($father_vangusam[0]))
        {
           $this->db->like('family_info','"father_vangusam":"'.trim($father_vangusam[0]).'"','both');
          
           if(isset($father_vangusam[1])){
              $this->db->group_start();
                foreach ($father_vangusam as $key => $value) {
                   $this->db->or_like('family_info','"father_vangusam":"'.trim($value).'"','both');
                }
            $this->db->group_end();
            }
            
                
        }
        // if(!empty($gender))
        // {
        //    $this->db->where('gender',$gender);
        // }
        if(!empty($star[0]))
        {
           $this->db->like('astronomic_information','"star":"'.trim($star[0]).'"','both');
        }
        if(!empty($dosham))
        {
            if($dosham=='clean horoscope')
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.''.'"','both');
            }else
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.$dosham.'"','both');
            }
        }
        if(!empty($Soveran_Details))
        {
           $this->db->where('soveran_detail<=',$Soveran_Details);
        }
        if(!empty($Type_of_study))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$Type_of_study.'"','both');
        }
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('is_blocked','no');
        $this->db->where('is_closed','no');
        $this->db->where('is_married',0);
        // $this->db->where('email_verification_status',1);
        $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        if(!empty($limit)){
           $this->db->limit($limit); 
        }
        
        $this->db->order_by('member_id','desc');
        // echo $this->db->last_query();exit;
        return $query=$this->db->get()->result();

    }

    public function get_advanced_activesearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$height_from,$height_to,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$soveran,$ignored_ids,$ignored_by_ids,$limit="",$id="")
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('gender',$gender);
        $this->db->where_not_in('member_id',$ignored_ids);
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
        $this->db->where_not_in('member_id',$ignored_by_ids);
        $this->db->where('soveran_detail<=',$soveran);
        $this->db->where('membership_date!=',NULL);
        if(!empty($limit)){

            $this->db->limit($limit);
        }
        if(!empty($id)){

            $this->db->where('member_id<',$id);
        }
        $this->db->where(array('date_of_birth <=' => $sql_aged_from, 'date_of_birth >=' => $sql_aged_to));
        if(!empty($height_from && $height_to))
        {
        $this->db->where(array('height >=' => $height_from, 'height <=' => $height_to));
        }
        


        if(!empty($member_profile_id))
        {
           $this->db->where('prefixId',$member_profile_id);
        }
        if(!empty($marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$marital_status.'"','both');
        }
        if(!empty($occupation))
        {
           $this->db->like('education_and_career','"Type_of_occupation":"'.$occupation.'"','both');
        }
        // $this->ar_bracket_open = TRUE;
        if(!empty($father_vangusam[0]))
        {
          
           

           
           if(!empty($father_vangusam[1])){
            $this->db->group_start();
                foreach ($father_vangusam as $key => $value) {
                   $this->db->or_like('family_info','"father_vangusam":"'.trim($value).'"','both');
                }
            $this->db->group_end();
            }else{

                $this->db->like('family_info','"father_vangusam":"'.trim($father_vangusam[0]).'"','both');
            }
           
            
        }
        // if(!empty($gender))
        // {
        //    $this->db->where('gender',$gender);
        // }
        if(!empty($star[0]))
        {
           
           if(!empty($star[1])){
            $this->db->group_start();
                foreach ($star as $key => $value) {
                   $this->db->or_like('astronomic_information','"star":"'.trim($star[$key]).'"','both');
                }
            $this->db->group_end();
            }else{

                $this->db->like('astronomic_information','"star":"'.trim($star[0]).'"','both');
            }
        }
        if(!empty($dosham))
        {
            if($dosham=='clean horoscope')
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.''.'"','both');
            }else
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.$dosham.'"','both');
            }
        }

        if(!empty($Soveran_Details))
        {
           $this->db->where('soveran_detail<=',$Soveran_Details);
        }
        if(!empty($Type_of_study))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$Type_of_study.'"','both');
        }
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('is_blocked','no');
        $this->db->where('is_closed','no');
        $this->db->where('is_married',0);
        // $this->db->where('email_verification_status',1);
        $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('member_id','desc');
        //echo $this->db->last_query();exit;
        return $query=$this->db->get()->result();
    }




    public function get_advanced_matchsearch_pagination_datas($member_profile_id,$sql_aged_from,$sql_aged_to,$height_from,$height_to,$marital_status,$occupation,$father_vangusam,$gender,$star,$dosham,$Soveran_Details,$Type_of_study,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids,$limit="",$id="")
    {
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('gender',$gender);
        $this->db->where_not_in('member_id',$ignored_ids);
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
        $this->db->where_not_in('member_id',$ignored_by_ids);
        $this->db->where('soveran_detail<=',$soveran);
        $this->db->where('membership_date!=',NULL);
        if(!empty($limit)){

            $this->db->limit($limit);
        }
        if(!empty($id)){

            $this->db->where('member_id<',$id);
        }
        $this->db->where(array('date_of_birth <=' => $sql_aged_from, 'date_of_birth >=' => $sql_aged_to));
        if(!empty($height_from && $height_to))
        {
        $this->db->where(array('height >=' => $height_from, 'height <=' => $height_to));
        }
        


        if(!empty($member_profile_id))
        {
           $this->db->where('prefixId',$member_profile_id);
        }
        if(!empty($marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$marital_status.'"','both');
        }
        if(!empty($occupation))
        {
           $this->db->like('education_and_career','"Type_of_occupation":"'.$occupation.'"','both');
        }
        // $this->ar_bracket_open = TRUE;
        if(!empty($father_vangusam[0]))
        {
          
           

           
           if(!empty($father_vangusam[1])){
            $this->db->group_start();
                foreach ($father_vangusam as $key => $value) {
                   $this->db->or_like('family_info','"father_vangusam":"'.trim($value).'"','both');
                }
            $this->db->group_end();
            }else{

                $this->db->like('family_info','"father_vangusam":"'.trim($father_vangusam[0]).'"','both');
            }
           
            
        }
        // if(!empty($gender))
        // {
        //    $this->db->where('gender',$gender);
        // }
        if(!empty($star[0]))
        {
           
           if(!empty($star[1])){
            $this->db->group_start();
                foreach ($star as $key => $value) {
                   $this->db->or_like('astronomic_information','"star":"'.trim($star[$key]).'"','both');
                }
            $this->db->group_end();
            }else{

                $this->db->like('astronomic_information','"star":"'.trim($star[0]).'"','both');
            }
        }
        if(!empty($dosham))
        {
           
            if($dosham=='clean horoscope')
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.''.'"','both');
            }else
            {
                $this->db->like('astronomic_information','"TYPE_OF_DOSHAM":"'.$dosham.'"','both');
            }
        }
        if(!empty($Soveran_Details))
        {
           $this->db->where('soveran_detail<=',$Soveran_Details);
        }
        if(!empty($Type_of_study))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$Type_of_study.'"','both');
        }



        if(!empty($partner_age))
        {
        $this->db->where(array('date_of_birth <' => $partner_age));
        }
        if(!empty($partner_height))
        {
        $this->db->where(array('height >=' => $partner_height));
        }
        if(!empty($partner_weight))
        {
           $this->db->like('physical_attributes','"weight":"'.$partner_weight.'"','both');
        }
        if(!empty($with_children_acceptables))
        {
           $this->db->like('basic_info','"with_children_acceptables":"'.$with_children_acceptables.'"','both');
        }
        if(!empty($partner_any_disability))
        {
           $this->db->like('physical_attributes','"any_disability":"'.$partner_any_disability.'"','both');
        }
        if(!empty($partner_marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$partner_marital_status.'"','both');
        }
        if(!empty($partner_education))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$partner_education.'"','both');
        }
        if(!empty($partner_body_type))
        {
           $this->db->like('physical_attributes','"body_art":"'.$partner_body_type.'"','both');
        }
        if(!empty($partner_DOSHAM))
        {
           $this->db->like('astronomic_information','"DOSHAM":"'.$partner_DOSHAM.'"','both');
        }




        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('is_blocked','no');
        $this->db->where('is_closed','no');
        $this->db->where('is_married',0);
        // $this->db->where('email_verification_status',1);
        $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->order_by('member_id','desc');
        //echo $this->db->last_query();exit;
        return $query=$this->db->get()->result();
    }



    function profile_report($from = '', $from_name ='', $reported_person = '')
        {

            $this->load->database();
            $to = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
            $sub = 'Profile report';
            $member_type = $this->db->get_where('member',array('member_id'=>$reported_person))->row()->membership;
            if($member_type == 1)
            {
                $type = 'free_members';
            }
            else
            {
                $type = 'premium_members';
            }
            $link = base_url()."admin".'/members/'.$type.'/view_member'.'/'.$reported_person;
            $email_body = $from_name.' '.'reported to this member'.' '.$link;
            $send_mail = $this->do_email($from, $from_name, $to, $sub, $email_body, $mailtype="text" );
            return $send_mail;

        }
        function do_email($from = '', $from_name = '', $to = '', $sub = '', $msg = '', $mailtype = 'html' )
        {
            $config = array();
            $smtp_config = array();
            $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;

            if (!empty($protocol)) {
                if ($protocol == 'smtp') {
                    $smtp_config = $this->get_smtp_config();
                }
            }


            $this->load->library('email');
            $this->email->set_newline("\r\n");

            $config['priority'] = 1;
            $config['mailtype'] = $mailtype;


            if (!empty($smtp_config)) {
                $from = $smtp_config['smtp_user'];
                $config = array_merge($config,$smtp_config);
            }

            if (!empty($config)) {
                $this->email->initialize($config);
            }

            $this->email->from($from, $from_name);
            $this->email->to($to);
            $this->email->subject($sub);
            $this->email->message($msg);

            if(!demo()){
                if ($this->email->send()) {
                    return true;
                } else {
                    // echo $this->email->print_debugger();
                    return false;
                }
            }else {
                return true;
            }

            // echo $this->email->print_debugger();
            // exit;
        }
        public function get_smtp_config()
        {
            $config = array();
            $flag_count = 0;

            $smtp_host = $this->db->get_where('general_settings', array('type' => 'smtp_host'))->row()->value;
            $smtp_port = $this->db->get_where('general_settings', array('type' => 'smtp_port'))->row()->value;
            $smtp_user = $this->db->get_where('general_settings', array('type' => 'smtp_user'))->row()->value;
            $smtp_pass = $this->db->get_where('general_settings', array('type' => 'smtp_pass'))->row()->value;


            if (!empty($smtp_host)) {

                $config['smtp_host'] = $smtp_host;
                $flag_count++; // 1

            }

            if (!empty($smtp_port)) {

                $config['smtp_port'] = $smtp_port;
                $flag_count++; // 2

            }

            if (!empty($smtp_user)) {

                $config['smtp_user'] = $smtp_user;
                $flag_count++; // 3

            }

            if (!empty($smtp_pass)) {

                $config['smtp_pass'] = $smtp_pass;
                $flag_count++; // 4

            }

            if ($flag_count < 4) {
                $config = array();
            }

            return $config;
        }
        


        function get_matched_members($gender,$partner_age,$partner_height,$partner_weight,$with_children_acceptables,$partner_any_disability,$partner_marital_status,$partner_education,$partner_body_type,$partner_DOSHAM,$partner_TYPE_OF_DOSHAM,$partner_Other_Dosham,$partner_Expectation,$partner_Other_Expectation,$soveran,$ignored_ids,$ignored_by_ids,$limit="",$view_id="")
    {
        
        $this->db->select('*');
        $this->db->from('member');
        $this->db->where('gender',$gender);
        $this->db->where('is_blocked','no');
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
        $this->db->where('membership_date!=',NULL);
        $this->db->where('is_closed','no');
        if(!empty($view_id))
        {
            $this->db->where('member_id<',$view_id);
        }
        if(!empty($limit))
        {
            $this->db->limit($limit);
        }
        $this->db->where_not_in('member_id',$ignored_ids);
        $this->db->where_not_in('member_id',$ignored_by_ids);
        $this->db->where('soveran_detail<=',$soveran);
        if(!empty($partner_age))
        {
        $this->db->where(array('date_of_birth <' => $partner_age));
        }
        if(!empty($partner_height))
        {
        $this->db->where(array('height >=' => $partner_height));
        }
        if(!empty($partner_weight))
        {
           $this->db->like('physical_attributes','"weight":"'.$partner_weight.'"','both');
        }
        if(!empty($with_children_acceptables))
        {
           $this->db->like('basic_info','"with_children_acceptables":"'.$with_children_acceptables.'"','both');
        }
        if(!empty($partner_any_disability))
        {
           $this->db->like('physical_attributes','"any_disability":"'.$partner_any_disability.'"','both');
        }
        if(!empty($partner_marital_status))
        {
           $this->db->like('basic_info','"marital_status":"'.$partner_marital_status.'"','both');
        }
        if(!empty($partner_education))
        {
           $this->db->like('education_and_career','"Type_of_study":"'.$partner_education.'"','both');
        }
        if(!empty($partner_body_type))
        {
           $this->db->like('physical_attributes','"body_art":"'.$partner_body_type.'"','both');
        }
        if(!empty($partner_DOSHAM))
        {
           $this->db->like('astronomic_information','"DOSHAM":"'.$partner_DOSHAM.'"','both');
        }
        // if(!empty($partner_Expectation))
        // {
        //    $this->db->like('astronomic_information','"DOSHAM":"'.$partner_Expectation.'"','both');
        // }
        // if(!empty($partner_Other_Expectation))
        // {
        //    $this->db->like('astronomic_information','"DOSHAM":"'.$partner_Other_Expectation.'"','both');
        // }
        $this->db->order_by('member_id','desc');
        $this->db->where('is_married',0);
        $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $query=$this->db->get()->result(); 
        // echo $this->db->last_query();exit;     
        return $query;
    }
}