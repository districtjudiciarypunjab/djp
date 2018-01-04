<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// echo '<pre>';
// var_dump($first_name);
// die();

?>

                    <div class="row">
                   
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">MONTHLY REPORT</h3>
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
                            <th colspan="12">
                        In the court of  <?php // echo $_SESSION['officer_e']; ?>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="12">
                        <h3> Implementation of National Judiciary Policy </h3>
                            </th>
                        </tr> 
                         <tr>
                            <th colspan="12">
                                <span style="word-spacing:10px;">Civil Courts______________________  Statement of the period from  <?php echo date("d-m-Y",strtotime($from)); ?> to <?php echo date("d-m-Y",strtotime($to)); ?></span>
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th rowspan="2" colspan="2"> Categories of cases </th>
                            
                            <th classs="numbers " rowspan="2">Previous <br>Pendency</th>
                            
                            <th colspan="2">Institution During the month</th>
                           
                            <th colspan="3">Disposal During the month</th>
                            <th class="numbers" rowspan="2">Transfer</th>
                            <th class="numbers" rowspan="2">Balance at <br> the close of <br> month</th>
                        </tr>
                        <tr>
                            <th>fresh</th>
                            <th>RBT</th> 
                            
                            <th>Actual</th>
                            <th>Con</th>
                            <th>Un-con</th>
                           
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="<?php echo count($civil_categories)+1; ?> " style="text-align: center;">Civil</td>
                        </tr>

                        
                           <?php 
                           $previous_pending_array=[];
            //this is for institution this month
                           $institution_array=[];
                            $rbt_array=[];
           
                            //this is for contusted and uncontusted this month
            
            $disposal_array=[];
           $disposal_contusted_array=[];
           $disposal_uncontusted_array=[];
            
            //this is for transfer array
            $ttc_array=[];
            
            //this is for balance this month
            $pending_array=[];
                           $i=0;
                           $court_id=8;
                           
                         foreach($civil_categories as $tuple){
                              $category_id=$tuple->id;
                            
                            
                            
            ?>    
                        
                        <tr>
                            
                            <td ><?php echo $tuple->cat_name; ?> </td>
                            <td ><?php echo $pending_cases_array[]=$pending_cases=$report_model->getTotalPendingCases(null,$court_id,$category_id);  ?></td>
                            <td><?php echo $institution_array[]=$institution=$institution_cases=$report_model->getTotalInstitution(22,$court_id,$category_id,$from,$to); ?></td>
                            <td><?php echo $rbt_array[]=$rbt=$report_model->getTotalRBT(null,$court_id,$category_id,$from,$to); ?></td>
                            <td><?php 
                            $contusted=$report_model->getTotalContustedCases(null,$court_id,$category_id,$from,$to);
                            $uncontusted=$report_model->getTotalUnContustedCases(null,$court_id,$category_id,$from,$to); 
                            echo $disposal_array[]=$disposal=$contusted+$uncontusted; ?></td>
                            <td><?php echo $disposal_contusted_array[]=$contusted; ?></td>
                            <td><?php echo $disposal_uncontusted_array[]=$uncontusted; ?></td>
                            <td><?php echo $ttc_array[]=$ttc=$report_model->getTotalTTC(null,$court_id,$category_id,$from,$to); ?></td>   
                            <td><?php echo $pending_array[]=$pending_cases-$ttc+$institution+$rbt-$disposal; ?></td>
                        </tr>
                         <?php }

        ?> 
                        
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th >A. Total of all categories(1 to 14) </th>
                            <th ><?php echo array_sum($previous_pending_array);  ?></th>
                            <th><?php echo array_sum($institution_array); ?></th>
                            <th><?php echo array_sum($rbt_array); ?></th>
                            <th><?php echo array_sum($disposal_array); ?></th>
                            <th><?php echo array_sum($disposal_contusted_array); ?></th>
                            <th><?php echo array_sum($disposal_uncontusted_array); ?></th>
                            <th><?php echo array_sum($ttc_array); ?></th>
                            <th><?php echo array_sum($pending_array); ?></th>

                        </tr>
                    </thead>
                    
                    
                    
                    
                    <!-- criminal list-->
                     <tbody>
                     <tr>
                            <td rowspan="<?php echo count($criminal_categories)+1; ?> " style="text-align: center;">Criminal</td>
                        </tr>
                        
                           <?php 
                           $previous_pending_array=[];
            //this is for institution this month
                           $institution_array=[];
                            $rbt_array=[];
           
                            //this is for contusted and uncontusted this month
            
            $disposal_array=[];
           $disposal_contusted_array=[];
           $disposal_uncontusted_array=[];
            
            //this is for transfer array
            $ttc_array=[];
            
            //this is for balance this month
            $pending_array=[];
                           $i=0;
                           
                         foreach($criminal_categories as $tuple){
                            $category_id=$tuple->id;
                            
                    
                            
            ?>    
                        
                        <tr>
                            
                            <td ><?php echo $tuple->cat_name; ?> </td>
                            <td ><?php echo  $pending_cases_array[]=$pending_cases=$report_model->getTotalPendingCases(null,$court_id,$category_id);  ?></td>
                            <td><?php echo $institution_array[]=$institution=$institution_cases=$report_model->getTotalInstitution(22,$court_id,$category_id,$from,$to); ?></td>
                            <td><?php echo $rbt_array[]=$rbt=$report_model->getTotalRBT(null,$court_id,$category_id,$from,$to); ?></td>
                            <td><?php 
                            $contusted=$report_model->getTotalContustedCases(null,$court_id,$category_id,$from,$to);
                            $uncontusted=$report_model->getTotalUnContustedCases(null,$court_id,$category_id,$from,$to); 
                            echo $disposal_array[]=$disposal=$contusted+$uncontusted; ?></td>
                            <td><?php echo $disposal_contusted_array[]=$contusted; ?></td>
                            <td><?php echo $disposal_uncontusted_array[]=$uncontusted; ?></td>
                            <td><?php echo $ttc_array[]=$ttc=$report_model->getTotalTTC(null,$court_id,$category_id,$from,$to); ?></td>   
                            <td><?php echo $pending_array[]=$pending_cases-$ttc+$institution+$rbt-$disposal; ?></td>
                        </tr>
                         <?php }

        ?> 
                        
                    </tbody>
                    <thead>
                        <tr>
                            <th></th>
                            <th >A. Total of all categories(1 to 14) </th>
                            <th ><?php echo array_sum($previous_pending_array);  ?></th>
                            <th><?php echo array_sum($institution_array); ?></th>
                            <th><?php echo array_sum($rbt_array); ?></th>
                            <th><?php echo array_sum($disposal_array); ?></th>
                            <th><?php echo array_sum($disposal_contusted_array); ?></th>
                            <th><?php echo array_sum($disposal_uncontusted_array); ?></th>
                            <th><?php echo array_sum($ttc_array); ?></th>
                            <th><?php echo array_sum($pending_array); ?></th>

                        </tr>
                    </thead>
                    <tfoot>
                    <td colspan="12" style="text-align:left;">Note:_______________________________________________________________
                        <br>____________________________________________________________________</td>
                        
                    </tfoot>
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