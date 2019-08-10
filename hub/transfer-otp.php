<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user data
$user = $_SESSION['email'];

# Request data from index
$amount = $_REQUEST['amount'];
$account = $_REQUEST['account'];
$type = "transfer";

# sanitize data
$amount = sanitizeString($amount);

# one time password
$otp_number = rand(0000, 9999);

# send data to processor
$new_otp = new OTP($user, $amount, $type, $otp_number);
$new_otp->userPhone();
$new_otp->sendOtp();
$new_otp->createOtp();