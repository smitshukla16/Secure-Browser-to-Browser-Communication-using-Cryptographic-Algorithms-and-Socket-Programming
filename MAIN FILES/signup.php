<?php
include_once 'dbconnect.php';
$error = false;
if ( isset($_POST['sign']) ) {
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);


  $dob = strtotime($_POST["dob"]);
  $dob = date('Y-m-d', $dob);

  $gender = trim($_POST['gender']);
  $gender = strip_tags($gender);
  $gender = htmlspecialchars($gender);

  $phone = trim($_POST['phone']);
  $phone = strip_tags($phone);
  $phone = htmlspecialchars($phone);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);

  $usr = trim($_POST['usr']);
  $usr = strip_tags($usr);
  $usr = htmlspecialchars($usr);


  if(empty($pass)){
      $error = true;
      $errMSG = "Please enter a password.";
    }
   if(empty($usr)){
      $error = true;
      $errMSG = "Please enter a username.";
    } 

  if((strlen($pass) < 6) &&($error == false)){
    $error = true;
    $errMSG = "Password must have atleast 6 characters.";
  }
  

  $password = hash('sha256', $pass);

    $query = "SELECT email FROM chat_users WHERE email='$email'";
    $result = mysqli_query($conn,$query);
    $count = mysqli_num_rows($result);
    if($count!=0){
      $error = true;
      $errMSG = "The account for given email already exists";
    }

 
  $query = "SELECT username FROM login WHERE username='$usr'";
    $result = mysqli_query($conn,$query);
    $count = mysqli_num_rows($result);
    if($count!=0){
      $error = true;
      $errMSG = "Provided username is already in use.";
    }

  
if(!$error){
    $query = "INSERT INTO chat_users(name,email,dob,gender, phone) VALUES('$name','$email','$dob','$gender','$phone')";
    $query2 = "INSERT INTO login(username,password, email) VALUES('$usr', '$password', '$email')";
    $res = mysqli_query($conn,$query);
    $res1 = mysqli_query($conn,$query2);
    if( ($res)&&($res1)) {
          $success = "Account created successfully";
    } else {
      $errMSG = "Something went wrong, try again later...";
    }
}
  
}
?>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="..\CSS\create_personnel.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="..\CSS\header.css">
  <link rel="stylesheet" type="text/css" href="..\CSS\footer.css">
<script src="..\javascript\home.js"></script>
</head>
<body>
  <div class="loginBox">
      <!-- <img src="..\images\user.png" class="user"> -->
      <h2> CHAT ACCOUNT CREATION </h2>
      <form method="post" action="<?php $_SERVER['PHP_SELF'] ?>">
        
        <p >FULL NAME </p>
        <input class="inp" type="text" name="name" placeholder="Enter Name">
        <p>EMAIL </p>
        <input class="inp" type="text" name="email" placeholder="Enter email">

        <div style="width: 100%; display: inline-block;">
          <div style="width:32%;display: inline-block;">
            <p> DATE OF BIRTH </p><br>
            <input class="inp date" type="date" name="dob">
          </div>
          <div style="width:30%;display: inline-block;margin-left: 20px">
              <p> GENDER </p><br>
              <select id = "selectGender" name="gender">
                <option id = "optionGender">Choose</option>
                <option id = "optionGender" value="M">Male</option>
                <option id = "optionGender" value="F">Female</option>
                <option id = "optionGender" value="O">Others</option>
              </select>
          </div>
          <div style="width:30%;display: inline-block;">
            <p> PHONE </p><br>
            <input class="inp age" type="tel" name="phone" pattern="[0-9]{10}" placeholder="phone number">
          </div>
        </div>
        <p >USERNAME </p>
        <input class="inp" type="text" name="usr" placeholder="Enter Username">
        <p >PASSWORD </p>
        <input class="inp" type="password" name="pass" placeholder="Enter Password">
        <input class="inp" type="submit" name="sign" value="CREATE ACCOUNT">
	<label><a href="user_login.php">BACK TO LOGIN --> </a></label><br><br>

        <?php if(isset($errMSG)) {?>
          <span style="color:red;"><?php echo $errMSG; ?></span><br><br>
        <?php } ?>
        <?php if(isset($success)) {?>
          <span style="color: black;"><?php echo $success; ?></span><br><br>
        <?php } ?>

      </form>
  </div>
      </div>
</body>
</html>
