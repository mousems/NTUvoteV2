<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {
	/**
	* MIT License (MIT)
	* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/
	

	function __construct()
	{

		parent::__construct();

		$this->load->library(array('user'));

		if (!$this->user->valid_session('vote'))
		{
			redirect('login/logout', 'location');
		}

	}

	public function index()
	{
		$this->welcome();


	}
	public function welcome($message="")
	{
		
		if(preg_match("/^(.*)-([1-4])$/", $this->session->userdata('username'), $matches) === 1 ){

			switch ($message) {
				case 'authfail':
					$warning_html = '<div class="alert alert-warning" role="alert">沒有接收到授權碼。</div>';
					break;
				case 'authwrong':
					$warning_html = '<div class="alert alert-warning" role="alert">授權碼錯誤。</div>';
					break;
				case 'storeerror':
					$warning_html = '<div class="alert alert-warning" role="alert">儲存選票錯誤。</div>';
					break;
				
				
				default:
					$warning_html = '';
					break;
			}

			$data = array(
					"boothname"=>$this->session->userdata('booth_name'),
					"boothnum"=>$matches[2],
					"warning_html"=>$warning_html,
					"title"=>$this->config_lib->Get_Config('title'),
					'b_id'=>$this->session->userdata('b_id')
					);
			$this->load->view('/vote/welcome' , $data);
		}else{
			redirect('login/logout', 'location');
		}


	}

	public function vote_do(){
		// check authcode , step , controll vote page show
		$this->load->model('vote_core_model');
		$return = $this->vote_core_model->checkVoteStatus($this->session->userdata('username'));

		if ($return === FALSE) {
			redirect('vote/welcome/authfail', 'location');
		}else{
			redirect('vote/voting/'.$return, 'location');
		}
		
	}

	public function vote_store($authcode)
	{
		$this->load->model('vote_core_model');
		$this->load->model('api_model');
		$this->load->library('ticket_lib');
		$authcode_status = $this->authcode_lib->get_authcode_status($authcode);

		if ($authcode_status==FALSE) {
			$this->api_model->booth_free($authcode);
			redirect('vote/welcome/authwrong', 'location');
			return FALSE;
		}else{

				
			$type_status = $this->vote_core_model->get_ballot_type_status_by_prefix($authcode_status->{'prefix'});
			$t_id_array = $type_status->{'t_id'};
			$t_id = $t_id_array[$authcode_status->{'step'}];
			$ballot_type_status = $this->vote_core_model->get_ballot_type_status($t_id);

			if ($this->input->post("skipped")==="true") {
				$this->authcode_lib->plus_authcode($authcode);
				redirect('vote/voting/'.$authcode , 'location');
				return TRUE;
			}
			switch ($ballot_type_status->{'type'}) {
				case 'single':
				case 'many':
					if ($this->input->post('selection')==FALSE) {
						$selection = 0;
					}else{
						$selection = $this->input->post('selection');
					}
					$store_result = $this->ticket_lib->Store_single($t_id , $selection);
					break;
				
				case 'multiple':
					$vote_result = array();
					$candidate_list = $this->vote_core_model->get_candidate_list($t_id);
					foreach ($candidate_list as $key => $value) {
						$tmp = new stdClass;
						$tmp->{'num'} = $value->{'num'};

						switch ($this->input->post('opinion_to_'.$value->{'num'})) {
							case '1':
								$tmp->{'opinion'} = '1';
								break;
							
							case '0':
								$tmp->{'opinion'} = '0';
								break;
							
							case '-1':
								$tmp->{'opinion'} = '-1';
								break;
							
							default:
								$tmp->{'opinion'} = '0';
								break;
						}
						array_push($vote_result, $tmp);
					}

					$store_result = $this->ticket_lib->Store_multiple($t_id , $vote_result);
					break;
				default:
					redirect('vote/welcome/storeerror', 'location');
					return FALSE;
					break;
			}
			
			if ($store_result==TRUE) {
				$this->authcode_lib->plus_authcode($authcode);
				redirect('vote/voting/'.$authcode , 'location');
			}else{
				redirect('vote/welcome/storeerror', 'location');
			}
		}
		
	}

	public function voting($authcode)
	{
		$this->load->model('vote_core_model');
		$this->load->model('api_model');
		$authcode_status = $this->authcode_lib->get_authcode_status($authcode);

		if ($authcode_status==FALSE) {
			redirect('vote/welcome/authwrong', 'location');
		}else{
			$type_status = $this->vote_core_model->get_ballot_type_status_by_prefix($authcode_status->{'prefix'});
			if ($authcode_status->{'step'}>=$type_status->{'count'}) {
				$this->api_model->booth_free($authcode);
				redirect('vote/done', 'location');			
			}else{

				
				$t_id_array = $type_status->{'t_id'};
				$t_id = $t_id_array[$authcode_status->{'step'}]; // next to vote

				$ballot_type_status = $this->vote_core_model->get_ballot_type_status($t_id);
				


				preg_match("/^(.*)-([1-4])$/", $this->session->userdata('username'), $matches_username);

				switch ($ballot_type_status->{'type'}) {
					case 'single':
						
						$data = array(
								"boothname"=>$this->session->userdata('booth_name'),
								"boothnum"=>$matches_username[2],
								"title"=>$this->config_lib->Get_Config('title'),
								"title1"=>$ballot_type_status->{'title1'},
								"title2"=>$ballot_type_status->{'title2'},
								"step"=>$authcode_status->{'step'},
								"count"=>$type_status->{'count'},
								"candidate_list"=>$this->vote_core_model->get_candidate_list($ballot_type_status->{'t_id'}),
								"authcode"=>$authcode,
								"t_id"=>$t_id

								);
						$this->load->view('/vote/single' , $data);
						break;
					case 'multiple':
						$data = array(
								"boothname"=>$this->session->userdata('booth_name'),
								"boothnum"=>$matches_username[2],
								"title"=>$this->config_lib->Get_Config('title'),
								"title1"=>$ballot_type_status->{'title1'},
								"title2"=>$ballot_type_status->{'title2'},
								"step"=>$authcode_status->{'step'},
								"count"=>$type_status->{'count'},
								"candidate_list"=>$this->vote_core_model->get_candidate_list($ballot_type_status->{'t_id'}),
								"authcode"=>$authcode,
								"t_id"=>$t_id

								);
						$this->load->view('/vote/multiple' , $data);
						break;
					case 'many':
						$data = array(
								"boothname"=>$this->session->userdata('booth_name'),
								"boothnum"=>$matches_username[2],
								"title"=>$this->config_lib->Get_Config('title'),
								"title1"=>$ballot_type_status->{'title1'},
								"title2"=>$ballot_type_status->{'title2'},
								"step"=>$authcode_status->{'step'},
								"count"=>$type_status->{'count'},
								"candidate_list"=>$this->vote_core_model->get_candidate_list($ballot_type_status->{'t_id'}),
								"authcode"=>$authcode,
								"t_id"=>$t_id

								);
						$this->load->view('/vote/many' , $data);
						break;
				}


			}
			
		}



	}

	public function done()
	{
		if(preg_match("/^(.*)-([1-4])$/", $this->session->userdata('username'), $matches) === 1 ){

			$data = array(
					"boothname"=>$this->session->userdata('booth_name'),
					"boothnum"=>$matches[2],
					"title"=>$this->config_lib->Get_Config('title')
					);
			$this->load->view('/vote/done' , $data);
		}else{
			redirect('login/logout', 'location');
		}

		
	}
}
