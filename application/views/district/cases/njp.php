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
                        In the court of  <?php // echo $_SESSION['officer_e']; ?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="15">
                        <h3> Implementation of National Judiciary Policy </h3>
                            </th>
                        </tr> 
                        
                        
                         <tr>
                            <th colspan="15">
                                <span style="word-spacing:10px;">Civil Courts______________________  Statement of the period from  <?php // echo date("d-m-Y",strtotime($from)); ?> to <?php // echo date("d-m-Y",strtotime($to)); ?></span>
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th rowspan="3" colspan="2">Criminal Cases </th>
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
                          
                           $court_id=8;
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
                         foreach($criminal_categories as $tuple){

                             ?>    
                        
                        <tr>
                              <td  style="text-align: center;"><?php echo ++$i; ?></td>
                              <!--upto 2011-->
                            <td ><?php echo $tuple->cat_name;?> </td>
                            
                            <td>
                                <?php
                          echo $previous_pending_array_before_2011[]=$pending_before_2011 = $report_model->getPreviousPendingBefore(14,$court_id,$tuple->id);
                            ?>
                            </td>
                            
                            <td><?php
                             echo $rbt_array_before_2011[]=$rbt_before_2011 = $report_model->getCasesTotalOf(16,$court_id,$tuple->id,$from,$to);
                            ?></td>
                            
                            <td><?php
                             echo $disposal_array_before_2011[]=$disposal_before_2011= $report_model->getCasesTotalOf(17,$court_id,$tuple->id,$from,$to)+$report_model->getCasesTotalOf(18,$court_id,$tuple->id,$from,$to);
                            ?></td>
                            
                            <td><?php
                            echo $ttc_array_before_2011[]=$ttc_before_2011=$report_model->getCasesTotalOf(19,$court_id,$tuple->id,$from,$to);   
                            ?></td>  
                            
                            <td><?php
                            echo $total_array_before_2011[]=$total_before_2011=$pending_before_2011+$rbt_before_2011-$disposal_before_2011-$ttc_before_2011;
                            ?></td>
                            
                                <!--from 2012-->
                                
                            <td>
                                <?php
                            echo $previous_pending_array_after_2012[]=$pending_after_2012=$report_model->getPreviousPendingAfter(21,$court_id,$tuple->id);
//                              ?>
                            </td>
                            
                            <td><?php echo $rbt_array_after_2012[]=$rbt_after_2012=$report_model->getCasesTotalOf(23,$court_id,$tuple->id,$from,$to); ?></td>
                            
                            <td><?php echo $fresh_array_after_2012[]=$fresh_after_2012=$report_model->getCasesTotalOf(22,$court_id,$tuple->id,$from,$to); ?></td>
                            
                            <td><?php echo $disposal_array_after_2012[]= $disposal_after_2012= $report_model->getCasesTotalOf(24,$court_id,$tuple->id,$from,$to)+$report_model->getCasesTotalOf(25,$court_id,$tuple->id,$from,$to); ?></td>
                            
                            <td><?php echo $ttc_array_after_2012[]=$ttc_after_2012=$report_model->getCasesTotalOf(26,$court_id,$tuple->id,$from,$to); ?></td>
                           
                            
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
                    
                    
                    
                    
                    <!-- criminal list-->
               
                </table>
                
                
                
                
                  <table class="table table-bordered table-hover" style="text-align: left;" >
                    
                  
                    <thead>
                        <tr>
                            <th rowspan="3" colspan="2">Civil Cases </th>
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
                          
                           $court_id=0;
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
                         foreach($civil_categories as $tuple){
//                          echo "<pre>";
//                           print_r($tuple);
//                           echo "</pre>";
//                           exit;
                             ?>    
                        
                        <tr>
                              <td  style="text-align: center;"><?php echo ++$i; ?></td>
                              <!--upto 2011-->
                            <td ><?php echo $tuple->cat_name;?> </td>
                            
                            <td>
                                <?php
                          echo $previous_pending_array_before_2011[]=$pending_before_2011 = $report_model->getPreviousPendingBefore(14,$court_id,$tuple->id);
                            ?>
                            </td>
                            
                            <td><?php
                             echo $rbt_array_before_2011[]=$rbt_before_2011 = $report_model->getCasesTotalOf(16,$court_id,$tuple->id,$from,$to);
                            ?></td>
                            
                            <td><?php
                             echo $disposal_array_before_2011[]=$disposal_before_2011= $report_model->getCasesTotalOf(17,$court_id,$tuple->id,$from,$to)+$report_model->getCasesTotalOf(18,$court_id,$tuple->id,$from,$to);
                            ?></td>
                            
                            <td><?php
                            echo $ttc_array_before_2011[]=$ttc_before_2011=$report_model->getCasesTotalOf(19,$court_id,$tuple->id,$from,$to);   
                            ?></td>  
                            
                            <td><?php
                            echo $total_array_before_2011[]=$total_before_2011=$pending_before_2011+$rbt_before_2011-$disposal_before_2011-$ttc_before_2011;
                            ?></td>
                            
                                <!--from 2012-->
                                
                            <td>
                                <?php
                            echo $previous_pending_array_after_2012[]=$pending_after_2012=$report_model->getPreviousPendingAfter(21,$court_id,$tuple->id);
//                              ?>
                            </td>
                            
                            <td><?php echo $rbt_array_after_2012[]=$rbt_after_2012=$report_model->getCasesTotalOf(23,$court_id,$tuple->id,$from,$to); ?></td>
                            
                            <td><?php echo $fresh_array_after_2012[]=$fresh_after_2012=$report_model->getCasesTotalOf(22,$court_id,$tuple->id,$from,$to); ?></td>
                            <td><?php 
                            echo $disposal_array_after_2012[]= $disposal_after_2012= $report_model->getCasesTotalOf(24,$court_id,$tuple->id,$from,$to)+$report_model->getCasesTotalOf(25,$court_id,$tuple->id,$from,$to);
                             ?></td>
                            <td><?php echo $ttc_array_after_2012[]=$ttc_after_2012=$report_model->getCasesTotalOf(26,$court_id,$tuple->id,$from,$to); ?></td>
                           
                            
                            <td><?php echo $total_array_after_2012[]= $total_after_2012=$pending_after_2012+$rbt_after_2012+$fresh_after_2012-$disposal_after_2012+$ttc_after_2012;
                            ?></td>
                            <!--Total all of both-->
                            <td><?php echo $total_above_all_array[]=$total_above_all[]=$total_before_2011+$total_after_2012; 
                            
                            ?></td>
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