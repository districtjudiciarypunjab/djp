<?php	defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $sub_title; ?></h3>
			</div>
                    
			<?php if ( !empty(validation_errors()) )  : ?>
            	<div class="col-sm-8 col-sm-offset-4 text-danger m-b-10">
					<?php if (!empty(validation_errors())) { echo '<strong>Please fill below required field(s).</strong>'; } ?>
					<?php echo $message;?>
				</div>                                    
			<?php endif; ?>
               
			<div class="box-body">
					
				<?php echo form_open(base_url('district/cases/save'),'class="form-horizontal"'); ?>
                            
				<div class="col-sm-6">
					<div class="form-group">
						<label class="col-sm-4 control-label">Judge Name</label>
						<div class="col-sm-8">
							<?php 
								$options = array();
								$options[''] = 'Please select...';
								foreach ($courts as $court) {
									$options[$court->id] = $court->judge_name.' '.$court->designation ;
								}
								echo form_dropdown('heading[court_id]', $options, 
									isset($item->court)? $item->court_id: set_value('court_id'),
									array('class' => 'form-control select2',"id"=>"court_id"));
							?>
							<?php echo form_error('court_id', '<div class="error">', '</div>'); ?>
						</div>
					</div>
						
					<div class="form-group">
						<label class="col-sm-4 control-label"><?php echo lang("cases_select_date"); ?>:</label>
						<div class="col-sm-8">
							<input id="date-of-report" name="heading[date_of_report]" type="text" class="form-control datepicker" placeholder="<?php echo lang("cases_select_date"); ?>">
						</div>
					</div>
						
					
                                </div>
						
                       <table id="dataTable" class="table table-bordered">
                	
                        	<thead>
                        		
                    			<tr>
                        			<th rowspan="2">SELECT CATEGORY</th> 
                    				<th rowspan="2">ENTER FRESH CASES</th>
                    				<th class="text-center" colspan="2">DECIDED CASES</th>
                    				<th class="text-center" rowspan="2">TRANSFER CASES</th>
                                                <th class="text-center" rowspan="2">RECEIVE BY TRANSFER CASES</th>
                    				<th rowspan="2"></th>                   
					</tr>
								<tr>
									
                    				<th>CONTESTED CASES</th>
                    				<th>UNCONTESTED CASES</th>
                    				  
								</tr>
								
							</thead>
							
							<tbody>
					
                    			<tr>
                                    <td >
                                        	
										<?php 
										$options = array();
										$options[''] = 'None';
			                                                        
										foreach ($categories as $cat) {
											$options[$cat->id] = $cat->cat_name;
										}
										echo form_dropdown('heading[category_id][]', $options
											,"",
											array('class' => 'form-control',"id"=>"category_id"));
									?>
									<?php echo form_error('category_id', '<div class="error">', '</div>'); ?>
				
                                    
                                    </td>            
	                                <td><input type="number" name="heading[fresh][]" value="" id="fresh" placeholder="Fresh i.e: 123"  class="form-control"></td>
	                                <td><input type="number" name="heading[contested][]" value="" id="contested" placeholder="Contested i.e: 123"  class="form-control"></td>
	                                <td><input type="text" name="heading[uncontested][]" value="" id="uncontested" placeholder="uncontested i.e: 123"  class="form-control"></td>
	                                <td><input type="number" name="heading[transfer][]" value="" id="transfer" placeholder="transfered  i.e: 123"  class="form-control"></td>
	                                <td><input type="number" name="heading[received][]" value="" id="received" placeholder="Received i.e: 123"  class="form-control"></td>
                                
                                	<td class="buttons">
                                		<span class="btn btn-primary btn-sm  btn-add"><i class="fa fa-plus fa-2x "></i></span>
                            		</td>
								</tr>
								
                    		</tbody>
						</table>
			
					
						
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<input type="submit" value="<?php echo lang("cases_save_info"); ?>" class="btn btn-lg btn-info">
						</div>
					</div>
						
				
                            
				<?php echo form_close(); ?>
                            
			</div>
		</div>
	</div>
</div>

<script>

$(document).ready(function(){
$(".datepicker").datepicker();
$('.select2').select2();

var prevoiusEntry = $("body").find('tbody tr:first');

$(document).on("click",".btn-add",function(){

    if($("#heading").val()==""){
        alert("Heading Cannot be empty");
        return false;
    }
    
        var controlForm = $('tbody'),
            currentEntry = $(this).parents('tbody tr:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('tr:not(:last) .buttons .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .find(".fa-plus").removeClass("fa-plus").addClass("fa-remove");
    
    
}).on('click','.btn-remove', function()
    {
		$(this).parents('tr').remove();

		
	});
        
       $("#date-of-report").on("change",function(){
           $("body #dataTable>tbody").html(prevoiusEntry);
          
  waitingDialog.show("Please wait...");
  var controlForm = $('body #dataTable > tbody'),
            currentEntry = $("body").find('#dataTable>tbody tr:first');
            var newEntry="";
       $.ajax({
           type:"POST",
           url:"<?php echo base_url("district/cases/getJsonReport"); ?>",
           data:{date_of_report:$("#date-of-report").val(),court_id:$("#court_id").val()},
           success:function(data){

$.each(data,function(i,e){
 
            newEntry = $(currentEntry.clone()).prependTo(controlForm);
            
        newEntry.find('select option[value="'+e.category_id+'"]').attr("selected","selected");
newEntry
        .find("#contested").val(e.contested);
newEntry
        .find("#fresh").val(e.fresh);

newEntry
        .find("#uncontested").val(e.uncontested);
newEntry
        .find("#transfer").val(e.transfer);
newEntry=newEntry
        .find("#received").val(e.received);
        controlForm.find('tr:not(:last) .buttons .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .find(".fa-plus").removeClass("fa-plus").addClass("fa-remove");
    
});



    waitingDialog.hide();
           },
           dataType:"JSON",
   
    error: function (jqXHR, exception) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        console.log(msg);
    },
       })
       
       
   })
  
function freez(){
    $("#heading").attr("disabled",true);
    $("#date-of-report").attr("disabled",true);
}

});



var waitingDialog = waitingDialog || (function ($) {
    'use strict';

	
	var $dialog = $(
		'<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
		'<div class="modal-dialog modal-m">' +
		'<div class="modal-content">' +
			'<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
			'<div class="modal-body">' +
				'<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
			'</div>' +
		'</div></div></div>');

	return {
		
		show: function (message, options) {
			
			if (typeof options === 'undefined') {
				options = {};
			}
			if (typeof message === 'undefined') {
				message = 'Loading';
			}
			var settings = $.extend({
				dialogSize: 'm',
				progressType: '',
				onHide: null 
			}, options);

		
			$dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
			$dialog.find('.progress-bar').attr('class', 'progress-bar');
			if (settings.progressType) {
				$dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
			}
			$dialog.find('h3').text(message);
		
			if (typeof settings.onHide === 'function') {
				$dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
					settings.onHide.call($dialog);
				});
			}
		
			$dialog.modal();
		},
		
		hide: function () {
			$dialog.modal('hide');
		}
	};

})(jQuery);


</script>