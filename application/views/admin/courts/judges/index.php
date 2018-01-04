<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
            	<h3 class="box-title"><?php echo $sub_title?></h3>
            	<?php echo anchor('admin/courts/add_judge', '<span class="btn-label"><i class="fa fa-plus"></i></span> '. lang('menu_judge_add'), array('class' => 'btn btn-primary btn-labeled btn-flat hidden-print pull-right')); ?>
			</div>
			<div class="box-body">
                
				<table id="record-table" class="table table-striped table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th>Sr.No</th>
                            <th>Judge Name</th>
                            <th>Designation</th>
                            <th>Date of Birth</th>
                            <th>Domicile</th>
                            <th>Date of Joining</th>
                            <th>Date of Retirement</th>
                            <th>Gender</th>
                            <th>Seniority #</th>
                            <th>Active</th>
                            <th class="hidden-print">Action</th>
						</tr>
					</thead>
                                		
					<tbody>
						<?php $i = 1?>
						<?php foreach ($judges as $item) : ?>
							
							<tr>
								<td><?php echo $i++?></td>
								<td><?php echo $item->judge_name; ?></td>
								<td><?php echo $item->designation; ?></td>
								<td><?php echo $item->date_of_birth; ?></td>
								<td><?php echo $item->domicile; ?></td>
								<td><?php echo $item->date_of_joining; ?></td>
								<td><?php echo $item->date_of_retirement; ?></td>
								<td><?php echo $item->gender; ?></td>
								<td><?php echo $item->seniority; ?></td>
								<td><span class="label <?= (($item->active=='Yes') ? 'bg-blue' : 'bg-yellow'); ?>"><?php echo $item->active;?></span></td>
								<td class="hidden-print"><?php echo anchor('admin/courts/edit_judge/'.$item->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?></td>
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
	    $('#record-table').DataTable({
	      'paging'      : true,
	      'lengthChange': true,
	      'searching'   : true,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : false
	    });
	});
</script>