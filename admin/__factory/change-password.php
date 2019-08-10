<?php 

include ('../__class/class.change_password.php');

# get from form index
$new_password = $_REQUEST['newPassword'];
$old_password = $_REQUEST['oldPassword'];

# encrypt password
$old_password_hash = md5(sha1($old_password));
$new_password_hash = md5(sha1($new_password));

# [global]
$user_id = $_SESSION['code'];

# insert 
$update_password = new UpdatePassword($old_password_hash, $new_password_hash, $user_id);
$update_password->update();

?>