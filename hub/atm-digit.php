<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# Request data from index

$digit = $_REQUEST['textbox'];

# sanitize data
$digit = sanitizeString($digit);

# send data to processor 
$new_digit = new ATMDIGITS($digit);
$new_digit->validateDigit();