<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="image/alphatim.png" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>OAS</title>
<!-- Bootstrap core CSS -->
<link href="dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<body>

<div class="jumbotron">
      <div class="container" align="center">
      <h1 align="center">Online Assignment Submission</h1>
      <p align="center">Login Page</p>
      </div>
 </div><!-- End of Main Jumbotron-->	


<?php
// Starting a sesssion variable
session_start();
$user = $pass = $passwrd = $usrname = $paswrd = $position = "";
// if user is already logged in
if(!empty($_SESSION['oas_adminuser']))
{
	header("Location:../cordinator/addCourse.php");
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
  header('Location:../cordinator/addCourse.php');
}
else{
  header('Location:index.php');
}
}
}
?>



<!-- Div container to contain the page -->
 <div class="container">

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
</div>

</form>
</div>



<div class="col-sm-12">
    <footer class="footer">
         <hr>
       <p align="center">&copy; <?php echo Date("Y");?> Oas system </p>
      </footer>
</div>


</div>
</body> 




