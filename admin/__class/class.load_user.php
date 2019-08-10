<?php

include ('__config/core.php');

/**
* Load user
*/

# Session to retrieve logged in user;
$user_id = $_SESSION['code'];

class LoadUser extends DBconnect
{
	public $session;

	public function __construct($session)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		global $user_id;

		$this->session =& $user_id;
	}

	public function load_details()
	{
		$load_user = "SELECT * FROM users WHERE";
		$load_user .= "(code = '".$this->session."')";
		$load_user_query = mysqli_query($this->plug, $load_user);

		while ($details = mysqli_fetch_assoc($load_user_query))
		{
			# code...
			extract($details);
			echo '<div class="panel-success">';
			echo '<div class="panel-heading"><h4>Account details</h4></div>'.'<br />';
			echo '<div class="panel-body">';
			echo '<b>Account Holder Name:</b> '.$details['name'].'<br />';
			echo '<b>Account Type:</b> '.$details['account_type'].'<br />';
			echo '<b>Account Number:</b> '.$details['account_no'].'<br />';
			echo '<b>Email Address:</b> '.$details['email'].'<br />';
			echo '<b>ATM Card Digits:</b> '.$details['atm_digit'].'<br />';
		}
	}

	public function load_validation()
	{
		$load_validation = "SELECT * FROM valid_account WHERE";
		$load_validation .= "(code = '".$this->session."')";
		$load_validation_query = mysqli_query($this->plug, $load_validation);

		while ($status = mysqli_fetch_assoc($load_validation_query))
		{
			echo '<b>BVN Number:</b> '.$status['bvn_no'];
			echo '</div>';
			echo '<div class="panel-footer"></div>';
			echo '</div>';
		}
	}
}

$new_user =  new LoadUser($user_id);
$new_user->load_details();
$new_user->load_validation();
