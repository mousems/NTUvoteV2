<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_lib {
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/
	

	private $db;

	function __construct()
	{

		$this->CI =& get_instance();




		$this->db = $this->CI->load->database('default', true);

	}






	function Get_Config($id)
	{
		$this->db->from('config')->where('id',$id);
		$query = $this->db->get();
		if ($query->num_rows()>0) {
			return $query->row(1)->{'value'};
		}else{
			return "";
		}

	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */