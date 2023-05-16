<?php


ob_start();
$error = $this->session->flashdata('error');
if ($error) {
  echo '<div class="alert alert-warning">';
  echo $error;
  echo '</div>'."\n";
}
?>
<form role="form" method="post" name="pathfinder-form" id="pathfinder-form" action="<?php echo site_url('/taxonomy/save/'.$type) ?>">
<?php echo create_bootstrap_input('text', 'name', array(), 'Term Name', '', '', isset($record->name)?$record->name:'', '', 'Name of term', true) ?>
<?php echo create_bootstrap_input('text', 'description', array(), 'Description', '', '', isset($record->description)?$record->description:'', '', 'Description/qualifier of term') ?>
<?php
  $weight_options = array();
  for ($i = -50; $i < 51; $i++ ) { $weight_options[$i] = $i; }
  
  echo create_bootstrap_input('select', 'weight', $weight_options, 'Weight', '', '', isset($record->weight)?$record->weight:'', 'style="width: 75px;"', 'Weight for term');
?>
<input type="hidden" name="type" value="<?php echo $type ?>" />
<?php
  if (isset($update_ID)) {
    echo text_input('hidden', 'update_ID', '', '', $update_ID);
    echo text_input('button', 'cancel', 'btn btn-warning', '', 'Cancel', 'onclick="javascript: history.back()"');
    echo '&nbsp;';
  }
  echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Term');
?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>