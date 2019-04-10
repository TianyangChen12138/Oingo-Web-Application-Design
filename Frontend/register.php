<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
</head>
<body>
  <div>
  	<h2>Register</h2>
  </div>
	
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Userfirstname:</label>
  	  <input type="text" name="ufirstname" value="<?php echo $ufirstname; ?>">
  	</div>
    <div>
  	  <label>Userlastname:</label>
  	  <input type="text" name="ulastname" value="<?php echo $ulastname; ?>">
  	</div>
  	<div>
  	  <label>Email:</label>
  	  <input type="email" name="uemail" value="<?php echo $uemail; ?>">
  	</div>
    <div>
  	  <label>Username:</label>
  	  <input type="text" name="uusername" value="<?php echo $uusername; ?>">
  	</div>
  	<div>
  	  <label>Password:</label>
  	  <input type="password" name="upassword">
  	</div>
  	<div>
  	  <label>Confirm password:</label>
  	  <input type="password" name="upassword_1">
  	</div>
    <div>
  	  <label>Gender:</label>
      <input type="radio" name="ugender" value="Male">Male
  	  <input type="radio" name="ugender" value="Female">Female
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>