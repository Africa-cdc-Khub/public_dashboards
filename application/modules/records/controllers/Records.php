<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Records extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('records_model');
		$this->load->library('pagination');
	}

	public function index()
	{
		// Pagination configuration
		$data['module'] = 'records';
		$data['title'] = 'Home';
		$data['uptitle'] = "Home";
		$config['base_url'] = site_url('records/index');
		$config['total_rows'] = $this->records_model->count_all_outbreak_events();
		$config['per_page'] = 9; // Number of events per page
		$config['uri_segment'] = 3;

		// Bootstrap 4 pagination styles
		$config['full_tag_open'] = '<ul class="pagination justify-content-center">';
		$config['full_tag_close'] = '</ul>';
		$config['attributes'] = ['class' => 'page-link'];
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '&laquo';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
		$config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['outbreak_events'] = $this->records_model->get_outbreak_events($config['per_page'], $page);
		$data['pagination'] = $this->pagination->create_links();

		render_site('index', $data);
	}

	public function search()
	{
		$data['module'] = 'records';
		$data['title'] = 'Search';
		$data['uptitle'] = "Search";

		// Get the search term from the query string
		$term = $this->input->get('term');

		// Fetch the outbreak events based on the search term
		$data['outbreak_events'] = $this->records_model->search_outbreak_events($term);

		// Load the view with the entire outbreak events array
		$html = $this->load->view('records/event_card', $data, true);

		// Return the generated HTML
		echo $html;
	}

	public function dashboard($id, $menu_id=FALSE)
	{
		$data['module'] = 'records';
		$data['title'] = 'Home';
		$data['uptitle'] = "Home";
		$data['event'] = $this->records_model->get_outbreak_event($id)->outbreak_name;
		$data['menus'] = $this->db
			->order_by('order', 'ASC')
			->get_where('outbreak_menu_links', ['outbreak_id' => $id])
			->result();

		if(empty($menu_id)){
		 $data['active_url'] = $this->db->query("SELECT `url` as default_url  from  outbreak_menu_links where is_default=1 and outbreak_id=$id")->row()->default_url;
		}
		else{
		$data['active_url'] = $this->db->query("SELECT `url` as default_url  from  outbreak_menu_links where outbreak_id=$id and id=$menu_id")->row()->default_url;
		}

		render_site('dashboard', $data);
	}

}