<?php

include ("../__config/core.php");

/**
* Check Recepient Account
*/
class AccountCheck extends DBconnect
{

	protected $plug;
	protected $amount;
	protected $account_no;
	protected $cash;
	protected $hint;

	public function __construct($account_no)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		$this->account_no = $account_no;
	}

	public function checkAccount()
	{

		$user_account = "SELECT * FROM users WHERE";
		$user_account .= "(account_no = '".$this->account_no."')";
		$user_account_query = mysqli_query($this->plug, $user_account);
		$user_account_result = mysqli_num_rows($user_account_query);

		if (!$user_account_query)
		{
			# code...
			echo "Error Finding the Supplied Account Number";
		}elseif ($user_account_result === 0) {
			# code...
			echo "<span style='color: red;'>Invalid Account Number</span>";
		}else{

			while ($details = mysqli_fetch_array($user_account_query)) {
				# code...

				extract($details);

				echo '<b>Account Name:</b> '.$details['name'];
			}
		}
	}
}

/**
* Transfer Cash
*/
class Transact extends DBconnect
{
	protected $plug;
	protected $amount;
	protected $account_no;
	protected $cash;
	protected $code;
	protected $deduction;
	protected $tran_id;

	public function __construct($account_no, $amount, $user_id)
	{
		# code...
		parent::__construct();

		$this->plug = DBconnect::iConnect();
		$this->amount = $amount;
		$this->account_no = $account_no;
		$this->tran_id = "PHP-Bank-".rand(0000, 9999);

		global $user_id;
		$this->code =& $user_id;
	}

	public function deductCash()
	{

		# Validate reciepient
		$account_check = "SELECT * FROM users WHERE";
		$account_check .= "(account_no = '".$this->account_no."')";
		$account_check_query = mysqli_query($this->plug, $account_check);

		# validate account check query
		if (!$account_check_query)
		{
			# code...
			echo "<span style='color: red;'>Error running account check query</span>";
			
		}elseif (mysqli_num_rows($account_check_query) === 0){
			# code...
			echo "<div class='alert alert-danger alert-dismissible' role='alert'>
				  <button type='button' id='closebtn' class='close' data-dismiss='alert' aria-label='close'>
				  <span aria-hidden='true'>&times;</span></button><strong></strong>Invalid account Number</div>
				  </span>";
		}else{

			# Check the user balance
			$check_bal = "SELECT * FROM users WHERE";
			$check_bal .= "(code = '".$this->code."')";
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
					}elseif ($this->amount > $beam)
					{
						# code...
						echo "<span class='alert alert-danger'>Insufficient Balance, Kindly make a deposit</span>";
					}else
					{

						# Deduct Cash from Sender's Account
						$deduct_cash = "SELECT * FROM users WHERE";
						$deduct_cash .= "(code = '".$this->code."')";
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
								$this->deduction = ($money - $this->amount);

								# Update sender's account balance
								$set_bal = "UPDATE users SET account_bal = '".$this->deduction."' ";
								$set_bal .= "WHERE (code = '".$this->code."')";
								$set_bal_query = mysqli_query($this->plug, $set_bal);

								if (!$set_bal_query)
								{
									# code...
									echo "<div class='alert alert-danger alert-dismissible' role='alert'>
										<button type='button' id='closebtn' class='close' data-dismiss='alert' aria-label='close'>
										<span aria-hidden='true'>&times;</span></button><strong></strong>Error Making Transfer</div>
										</span>";
								}else
								{
									# Check the Receiving Account
									$send_fund = "SELECT * FROM users WHERE";
									$send_fund .= "(account_no = '".$this->account_no."')";
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

											$this->cash = ($this->amount + $bal);

											# Update recepient account balance
											$transfer_cash = "UPDATE users SET account_bal = '".$this->cash."' ";
											$transfer_cash .= "WHERE (account_no = '".$this->account_no."')";
											$transfer_cash_query = mysqli_query($this->plug, $transfer_cash);

											if (!$transfer_cash_query)
											{
												# code...
												echo "<div class='alert alert-danger alert-dismissible' role='alert'>
													<button type='button' id='closebtn' class='close' data-dismiss='alert' aria-label='close'>
													<span aria-hidden='true'>&times;</span></button><strong></strong>Error Making Transfer</div>
													</span>";
											}else
											{
												# (Send notification to the Sender)
												# collect sender's details from database
												$collect_data = "SELECT * FROM users WHERE";
												$collect_data .= "(code = '".$this->code."')";
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
														$debit_user .= "VALUES ('".$this->tran_id."', '".$sender."', '".$this->account_no."', '".$this->amount."')";
														$debit_user_query = mysqli_query($this->plug, $debit_user);

														if (!$debit_user_query)
														{
															# code...
															echo "Notification not sent";
														}else{
														# code...
														echo "<div class='alert alert-success alert-dismissible' role='alert'>
														<button type='button' id='closebtn' class='close' data-dismiss='alert' aria-label='close'>
														<span aria-hidden='true'>&times;</span></button><strong></strong>Transaction Successful</div>
														</span>";

														echo '<script>
															var timer = function(){
																window.reload();
															};
															setInterval(timer, 1000);
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
	}
}