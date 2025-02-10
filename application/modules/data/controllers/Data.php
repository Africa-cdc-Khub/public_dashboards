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
		//Get table schema
		// $schema_query = $this->db->query("SHOW COLUMNS FROM " . $table);
		// $schema = $schema_query->result_array();

		$schema_query = $this->db->query("
		SELECT COLUMN_NAME as Field, COLUMN_TYPE as Type, COLUMN_COMMENT as Comment
		FROM INFORMATION_SCHEMA.COLUMNS 
		WHERE TABLE_SCHEMA = DATABASE() 
		AND TABLE_NAME = '" . $table . "'
	     ");
		 $schema = $schema_query->result_array();

		 //dd($schema);
		// Bootstrap column width (12 / num_columns)
		$col_width = 12 / max(1, min($num_columns, 12));
	
		// Start form with Bootstrap styling
		
		$form_html = form_open("data/save/" . $table, [
			'class' => 'p-4 border rounded forms_data',
			'method' => 'post',
			'id' => 'tables_data'
		]);
		
		
		$form_html .= '<div class="mb-2 mt-2 row">
		<a href="'.base_url('data/view/'.$table).'" class="btn btn-md btn-primary"><i class="fa fa-eye"></i>View Data</a></div>';
		$form_html .= '<div class="row">';


		
	
		foreach ($schema as $field) {
			$field_name = $field['Field'];
			$fe = $field['Comment'];
			if(!empty($fe)){
				$field_extra = ' - '.$fe;
			}
			else{
				$field_extra ='';
			}

			$field_type = strtolower($field['Type']);
	
			// Skip the 'id' field entirely
			if ($field_name == 'id'|| $field_name == 'no'|| $field_name == 'created_at'|| $field_name == 'updated_at' ) {
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
				$distinct_query = $this->db->query("SELECT DISTINCT `$field_name` FROM `member_states` ORDER BY $field_name ASC");
				$distinct_values = $distinct_query->result_array();
	
				$input_type = 'select';
				$enum_values = array_column($distinct_values, $field_name);
			}
			elseif ($field_name == 'outbreak_id') {
				// Fetch distinct values for the 'member_state' field
				$outbreak_id = $this->session->userdata('outbreak_id');
				//dd($outbreak_id);
				$distinct_query = $this->db->query("SELECT DISTINCT id FROM `outbreak_events` WHERE id='$outbreak_id'");
				$distinct_values = $distinct_query->result_array();
	
				$input_type = 'select';
				$enum_values = array_column($distinct_values, 'id');
				$readonly = "readonly";
			}
			elseif ($field_name == 'is_verified') {
				$input_type = 'select';
				
				// Force the distinct values to be 0
				$enum_values = [0];
				
				$readonly = "readonly";
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
			$form_html .= '<label for="' . $field_name . '">' . ucfirst(str_replace('_', ' ', $field_name)).$field_extra. '</label>';
			
			// Generate input field
			if ($input_type == 'textarea') {
				$form_html .= '<textarea class="form-control" name="' . $field_name . '" id="' . $field_name . '">' . $old_value . '</textarea>';
			} elseif ($input_type == 'select') {
			$form_html .= '<select class="form-control" name="' . $field_name . '" id="' . $field_name . '" ' . @$readonly . '>';
			foreach ($enum_values as $value) {
				$selected = ($old_value == $value) ? 'selected' : '';
				if($field_name==='outbreak_id'){
				$id = $this->session->userdata('outbreak_id');
				$form_html .= '<option value="' . $value . '" ' . $selected . '>' . get_outbreak($id)->outbreak_name . '</option>';
				}
				else{
				$form_html .= '<option value="' . $value . '" ' . $selected . '>' . ucfirst($value) . '</option>';

				}
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
		$form_html .= '<button type="submit" class="btn btn-primary mt-3"><i class="fa fa-file"></i>Save</button>';
		$form_html .= '</form>';
	
		return $form_html;
	}

	public function view($table)
{
    $data['module'] = $this->module;
    $data['title']  = $this->title;
    $data['uptitle']   = "Data";
    
    // Fetch all data from the table
    $data['rows'] = $this->db->get($table)->result_array();
    
    // Generate the editable table
    $data['form'] = $this->generate_editable_table($table, $data['rows']);
    
    render('add', $data);
}

public function generate_editable_table($table, $rows)
{
    // Get table schema
    $schema_query = $this->db->query("SHOW COLUMNS FROM " . $table);
    $schema = $schema_query->result_array();
	// Columns to exclude from display
    $excluded_columns = ['is_verified', 'created_at', 'updated_at'];

    // Start table with Bootstrap styling and DataTables integration
	$table_html = '<div class="mb-2 mt-2 row">
	<a href="'.base_url('data/form/'.$table).'/2" class="btn btn-md btn-primary"><i class="fa fa-plus"></i>Add Data</a></div>';
	
    $table_html .= '<table id="data-table" class="table table-bordered table-striped">';
    $table_html .= '<thead><tr>';

    // Generate table headers
    foreach ($schema as $field) {
        $field_name = $field['Field'];
		if (!in_array($field_name, $excluded_columns)) {
			$table_html .= '<th>' . ucfirst(str_replace('ID', '', str_replace('_', ' ', $field_name))) . '</th>';

        }
    }
    $table_html .= '<th>Actions</th>';
    $table_html .= '</tr></thead>';
    $table_html .= '<tbody>';

    
     // Generate table rows while excluding specific columns
	 foreach ($rows as $row) {
        $table_html .= '<tr data-id="' . $row['id'] . '" data-table="' . $table . '">';
        foreach ($schema as $field) {
            $field_name = $field['Field'];
            if (!in_array($field_name, $excluded_columns)) {
                $fv = htmlspecialchars($row[$field_name], ENT_QUOTES, 'UTF-8');
                if ($field_name == 'outbreak_id') {
                    $fv = get_outbreak($fv)->outbreak_name;  
                }
				if($field_name==='outbreak_id'|| $field_name==='id'){
                	$editable = 'false';

				}
				else{
					$editable = 'true';

				}
				
			
                $table_html .= '<td contenteditable="'.$editable.'" data-field="' . $field_name. '">' . $fv . '</td>';
            }
        }
        
        // Add action button with color based on is_verified
		$id=$row['id'];
        $is_verified = is_verified($table,$id);
		
        $button_color = $is_verified ? 'btn-success' : 'btn-danger';
        $table_html .= '<td>';
        $table_html .= '<button class="btn ' . $button_color . ' btn-sm verify-button" data-id="' . $row['id'] . '" data-table="' . $table . '">';
        $table_html .= $is_verified ? 'Verified' : 'Verify';
        $table_html .= '</button>';
        $table_html .= '</td>';
        $table_html .= '</tr>';
    }

    $table_html .= '</tbody>';
    $table_html .= '</table>';

    // Include DataTables initialization script and AJAX handlers
    // $table_html .= '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
    // $table_html .= '<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>';
    // $table_html .= '<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>';
    // $table_html .= '<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">';

    $table_html .= '';

    return $table_html;
}

public function verify_status($table)
{

    $id = $this->input->post('id');
    $row = $this->db->get_where($table, ['id' => $id])->row_array();
    $new_status = $row['is_verified'] ? 0 : 1;
    $this->db->where('id', $id)->update($table, ['is_verified' => $new_status]);
    echo json_encode(["success" => true, "status" => $new_status ? 'Verified' : 'Verify']);
}

public function update_field($table)
{
    $id = $this->input->post('id');
    $field = $this->input->post('field');
    $value = $this->input->post('value');
    $this->db->where('id', $id)->update($table, [$field => $value]);
    echo json_encode(["success" => true]);
}

public function save($table)
{
    // Load necessary helpers and libraries
    $this->load->helper(['form', 'security']);
    $this->load->library('form_validation');


    // Retrieve input data
    $data = $this->input->post();
    unset($data[$this->security->get_csrf_token_name()]); // Remove CSRF token from data

	//dd($data);

    // Remove ID if present (to prevent overwriting an existing record unintentionally)
    if (isset($data['id']) && empty($data['id'])) {
        unset($data['id']);
    }

    // Sanitize input values
    foreach ($data as $key => $value) {
        $data[$key] = $this->security->xss_clean($value);
    }

 
        // Insert new record
        if ($this->db->insert($table, $data)) {
            echo json_encode(['success' => true, 'message' => 'Record added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add record.']);
        }
    
}


	


}
