
<?php
class AdminController extends MY_Controller 
{
    public function __construct()
  {
        parent::__construct();
        if(!$this->session->userdata('THIRUMANAM_ADMIN_SESSION'))
        {
            redirect('administrator');
        }
        $this->load->model('Customers_model');
        $this->load->model('HomeModel');
        $this->load->model('MetaModel');
        
  } 


  function setLanguage($lang) {
        $this->session->set_userdata('language', $lang);
        
        redirect($_SERVER['HTTP_REFERER']);
    }
    public function index()
    {   
        $all_customers_datas=$this->Customers_model->get_all_memberdatas();
        $Offline_members_datas=$this->HomeModel->getOfflineDatas('member','result');
        $Online_members_datas=$this->HomeModel->getOnlineDatas('member','result');
        $Blocked_members_datas=$this->HomeModel->getblockDatas();
        $Report_members_datas=$this->HomeModel->getreportedDatas();
        $Incompelte_members_datas=$this->HomeModel->getincompleteProfileDatas('member','result');
        $getPendingDatas=$this->HomeModel->getPendingDatas('member','result');
        $profile_image[] = array(
            'profile_image' => 'default.jpg',
            'thumb' =>  'default_thumb.jpg',
        );
        $profile['profile_image'] = json_encode($profile_image);
        $getWithoutProfileDatas=$this->HomeModel->getWithoutProfileDatas('member','result',$profile);
        $Earning_members_datas=$this->HomeModel->getearningDatas();
        $Earning_members_online=$this->HomeModel->gettypeearningDatas(1);
        $Earning_members_offline=$this->HomeModel->gettypeearningDatas(2);
        
       // print_r(count($Incompelte_members_datas));exit;
        $datas['all_customer_count']=count($all_customers_datas);
        $datas['Offline_members_datas']=count($Offline_members_datas);
        $datas['Online_members_datas']=count($Online_members_datas);
        $datas['Blocked_members_datas']=count($Blocked_members_datas);
        $datas['Report_members_datas']=count($Report_members_datas);
        $datas['Incompelte_members_datas']=count($Incompelte_members_datas);
        $datas['getPendingDatas']=count($getPendingDatas);
        $datas['getWithoutProfileDatas']=count($getWithoutProfileDatas);
        $datas['all_member']=$this->Customers_model->get_all_memberdatasarray();
        $datas['Earning_members_datas']=count($Earning_members_datas);
        $datas['Earning_members_online']=count($Earning_members_online);
        $datas['Earning_members_offline']=count($Earning_members_offline);
        $datas['online_today_earnings'] = getEarnings(date('Y-m-d 00:00:00'),1);
        $datas['online_lastweek_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-7 days")),1);
        $datas['online_lastmonth_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-1 months")),1);
        $datas['online_quarterly_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-3 months")),1);
        $datas['online_halfyearly_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-6 months")),1);
        $datas['online_lastyear_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-12 months")),1);

        $datas['offline_today_earnings'] = getEarnings(date('Y-m-d 00:00:00'),2);
        $datas['offline_lastweek_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-7 days")),2);
        $datas['offline_lastmonth_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-1 months")),2);
        $datas['offline_quarterly_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-3 months")),2);
        $datas['offline_halfyearly_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-6 months")),2);
        $datas['offline_lastyear_earnings'] = getEarnings(date('Y-m-d 00:00:00',strtotime("-12 months")),2);
        
        $all_story_datas = $this->HomeModel->getstoryDatas();
        $datas['total_stories']=count($all_story_datas);
        $approved_story_datas = $this->HomeModel->getstoryAprovedDatas(1);
        $datas['approved_stories']=count($approved_story_datas);
        $pending_story_datas = $this->HomeModel->getstoryAprovedDatas(0);
        $datas['pending_stories']=count($pending_story_datas);
        // $datas['total_stories'] = $this->db->get('happy_story')->num_rows();
        $datas['roles']=$this->Customers_model->getDatas('role','result');
        $datas['permissions']=$this->Customers_model->getDatas('permission','result_array');
        
        // print_r($datas['roles']);exit;
        $datas['members']=$this->HomeModel->getMemberActiveDatas(4);
        $datas['admins']=$this->HomeModel->getAdminActiveDatas(5);
        $datas['matchesMales']=$this->HomeModel->getMatchedDatas('member','result',1,5);
        $datas['matchesFemales']=$this->HomeModel->getMatchedDatas('member','result',2,5);
        // print_r($datas['matchesFemales']);exit;
        $this->template['middle'] = $this->load->view($this->middle = 'Administrator/dashboard_page',$datas, true);
        $this->AdminLayout();
    }
    public function adminForgetPassword()
    {
        $this->load->view('Administrator/admin_forget_password');
        
    }

    public function allmembers()
    {
        
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/allmembers_view',$datas, true);
        $this->AdminLayout();
    }
    public function offlineMembers()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/offline_members_view',$datas, true);
        $this->AdminLayout();
    }
    public function onlineMembers()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/online_members_view',$datas, true);
        $this->AdminLayout();
    }
    public function reportMembers()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/reported_members_view',$datas, true);
        $this->AdminLayout();
    }
    public function viewMember($id)
    {
        $date_validity=strtotime(date('Y-m-d H:i:s',strtotime('-6 months')));
        $datas['single_member']=$this->Customers_model->get_single_member($id);
        $datas['current_plan']=$this->Customers_model->get_currentplan($id,$date_validity);
        $datas['plans']=$this->Customers_model->get_plan();
        // print_r($id);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/view_member',$datas, true);
        $this->AdminLayout();
    }
    public function editMember($data)
    {
        $datas['single_member']=$this->Customers_model->get_single_member($data);
        $datas['singlemember']=$this->Customers_model->get_singlemember($data);
        $datas['mariages_status']=$this->Customers_model->get_martial_status();
        $datas['states']=$this->Customers_model->get_states();
        $datas['cities']=$this->Customers_model->get_cities();
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/edit_member',$datas, true);
        $this->AdminLayout();
    }
    public function updateMember()
    {
        

        $inputs = $this->input->post();
        // print_r($inputs);exit;
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

        $member = $this->Customers_model->get_single_member($inputs['member_id']);
        // print_r($member);exit;

        if(!empty($inputs['password'])){

            $password = sha1($inputs['password']);
        }else{

            $password = $member->password;
        }
        $input['height'] = 0.00;
        // 
        $input = array(
            'member_profile_id'=>$inputs['member_profile_id'],
            'first_name'=>$inputs['first_name'],
            'email'=>$inputs['email'],
            'height'=>$inputs['height'],
            'introduction'=>$inputs['introduction'],
            'date_of_birth' => strtotime($inputs['date_of_birth']),
            'password'=>$password,
            // 'mobile' =>$inputs['mobile']
        );
        // print_r($inputs);exit();
        $basic_info[]= array(
            'marital_status'=>$inputs['marital_status'],
            'number_of_children'=>$inputs['number_of_children'],
            'Child_living_place'=>$inputs['Child_living_place'],
        );
        $input['basic_info'] = json_encode($basic_info,JSON_UNESCAPED_UNICODE);
        $education_and_career[]= array(
            'Type_of_study'=>$inputs['Type_of_study'],
            'other_study'=>$inputs['other_study'],
            'STUDY_DETAILS'=>$inputs['STUDY_DETAILS'],
            'Type_of_occupation'=>$inputs['Type_of_occupation'],
            'Other_Occupation_Details'=>$inputs['Other_Occupation_Details'],
            'Career_Profile'=>$inputs['Career_Profile'],
            'annual_income'=>$inputs['annual_income'],
            'Earnings'=>$inputs['Earnings'],
        );
        $input['education_and_career'] = json_encode($education_and_career,JSON_UNESCAPED_UNICODE);
        $physical_attributes[]= array(
            'weight'=>$inputs['weight'],
            'eye_color'=>$inputs['eye_color'],
            'hair_color'=>$inputs['hair_color'],
            'complexion'=>$inputs['complexion'],
            'blood_group'=>$inputs['blood_group'],
            'body_type'=>$inputs['body_type'],
            'body_art'=>$inputs['body_art'],
            'any_disability'=>$inputs['any_disability'],
        );
        $input['physical_attributes'] = json_encode($physical_attributes,JSON_UNESCAPED_UNICODE);
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

        $permanent_address[]= array(
            'permanent_country'=>$inputs['permanent_country'],
            'permanent_state'=>$inputs['permanent_state'],
            'permanent_city_other'=>$inputs['permanent_city_other'],
            'permanent_city'=>$inputs['permanent_city'],
            'address'=>$inputs['address'],
            'permanent_postal_code'=>$inputs['permanent_postal_code'],
            // 'mobile'=>$inputs['mobile'],
            'alternate_number'=>$inputs['alternate_number'],
            'landline'=>$inputs['landline'],
        );
        $input['permanent_address'] = json_encode($permanent_address,JSON_UNESCAPED_UNICODE);

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
        $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['updated_date'] = date('Y-m-d');

        $input['soveran_detail'] = $inputs['Soveran_Details'];
        $single=$this->Customers_model->get_single_member($inputs['member_id']);
        if($single->member_type == 2 && $single->updateProfileDoneStatus==0){

            $input['membership_date'] = date('Y-m-d'); 
        }
        $input['updateProfileDoneStatus'] = 1;
        // print_r($single);exit;

        $detailed_activity1 = $this->Customers_model->ifIntroUpdateorNot($inputs['member_id'],$inputs);
        $detailed_activity2 = $this->Customers_model->ifBasicUpdateorNot($inputs['member_id'],$inputs);
         $detailed_activity3 = $this->Customers_model->ifEducationUpdateorNot($inputs['member_id'],$inputs);
         $detailed_activity4 = $this->Customers_model->ifPhysicalUpdateorNot($inputs['member_id'],$inputs);
         $detailed_activity5 = $this->Customers_model->ifAstronomicUpdateorNot($inputs['member_id'],$inputs);
         $detailed_activity6 = $this->Customers_model->ifPermanantUpdateorNot($inputs['member_id'],$inputs);
         $detailed_activity7 = $this->Customers_model->ifFamilyUpdateorNot($inputs['member_id'],$inputs);
         $detailed_activity8 = $this->Customers_model->ifPartnerUpdateorNot($inputs['member_id'],$inputs);

        
            if(!empty($detailed_activity1))
            {
                $detailed_data1 = 'Member Profile Introduction Updated-->'.$detailed_activity1.' / ';
            }else
            {
                // $detailed_data1 = 'Member Profile Introduction Updated But Not Changed';
                $detailed_data1 = '';
            }
            if(!empty($detailed_activity2))
            {
                $detailed_data2 = 'Member Profile Basic info Updated-->'.$detailed_activity2.' / ';
            }else
            {
                // $detailed_data2 = 'Member Profile Basic info Updated But Not Changed';
                $detailed_data2 = '';
            }
            if(!empty($detailed_activity3))
            {
                $detailed_data3 = 'Member Profile Education Updated-->'.$detailed_activity3.' / ';
            }else
            {
                // $detailed_data3 = 'Member Profile Education Updated But Not Changed';
                $detailed_data3 = '';
            }
            if(!empty($detailed_activity4))
            {
                $detailed_data4 = 'Member Profile Physical attributes Updated-->'.$detailed_activity4.' / ';
            }else
            {
                // $detailed_data4 = 'Member Profile Physical attributes Updated But Not Changed';
                $detailed_data4 = '';
            }
            if(!empty($detailed_activity5))
            {
                $detailed_data5 = 'Member Profile Astronomic information Updated-->'.$detailed_activity5.' / ';
            }else
            {
                // $detailed_data5 = 'Member Profile Astronomic information Updated But Not Changed';
                $detailed_data5 = '';
            }
            if(!empty($detailed_activity6))
            {
                $detailed_data6 = 'Member Profile Permanent address Updated-->'.$detailed_activity6.' / ';
            }else
            {
                // $detailed_data6 = 'Member Profile Permanent address Updated But Not Changed';
                $detailed_data6 = '';
            }
            if(!empty($detailed_activity7))
            {
                $detailed_data7 = 'Member Profile Family information Updated-->'.$detailed_activity7.' / ';
            }else
            {
                // $detailed_data7 = 'Member Profile Family information Updated But Not Changed';
                $detailed_data7 = '';
            }
            if(!empty($detailed_activity8))
            {
                $detailed_data8 = 'Member Profile Partner expectation Updated-->'.$detailed_activity8.' / ';
            }else
            {
                // $detailed_data8 = 'Member Profile Partner expectation Updated But Not Changed';
                $detailed_data8 = '';
            }
        
            $detailed_datas = $detailed_data1.' '.$detailed_data2.' '.$detailed_data3.' '.$detailed_data4.' '.$detailed_data5.' '.$detailed_data6.' '.$detailed_data7.' '.$detailed_data8;
            // print_r($detailed_datas);exit;

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
            $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Member Profile Updated --'.$detailed_datas.' / Member Id: '.$single->member_profile_id.' / Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        $result = $this->Customers_model->update_member('member',$inputs['member_id'],$input);
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/all_members');

    }

     public function get_city_of_state_ajax_admin()
    {
        $state_id=$this->input->get('state_id');
        $result=$this->Customers_model->getCitiesofState($state_id);
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

    public function get_email_templates()
    {
        $id=$this->input->get('id');
        $result=$this->Customers_model->getTemplates($id);
        
        $html='';

        if(empty($result)){
            $html.='';
        }
        else
        {
            foreach ($result as $value) {
                $html.= $value->template;   
            }            
        }

        echo $html;
        
    }
    public function get_membership_data_ajax_admin()
    {
        $id=$this->input->get('id');
        // print_r($id);exit;
        $result=$this->Customers_model->getmembershipData();
        // print_r($result);exit();
        $html='';
        if($id==1){
            if(empty($result)){
                $html.='<option>No Data Found</option>';
            }
            else
            {   
                $html.='<option value="">'.translate('choose_one').'</option>';
                foreach ($result as $value) {
    
                    $html.='<option value="'.$value->plan_id .'">'.dropdownTranslate($value->name).'</option>';   
                }            
            }
        }else{
            if(empty($result)){
                $html.='<option>No Data Found</option>';
            }
            else
            {
                $html.='<option value="">'.translate('choose_one').'</option>';
                foreach ($result as $value) {
    
                    $html.='<option value="'.$value->plan_id.'">'.dropdownTranslate($value->offline_name).'</option>';   
                }            
            }
        }
        

        echo $html;
        
    }

    // public function printMember($id)
    // {
    //     $datas['single_member']=$this->Customers_model->get_single_members($id);
    //     // print_r($datas['single_member']);exit();
    //     $this->load->library('pdf');
    //     $html = $this->load->view('print', $datas, true);
    //     $this->pdf->createPDF($html, 'profile_print', false);
    // }
    public function printMember($id)
    {
        $datas['single_member']=$this->Customers_model->get_single_members($id);
        // print_r($datas['single_member']);exit();
        $html = $this->load->view('print', $datas);
    }

    public function print_admin_Member($id)
    {
        $datas['single_member']=$this->Customers_model->get_single_members($id);
        // print_r($datas['single_member']);exit();
        $html = $this->load->view('print_admin', $datas);
    }
    

    public function deleteMember($id)
    {
        // print_r($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id']);exit;
        $single=$this->Customers_model->get_single_member($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'deleted Member Id: '.$single->member_profile_id.' name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        $this->Customers_model->update_single_member('member',$id,array('delete_status' => 1));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/all_members');
    }
    public function deletereportedMember($id)
    {
        // print_r($id);exit;
        $single=$this->Customers_model->get_single_member($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'report deleted',
        );
        $this->Customers_model->add_info('admin_activity',$data);
        $this->Customers_model->update_report_member('members_report',array('id'=>$id),array('delete_status' => 1));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/reported_members');
    }
    public function deleteMemberPermanant($id)
    {
        $single=$this->Customers_model->get_single_member($id);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'deleted Permanently Member Id: '.$single->member_profile_id.'Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        $this->Customers_model->delete_single_member('member',$id);
        $this->session->set_flashdata('msg',showAlert('success','Success Deleted Permanantly'));
        redirect('administrator/deleted_members');
    }
    public function deleteMemberPermanantly($id)
    {
        $single=$this->Customers_model->get_single_member($id);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'deleted Permanently Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);   
        $this->Customers_model->delete_single_member('deactivated_member',$id);
        $this->session->set_flashdata('msg',showAlert('success','Success Deleted Permanantly'));
        redirect('administrator/old_id_of_renewed_members');
    }
    public function blockMemberr($id)
    {   
        $single=$this->Customers_model->get_single_member($id);
        // print_r($single);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Blocked Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        $inputs = $this->input->post(); 
        // print_r($inputs);exit();
        $this->Customers_model->add_info('blocked_members',$inputs);
        $this->Customers_model->block_single_member('member',$id,array('is_blocked' => 'yes'));
        $this->session->set_flashdata('msg',showAlert('success','Blocked Successfully'));
        redirect('administrator/all_members');
    }
    public function unblockMember($id) 
    {
        $single=$this->Customers_model->get_single_member($id);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'unBlocked Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        // print_r($inputs);exit();
        $this->Customers_model->update_block('blocked_members',$id,array('delete_status' => '1'));
        $this->Customers_model->block_single_member('member',$id,array('is_blocked' => 'no'));
        $this->session->set_flashdata('msg',showAlert('success','unBlocked Successfully'));
        redirect('administrator/all_members');
    }

    public function closeMemberr($id)
    {   
        $single=$this->Customers_model->get_single_member($id);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Closed Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        $inputs = $this->input->post(); 
        // print_r($inputs);exit();
        $this->Customers_model->add_info('closed_members',$inputs);
        $this->Customers_model->block_single_member('member',$id,array('is_closed' => 'yes'));
        $this->session->set_flashdata('msg',showAlert('success','Closed Successfully'));
        redirect('administrator/all_members');
    }
    public function uncloseMember($id) 
    {
        $single=$this->Customers_model->get_single_member($id);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Open Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$data);
        // print_r($inputs);exit();
        $this->Customers_model->update_close('closed_members',$id,array('delete_status' => '1'));
        $this->Customers_model->block_single_member('member',$id,array('is_closed' => 'no'));
        $this->session->set_flashdata('msg',showAlert('success','Open Successfully'));
        redirect('administrator/all_members');
    }

    public function blockMember()
    {
        $meta_value_id=$this->input->post('m_id');
        
        echo'<div id="myModal'.$meta_value_id.'" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form method="post" action="'.base_url('administrator/blockMemberr/'.$meta_value_id).'">
            <div class="modal-header">
            <input type="hidden" value="'.$meta_value_id.'" name="blocked_member_id">
                <h5 class="modal-title" id="zoomInModalLabel">Reason For Block</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-4 pt-4">
                    <textarea name="reason" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary ">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

';
  }

  

  public function closeMember()
    {
        $meta_value_id=$this->input->post('m_id');
        
        echo'<div id="myModal'.$meta_value_id.'" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <form method="post" action="'.base_url('administrator/closeMemberr/'.$meta_value_id).'">
            <div class="modal-header">
            <input type="hidden" value="'.$meta_value_id.'" name="member_id">
                <h5 class="modal-title" id="zoomInModalLabel">Reason For Close</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-4 pt-4">
                    <textarea name="reason" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary ">Save</button>
            </div>
        </div>
        </form>
    </div>
</div>

';
  }

  public function renewProfile()
  {
        $member_id = $this->input->post('member_id');
        $member_type = $this->input->post('member_type');
        $plan_id=(isset($_REQUEST['plan_id'])) ? $_REQUEST['plan_id'] : 7 ;
        $memberData = $this->Customers_model->get_single_member($member_id);
        $memberData->delete_status=1;
        $basic_decode = json_decode($memberData->basic_info); 
        $education_decode = json_decode($memberData->education_and_career); 
        $physical_decode = json_decode($memberData->physical_attributes);
        $astro_decode = json_decode($memberData->astronomic_information);
        $permanant_decode = json_decode($memberData->permanent_address);
        $family_decode = json_decode($memberData->family_info);
        $partner_decode = json_decode($memberData->partner_expectation);
        $chart_decode = json_decode($memberData->chart);
        // print_r($member_type);exit;
        
        
        $newMenberId = "";
        $t = 0;
        // if ($memberData['membership']==2) {          
        
            if($memberData->gender == '1')
            {
                $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1,'prefixId !='=>0))->row_array();

                $getId  = $u['prefixId'];
                if($getId < 5131)
                {   $t = 5131;
                    $newMenberId = 'Male5131';
                }
                else
                {
                    $t = $getId + 1;
                    $newMenberId = 'Male'.$t;
                }

            }else{
                $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2,'prefixId !='=>0))->row_array();
                                             
                $getId  = $u['prefixId'];
                if($getId < 2677)
                {
                    $newMenberId = 'Female2677';
                }
                else
                {
                    $t = $getId +1;
                    $newMenberId = 'Female'.$t;
                }
            }
        // }
           // print_r($memberData);exit;
        unset($memberData->member_id);

        $insertMember = $this->Customers_model->add_info('deactivated_member',$memberData);
        $memberData->created_date=date('Y/m/d H:i:s');
        $renewed_id = $this->Customers_model->add_info('member',$memberData);
        // print_r($renewed_id);exit;
        $update_data = array(

                'delete_status'=>1,
                'updateProfileDoneStatus'=>0,
                'is_closed'=>'yes'

        );
        $this->Customers_model->update_member('member',$member_id,$update_data);

        // INSERT PAYMENT
            $date_validity=strtotime(date('Y-m-d H:i:s',strtotime('-6 months')));
            $payment_details = $this->Customers_model->get_payment_detail($member_id,$date_validity);
            // $plan_id=(!empty($payment_details)) ? $payment_details->plan_id : 5 ;            
            $plan_details = $this->Customers_model->planDetails($plan_id);


            
            $updateData['membership'] = 2;
            $plan_amount=$plan_details->amount;
            if ($member_type==1) {
                $payment_type = 'Online_Admin';
                // $updateData['express_interest'] = $memberData->express_interest + $plan_details->express_interest;
                // $updateData['remain_download'] = 100;
                // $updateData['direct_messages'] = $memberData->direct_messages + $plan_details->direct_messages;
                // $updateData['photo_gallery'] = $memberData->photo_gallery + $plan_details->photo_gallery;

                $package_info[] = array('current_package'   => $plan_details->name,
                            'package_price' => $plan_amount,
                            'payment_type'  => $payment_type
                );

                $updateData = array("member_profile_id"=>"","prefixId"=>"","member_since"=>date("Y-m-d H:i:s"),"isRenewed"=>1,"active_status"=>1,'is_closed'=>"no",'delete_status'=>0,'deactivate_status'=>0,'package_info'=>json_encode($package_info),'paymentReq'=>0,'member_type'=>1,'express_interest'=>$memberData->express_interest + $plan_details->express_interest,'remain_download'=>100,'direct_messages'=>$memberData->direct_messages + $plan_details->direct_messages,'photo_gallery'=>$memberData->photo_gallery + $plan_details->photo_gallery);

                $package['payment_status'] = 'due';
            }
            else
            {   
                $payment_type = 'DIRECT_CASH';
                                            
                $package_info[] = array('current_package'   => $plan_details->offline_name,
                            'package_price' => $plan_details->offline_amount,
                            'payment_type'  => $payment_type
                );

                $updateData = array("member_profile_id"=>$newMenberId,"prefixId"=>$t,"member_since"=>date("Y-m-d H:i:s"),"member_since_for_edit_profile"=>date("Y-m-d"),"isRenewed"=>1,"active_status"=>1,'is_closed'=>"no",'delete_status'=>0,'deactivate_status'=>0,'membership_date'=>date('Y-m-d'),'package_info'=>json_encode($package_info),'paymentReq'=>0,'member_type'=>2);

                $package['payment_status'] = 'paid';
            } 

            // print_r($updateData);exit;
            // $result = $this->Customers_model->update_member('member',$member_id,$data);     
            // $this->db->where('member_id', $member_id);
            // $result = $this->db->update('member', $data);
              
            // INSERT PAYMENT
            
            $this->Customers_model->update_member('member',$renewed_id,$updateData);
            
            // print_r($updateData);exit; 

            
            
            // $r = $this->Customers_model->update_member('member',$renewed_id,$updateData);
            // print_r($updateData);exit;
            $package['plan_id']  = $plan_id;
            $package['member_id']= $renewed_id;
            $package['member_type']= $member_type;
            $package['payment_type']= $payment_type;
            
            $package['payment_details'] = 'none';
            $package['custom_payment_method_transaction_id'] = '--';
            $package['amount']   = ($member_type==1) ? $plan_amount : $plan_details->offline_amount;
            $package['plan_amount']   = ($member_type==1) ? $plan_amount : $plan_details->offline_amount;
            $package['purchase_datetime'] = time();
            $package['payment_timestamp'] = time();
            $package['expire']   = 'no'; 
            

            $insert = $this->db->insert('package_payment', $package);
            // $this->db->update("member",$updateData,array("member_id"=>$member_id));
            // echo "string";exit;
            // print_r($member_id);exit;
            
            if($updateData){


            $SMSTEXT = "Dear ".$memberData->first_name.", your account has been renewed with Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$newMenberId.".";

            $mobile = "91".$memberData->mobile;

            $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
            $activity = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Renewed Member Id: '.$newMenberId.' Name: '.$memberData->first_name,
            );
            // print_r($memberData);exit;
            $this->Customers_model->add_info('admin_activity',$activity);
            $this->Customers_model->sendSms($mobile,$SMSTEXT);
            $this->session->set_flashdata('msg',showAlert('success','Renew Successfully'));

            }else{
                $this->session->set_flashdata('msg',showAlert('danger','Renew Failed'));
            }
            redirect('administrator/all_members');
  }

    public function updateProfileimage()
    {
        $inputs = $this->input->post();
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
            'thumb'         => $inputs['thumb']
        );
        $datas['profile_image'] = json_encode($profile_image);
        // print_r($datas);exit;
        $single=$this->Customers_model->get_single_member($inputs['member_id']);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
            $activity = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Updated Profile Image Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        $this->Customers_model->add_info('admin_activity',$activity);
        $this->Customers_model->update_single_member('member',$inputs['member_id'],$datas);
        $this->session->set_flashdata('msg',showAlert('success','Profile Image Updated Successfully'));
        redirect('administrator/all_members');
    }

    public function offlineRegisterMembers()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/offline_register_member',$datas, true);
        $this->AdminLayout(); 
    }
    public function offlineRegisterMale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/offline_register_male',$datas, true);
        $this->AdminLayout(); 
    }
    public function offlineRegisterFemale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/offline_register_female',$datas, true);
        $this->AdminLayout(); 
    }
    public function pendingRenewal()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/pending_renewal',$datas, true);
        $this->AdminLayout(); 
    }
    public function pendingRenewalOffline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/pending_renewal_offline',$datas, true);
        $this->AdminLayout(); 
    }
    public function pendingRenewalOnline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/pending_renewal_online',$datas, true);
        $this->AdminLayout(); 
    }
    public function pendingOnlineUnpaid()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/pending_online_unpaid',$datas, true);
        $this->AdminLayout(); 
    }
    public function incompleteProfile()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/incomplete_profile',$datas, true);
        $this->AdminLayout(); 
    }
    public function incompleteonlinePaid()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/incomplete_online_paid',$datas, true);
        $this->AdminLayout(); 
    }
    public function incompleteonlineUnpaid()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/incomplete_online_unpaid',$datas, true);
        $this->AdminLayout(); 
    }
    public function incompleteOffline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/incomplete_offline',$datas, true);
        $this->AdminLayout(); 
    }
    public function withoutProfile()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/without_profile',$datas, true);
        $this->AdminLayout(); 
    }
    public function withoutProfileOffline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/without_profile_offline',$datas, true);
        $this->AdminLayout(); 
    }
    public function withoutProfileOnline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/without_profile_online',$datas, true);
        $this->AdminLayout(); 
    }
    public function bulkProfilePrint()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/bulk_profile_print',$datas, true);
        $this->AdminLayout(); 
    }
    public function bulkPrintFemale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/bulk_profile_print_female',$datas, true);
        $this->AdminLayout(); 
    }
    public function bulkPrintMale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/bulk_profile_print_male',$datas, true);
        $this->AdminLayout(); 
    }
    // public function printBulkMember($member_id)
    // {
         
    //         $datas['single_member'] = $_POST['selected_ids'];
    //         // print_r($data);exit;
    //         $this->load->library('pdf');
    //         $html = $this->load->view('bulk_print', $datas, true);
    //         $this->pdf->createPDF($html, 'mypdf', false);
       
        
    // }
    public function printBulkMember($id)
    {
        $datas['single_member'] = $_POST['selected_ids'];
        // print_r($datas['single_member']);exit();
        $html = $this->load->view('bulk_print', $datas);
    }
    public function blockMembers()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/block_members',$datas, true);
        $this->AdminLayout(); 
    }
    public function blockMembersOffline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/block_members_offline',$datas, true);
        $this->AdminLayout(); 
    }
    public function blockMembersOnline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/block_members_online',$datas, true);
        $this->AdminLayout(); 
    }
    public function closeMembers()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/close_members',$datas, true);
        $this->AdminLayout(); 
    }
    public function closeMembersOffline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/close_members_offline',$datas, true);
        $this->AdminLayout(); 
    }
    public function closeMembersOnline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/close_members_online',$datas, true);
        $this->AdminLayout(); 
    }
    public function duplicateMembers()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/duplicate_members',$datas, true);
        $this->AdminLayout(); 
    }
    public function duplicateMembersOffline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/duplicate_members_offline',$datas, true);
        $this->AdminLayout(); 
    }
    public function duplicateMembersOnline()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/duplicate_members_online',$datas, true);
        $this->AdminLayout(); 
    }
    public function onlineRegisterMembers()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/online_register_members',$datas, true);
        $this->AdminLayout(); 
    }
    public function onlineRegisterMale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/online_register_male',$datas, true);
        $this->AdminLayout(); 
    }
    public function onlineRegisterFemale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/online_register_female',$datas, true);
        $this->AdminLayout(); 
    }
    public function onlineRegisterRenew()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/online_register_renew',$datas, true);
        $this->AdminLayout(); 
    }
    public function onlineRegisterUnpaid()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/online_register_unpaid',$datas, true);
        $this->AdminLayout(); 
    }
    public function addNewMember()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/add_new_member',$datas, true);
        $this->AdminLayout(); 
    }
    public function saveMember()
    {
        $inputs = $this->input->post();
        $newMenberId = '';
        if($inputs['gender'] == '1')
        {
            $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1,'prefixId !='=>0))->row_array();

            $getId  = $u['prefixId'];
            if($getId < 5131)
            {   $t = 5131;
                $newMenberId = 'Male5131';
            }
            else
            {
                $t = $getId + 1;
                $newMenberId = 'Male'.$t;
            }

        }else{
            $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2,'prefixId !='=>0))->row_array();
                                            
            $getId  = $u['prefixId'];
            if($getId < 2677)
            {
                $newMenberId = 'Female2677';
            }
            else
            {
                $t = $getId +1;
                $newMenberId = 'Female'.$t;
            }
        }
        if ($_POST['gender'] == 1) {
            $profile_image[] = array(
                'profile_image' => 'default.jpg',
                'thumb'         =>  'default_thumb.jpg'
                );
            
            $profile_image = json_encode($profile_image);
        }
        else
        {
            $profile_image[] = array(
                'profile_image' =>  'default_female.jpg',
                'thumb'         =>  'default_female_thumb.jpg'
            );
            
            $profile_image = json_encode($profile_image);
        }

        $basic_info[] = array('age' => (date('Y') - date('Y', strtotime($this->input->post('date_of_birth')))),
                'marital_status'        => '',
                'number_of_children'    => '',
                        
                //   'on_behalf'        => $this->input->post('on_behalf')
                        );
                        
        $basic_info = json_encode($basic_info);

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
              'Expectation'                 => '',
              'Earnings'                 => '',

              );
        $education_and_career = json_encode($education_and_career);

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

        $permanent_address[] = array('permanent_country'    => '',
              'permanent_city'                => '',
              'permanent_state'               => '',
              'permanent_postal_code'         => '',
              'address'         => '',
              'mobile'         => $this->input->post('mobile'),
              );
        $permanent_address = json_encode($permanent_address);

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
            $chart = json_encode($chart);

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

        $pic_privacy[] = array(
              'profile_pic_show'        => 'all',
              'gallery_show'            => 'premium'

              );
        $pic_privacy = json_encode($pic_privacy);

        $plan = getData('plan','row',array('plan_id '=>$inputs['current_package'])); 

        if($inputs['member_type']==1){

            $amount = $plan->amount;
            $name = $plan->name;
            $type = 'Online_Admin';
        }else{
            $amount = $plan->offline_amount;
            $name = $plan->offline_name;
            $type = 'DIRECT_CASH';
        }
        // print_r($plan);exit;
        $package_info[]=array(
            'current_package'=>$name,
            'package_price'     => $amount,
            'payment_type'      => $type,
        );
         $package_info = json_encode($package_info);
        
        $input = array(
            // 'member_profile_id' => $newMenberId,
            'first_name' => $inputs['first_name'],
            'email' => $inputs['email'],
            'gender' => $inputs['gender'],
            'member_type' => $inputs['member_type'],
            'mobile' => $inputs['mobile'],
            'password' => sha1($inputs['password']),
            'date_of_birth' =>  strtotime($inputs['date_of_birth']),
        );
        // $input['first_name'] = $this->input->post('first_name');
        // $input['gender'] = $this->input->post('gender');
        // $input['email'] = $this->input->post('email');
        // $input['member_type'] = $this->input->post('member_type');
        // $input['password'] = $this->input->post('password');
        // $input['mobile'] = $this->input->post('mobile');
        $input['basic_info'] = $basic_info;
        $input['education_and_career'] = $education_and_career;
        $input['physical_attributes'] = $physical_attributes;
        $input['astronomic_information'] = $astronomic_information;
        $input['permanent_address'] = $permanent_address;
        $input['family_info'] = $family_info;
        $input['partner_expectation'] = $partner_expectation;
        $input['chart'] = $chart;
        $input['privacy_status'] = $privacy_status;
        $input['pic_privacy'] = $pic_privacy;
        $input['profile_image'] = $profile_image;
        $input['package_info'] = $package_info;
        $input['interest'] = '[]';
        $input['short_list'] = '[]';
        $input['followed'] = '[]';
        $input['ignored'] = '[]';
        $input['ignored_by'] = '[]';
        $input['gallery'] = '[]';
        $input['happy_story'] = '[]';
        $input['payments_info'] = '[]';
        $input['interested_by'] = '[]';
        $input['follower'] = 0;
        $input['notifications'] = '[]';
        $input['membership'] = 1;
        $input['is_closed'] = 'no';
        $input['profile_status'] = 1;
        $input['member_since'] = date("Y-m-d H:i:s");
        $input['member_since_for_edit_profile'] = date("Y-m-d");
        $input['express_interest'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->express_interest;
        $input['direct_messages'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->direct_messages;
        $input['photo_gallery'] = $this->db->get_where('plan', array('plan_id'=> 1))->row()->photo_gallery;
        $input['profile_completion'] = 0;
        $input['is_blocked'] = 'no';
        // $input['membership_date'] = date('Y-m-d');
        $input['member_since_for_edit_profile'] = date('Y-m-d');
        $input['prefixId'] = 0;
        if($input['member_type']==1){

            $input['member_profile_id'] = '';
            $input['prefixId'] = '';
            $input['active_status']=0;
            $input['is_closed']='yes';
            $paymenet_status = 'due';
            $active_status = 0;
            $type = 'Online_Admin';
        }else{
            $input['member_profile_id'] = $newMenberId;
            $input['prefixId'] = $t;
            $input['is_closed']='no';
            $input['active_status']=1;

            $paymenet_status = 'paid';
            $active_status = 1;
            $type = 'DIRECT_CASH';
        }
            $SMSTEXT="Dear ".$input['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$newMenberId.". To access your profile kindly visit http://thirumanam.info/";
            

             $mobile = "91".$input['mobile'];
             $this->Customers_model->sendSms($mobile,$SMSTEXT);
        
        
        // print_r($plan);exit;


        $this->db->insert('member', $input);
        
        $insert_id = $this->db->insert_id();
        $data['plan_id']=$plan->plan_id;
        $data['member_id']=$insert_id;
        $data['member_type']=$inputs['member_type'];
        $data['payment_status']= $paymenet_status;
        $data['payment_type']=$type;
        $data['amount']=$amount;
        $data['plan_amount']=$amount;
        $data['payment_timestamp'] = time();
        $data['purchase_datetime'] = time();
        $data['active_status']=$active_status;

        $this->db->insert('package_payment', $data);
        $single=$this->Customers_model->get_single_member($insert_id);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> 'Registered Member Id: '.$single->member_profile_id.' Name: '.$single->first_name,
        );
        // print_r($memberData);exit;
        $this->Customers_model->add_info('admin_activity',$activity);
        $this->session->set_flashdata('msg',showAlert('success','Save Member Successfully'));
        redirect('administrator/all_members');
        
    }
    public function deletedMembers()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/deleted_members',$datas, true);
        $this->AdminLayout();
    }

    public function restoreMember($id) 
    {
        // print_r($inputs);exit();
        $this->Customers_model->update_single_member('member',$id,array('delete_status' => '0'));
        $this->session->set_flashdata('msg',showAlert('success','Restore Successfully'));
        redirect('administrator/deleted_members');
    }
    public function oldIdRenewedMembers()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/old_id_renewed_members',$datas, true);
        $this->AdminLayout();
    }
    public function reportedMembers()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/reported_members',$datas, true);
        $this->AdminLayout();
    }
    public function membershipPlans()
    {
        $datas['plans']=$this->Customers_model->get_plan();
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Payment/membership_plans',$datas, true);
        $this->AdminLayout();
    }
    public function addPlan()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Payment/add_plan',$datas, true);
        $this->AdminLayout();
    }
    public function savePlan()
    {
        $inputs = $this->input->post();
        // print_r($inputs['direct_messages']);exit;
        if($_FILES["image"]['name']!='')
        {   
            $new_name = time().$_FILES["image"]['name'];

            $config['upload_path'] = FCPATH ."uploads/plan_image/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image'))
            {}
            else
            {
              $data = $this->upload->data();
            }
        }
        else
        {
            $new_name=$inputs['images'];
        }
        $datas=array(
            'name' => $inputs['name'],
            'offline_amount' => $inputs['offline_amount'],
            'amount' => $inputs['amount'],
            'photo_gallery' => $inputs['photo_gallery'],
            'direct_messages' => $inputs['direct_messages'],
            'express_interest' => $inputs['express_interest'],
            
        );
        $image[]=array(
            'image' => $new_name,
            
        );
        $datas['image'] = json_encode($image);
        $info[]=array(
            'english' => $inputs['english_info'],
            'tamil' => $inputs['tamil_info'],
            
        );
        $datas['info'] = json_encode($info);
        // print_r($datas);exit;
        $this->Customers_model->add_info('plan',$datas);

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> $inputs['name'].' plan was added',
        );
        $this->Customers_model->add_info('admin_activity',$activity);
        $this->session->set_flashdata('msg',showAlert('success','Save Plan Successfully'));
        redirect('administrator/membership_plans');
    }
    public function editPlan($id)
    {
        $datas['plan']=$this->Customers_model->planDetails($id);
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Payment/edit_plan',$datas, true);
        $this->AdminLayout();
    }
    public function updatePlan($id)
    {
        $inputs = $this->input->post();
        // print_r($inputs['images']);exit;
        if($_FILES["image"]['name']!='')
        {   
            $new_name = time().$_FILES["image"]['name'];

            $config['upload_path'] = FCPATH ."uploads/plan_image/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image'))
            {}
            else
            {
              $data = $this->upload->data();
            }
        }
        else
        {
            $new_name=$inputs['images'];
        }
        $datas=array(
            'name' => $inputs['name'],
            'offline_amount' => $inputs['offline_amount'],
            'amount' => $inputs['amount'],
            'photo_gallery' => $inputs['photo_gallery'],
            'direct_messages' => $inputs['direct_messages'],
            'express_interest' => $inputs['express_interest'],
            
        );
        $image[]=array(
            'image' => $new_name,
            
        );
        $datas['image'] = json_encode($image);
        $info[]=array(
            'english' => $inputs['english_info'],
            'tamil' => $inputs['tamil_info'],
            
        );
        $datas['info'] = json_encode($info);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> $inputs['name'].' plan was updated',
        );
        $this->Customers_model->add_info('admin_activity',$activity);
        $this->Customers_model->updateInfo('plan',$datas,array('plan_id'=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Update Plan Successfully'));
        redirect('administrator/membership_plans');
    }
    public function deleteplan($id)
    {
        $datas=$this->Customers_model->planDetails($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> $datas->name.' plan was deleted',
        );
        $this->Customers_model->add_info('admin_activity',$activity);
        // print_r($id);exit;
        $this->Customers_model->updateInfo('plan',array('delete_status'=>1),array('plan_id'=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Plan Successfully'));
        redirect('administrator/membership_plans');
    }
    public function successStories()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Pages/success_stories',$datas, true);
        $this->AdminLayout();
    }
    public function viewStory($id)
    {
        $datas['story']=$this->Customers_model->getstoryDatas($id); 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Pages/view_stories',$datas, true);
        $this->AdminLayout();
    }
    public function aproveStory($id)
    {
        $datas=$this->Customers_model->getstoryDatas($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> $datas->title.' story was Approved',
        );
        $this->Customers_model->add_info('admin_activity',$activity);
        // print_r($id);exit;
        $this->Customers_model->updateInfo('happy_story',array('approval_status'=>1),array('happy_story_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Aproved story Successfully'));
        redirect('administrator/stories');
    }
    public function disaproveStory($id)
    {
        $datas=$this->Customers_model->getstoryDatas($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> $datas->title.' story was Disapproved',
        );
        $this->Customers_model->add_info('admin_activity',$activity);
        // print_r($id);exit;
        $this->Customers_model->updateInfo('happy_story',array('approval_status'=>0),array('happy_story_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Disaproved story Successfully'));
        redirect('administrator/stories');
    }
    public function deleteStory($id)
    {
        $datas=$this->Customers_model->getstoryDatas($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity = array(

        'admin_id'=>$admin_id,
        'activity'=> $datas->title.' story was Deleted',
        );
        $this->Customers_model->add_info('admin_activity',$activity);
         $this->Customers_model->updateInfo('happy_story',array('delete_status'=>1),array('happy_story_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/stories');
    }
    public function totalEarnings()
    {
        $datas['']=""; 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Payment/total_earnings',$datas, true);
        $this->AdminLayout();
    }
    public function onlineEarnings()
    {
        $datas['']=""; 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Payment/online_earnings',$datas, true);
        $this->AdminLayout();
    }
    public function offlineEarnings()
    {
        $datas['']=""; 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Payment/offline_earnings',$datas, true);
        $this->AdminLayout();
    }
    public function acceptMember()
    {
        $id=$this->input->post('m_id');
        $paydata = $this->Customers_model->getData('package_payment','row',array('package_payment_id'=>$id));
        $member = $this->Customers_model->getData('member','row',array('member_id'=>$paydata->member_id));
        $plan = $this->Customers_model->getData('plan','row',array('plan_id'=>$paydata->plan_id));
        // print_r($plan);exit;
        echo'<div id="myModal'.$id.'" class="modal fade zoomIn" tabindex="-1" aria-labelledby="zoomInModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
            <div class="modal-header">
            <input type="hidden" value="'.$id.'" name="accept_member">
                <h5 class="modal-title" id="zoomInModalLabel">'.translate('accept').'</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <table class="table table-condensed table-bordered">
                <tbody>
                    <tr>
                        <th>Name :</th>
                        <td>'.((!empty($member->first_name)) ? $member->first_name : "").'</td>
                    </tr>
                    <tr>
                        <th>plan :</th>
                        <td>'.$plan->name.'</td>
                    </tr>
                    <tr>
                        <th>Mobile Number :</th>
                        <td>'.((!empty($member->mobile)) ? $member->mobile : "").'</td>
                    </tr>
                    <tr>
                        <th>Activation date :</th>
                        <td>'.$paydata->created_date.'</td>
                    </tr>
                    
                  
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                '.(($paydata->payment_status=='due') ? '<a title="ACCEPT" href="'.base_url('AdminController/updatePayment/'.$paydata->package_payment_id).'" onclick="return confirm(\'Are you sure want to accept this?\')" class="btn btn-primary ">Accept</a>': '<a class="btn btn-primary ">Already Accept</a>').'
            </div>
        </div>
    </div>
</div>

';
  }
  public function updatePayment($id)
    {
        
        $member = getMemberPayments($id);
        $single=$this->Customers_model->get_single_member($member->member_id);
        // print_r($single);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];

        $activity_data = array(

        'admin_id'=>$admin_id,
        'activity'=> 'Member Id: '.$single->member_id.' Name: '.$single->first_name.'  was activated',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
        // print_r($admin_id);exit;
                $payment_details = $this->db->get_where('package_payment', array('package_payment_id' => $id))->row();
               
                $member_details = $this->db->get_where('member', array('member_id' => $payment_details->member_id))->row();
                $plan_details = $this->db->get_where('plan', array('plan_id' => $payment_details->plan_id))->row();
 
                if ($plan_details->plan_id == '1') {
                    $data['membership'] = 1;
                } else {
                    $data['membership'] = 2;
                }
                if ($member_details->member_type == '1') {
                    $member_type = 1;
                } else {
                    $member_type = 2;
                }

                // print_r($member_details->remain_download);exit;

                if ($payment_details->amount==$plan_details->amount || $member_details->remain_download) {
                    $data['express_interest'] = $member_details->express_interest + $plan_details->express_interest;
                    $data['remain_download'] = 100;
                    $data['membership_date'] = date('Y-m-d');
                    $data['member_since_for_edit_profile'] = date('Y-m-d');
                    $data['direct_messages'] = $member_details->direct_messages + $plan_details->direct_messages;
                    $data['photo_gallery'] = $member_details->photo_gallery + $plan_details->photo_gallery;

                    $package_info[] = array('current_package'   => $plan_details->name,
                                'package_price' => $payment_details->amount,
                                'payment_type'  => (!empty($payment_details->custom_payment_method_name) ? $payment_details->custom_payment_method_name : $payment_details->payment_type)
                    );
                    $data['package_info'] = json_encode($package_info);
                    $data['paymentReq'] = 0;    
                    $data['member_type'] = $member_type;
                    $data['active_status'] = 1;
                    $data['is_closed']='no';
                }
                else
                {                   
                    $data['membership_date'] = date('Y-m-d');
                    $data['member_since_for_edit_profile'] = date('Y-m-d');
                    $package_info[] = array('current_package'   => $plan_details->name,
                                'package_price' => $payment_details->amount,
                                'payment_type'  => (!empty($payment_details->custom_payment_method_name) ? $payment_details->custom_payment_method_name : $payment_details->payment_type)
                    );
                    $data['package_info'] = json_encode($package_info);
                    $data['paymentReq'] = 0;    
                    $data['member_type'] = $member_type;
                    $data['is_closed']='no';
                    $data['active_status'] = 1;   
                }
                
                $this->db->where('member_id', $payment_details->member_id);
                $result = $this->db->update('member', $data);
                recache();
                if ($result) {
                    $data2['payment_status'] = "paid";
                    $data2['active_status'] = 1;
                    $this->db->where('package_payment_id', $id);
                    $result1 = $this->db->update('package_payment', $data2);
                    if($result1){
                        $memberData     = $this->db->get_where('member', array('member_id' => $payment_details->member_id))->row_array();


                    // $from=$this->Customers_model->getData('general_settings','row',array('type' => 'system_email'));
                    // $smtp_host=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_host'));
                    // $smtp_user=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_user'));
                    // $smtp_pass=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_pass'));
                    // $smtp_port=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_port'));
                    // print_r($from->value);echo '<br>';
                    // print_r($smtp_host->value);echo '<br>';
                    // print_r($smtp_user->value);echo '<br>';
                    // print_r($smtp_pass->value);echo '<br>';
                    // print_r($smtp_port->value);echo '<br>';
                    // print_r($memberData['email']);exit;


            
            $checkRegisDate = date('Y-m-d');
            // if ($member_details->member_profile_id!='') {            
                $newMemberId = "";
                $t = 0;
                if($memberData['gender'] == '1')
                {
                    $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>1,'prefixId !='=>0))->row_array();

                    $getId  = $u['prefixId'];
                    if($getId < 5131){
                        $t = 5131;
                        $newMemberId = 'Male5131';
                    }
                    else{
                        $t = $getId + 1;
                        $newMemberId = 'Male'.$t;
                    }
                }else{
                    $u = $this->db->order_by('prefixId','DESC')->limit(1)->get_where('member',array('gender'=>2,'prefixId !='=>0))->row_array();

                    $getId  = $u['prefixId'];
                    if($getId < 2677)
                    {
                        $newMemberId = 'Female2677';
                    }
                    else
                    {
                        $t = $getId +1;
                        $newMemberId = 'Female'.$t;
                    }
                }
                $updateData = array("member_profile_id"=>$newMemberId,"prefixId"=>$t);
                $this->db->update("member",$updateData,array("member_id"=>$payment_details->member_id));
            // }
             $checkRegisDate = date('Y-m-d', strtotime("+6 months", strtotime($memberData['member_since'])));
             // print_r($memberData['email']);exit;
        
            if($checkRegisDate <= date("Y-m-d"))
            {
                // print_r('renew');exit;
           
            unset($memberData['member_id']);
            $insertMember = $this->db->insert('deactivated_member',$memberData);
         

            $updateData = array('member_since'=>date('Y-m-d H:i:s'),"isRenewed"=>1);
            $this->db->update("member",$updateData,array("member_id"=>$payment_details->member_id));
             

             $SMSTEXT = "Dear ".$memberData['first_name'].", your account has been renewed with Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$newMemberId.".";
            // $SMSTEXT="Dear ".$memberData['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$newMemberId.". To access your profile kindly visit http://thirumanam.info/";

             $mobile = "91".$memberData['mobile'];
             $this->Customers_model->sendSms($mobile,$SMSTEXT);



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
               if(!empty($memberData['email']))
            {
               $from=$this->Customers_model->getData('general_settings','row',array('type' => 'system_email'));
                    $smtp_host=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_host'));
                    $smtp_user=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_user'));
                    $smtp_pass=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_pass'));
                    $smtp_port=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_port'));
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
            }
            else
            {
                // print_r('created');exit;
            $SMSTEXT = "Dear ".$memberData['first_name'].", your account has been activated in Sri Sowdeswari Amman Narpani Mandram and your member ID :  ".$newMemberId.". To access your profile kindly visit https://thirumanam.info/";
             // $SMSTEXT="Dear ".$memberData['first_name'].", your account has been created in Sri Sowdeswari Amman Narpani Mandram and your member ID : ".$newMemberId.". To access your profile kindly visit http://thirumanam.info/";
            

             $mobile = "91".$memberData['mobile'];
             $this->Customers_model->sendSms($mobile,$SMSTEXT);
             

             

                $email_template = getData('email_templates','row',array('temp_name'=>'activated'));
            
            
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
               // $this->load->view('Administrator/emails/activatemail',$emailText);
                
               

               
                if(!empty($memberData['email']))
            {
                $from=$this->Customers_model->getData('general_settings','row',array('type' => 'system_email'));
                $smtp_host=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_host'));
                $smtp_user=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_user'));
                $smtp_pass=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_pass'));
                $smtp_port=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_port'));
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
                $msg=$this->load->view('Administrator/emails/activatemail',$emailText, true);
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
            }
                        
                      
                        
                        
                        
                        $this->session->set_flashdata('msg',showAlert('success','Accepted Successfully'));
                        redirect('administrator/activation');
                    }
                }
                else{
                     $this->session->set_flashdata('msg',showAlert('danger','payment_accepted_error'));
                        redirect('administrator/activation');
                }

            



        // $this->Customers_model->updateInfo('member',array('active_status'=>'1'),array('member_id '=>$member->member_id));
        //  $this->Customers_model->updateInfo('package_payment',array('payment_status'=>'paid'),array('package_payment_id '=>$id));
        // $this->session->set_flashdata('msg',showAlert('success','Accepted Successfully'));
        // redirect('administrator/activation');
    }
    public function deletePayment($id)
    {
        $member = getMemberPayments($id);
        $single=$this->Customers_model->get_single_member($id);
        // print_r($member);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

        'admin_id'=>$admin_id,
        'activity'=> 'Member Id: '.$single->member_profile_id.' Name: '.$single->first_name.'  was deleted in activated',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
         $this->Customers_model->updateInfo('package_payment',array('delete_status'=>1),array('package_payment_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/activation');
    }
    public function contactMessage()
    {
        $datas['']=""; 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Messages/contact_message',$datas, true);
        $this->AdminLayout();
    }
    public function viewMessage($id)
    {
        $datas['message']=$this->Customers_model->getData('contact_message','row',array('contact_message_id '=>$id)); 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Messages/view_message',$datas, true);
        $this->AdminLayout();
    }
    public function saveReply($id)
    {
        $inputs = $this->input->post();

        $datas=array(
            'reply'=>$inputs['reply'],
        );
        
         $this->Customers_model->updateInfo('contact_message',$datas,array('contact_message_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Reply Send Successfully'));
        redirect('administrator/view_message');
    }
    public function deleteMessage($id)
    {
        $datas=$this->Customers_model->getData('contact_message','row',array('contact_message_id '=>$id));
         // print_r($datas);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

        'admin_id'=>$admin_id,
        'activity'=> $datas->name.' contact message was deleted',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
         $this->Customers_model->updateInfo('contact_message',array('delete_status'=>1),array('contact_message_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/contact_message');
    }
    public function newsLetter()
    {
        $datas['news']=$this->Customers_model->getDatas('member','result');
        $datas['templates']=$this->Customers_model->getDatas('email_templates','result'); 
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Messages/news_letter',$datas, true);
        $this->AdminLayout();
    }
    public function sendMail()
    {
        $toemail       = explode(',', $this->input->post('email'));
        // for($i=0;$i<count($toemail);$i++)
        // {
        //      echo $i.'<br>';
        // }
        // print_r($this->input->post());exit;
        $subject        = $this->input->post('subject');
        $inputs['inputs']     = $this->input->post(); 
        // $this->load->view('Administrator/emails/contactmail',$inputs);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

        'admin_id'=>$admin_id,
        'activity'=> 'newsLetter was sended. subject: '.$subject,
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);              
        $from_name = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
        if(empty($subject)){
            $subject = 'iCLIENT';
        }
        $from=$this->Customers_model->getData('general_settings','row',array('type' => 'system_email'));
        $smtp_host=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_host'));
        $smtp_user=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_user'));
        $smtp_pass=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_pass'));
        $smtp_port=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_port'));
        // print_r($toemail);exit;
            // $msg=$this->load->view('Administrator/emails/contactmail',$inputs);
        for($i=0;$i<count($toemail);$i++)
        {
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
            $this->email->to($toemail[$i]);
            $this->email->subject($subject);
            $msg=$this->load->view('Administrator/emails/contactmail',$inputs, true);
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
        

        $this->session->set_flashdata('msg',showAlert('success','Send Successfully'));
        redirect('administrator/news_letter');
    }

    public function expiryAlert()
    {
        $datas['members']=$this->Customers_model->getData('member','result',array('is_closed' => "no","is_blocked"=>'no')); 
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Alert/expiry_alert',$datas, true);
        $this->AdminLayout();
    }
    public function sendAlert()
    {
         
        
        $inputs=$this->input->post();
       // print_r($inputs);exit; 
        
        $error_code=0;
       
        if (!empty($inputs['members']))
        {
            foreach ($inputs['members'] as $value) 
            {
              $member=$this->Customers_model->getData('member','row',array('member_id' => $value));

              if(in_array(1,$inputs['type'])) 
              {
                

                if($member->mobile!='')
                {
                // print_r($member);exit;
                // print_r($member->mobile);exit;
                $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                $activity_data = array(

                'admin_id'=>$admin_id,
                'activity'=> 'member Id: '.$member->member_profile_id.' Name: '.$member->first_name.' expiry alert was sended through message',
                );
                $this->Customers_model->add_info('admin_activity',$activity_data);

                    $mobile = "91".$member->mobile;
                    // $message = "Dear ".$member->first_name.", your account going to expire soon, Please Renew Your Membership in Sri Sowdeswari Amman Narpani Mandram, and your member ID: ".$member->member_profile_id.". To access your profile kindly visit https://thirumanam.info/";

                    $message = "Dear ".$member->first_name.", your membership with Sri Sowdeswari Amman Narpani Mandram will be expiring soon for the  ID:  ".$member->member_profile_id.",   for uninterpreted service kindly renew Your Membership.Note: Id will get deactivated if the profile is not renewed with in 30 days of expiry. To access your profile kindly visit https://thirumanam.info/
                    ";
                    if($this->Customers_model->sendSms($mobile,$message))
                    {
                        
                    }else
                    {
                        $error_code=1;
                    }
                }else

                {

                ////////////////

                }
              }
              if (in_array(2,$inputs['type'])) 
              {
                if($member->email!='')
                {
                    $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                    $activity_data = array(

                    'admin_id'=>$admin_id,
                    'activity'=> 'member Id: '.$member->member_profile_id.' Name: '.$member->first_name.' expiry alert was sended through Email',
                    );
                    $this->Customers_model->add_info('admin_activity',$activity_data);

                    
                    $email_template = getData('email_templates','row',array('temp_name'=>'Expired'));
                    $package = $this->MetaModel->getMemberPlan($member->member_id);
                    $plan_name = "";
                    if(!empty($package)){

                    $plan = $this->MetaModel->getPlan($package->plan_id);
                    if($member->member_type == 1){
                        $plan_name = $plan->name;
                    }else{

                        $plan_name = $plan->offline_name;

                    }  
                    }
                    
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
                       href="http://192.168.0.126/ci/thirumanam_new/Subscription" target="_blank">Renew Now
                    </a>';
                   $link = '&copy; <strong><a style="font-family:Lucida Console" href="https://thirumanam.info/" target="_blank">www.thirumanam.info</a></strong>';
                   $email_template  = $email_template->template;
                   $name = ["[[logo]]", "[[name]]", "[[member_id]]", "[[mobile]]", "[[plan]]", "[[renew]]","[[link]]"];
                   $value   = [$image, $member->first_name, $member->member_profile_id, $member->mobile, $plan_name,$subscribe, $link];
                   $emailText['text'] = str_replace($name, $value, $email_template);
                  
                   // $this->load->view('Administrator/emails/expirymail',$emailText);
                    
                    
                   } 
                   
                    // print_r($emailText);exit;
                    // print_r($emailText);exit;
                   
                    $from=$this->Customers_model->getData('general_settings','row',array('type' => 'system_email'));
                    $smtp_host=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_host'));
                    $smtp_user=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_user'));
                    $smtp_pass=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_pass'));
                    $smtp_port=$this->Customers_model->getData('general_settings','row',array('type' => 'smtp_port'));
                    $toemail = $member->email;
                    // print_r($from->value.'/'.$smtp_host->value.'/'.$smtp_user->value.'/'.$smtp_pass->value.'/'.$smtp_port->value);exit;
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

                    $this->email->from($smtp_user->value);
                    $this->email->to($toemail);
                    $this->email->subject($subject);
                    $msg=$this->load->view('Administrator/emails/expirymail',$emailText, true);
                    $this->email->message($msg);

                    if($this->email->send())
                    {
                        $mail_status='send';
                        
                    }
                    else
                    {
                        echo $this->email->print_debugger();exit;
                        $mail_status='not-send';
                        $error_code=1;
                    }
                }else
                {

                //////////////////

                }
              }
            }
        }
        if($error_code==1){
            $this->session->set_flashdata('msg',showAlert('warning','message Not Send'));
            redirect("administrator/expiry_alert");
        }else
        {
            $this->session->set_flashdata('msg',showAlert('success','message Send Successfully'));
            redirect("administrator/expiry_alert");
        }
        
    }
    public function previewTemplate($id)
    {
        // print_r($id);exit;

        $email_template = getData('email_templates','row',array('id'=>$id));
        $member = get_random_members();
        $package = $this->MetaModel->getMemberPlan($member->member_id);
        $plan_name = "";
        if(!empty($package)){

        $plan = $this->MetaModel->getPlan($package->plan_id);
        if($member->member_type == 1){
            $plan_name = $plan->name;
        }else{

            $plan_name = $plan->offline_name;

        }  
        }
        // print_r($member);exit;
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
           href="http://192.168.0.126/ci/thirumanam_new/Subscription" target="_blank">Renew Now
        </a>';
       $link = '&copy; <strong><a style="font-family:Lucida Console" href="https://thirumanam.info/" target="_blank">www.thirumanam.info</a></strong>';
       if($email_template->temp_name=='Expired'){
        $name = ["[[logo]]", "[[name]]", "[[member_id]]", "[[mobile]]", "[[plan]]", "[[renew]]","[[link]]"];
       $value   = [$image, $member->first_name, $member->member_profile_id, $member->mobile, $plan_name,$subscribe, $link];
       }else{

        $name = ["[[logo]]", "[[name]]", "[[member_id]]", "[[mobile]]", "[[email]]", "[[link]]"];
           $value   = [$image, $member->first_name, $member->member_profile_id, $member->mobile, $member->email, $link];

       }
       
       $emailText['text'] = str_replace($name, $value, $email_template->template);
       $this->load->view('Administrator/emails/expirymail',$emailText);
    }
    public function memories()
    {
        $datas['memories']=$this->Customers_model->getDatas('memories','result'); 
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Images/memories',$datas, true);
        $this->AdminLayout();
    }

    public function saveMemories()
    {
        if (isset($_FILES['file'])) {
                 
            $file_name=time().'_'.htmlspecialchars( basename( $_FILES["file"]["name"]));
            $file_tmp=$_FILES["file"]["tmp_name"];
            $ext=pathinfo($file_name,PATHINFO_EXTENSION);

            $path=getcwd().'/uploads/memories/';
            if(move_uploaded_file($file_tmp,$path.$file_name))
            {
                echo 'uploaded';
                $datas = array('name' => $file_name,);
                $this->Customers_model->add_info('memories',$datas);
            }
            else
            {                           
                echo $_FILES["file"]["error"];
            }         

            

        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Memory was Uploaded',
        );       
          $this->Customers_model->add_info('admin_activity',$activity_data);  
        } 

        

    }
    public function deleteMemoryImage($id)
    {
         $this->Customers_model->updateInfo('memories',array('delete_status'=>1),array('id'=>$id));
         $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Memory was Deleted',
        );       
          $this->Customers_model->add_info('admin_activity',$activity_data);  
        
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/memories');
    }
    public function feedSms()
    {
        $datas['']=""; 
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Messages/send_sms',$datas, true);
        $this->AdminLayout();
    }
    public function sendUserSms()
    {
        $inputs = $this->input->post();
        $error_code=0;
        // print_r($inputs);exit;
        if($inputs['member']=='all'){
            $datas = $this->Customers_model->getDatas('member','result');
            foreach($datas as $member)
            {
                if(!empty($member->mobile))
                {
                    $message = $inputs['msg'];
                    if($this->Customers_model->sendSms('91'.$member->mobile,$message))
                    {
                        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                        $activity_data = array(

                        'admin_id'=>$admin_id,
                        'activity'=> 'send sms to Allmembers. Message: '.$inputs['msg'],
                    );       
                      $this->Customers_model->add_info('admin_activity',$activity_data);
                    }else
                    {
                        $error_code=1;
                    }

                      
                }
                    
            }
        }
        
        if($inputs['member']=='online'){
            $datas = $this->Customers_model->getOnlineDatas('member','result');
            foreach($datas as $member)
            {
                if(!empty($member->mobile))
                {
                    $message = $inputs['msg'];
                    if($this->Customers_model->sendSms('91'.$member->mobile,$message))
                    {
                        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                        $activity_data = array(

                        'admin_id'=>$admin_id,
                        'activity'=> 'send sms to onlinemembers. Message: '.$inputs['msg'],
                    );
                    $this->Customers_model->add_info('admin_activity',$activity_data);  
                    }else
                    {
                        $error_code=1;
                    }

                    
                }
            }
        }
        if($inputs['member']=='offline'){
            $datas = $this->Customers_model->getOfflineDatas('member','result');
            foreach($datas as $member)
            {
                if(!empty($member->mobile))
                {
                    $message = $inputs['msg'];
                    if($this->Customers_model->sendSms('91'.$member->mobile,$message))
                    {
                        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                        $activity_data = array(

                        'admin_id'=>$admin_id,
                        'activity'=> 'send sms to Offlinemembers. Message: '.$inputs['msg'],
                    );
                    $this->Customers_model->add_info('admin_activity',$activity_data); 

                    }else
                    {
                        $error_code=1;
                    }
                     
                }
            }
        }
        if($inputs['member']=='test'){
            $mobile = "919500438555,918124363776";
            $message = $inputs['msg'];
            if($this->Customers_model->sendSms($mobile,$message))
            {
                $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
                $activity_data = array(

                    'admin_id'=>$admin_id,
                    'activity'=> 'send sms for Testing. Message: '.$inputs['msg'],
                );
                $this->Customers_model->add_info('admin_activity',$activity_data);  
            }else
            {
                $error_code=1;
            }
        }

        if($error_code==1){
            $this->session->set_flashdata('msg',showAlert('warning','message Not Send'));
            redirect("administrator/send_sms");
        }else
        {
            $this->session->set_flashdata('msg',showAlert('success','message Send Successfully'));
            redirect("administrator/send_sms");
        }
    }
    public function importantNotes()
    {
        $datas['message']=$this->Customers_model->getData('important_note','row',array('id'=>1)); 
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Pages/important_notes',$datas, true);
        $this->AdminLayout();
    }

    public function updateNote()
    {
        $inputs = $this->input->post();
        // print_r($inputs);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Importent Notes Updated',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
         $this->Customers_model->updateInfo('important_note',$inputs,array('id'=>1));
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/important_notes');
    }

    public function ManageAdminProfile()
    {
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $datas['admin']=$this->Customers_model->getData('admin','row',array('admin_id'=>$admin_id));
        $datas['all_admins']=$this->Customers_model->getDatas('admin','result'); 
        $datas['admin_login_image']=$this->Customers_model->getData('general_settings','row',array('type'=>'admin_login_image'));
        $datas['forget_pass_image']=$this->Customers_model->getData('general_settings','row',array('type'=>'forget_pass_image')); 
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/Manage_admin_profile',$datas, true);
        $this->AdminLayout();
    }
    public function updateadmin($id)
    {
        $inputs = $this->input->post();
        // print_r($inputs);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'admin Profile Detail Updated',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
         $this->Customers_model->updateInfo('admin',$inputs,array('admin_id'=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/Manage_admin_profile');
    }
    public function updatePassword($id)
    {
        $inputs = $this->input->post();
        
        $current_password = sha1($inputs['current_password']);
        $data['password'] = sha1($inputs['new_password']);
        $confirm_password = sha1($inputs['confirm_password']);
        $datas=$this->Customers_model->getData('admin','row',array('admin_id'=>$id)); 
        // print_r($datas->password);exit;
        $prev_password = $datas->password;
        if ($current_password==$prev_password && $data['password']!=$current_password && $data['password']==$confirm_password) {
            $this->Customers_model->updateInfo('admin',$data,array('admin_id'=>$id));
            $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
            $admindata = array(

            'admin_id'=>$admin_id,
            'activity'=> 'admin Profile Password Updated',
        );
        $this->Customers_model->add_info('admin_activity',$admindata);
            $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
            redirect('administrator/Manage_admin_profile');
        }
        elseif($current_password!=$prev_password) 
        {
            $this->session->set_flashdata('msg',showAlert('danger','Current password Prev Passwors Mismatsh!!'));
            redirect('administrator/Manage_admin_profile');
        }
        elseif($data['password']==$current_password) 
        {
            $this->session->set_flashdata('msg',showAlert('danger','Try Another New Password'));
            redirect('administrator/Manage_admin_profile');
        }
        elseif($data['password']!=$confirm_password) 
        {
            $this->session->set_flashdata('msg',showAlert('danger','New Password Corfirm Password MisMatch'));
            redirect('administrator/Manage_admin_profile');
        }
        
    }

    public function updateAdminPassword()
    {
        $inputs = $this->input->post();

        $admin_id = $inputs['admin'];
        $admin=$this->Customers_model->getData('admin','row',array('admin_id'=>$admin_id));
        // print_r($admin_name->name);exit;
        $data['password'] = sha1($inputs['new_password']);
        $confirm_password = sha1($inputs['confirm_password']);
        if ($data['password']==$confirm_password) {
            $this->Customers_model->updateInfo('admin',$data,array('admin_id'=>$admin_id));
            $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
            $admindata = array(

            'admin_id'=>$admin_id,
            'activity'=> 'admin '.$admin->name.' Password Updated',
        );
        $this->Customers_model->add_info('admin_activity',$admindata);
            $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
            redirect('administrator/Manage_admin_profile');
        }
        else 
        {
            $this->session->set_flashdata('msg',showAlert('danger','New Password Corfirm Password MisMatch'));
            redirect('administrator/Manage_admin_profile');
        }
        
    }

    public function updateloginImage()
    {
         $data=$this->Customers_model->getData('general_settings','row',array('type'=>'admin_login_image'));
        // print_r($_FILES["memory_image"]['name']);exit;
        if($_FILES["image"]['name']!='')
        {   
            $new_name = time().$_FILES["image"]['name'];

            $config['upload_path'] = FCPATH ."uploads/admin_login_image/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image'))
            {}
            else
            {
              $data = $this->upload->data();
            }
        $value[]=array(
            'image' => $new_name,
        );
        $datas['value'] = json_encode($value);
        }
        else
        {
            $datas['value']=$data->value;
        }
        
        // print_r($datas['value']);exit;
        $this->Customers_model->updateInfo('general_settings',$datas,array('type'=>'admin_login_image'));
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/Manage_admin_profile');
    }

    public function updateForgetImage()
    {
        $data=$this->Customers_model->getData('general_settings','row',array('type'=>'forget_pass_image'));
        // print_r($_FILES["memory_image"]['name']);exit;
        if($_FILES["image"]['name']!='')
        {   
            $new_name = time().$_FILES["image"]['name'];

            $config['upload_path'] = FCPATH ."uploads/forget_pass_image/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('image'))
            {}
            else
            {
              $data = $this->upload->data();
            }
            $value[]=array(
            'image' => $new_name,
        );
        $datas['value'] = json_encode($value);
        }
        else
        {
           $datas['value']=$data->value;
        }
        
        $this->Customers_model->updateInfo('general_settings',$datas,array('type'=>'forget_pass_image'));
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/Manage_admin_profile');
    }
    public function allStaffs()
    {
        $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/all_staffs',$datas, true);
        $this->AdminLayout();
    }
    public function editAdmin($id)
    {
        $datas['admin']=$this->Customers_model->getData('admin','row',array('admin_id'=>$id));
        $datas['roles']=$this->Customers_model->getDatas('role','result');
        // print_r($data);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/edit_admin',$datas, true);
        $this->AdminLayout();
    }
     public function updateStaff($id)
    {
        $inputs = $this->input->post();
        
        $admin_data=$this->Customers_model->getData('admin','row',array('admin_id'=>$id));
        // print_r($admin_data);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Staff Pannel admin Profile Detail Updated Name :'.$admin_data->name,
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
         $this->Customers_model->updateInfo('admin',$inputs,array('admin_id'=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/all_staffs');
    }
    public function deleteAdmin($id)
    {
        $admin_data=$this->Customers_model->getData('admin','row',array('admin_id'=>$id));
        // print_r($admin_data);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Staff Pannel admin Profile Detail Deleted Name :'.$admin_data->name,
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);

         $this->Customers_model->updateInfo('admin',array('delete_status'=>1),array('admin_id'=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/all_staffs');
    }
    public function addStaff()
    {
        $datas['roles']=$this->Customers_model->getDatas('role','result');
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/add_staff',$datas, true);
        $this->AdminLayout();
    }

    public function saveStaff()
    {   
        $inputs = $this->input->post(); 
        // print_r($inputs);exit();
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Staff Pannel admin Profile Detail created Name :'.$inputs['name'],
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
        $this->Customers_model->add_info('admin',$inputs);
        $this->session->set_flashdata('msg',showAlert('success','Saved Successfully'));
        redirect('administrator/all_staffs');
    }
    public function manageRole()
    {
        $datas['roles']=$this->Customers_model->getDatas('role','result');
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/manage_role',$datas, true);
        $this->AdminLayout();
    }
    public function editRole($id)
    {
        $datas['admin']=$this->Customers_model->getData('role','row_array',array('role_id'=>$id));
        $datas['permissions']=$this->Customers_model->getDatas('permission','result_array');
        // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/edit_role',$datas, true);
        $this->AdminLayout();
    }
     public function updateRole($id)
    {   
        $inputs= $this->input->post(); 
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Staff Pannel admin manage role Updated Name :'.$inputs['name'],
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
        $roles = $inputs['permission'];
        $datas = array(

            'name' => $inputs['name'],
            'description' => $inputs['description'],
        );
        $datas['permission'] = json_encode($roles);
        // print_r($inputs['permission']);exit;
        $this->Customers_model->updateInfo('role',$datas,array('role_id '=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
        redirect('administrator/manage_role');
    }
    public function addRole()
    {
         $datas['permissions']=$this->Customers_model->getDatas('permission','result');
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Adminusers/add_role',$datas, true);
        $this->AdminLayout();
    }
    public function saveRole()
    {   
        $inputs= $this->input->post(); 
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Staff Pannel admin manage role Created Name :'.$inputs['name'],
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
        $roles = $inputs['permission'];
        $datas = array(

            'name' => $inputs['name'],
            'description' => $inputs['description'],
        );
        $datas['permission'] = json_encode($roles);
        $this->Customers_model->add_info('role',$datas);
        $this->session->set_flashdata('msg',showAlert('success','Saved Successfully'));
        redirect('administrator/manage_role');
    }
    public function deleteRole($id)
    {
        $admin_role=$this->Customers_model->getData('role','row_array',array('role_id'=>$id));
        // print_r($admin_role['name']);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Staff Pannel admin manage role Deleted Name :'.$admin_role['name'],
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
         $this->Customers_model->updateInfo('role',array('delete_status'=>1),array('role_id'=>$id));
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/manage_role');
    }
    public function reports()
    {
        $datas['member_type'] = '';
        $datas['filter_by'] = '';
        $datas['from_date'] = '';
        $datas['to_date'] = '';
        $datas['male_count'] = '';
        $datas['female_count'] = '';
        $datas['permissions']=$this->Customers_model->getDatas('permission','result');
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Pages/reports',$datas, true);
        $this->AdminLayout();
    }
    public function searchReport()
    {

        // $payment = $this->Customers_model->getDatas('package_payment','result');
       
        // foreach($payment as $value){

        //     $date = date('Y-m-d H:i:s', $value->payment_timestamp);
        //     $this->Customers_model->updateInfo('package_payment',array('created_date'=>$date),$value->package_payment_id);
        //      print_r($value->package_payment_id);exit;
        // }
        $inputs = $this->input->post();
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'search Reportes',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
        $member_type = ($inputs['member_type']) ? $inputs['member_type'] : 'all';
        $filter_by = ($inputs['filter_by']) ? $inputs['filter_by'] : 'today';
        $from_date = ($inputs['from_date']) ? $inputs['from_date'] :date('Y-m-d');
        $to_date = ($inputs['to_date']) ? $inputs['to_date'] : date('Y-m-d');
        $datas['member_type'] = $member_type;
        $datas['filter_by'] = $filter_by;
        $datas['from_date'] = $from_date;
        $datas['to_date'] = $to_date;
        $male_count = $this->Customers_model->reportTotal($member_type,$from_date,$to_date,1);
        $female_count = $this->Customers_model->reportTotal($member_type,$from_date,$to_date,2);
        $datas['male_count'] = count($male_count);
        $datas['female_count'] = count($female_count);
        $datas['males'] = $male_count;
        $datas['females'] = $female_count;
        $fdate[0] = $fdate[1] = $fdate[2] = $fdate[3] = $fdate[4] = $fdate[5] = $fdate[6] = $fdate[7] = $fdate[8] = $fdate[9] = $fdate[10] = $fdate[11] = $fdate[12] = "";

        $month[0] = $month[1] = $month[2] = $month[3] = $month[4] = $month[5] = $month[6] = $month[7] = $month[8] = $month[9] = $month[10] = $month[11] = $month[12] =  "";

        $count1 = $count2 = $count3 = $count4 = $count5 = $count6 = $count7 = $count8 = $count9 = $count10 = $count11 = $count12 = array();
        $activecount1 = $activecount2 = $activecount3 = $activecount4 = $activecount5 = $activecount6 = $activecount7 = $activecount8 = $activecount9 = $activecount10 = $activecount11 = $activecount12 = array();

        $inactivecount1 = $inactivecount2 = $inactivecount3 = $inactivecount4 = $inactivecount5 = $inactivecount6 = $inactivecount7 = $inactivecount8 = $inactivecount9 = $inactivecount10 = $inactivecount11 = $inactivecount12 = array();

        $month1 = $month2 = $month3 = $month4 = $month5 = $month6 = $month7 = $month8 = $month9 = $month10 = $month11 = $month12 = "";
        // print_r($filter_by);exit;
        if($filter_by!='today' && $filter_by!='last_week')
        {

        $begin = new DateTime($from_date);
        $end = new DateTime($to_date);

        $interval = DateInterval::createFromDateString('1 month');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($period as $index => $dt) {
            $dates[] =  $dt->format("Y-m");
            $months[] =  $dt->format("M");
            

            
        }
        $last_month = date('M',strtotime($to_date));
        
      for($i=1;$i<=count($dates);$i++)
      {
            if(!empty($dates[$i])){

            $fdate[$i]= $dates[$i];
            
            }else{

                $fdate[$i] = date('Y-m',strtotime($to_date));

            }
        
       }

      //  for($i=1;$i<=count($dates);$i++)
      // {
      //       if(!empty($dates[$i])){

      //       $tdate[$i]= $dates[$i];
            
      //       }else{

      //           $tdate[$i] = $to_date;

      //       }
        

      //  }
       // print_r($fdate[1]);exit; 
       
       for($i=1;$i<=count($months);$i++)
      {

        if(!empty($months[$i])){

            $month[$i]= $months[$i];
            
            }else{

                $month[$i] = $last_month;

            }

      }

        
        $count1 = $this->Customers_model->reportTotalchart($member_type,$fdate[1]);
        $count2 = $this->Customers_model->reportTotalchart($member_type,$fdate[2]);
        $count3 = $this->Customers_model->reportTotalchart($member_type,$fdate[3]);
        $count4 = $this->Customers_model->reportTotalchart($member_type,$fdate[4]);
        $count5 = $this->Customers_model->reportTotalchart($member_type,$fdate[5]);
        $count6 = $this->Customers_model->reportTotalchart($member_type,$fdate[6]);
        $count7 = $this->Customers_model->reportTotalchart($member_type,$fdate[7]);
        $count8 = $this->Customers_model->reportTotalchart($member_type,$fdate[8]);
        $count9 = $this->Customers_model->reportTotalchart($member_type,$fdate[9]);
        $count10 = $this->Customers_model->reportTotalchart($member_type,$fdate[10]);
        $count11 = $this->Customers_model->reportTotalchart($member_type,$fdate[11]);
        $count12 = $this->Customers_model->reportTotalchart($member_type,$fdate[12]);

        $activecount1 = $this->Customers_model->activereportTotalchart($member_type,$fdate[1]);
        $activecount2 = $this->Customers_model->activereportTotalchart($member_type,$fdate[2]);
        $activecount3 = $this->Customers_model->activereportTotalchart($member_type,$fdate[3]);
        $activecount4 = $this->Customers_model->activereportTotalchart($member_type,$fdate[4]);
        $activecount5 = $this->Customers_model->activereportTotalchart($member_type,$fdate[5]);
        $activecount6 = $this->Customers_model->activereportTotalchart($member_type,$fdate[6]);
        $activecount7 = $this->Customers_model->activereportTotalchart($member_type,$fdate[7]);
        $activecount8 = $this->Customers_model->activereportTotalchart($member_type,$fdate[8]);
        $activecount9 = $this->Customers_model->activereportTotalchart($member_type,$fdate[9]);
        $activecount10 = $this->Customers_model->activereportTotalchart($member_type,$fdate[10]);
        $activecount11 = $this->Customers_model->activereportTotalchart($member_type,$fdate[11]);
        $activecount12 = $this->Customers_model->activereportTotalchart($member_type,$fdate[12]);


        $inactivecount1 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[1]);
        $inactivecount2 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[2]);
        $inactivecount3 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[3]);
        $inactivecount4 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[4]);
        $inactivecount5 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[5]);
        $inactivecount6 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[6]);
        $inactivecount7 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[7]);
        $inactivecount8 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[8]);
        $inactivecount9 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[9]);
        $inactivecount10 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[10]);
        $inactivecount11 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[11]);
        $inactivecount12 = $this->Customers_model->inactivereportTotalchart($member_type,$fdate[12]);

        // $earningcount1 = $this->Customers_model->earningreportTotalchart($fdate[1]);
        // $earningcount2 = $this->Customers_model->earningreportTotalchart($fdate[2]);
        // $earningcount3 = $this->Customers_model->earningreportTotalchart($fdate[3]);
        // $earningcount4 = $this->Customers_model->earningreportTotalchart($fdate[4]);
        // $earningcount5 = $this->Customers_model->earningreportTotalchart($fdate[5]);
        // $earningcount6 = $this->Customers_model->earningreportTotalchart($fdate[6]);
        // $earningcount7 = $this->Customers_model->earningreportTotalchart($fdate[7]);
        // $earningcount8 = $this->Customers_model->earningreportTotalchart($fdate[8]);
        // $earningcount9 = $this->Customers_model->earningreportTotalchart($fdate[9]);
        // $earningcount10 = $this->Customers_model->earningreportTotalchart($fdate[10]);
        // $earningcount11 = $this->Customers_model->earningreportTotalchart($fdate[11]);
        // $earningcount12 = $this->Customers_model->earningreportTotalchart($fdate[12]);
        // print_r($earningcount1);exit;
        $month1 = $month[1];
        $month2 = $month[2];
        $month3 = $month[3];
        $month4 = $month[4];
        $month5 = $month[5];
        $month6 = $month[6];
        $month7 = $month[7];
        $month8 = $month[8];
        $month9 = $month[9];
        $month10 = $month[10];
        $month11 = $month[11];
        $month12 = $month[12];
        // echo $fdate[0].'<br>';
        // echo $fdate[1].'<br>';
        // echo $fdate[2].'<br>';
        // echo $fdate[3].'<br>';
        // echo $fdate[4].'<br>';
        // echo $fdate[5].'<br>';
        // echo $fdate[6].'<br>';
        // echo $fdate[7].'<br>';
        // echo $fdate[8].'<br>';
        // echo $fdate[9].'<br>';
        // echo $fdate[10].'<br>';
        // echo $fdate[11].'<br><br>';
        // echo $month[0].'<br>';
        // echo $month[1].'<br>';
        // echo $month[2].'<br>';
        // echo $month[3].'<br>';
        // echo $month[4].'<br>';
        // echo $month[5].'<br>';
        // echo $month[6].'<br>';
        // echo $month[7].'<br>';
        // echo $month[8].'<br>';
        // echo $month[9].'<br>';
        // echo $month[10].'<br>';
        // print_r($fdate[0]);exit;
       // print_r(count($count5));exit;

    }
       $datas['count1'] = count($count1);
       $datas['count2'] = count($count2);
       $datas['count3'] = count($count3);
       $datas['count4'] = count($count4);
       $datas['count5'] = count($count5);
       $datas['count6'] = count($count6);
       $datas['count7'] = count($count7);
       $datas['count8'] = count($count8);
       $datas['count9'] = count($count9);
       $datas['count10'] = count($count10);
       $datas['count11'] = count($count11);
       $datas['count12'] = count($count12);

       $datas['activecount1'] = count($activecount1);
       $datas['activecount2'] = count($activecount2);
       $datas['activecount3'] = count($activecount3);
       $datas['activecount4'] = count($activecount4);
       $datas['activecount5'] = count($activecount5);
       $datas['activecount6'] = count($activecount6);
       $datas['activecount7'] = count($activecount7);
       $datas['activecount8'] = count($activecount8);
       $datas['activecount9'] = count($activecount9);
       $datas['activecount10'] = count($activecount10);
       $datas['activecount11'] = count($activecount11);
       $datas['activecount12'] = count($activecount12);


       $datas['inactivecount1'] = count($inactivecount1);
       $datas['inactivecount2'] = count($inactivecount2);
       $datas['inactivecount3'] = count($inactivecount3);
       $datas['inactivecount4'] = count($inactivecount4);
       $datas['inactivecount5'] = count($inactivecount5);
       $datas['inactivecount6'] = count($inactivecount6);
       $datas['inactivecount7'] = count($inactivecount7);
       $datas['inactivecount8'] = count($inactivecount8);
       $datas['inactivecount9'] = count($inactivecount9);
       $datas['inactivecount10'] = count($inactivecount10);
       $datas['inactivecount11'] = count($inactivecount11);
       $datas['inactivecount12'] = count($inactivecount12);


       $datas['month1'] = $month1;
       $datas['month2'] = $month2;
       $datas['month3'] = $month3;
       $datas['month4'] = $month4;
       $datas['month5'] = $month5;
       $datas['month6'] = $month6;
       $datas['month7'] = $month7;
       $datas['month8'] = $month8;
       $datas['month9'] = $month9;
       $datas['month10'] = $month10;
       $datas['month11'] = $month11;
       $datas['month12'] = $month12;
       

        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/Pages/reports',$datas, true);
        $this->AdminLayout();
    }
     public function viewFaq()
    {
         $datas[''] = '';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/view_faq',$datas, true);
        $this->AdminLayout();
    }
     public function CommonFaq()
    {
         $datas[''] = '';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/common_faq',$datas, true);
        $this->AdminLayout();
    }
    public function onlineFaq()
    {
         $datas[''] = '';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/online_faq',$datas, true);
        $this->AdminLayout();
    }
    public function offlineFaq()
    {
         $datas[''] = '';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/offline_faq',$datas, true);
        $this->AdminLayout();
    }
     public function editFaq($id)
    {
         $datas['faq_ques'] =$this->Customers_model->getfaqData('faq_ques','row',array('id '=>$id));
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/edit_faq',$datas, true);
        $this->AdminLayout();
    }
    public function addFaq()
    {
         $datas[''] = '';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/add_faq',$datas, true);
        $this->AdminLayout();
    }
     public function editTermsandConditions()
    {
         $datas['']='';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/edit_terms_and_conditions',$datas, true);
        $this->AdminLayout();
    }
     public function editPrivacyPolicy()
    {
        $datas['']='';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/usefull_links/edit_privacy_policy',$datas, true);
        $this->AdminLayout();
    }

    public function updateTermsCondition()
    {
        $inputs = $this->input->post();
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'terms and Condition updated ',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
        // print_r($inputs['description']);exit;
        if($set_lang = $this->session->userdata('language')=='english')
        {
            $description1 = array(
            'english' => $inputs['description'] 
            );
            
            $description2 = array(
                'english' => $inputs['description2'] 
            );
        }
        else{

            $description1 = array(
            'tamil' => $inputs['description'] 
            );
            
            $description2 = array(
                'tamil' => $inputs['description2'] 
            );
        }
            $this->Customers_model->updateInfo('site_language',$description1,array('word_id '=>'1136'));
            $this->Customers_model->updateInfo('site_language',$description2,array('word_id '=>'1137'));
            $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
            redirect('administrator/edit_terms_and_conditions');
        
    }

    public function updatePrivacyPolicy()
    {
        $inputs = $this->input->post();
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Privacy Policy updated ',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
        // print_r($inputs['description']);exit;
        if($set_lang = $this->session->userdata('language')=='english')
        {
            $description1 = array(
            'english' => $inputs['description'] 
            );
        }
        else{

            $description1 = array(
            'tamil' => $inputs['description'] 
            ); 
        }
            $this->Customers_model->updateInfo('site_language',$description1,array('word_id '=>'1138'));
            $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
            redirect('administrator/edit_privacy_policy');
        
    }

    public function updateFaq()
    {
        $inputs = $this->input->post();
        // print_r($inputs);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'FAQ updated',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
       
            $faq_data = array(
            'ques_english' => $inputs['ques_english'],
            'ans_english' => $inputs['ans_english'], 
            'ques_tamil' => $inputs['ques_tamil'],
            'ans_tamil' => $inputs['ans_tamil'],
            ); 
        
            $this->Customers_model->updateInfo('faq_ques',$faq_data,array('id '=>$inputs['faq_id']));
            $this->session->set_flashdata('msg',showAlert('success','Updated Successfully'));
            redirect('administrator/view_faq');
        
    }
    public function saveFaq()
    {
        $inputs = $this->input->post();
        // print_r($inputs);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'FAQ added',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data); 
        
            $faq_data = array(
            'qId' => $inputs['qId'],
            'ques_english' => $inputs['ques_english'],
            'ans_english' => $inputs['ans_english'], 
            'ques_tamil' => $inputs['ques_tamil'],
            'ans_tamil' => $inputs['ans_tamil'],
            );
         
        
            $this->Customers_model->add_info('faq_ques',$faq_data);
            $this->session->set_flashdata('msg',showAlert('success','Saved Successfully'));
            redirect('administrator/view_faq');
        
    }

     public function memberActivity()
    {
         $datas['']='';
         // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/activity/member_activity',$datas, true);
        $this->AdminLayout();
    }
    public function addtemplate()
    {
         $datas['']= "";
         // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/emails/email_template',$datas, true);
        $this->AdminLayout();
    }

    public function addEmailTemplate()
    {
        $inputs = $this->input->post();
        // print_r($inputs);exit;
            $data = array(
            'temp_name' => $inputs['name'],
            'subject' => $inputs['subject'],
            'template' => $inputs['description'],
            );
        
        $this->Customers_model->add_info('email_templates',$data);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Email Template Added. Name: '.$inputs['name'],
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
            $this->session->set_flashdata('msg',showAlert('success','saved Successfully'));
            redirect('administrator/view_template');
        
    }
    public function editTemplate($id)
    {
         $datas['template']=$this->HomeModel->getTemplateData('email_templates','row',array('id'=>$id));
         // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/emails/edit_template',$datas, true);
        $this->AdminLayout();
    }
    public function updateEmailTemplate($id)
    {
        $inputs = $this->input->post();
        // print_r($inputs['description']);exit;
            $data = array(
            'temp_name' => $inputs['name'],
            'subject' => $inputs['subject'],
            'template' => $inputs['description'],
            );
        
        $this->Customers_model->updateInfo('email_templates',$data,array('id'=>$id));
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Email Template Updated. Name: '.$inputs['name'],
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
            $this->session->set_flashdata('msg',showAlert('success','updated Successfully'));
            redirect('administrator/view_template');
        
    }

    public function deleteTemplate($id)
    {
        $template=$this->HomeModel->getTemplateData('email_templates','row',array('id'=>$id));
        // print_r($template);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Email Template Deleted. Name: '.$template->temp_name,
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
        $data = array(
            'delete_status' => 1,
            );
        $this->Customers_model->updateInfo('email_templates',$data,array('id'=>$id));
        
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/view_template');
    }

     public function adminActivity()
    {
         $datas['']='';
         // print_r($datas);exit;
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/activity/admin_activity',$datas, true);
        $this->AdminLayout();
    }

     public function matchedMembers()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/matched_members',$datas, true);
        $this->AdminLayout(); 
    }
     public function matchedMembersMale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/matched_members_male',$datas, true);
        $this->AdminLayout(); 
    }
     public function matchedMembersFemale()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/matched_members_female',$datas, true);
        $this->AdminLayout(); 
    }
    
    public function matchMember($id)
    {
        // print_r($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id']);exit;
        $single=$this->Customers_model->get_single_member($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Remove Matched Member Id: '.$single->member_profile_id.' name: '.$single->first_name,
        );
       
        $this->Customers_model->add_info('admin_activity',$activity_data);
        $date = getTimeStamp();
        // $this->Customers_model->update_single_member('member',$id,array('is_married'=>1,'active_status'=>0,'is_closed'=>'yes','delete_status' => 1,'matched_date'=>$date));
        $this->Customers_model->update_single_member('member',$id,array('is_married'=>0,'active_status'=>1,'is_closed'=>'no','delete_status' => 0,'matched_date'=>''));
        $this->session->set_flashdata('msg',showAlert('success','Active Successfully'));
        redirect('administrator/matched_members');
    }

    public function deactivateMember($id)
    {
        // print_r($this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id']);exit;
        $single=$this->Customers_model->get_single_member($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Deactivated Matched Member Id: '.$single->member_profile_id.' name: '.$single->first_name,
        );
       
        $this->Customers_model->add_info('admin_activity',$activity_data);
        $date = getTimeStamp();
        // $this->Customers_model->update_single_member('member',$id,array('is_married'=>1,'active_status'=>0,'is_closed'=>'yes','delete_status' => 1,'matched_date'=>$date));
        $this->Customers_model->update_single_member('member',$id,array('is_married'=>1,'active_status'=>0,'is_closed'=>'yes','delete_status' => 1,'matched_date'=>$date));
        $SMSTEXT = "Dear '".$single->first_name."', your account has been deactivated. To activate kindly reach out to Sri Sowdeswari Amman Narpani Mandram.";
            

         $mobile = "91".$single->mobile;
         $this->Customers_model->sendSms($mobile,$SMSTEXT);
        $this->session->set_flashdata('msg',showAlert('success','Deactivated Successfully'));
        redirect('administrator/matched_members');
    }

    public function viewTemplate()
    {
       $datas['']="";
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/emails/view_template',$datas, true);
        $this->AdminLayout(); 
    }

    // public function deleteFaq($id)
    // {
       
    //     // print_r($template);exit;
    //     $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
    //     $data = array(

    //         'admin_id'=>$admin_id,
    //         'activity'=> 'Faq Deleted',
    //     );
    //     $this->Customers_model->add_info('admin_activity',$data);
    //     $data = array(
    //         'delete_status' => 1,
    //         );
    //     $this->Customers_model->updateInfo('faq_ques',$data,array('id'=>$id));
        
    //     $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
    //     redirect('administrator/view_faq');
    // }


    public function deactivatedMembers()
    {
         $datas[''] = '';
        $this->template['middle'] = $this->load->view ($this->middle = 'Administrator/members/deactivated_members',$datas, true);
        $this->AdminLayout();
    }

    public function activateMember($id)
    {
        // print_r($id);exit;
        $single=$this->Customers_model->get_single_member($id);
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'activate Member Id: '.$single->member_profile_id.' name: '.$single->first_name,
        );
       
        $this->Customers_model->add_info('admin_activity',$activity_data);
        $this->Customers_model->update_single_member('member',$id,array('active_status'=>1,'is_closed'=>'no','delete_status'=>0,'deactivate_status'=>0));
        
        $this->session->set_flashdata('msg',showAlert('success','Activate Successfully'));
        redirect('administrator/deactivated_members');
    }

    public function deleteFaq($id)
    {
        $this->HomeModel->getTemplateData('faq_ques','row',array('id'=>$id));
        // print_r($template);exit;
        $admin_id = $this->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $activity_data = array(

            'admin_id'=>$admin_id,
            'activity'=> 'Faq Deleted',
        );
        $this->Customers_model->add_info('admin_activity',$activity_data);
        $data = array(
            'delete_status' => 1,
            );
        $this->Customers_model->updateInfo('faq_ques',$data,array('id'=>$id));
        
        $this->session->set_flashdata('msg',showAlert('success','Deleted Successfully'));
        redirect('administrator/view_faq');
    }
}


