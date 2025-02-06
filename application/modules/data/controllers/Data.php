<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data extends MX_Controller
{


	public  function __construct()
	{
		parent::__construct();

		$this->module = "data";
		$this->title  = "Data";
		$this->load->model("data_mdl", 'datamdl');
	}

	public function form($table,$cols)
	
	{
		//$table = 'response_plan_indicators';
		$data['module'] = $this->module;
		$data['title']  = $this->title;
		$data['uptitle']   = "Data";
		// $data['fields'] = $this->datamdl->get($table);
		$old_values ='';
		$data['form'] = $this->generate_form($table, $cols, $old_values);
		//dd($data);

		render('add', $data);
	}
	public function generate_form($table, $num_columns, $old_values = [])
	{
		// Get table schema
		$schema_query = $this->db->query("SHOW COLUMNS FROM " . $table);
		$schema = $schema_query->result_array();
	
		// Bootstrap column width (12 / num_columns)
		$col_width = 12 / max(1, min($num_columns, 12));
	
		// Start form with Bootstrap styling
		$form_html = '<form method="POST" action="" class="p-4 border rounded">';
		$form_html .= '<div class="row">';
	
		foreach ($schema as $field) {
			$field_name = $field['Field'];
			$field_type = strtolower($field['Type']);
	
			// Skip the 'id' field entirely
			if ($field_name == 'id'|| $field_name == 'no' ) {
				continue;
			}
	
			// Fetch old value if available
			$old_value = isset($old_values[$field_name]) ? htmlspecialchars($old_values[$field_name], ENT_QUOTES, 'UTF-8') : '';
	
			// Determine input type based on MySQL data type or field name
			if ($field_name == 'category') {
				// Fetch distinct values for the 'category' field
				$distinct_query = $this->db->query("SELECT DISTINCT `$field_name` FROM `$table`");
				$distinct_values = $distinct_query->result_array();
	
				$input_type = 'select';
				$enum_values = array_column($distinct_values, $field_name);
			} elseif ($field_name == 'member_state') {
				// Fetch distinct values for the 'member_state' field
				$distinct_query = $this->db->query("SELECT DISTINCT `$field_name` FROM `member_states`");
				$distinct_values = $distinct_query->result_array();
	
				$input_type = 'select';
				$enum_values = array_column($distinct_values, $field_name);
			}
			elseif ($field_name == 'outbreak_id') {
				// Fetch distinct values for the 'member_state' field
				$outbreak_id = $this->session->userdata('outbreak_id');
				$distinct_query = $this->db->query("SELECT DISTINCT id FROM `outbreak_events` WHERE id='$outbreak_id'");
				$distinct_values = $distinct_query->result_array();
	
				$input_type = 'select';
				$enum_values = array_column($distinct_values, $field_name);
			}
			elseif ($field_name == 'value') {
				// Fetch distinct values for the 'member_state' field
				$distinct_query = $this->db->query("SELECT DISTINCT `$field_name` FROM `$table`");
				$distinct_values = $distinct_query->result_array();
	
				$input_type = 'select';
				$enum_values = array_column($distinct_values, $field_name);
			} 
			 elseif (preg_match('/int|double|float|decimal/', $field_type)) {
				$input_type = 'number';
			} elseif (preg_match('/text/', $field_type)) {
				$input_type = 'textarea';
			} elseif (preg_match('/varchar|char/', $field_type)) {
				$input_type = 'text';
			} elseif (preg_match('/enum\((.*)\)/', $field_type, $matches)) {
				// Extract ENUM values
				$enum_values = str_replace("'", "", explode(",", $matches[1]));
				$input_type = 'select';
			} else {
				$input_type = 'text';
			}
	
			// Open column
			$form_html .= '<div class="col-md-' . $col_width . '">';
			$form_html .= '<div class="form-group">';
			$form_html .= '<label for="' . $field_name . '">' . ucfirst(str_replace('_', ' ', $field_name)) . '</label>';
			
			// Generate input field
			if ($input_type == 'textarea') {
				$form_html .= '<textarea class="form-control" name="' . $field_name . '" id="' . $field_name . '">' . $old_value . '</textarea>';
			} elseif ($input_type == 'select') {
				$form_html .= '<select class="form-control" name="' . $field_name . '" id="' . $field_name . '">';
				foreach ($enum_values as $value) {
					$selected = ($old_value == $value) ? 'selected' : '';
					$form_html .= '<option value="' . $value . '" ' . $selected . '>' . ucfirst($value) . '</option>';
				}
				$form_html .= '</select>';
			} else {
				$form_html .= '<input type="' . $input_type . '" class="form-control" name="' . $field_name . '" id="' . $field_name . '" value="' . $old_value . '">';
			}
	
			$form_html .= '</div>'; // Close form-group
			$form_html .= '</div>'; // Close column
		}
	
		$form_html .= '</div>'; // Close row
	
		// Submit button
		$form_html .= '<button type="submit" class="btn btn-primary mt-3">Save</button>';
		$form_html .= '</form>';
	
		return $form_html;
	}


	public function create()
	{
		$data['module'] = $this->module;
		$data['title'] = $this->title;
		$data['uptitle'] = "Add Outbreaks";
		$data['outbreaks'] = $this->outbreaksmodel->get();

		render('add', $data);
	}

	public function create_links()
	{
		$data['module'] = $this->module;
		$data['title'] = $this->title;
		$data['uptitle'] = "Add Outbreaks";
		$data['outbreaks'] = $this->outbreaksmodel->get();

		render('links', $data);
	}
	public function edit_links()
	{
		$data['module'] = $this->module;
		$data['title'] = $this->title;
		$data['uptitle'] = "Add Outbreaks";
		$data['outbreaks'] = $this->outbreaksmodel->get();

		render('edit_links', $data);
	}


	public function add()
	{
	

		// Get form data
		$data = [
			'outbreak_name' => $this->input->post('outbreak_name'),
			'outbreak_type' => $this->input->post('outbreak_type'),
			'start_date' => $this->input->post('start_date'),
			'end_date' => $this->input->post('end_date'),
			'severity_level' => $this->input->post('severity_level'),
			'status' => $this->input->post('status'),
			'affected_regions' => $this->input->post('affected_regions'),
			'coordinator_name' => $this->input->post('coordinator_name'),
			'contact_email' => $this->input->post('contact_email'),
			'contact_phone' => $this->input->post('contact_phone'),
			'description' => $this->input->post('description')
		];

		// Insert outbreak data into the database
		$result = $this->outbreaksmodel->insert($data);

		if ($result) {
			$response = [
				'success' => true,
				'message' => 'Outbreak added successfully'
			];
		} else {
			$response = [
				'success' => false,
				'message' => 'Failed to add outbreak'
			];
		}

		// Return JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function edit($id, $status=FALSE)
	{
		// Load outbreak by ID for GET request or failed POST validation
		$outbreak = $this->outbreaksmodel->get_by_id($id);

		if (!$outbreak) {
			show_404(); // If no outbreak is found, show a 404 page
			return;
		}

		// Handle POST request (update)
		if ($this->input->post()) {
			// Collect the input data
			if(!$this->input->post('status')){
			$data['status'] = $status;
			}
			$data =$this->input->post();

			

			// Update the outbreak
			$result = $this->outbreaksmodel->update($id, $data);

			if ($result) {
				$response = [
					'success' => true,
					'message' => 'Outbreak updated successfully',
					'data' => $this->outbreaksmodel->get_by_id($id)
				];
			} else {
				$response = [
					'success' => false,
					'message' => 'Failed to update outbreak'
				];
			}

			// Return JSON response for AJAX call
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
		} else {
			// Handle GET request (display the edit form)
			$data['outbreak'] = $outbreak;
			$this->load->view('outbreaks/edit', $data);
		}
	}
	public function delete($id)
	{
		

		// Attempt to delete the outbreak
		$result = $this->outbreaksmodel->delete($id);

		if ($result) {
			$response = [
				'success' => true,
				'message' => 'Outbreak deleted successfully'
			];
		} else {
			$response = [
				'success' => false,
				'message' => 'Failed to delete outbreak'
			];
		}

		// Return JSON response
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
	public function assign_menu_links()
	{
		

		$outbreak_id = $this->input->post('outbreak_id');
		$menu_items = $this->input->post('menu');

		// Ensure menu items do not exceed 5 and outbreak ID is valid
		if (count($menu_items) > 5 || !$outbreak_id) {
			$response = [
				'success' => false,
				'message' => 'Invalid outbreak ID or too many menu items'
			];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
			return;
		}

		foreach ($menu_items as $item) {
			$data = [
				'outbreak_id' => $outbreak_id,
				'name' => $item['name'],
				'title' => $item['name'],
				'tab' => $item['tab'],
				'url' => $item['url'],
			];

			$this->outbreaksmodel->insert_menu_link($data);
		}

		$response = [
			'success' => true,
			'message' => 'Menu links assigned successfully'
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
	public function get_menu_links($outbreak_id)
	{
		$menu_items = $this->outbreaksmodel->get_menu_links_by_outbreak($outbreak_id);
		$response = [
			'success' => true,
			'menu_items' => $menu_items
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
	public function update_menu_links()
	{
	

		// Get the outbreak ID
		$outbreak_id = $this->input->post('outbreak_id');
		if (!$outbreak_id) {
			$response = [
				'success' => false,
				'message' => 'Invalid outbreak ID'
			];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
			return;
		}

		// Get the menu items from the form data
		$menu_items = $this->input->post('menu');
		if (empty($menu_items) || !is_array($menu_items)) {
			$response = [
				'success' => false,
				'message' => 'No menu items provided'
			];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
			return;
		}

		// Delete existing menu links for the outbreak before inserting the updated ones
		$this->outbreaksmodel->delete_menu_links_by_outbreak($outbreak_id);

		// Insert the new menu items
		foreach ($menu_items as $item) {
			$data = [
				'outbreak_id' => $outbreak_id,
				'name' => $item['name'],
				'title' => $item['title'],
				'tab' => $item['tab'],
				'url' => $item['url'],
				'icon' => isset($item['icon']) ? $item['icon'] : null,
				'is_active' => 1 // Default to active; this can be adjusted based on your requirements
			];

			// Insert each menu link
			$this->outbreaksmodel->insert_menu_link($data);
		}

		// Send a success response
		$response = [
			'success' => true,
			'message' => 'Menu items updated successfully'
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}

	public function copy_menu_links()
	{
		

		// Retrieve source and target outbreak IDs
		$source_outbreak_id = $this->input->post('source_outbreak_id');
		$target_outbreak_id = $this->input->post('target_outbreak_id');

		// Check if both IDs are valid
		if (!$source_outbreak_id || !$target_outbreak_id) {
			$response = [
				'success' => false,
				'message' => 'Invalid outbreak IDs'
			];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
			return;
		}

		// Fetch menu links for the source outbreak
		$menu_links = $this->outbreaksmodel->get_menu_links_by_outbreak($source_outbreak_id);

		// Check if there are menu links to copy
		if (empty($menu_links)) {
			$response = [
				'success' => false,
				'message' => 'No menu items to copy from the selected outbreak'
			];
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($response));
			return;
		}

		// Copy each menu link to the target outbreak as new entries
		foreach ($menu_links as $menu_link) {
			$data = [
				'outbreak_id' => $target_outbreak_id,
				'name' => $menu_link->name,
				'title' => $menu_link->title,
				'tab' => $menu_link->tab,
				'url' => $menu_link->url,
				'icon' => $menu_link->icon,
				'order' => $menu_link->order,
				'is_active' => $menu_link->is_active
			];

			// Insert each copied menu link into the target outbreak
			$this->outbreaksmodel->insert_menu_link($data);
		}

		// Send a success response
		$response = [
			'success' => true,
			'message' => 'Menu items copied successfully'
		];

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}






}
