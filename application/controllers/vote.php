<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vote extends CI_Controller {

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
				
				
				default:
					$warning_html = '';
					break;
			}

			$data = array(
					"boothname"=>$this->session->userdata('booth_name'),
					"boothnum"=>$matches[2],
					"warning_html"=>$warning_html
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


	public function voting($authcode)
	{
		$this->load->model('vote_core_model');
		$authcode_status = $this->vote_core_model->get_authcode_status($authcode);

		if ($authcode_status==FALSE) {
			redirect('vote/welcome/authwrong', 'location');
		}else{
			$type_status = $this->vote_core_model->get_ballot_type_status_by_prefix($authcode_status->{'prefix'});
			if ($authcode_status->{'step'}>=$type_status->{'count'}) {
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
								"title1"=>$ballot_type_status->{'title1'},
								"title2"=>$ballot_type_status->{'title2'},
								"candidate_list"=>$this->vote_core_model->get_candidate_list($ballot_type_status->{'t_id'})
								);
						$this->load->view('/vote/single' , $data);
						break;
					case 'multi':
						# code...
						break;
				}


			}
			
		}

		// $this->load->view('/vote/single');

	}

	public function multiple()
	{
		$this->load->view('/vote/multiple');
	}

	public function done()
	{
		if(preg_match("/^(.*)-([1-4])$/", $this->session->userdata('username'), $matches) === 1 ){

			$data = array(
					"boothname"=>$this->session->userdata('booth_name'),
					"boothnum"=>$matches[2]
					);
			$this->load->view('/vote/done' , $data);
		}else{
			redirect('login/logout', 'location');
		}

		
	}
}
