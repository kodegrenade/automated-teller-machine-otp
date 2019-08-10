<?php

include ('../__config/core.php');
include ('../__functions/functions.php');

/**
* Create Account Class
*/
class CreateAccount extends DBconnect
{
	protected $plug;
	protected $name;
	protected $acc_type;
	protected $email;
	protected $phone;
	protected $account_no;
	protected $code;

	public function __construct($name, $email, $phone, $acc_type)
	{
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# Expected variables
		$this->name     = $name;
		$this->acc_type = $acc_type;
		$this->email    = $email;
		$this->phone =  $phone;

		# Defaults variables
		$this->account_no = "201014".mt_rand(0000, 9999);
		$this->code       = "PHP-Bank"."-".rand(0000, 9999);
		$this->bvn_no     = "PHP-BVN: 0021"."-".mt_rand(000, 999);
		$this->pin_code   = md5(sha1(1234));
		$this->balance    = '0000000'.'.00';
		$this->atm_digit  = rand(0000, 9999);

		if (strlen($this->atm_digit) < 4) {
			
			# code...
			$this->atm_digit = $this->atm_digit.'0';
		}
	}

	public function create_user()
	{
		# check email
		$check_email         = " SELECT * FROM users WHERE ";
		$check_email        .= " (email = '".$this->email."') ";
		$check_email_query   = mysqli_query($this->plug, $check_email);
		$check_email_result  = mysqli_num_rows($check_email_query);

		/* check query instead of command string */
		if (!$check_email_query)
		{
			// if query did not run
			echo "Error proccessing query for checking already signup email";

		}elseif ($check_email_result > 0){

			// now query run but user already exists
			echo "<span style='color: red;'>Email already exists </span>";

		}else{

			# Create User Account
			$create_account  = " INSERT INTO `USERS`( ";
			$create_account .= " name, email, phone, account_type, ";
			$create_account .= " account_no, account_bal, code, pin_code, atm_digit) ";
			$create_account .= " VALUES ('".$this->name."', '".$this->email."', '".$this->phone."', ";
			$create_account .= " '".$this->acc_type."', '".$this->account_no."', ";
			$create_account .= " '".$this->balance."', '".$this->code."', '".$this->pin_code."', '".$this->atm_digit."')";
			$create_account_query = mysqli_query($this->plug, $create_account);

			if (!$create_account_query)
			{
				// here i catch the error using the mysqli_error method
				echo "Error Creating Account, Please Try Again <br />".mysqli_error($this->plug); 

			}elseif (mysqli_affected_rows($this->plug)){
				# code...
				echo '<div class="panel-primary">';
				echo '<div class="panel-heading">Account Details</div>';
				echo '<div class="panel-body">';
				echo '<b>Hello</b>, '.$this->name.'<br />';
				echo '<hr />';
				echo 'Your Account has been Created <br />';
				echo '<span class="fa fa-money"> Your Account number:  '.$this->account_no.' <br />';
				echo '<span class="fa fa-card">Your ATM digits: '.$this->atm_digit.'<br />';
			}
		}
	}

	public function validate_account()
	{
		# Check Account & Validate user account

		$valid_check        = " SELECT * FROM valid_account WHERE ";
		$valid_check       .= " (email = '".$this->email."') ";
		$valid_check_query  = mysqli_query($this->plug, $valid_check);
		$valid_check_result = mysqli_num_rows($valid_check_query);

		if (!$valid_check_query)
		{
			// check if query fail to run...
			echo 'Error Validating account Query <br />'.mysqli_error($this->plug);

		}elseif ($valid_check_result > 0){ //greater than z3r0 means something was found

			// check if account not found...
			echo '<span style="color: red;">Account already validated i guess.</span>';
		}else{

			// create a new valid account 
			$validated_acc  = " INSERT INTO valid_account ";
			$validated_acc .= " (bvn_no, name, email, account_type, ";
			$validated_acc .= " account_no, code, pin_code, atm_digit) ";
			$validated_acc .= " VALUES ('".$this->bvn_no."', '".$this->name."', ";
			$validated_acc .= " '".$this->email."', '".$this->acc_type."',  "; 
			$validated_acc .= " '".$this->account_no."', '".$this->code."', '".$this->pin_code."', '".$this->atm_digit."')";
			$validated_acc_query = mysqli_query($this->plug, $validated_acc);

			if (!$validated_acc_query)
			{
				echo 'Error processing validation request query '.mysqli_error($this->plug);
			}elseif(mysqli_affected_rows($this->plug)){
				# code...
				echo '<span class="glyphicon glyphicon-ok">Account Validated</span><br />';
				echo '<span class="fa fa-lock">Your defualt pin: 1234 </span><br />';
				echo '<a href="login.php">Login Now</a> to change pin and Perform Transactions<br />';
				echo '</div>';
				echo '<div class="panel-footer">GT Bank</div>';
				echo '</div>';
			}else{
				// if no rows was affected 
				// echo 'Your Account can not be validated now, please try again';
				echo '<br />';
				echo 'Your Account can not be validated now, please try again';	
			}
		}
	}
}
