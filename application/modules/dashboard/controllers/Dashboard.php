<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MX_Controller
{


	public  function __construct()
	{
		parent::__construct();

		$this->dashmodule = "dashboard";
		$this->load->model("dashboard_mdl", 'dash_mdl');
	}

	public function index()
	{


		render('home', $data);
	}

}
