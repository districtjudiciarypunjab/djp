<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courts extends District_Controller {
	
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
		$this->breadcrumbs->unshift(1, lang('menu_courts'), 'district/courts');
	}
	
	public function index()
	{
		$user = $this->ion_auth->user()->row();
		$userGroup = $this->core_model->getLoggin_userGroup($user->id, $user->city_id);
		
		if ($userGroup->name !='district')
		{
			$this->session->set_flashdata('message','You can not view this page!');
			$this->session->set_flashdata('message_type','warning');
			redirect('district/dashboard');
		}
		
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
		
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		$this->breadcrumbs->unshift(2, lang('menu_courts_list'), 'district/courts');
			
		$this->data['sub_title'] = lang('menu_courts_list');
		
		$this->data['courts'] = $this->courts_model->getCourtsByCityId($user->city_id);
		
		/* Load Template */
		$this->template->district_render('district/courts/index', $this->data);
	}
	
	public function edit_court($id = null)
	{
		$this->data['item'] = $this->courts_model->getCourtForEdit($id);
	
		// 		echo '<pre>';
		// 		var_dump($this->data['item']);
		// 		die();
	
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('district/courts', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_court_edit'), 'district/courts/edit_court');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
			$this->data['sub_title'] = lang('menu_court_edit');
	
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
	
			/* Dropdown list */
			$this->data['judgesNames'] 	= $this->courts_model->getJudges();
			$this->data['cities'] 		= $this->districts_model->getCitiesNamewithTehsils();
			
			/* Get all users */
			$user = $this->ion_auth->user()->row();
			$this->data['users'] = $this->core_model->getUsersByCityId($user->city_id);
			
// 			echo '<pre>';
// 			var_dump($this->data['users']);
// 			die();
	
			/* Load Template */
			$this->template->district_render('district/courts/add_court', $this->data);
		}
	}
	
	public function check_uniqueUserDefinedCourt($value, $id)
	{
		$this->form_validation->set_message('check_uniqueUserDefinedCourt','This user is already define other court!');
	
		$users = $this->courts_model->check_uniqueUserDefinedCourt($id);
		
		if (array_key_exists($value,$users))
		{
			return false;
		} else {
			return true;
		}
	}
	
	public function save_court()
	{
		$data = array(
				'id' 			=> $this->input->post('id'),
				'user_id'		=> strip_tags($this->input->post('user_id', TRUE)),
				'sorting'		=> strip_tags($this->input->post('sorting', TRUE))
		);
	
// 		$this->form_validation->set_rules('user_id', 'User', 'required|callback_check_uniqueUserDefinedCourt['.$data['id'].']');
		$this->form_validation->set_rules('user_id', 'User', 'required');
	
		if ($this->form_validation->run() == FALSE)
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_court_edit'), 'district/courts/edit_court');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
	

			$this->data['sub_title'] = lang('menu_court_edit');
			
	
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
				
			/* Dropdown list */
			$this->data['judgesNames'] 	= $this->courts_model->getJudges();
			$this->data['cities'] = $this->districts_model->getCitiesNamewithTehsils();
	
			/* Get all users */
			$user = $this->ion_auth->user()->row();
			$this->data['users'] = $this->core_model->getUsersByCityId($user->city_id);
			
			$this->data['item'] = $this->courts_model->getCourtForEdit($data['id']);
				
// 			$this->data['item'] 	= (object) $data;
				
			/* Load Template */
			$this->template->district_render('district/courts/add_court', $this->data);
		}
		else
		{
			if($this->courts_model->save_courtByDistirctUser($data) > 0)
			{
				$this->session->set_flashdata('message','The court name have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The court name could not be saved!');
				$this->session->set_flashdata('message_type','warning');
			}
	
			redirect('district/courts');
		}
	}
}