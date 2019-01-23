<?php 
// Student log in credential
require 'Admin/connect.php';

?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<title>ASG System</title>
<!-- Bootstrap core CSS -->
    <link href="admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom fonts for this template-->
<link href="admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<script src="admin/dashboard/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="admin/dashboard/vendor/bootstrap/jquery/jquery.min.js"></script>

<!-- Custom styles for this template-->
<link href="admin/dashboard/css/sb-admin.css" rel="stylesheet">

<?php 
  // Starting a sesssion variable
session_start();
require_once "Admin/connect.php";
$user = $pass = $passwrd = $usrname = $paswrd = $position = "";
// if user is already logged in
if(!empty($_SESSION['oas_tutorId']) && !empty($_SESSION['oas_tutorpos']))
{
  header("Location:tutor.php");
  exit();
}
elseif(!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])){
  header("Location:student.php");
  exit();
}
 ?>

<script type="text/javascript">
function validate(form){

fail = validatePassword(form.password.value)
fail += validateUsername(form.username.value)

if (fail == "") return true

else{

alert("Fill in the required fields"); 
return false
}
}
</script>

<!-- style Sheet -->
<style type="text/css">
  body {
    background:  url(Admin/dashboard/image/back.jpg) no-repeat;
    background-size: 100%;
    overflow: hidden;
}
</style>

 <!-- Just an image -->

<body class="bg-light">
  <nav class="navbar navbar-light bg-dark">
  <a class="navbar-brand" href="#">
    <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
    <span style="color: white;">ASG System</span>
  </a>
  <div class="navbar-right">
    <a class="btn btn-primary" style="color:white;" href="cordinator/index.php">Student Login</a>
  </div>
</nav>

<!-- Div container to contain the page -->
 <div class="container-fluid" style="position: relative;left: 25%;">

<div class="col-sm-12 row" style="margin-top: 50px;">
<div class="col-sm-3">
<div class="card card-login mx-auto mt-5">
        <div class="card-header">Tutor Login</div>
        <div class="card-body">
          <form method="post" class="form-horizontal" role="form" action="index.php">

            <div class="form-group">
              <!-- <div class="form-label-group"> -->
                <input type="text" name="oas_tutorId" class="form-control" placeholder="Tutor Id" required="required" autofocus="autofocus">
              <!-- <label for="inputEmail">Tutor Id</label> -->
              <!-- </div> -->
            </div>
            <div class="form-group">
              <!-- <div class="form-label-group"> -->
                <input type="password" name="oas_tutorpword" id="inputPassword" class="form-control" placeholder="Password" required="required">
                <!-- <label for="inputPassword">Password</label> -->
              <!-- </div> -->
            </div>
            <div class="form-group">
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            <br />
            <br />
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href=""></a></div>
          </div>
      </div>
</div>

<div class="col-sm-3">
<div class="card card-login mx-auto mt-5">
        <div class="card-header">Student Login</div>
        <div class="card-body">

            <? include 'errors.php'; ?>

          <form method="post" class="form-horizontal" role="form" action="index.php">
            <div class="form-group">
                <input type="text" name="oas_matricNum" class="form-control" placeholder="Matric number" required="required">
            </div>
            <div class="form-group">
             <!--  <div class="form-label-group"> -->
                <input type="password" name="oas_studpword" class="form-control" placeholder="Password" required="required">
              <!-- </div> -->
            </div>
            <div class="form-group">
            </div>
            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="registration.php">Register an Account</a>
<!--             <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
 -->          </div>
          <div class="text-center">
            <a class="d-block small mt-2" href="registration.php">Forgot Password</a>
<!--             <a class="d-block small" href="forgot-password.html">Forgot Password?</a>
 -->      </div>
        </div>
      </div>
      </div>
<!-- <div class="col-sm-6">
  <img src="../Admin/dashboard/image/back.jpg" class="img-fluid rounded">
</div> -->
</div>

</div>
<!-- Sticky Footer -->
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<nav class = "navbar navbar-default bg-dark">
      <div class = "container-fluid" style="float:right;">
        <div class="container navbar-right">
        <label class = "navbar-text p navbar-right" style="color:white;">Assignment Submission & Grading System &copy; All rights reserved 2018</label>
        </div>
      </div>
    </nav>
  </body>
  <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// if both username and password are entered
if(!empty($_POST['oas_tutorId']) && !empty($_POST['oas_tutorpword']))
{
 $user = fix_string($_POST['oas_tutorId']);
 $pass = fix_string($_POST['oas_tutorpword']);

// Hash encryption for protecting password in the database
$salt1 = "qm&h*";
$salt2 = "pg!@";
$passwrd = hash('ripemd128', "$salt1$pass$salt2");


$query = "SELECT* FROM tutor WHERE StaffId = '$user' AND password = '$passwrd' ";
$result = $conn->query($query);

    if($result->num_rows <  1){
      ?>
     <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
         <?php

    }

    else{

        $position = "tutor";
       //Creating sessions and cookies
       $_SESSION['oas_tutorId']=$user;
       $_SESSION['oas_tutorpos']=$position;

       // echo "Success logging in";
      ?>
      <script>
      window.location = "tutor.php";
      </script>
      <?php
     }
}// End of condition if both username and password are entered.

// Confirming if the current user is a student
elseif (!empty($_POST['oas_matricNum']) && !empty($_POST['oas_studpword'])) {

    $user = fix_string($_POST['oas_matricNum']);
    $pass = fix_string($_POST['oas_studpword']);

    // Hash encryption for protecting password in the database
    $salt1 = "qm&h*";
    $salt2 = "pg!@";
    $passwrd = hash('ripemd128', "$salt1$pass$salt2");

    $query = "SELECT* FROM student WHERE MatricNum = '$user' AND password = '$passwrd' ";
    $result = $conn->query($query);

    if($result->num_rows <  1){
      ?>
      <h6 align="center">Incorrect Username or Password</h6>
     
         <?php
    }

    else{

      $_SESSION['oas_studmatricNum'] = $user;
      $_SESSION['oas_studpos'] = "student";
      // echo "Success logging in";
      ?>
      <script>
      window.location = "student.php";
      </script>
      <?php
     }
  }

else{

  ?>
  <div class="alert-danger">
    <span class="closebtn" onclick="location.reload();" onload="this.parentElement.style.display='none';">&times;</span> 
    Please enter the username and password
    </div>
    <?php
}

}#End of validating that the request sent is a POST method

function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}


?>
<script type="text/javascript">

function validatePassword(){var a=document.getElementById('password').value; var b=document.getElementById('password'); if (a == "") {document.getElementById('pword').innerHTML='<font color=red size=2><i>No Password was Entered</i><font>';b.style.borderColor="red";} else if (!/[a-z]/.test(a) || ! /[A-Z]/.test(a) || !/[0-9]/.test(a)){document.getElementById('pword').innerHTML='<font size=2 color=red><i>Passwords require one each of a-z, A-Z and 0-9.</i><font>';b.style.borderColor="red";} else if (a.length  < 4) {document.getElementById('pword').innerHTML='<font color=red size=2><i>Passwords too weak</i></font>';b.style.borderColor="red";} else {document.getElementById('pword').innerHTML=""; b.style.borderColor="green"; return ""}}

function validateUsername(){var a=document.getElementById('username').value; var b=document.getElementById('username'); if(a == ""){document.getElementById('uname').innerHTML='<font color=red size=2><i>No username was Entered</i><font>';b.style.borderColor="red";} else if (/[^a-zA-Z0-9_-]/.test(a)){document.getElementById('uname').innerHTML='<font size=2 color=red><i>Only a-z, A-Z, 0-9, _ and - are required</i><font>';b.style.borderColor="red";} else{document.getElementById('uname').innerHTML=""; b.style.borderColor="green"; return ""}}
</script>

<script type="text/javascript">
  $(document).on('click', '#cont', function(){
    $('#content-data').html('');
    $.ajax({
      url:'editTutor.php',
      type:'POST',
      dataType:'html'
    }).done(function(data){
      $('#content-data').html('');
      $('#content-data').html(data);
    })
  });
</script>