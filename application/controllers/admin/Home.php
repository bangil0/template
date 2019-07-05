<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends MY_Controller
{

	function __construct()
	{
		parent::__construct();

		//If wanna specified who want to see this page
	}

	function index()
	{
		//Intialize variabel to store data
        $data_view = array();
		// $data_view['datefilter'] = true; if there are filter by date range

		//Generate View
		$this->uview->builder($data_view, 'home', 'admin');

		// $this->load->view('admin/admin_message');
	}

	function about()
	{
		$this->load->view('admin/admin_message');
	}
}
