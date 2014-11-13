<?php
class Vote_core_model extends CI_Model {

    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
    }
    function vaild_authcode_format($authcode)
    {
        preg_match("/^(.*)\-([A-Z0-9]{9})-([A-Z0-9]{9})-([A-Z0-9]{5})$/", $authcode, $matches);


        if (isset($matches[4])) {




            $this->db->from('ballot_list')->where('prefix' , $matches[1]);
            $query = $this->db->get();
            if ($query->num_rows()==0) {
                return FALSE;
            }



            $part1 = $matches[2];
            $part2 = $matches[3];
            $part3 = strtoupper(substr(md5($part1.md5($part2)), 1, 5)) ;
            if ($part3==$matches[4]) {
                return TRUE;
            }else{
                return FALSE;

            }
        }else{
            return FALSE;
        }
    }
    function get_authcode_status($authcode)
    {
        if ($this->vaild_authcode_format($authcode)===FALSE) {
            return FALSE;
        }


        $this->db->select("hash ,prefix , step")->from('authcode')->where('hash' , sha1($authcode));
        $query = $this->db->get();

        if($query->num_rows()==0){
            return FALSE;
        }else{
            return $query->row(1);
        }
        
    }

    function get_ballot_type_status_by_prefix($prefix)
    {



        $this->db->from('ballot_list')->where('prefix' , $prefix)->join('ballot_map','ballot_map.l_id=ballot_list.l_id');
        $query = $this->db->get();

        if($query->num_rows()==0){
            return FALSE;
        }else{
            $result = $query->result();
            if (isset($result[0])) {
                $tmp = new stdClass();
                $tmp->{'count'} = count($result);
                $tmp->{'t_id'} = array();
                foreach ($result as $key => $value) {
                    array_push($tmp->{'t_id'}, $value->{'t_id'});
                }
                return $tmp;
            }else{
                $tmp = new stdClass();
                $tmp->{'count'} = count($result);
                $tmp->{'t_id'} = array();

                return $tmp;
            }
        }
        
    }

    function get_ballot_type_status($t_id)
    {



        $this->db->from('ballot_type')->where('t_id' , $t_id);
        $query = $this->db->get();

        if($query->num_rows()==0){
            return FALSE;
        }else{
            return $query->row();
            
        }
        
    }
    function checkVoteStatus($booth_username="")
    {

        $this->db->from('booth')->where('username' , $booth_username);
        $query = $this->db->get();

        if($query->num_rows()==0){
            return FALSE;
        }elseif($query->row(1)->{'status'} == "lock") {
            return $query->row(1)->{'authcode'};
        }else{
            return FALSE;
        }
        
    }
    function get_candidate_list($t_id)
    {
        $this->db->from('candidate')->where('t_id',$t_id);
        $query = $this->db->get();
        
        return $query->result();
    }

}

?>