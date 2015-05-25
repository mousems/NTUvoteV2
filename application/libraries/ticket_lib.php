<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_lib {
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/
	


	function __construct()
	{

		$this->CI =& get_instance();

	}




	function Store_single($t_id , $selection)
	{
		if (preg_match("/^\d+$/", $t_id)!==1) {
			return FALSE;
		}

		// won't miss again :P
		if (preg_match("/^\d+$/", $selection)!==1) {
			$selection = 0;
		}

		$this->CI->load->helper('file');
		$filename = '/var/log/NTUticket/'.$t_id;
		

		if (get_file_info($filename)==FALSE) {
			$content = date("Y.m.d H:i")." ".$selection;
		}else{
			$content = "\n".date("Y.m.d H:i:s")." ".$selection;
		}
		

		if(!write_file($filename, $content,"a+")){
			return FALSE;
		}else{
			$path = "/var/log/NTUticket/"; 
			chdir($path);

			exec('git config user.email "mousems.kuo@gmail.com"');
			exec('git config user.name "NTUvoteV2"');
			exec(escapeshellcmd("git add $t_id"));  
			exec(escapeshellcmd("git commit -m'submit ticket by ".$ServerName." automatically , ".$t_id."-".$selection."'"));

			return TRUE;
		}
	}


	function Store_multiple($t_id , $vote_result)
	{


		
		$this->CI->load->helper('file');
		$filename = '/var/log/NTUticket/'.$t_id;
		
		foreach ($vote_result as $key => $value) {
			$content.="\n".date("Y.m.d H:i:s")." ".$t_id."-".$value->{'num'}.":".$value->{'opinion'};
		}


		if(!write_file($filename, $content,"a+")){
			return FALSE;
		}else{
			$path = "/var/log/NTUticket/"; 
			chdir($path);

			exec('git config user.email "mousems.kuo@gmail.com"');
			exec('git config user.name "NTUvoteV2"');
			exec(escapeshellcmd("git add $t_id"));  
			exec(escapeshellcmd("git commit -m'submit ticket by ".$ServerName." automatically , ".$t_id."'"));

			return TRUE;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */