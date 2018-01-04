<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
            	<h3 class="box-title"><?php echo $sub_title?></h3>
            	<?php echo anchor('admin/courts/add_court', '<span class="btn-label"><i class="fa fa-plus"></i></span> '. lang('menu_court_add'), array('class' => 'btn btn-primary btn-labeled btn-flat hidden-print pull-right')); ?>
			</div>
			<div class="box-body">
                
				<table id="recordTable" class="table table-striped table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th>Sr.No</th>
                        	<th>Court #</th>
                            <th>Court Name</th>
                            <th>Designation</th>
                            <th>Posting City</th>
                            <th>Type</th>                            
                            <th>User</th>
                            <th>Sorting #</th>
                            <th class="hidden-print">Action</th>
						</tr>
					</thead>
                                		
					<tbody>
						<?php $i = 1?>
						<?php foreach ($courts as $item) : ?>
							
							<tr>
								<td><?php echo $i++?></td>
								<td><?php echo $item->court_number; ?></td>
								<td><?php echo $item->judge_name; ?></td>
								<td><?php echo $item->designation?></td>
								<td><?php echo $item->city; ?></td>
								<td><?php echo $item->court_type; ?></td>
								<td><?php echo $item->user; ?></td>
								<td><?php echo $item->sorting; ?></td>
								<td class="hidden-print">
									<?php echo anchor('admin/courts/edit_court/'.$item->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?>
									<?php echo anchor('admin/courts/delete_court/'.$item->id, '<i class="fa fa-trash-o"></i>','class="btn btn-danger btn-sm m-r-5"'); ?>
								</td>
							</tr>
							
						<?php endforeach; ?>
					</tbody>
					
				</table>
			</div>
		</div>
	</div>
</div>
                    
<script>
	$(document).ready(function(){
	    $('#recordTable').DataTable({
	      'paging'      : true,
	      'lengthChange': false,
	      'searching'   : false,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    });
	});
</script>