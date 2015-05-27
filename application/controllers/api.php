<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/

	public function index()
	{
		$tmp = new stdClass();
		$tmp->{'status'} = "running";
		echo json_encode($tmp);
	}

	public function preg_match_every($patterns , $values)
	{
		// $parttens = array(pattern1 , pattern2 ...)
		// $values = array(value1 , value2 ...)
		//will check each patten map to value then return TRUE if all ok.
		if (count($patterns)!==count($values)) {
			return FALSE;
		}
		foreach ($patterns as $pkey => $pvalue) {
			if ($values[$pkey]===FALSE) {
				return FALSE;
			}

			if (preg_match($pvalue, $values[$pkey])!==1) {
				return FALSE;
			}
		}
		return TRUE;
	}

	public function vote($param)
	{
		$random_api_callid = $this->generateRandomString(12);
		log_message('info', 'apilog:vote/'.$param.' '.$random_api_callid.' '.json_encode($this->input->post()));
		$this->load->model("api_model");
		switch ($param) {
			case 'new':
				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]+$/" , 
									"/^\d+$/" , 
									"/^(.*)\-([A-Z0-9]{9})-([A-Z0-9]{9})-([A-Z0-9]{5})$/"
							),	
							array(
									$this->input->post("apikey"),
									$this->input->post("a_id"),
									$this->input->post("authcode")
								)
				);
				
				if ($check) {
					//check apikey
					if(!$this->api_model->vaild_apikey($this->input->post("apikey"))){
						$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"apikey wrong"));
						log_message('info', 'apilog:api response:'.$response);
						echo $response;
						http_response_code(400);
						return FALSE;
					}

					//check a_id
					if(!$this->api_model->vaild_a_id($this->input->post("a_id"))){
						$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"a_id wrong"));
						log_message('info', 'apilog:api response:'.$response);
						echo $response;
						http_response_code(400);
						return FALSE;
					}

					//check and get status of authcode
					$authcode_status = $this->authcode_lib->get_authcode_status($this->input->post("authcode"));
					if ($authcode_status==FALSE) {
						$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"authcode wrong"));
						log_message('info', 'apilog:api response:'.$response);
						echo $response;
						http_response_code(400);
						return FALSE;
					}


					//authcode b_id must be null
					if ($authcode_status->{'b_id'}!="") {
						$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"authcode step must 0"));
						log_message('info', 'apilog:api response:'.$response);
						echo $response;
						http_response_code(400);
						return FALSE;
					}

					//authcode step must be 0
					if ($authcode_status->{'step'}!=0) {
						$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"authcode step must 0"));
						log_message('info', 'apilog:api response:'.$response);
						echo $response;
						http_response_code(400);
						return FALSE;
					}

					// pickup a free booth
					$free_booth_num = $this->api_model->get_free_booth($this->input->post("a_id"));

					if ($free_booth_num==FALSE) {
						$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"there are no more online-booth-tablet"));
						log_message('info', 'apilog:api response:'.$response);
						echo $response;
						http_response_code(400);
						return FALSE;
					}
					
					// mapping authcode to booth

					$this->api_model->map_authcode_booth($this->input->post("a_id") ,$free_booth_num,$this->input->post("authcode"));

					
					$response = json_encode(array("status"=>"ok", "api_callid"=>$random_api_callid , "num"=>$free_booth_num));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					return TRUE;

				}else{
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"param miss or wrong format"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
				}
				break;
			
			default:
				$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"action missing"));
				log_message('info', 'apilog:api response:'.$response);
				echo $response;
				http_response_code(400);
				break;
		}


	}

	public function status($param="")
	{
		$random_api_callid = $this->generateRandomString(12);

		log_message('info', 'apilog:status/'.$param.' '.$random_api_callid.' '.json_encode($this->input->post()));
		$this->load->model("api_model");
		$this->load->library('user');
		switch ($param) {
			case 'booth':

				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]+$/"							
								),	
							array(
									$this->input->post("apikey")
								)
				);

				//check apikey
				if(!$this->api_model->vaild_apikey($this->input->post("apikey"))){
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"apikey wrong"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}
				if (!$check) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"param miss or wrong format"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}


				$station_list = $this->api_model->get_station_list();
				if (!$station_list) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"DB error"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}
				$result = array();
				foreach ($station_list as $key => $value) {
					$tmp = new stdClass();
					$tmp->{'a_id'} = $value->{'a_id'};
					$tmp->{'name'} = $value->{'name'};
					$tmp->{'tablet_count'} = $value->{'boothcount'};
					array_push($result, $tmp);
				}
				$response = json_encode(array("status"=>"ok", "api_callid"=>$random_api_callid ,"list"=>$result));
				log_message('info', 'apilog:api response:'.$response);
				echo $response;
				break;
			case 'ping':
				$check = $this->preg_match_every(
							array(
									"/^\d+$/"							
								),	
							array(
									$this->input->post("b_id")
								)
				);
				if (!$check) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"param miss or wrong format"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}

				$return = $this->user->update_lastseen($this->input->post("b_id"));
				if ($return) {
					$response = json_encode(array("status"=>"ok", "api_callid"=>$random_api_callid));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
				}else{
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"DB error"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;

				}
				break;

			case 'tablet_status':
				$check = $this->preg_match_every(
							array(
									"/^\d+$/",
									"/^\d$/"
								),	
							array(
									$this->input->post("a_id"),
									$this->input->post("num")
								)
				);
				if (!$check) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"param miss or wrong format"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}
				$result = $this->api_model->get_booth_status($this->input->post("a_id"),$this->input->post("num"));

				if ($result===FALSE) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"DB error"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}else{
					$response = json_encode(array("status"=>"ok", "api_callid"=>$random_api_callid,"result"=>$result->{'status'},"b_id"=>$result->{'b_id'}));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;

				}


				break;

			default:

				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]+$/"
								),	
							array(
									$this->input->post("apikey")
								)
				);

				if (!$check) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"param miss or wrong format"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}
				//check apikey
				if(!$this->api_model->vaild_apikey($this->input->post("apikey"))){
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"apikey wrong"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}
				$response = json_encode(array("status"=>"ok", "api_callid"=>$random_api_callid,"vote_range"=>array("start"=>0,"end"=>2147483647)));
				log_message('info', 'apilog:api response:'.$response);
				echo $response;
				break;
		}

	}

	public function account($param)
	{
		$random_api_callid = $this->generateRandomString(12);

		log_message('info', 'apilog:account/'.$param.' '.$random_api_callid.' '.json_encode($this->input->post()));
		$this->load->model("api_model");
		$this->load->library('user');
		switch ($param) {
			case 'login':

				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]+$/",
									"/^.+$/",
									"/^.+$/"						
								),	
							array(
									$this->input->post("apikey"),
									$this->input->post("username"),
									$this->input->post("password")
								)
				);

				//check apikey
				if(!$this->api_model->vaild_apikey($this->input->post("apikey"))){
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"apikey wrong"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}
				if (!$check) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"param miss or wrong format"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}



				$result = $this->user->valid_account("station",$this->input->post("username"),$this->input->post("password"),FALSE,FALSE);

				if ($result===FALSE) {
					$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"auth fail"));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;
					http_response_code(400);
					return FALSE;
				}else{
					$response = json_encode(array("status"=>"ok", "api_callid"=>$random_api_callid , "a_id"=>$result->{'a_id'} , "name"=>$result->{'name'}));
					log_message('info', 'apilog:api response:'.$response);
					echo $response;

				}
				break;
			
			default:
				$response = json_encode(array("status"=>"error", "api_callid"=>$random_api_callid , "message"=>"action missing"));
				log_message('info', 'apilog:api response:'.$response);
				echo $response;
				http_response_code(400);
				break;
		}
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
