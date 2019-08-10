<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user data
$user = $_SESSION['email'];

# Request data from index
$pin = $_REQUEST['pin'];

# sanitize data
$pin = sanitizeString($pin);

# encrypt new pin
$pin = encrypt($pin);

# send data to processor 
$new_pass = new ChangePin($user, $pin);
$new_pass->change();
