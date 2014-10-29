<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->library('user');

		if ($this->user->valid_session()) {
			switch ($this->CI->session->userdata('logintype')) {
				case 'admin':
					redirect('admin', 'location');
					break;
				
				case 'station':
					redirect('station', 'location');
					break;
				
				case 'vote':
					redirect('vote', 'location');
					break;
				
				default:
					$this->load->view('login');
					break;
			}
		}else{
			$this->load->view('login');
		}
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect("/" , "location");
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