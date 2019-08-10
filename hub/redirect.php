<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# stored account number
$_SESSION['account'];

# Request amount
$amount = $_REQUEST['amount'];

$_SESSION['amount'] = $amount;

echo '<script>
	window.location.href = "transfer-after.php";
</script>';