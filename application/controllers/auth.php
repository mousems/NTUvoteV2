<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
	/**
	* MIT License (MIT)
	* Copyright (c) 2016 MouseMs <mousems.kuo@gmail.com>
	* http://opensource.org/licenses/MIT
	* https://github.com/mousems/NTUVoteV2
	**/

	function __construct()
	{

		parent::__construct();

		$this->load->library(array('user'));

		if (!$this->user->valid_session('auth'))
		{
			redirect('login/logout', 'location');
		}

	}

	public function index()
	{
		$this->welcome();

	}

	public function test($student_id)
	{		
		$this->load->model('auth_core_model');
		echo $this->auth_core_model->get_stu_data($student_id);


	}
	public function welcome($message="")
	{

			switch ($message) {
				case 'student_notfound':
					$warning_html = '<div class="alert alert-warning" role="alert">學號錯誤。</div>';
					break;
				case 'already_vote':
					$warning_html = '<div class="alert alert-warning" role="alert">此學生已投過票。</div>';
					break;

				default:
					$warning_html = '';
					break;
			}
			$this->load->model('auth_core_model');


			$data = array(
					"voted_count"=>$this->auth_core_model->get_voted_people($this->session->userdata('a_id')),
					"boothname"=>$this->session->userdata('booth_name'),
					"warning_html"=>$warning_html,
					"title"=>$this->config_lib->Get_Config('title')					);
			$this->load->view('/auth/welcome' , $data);

	}

	public function auth_do(){
		// 確認是否重複投票，取得身份
		$this->load->model('auth_core_model');
		$this->load->model('vote_core_model');
		$student_id = $this->input->post('student_id');
		$student_id = strtoupper($student_id);
		log_message("debug","auth log auth_do ".$student_id." ".$this->session->userdata('a_id'));
		$return = $this->auth_core_model->whether_voted($student_id);

		if ($return === "student_notfound") {
			redirect('auth/welcome/student_notfound', 'location');
		}elseif ($return === "already_vote") {			
			redirect('auth/welcome/already_vote', 'location');
		}else{


			$ballot_list = array();

			$prefix_name = $this->auth_core_model->get_stu_data($student_id);
			if ($prefix_name !== FALSE) {
				$ballot_result = $this->vote_core_model->get_ballot_type_status_by_prefix($prefix_name[0]);
				$t_id_array = $ballot_result->{'t_id'};
				foreach ($t_id_array as $key => $value) {
					$ballot_list[] = $this->vote_core_model->get_ballot_type_status($value)->{'title1'};
				}
			}else{
				redirect('auth/welcome', 'location');
			}


			$data = array(
					"ticket_count"=>$ballot_result->{'count'},
					"ballot_list"=>$ballot_list,
					"dept_name"=>$return,
					"student_id"=>$this->input->post('student_id')
					);
			$this->load->view('/auth/authing' , $data);
		}

	}


	public function auth_vote_do()
	{
		// 確認取票並顯示票卷內容
		$this->load->model('auth_core_model');
		$this->load->model('vote_core_model');
		$student_id = $this->input->post('student_id');
		$student_id = strtoupper($student_id);

		log_message("debug","auth log auth_vote_do ".$student_id." ".$this->session->userdata('a_id'));
		if ($student_id!=="") {
				
			$return = $this->auth_core_model->whether_voted($student_id);

			if ($return === "student_notfound") {
				redirect('auth/welcome/student_notfound', 'location');
			}elseif ($return === "already_vote") {			
				redirect('auth/welcome/already_vote', 'location');
			}else{


				// 寫入資料庫
				$return = $this->auth_core_model->set_vote_step($student_id);

				if($return===true){

					$data = array(
						"student_id"=>$student_id
					);
					$this->load->view('/auth/done' , $data);
				}else{
					redirect('auth/welcome', 'location');
				}
			}# code...
		}


	}

	public function see_all_booth()
	{
		$this->load->model('auth_core_model');

		$return = $this->auth_core_model->get_all_people();

		$message = "";
		foreach ($return as $key => $value) {
			$message.=$value->{'name'}.":".$value->{'count'}."<br />";
		}

		$data = array(
				"voted_count"=>$this->auth_core_model->get_voted_people($this->session->userdata('a_id')),
				"boothname"=>$this->session->userdata('booth_name'),
				"warning_html"=>$message,
				"title"=>$this->config_lib->Get_Config('title')		
				);
		$this->load->view('/auth/welcome' , $data);
		
	}

}
