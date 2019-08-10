<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>GT Bank - Create Account</title>
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="icon" href="img/">
	<link rel="stylesheet" type="text/css" href="fonts/css/font-awesome.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>


	<nav class="navbar navbar-default navbar-static-top" role="navigation"><!--Navigation bar-->
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">
					GT Bank<!--<img src="" width="30" height="30">-->
				</a>
			</div>
			<ul style="float: right;" class="nav navbar-nav">
				<li class="active"><a href="index.php" title="Home"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="login.php" title=""><i class="fa fa-location-arrow"></i> Login</a></li>
				<li><a href="#" title=""><i class=""></i> </a></li>
			</ul>
		</div>
	</nav>

	<div class="wrapper">
		<h3 style="font-family: cursive; text-align: center; color: brown;">Create an Account with today and let us manage your money and investments for you.</h3>
	</div>


	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-3">
				<div id="stat"></div>
				<form method="POST" id="user-form" onsubmit="return CreateAccount()">
					<div class="form-group">
						<label>Full Name</label>
						<input type="text"  id="fname" class="form-control" placeholder="Full Name" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email"  id="email" class="form-control" placeholder="name@address.com" required>
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="number" minlength="11" maxlength="13"  id="phone" class="form-control" placeholder="0-XXXXXXXXXX" required>
					</div>
					<div class="form-group">
						<label>Account Type</label>
						<select class="form-control" id="account_type" value="" required>
							<option></option>
							<option value="Savings">Savings</option>
							<option value="Current">Current</option>
						</select>
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Submit</button>
						<!-- <a href="#" class="button" role="button">Terms and conditions</a> -->
					</div>
				<form>
			</div>
			<script type="text/javascript">
				function CreateAccount()
				{
					var fname = $("#fname").val();
					var email = $("#email").val();
					var phone = $("#phone").val();
					var account_type = $("#account_type").val();

					$.ajax({
						type: "POST",
						url: "__factory/create_account.php",
						data:{
							fname:fname,
							email:email,
							phone:phone,
							account_type:account_type
						},
						cache:false,
						success: function(data)
						{
							$("#stat").html(data);
							$("#user-form").hide();
						}
					});
					return false;
				}
			</script>
		</div>
	</div>
	<footer style="background-color: black;">
		<div class="container">
			<div class="row">
				<div class="">
					
				</div>
			</div>
		</div>
	</footer>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
