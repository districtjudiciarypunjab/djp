<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

            	</section>
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b><?php echo lang('footer_version'); ?></b> 1.0.0
                </div>
                <strong><?php echo lang('footer_copyright'); ?> &copy; <?php echo date('Y'); ?> <a href="http://warisdev.com" target="_blank">WarisDev</a> &amp; <a href="https://www.linkedin.com/in/shahid-muneer-825689119/">Shahid</a>.</strong> <?php echo lang('footer_all_rights_reserved'); ?>.
            </footer>
        </div>

        <!-- THIS PAGE PLUGINS -->
<?php if (isset($js_files)) : ?>
<?php foreach ($js_files as $js) : ?>
	 <script src="<?php echo base_url($frameworks_dir.$js); ?>"></script>
<?php endforeach; ?>
<?php endif;?>
<!-- END PAGE PLUGINS --> 
        <script src="<?php echo base_url($plugins_dir . '/slimscroll/slimscroll.min.js'); ?>"></script>
<?php if ($mobile == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/fastclick/fastclick.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($admin_prefs['transition_page'] == TRUE): ?>
        <script src="<?php echo base_url($plugins_dir . '/animsition/animsition.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'users' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/pwstrength/pwstrength.min.js'); ?>"></script>
<?php endif; ?>
<?php if ($this->router->fetch_class() == 'groups' && ($this->router->fetch_method() == 'create' OR $this->router->fetch_method() == 'edit')): ?>
        <script src="<?php echo base_url($plugins_dir . '/tinycolor/tinycolor.min.js'); ?>"></script>
        <script src="<?php echo base_url($plugins_dir . '/colorpickersliders/colorpickersliders.min.js'); ?>"></script>
<?php endif; ?>
        <script src="<?php echo base_url($frameworks_dir . '/adminlte/js/adminlte.min.js'); ?>"></script>
        <!--  <script src="<?php echo base_url($frameworks_dir . '/domprojects/js/dp.min.js'); ?>"></script> -->
<!-- THIS PAGE PLUGINS -->
<?php if (isset($custom_js)) : ?>
<?php foreach ($custom_js as $js) : ?>
	 <script src="<?php echo base_url($frameworks_dir.$js); ?>"></script>
<?php endforeach; ?>
<?php endif;?>
<!-- END PAGE PLUGINS -->   
    </body>
</html>