<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<div class="row">
	<div class="col-md-10">
		<div class="box">
			<div class="box-header with-border">
            	<h3 class="box-title"><?php echo $sub_title?></h3>
            	<?php echo anchor('admin/category/add', '<span class="btn-label"><i class="fa fa-plus"></i></span> '. lang('menu_category_add'), array('class' => 'btn btn-primary btn-labeled btn-flat hidden-print pull-right')); ?>
			</div>
			<div class="box-body">
                
				<table id="record-table" class="table table-striped table-hover table-condensed">
                	<thead>
                    	<tr>
                        	<th>Sr.No</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Court Type</th>
                            <th>Case Type</th>
                            <th>Active</th>
                            <th class="hidden-print">Action</th>
						</tr>
					</thead>
                                		
					<tbody>
						<?php $i = 1?>
						<?php foreach ($categories as $cat) : ?>
							
							<tr>
								<td><?php echo $i++?></td>
								<td><?php echo $cat->cat_name; ?></td>
								<td></td>
								<td><?php echo $cat->court_type; ?></td>
								<td><?php echo $cat->case_type; ?></td>
								<td><span class="label <?= (($cat->active=='Yes') ? 'bg-blue' : 'bg-yellow'); ?>"><?php echo $cat->active;?></span></td>
								<td class="hidden-print"><?php echo anchor('admin/category/edit/'.$cat->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?></td>
							</tr>
							<?php foreach ($cat->sub_categories as $sub_cat) : ?>
							<tr>
								<td></td>
								<td><i class="fa fa-angle-double-right pull-right"></i></td>
								<td><?php echo $sub_cat->cat_name; ?></td>
								<td><?php echo $cat->court_type; ?></td>
								<td><?php echo $sub_cat->case_type; ?></td>
								<td><span class="label <?= (($cat->active=='Yes') ? 'bg-blue' : 'bg-yellow'); ?>"><?php echo $cat->active;?></span></td>
								<td class="hidden-print"><?php echo anchor('admin/category/edit/'.$sub_cat->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?></td>
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