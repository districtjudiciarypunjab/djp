<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<pre>';
// var_dump($first_name);
// die();

?>

                    <div class="row">
                        
                        
                   
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">NJP REPORT</h3>
                                </div>
                                 <div class="col col-sm-6">
                                     <form action="" method="get">
                                         <?php  
                                         $court_id=["court_id"=>0];
                                         if(!empty($courts)) {
                                             
                                            
                                                      ?>
                                 <div class="form-group row">
						<label class="col-sm-4 control-label">SELECT JUDGE NAME</label>
						<div class="col-sm-8">
							
                                                    
                                                    <?php    
                                                        $court_id = !empty($_GET['court_id'])?($courts[0]->id?$courts[0]->id:0):0;
                                                       
                                                        $court_id=["court_id"=>$court_id];
                           
								$options = array();
//								$options[''] = 'Please select...';
								foreach ($courts as $court) {
									$options[$court->id] = $court->judge_name.' '.$court->designation ;
								}
								echo form_dropdown('court_id', $options, 
									isset($item->court)? $item->court_id: set_value('court_id'),
									array('class' => 'form-control select2',"id"=>"court_id"));
							?>
							<?php echo form_error('court_id', '<div class="error">', '</div>'); ?>
						
                                                </div>
					</div>
                                     
                                                      <?php }
                                                  ?>
                                         
                                         <?php 
                                           if(!empty($districts)){ ?>
                                         
                                          <div class="form-group row">
						<label class="col-sm-4 control-label">SELECT DISTRICT</label>
						<div class="col-sm-8">
							
                                         <?php 
                                         
                                                          $court_id=["teh_id"=>$districts[0]->id??0];      
                                                     
                                                          
                                                              
                                                                     $court_id = !empty($_GET['court_id'])?($district[0]->id?$district[0]->id:0):0;
                                                       
                                                        $court_id=["teh_id"=>$court_id];
                           
								$options = array();
								foreach ($districts as $court) {
									$options[$court->id] = $court->city_name;
								}
								echo form_dropdown('court_id', $options, 
									isset($item->court)? $item->court_id: set_value('court_id'),
									array('class' => 'form-control select2',"id"=>"court_id"));
							?>
							<?php echo form_error('district_id', '<div class="error">', '</div>'); ?>
                                                   
                                                    </div>
                                          </div>
                                      <?php } ?>
                                                    
                                     <div class="form-group row">
						<label class="col-sm-4 control-label">From:</label>
						<div class="col-sm-8">
                                                    <input type="date" class="form-control datepicker" name="from" placeholder="Select From Date"
                                                </div>
                                                 </div>
                                    </div>
                                 
                                 
                                 <div class="form-group row" >
						<label class="col-sm-4 control-label">TO:</label>
						<div class="col-sm-8">
                                                    <input type="date" class="form-control datepicker" name="to" placeholder="Select to Date"
                                                </div>
                                                 </div>
                                    </div>
                        
                        <div class="form-group row">
                            <input type="submit" class="btn btn-primary col-xs-offset-2">
                        </div>
                    </form>
                             </div>
                                 
                                 <div class="box-body">
                                    

            <?php
         $from=!empty($_GET['from'])?date("Y-m-d",strtotime($_GET['from'])):date("Y-m-1");
$to=!empty($_GET['to'])?date("Y-m-d",strtotime($_GET['to'])):date("Y-m-31");

            ?>
               
            </div>

            <div class="container">
                <table class="table table-bordered table-hover" style="text-align: left;" >
                    
                    <thead>
                        <tr> 
                            <th colspan="15">
                       
 <?php 
 if(!empty($courts)){
 echo " In the court of ".$courts[0]->judge_name.' '.$courts[0]->designation.' '.$courts[0]->city;  
 }
 elseif(!empty($districts)){
     echo "In district ".$district[0]->city_name;
 }?>
                        
                            </th>
                        </tr>
                        <tr>
                            <th colspan="15">
                        <h3> Implementation of National Judiciary Policy </h3>
                            </th>
                        </tr> 
                        
                        
                         <tr>
                            <th colspan="15">
                                <span style="word-spacing:10px;">Civil Courts______________________  Statement of the period from  <?php echo date("d-m-Y",strtotime($from)); ?> to <?php echo date("d-m-Y",strtotime($to)); ?></span>
                            </th>
                        </tr>
                    </thead>
                    <?php 
                    
                    $array=array(
                        "Criminal Cases"=>$criminal_categories,
                        "Civil Cases"=>$civil_categories
                            );
                    
                    foreach($array as $key=>$result){
                    ?>
                    
                    <thead>
                        <tr>
                            <th rowspan="3" colspan="2"> <?php echo $key; ?> </th>
                            <th colspan="5">OLD Cases</th>
                            <th colspan="6">New Cases</th>
                            <th rowspan="3">Total</th>
                        </tr>
                        <tr>
                            <th colspan="5">Filed Upto 31.12.2011</th>
                              <th colspan="6">Filed Upto 01.01.2012</th>
                            
                          
                            
                        </tr>
                       
                        <tr>
                            <th>Pend</th>
                            <th>Rec</th> 
                            
                            <th>Disp</th>
                            <th>Tran</th>
                            <th>Bal</th>
                            
                            
                            <th>Pend</th>
                            <th>Rec</th> 
                            <th>Inst</th>
                            <th>Disp</th>
                            <th>Tran</th>
                            <th>Bal</th>
                            
                            
                            
                        </tr>
                    </thead>
                    
              
                    
                  
                    <tbody>
                        
                           <?php 
                          $before_date=" date_of_institution < '2011-12-31'";
                          $after_date=" date_of_institution > '2012-01-01'";

                          $previous_pending_array_before_2011=[];
                          $rbt_array_before_2011=[];
                          $disposal_array_before_2011=[];
                          $ttc_array_before_2011=[];
                            $total_array_before_2011=[];
                            
                            
                            
                            $previous_pending_array_after_2012=[];
                            
                          $fresh_array_after_2012=[];
                          $rbt_array_after_2012=[];
                          $disposal_array_after_2012=[];
                          $ttc_array_after_2012=[];
                            $total_array_after_2012=[];
                            
                            
                            $total_above_all_array=[];
                           $i=0;
                         foreach($result as $tuple){

                             ?>    
                        
                        <tr>
                              <td  style="text-align: center;"><?php echo ++$i; ?></td>
                              <!--upto 2011-->
                            <td ><?php echo $tuple->cat_name;?> </td>
                            
                            <td>
                                <?php
                          echo $previous_pending_array_before_2011[]=$pending_before_2011 = $report_model->getPendingCases($tuple->id,$court_id,$from,$before_date);
                         
                          ?>
                            </td>
                            
                            <td><?php
                             echo $rbt_array_before_2011[]=$rbt_before_2011 = $report_model->getReceivedCases($tuple->id,$court_id,$from,$to,$before_date);
                            ?></td>
                            
                            <td><?php
                             echo $disposal_array_before_2011[]=$disposal_before_2011= $report_model->getContestedCases($tuple->id,$court_id,$from,$to,$before_date)+$report_model->getUnContestedCases($tuple->id,$court_id,$from,$to,$before_date);
                            ?></td>
                            
                            <td><?php
                            echo $ttc_array_before_2011[]=$ttc_before_2011=$report_model->getTransferCases($tuple->id,$court_id,$from,$to,$before_date)   
                            ?></td>  
                            
                            <td><?php
                            echo $total_array_before_2011[]=$total_before_2011=$pending_before_2011+$rbt_before_2011-$disposal_before_2011-$ttc_before_2011;
                            ?></td>
                            
                                <!--from 2012-->
                                <td>
                                <?php
                          echo $previous_pending_array_after_2012[]=$pending_after_2012 = $report_model->getPendingCases($tuple->id,$court_id,$from,$after_date);
                          ?>
                            </td>
                            
                            <td><?php
                             echo $fresh_array_after_2012[]=$fresh_after_2012 = $report_model->getReceivedCases($tuple->id,$court_id,$from,$to,$after_date);
                            ?></td>
                            
                            <td><?php
                             echo $rbt_array_after_2012[]=$rbt_after_2012 = $report_model->getReceivedCases($tuple->id,$court_id,$from,$to,$after_date);
                            ?></td>
                            
                            <td><?php
                             echo $disposal_array_after_2012[]=$disposal_after_2012= $report_model->getContestedCases($tuple->id,$court_id,$from,$to,$after_date)+$report_model->getUnContestedCases($tuple->id,$court_id,$from,$to,$after_date);
                            ?></td>
                            
                            <td><?php
                            echo $ttc_array_after_2012[]=$ttc_after_2012=$report_model->getTransferCases($tuple->id,$court_id,$from,$to,$after_date)   
                            ?></td>  

                            
                            <td><?php echo $total_array_after_2012[]= $total_after_2012=$pending_after_2012+$rbt_after_2012+$fresh_after_2012-$disposal_after_2012+$ttc_after_2012;?></td>
                           
                            <!--Total all of both-->
                            <td><?php echo $total_above_all_array[]=$total_above_all[]=$total_before_2011+$total_after_2012;?></td>
                        </tr>
                        
                         <?php }

                         ?> 
                        
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th >Total</th>
                         
                            
                            
                            <th ><?php echo array_sum($previous_pending_array_before_2011);  ?></th>
                            <th><?php echo array_sum($rbt_array_before_2011); ?></th>
                            <th><?php echo array_sum($disposal_array_before_2011); ?></th>
                            <th><?php echo array_sum($ttc_array_before_2011); ?></th>
                            <th><?php echo array_sum($total_array_before_2011); ?></th>

                              <th ><?php echo array_sum($previous_pending_array_after_2012);  ?></th>
                            <th><?php echo array_sum($rbt_array_after_2012); ?></th>
                             <th><?php echo array_sum($fresh_array_after_2012); ?></th>
                            <th><?php echo array_sum($disposal_array_after_2012); ?></th>
                            <th><?php echo array_sum($ttc_array_after_2012); ?></th>
                            <th><?php echo array_sum($total_array_after_2012); ?></th>
                            <th><?php echo array_sum($total_above_all_array);
                            ?></th>
                        </tr>
                    </thead>
                    
                    
                    <?php } ?>
                    
                    <!-- criminal list-->
               
                </table>
                
                
                
                  
                
                
                
           
     

    
 
                                 </div>
                            </div>
                        
                    </div>
                    
<script>
$(document).ready(function(){
	$('[data-mask]').inputmask();
	// select search
    $('.select2').select2();
});
</script>