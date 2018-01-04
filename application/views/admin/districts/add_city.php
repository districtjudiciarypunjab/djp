<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($item))
{
	$item = new stdClass();
	$item->id=0;
	$item->city_name='';
	$item->teh_id='';
	$item->active='Yes';
	$item->sorting='';
}
?>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title;?></h3>
			</div>
			
			<?php echo form_open(base_url('admin/districts/save'),'class="form-horizontal"'); ?>

			<div class="box-body">
			
				<div class="form-group">
					<label class="col-sm-4 control-label">City/Tehsil Name *</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo set_value('city_name', $item->city_name);?>" name="city_name" class="form-control" autofocus maxlength="50">
						<?php echo form_error('city_name', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">District Name</label>
					<div class="col-sm-6">
						<?php 
							$options = array();
							$options[''] = 'None';
							foreach ($cities as $city) {
								$options[$city->id] = $city->city_name;
							}
							echo form_dropdown('teh_id', $options, 
								isset($item->teh_id)? $item->teh_id: set_value('teh_id'),
								array('class' => 'form-control select2 col-sm-4'));
						?>
						<?php echo form_error('teh_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>

                <div class="form-group">
					<label class="col-sm-4 control-label" for="active">Active:</label>
					<div class="col-sm-8">
						<div class="input-group">
							<div class="btn-group radio-group">
								<label class="btn btn-success <?php if($item->active != 'Yes'){ echo 'not-active'; } ?>"> Yes <input type="radio" name="active" class="hidden" value="Yes" <?php if($item->active=='Yes'){echo 'checked';}?>></label>
	                			<label class="btn btn-danger <?php if($item->active != 'No'){ echo 'not-active'; } ?>"> No <input type="radio" name="active" class="hidden" value="No" <?php if($item->active=='No'){echo 'checked';}?>></label>
						</div>
					</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label" for="sorting">Sorting order by</label>
					<div class="col-sm-3">
						<input type="number" value="<?php echo set_value('sorting', $item->sorting);?>" name="sorting" placeholder="ex. 123" class="form-control" maxlength="10">
						<?php echo form_error('sorting', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
		        <input type="hidden" name="id" value="<?php echo set_value('id',$item->id); ?>">
		        
			</div>
		
			<div class="box-footer">
				<div class="col-sm-8 col-sm-offset-4">
					<div class="btn-group">
						<button type="submit" class="btn btn-labeled btn-primary m-r-5"><span class="btn-label"><i class="fa fa-save"></i></span>Save</button>
                    	<?php echo anchor('admin/districts', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                    </div>
				</div>
			</div>

			<?php echo form_close();?>
			
		</div>
	</div>
</div>			

<script>
$(document).ready(function(){
	
	$('.radio-group label').on('click', function(){
        $(this).removeClass('not-active').siblings().addClass('not-active');
    });
    	
	$('.select2').select2();
});
</script>