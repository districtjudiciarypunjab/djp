<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

                    <div class="row">
                        <div class="col-md-6">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo lang('users_create_user'); ?></h3>
                                </div>
                                <div class="box-body">
                                	<p><?php echo lang('create_user_subheading'); ?></p>
                                	
                                	<?php if ( !empty(validation_errors()) )  : ?>
                                	<div class="col-sm-8 col-sm-offset-4 text-danger m-b-10">
										<?php if (!empty(validation_errors())) { echo '<strong>Please fill below required field(s).</strong>'; } ?>
										<?php echo $message; ?>
									</div>                                    
                                    <?php endif; ?>

                                    <?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'form-create_user')); ?>
                                        <div class="form-group">
                                            <?php echo lang('users_firstname', 'first_name', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($first_name);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_lastname', 'last_name', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($last_name);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_username', 'user_name', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($username);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
											<label class="col-sm-4 control-label">City</label>
											<div class="col-sm-8">
												<?php 
													$options = array();
													$options[''] = 'None';
													foreach ($cities as $city) {
														$options[$city->id] = $city->city_name;
													}
													echo form_dropdown('city_id', $options, set_value('city_id'),
														array('class' => 'form-control col-sm-4 selectpicker', 'data-live-search' => 'true'));
												?>
											</div>
										</div>
                                        <div class="form-group">
                                            <?php echo lang('users_company', 'company', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($company);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_email', 'email', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($email);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_phone', 'phone', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                            	<div class="input-group">
                                            		<div class="input-group-addon"><i class="fa fa-phone"></i></div>
                                                	<?php echo form_input($phone);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_password', 'password', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($password);?>
                                                <div class="progress" style="margin:0">
                                                    <div class="pwstrength_viewport_progress"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?php echo lang('users_password_confirm', 'password_confirm', array('class' => 'col-sm-4 control-label')); ?>
                                            <div class="col-sm-8">
                                                <?php echo form_input($password_confirm);?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8">
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
                                                    <?php echo form_button(array('type' => 'reset', 'class' => 'btn btn-warning btn-flat', 'content' => lang('actions_reset'))); ?>
                                                    <?php echo anchor('admin/users', lang('actions_cancel'), array('class' => 'btn btn-default btn-flat')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
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