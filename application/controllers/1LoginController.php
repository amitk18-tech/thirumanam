<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();        
        $this->load->model('LoginModel');
        $this->load->model('MetaModel'); 
        $this->load->model('Customers_model');
         
        $this->load->helper('sms');
        $this->load->helper('emails');
        $this->load->helper('sidebar'); 
        $this->load->helper('common');       
    }

    public function login()
    {
      // print_r($this->session->userdata('thirumanam_logged_data'));exit;
        $this->load->view('front/pages/login');
    }
    public function forgetPassword()
    {
        $this->load->view('front/pages/forget_password');
    }
    public function register()
    {
      $this->load->view('front/pages/register');
    }

    public function forgotChangePassword()
    {
        $data['phone'] = $this->uri->segment(3);
        $data['gender'] = $this->uri->segment(4);
        $this->load->view('front/pages/changePass',$data);
    }
    public function checkPhone()
    {
        $phone = $this->input->post('phone');
        $gender = $this->input->post('gender');
        // print_r($gender);exit;
        $otp = $this->input->post('otp');
        if($phone!= '' && $otp != ''){
            $check = $this->Customers_model->getMemDatas('member',$phone,$gender,$otp,'row');
            // print_r($check);exit;
            if($check)
            {
                echo 1; 
            }
            else
            {
                echo 2;
            }
        }
        else{
            
            $check = $this->Customers_model->getMemDatas('member',$phone,$gender,'','row');
            // print_r($check);exit;
            if($check)
            {
                $code = rand(1000,9999);
                //$smsBody1="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
                $smsBody1="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
                $mobile = "91".$phone;
                $this->sendSms($mobile,$smsBody1);
                if(!empty($gender)){
                    $this->db->update('member',array("phoneOtp"=>$code),array('mobile'=>$phone,'gender'=>$gender));
                }else{
                    $this->db->update('member',array("phoneOtp"=>$code),array('mobile'=>$phone));
                }
                
                echo 3; // Phone Ok
            }
            else
            {
                echo 4;
            }
        }
       
    }
    public function checkAdminPhone()
    {
        $phone = $this->input->post('phone');
        $gender = $this->input->post('gender');
        // print_r($phone);exit;
        if($phone!= ''){
            $check = $this->db->get_where('member',array('mobile'=>$phone,'gender'=>$gender,'delete_status'=>0))->row_array();
            // print_r($check);exit;
            if(!empty($check))
            {
                echo 1; 
            }
            else
            {
                echo 2;
            }
        }
    }
    public function changePassword()
    {
        $inputs = $this->input->post();
        $current_password = sha1($inputs['current_password']);
        $new_password = sha1($inputs['new_password']);
        $confirm_password = sha1($inputs['confirm_password']);
        $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
        $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id,'password' => $current_password));
        // print_r($result);exit;
        if(!empty($result))
        {
            
                $this->MetaModel->updateMemberDatas('member',array('password'=>$current_password),array('password'=>$new_password));
                $this->session->set_flashdata('msg',getAlert('success','Updated Successfully'));
                redirect('profile');
            
        }else
            {
                $this->session->set_flashdata('msg',getAlert('danger','current password Did not match!!'));
                redirect('profile');
            }
    }
    public function checkPassword()
    {
        $inputs = $this->input->post();
        $new_password = sha1($inputs['new_password']);
        $match = $this->MetaModel->getMemberData('member','row',array('password' => $new_password));
        // print_r($match);exit;
        if(empty($match)){

            echo 3;
        }
    }
    public function changeNewPassword()
    {
        $inputs = $this->input->post();
        
        
        $phone = ($inputs['phone']);
        $gender = ($inputs['gender']);
        $new_password = sha1($inputs['new_password']);
        $confirm_password = sha1($inputs['confirm_password']);
        
        $result = $this->Customers_model->getMemDatas('member',$phone,$gender,'','row');
        // print_r($gender);exit;
        if(!empty($result))
        {
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $data=array(

                    'member_id'=>$result->member_id,
                    'activity' =>'changed password',
                    'location'=>$decode['city'],

                );
                $this->Customers_model->add_info('user_activity',$data);
                if(!empty($gender)){
                    $this->MetaModel->updateMemberDatas('member',array('mobile'=>$phone,'gender' => $gender),array('password'=>$new_password));
                }else{
                    $this->MetaModel->updateMemberDatas('member',array('mobile'=>$phone),array('password'=>$new_password));
                }
                $this->session->set_flashdata('msg',getAlert('success','Updated Successfully'));
                redirect('login');
            
        }else
            {

                $this->session->set_flashdata('msg',getAlert('danger','Phone Number Did not match!!'));
                redirect('forget_password');
            }
        
    }
    public function passwordVerify($gender,$mobile="")
    {
        $check2 =check_user_Mobile($mobile,$gender);
        // print_r($check2);exit;
       if(!empty($check2)){
            echo 2;
        }else{
            
            echo 4;
        }
        


    }
    
    public function passwordChangeVerify($password)
    {
        $check1 =check_user_password(sha1($password));
        // print_r($check1);exit;
        if(empty($check1)){
            echo 1;
        }
        


    }
    public function passwordProfileVerify()
    {
        $inputs = $this->input->post();
        // print_r($inputs['current_password']);exit;
        $current_password = $inputs['current_password'];
        $current_password = sha1($current_password);
        $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
        $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id,'password' => $current_password));
        if(empty($result)){
            echo 2;
        }
        


    }


  public function saveRegister()
    {
        $dob=strtotime($this->input->post('date_of_birth'));

        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        // print_r($decode);exit;
        if($decode['city']=='Moscow' || $dob==0 || $decode['city']=='Frankfurt am Main' || $decode['city']=='Sīkar' || $decode['city']=='Isfahan' || $decode['city']=='Kuala Lumpur' || $decode['city']=='Santana do Livramento')
        {
            redirect('login');
        }
        
         // print_r($decode['city']);exit;
            // recache();
            $member_approval = $this->db->get_where('general_settings', array('type' => 'member_approval_by_admin'))->row()->value;
            $member_email_verification = $this->db->get_where('general_settings', array('type' => 'member_email_verification'))->row()->value;

            // print_r($member_approval);exit;
            
            if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') {
                // $this->load->library('recaptcha');
            }
            // --------------------Check for Disallowed Characters-------------------- //
            $safe = 'yes';
            $char = '';
            foreach($_POST as $check=>$row){
                if (preg_match('/[\'^":()}{#~><>|=¬]/', $row,$match))
                {
                    if($check !== 'password' && $check !== 'confirm_password')
                    {
                        $safe = 'no';
                        $char = $match[0];
                    }
                }
                 
            }
            
            // --------------------Check for Disallowed Characters-------------------- //
            
                

                $dob=strtotime($this->input->post('date_of_birth'));
                $father=$this->input->post('father');
                $mother=$this->input->post('mother');
                $name=$this->input->post('first_name');
                $validation=array();
                if ($dob!='' && $father!='' && $mother!='') {
                    $this->db->select('*');
                    $this->db->from('member');
                    $this->db->where('date_of_birth',$dob);
                    $this->db->where('first_name',$name);
                    $this->db->like('family_info','"father":"'.$father.'"', 'both');
                    $this->db->like('family_info','"mother":"'.$mother.'"', 'both');
                    $validation=$this->db->get()->result();
                    // echo $this->db->last_query();
                } 

                if (!empty($validation)) {
                    if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') {
                        $page_data['recaptcha_html'] = $this->recaptcha->render();
                    }
                    $this->session->set_flashdata('login_msg', getAlert('warning','The Given Details already exist, so please try to login or else contact Admin'));
                    
                    $this->load->view('front/pages/registration', $page_data);
                }
                else {
                    if ($safe == 'yes') {
                        // ------------------------------------Profile Image------------------------------------ //
                      
                        if ($_POST['gender'] == 1) {
                            $profile_image[] = array('profile_image'    =>  'default.jpg',
                      'thumb'         =>  'default_thumb.jpg'
              );
                            $profile_image = json_encode($profile_image);
                        }
                        else
                        {
                            $profile_image[] = array('profile_image'    =>  'default_female.jpg',
                            'thumb'         =>  'default_female_thumb.jpg'
                    );
                         $profile_image = json_encode($profile_image);
                        }
                        // ------------------------------------Profile Image------------------------------------ //

                        // ------------------------------------Basic Info------------------------------------ //
                        $basic_info[] = array('age' => (date('Y') - date('Y', strtotime($this->input->post('date_of_birth')))),
                        'marital_status'        => '',
                        'number_of_children'    => '',
                        
                      //   'on_behalf'             => $this->input->post('on_behalf')
                        );
                        
                        $basic_info = json_encode($basic_info);
                        // ------------------------------------Basic Info------------------------------------ //

                      
                        // ------------------------------------Education & Career------------------------------------ //
                        $education_and_career[] = array('highest_education' => '',

              'STUDY_DETAILS'                    => '',
              'occupation'                    => '',
              'annual_income'                 => '',
              'Type_of_study'                 => '',
              'STUDY_DETAILS'                 => '',
              'Type_of_occupation'                 => '',
              'Other_Occupation_Details'                 => '',
              'Career_Profile'                 => '',
              'Property_Description'                 => '',

              );
                        $education_and_career = json_encode($education_and_career);
                        // ------------------------------------Education & Career------------------------------------ //

                        // ------------------------------------ Physical Attributes------------------------------------ //
                        $physical_attributes[] = array('weight'     => '',
              'eye_color'             => '',
              'hair_color'            => '',
              'complexion'            => '',
              'blood_group'           => '',
              'body_type'             => '',
              'body_art'              => '',
              'any_disability'        => ''
              );
                        $physical_attributes = json_encode($physical_attributes);
                        // ------------------------------------ Physical Attributes------------------------------------ //

                       
                        

                        // ------------------------------------ Astronomic Information------------------------------------ //
                        $astronomic_information[] = array(
              'time_of_birth'             => '',
              'date_of_birth'             => $this->input->post('date_of_birth'),
              'birthDay'             => $this->input->post('birthDay'),
              'city_of_birth'             => '',
              'PAKSHA'             => '',
              'Other_Paksha'             => '',
              'star'             => '',
              'PADAM'             => '',
              'LAKKNAM'             => '',
              'HOROSCOPE_MATCHING'             => '',
              'TITHI'             => '',
              'DOSHAM'             => '',
              'TYPE_OF_DOSHAM'             => '',
              'DIRECTIONAL_BALANCE'             => '',
              'rashi'             => '',
              );
                        $astronomic_information = json_encode($astronomic_information);
                        // ------------------------------------ Astronomic Information------------------------------------ //

                        // ------------------------------------Permanent Address------------------------------------ //
                        $permanent_address[] = array('permanent_country'    => '',
              'permanent_city'                => '',
              'permanent_state'               => '',
              'permanent_postal_code'         => '',
              'address'         => '',
              'mobile'         => $this->input->post('mobile'),
              );
                        $permanent_address = json_encode($permanent_address);
                        // ------------------------------------Permanent Address------------------------------------ //

                        // ------------------------------------Family Information------------------------------------ //
                        $family_info[] = array('father'             => '',
              'mother'                => '',
              'Surname'        => '',
              'father_vangusam'        => '',
              'mother_vangusam'        => '',
              'family_type'        => '',
              'Number_of_brothers'        => '',
              'Number_of_married_brothers'        => '',
              'Number_of_Sisters'        => '',
              'Number_of_married_sisters'        => '',
              'Soveran_Details'        => '',
              
              );
                        $family_info = json_encode($family_info);
                        // ------------------------------------Family Information------------------------------------ //

                       

                        // ------------------------------------ Partner Expectation------------------------------------ //
                        $partner_expectation[] = array('general_requirement'    => '',
              'partner_age'                       => '',
              'partner_height'                    => '',
              'partner_weight'                    => '',
              'partner_marital_status'            => '',
              'with_children_acceptables'         => '',
              'partner_country_of_residence'      => '',
              'partner_religion'                  => '',
              'partner_caste'                     => '',
              'partner_sub_caste'                  => '',
              'partner_complexion'                => '',
              'partner_education'                 => '',
              'partner_profession'                => '',
              'partner_drinking_habits'           => '',
              'partner_smoking_habits'            => '',
              'partner_diet'                      => '',
              'partner_body_type'                 => '',
              'partner_personal_value'            => '',
              'manglik'                           => '',
              'partner_any_disability'            => '',
              'partner_mother_tongue'             => '',
              'partner_family_value'              => '',
              'prefered_country'                  => '',
              'prefered_state'                    => '',
              'prefered_status'                   => '',
              'partner_DOSHAM'                    => '',
              'partner_TYPE_OF_DOSHAM'            => '',
              'partner_Expectation'               => '',
              );
                        $partner_expectation = json_encode($partner_expectation);
                        // ------------------------------------ Partner Expectation------------------------------------ //


                        // ------------------------------------ Partner Expectation------------------------------------ //
$chart[] = array( 'f010'=>"",
                              'f011'=>"",
                              'f012'=>"",
                              'f013'=>"",
                              'f014'=>"",
                              'f015'=>"",
                              'f020'=>"",
                              'f021'=>"",
                              'f022'=>"",
                              'f023'=>"",

                              'f024'=>"",
                              'f025'=>"",
                              'f030'=>"",
                              'f031'=>"",
                              'f032'=>"",
                              'f033'=>"",
                              'f034'=>"",
                              'f035'=>"",
                              'f040'=>"",
                              'f041'=>"",

                              'f042'=>"",
                              'f043'=>"",
                              'f044'=>"",
                              'f045'=>"",
                              'f110'=>"",
                              'f111'=>"",
                              'f112'=>"",
                              'f113'=>"",
                              'f114'=>"",
                              'f115'=>"",

                              'f210'=>"",
                              'f211'=>"",
                              'f212'=>"",
                              'f213'=>"",
                              'f214'=>"",
                              'f215'=>"",

                              'f310'=>"",
                              'f311'=>"",
                              'f312'=>"",
                              'f313'=>"",
                              'f314'=>"",
                              'f315'=>"",

                              'f320'=>"",
                              'f321'=>"",
                              'f322'=>"",
                              'f323'=>"",
                              'f324'=>"",
                              'f325'=>"",

                              'f410'=>"",
                              'f411'=>"",
                              'f412'=>"",
                              'f413'=>"",
                              'f414'=>"",
                              'f415'=>"",

                              'f420'=>"",
                              'f421'=>"",
                              'f422'=>"",
                              'f423'=>"",
                              'f424'=>"",
                              'f425'=>"",

                              'f430'=>"",
                              'f431'=>"",
                              'f432'=>"",
                              'f433'=>"",
                              'f434'=>"",
                              'f435'=>"",

                              'f440'=>"",
                              'f441'=>"",
                              'f442'=>"",
                              'f443'=>"",
                              'f444'=>"",
                              'f445'=>"",

                              'f510'=>"",
                              'f511'=>"",
                              'f512'=>"",
                              'f513'=>"",
                              'f514'=>"",
                              'f515'=>"",

                              'f520'=>"",
                              'f521'=>"",
                              'f522'=>"",
                              'f523'=>"",
                              'f524'=>"",
                              'f525'=>"",

                              'f530'=>"",
                              'f531'=>"",
                              'f532'=>"",
                              'f533'=>"",
                              'f534'=>"",
                              'f535'=>"",

                              'f540'=>"",
                              'f541'=>"",
                              'f542'=>"",
                              'f543'=>"",
                              'f544'=>"",
                              'f545'=>"",

                              'f610'=>"",
                              'f611'=>"",
                              'f612'=>"",
                              'f613'=>"",
                              'f614'=>"",
                              'f615'=>"",

                              'f710'=>"",
                              'f711'=>"",
                              'f712'=>"",
                              'f713'=>"",
                              'f714'=>"",
                              'f715'=>"",

                              'f810'=>"",
                              'f811'=>"",
                              'f812'=>"",
                              'f813'=>"",
                              'f814'=>"",
                              'f815'=>"",

                              'f820'=>"",
                              'f821'=>"",
                              'f822'=>"",
                              'f823'=>"",
                              'f824'=>"",
                              'f825'=>"",

                              'f910'=>"",
                              'f911'=>"",
                              'f912'=>"",
                              'f913'=>"",
                              'f914'=>"",
                              'f915'=>"",

                              'f920'=>"",
                              'f921'=>"",
                              'f922'=>"",
                              'f923'=>"",
                              'f924'=>"",
                              'f925'=>"",

                              'f930'=>"",
                              'f931'=>"",
                              'f932'=>"",
                              'f933'=>"",
                              'f934'=>"",
                              'f935'=>"",

                              'f940'=>"",
                              'f941'=>"",
                              'f942'=>"",
                              'f943'=>"",
                              'f944'=>"",
                              'f945'=>"",
                                
                                );
                        $chartData = json_encode($chart);
                        // ------------------------------------ Partner Expectation------------------------------------ //

                        // ------------------------------------Privacy Status------------------------------------ //
                        $privacy_status[] = array(
              'present_address'                 => 'no',
              'education_and_career'            => 'no',
              'physical_attributes'             => 'no',
              'language'                        => 'no',
              'hobbies_and_interest'            => 'no',
              'personal_attitude_and_behavior'  => 'no',
              'residency_information'           => 'no',
              'spiritual_and_social_background' => 'no',
              'life_style'                      => 'no',
              'astronomic_information'          => 'no',
              'permanent_address'               => 'no',
              'family_info'                     => 'no',
              'additional_personal_details'     => 'no',
              'partner_expectation'             => 'yes',
              'chart'             => 'yes'
              );
                        $privacy_status = json_encode($privacy_status);
                        // ------------------------------------Privacy Status------------------------------------ //

                        // ------------------------------------Pic Privacy Status------------------------------------ //
                        $pic_privacy[] = array(
              'profile_pic_show'        => 'all',
              'gallery_show'            => 'premium'

              );
                        $data_pic_privacy = json_encode($pic_privacy);
                        // ------------------------------------Pic Privacy Status------------------------------------ //

                        // --------------------------------- Additional Personal Details--------------------------------- //
                        $package_info[] = array('current_package'   => get_type_name_by_id('plan', '1'),
                  'package_price'     => get_type_name_by_id('plan', '1', 'amount'),
                  'payment_type'      => 'None',
              );
                        $package_info = json_encode($package_info);
                        // --------------------------------- Additional Personal Details--------------------------------- //

                   
                            

  $data['status']     = $this->input->post('approval_status');
  $data['first_name'] = $this->input->post('first_name');
  $data['last_name'] = $this->input->post('last_name');
  $data['gender'] = $this->input->post('gender');
  $data['email'] = $this->input->post('email');

  if($member_email_verification == 'on'){
    // $data['email_verification_code'] = generate_key('member','email_verification_code','TM');
    $data['email_verification_code'] =$rand_code;
      $data['email_verification_status'] = '0';
  } else {
      $data['email_verification_status'] = '1';
  }
  $data['date_of_birth'] = strtotime($this->input->post('date_of_birth'));
  $data['height'] = 0.00;
  $data['mobile'] = $this->input->post('mobile');
  $data['password'] = sha1($this->input->post('password'));
  $data['profile_image'] = $profile_image;
  $data['introduction'] = '';
  $data['basic_info'] = $basic_info;

  $data['family_info'] = $family_info;
  $data['education_and_career'] = $education_and_career;
  $data['physical_attributes'] = $physical_attributes;
  
 
  $data['astronomic_information'] = $astronomic_information;
  $data['permanent_address'] = $permanent_address;
 
  $data['partner_expectation'] = $partner_expectation;
  $data['chart'] = $chartData;
  $data['interest'] = '[]';
  $data['short_list'] = '[]';
  $data['followed'] = '[]';
  $data['ignored'] = '[]';
  $data['ignored_by'] = '[]';
  $data['gallery'] = '[]';
  $data['happy_story'] = '[]';
  $data['package_info'] = $package_info;
  $data['payments_info'] = '[]';
  $data['interested_by'] = '[]';
  $data['follower'] = 0;
  $data['notifications'] = '[]';
  $data['membership'] = 1;
  $data['is_closed'] = 'no';
  $data['profile_status'] = 1;
  $data['member_since'] = date("Y-m-d H:i:s");
  $data['member_since_for_edit_profile'] = date("Y-m-d");
  $data['express_interest'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->express_interest;
  $data['direct_messages'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->direct_messages;
  $data['photo_gallery'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->photo_gallery;
  $data['profile_completion'] = 0;
  $data['is_blocked'] = 'no';
  $data['privacy_status'] = $privacy_status;
  $data['pic_privacy'] = $data_pic_privacy;
  $data['member_type'] = 1;
  $data['active_status'] = 0;
  
  
//   if($_POST['gender'] == '1')
//       {

//           $u = $this->db->order_by('member_id','DESC')->limit(1)->get_where('member',array('gender'=>1))->row_array();

//           $getId  = str_replace("Male","",$u['member_profile_id']);
//           if($getId < 5131)
//           {
//               $data['member_profile_id'] = 'Male5131';
//           }
//           else
//           {
//               $t = $getId +1;
//               $data['member_profile_id'] = 'Male'.$t;
//           }



                            
//       }else{
//           $u = $this->db->order_by('member_id','DESC')->limit(1)->get_where('member',array('gender'=>2))->row_array();

//           $getId  = str_replace("Female","",$u['member_profile_id']);
//           if($getId < 2677)
//           {
//               $data['member_profile_id'] = 'Female2677';
//           }
//           else
//           {
//               $t = $getId +1;
//               $data['member_profile_id'] = 'Female'.$t;
//           }
        
//       }





$t = 0;
  if($_POST['gender'] == '1')
      {

          $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1))->row_array();
          
          $getId  = $u['prefixId'];
          if($getId < 5131)
          {
            $t = 5131;
              $data['member_profile_id'] = 'Male5131';
          }
          else
          {
              $t = $getId +1;
              $data['member_profile_id'] = 'Male'.$t;
          }
          // print_r($data);exit;


            
      }else{
          $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2))->row_array();

          $getId  = $u['prefixId'];
          if($getId < 2677)
          {
            $t= 2677;
              $data['member_profile_id'] = 'Female2677';
          }
          else
          {
              $t = $getId +1;
              $data['member_profile_id'] = 'Female'.$t;
          }
        
      }

      $data['prefixId'] = $t;
// TEMPORARY ID
        $data['prefixId'] = 0;
        $data['member_profile_id'] = '';
  
  
    $this->db->insert('member', $data);
    $insert_id = $this->db->insert_id();
    $ip = get_IP_address();
    $loc = file_get_contents("http://ip-api.com/json/$ip");
    $decode = json_decode($loc, true);
    $get_SERVER[] = get_SERVER();
    $server = json_encode($get_SERVER);
    // print_r($server);exit;
    $datas=array(
        'member_id'=>$insert_id,
        'activity' =>'register',
        'location' => $decode['city'],
        'country' => $decode['country'],
        'regionName' => $decode['regionName'],
        'status' => $decode['status'],
        'ip_address' => $server,
        'server' => json_encode($_SERVER)
    );
    $this->Customers_model->add_info('user_activity',$datas);
 
  recache();
// print_r($data);exit;
  if($member_approval == 'yes'){

      if ($this->LoginModel->account_opening_member_approval_on('member', $data['email'], $this->input->post('password')) == true) {
          $msg = 'done_and_sent';
      }
      if($member_email_verification == 'on'){
          $this->LoginModel->member_email_verification('member', $data['email'], $data['email_verification_code']);
      }
      $this->LoginModel->member_registration_email_to_admin($insert_id);

        $code = rand(1000,9999);
        $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$insert_id));

      $check="checked";
              $this->session->set_flashdata('alert', 'register_success');
    //   redirect(base_url().'verify_otp/'.$insert_id.'/'.$check);
  }
  else{
      if ($this->LoginModel->account_opening_member_approval_off('member', $data['email'], $this->input->post('password')) == true) {
          $msg = 'done_and_sent';
      }
      if($member_email_verification == 'on'){
          $this->LoginModel->member_email_verification('member', $data['email'], $data['email_verification_code']);
      }
      $this->LoginModel->member_registration_email_to_admin($insert_id);
      $this->session->set_flashdata('alert', 'register_success');
      if($member_email_verification == 'on'){
          redirect(base_url().'home/email_verification_msg', 'refresh');
      }
   // $getData = $this->db->get_where("member",array("member_id"=>$insert_id))->row_array();
     // $code = rand(1000,9999);
     //$mobile = "91".$data['mobile'];
     // print_r($mobile);exit;
      //$smsBody1="Dear ".$getData['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$getData['member_profile_id'].".  To access your profile kindly visit http://thirumanam.info/       ";
     // $getData1 = '';
//$smsBody1="Dear ".$getData['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$getData1.". To access your profile kindly visit http://thirumanam.info/";
     
    //   $a = $this->sendSms($mobile,$smsBody1);
      
    //   if($data['mobile']==9826983216)
    //   {
    //       //echo $a;
    //       //die();
    //   }
      
      //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is: ".$code." -SSANPM";
      
    //   $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : ".$code." -SSANPM";
     
    //  $this->sendSms($mobile,$smsBody);
      
    //     $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$insert_id));
    //     $check="checked";
              $this->session->set_flashdata('alert', 'register_success');
        // redirect(base_url().'verify_otp/'.$insert_id.'/'.$check);
 
        



   
  }

                           
                       
                    }
                    else {
                        
                        $this->load->view('front/pages/register');
                    }
                }
            }
        

    
    

    public function verifyMember()
    {
      $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];

      $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id));
      // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
      // print_r($getLatest->membership);exit;
      if($getLatest->membership!= 2)
      {
          redirect('profile');
      }
      else{                            
          // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
          // redirect("home/plans/subscribe/5");
          // redirect("home/plans/subscribe");
        

          if ($getLatest->member_type==1) {
              if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                $this->session->set_flashdata('msg',getAlert('warning','Edit Profile First'));
                  redirect('profile');
              }
              else if($getLatest->updateProfileDoneStatus==1) {
                $this->session->set_flashdata('msg',getAlert('warning','Subscribe Plan First'));
                  redirect('Subscription');
              }
              else{
                // $this->session->set_flashdata('msg',getAlert('warning','Edit Profile First'));
                  redirect('profile');
              }
          }else{
            $this->session->set_flashdata('msg',getAlert('warning','You are offline Member!!'));
              redirect('home');
          }
      }
    }

    public function do_login()
    {
        $results = $this->LoginModel->checkInfo();
          //print_r($results);exit;
        if($results==1)
        {
        $result2 = $this->LoginModel->checkInfo_2();
    //   echo'<pre>';
    //   print_r($result2);exit;
        if($result2==1)
        {   
          $username = $this->input->post('phone');
          $password = sha1($this->input->post('password'));
          $gender=$this->input->post('gender');
          $remember = $this->input->post('remember_me');
          // print_r($remember);exit;
          if(!empty($remember)){
            $remember_me = $remember;
          }else{
            $remember_me = 'off';
          }
          
          $result = $this->LoginModel->getUserInformationByAnyOne($username,$password,$gender);
          if($result->deactivate_status==1){
            $this->session->set_flashdata('msg',getAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('login');
          }
          // print_r($result);exit;
          $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1,'delete_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',getAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('login');
                
            }
         // print($expiry);exit;
          if($result->phoneVerifyStatus == 0){
            $code = rand(1000,9999);
           //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : ".$code." -SSANPM";
          $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : ".$code." -SSANPM";
          $mobile = "91".$username;
          $this->sendSms($mobile,$smsBody);

          $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),array("phoneOtp"=>$code));
            // $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$answer->member_id));

          $this->session->set_flashdata('msg',getAlert('success','Register Successfully'));
         
            redirect('verify_otp/'.$result->member_id.'/'.$remember_me);
          }else{
            // print_r($result);exit;
            $member_approval = get_settings_value('general_settings','member_approval_by_admin');
         $member_email_verification = get_settings_value('general_settings','member_email_verification');
         // print_r($member_approval);exit;
        
        // $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
        if($member_approval == 'yes'){
          if ($result->status == "approved") {
            if($member_email_verification == 'on'){
              if($result->email_verification_status == '1'){
                  $check = 'done';
              }
              else{
                $this->session->set_flashdata('msg',getAlert('warning','Email Not Verified'));
                 
                  redirect('login');
              }

              }else{
                  $check = 'done';
              }
              // print_r($check);exit;
              if($check == 'done'){
                
                // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));                            
                // if($sixDate <= date('Y-m-d')) {

                //   $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes');
                //   $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
                //   $arr2 = array('active_status'=>0);
                //   $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$arr2);
                //   //$this->db->update("member",$arr1,array("member_id"=>$result->member_id));    
                //    $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id));    
                //   // 
                //    if(!empty($result->membership_date)){

                // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
                //    $this->session->set_flashdata('msg',getAlert('warning','Your Account has been Expired'));
                // }
                     
                // }
                if ($result->is_blocked == "no" && $result->is_closed == "no") {
                  $session_data = array(
                  'member_id' => $result->member_id,
                  'member_name'=>$result->first_name,
                  'member_email'=> $result->email,
                  'mobile'=> $result->mobile,
                  'password'=> $result->password,
                  );
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                // print_r($decode);exit;
                $data=array(

                    'member_id'=>$result->member_id,
                    'activity' =>$result->first_name.' Logged In'. date('d-m-Y H:i:s'),
                    'location'=>$decode['city'],
                    'server' => json_encode($_SERVER),
                    'ip_address'=>$_SERVER['HTTP_HOST']

                );
                $this->Customers_model->add_info('user_activity',$data);
                  if ($remember_me == 'checked') {
                      $this->session->set_userdata('thirumanam_login_status', 1);
                      $this->session->set_userdata('thirumanam_logged_data', $session_data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");

                  } else {
                      $this->session->set_userdata('thirumanam_login_status', 1);
                      $this->session->set_userdata('thirumanam_logged_data', $session_data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();

                  if($getLatest->membership != 1){
                      redirect('profile');
                      // redirect( base_url().'home/edit_profile');
                  }
                  else{
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe");    
                      if ($getLatest->member_type==1) {
                          // echo "string";exit;
                          if (date('Y-m-d')>date('Y-m-d',strtotime('+7 days',$getLatest->member_since_for_edit_profile)) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('profile');        
                          }
                          else{
                              redirect('profile');
                          }  
                      }
                      else
                      {
                          redirect('home');    
                      }
                      // redirect("home/plans/subscribe/5");
                  }
              }
              elseif($result->status == "pending")
              {
                $this->session->set_flashdata('msg',getAlert('warning','Unapproved'));
                
                  redirect('login');
              }

            }

            }else{

                $this->session->set_flashdata('msg',getAlert('warning','Status Not Aproved'));
               
                    redirect('login');
            }
          }else{

            //email verification check start
            if($member_email_verification == 'on'){
                if($result->email_verification_status == '1'){
                    $check = 'done';
                }
                else{
                    $this->session->set_flashdata('msg',getAlert('warning','email not verified'));
                  
                    redirect('login');
                }
            }
            else{
                $check = 'done';
            }
            if($check == 'done'){
                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

                $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
                $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
                if($expiry <= date('Y-m-d') && !empty($result->membership_date))
                {
                    $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                    $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                    $this->session->set_flashdata('msg',getAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('login');
                    
                }
                // print_r($check);exit;
              // $get_date = $this->db->get_where("member", array("member_id" => $result->member_id))->row()->membership_date;                          
              // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));
              // if($sixDate <= date('Y-m-d')) {
              //     $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes');
              //     $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
              //     $arr2 = array('active_status'=>0);
              //     $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$arr2);
              //     // $this->db->update("member",$arr1,array("member_id"=>$result->member_id));

              //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
              //     if(!empty($result->membership_date)){
              //       // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
              //     $this->session->set_flashdata('msg',getAlert('warning','Your Account has been Expired'));
              // }
                                              
              // }                        
              
              if ($result->is_blocked == "no") {
                // print_r($check);exit;
                 
                  $session_data = array(
                  'member_id' => $result->member_id,
                  'member_name'=>$result->first_name,
                  'member_email'=> $result->email,
                  'mobile'=> $result->mobile,
                  'password'=> $result->password,
                  );
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $data=array(

                    'member_id'=>$result->member_id,
                    'activity' =>'Logged In',
                    'location'=>$decode['city'],
                    'server' => json_encode($_SERVER)

                );
                $this->Customers_model->add_info('user_activity',$data);   
                  if ($remember_me == 'checked') {
                      $this->session->set_userdata('thirumanam_login_status', 1);
                      $this->session->set_userdata('thirumanam_logged_data', $session_data);
                      setcookie('cookie_member_id', $this->session->userdata('thirumanam_logged_data')['member_id'], time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('thirumanam_logged_data')['member_name'], time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('thirumanam_logged_data')['member_email'], time() + (1296000), "/");
                  } else {
                      $this->session->set_userdata('thirumanam_login_status', 1);
                      $this->session->set_userdata('thirumanam_logged_data', $session_data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$result->member_id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
                  // print_r($getLatest->membership);exit;
                  if($getLatest->membership!= 1)
                  {
                      redirect('profile');
                  }
                  else{                            
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe/5");
                      // redirect("home/plans/subscribe");
                    

                      if ($getLatest->member_type==1) {
                          if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                            
                              redirect('profile');
                          }
                          else if($getLatest->updateProfileDoneStatus==1) {
                              redirect('Subscription');
                          }
                          else{
                              redirect('profile');
                          }
                      }else{
                          redirect('home');
                      }
                  }
              }
              elseif ($result->is_blocked == "yes") {
                $this->session->set_flashdata('msg',getAlert('warning','Blocked'));
                redirect('login');
              }

            }//check done if




          }

          }  
    
      }else{
        $this->session->set_flashdata('msg',getAlert('warning','Password Already Exist'));
      
      redirect('login');
    }

      }else{
        $this->session->set_flashdata('msg',getAlert('warning','Invalid Credentials'));
      redirect('login');   
    }
    
  }

public function verifyOtp($id,$check)
{
  // print_r($id);exit;
    $data['member_id']=$id;
    $data['remember_me']=$check;
    $this->load->view('front/pages/verify_otp',$data);
    // $this->withoutOTP($id,$check);
}

public function withoutOTP($id,$remember_me)
{

    // $id = $this->input->post('member_id');
    // $remember_me = $this->input->post('remember_me');
    // print_r($remember_me);exit;
    // $otp = $this->input->post('otp');
    $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
    // $check = $this->db->get_where('member',array('member_id'=>$id,"phoneOtp"=>$otp))->row_array();
    // print_r($remember_me);exit;
    
    if($result)
    {
         $member_approval = get_settings_value('general_settings','member_approval_by_admin');
         $member_email_verification = get_settings_value('general_settings','member_email_verification');
         // print_r($member_email_verification);exit;
        $this->MetaModel->updateMemberDatas('member',array('member_id'=>$id),array("phoneVerifyStatus"=>1));
        // $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
        if($member_approval == 'yes'){
          if ($result->status == "approved") {
            if($member_email_verification == 'on'){
              if($result->email_verification_status == '1'){
                  $check = 'done';
              }
              else{

                $this->session->set_flashdata('msg',appAlert('warning','Email Not Verified'));
                
                  redirect('login');
              }

              }else{
                  $check = 'done';
              }
              if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('login');
                
            }
               //  $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));                            
               //  if($sixDate <= date('Y-m-d')) {

               //    $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
               //    $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
               //    //$this->db->update("member",$arr1,array("member_id"=>$result->member_id));    
               //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id));   
               //     if(!empty($result->membership_date)){
               //      // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
               //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));
               // }
                     
               //  }
                if ($result->is_blocked == "no" && $result->is_closed == "no") {
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;
                  $data['mobile'] = $result->mobile;
                  $data['password'] = $result->password;
                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();
                  print_r($getLatest->membership);exit;
                  if($getLatest->membership != 1){
                      redirect('profile');
                      // redirect( base_url().'home/edit_profile');
                  }
                  else{
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe");    
                      if ($getLatest->member_type==1) {
                          // echo "string";exit;
                          if (date('Y-m-d')>date('Y-m-d',strtotime('+7 days',$getLatest->member_since_for_edit_profile)) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('profile');        
                          }
                          else{
                              redirect('profile');
                          }  
                      }
                      else
                      {
                          redirect( base_url('home'));    
                      }
                      // redirect("home/plans/subscribe/5");
                  }
              }
              elseif($result->status == "pending")
              {
                $this->session->set_flashdata('msg',appAlert('warning','Unapproved'));
                
                  redirect('login');
              }

            }

            }
          }else{

            //email verification check start
            if($member_email_verification == 'on'){
                if($result->email_verification_status == '1'){
                    $check = 'done';
                }
                else{
                    $this->session->set_flashdata('msg',appAlert('warning','Email not verified'));
                  
                    redirect('login');
                }
            }
            else{
                $check = 'done';
            }
            if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('login');
                
            }
              // $get_date = $this->db->get_where("member", array("member_id" => $result->member_id))->row()->membership_date;                          
              // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));
              // if($sixDate <= date('Y-m-d')) {
              //     $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
              //     $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
              //     // $this->db->update("member",$arr1,array("member_id"=>$result->member_id));

              //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
              //     // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
              //    if(!empty($result->membership_date)){
              //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));   
              //     }                         
              // }                        
              
              if ($result->is_blocked == "no") {
                // print_r($check);exit;
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;

                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
                  
                  if($getLatest->membership!= 1)
                  {
                      redirect( base_url().'profile', 'refresh' );
                  }
                  else{                            
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe/5");
                      // redirect("home/plans/subscribe");
                      if ($getLatest->member_type==1) {
                          if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('profile');
                          }
                          else if($getLatest->updateProfileDoneStatus==1) {
                              redirect('Subscription');
                          }
                          else{
                              redirect('profile');
                          }
                      }
                      else{
                          redirect('home');
                      }
                  }
              }
              elseif ($result->is_blocked == "yes") {
                $this->session->set_flashdata('msg',appAlert('warning','Blocked'));
               
                  redirect('login');
              }

            }//check done if




          }//else


        
    }
    else
    {
        $this->session->set_flashdata('msg',appAlert('warning','Wrong OTP'));
      
      redirect('login');
        
    }
}






function checkPhoneOtp()
{
    $id = $this->input->post('member_id');
    $remember_me = $this->input->post('remember_me');
    // print_r($remember_me);exit;
    $otp = $this->input->post('otp');
    $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id,"phoneOtp"=>$otp));
    // $check = $this->db->get_where('member',array('member_id'=>$id,"phoneOtp"=>$otp))->row_array();
    // print_r($remember_me);exit;
    
    if($result)
    {
         $member_approval = get_settings_value('general_settings','member_approval_by_admin');
         $member_email_verification = get_settings_value('general_settings','member_email_verification');
         // print_r($member_email_verification);exit;
        $this->MetaModel->updateMemberDatas('member',array('member_id'=>$id),array("phoneVerifyStatus"=>1));
        // $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
        if($member_approval == 'yes'){
          if ($result->status == "approved") {
            if($member_email_verification == 'on'){
              if($result->email_verification_status == '1'){
                  $check = 'done';
              }
              else{

                $this->session->set_flashdata('msg',getAlert('warning','Email Not Verified'));
                
                  redirect('login');
              }

              }else{
                  $check = 'done';
              }
              if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

                $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
                $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
                if($expiry <= date('Y-m-d') && !empty($result->membership_date))
                {
                    $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                    $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                    $this->session->set_flashdata('msg',getAlert('success','Your account has been deactivated!! please conact admin to activate'));
                    redirect('login');
                    
                }
               //  $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));                            
               //  if($sixDate <= date('Y-m-d')) {

               //    $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
               //    $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
               //    //$this->db->update("member",$arr1,array("member_id"=>$result->member_id));    
               //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id));   
               //     if(!empty($result->membership_date)){
               //      // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
               //     $this->session->set_flashdata('msg',getAlert('warning','Your Account has been Expired'));
               // }
                     
               //  }
                if ($result->is_blocked == "no" && $result->is_closed == "no") {
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;
                  $data['mobile'] = $result->mobile;
                  $data['password'] = $result->password;
                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_login_status', 1);
                      $this->session->set_userdata('thirumanam_logged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_login_status', 1);
                    $this->session->set_userdata('thirumanam_logged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();
                  print_r($getLatest->membership);exit;
                  if($getLatest->membership != 1){
                      redirect('profile');
                      // redirect( base_url().'home/edit_profile');
                  }
                  else{
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe");    
                      if ($getLatest->member_type==1) {
                          // echo "string";exit;
                          if (date('Y-m-d')>date('Y-m-d',strtotime('+7 days',$getLatest->member_since_for_edit_profile)) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('profile');        
                          }
                          else{
                              redirect('profile');
                          }  
                      }
                      else
                      {
                          redirect( base_url('home'));    
                      }
                      // redirect("home/plans/subscribe/5");
                  }
              }
              elseif($result->status == "pending")
              {
                $this->session->set_flashdata('msg',getAlert('warning','Unapproved'));
                
                  redirect('login');
              }

            }

            }
          }else{

            //email verification check start
            if($member_email_verification == 'on'){
                if($result->email_verification_status == '1'){
                    $check = 'done';
                }
                else{
                    $this->session->set_flashdata('msg',getAlert('warning','Email not verified'));
                  
                    redirect('login');
                }
            }
            else{
                $check = 'done';
            }
            if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',getAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('login');
                
            }

              // $get_date = $this->db->get_where("member", array("member_id" => $result->member_id))->row()->membership_date;                          
              // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));
              // if($sixDate <= date('Y-m-d')) {
              //     $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
              //     $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
              //     // $this->db->update("member",$arr1,array("member_id"=>$result->member_id));

              //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
              //     // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
              //    if(!empty($result->membership_date)){
              //     $this->session->set_flashdata('msg',getAlert('warning','Your Account has been Expired'));   
              //     }                         
              // }                        
              
              if ($result->is_blocked == "no") {
                // print_r($check);exit;
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;

                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_login_status', 1);
                    $this->session->set_userdata('thirumanam_logged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_login_status', 1);
                    $this->session->set_userdata('thirumanam_logged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
                  
                  if($getLatest->membership!= 1)
                  {
                      redirect( base_url().'profile', 'refresh' );
                  }
                  else{                            
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe/5");
                      // redirect("home/plans/subscribe");
                      if ($getLatest->member_type==1) {
                          if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('profile');
                          }
                          else if($getLatest->updateProfileDoneStatus==1) {
                              redirect('Subscription');
                          }
                          else{
                              redirect('profile');
                          }
                      }
                      else{
                          redirect('home');
                      }
                  }
              }
              elseif ($result->is_blocked == "yes") {
                $this->session->set_flashdata('msg',getAlert('warning','Blocked'));
               
                  redirect('login');
              }

            }//check done if




          }//else


        
    }
    else
    {
        $this->session->set_flashdata('msg',getAlert('warning','Wrong OTP'));
      
      redirect('verify_otp/'.$id.'/'.$remember_me);
        
    }
}

function resendOtp($id)
{
    $getData = $this->db->get_where('member',array('member_id'=>$id))->row();
    $code = rand(1000,9999);
    //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
    $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
    $mobile = "91".$getData->mobile;
    $this->sendSms($mobile,$smsBody);
    $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$id));
    $this->session->set_flashdata('msg',getAlert('success','Resend OTP Successfully'));
    
    $check="checked";
    redirect('verify_otp/'.$id.'/'.$check);
    

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

    public function do_logout()
    {
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);

        $member_id = $this->session->userdata('thirumanam_logged_data')['member_id'];
         $single = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id));

        $data=array(
            'member_id'=>$single->member_id,
            'activity' =>'Logged Out',
            'location' => $decode['city'],
            'server' => json_encode($_SERVER)
        );
        // print_r($data);exit;
        $this->Customers_model->add_info('user_activity',$data);
        $this->session->set_userdata('thirumanam_login_status', 0);
        $this->session->set_userdata('thirumanam_logged_data', array());
        $this->session->set_userdata('adv_search', array());

        $this->session->set_flashdata('msg',getAlert('success','Logged Out Successfully'));
                
        redirect('home');
    }

    public function save_user_simple()
    {   
        $otp=mt_rand(100000, 999999);
        $username=$this->input->post('profile_name');       
        $dob=date('Y-m-d',strtotime($this->input->post('profile_dob')));
        $profile_created_by=$this->input->post('register_by');
        $gender=$this->input->post('profile_gender');
        $email=$this->input->post('profile_mail');
        $password=$this->input->post('profile_password');
        $mobile_number=$this->input->post('profile_mobile');

        $ip_address=user_ip();
        $dev_type=user_device();

        $active_user_last_datas=get_user_last_datas();
        if(count($active_user_last_datas)==0)
        {
            $user_c=1;
        }
        else
        {
            $user_c=substr($active_user_last_datas['profile_id'], 2)+1;
        }

        if($user_c<10)
        {
            $profile_id='00'.$user_c;
        }
        elseif($user_c<100)
        {
            $profile_id='0'.$user_c;
        }
        else
        {
            $profile_id=$user_c;
        }

        $datas=array(
            'profile_id'=>'VM'.$profile_id,
            'username'=>$username,
            'password'=>$password,
            'gender'=>$gender,
            'email'=>$email,
            'mobile_number'=>$mobile_number,
            'user_type'=>1,
            'profile_created_by_meta'=>$profile_created_by,
            'dob'=>$dob,
            'otp'=>$otp,
            'login_ip_address'=>$ip_address,
            'login_device'=>$dev_type,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
            );

        $check_user_datas=$this->LoginModel->check_user_datas($email,$password);
        if(empty($check_user_datas))
        {
            $saved_user_id=$this->LoginModel->save_user_datas($datas);          
            $this->load->helper('emails');
          // MOBILE OTP SEND FUNCTION 

            $username = "vallikodi";
            $password = "Vallikodi@2020";
            $sender = "VKVAMM";
            $url = "http://textsms.iclienttech.com/http-api.php";
            $port = 80;
            // $message='Welcome to Vallikodi Register , Your Registration OTP Code is : '.$otp;
            $message='Welcome to Vallikodi Register , Your Registration 
Code is : '.$otp;
            $api_url = $url."?username=".urlencode($username)."&password=".urlencode($password)."&senderid=". $sender ."&route=1&unicode=2&message=".urlencode($message)."&number=".$mobile_number;
            $ch = curl_init( );
            curl_setopt ( $ch, CURLOPT_URL, $api_url );
            curl_setopt ( $ch, CURLOPT_PORT, $port );
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
            curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
            $response_string = curl_exec( $ch );
            // print_r($response_string);exit;

          // END MOBILE OTP SEND FUNCTION 

          // EMAIL OTP SEND FUNCTION

            $email_for_user_otp_notification=send_email_for_user_otp_notification($email,$otp);


          // END EMAIL OTP SEND FUNCTION             
        }
        else
        {
            $saved_user_id=$check_user_datas['user_id'];            
        }
        // exit;
        $datas['user_id']=$saved_user_id;
        $this->load->view('front/pages/user_search_query',$datas);
         $this->session->set_flashdata('msg',getAlert('success','OTP has been send to Register Mail Id')); 
        
        $datas['saved_user_id']=$saved_user_id;
        $this->template['middle'] = $this->load->view ($this->middle = 'front/pages/view_otp_page',$datas, true);
        $this->frontLayout();           
    }

    public function otp_check()
    {
       $user_id=$this->input->post('user_id');
       $user_otp=$this->input->post('user_otp');
       $user_datas=$this->ProfileModel->get_user_datas($user_id,$user_otp);

       if(count($user_datas)!=0)
       {
          $data=array(
            'status'=>1,
            'updated_at'=>date('Y-m-d H:i:s')
            );
          $this->ProfileModel->update_user_datas_new($user_id,$data);

          $results = $this->LoginModel->checkInfo_otp($user_datas['email'],$user_datas['password']);
          if($results==true)
          {
            // Email Code Start
            //  $email_for_user_welcome=send_email_for_user_welcome($user_datas);
            // Email Code End

            $username = $user_datas['email'];
            $password = $user_datas['password'];
            $answer = $this->LoginModel->getUserInformationByAnyOne($username,$password);
            $session_data = array(
            'member_id' => $answer->member_id,
            'member_name'=>$answer->first_name,
            'v_status'=>$answer->verified_status,
            'gender'=>$answer->gender,
            'mobile'=> $answer->mobile,
            'password'=> $answer->password,
            );
            $this->session->set_userdata('thirumanam_login_status', 1);
            $this->session->set_userdata('thirumanam_logged_data', $session_data); 
             $this->session->set_flashdata('msg',getAlert('success','Your OTP has been Successfully Verified'));            
            
            redirect('myprofile');
          }
          else
          {       
          $this->session->set_flashdata('msg',getAlert('danger','User Credentials Seems to be Invalid'));      
                       
            redirect('home');
          }
       }
       else
       {
          $datas['saved_user_id']=$user_id;
          $this->session->set_flashdata('msg',getAlert('danger','OTP is Not Valid'));    
                              
          $this->template['middle'] = $this->load->view ($this->middle = 'front/pages/view_otp_page',$datas, true);
          $this->FrontLayout();
       }
    }

  public function resend_otp_user()
    {
        $user_id=$this->input->post('user_id');
        $get_user_datas=$this->LoginModel->get_login_user_datas($user_id);
        $mobile_number=$get_user_datas['mobile_number'];
        $user_email=$get_user_datas['email'];
        $user_otp=$get_user_datas['otp'];       
        $email_for_user_otp_notification=send_email_for_user_otp_notification($user_email,$user_otp);
    }

   public function admin_login()
  {
    if (!isset($this->session->userdata['THIRUMANAM_ADMIN_SESSION']))
    {
      $this->load->view('Administrator/admin_login');
    }
    else
    {
      redirect('administrator/home');
    }
  }

  public function isValidAdmin()
    {
        $isValidRequest = isValidRequest('POST', $_SERVER['REQUEST_METHOD'], true);        
        if ($isValidRequest) {
            $inputs = $this->input->post();            
            if ((isset($inputs['username']) && $inputs['username'] != "") && (isset($inputs['password']) && $inputs['password'] != ""))
            {               
                $admin = $this->LoginModel->isValidAdmin($inputs); 
                // print_r($admin);exit();                 
                if (!empty($admin)) {
                    $admin['user_type']=1;
                    $this->load->library('session');
                    $this->session->set_userdata('THIRUMANAM_ADMIN_SESSION',$admin);

                    $this->session->set_flashdata('msg', showAlert('success', 'Logged In Successfully'));
                    $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                    $data = array(

                    'admin_id'=>$admin_id,
                    'activity'=> 'Logged In',
                    );
                    $this->Customers_model->add_info('admin_activity',$data); 
                    redirect('administrator/home');
                } else {
                    $this->session->set_flashdata('login_msg', showAlert('danger', 'Invalid Credentials'));
                    redirect('administrator');   
                }
                    
            }else{
                $this->session->set_flashdata('login_msg', showAlert('danger', 'Invalid Credentials'));
                redirect('administrator');
            }
        } else {            
            $this->session->set_flashdata('login_msg', showAlert('danger', 'Invalid Request'));
            redirect('administrator');
        }
    }

 

  public function admin_logout()
  {
    $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
    $data = array(

    'admin_id'=>$admin_id,
    'activity'=> 'Logged Out',
    );
    $this->Customers_model->add_info('admin_activity',$data);
    $this->session->unset_userdata('THIRUMANAM_ADMIN_SESSION');
    $this->session->sess_destroy();
    $this->session->set_flashdata('login_msg', showAlert('success', 'Logged Out Successfully'));
    redirect('administrator');
  }

  public function forgetEmail()
    {
      $toemail = $this->input->post('email');
      $inputs = getData('admin','row',array('email'=>$toemail));
      if(!empty($inputs)){
        $from_name=$this->Customers_model->getData('general_settings','row',array('type' => 'system_name'));
      $subject = $this->db->get_where('email_template', array('email_template_id' => 1))->row()->subject;
      $email_body = $this->db->get_where('email_template', array('email_template_id' => 1))->row()->body;
      
     $pass_txt = substr(rand(),0,12);
      
      // $pass = substr(hash('sha1', rand()), 0, 12);
      
     $data['password'] = sha1($pass_txt);
      $to_name = $inputs->name;
      $account_type = 'Admin';

      $email_body = str_replace('[[to]]', $to_name, $email_body);
      $email_body = str_replace('[[account_type]]', $account_type, $email_body);
      $email_body = str_replace('[[password]]', $pass_txt, $email_body);

      $email_body = str_replace('[[from]]', $from_name->value, $email_body);
      $email['text'] = $email_body;
     // print_r($data);
      $this->Customers_model->updateInfo('admin',$data,array('admin_id'=>$inputs->admin_id));
      //echo $this->db->last_query();exit;
        
        // print_r($toemail);exit;
        $from=$this->Customers_model->getData('general_settings','row',array('type' => 'system_email'));
        $smtp_host=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_host'));
        $smtp_user=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_user'));
        $smtp_pass=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_pass'));
        $smtp_port=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_port'));
        
          
          
          // $this->load->view('Administrator/emails/forgetmail',$email);
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
            $msg=$this->load->view('Administrator/emails/forgetmail',$email, true);
            $this->email->message($msg);
            $mail_result=$this->email->send();
            if($mail_result==1)
            {
                //$mail_status='send';
                $this->session->set_flashdata('msg',getAlert('success','Send Successfully'));        
                redirect('administrator');
                
            }
            else
            {
                echo $this->email->print_debugger();exit;
                $mail_status='not-send';
            }
        
        }else{

            $this->session->set_flashdata('msg',getAlert('danger','MisMatch Email!!!'));        
            redirect('administrator');
        }
      
            //echo $mail_status;
            

        
        
       
    }

    public function app_do_login()
    {

        $results = $this->LoginModel->checkInfo();
         // print_r($results);exit;
        if($results==1)
        {
        $result2 = $this->LoginModel->checkInfo_2();
      // echo'<pre>';
      // print_r($result2);exit;
        if($result2==1)
        {   
          $username = $this->input->post('phone');
          $password = sha1($this->input->post('password'));
          $gender=$this->input->post('gender');
          $remember = $this->input->post('remember_me');
          
          if(!empty($remember)){
            $remember_me = $remember;
          }else{
            $remember_me = 'off';
          }
          // print_r($remember_me);exit;
          $result = $this->LoginModel->getUserInformationByAnyOne($username,$password,$gender);
          if($result->deactivate_status==1){
            $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('app/login');
          }
          // print_r($result);exit;
          $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'deactivate_status'=>1,'is_closed'=>'yes');
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('app/login');
                
            }
         // print($expiry);exit;
          if($result->phoneVerifyStatus == 0){
            $code = rand(1000,9999);
           //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : ".$code." -SSANPM";
          $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : ".$code." -SSANPM";
          $mobile = "91".$username;
          $this->sendSms($mobile,$smsBody);

          $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),array("phoneOtp"=>$code));
            // $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$answer->member_id));

          // $this->session->set_flashdata('msg',appAlert('success','Register Successfully'));
         
            redirect('app_verify_otp/'.$result->member_id.'/'.$remember_me);
          }else{
            // print_r($result);exit;
            $member_approval = get_settings_value('general_settings','member_approval_by_admin');
         $member_email_verification = get_settings_value('general_settings','member_email_verification');
         // print_r($member_approval);exit;
        
        // $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
        if($member_approval == 'yes'){
          if ($result->status == "approved") {
            if($member_email_verification == 'on'){
              if($result->email_verification_status == '1'){
                  $check = 'done';
              }
              else{
                $this->session->set_flashdata('msg',appAlert('warning','Email Not Verified'));
                 
                  redirect('app/login');
              }

              }else{
                  $check = 'done';
              }
              // print_r($check);exit;
              if($check == 'done'){

                // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));                            
                // if($sixDate <= date('Y-m-d')) {

                //   $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes');
                //   $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
                //   $arr2 = array('active_status'=>0);
                //   $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$arr2);
                //   //$this->db->update("member",$arr1,array("member_id"=>$result->member_id));    
                //    $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
                //    if(!empty($result->membership_date)){   
                //   // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
                //    $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));
                //      }
                // }
                if ($result->is_blocked == "no" && $result->is_closed == "no") {
                  $session_data = array(
                  'member_id' => $result->member_id,
                  'member_name'=>$result->first_name,
                  'member_email'=> $result->email,
                  'mobile'=> $result->mobile,
                  'password'=> $result->password,
                  );
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $data=array(

                    'member_id'=>$result->member_id,
                    'activity' =>'Logged In',
                    'location'=>$decode['city'],
                    'server' => json_encode($_SERVER)

                );
                $this->Customers_model->add_info('user_activity',$data);
                  if ($remember_me == 'checked') {
                      $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data', $session_data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");

                  } else {
                      $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data', $session_data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();

                  if($getLatest->membership != 1){
                      redirect('app/profile');
                      // redirect( base_url().'home/edit_profile');
                  }
                  else{
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe");    
                      if ($getLatest->member_type==1) {
                          // echo "string";exit;
                          if (date('Y-m-d')>date('Y-m-d',strtotime('+7 days',$getLatest->member_since_for_edit_profile)) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('app/profile');        
                          }
                          else{
                              redirect('app/profile');
                          }  
                      }
                      else
                      {
                          redirect('app/home');    
                      }
                      // redirect("home/plans/subscribe/5");
                  }
              }
              elseif($result->status == "pending")
              {
                $this->session->set_flashdata('msg',appAlert('warning','Unapproved'));
                
                  redirect('app/login');
              }

            }

            }else{

                $this->session->set_flashdata('msg',appAlert('warning','Status Not Aproved'));
               
                    redirect('app/login');
            }
          }else{

            //email verification check start
            if($member_email_verification == 'on'){
                if($result->email_verification_status == '1'){
                    $check = 'done';
                }
                else{
                    $this->session->set_flashdata('msg',appAlert('warning','email not verified'));
                  
                    redirect('app/login');
                }
            }
            else{
                $check = 'done';
            }
            if($check == 'done'){
                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

                $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'deactivate_status'=>1,'is_closed'=>'yes');
                $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
                if($expiry <= date('Y-m-d') && !empty($result->membership_date))
                {
                    $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                    $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                    $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                    redirect('app/login');
                    
                }
                // print_r($check);exit;
              // $get_date = $this->db->get_where("member", array("member_id" => $result->member_id))->row()->membership_date;                          
              // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));
              // if($sixDate <= date('Y-m-d')) {
              //     $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes');
              //     $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
              //     $arr2 = array('active_status'=>0);
              //     $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$arr2);
              //     // $this->db->update("member",$arr1,array("member_id"=>$result->member_id));

              //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
              //     if(!empty($result->membership_date)){
              //     // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
              //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));
              // }
                                              
              // }                        
              
              if ($result->is_blocked == "no") {
                // print_r($check);exit;
                 
                  $session_data = array(
                  'member_id' => $result->member_id,
                  'member_name'=>$result->first_name,
                  'member_email'=> $result->email,
                  'mobile'=> $result->mobile,
                  'password'=> $result->password,
                  );
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $data=array(

                    'member_id'=>$result->member_id,
                    'activity' =>'Logged In',
                    'location'=>$decode['city'],
                    'server' => json_encode($_SERVER)

                );
                $this->Customers_model->add_info('user_activity',$data);   
                  if ($remember_me == 'checked') {
                      $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data', $session_data);
                      setcookie('cookie_member_id', $this->session->userdata('thirumanam_logged_data')['member_id'], time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('thirumanam_logged_data')['member_name'], time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('thirumanam_logged_data')['member_email'], time() + (1296000), "/");
                  } else {
                      $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data', $session_data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$result->member_id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
                  // print_r($getLatest->membership);exit;
                  if($getLatest->membership!= 1)
                  {
                      redirect('app/profile');
                  }
                  else{                            
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe/5");
                      // redirect("home/plans/subscribe");
                    

                      if ($getLatest->member_type==1) {
                          if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                            
                              redirect('app/profile');
                          }
                          else if($getLatest->updateProfileDoneStatus==1) {
                              redirect('app/Subscription');
                          }
                          else{
                              redirect('app/profile');
                          }
                      }else{
                          redirect('app/home');
                      }
                  }
              }
              elseif ($result->is_blocked == "yes") {
                $this->session->set_flashdata('msg',appAlert('warning','Blocked'));
                redirect('app/login');
              }

            }//check done if




          }

          }  
    
      }else{
        $this->session->set_flashdata('msg',appAlert('warning','Password Already Exist'));
      
      redirect('app/login');
    }

      }else{
        $this->session->set_flashdata('msg',appAlert('warning','Invalid Credentials'));
      redirect('app/login');   
    }
    
  }

  public function apppasswordProfileVerify()
    {
        $inputs = $this->input->post();
        // print_r($inputs['current_password']);exit;
        $current_password = $inputs['current_password'];
        $current_password = sha1($current_password);
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id,'password' => $current_password));
        if(empty($result)){
            echo 2;
        }
     }

    public function appchangePassword()
    {
        $inputs = $this->input->post();
        $current_password = sha1($inputs['current_password']);
        $new_password = sha1($inputs['new_password']);
        $confirm_password = sha1($inputs['confirm_password']);
        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
        $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id,'password' => $current_password));
        // print_r($result);exit;
        if(!empty($result))
        {
            
                $this->MetaModel->updateMemberDatas('member',array('password'=>$current_password),array('password'=>$new_password));
                $this->session->set_flashdata('msg',appAlert('success','Updated Successfully'));
                redirect('app/change_password');
            
        }else
            {
                $this->session->set_flashdata('msg',appAlert('danger','current password Did not match!!'));
                redirect('app/change_password');
            }
    }


    public function app_do_logout()
    {
        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);

        $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];
         $single = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id));

        $data=array(
            'member_id'=>$single->member_id,
            'activity' =>'Logged Out',
            'location' => $decode['city'],
            'server' => json_encode($_SERVER)
        );
        // print_r($data);exit;
        $this->Customers_model->add_info('user_activity',$data);
        $this->session->set_userdata('thirumanam_applogin_status', 0);
        $this->session->set_userdata('thirumanam_applogged_data', array());

        $this->session->set_flashdata('msg',appAlert('success','Logged Out Successfully'));
                
        redirect('app/login');
    }

    public function appregister()
    {
      $this->load->view('app/register');
 
    }

    public function apppasswordVerify($gender,$mobile="")
    {
        $check2 =check_user_Mobile($mobile,$gender);
        // print_r($check2);exit;
       if(!empty($check2)){
            echo 2;
        }else{
            
            echo 4;
        }
    }

   public function appsaveRegister()
    {
        $dob=strtotime($this->input->post('date_of_birth'));

        $ip = get_IP_address();
        $loc = file_get_contents("http://ip-api.com/json/$ip");
        $decode = json_decode($loc, true);
        if($decode['city']=='Moscow' || $dob==0 || $decode['city']=='Frankfurt am Main')
        {
            redirect('login');
        }
         // print_r($dob);exit;
            recache();
            $member_approval = $this->db->get_where('general_settings', array('type' => 'member_approval_by_admin'))->row()->value;
            $member_email_verification = $this->db->get_where('general_settings', array('type' => 'member_email_verification'))->row()->value;

            // print_r($member_approval);exit;
            
            if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') {
                // $this->load->library('recaptcha');
            }
            // --------------------Check for Disallowed Characters-------------------- //
            $safe = 'yes';
            $char = '';
            foreach($_POST as $check=>$row){
                if (preg_match('/[\'^":()}{#~><>|=¬]/', $row,$match))
                {
                    if($check !== 'password' && $check !== 'confirm_password')
                    {
                        $safe = 'no';
                        $char = $match[0];
                    }
                }
            }
            
            // --------------------Check for Disallowed Characters-------------------- //
            
                

                $dob=strtotime($this->input->post('date_of_birth'));
                $father=$this->input->post('father');
                $mother=$this->input->post('mother');
                $name=$this->input->post('first_name');
                $validation=array();
                if ($dob!='' && $father!='' && $mother!='') {
                    $this->db->select('*');
                    $this->db->from('member');
                    $this->db->where('date_of_birth',$dob);
                    $this->db->where('first_name',$name);
                    $this->db->like('family_info','"father":"'.$father.'"', 'both');
                    $this->db->like('family_info','"mother":"'.$mother.'"', 'both');
                    $validation=$this->db->get()->result();
                    // echo $this->db->last_query();
                } 

                if (!empty($validation)) {
                    if (get_settings_value('third_party_settings', 'captcha_status', 'value') == 'ok') {
                        $page_data['recaptcha_html'] = $this->recaptcha->render();
                    }
                    $this->session->set_flashdata('login_msg', getAlert('warning','The Given Details already exist, so please try to login or else contact Admin'));
                    
                    $this->load->view('front/pages/registration', $page_data);
                }
                else {
                    if ($safe == 'yes') {
                        // ------------------------------------Profile Image------------------------------------ //
                      
                        if ($_POST['gender'] == 1) {
                            $profile_image[] = array('profile_image'    =>  'default.jpg',
                      'thumb'         =>  'default_thumb.jpg'
              );
                            $profile_image = json_encode($profile_image);
                        }
                        else
                        {
                            $profile_image[] = array('profile_image'    =>  'default_female.jpg',
                            'thumb'         =>  'default_female_thumb.jpg'
                    );
                         $profile_image = json_encode($profile_image);
                        }
                        // ------------------------------------Profile Image------------------------------------ //

                        // ------------------------------------Basic Info------------------------------------ //
                        $basic_info[] = array('age' => (date('Y') - date('Y', strtotime($this->input->post('date_of_birth')))),
                        'marital_status'        => '',
                        'number_of_children'    => '',
                        
                      //   'on_behalf'             => $this->input->post('on_behalf')
                        );
                        
                        $basic_info = json_encode($basic_info);
                        // ------------------------------------Basic Info------------------------------------ //

                      
                        // ------------------------------------Education & Career------------------------------------ //
                        $education_and_career[] = array('highest_education' => '',

              'STUDY_DETAILS'                    => '',
              'occupation'                    => '',
              'annual_income'                 => '',
              'Type_of_study'                 => '',
              'STUDY_DETAILS'                 => '',
              'Type_of_occupation'                 => '',
              'Other_Occupation_Details'                 => '',
              'Career_Profile'                 => '',
              'Property_Description'                 => '',

              );
                        $education_and_career = json_encode($education_and_career);
                        // ------------------------------------Education & Career------------------------------------ //

                        // ------------------------------------ Physical Attributes------------------------------------ //
                        $physical_attributes[] = array('weight'     => '',
              'eye_color'             => '',
              'hair_color'            => '',
              'complexion'            => '',
              'blood_group'           => '',
              'body_type'             => '',
              'body_art'              => '',
              'any_disability'        => ''
              );
                        $physical_attributes = json_encode($physical_attributes);
                        // ------------------------------------ Physical Attributes------------------------------------ //

                       
                        

                        // ------------------------------------ Astronomic Information------------------------------------ //
                        $astronomic_information[] = array(
              'time_of_birth'             => '',
              'date_of_birth'             => $this->input->post('date_of_birth'),
              'birthDay'             => $this->input->post('birthDay'),
              'city_of_birth'             => '',
              'PAKSHA'             => '',
              'Other_Paksha'             => '',
              'star'             => '',
              'PADAM'             => '',
              'LAKKNAM'             => '',
              'HOROSCOPE_MATCHING'             => '',
              'TITHI'             => '',
              'DOSHAM'             => '',
              'TYPE_OF_DOSHAM'             => '',
              'DIRECTIONAL_BALANCE'             => '',
              'rashi'             => '',
              );
                        $astronomic_information = json_encode($astronomic_information);
                        // ------------------------------------ Astronomic Information------------------------------------ //

                        // ------------------------------------Permanent Address------------------------------------ //
                        $permanent_address[] = array('permanent_country'    => '',
              'permanent_city'                => '',
              'permanent_state'               => '',
              'permanent_postal_code'         => '',
              'address'         => '',
              'mobile'         => $this->input->post('mobile'),
              );
                        $permanent_address = json_encode($permanent_address);
                        // ------------------------------------Permanent Address------------------------------------ //

                        // ------------------------------------Family Information------------------------------------ //
                        $family_info[] = array('father'             => '',
              'mother'                => '',
              'Surname'        => '',
              'father_vangusam'        => '',
              'mother_vangusam'        => '',
              'family_type'        => '',
              'Number_of_brothers'        => '',
              'Number_of_married_brothers'        => '',
              'Number_of_Sisters'        => '',
              'Number_of_married_sisters'        => '',
              'Soveran_Details'        => '',
              
              );
                        $family_info = json_encode($family_info);
                        // ------------------------------------Family Information------------------------------------ //

                       

                        // ------------------------------------ Partner Expectation------------------------------------ //
                        $partner_expectation[] = array('general_requirement'    => '',
              'partner_age'                       => '',
              'partner_height'                    => '',
              'partner_weight'                    => '',
              'partner_marital_status'            => '',
              'with_children_acceptables'         => '',
              'partner_country_of_residence'      => '',
              'partner_religion'                  => '',
              'partner_caste'                     => '',
              'partner_sub_caste'                  => '',
              'partner_complexion'                => '',
              'partner_education'                 => '',
              'partner_profession'                => '',
              'partner_drinking_habits'           => '',
              'partner_smoking_habits'            => '',
              'partner_diet'                      => '',
              'partner_body_type'                 => '',
              'partner_personal_value'            => '',
              'manglik'                           => '',
              'partner_any_disability'            => '',
              'partner_mother_tongue'             => '',
              'partner_family_value'              => '',
              'prefered_country'                  => '',
              'prefered_state'                    => '',
              'prefered_status'                   => '',
              'partner_DOSHAM'                    => '',
              'partner_TYPE_OF_DOSHAM'            => '',
              'partner_Expectation'               => '',
              );
                        $partner_expectation = json_encode($partner_expectation);
                        // ------------------------------------ Partner Expectation------------------------------------ //


                        // ------------------------------------ Partner Expectation------------------------------------ //
$chart[] = array( 'f010'=>"",
                              'f011'=>"",
                              'f012'=>"",
                              'f013'=>"",
                              'f014'=>"",
                              'f015'=>"",
                              'f020'=>"",
                              'f021'=>"",
                              'f022'=>"",
                              'f023'=>"",

                              'f024'=>"",
                              'f025'=>"",
                              'f030'=>"",
                              'f031'=>"",
                              'f032'=>"",
                              'f033'=>"",
                              'f034'=>"",
                              'f035'=>"",
                              'f040'=>"",
                              'f041'=>"",

                              'f042'=>"",
                              'f043'=>"",
                              'f044'=>"",
                              'f045'=>"",
                              'f110'=>"",
                              'f111'=>"",
                              'f112'=>"",
                              'f113'=>"",
                              'f114'=>"",
                              'f115'=>"",

                              'f210'=>"",
                              'f211'=>"",
                              'f212'=>"",
                              'f213'=>"",
                              'f214'=>"",
                              'f215'=>"",

                              'f310'=>"",
                              'f311'=>"",
                              'f312'=>"",
                              'f313'=>"",
                              'f314'=>"",
                              'f315'=>"",

                              'f320'=>"",
                              'f321'=>"",
                              'f322'=>"",
                              'f323'=>"",
                              'f324'=>"",
                              'f325'=>"",

                              'f410'=>"",
                              'f411'=>"",
                              'f412'=>"",
                              'f413'=>"",
                              'f414'=>"",
                              'f415'=>"",

                              'f420'=>"",
                              'f421'=>"",
                              'f422'=>"",
                              'f423'=>"",
                              'f424'=>"",
                              'f425'=>"",

                              'f430'=>"",
                              'f431'=>"",
                              'f432'=>"",
                              'f433'=>"",
                              'f434'=>"",
                              'f435'=>"",

                              'f440'=>"",
                              'f441'=>"",
                              'f442'=>"",
                              'f443'=>"",
                              'f444'=>"",
                              'f445'=>"",

                              'f510'=>"",
                              'f511'=>"",
                              'f512'=>"",
                              'f513'=>"",
                              'f514'=>"",
                              'f515'=>"",

                              'f520'=>"",
                              'f521'=>"",
                              'f522'=>"",
                              'f523'=>"",
                              'f524'=>"",
                              'f525'=>"",

                              'f530'=>"",
                              'f531'=>"",
                              'f532'=>"",
                              'f533'=>"",
                              'f534'=>"",
                              'f535'=>"",

                              'f540'=>"",
                              'f541'=>"",
                              'f542'=>"",
                              'f543'=>"",
                              'f544'=>"",
                              'f545'=>"",

                              'f610'=>"",
                              'f611'=>"",
                              'f612'=>"",
                              'f613'=>"",
                              'f614'=>"",
                              'f615'=>"",

                              'f710'=>"",
                              'f711'=>"",
                              'f712'=>"",
                              'f713'=>"",
                              'f714'=>"",
                              'f715'=>"",

                              'f810'=>"",
                              'f811'=>"",
                              'f812'=>"",
                              'f813'=>"",
                              'f814'=>"",
                              'f815'=>"",

                              'f820'=>"",
                              'f821'=>"",
                              'f822'=>"",
                              'f823'=>"",
                              'f824'=>"",
                              'f825'=>"",

                              'f910'=>"",
                              'f911'=>"",
                              'f912'=>"",
                              'f913'=>"",
                              'f914'=>"",
                              'f915'=>"",

                              'f920'=>"",
                              'f921'=>"",
                              'f922'=>"",
                              'f923'=>"",
                              'f924'=>"",
                              'f925'=>"",

                              'f930'=>"",
                              'f931'=>"",
                              'f932'=>"",
                              'f933'=>"",
                              'f934'=>"",
                              'f935'=>"",

                              'f940'=>"",
                              'f941'=>"",
                              'f942'=>"",
                              'f943'=>"",
                              'f944'=>"",
                              'f945'=>"",
                                
                                );
                        $chartData = json_encode($chart);
                        // ------------------------------------ Partner Expectation------------------------------------ //

                        // ------------------------------------Privacy Status------------------------------------ //
                        $privacy_status[] = array(
              'present_address'                 => 'no',
              'education_and_career'            => 'no',
              'physical_attributes'             => 'no',
              'language'                        => 'no',
              'hobbies_and_interest'            => 'no',
              'personal_attitude_and_behavior'  => 'no',
              'residency_information'           => 'no',
              'spiritual_and_social_background' => 'no',
              'life_style'                      => 'no',
              'astronomic_information'          => 'no',
              'permanent_address'               => 'no',
              'family_info'                     => 'no',
              'additional_personal_details'     => 'no',
              'partner_expectation'             => 'yes',
              'chart'             => 'yes'
              );
                        $privacy_status = json_encode($privacy_status);
                        // ------------------------------------Privacy Status------------------------------------ //

                        // ------------------------------------Pic Privacy Status------------------------------------ //
                        $pic_privacy[] = array(
              'profile_pic_show'        => 'all',
              'gallery_show'            => 'premium'

              );
                        $data_pic_privacy = json_encode($pic_privacy);
                        // ------------------------------------Pic Privacy Status------------------------------------ //

                        // --------------------------------- Additional Personal Details--------------------------------- //
                        $package_info[] = array('current_package'   => get_type_name_by_id('plan', '1'),
                  'package_price'     => get_type_name_by_id('plan', '1', 'amount'),
                  'payment_type'      => 'None',
              );
                        $package_info = json_encode($package_info);
                        // --------------------------------- Additional Personal Details--------------------------------- //

                   
                            if (1) {

  $data['status']     = $this->input->post('approval_status');
  $data['first_name'] = $this->input->post('first_name');
  $data['last_name'] = $this->input->post('last_name');
  $data['gender'] = $this->input->post('gender');
  $data['email'] = $this->input->post('email');

  if($member_email_verification == 'on'){
      $data['email_verification_code'] = generate_key('member','email_verification_code','');
      $data['email_verification_status'] = '0';
  } else {
      $data['email_verification_status'] = '1';
  }
  $data['date_of_birth'] = strtotime($this->input->post('date_of_birth'));
  $data['height'] = 0.00;
  $data['mobile'] = $this->input->post('mobile');
  $data['password'] = sha1($this->input->post('password'));
  $data['profile_image'] = $profile_image;
  $data['introduction'] = '';
  $data['basic_info'] = $basic_info;

  $data['family_info'] = $family_info;
  $data['education_and_career'] = $education_and_career;
  $data['physical_attributes'] = $physical_attributes;
  
 
  $data['astronomic_information'] = $astronomic_information;
  $data['permanent_address'] = $permanent_address;
 
  $data['partner_expectation'] = $partner_expectation;
  $data['chart'] = $chartData;
  $data['interest'] = '[]';
  $data['short_list'] = '[]';
  $data['followed'] = '[]';
  $data['ignored'] = '[]';
  $data['ignored_by'] = '[]';
  $data['gallery'] = '[]';
  $data['happy_story'] = '[]';
  $data['package_info'] = $package_info;
  $data['payments_info'] = '[]';
  $data['interested_by'] = '[]';
  $data['follower'] = 0;
  $data['notifications'] = '[]';
  $data['membership'] = 1;
  $data['is_closed'] = 'no';
  $data['profile_status'] = 1;
  $data['member_since'] = date("Y-m-d H:i:s");
  $data['member_since_for_edit_profile'] = date("Y-m-d");
  $data['express_interest'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->express_interest;
  $data['direct_messages'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->direct_messages;
  $data['photo_gallery'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->photo_gallery;
  $data['profile_completion'] = 0;
  $data['is_blocked'] = 'no';
  $data['privacy_status'] = $privacy_status;
  $data['pic_privacy'] = $data_pic_privacy;
  $data['member_type'] = 1;
  $data['active_status'] = 0;
  
  
//   if($_POST['gender'] == '1')
//       {

//           $u = $this->db->order_by('member_id','DESC')->limit(1)->get_where('member',array('gender'=>1))->row_array();

//           $getId  = str_replace("Male","",$u['member_profile_id']);
//           if($getId < 5131)
//           {
//               $data['member_profile_id'] = 'Male5131';
//           }
//           else
//           {
//               $t = $getId +1;
//               $data['member_profile_id'] = 'Male'.$t;
//           }



                            
//       }else{
//           $u = $this->db->order_by('member_id','DESC')->limit(1)->get_where('member',array('gender'=>2))->row_array();

//           $getId  = str_replace("Female","",$u['member_profile_id']);
//           if($getId < 2677)
//           {
//               $data['member_profile_id'] = 'Female2677';
//           }
//           else
//           {
//               $t = $getId +1;
//               $data['member_profile_id'] = 'Female'.$t;
//           }
        
//       }





$t = 0;
  if($_POST['gender'] == '1')
      {

          $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1))->row_array();
          
          $getId  = $u['prefixId'];
          if($getId < 5131)
          {
            $t = 5131;
              $data['member_profile_id'] = 'Male5131';
          }
          else
          {
              $t = $getId +1;
              $data['member_profile_id'] = 'Male'.$t;
          }
          // print_r($data);exit;


            
      }else{
          $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2))->row_array();

          $getId  = $u['prefixId'];
          if($getId < 2677)
          {
            $t= 2677;
              $data['member_profile_id'] = 'Female2677';
          }
          else
          {
              $t = $getId +1;
              $data['member_profile_id'] = 'Female'.$t;
          }
        
      }

      $data['prefixId'] = $t;
// TEMPORARY ID
        $data['prefixId'] = 0;
        $data['member_profile_id'] = '';
  
  
  $this->db->insert('member', $data);
  $insert_id = $this->db->insert_id();
  $ip = get_IP_address();
$loc = file_get_contents("http://ip-api.com/json/$ip");
$decode = json_decode($loc, true);
$datas=array(
    'member_id'=>$insert_id,
    'activity' =>'register',
    'location' => $decode['city'],
    'ip_address' => user_ip(),
    'server' => json_encode($_SERVER)
);
$this->Customers_model->add_info('user_activity',$datas);
 
  recache();
// print_r($data);exit;
  if($member_approval == 'yes'){

      if ($this->LoginModel->account_opening_member_approval_on('member', $data['email'], $this->input->post('password')) == true) {
          $msg = 'done_and_sent';
      }
      if($member_email_verification == 'on'){
          $this->LoginModel->member_email_verification('member', $data['email'], $data['email_verification_code']);
      }
      $this->LoginModel->member_registration_email_to_admin($insert_id);

        $code = rand(1000,9999);
        $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$insert_id));

      $check="checked";
           //   $this->session->set_flashdata('alert', 'register_success');
      redirect(base_url().'verify_otp/'.$insert_id.'/'.$check);
  }
  else{
      if ($this->LoginModel->account_opening_member_approval_off('member', $data['email'], $this->input->post('password')) == true) {
          $msg = 'done_and_sent';
      }
      if($member_email_verification == 'on'){
          $this->LoginModel->member_email_verification('member', $data['email'], $data['email_verification_code']);
      }
      $this->LoginModel->member_registration_email_to_admin($insert_id);
      $this->session->set_flashdata('alert', 'register_success');
      if($member_email_verification == 'on'){
          redirect(base_url().'home/email_verification_msg', 'refresh');
      }
    $getData = $this->db->get_where("member",array("member_id"=>$insert_id))->row_array();
      $code = rand(1000,9999);
     $mobile = "91".$data['mobile'];
     // print_r($mobile);exit;
      //$smsBody1="Dear ".$getData['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$getData['member_profile_id'].".  To access your profile kindly visit http://thirumanam.info/       ";
      $getData1 = '';
      $smsBody1="Dear ".$getData['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$getData1.". To access your profile kindly visit http://thirumanam.info/";
     
      $a = $this->sendSms($mobile,$smsBody1);
      
      if($data['mobile']==9826983216)
      {
          //echo $a;
          //die();
      }
      
      //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is: ".$code." -SSANPM";
      
      $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for first time Login is : ".$code." -SSANPM";
     
     $this->sendSms($mobile,$smsBody);
      
        $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$insert_id));
        $check="checked";
           //   $this->session->set_flashdata('alert', 'register_success');
        redirect(base_url().'app_verify_otp/'.$insert_id.'/'.$check);
 
        



    //   redirect(base_url().'home/login', 'refresh');
  }

                            }
                            else {
  

                      $this->load->view('app/register');
                            }
                       
                    }
                    else {
                        
                        $this->load->view('app/register');
                    }
                }
            } 

    public function appverifyOtp($id,$check)
    {
      // print_r($id);exit;
        $data['member_id']=$id;
        $data['remember_me']=$check;
        $this->load->view('app/verify_otp',$data);
        // $this->appwithoutOTP($id,$check);
    }

    public function appwithoutOTP($id,$remember_me)
{
    
    // $id = $this->input->post('member_id');
    // $remember_me = $this->input->post('remember_me');
    // print_r($remember_me);exit;
    // $otp = $this->input->post('otp');
    $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
    // $check = $this->db->get_where('member',array('member_id'=>$id,"phoneOtp"=>$otp))->row_array();
    // print_r($remember_me);exit;
    
    if($result)
    {
         $member_approval = get_settings_value('general_settings','member_approval_by_admin');
         $member_email_verification = get_settings_value('general_settings','member_email_verification');
         // print_r($member_email_verification);exit;
        $this->MetaModel->updateMemberDatas('member',array('member_id'=>$id),array("phoneVerifyStatus"=>1));
        // $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
        if($member_approval == 'yes'){
          if ($result->status == "approved") {
            if($member_email_verification == 'on'){
              if($result->email_verification_status == '1'){
                  $check = 'done';
              }
              else{

                $this->session->set_flashdata('msg',appAlert('warning','Email Not Verified'));
                
                  redirect('app/login');
              }

              }else{
                  $check = 'done';
              }
              if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('app/login');
                
            }
               //  $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));                            
               //  if($sixDate <= date('Y-m-d')) {

               //    $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
               //    $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
               //    //$this->db->update("member",$arr1,array("member_id"=>$result->member_id));    
               //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id));   
               //     if(!empty($result->membership_date)){
               //      // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
               //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));
               // }
                     
               //  }
                if ($result->is_blocked == "no" && $result->is_closed == "no") {
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;
                  $data['mobile'] = $result->mobile;
                  $data['password'] = $result->password;
                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();
                  print_r($getLatest->membership);exit;
                  if($getLatest->membership != 1){
                      redirect('app/profile');
                      // redirect( base_url().'home/edit_profile');
                  }
                  else{
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe");    
                      if ($getLatest->member_type==1) {
                          // echo "string";exit;
                          if (date('Y-m-d')>date('Y-m-d',strtotime('+7 days',$getLatest->member_since_for_edit_profile)) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('app/profile');        
                          }
                          else{
                              redirect('app/profile');
                          }  
                      }
                      else
                      {
                          redirect( base_url('app/home'));    
                      }
                      // redirect("home/plans/subscribe/5");
                  }
              }
              elseif($result->status == "pending")
              {
                $this->session->set_flashdata('msg',appAlert('warning','Unapproved'));
                
                  redirect('app/login');
              }

            }

            }
          }else{

            //email verification check start
            if($member_email_verification == 'on'){
                if($result->email_verification_status == '1'){
                    $check = 'done';
                }
                else{
                    $this->session->set_flashdata('msg',appAlert('warning','Email not verified'));
                  
                    redirect('app/login');
                }
            }
            else{
                $check = 'done';
            }
            if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('app/login');
                
            }
              // $get_date = $this->db->get_where("member", array("member_id" => $result->member_id))->row()->membership_date;                          
              // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));
              // if($sixDate <= date('Y-m-d')) {
              //     $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
              //     $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
              //     // $this->db->update("member",$arr1,array("member_id"=>$result->member_id));

              //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
              //     // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
              //    if(!empty($result->membership_date)){
              //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));   
              //     }                         
              // }                        
              
              if ($result->is_blocked == "no") {
                // print_r($check);exit;
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;

                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
                  
                  if($getLatest->membership!= 1)
                  {
                      redirect( base_url().'app/profile', 'refresh' );
                  }
                  else{                            
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe/5");
                      // redirect("home/plans/subscribe");
                      if ($getLatest->member_type==1) {
                          if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('app/profile');
                          }
                          else if($getLatest->updateProfileDoneStatus==1) {
                              redirect('app/Subscription');
                          }
                          else{
                              redirect('app/profile');
                          }
                      }
                      else{
                          redirect('app/home');
                      }
                  }
              }
              elseif ($result->is_blocked == "yes") {
                $this->session->set_flashdata('msg',appAlert('warning','Blocked'));
               
                  redirect('app/login');
              }

            }//check done if




          }//else


        
    }
    else
    {
        $this->session->set_flashdata('msg',appAlert('warning','Wrong OTP'));
      
      redirect('app/login');
        
    }
}
   public function appcheckPhoneOtp($id,$remember_me,$otp)
{
    // $id = $this->input->post('member_id');
    // $remember_me = $this->input->post('remember_me');
    // print_r($remember_me);exit;
    // $otp = $this->input->post('otp');
    $result = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id,"phoneOtp"=>$otp));
    // $check = $this->db->get_where('member',array('member_id'=>$id,"phoneOtp"=>$otp))->row_array();
    // print_r($remember_me);exit;
    
    if($result)
    {
         $member_approval = get_settings_value('general_settings','member_approval_by_admin');
         $member_email_verification = get_settings_value('general_settings','member_email_verification');
         // print_r($member_email_verification);exit;
        $this->MetaModel->updateMemberDatas('member',array('member_id'=>$id),array("phoneVerifyStatus"=>1));
        // $this->db->update('member',array("phoneVerifyStatus"=>1),array('member_id'=>$id));
        if($member_approval == 'yes'){
          if ($result->status == "approved") {
            if($member_email_verification == 'on'){
              if($result->email_verification_status == '1'){
                  $check = 'done';
              }
              else{

                $this->session->set_flashdata('msg',appAlert('warning','Email Not Verified'));
                
                  redirect('app/login');
              }

              }else{
                  $check = 'done';
              }
              if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('app/login');
                
            }
               //  $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));                            
               //  if($sixDate <= date('Y-m-d')) {

               //    $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
               //    $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
               //    //$this->db->update("member",$arr1,array("member_id"=>$result->member_id));    
               //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id));   
               //     if(!empty($result->membership_date)){
               //      // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
               //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));
               // }
                     
               //  }
                if ($result->is_blocked == "no" && $result->is_closed == "no") {
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;
                  $data['mobile'] = $result->mobile;
                  $data['password'] = $result->password;
                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                      $this->session->set_userdata('thirumanam_applogged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();
                  print_r($getLatest->membership);exit;
                  if($getLatest->membership != 1){
                      redirect('app/profile');
                      // redirect( base_url().'home/edit_profile');
                  }
                  else{
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe");    
                      if ($getLatest->member_type==1) {
                          // echo "string";exit;
                          if (date('Y-m-d')>date('Y-m-d',strtotime('+7 days',$getLatest->member_since_for_edit_profile)) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('app/profile');        
                          }
                          else{
                              redirect('app/profile');
                          }  
                      }
                      else
                      {
                          redirect( base_url('app/home'));    
                      }
                      // redirect("home/plans/subscribe/5");
                  }
              }
              elseif($result->status == "pending")
              {
                $this->session->set_flashdata('msg',appAlert('warning','Unapproved'));
                
                  redirect('app/login');
              }

            }

            }
          }else{

            //email verification check start
            if($member_email_verification == 'on'){
                if($result->email_verification_status == '1'){
                    $check = 'done';
                }
                else{
                    $this->session->set_flashdata('msg',appAlert('warning','Email not verified'));
                  
                    redirect('app/login');
                }
            }
            else{
                $check = 'done';
            }
            if($check == 'done'){

                $expiry = date("Y-m-d", strtotime("+9 months", strtotime($result->membership_date)));

            $deactivate_data = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL,'active_status'=>0,'is_closed'=>'yes','deactivate_status'=>1);
            $deactivate_data2 = array('active_status'=>0,'delete_status'=>1);
            if($expiry <= date('Y-m-d') && !empty($result->membership_date))
            {
                $this->MetaModel->updateMemberDatas('member',array('member_id'=>$result->member_id),$deactivate_data);
                $this->MetaModel->updateMemberDatas('package_payment',array('member_id'=>$result->member_id),$deactivate_data2);
                $this->session->set_flashdata('msg',appAlert('success','Your account has been deactivated!! please conact admin to activate'));
                redirect('app/login');
                
            }
              // $get_date = $this->db->get_where("member", array("member_id" => $result->member_id))->row()->membership_date;                          
              // $sixDate =  date("Y-m-d", strtotime("+6 months", strtotime($result->membership_date)));
              // if($sixDate <= date('Y-m-d')) {
              //     $arr1 = array("membership"=>1,"express_interest"=>0,"remain_download"=>0,"direct_messages"=>0,"photo_gallery"=>0,'membership_date'=>NULL);
              //     $this->MetaModel->updateMemberDatas('member',array("member_id"=>$result->member_id),$arr1);
              //     // $this->db->update("member",$arr1,array("member_id"=>$result->member_id));

              //     $this->MetaModel->deleteMemberDatas('view_profile_management',array('user_id'=>$result->member_id)); 
              //     // $this->db->delete('view_profile_management',array('user_id'=>$result->member_id));
              //    if(!empty($result->membership_date)){
              //     $this->session->set_flashdata('msg',appAlert('warning','Your Account has been Expired'));   
              //     }                         
              // }                        
              
              if ($result->is_blocked == "no") {
                // print_r($check);exit;
                  $data['login_state'] = 'yes';
                  $data['member_id'] = $result->member_id;
                  $data['member_name'] = $result->first_name;
                  $data['member_email'] = $result->email;

                  if ($remember_me == 'checked') {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                      setcookie('cookie_member_id', $this->session->userdata('member_id'), time() + (1296000), "/");
                      setcookie('cookie_member_name', $this->session->userdata('member_name'), time() + (1296000), "/");
                      setcookie('cookie_member_email', $this->session->userdata('member_email'), time() + (1296000), "/");
                  } else {
                    $this->session->set_userdata('thirumanam_applogin_status', 1);
                    $this->session->set_userdata('thirumanam_applogged_data',$data);
                  }
                  $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$id));
                  // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
                  
                  if($getLatest->membership!= 1)
                  {
                      redirect( base_url().'app/profile', 'refresh' );
                  }
                  else{                            
                      // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
                      // redirect("home/plans/subscribe/5");
                      // redirect("home/plans/subscribe");
                      if ($getLatest->member_type==1) {
                          if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                              redirect('app/profile');
                          }
                          else if($getLatest->updateProfileDoneStatus==1) {
                              redirect('app/Subscription');
                          }
                          else{
                              redirect('app/profile');
                          }
                      }
                      else{
                          redirect('app/home');
                      }
                  }
              }
              elseif ($result->is_blocked == "yes") {
                $this->session->set_flashdata('msg',appAlert('warning','Blocked'));
               
                  redirect('app/login');
              }

            }//check done if




          }//else


        
    }
    else
    {
        $this->session->set_flashdata('msg',appAlert('warning','Wrong OTP'));
      
      redirect('app_verify_otp/'.$id.'/'.$remember_me);
        
    }
}

function appresendOtp($id)
{
    $getData = $this->db->get_where('member',array('member_id'=>$id))->row();
    $code = rand(1000,9999);
    //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
    $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
    $mobile = "91".$getData->mobile;
    $this->sendSms($mobile,$smsBody);
    $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$id));
    $this->session->set_flashdata('msg',appAlert('success','Resend OTP Successfully'));
    
    $check="checked";
    redirect('app_verify_otp/'.$id.'/'.$check);
    

}

function appresendLoginOtp()
{
    $phone = $this->input->post('phone');
    $gender = $this->input->post('gender');
    if(!empty($gender)){
        $getData = getData('member','row',array('mobile'=>$phone,'gender'=>$gender));
    }else
    {
        $getData = getData('member','row',array('mobile'=>$phone));
    }
    // print_r($gender);exit;
    $code = rand(1000,9999);
    //$smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
    $smsBody="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
    $mobile = "91".$getData->mobile;
    $this->sendSms($mobile,$smsBody);
    $this->db->update('member',array("phoneOtp"=>$code),array('member_id'=>$getData->member_id));
    // $this->session->set_flashdata('msg',appAlert('success','Resend OTP Successfully'));
    
    $check="checked";
    // redirect('app_verify_otp/'.$id.'/'.$check);
    

}

    public function appforgetPassword()
    {
        $this->load->view('app/forget_password');
    }

     public function appcheckPhone()
    {
        $phone = $this->input->post('phone');
        $gender = $this->input->post('gender');
        // print_r($gender);exit;
        $otp = $this->input->post('otp');
        if($phone!= '' && $otp != ''){
            $check = $this->Customers_model->getMemDatas('member',$phone,$gender,$otp,'row');
            // print_r($check);exit;
            if($check)
            {
                echo 1; 
            }
            else
            {
                echo 2;
            }
        }
        else{
            
            $check = $this->Customers_model->getMemDatas('member',$phone,$gender,'','row');
            // print_r($check);exit;
            if($check)
            {
                $code = rand(1000,9999);
                //$smsBody1="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
                $smsBody1="Kindly don't share the OTP to anyone. Sharing this gives them full access to your account. Your confidential OTP for password reset is : ".$code." -SSANPM";
                $mobile = "91".$phone;
                $this->sendSms($mobile,$smsBody1);
                if(!empty($gender)){
                    $this->db->update('member',array("phoneOtp"=>$code),array('mobile'=>$phone,'gender'=>$gender));
                }else{
                    $this->db->update('member',array("phoneOtp"=>$code),array('mobile'=>$phone));
                }
                
                echo 3; // Phone Ok
            }
            else
            {
                echo 4;
            }
        }
       
    }


    public function appforgotChangePassword()
    {
        $data['phone'] = $this->uri->segment(3);
        $data['gender'] = $this->uri->segment(4);
        $this->load->view('app/changePass',$data);
    }

    public function appchangeNewPassword()
    {
        $inputs = $this->input->post();
        
        
        $phone = ($inputs['phone']);
        $gender = ($inputs['gender']);
        $new_password = sha1($inputs['new_password']);
        $confirm_password = sha1($inputs['confirm_password']);
        
        $result = $this->Customers_model->getMemDatas('member',$phone,$gender,'','row');
        // print_r($gender);exit;
        if(!empty($result))
        {
                $ip = get_IP_address();
                $loc = file_get_contents("http://ip-api.com/json/$ip");
                $decode = json_decode($loc, true);
                $data=array(

                    'member_id'=>$result->member_id,
                    'activity' =>'changed password',
                    'location'=>$decode['city'],
                    'server' => json_encode($_SERVER)

                );
                $this->Customers_model->add_info('user_activity',$data);
                if(!empty($gender)){
                    $this->MetaModel->updateMemberDatas('member',array('mobile'=>$phone,'gender' => $gender),array('password'=>$new_password));
                }else{
                    $this->MetaModel->updateMemberDatas('member',array('mobile'=>$phone),array('password'=>$new_password));
                }
                $this->session->set_flashdata('msg',appAlert('success','Updated Successfully'));
                redirect('app/login');
            
        }else
            {

                $this->session->set_flashdata('msg',appAlert('danger','Phone Number Did not match!!'));
                redirect('app/forget_password');
            }
        
    }

    public function appverifyMember()
    {
      $member_id = $this->session->userdata('thirumanam_applogged_data')['member_id'];

      $getLatest = $this->MetaModel->getMemberData('member','row',array('member_id'=>$member_id));
      // $getLatest = $this->db->get_where('member',array('member_id'=>$result->member_id))->row_array();    
      // print_r($getLatest->membership);exit;
      if($getLatest->membership!= 1)
      {
          redirect('app/profile');
      }
      else{                            
          // redirect(base_url()."home/submitPayment/".$this->session->userdata('member_id')."/5");
          // redirect("home/plans/subscribe/5");
          // redirect("home/plans/subscribe");
        

          if ($getLatest->member_type==1) {
              if (date('Y-m-d')<date('Y-m-d',strtotime('+7 day',strtotime($getLatest->member_since_for_edit_profile))) && $getLatest->updateProfileDoneStatus==0) {
                $this->session->set_flashdata('msg',appAlert('warning','Edit Profile First'));
                  redirect('app/profile');
              }
              else if($getLatest->updateProfileDoneStatus==1) {
                $this->session->set_flashdata('msg',appAlert('warning','Subscribe Plan First'));
                  redirect('app/Subscription');
              }
              else{
                // $this->session->set_flashdata('msg',getAlert('warning','Edit Profile First'));
                  redirect('app/profile');
              }
          }else{
            $this->session->set_flashdata('msg',appAlert('warning','You are offline Member!!'));
              redirect('app/home');
          }
      }
    }


}
?>