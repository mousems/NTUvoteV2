<?php
class Test_model extends CI_Model {
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
    
    function get_unuse_authcode()
    {
        $this->db->select('authcode')->from('test_authcode');
        $this->db->where('used' ,"0");
        $this->db->order_by('RAND()');
        $this->db->limit('1');
        $query = $this->db->get();
        $authcode_plain = $query->result();
        $authcode_plain = $authcode_plain[0]->{'authcode'};

        $data = array(
            "used"=>"1"
        );
        $this->db->where('authcode',$authcode_plain);
        $this->db->update('test_authcode',$data);


        return $authcode_plain;
    }
    function get_ballotlist($prefix)
    {
        $this->db->select('name')->from('ballot_list')->where('prefix',$prefix);
        $query = $this->db->get();
        $result = $query->result();
        return  $result[0]->{'name'};

    }

}

?>