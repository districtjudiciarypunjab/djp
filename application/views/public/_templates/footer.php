<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
        </div>

        <script src="<?php echo base_url($frameworks_dir . '/jquery/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url($frameworks_dir . '/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/icheck/js/icheck.min.js'); ?>"></script>
<!-- THIS PAGE PLUGINS -->
<?php if (isset($js_files)) : ?>
<?php foreach ($js_files as $js) : ?>
	 <script src="<?php echo base_url($js); ?>"></script>
<?php endforeach; ?>
<?php endif;?>
<!-- END PAGE PLUGINS -->        
        <script>
            $(function(){
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
            });
        </script>
    </body>
</html>