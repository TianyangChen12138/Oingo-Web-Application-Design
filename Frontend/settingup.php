<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
</head>
<body>
  
  <?php
	
	$db = mysqli_connect('localhost', 'root', 'ctyang2012', 'project1');

  if (isset($_SESSION['uusername'])) {
    $uusername = mysqli_real_escape_string($db, $_SESSION['uusername']);
    echo "<h2>"."Hello ".$uusername."!"."</h2>";
  }

  $query = "SELECT currentstatenname FROM currentstate natural join user WHERE uusername='$uusername'";
  $result = mysqli_query($db, $query);
  echo "You have following states can be selected from:  ";
  while ($row = mysqli_fetch_assoc($result)) {
    printf ("(%s). \n", $row['currentstatenname']);
  }
  echo "<br><br><br>Please fill all the information below to continue:<br><br>"
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Current State (please choose the state from above):</label>
  	  <input type="text" name="currentstate" value="<?php echo $currentstate; ?>">
  	</div>
    <div>
  	  <label>Current Time:</label>
  	  <input type="time" name="ttime" value="<?php echo $ttime; ?>">
  	</div>
    <div>
  	  <label>Current Date:</label>
  	  <input type="date" name="ttdate" value="<?php echo $ttdate; ?>">
  	</div>
		<div>
  	  <label>Current Day of the Week (please use abbreviation):</label>
  	  <input type="text" name="ttweeknum" value="<?php echo $ttweeknum; ?>">
  	</div>
  	<div>
  	  <label>Current location x cord:</label>
  	  <input type="text" name="ttxcord" value="<?php echo $ttxcord; ?>">
  	</div>
  	<div>
  	  <label>Current location y cord:</label>
  	  <input type="text" name="ttycord" value="<?php echo $ttycord; ?>">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="set_state">Submit</button>
  	</div>
  </form>

  <?php
  echo "<br><br>If you want to add a new state, please fill the information below:<br><br>"
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>New State:</label>
  	  <input type="text" name="currentstate" value="<?php echo $currentstate; ?>">
  	</div>
    <div>
  	  <button type="submit" class="btn" name="new_state">Add</button>
  	</div>
  </form>

  <?php
  echo "<br><br>Here are the famous positions we have in the database:<br><br>";
  echo "Brooklyn,  x cord: 400,  y cord: 450<br>";
  echo "Las Vegas, x cord: 3000, y cord: 4000<br>";
  echo "<br>Hint: Most of the posts in the database are centered in these two positions, so when you choose your current location, it is recommended to locate around these two positions.";
  ?>
</body>
</html>