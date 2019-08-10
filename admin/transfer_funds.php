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
	<title>GT Bank - Transfer Funds</title>
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="icon" href="img/loading.gif">
	<link rel="stylesheet" type="text/css" href="fonts/css/font-awesome.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/npm.js"></script>
	<script src="js/jquery.js"></script>
	<script>
		function showHint(str) {
		    if (str.length == 0) { 
		        document.getElementById("txtHint").innerHTML = "";
		        return;
		    } else {
		        var xmlhttp = new XMLHttpRequest();
		        xmlhttp.onreadystatechange = function() {
		            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
		            }
		        };
		        xmlhttp.open("GET", "__factory/check_account.php?q=" + str, true);
		        xmlhttp.send();
		    }
		}
	</script>
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
				<!-- <li class="active"><a href="#"><i class="fa fa-user"></i> </a></li> -->
				<li><a href="home.php" title="Home"><i class="fa fa-bank"></i> Home</a></li>
				<li><a href="deposit.php" title="Deposit"><i class="fa fa-money"></i> Deposit</a></li>
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
				<h4 style="">Transfer Funds to PHP-Bank Account</h4>
				<h5 style="font-style: italic;"><del>(other banks are not available for now)</del></h5>
				<!--Account Form-->
				<form method="POST" id="transForm" onsubmit="return sendMoney()">
					<div class="form-group">
						<label>Enter Recepient Account</label><div style="float: right;" id="txtHint"></div>
						<input type="number" name="" id="account_no" placeholder="Account Number here" class="form-control" onkeyup="showHint(this.value)" required>
					</div>
					<div class="form-group">
						<label>Enter Amount (#)</label>
						<input type="number" name="" id="amount" placeholder="Account Number here" class="form-control">
					</div>
					<div>
						<button class="btn btn-info" id="chk">Next</button>
						<div id="loading" style="display:none;" class="text-center">
							<img src="img/loading.gif" width="" height="" alt="loading">
						</div>
					</div>	
				</form>
				&nbsp;
				&nbsp;
				<div id="log-stat"></div>
				<script type="text/javascript">
					function sendMoney()
					{
						var account_no = $("#account_no").val();
						var amount = $("#amount").val();

						$.ajax({
							type: "POST",
							url: "__factory/transfer-funds.php",
							data:{
								account_no:account_no,
								amount:amount
							},
							cache: false,
							success: function (data)
							{
								$("#log-stat").html(data);
								$("#transForm").hide();
							}
						});
						return false;
					}
				</script>
			</div>
		</div>
	</div>

		&nbsp;
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="panel-info">
					<div class="panel-heading">Account Balance</div>
					<div class="panel-body">
						<?php include ('__class/class.account_bal.php'); ?>
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