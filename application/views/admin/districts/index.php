<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="row">
	<div class="col-md-8">
		<div class="box">
			<div class="box-header with-border">
            	<h3 class="box-title"><?php echo $sub_title; ?></h3>
            	<?php echo anchor('admin/districts/add', '<span class="btn-label"><i class="fa fa-plus"></i></span> '. lang('menu_city_add'), array('class' => 'btn btn-primary btn-labeled btn-flat hidden-print pull-right')); ?>
			</div>
			<div class="box-body">
                                
				<table id="record-table" class="table table-striped table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th>Sr.No</th>
                            <th>District</th>
                            <th>Sub Division</th>
                            <th>Active</th>                            
                            <th class="hidden-print">Action</th>
						</tr>
					</thead>
                                		
					<tbody>
						<?php $i = 1?>
						<?php foreach ($cities as $city) : ?>
							
							<tr>
								<td><?php echo $i++?></td>
								<td><?php echo $city->city_name;?></td>
								<td></td>
								<td><span class="label <?= (($city->active=='Yes') ? 'bg-blue' : 'bg-yellow'); ?>"><?php echo $city->active;?></span></td>
								<td class="hidden-print"><?php echo anchor('admin/districts/edit/'.$city->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?></td>
							</tr>
							<?php foreach ($city->tehsils as $teh) : ?>
							<tr>
								<td></td>
								<td><i class="fa fa-angle-double-right pull-right"></i></td>
								<td><?php echo $teh->city_name; ?></td>
								<td><span class="label <?= (($teh->active=='Yes') ? 'bg-blue' : 'bg-yellow'); ?>"><?php echo $teh->active;?></span></td>
								<td class="hidden-print"><?php echo anchor('admin/districts/edit/'.$teh->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?></td>
							</tr>
							<?php endforeach;?>
							
						<?php endforeach; ?>
					</tbody>
					
				</table>
			</div>
		</div>
	</div>
</div>
                    
<script>
	$(document).ready(function(){
	    $('#record-table').DataTable({
	      'paging'      : true,
	      'lengthChange': true,
	      'searching'   : true,
	      'ordering'    : false,
	      'info'        : true,
	      'autoWidth'   : false
	    });
	});
</script>