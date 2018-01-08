<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report_model extends CI_Model {

    public $before_date="31-12-2011";
    public $after_date="01-01-2012";

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
        
        public function getReportByCondition($condition=[],$second_condition=null)
	{
		$this->db->select('*');
		$this->db->from('report');
		 
                
                if(count($condition)>0){
                foreach($condition as $key=>$value){            
                $this->db->where($key,$value);        
                }        
        }
        
                if($second_condition!=null){
                    $this->db->where($second_condition);
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
      	 $date_of_institution=$this->input->post("heading[institution_date]");
       $date_of_institution=date("Y-d-m",strtotime($date_of_institution));
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
            
//        if($date_of_institution<$this->before_date){
//              $this->getPendingCasesBefore($court_id, $category_id, $date_of_institution);
//        }elseif($date_of_institution>$this->after_date){
//    $this->getPendingCasesAfter($court_id, $category_id, $date_of_institution);
//        }
        

            
                                $data[]=array(
                                            "court_id"=>$court_id,
                                            "date_of_report"=>$date_of_report,
                                            "category_id"=>$value,
                                            "fresh"=>$fresh,
                                            "contested"=>$contested,
                                            "uncontested"=>$uncontested,
                                            "transfer"=>$transfer,
                                            "received"=>$received,
                                    "date_of_institution"=>$date_of_institution
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

	}
     
        
      
        
        public function getPendingCases($category_id,$court_id,$from,$institution_date=null){
            
           
            
     $total    = $this->getCasesTotalOf("fresh", $court_id, $category_id,$from,null,$institution_date)
                     -
                    $this->getCasesTotalOf("contested", $court_id, $category_id,$from,null,$institution_date)
                         -
                         $this->getCasesTotalOf("uncontested", $court_id, $category_id,$from,null,$institution_date)
                                    -
                                $this->getCasesTotalOf("transfer", $court_id, $category_id,$from,null,$institution_date)
                                        + 
                                     $this->getCasesTotalOf("received", $court_id, $category_id,$from,null,$institution_date);
    
    return $total;  
        }
        
        public function getFreshCases($category_id,$court_id,$from,$to,$institution_date=null)
        {
                        $result=  $this->getCasesTotalOf("fresh", $court_id, $category_id,$from,$to,$institution_date=null);
        
                        return $result??0;
        }
          public function getContestedCases($category_id,$court_id,$from,$to,$institution_date=null)
        {     
                        $result =   $this->getCasesTotalOf("contested", $court_id, $category_id,$from,$to,$institution_date=null);
                        return $result??0;
                        
        }
        public function getUnContestedCases($category_id,$court_id,$from,$to,$institution_date=null)
        {     
                        $result   =    $this->getCasesTotalOf("uncontested", $court_id, $category_id,$from,$to,$institution_date=null);        
        
                        return $result??0;
        }
         public function getReceivedCases($category_id,$court_id,$from,$to,$institution_date=null)
        {
                       $result  =    $this->getCasesTotalOf("received", $court_id, $category_id,$from,$to,$institution_date=null);
        
                       return $result??0;
        }
        
         public function getTransferCases($category_id,$court_id,$from,$to,$institution_date=null)
        {
                        $result =   $this->getCasesTotalOf("transfer", $court_id, $category_id,$from,$to,$institution_date=null);
                        return $result??0;
        }
        
       public function getCasesTotalOf($of,$court_id=[],$category_id,$from=null,$to=null,$extra_condition=null){
           $this->db->distinct();
           $this->db->select("sum({$of}) as result");
           $this->db->from("report");
           $this->db->join("courts c","c.id=report.court_id","left");
           $this->db->join("districts d","d.id=c.city_id","left");
           $condition=" category_id='{$category_id}'";
           
           if(!empty($to))
           {
               $condition.="AND  (date_of_report BETWEEN '{$from}' AND '{$to}')";
           }
           elseif(!empty($from) && empty($to))
           {
              
               $condition.=" AND date_of_report < '{$from}'";
           }
           
           if(!empty($extra_condition)){
               $condition.="AND {$extra_condition}";
           }
           
           
           
           
           $this->db->where($condition);
           foreach($court_id as $key=>$value){
             
               $this->db->where($key,$value);
           }
           
           
           $query=$this->db->get();
           $result=$query->result();
           if(count($result)>0){
          return $result[0]->result;
           }
           else{
           return 0;
           }
           
       }
       
       
}
