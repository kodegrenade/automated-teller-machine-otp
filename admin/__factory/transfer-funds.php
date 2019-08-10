<?php 

include ("../__class/class.transfer-funds.php");

# Request  Data from index
$account_no = $_REQUEST['account_no'];
$amount = $_REQUEST['amount'];
$user_id = $_SESSION['code'];

# Transfer Funds
$new_transfer = new Transact($account_no, $amount, $user_id);
$new_transfer->deductCash();

