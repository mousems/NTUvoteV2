<?php
class Api_model extends CI_Model {
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
    function exception_handler($exception)
    {
      echo json_encode(array("status"=>"error" ,"message"=>$exception->getMessage()));
      exit();
    }
    function vaild_apikey($apikey)
    {
        if(preg_match("/^[A-Za-z0-9]+$/", $apikey)!==1){
            return FALSE;
        }


        $this->db->from('apikey')->where('apikey_hash' , sha1($apikey));
        $query = $this->db->get();
        if ($query->num_rows()==0) {
            return FALSE;
        }else{
            return TRUE;
        }


    }
    function vaild_a_id($a_id)
    {
        if(preg_match("/^\d+$/", $a_id)!==1){
            return FALSE;
        }


        $this->db->from('account')->where('a_id' , $a_id);
        $query = $this->db->get();
        if ($query->num_rows()==0) {
            return FALSE;
        }else{
            return TRUE;
        }


    }
    function get_free_booth($a_id)
    {
        if($this->vaild_a_id($a_id)==FALSE){
            return FALSE;
        }


        $this->db->from('booth')->where('a_id' , $a_id)->where('status' , "free")->where('lastseen >=' , date('U')-120)->order_by('a_id','asc');
        $query = $this->db->get();
        if ($query->num_rows()==0) {
            return FALSE;
        }else{
            return $query->row(1)->{'num'};
        }
    }

    function get_b_id($a_id , $num)
    {
        if($this->vaild_a_id($a_id)==FALSE){
            return FALSE;
        }


        $this->db->from('booth')->where('a_id' , $a_id)->where('num' , $num);
        $query = $this->db->get();
        if ($query->num_rows()==0) {
            return FALSE;
        }else{
            return $query->row(1)->{'b_id'};
        }
    }
    function booth_free($authcode)
    {
        if($this->authcode_lib->vaild_authcode_format($authcode)==FALSE){
            return FALSE;
        }

        $data = array(
               'status' => 'free',
               'authcode' => ''
        );


        $this->db->where('authcode', $authcode);
        $this->db->update('booth', $data); 


    }
    function map_authcode_booth($a_id , $num , $authcode)
    {
        if($this->vaild_a_id($a_id)==FALSE){
            return FALSE;
        }
        if (preg_match("/^[1-4]$/", $num)!==1) {
            return FALSE;
        }

        $data = array(
               'status' => 'lock',
               'authcode' => $authcode
        );

        $this->db->where('a_id', $a_id);
        $this->db->where('num', $num);
        $this->db->update('booth', $data); 


        $data = array(
               'b_id' => $this->get_b_id($a_id,$num)
        );
        $this->db->where('hash', sha1($authcode));
        $this->db->update('authcode', $data); 

        return TRUE;
    }
    function get_station_list()
    {
        $this->db->from('account')->where('rule','station');
        $query = $this->db->get();
        return $query->result();

    }

    function get_booth_status($a_id , $num)
    {
        $this->db->from('booth')->where('a_id',$a_id)->where('num',$num);
        $query = $this->db->get();
        return $query->row(1);

    }
}

?>