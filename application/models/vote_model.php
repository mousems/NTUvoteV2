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
           'name' => base64_encode($location),
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
                $tmp->{'title1'} = base64_decode($value2->{'title1'});       
                $tmp->{'type'} = $value2->{'type'};

                array_push($t_id_array , $tmp);
            }


            $tmp = new stdClass();
            $tmp->{'l_id'} = $value->{'l_id'};
            $tmp->{'name'} = base64_decode($value->{'name'});
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
           'name' => base64_encode($name),
           'prefix' => $prefix
        );
        $this->db->insert('ballot_list', $data);


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