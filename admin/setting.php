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
	<title>GT Bank - Settings</title>
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
				<li class="active"><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="deposit.php" title="Deposit"><i class="fa fa-money"></i> Deposit</a></li>
				<li><a href="transfer_funds.php" title="Transfer Funds"><i class="fa fa-bank"></i> Transfer Funds</a></li>
				<li><a href="logout.php" title="logout"><i class="fa fa-sign-out"></i> Logout</a></li>
			</ul>
		</div>
	</nav>

	<!--preview State-->
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div id="cards-form">
					<div class="panel-info">
					<div class="panel-heading">Change User Login Details</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 text-center">
								<form method="post" onsubmit="return verifyPassword()">
									<div id="new-password">
										<div class="form-group">
											<label>New password</label>
											<input type="password" id="pass1" placeholder="password" name="" required="" class="form-control">
										</div>
										<div class="form-group">
											<label>Confirm password</label>
											<input type="password" id="pass2" placeholder="confirm password" name="" required="" class="form-control">
										</div>
										<div class="form-group">
											<button class="btn btn-primary col-md-12" id="Change-pass">Change Password</button>
											<hr /><br />
										</div>
										<div id="error-stat" style="display: none;" class="alert alert-danger"></div>
									</div>
									<br />
								</form>

								<form method="post" onsubmit="return updatePassword()">
									<div id="confirm-old" style="display: none;">
										<p class="lead">Are you sure ?</p>
										<div class="form-group">
											<label>Input your Old password</label>
											<input type="password" id="old-password" placeholder="Enter Old Password" name="" required="" class="form-control">
										</div>
										<div class="form-group">
											<button class="btn btn-success col-md-12">Confirm</button>
										</div>
									</div>
									<div id="password-stat"></div>
								</form>
								<br />
							</div>
						</div>
						<br />
					</div>
					<div class="panel-footer">Copyright protected &copy; <?php echo date("Y"); ?> GT Bank.inc</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function verifyPassword()
		{
			var pass1 = $("#pass1").val();
			var pass2 = $("#pass2").val();

			if (pass2 == pass1)
			{
				$("#confirm-old").show();
				$("#new-password").hide();
			}else{
				$("#error-stat").text("Password does not match").show();
				return false;
			}			

			return false;
		}

		function updatePassword()
		{
			var newPassword = $("#pass1").val();
			var oldPassword = $("#old-password").val();

			$.ajax({
				type: "POST",
				url: "__factory/change-password.php",
				data:{
					newPassword:newPassword,
					oldPassword:oldPassword
				},
				cache: false,
				success: function (data)
				{
					$("#password-stat").html(data);
					$("#confirm-old").hide();
				}
			});
			return false;
		}
	</script>
	
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>