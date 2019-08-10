<?php

include ("../auth/functions.php");
include ("../auth/processor.php");

# Request data from index

$acc = $_REQUEST['textbox'];

# sanitize data
$digit = sanitizeString($acc);