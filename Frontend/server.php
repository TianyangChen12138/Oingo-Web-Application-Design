<?php
session_start();

// initializing variables
$ufirstname = "";
$ulastname = "";
$uemail = "";
$uusername = "";
$upassword = "";
$upassword_1 = "";
$ugender = "";

$severydayYN = "";
$severyweeknumN = "";
$sdate = "";
$sstarttime = "";
$sendtime = "";
$sfromdate = "";
$senddate = "";

$pinfo = "";
$ptag = "";
$pradius = "";
$sid = "";
$pcommentYN = "";
$pvisible = "";
$pxcord = "";
$pycord = "";

$currentstate = "";
$ttime = "";
$ttweeknum = "";
$ttdate = "";
$ttxcord = "";
$ttycord = "";

$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', 'ctyang2012', 'project1');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $ufirstname = mysqli_real_escape_string($db, $_POST['ufirstname']);
  $ulastname = mysqli_real_escape_string($db, $_POST['ulastname']);
  $uemail = mysqli_real_escape_string($db, $_POST['uemail']);
  $uusername = mysqli_real_escape_string($db, $_POST['uusername']);
  $upassword = mysqli_real_escape_string($db, $_POST['upassword']);
  $upassword_1 = mysqli_real_escape_string($db, $_POST['upassword_1']);
  $ugender = mysqli_real_escape_string($db, $_POST['ugender']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($ufirstname)) { array_push($errors, "Firstname is required"); }
  if (empty($ulastname)) { array_push($errors, "Lastname is required"); }
  if (empty($uemail)) { array_push($errors, "Email is required"); }
  if (empty($uusername)) { array_push($errors, "Username is required"); }
  if (empty($upassword)) { array_push($errors, "Password is required"); }
  if (empty($upassword_1)) { array_push($errors, "Password is required"); }
  if (empty($ugender)) { array_push($errors, "Gender is required"); }
  if ($upassword != $upassword_1) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM user WHERE uusername='$uusername' OR uemail='$uemail' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['uusername'] === $uusername) {
      array_push($errors, "Username already exists");
    }

    if ($user['uemail'] === $uemail) {
      array_push($errors, "Email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$query = "INSERT INTO user (ufirstname, ulastname, uemail, uusername, upassword, ugender, currentstate)
  			  VALUES('$ufirstname', '$ulastname', '$uemail', '$uusername', '$upassword', '$ugender', 'None')";
    mysqli_query($db, $query);

    $query1 = "SELECT uid FROM user WHERE uusername='$uusername' AND uemail='$uemail'";
    $result1 = mysqli_query($db, $query1);
    $user1 = mysqli_fetch_assoc($result1);
    $uid = $user1['uid'];

    $query2 = "INSERT INTO currentstate (uid, currentstatenname)
  			  VALUES('$uid', 'None')";
  	mysqli_query($db, $query2);
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    $uusername = mysqli_real_escape_string($db, $_POST['uusername']);
    $upassword = mysqli_real_escape_string($db, $_POST['upassword']);
  
    if (empty($uusername)) {
        array_push($errors, "Username is required");
    }
    if (empty($upassword)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $query = "SELECT * FROM user WHERE uusername='$uusername' AND upassword='$upassword'";
        $results = mysqli_query($db, $query);
        $user = mysqli_fetch_assoc($results);
        $uid = $user['uid'];
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['uusername'] = $uusername;
            $_SESSION['uid'] = $uid;
            header('location: settingup.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

// setting up
if (isset($_POST['set_state'])) {
    if (isset($_SESSION['uid'])) {
        $uid = mysqli_real_escape_string($db, $_SESSION['uid']);

        $currentstate = mysqli_real_escape_string($db, $_POST['currentstate']);
        $ttime = mysqli_real_escape_string($db, $_POST['ttime']);
        $ttweeknum = mysqli_real_escape_string($db, $_POST['ttweeknum']);
        $ttdate = mysqli_real_escape_string($db, $_POST['ttdate']);
        $ttxcord = mysqli_real_escape_string($db, $_POST['ttxcord']);
        $ttycord = mysqli_real_escape_string($db, $_POST['ttycord']);
  
        if (empty($currentstate)) {
            array_push($errors, "Current State is required");
        }
        if (empty($ttime)) {
            array_push($errors, "Current Time is required");
        }
        if (empty($ttweeknum)) {
            array_push($errors, "Current Day of the Week is required");
        }
        if (empty($ttdate)) {
            array_push($errors, "Current Date is required");
        }
        if (empty($ttxcord)) {
            array_push($errors, "Current location x cord is required");
        }
        if (empty($ttycord)) {
            array_push($errors, "Current location y cord is required");
        }
  
        if (count($errors) == 0) {
            $query = "DELETE FROM lasttracking WHERE uid='$uid';";
            $query .= "INSERT INTO lasttracking (uid, ttime, ttweeknum, ttdate, ttxcord, ttycord)
                       VALUES('$uid', '$ttime', '$ttweeknum', '$ttdate', '$ttxcord', '$ttycord');";
            $query .= "UPDATE user SET currentstate='$currentstate' WHERE uid='$uid'";
            mysqli_multi_query($db, $query);

            $_SESSION['currentstate'] = $currentstate;
            $_SESSION['ttime'] = $ttime;
            $_SESSION['ttweeknum'] = $ttweeknum;
            $_SESSION['ttdate'] = $ttdate;
            $_SESSION['ttxcord'] = $ttxcord;
            $_SESSION['ttycord'] = $ttycord;
            header('location: mainpage.php');
        }
    }
}

// create new state
if (isset($_POST['new_state'])) {
    if (isset($_SESSION['uid'])) {
        $uid = mysqli_real_escape_string($db, $_SESSION['uid']);

        $currentstate = mysqli_real_escape_string($db, $_POST['currentstate']);
        
        if (empty($currentstate)) {
            array_push($errors, "New State is required");
        }
  
        if (count($errors) == 0) {
            $query = "INSERT INTO currentstate (uid, currentstatenname)
                    VALUES('$uid', '$currentstate')";
            mysqli_query($db, $query);
        }
    }
}

// make new friend
if (isset($_POST['make_friend'])) {
    if (isset($_SESSION['uid'])) {
        $uid = mysqli_real_escape_string($db, $_SESSION['uid']);
    }
    
    $uid1 = mysqli_real_escape_string($db, $_POST['uid']);

    if (empty($uid1)) {
        array_push($errors, "User id is required");
    }

    if (count($errors) == 0) {
        $query = "INSERT INTO friend (uid, friendid)
                VALUES('$uid', '$uid1'), ('$uid1', '$uid')";
        mysqli_query($db, $query);
    }
}

// new schedule in post.php
if (isset($_POST['new_schedule'])) {

        $severydayYN = mysqli_real_escape_string($db, $_POST['severydayYN']);
        $severyweeknumN = mysqli_real_escape_string($db, $_POST['severyweeknumN']);
        $sdate = mysqli_real_escape_string($db, $_POST['sdate']);
        $sstarttime = mysqli_real_escape_string($db, $_POST['sstarttime']);
        $sendtime = mysqli_real_escape_string($db, $_POST['sendtime']);
        $sfromdate = mysqli_real_escape_string($db, $_POST['sfromdate']);
        $senddate = mysqli_real_escape_string($db, $_POST['senddate']);
  
        if (empty($severydayYN)) {
            array_push($errors, "Yes/No is required");
        }
        if (empty($severyweeknumN)) {
            array_push($errors, "Abbreviation of Day of the Week/No is required");
        }
        if (empty($sdate)) {
            array_push($errors, "Exact date is required");
        }
        if (empty($sstarttime)) {
            array_push($errors, "Start time is required");
        }
        if (empty($sendtime)) {
            array_push($errors, "End time is required");
        }
        if (empty($sfromdate)) {
            array_push($errors, "From date is required");
        }
        if (empty($senddate)) {
            array_push($errors, "End date is required");
        }
  
        if (count($errors) == 0) {
            $query = "INSERT INTO schedule (severydayYN, severyweeknumN, sdate, sstarttime, sendtime, sfromdate, senddate)
                    VALUES('$severydayYN', '$severyweeknumN', '$sdate', '$sstarttime', '$sendtime', '$sfromdate', '$senddate');";
            mysqli_query($db, $query);
        }
}

// new post
if (isset($_POST['new_post'])) {
    if (isset($_SESSION['uid'])) {
        $uid = mysqli_real_escape_string($db, $_SESSION['uid']);
        
        $pinfo = mysqli_real_escape_string($db, $_POST['pinfo']);
        $ptag = mysqli_real_escape_string($db, $_POST['ptag']);
        $pradius = mysqli_real_escape_string($db, $_POST['pradius']);
        $sid = mysqli_real_escape_string($db, $_POST['sid']);
        $pcommentYN = mysqli_real_escape_string($db, $_POST['pcommentYN']);
        $pvisible = mysqli_real_escape_string($db, $_POST['pvisible']);
        $pxcord = mysqli_real_escape_string($db, $_POST['pxcord']);
        $pycord = mysqli_real_escape_string($db, $_POST['pycord']);
  
        if (empty($pinfo)) {
            array_push($errors, "Info is required");
        }
        if (empty($ptag)) {
            array_push($errors, "Tags is required");
        }
        if (empty($pradius)) {
            array_push($errors, "Radius is required");
        }
        if (empty($sid)) {
            array_push($errors, "Schedule id is required");
        }
        if (empty($pcommentYN)) {
            array_push($errors, "Yes/No is required");
        }
        if (empty($pvisible)) {
            array_push($errors, "Visible is required");
        }
        if (empty($pxcord)) {
            array_push($errors, "x cord is required");
        }
        if (empty($pycord)) {
            array_push($errors, "y cord is required");
        }
  
        if (count($errors) == 0) {
            $query = "INSERT INTO post (uid, pinfo, ptag, pradius, sid, pcommentYN, pvisible, pxcord, pycord)
                    VALUES('$uid', '$pinfo None', '$ptag None', '$pradius', '$sid', '$pcommentYN', '$pvisible', '$pxcord', '$pycord');";
            mysqli_query($db, $query);
        }
    }
}

?>