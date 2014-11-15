<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Station extends CI_Controller {
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/
	

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
