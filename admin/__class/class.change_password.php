<?php 

include ('../__config/core.php');

/**
* update password
*/

$user_id = $_SESSION['code'];

class UpdatePassword extends DBConnect
{

	protected $plug;
	protected $date;

	protected $old_password;
	protected $new_password;
	public $session;
	
	public function __construct($old_password, $new_password, $session)
	{
		# code...
		parent::__construct();
		$this->plug = DBconnect::iConnect();

		# Global variable
		global $user_id;

		$this->session =& $user_id;
		$this->old_password = $old_password;
		$this->new_password = $new_password;
		$this->date = time();
	}

	public function update()
	{
		# check verifcation
		$check_password = " SELECT * FROM users WHERE (pin_code = '".$this->old_password."') AND (code = '".$this->session."') ";
		$check_password_query = mysqli_query($this->plug, $check_password);
		if(!$check_password_query)
		{
			echo 'Error running password check query '.mysqli_error($this->plug);
		}elseif(!mysqli_num_rows($check_password_query)){
			echo '
				<p class="alert alert-danger">Invalid Password, try again !
					after 5 attempt to change password account lock-down will initialize.
				</p>
			';
		}else{
			while ($details = mysqli_fetch_array($check_password_query)) {
				# code...
				$db_password = $details['pin_code'];
				if($db_password == $this->old_password)
				{
					# change [password]
					$update_pass = " UPDATE users SET pin_code = '".$this->new_password."' ";
					$update_pass .= " WHERE (code = '".$this->session."') ";
					$update_pass_query = mysqli_query($this->plug, $update_pass);
					if(!$update_pass_query)
					{
						echo 'Error updating password '.mysql_error($this->plug);
					}else{
						echo '
							<span class="alert alert-success">password updated successfully</span> <br />

							<script>
								var timer = function(){
									window.location.href =  "home.php"
								};

								setInterval(timer, 3000);
							</script>
						';
					}
				}
			}
		}
	}
}