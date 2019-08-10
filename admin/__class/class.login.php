<?php

include ('../__config/core.php');
include ('../__functions/functions.php');

/**
* Login Class
*/
class Login extends DBconnect
{
	protected $plug;
	protected $email;
	protected $code;

	public function __construct($email, $code)
	{
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# Expected Variables
		$this->email = $email;
		$this->code = $code;
	}

	public function login_user()
	{
		# Check Account Holder
		$check_account = "SELECT * FROM users WHERE";
		$check_account .= "(email = '".$this->email."' AND pin_code = '".$this->code."')";
		$check_account_query = mysqli_query($this->plug, $check_account);

		if (!$check_account_query)
		{
			# code...
			echo 'Error Connecting to your Account';
		}elseif (!mysqli_num_rows($check_account_query))
		{
			# code...
			echo '<span class="alert alert-danger">Invalid login Details, Try Again</span> <br />';
		}else{

			while ($details = mysqli_fetch_assoc($check_account_query))
			{
				# code...
				extract($details);

				$email = $details ['email'];
				$code = $details ['code'];

				$_SESSION['email'] = $email;
				$_SESSION['code'] = $code;

				echo '
				<script>;
					window.location.href = "home.php";
				</script>';
			}
		}
	}
}
