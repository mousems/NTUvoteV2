<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Station extends CI_Controller {

	public function index()
	{




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
