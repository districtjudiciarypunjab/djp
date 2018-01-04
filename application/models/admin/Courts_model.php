<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Courts_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function check_unique_court_name($id)
    {
    	$this->db->select('judge_id, city_id');
    	$this->db->where('id !=', $id);
    	$this->db->from('courts');
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    
//     	$names =  array();
//     	foreach ($result as $r){
//     		$names[$r->judge_id] = $r;
//     	}
//     	return $names;
    }
    
    public function check_uniqueUserDefinedCourt($id)
    {
    	$this->db->select('user_id');
    	$this->db->where('id !=', $id);
    	$this->db->from('courts');
    	$query = $this->db->get();
    	$result = $query->result();
//     	return $result;
    
    	$names =  array();
    	foreach ($result as $r){
    		$names[$r->user_id] = $r;
		}
    	return $names;
    }
    
    public function getCourtForEdit($id)
    {
    	$this->db->select('*');
    	$this->db->from('courts');
    	$this->db->where('id', $id);
    	$query = $this->db->get();
    	$result = $query->row();
    	return $result;
    }
    
    public function getTehsilparrentId($id)
    {
    	$this->db->select('id');
    	$this->db->from('districts');
    	$this->db->where('teh_id', $id);
    	$query = $this->db->get();
    	$result = $query->row();
    	return $result;
    }
    
    public function save_court($data)
    {
    	//set value by name
    	$this->db->set('judge_id', $data['judge_id']);
    	$this->db->set('court_type_id', $data['court_type_id']);
    	$this->db->set('user_id', (!empty($data['user_id']) ? $data['user_id'] : NULL ));
    	$this->db->set('city_id', (!empty($data['city_id']) ? $data['city_id'] : NULL));
    	$this->db->set('sorting', $data['sorting']);
    	//     	$this->db->set('case_type_id', (!empty($data['case_type_id']) ? $data['case_type_id'] : NULL ) );
    
    	if ($data['id'] == 0 )
    	{
    		$this->db->set('court_number', $data['court_number']);
    		
    		$status = $this->db->insert('courts');
    	}
    	else
    	{
    		$this->db->where('id',$data['id']);
    		$status = $this->db->update('courts');
    	}
    
    	$status = $this->db->affected_rows();
    	return $status;
    }
    
    public function delete_court($id)
    {
    	$this->db->where('id', $id);
    	$this->db->delete('courts');
    	$result = $this->db->affected_rows();
    	return $result;
    }
    
    public function save_courtByDistirctUser($data)
    {
    	$this->db->set('user_id', (!empty($data['user_id']) ? $data['user_id'] : NULL ));
    	$this->db->set('sorting', $data['sorting']);
    	$this->db->where('id',$data['id']);
    	$status = $this->db->update('courts');
    	$status = $this->db->affected_rows();
    	return $status;
    }
    
/*     public function getCitiesNamewithTehsils()
    {
    	
    	$this->db->select('districts.id as district_id, districts.city_name as district_name, tehsil.id as tehsil_id, tehsil.city_name as tehsil_name');
    	$this->db->from('districts');
    	
    	$this->db->join("districts tehsil", "tehsil.teh_id=districts.id","left");
    	$this->db->where("districts.teh_id IS NULL");
//     	$this->db->group_by('city_name');
//     	$this->db->order_by('teh_id asc');

    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    } */
    
    function getCourts()
    {
    	$this->db->select('courts.*,j.judge_name, courts_type.court_type, d.desgn_name as designation, city.city_name as city, CONCAT(first_name," ",last_name, "<br>(",email,")") as user');
    	$this->db->from('courts');
    	$this->db->join('judges as j', 'j.id = courts.judge_id', 'left');
    	$this->db->join('courts_type', 'courts_type.id = courts.court_type_id', 'left');
    	$this->db->join('designation as d', 'd.id = j.desgn_id', 'left');
    	$this->db->join('districts as city', 'city.id = courts.city_id', 'left');
    	$this->db->join('users', 'users.id = courts.user_id', 'left');
    	$this->db->order_by('d.id asc, j.seniority asc');
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }
    
    // check cnic validation of judge
    public function check_unique_cnic_number($id)
    {
    	$this->db->select('cnic');
    	$this->db->from('judges');
    	$this->db->where('id !=', $id);
    	$query = $this->db->get();
    	$result = $query->result();
    
    	$cnic =  array();
    	foreach ($result as $r){
    		$cnic[$r->cnic] = $r;
    	}
    	return $cnic;
    }
    
    public function save_judge($data)
    {
    	//set value by name
    	$this->db->set('judge_name', $data['judge_name']);
    	$this->db->set('desgn_id', $data['desgn_id']);
    	$this->db->set('cnic', $data['cnic']);
    	$this->db->set('date_of_birth', $data['date_of_birth']);
    	$this->db->set('date_of_joining', $data['date_of_joining']);
    	$this->db->set('date_of_retirement', $data['date_of_retirement']);
    	$this->db->set('city_id', $data['city_id']);
    	$this->db->set('gender', $data['gender']);
    	$this->db->set('seniority', $data['seniority']);
    	$this->db->set('active', $data['active']);
    
    	if ($data['id'] == 0 )
    	{
    		$status = $this->db->insert('judges');
    	}
    	else
    	{
    		$this->db->where('id',$data['id']);
    		$status = $this->db->update('judges');
    	}
    
    	$status = $this->db->affected_rows();
    	return $status;
    }
    
    function getJudgeForEdit($id)
    {
    	$this->db->select('*');
    	$this->db->from('judges');
    	$this->db->where('id', $id);
    	$query = $this->db->get();
    	$result = $query->row();
    	return $result;
    }
    
    function getJudges()
    {
    	$this->db->select('a.id, a.judge_name, a.date_of_birth, a.date_of_joining, a.date_of_retirement, a.gender, a.seniority, a.active, d.desgn_name as designation, c.city_name as domicile');
    	$this->db->from('judges as a');
    	$this->db->join('designation as d', 'd.id = a.desgn_id', 'left');
    	$this->db->join('districts as c', 'c.id = a.city_id', 'left');
    	$this->db->where('a.active', 'Yes');
    	$this->db->order_by('a.desgn_id asc, a.seniority asc');
    	$query = $this->db->get();
    	$result = $query->result();
    	return $result;
    }
	
	public function check_unique_designation($id)
	{
		$this->db->select('desgn_name');
		$this->db->where('id !=', $id);
		$this->db->from('designation');
		$query = $this->db->get();
		$result = $query->result();

		$names =  array();
		foreach ($result as $r){
			$names[$r->desgn_name] = $r;
		}
		return $names;
	}
	
	public function save_designation($data)
	{
		//set value by name
		$this->db->set('desgn_name', $data['desgn_name']);
		$this->db->set('desgn_short_name', $data['desgn_short_name']);
		$this->db->set('active', $data['active']);
		$this->db->set('sorting', $data['sorting']);
		
		if ($data['id'] == 0 )
		{
			$status = $this->db->insert('designation');
		}
		else
		{
			$this->db->where('id',$data['id']);
			$status = $this->db->update('designation');
		}
		
		$status = $this->db->affected_rows();
		return $status;
	}
	
	function getDesignationForEdit($id)
	{
		$this->db->select('*');
		$this->db->from('designation');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	function getDesignations()
	{
		$this->db->select('*');
		$this->db->from('designation');
		$this->db->order_by('sorting asc');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	// District wise COURTS 
	function getCourtsByCityId($cityId)
	{
		$this->db->select('courts.*,j.judge_name, courts_type.court_type, d.desgn_name as designation, city.city_name as city, CONCAT(first_name," ",last_name, "<br>(",email,")") as user');
		$this->db->from('courts');
		$this->db->join('judges as j', 'j.id = courts.judge_id', 'left');
		$this->db->join('courts_type', 'courts_type.id = courts.court_type_id', 'left');
		$this->db->join('designation as d', 'd.id = j.desgn_id', 'left');
		$this->db->join('districts as city', 'city.id = courts.city_id', 'left');
		$this->db->join('users', 'users.id = courts.user_id', 'left');
		$this->db->where('city.teh_id', $cityId);
		$this->db->order_by('d.id asc, j.seniority asc');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	public function getCourtsByUser($userId)
	{
		$this->db->select('courts.id, judges.judge_name, designation.desgn_name as designation, districts.city_name as city');
		$this->db->from('courts');
		$this->db->join('judges', 'judges.id = courts.judge_id', 'left');
		$this->db->join('designation', 'designation.id = judges.desgn_id','left');
		$this->db->join('districts', 'districts.id = courts.city_id', 'left');
		$this->db->where('courts.user_id', $userId);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}
	
	/* public function get_dropdown_cats_list()
	{
		$this->db->select('id, cat_name');
		$this->db->from('categories');
		$this->db->where('cat_id', 0);
		$this->db->order_by('case_type_id asc, sorting asc');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	} */
	
	/* function getCategoryForEdit($id)
	{
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	} */
	
	/* function getCategoryForParentId($id)
	{
		$this->db->select('a.id, a.cat_name, a.cat_id, b.case_type as cat_type');
		$this->db->from('categories as a');
		$this->db->join('type_of_cases as b', 'a.case_type_id = b.case_type_id', 'left');
		$this->db->where('cat_id', $id);
		$this->db->order_by('cat_type desc, sorting asc');
		$query = $this->db->get();
		$result = $query->result();
		return $result; 

// 		$categories = array();
		
// 		$query = $this->db->query("SELECT * FROM categories WHERE cat_id='".$parent_id."' ORDER BY cat_name asc;");
		
// 		foreach ($query->result() as $row)
// 		{
// 			$category = array();
			
// 			$category['id'] = $row->id . '<br>';
// 			$category['name'] = $row->cat_name . '<br>';
// 			$category['parent_id'] = $row->cat_id .'<br>';
// 			$category['sub_categories'] = $this->getCategoryForParentId($category['id']);
// 			$categories[$row->id]=  $category;
// 		}
		
// 		return $categories;
	} */
	
	
}
