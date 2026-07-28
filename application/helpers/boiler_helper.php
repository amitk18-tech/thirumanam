<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  function jsonEncodePrint($jsonEncodedArray){
    $ci =& get_instance();
    $jsonResultArray=[];
    if((isset($jsonEncodedArray['message']))&&(is_array($jsonEncodedArray['message']))&&(sizeof($jsonEncodedArray['message'])!=0)){
      $jsonResultArray['message']=implode(",",$jsonEncodedArray['message']);
      $jsonResultArray['API_STATUS']='FAILURE';
      unset($jsonEncodedArray['message']);
      $jsonResultArray['datas']=$jsonEncodedArray;
      $ci->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($jsonResultArray))->_display();
    }else{
      $jsonResultArray['message']="API Successfully Executed";
      $jsonResultArray['API_STATUS']='SUCCESS';
      unset($jsonEncodedArray['message']);
      $jsonResultArray['datas']=$jsonEncodedArray;
      $ci->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($jsonResultArray))->_display();
    }
    exit;
  }

  function checkTokenValidation() {
    $jsonResultArray['message'] =[];
    $ci =& get_instance();
    $headers = $ci->input->request_headers();
    if(isset($headers['token'])){
      $token = $headers['token'];
      $ci->db->select('*,users.user_id as user_identity,DATEDIFF(NOW(),users.dob)/365.25 AS age_dob');
      $ci->db->from('users');
      $ci->db->join('user_details','user_details.user_id = users.user_id','left');
      $ci->db->join('user_family_details','user_family_details.user_id = users.user_id','left');
      $ci->db->join('user_professional_details','user_professional_details.user_id = users.user_id','left');
      $ci->db->join('partner_preference_basic_detatils','partner_preference_basic_detatils.user_id = users.user_id','left');
      $ci->db->where('md5(users.user_id)',$token);
      $userDetails= $ci->db->get()->row_array();
      if(sizeof($userDetails)==0){
        $jsonResultArray['message']=[];
        array_push($jsonResultArray['message'],'Invalid Token');
        jsonEncodePrint($jsonResultArray);
      }else{
        return $userDetails;
      }
    }else{
      array_push($jsonResultArray['message'],'Need Token Authorization');
      jsonEncodePrint($jsonResultArray);
    }
  }

  function valid_email_with_domain($email){
    // First, we check that there's one @ symbol, and that the lengths are right
    $allowed = array('gmail.com', 'ymail.com', 'gmail.in', 'hotmail.com');
    // Make sure the address is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $explodedEmail = explode('@', $email);
        $domain = array_pop($explodedEmail);
        if ( ! in_array($domain, $allowed))
        {
            return false;
        }
    }
    return true;
  }

  function valid_email($email){
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
  }

  function valid_password($password){
    if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[!@#$%])[0-9A-Za-z!@#$%]{6,15}$/', $password)) {
      return false;
    }
    return true;
  }

  function valid_mobile($phoneNumber){
    if(preg_match('/^(\+91[\-\s]?)?[0]?(91)?[789]\d{9}$/', $phoneNumber)){
      return true;
    }
    else
      return false;
  }

  function valid_mobile_no($phoneNumber){
    if(preg_match('/^\d{10}$/',$phoneNumber) OR preg_match('/^\d{11}$/',$phoneNumber) OR preg_match('/^\d{12}$/',$phoneNumber)) // phone number is valid
    {
      return true;
    }
    return false;
  }

  function profileImageURL($image_name){
    if((strpos($image_name, "https://")!==false)||(strpos($image_name, "https://")!==false)){
      return $image_name;
    }else if($image_name=='0'){
      return base_url()."assets/images/no_image.jpg";
    }else{
      return base_url()."assets/images/users/".$image_name;
    }
  }

  function setPagination($pass){
    $pagination=[];
    if((isset($pass['limit']))&&($pass['limit']!=0)){
      $pagination['limit']=(int)$pass['limit'];
    }else{
      $pagination['limit']=2;
    }
    if((isset($pass['page_no']))&&($pass['page_no']!=0)){
      $pagination['page_no']=(int)$pass['page_no'];
    }else{
      $pagination['page_no']=1;
    }
    if($pagination['page_no']<=1){
      $pagination['start_limit']=0;
    }else{
      $pagination['start_limit']=($pagination['page_no']-1)*$pagination['limit'];
    }
    return $pagination;
  }

  function getPagination($paginationDetails,$status){
    $pagination['page_no']=$paginationDetails['page_no'];
    $pagination['limit']=$paginationDetails['limit'];
    if($paginationDetails['page_no'] <= 1){
      $pagination['prev_page']=null;
    }else{
      $pagination['prev_page']=$paginationDetails['page_no'] -1;
    }
    if($status){
      $pagination['next_page']=$paginationDetails['page_no'] + 1;
    }else{
      $pagination['next_page']=null;
    }
    return $pagination;
  }
?>
