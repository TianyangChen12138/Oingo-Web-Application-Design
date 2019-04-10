<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
</head>
<body>
  <div>
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="<?php echo htmlspecialchars("login.php"); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  		<label>Username</label>
  		<input type="text" name="uusername" value="<?php echo $uusername; ?>">
  	</div>
  	<div>
  		<label>Password</label>
  		<input type="password" name="upassword">
  	</div>
  	<div>
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>