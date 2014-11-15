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
		$this->load->model("api_model");
		switch ($param) {
			case 'new':
				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]{30}$/" , 
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
						echo json_encode(array("status"=>"error" , "message"=>"apikey wrong"));
						return FALSE;
					}

					//check a_id
					if(!$this->api_model->vaild_a_id($this->input->post("a_id"))){
						echo json_encode(array("status"=>"error" , "message"=>"a_id wrong"));
						return FALSE;
					}

					//check and get status of authcode
					$authcode_status = $this->authcode_lib->get_authcode_status($this->input->post("authcode"));
					if ($authcode_status==FALSE) {
						echo json_encode(array("status"=>"error" , "message"=>"authcode wrong"));
						return FALSE;
					}


					//authcode b_id must be null
					if ($authcode_status->{'b_id'}!="") {
						echo json_encode(array("status"=>"error" , "message"=>"authcode step must 0"));
						return FALSE;
					}

					//authcode step must be 0
					if ($authcode_status->{'step'}!=0) {
						echo json_encode(array("status"=>"error" , "message"=>"authcode step must 0"));
						return FALSE;
					}

					// pickup a free booth
					$free_booth_num = $this->api_model->get_free_booth($this->input->post("a_id"));

					if ($free_booth_num==FALSE) {
						echo json_encode(array("status"=>"error" , "message"=>"all booth tablet full"));
						return FALSE;
					}
					
					// mapping authcode to booth

					$this->api_model->map_authcode_booth($this->input->post("a_id") ,$free_booth_num,$this->input->post("authcode"));

					
					echo json_encode(array("status"=>"ok" , "num"=>$free_booth_num));
					return TRUE;

				}else{
					echo json_encode(array("status"=>"error" , "message"=>"param miss or wrong format"));
				}
				break;
			
			default:
				echo json_encode(array("status"=>"error"));
				break;
		}


	}

	public function status($param)
	{
		$this->load->model("api_model");
		$this->load->library('user');
		switch ($param) {
			case 'booth':

				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]{30}$/"							
								),	
							array(
									$this->input->post("apikey")
								)
				);
				if (!$check) {
					echo json_encode(array("status"=>"error" , "message"=>"param miss or wrong format"));
					return FALSE;
				}


				$station_list = $this->api_model->get_station_list();
				if (!$station_list) {
					echo json_encode(array("status"=>"error" , "message"=>"DB error"));
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
				echo json_encode(array("status"=>"ok" ,"list"=>$result));
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
					echo json_encode(array("status"=>"error" , "message"=>"param miss or wrong format"));
					return FALSE;
				}

				$return = $this->user->update_lastseen($this->input->post("b_id"));
				if ($return) {
					echo json_encode(array("status"=>"ok"));
				}else{
					echo json_encode(array("status"=>"error" , "message"=>"DB error"));
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
					echo json_encode(array("status"=>"error" , "message"=>"param miss or wrong format"));
					return FALSE;
				}
				$result = $this->api_model->get_booth_status($this->input->post("a_id"),$this->input->post("num"));

				if ($result===FALSE) {
					echo json_encode(array("status"=>"error" , "message"=>"DB error"));
					return FALSE;
				}else{
					echo json_encode(array("status"=>"ok","result"=>$result->{'status'},"b_id"=>$result->{'b_id'}));

				}


				break;

			default:
				echo json_encode(array("status"=>"error" , "message"=>"param missing"));
				break;
		}

	}

	public function account($param)
	{
		$this->load->model("api_model");
		$this->load->library('user');
		switch ($param) {
			case 'login':

				$check = $this->preg_match_every(
							array(
									"/^[A-Za-z0-9]{30}$/",
									"/^.+$/",
									"/^.+$/"						
								),	
							array(
									$this->input->post("apikey"),
									$this->input->post("username"),
									$this->input->post("password")
								)
				);
				if (!$check) {
					echo json_encode(array("status"=>"error" , "message"=>"param miss or wrong format"));
					return FALSE;
				}



				$result = $this->user->valid_account("station",$this->input->post("username"),$this->input->post("password"),FALSE,FALSE);

				if ($result===FALSE) {
					echo json_encode(array("status"=>"error" , "message"=>"auth fail"));
					return FALSE;
				}else{
					echo json_encode(array("status"=>"ok" , "a_id"=>$result->{'a_id'} , "name"=>$result->{'name'}));

				}
				break;
			
			default:
				echo json_encode(array("status"=>"error" , "message"=>"param missing"));
				break;
		}
	}
}
