<?php

include ('__functions/functions.php');

if (login_admin())
{
	# code...
	header('location: home.php');
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>GT Bank - Home</title>
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="icon" href="img/">
	<link rel="stylesheet" type="text/css" href="fonts/css/font-awesome.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/npm.js"></script>
	<script src="js/jquery.js"></script>
</head>
<body>

	<nav class="navbar navbar-default navbar-static-top" role="navigation"><!--Navigation bar-->
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="home.php">
					PHP BANK<!--<img src="" width="30" height="30">-->
				</a>
			</div>
			<ul style="float: right;" class="nav navbar-nav">
				<li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="transfer_funds.php" title="Transfer Funds"><i class="fa fa-bank"></i> Transfer Funds</a></li>
				<li><a href="setting.php" title="Settings"><i class="fa fa-cog"></i> Settings</a></li>
				<li><a href="logout.php" title="logout"><i class="fa fa-sign-out"></i> Logout</a></li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<?php include ('__class/class.load_user.php');?>
			</div>
			<div class="col-md-6">
				&nbsp;
				<div id="deposit-stat"></div>
				<form method="POST" id="deposit-form" onsubmit="return Deposit()">
					<div class="form-group">
						<small>Deposit is currently diabled, contact cashier for help</small><br>
						<label>Amount</label>
						<input type="number" id="amount" placeholder="Enter amount to deposit" class="form-control" disabled>
					</div>
					<div>
						<button class="btn btn-info" disabled>Deposit</button>
					</div>
				</form>
			</div>
			<script type="text/javascript">
				function Deposit()
				{
					var amount = $("#amount").val();

					$.ajax({
						type: "POST",
						url: "__factory/deposit.php",
						data:{
							amount:amount
						},
						cache: false,
						success: function(data)
						{
							$("#deposit-stat").html(data);
							$("#deposit-form").hide();
						}
					});
					return false;
				}
			</script>
		</div>
	</div>
	&nbsp;
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<h4 style="color: blue;">Kindly Use the Atm for Withdrawal</h4>
			</div>
		</div>
	</div>
	
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>