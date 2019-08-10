<?php 

include ('../__class/class.login.php');

# Request from index
$email = $_REQUEST['email'];
$code = $_REQUEST['code'];

$email = sanitizeString($email);
$code = sanitizeString($code);

$code = md5(sha1($code));

# Login User 
$new_login = new Login($email, $code);
$new_login->login_user();