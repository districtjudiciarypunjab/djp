<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_not_found extends Public_Controller {

    public function __construct()
    {
        parent::__construct();
        /* Title Page :: Common */
        
    }

	public function index()
	{
		$this->data['title'] = 'Page not found! error404';
		
		/* Load Template */
		$this->template->frontend_render('public/error404', $this->data);
	}
}
