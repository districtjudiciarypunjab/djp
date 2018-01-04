<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
    
        
        
    public function getReportById($id=null)
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
        
        public function getReportByCondition($condition=[])
	{
		$this->db->select('*');
		$this->db->from('report');
		 
                
                if(count($condition)>0){
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
	
	public function save()
	{
              
          $date_of_report=date("Y-m-d",strtotime($this->input->post("heading[date_of_report]")));
      	
          	$court_id=$this->input->post("heading[court_id]");
      
           $this->db->where("date_of_report","{$date_of_report}");
           $this->db->where("court_id",$court_id);
           $this->db->delete("report");
           
                   
            $data=[];
foreach($this->input->post("heading[category_id]") as $key => $value):
            
    if(!empty($value)):
        
    $fresh=$this->input->post("heading[fresh][{$key}]");
            $contested=$this->input->post("heading[contested][{$key}]");
            $uncontested=$this->input->post("heading[uncontested][{$key}]");
            $transfer=$this->input->post("heading[transfer][{$key}]");
            $received=$this->input->post("heading[received][{$key}]");


            
                                $data[]=array(
                                            "court_id"=>$court_id,
                                            "date_of_report"=>$date_of_report,
                                            "category_id"=>$value,
                                            "fresh"=>$fresh,
                                            "contested"=>$contested,
                                            "uncontested"=>$uncontested,
                                            "transfer"=>$transfer,
                                            "received"=>$received
                                            );
                                
                               
         endif;
                                endforeach;
//        
            $this->db->insert_batch("report",$data);
           $status = $this->db->affected_rows();
           
            if($status>0){
                return true;
            }else{
                return false;
            }
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
     
        public function getPreviousPendingBefore($type_id,$court_id,$category_id){
           $pending=$this->getCasesTotalOf(14,$court_id,$category_id)
                   +$this->getCasesTotalOf(16,$court_id,$category_id)
                   +$this->getCasesTotalOf(17,$court_id,$category_id)
                   -$this->getCasesTotalOf(18,$court_id,$category_id)
                   -$this->getCasesTotalOf(19,$court_id,$category_id);;
           return $pending;
        }
        public function getTotalPendingCases($type_id,$court_id,$category_id){
            return $total=$this->getPreviousPendingBefore($type_id,$court_id,$category_id)+$this->getPreviousPendingAfter($type_id,$court_id,$category_id);
        }
        
       
        
           public function getPreviousPendingAfter($type_id,$court_id,$category_id){
           $pending=$this->getCasesTotalOf(21,$court_id,$category_id)
                   +$this->getCasesTotalOf(22,$court_id,$category_id)
                   +$this->getCasesTotalOf(23,$court_id,$category_id)
                   -$this->getCasesTotalOf(24,$court_id,$category_id)
                   -$this->getCasesTotalOf(25,$court_id,$category_id)
                   -$this->getCasesTotalOf(26,$court_id,$category_id);
           return $pending;
        }
        
       public function getCasesTotalOf($of,$court_id,$category_id,$from=null,$to=null){
           $this->db->select("sum({$of}) as result");
           $this->db->from("report");
           $condition=" court_id='{$court_id}' AND category_id='{$category_id}'";
           
           if(!empty($from) && !empty($to)){
               
               $condition.="AND  (date_of_report BETWEEN '{$from}' AND '{$to}')";
           
               
               }else{
               $current_date=date("1-m-Y");
               $condition.=" AND date_of_report < '{$current_date}'";
           }
           
           $this->db->where($condition);
          
           
           $query=$this->db->get();
           $result=$query->result();
           if(count($result)>0){
           
          return $result[0]->result;
           }
           else{
           return 0;
           }
           
       }
       
        public function getTotalInstitution($type_id,$court_id,$category_id,$from,$to){
            
            return $this->getCasesTotalOf(22,$court_id,$category_id,$from,$to);
            
        }
       
        public function getTotalContustedCases($type_id,$court_id,$category_id,$from,$to){
            
            return $this->getCasesTotalOf(24,$court_id,$category_id,$from,$to)+$this->getCasesTotalOf(17,$court_id,$category_id,$from,$to);
        }
        
                public function getTotalUnContustedCases($type_id,$court_id,$category_id,$from,$to){
            
            return $this->getCasesTotalOf(25,$court_id,$category_id,$from,$to)+$this->getCasesTotalOf(25,$court_id,$category_id,$from,$to);
            
        }
        
        public function getTotalTTC($type_id,$court_id,$category_id,$from,$to){
            return $this->getCasesTotalOf(26,$court_id,$category_id,$from,$to)+$this->getCasesTotalOf(19,$court_id,$category_id,$from,$to);
        }
        
         public function getTotalRBT($type_id,$court_id,$category_id,$from,$to){
            return $this->getCasesTotalOf(16,$court_id,$category_id,$from,$to)+$this->getCasesTotalOf(23,$court_id,$category_id,$from,$to);
        }
       
	
	
}
