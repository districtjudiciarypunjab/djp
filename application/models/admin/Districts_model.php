<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Districts_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    // cityNames with tehsil name Dropdown options
    public function getCitiesNamewithTehsils()
    {
    	 
    	$this->db->select('districts.city_name as city_name, teh.id as teh_id, teh.city_name as tehsil_name');
    	$this->db->from('districts');
    	$this->db->join("districts teh", "teh.teh_id=districts.id","left");
    	$this->db->where("districts.teh_id IS NULL");
    	$this->db->order_by('city_name asc, tehsil_name asc');
    
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }
    // get cities by parrent id
    public function getCitiesByParrentID($id)
    {
    	$this->db->select('id, city_name');
    	$this->db->from('districts');
    	$this->db->where('teh_id', $id);
    	$this->db->order_by('sorting asc');
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }

// 	public function get_dropdown_city_list($id)
// 	{
// 		$this->db->select('id, city_name');
// 		$this->db->from('districts');
// 		$this->db->where('teh_id', $id);
// 		$this->db->order_by('sorting asc');
// 		$query = $this->db->get();
// 		$result = $query->result();
// 		return $result;
// 	}
	
	public function check_unique_city($id)
	{
		$this->db->select('city_name, teh_id');
		$this->db->where('id !=', $id);
		$this->db->from('districts');
		$query = $this->db->get();
		$result = $query->result();

		$names =  array();
		foreach ($result as $r){
			$names[$r->city_name] = $r;
		}
		return $names;
	}
	
	public function count_cityNamesByCity($city)
	{
		$this->db->select('city_name');
		$this->db->from('districts');
		$this->db->where('city_name', $city);
		$query = $this->db->get();
		$result = $query->num_rows();
		return $result;
	}
	
	public function save($data)
	{
		//set value by name
		$this->db->set('city_name', $data['city_name']);
		$this->db->set('teh_id', ( !empty($data['teh_id']) ? $data['teh_id'] : NULL ) );
		$this->db->set('active', $data['active']);
		$this->db->set('sorting', $data['sorting']);
		
		if ($data['id'] == 0 )
		{
			$status = $this->db->insert('districts');
		}
		else
		{
			$this->db->where('id',$data['id']);
			$status = $this->db->update('districts');
		}
		
		$status = $this->db->affected_rows();
		return $status;
	}
	
	function getCityForEdit($id)
	{
		$this->db->select('*');
		$this->db->from('districts');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	function getCityForParentId($id)
	{
		$this->db->select('id, city_name, teh_id, active');
		$this->db->from('districts');
		$this->db->where('teh_id', $id);
		$this->db->order_by('sorting asc');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
}
