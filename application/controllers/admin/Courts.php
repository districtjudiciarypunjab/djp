<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courts extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->load->library('session');

        $this->load->dbutil();

        $this->load->model('admin/courts_model');
        $this->load->model('admin/districts_model');

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_courts'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->breadcrumbs->unshift(1, lang('menu_courts'), 'admin/courts');
    }

	public function index()
	{		
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
				
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['sub_title'] = lang('menu_courts_list');
		
		/* Data */
		$this->data['courts'] = $this->courts_model->getCourts();
		
// 		echo 'pre';
// 		var_dump($this->data['courts']);
// 		die();

		/* Load Template */
		$this->template->admin_render('admin/courts/index', $this->data);
	}
	
	public function check_unique_court_name($value, $id)
	{
		$city_id = $this->input->post('city_id');
		
		$this->form_validation->set_message('check_unique_court_name','This judge is already exist!');
	
		$judges = $this->courts_model->check_unique_court_name($id);
		
		foreach ($judges as $r )
		{
			if ($r->judge_id == $value )
			{
				if ($r->city_id == $city_id)
				{
					return false;
				} else {
					$retnValue = 0;
				}
				
			} else {
				$retnValue = 0;
			}
		}
		if ($retnValue == 0 )
		{
			return true;
		}
	
	}
	
	public function add_court()
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_court_add'), 'admin/courts/add_court');
// 		$this->breadcrumbs->unshift(2, lang('menu_courts'), 'admin/courts');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
		$this->data['sub_title'] = lang('menu_court_add');
		
		// load js files in array
		$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
		// load css files
		$this->data['css_files'] = array('/select2/css/select2.min.css');
			
		/* Dropdown list */
		/* Get all users */
		$this->data['users'] 		= $this->ion_auth->users()->result();
		$this->data['judgesNames'] 	= $this->courts_model->getJudges();
// 		$this->data['cities'] 		= $this->districts_model->getCityForParentId($id=null);
		
		$this->data['cities'] = $this->districts_model->getCitiesNamewithTehsils();
		
// 		echo '<pre>';
//  		var_dump($this->data['judgesNames']);
// 		die();
		
		
		/* Load Template */
		$this->template->admin_render('admin/courts/add_court', $this->data);
	}
	
	public function edit_court($id = null)
	{
		$this->data['item'] = $this->courts_model->getCourtForEdit($id);
		
// 		$this->data['maincities'] = $this->courts_model->getCity();
//		
// 		echo '<pre>';
// 		var_dump($this->data['item']);
// 		die();
	
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/courts', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_court_edit'), 'admin/courts/edit_court');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
			$this->data['sub_title'] = lang('menu_court_edit');
	
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
				
			/* Dropdown list */
			/* Get all users */
			$this->data['users'] 		= $this->ion_auth->users()->result();
			$this->data['judgesNames'] 	= $this->courts_model->getJudges();
			$this->data['cities'] = $this->districts_model->getCitiesNamewithTehsils();
	
			/* Load Template */
			$this->template->admin_render('admin/courts/add_court', $this->data);
		}
	}
	
	public function save_court()
	{
		
		$id = $this->input->post('id');
		
		if ($id == 0)
		{
			$courtNumber = strip_tags($this->input->post('court_number', TRUE));
			$this->form_validation->set_rules('court_number', 'court number', 'required|is_unique[courts.court_number]');
		}
		else
		{
			$courtNumber = strip_tags($this->input->post('courtNumber', TRUE));
		}
		
		$data = array(
				'id' 			=> $id,
				'court_number'	=> $courtNumber,
				'court_type_id' => strip_tags($this->input->post('court_type_id', TRUE)),
				'judge_id' 		=> strip_tags($this->input->post('judge_id', TRUE)),
				'city_id'		=> strip_tags($this->input->post('city_id', TRUE)),
				'user_id'		=> strip_tags($this->input->post('user_id', TRUE)),
				'sorting'		=> strip_tags($this->input->post('sorting', TRUE))
		);
	
// 		echo '<pre>';
// 		var_dump($data);
// 		die();
		
		$this->form_validation->set_rules('judge_id', 'judge name', 'required|callback_check_unique_court_name['.$data['id'].']');
		$this->form_validation->set_rules('court_type_id', 'court type', 'required');
		$this->form_validation->set_rules('city_id', 'city', 'required');
	
		if ($this->form_validation->run() == FALSE)
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_court_edit'), 'admin/courts/edit_court');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
			if ($data['id']==0)
			{
				$this->data['sub_title'] = lang('menu_court_add');
			}
			else
			{
				$this->data['sub_title'] = lang('menu_court_edit');
			}
	
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
			
			/* Dropdown list */
			$this->data['judgesNames'] 	= $this->courts_model->getJudges();
			$this->data['cities'] = $this->districts_model->getCitiesNamewithTehsils();

			/* Get all users */
			$this->data['users'] 	= $this->ion_auth->users()->result();
			
			$this->data['item'] 	= (object) $data;
			
			/* Load Template */
			$this->template->admin_render('admin/courts/add_court', $this->data);
		}
		else
		{
			if($this->courts_model->save_court($data) > 0)
			{
				$this->session->set_flashdata('message','The court name have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The court name could not be saved!');
				$this->session->set_flashdata('message_type','warning');
			}
	
			redirect('admin/courts/add_court');
		}
	}
	
	public function delete_court($id)
	{
		if ( !$this->ion_auth->is_Admin() )
		{
			$this->session->set_flashdata('message','You are not authorized user to delete court!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/dashboard');
		}
		else
		{
			if (!$id){
				
				$this->session->set_flashdata('message','Record not found!');
				$this->session->set_flashdata('message_type','warning');
				redirect('admin/courts');
			}
			if($this->courts_model->delete_court($id) > 0)
			{
				$this->session->set_flashdata('message','The court name have deleted!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The court name could not be deleted!');
				$this->session->set_flashdata('message_type','danger');
			}
			redirect('admin/courts');
		}
		
	}
	
	public function judges()
	{
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
	
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_judge'), 'admin/courts/judges');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
		$this->data['sub_title'] = lang('menu_judge');
	
		/* Data */
		$this->data['judges'] = $this->courts_model->getJudges();
		
// 		echo '<pre>';
// 		var_dump($this->data['judges']);
// 		die();
		
		/* Load Template */
		$this->template->admin_render('admin/courts/judges/index', $this->data);
	}
	
	public function check_unique_cnic_number($value, $id)
	{
		$this->form_validation->set_message('check_unique_cnic_number','This cnic number is already exist!');
	
		$cnic = $this->courts_model->check_unique_cnic_number($id);
		
// 		echo $value.'<br>';
// 		echo '<pre>';
// 		var_dump($cnic);
// 		die();
	
		if ( array_key_exists ($value, $cnic) ) {
	
			return false;
	
		} else {
			return true;
		}
	}
	
	public function add_judge()
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_judge_add'), 'admin/courts/add_judge');
		$this->breadcrumbs->unshift(2, lang('menu_judge'), 'admin/courts/judges');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		$this->data['sub_title'] = lang('menu_judge_add');
	
		// load js files in array
		$this->data['custom_js'] = array('/input-mask/jquery.inputmask.js','/select2/js/select2.full.min.js','/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
		// load css files
		$this->data['css_files'] = array('/select2/css/select2.min.css','/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
		
		/* Dropdown list */
		$this->data['designations'] = $this->courts_model->getDesignations();
		$this->data['cities'] = $this->districts_model->getCityForParentId($id=null);
		
		/* Load Template */
		$this->template->admin_render('admin/courts/judges/add_judge', $this->data);
	}
	
	public function edit_judge($id = null)
	{
		$this->data['item'] = $this->courts_model->getJudgeForEdit($id);
	
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/courts/judges', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_judge_edit'), 'admin/courts/edit_judge');
			$this->breadcrumbs->unshift(2, lang('menu_judge'), 'admin/courts/judges');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
			$this->data['sub_title'] = lang('menu_judge_edit');
	
			// load js files in array
			$this->data['custom_js'] = array('/input-mask/jquery.inputmask.js','/select2/js/select2.full.min.js','/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css','/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
			
			/* Dropdown list */
			$this->data['designations'] = $this->courts_model->getDesignations();
			$this->data['cities'] = $this->districts_model->getCityForParentId($id=null);
	
			/* Load Template */
			$this->template->admin_render('admin/courts/judges/add_judge', $this->data);
		}
	}
	
	public function save_judge()
	{
		$data = array(
				'id' 				=> strip_tags($this->input->post('id', TRUE)),
				'judge_name' 		=> strip_tags(trim($this->input->post('judge_name', TRUE))),
				'desgn_id'			=> strip_tags(trim($this->input->post('desgn_id', TRUE))),
				'cnic'				=> strip_tags(trim($this->input->post('cnic', TRUE))),
				'date_of_birth' 	=> strip_tags($this->input->post('date_of_birth', TRUE)),
				'date_of_joining' 	=> strip_tags($this->input->post('date_of_joining', TRUE)),
				'date_of_retirement'=> strip_tags($this->input->post('date_of_retirement', TRUE)),
				'city_id'			=> strip_tags($this->input->post('city_id', TRUE)),
				'gender'			=> strip_tags($this->input->post('gender', TRUE)),
				'seniority'			=> strip_tags($this->input->post('seniority', TRUE)),
				'active'			=> strip_tags($this->input->post('active', TRUE))
		);
	
// 				echo '<pre>';
// 				var_dump($data);
// 				die();
	
// 		$this->form_validation->set_rules('desgn_name', 'designation', 'required|callback_check_unique_designation['.$data['desgn_id'].']');
		$this->form_validation->set_rules('cnic', 'CNIC #', 'required|callback_check_unique_cnic_number['.$data['id'].']');
		$this->form_validation->set_rules('judge_name', 'judge name', 'required');
		$this->form_validation->set_rules('desgn_id', 'designation', 'required');
		$this->form_validation->set_rules('city_id', 'city', 'required');
		$this->form_validation->set_rules('gender', 'gender', 'required');
		$this->form_validation->set_rules('active', 'active', 'required');
	
		if ($this->form_validation->run() == FALSE)
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_judge_edit'), 'admin/courts/edit_judge');
			$this->breadcrumbs->unshift(2, lang('menu_judge'), 'admin/courts/judges');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
			if ($data['id']==0)
			{
				$this->data['sub_title'] = lang('menu_judge_add');
			}
			else
			{
				$this->data['sub_title'] = lang('menu_judge_edit');
			}
	
			// load js files in array
			$this->data['custom_js'] = array('/input-mask/jquery.inputmask.js','/select2/js/select2.full.min.js','/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css','/bootstrap-datepicker/css/bootstrap-datepicker.min.css');
			
			/* Dropdown list */
			$this->data['designations'] = $this->courts_model->getDesignations();
			$this->data['cities'] = $this->districts_model->getCityForParentId($id=null);
	
			$this->data['item'] = (object) $data;
	
			/* Load Template */
			$this->template->admin_render('admin/courts/judges/add_judge', $this->data);
		}
		else
		{
			if($this->courts_model->save_judge($data) > 0)
			{
				$this->session->set_flashdata('message','The judge profile have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The judge profile could not be saved!');
				$this->session->set_flashdata('message_type','warning');
			}
	
			redirect('admin/courts/add_judge');
		}
	}
	
	public function designations()
	{
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
	
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_desgn'), 'admin/courts/designations');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
		$this->data['sub_title'] = lang('menu_desgn');
	
		/* Data */
		$this->data['designations'] = $this->courts_model->getDesignations();
	
		/* Load Template */
		$this->template->admin_render('admin/courts/designation/index', $this->data);
	}
	
	function check_unique_designation($value, $id)
	{
		$this->form_validation->set_message('check_unique_designation','This designation name is already exist!');
	
		$desgnNames = $this->courts_model->check_unique_designation($id);
	
		if ( array_key_exists ( $value, $desgnNames ) ) {
	
			return false;
	
		} else {
			return true;
		}
	}
	
	public function add_designation()
	{		
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_desgn_add'), 'admin/courts/add_designation');
		$this->breadcrumbs->unshift(2, lang('menu_desgn'), 'admin/courts/designations');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		$this->data['sub_title'] = lang('menu_desgn_add');
		
		/* Load Template */
		$this->template->admin_render('admin/courts/designation/add_desgn', $this->data);
	}
	
	public function edit_designation($id = null)
	{
		$this->data['item'] = $this->courts_model->getDesignationForEdit($id);
	
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/courts/designations', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_desgn_edit'), 'admin/courts/edit_designation');
			$this->breadcrumbs->unshift(2, lang('menu_desgn'), 'admin/courts/designations');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
				
			$this->data['sub_title'] = lang('menu_desgn_edit');
				
			/* Load Template */
			$this->template->admin_render('admin/courts/designation/add_desgn', $this->data);
		}
	}
	
	public function save_designation()
	{
		$data = array(
				'id' 				=> strip_tags($this->input->post('id', TRUE)),
				'desgn_name' 		=> strip_tags(trim($this->input->post('desgn_name', TRUE))),
				'desgn_short_name'	=> strip_tags(trim($this->input->post('desgn_short_name', TRUE))),
				'active' 			=> strip_tags($this->input->post('active', TRUE)),
				'sorting'			=> strip_tags($this->input->post('sorting', TRUE))
		);
	
		$this->form_validation->set_rules('desgn_name', 'designation', 'required|callback_check_unique_designation['.$data['id'].']');
		$this->form_validation->set_rules('desgn_short_name', 'short name', 'required');
	
		if ($this->form_validation->run() == FALSE)
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_desgn_edit'), 'admin/courts/edit_designation');
			$this->breadcrumbs->unshift(2, lang('menu_desgn'), 'admin/courts/designations');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
				
			if ($data['id']==0)
			{
				$this->data['sub_title'] = lang('menu_desgn_add');
			}
			else
			{
				$this->data['sub_title'] = lang('menu_desgn_edit');
			}
	
			$this->data['item'] = (object) $data;

			/* Load Template */
			$this->template->admin_render('admin/courts/designation/add_desgn', $this->data);
		}
		else
		{
			if($this->courts_model->save_designation($data) > 0)
			{
				$this->session->set_flashdata('message','The designation have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The designation could not be saved!');
				$this->session->set_flashdata('message_type','warning');
			}
				
			redirect('admin/courts/add_designation');
		}
	}
}