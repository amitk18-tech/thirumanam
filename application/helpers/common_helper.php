<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function user_ip()
{
$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');
return $ip;
}// user_ip function closed

function user_device()
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];
    $devicesTypes = array(
        "computer" => array("msie 10", "msie 9", "msie 8", "windows.*firefox", "windows.*chrome", "x11.*chrome", "x11.*firefox", "macintosh.*chrome", "macintosh.*firefox", "opera"),
        "tablet"   => array("tablet", "android", "ipad", "tablet.*firefox"),
        "mobile"   => array("mobile ", "android.*mobile", "iphone", "ipod", "opera mobi", "opera mini"),
        "bot"      => array("googlebot", "mediapartners-google", "adsbot-google", "duckduckbot", "msnbot", "bingbot", "ask", "facebook", "yahoo", "addthis")
    );
    foreach($devicesTypes as $deviceType => $devices) {
        foreach($devices as $device) {
            if(preg_match("/" . $device . "/i", $userAgent)) {
                $deviceName = $deviceType;
            }
        }
    }
   return ucfirst($deviceName);
}// user_device function closed
function get_dropdown($type){
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('dropdown_site_language');
    $ci->db->where('type',$type);
    $query=$ci->db->get()->result();
    // echo $ci->db->last_query();
    return $query;
}
function get_state_citys($state_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('citys');
    $ci->db->where('state_id',$state_id);
    $ci->db->where('status',1);
    $ci->db->where('delete_status',0);    
    $query=$ci->db->get()->result();    
    return $query;   
}// get_state_citys function closed


function getLoggedAdmin()
{
    $ci = & get_instance();
    $ci->load->database();
    $id=$ci->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
    $type=$ci->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'];

    $ci->db->select('*');
    if($type==0){
    $ci->db->from('admin');
    }
    else{
    $ci->db->from('admin');   
    }
    $ci->db->where('admin_id',$id);
        
    $user = $ci->db->get()->row();
    return $user;
}
function getLoggerID(){
   $ci = & get_instance();
   return $ci->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
}
function getLoggerType(){
   $ci = & get_instance();
   return (isset($ci->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'])) ? $ci->session->userdata('THIRUMANAM_ADMIN_SESSION')['role'] : 0;
}

// function getStatusLabel($status)
// {
//     switch ($status) {
//         case 1:return '<span class="badge badge-soft-success badge-border">Active</span>';break;
//         case 0:return '<span class="badge badge-soft-danger badge-border">In Active</span>';break;
//         default:return '<span class="badge badge-soft-danger badge-border">In Active</span>';break;
//     }  
// }

function getStatusLabel($status)
{
    if($status == "yes"){
        return 1;
    }else{
        return 0;
    } 
    
}

function getBlockLabel($status)
{
    if($status=='yes'){
        return '<span class="badge badge-soft-danger badge-border">blocked</span>';
    }
    else
    {
        return '<span class="badge badge-soft-success badge-border">'.translate('no').'</span>';
    }
}
function getPaidLabel($status)
{
    if($status=='paid'){
        return '<span class="badge badge-soft-success badge-border">paid</span>';
    }
    else
    {
        return '<span class="badge badge-soft-warning badge-border">due</span>';
    }
}
function getReportedLabel($prefixId,$member_profile_id,$name)
{
    
        return '<a title="VIEW" href="'.base_url('administrator/all_members/view_member/'.$prefixId.'/'.$member_profile_id).'"><span class="badge badge-soft-primary badge-border">"'.$name.' - '.$member_profile_id.'"</span></a>';
    
}
function getCloseLabel($status)
{
    if($status=='yes'){
        return '<span class="badge badge-soft-danger badge-border">closed</span>';
    }
    else
    {
        return '<span class="badge badge-soft-success badge-border">'.translate('no').'</span>';
    }
}

function getReportLabel($status)
{
    switch ($status) {
        case 1:return '<i class="mdi mdi-account-check  bg-success text-white" style="font-size:25px"></i>';break;
        case 0:return '<i class="mdi mdi-account-remove bg-danger text-white" style="font-size:25px"></i>';break;
        default:return '<i class="mdi mdi-account-remove bg-danger text-white" style="font-size:25px"></i>';break;
    }  
}

function getRoleLabel($status)
{
    switch ($status) {
        case 3:return '<span class="badge badge-soft-success badge-border">Branch Admin</span>';break;
        case 4:return '<span class="badge badge-soft-success badge-border">Staff</span>';break;
        default:return '<span class="badge badge-soft-success badge-border">Staff</span>';break;
    }  
}

function getVerifiedStatusLabel($status)
{
    switch ($status) {
        case 1:return '<span class="badge badge-soft-warning badge-border">Partial Verified</span>';break;
        case 2:return '<span class="badge badge-soft-success badge-border">Verified</span>';break;
        default:return '<span class="badge badge-soft-danger badge-border">NotVerified</span>';break;
    }  
}
function getUserType($status)
{
    switch ($status) {
        case 1:return '<span class="badge badge-soft-success badge-border">online</span>';break;
        case 0:return '<span class="badge badge-soft-danger badge-border">simple</span>';break;
        default:return '<span class="badge badge-soft-danger badge-border">simple</span>';break;
    }  
}

function getSettings()
{
    $ci = & get_instance();
    $ci->load->database();

    $ci->db->select('*');
    $ci->db->from('main_settings');    
    $settings = $ci->db->get()->row();
    if(empty($settings)){
        $settings=(object)[];
        $settings->header='iCLIENT';
    }
    return $settings;
}

function isValidRequest($needed_type, $method_type)
{
    return ($needed_type == $method_type) ? true : false;
}
function getAlert($purpose, $message)
{
   
    return '<div id="flash" style="
    position: fixed;
    right: 5%;
    top: 23px;
    z-index: 9999999;
    width: 30%;
    height: 60px;
    padding: 14px 14px 14px 26px;
    background-color: #f24570;
    color: rgb(253 255 254);"  class="alert alert-'.$purpose.' alert-dismissible show" role="alert">
    <center><strong>' . $message . '</strong>
    </center>
    
  </div>';
}

function getappAlert($purpose, $message)
{
   
    return '<div id="app_flash" 
      style="position: fixed;
      z-index: 9999999;
      width: 100%;"
      role="alert" class="alert alert-'.$purpose.'">
      '.$message.'
    </div>';
}



function appAlert($purpose, $message)
{
   
    return '<div id="app_flash" style="position: fixed;
    top: 82px;
    z-index: 9999999;
    width: 100%;"  class="alert alert-'.$purpose.'" role="alert">
    <center><strong>' . $message . '</strong>
    </center>
    
  </div>';
}
function showAlert($purpose, $message)
{
    $icon=($purpose=='danger') ? 'ri-error-warning-line' : 'ri-check-double-line';
    return '<div id="admin_alert" class="alert alert-'.$purpose.' alert-dismissible alert-label-icon label-arrow shadow fade show mb-xl-0" role="alert">
                <i class="'.$icon.' label-icon"></i><strong>'.$message.'</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
}

function stateTranslate($word){
            $CI=& get_instance();
            $CI->load->database();
            if($set_lang = $CI->session->userdata('language')){} else {
                $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
            }
            // $set_lang = 'tamil';
            $return = '';
            $result = $CI->db->get_where('all_states',array('word'=>$word));
            if($result->num_rows() > 0){
                if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
                    $return = $result->row()->$set_lang;
                    $lang = $set_lang;
                } else {
                    $return = $result->row()->english;
                    $lang = 'english';
                }
                $id = $result->row()->state_id;
            } else {
                
         
            
            //return '-------';
            // return ucwords(str_replace('_', ' ', $word));
        }
        return $return;
    }

    function cityTranslate($word){
            $CI=& get_instance();
            $CI->load->database();
            if($set_lang = $CI->session->userdata('language')){} else {
                $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
            }
            
            $return = '';
            $result = $CI->db->get_where('all_cities',array('word'=>$word));
            if($result->num_rows() > 0){
                if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
                    $return = $result->row()->$set_lang;
                    $lang = $set_lang;
                } else {
                    $return = $result->row()->english;
                    $lang = 'english';
                }
                $id = $result->row()->state_id;
            } else {
                
         
            
            //return '-------';
            // return ucwords(str_replace('_', ' ', $word));
        }
        return $return;
    }

    function dropdownTranslate($word){
            $CI=& get_instance();
            $CI->load->database();
            if($set_lang = $CI->session->userdata('language')){} else {
                $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
            }
            $return = '';
            $result = $CI->db->get_where('dropdown_site_language',array('word'=>$word));
            if($result->num_rows() > 0){
                if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
                    $return = $result->row()->$set_lang;
                    $lang = $set_lang;
                } else {
                    $return = $result->row()->english;
                    $lang = 'english';
                }
                $id = $result->row()->word_id;
            } else {
                
         
            
            //return '-------';
            // return ucwords(str_replace('_', ' ', $word));
        }
        return $return;
    }
    function translate($word){
            $CI=& get_instance();
            $CI->load->database();
            if($set_lang = $CI->session->userdata('language')){} else {
                $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
            }
            // $set_lang ='tamil';
            $return = '';
            $result = $CI->db->get_where('site_language',array('word'=>$word));

            if($result->num_rows() > 0){

                if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
                    $return = $result->row()->$set_lang;
                    $lang = $set_lang;
                } else {
                    $return = $result->row()->english;
                    $lang = 'english';
                }
                $id = $result->row()->word_id;
            } else {
            $return = "";
                    $lang = 'english';
            }
            // print_r($return);exit;
            return $return;
            //return '-------';
            // return ucwords(str_replace('_', ' ', $word));
        }
        function translate_result($word){
            $CI=& get_instance();
            $CI->load->database();
            if($set_lang = $CI->session->userdata('language')){} else {
                $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
            }
            $return = '';
            $result = $CI->db->get_where('site_language',array('word'=>$word));
            if($result->num_rows() > 0){

                if($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== ''){
                    $return = $result->result();
                    $lang = $set_lang;
                } else {
                    $return = $result->result();
                    $lang = 'english';
                }
                $id = $result->row()->word_id;
            } else {
            $return = $result->row()->english;
                    $lang = 'english';
            } 
        
            // print_r($return);exit;
            return $return;
            //return '-------';
            // return ucwords(str_replace('_', ' ', $word));
        }

    function get_allmembers($id){
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('member');
    $ci->db->where('member_id',$id);
    // $ci->db->where('active_status',1);
    $ci->db->where('delete_status',0);
    $query=$ci->db->get()->row();
    // echo $ci->db->last_query();
    return $query;
}
   
    function getDataa($table,$where = '')
    {
        $ci =& get_instance();
        $ci->load->database();
        if($where != '')
        {
            $ci->db->where($where);
        }
        $data = $ci->db->get($table);
        return $data->result_array();
    }
    function getData($table,$row,$where){
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from($table);
    $ci->db->where($where);
    // $ci->db->where('active_status',1);
    $ci->db->where('delete_status',0);
    $query=$ci->db->get()->$row();
    // echo $ci->db->last_query();
    return $query;
    }
    function dropdownDatas($table,$row,$where=""){
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from($table);
    if(!empty($where)){
        $ci->db->where($where);
    }
    $query=$ci->db->get()->$row();
    // echo $ci->db->last_query();
    return $query;
    }
    function getEarnings($date,$member_type){
        $CI=& get_instance();
        $CI->load->database();

        $CI->db->select('*');
        $CI->db->from('package_payment');
        // $CI->db->join('member','member.member_id=package_payment.member_id','left');
        // $CI->db->join('deactivated_member','deactivated_member.member_id=package_payment.member_id','left');
        // $CI->db->join('deleted_member','deleted_member.member_id=package_payment.member_id','left');
        if ($date!='All') {
            $CI->db->where('package_payment.payment_timestamp >=',strtotime($date));    
        }       
        $jan='2022-01-01 00:00:00';
        $CI->db->where('package_payment.payment_timestamp >=',strtotime($jan));
        $CI->db->where('package_payment.payment_status !=','due');
        // if ($member_type!=0) {
        //  $CI->db->group_start();
        //  $CI->db->or_where('member.member_type',$member_type);
        //  $CI->db->or_where('deactivated_member.member_type',$member_type);
        //  $CI->db->or_where('deleted_member.member_type',$member_type);           
        //  $CI->db->group_end();

        //  $CI->db->group_start();
        //  $CI->db->or_where('member.membership !=',1);
        //  $CI->db->or_where('deactivated_member.membership !=',1);
        //  $CI->db->or_where('deleted_member.membership !=',1);
        //  $CI->db->group_end();
        // }
        if ($member_type!=0) {
            $CI->db->where('package_payment.member_type',$member_type);         
        }
        $CI->db->group_by('package_payment.package_payment_id');
        $result=$CI->db->get()->result();
        // print_r($result);

        // $amount=0;
        // if (!empty($result)) {
        //  foreach ($result as $value) {
        //      $member=checkMemberType('member',$value->member_id,$member_type);
        //      $deactivated_member=checkMemberType('deactivated_member',$value->member_id,$member_type);
        //      $deleted_member=checkMemberType('deleted_member',$value->member_id,$member_type);
        //      if (!empty($member) || !empty($deactivated_member) || !empty($deleted_member)) {
        //          $amount+=$value->amount;
        //      }
        //  }
        // }
        // return $amount;
        // exit;
        // echo $CI->db->last_query();
        // // print_r($result);
        // echo count($result);
        // echo "===";
        return (!empty($result)) ? array_sum(array_column($result, 'amount')) : 0 ;
    }

     function get_type_name_by_id($type, $type_id = '', $field = 'name')
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($type_id != '') {
            $l = $ci->db->get_where($type, array(
                $type . '_id' => $type_id
            ));
            $n = $l->num_rows();
            if ($n > 0) {
                return $l->row()->$field;
            }
        }
    }
    if ( ! function_exists('status'))
    {
        function status($approval, $array){
            if ($approval == 'yes') {
                //array_push($array, 'status'=>'approved');
                $array['status'] = 'approved';
            }
            return $array;
        }
    }

    function get_settings_value($type, $type_name = '', $field = 'value')
    {
        $ci =& get_instance();
        $ci->load->database();
        if ($type_name != '') {
            return $ci->db->get_where($type, array('type' => $type_name))->row()->$field;
        }
    }

    function select_html($from, $name, $field, $type, $class, $e_match = '', $condition = '', $c_match = '', $onchange = '',$condition_type='single')
    {
        $ci =& get_instance();
        $ci->load->database();
        $return = '';
        $other  = '';
        $multi  = 'no';
        $phrase = 'Choose a ' . $name;
        if ($class == 'demo-cs-multiselect') {
            $other = 'multiple';
            $name  = $name . '[]';
            if ($type == 'edit') {
                $e_match = json_decode($e_match);
                if ($e_match == NULL) {
                    $e_match = array();
                }
                $multi = 'yes';
            }
        }
        $return = '<select name="' . $name . '" onChange="' . $onchange . 'martialfun(this.value,this)" class="' . $class . '" ' . $other . '  data-placeholder="' . $phrase . '" tabindex="2" data-hide-disabled="true" >';
        if (!is_array($from)) {
            if ($condition == '') {
                $all = $ci->db->get($from)->result_array();
            } else if ($condition !== '') {
                if($condition_type=='single'){
                    $all = $ci->db->get_where($from, array(
                        $condition => $c_match
                    ))->result_array();
                }else if($condition_type=='multi'){
                    $ci->db->where_in($condition,$c_match);
                    $all = $ci->db->get($from)->result_array();
                }
            }

            $return .= "<option value=''>".translate('choose_one')."</option>";

            foreach ($all as $row):
                if ($type == 'add') {
                    $return .= '<option value="' . $row[$from . '_id'] . '">' . $row[$field] . '</option>';
                } else if ($type == 'edit') {
                    $return .= '<option value="' . $row[$from . '_id'] . '" ';
                    if ($multi == 'no') {
                        if ($row[$from . '_id'] == $e_match) {
                            $return .= 'selected=."selected"';
                        }
                    } else if ($multi == 'yes') {
                        if (in_array($row[$from . '_id'], $e_match)) {
                            $return .= 'selected=."selected"';
                        }
                    }
                    $return .= '>' . $row[$field] . '</option>';
                }
            endforeach;
        } else {
            $all = $from;
            $return .= '<option value="">'.translate('choose_one').'</option>';
            foreach ($all as $row):
                if ($type == 'add') {
                    $return .= '<option value="' . $row . '">';
                    if ($condition == '') {
                        $return .= ucfirst(str_replace('_', ' ', $row));
                    } else {
                        $return .= get_type_name_by_id($condition, $row, $c_match);
                    }
                    $return .= '</option>';
                } else if ($type == 'edit') {
                    $return .= '<option value="' . $row . '" ';
                    if ($row == $e_match) {
                        $return .= 'selected=."selected"';
                    }
                    $return .= '>';

                    if ($condition == '') {
                        $return .= ucfirst(str_replace('_', ' ', $row));
                    } else {
                        $return .= get_type_name_by_id($condition, $row, $c_match);
                    }

                    $return .= '</option>';
                }
            endforeach;
        }
        $return .= '</select>';
        return $return;
    }

    if ( ! function_exists('recache'))
    {
        function recache(){
            $ci =& get_instance();
            $ci->load->database();
            $files = glob(APPPATH.'cache/*'); // get all file names
            foreach($files as $file){ // iterate files
              if(is_file($file) && $file !== '.htaccess' && $file !== 'index.html' ){
                unlink($file); // delete file
              }
            }
            //file_get_contents(base_url().'index.php/home/index');
        }
    }

    function getMemberCurrentPayment($id)
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('package_payment');
        $ci->db->where('member_id',$id);
        $ci->db->where('payment_status','paid');
        $ci->db->where('active_status',1);
        $ci->db->where('delete_status',0);
        $ci->db->where('payment_timestamp >=',strtotime(date('Y-m-d H:i:s',strtotime('-6 months'))));
        $ci->db->order_by('package_payment_id','DESC');
        $ci->db->limit(1);
        $row=$ci->db->get()->row();        
        return $row;

    }
    function getMemberCurrentPayments()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('package_payment');
        $ci->db->where('member_id',$ci->session->userdata['thirumanam_logged_data']['member_id']);
        $ci->db->where('payment_status','paid');
        $ci->db->where('payment_timestamp >=',strtotime(date('Y-m-d H:i:s',strtotime('-6 months'))));
        $ci->db->order_by('package_payment_id','DESC');
        $ci->db->limit(1);
        $row=$ci->db->get()->row();        
        return $row;

    }

    function getMemberPayments($id)
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('package_payment');
        $ci->db->where('package_payment_id',$id);
        // $ci->db->where('payment_timestamp >=',strtotime(date('Y-m-d H:i:s',strtotime('-6 months'))));
        $ci->db->limit(1);
        $row=$ci->db->get()->row();        
        return $row;

    }
    function getLanguage()
    {
        $CI=& get_instance();
        $CI->load->database();
        if($set_lang = $CI->session->userdata('language')){

        } else {
            $set_lang = $CI->db->get_where('general_settings',array('type'=>'language'))->row()->value;
        }
        return $set_lang;
    }

    if ( ! function_exists('demo'))
    {
        function demo(){
            $CI=& get_instance();
            return $CI->config->item('demo');
        }
    }

    function in_assoc_array($value,$index,$array)
    {
        foreach ($array as $row) {
            if($row[$index] == $value){
                return true;
            }
        }
        return false;
    }

    function get_listed_messaging_members($member_id)
    {
        $ci =& get_instance();
        $ci->load->database();
        $message_array1 = array();
        $message_array2 = array();
        $message_list1 = $ci->db->select('message_thread_to AS list')->select('message_thread_id')->select('message_thread_time')->select('message_thread_from')->select('message_to_seen')->select('message_from_seen')->get_where('message_thread', array('message_thread_from' => $member_id))->result();
        $message_list2 = $ci->db->select('message_thread_from AS list')->select('message_thread_id')->select('message_thread_time')->select('message_thread_to')->select('message_to_seen')->select('message_from_seen')->get_where('message_thread', array('message_thread_to' => $member_id))->result();
        foreach ($message_list1 as $list1) {
            // $message_array1[] = $list1->list;
            $message_array1[] = array('message_thread_id' => $list1->message_thread_id, 'member_id' => $list1->list, 'message_thread_time' => $list1->message_thread_time,'from_id' =>$list1->message_thread_from,'message_to_seen' =>$list1->message_to_seen,'message_from_seen' =>$list1->message_from_seen);
        }
        foreach ($message_list2 as $list2) {
            // $message_array2[] = $list2->list;
            $message_array2[] = array('message_thread_id' => $list2->message_thread_id, 'member_id' => $list2->list, 'message_thread_time' => $list2->message_thread_time,'to_id' =>$list2->message_thread_to,'message_to_seen' =>$list2->message_to_seen,'message_from_seen' =>$list2->message_from_seen);
        }
        return $listed_messaging_members = array_unique (array_merge ($message_array1, $message_array2), SORT_REGULAR);
    }

    // function get_listed_messaging_members($member_id)
    // {
    //     $ci =& get_instance();
    //     $ci->load->database();
    //     $message_array1 = array();
    //     $message_array2 = array();
    //     $message_list1 = $ci->db->select('message_thread_to AS list')->select('message_thread_id')->select('message_thread_time')->select('message_thread_from')->select('message_to_seen')->select('message_from_seen')->get_where('message_thread', array('message_thread_from' => $member_id))->result();
    //     $message_list2 = $ci->db->select('message_thread_from AS list')->select('message_thread_id')->select('message_thread_time')->select('message_thread_to')->select('message_to_seen')->select('message_from_seen')->get_where('message_thread', array('message_thread_to' => $member_id))->result();
    //     foreach ($message_list1 as $list1) {
    //         // $message_array1[] = $list1->list;
    //         $message_array1[] = array('message_thread_id' => $list1->message_thread_id, 'member_id' => $list1->list, 'message_thread_time' => $list1->message_thread_time,'recieverd_id' =>$list1->message_thread_from,'message_to_seen' =>$list1->message_to_seen,'message_from_seen' =>$list1->message_from_seen);
    //     }
    //     foreach ($message_list2 as $list2) {
    //         // $message_array2[] = $list2->list;
    //         $message_array2[] = array('message_thread_id' => $list2->message_thread_id, 'member_id' => $list2->list, 'message_thread_time' => $list2->message_thread_time,'recieverd_id' =>$list2->message_thread_to,'message_to_seen' =>$list2->message_to_seen,'message_from_seen' =>$list2->message_from_seen);
    //     }
    //     return $listed_messaging_members = array_unique (array_merge ($message_array1, $message_array2), SORT_REGULAR);
    // }

    function count_listed_messaging_members($member_id)
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('message_thread');
        $ci->db->where('message_thread_to',$member_id);
        $ci->db->group_start();
        $ci->db->where("message_to_seen",NULL);
        $ci->db->or_where("message_to_seen"," ");
        $ci->db->group_end();
        $query=$ci->db->get()->result();
        return $query;
    }

    function message_thread_member_position($thread_id,$member){
        $ci =& get_instance();
        $ci->load->database();
        $from = $ci->db->get_where('message_thread',array('message_thread_id'=>$thread_id,'message_thread_from'=>$member))->num_rows();
        $to = $ci->db->get_where('message_thread',array('message_thread_id'=>$thread_id,'message_thread_to'=>$member))->num_rows();
        if($from > 0){
            return 'from';
        } else if($to > 0){
            return 'to';
        }
    }

    if ( ! function_exists('currency'))
    {
        function currency($val='',$def=''){
            $CI=& get_instance();
            //$CI->security->cron_line_security();
            $CI->load->database();

            $currency_format = $CI->db->get_where('business_settings', array('type' => 'currency_format'))->row()->value;
            $symbol_format = $CI->db->get_where('business_settings', array('type' => 'symbol_format'))->row()->value;
            $no_of_decimal = $CI->db->get_where('business_settings', array('type' => 'no_of_decimals'))->row()->value;
            if($currency_format == 'us'){
                $dec_point = '.';
                $thousand_sep = ',';
            }elseif($currency_format == 'german'){
                $dec_point = ',';
                $thousand_sep = '.';
            }elseif($currency_format == 'french'){
                $dec_point = ',';
                $thousand_sep = ' ';
            }

            if($currency_id = $CI->session->userdata('currency')){} else {
                $currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
            }
            if($def == 'def'){
                $currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
            }
            $exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate_def;
            $symbol = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->symbol;

            if($val == ''){
                return $symbol;
            } else {
                $val = $val*$exchange_rate;
                if($def == 'only_val'){
                    return number_format($val,$no_of_decimal);
                } else {
                    if($symbol_format == 's_amount'){
                        return $symbol.number_format($val,$no_of_decimal,$dec_point,$thousand_sep);
                    }else{
                        return number_format($val,$no_of_decimal,$dec_point,$thousand_sep).$symbol;
                    }
                }
            }

        }
    }

   if ( ! function_exists('exchange'))
    {
        function exchange($def=''){
            $CI=& get_instance();
            //$CI->security->cron_line_security();
            $CI->load->database();
            if($currency_id = $CI->session->userdata('currency')){} else {
                $currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
            }
            if($def == 'usd'){
                $currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
                $exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate;
            } else if($def == 'def'){
                $currency_id = $CI->db->get_where('business_settings', array('type' => 'currency'))->row()->value;
                $exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate_def;
            } else {
                $exchange_rate = $CI->db->get_where('currency_settings', array('currency_settings_id' => $currency_id))->row()->exchange_rate_def;
            }

            return $exchange_rate;
        }
    }

    function getPartnerExpectaions($member,$value,$type)
{
   $preference=$member->partner_expectation;
   $gender=$member->gender;
   $expectation=json_decode($preference); 
   // print_r($expectation);
   if (isset($expectation[0]->$value)) {         
      $date1 = $member->date_of_birth; 
      $date2 = strtotime(date("d-m-Y"));
      $diff = abs($date2 - $date1); 
      $age = floor($diff / (365*60*60*24));
      if ($type==1) {                  
         // FROM AGE      
         // return $expectation[0]->$value;
         // echo $age;
         return ($gender==1) ? ((isset($expectation[0]->$value) && $expectation[0]->$value!='') ? $expectation[0]->$value : 18) : ((isset($age) && $age!='' && $age<80) ? $age : 18);
      }
      else if ($type==2) {
         // TO AGE         
         return ($gender==1) ? ((isset($age)) ? $age : 60) : ((isset($expectation[0]->$value)) ? $expectation[0]->$value : 60) ;
      }
      else if ($type==3) {
         // FROM HEIGHT
         return (isset($expectation[0]->$value) && $expectation[0]->$value!='') ? $expectation[0]->$value-15 : 100;
      }
      else if ($type==4) {
         // TO HEIGHT
         return (isset($expectation[0]->$value) && $expectation[0]->$value!='') ? $expectation[0]->$value+15 : 200 ;
      }
      else
      {
         return (isset($expectation[0]->$value)) ? $expectation[0]->$value : '' ;
      }
   }
   else{
      $date1 = $member->date_of_birth; 
      $date2 = strtotime(date("d-m-Y"));      
      $diff = abs($date2 - $date1); 
      $age = floor($diff / (365*60*60*24));
      if ($type==1) {    
         return ($gender==1) ? 18 : ((isset($age) && $age<60) ? $age : 18);
      }
      else if ($type==2) {
         // TO AGE
         return ($gender==1) ? $age : 60 ;
      }
      else if ($type==3) {
         // FROM HEIGHT
         return 100;
      }
      else if ($type==4) {
         // TO HEIGHT
         return 180;
      }
      else
      {
         return '' ;
      }
   }  
   
}

function checkAlreadyViewed($logger_id,$user_id)
    {
        $ci=& get_instance();
        $ci->load->database();
      $array_data = array('user_id' => $logger_id,'member_user_id' => $user_id);
      
       return $ci->db->get_where("view_profile_management", $array_data)->row();
    //  
        
//         $result=$this->db->get_where("view_profile_management", $array_data)->row();
//      return $result;
    }

   function generate_key($table_name, $column_name, $prefix)
    {
        $ci=& get_instance();
        $ci->load->database();
        $key = $ci->__generate_key($prefix);

        while ($ci->__key_exist($key, $table_name, $column_name)) {
            $key = $ci->__generate_key($prefix);
        }
        return $key;

    }

   function check_user_password($password)
  {
    $ci=& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('member');
    $ci->db->where('password',$password);
    $ci->db->where('delete_status',0);
    $query=$ci->db->get()->row();
    return $query;
  }
  function check_user_Mobile($mobile,$gender)
  {
    $ci=& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('member');
    $ci->db->where('mobile',$mobile);
    $ci->db->where('gender',$gender);
    $ci->db->where('delete_status',0);
    $query=$ci->db->get()->row();
    return $query;
  }  
  function sort_array_of_array(&$array, $subfield, $sort)
    {   
        $ci=& get_instance();
        $ci->load->database();
        $sortarray = array();
        foreach ($array as $key => $row)
        {
            $sortarray[$key] = $row[$subfield];
        }

        array_multisort($sortarray, $sort, $array);
    }

    function is_message_thread_seen($thread_id,$member){
        $ci=& get_instance();
        $ci->load->database();
        $position = message_thread_member_position($thread_id,$member);
        $position_db_field = 'message_'.$position.'_seen';
        $seen = $ci->db->get_where('message_thread', array('message_thread_id' => $thread_id))->row()->$position_db_field;
        if($seen == 'yes'){
            return true;
        }
        return false;
    }

     function admin_permission($codename)
    {
        $ci=& get_instance();
        $ci->load->database();
        $admin_id   = $ci->session->userdata('THIRUMANAM_ADMIN_SESSION')['admin_id'];
        $admin        = $ci->db->get_where('admin', array(
            'admin_id' => $admin_id
        ))->row();
        $permission = $ci->db->get_where('permission', array('codename' => $codename))->row()->permission_id;
        if ($admin->role == 1) {
            return true;
        } else {
            $role             = $admin->role;
            $role_permissions = json_decode(get_type_name_by_id('role', $role, 'permission'));
            if (in_array($permission, $role_permissions)) {
                return true;
            } else {
                return false;
            }
        }/**/
    }

    function get_IP_address()
    {
        foreach (array('HTTP_CLIENT_IP',
                       'HTTP_X_FORWARDED_FOR',
                       'HTTP_X_FORWARDED',
                       'HTTP_X_CLUSTER_CLIENT_IP',
                       'HTTP_FORWARDED_FOR',
                       'HTTP_FORWARDED',
                       'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                    $IPaddress = trim($IPaddress); // Just to be safe

                    if (filter_var($IPaddress,
                                   FILTER_VALIDATE_IP,
                                   FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                        !== false) {

                        return $IPaddress;
                    }
                }
            }
        }
    }

    function getTimeStamp(){
    return date('Y-m-d h:i:s');
}
function get_SERVER()
    {
        return $_SERVER;

    }



//appp ////////////////////////////////

function isValidUserSession()
    {
        $ci = & get_instance();
        if(!$ci->session->userdata('thirumanam_logged_data')){
            return false;
        }else{
            return true;
        }
    }


function getLoggedUser()
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('member');
        $ci->db->where('member_id',getAppLoggerID());        
        $ci->db->where('delete_status',0);
        $query=$ci->db->get()->row();
        return $query;
    }
function getAppLoggerID(){
   $ci = & get_instance();
   return $ci->session->userdata('thirumanam_applogged_data')['member_id'];
}

function get_random_members()
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('member');
    $ci->db->limit(1);
    $ci->db->order_by('rand()');
    $ci->db->where('is_blocked','no');
    $ci->db->where('is_closed','no');
    $query=$ci->db->get()->row();      
    return $query;
}

function member_permission()
{
    $ci =& get_instance();
    $ci->load->database();   
    $member_id = $ci->session->userdata('thirumanam_logged_data')['member_id'];
    if ($member_id == NULL) {
        return FALSE;
    }
    else {
        return TRUE;
    }
        
}

function time_convert($timestamp, $timezone = 'UTC'){
    $ci =& get_instance();
    $ci->load->database();
    $datetime = new DateTime($timestamp, new DateTimeZone($timezone));
    return $datetime->format('Y-m');
}