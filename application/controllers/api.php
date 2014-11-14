<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index()
	{
		$tmp = new stdClass();
		$tmp->{'status'} = "running";
		echo json_encode($tmp);
	}

	public function preg_match_every($patterns , $values)
	{
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
		switch ($param) {
			case 'new':
				$check = $this->preg_match_every(
							array("/^.*$/" , "/^\d+$/" , "/^(.*)\-([A-Z0-9]{9})-([A-Z0-9]{9})-([A-Z0-9]{5})$/") ,
							array(
									$this->input->post("apikey"),
									$this->input->post("a_id"),
									$this->input->post("authcode")
								)
				);
				
				if ($check) {
					print_r($this->input->post());
				}else{
					echo json_encode(array("status"=>"error" , "message"=>"param miss or wrong format"));
				}
				break;
			
			default:
				echo json_encode(array("status"=>"error"));
				break;
		}


	}

	public function multiple()
	{
		$this->load->view('/vote/multiple');
	}

	public function done()
	{
		$this->load->view('/vote/done');
	}
}
