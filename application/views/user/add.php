<?php

ob_start();
?>
<form role="form" name="user-form" id="user-form" method="post" action="<?php echo site_url('/user/save') ?>">
<?php echo create_bootstrap_input('text', 'realname', array(), 'Real name', '', '', isset($record->realname)?$record->realname:'', '', 'Real name of user', true) ?>
<?php echo create_bootstrap_input('text', 'username', array(), 'Login username', '', '', isset($record->username)?$record->username:'', '', 'Name to be used on login page', true) ?>
<?php echo create_bootstrap_input('text', 'email', array(), 'E-mail', '', '', isset($record->email)?$record->email:'', '', 'E-mail', true) ?>
<?php
$group_options['Patron'] = 'Library Patron/User';
$group_options['Librarian'] = 'Librarian';
echo create_bootstrap_input('select', 'groups', $group_options, 'Group', '', '', isset($record->groups)?$record->groups:'', '', 'Group for this user', true);
?>
<?php echo create_bootstrap_input('password', 'passwd', array(), 'Password', '', '', '', '', 'Password (case sensitive)', true) ?>
<?php echo create_bootstrap_input('password', 'passwd2', array(), 'Password Confirmation', '', '', '', '', 'Password Confirmation, must be exactly same with Password', true) ?>
<?php

  if (isset($update_ID)) {
    echo text_input('hidden', 'update_ID', '', '', $update_ID);
  }
?>
<?php echo text_input('submit', 'save', 'btn btn-primary', '', 'Save Resource') ?>
</form>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>