<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	public function index()
	{
		$tmp = new stdClass();
		$tmp->{'status'} = "running";
		echo json_encode($tmp);
	}


	public function single($authcode)
	{
		$this->load->view('/vote/single');

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
