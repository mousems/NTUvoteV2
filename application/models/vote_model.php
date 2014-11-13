<?php
class Vote_model extends CI_Model {

    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
    }
    
    function get_booth_status($a_id="")
    {
        $this->db->select('booth.a_id ,num ,status , account.name , lastseen')->from('booth');
        $this->db->join('account' , 'account.a_id=booth.a_id');
        if ($a_id!="") {
            $this->db->where('a_id' ,$a_id);
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

        $this->db->from('ballot_list');
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
        print_r($postvalue);
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


}

?>