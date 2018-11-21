<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	
	function __construct()
    {
		parent::__construct();
		
		//If wanna specified who want to see this page
	}
	
	function index()
	{
		$user = $orm->user->include("pegawai")->getData(array("id_data" => "data"));

		$this->load->view('admin/admin_message');
	}

	function about()
	{
		$this->load->view('admin/admin_message');
	}
}
