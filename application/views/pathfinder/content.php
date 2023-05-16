<?php


ob_start();
?>
<div class="row">
  
<div class="col-md-12">

<div class="panel panel-primary resource-type">
  <div class="panel-body">
    <?php echo $content ?>
  </div>
</div>

</div>

</div>

<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>