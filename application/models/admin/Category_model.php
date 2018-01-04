<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
    public function getParentCats_dropdown_list($id)
	{
		$this->db->select('id, cat_name');
		$this->db->from('categories');
		$this->db->where('cat_id', $id);
		$this->db->order_by('case_type_id asc, sorting asc');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	public function check_unique_category($id)
	{
		$this->db->select('cat_name, court_type_id, case_type_id');
		$this->db->where('id !=', $id);
		$this->db->from('categories');
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	
// 		$names =  array();
// 		foreach ($result as $r){
// 			$names[$r->cat_name] = $r;
// 		}
// 		return $names;
	}
	
	public function save($data)
	{
		//set value by name
		$this->db->set('cat_name', $data['cat_name']);
		$this->db->set('case_type_id', (!empty($data['case_type_id']) ? $data['case_type_id'] : NULL ) );
		$this->db->set('court_type_id', (!empty($data['court_type_id']) ? $data['court_type_id'] : NULL ) );
		$this->db->set('cat_id', (!empty($data['cat_id']) ? $data['cat_id'] : NULL ) );
		$this->db->set('active', $data['active']);
		$this->db->set('sorting', $data['sorting']);
		
		if ($data['id'] == 0 )
		{
			$status = $this->db->insert('categories');
		}
		else
		{
			$this->db->where('id',$data['id']);
			$status = $this->db->update('categories');
		}
		
		$status = $this->db->affected_rows();
		return $status;
	}
	
	function getCategoryForEdit($id)
	{
		$this->db->select('*');
		$this->db->from('categories');
		$this->db->where('id', $id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
	
	function getCategoryForParentId($id)
	{
		$this->db->select('a.id, a.cat_name, a.cat_id, a.active, c.court_type, b.case_type');
		$this->db->from('categories as a');
		$this->db->join('cases_type as b', 'a.case_type_id = b.id', 'left');
		$this->db->join('courts_type as c', 'a.court_type_id = c.id', 'left');
		$this->db->where('cat_id', $id);
		$this->db->order_by('c.court_type desc, b.case_type desc, a.cat_name asc, a.sorting asc');
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
	}
	
	
}
