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
  
  echo "Here are all the posts around you in the database that can be commented:<br><br>";

    $query = "SELECT pid, pinfo, ptag, pradius, pvisible, pxcord, pycord FROM post WHERE pid in (select pid from temp1) union SELECT pid, pinfo, ptag, pradius, pvisible, pxcord, pycord FROM post WHERE pid in (select pid from temp2) order by pid";
    $results = mysqli_query($db, $query);
    if ($results->num_rows > 0) {
      while($row = $results->fetch_assoc()) {
        echo "Post id: " . $row['pid']. " -- Info: " . $row['pinfo']. " -- Tags: " . $row['ptag']. " -- Radius: " . $row['pradius']. " -- Visible: " . $row['pvisible']. " -- x cord: " . $row['pxcord']. " -- y cord: " . $row['pycord']. "<br>";
      }
    }
    else {
      echo "0 results<br>";
    }
  
  echo "<br>Please choose a post id from above to check its comments:<br>";
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Post id: </label>
  	  <input type="text" name="pid">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="check_comment">Check Comment</button>
  	</div>
  </form>
  
  <?php
    // check comment
    if (isset($_POST['check_comment'])) {

        $pid = mysqli_real_escape_string($db, $_POST['pid']);
        $bool = 0;
        if (empty($pid)) {
            echo "Post id is required<br>";
            $bool=1;
        }

        if ($bool == 0) {
            $query = "SELECT u.uusername, c.cinfo FROM comment as c, user as u WHERE c.uid=u.uid AND c.pid='$pid'";
            $results = mysqli_query($db, $query);
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()) {
                    echo "Username: " . $row['uusername']. " -- Comment: " . $row['cinfo']. "<br>";
                }
            }
            else {
                echo "0 results<br>";
            }
        }
    }
  ?>
  
  <?php
    echo "<br>Want to make a new comment for a post? Please fill the following information:<br>";
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Post id: </label>
  	  <input type="text" name="pid">
  	</div>
    <div>
  	  <label>Comments: </label>
  	  <input type="text" name="cinfo">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="make_comment">Create Comment</button>
  	</div>
  </form>

  <?php
    // make comment
    if (isset($_POST['make_comment'])) {
        if (isset($_SESSION['uid'])) {
            $uid = mysqli_real_escape_string($db, $_SESSION['uid']);
            $pid = mysqli_real_escape_string($db, $_POST['pid']);
            $cinfo = mysqli_real_escape_string($db, $_POST['cinfo']);
            $bool = 0;
    
            if (empty($pid)) {
                echo "Post id is required<br>";
                $bool=1;
            }
            if (empty($cinfo)) {
                echo "Comment is required<br>";
                $bool=1;
            }

            if ($bool == 0) {
                $query = "INSERT INTO comment (pid, uid, cinfo)
                        VALUES('$pid', '$uid', '$cinfo');";
                mysqli_query($db, $query);
            }
        }
    }
  ?>
  
  <p>
  	Want to go back to the main page? <a href="mainpage.php">Main page</a>
  </p>

</body>
</html>