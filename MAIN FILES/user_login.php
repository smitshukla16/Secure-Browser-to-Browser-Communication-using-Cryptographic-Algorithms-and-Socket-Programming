<?php
  session_start();
  include_once 'dbconnect.php';
  $error = false;
  if( isset($_POST['log']) ) {
    $error = false;
    
    $usrid = trim($_POST['usrid']);
    $usrid = strip_tags($usrid);
    $usrid = htmlspecialchars($usrid);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    
    $roomid = $_POST['roomid'];
    
    if(empty($pass)){
      $error = true;
      $errMSG1 = "Please enter your password.";
    } 
    else{
      $pass = hash('sha256', $pass);
    }
    if(empty($usrid)){
      $error = true;
      $errMSG1 = "Please enter your user id address.";
    }
    if (!$error) {
        $res=mysqli_query($conn,"SELECT username, password, email FROM login WHERE username='$usrid'");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res);
        if( $count == 1 && $row['password']==$pass && $row['is_staff']==0) {
          $_SESSION['chat'] = $row['email'];
          
          if($roomid == 3000){
            header("Location: http://localhost:3000?user=$usrid");
          }
          elseif ($roomid == 3001) {
            header("Location: http://localhost:3001?user=$usrid");
          }
          elseif ($roomid == 3002) {
            header("Location: http://localhost:3002?user=$usrid");
          }
          elseif ($roomid == 3003) {
            header("Location: http://localhost:3003?user=$usrid");
          }
          elseif ($roomid == 3004) {
            header("Location: http://localhost:3004?user=$usrid");
          }
      } 
      else {
        $errMSG1 = "Incorrect Credentials, Try again...";
      }
    }
  }
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="..\CSS\login.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fontawesome/4.7.0/css/font-awesome.min.css">
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="..\CSS\header.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="..\CSS\footer.css"> -->
<!-- <script src="..\javascript\home.js"></script> -->
</head>
<body>
  <div class="loginBox">
    <!-- <img src="..\images\user.png" class="user"> -->
    <h2> USER LOGIN </h2>
    <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
      <p >USERNAME </p>
      <input type="text" name="usrid" placeholder="Enter Username" id="userID">
      <p>PASSWORD </p>
      <input type="password" name="pass" placeholder="Enter Password">
      <p >ROOM ID </p>
      <input type="text" name="roomid" placeholder="Enter Room" id="roomID">

      <input type="submit" name="log" value="Sign In">

      <label><a href="signup.php">SIGNUP ?</a></label><br><br>

      <?php if(isset($errMSG1)) {?>
        <span style="color:red;"><?php echo $errMSG1; ?></span><br><br>
      <?php } ?>
    </form>
  </div>
<br>
</body>
</html>