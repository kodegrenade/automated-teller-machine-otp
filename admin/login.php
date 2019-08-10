<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>GT Bank - Login</title>
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="icon" href="img/loading.gif">
	<link rel="stylesheet" type="text/css" href="fonts/css/font-awesome.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/npm.js"></script>
	<script src="js/jquery.js"></script>
</head>
<body>

	<!--Navigation bar-->
		<nav class="navbar navbar-default navbar-static-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">
						GT Bank<!--<img src="" width="30" height="30">-->
					</a>
				</div>
				<ul style="float: right;" class="nav navbar-nav">
					<li class="active"><a href="index.php" title="Home"><i class="fa fa-home"></i> Home</a></li>
					<li><a href="create_account.php" title=""><i class="fa fa-user-o"></i> Create Account</a></li>
				</ul>
			</div>
		</nav>

		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h2>Welcome, <br/> Please enter your email and pass code</h2>
					<hr />
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-md-5 col-md-offset-3">
					<div id="login-stat"></div>
					&nbsp;
					<form method="POST" onsubmit="return loginUser()">
						<div class="form-group">
							<label>Email</label>
							<input type="email" id="email" placeholder="name@address.com" required class="form-control">
						</div>
						<div class="form-group">
							<label>Code</label>
							<input type="password" id="code" placeholder="enter pass code here" required class="form-control">
						</div>
						<div class="form-group">
							<button class="btn btn-info">Login</button>
						</div>
					</form>
				</div>
				<script type="text/javascript">
					function loginUser()
					{
						var email = $("#email").val();
						var code = $("#code").val();

						$.ajax({
							type: "POST",
							url: "__factory/login.php",
							data:{
								email:email,
								code:code
							},
							cache:false,
							success: function(data)
							{
								$("#login-stat").html(data);
							}
						});
						return false;
					}
				</script>
			</div>
		</div>
	<script type="text/javascript" src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>

