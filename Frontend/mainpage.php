<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
</head>
<body>
  
  <?php
  $fid1 = "";
  $sid1 = "";
  $db = mysqli_connect('localhost', 'root', 'ctyang2012', 'project1');
  
  if (isset($_SESSION['uusername'])) {
    $uusername = mysqli_real_escape_string($db, $_SESSION['uusername']);
    echo "<h2>"."Hello ".$uusername."!"."</h2>";
  }

  if (isset($_SESSION['currentstate'])) {
    $currentstate = mysqli_real_escape_string($db, $_SESSION['currentstate']);
    echo "Your current state is: ".$currentstate.".";
  }
  
  echo "<br>All the filters that you create now will be stored under this current state.";
  
  if (isset($_SESSION['ttxcord'])) {
    if (isset($_SESSION['ttycord'])) {
      $ttxcord = mysqli_real_escape_string($db, $_SESSION['ttxcord']);
      $ttycord = mysqli_real_escape_string($db, $_SESSION['ttycord']);
      echo "<br>Your current location is: -- x cord: ".$ttxcord." -- y cord: ".$ttycord;
    }
  }
  ?>
  
  <p>
  	Want to make a post? <a href="post.php">Post</a>
  </p>
  
  <p>
  	Want to make a friend? <a href="friend.php">Friend</a>
  </p>
  
  <p>
  	Want to make a comment? <a href="comment.php">Comment</a>
  </p>

  <?php
  echo "Here are all the schedules that avaliable to use during current time and current date: ";

  if (isset($_SESSION['ttime'])) {
    $ttime = mysqli_real_escape_string($db, $_SESSION['ttime']);
  }
  if (isset($_SESSION['ttweeknum'])) {
    $ttweeknum = mysqli_real_escape_string($db, $_SESSION['ttweeknum']);
  }
  if (isset($_SESSION['ttdate'])) {
    $ttdate = mysqli_real_escape_string($db, $_SESSION['ttdate']);
  }
  
  $query2 = "DELETE FROM temp";
  mysqli_query($db, $query2);
  
    $query = "SELECT sid FROM schedule WHERE ('$ttdate' between sfromdate AND senddate AND '$ttime' between sstarttime AND sendtime AND severydayYN='Y') 
    or ('$ttdate' between sfromdate and senddate and '$ttime' between sstarttime and sendtime and locate('$ttweeknum', severyweeknumN)) 
    or ('$ttdate' between sfromdate and senddate and '$ttime' between sstarttime and sendtime and sdate='$ttdate')";
    $results = mysqli_query($db, $query);
    if ($results->num_rows > 0) {
      while($row = $results->fetch_assoc()) {
        $sid=$row['sid'];
        echo $sid." . ";
        $query1 = "INSERT INTO temp (sid) VALUES ('$sid')";
        mysqli_query($db, $query1);
      }
    }
    else {
      echo "0 results";
    }
  
  echo "<br>You currently have these filters that avaliable to use: ";
  
  if (isset($_SESSION['uid'])) {
    $uid = mysqli_real_escape_string($db, $_SESSION['uid']);
  }

    $query3 = "SELECT fid FROM filter WHERE uid='$uid' and sid in (SELECT sid FROM temp) and locate('$currentstate', currentstatename)";
    $results = mysqli_query($db, $query3);
    if ($results->num_rows > 0) {
      while($row = $results->fetch_assoc()) {
        $fid=$row['fid'];
        echo $fid." . ";
      }
    }
    else {
      echo "0 results";
    }
  
    echo "<br><br>Here are the positions we have in the database:<br><br>";
    echo "Position id = 1,  your current location<br>";
    echo "Position id = 2,  Brooklyn,  x cord: 400,  y cord: 450<br>";
    echo "Position id = 3,  Las Vegas, x cord: 3000, y cord: 4000<br>";
    echo "<br>Hint: When you create a new filter, the position id can be chosen from above.<br>";

    echo "<br>Want to check a valid filter information? Please fill the information below:<br>";
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Filter id (please choose an id from above): </label>
  	  <input type="text" name="fid1">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="check_filter">Check Filter</button>
  	</div>
  </form>

  <?php
    // check filter
    if (isset($_POST['check_filter'])) {
      
      $fid1 = mysqli_real_escape_string($db, $_POST['fid1']);
      $bool = 0;
      
      if (empty($fid1)) {
        echo "Filter id is required<br>";
        $bool=1;
      }

      if ($bool == 0) {
        $query = "SELECT fid, sid, ftag1, ftag2, ftag3, fradius, positionid, fvisible, fkeyword FROM filter WHERE fid='$fid1' and uid='$uid'";
        $results = mysqli_query($db, $query);
        if ($results->num_rows > 0) {
          while($row = $results->fetch_assoc()) {
              echo "Filter id: ". $row['fid']. " -- Schedule id: ". $row['sid']. " -- Tag1: " . $row['ftag1']. " -- Tag2: " . $row['ftag2']. " -- Tag3: " . $row['ftag3']. " -- Radius: " . $row['fradius']. " -- Position id: " . $row['positionid']. " -- Visible: " . $row['fvisible']. " -- Keyword: " . $row['fkeyword']. "<br>";
          }
        }
        else {
          echo "0 results<br>";
        }
      }
    }
  ?>
  
  <?php
  echo "<br>Want to check a valid schedule information? Please fill the information below:<br>";
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Schedule id (please choose an id from above): </label>
  	  <input type="text" name="sid1">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="check_schedule">Check Schedule</button>
  	</div>
  </form>

  <?php
    // check schedule
    if (isset($_POST['check_schedule'])) {
      $sid1 = mysqli_real_escape_string($db, $_POST['sid1']);
      $bool = 0;
      
      if (empty($sid1)) {
        echo "Schedule id is required<br>";
        $bool=1;
      }

      if ($bool == 0) {
        $query = "SELECT * FROM schedule WHERE sid='$sid1'";
        $results = mysqli_query($db, $query);
        if ($results->num_rows > 0) {
          while($row = $results->fetch_assoc()) {
              echo "Schedule id: ". $row['sid']. " -- Everyday(Y/N): " . $row['severydayYN']. " -- Day of week(N): " . $row['severyweeknumN']. " -- Exact date: " . $row['sdate']. " -- Start time: " . $row['sstarttime']. " -- End time: " . $row['sendtime']. " -- From date: " . $row['sfromdate']. " -- End date: " . $row['senddate']. "<br>";
          }
        }
        else {
          echo "0 results<br>";
        }
      }
    }
  ?>

  <?php
  echo "<br>Want to create a new valid filter? Please fill the information below:<br>";
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Schedule id (please choose an id from above): </label>
  	  <input type="text" name="sid2">
  	</div>
    <div>
  	  <label>Tag1 (please enter like #something or None): </label>
  	  <input type="text" name="ftag1">
  	</div>
    <div>
  	  <label>Tag2 (please enter like #something or None): </label>
  	  <input type="text" name="ftag2">
  	</div>
    <div>
  	  <label>Tag3 (please enter like #something or None): </label>
  	  <input type="text" name="ftag3">
  	</div>
    <div>
  	  <label>Radius: </label>
  	  <input type="text" name="fradius">
  	</div>
    <div>
  	  <label>Position id (please choose an id from above): </label>
  	  <input type="text" name="positionid">
  	</div>
    <div>
  	  <label>Visible: </label>
      <input type="radio" name="fvisible" value="Everyone">Everyone
  	  <input type="radio" name="fvisible" value="Friend">Friend
      <input type="radio" name="fvisible" value="Me">Me
  	</div>
    <div>
  	  <label>Keyword: </label>
  	  <input type="text" name="fkeyword">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="new_filter">New Filter</button>
  	</div>
  </form>

  <?php
    // new filter
    if (isset($_POST['new_filter'])) {
      $sid2 = mysqli_real_escape_string($db, $_POST['sid2']);
      $ftag1 = mysqli_real_escape_string($db, $_POST['ftag1']);
      $ftag2 = mysqli_real_escape_string($db, $_POST['ftag2']);
      $ftag3 = mysqli_real_escape_string($db, $_POST['ftag3']);
      $fradius = mysqli_real_escape_string($db, $_POST['fradius']);
      $positionid = mysqli_real_escape_string($db, $_POST['positionid']);
      $fvisible = mysqli_real_escape_string($db, $_POST['fvisible']);
      $fkeyword = mysqli_real_escape_string($db, $_POST['fkeyword']);
      $bool = 0;
      
      if (empty($sid2)) {
        echo "Schedule id is required<br>";
        $bool=1;
      }
      if (empty($ftag1)) {
        echo "Tag is required<br>";
        $bool=1;
      }
      if (empty($ftag2)) {
        echo "Tag is required<br>";
        $bool=1;
      }
      if (empty($ftag3)) {
        echo "Tag is required<br>";
        $bool=1;
      }
      if (empty($fradius)) {
        echo "Radius is required<br>";
        $bool=1;
      }
      if (empty($positionid)) {
        echo "Position id is required<br>";
        $bool=1;
      }
      if (empty($fvisible)) {
        echo "Visble is required<br>";
        $bool=1;
      }
      if (empty($fkeyword)) {
        echo "Keyword is required<br>";
        $bool=1;
      }

      if ($bool == 0) {
        $query = "INSERT INTO filter (uid, sid, ftag1, ftag2, ftag3, fradius, positionid, fvisible, currentstatename, fkeyword)
                VALUES('$uid', '$sid2', '$ftag1', '$ftag2', '$ftag3', '$fradius', '$positionid', '$fvisible', '$currentstate/None', '$fkeyword');";
        mysqli_query($db, $query);
      }
    }
  ?>

  <?php
  echo "<br>Want to create a new schedule? Please fill the following information:<br>";
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Everyday(Y/N): </label>
  	  <input type="text" name="severydayYN">
  	</div>
    <div>
  	  <label>Day of week(N) (please use abbreviation): </label>
  	  <input type="text" name="severyweeknumN">
  	</div>
    <div>
  	  <label>Exact date (Please enter 1990-01-01 if you do not want to choose a exact date): </label>
  	  <input type="date" name="sdate">
  	</div>
    <div>
  	  <label>Start time: </label>
  	  <input type="time" name="sstarttime">
  	</div>
    <div>
  	  <label>End time: </label>
  	  <input type="time" name="sendtime">
  	</div>
    <div>
  	  <label>From date: </label>
  	  <input type="date" name="sfromdate">
  	</div>
    <div>
  	  <label>End date: </label>
  	  <input type="date" name="senddate">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="new_schedule1">New schedule</button>
  	</div>
  </form>
  
  <?php
  // new schedule in mainpage.php
  if (isset($_POST['new_schedule1'])) {
  $severydayYN = mysqli_real_escape_string($db, $_POST['severydayYN']);
  $severyweeknumN = mysqli_real_escape_string($db, $_POST['severyweeknumN']);
  $sdate = mysqli_real_escape_string($db, $_POST['sdate']);
  $sstarttime = mysqli_real_escape_string($db, $_POST['sstarttime']);
  $sendtime = mysqli_real_escape_string($db, $_POST['sendtime']);
  $sfromdate = mysqli_real_escape_string($db, $_POST['sfromdate']);
  $senddate = mysqli_real_escape_string($db, $_POST['senddate']);
  $bool=0;

  if (empty($severydayYN)) {
      echo "Yes/No is required<br>";
      $bool=1;
  }
  if (empty($severyweeknumN)) {
      echo "Abbreviation of Day of the Week/No is required<br>";
      $bool=1;
  }
  if (empty($sdate)) {
      echo "Exact date is required<br>";
      $bool=1;
  }
  if (empty($sstarttime)) {
      echo "Start time is required<br>";
      $bool=1;
  }
  if (empty($sendtime)) {
      echo "End time is required<br>";
      $bool=1;
  }
  if (empty($sfromdate)) {
      echo "From date is required<br>";
      $bool=1;
  }
  if (empty($senddate)) {
      echo "End date is required<br>";
      $bool=1;
  }

  if ($bool == 0) {
      $query = "INSERT INTO schedule (severydayYN, severyweeknumN, sdate, sstarttime, sendtime, sfromdate, senddate)
              VALUES('$severydayYN', '$severyweeknumN', '$sdate', '$sstarttime', '$sendtime', '$sfromdate', '$senddate');";
      mysqli_query($db, $query);
  }
  }
  ?>

  <?php
  echo "<br>Want to check all the posts for a single filter? Please fill the information below:<br>";
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <label>Filter id (please choose an id from above): </label>
  	  <input type="text" name="fid2">
  	</div>
  	<div>
  	  <button type="submit" class="btn" name="check_singlefilterpost">Check Posts</button>
  	</div>
  </form>

  <?php
    // check schedule
    if (isset($_POST['check_singlefilterpost'])) {
      $fid2 = mysqli_real_escape_string($db, $_POST['fid2']);
      $bool = 0;
      
      if (empty($fid2)) {
        echo "Filter id is required<br>";
        $bool=1;
      }

      if ($bool == 0) {
        $query2 = "DELETE FROM temp1";
        mysqli_query($db, $query2);
        
        $query = "with temp1 as  (select uid,ttime,ttweeknum,ttdate,ttxcord,ttycord  from lasttracking  where uid='$uid' )  

        ,temp2 as  (select f.fid,f.uid,f.sid,f.ftag1,f.ftag2,f.ftag3,f.fradius,f.positionid,f.fvisible,f.fkeyword  from filter as f  where f.fid='$fid2' and locate('$currentstate', f.currentstatename)  )  
        
        ,temp7 as  (select s.sid  from Schedule as s, temp1 as t  where (t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and s.severydayYN=\"Y\")   
        or (t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and locate(t.ttweeknum, s.SeveryweeknumN))  
        or (t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and s.sdate=t.ttdate) )  
        
        ,temp3 as  (select *  from post  where sid in (select sid from temp7) )  
        
        ,temp4 as  (select *  from temp2  where positionid=1 )  
        
        ,temp5 as  (select *  from temp2  where positionid!=1 )  
        
        ,temp6 as  (select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and c.uid='$uid' and (b.fvisible=\"Me\" and c.pvisible=\"Me\") and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )   
        
        ,temp8 as  (select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and (b.fvisible=\"Everyone\" and c.pvisible=\"Everyone\") and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag)) 
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) Union  select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and c.pid in (select friendid from friend where uid='$uid') 
        and (b.fvisible=\"Everyone\" and c.pvisible=\"Friend\") and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        ,temp9 as  (select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and c.pid in (select friendid from friend where uid='$uid') 
        and ((b.fvisible=\"Friend\" and c.pvisible=\"Friend\") or (b.fvisible=\"Friend\" and c.pvisible=\"Everyone\"))  and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        ,temp10 as  (select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and c.uid='$uid' and p.positionid=b.positionid and (b.fvisible=\"Me\" and c.pvisible=\"Me\") 
        and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        ,temp11 as  (select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and p.positionid=b.positionid and (b.fvisible=\"Everyone\" and c.pvisible=\"Everyone\") 
        and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius)  and locate(b.fkeyword, c.pinfo)
        Union  select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and p.positionid=b.positionid and c.pid in (select friendid from friend where uid='$uid') 
        and (b.fvisible=\"Everyone\" and c.pvisible=\"Friend\")  and (locate(b.ftag1, c.ptag) or locate(b.ftag2, c.ptag) or locate(b.ftag3, c.ptag))  and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  
        and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )   
        
        ,temp12 as  (select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and p.positionid=b.positionid and c.pid in (select friendid from friend where uid='$uid') 
        and ((b.fvisible=\"Friend\" and c.pvisible=\"Friend\") or (b.fvisible=\"Friend\" and c.pvisible=\"Everyone\")) and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))  and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  
        and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        select distinct pid from temp6 union select distinct pid from temp8 union select distinct pid from temp9 union select distinct pid from temp10 union select distinct pid from temp11 union select distinct pid from temp12 order by pid
        ";

        $results = mysqli_query($db, $query);
        if ($results->num_rows > 0) {
          while($row = $results->fetch_assoc()) {
            $pid=$row['pid'];
            $query1 = "INSERT INTO temp1 (pid) VALUES ('$pid')";
            mysqli_query($db, $query1);
          }
        }

        $query4 = "SELECT * FROM temp1 as t, post as p WHERE t.pid=p.pid";
        $results = mysqli_query($db, $query4);
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()) {
                  echo "Post id: " . $row['pid']. " -- User id: " . $row['uid']. " -- Info: " . $row['pinfo']. " -- Tags: " . $row['ptag']. " -- Radius: " . $row['pradius']. " -- Visible: " . $row['pvisible']. " -- x cord: " . $row['pxcord']. " -- y cord: " . $row['pycord']. "<br>";
                }
            }
            else {
                echo "0 results<br>";
            }
      }
    }
  ?>

  <?php
  echo "<br>Want to check all the valid posts for all current avaliable filters? Please click the bottom below:<br>";
  ?>
  
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  	<?php include('errors.php'); ?>
  	<div>
  	  <button type="submit" class="btn" name="check_allfilterspost">Check Posts</button>
  	</div>
  </form>

  <?php
    // check schedule
    if (isset($_POST['check_allfilterspost'])) {
        $query = "with temp1 as  (select uid,ttime,ttweeknum,ttdate,ttxcord,ttycord  from lasttracking  where uid='$uid' )  
        
        ,temp2 as  (select f.fid,f.uid,f.sid,f.ftag1,f.ftag2,f.ftag3,f.fradius,f.positionid,f.fvisible,f.fkeyword  from filter as f, schedule as s, temp1 as t  
        where (f.uid='$uid' and f.uid=t.uid and s.sid=f.sid and locate('$currentstate', f.currentstatename) and t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and s.severydayYN=\"Y\")  
        or (f.uid='$uid' and f.uid=t.uid and s.sid=f.sid and locate('$currentstate', f.currentstatename) 
        and t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and locate(t.ttweeknum, s.SeveryweeknumN))  
        or (f.uid='$uid' and f.uid=t.uid and s.sid=f.sid and locate('$currentstate', f.currentstatename) and t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and s.sdate=t.ttdate) )
        
        ,temp7 as  (select s.sid  from Schedule as s, temp1 as t  where (t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and s.severydayYN=\"Y\")   
        or (t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and locate(t.ttweeknum, s.SeveryweeknumN))  
        or (t.ttdate between s.sfromdate and s.senddate and t.ttime between s.sstarttime and s.sendtime and s.sdate=t.ttdate) )  
        
        ,temp3 as  (select *  from post  where sid in (select sid from temp7) )  
        
        ,temp4 as  (select *  from temp2  where positionid=1 )  
        
        ,temp5 as  (select *  from temp2  where positionid!=1 )  
        
        ,temp6 as  (select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and c.uid='$uid' and (b.fvisible=\"Me\" and c.pvisible=\"Me\") and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )   
        
        ,temp8 as  (select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and (b.fvisible=\"Everyone\" and c.pvisible=\"Everyone\") and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag)) 
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) Union  select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and c.pid in (select friendid from friend where uid='$uid') 
        and (b.fvisible=\"Everyone\" and c.pvisible=\"Friend\") and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        ,temp9 as  (select c.pid  from temp1 as a, temp4 as b, temp3 as c  where a.uid=b.uid and c.pid in (select friendid from friend where uid='$uid') 
        and ((b.fvisible=\"Friend\" and c.pvisible=\"Friend\") or (b.fvisible=\"Friend\" and c.pvisible=\"Everyone\"))  and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-c.pxcord,2)+power(a.ttycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        ,temp10 as  (select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and c.uid='$uid' and p.positionid=b.positionid and (b.fvisible=\"Me\" and c.pvisible=\"Me\") 
        and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        ,temp11 as  (select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and p.positionid=b.positionid and (b.fvisible=\"Everyone\" and c.pvisible=\"Everyone\") 
        and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))
        and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius)  and locate(b.fkeyword, c.pinfo)
        Union  select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and p.positionid=b.positionid and c.pid in (select friendid from friend where uid='$uid') 
        and (b.fvisible=\"Everyone\" and c.pvisible=\"Friend\")  and (locate(b.ftag1, c.ptag) or locate(b.ftag2, c.ptag) or locate(b.ftag3, c.ptag))  and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  
        and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )   
        
        ,temp12 as  (select c.pid  from temp1 as a, temp5 as b, temp3 as c, position as p  where a.uid=b.uid and p.positionid=b.positionid and c.pid in (select friendid from friend where uid='$uid') 
        and ((b.fvisible=\"Friend\" and c.pvisible=\"Friend\") or (b.fvisible=\"Friend\" and c.pvisible=\"Everyone\")) and (locate(b.ftag1, c.ptag) and locate(b.ftag2, c.ptag) and locate(b.ftag3, c.ptag))  and sqrt(power(a.ttxcord-p.posxcord,2)+power(a.ttycord-p.posycord,2)) <= b.fradius  
        and sqrt(power(p.posxcord-c.pxcord,2)+power(p.posycord-c.pycord,2)) <= (b.fradius+c.pradius) and locate(b.fkeyword, c.pinfo) )  
        
        select distinct pid from temp6 union select distinct pid from temp8 union select distinct pid from temp9 union select distinct pid from temp10 union select distinct pid from temp11 union select distinct pid from temp12 order by pid
        ";
        
        $query2 = "DELETE FROM temp2";
        mysqli_query($db, $query2);
        $results = mysqli_query($db, $query);
        if ($results->num_rows > 0) {
          while($row = $results->fetch_assoc()) {
            $pid=$row['pid'];
            $query1 = "INSERT INTO temp2 (pid) VALUES ('$pid')";
            mysqli_query($db, $query1);
          }
        }

        $query4 = "SELECT * FROM temp2 as t, post as p WHERE t.pid=p.pid";
        $results = mysqli_query($db, $query4);
            if ($results->num_rows > 0) {
                while($row = $results->fetch_assoc()) {
                  echo "Post id: " . $row['pid']. " -- User id: " . $row['uid']. " -- Info: " . $row['pinfo']. " -- Tags: " . $row['ptag']. " -- Radius: " . $row['pradius']. " -- Visible: " . $row['pvisible']. " -- x cord: " . $row['pxcord']. " -- y cord: " . $row['pycord']. "<br>";
                }
            }
            else {
                echo "0 results<br>";
            }
      }
  ?>
</body>
</html>