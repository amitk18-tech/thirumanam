<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function send_email_for_user_otp_notification($email,$otp)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->where('email',$email);
    $ci->db->where('delete_status',0);
    $user_details=$ci->db->get()->row_array();

    $datas['user_datas']=$user_details;
    $datas['otp']=$otp;
    $ci->load->library('email');
    $to_email=$email;

    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['useragent'] = 'CodeIgniter';
    $config['smtp_host'] = 'ssl://smtp.gmail.com'; 
    $config['smtp_user'] = 'valli.vallikodi@gmail.com';
    $config['smtp_pass'] ='jayakumar@2022';
    $config['smtp_port'] = '465';
    $config['mailtype'] = 'html';
    $config['newline'] = "\r\n";

     $ci->load->library('email');
    $ci->email->initialize($config);

    $ci->email->from('valli.vallikodi@gmail.com');
    $ci->email->to($to_email);
    $ci->email->subject('Vallikodi Matrimony - OTP Notification');
    $msg=$ci->load->view ('front/email/otp_notification_mail',$datas, true);
    $ci->email->message($msg);
      
    if($ci->email->send())
    {
        $mail_status='send';
    }
    else
    {
      echo $ci->email->print_debugger();exit;
      $mail_status='not-send';
    }
    //echo $mail_status;
}   // send_email_for_user_otp_notification function closed

function send_email_for_user_welcome($user_datas)
{
	$today=date('Y-m-d');
	$ci =& get_instance();
    $ci->load->database();

    $ci->db->select('*');
    $ci->db->from('payment_plans');
    $ci->db->join('meta_value','payment_plans.plan_type_meta = meta_value.meta_value_id','left');
    $ci->db->where('payment_plans.delete_status',0);
    $ci->db->where('payment_plans.status',1);
    $ci->db->where('payment_plans.plan_from_date <=',$today);
    $ci->db->where('payment_plans.plan_to_date >=',$today);
    $payment=$ci->db->get()->result();

	$datas['user_datas']=$user_datas;
	$datas['payment_datas']=$payment;

	$ci->load->library('email');
    $to_email=$user_datas['email'];
   /* $config = array(
    'protocol' => 'smtp',
    'mailpath' => '/usr/bin/sendmail',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => $GLOBALS['smtp_user'],
    'smtp_pass' => $GLOBALS['smtp_pass'],
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
    'wordwrap' =>true
    );*/
    $config['protocol'] = 'sendmail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['wordwrap'] = TRUE;
    $config['useragent'] = 'CodeIgniter';
    $config['smtp_host'] = 'ssl://smtp.gmail.com'; 
    $config['smtp_user'] = 'valli.vallikodi@gmail.com';
    $config['smtp_pass'] ='jayakumar@2022';
    $config['smtp_port'] = '465';
    $config['mailtype'] = 'html';
    $config['newline'] = "\r\n";
     /*$config = array(
        'useragent'=>'CodeIgniter',
        'smtp_timeout'=>'30',
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://bh-3.webhostbox.net',
        'smtp_port' => 465,
        'smtp_user' => $GLOBALS['smtp_user'],
        'smtp_pass' => $GLOBALS['smtp_pass'],
        'mailtype'  => 'html',
        'charset'   =>'utf-8',
        'wordwrap' =>true
        );*/

    $ci->load->library('email');
    $ci->email->initialize($config);

    $ci->email->from('valli.vallikodi@gmail.com');
    $ci->email->to($to_email);
    $ci->email->subject('Welcome to Vallikodi Matrimony');

    $msg=$ci->load->view ('email/welcome_payment_notification_mail',$datas, true);
    $ci->email->message($msg);


    // $ci->email->initialize($config);
    // $ci->email->set_newline("\r\n");
    // $ci->email->from($GLOBALS['from_email'], 'Vallikodi Matrimony');
    // $ci->email->to($to_email);
    // $ci->email->subject('Welcome to Vallikodi Matrimony');
    // $msg=$ci->load->view ('email/welcome_payment_notification_mail',$datas, true);
    // $ci->email->message($msg);

	//$ci->load->view ('email/welcome_payment_notification_mail',$datas);

    if($ci->email->send())
    {
     	$mail_status='send';
    }
    else
    {
      //echo $this->email->print_debugger();
      $mail_status='not-send';
    }
    //echo $mail_status;
}// send_email_for_user_welcome function closed

function send_mail_for_to_user($login_user_id,$to_user_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->from('users');
    $ci->db->join('user_details','user_details.user_id = users.user_id','left');
    $ci->db->join('user_family_details','user_family_details.user_id = users.user_id','left');
    $ci->db->join('user_professional_details','user_professional_details.user_id = users.user_id','left');
    $ci->db->join('citys','citys.city_id = user_details.city_id','left');
    $ci->db->where('users.user_id',$login_user_id);
    $profile_user_details=$ci->db->get()->row_array();


    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->where('users.user_id',$to_user_id);
    $to_user_datas=$ci->db->get()->row_array();

    $datas['user_datas']=$to_user_datas;
    $datas['profile_datas']=$profile_user_details;

    $ci->load->library('email');
    $to_email=$to_user_datas['email'];
   /* $config = array(
    'protocol' => 'smtp',
    'mailpath' => '/usr/bin/sendmail',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => $GLOBALS['smtp_user'],
    'smtp_pass' => $GLOBALS['smtp_pass'],
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
    'wordwrap' =>true
    );*/
     $config = array(
        'useragent'=>'CodeIgniter',
        'smtp_timeout'=>'30',
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://bh-3.webhostbox.net',
        'smtp_port' => 465,
        'smtp_user' => $GLOBALS['smtp_user'],
        'smtp_pass' => $GLOBALS['smtp_pass'],
        'mailtype'  => 'html',
        'charset'   =>'utf-8',
        'wordwrap' =>true
        );
    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from($GLOBALS['from_email'], 'Vallikodi Matrimony');
    $ci->email->to($to_email);
    $ci->email->subject('Vallikodi Matrimony - Message Notification');
    $msg=$ci->load->view ('email/message_notification_mail',$datas, true);
    $ci->email->message($msg);

    //$ci->load->view ('email/message_notification_mail',$datas);
        
    if($ci->email->send())
    {
        $mail_status='send';
    }
    else
    {
      //echo $this->email->print_debugger();
      $mail_status='not-send';
    }
    //echo $mail_status;
}// send_mail_for_to_user function closed


function send_mail_for_touser_interest($login_user_id,$partner_user_id)
{
    $ci =& get_instance();
    $ci->load->database();

    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->join('user_details','users.user_id = user_details.user_id','left');
    $ci->db->join('user_family_details','users.user_id = user_family_details.user_id','left');
    $ci->db->join('user_professional_details','users.user_id = user_professional_details.user_id','left');
    $ci->db->join('citys','user_details.city_id = citys.city_id','left');
    $ci->db->where('users.user_id',$login_user_id);
    $profile_user_details=$ci->db->get()->row_array();

    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->where('user_id',$partner_user_id);
    $to_user_datas=$ci->db->get()->row_array();

    $datas['user_datas']=$to_user_datas;
    $datas['profile_datas']=$profile_user_details;
   
    $ci->load->library('email');
    $to_email=$to_user_datas['email'];
  /*  $config = array(
    'protocol' => 'smtp',
    'mailpath' => '/usr/bin/sendmail',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => $GLOBALS['smtp_user'],
    'smtp_pass' => $GLOBALS['smtp_pass'],
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
    'wordwrap' =>true
    );*/
     $config = array(
        'useragent'=>'CodeIgniter',
        'smtp_timeout'=>'30',
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://bh-3.webhostbox.net',
        'smtp_port' => 465,
        'smtp_user' => $GLOBALS['smtp_user'],
        'smtp_pass' => $GLOBALS['smtp_pass'],
        'mailtype'  => 'html',
        'charset'   =>'utf-8',
        'wordwrap' =>true
        );
    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from($GLOBALS['from_email'], 'Vallikodi Matrimony');
    $ci->email->to($to_email);
    $ci->email->subject('Vallikodi Matrimony - Interest Notification');
    $msg=$ci->load->view ('email/interest_notification_mail',$datas, true);
    $ci->email->message($msg);

    //$ci->load->view ('email/interest_notification_mail',$datas);
       
    if($ci->email->send())
    {
        $mail_status='send';
    }
    else
    {
      $mail_status='not-send';
    }
    //echo $mail_status;

}// send_mail_for_touser_interest function closed 

function send_profile_verification_email($user_datas,$detail_vstatus,$professional_vstatus,$family_vstatus)
{
    $ci =& get_instance();
    $ci->load->database();

    $datas['user_datas']=$user_datas;
    $datas['detail_vstatus']=$detail_vstatus;
    $datas['professional_vstatus']=$professional_vstatus;
    $datas['family_vstatus']=$family_vstatus;

    $ci->load->library('email');
    $to_email=$user_datas['email'];
  /*  $config = array(
    'protocol' => 'smtp',
    'mailpath' => '/usr/bin/sendmail',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => $GLOBALS['smtp_user'],
    'smtp_pass' => $GLOBALS['smtp_pass'],
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
    'wordwrap' =>true
    );*/
     $config = array(
        'useragent'=>'CodeIgniter',
        'smtp_timeout'=>'30',
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://bh-3.webhostbox.net',
        'smtp_port' => 465,
        'smtp_user' => $GLOBALS['smtp_user'],
        'smtp_pass' => $GLOBALS['smtp_pass'],
        'mailtype'  => 'html',
        'charset'   =>'utf-8',
        'wordwrap' =>true
        );
        
    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from($GLOBALS['from_email'], 'Vallikodi Matrimony');
    $ci->email->to($to_email);
    $ci->email->subject('Vallikodi Matrimony - Profile Verification Notification');
    $msg=$ci->load->view ('email/profile_verification_notification_mail',$datas, true);
    $ci->email->message($msg);
  
    if($ci->email->send())
    {
        $mail_status='send';
    }
    else
    {
        $mail_status='not-send';
    }
    //echo $mail_status;
}// send_profile_verification_email function closed


function send_mail_interest_accepted($user_details,$p_u_id)
{
    $ci =& get_instance();
    $ci->load->database();
    
    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->where('user_id',$p_u_id);
    $prefer_user_datas=$ci->db->get()->row_array();

    $datas['user_details']=$user_details;
    $datas['prefer_user_datas']=$prefer_user_datas;

    $ci->load->library('email');
    $to_email=$prefer_user_datas['email'];
   /* $config = array(
    'protocol' => 'smtp',
    'mailpath' => '/usr/bin/sendmail',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => $GLOBALS['smtp_user'],
    'smtp_pass' => $GLOBALS['smtp_pass'],
    'mailtype'  => 'html',
    'charset'   => 'iso-8859-1',
    'wordwrap' =>true
    );*/
     $config = array(
        'useragent'=>'CodeIgniter',
        'smtp_timeout'=>'30',
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://bh-3.webhostbox.net',
        'smtp_port' => 465,
        'smtp_user' => $GLOBALS['smtp_user'],
        'smtp_pass' => $GLOBALS['smtp_pass'],
        'mailtype'  => 'html',
        'charset'   =>'utf-8',
        'wordwrap' =>true
        );
        
    $ci->email->initialize($config);
    $ci->email->set_newline("\r\n");
    $ci->email->from($GLOBALS['from_email'], 'Vallikodi Matrimony');
    $ci->email->to($to_email);
    $ci->email->subject('Vallikodi Matrimony - Interest Notification');
    $msg=$ci->load->view ('email/accepted_interest_notification_mail',$datas, true);
    $ci->email->message($msg);

    if($ci->email->send())
    {
        $mail_status='send';
    }
    else
    {
        $mail_status='not-send';
    }
    //echo $mail_status;
}// send_mail_interest_accepted function closed