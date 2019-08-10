<?php 

include ('../__config/core.php');

/**
* Deposit Class
*/
$user_id = $_SESSION['code'];

class Deposit extends DBconnect
{
	protected $plug;
	protected $amount;
	protected $cash;
	public $session;

	public function __construct($amount, $session)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		global $user_id;
		$this->session =& $user_id ;
		$this->amount = $amount;
	}

	public function deposit_money()
	{
		$deposit_cash = "SELECT account_bal FROM users WHERE";
		$deposit_cash .= "(code = '".$this->session."')";
		$deposit_cash_query = mysqli_query($this->plug, $deposit_cash);

		if (!$deposit_cash_query)
		{
			# code...
			echo 'Error Connecting to Account';
		}else
		{
			while ($details = mysqli_fetch_array($deposit_cash_query))
			{
				$money = $details['account_bal'];

				$this->cash = ($this->amount + $money);

				$save_cash = "UPDATE users SET account_bal = '".$this->cash."'  ";
				$save_cash .="WHERE (code = '".$this->session."')";
				$save_cash_query = mysqli_query($this->plug, $save_cash);

				if (!$save_cash_query)
				{
					# code...
					echo "
					<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' id='closebtn' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button><strong></strong>Error Making Deposit</div></span>";
				}else{

					echo "<div class='alert alert-success alert-dismissible' role='alert'> <button type='button' id='closebtn' class='close' data-dismiss='alert' aria-label='close'><span aria-hidden='true'>&times;</span></button><strong>Done !!</strong> Deposit Successful</div>";

						# Redirect back home
					echo '<script>
							var timer = function(){
								window.location.href =  "home.php"
							};

							setInterval(timer, 5000);
						</script>';
				}
			}
		}
	}
}



?>