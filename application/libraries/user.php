<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User {
	private $db;

	function __construct()
	{

		$this->CI =& get_instance();




		$this->db = $this->CI->load->database('default', true);

		//$this->valid_session();
	}


	public function valid_session(){
		if ($this->CI->session->userdata('logintype')==FALSE) {
			return FALSE;
		}else{

			if ($this->valid_account(
					$this->CI->session->userdata('logintype'),
					$this->CI->session->userdata('username'),
					$this->CI->session->userdata('passen'),
					TRUE
				) //login test
			) {
				return TRUE;
			}else{
				return FALSE;
			}

		}
	}



	// return bool
	public function valid_account($login_type , $username , $password , $hashed = FALSE){


		switch ($login_type) {
			case 'admin':
			case 'station':

				$this->db->from('account')->where('username',$username);
				$query = $this->db->get();
				$row = $query->row();
				if ($query->num_rows()==0) {
					log_message('debug' , "num_rows = 0");
					return FALSE;
				}

				if ($hashed) {
					
					if ($row->{'password'} == md5($password.$row->{'salt'})) {
						$this->CI->session->set_userdata('logintype' , $row->{'rule'});
						$this->CI->session->set_userdata('username' , $username);
						$this->CI->session->set_userdata('passen' , $password);
						return TRUE;
					}else{
						log_message('debug' , "password not match , hashed=T");
						return FALSE;
					}


				}else{
					if ($row->{'password'} == md5(md5($password).$row->{'salt'})) {
						$this->CI->session->set_userdata('logintype' , $row->{'rule'});
						$this->CI->session->set_userdata('username' , $username);
						$this->CI->session->set_userdata('passen' , md5($password));
						return TRUE;
					}else{
						log_message('debug' , $row->{'password'}."password not match , hashed=F");
						return FALSE;
					}

				}


				break;
			case 'vote':
				# code...
				break;
			
			default:
				return FALSE;
				break;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */