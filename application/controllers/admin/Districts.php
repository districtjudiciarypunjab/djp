<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Districts extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->dbutil();
//         $this->load->model('admin/districts_model');

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_districts'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_districts'), 'admin/districts');
    }

	public function index()
	{
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
		
		/* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        
        $this->data['sub_title'] = lang('menu_city_list');
        
        /* Data */
        $this->data['cities'] = $this->districts_model->getCityForParentId($id=null);
        
        foreach ($this->data['cities'] as $city)
        {
        	$city->tehsils = $this->districts_model->getCityForParentId($city->id);
        }
        
//         echo '<pre>';
//         var_dump($this->data['cities']);
//         die();
        
		/* Load Template */
		$this->template->admin_render('admin/districts/index', $this->data);
	}
	
	public function add()
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_city_add'), 'admin/districts/add');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		$this->data['sub_title'] = lang('menu_city_add');
		
		// load js files in array
		$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
		// load css files
		$this->data['css_files'] = array('/select2/css/select2.min.css');
		
		$this->data['cities'] = $this->districts_model->getCitiesByParrentID($id=null);
		
		/* Load Template */
		$this->template->admin_render('admin/districts/add_city', $this->data);
	}
	
	public function edit($id = null)
	{
		$this->data['item'] = $this->districts_model->getCityForEdit($id);
	
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/districts', 'refresh');
		}
		else
		{				
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_city_edit'), 'admin/districts/edit');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
			$this->data['sub_title'] = lang('menu_city_edit');
				
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
				
			$this->data['cities'] = $this->districts_model->getCitiesByParrentID($id=NULL);
				
			/* Load Template */
			$this->template->admin_render('admin/districts/add_city', $this->data);
		}
	}
	
	public function save()
	{
		$data = array(
				'id' 		=> strip_tags($this->input->post('id', TRUE)),
				'city_name' => strip_tags(trim($this->input->post('city_name', TRUE))),
				'teh_id' => strip_tags(trim($this->input->post('teh_id', TRUE))),
				'active' 	=> strip_tags($this->input->post('active', TRUE)),
				'sorting'	=> strip_tags($this->input->post('sorting', TRUE))
		);
		
// 		var_dump(strip_tags(trim($this->input->post('teh_id', TRUE))));
// 		die();
		
		$this->form_validation->set_rules('city_name', 'city name', 'required|callback_check_unique_city['.$data['id'].']');
		$this->form_validation->set_rules('active', 'Active', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_city_edit'), 'admin/districts/edit');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
			if ($data['id']==0)
			{
				$this->data['sub_title'] = lang('menu_city_add');
			}
			else
			{
				$this->data['sub_title'] = lang('menu_city_edit');
			}
			
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
			
			$this->data['cities'] = $this->districts_model->getCitiesByParrentID($id=null);
			
			$this->data['item'] = (object) $data;
			
			/* Load Template */
			$this->template->admin_render('admin/districts/add_city', $this->data);
		}
		else 
		{
			if($this->districts_model->save($data) > 0)
			{
				$this->session->set_flashdata('message','The city name have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The city name could not be saved!');
				$this->session->set_flashdata('message_type','danger');
			}
			
			redirect('admin/districts/add');
		}
	}
	
	public function check_unique_city($value, $id)
	{
		$teh_id = $this->input->post('teh_id');
		
		$this->form_validation->set_message('check_unique_city','The city name is already exist!');
	
		$cityNames = $this->districts_model->check_unique_city($id);
		
		$total = $this->districts_model->count_cityNamesByCity($value);
		
		if ( array_key_exists($value, $cityNames) ) {
			
			if ( !empty($teh_id) && $total != 2 )
			{
				return true;
			}
			
			return false;
	
		} else {
			return true;
		}
	}
	
	// sub-district for dropdown
	public function getCityByParentId()
	{
		$city_id = $this->input->post('city_id');
		$cities = $this->districts_model->getCityForParentId($city_id);
		echo json_encode($cities);
	}
	
}