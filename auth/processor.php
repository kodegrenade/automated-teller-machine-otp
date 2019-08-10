<?php

# Secure atm using otp
# Processor script
# Dev: Temitope Ayotunde (codegrenade)

# Connection and SMS API
include ("sms.php");
include ("core.php");

/**
 * ATM DIGITS
 */
class ATMDIGITS extends DBconnect
{
	protected $plug;
	protected $digits;
	
	public function __construct($digits)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data
		$this->digits = $digits;
	}

	public function validateDigit()
	{
		# check atm digit
		$check_atm_digit  = "SELECT * FROM users WHERE";
		$check_atm_digit .= "(atm_digit = '".$this->digits."')";
		$check_atm_digit_query = mysqli_query($this->plug, $check_atm_digit);

		if (!$check_atm_digit_query) {
			# code...
			echo 'Error checking Atm digits';
		}elseif (mysqli_num_rows($check_atm_digit_query) === 0) {
			# code...
			echo '<h4><span class="alert-danger">Invalid card number, Try again!<span></h4>';

			echo '<script>
				var timer = function(){
					window.location.href = "";
				};
				setInterval(timer, 5000);
			</script>';
		}else {

			while ($details = mysqli_fetch_array($check_atm_digit_query)) {
				# code...
				extract($details);

				# set initial session
				$atm = $details['atm_digit'];
				$name = $details['name'];

				# user session
				$_SESSION['atm'] = $atm;
				$_SESSION['name'] = $name;

				echo '<script>
					window.location.href = "pin.php";
				</script>';
			}
		}
	}
}


/**
 * Card Pin
 */
class CardPin extends DBconnect
{
	protected $plug;
	protected $pin;
	protected $user; // transfered from the first page
	
	public function __construct($pin, $user)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data 
		$this->pin = $pin;
		$this->user = $user;
	}

	public function user()
	{
		# validate user card pin
		$check_pin  = "SELECT * FROM users WHERE";
		$check_pin .= "(pin_code = '".$this->pin."') AND (atm_digit = '".$this->user."')";
		$check_pin_query = mysqli_query($this->plug, $check_pin);

		if (!$check_pin_query) {
			# code...
			echo 'Error running card validation query!!';
		}elseif (mysqli_num_rows($check_pin_query) === 0) {
			# code...
			echo '<h4><span class="alert-danger">Invalid pin, Try again!!</span></h4>';

			# reload page
			echo '<script>
				var timer = function(){
					window.location.href = "";
				};
				setInterval(timer, 5000);
			</script>';
		}else{

			while ($details = mysqli_fetch_array($check_pin_query)) {
				# code...
				extract($details);

				$pin = $details['pin_code'];
				$acct  = $details['account_no'];
				$email = $details['email'];
				$name = $details['name'];

				$_SESSION['email'] = $email;
				$_SESSION['account_no'] = $account_no;
				$_SESSION['name'] = $name;

				echo '<script>
					window.location.href = "transactionlist.php";
				</script>';
			}
		}
	}
}


/**
 * Transactions
 */
class ValidateOtp extends DBconnect
{
	protected $plug;
	protected $user; // value from the interface button
	protected $otp;
	
	public function __construct($otp, $user, $account)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data 
		$this->otp = $otp;
		$this->user = $user;
		$this->account = $account;

		# defualts
		$this->com = "Used";
		$this->status = "Unused";
		$this->otp_type = "";
		$this->otp_amount = "";
		$this->tran_id = "PHP-Bank-".rand(00, 99);
	}

	public function checkOtp()
	{
		# validate otp and get transaction type
		$validate_opt  = "SELECT * FROM otp WHERE";
		$validate_opt .= "(otp_code = '".$this->otp."') AND (otp_status = '".$this->status."' ) AND (otp_user =  '".$this->user."')";
		$validate_opt_query = mysqli_query($this->plug, $validate_opt);

		if (!$validate_opt_query) {
			# code...
			echo 'One time password validation failed'.mysqli_error($this->plug);;
		}elseif (mysqli_num_rows($validate_opt_query) === 0) {
			# code...
			echo '<h4><span class="alert-danger">Invalid one time password!!</span></h4><br>';

			# reload message
			echo '<script>
				var timer = function(){
					window.location.href = "otp.php";
				};
				setInterval(timer, 5000);
			</script>';
		}else{

			while ($details =  mysqli_fetch_array($validate_opt_query)) {
				# code...
				extract($details);

				$this->otp_type = $details['otp_type'];
				$this->otp_amount = $details['otp_amount'];
			}
		}
	}

	public function transactType()
	{

		switch ($this->otp_type) {
			case 'withdrawal':
				# make widthdrawal
					$make_withdrawal  = "SELECT * FROM users WHERE";
					$make_withdrawal .= "(email = '".$this->user."')";
					$make_withdrawal_query = mysqli_query($this->plug, $make_withdrawal);

					if (!$make_withdrawal_query) {
						# code...
						echo 'Error with Withdrawal query';
					}else{

						while ($details = mysqli_fetch_array($make_withdrawal_query)) {
							# code...
							extract($details);

							$balance = $details['account_bal'];

							if (empty($balance)) {
								# code...
								echo '<h4><span class="alert-danger">Insufficient Fund<span></h4>';
							}elseif ($this->otp_amount > $balance) {
								# code...
								echo '<span class="alert alert-danger">Insufficient Balance, Kindly make a deposit</span>';
							}else{

								# deduct cash from user account
								$deduction = ($balance - $this->otp_amount);

								# Update users account balance
								$set_bal = "UPDATE users SET account_bal = '".$deduction."' ";
								$set_bal .= "WHERE (email = '".$this->user."')";
								$set_bal_query = mysqli_query($this->plug, $set_bal);

								if (!$set_bal_query) {
									# code...
									echo '<span class="alert-danger">Error making withdrawal</span>';
								}else{

									# change otp status
									$otp_update  = "UPDATE otp SET otp_status = '".$this->com."'";
									$otp_update .= "WHERE(otp_code = '".$this->otp."')";
									$otp_update_query = mysqli_query($this->plug, $otp_update);

									if (!$otp_update_query) {
										# code...
										echo 'one time password update error';
									}elseif (mysqli_affected_rows($this->plug)) {

										# goto to cash page
										echo '<script>
											window.location.href = "takecash.php";
										</script>';
									}
								}
							}
						}
					}
			break;

			case 'transfer':
				# code...
			# Validate reciepient
			$account_check = "SELECT * FROM users WHERE";
			$account_check .= "(account_no = '".$this->account."')";
			$account_check_query = mysqli_query($this->plug, $account_check);

			# validate account check query
			if (!$account_check_query)
			{
				# code...
				echo "<span style='color: red;'>Error running account check query</span>";
			}elseif (mysqli_num_rows($account_check_query) === 0){
				# code...
				echo '<span class="alert-danger">Invalid account Number</span>';
			}else{

				# Check the user balance
				$check_bal = "SELECT * FROM users WHERE";
				$check_bal .= "(email = '".$this->user."')";
				$check_bal_query = mysqli_query($this->plug, $check_bal);

				# Validate Query
				if (!$check_bal_query)
				{
					# code...
					echo "<span class='alert alert-danger'>Financial Institution Unavailable, Contact Bank</span>";
				}else{

					while($redit = mysqli_fetch_array($check_bal_query))
					{
						extract($redit);

						$beam = $redit['account_bal'];

						# (check if account balance is empty
						# or balance is less than amount to transfer)
						if (empty($beam))
						{
							# code...
							echo "<span class='alert alert-danger'>Insufficient Funds</span>";
						}elseif ($this->otp_amount > $beam)
						{
							# code...
							echo "<span class='alert alert-danger'>Insufficient Balance, Kindly make a deposit</span>";
						}else
						{

							# Deduct Cash from Sender's Account
							$deduct_cash = "SELECT * FROM users WHERE";
							$deduct_cash .= "(email = '".$this->user."')";
							$deduct_cash_query = mysqli_query($this->plug, $deduct_cash);

							if (!$deduct_cash_query)
							{
								# code...
								echo "<span style='color: red;'>Transaction Can't be processed</span>";
							}else
							{

								while ($d_cash = mysqli_fetch_array($deduct_cash_query))
								{
									extract($d_cash);

									# Sender's Balance
									$money = $d_cash['account_bal'];

									# Subtract fee
									$deduction = ($money - $this->otp_amount);

									# Update sender's account balance
									$set_bal = "UPDATE users SET account_bal = '".$deduction."' ";
									$set_bal .= "WHERE (email = '".$this->user."')";
									$set_bal_query = mysqli_query($this->plug, $set_bal);

									if (!$set_bal_query)
									{
										# code...
										echo "<span>Error Making Transfer</span>";
									}else
									{
										# Check the Receiving Account
										$send_fund = "SELECT * FROM users WHERE";
										$send_fund .= "(account_no = '".$this->account."')";
										$send_fund_query = mysqli_query($this->plug, $send_fund);

										if (!$send_fund_query)
										{
											# code...
											echo "Error Performing Transaction, Try Again";
										}else{

											while ($get_data = mysqli_fetch_array($send_fund_query))
											{
												# code...
												extract($get_data);

												# Previous Balance
												$bal = $get_data['account_bal'];

												# add new amount
												$cash = ($this->otp_amount + $bal);

												# Update recipient account balance
												$transfer_cash = "UPDATE users SET account_bal = '".$cash."' ";
												$transfer_cash .= "WHERE (account_no = '".$this->account."')";
												$transfer_cash_query = mysqli_query($this->plug, $transfer_cash);

												if (!$transfer_cash_query)
												{
													# code...
													echo "<span>Error Making Transfer</span>";
												}else
												{
													# (Send notification to the Sender)
													# collect sender's details from database
													$collect_data = "SELECT * FROM users WHERE";
													$collect_data .= "(email = '".$this->user."')";
													$collect_data_query = mysqli_query($this->plug, $collect_data);

													if (!$collect_data_query)
													{
														# code...
														echo "Error making notification query";
													}else{
														while ($jugat = mysqli_fetch_array($collect_data_query))
														{
															# code...
															extract($jugat);

															# sender's name retrieved
															$sender = $jugat['account_no'];

															# write message to nofication file
															$debit_user = "INSERT INTO notification";
															$debit_user .= "(transaction_id, sender, receiver, amount)";
															$debit_user .= "VALUES ('".$this->tran_id."', '".$sender."', '".$this->account."', '".$this->otp_amount."')";
															$debit_user_query = mysqli_query($this->plug, $debit_user);

															if (!$debit_user_query)
															{
																# code...
																echo "Notification not sent";
															}else{
															# code...
															echo '<h4><span class="alert-success">Transaction Successful
															</span></h4>';

															echo '<script>
																var timer = function(){
																	window.location.href="anotherop.php";
																};
																setInterval(timer, 10000);
															</script>';

															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}	
			break;

			default:
				# code...
			break;
		}
	}
}


/**
 * OTP
 */
class OTP extends DBconnect
{
	protected $plug;
	protected $user;
	
	public function __construct($user, $amount, $type, $otp_number)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data
		$this->user = $user;
		$this->amount = $amount;
		$this->type = $type;

		# defaults
		$this->otp_number = $otp_number;
		$this->phone = "";
		$this->date = time();
		$this->status = "Unused";
		$this->recipient = "";
	}

	public function userPhone()
	{
		$user_phone  = "SELECT * FROM users WHERE";
		$user_phone .= "(email = '".$this->user."')";
		$user_phone_query = mysqli_query($this->plug, $user_phone);

		if (!$user_phone_query) {
			# code...
			echo 'Unable to process request';
		}else{

			while ($details = mysqli_fetch_array($user_phone_query)) {
				# code...
				extract($details);

				$this->recipient = $details['phone'];
			}
		}
	}

	public function sendOtp()
	{
		# sms api link 
		$url = 'http://api.smartsmssolutions.com/smsapi.php';

		# sms parameters
		$username = "brhamix@gmail.com";
		$password = "MacOsx23";
		$message = "Your One time password for this transaction  is ".$this->otp_number;
		$senderid = "OTP-ATM";
		$recipient = ''.$this->recipient.'';

		# sms array
		$sms_array = array (
			'username' => $username,
			'password' => $password,
			'message' => $message,
			'sender' => $senderid,
			'recipient' => $recipient
		);

		# function to authenticate One time password
		AuthOtp($url, $sms_array);
	}

	public function createOtp()
	{
		# create otp record
		$create_otp  = "INSERT INTO otp(otp_code, otp_user, otp_type, otp_amount, otp_status, otp_date)";
		$create_otp .= "VALUES('".$this->otp_number."', '".$this->user."', '".$this->type."', '".$this->amount."', '".$this->status."', '".$this->date."')";
		$create_otp_query = mysqli_query($this->plug, $create_otp);

		if (!$create_otp_query) {
			# code...

			echo 'Unable to save one time password';
		}elseif (mysqli_affected_rows($this->plug)) {
			# code...
			echo '<script>
				window.location.href = "otp.php";
			</script>';
		}
	}
}


/**
 * Check Balance 
 */
class Balance extends DBconnect
{
	protected $plug;
	protected $user;
	protected $bal;
	
	public function __construct($user, $bal)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data
		$this->user = $user;
		$this->bal = $bal;
	}

	public function check()
	{
		# check user account balance
		$user_balance  = "SELECT * FROM users WHERE";
		$user_balance .= "(email = '".$this->user."')";
		$user_balance_query = mysqli_query($this->plug, $user_balance);

		if (!$user_balance_query) {
			# code...
			echo 'Unable to validate user balance';
		}else{

			while ($details = mysqli_fetch_array($user_balance_query)) {
				# code...
				extract($details);

				# user balance 
				$balance = $details['account_bal'];

				echo '<h3><span class="alert alert-info">Your Account balance:</span></h3><br>';
				echo '<h4><span class="alert-info">'.'#'.$balance.'</span></h4>';

				# redirect page
				echo '<script>
					var timer = function(){
						window.location.href = "anotherop.php";
					};
					setInterval(timer, 10000);
				</script>';
			}
		}
	}
}


/**
 * Transfer
 */
class Transfer extends DBconnect
{
	protected $plug;
	protected $user;
	protected $amount;
	protected $account_no;
	protected $otp;

	public function __construct($user, $amount, $account_no, $otp)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data
		$this->user = $user;
		$this->otp = $otp;
		$this->amount = $amount;
		$this->account_no = $account_no;

		# defaults
		$this->data = "";
		$this->deduction = "";
		$this->cash = "";
	}

	public function otpCheck()
	{
		// if otp is valid the second method works
		# check otp was registered
		$otp_check  = "SELECT * FROM otp WHERE";
		$otp_check .= "(otp_code = '".$this->otp."') AND (otp_user = '".$this->user."')";
		$otp_check_query = mysqli_query($this->plug, $otp_check);

		if (!$otp_check_query) {
			# code...
			echo 'One time password validation failed';
		}elseif (mysqli_num_rows($otp_check_query) === 0) {
			# code...
			echo '<span class="alert-danger">Invalid OTP, Try again</span>';
		}else{

			while ($details = mysqli_fetch_array($otp_check_query)) {
				# code...
				extract($details);

				$this->data = $details['otp_code'];
			}
		}
	}

	public function transact()
	{
		# otp validation
		if (!empty($this->data)) {

			# check user account balance
			$user_balance  = "SELECT * FROM users WHERE";
			$user_balance .= "(email = '".$this->user."')";
			$user_balance_query = mysqli_query($this->plug, $user_balance);

			if (!$user_balance_queryser) {
				# code...
				echo 'Balance validation failed';
			}else{

				while ($details = mysqli_fetch_array($user_balance_query)) {
					# code...
					extract($details);

					# user's current balance
					$balance = $details['account_bal'];

					if (empty($balance)) {
						# code...
						echo '<span>Insufficient Fund</span>';
					}elseif ($this->amount > $balance) {
						# code...
						echo '<span>Insufficient Fund</span>';
					}else{

						# desuct cash from sender account
						$this->deduction = ($balance - $this->amount);

						# update sender account 

						$account_update  = "UPDATE users SET account_bal = '".$this->deduction."'";
						$account_update .= "WHERE (email = '".$this->user."')";
						$account_update_query = mysqli_query($this->plug, $account_update);

						if (!$account_update_query) {
							# code...
							echo 'Process Error';
						}else{

							# update the reciever account
							$reciever_account  = "SELECT * FROM users WHERE";
							$reciever_account .= "(account_no = '".$this->account_no."')";
							$reciever_account_query = mysqli_query($this->plug, $reciever_account);

							if (!$reciever_account_query) {
								# code...
								echo 'Account Error!!!';
							}else{

								while ($details = mysqli_fetch_array($reciever_account_query)) {
									# code...
									extract($details);

									# previous balance
									$bal = $details['account_bal'];

									# new amount added to previous balance
									$this->cash = ($this->amount + $bal);

									# update the receiver account balance
									$receiver_update  = "UPDATE users SET account_bal = '".$this->cash."'";
									$receiver_update .= "WHERE (account_no = '".$this->account_no."')";
									$receiver_update_qeury = mysqli_query($this->plug, $receiver_update);

									if (!$receiver_update_qeury) {
										# code...
										echo 'Transaction Error';
									}else{

										echo '<h4><span>Transaction Comleted<span></h4>';
									}
								}
							}
						}
					}
				}
			}
		}
	}
}


/**
 * Change Pin
 */
class ChangePin extends DBconnect
{
	protected $plug;
	protected $user;
	protected $pin;
	
	public function __construct($user, $pin)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data
		$this->user = $user;
		$this->pin = $pin;
	}

	public function change()
	{
		# change user pin
		$change_pin  = "SELECT * FROM users WHERE";
		$change_pin .= "(email = '".$this->user."')";
		$change_pin_query = mysqli_query($this->plug, $change_pin);

		if (!$change_pin_query) {
			# code...
			echo 'Unable to validate change pin query';
		}else{

			# update user pin
			$update_pin  = "UPDATE users SET pin_code = '".$this->pin."'";
			$update_pin .= "WHERE (email = '".$this->user."')";
			$update_pin_query = mysqli_query($this->plug, $update_pin);

			if (!$update_pin_query) {
				# code...
				echo 'update pin error';
			}elseif (mysqli_affected_rows($this->plug)) {
				# code...
				echo '<h4><span class="alert alert-info">Pin changed successfuully</span></h4><br>';

				# redirect
				echo '<script>
					var timer = function(){
						window.location.href = "anotherop.php";
					};
					setInterval(timer, 10000);
				</script>';
			}
		}
	}
}


/**
 * Recipient Account
 */
class Account extends DBconnect
{
	protected $plug;
	protected $account;
	
	public function __construct($account)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# data
		$this->account = $account;
	}

	public function checkAccount()
	{
		# validate recipient account number
		$account_number  = "SELECT * FROM users WHERE";
		$account_number .= "(account_no = '".$this->account."')";
		$account_number_query = mysqli_query($this->plug, $account_number);

		if (!$account_number_query) {
			# code...
			echo 'Account number validation failed';
		}elseif (mysqli_num_rows($account_number_query) === 0) {
			# code...
			echo '<h4><span class="alert-danger">Invalid Account number</span></h4>';

			# reload page
			echo '<script>
				var timer = function(){
					window.location.href = "";
				};
				setInterval(timer, 6000);
			</script>';
		}else{

			# store account number in session
			$_SESSION['account'] = $this->account;

			echo '<script>
				window.location.href = "transfer-amount.php";
			</script>';
		}
	}
}