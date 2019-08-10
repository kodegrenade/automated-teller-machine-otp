<?php

/* JTTF Function........ */
/* version: 1.0.0 */
/* Core connection function */

//start base
ob_start();
session_start();

function dateSet($date)
{
	$format = "M D Y";
	$date = date($format, $date);
	return $date;
}

function encrypt($data)
{
	$data = md5(sha1($data));
	return $data;
}

function sanitizeString($data)
{
	$data = trim($data);
	$data = strip_tags($data); 
	$data = stripslashes($data); 
	$data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
	return $data;
}

//check user login panel
function login_user(){
	if(isset($_SESSION['atm']) && isset($_SESSION['name'])){
		if(!empty($_SESSION['atm']) && !empty($_SESSION['name'])){
			return TRUE;
		}else{
			return FALSE;
		}	
	}
} /*login hanlder*/


//check user login panel
function loginAdmin(){
	if(isset($_SESSION['email']) && isset($_SESSION['account_no']) && isset($_SESSION['name'])){
		if(!empty($_SESSION['email']) && !empty($_SESSION['account_no']) && !empty($_SESSION['name'])){
			return TRUE;
		}else{
			return FALSE;
		}	
	}
} /*login hanlder*/
?>