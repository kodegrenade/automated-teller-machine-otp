<?php

session_start();
if (session_destroy()) // Destroying All sessions
{
	header("Location: login.php"); // Redirecting to Home Page
}

?>