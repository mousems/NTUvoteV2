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
				array_push($vote_count_title, $value->{'name'}.$value->{'num'}.'號機');
				array_push($vote_count_value, (int)$value->{'count'});
			}
		}

		$this->table->set_template($tmpl);

		$table = array(array("地點","一號平版","二號平版","三號平版","四號平版"));
		$tmp_aid = "start";
		$tmp_row = array();

		$boothlist = $this->vote_model->get_booth_status($this->session->userdata('a_id'));

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
				$location_name=$value->{'name'};
			}

			array_push($tmp_row, $this->status_to_button($value->{'status'},$value->{'a_id'},$value->{'lastseen'},$value->{'b_id'}));

			$tmp_aid=$value->{'a_id'};
		}
		if ($this->session->userdata('autoreload')=="true") {
			header('refresh: 5;url="/station/dashboard"');
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
					'location_name'=>$location_name,
					'autoreload_title'=>$autoreload_title,
					'announce_text'=>$this->config_lib->Get_COnfig("announce")
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	private function status_to_button($status,$a_id , $lastseen , $b_id){
		$html = "";
		if (date("U") - $lastseen > 60) {
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
	private function generateSiderArray($id){
		$id_mapping = array(
						'dashboard' => "Dashboard"
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
		redirect('station/','location');

	}
}
