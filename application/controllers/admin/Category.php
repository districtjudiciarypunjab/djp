<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->dbutil();

        $this->load->model('admin/category_model');

        /* Title Page :: Common */
        $this->page_title->push(lang('menu_category'));
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, lang('menu_category_list'), 'admin/category');
    }

	public function index()
	{		
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
				
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['sub_title'] = lang('menu_category_list');

		/* Data */
		$this->data['categories'] = $this->category_model->getCategoryForParentId($id=null);
            
        foreach ($this->data['categories'] as $cat)
        {
        	$cat->sub_categories = $this->category_model->getCategoryForParentId($cat->id);
        }
        
//                 echo '<pre>';
//                 var_dump($this->data['categories']);
//                 die();

		/* Load Template */
		$this->template->admin_render('admin/category/index', $this->data);
	}
	
	public function add()
	{		
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_category_add'), 'admin/category/add');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		$this->data['sub_title'] = lang('menu_category_add');
		
		// load js files in array
		$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
		// load css files
		$this->data['css_files'] = array('/select2/css/select2.min.css');
		
		$this->data['cats'] = $this->category_model->getParentCats_dropdown_list($id=null);
		
		/* Load Template */
		$this->template->admin_render('admin/category/add_cat', $this->data);
	}
	
	public function edit($id = null)
	{
		$this->data['item'] = $this->category_model->getCategoryForEdit($id);
		
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/category', 'refresh');
		}
		else
		{			
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_category_edit'), 'admin/category/edit');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
			$this->data['sub_title'] = lang('menu_category_edit');
			
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
			
			$this->data['cats'] = $this->category_model->getParentCats_dropdown_list($id=null);
			
			/* Load Template */
			$this->template->admin_render('admin/category/add_cat', $this->data);
		}
	}
	
	public function save()
	{
		$data = array(
				'id' 		=> strip_tags($this->input->post('id', TRUE)),
				'cat_name' 	=> strip_tags(trim($this->input->post('cat_name', TRUE))),
				'court_type_id'	=> strip_tags(trim($this->input->post('court_type_id', TRUE))),
				'case_type_id'	=> strip_tags(trim($this->input->post('case_type_id', TRUE))),
				'cat_id' 	=> strip_tags(trim($this->input->post('cat_id', TRUE))),
				'active' 	=> strip_tags($this->input->post('active', TRUE)),
				'sorting'	=> strip_tags($this->input->post('sorting', TRUE))
		);

		$this->form_validation->set_rules('cat_name', 'category', 'required|callback_check_unique_category['.$data['id'].'] ');
		$this->form_validation->set_rules('court_type_id', 'court type', 'required');
		$this->form_validation->set_rules('case_type_id', 'category type', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{
			/* Breadcrumbs */
			$this->breadcrumbs->unshift(2, lang('menu_category_edit'), 'admin/category/edit');
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
			
			if ($data['id']==0)
			{
				$this->data['sub_title'] = lang('menu_category_add');
			}
			else 
			{
				$this->data['sub_title'] = lang('menu_category_edit');
			}
			
			// load js files in array
			$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
			// load css files
			$this->data['css_files'] = array('/select2/css/select2.min.css');
			
			$this->data['cats'] = $this->category_model->getParentCats_dropdown_list($id=null);
			
			$this->data['item'] = (object) $data;
			
			/* Load Template */
			$this->template->admin_render('admin/category/add_cat', $this->data);
		}
		else 
		{
			if($this->category_model->save($data) > 0)
			{
				$this->session->set_flashdata('message','The category have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
				$this->session->set_flashdata('message','The category could not be saved!');
				$this->session->set_flashdata('message_type','warning');
			}
			
			redirect('admin/category/add');
		}
	}
	
	function check_unique_category($value, $id)
	{	
		$courtType	= $this->input->post('court_type_id');	 
		$caseType	= $this->input->post('case_type_id');

		$this->form_validation->set_message('check_unique_category','The category name is already exist!');
	
		$catNames = $this->category_model->check_unique_category($id);
			
			foreach ($catNames as $cat )
			{	
				if ($cat->cat_name == $value )
				{
					if ( ($cat->court_type_id == $courtType) && ($cat->case_type_id == $caseType) )
					{
						$retrunValue = 1;	
					} 
					
				}else {
					$retrunValue = 0;
				}
			}
			
			if ($retrunValue == 1 )
			{
				return false;
			} else {
				return true;
			}
		
	}
	
}