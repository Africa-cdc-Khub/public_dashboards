<?php

use utils\HttpUtil;
defined('BASEPATH') or exit('No direct script access allowed');

class Jobs extends MX_Controller
{


	public  function __construct()
	{
		parent::__construct();

		$this->load->model("jobs_mdl", 'jobs_mdl');
	}

	public function index()
	{
		echo "DASHBOARD API";
	}
	public function fetch_data()
    {

        $http = new HttpUtil();
        $headr = array();
        $headr[] = 'Content-length: 0';
        $headr[] = 'Content-type: application/json';
 
        $endpoint = 'mpox_data/api/mpox/mpox_cases_dates';

        $response = $http->curlgetHttp($endpoint, $headr, []);
		$data = $response;
		dd($data);
    }
	function fetch_orgunits()
	{
		// Base URL for the API endpoint
		$baseUrl = 'https://hmis.health.go.ug/api/organisationUnits';

		// Initial URL to fetch the first page
		$url = $baseUrl . '?fields=id,name,geometry,parent[id,name,parent[id,name,parent[id,name]]]&level=5&paging=false';

		// Initialize the data array
		$allData = array();
		// $headr[] = 'Content-length: 0';
		// $headr[] = 'Content-type: application/json';

			// Fetch data from the current URL
		$data = $this->curlgetHttp($url,$headr=[],'moh-ict.aagaba','Agaba@432');

		$csvFile = 'organisation_units.csv';
		$organisationUnits = $data->organisationUnits;
		foreach ($organisationUnits as $organisationUnit):
			$csv['facility_id'] = $organisationUnit->id;
		    $csv['facility'] = $organisationUnit->name;
		    $csv['latitude'] = $organisationUnit->geometry->coordinates[1];
		    $csv['longitude'] = $organisationUnit->geometry->coordinates[0];
		    $csv['subcounty_id'] = $organisationUnit->parent->id;
		    $csv['subcounty'] = $organisationUnit->parent->name;
		    $csv['district_id'] = $organisationUnit->parent->parent->id;
	     	$csv['district_name'] = $organisationUnit->parent->parent->name;
			$csv['region_id'] = $organisationUnit->parent->parent->parent->id;
			$csv['region_name'] = $organisationUnit->parent->parent->parent->name;
			array_push($allData, $csv);
		endforeach;
		render_csv_data($allData, $csvFile);
	}



}
