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
  
  echo "Here are all the posts in the database that you created:<br><br>";
  
  if (isset($_SESSION['uid'])) {
    $uid = mysqli_real_escape_string($db, $_SESSION['uid']);
    $query = "SELECT pinfo, ptag, pradius, pcommentYN, pvisible, pxcord, pycord FROM post WHERE uid='$uid'";
    $results = mysqli_query($db, $query);
    if ($results->num_rows > 0) {
      while($row = $results->fetch_assoc()) {
        echo "Info: " . $row['pinfo']. " -- Tags: " . $row['ptag']. " -- Radius: " . $row['pradius']. " -- Comment(Y/N): " . $row['pcommentYN']. " -- Visible: " . $row['pvisible']. " -- x cord: " . $row['pxcord']. " -- y cord: " . $row['pycord']. "<br>";
      }
    }
    else {
      echo "0 results<br>";
    }
  }
  
  echo "<br>Here are all the schedules in the database that you can use:<br><br>";
  
  $query = "SELECT * FROM schedule";
  $results = mysqli_query($db, $query);
  if ($results->num_rows > 0) {
    while($row = $results->fetch_assoc()) {
        echo "Schedule id: ". $row['sid']. " -- Everyday(Y/N): " . $row['severydayYN']. " -- Day of week(N): " . $row['severyweeknumN']. " -- Exact date: " . $row['sdate']. " -- Start time: " . $row['sstarttime']. " -- End time: " . $row['sendtime']. " -- From date: " . $row['sfromdate']. " -- End date: " . $row['senddate']. "<br>";
    }
  }
  else {
    echo "0 results<br>";
  }
  
  echo "<br>Want to make a new schedule? Please fill the following information:<br>";
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Everyday(Y/N): </label>
  	  <input type="text" name="severydayYN" value="<?php echo $severydayYN; ?>">
  	</div>
    <div>
  	  <label>Day of week(N) (please use abbreviation): </label>
  	  <input type="text" name="severyweeknumN" value="<?php echo $severyweeknumN; ?>">
  	</div>
    <div>
  	  <label>Exact date (Please enter 1990-01-01 if you do not want to choose a exact date): </label>
  	  <input type="date" name="sdate" value="<?php echo $sdate; ?>">
  	</div>
    <div>
  	  <label>Start time: </label>
  	  <input type="time" name="sstarttime" value="<?php echo $sstarttime; ?>">
  	</div>
    <div>
  	  <label>End time: </label>
  	  <input type="time" name="sendtime" value="<?php echo $sendtime; ?>">
  	</div>
    <div>
  	  <label>From date: </label>
  	  <input type="date" name="sfromdate" value="<?php echo $sfromdate; ?>">
  	</div>
    <div>
  	  <label>End date: </label>
  	  <input type="date" name="senddate" value="<?php echo $senddate; ?>">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="new_schedule">New schedule</button>
  	</div>
  </form>

  <?php
    echo "<br>Want to make a new post? Please fill the following information:<br>";
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Info: </label>
  	  <input type="text" name="pinfo" value="<?php echo $pinfo; ?>">
  	</div>
    <div>
  	  <label>Tags: </label>
  	  <input type="text" name="ptag" value="<?php echo $ptag; ?>">
  	</div>
    <div>
  	  <label>Radius: </label>
  	  <input type="text" name="pradius" value="<?php echo $pradius; ?>">
  	</div>
    <div>
  	  <label>Schedule id (Please choose a schedule id from above)</label>
  	  <input type="text" name="sid" value="<?php echo $sid; ?>">
  	</div>
    <div>
  	  <label>Comment(Y/N): </label>
  	  <input type="text" name="pcommentYN" value="<?php echo $pcommentYN; ?>">
  	</div>
    <div>
  	  <label>Visible: </label>
      <input type="radio" name="pvisible" value="Everyone">Everyone
  	  <input type="radio" name="pvisible" value="Friend">Friend
      <input type="radio" name="pvisible" value="Me">Me
  	</div>
    <div>
  	  <label>x cord: </label>
  	  <input type="text" name="pxcord" value="<?php echo $pxcord; ?>">
  	</div>
    <div>
  	  <label>y cord: </label>
  	  <input type="text" name="pycord" value="<?php echo $pycord; ?>">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="new_post">Make post</button>
  	</div>
  </form>
  
  <?php
    echo "<br>Here are the famous positions we have in the database:<br><br>";
    echo "Brooklyn,  x cord: 400,  y cord: 450<br>";
    echo "Las Vegas, x cord: 3000, y cord: 4000<br>";
    echo "<br>Hint: Most of the posts in the database are centered in these two positions, so when you make a new post, it is recommended to locate the post around these two positions.";
  ?>
  
  <p>
  	Want to go back to the main page? <a href="mainpage.php">Main page</a>
  </p>

</body>
</html>