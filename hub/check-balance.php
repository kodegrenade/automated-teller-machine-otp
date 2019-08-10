<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user data
$user = $_SESSION['email'];

# Request data from index
$bal = $_REQUEST['balance'];

# sanitize data
$bal = sanitizeString($bal);

# send data to processor 
$new_digit = new Balance($user, $bal);
$new_digit->check();