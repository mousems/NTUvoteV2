<?php
class Login_model extends CI_Model {

    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
    }
    
    function reg()
    {
        $data = array(
            'username'=>'mousems',
            'password'=>md5(md5("ntuvote!@#$%")."qweasdzxcqwe"),
            'salt'=>"qweasdzxcqwe",
            'name'=>base64_encode("MouseMs"),
            'rule'=>'admin'
        );
        $query = $this->db->insert('account',$data);

        $query = $this->db->get('account');
        print_r($query->result());

    }


}

?>