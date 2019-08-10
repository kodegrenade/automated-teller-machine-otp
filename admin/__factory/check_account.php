<?php

include ('../__class/class.transfer-funds.php');

// get the q parameter from URL
$account_no = $_REQUEST["q"];

// check account in database

$new_chk = new AccountCheck($account_no);
$new_chk->checkAccount();