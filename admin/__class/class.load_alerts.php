<?php
/**
* Load notifications
*/

# SESSION OF THE LOGGED IN USER
$user_id = $_SESSION['code'];

class Notification extends DBconnect
{
	public $session;
	protected $account;
	protected $name;
	protected $receiver;

	public function __construct($session)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		global $user_id;
		$this->session =& $user_id;
	}

	public function debit_alerts()
	{
		$load_user_alerts = "SELECT * FROM users WHERE";
		$load_user_alerts .= "(code = '".$this->session."')";
		$load_user_alerts_query = mysqli_query($this->plug, $load_user_alerts);
		#$load_alerts_result = mysqli_num_rows($load_user_alerts_query);

		if (!$load_user_alerts_query)
		{
			# code...
			echo "Error loading alerts messages";
		}else{

			while ($load = mysqli_fetch_array($load_user_alerts_query))
			{
				# code...
				extract($load);

				# retrieve account number from database
				$this->account = $load['account_no'];
				$this->name = $load['name'];

				# load debit alert for user
				$debit_msg = "SELECT * FROM notification WHERE";
				$debit_msg .= "(sender = '".$this->account."') ORDER BY date_sent DESC LIMIT 3";
				$debit_msg_query = mysqli_query($this->plug, $debit_msg);

				if (!$debit_msg_query)
				{
					# code...
					echo "Error checking notification file";
				}elseif (mysqli_num_rows($debit_msg_query) === 0)
				{
					# code...
					echo "No debit messages";
				}else{
					while ($debit = mysqli_fetch_array($debit_msg_query))
					{
						# code...
						extract($debit);
						echo "<hr />";
						echo '<h5 style="font-family: cursive;">Debit Alert</h5>';
						echo '<b>Transaction id:</b> '.$debit['transaction_id'].'<br />';
						echo '<b>Receiver:</b> '.$debit['receiver'].'<br />';
						echo '<b>Sender:</b> '.$this->name.'<br />';
						echo '<b>Amt:</b> '.'NGN '.$debit['amount'].' DR'.'<br />';
						echo '<b>Transaction Time:</b> '.$debit['date_sent'].'<br />';
					}
				}
			}
		}
	}
}

$new_alert = new Notification($user_id);
$new_alert->debit_alerts();