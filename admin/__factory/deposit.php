<?php 

include ('../__class/class.deposit.php');

# Request bfrom index
$session = $_SESSION['code'];
$amount = $_REQUEST['amount'];

# Deposit Cash
$new_deposit = new Deposit($amount, $session);
$new_deposit->deposit_money();


?>