<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($item))
{
	$item = new stdClass();
	$item->id=0;
	$item->judge_name='';
	$item->desgn_id='';
	$item->cnic='';
	$item->date_of_birth='';
	$item->date_of_joining='';
	$item->date_of_retirement='';
	$item->city_id='';
	$item->gender='Male';
	$item->seniority='';
	$item->active='Yes';
}
?>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title;?></h3>
			</div>
			
			<?php echo form_open(base_url('admin/courts/save_judge'),'class="form-horizontal"'); ?>

			<div class="box-body">
			
				<?php if ( !empty(validation_errors()) )  : ?>
                	<div class="col-sm-8 col-sm-offset-4 text-danger m-b-10">
					<?php if (!empty(validation_errors())) { echo '<strong>Please fill below required field(s).</strong>'; } ?>
				</div>                                    
                <?php endif; ?>
		
				<div class="form-group">
					<label class="col-sm-4 control-label">Judge Name *</label>
					<div class="col-sm-6">
						<input type="text" value="<?php echo set_value('judge_name', $item->judge_name);?>" name="judge_name" class="form-control" placeholder="Judge name..." autofocus maxlength="100">
						<?php echo form_error('judge_name', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Designation</label>
					<div class="col-sm-6">
						<?php 
							$options = array();
							$options[''] = 'Please select...';
							foreach ($designations as $desgn) {
								$options[$desgn->id] = $desgn->desgn_name;
							}
							echo form_dropdown('desgn_id', $options, 
								isset($item->desgn_id)? $item->desgn_id: set_value('desgn_id'),
								array('class' => 'form-control select2 col-sm-4'));
						?>
						<?php echo form_error('desgn_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">CNIC #</label>
                    <div class="col-sm-6">
						<div class="input-group">
                         	<div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                            <input type="text" name="cnic" class="form-control" value="<?php echo set_value('cnic', $item->cnic); ?>" data-inputmask="'mask':'99999-9999999-9'" data-mask>
						</div>
						<?php echo form_error('cnic', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
                	<label class="col-sm-4 control-label">Date of Birth:</label>
                	<div class="col-sm-6">
                		<div class="input-group date">
                  			<div class="input-group-addon">
                    			<i class="fa fa-calendar"></i>
                  			</div>
                  			<input type="text" value="<?php echo set_value('date_of_birth', $item->date_of_birth);?>" name="date_of_birth"  class="form-control pull-right" id="datepicker-1">
              			</div>
              		</div>
              	</div>
              	
              	<div class="form-group">
                	<label class="col-sm-4 control-label">Date of Joining:</label>
                	<div class="col-sm-6">
                		<div class="input-group date">
                  			<div class="input-group-addon">
                    			<i class="fa fa-calendar"></i>
                  			</div>
                  			<input type="text" value="<?php echo set_value('date_of_joining', $item->date_of_joining);?>" name="date_of_joining"  class="form-control pull-right" id="datepicker-2">
              			</div>
              		</div>
              	</div>
              	
              	<div class="form-group">
                	<label class="col-sm-4 control-label">Date of Retirement:</label>
                	<div class="col-sm-6">
                		<div class="input-group date">
                  			<div class="input-group-addon">
                    			<i class="fa fa-calendar"></i>
                  			</div>
                  			<input type="text" value="<?php echo set_value('date_of_retirement', $item->date_of_retirement);?>" name="date_of_retirement"  class="form-control pull-right" id="datepicker-3">
              			</div>
              		</div>
              	</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">Domicile District</label>
					<div class="col-sm-6">
						<?php 
							$options = array();
							$options[''] = 'Please select...';
							foreach ($cities as $city) {
								$options[$city->id] = $city->city_name;
							}
							echo form_dropdown('city_id', $options, 
								isset($item->city_id)? $item->city_id: set_value('city_id'),
								array('class' => 'form-control select2 col-sm-4'));
						?>
						<?php echo form_error('city_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>

                <div class="form-group">
					<label class="col-sm-4 control-label" for="active">Gender</label>
					<div class="col-sm-8">
						<div class="input-group">
							<div class="btn-group radio-group">
								<label class="btn btn-success <?php if($item->gender != 'Male'){ echo 'not-active'; } ?>"> Male <input type="radio" name="gender" class="hidden" value="Male" <?php if($item->gender=='Male'){echo 'checked';}?>></label>
	                			<label class="btn btn-primary <?php if($item->gender != 'Female'){ echo 'not-active'; } ?>"> Female <input type="radio" name="gender" class="hidden" value="Female" <?php if($item->gender=='Female'){echo 'checked';}?>></label>
							</div>
						</div>
						<?php echo form_error('gender', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label" for="sorting">Seniority #</label>
					<div class="col-sm-3">
						<input type="number" value="<?php echo set_value('seniority', $item->seniority);?>" name="seniority" placeholder="ex. 123" class="form-control" maxlength="10">
						<?php echo form_error('seniority', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label" for="active">Active</label>
					<div class="col-sm-8">
						<div class="input-group">
							<div class="btn-group radio-group">
								<label class="btn btn-success <?php if($item->active != 'Yes'){ echo 'not-active'; } ?>"> Yes <input type="radio" name="active" class="hidden" value="Yes" <?php if($item->active=='Yes'){echo 'checked';}?>></label>
	                			<label class="btn btn-danger <?php if($item->active != 'No'){ echo 'not-active'; } ?>"> No <input type="radio" name="active" class="hidden" value="No" <?php if($item->active=='No'){echo 'checked';}?>></label>
							</div>
						</div>
						<?php echo form_error('active', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
		        <input type="hidden" name="id" value="<?php echo set_value('id',$item->id); ?>">
		        
			</div>
		
			<div class="box-footer">
				<div class="col-sm-8 col-sm-offset-4">
					<div class="btn-group">
						<button type="submit" class="btn btn-labeled btn-primary m-r-5"><span class="btn-label"><i class="fa fa-save"></i></span>Save</button>
                    	<?php echo anchor('admin/courts/judges', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
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

	$('[data-mask]').inputmask();

    $('#datepicker-1, #datepicker-2,#datepicker-3').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
    });
});
</script>