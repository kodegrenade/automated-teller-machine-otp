<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# Request data from index

$user = $_SESSION['atm'];
$pin = $_REQUEST['textbox'];

# sanitize data
$pin = sanitizeString($pin);

# encrypt
$pin = encrypt($pin);

# send data to processor 
$new_pin = new CardPin($pin, $user);
$new_pin->user();
