<?php	defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title; ?></h3>
				<?php echo anchor('admin/users/create', '<span class="btn-label"><i class="fa fa-plus"></i></span> '. lang('users_create_user'), array('class' => 'btn btn-primary btn-labeled btn-flat hidden-print pull-right')); ?>
			</div>
			<div class="box-body">
				<table id="dataTable" class="table table-striped table-hover">
                	<thead>
                    	<tr>
                        	<th><?php echo lang('users_firstname');?></th>
                        	<th><?php echo lang('users_lastname');?></th>
                        	<th><?php echo lang('users_username'); ?></th>
                            <th><?php echo lang('users_email');?></th>
                            <th><?php echo lang('users_groups');?></th>
                            <th><?php echo lang('users_status');?></th>
                            <th><?php echo lang('users_action');?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($users as $user):?>
                    	<tr>
                        	<td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
								<?php foreach ($user->groups as $group):?>
                            	<?php echo anchor('admin/groups/edit/'.$group->id, '<span class="label" style="background:'.$group->bgcolor.';">'.htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8').'</span>'); ?>
								<?php endforeach?>
                            </td>
                            <td><?php echo ($user->active) ? anchor('admin/users/deactivate/'.$user->id, '<span class="label label-success">'.lang('users_active').'</span>') : anchor('admin/users/activate/'. $user->id, '<span class="label label-danger">'.lang('users_inactive').'</span>'); ?></td>
                            <td>
                            	<?php echo anchor('admin/users/edit/'.$user->id, '<i class="fa fa-edit"></i>','class="btn btn-primary btn-sm m-r-5"'); ?>
                            	<?php echo anchor('admin/users/profile/'.$user->id, '<i class="fa fa-eye"></i>','class="btn btn-info btn-sm"'); ?>
                            </td>
						</tr>
					<?php endforeach;?>
                    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	
	$('#dataTable').DataTable({
	      'paging'      : true,
	      'lengthChange': true,
	      'searching'   : true,
	      'ordering'    : true,
	      'info'        : true,
	      'autoWidth'   : true
	    });
	
});
</script>