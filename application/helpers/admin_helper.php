<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_user_image_active($user_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('images');
    $ci->db->where('user_id',$user_id);
    $ci->db->where('delete_status',0);
    $ci->db->where('status',0);
    return $query=$ci->db->get()->result();
}// get_user_image_active function closed
    
function get_user_datas_admin($users_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->where('user_id',$users_id);
    $ci->db->where('delete_status',0);
    $query=$ci->db->get()->row_array();
    return $query;
}// get_user_datas_admin function closed

function get_edu_parent_datas($education_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('educations');
    $ci->db->where('edu_patient_id',$education_id);
    $ci->db->where('delete_status',0);
    $query=$ci->db->get()->result();
    return $query;
}// get_edu_parent_datas function closed



function get_single_user_datas_new($user_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->from('users');
    $ci->db->where('user_id',$user_id);
    $query=$ci->db->get()->row_array();
    return $query;
}// get_single_user_datas_new function closed


function upload_files($target_dir,$image_variable)
{   
    $ci=& get_instance();
    $config['file_name'] = time().'_'.basename(str_replace(" ","",$_FILES[$image_variable]["name"]));
    $config['upload_path'] = $target_dir;
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = 15000;
    $ci->load->library('upload', $config);
    
    if (!$ci->upload->do_upload($image_variable)) 
    {
        // return $error = array('error' => $ci->upload->display_errors());
        return '';        
    } 
    else 
    {
        // return $data = array('image_metadata' => $ci->upload->data());     
        return $config['file_name'];
    }
}


function uploading_array_of_files($target_dir,$image_variable)
{
    $total_images = count($_FILES[$image_variable]["name"]);
    $images_names = [];
    for ($i=0; $i < $total_images; $i++) { 
        $image_name=time().'_'.basename($_FILES[$image_variable]["name"][$i]);
        $target_file = $target_dir .$image_name;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if (move_uploaded_file($_FILES[$image_variable]["tmp_name"][$i], $target_file)){
            $images_names[]=$image_name;
        } 
        else {
            $images_names[]='';
        }

    }
    return $images_names;   
}