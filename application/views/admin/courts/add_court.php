<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!isset($item))
{
	$item = new stdClass();
	$item->id=0;
	$item->court_number='';
	$item->judge_id='';
	$item->court_type_id='';
	$item->city_id='';
	$item->user_id='';
	$item->sorting='';
}

// 	echo '<pre>';
// 	var_dump($cities);
// 	die();

?>

<div class="row">
	<div class="col-md-6">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title;?></h3>
			</div>
			
			<?php echo form_open(base_url('admin/courts/save_court'),'class="form-horizontal"'); ?>

			<div class="box-body">
			
			<div class="color-palette-set">
				<div class="alert  alert-dismissible bg-light-blue disabled color-palette">
					
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					<h4><i class="icon fa fa-info"></i> Important alert!</h4>
					If judge have transfer from this court number please only change judge name!
				</div>
			</div>
			
				<?php if ( !empty(validation_errors()) )  : ?>
                	<div class="col-sm-8 col-sm-offset-4 text-danger m-b-10">
					<?php if (!empty(validation_errors())) { echo '<strong>Please fill below required field(s).</strong>'; } ?>
				</div>                                    
                <?php endif; ?>
                
                <div class="form-group">
                	<label class="col-sm-4 control-label">Court Number</label>
                	<div class="col-sm-6">
                		<input type="text" name="court_number" value="<?php echo $item->court_number; ?>" <?php echo ($item->id!=0)? 'disabled' : null; ?> placeholder="Lahore-1" maxlength="30" class="form-control">
                		<?php echo form_error('court_number', '<div class="error">', '</div>'); ?>
                	</div>
                </div>
						
				<div class="form-group">
					<label class="col-sm-4 control-label">Judge Name</label>
					<div class="col-sm-6">
						<?php 
							$options = array();
							$options[''] = 'Please select...';
							foreach ($judgesNames as $judge) {
								$options[$judge->id] = $judge->judge_name.' '.$judge->designation ;
							}
							echo form_dropdown('judge_id', $options, 
								isset($item->judge_id)? $item->judge_id: set_value('judge_id'),
								array('class' => 'form-control select2 col-sm-4'));
						?>
						<?php echo form_error('judge_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label" for="active">Type of Court</label>
					<div class="col-sm-8">
						<div class="input-group">
							<div class="btn-group radio-group">
								<label class="btn btn-success <?php if($item->court_type_id != '1'){ echo 'not-active'; } ?>"> Sesssions <input type="radio" name="court_type_id" class="hidden" value="1" <?php if($item->court_type_id=='1'){echo 'checked';}?>></label>
	                			<label class="btn btn-primary <?php if($item->court_type_id != '2'){ echo 'not-active'; } ?>"> Civil <input type="radio" name="court_type_id" class="hidden" value="2" <?php if($item->court_type_id=='2'){echo 'checked';}?>></label>
							</div>
						</div>
						<?php echo form_error('court_type_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">City</label>
					<div class="col-sm-6">
					<select class="form-control select2" name="city_id">
                    	<option value="" selected="">Please select...</option>
							<?php
							
                            	$prev_city="not";
                            	
								foreach($cities as $city) : 
									$selected='';
									if($city->teh_id == $item->city_id){
									$selected="selected='selected'";
								}
                                                        
							?>
                                             
                            <?php
                            	if($city->city_name!=$prev_city) {
                                	echo "<optgroup label='{$city->city_name}'>";
                                                
                                	$prev_city=$city->city_name;
								}
                                        if(!empty($city->teh_id))
                                        {
                            ?>
                                            
                            			<option value="<?php echo $city->teh_id; ?>" <?php echo $selected; ?>>
                            				<?php echo $city->tehsil_name; ?>
                            			</option>
                                                        
							<?php
                            
                                        }
                                            if($city->city_name!=$prev_city){
                                            	echo "</optgroup>";
                                        }
							?>
                            
						<?php 
							endforeach;
						?>
						
					</select>
						
						<?php echo form_error('main-city', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-4 control-label">User Name</label>
					<div class="col-sm-6">
						<?php 
							$options = array();
							$options[''] = 'Please select...';
							foreach ($users as $user) {
								$options[$user->id] = $user->first_name.' '.$user->last_name. ' ('.$user->email.')';
							}
							echo form_dropdown('user_id', $options, 
								isset($item->user_id)? $item->user_id: set_value('user_id'),
								array('class' => 'form-control select2 col-sm-4'));
						?>
						<?php echo form_error('user_id', '<div class="error">', '</div>'); ?>
					</div>
				</div>
              					
				<div class="form-group">
					<label class="col-sm-4 control-label" for="sorting">Sorting order #</label>
					<div class="col-sm-3">
						<input type="number" value="<?php echo set_value('sorting', $item->sorting);?>" name="sorting" placeholder="ex. 123" class="form-control" maxlength="10">
						<?php echo form_error('sorting', '<div class="error">', '</div>'); ?>
					</div>
				</div>
				
		        <input type="hidden" name="id" value="<?php echo set_value('id',$item->id); ?>">
		        <input type="hidden" name="courtNumber" value="<?php echo $item->court_number; ?>">
		        
			</div>
		
			<div class="box-footer">
				<div class="col-sm-8 col-sm-offset-4">
					<div class="btn-group">
						<button type="submit" class="btn btn-labeled btn-primary m-r-5"><span class="btn-label"><i class="fa fa-save"></i></span>Save</button>
                    	<?php echo anchor('admin/courts', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
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