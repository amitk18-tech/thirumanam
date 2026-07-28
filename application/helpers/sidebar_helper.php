<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');




function getSubMenuCountForParticularParent($id)
{
	$ci =& get_instance();
	$ci->load->database();
	$ci->db->select('*');
	$ci->db->from('menu_navigation');
	$ci->db->where('parent_id',$id);
	$ci->db->where('delete_status',0);
	$ci->db->order_by('id','ASC');
	$query=$ci->db->get()->result();
	return $query;
}// getSubMenuCountForParticularParent function closed



function get_main_settings()
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('main_settings');
    $ci->db->where('delete_status',0);
    $ci->db->order_by('id','DESC');
    $q=$ci->db->get()->row_array();
    return $q;
}
    
