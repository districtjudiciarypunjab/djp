<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Heads extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->dbutil();

        $this->load->model('admin/Heads_model');

        /* Title Page :: Common */
        $this->page_title->push("Headings");
        $this->data['pagetitle'] = $this->page_title->show();

        /* Breadcrumbs :: Common */
        $this->breadcrumbs->unshift(1, "Headings", 'admin/Heads');
    }

	public function index()
	{		
		// load js files in array
		$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
		// load css files
		$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
				
		/* Breadcrumbs */
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		$this->data['sub_title'] = "Headings with sub headings";
                

		/* Data */
		$this->data['headings'] = $this->Heads_model->getHeadsByParent();
            
//        foreach ($this->data['categories'] as $cat)
//        {
//        	$cat->sub_categories = $this->category_model->getCategoryForParentId($cat->id);
//        }
        
//                 echo '<pre>';
//                 var_dump($this->data['heads']);
//                 die();

		/* Load Template */
		$this->template->admin_render('admin/heads/index', $this->data);
	}
	
	public function add()
	{		
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, "Add Headings", 'admin/heads/add');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
		
		$this->data['sub_title'] = "Information That will be appear on Satements heading";
		
		// load js files in array
		$this->data['custom_js'] = array('/select2/js/select2.full.min.js');
		// load css files
		$this->data['css_files'] = array('/select2/css/select2.min.css');
		/* Data */
                
		$this->data['heads'] = $this->Heads_model->getHeads();
            
//        foreach ($this->data['categories'] as $cat)
//        {
//        	$cat->sub_categories = $this->category_model->getCategoryForParentId($cat->id);
//        }
        
//                 echo '<pre>';
//                 var_dump($this->data['heads']);
//                 die();
		/* Load Template */
		$this->template->admin_render('admin/heads/add_head', $this->data);
	}
	
	public function edit($id = null)
	{
		$this->data['item'] = $this->Heads_model->getHeads($id);
	
		if ( !$id OR empty($this->data['item']) )
		{
			$this->session->set_flashdata('message','This record not found!');
			$this->session->set_flashdata('message_type','warning');
			redirect('admin/heads', 'refresh');
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
			
			$this->data['item'] = $this->Heads_model->getHeads($id)[0]??"";
//			var_dump($this->data['item']);
//                        exit;
			/* Load Template */
                        
		$this->data['heads'] = $this->Heads_model->getHeads();
            
			$this->template->admin_render('admin/heads/add_head', $this->data);
		}
	}
	
	public function save()
	{
       
		$data = array(
				'name' 	=> strip_tags(trim($this->input->post('name', TRUE))),
				'parent_id' 	=> strip_tags(trim($this->input->post('parent_id', TRUE))),
				'active' 	=> strip_tags($this->input->post('active', TRUE)),
				'priority'	=> strip_tags($this->input->post('priority', TRUE))
		);

		$this->form_validation->set_rules('name', 'Heading Name ', 'required');
		
		
		if ($this->form_validation->run() == FALSE)
		{
                    
    $this->session->set_flashdata('message', 'Category Cannot be empty');


redirect("admin/Heads/add");
                }
		else 
		{
			if($status=$this->Heads_model->save($data)>0)
			{
				$this->session->set_flashdata('message','The Heading have saved!');
				$this->session->set_flashdata('message_type','success');
			}
			else
			{
                           
				$this->session->set_flashdata('message','The heading could not be saved!');
				$this->session->set_flashdata('message_type','warning');
			}
			
			redirect('admin/heads/add');
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