<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeModel extends CI_Model
{


public function process_custom_query($query)
  {
    $result=$this->db->query($query);
    return $result->result();
  } 
 public function getAllDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('date_of_birth !=',0);
        $this->db->where('delete_status',0);
        //$this->db->limit(50);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getAllPrintDatas($table,$result,$gender="")
    {
        $this->db->select('*');
        $this->db->from($table);
        // //$this->db->where('active_status',1);
        if(!empty($gender)){
            $this->db->where('gender',$gender);
        }
        $this->db->where('delete_status',0);
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('is_closed','no');
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        // $this->db->limit(50);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("prefixId", "desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getDeactivateDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('active_status',0);
        $this->db->where('delete_status',1);
        $this->db->where('deactivate_status',1);
        //$this->db->limit(50);
        $this->db->order_by("member_id","desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getAdminDatas($table,$result,$id)
    {
        $this->db->select('*');
        $this->db->from($table);
        // //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        //$this->db->limit(50);
        $this->db->order_by($id,"desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getcontactDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        // //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        //$this->db->limit(50);
        $this->db->order_by("contact_message_id", "desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    

    public function getImageDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        //$this->db->limit(50);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOfflineDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',2);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }

    public function getOfflineMale($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',2);
        $this->db->where('gender',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOfflineFemale($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',2);
        $this->db->where('gender',2);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }

    public function getOnlineDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getFemaleDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('gender',2);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getMaleDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('gender',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOnlineMaleDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('gender',1);
        $this->db->where('member_type',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOnlineFemaleDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('gender',2);
        $this->db->where('member_type',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOnlineRenewDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('isRenewed',1);
        $this->db->where('member_type',1);
        //$this->db->where('active_status',1);
        $this->db->where('membership',2);
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        $this->db->order_by("member_id", "desc");  
        $this->db->where('is_closed','no');
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }

    public function getReportDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('reported_by',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getPendingDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('isRenewed',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getPendingOfflineDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',2);
        $this->db->where('isRenewed',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getPendingOnlineDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',1);
        $this->db->where('isRenewed',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getPendingOnlineUnpaid($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('membership',1);
        $this->db->where('member_type',1);
        $this->db->where('isRenewed',0);
         $this->db->where('updateProfileDoneStatus',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getincompleteProfileDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('updateProfileDoneStatus',0);
        $this->db->where('is_blocked','no');
        $this->db->where('member_since >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)');
        $this->db->where('updateProfileDoneStatus',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getincompleteOnlinePaid($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('membership',2);
        $this->db->where('member_type',1);
        $this->db->where('updateProfileDoneStatus',0);
        // $this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getincompleteOnlineUnpaid($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('membership',1);
        $this->db->where('member_type',1);
        $this->db->where('updateProfileDoneStatus',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getincompleteOffline($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_type',2);
        $this->db->where('updateProfileDoneStatus',0);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getWithoutProfileDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where("member_since >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
        $this->db->where("membership_date >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)"); 
        $this->db->where("(`profile_image` LIKE '%\"profile!_image\":\"default.jpg\"%' ESCAPE '!' OR `profile_image` LIKE '%\"profile!_image\":\"default!_female.jpg\"%' ESCAPE '!')");
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        $this->db->where('is_closed','no');
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getWithoutProfileOffline($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        // $this->db->where($profile);
        $this->db->where('member_type',2);
        $this->db->where("(`profile_image` LIKE '%\"profile!_image\":\"default.jpg\"%' ESCAPE '!' OR `profile_image` LIKE '%\"profile!_image\":\"default!_female.jpg\"%' ESCAPE '!')");
        //$this->db->where('active_status',1);
        $this->db->where("member_since >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        $this->db->where('is_closed','no');
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getWithoutProfileOnline($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        // $this->db->where($profile);
        $this->db->where('member_type',1);
        $this->db->where("(`profile_image` LIKE '%\"profile!_image\":\"default.jpg\"%' ESCAPE '!' OR `profile_image` LIKE '%\"profile!_image\":\"default!_female.jpg\"%' ESCAPE '!')");
        //$this->db->where('active_status',1);
        $this->db->where('updateProfileDoneStatus',1);
        $this->db->where("member_since >= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        $this->db->where('is_closed','no');
        $this->db->where('delete_status',0);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getblockDatas()
    {
        $this->db->select('blocked_members.*,member.*');
        $this->db->from('blocked_members');
        $this->db->join('member','blocked_members.blocked_member_id = member.member_id','left');
        $this->db->where('member.is_blocked','yes');
        $this->db->where('blocked_members.delete_status',0);
        $this->db->order_by("blocked_members.id ", "desc"); 
        //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }

    // public function getblockDatas()
    // {
    //     $this->db->select('*');
    //     $this->db->from('member');
    //     $this->db->where('is_blocked','yes');
    //     $this->db->where('delete_status',0);
    //     $this->db->where('deactivate_status',0);
    //     $this->db->order_by("member_id", "desc"); 
    //     //$this->db->limit(50); 
    //     $query=$this->db->get()->result();
    //     return $query;
    // }
    public function getblockOfflineDatas()
    {
        $this->db->select('blocked_members.*,member.*');
        $this->db->from('blocked_members');
        $this->db->join('member','blocked_members.blocked_member_id = member.member_id','left');
        $this->db->where('member.member_type',2);
        $this->db->where('member.is_blocked','yes');
        $this->db->where('blocked_members.delete_status',0);
        $this->db->order_by("blocked_members.id ", "desc"); 
        $query=$this->db->get()->result();
        return $query;
    }//
    public function getblockOnlineDatas()
    {
        $this->db->select('blocked_members.*,member.*');
        $this->db->from('blocked_members');
        $this->db->join('member','blocked_members.blocked_member_id = member.member_id','left');
        $this->db->where('member.member_type',1);
        $this->db->where('member.is_blocked','yes');
        $this->db->where('blocked_members.delete_status',0);
        $this->db->order_by("blocked_members.id ", "desc"); 
        $query=$this->db->get()->result();
        return $query;
    }//
    public function getCloseDatas()
    {
        $this->db->select('closed_members.*,member.*');
        $this->db->from('closed_members');
        $this->db->join('member','closed_members.member_id = member.member_id','left');
        $this->db->where('member.is_closed','yes');
        $this->db->order_by('closed_members.id','desc');
        $this->db->where('closed_members.delete_status',0); 
        $query=$this->db->get()->result();
        return $query;
    }//
    public function getCloseOfflineDatas()
    {
        $this->db->select('closed_members.*,member.*');
        $this->db->from('closed_members');
        $this->db->join('member','closed_members.member_id = member.member_id','left');
        $this->db->where('member.is_closed','yes');
        $this->db->where('member.member_type',2);
        $this->db->order_by('closed_members.id','desc');
        $this->db->where('closed_members.delete_status',0);
        $query=$this->db->get()->result();
        return $query;
    }//
    public function getCloseOnlineDatas()
    {
        $this->db->select('closed_members.*,member.*');
        $this->db->from('closed_members');
        $this->db->join('member','closed_members.member_id = member.member_id','left');
        $this->db->where('member.is_closed','yes');
        $this->db->where('member.member_type',1);
        $this->db->order_by('closed_members.id','desc');
        $this->db->where('closed_members.delete_status',0);
        $query=$this->db->get()->result();
        return $query;
    }//

    public function getDuplicateDatas()
    {
        $sql = "SELECT mem.* FROM member AS mem INNER JOIN (SELECT mobile FROM member WHERE mobile != '' GROUP BY (mobile) HAVING COUNT(mobile) > 2) AS mem1 ON mem.mobile = mem1.mobile WHERE mem.mobile!='' AND mem.is_closed='no' AND mem.isRenewed=0 AND mem.date_of_birth !=0 AND mem.deactivate_status=0 ORDER BY mem.mobile ASC";

        $query = $this->db->query($sql)->result();
        return $query;
    }//
    public function getDuplicateOffline()
    {
        $sql = "SELECT mem.* FROM member AS mem INNER JOIN (SELECT mobile FROM member WHERE mobile != '' GROUP BY (mobile) HAVING COUNT(mobile) > 2) AS mem1 ON mem.mobile = mem1.mobile WHERE mem.mobile!='' AND mem.is_closed='no' AND mem.isRenewed=0 AND mem.member_type=2 AND mem.date_of_birth !=0 AND mem.deactivate_status=0 ORDER BY mem.mobile ASC";

        $query = $this->db->query($sql)->result();
        return $query;
    }//

    public function getDuplicateOnline()
    {
        $sql = "SELECT mem.* FROM member AS mem INNER JOIN (SELECT mobile FROM member WHERE mobile != '' GROUP BY (mobile) HAVING COUNT(mobile) > 2) AS mem1 ON mem.mobile = mem1.mobile WHERE mem.mobile!='' AND mem.is_closed='no' AND mem.isRenewed=0 AND mem.member_type=1 AND mem.date_of_birth !=0 AND mem.deactivate_status=0 ORDER BY mem.mobile ASC";

        $query = $this->db->query($sql)->result();
        return $query;
    }//
    public function getOnlineUnpaidDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        // $this->db->where($data);
        $this->db->where('member_type',1);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);

        $this->db->group_start();
        $this->db->where("membership_date <= DATE_SUB(CURDATE(),INTERVAL 6 MONTH)");
        $this->db->or_where("membership_date",NULL);
        $this->db->group_end();

        $this->db->order_by("member_id","desc"); 
        //$this->db->limit(50);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getDeletedDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',1);
        $this->db->order_by("member_id","desc");
        $this->db->limit(100);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getOldRenewedDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        // $this->db->where('active_status',0);
        $this->db->where('delete_status',0);
        $this->db->order_by("member_id","desc");
        // $this->db->limit(100);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getreportedDatas()
    {
        $this->db->select('members_report.*,members_report.id as report_id,member.*');
        $this->db->from('members_report');
        $this->db->join('member','member.member_id = members_report.member_id','left');
        $this->db->where('members_report.delete_status',0);
        $this->db->where('member.delete_status',0);
        $this->db->order_by('members_report.id','desc');
        //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }// get_feedbacks_datas function closed
    public function getSingleData($table,$id)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('member_id',$id);
        //$this->db->where('active_status',1);
        $this->db->where('delete_status',0);
        // $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");   
        $data=$this->db->get()->row();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getstoryDatas()
    {
        $this->db->select('happy_story.*,member.*');
        $this->db->from('happy_story');
        $this->db->join('member','member.member_id = happy_story.posted_by','left');
        $this->db->where('happy_story.active_status',1);
        $this->db->where('happy_story.delete_status',0);
        $this->db->order_by("happy_story.happy_story_id ","desc");
        // //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }
    public function getstoryAprovedDatas($data)
    {
        $this->db->select('happy_story.*,member.*');
        $this->db->from('happy_story');
        $this->db->join('member','member.member_id = happy_story.posted_by','left');
        $this->db->where('happy_story.active_status',1);
        $this->db->where('happy_story.delete_status',0);
        $this->db->where('happy_story.approval_status',$data);
        // //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }
    public function getearningDatas()
    {
        $this->db->select('package_payment.*,package_payment.amount as amt,package_payment.created_date as date,member.*,plan.*');
        $this->db->from('package_payment');
        $this->db->join('member','member.member_id = package_payment.member_id','left');
        $this->db->join('plan','plan.plan_id = package_payment.plan_id ','left');
        // $this->db->where('package_payment.active_status',1);
        $this->db->where('package_payment.delete_status',0);
        $this->db->where('member.delete_status',0);
        $this->db->order_by('package_payment.package_payment_id ','desc');
        // //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }
    public function getonlineearningDatas()
    {
        $this->db->select('package_payment.*,package_payment.amount as amt,package_payment.created_date as date,member.*,plan.*');
        $this->db->from('package_payment');
        $this->db->join('member','member.member_id = package_payment.member_id','left');
        $this->db->join('plan','plan.plan_id = package_payment.plan_id ','left');
        $this->db->where('member.member_type',1);
        // $this->db->where('package_payment.active_status',1);
        $this->db->where('package_payment.delete_status',0);
        $this->db->where('member.delete_status',0);
        $this->db->order_by('package_payment.package_payment_id ','desc');
        //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }
    public function getofflineearningDatas()
    {
        $this->db->select('package_payment.*,package_payment.amount as amt,package_payment.created_date as date,member.*,plan.*');
        $this->db->from('package_payment');
        $this->db->join('member','member.member_id = package_payment.member_id','left');
        $this->db->join('plan','plan.plan_id = package_payment.plan_id ','left');
        $this->db->where('member.member_type',2);
        // $this->db->where('package_payment.active_status',1);
        $this->db->where('package_payment.delete_status',0);
        $this->db->where('member.delete_status',0);
        $this->db->order_by('package_payment.package_payment_id ','desc');
        //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }
    public function gettypeearningDatas($type)
    {
        $this->db->select('package_payment.*,package_payment.amount as amt,package_payment.created_date as date,member.*,plan.*');
        $this->db->from('package_payment');
        $this->db->where('member.member_type',$type);
        $this->db->join('member','member.member_id = package_payment.member_id','left');
        $this->db->join('plan','plan.plan_id = package_payment.plan_id ','left');
        // $this->db->where('package_payment.active_status',1);
        $this->db->where('package_payment.delete_status',0);
        $this->db->where('member.delete_status',0);
        $this->db->order_by('package_payment.package_payment_id ','desc');
        //$this->db->limit(50); 
        $query=$this->db->get()->result();
        return $query;
    }
    public function getMemberActiveDatas($limit="")
    {
        $this->db->select('user_activity.*,user_activity.created_date as date,member.*');
        $this->db->from('user_activity');
        $this->db->join('member','member.member_id = user_activity.member_id','left');
        $this->db->where('member.delete_status',0);
        $this->db->order_by('user_activity.created_date','desc');
        if(!empty($limit)){
            $this->db->limit($limit);
        }
        $query=$this->db->get()->result();
        return $query;
    }
    public function getAdminActiveDatas($limit="")
    {
        $this->db->select('admin_activity.*,admin_activity.created_date as date,admin.*');
        $this->db->from('admin_activity');
        $this->db->join('admin','admin.admin_id = admin_activity.admin_id','left');
        $this->db->where('admin.delete_status',0);
        $this->db->order_by('admin_activity.created_date','desc');
        if(!empty($limit)){
            $this->db->limit($limit);
        }
         
        $query=$this->db->get()->result();
        return $query;
    }
    public function getTemplateDatas($table,$result)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where('delete_status',0);
        $this->db->order_by("id ", "desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getTemplateData($table,$result,$where)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $this->db->where('delete_status',0);  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
     public function getMatchedDatas($table,$result,$gender="",$limit="")
    {
        $this->db->select('*');
        $this->db->from($table);
        // //$this->db->where('active_status',1);
        if(!empty($gender)){
           $this->db->where('gender',$gender); 
        }
        if(!empty($limit)){
           $this->db->limit($limit); 
        }
        $this->db->where('is_married',1);
        // $this->db->where('active_status',0);
        $this->db->where('delete_status',1);
        //$this->db->limit(50);
        $this->db->where('deactivate_status',0);
        $this->db->order_by("member_id", "desc");  
        $data=$this->db->get()->$result();
        //echo $this->db->last_query(); exit;
        return $data;
    }
    public function getfaqDatas($table,$result,$qId="")
   {
      $this->db->select('*');
      $this->db->from($table); 
      if(!empty($qId)){
        $this->db->where('qId',$qId);  
      }
      $this->db->where('delete_status',0);
      $result=$this->db->get()->$result();
      return $result;
   }
   public function getcommonfaqDatas($table,$result)
   {
      $this->db->select('*');
      $this->db->from($table); 
      $this->db->where('qId',0); 
      $this->db->where('delete_status',0); 
      $result=$this->db->get()->$result();
      return $result;
   }
}