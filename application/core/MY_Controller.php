<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

   var $template  = array();
   var $data      = array();

   public function frontLayout()
   {
     $this->template['header_scripts'] = $this->load->view('front/includes/header_scripts', $this->data, true);
     // $this->template['header'] = $this->load->view('front/includes/header', $this->data, true);
     $this->template['top_navigation'] = $this->load->view('front/includes/top_navigation', $this->data, true);
     $this->template['middle'] = $this->load->view($this->middle, $this->data, true);         
     $this->template['footer'] = $this->load->view('front/includes/footer', $this->data, true);
     $this->template['footer_scripts'] = $this->load->view('front/includes/footer_scripts', $this->data, true);
     $this->load->view('front/includes/index', $this->template);
   }

   public function frontLayoutfooter()
   {
     $this->template['header_scripts'] = $this->load->view('front/includes/header_scripts', $this->data, true);
     // $this->template['header'] = $this->load->view('front/includes/header', $this->data, true);
     $this->template['top_navigation'] = $this->load->view('front/includes/top_navigation', $this->data, true);
     $this->template['middle'] = $this->load->view($this->middle, $this->data, true);         
     // $this->template['footer'] = $this->load->view('front/includes/footer', $this->data, true);
     $this->template['footer_scripts'] = $this->load->view('front/includes/footer_scripts', $this->data, true);
     $this->load->view('front/includes/index', $this->template);
   }

   public function AdminLayout()
   {
     
     $this->template['header_scripts']   = $this->load->view('Administrator/includes/header_scripts', $this->data, true);
     $this->template['top_navigation']   = $this->load->view('Administrator/includes/top_navigation', $this->data, true);
     $this->template['side_navigation']   = $this->load->view('Administrator/includes/side_navigation', $this->data, true);    
     $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
     $this->template['footer'] = $this->load->view('Administrator/includes/footer', $this->data, true);
     $this->template['footer_scripts'] = $this->load->view('Administrator/includes/footer_scripts', $this->data, true);
     $this->load->view('Administrator/includes/index', $this->template);
   }

   public function getAppLayout()
    {
        $this->template['header_scripts'] = $this->load->view('app/includes/header_scripts', $this->data, true);
        $this->template['top_navigation'] = $this->load->view('app/includes/top_navigation', $this->data, true);
        $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
        $this->template['footer'] = $this->load->view('app/includes/footer', $this->data, true);
        $this->template['footer_scripts'] = $this->load->view('app/includes/footer_scripts', $this->data, true);
        $this->load->view('app/includes/index', $this->template);
    }
    public function getAppLayoutfooter()
    {
        $this->template['header_scripts'] = $this->load->view('app/includes/header_scripts', $this->data, true);
        $this->template['top_navigation'] = $this->load->view('app/includes/top_navigation', $this->data, true);
        $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
        // $this->template['footer'] = $this->load->view('app/includes/footer', $this->data, true);
        $this->template['footer_scripts'] = $this->load->view('app/includes/footer_scripts', $this->data, true);
        $this->load->view('app/includes/index', $this->template);
    }
}
?>
  