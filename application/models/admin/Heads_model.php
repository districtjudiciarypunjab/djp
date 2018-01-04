<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Heads_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
    public function getHeadsByParent($id=null)
	{
		$this->db->select('header_information.id as main_id, header_information.name as main_name,sub_heading.id as sub_id, sub_heading.name as sub_name');
		$this->db->from('header_information');
		$this->db->join('header_information sub_heading', 'header_information.id = sub_heading.parent_id', 'left');
		$this->db->order_by('header_information.priority,header_information.id , sub_heading.id asc');
                if($id==null){
                $this->db->where('header_information.parent_id IS NULL');   
                }
                else if(ctype_digit ($id)){
               $this->db->where('sub_heading.id',$id);   
        }
                $query = $this->db->get();
		$result = $query->result();
                
		return $result;
	}
        
        
    public function getHeads($id=null)
	{
		$this->db->select('*');
		$this->db->from('header_information');
		 if($id!=null){
                $this->db->where('header_information.id',$id);   
                }
//               
                $query = $this->db->get();
		$result = $query->result();
		return $result;
	}
        
        public function getHeadsByCondition($condition=[])
	{
		$this->db->select('*');
		$this->db->from('header_information');
		 
                
                if(count($id)>0){
                foreach($condition as $key=>$value){ 
                    
                $this->db->where($key,$value);   
                
                }
                
                }
//               
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
//		$this->db->insert("heading_information",$data);
            $update_able=[];
            foreach($data as $key=>$value){
            
                if(!empty($value)){
                $update_able[$key]=$value;
                }
            }
		if (empty($data['id']))
		{
			$status = $this->db->insert('header_information',$update_able);
		}
		else
		{
                    $this->db->where("id","{$data['id']}");
			$status = $this->db->update('header_information',$update_able);
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
