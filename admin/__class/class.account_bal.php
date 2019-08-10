<?php 

//include ('__config/core.php');

/**
* Account Balance
*/

$user_id = $_SESSION['code'];

class Balance extends DBconnect
{
	
	protected $plug;
	public $user_id;

	public function __construct($user_id)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		global $user_id;

		$this->session =& $user_id;
	}

	public function load_balance()
	{
		$user_balance = "SELECT * FROM users WHERE";
		$user_balance .= "(code = '".$this->session."')";
		$user_balance_query = mysqli_query($this->plug, $user_balance);

		while ($get_balance = mysqli_fetch_array($user_balance_query))
		{
			# code...
			extract($get_balance);

			echo "<b>Account Balance:</b> "."# ".$get_balance['account_bal'];

			for ($i=0; $i < $get_balance['account_bal']; $i++)
			{ 
				# code...

			}
		}
	}
}

$new_balance = new Balance($user_id);
$new_balance->load_balance();