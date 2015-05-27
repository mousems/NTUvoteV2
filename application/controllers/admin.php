<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* MIT License (MIT)
* Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
* http://opensource.org/licenses/MIT
* https://github.com/mousems/NTUVoteV2
**/

class Admin extends CI_Controller {

	function __construct()
	{

		parent::__construct();

		$this->load->library(array('user'));

		if (!$this->user->valid_session('admin'))
		{
			redirect('login/logout', 'location');
		}

	}


	public function index()
	{
		$this->dashboard();
	}

	public function dashboard()
	{
		$pageid = "dashboard";




		$this->load->model('vote_model');
		$this->load->library('table');

		$tmpl = array (
		                    'table_open'          => '<table class="table table-striped">',

		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',

		                    'row_start'           => '<tr>',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',

		                    'row_alt_start'       => '<tr>',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',

		                    'table_close'         => '</table>'
		              );

		$result = $this->vote_model->get_booths_vote_group_count_list();

		$vote_count_title = array();
		$vote_count_value = array();
		if ($result!==FALSE) {
			foreach ($result as $key => $value) {
				array_push($vote_count_title, $value->{'name'});
				array_push($vote_count_value, (int)$value->{'count'});
			}
		}

		$this->table->set_template($tmpl);

		$table = array(array("地點","一號平版","二號平版","三號平版","四號平版"));
		$tmp_aid = "start";
		$tmp_row = array();

		$boothlist = $this->vote_model->get_booth_status();

		array_push($boothlist , "end");

		foreach ($boothlist as $key => $value) {

			if ($value=="end") {

				for ($i=0; $i < 6-count($tmp_row); $i++) { 
					array_push($tmp_row, "-");
				}

				array_push($table, $tmp_row);
				break;
			}

			if ($value->{'a_id'}!=$tmp_aid) {
				if ($tmp_aid!="start") {

					for ($i=0; $i < 6-count($tmp_row); $i++) { 
						array_push($tmp_row, "-");
					}

					array_push($table, $tmp_row);
				}
				$tmp_row=array($value->{'name'});
			}

			array_push($tmp_row, $this->status_to_button($value->{'status'},$value->{'a_id'},$value->{'lastseen'},$value->{'b_id'}));

			$tmp_aid=$value->{'a_id'};
		}
		if ($this->session->userdata('autoreload')=="true") {
			header('refresh: 5;url="/admin/dashboard"');
			$autoreload_title = "關閉自動重整功能";
		}else{
			$autoreload_title = "啟動自動重整功能";
		}
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'booth_table'=>$this->table->generate($table),
					'vote_count_title'=>$vote_count_title,
					'vote_count_value'=>$vote_count_value,
					'location_name'=>"管理員",
					'autoreload_title'=>$autoreload_title,
					'announce_text'=>$this->config_lib->Get_COnfig("announce")
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	private function status_to_button($status,$a_id , $lastseen , $b_id){
		$html = "";
		if (date("U") - $lastseen > 120) {
			$html = '<span class="label label-danger">離線</span>';
		}else{

			switch ($status) {
				case 'lock':
					$html = '<span class="label label-warning">投票中</span>';
					break;

				case 'free':
					$html = '<span class="label label-success">待命中</span>'.(date("U")-$lastseen).'秒前';
					break;
				
				
				default:
					$html = '<span class="label label-danger">離線</span>';
					break;
			}

		}

		return $html;
	}


	public function account()
	{
		$pageid = "account";






		$this->load->model('vote_model');
		$this->load->library('table');

		$tmpl = array (
		                    'table_open'          => '<table class="table table-striped">',

		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',

		                    'row_start'           => '<tr>',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',

		                    'row_alt_start'       => '<tr>',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',

		                    'table_close'         => '</table>'
		              );

		$this->table->set_template($tmpl);

		$table = array(array("地點名稱","帳號","平版狀態","操作"));
		$tmp_row = array();

		$query_result = $this->vote_model->get_account_list();

		foreach ($query_result as $key => $value) {
			array_push($table , array(
										$value->{'name'} , 
										$value->{'username'} , 
										$value->{'boothcount'} , 
										'<button class="btn btn-danger" onclick="javascript:location.href=\''.base_url('/admin/account_del/'.$value->{'a_id'}).'\';">刪除</span>'
									)
			);
		}



		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'account_table'=>$this->table->generate($table)
					);
		$this->load->view('admin/'.$pageid , $data);
	}


	public function account_del($a_id)
	{

		$this->load->model('vote_model');

		$this->vote_model->del_account($a_id);
		redirect("/admin/account" , "location");
	}

	public function account_new()
	{
		$pageid = "account_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function account_new_do()
	{

		$this->load->model('vote_model');

		if($this->input->post('location')==""){
			$content = '<span class="label label-danger">錯誤</span>地點不得為空';
		}elseif($this->input->post('username')==""){
			$content = '<span class="label label-danger">錯誤</span>帳號不得為空';
		}elseif($this->input->post('password')==""){
			$content = '<span class="label label-danger">錯誤</span>密碼不得為空';
		}elseif(preg_match("([1234])",$this->input->post('boothcount'))!==1){
			$content = '<span class="label label-danger">錯誤</span>數量錯誤';
		}else{

			$query_result = $this->vote_model->add_account(
													$this->input->post('location') , 
													$this->input->post('username') , 
													$this->input->post('password') , 
													$this->input->post('boothcount')
													);

		}



		$this->load->library('table');

		$tmpl = array (
		                    'table_open'          => '<table class="table table-striped">',

		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',

		                    'row_start'           => '<tr>',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',

		                    'row_alt_start'       => '<tr>',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',

		                    'table_close'         => '</table>'
		              );

		$this->table->set_template($tmpl);

		$table = array(array("票亭名稱","票亭帳號","票亭密碼","平版帳號","平版密碼"));		
		foreach ($query_result as $key => $value) {
			array_push($table , array(
										$this->input->post('location') , 
										$this->input->post('username'),
										"********",
										$this->input->post('username')."-".$key , 
										$value
									)
			);
		}

		$content = "<p>您成功新增了票亭帳號，並產生".$this->input->post("boothcount")."個平板帳號，這些平板的帳密如下</p>";
		$content .= $this->table->generate($table);

		$pageid = "account_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'result_title'=>"票亭新增結果",
					'content'=>$content
					);
		$this->load->view('admin/result' , $data);
	}

	public function ballot_list()
	{




		$this->load->model('vote_model');
		$this->load->library('table');


		$query_result = $this->vote_model->get_ballot_list();



		$tmpl = array (
		                    'table_open'          => '<table class="table table-striped">',

		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',

		                    'row_start'           => '<tr>',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',

		                    'row_alt_start'       => '<tr>',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',

		                    'table_close'         => '</table>'
		              );

		$this->table->set_template($tmpl);

		$table = array(array("票別名稱","授權碼前綴","對應票種".'<span class="label label-primary">多數決</span><span class="label label-info">正副多數決</span><span class="label label-success">正反決</span><span class="label label-warning">正副正反決</span>',"操作"));		

		foreach ($query_result as $key => $value) {
			$mapping_html = "";
			foreach ($value->{'t_arr'} as $key2 => $value2) {
				switch ($value2->{'type'}) {
					case 'single':
						$mapping_html .= '<span class="label label-primary">'.$value2->{'title1'}.'</span>';
						break;
					case 'many_single':
						$mapping_html .= '<span class="label label-info">'.$value2->{'title1'}.'</span>';
						break;
					case 'many_multiple':
						$mapping_html .= '<span class="label label-warning">'.$value2->{'title1'}.'</span>';
						break;
					case 'multiple':
						$mapping_html .= '<span class="label label-success">'.$value2->{'title1'}.'</span>';
						break;
					
				}
			}

			array_push($table , array(
										$value->{'name'}, 
										$value->{'prefix'} ,
										$mapping_html ,
										'<button class="btn btn-warning" onclick="javascript:location.href=\''.base_url('/admin/mapping/'.$value->{'l_id'}).'\';">編輯關聯</span><button class="btn btn-danger" onclick="javascript:location.href=\''.base_url('/admin/ballot_list_del/'.$value->{'l_id'}).'\';">刪除</span>'
									)
			);
		}


		$pageid = "ballot_list";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'ballot_list_table' => $this->table->generate($table)
					);
		$this->load->view('admin/'.$pageid , $data);
	}
	public function ballot_list_del($l_id)
	{

		$this->load->model('vote_model');

		$this->vote_model->del_ballot_list($l_id);
		redirect("/admin/ballot_list" , "location");


	}
	public function ballot_list_new()
	{
		$pageid = "ballot_list_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function ballot_list_new_do()
	{
		$this->load->model('vote_model');

		if($this->input->post('name')==""){
			$content = '<span class="label label-danger">錯誤</span>票別名稱不得為空';
		}elseif($this->input->post('prefix')==""){
			$content = '<span class="label label-danger">錯誤</span>授權碼前綴不得為空';
		}else{

			$query_result = $this->vote_model->add_ballot_list(
													$this->input->post('name') , 
													$this->input->post('prefix')
													);
			redirect("admin/ballot_list" , "location");
		}


		$pageid = "account_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'result_title'=>"票亭新增結果",
					'content'=>$content
					);
		$this->load->view('admin/result' , $data);
	}

	public function ballot_type()
	{




		$this->load->model('vote_model');
		$this->load->library('table');


		$query_result = $this->vote_model->get_ballot_type_list();



		$tmpl = array (
		                    'table_open'          => '<table class="table table-striped">',

		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',

		                    'row_start'           => '<tr>',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',

		                    'row_alt_start'       => '<tr>',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',

		                    'table_close'         => '</table>'
		              );

		$this->table->set_template($tmpl);

		$table = array(array("票種標題1","票種標題2","投票類型","操作"));		

		foreach ($query_result as $key => $value) {

			

			switch ($value->{'type'}) {
				case 'single':
					$mapping_html = '<span class="label label-primary">多數決</span>';
					break;
				
				case 'many_single':
					$mapping_html = '<span class="label label-info">正副多數決</span>';
					break;

				case 'many_multiple':
					$mapping_html = '<span class="label label-warning">正副正反決</span>';
					break;
				case 'multiple':
					$mapping_html = '<span class="label label-success">正反決</span>';
					break;
					
			}

			array_push($table , array(
										$value->{'title1'}, 
										$value->{'title2'}, 
										$mapping_html,
										'<button class="btn btn-danger" onclick="javascript:location.href=\''.base_url('/admin/ballot_type_del/'.$value->{'t_id'}).'\';">刪除</span>'
									)
			);
		}



		$pageid = "ballot_type";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'ballot_type_table'=>$this->table->generate($table)
					);
		$this->load->view('admin/'.$pageid , $data);
	}
	public function ballot_type_del($t_id){

		$this->load->model('vote_model');

		$this->vote_model->del_ballot_type($t_id);
		redirect("/admin/ballot_type" , "location");

	}
	public function ballot_type_new()
	{
		$pageid = "ballot_type_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}


	public function ballot_type_new_do()
	{
		$this->load->model('vote_model');

		if($this->input->post('title1')==""){
			$content = '<span class="label label-danger">錯誤</span>票種標題1不得為空';
		}elseif($this->input->post('title2')==""){
			$content = '<span class="label label-danger">錯誤</span>票種標題2不得為空';
		}elseif($this->input->post('type')!="single" && $this->input->post('type')!="multiple"){
			$content = '<span class="label label-danger">錯誤</span>投票類型錯誤';
		}else{

			$query_result = $this->vote_model->add_ballot_type(
													$this->input->post('title1') , 
													$this->input->post('title2') , 
													$this->input->post('type')
													);
			redirect("admin/ballot_type" , "location");
		}


		$pageid = "account_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'result_title'=>"票亭新增結果",
					'content'=>$content
					);
		$this->load->view('admin/result' , $data);
	}

	public function candidate()
	{



		$this->load->model('vote_model');
		$this->load->library('table');


		$query_result = $this->vote_model->get_candidate_list();



		$tmpl = array (
		                    'table_open'          => '<table class="table table-striped">',

		                    'heading_row_start'   => '<tr>',
		                    'heading_row_end'     => '</tr>',
		                    'heading_cell_start'  => '<th>',
		                    'heading_cell_end'    => '</th>',

		                    'row_start'           => '<tr>',
		                    'row_end'             => '</tr>',
		                    'cell_start'          => '<td>',
		                    'cell_end'            => '</td>',

		                    'row_alt_start'       => '<tr>',
		                    'row_alt_end'         => '</tr>',
		                    'cell_alt_start'      => '<td>',
		                    'cell_alt_end'        => '</td>',

		                    'table_close'         => '</table>'
		              );

		$this->table->set_template($tmpl);

		$table = array(array("候選人票種".'<span class="label label-primary">多數決</span><span class="label label-info">正副多數決</span><span class="label label-success">正反決</span><span class="label label-warning">正副正反決</span>',"候選人編號","姓名","照片","操作"));		

		foreach ($query_result as $key => $value) {

			

			switch ($value->{'type'}) {
				case 'single':
					$mapping_html = '<span class="label label-primary">'.$value->{'title1'}.'</span><span class="label label-default">多數決</span>';
					break;
				case 'many_single':
					$mapping_html = '<span class="label label-info">'.$value->{'title1'}.'</span><span class="label label-default">正副多數決</span>';
					break;
				case 'many_multiple':
					$mapping_html = '<span class="label label-warning">'.$value->{'title1'}.'</span><span class="label label-default">正副正反決</span>';
					break;
				
				case 'multiple':
					$mapping_html = '<span class="label label-success">'.$value->{'title1'}.'</span><span class="label label-default">正反決</span>';
					break;
					
			}

			if (preg_match("/(.+),(.+)/", $value->{'img'},$matches)===1) {
				$img_html = "<img src='".$matches[1]."' height='150px'/>";
				$img_html .= "<img src='".$matches[2]."' height='150px'/>";

			}else{
				$img_html = "<img src='".$value->{'img'}."' height='150px'/>";
			}

			array_push($table , array(
										$mapping_html,
										$value->{'num'}, 
										$value->{'name'}, 
										$img_html, 
										'<button class="btn btn-danger" onclick="javascript:location.href=\''.base_url('/admin/candidate_del/'.$value->{'c_id'}).'\';">刪除</span>'
									)
			);
		}







		$pageid = "candidate";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'candidate_table'=>$this->table->generate($table)
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function candidate_del($c_id)
	{
		$this->load->model('vote_model');

		$this->vote_model->del_candidate($c_id);
		redirect("/admin/candidate" , "location");

	}

	public function candidate_new()
	{



		$this->load->model('vote_model');
		$this->load->library('table');


		$query_result = $this->vote_model->get_ballot_type_list();

		$html_ballottype="";

		foreach ($query_result as $key => $value) {
			$html_ballottype.='<option value="'.$value->{'t_id'}.'">'.$value->{'title1'}.'</option>';
		}




		
		$pageid = "candidate_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'html_ballottype'=>$html_ballottype
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function candidate_new_do()
	{
		$this->load->model('vote_model');
		$this->load->model('vote_core_model');
		$ballot_type_status = $this->vote_core_model->get_ballot_type_status($this->input->post('t_id'));
		var_dump($ballot_type_status);
		if($this->input->post('name')==""){
			$content = '<span class="label label-danger">錯誤</span>候選人姓名不得為空';
		}elseif($this->input->post('num')==""){
			$content = '<span class="label label-danger">錯誤</span>候選人編號不得為空';
		}elseif($this->input->post('img')=="" && $ballot_type_status->{'type'}!='many'){
			$content = '<span class="label label-danger">錯誤</span>候選人照片連結不得為空';
		}else{

			$query_result = $this->vote_model->add_candidate(
													$this->input->post('name') , 
													$this->input->post('num') ,
													$this->input->post('img') ,
													$this->input->post('t_id')
													);
			redirect("admin/candidate" , "location");
		}


		$pageid = "candidate_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'result_title'=>"候選人新增結果",
					'content'=>$content
					);
		$this->load->view('admin/result' , $data);
	}



	public function mapping($l_id="")
	{
		if ($l_id == "") {
			redirect("/admin/ballot_list" , "location");
		}

		$this->load->model('vote_model');

		$ballot_list_name = $this->vote_model->get_ballot_list_by_l_id($l_id);
		$ballot_list_name = $ballot_list_name[0]->{'name'};



		$ballot_type_list = $this->vote_model->get_ballot_type_assign_status($l_id);

		$mapping_html = "";
		foreach ($ballot_type_list as $key => $value) {
			
			switch ($value->{'assign'}) {
				case 'true':
					$mapping_html .= "<label><input type='checkbox' id='".$value->{'t_id'}."' name='".$value->{'t_id'}."' value='true' checked>";
					break;
				
				case 'false':
					$mapping_html .= "<label><input type='checkbox' id='".$value->{'t_id'}."' name='".$value->{'t_id'}."' value='true'>";
					break;
					
			}
			switch ($value->{'type'}) {
				case 'single':
					$mapping_html .= '<span class="label label-primary">'.$value->{'title1'}.'</span></label><br />';
					break;
				case 'many_single':
					$mapping_html .= '<span class="label label-info">'.$value->{'title1'}.'</span></label><br />';
					break;
				case 'many_multiple':
					$mapping_html .= '<span class="label label-warning">'.$value->{'title1'}.'</span></label><br />';
					break;
				case 'multiple':
					$mapping_html .= '<span class="label label-success">'.$value->{'title1'}.'</span></label><br />';
					break;
					
			}

		}


		$pageid = "mapping";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'ballot_list_name'=>$ballot_list_name,
					'mapping_html'=>$mapping_html,
					'l_id'=>$l_id
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function mapping_do()
	{

		$this->load->model('vote_model');
		$this->vote_model->mapping_do($this->input->post());

		redirect("admin/ballot_list" , "location");

	}
	public function setting()
	{
		$pageid = "setting";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid,
					'announce_text'=>$this->config_lib->Get_Config("announce")
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function setting_do($action)
	{
		switch ($action) {
			case 'setannounce':
				$remote_account_pass = $this->config_lib->Set_Config("announce",$this->input->post("announce"));
				redirect("/admin/setting","location");
				break;
			
			default:
				# code...
				break;
		}
	}
	public function authcode_gen(){
		$this->load->model('vote_model');

		$authcode = $this->vote_model->generate_authcode($this->input->post("count"));



		header('Content-type: text/csv');
		header('Content-Disposition: attachment; filename="authcode.csv"');

		foreach ($authcode as $key => $value) {
			echo $value->{'plain'}."\n";
		}


	}

	private function generateSiderArray($id){
		$id_mapping = array(
						'dashboard' => "Dashboard",
						'account' => "票亭管理",
						'account_new' => ">>票亭新增",
						'ballot_list' => "票別管理",
						'ballot_list_new' => ">>票別新增",
						'ballot_type' => "票種管理",
						'ballot_type_new' => ">>票種新增",
						'candidate' => "候選人管理",
						'candidate_new' => ">>候選人新增",
						'setting' => "系統設定"
							 );

		//remove _new from $id
		if (preg_match("/(\w+)_new/", $id , $matches)===1) {
			$id = $matches[1];
		}

		//remove all *_new element except itself
		foreach ($id_mapping as $key => $value) {
			if (preg_match("/(\w+)_new/", $key)===1 && $key!=$id."_new") {
				unset($id_mapping[$key]);
			}
		}

		return $id_mapping;

	}

	public function kick($b_id){
		$this->load->model("vote_model");
		$this->vote_model->kick($b_id);
		redirect('admin/','location');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */