<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/
	

	public function index()
	{

		$this->load->library('user');

		if ($this->user->valid_session()) {
			switch ($this->session->userdata('logintype')) {
				case 'admin':
					redirect('admin', 'location');
					break;
				
				case 'station':
					redirect('station', 'location');
					break;
				
				case 'vote':
					redirect('vote', 'location');
					break;

				case 'auth':
					redirect('auth', 'location');
					break;
				
				default:
					$this->load->view('login');
					break;
			}
		}else{
			$this->load->view('login' , array("title"=>$this->config_lib->Get_Config('title')));
		}
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/" , "location");
	}
	public function autoreload()
	{
		if ($this->session->userdata('autoreload')=="true") {
			$this->session->set_userdata('autoreload',"false");
		}else{
			$this->session->set_userdata('autoreload',"true");
		}
		
		switch ($this->session->userdata('logintype')) {
			case 'admin':
				redirect('admin', 'location');
				break;
			
			case 'station':
				redirect('station', 'location');
				break;
			default:
				$this->logout();
				break;
		}
					

	}

	public function login_do()
	{
		$this->load->library('user');
		if ($this->user->valid_account(
					$this->input->post('logintype'),
					$this->input->post('username'),
					$this->input->post('password'),
					FALSE
				) //login test
			) {
				switch ($this->session->userdata('logintype')) {
					case 'admin':
						redirect('admin', 'location');
						break;
					
					case 'station':
						redirect('station', 'location');
						break;
					
					case 'vote':
						redirect('vote', 'location');
						break;

					case 'auth':
						redirect('auth', 'location');
						break;
					
					default:
						$this->logout();
						break;
				}
			}else{
				log_message('debug' , "hello");
				$this->logout();
			}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */