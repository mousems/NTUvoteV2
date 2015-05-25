<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Testvote extends CI_Controller {
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/

	function __construct()
	{

		parent::__construct();

		if (ENVIRONMENT=="production") {
			redirect('login', 'location');
		}
	}

	public function index()
	{
		$this->load->view('testvote/testvote',array("title_return"=>""));
	}
	public function do_submit()
	{
		$this->load->model('test_model');



		$authcode_plain = $this->test_model->get_unuse_authcode();
		$ballotname = $this->test_model->get_ballotlist(substr($authcode_plain, 0,2));
		


		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://ntuvote.org/api/vote/new");
        curl_setopt($ch, CURLOPT_POST, true); // enable POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, "apikey=123456789012345678901234567890&a_id=45&authcode=".$authcode_plain); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $curl_result = json_decode(curl_exec($ch)); 
        curl_close($ch);
        if (isset($curl_result->{'message'})){
        	if($curl_result->{'message'}=="there are no more online-booth-tablet") {
        		$result_string = "沒有待命的平版可以用惹。";
        	}else{
        		$result_string = $curl_result->{'message'};
        	}
        }else{
        	$result_string = $ballotname."安安，請到".$curl_result->{'num'}."號平版";
        }

        $this->load->view('testvote/testvote',array("title_return"=>$result_string));

	}
}
