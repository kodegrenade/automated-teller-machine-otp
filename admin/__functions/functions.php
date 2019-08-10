<?php  

//session_start();

# validate username
function validateUsername($username)
{
	if (!preg_match("#^[a-zA-Z0-9 ]+$#", $username))
	{
		echo $username;	
	}else{
		$error = '<span class="alert-danger">invalid username, username must be letters and numbers only</span>';
	}
}

# filter Strings
function sanitizeString($data)
{
	$data = strip_tags($data);
	$data = stripslashes($data);
	$data = trim($data);
	$data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
    return $data;
}

//check user login panel
function login_admin(){
    if(isset($_SESSION['email']) && isset($_SESSION['code'])){
        if(!empty($_SESSION['email']) && !empty($_SESSION['code'])){
            return TRUE;
        }else{
            return FALSE;
        }
    }
} /*login hanlder*/

?>