<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($item))
{
	$item = new stdClass();
	$item->id=0;
	$item->name='';
        $item->parent_id="";
//	$item->cat_id='';
	$item->active=1;
	$item->priority='';
}

?>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title;?></h3>
			</div>
			
			<?php echo form_open(base_url('admin/heads/save'),'class="form-horizontal"'); ?>

			<div class="box-body">
			
				<?php if ( !empty(validation_errors()) )  : ?>
                	<div class="col-sm-8 col-sm-offset-4 text-danger m-b-10">
					<?php if (!empty(validation_errors())) { echo '<strong>Please fill below required field(s).</strong>'; } ?>
				</div>                                    
                <?php endif; ?>
		
				<div class="form-group">
					<label class="col-sm-4 control-label">Head Name *</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo set_value('name', $item->name);?>" name="name" class="form-control" placeholder="Head name..." autofocus maxlength="50">
						<?php echo form_error('name', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Parent Header Information</label>
					<div class="col-sm-6">
						<?php 
							$options = array();
							$options[''] = 'None';
							foreach ($heads as $head) {
                                                            
								$options[$head->id] = $head->name;
                                                                
							}
							echo form_dropdown('parent_id', $options, 
								isset($item->parent_id)? $item->parent_id: set_value('parent_id'),
								array('class' => 'form-control select2 col-sm-4'));
						?>
						<?php echo form_error('parent_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>

                <div class="form-group">
					<label class="col-sm-4 control-label" for="active"> Active</label>
					<div class="col-sm-8">
						<div class="input-group">
							<div class="btn-group radio-group">
								<label class="btn btn-success <?php if($item->active != 1){ echo 'not-active'; } ?>"> Yes <input type="radio" name="active" class="hidden" value="Yes" <?php if($item->active==1){echo 'checked';}?>></label>
	                			<label class="btn btn-danger <?php if($item->active != 0){ echo 'not-active'; } ?>"> No <input type="radio" name="active" class="hidden" value="0" <?php if($item->active==0){echo 'checked';}?>></label>
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label" for="sorting">Sorting order by</label>
					<div class="col-sm-3">
						<input type="number" value="<?php echo set_value('priority', $item->priority);?>" name="priority" placeholder="ex. 123" class="form-control" >
						<?php echo form_error('sorting', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
		        <input type="hidden" name="id" value="<?php echo set_value('id',$item->id); ?>">
		        
			</div>
		
			<div class="box-footer">
				<div class="col-sm-8 col-sm-offset-4">
					<div class="btn-group">
						<button type="submit" class="btn btn-labeled btn-primary m-r-5"><span class="btn-label"><i class="fa fa-save"></i></span>Save</button>
                    	<?php echo anchor('admin/Heads', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
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