<?php

$site_name_data = $this->Pathfinder_model->getConfig('site_name');
$contact_data = $this->Pathfinder_model->getConfig('content.contact');
$homepage_data = $this->Pathfinder_model->getConfig('content.homepage');
$site_logo = $this->Pathfinder_model->getConfig('site_logo');
ob_start();
?>
<form role="form" method="post" name="pathfinder-form" id="pathfinder-form" enctype="multipart/form-data" action="<?php echo site_url('/pathfinder/config/save') ?>">
<?php echo create_bootstrap_input('text', 'site_name', array(), 'Site name', '', '', isset($site_name_data['site_name'])?$site_name_data['site_name']:'', '', 'Name of this pathfinder site') ?>
<?php echo create_bootstrap_input('textarea', 'contact', array(), 'Contact Information', '', '', isset($contact_data['content.contact']['content'])?$contact_data['content.contact']['content']:'', '', 'Library/Librarian contact information') ?>
<?php echo create_bootstrap_input('textarea', 'homepage', array(), 'Homepage Information', '', '', isset($homepage_data['content.homepage']['content'])?$homepage_data['content.homepage']['content']:'', '', 'Information that appears on the homepage') ?>
<?php echo create_bootstrap_input('file', 'site_logo', array(), 'Image', '', '', '', '', 'Optional site logo') ?>
<?php echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Configuration') ?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>