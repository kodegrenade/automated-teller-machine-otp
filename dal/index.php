<?php

# session authenticator
include ("../auth/functions.php");

session_unset();

if (session_destroy()) {
	# code...
	header("location: ../index.php");
}