<?php
session_start();
if (isset($_SESSION["login"])) {
	if ($_SESSION["login"] == "7893login") {
		header("Location: index.php");
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<section class="login-block">
    <div class="container">
	<div class="row ">
		<div class="col login-sec">
		    <h2 class="text-center">Login Now</h2>
		    <form class="login-form" action="lg.php" method="post">
			  <div class="form-group">
			    <label for="exampleInputEmail1" class="text-uppercase">Username</label>
			    <input type="text" class="form-control" placeholder="" required name="un">
			    
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1" class="text-uppercase">Password</label>
			    <input type="password" class="form-control" placeholder="" required name="pw">
			  </div>
			  
			  
			    <div class="form-check">
			    <!--label class="form-check-label">
			      <input type="checkbox" class="form-check-input">
			      <small>Remember Me</small>
			    </label-->
			    <button type="submit" class="btn btn-login float-right">Login</button>
			  </div>
			  
			</form>
  </div>
    </div>
    </div>
</section>
<footer>
		<p style="text-align: center;bottom: 5px;padding: 20px;color: #fff;">Powerd by <a href="http://otomate.lk/" target="_blank" style="color: #eec9ff">otomate.lk</a></p>
	</footer>
</body>
</html>