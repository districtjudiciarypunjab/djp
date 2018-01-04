<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends District_Controller {

    public function __construct()
    {
        parent::__construct();
        
        /* Load :: Common */
        $this->lang->load('admin/users');
        
        /* Title Page :: Common */
        $this->page_title->push(lang('menu_users'));
        $this->data['pagetitle'] = $this->page_title->show();
        
        /* Breadcrumbs :: Common */
        $this->data['breadcrumb'] = $this->breadcrumbs->show();
        $this->breadcrumbs->unshift(1, lang('menu_users'), 'district/users');
    }

	public function index()
	{
		if ( ! $this->ion_auth->logged_in() )
		{
			redirect('auth/login', 'refresh');
		}
		else
		{
			/* Breadcrumbs */
			$this->data['breadcrumb'] = $this->breadcrumbs->show();
			$this->breadcrumbs->unshift(2, lang('menu_users'), 'district/users');
			
			$this->data['sub_title'] = lang('menu_users_list');
			
			$user = $this->ion_auth->user()->row();
			$userGroup = $this->core_model->getLoggin_userGroup($user->id, $user->city_id);
			
			if ($userGroup->name !='district')
			{
				$this->session->set_flashdata('message','You can not view this page!');
				$this->session->set_flashdata('message_type','warning');
				redirect('district/dashboard');
			}
			
			if ($userGroup->name == 'district')
			{
				$this->data['users'] = $this->core_model->getUsersByCityId($user->city_id);
			}
			
			foreach ($this->data['users'] as $k => $user)
			{
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}
			
			// load js files in array
			$this->data['js_files'] = array('/datatables.net/js/jquery.dataTables.min.js', '/datatables.net-bs/js/dataTables.bootstrap.min.js');
			// load css files
			$this->data['css_files'] = array('/datatables.net-bs/css/dataTables.bootstrap.min.css');
	
			/* Load Template */
			$this->template->district_render('district/users/index', $this->data);
		}
	}
	
	public function create()
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_create'), 'admin/users/create');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
		/* Variables */
		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity','ion_auth');
		$this->data['identity_column'] = $identity_column;
	
		/* Validate form input */
		$this->form_validation->set_rules('first_name', 'lang:users_firstname', 'required');
		$this->form_validation->set_rules('last_name', 'lang:users_lastname', 'required');
		$this->form_validation->set_rules('username', 'lang:users_username', 'required|is_unique['.$tables['users'].'.username]');
		$this->form_validation->set_rules('email', 'lang:users_email', 'required|valid_email|is_unique['.$tables['users'].'.email]');
		$this->form_validation->set_rules('phone', 'lang:users_phone', 'required');
		// 		$this->form_validation->set_rules('company', 'lang:users_company', 'required');
		$this->form_validation->set_rules('city_id', 'lang:users_city', 'required');
		$this->form_validation->set_rules('password', 'lang:users_password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'lang:users_password_confirm', 'required');
	
		if ($this->form_validation->run() == TRUE)
		{
			// 			$username = strtolower($this->input->post('first_name')) . ' ' . strtolower($this->input->post('last_name'));
			$username = strtolower($this->input->post('username'));
			$identity = ($identity_column==='username') ? $username : $this->input->post('identity');
			$password = $this->input->post('password');
			$email    = strtolower($this->input->post('email'));
	
			$additional_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
					'city_id'	 => $this->input->post('city_id'),
			);
		}
	
		if ($this->form_validation->run() == TRUE && $this->ion_auth->register($identity, $password, $username, $email, $additional_data))
		{
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('message_type','success');
			redirect('district/users', 'refresh');
		}
		else
		{
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
	
			$this->data['first_name'] = array(
					'name'  => 'first_name',
					'id'    => 'first_name',
					'type'  => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('first_name'),
			);
			$this->data['last_name'] = array(
					'name'  => 'last_name',
					'id'    => 'last_name',
					'type'  => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('last_name'),
			);
			$this->data['username'] = array(
					'name'  => 'username',
					'id'    => 'username',
					'type'  => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('username'),
			);
			$this->data['email'] = array(
					'name'  => 'email',
					'id'    => 'email',
					'type'  => 'email',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('email'),
			);
			$this->data['company'] = array(
					'name'  => 'company',
					'id'    => 'company',
					'type'  => 'text',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('company'),
			);
			$this->data['phone'] = array(
					'name'  => 'phone',
					'id'    => 'phone',
					'type'  => 'text',
					'data-inputmask'=> "'mask': '9999-9999999'",
					'data-mask' => '',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('phone'),
			);
			$this->data['password'] = array(
					'name'  => 'password',
					'id'    => 'password',
					'type'  => 'password',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('password'),
			);
			$this->data['password_confirm'] = array(
					'name'  => 'password_confirm',
					'id'    => 'password_confirm',
					'type'  => 'password',
					'class' => 'form-control',
					'value' => $this->form_validation->set_value('password_confirm'),
			);
				
			/* Dropdown list */
			$this->data['cities'] = $this->districts_model->getCityForParentId($id=null);
				
			// load js files in array
			$this->data['custom_js'] = array('/input-mask/jquery.inputmask.js','/bootstrap-select/dist/js/bootstrap-select.min.js');
			// load css files
			$this->data['css_files'] = array('/bootstrap-select/dist/css/bootstrap-select.min.css');
	
			/* Load Template */
			$this->template->district_render('district/users/create', $this->data);
		}
	}
	
	public function edit($id)
	{
	
		$id = (int) $id;
		
		/* Data */
		$loginUserCity = $this->ion_auth->user()->row()->city_id;
		$user          = $this->ion_auth->user($id)->row();
		$groups        = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();
		
// 		echo '<pre>';
// 		var_dump($loginUserCity);
// 		die();
	
		if ( ! $this->ion_auth->logged_in() OR ( ! $this->ion_auth->in_group($currentGroups[0]->name) == 'district' && ! ($this->ion_auth->user()->row()->city_id == $loginUserCity)) )
		{
			redirect('district/dashboard', 'refresh');
		}
	
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_edit'), 'admin/users/edit');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();

		/* Validate form input */
		$this->form_validation->set_rules('first_name', 'lang:edit_user_validation_fname_label', 'required');
		$this->form_validation->set_rules('last_name', 'lang:edit_user_validation_lname_label', 'required');
		$this->form_validation->set_rules('phone', 'lang:edit_user_validation_phone_label', 'required');
		// 		$this->form_validation->set_rules('company', 'lang:edit_user_validation_company_label', 'required');
		$this->form_validation->set_rules('city_id', 'lang:users_city', 'required');
	
		if (isset($_POST) && ! empty($_POST))
		{
			if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
				
			if ($this->input->post('email') != $user->email )
			{
				$this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required|valid_email|is_unique[' . 'users' . '.email]');
			}
	
			if ($this->input->post('username') != $user->username)
			{
				$this->form_validation->set_rules('username', $this->lang->line('edit_user_validation_username_label'), 'required|is_unique[' . 'users' . '.username]');
			}
	
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
	
			if ($this->form_validation->run() == TRUE)
			{
				$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name'  => $this->input->post('last_name'),
						'username'	 => $this->input->post('username'),
						'email'		 =>  $this->input->post('email'),
						'company'    => $this->input->post('company'),
						'phone'      => $this->input->post('phone'),
						'city_id'	 => $this->input->post('city_id'),
				);
	
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
	
				if ($this->ion_auth->is_admin())
				{
					$groupData = $this->input->post('groups');
	
					if (isset($groupData) && !empty($groupData))
					{
						$this->ion_auth->remove_from_group('', $id);
	
						foreach ($groupData as $grp)
						{
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}
	
				if($this->ion_auth->update($user->id, $data))
				{
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					$this->session->set_flashdata('message_type','success');
	
					if ($this->ion_auth->is_admin())
					{
						redirect('admin/users', 'refresh');
					}
					else
					{
						redirect('district/users', 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					$this->session->set_flashdata('message_type','warning');
	
					if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('district/dashboard', 'refresh');
					}
				}
			}
		}
	
		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();
	
		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
	
		// pass the user to the view
		$this->data['user']          = $user;
		$this->data['groups']        = $groups;
		$this->data['currentGroups'] = $currentGroups;
	
		// 		echo '<pre>';
		// 		var_dump($this->data['user']);
		// 		die();
	
		$this->data['first_name'] = array(
				'name'  => 'first_name',
				'id'    => 'first_name',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('first_name', $user->first_name)
		);
		$this->data['last_name'] = array(
				'name'  => 'last_name',
				'id'    => 'last_name',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('last_name', $user->last_name)
		);
		$this->data['username'] = array(
				'name'  => 'username',
				'id'    => 'username',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('username', $user->username),
		);
		$this->data['email'] = array(
				'name'  => 'email',
				'id'    => 'email',
				'type'  => 'email',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('email', $user->email),
		);
		$this->data['company'] = array(
				'name'  => 'company',
				'id'    => 'company',
				'type'  => 'text',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('company', $user->company)
		);
		$this->data['phone'] = array(
				'name'  => 'phone',
				'id'    => 'phone',
				'type'  => 'text',
				'data-inputmask'=> "'mask': '9999-9999999'",
				'data-mask' => '',
				'class' => 'form-control',
				'value' => $this->form_validation->set_value('phone', $user->phone)
		);
		$this->data['password'] = array(
				'name' => 'password',
				'id'   => 'password',
				'class' => 'form-control',
				'type' => 'password'
		);
		$this->data['password_confirm'] = array(
				'name' => 'password_confirm',
				'id'   => 'password_confirm',
				'class' => 'form-control',
				'type' => 'password'
		);
	
		/* Dropdown list */
		$this->data['cities'] = $this->districts_model->getCityForParentId($id=null);
			
		// load js files in array
		$this->data['custom_js'] = array('/input-mask/jquery.inputmask.js','/bootstrap-select/dist/js/bootstrap-select.min.js');
		// load css files
		$this->data['css_files'] = array('/bootstrap-select/dist/css/bootstrap-select.min.css');
	
		/* Load Template */
		$this->template->district_render('district/users/edit', $this->data);
	}
	
	function activate($id, $code = FALSE)
	{
		$id = (int) $id;
		
		$loginUserId   = $this->ion_auth->user()->row()->id;
		$userCity      = $this->ion_auth->user($id)->row()->city_id;
		$currentGroups = $this->ion_auth->get_users_groups($loginUserId)->row()->name;
		
// 		echo $loginUserId.'<br>';
// 		echo $userCity.'<br>';
// 		echo $currentGroups.'<br>';
// 		die();
	
		if ($code !== FALSE)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ( $this->ion_auth->in_group($currentGroups) == 'district' && ($this->ion_auth->user()->row()->city_id == $userCity) )
		{					
			$activation = $this->ion_auth->activate($id);
		}
	
		if ($activation)
		{
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('message_type','info');
			redirect('district/users', 'refresh');
		}
		else
		{
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			$this->session->set_flashdata('message_type','warning');
			redirect('auth/forgot_password', 'refresh');
		}
	}
	
	
	public function deactivate($id = NULL)
	{
		/* Data */
// 		$loginUserCity = $this->ion_auth->user()->row()->city_id;
		$loginUserId   = $this->ion_auth->user()->row()->id;
		$userCity          = $this->ion_auth->user($id)->row()->city_id;
// 		$groups        = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($loginUserId)->row()->name;
		
		if ( ! $this->ion_auth->logged_in() OR ( ! $this->ion_auth->in_group($currentGroups) == 'district' && ! ($this->ion_auth->user()->row()->city_id == $userCity)) )
		{
			$this->session->set_flashdata('message', 'You must be an administrator to view this page.');
			$this->session->set_flashdata('message_type','warning');
			
			redirect('district/users', 'refresh');
		}

		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_deactivate'), 'district/users/deactivate');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
		/* Validate form input */
		$this->form_validation->set_rules('confirm', 'lang:deactivate_validation_confirm_label', 'required');
		$this->form_validation->set_rules('id', 'lang:deactivate_validation_user_id_label', 'required|alpha_numeric');
	
		$id = (int) $id;
	
		if ($this->form_validation->run() === FALSE)
		{
			$user = $this->ion_auth->user($id)->row();
	
			$this->data['csrf']       = $this->_get_csrf_nonce();
			$this->data['id']         = (int) $user->id;
			$this->data['firstname']  = ! empty($user->first_name) ? htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8') : NULL;
			$this->data['lastname']   = ! empty($user->last_name) ? ' '.htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8') : NULL;
	
			/* Load Template */
			$this->template->district_render('district/users/deactivate', $this->data);
		}
		else
		{
			if ($this->input->post('confirm') == 'yes')
			{
				if ($this->_valid_csrf_nonce() === FALSE OR $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}
	
				if ($this->ion_auth->logged_in() && $this->ion_auth->in_group($currentGroups) == 'district')
				{
					$this->ion_auth->deactivate($id);
				}
			}
			
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->session->set_flashdata('message_type','warning');
	
			redirect('district/users', 'refresh');
		}
	}
	
	public function profile($id)
	{
		/* Breadcrumbs */
		$this->breadcrumbs->unshift(2, lang('menu_users_profile'), 'admin/groups/profile');
		$this->data['breadcrumb'] = $this->breadcrumbs->show();
	
		/* Data */
		$id = (int) $id;
	
		$this->data['user_info'] = $this->ion_auth->user($id)->result();
		foreach ($this->data['user_info'] as $k => $user)
		{
			$this->data['user_info'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
		}
	
		/* Load Template */
		$this->template->district_render('admin/users/profile', $this->data);
	}
	
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
	
		return array($key => $value);
	}
	
	public function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE && $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}
