<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# user data
$user = $_SESSION['name'];

# Request data from index
$acc = $_REQUEST['account'];

# sanitize data
$acc = sanitizeString($acc);

# send data to processor
$new_account = new Account($acc);
$new_account->checkAccount();