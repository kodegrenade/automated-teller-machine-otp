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
	<link rel="icon" href="img/loading.gif">
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
					GT Bank<!--<img src="" width="30" height="30">-->
				</a>
			</div>
			<ul style="float: right;" class="nav navbar-nav">
				<!-- <li class="active"><a href="#"><i class="fa fa-user"></i> 	</a></li> -->
				<li><a href="deposit.php" title="Deposit"><i class="fa fa-money"></i> Deposit</a></li>
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
			<div class="col-md-2">
				<div class="panel-info">
					<div class="panel-heading">Account Balance</div>
					<div class="panel-body">
						<?php include ('__class/class.account_bal.php'); ?>
					</div>
					<div class="panel-footer"></div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel-info">
					<div class="panel-heading">Debit Alerts</div>
					<div class="panel-body">
						<?php include ('__class/class.load_alerts.php'); ?>
					</div>
					<div class="panel-footer"></div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="panel-info">
					<div class="panel-heading">Credit Alerts</div>
					<div class="panel-body">
						<?php include ('__class/class.load_credit_alerts.php'); ?>
					</div>
					<div class="panel-footer"></div>
				</div>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
