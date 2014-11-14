<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authcode_lib {
	private $db;

	function __construct()
	{

		$this->CI =& get_instance();
		$this->db = $this->CI->load->database('default', true);

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


        $this->db->select("hash ,prefix , step , b_id")->from('authcode')->where('hash' , sha1($authcode));
        $query = $this->db->get();

        if($query->num_rows()==0){
            return FALSE;
        }else{
            return $query->row(1);
        }
        
    }


}
