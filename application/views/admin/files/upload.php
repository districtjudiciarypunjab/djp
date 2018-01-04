<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

                    <div class="row">
                        <div class="col-md-12">


<ul>
<?php foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
</ul>

<p><?php echo anchor('admin/files', 'Upload Another File!'); ?></p>




                        </div>
                    </div>
                </section>