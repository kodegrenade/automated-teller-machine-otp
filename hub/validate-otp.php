<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user data
$user = $_SESSION['email'];

# Request data from  index
$otp = $_REQUEST['textbox'];

# sanitize data
$otp = sanitizeString($otp);

if (!empty($_SESSION['account'])) {
	# code...

	$account = $_SESSION['account'];
}else{

	$account = "";
}

# send data to processor
$valid_otp = new ValidateOtp($otp, $user, $account);
$valid_otp->checkOtp();
$valid_otp->transactType();