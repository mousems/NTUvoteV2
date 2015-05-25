<?php
class Vote_model extends CI_Model {
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
    
    function get_booth_status($a_id="")
    {
        $this->db->select('booth.a_id ,booth.b_id ,num ,status , account.name , lastseen')->from('booth');
        $this->db->join('account' , 'account.a_id=booth.a_id');
        if ($a_id!="") {
            $this->db->where('account.a_id' ,$a_id);
        }
        $query = $this->db->get();
        
        return $query->result();
    }
    function get_account_list()
    {
        $this->db->from('account')->where('rule','station');
        $query = $this->db->get();
        
        return $query->result();
    }


    function del_account($a_id)
    {
        $this->db->delete('booth',array('a_id'=>$a_id));

        $this->db->delete('account',array('a_id'=>$a_id));
    }

    function add_account($location , $username , $password , $boothcount)
    {


        $salt = substr(md5("U"), 1,8);
        $password_en = md5(md5($password).$salt);

        $data = array(
           'username' => $username,
           'password' => $password_en,
           'salt' => $salt,
           'name' => $location,
           'rule' => "station",
           'boothcount' => $boothcount
        );
        $this->db->insert('account', $data);
        $a_id = $this->db->insert_id(); 

        $result_list = array();
        for ($i=1; $i <= $boothcount ; $i++) { 


            $boothusername = $username."-".$i;
            $booth_password = $this->generateRandomString(10);
            $booth_passwordenmd5 = md5(md5($booth_password).$boothusername);
            $data = array(
               'a_id' => $a_id,
               'username' => $boothusername,
               'password' => $booth_passwordenmd5,
               'num' => $i
            );

            $tmplist = new stdClass();

            $result_list[$i]=$booth_password;

            $this->db->insert('booth', $data); 

        }
        
        return $result_list;

    }


    //return
    //Array
// (
//     [0] => stdClass Object
//         (
//             [l_id] => 1
//             [prefix] => 1B
//             [t_arr] => Array
//                 (
//                     [0] => stdClass Object
//                         (
//                             [t_id] => 1
//                             [title1] => test string
//                         )

//                     [1] => stdClass Object
//                         (
//                             [t_id] => 2
//                             [title1] => test string
//                         )

//                 )

//         )

//     [1] => stdClass Object
//         (
//             [l_id] => 2
//             [prefix] => 1C
//             [t_arr] => Array
//                 (
//                     [0] => stdClass Object
//                         (
//                             [t_id] => 3
//                             [title1] => test string
//                         )

//                     [1] => stdClass Object
//                         (
//                             [t_id] => 4
//                             [title1] => test string
//                         )

//                     [2] => stdClass Object
//                         (
//                             [t_id] => 5
//                             [title1] => test string
//                         )

//                     [3] => stdClass Object
//                         (
//                             [t_id] => 5
//                             [title1] => test string
//                         )

//                 )

//         )

// )

    public function get_ballot_list(){

        $this->db->from('ballot_list')->order_by('prefix','asc');
        $query = $this->db->get();
        $ballot_list = $query->result();

        $return_result = array();

        foreach ($ballot_list as $key => $value) {

            $this->db->from('ballot_map')->where('ballot_map.l_id' ,$value->{'l_id'});
            $this->db->join('ballot_type' , 'ballot_type.t_id=ballot_map.t_id');
            $query = $this->db->get();
            $ballot_type_result = $query->result();
            
            $t_id_array = array();
            foreach ($ballot_type_result as $key2 => $value2) {


                $tmp = new stdClass();
                $tmp->{'t_id'} = $value2->{'t_id'};
                $tmp->{'title1'} = $value2->{'title1'};       
                $tmp->{'type'} = $value2->{'type'};

                array_push($t_id_array , $tmp);
            }


            $tmp = new stdClass();
            $tmp->{'l_id'} = $value->{'l_id'};
            $tmp->{'name'} = $value->{'name'};
            $tmp->{'prefix'} = $value->{'prefix'};
            $tmp->{'t_arr'} = $t_id_array;
            
            array_push($return_result , $tmp);
        }


        return $return_result;
    }

    function del_ballot_list($l_id){
        $this->db->delete('ballot_map',array('l_id'=>$l_id));

        $this->db->delete('ballot_list',array('l_id'=>$l_id));


    }


    function add_ballot_list($name , $prefix){


        $data = array(
           'name' => $name,
           'prefix' => $prefix
        );
        $this->db->insert('ballot_list', $data);


    }

    function get_ballot_type_list(){

        $this->db->from('ballot_type');
        $query = $this->db->get();
        $ballot_type_list = $query->result();


        return $ballot_type_list;
    }

    function del_ballot_type($t_id){
        $this->db->delete('ballot_map',array('t_id'=>$t_id));

        $this->db->delete('ballot_type',array('t_id'=>$t_id));

    }


    function add_ballot_type($title1 , $title2 , $type){

        $data = array(
           'title1' => $title1,
           'title2' => $title2,
           'type' => $type
        );
        $this->db->insert('ballot_type', $data);


     }

    function get_candidate_list(){

        $this->db->from('candidate');
        $this->db->join('ballot_type' ,'ballot_type.t_id=candidate.t_id');
        $this->db->order_by('ballot_type.t_id asc , candidate.num asc');
        $query = $this->db->get();
        $candidate_list = $query->result();


        return $candidate_list;
    }


    function add_candidate($name , $num , $img , $t_id){

        $data = array(
           'name' => $name,
           'num' => $num,
           'img' => $img,
           't_id' => $t_id
        );
        $this->db->insert('candidate', $data);


     }
    function del_candidate($c_id){
        $this->db->delete('candidate',array('c_id'=>$c_id));


    }

    function get_ballot_list_by_l_id($l_id){

        $this->db->from('ballot_list');
        $this->db->where('l_id' , $l_id);
        $query = $this->db->get();
        $ballot_list = $query->result();


        return $ballot_list;
    }

    // get ballot type that assign to a ballot list status
    function get_ballot_type_assign_status($l_id){

        $this->db->from('ballot_map');
        $this->db->where('l_id' , $l_id);
        $query = $this->db->get();
        $list = $query->result();

        $map_to_t_id = array();
        foreach ($list as $key => $value) {
            array_push($map_to_t_id, $value->{'t_id'});
        }


        $this->db->from('ballot_type');
        $query = $this->db->get();
        $list = $query->result();


        foreach ($list as $key => $value) {
            if (in_array($value->{'t_id'}, $map_to_t_id)) {
                $list[$key]->{'assign'} = 'true';
            }else{
                $list[$key]->{'assign'} = 'false';
            }
        }

        return $list;
    }

    function mapping_do($postvalue){

        $this->db->delete('ballot_map',array('l_id'=>$postvalue['l_id']));
        foreach ($postvalue as $key => $value) {
            if (preg_match("/(^\d+$)/", $key)===1) {
                $data = array(
                    'l_id' => $postvalue['l_id'],
                    't_id' => $key
                );
                $this->db->insert('ballot_map', $data);    
            }
        }
    }

    function generate_authcode($count){
        $this->load->helper('string');

        $this->db->truncate('authcode');

        $list = $this->get_ballot_list();
        $authcode = array();

        foreach ($list as $key => $value) {
            for ($i=0; $i < $count; $i++) { 
                $part1 = strtoupper(random_string('alnum',9));
                $part2 = strtoupper(random_string('alnum',9));
                $part3 = substr(md5($part1.md5($part2)), 1, 5) ;
                $authcode_plain = $value->{'prefix'}."-".$part1."-".$part2."-".strtoupper($part3);
                
                $tmp = new stdClass();
                $tmp->{'hash'}= sha1($authcode_plain);
                $tmp->{'plain'}= $authcode_plain;
                $tmp->{'prefix'}= $value->{'prefix'};

                array_push($authcode, $tmp);

            }
        }

        $this->db->trans_start();

        foreach ($authcode as $key => $value) {
            $data = array(
                "hash"=>$value->{'hash'},
                "prefix"=>$value->{'prefix'}
            );
            $this->db->insert('authcode' , $data);
        }
        $this->db->trans_complete();

        

        return $authcode;

 
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
    return $randomString;
    }
    function get_booths_vote_group_count_list(){
        
        switch ($this->session->userdata('logintype')) {
            case 'admin':
                $this->db->select('account.name , booth.num,count(*) as count');
                $this->db->from('authcode');
                $this->db->join('booth','booth.b_id=authcode.b_id');
                $this->db->join('account','booth.a_id=account.a_id');
                $this->db->where('authcode.b_id !=',"");
                $this->db->group_by('account.a_id');
                $this->db->order_by('account.a_id','asc');
                $query = $this->db->get();
                break;
            case 'station':
                $this->db->select('account.name , booth.num,count(*) as count');
                $this->db->from('authcode');
                $this->db->join('booth','booth.b_id=authcode.b_id');
                $this->db->join('account','booth.a_id=account.a_id');
                $this->db->where('authcode.b_id !=',"");
                $this->db->where('account.username',$this->session->userdata('username'));
                $this->db->group_by('authcode.b_id');
                $this->db->order_by('authcode.b_id','asc');
                $query = $this->db->get();
                break;
            
            default:
                return FALSE;
                break;
        }
        if ($query->num_rows()==0) {
            return FALSE;
        }else{
            return $query->result();
        }

    }

    function remote_vote_assign_bid($authcode){

        $this->db->from('booth')->where('username','remote-1');
        $query = $this->db->get();
        if (!isset($query->row(1)->{'b_id'})) {
            log_message('error','please create station account "remote" , with 1 booth.');
            return 0;
        }
        $remote_b_id = $query->row(1)->{'b_id'};

        $data = array("b_id"=>$remote_b_id);

        $this->db->where('hash',sha1($authcode));
        $this->db->update('authcode' , $data);
    }

    function kick($b_id){
        // will add 100 to authcode's step and free the booth

        //get authcode from b_id
        $this->db->from('booth')->where('b_id',$b_id);
        $query = $this->db->get();
        if (!isset($query->row(1)->{'authcode'})) {
            log_message('error','kick booth not found');
            return 0;
        }
        $authcode = $query->row(1)->{'authcode'};

        //get step from authcode
        $this->db->from('authcode')->where('hash',sha1($authcode));
        $query = $this->db->get();
        if (!isset($query->row(1)->{'step'})) {
            log_message('error','kick booth not found');
            return 0;
        }
        $step = $query->row(1)->{'step'};

        //set step+=100
        $data = array("step"=>$step+100);
        $this->db->where('hash',sha1($authcode));
        $this->db->update('authcode',$data);

        //reset booth with free/authcode=null
        $data = array("status"=>"free" , "authcode"=>"");
        $this->db->where('b_id',$b_id);
        $this->db->update('booth',$data);
        log_message('debug' , 'kick authcode='.$authcode.' b_id='.$b_id);

           
    }

}

?>