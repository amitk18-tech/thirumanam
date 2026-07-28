<?php
class LoginModel extends CI_Model 
{
	public function __construct()
  {
     	parent::__construct();
  }

  
  public function isValidAdmin($data)
    {
        $this->db->select('*');
        $this->db->from('admin');
        // $this->db->group_start();
        $this->db->where('email',$data['username']);
        // $this->db->or_where('mobile_number',$data['username']);
        // $this->db->or_where('username',$data['username']);
        // $this->db->group_end();
        $this->db->where('password',sha1($data['password']));
        
        //$this->db->where('role',1);
        $user = $this->db->get()->row_array();
        return $user;
    }

  public function select_limit($limit, $start)  
  {  
     $this->db->select('*');
     $this->db->from('users'); 
     $this->db->limit($limit, $start);
     $query = $this->db->get()->result();  
     return $query;  
  }  

  public function check_user_datas($email,$password)
  {
     $this->db->select('*');
     $this->db->from('users');
     $this->db->where('email',$email);
     $this->db->where('password',$password);
     $this->db->where('user_role',2);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->row_array();
     return $query;
  }  



  public function get_adminuser_datas($user_id)
  {
     $this->db->select('*');
     $this->db->from('users');
     $this->db->where('user_id',$user_id);
     $this->db->where('user_role',1);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->row_array();
     return $query;
  }

  public function update_admin_profile_datas($user_id,$datas)
  {
     $this->db->where('user_id',$user_id);
     $this->db->where('user_role',1);
     $this->db->update('users',$datas);
  }

  public function save_user_datas($datas)
  {
   	$this->db->insert('users',$datas);
   	return $insert_id = $this->db->insert_id();
  }// save_user_datas function closed

  public function checkInfo()
  {
     	$username=$this->input->post('phone');
        $gender=$this->input->post('gender');
		$password=sha1($this->input->post('password'));
      
     	$condition = "(email ="."'".$username."' OR mobile="."'".$username."') AND "."password="."'".$password."'";

      $this->db->select('*');
      $this->db->from('member');
      $this->db->where($condition);
      // $this->db->where('active_status',1);
      $this->db->where('delete_status',0);
      $result=$this->db->get()->row();
      
      $status=(!empty($result)) ? 1 : 0;
      return $status;
  }

  public function checkInfo_2()
  {
      $username=$this->input->post('phone');
      $gender=$this->input->post('gender');
      $password=sha1($this->input->post('password'));
      // print_r($gender);exit;
     // $condition = "(mobile="."'".$username."') AND "."password="."'".$password."'";
      $this->db->select('*');
      $this->db->from('member');
      $this->db->where('mobile',$username);
      $this->db->where('password',$password);
      if(!empty($gender)){
        $this->db->where('gender',$gender);
      }
      // $this->db->where('active_status',1);      
      $this->db->where('delete_status',0);
    //   $this->db->where_in('verified_status',[1,2]);
      $query = $this->db->get()->result();
      // return $username;
      if(count($query) == 1)
      {
        return '1';
      }
      else 
      {
        return $query;
      }
  }// checkInfo_2 function closed

  public function checkInfo_otp($username,$password)
  {
      $condition = "(mobile_number="."'".$username."') AND "."password="."'".$password."'";
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where($condition);
      $this->db->where('status',1);
      $this->db->where('delete_status',0);
      $query = $this->db->get();
      if ($query->num_rows() == 1) 
      {
      return true;
      }
      else 
      {
      return false;
      }
  }// checkInfo_otp function closed

  public function check_admin_dologin($user_email,$user_pass)
  {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('email',$user_email);
      $this->db->where('password',$user_pass);
      $this->db->where_in('user_role',[1,3,4]);
      $this->db->where('status',1);
      $this->db->where('delete_status',0);      
      $query=$this->db->get();
    //   echo $this->db->last_query();
      if($query->num_rows()==1)
      {
        return true;
      }
      else
      {
        return false;
      }
  }// check_admin_dologin function closed

  public function get_admin_user_information($user_email,$user_pass)
  {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('email',$user_email);
      $this->db->where('password',$user_pass);
      $this->db->where_in('user_role',[1,3,4]);
      $query=$this->db->get()->row();
      return $query;
  }// get_admin_user_information function closed

  public function getUserInformationByAnyOne($username,$password,$gender="")
  {
     // $condition = "(email ="."'".$data."' OR mobile_number="."'".$data."')";

       $condition = "(mobile="."'".$username."') AND "."password="."'".$password."'";
      $this->db->select('*');
      $this->db->from('member');
      $this->db->where($condition);
      if(!empty($gender)){
        $this->db->where('gender',$gender);
      }
      // $this->db->where('active_status',1);
      $this->db->where('delete_status',0);
      $query = $this->db->get()->row();
      return $query;
  }// getUserInformationByAnyOne function closed

 


  

  

  public function get_login_user_datas($id)
  {
     $this->db->select('*');
     $this->db->from('member');
     $this->db->where('member_id',$id);
     $this->db->where('delete_status',0);
     $query=$this->db->get()->row_array();
     return $query;
  }// get_login_user_datas function closed

  public function update_user_datas($user_id,$user_table_datas)
  {
     $this->db->where('user_id',$user_id);
     $this->db->update('users',$user_table_datas);
  }// update_user_datas function closed

  

  function account_opening_member_approval_on($account_type = '', $email = '', $pass = '') {
            $this->load->database();
            $from_name = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
            $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
            if ($protocol == 'smtp') {
                $from = $this->db->get_where('general_settings', array('type' => 'smtp_user'))->row()->value;
            } else if ($protocol == 'mail') {
                $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
            }

            $to = $email;
            $query = $this->db->get_where($account_type, array('email' => $email));

            if ($query->num_rows() > 0) {

                if ($account_type == 'member') {
                    $sub = $this->db->get_where('email_template', array('email_template_id' => 7))->row()->subject;
                    $to_name = $query->row()->first_name . ' ' . $query->row()->last_name;
                    $url = base_url()."home/login";

                    $email_body = $this->db->get_where('email_template', array('email_template_id' => 7))->row()->body;
                    $email_body = str_replace('[[to]]', $to_name, $email_body);
                    $email_body = str_replace('[[sitename]]', $from_name, $email_body);
                    $email_body = str_replace('[[account_type]]', $account_type, $email_body);
                    $email_body = str_replace('[[email]]', $to, $email_body);
                    $email_body = str_replace('[[password]]', $pass, $email_body);
                    $email_body = str_replace('[[url]]', $url, $email_body);
                    $email_body = str_replace('[[from]]', $from_name, $email_body);
                }

                $send_mail = $this->do_email($from, $from_name, $to, $sub, $email_body, $mailtype="text");
                return $send_mail;
            } else {
                return false;
            }
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

function member_registration_email_to_admin($member_id = '')
        {
            $this->load->database();

            $from_name = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
            $member_data = $this->db->get_where('member', array('member_id' => $member_id));
            $to = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;

            if ($member_data->num_rows() > 0) {

                $member_name = $member_data->row()->first_name . ' ' . $member_data->row()->last_name;

                $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
                if ($protocol == 'smtp') {
                    $from = $this->db->get_where('general_settings', array('type' => 'smtp_user'))->row()->value;
                } else if ($protocol == 'mail') {
                    $from = $member_data->row()->email;
                }

                $sub = $this->db->get_where('email_template', array('email_template_id' => 8))->row()->subject;

                $email_body = $this->db->get_where('email_template', array('email_template_id' => 8))->row()->body;
                $email_body = str_replace('[[member_name]]', $member_name, $email_body);
                $email_body = str_replace('[[email]]', $member_data->row()->email, $email_body);
                $email_body = str_replace('[[from]]', $from_name, $email_body);
                 $email_body = str_replace('[[member_id]]', $member_data->row()->member_profile_id, $email_body);

                $send_mail = $this->do_email($from, $from_name, $to, $sub, $email_body, $mailtype="text");
                return $send_mail;
            } else {
                return false;
            }
        }
         function account_opening_member_approval_off($account_type = '', $email = '', $pass = '') {
            $this->load->database();
            $from_name = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
            $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
            if ($protocol == 'smtp') {
                $from = $this->db->get_where('general_settings', array('type' => 'smtp_user'))->row()->value;
            } else if ($protocol == 'mail') {
                $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
            }

            $to = $email;
            $query = $this->db->get_where($account_type, array('email' => $email));

            if ($query->num_rows() > 0) {
                    $sub = $this->db->get_where('email_template', array('email_template_id' => 9))->row()->subject;
                    $to_name = $query->row()->first_name . ' ' . $query->row()->last_name;
                    $url = base_url()."login";

                    $email_body = $this->db->get_where('email_template', array('email_template_id' => 9))->row()->body;
                    $email_body = str_replace('[[to]]', $to_name, $email_body);
                    $email_body = str_replace('[[sitename]]', $from_name, $email_body);
                    $email_body = str_replace('[[account_type]]', $account_type, $email_body);
                    $email_body = str_replace('[[email]]', $to, $email_body);
                    $email_body = str_replace('[[password]]', $pass, $email_body);
                    $email_body = str_replace('[[url]]', $url, $email_body);
                    $email_body = str_replace('[[from]]', $from_name, $email_body);
                    //$email_body = str_replace('[[member_id]]', $query->row()->member_profile_id, $email_body);

                $send_mail = $this->do_email($from, $from_name, $to, $sub, $email_body, $mailtype="text");
                return $send_mail;
            } else {
                return false;
            }
        }

        function member_email_verification($account_type = '', $email = '', $email_verification = '')
        {
            $this->load->database();
            $from_name = $this->db->get_where('general_settings', array('type' => 'system_name'))->row()->value;
            $protocol = $this->db->get_where('general_settings', array('type' => 'mail_status'))->row()->value;
            if ($protocol == 'smtp') {
                $from = $this->db->get_where('general_settings', array('type' => 'smtp_user'))->row()->value;
            } else if ($protocol == 'mail') {
                $from = $this->db->get_where('general_settings', array('type' => 'system_email'))->row()->value;
            }

            $to = $email;
            $query = $this->db->get_where($account_type, array('email' => $email));

            if ($query->num_rows() > 0) {
                    $sub = $this->db->get_where('email_template', array('email_template_id' => 10))->row()->subject;
                    $to_name = $query->row()->first_name . ' ' . $query->row()->last_name;
                    $email_verify = base_url()."home/email_verification/".$email_verification;
                    $url = base_url()."home/login";

                    $email_body = $this->db->get_where('email_template', array('email_template_id' => 10))->row()->body;
                    $email_body = str_replace('[[to]]', $to_name, $email_body);
                    $email_body = str_replace('[[account_type]]', $account_type, $email_body);
                    $email_body = str_replace('[[email]]', $to, $email_body);
                    $email_body = str_replace('[[email_verify]]', $email_verify, $email_body);
                    $email_body = str_replace('[[from]]', $from_name, $email_body);

                $send_mail = $this->do_email($from, $from_name, $to, $sub, $email_body, $mailtype="text");
                return $send_mail;
            } else {
                return false;
            }
        }
  

  

}