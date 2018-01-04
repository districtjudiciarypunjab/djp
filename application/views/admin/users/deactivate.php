<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
                    <div class="row">
                        <div class="col-md-12">
                             <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo sprintf(lang('users_deactivate_question'), '<span class="label label-primary">'.$firstname.$lastname).'</span>';?></h3>
                                </div>
                                <div class="box-body">
                                    <?php echo form_open('admin/users/deactivate/'. $id, array('class' => 'form-horizontal', 'id' => 'form-status_user')); ?>
                                        
                                        <div class="form-group m-t-20">
											<label class="col-sm-4 control-label" for="active">Are you sure? </label>
											<div class="col-sm-8">
												<div class="input-group">
													<div class="btn-group radio-group">
														<label class="btn btn-success"> Yes <input type="radio" id="confirm1" name="confirm" checked="checked" class="hidden" value="yes"></label>
							                			<label class="btn btn-danger not-active"> No <input type="radio" id="confirm0" name="confirm" class="hidden" value="no"></label>
													</div>
												</div>
											</div>
										</div>
										
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-8 m-t-20">
                                                <?php echo form_hidden($csrf); ?>
                                                <?php echo form_hidden(array('id'=>$id)); ?>
                                                <div class="btn-group">
                                                    <?php echo form_button(array('type' => 'submit', 'class' => 'btn btn-primary btn-flat', 'content' => lang('actions_submit'))); ?>
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
	$('.radio-group label').on('click', function(){
        $(this).removeClass('not-active').siblings().addClass('not-active');
    });
});
</script>