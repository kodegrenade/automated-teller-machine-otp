<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user data
$user = $_SESSION['email'];

# Request data from index
$amount = $_REQUEST['btn'];

# sanitize data
$amount = sanitizeString($amount);

# send data to processor 
$new_digit = new Withdrawal($amount, $user);
$new_digit->otpCheck();
$new_digit->deductCash();