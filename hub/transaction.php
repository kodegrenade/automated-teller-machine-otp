<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user dat
$user = $_SESSION['email'];
$id = $_SESSION['account_no'];

# Request data from index
$option = $_REQUEST['option'];

# sanitize data
$option = sanitizeString($option);

# send data to processor 
$new_transact = new Transactions($option, $user);
$new_transact->transactType();