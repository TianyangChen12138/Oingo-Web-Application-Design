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

  if (isset($_SESSION['uid'])) {
    $uid = mysqli_real_escape_string($db, $_SESSION['uid']);
  }
  
  echo "Here are all the users in our database that you can make friends with:<br><br>";
  
  $query = "SELECT uid, ufirstname, ulastname, uusername FROM user WHERE uid != '$uid'";
  $results = mysqli_query($db, $query);
  if ($results->num_rows > 0) {
    while($row = $results->fetch_assoc()) {
        echo "uid: " . $row['uid']. " -- firstname: " . $row['ufirstname']. " -- lastname: " . $row['ulastname']. " -- username: " . $row['uusername']. "<br>";
    }
  }
  else {
    echo "0 results<br>";
  }

  echo "<br>Here are all the users that have already become your friends:<br><br>";

  $query = "SELECT u.uid, u.ufirstname, u.ulastname, u.uusername FROM friend as f, user as u WHERE f.friendid = u.uid AND f.uid = '$uid'";
  $results = mysqli_query($db, $query);
  if ($results->num_rows > 0) {
    while($row = $results->fetch_assoc()) {
        echo "uid: " . $row['uid']. " -- firstname: " . $row['ufirstname']. " -- lastname: " . $row['ulastname']. " -- username: " . $row['uusername']. "<br>";
    }
  }
  else {
    echo "0 results<br>";
  }
  
  echo "<br>Want to make more friends? Please fill the following information:<br>";
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>User id (please choose an id that is not your friend): </label>
  	  <input type="text" name="uid">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="make_friend">Make friend</button>
  	</div>
    <p>
  		Want to go back to the main page? <a href="mainpage.php">Main page</a>
  	</p>
  </form>

</body>
</html>