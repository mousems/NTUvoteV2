<?php
class Vote_core_model extends CI_Model {
    /**
    * MIT License (MIT)
    * Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
    * http://opensource.org/licenses/MIT
    * https://github.com/mousems/NTUVoteV2
    **/
    

    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
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