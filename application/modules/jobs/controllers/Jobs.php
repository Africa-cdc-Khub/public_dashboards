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
		
	    //$uri1 =  "https://ems.africacdc.org/api/analytics.json?dimension=dx%3Af2vR0fUA3WO%3BLU3aYsYN5C1%3BRAkL8FS7MUg%3BaX8O0TtqFEV&dimension=ou%3AynUPYzmA3Qx%3BlgF9DzO6BCC%3BR4VqRZJaDVG%3BtM0n92xvtsx%3BUzFdKL1DrLa%3BLEVEL-k0Ber6Navox&dimension=pe%3A20240101%3B20240102%3B20240103%3B20240104%3B20240105%3B20240106%3B20240107%3B20240108%3B20240109%3B20240110%3B20240111%3B20240112%3B20240113%3B20240114%3B20240115%3B20240116%3B20240117%3B20240118%3B20240119%3B20240120%3B20240121%3B20240122%3B20240123%3B20240124%3B20240125%3B20240126%3B20240127%3B20240128%3B20240129%3B20240130%3B20240131%3B20240201%3B20240202%3B20240203%3B20240204%3B20240205%3B20240206%3B20240207%3B20240208%3B20240209%3B20240210%3B20240211%3B20240212%3B20240213%3B20240214%3B20240215%3B20240216%3B20240217%3B20240218%3B20240219%3B20240220%3B20240221%3B20240222%3B20240223%3B20240224%3B20240225%3B20240226%3B20240227%3B20240228%3B20240229%3B20240301%3B20240302%3B20240303%3B20240304%3B20240305%3B20240306%3B20240307%3B20240308%3B20240309%3B20240310%3B20240311%3B20240312%3B20240313%3B20240314%3B20240315%3B20240316%3B20240317%3B20240318%3B20240319%3B20240320%3B20240321%3B20240322%3B20240323%3B20240324%3B20240325%3B20240326%3B20240327%3B20240328%3B20240329%3B20240330%3B20240331%3B20240401%3B20240402%3B20240403%3B20240404%3B20240405%3B20240406%3B20240407%3B20240408%3B20240409%3B20240410%3B20240411%3B20240412%3B20240413%3B20240414%3B20240415%3B20240416%3B20240417%3B20240418%3B20240419%3B20240420%3B20240421%3B20240422%3B20240423%3B20240424%3B20240425%3B20240426%3B20240427%3B20240428%3B20240429%3B20240430%3B20240501%3B20240502%3B20240503%3B20240504%3B20240505%3B20240506%3B20240507%3B20240508%3B20240509%3B20240510%3B20240511%3B20240512%3B20240513%3B20240514%3B20240515%3B20240516%3B20240517%3B20240518%3B20240519%3B20240520%3B20240521%3B20240522%3B20240523%3B20240524%3B20240525%3B20240526%3B20240527%3B20240528%3B20240529%3B20240530%3B20240531%3B20240601%3B20240602%3B20240603%3B20240604%3B20240605%3B20240606%3B20240607%3B20240608%3B20240609%3B20240610%3B20240611%3B20240612%3B20240613%3B20240614%3B20240615%3B20240616%3B20240617%3B20240618%3B20240619%3B20240620%3B20240621%3B20240622%3B20240623%3B20240624%3B20240625%3B20240626%3B20240627%3B20240628%3B20240629%3B20240630%3B20240701%3B20240702%3B20240703%3B20240704%3B20240705%3B20240706%3B20240707%3B20240708%3B20240709%3B20240710%3B20240711%3B20240712%3B20240713%3B20240714%3B20240715%3B20240716%3B20240717%3B20240718%3B20240719%3B20240720%3B20240721%3B20240722%3B20240723%3B20240724%3B20240725%3B20240726%3B20240727%3B20240728%3B20240729%3B20240730%3B20240731%3B20240801%3B20240802%3B20240803%3B20240804%3B20240805%3B20240806%3B20240807%3B20240808%3B20240809%3B20240810%3B20240811%3B20240812%3B20240813%3B20240814%3B20240815%3B20240816%3B20240817%3B20240818%3B20240819%3B20240820%3B20240821%3B20240822%3B20240823%3B20240824%3B20240825%3B20240826%3B20240827%3B20240828%3B20240829%3B20240830%3B20240831%3B20240901%3B20240902%3B20240903%3B20240904%3B20240905%3B20240906%3B20240907%3B20240908%3B20240909%3B20240910%3B20240911%3B20240912%3B20240913%3B20240914%3B20240915%3B20240916%3B20240917%3B20240918%3B20240919%3B20240920%3B20240921%3B20240922%3B20240923%3B20240924%3B20240925%3B20240926%3B20240927%3B20240928%3B20240929%3B20240930%3B20241001%3B20241002%3B20241003%3B20241004%3B20241005%3B20241006%3B20241007%3B20241008%3B20241009%3B20241010%3B20241011%3B20241012%3B20241013%3B20241014%3B20241015%3B20241016%3B20241017%3B20241018%3B20241019%3B20241020%3B20241021%3B20241022%3B20241023%3B20241024%3B20241025%3B20241026%3B20241027%3B20241028%3B20241029%3B20241030%3B20241031%3B20241101%3B20241102%3B20241103%3B20241104%3B20241105%3B20241106%3B20241107%3B20241108%3B20241109%3B20241110%3B20241111%3B20241112%3B20241113%3B20241114%3B20241115%3B20241116%3B20241117%3B20241118%3B20241119%3B20241120%3B20241121%3B20241122%3B20241123%3B20241124%3B20241125%3B20241126%3B20241127%3B20241128%3B20241129%3B20241130%3B20241201%3B20241202%3B20241203%3B20241204%3B20241205%3B20241206%3B20241207%3B20241208%3B20241209%3B20241210%3B20241211%3B20241212%3B20241213%3B20241214%3B20241215%3B20241216%3B20241217%3B20241218%3B20241219%3B20241220%3B20241221%3B20241222%3B20241223%3B20241224%3B20241225%3B20241226%3B20241227%3B20241228%3B20241229%3B20241230%3B20241231&tableLayout=true&columns=dx&rows=ou%3Bpe&skipRounding=false&completedOnly=false&hideEmptyColumns=true&hideEmptyRows=true";
		$uri1= 'https://ems.africacdc.org/mpox_data/api/mpox/mpox_cases_week';
		$data = $this->fetch_dhis2data($uri1);
		$dataArray = $data;
		//dd($dataArray[0]);
		if(!empty($dataArray[0])){
			$this->db->truncate('mpox_cases_dates');
		}
		//dd($data);
		foreach($dataArray as $row):

			$data = array(
				"organisationunitid" => $row->organisationunitid,
				"organisationunitname" => $row->organisationunitname,
				"organisationunitcode" => $row->organisationunitcode,
				"periodid" => $row->periodid,
				"periodname" => $row->periodname,
				"periodcode" => $row->periodcode,
				"Confirmed_Mpox_Cases" => trim($row->{"Confirmed Mpox Cases"}), "Mpox_Deaths" => trim($row->{"Mpox Deaths"}), "Suspected_Mpox_Cases" => trim($row->{"Notified Mpox Cases"})
			);			
 // dd($data);

			$this->db->insert('mpox_cases_dates', $data);
		
		
		endforeach;
		echo $this->db->affected_rows();
 }
 public function last_weeks_data(){
	//mpox_cases_week.csv
	$uri2 = 'https://ems.africacdc.org/mpox_data/api/mpox/mpox_cases_dates';
	// $uri2 = "https://ems.africacdc.org/api/analytics.json?dimension=dx%3ALU3aYsYN5C1%3BRAkL8FS7MUg%3BaX8O0TtqFEV&dimension=ou%3AynUPYzmA3Qx%3BlgF9DzO6BCC%3BR4VqRZJaDVG%3BtM0n92xvtsx%3BUzFdKL1DrLa%3BLEVEL-k0Ber6Navox&dimension=pe%3A2024W1%3B2024W2%3B2024W3%3B2024W4%3B2024W5%3B2024W6%3B2024W7%3B2024W8%3B2024W9%3B2024W10%3B2024W11%3B2024W12%3B2024W13%3B2024W14%3B2024W15%3B2024W16%3B2024W17%3B2024W18%3B2024W19%3B2024W20%3B2024W21%3B2024W22%3B2024W23%3B2024W24%3B2024W25%3B2024W26%3B2024W27%3B2024W28%3B2024W29%3B2024W30%3B2024W31%3B2024W32%3B2024W33%3B2024W34%3B2024W35%3B2024W36%3B2024W37%3B2024W38%3B2024W39%3B2024W40%3B2024W41%3B2024W42%3B2024W43%3B2024W44%3B2024W45%3B2024W46%3B2024W47%3B2024W48%3B2024W49%3B2024W50%3B2024W51%3B2024W52&tableLayout=true&columns=dx&rows=ou%3Bpe&skipRounding=false&completedOnly=false&hideEmptyColumns=true&hideEmptyRows=true";
	$data = $this->fetch_dhis2data($uri2);
	$dataArray = $data;
		//dd($dataArray);

		if(!empty($dataArray[0])){
			$this->db->truncate('mpox_cases_weeks');
		}
		//dd($data);
	foreach($dataArray as $row):

		$data = array(
			"organisationunitid" => $row->organisationunitid,
			"organisationunitname" => $row->organisationunitname,
			"organisationunitcode" => $row->organisationunitcode,
			"periodid" => $row->periodid,
			"periodname" => $row->periodname,
			"periodcode" => $row->periodcode,
			"Confirmed_Mpox_Cases" => $row->{"Confirmed Mpox Cases"},
			"Mpox_Deaths" => $row->{"Mpox Deaths"},
			"Suspected_Mpox_Cases" => $row->{"Notified Mpox Cases"}
		);
		
	
		$this->db->insert('mpox_cases_weeks', $data);
	
	//
	endforeach;
	echo $this->db->affected_rows();


}
public function last_4weeks_data(){
	// Base URL for the API endpoint

//cases last 4 weeks csv link
$uri3 = 'https://ems.africacdc.org/mpox_data/api/mpox/mpox_cases_weeks_last4';
//$uri3 =  "https://ems.africacdc.org/api/analytics.json?dimension=dx%3Af2vR0fUA3WO%3BLU3aYsYN5C1%3BRAkL8FS7MUg%3BaX8O0TtqFEV&dimension=ou%3AynUPYzmA3Qx%3BlgF9DzO6BCC%3BR4VqRZJaDVG%3BtM0n92xvtsx%3BUzFdKL1DrLa%3BLEVEL-k0Ber6Navox&dimension=pe%3ALAST_4_WEEKS&tableLayout=true&columns=dx&rows=ou%3Bpe&skipRounding=false&completedOnly=false&hideEmptyColumns=true&hideEmptyRows=true";
// Initial URL to fetch the first page
$data = $this->fetch_dhis2data($uri3);
//dd($data);
$dataArray = $data;
		//dd($dataArray);

		if(!empty($dataArray[0])){
			$this->db->truncate('mpox_cases_weeks_last4');
		}
		//dd($data);
	foreach($dataArray as $row):
		$data = array(
			"organisationunitid" => $row->organisationunitid, 
			"organisationunitname" => $row->organisationunitname, 
			"organisationunitcode" => $row->organisationunitcode, 
			"periodid" => $row->periodid, 
			"periodname" => $row->periodname, 
			"periodcode" => $row->periodcode, 
			"Confirmed_Mpox_Cases" => $row->{"Confirmed Mpox Cases"}, 
			"Mpox_Deaths" => $row->{"Mpox Deaths"}, 
			"Suspected_Mpox_Cases" => $row->{"Notified Mpox Cases"}
		);
		

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
