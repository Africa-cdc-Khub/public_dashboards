<?php
use Elastic\Elasticsearch\ClientBuilder;
use utils\HttpUtil;
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
	
	function fetch_dhis2data($uri)
	{

		$headr[] = 'Content-length: 0';
		// $headr[] = 'Content-type: application/json';
		$http = new HttpUtil();

			// Fetch data from the current URL
		$data = $http->curlgetHttpauth($uri,$headr=[],DHIS2_USERNAME,DHIS2_PASSWORD);
		//dd(DHIS2_USERNAME.''.''.DHIS2_PASSWORD);
	  return $data;
}
 public function dates_data(){
			// Base URL for the API endpoint
		//cases last 4 datews csv link
		$uri2 =  "https://ems.africacdc.org/api/analytics.json?dimension=dx%3ALU3aYsYN5C1%3BRAkL8FS7MUg%3BaX8O0TtqFEV&dimension=ou%3AynUPYzmA3Qx%3BlgF9DzO6BCC%3BR4VqRZJaDVG%3BtM0n92xvtsx%3BUzFdKL1DrLa%3BLEVEL-k0Ber6Navox&dimension=pe%3A2024W1%3B2024W2%3B2024W3%3B2024W4%3B2024W5%3B2024W6%3B2024W7%3B2024W8%3B2024W9%3B2024W10%3B2024W11%3B2024W12%3B2024W13%3B2024W14%3B2024W15%3B2024W16%3B2024W17%3B2024W18%3B2024W19%3B2024W20%3B2024W21%3B2024W22%3B2024W23%3B2024W24%3B2024W25%3B2024W26%3B2024W27%3B2024W28%3B2024W29%3B2024W30%3B2024W31%3B2024W32%3B2024W33%3B2024W34%3B2024W35%3B2024W36%3B2024W37%3B2024W38%3B2024W39%3B2024W40%3B2024W41%3B2024W42%3B2024W43%3B2024W44%3B2024W45%3B2024W46%3B2024W47%3B2024W48%3B2024W49%3B2024W50%3B2024W51%3B2024W52&tableLayout=true&columns=dx&rows=ou%3Bpe&skipRounding=false&completedOnly=false&hideEmptyColumns=true&hideEmptyRows=true";
		$data = $this->fetch_dhis2data($uri1);
		//dd($data);
		if(!empty($data->rows)){
			$this->db->truncate('mpox_cases_dates');
		}
		//dd($data);
		foreach($data->rows as $row):
			$data = array("organisationunitid" =>$row[0], "organisationunitname" =>$row[1], "organisationunitcode" =>$row[2], "periodid" =>$row[4], "periodname" =>$row[5], "periodcode" =>$row[6], "Confirmed_Mpox_Cases" =>$row[9], "Mpox_Deaths" =>$row[10], "Suspected_Mpox_Cases" =>$row[11]);
	
		
			$this->db->insert('mpox_cases_dates', $data);
		
		
		endforeach;
		echo $this->db->affected_rows();
 }
 public function last_weeks_data(){
	//mpox_cases_week.csv
	$uri2 = "https://ems.africacdc.org/api/analytics.json?dimension=dx%3ALU3aYsYN5C1%3BRAkL8FS7MUg%3BaX8O0TtqFEV&dimension=ou%3AynUPYzmA3Qx%3BlgF9DzO6BCC%3BR4VqRZJaDVG%3BtM0n92xvtsx%3BUzFdKL1DrLa%3BLEVEL-k0Ber6Navox&dimension=pe%3A2024W1%3B2024W2%3B2024W3%3B2024W4%3B2024W5%3B2024W6%3B2024W7%3B2024W8%3B2024W9%3B2024W10%3B2024W11%3B2024W12%3B2024W13%3B2024W14%3B2024W15%3B2024W16%3B2024W17%3B2024W18%3B2024W19%3B2024W20%3B2024W21%3B2024W22%3B2024W23%3B2024W24%3B2024W25%3B2024W26%3B2024W27%3B2024W28%3B2024W29%3B2024W30%3B2024W31%3B2024W32%3B2024W33%3B2024W34%3B2024W35%3B2024W36%3B2024W37%3B2024W38%3B2024W39%3B2024W40%3B2024W41%3B2024W42%3B2024W43%3B2024W44%3B2024W45%3B2024W46%3B2024W47%3B2024W48%3B2024W49%3B2024W50%3B2024W51%3B2024W52&tableLayout=true&columns=dx&rows=ou%3Bpe&skipRounding=false&completedOnly=false&hideEmptyColumns=true&hideEmptyRows=true";
	
	$data = $this->fetch_dhis2data($uri2);
	//dd($data);
	if(!empty($data->rows)){
		$this->db->truncate('mpox_cases_weeks');
	}
	foreach($data->rows as $row):
		
		$data = array("organisationunitid" =>$row[0], "organisationunitname" =>$row[1], "organisationunitcode" =>$row[2], "periodid" =>$row[4], "periodname" =>$row[5], "periodcode" =>$row[6], "Confirmed_Mpox_Cases" =>$row[8], "Mpox_Deaths" =>$row[9], "Suspected_Mpox_Cases" =>$row[10]);
		
	
	
		$this->db->insert('mpox_cases_weeks', $data);
	
	
	endforeach;
	echo $this->db->affected_rows();


}
public function last_4weeks_data(){
	// Base URL for the API endpoint

//cases last 4 weeks csv link
$uri3 =  "https://ems.africacdc.org/api/analytics.json?dimension=dx%3Af2vR0fUA3WO%3BLU3aYsYN5C1%3BRAkL8FS7MUg%3BaX8O0TtqFEV&dimension=ou%3AynUPYzmA3Qx%3BlgF9DzO6BCC%3BR4VqRZJaDVG%3BtM0n92xvtsx%3BUzFdKL1DrLa%3BLEVEL-k0Ber6Navox&dimension=pe%3ALAST_4_WEEKS&tableLayout=true&columns=dx&rows=ou%3Bpe&skipRounding=false&completedOnly=false&hideEmptyColumns=true&hideEmptyRows=true";
// Initial URL to fetch the first page
$data = $this->fetch_dhis2data($uri3);
//dd($data);
if(!empty($data->rows)){
	$this->db->truncate('mpox_cases_weeks_last4');
}
foreach($data->rows as $row):
$data = array("organisationunitid" =>$row[0], "organisationunitname" =>$row[1], "organisationunitcode" =>$row[2], "periodid" =>$row[4], "periodname" =>$row[5], "periodcode" =>$row[6], "Confirmed_Mpox_Cases" =>$row[9], "Mpox_Deaths" =>$row[10], "Suspected_Mpox_Cases" =>$row[11]);


	$this->db->insert('mpox_cases_weeks_last4', $data);


endforeach;
echo $this->db->affected_rows();
}
public function mpox_dhis_data(){
	$this->dates_data();
	$this->last_weeks_data();
	$this->last_4weeks_data();
}



}
