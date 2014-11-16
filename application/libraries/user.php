<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User {
	private $db;
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/
	

	function __construct()
	{

		$this->CI =& get_instance();




		$this->db = $this->CI->load->database('default', true);

		//$this->valid_session();
	}


	// logintype = {all,admin,station,vote}
	public function valid_session($logintype = "all"){
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
				if ($this->CI->session->userdata('logintype') == $logintype || $logintype == "all") {
					return TRUE;
				}else{
					return FALSE;
				}
				
			}else{
				return FALSE;
			}

		}
	}

	public function update_lastseen($b_id)
	{
		$data = array(
			"lastseen"=>date("U")
		);
		if (preg_match("/^\d+$/", $b_id)!==1) {
			return FALSE;
		}
		$this->db->where('b_id',$b_id);
		$this->db->update('booth',$data);
		if ($this->db->affected_rows()>0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// return bool
	public function valid_account($login_type , $username , $password , $hashed = FALSE , $booleanreturn = TRUE){


		switch ($login_type) {
			case 'admin':
			case 'station':

				$this->db->from('account')->where('username',$username);
				$query = $this->db->get();
				$row = $query->row();
				if ($query->num_rows()==0) {
					return FALSE;
				}

				if ($hashed) {
					
					if ($row->{'password'} == md5($password.$row->{'salt'})) {
						switch ($booleanreturn) {
							case TRUE:
								
								$this->CI->session->set_userdata('logintype' , $row->{'rule'});
								$this->CI->session->set_userdata('username' , $username);
								$this->CI->session->set_userdata('a_id' , $row->{'a_id'});
								$this->CI->session->set_userdata('passen' , $password);
								return TRUE;

								break;
							case FALSE:
								$tmp = new stdClass();
								$tmp->{'a_id'} = $row->{'a_id'};
								$tmp->{'name'} = $row->{'name'};
								return $tmp;
								
								break;
							default:
								return FALSE;
								break;
						}
					}else{
						log_message('debug' , "password not match , hashed=T");
						return FALSE;
					}


				}else{
					if ($row->{'password'} == md5(md5($password).$row->{'salt'})) {
						switch ($booleanreturn) {
							case TRUE:
								$this->CI->session->set_userdata('logintype' , $row->{'rule'});
								$this->CI->session->set_userdata('username' , $username);
								$this->CI->session->set_userdata('passen' , md5($password));
								return TRUE;
							case FALSE:
								$tmp = new stdClass();
								$tmp->{'a_id'} = $row->{'a_id'};
								$tmp->{'name'} = $row->{'name'};
								return $tmp;
								break;
							default:
								return FALSE;
								break;
						}
					}else{
						log_message('debug' , $row->{'password'}."password not match , hashed=F");
						return FALSE;
					}

				}


				break;
			case 'vote':
				
				$this->db->from('booth')->where('username',$username);
				$query = $this->db->get();
				$row = $query->row();
				if ($query->num_rows()==0) {
					return FALSE;
				}

		        $this->db->from('account')->where('a_id',$row->{'a_id'});
		        $query2 = $this->db->get();
		        if ($query2->num_rows()>0) {
		        	$booth_name = $query2->row(1)->{'name'};
		        }
		        
		        $this->update_lastseen($row->{'b_id'});

				if ($hashed) {
					
					if ($row->{'password'} == md5($password.$username)) {
						$this->CI->session->set_userdata('booth_name' , $booth_name);
						$this->CI->session->set_userdata('logintype' , "vote");
						$this->CI->session->set_userdata('b_id' , $row->{'b_id'});
						$this->CI->session->set_userdata('username' , $username);
						$this->CI->session->set_userdata('passen' , $password);
						return TRUE;
					}else{
						log_message('debug' , "password not match , hashed=T");
						return FALSE;
					}


				}else{
					if ($row->{'password'} == md5(md5($password).$username)) {
						$this->CI->session->set_userdata('booth_name' , "booth_name");
						$this->CI->session->set_userdata('logintype' , "vote");
						$this->CI->session->set_userdata('b_id' , $row->{'b_id'});						
						$this->CI->session->set_userdata('username' , $username);
						$this->CI->session->set_userdata('passen' , md5($password));
						return TRUE;
					}else{
						log_message('debug' , $row->{'password'}."password not match , hashed=F");
						return FALSE;
					}

				}
				break;
			
			default:
				return FALSE;
				break;
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */