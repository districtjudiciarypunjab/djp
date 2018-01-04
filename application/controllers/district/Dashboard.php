<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends District_Controller {

    public function __construct()
    {
        parent::__construct();
        
        /* Load :: Common */
        $this->load->helper('number');
        $this->load->model('admin/dashboard_model');
        
        /* Title Page :: Common */
        $this->page_title->push(lang('menu_dashboard'));
        $this->data['pagetitle'] = $this->page_title->show();
        
        /* Breadcrumbs */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->breadcrumbs->unshift(1, lang('menu_dashboard'), 'district/dashboard');
    }

	public function index()
	{
		/* Breadcrumbs */
//         $this->data['breadcrumb'] = $this->breadcrumbs->show();
//         $this->breadcrumbs->unshift(2, lang('menu_dashboard'), 'district/dashboard');
		
//         $this->data['pagetitle'] = $this->page_title->show();

		/* Data */
		$this->data['count_users']       = $this->dashboard_model->get_count_record('users');
		$this->data['count_groups']      = $this->dashboard_model->get_count_record('groups');
		$this->data['disk_totalspace']   = $this->dashboard_model->disk_totalspace(DIRECTORY_SEPARATOR);
		$this->data['disk_freespace']    = $this->dashboard_model->disk_freespace(DIRECTORY_SEPARATOR);
		$this->data['disk_usespace']     = $this->data['disk_totalspace'] - $this->data['disk_freespace'];
		$this->data['disk_usepercent']   = $this->dashboard_model->disk_usepercent(DIRECTORY_SEPARATOR, FALSE);
		$this->data['memory_usage']      = $this->dashboard_model->memory_usage();
		$this->data['memory_peak_usage'] = $this->dashboard_model->memory_peak_usage(TRUE);
		$this->data['memory_usepercent'] = $this->dashboard_model->memory_usepercent(TRUE, FALSE);
		
		/* Load Template */
		$this->template->district_render('district/dashboard/index', $this->data);
	}
}
