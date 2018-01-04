<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_file_install()
    {
    	if (file_exists('install.php'))
    	{
    		$val = '<div class="row">';
    		$val.= '<div class="col-md-12">';
    		$val.= '<div class="alert alert-danger">';
    		$val.= '<h4><i class="icon fa fa-warning"></i>' . lang('actions_security_error') . '</h4>';
    		$val.= '<p>' . sprintf(lang('actions_file_install_exist'), '<a href="#" class="btn btn-warning btn-flat btn-xs">' . strtolower(lang('actions_delete')) . '</a>') . '</p>';
    		$val.= '</div>';
    		$val.= '</div>';
    		$val.= '</div>';
    
    		return $val;
    	}
    }
    
    public function getUsersGroups()
    {
    	$this->db->select('*');
    	$this->db->from('groups');
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }
    
    function getUsersGroupId ( $group = NULL )
    {
    	$this->db->select('id');
    	$this->db->from('groups');
    	$this->db->where('name', $group);
    	$query = $this->db->get();
    	$result = $query->row();
    	return $result;
    }
    
    function getUsersByGroupId( $groupId )
    {
    	$this->db->select('users.*');
    	$this->db->from('groups');
    	$this->db->join('users_groups', 'groups.id = users_groups.group_id');
    	$this->db->join('users', 'users.id = users_groups.user_id');
    	$this->db->where('users_groups.group_id', $groupId);
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }
    
    function getLoggin_userGroup( $user_id, $city_id)
    {
    	$where = array('users.id' => $user_id, 'users.city_id' => $city_id);
    	
    	$this->db->select('groups.name');
    	$this->db->from('groups');
    	$this->db->join('users_groups', 'groups.id = users_groups.group_id');
    	$this->db->join('users', 'users.id = users_groups.user_id');
    	$this->db->where($where);
    	
    	$query = $this->db->get();
    	$result = $query->row();
    	return $result;
    }
    
    function getUsersByCityId($city_id)
    {
    	$this->db->select('users.*');
    	$this->db->from('groups');
    	$this->db->join('users_groups', 'groups.id = users_groups.group_id');
    	$this->db->join('users', 'users.id = users_groups.user_id');
    	$this->db->where('users.city_id', $city_id);
    	$this->db->order_by('users.id asc');
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }
}
