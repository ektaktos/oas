<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="image/alphatim.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>OAS</title>
<link rel="stylesheet" type="text/css" href="assets/css/loginxs.css" />
<!-- Bootstrap core CSS -->
 <link href="assets/css/bootstrap.css" rel="stylesheet">
 </script>

<!-- style Sheet -->
<style type="text/css">
  body {
    background:  url(../Admin/dashboard/image/back.jpg) no-repeat;
    background-size: 100%;
    overflow: hidden;
}
</style>

<body>

<div class="jumbotron" id="change" style="background:#343A40;">
  <div><center><img src="../Admin/dashboard/image/logo.gif" width="80px" height="80px" /></center></div>
      <div class="container">
      <h1 align="center" style="color:white;">Assignment Submission & Grading System</h1>
      </div>
 </div><!-- End of Main Jumbotron-->	


<?php
// Starting a sesssion variable
session_start();
$user = $pass = $passwrd = $usrname = $paswrd = $position = "";
// if user is already logged in
if(!empty($_SESSION['oas_adminuser']))
{
	header("Location:newCourse.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// if both username and password are entered
if(!empty($_POST['oas_adminuser']) && !empty($_POST['oas_adminpword']))
{
 $user = $_POST['oas_adminuser'];
 $pass = $_POST['oas_adminpword'];

//Hash encryption for protecting password in the database
$salt1 = "qm&h*";
$salt2 = "pg!@";
$passwrd = hash('ripemd128', "$salt1$pass$salt2");

require_once "connect.php";

$query = "SELECT * FROM admin WHERE username = '$user' AND password = '$passwrd' ";
$result = $conn->query($query);

if(mysqli_num_rows($result) == 1){
  $_SESSION['oas_adminuser'] = $user;
  header('Location:addCourse.php');
}
else{
  header('Location:index.php');
}
}
}
?>

<div class="login-page">
  <div class="form">
    <!-- <form class="register-form">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button>create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form> -->
    <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input type="text" name="oas_adminuser" placeholder="username"/>
      <input type="password" name="oas_adminpword" placeholder="password"/>
      <button type="submit" name="submit">login</button> 
      <!-- <p class="message">Not registered? <a href="#">Create an account</a></p> -->
    </form>
  </div>
</div>


<!-- <div id="wrapper" class="wrapper" style = "margin-top:30px;"> -->
<!-- Div container to contain the page -->
 <<!-- div class="container">

<div class="offset-md-2 col-md-8">


<form method="post" class="form-horizontal" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<div class="form-group">
<input name="oas_adminuser" type="text" class="form-control" placeholder="Enter Admin Username" >
</div>

<div class="form-group">
<input name="oas_adminpword" type="password" class="form-control" placeholder="Enter Admin Password" >
</div>

<div class="col-sm-12" align="center">
<input type="submit" value="Login" name="submit" class="btn btn-primary">
</div> -->

</form>
</div>
</div>
</div>


<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<nav class = "navbar navbar-default navbar-inverse navbar-fixed-bottom">
      <div class = "container-fluid">
        <label class = "navbar-text pull-right">Assignment Submission and Grading System &copy; All rights reserved 2018</label>
      </div>
    </nav>



</div>
</body> 
<script src = "assets/js/jquery.js"></script>
  <script src = "assets/js/bootstrap.js"></script>
  
</html>



