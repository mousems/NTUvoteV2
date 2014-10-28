<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->dashboard();
	}

	public function dashboard()
	{
		$pageid = "dashboard";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function account()
	{
		$pageid = "account";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
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

	public function ballot_list()
	{
		$pageid = "ballot_list";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
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

	public function ballot_type()
	{
		$pageid = "ballot_type";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
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

	public function candidate()
	{
		$pageid = "candidate";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function candidate_new()
	{
		$pageid = "candidate_new";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function mapping()
	{
		$pageid = "mapping";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
	}

	public function setting()
	{
		$pageid = "setting";
		$data = array(
					'sider_array'=>$this->generateSiderArray($pageid),
					'pageid'=>$pageid
					);
		$this->load->view('admin/'.$pageid , $data);
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
						'mapping' => "票種關連設定",
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */