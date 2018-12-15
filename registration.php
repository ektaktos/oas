<?php
require_once "Admin/connect.php";
// Selecting all the available courses from database
$querySelectCourse = "SELECT courseCode FROM course";  
$resultSelectCourse = $conn->query($querySelectCourse);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="Admin/dashboard/image/logo.gif" rel="shortcut icon"/>
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.jpeg">

<!-- Bootstrap core CSS-->
    <link href="Admin/dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="Admin/dashboard/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="Admin/dashboard/css/sb-admin.css" rel="stylesheet">

<title>Register - ASG</title>

</head>

<body class="bg-light">
	<nav class="navbar navbar-light bg-dark">
  <a class="navbar-brand" href="#">
    <img src="Admin/dashboard/image/logo.gif" width="50" height="50" alt="AU">
    <span style="color: white;">ASG System</span>
  </a>
</nav>


<div class="container div">
	<!-- FORM CONTROLS-->
	<form class="form-horizontal" method="POST" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">

    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div id="message" style="text-align: center; margin-top: 5px;"></div>
        <div class="card-body">
          <form>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="firstName" class="form-control" placeholder="First name" required="required" name="firstname" autofocus="autofocus">
                    <label for="firstName">First name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="lastName" class="form-control" placeholder="Last name" required="required" name="lastname">
                    <label for="lastName">Last name</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="required" name="email">
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="matricNum" class="form-control" placeholder="Matric Number" required="required" name="matric_num">
                    <label for="matricNum">Matric Number</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="phoneNum" class="form-control" placeholder="Phone Number" required="required" name="phone">
                    <label for="phoneNum">Phone Number</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" name="pword">
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required" name="pword1">
                    <label for="confirmPassword">Confirm password</label>
                  </div>
                </div>
              </div>
            </div>
            
            <button type="submit" name="submit" class="btn btn-primary btn-block">Register</button>
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="index.php">Login Page</a>
          </div>
        </div>
      </div>
    </div>
  
    </form>


<!-- FOOTER -->
 <!-- Sticky Footer -->
        <footer class="sticky-footer" style="margin-top: 120px; text-align: center;">
          <div class="container my-auto">
            <div class="">
              <span>Assignment Submission & Grading System &copy; All rights reserved <?=date('Y')?></span>
            </div>
          </div>
        </footer>
    <!-- Scroll to Top Button-->
 
</body>
</html>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['matric_num']) && !empty($_POST['phone']) && !empty($_POST['email'])  && !empty($_POST['pword'])) {
  
  $firstname = fix_string($_POST['firstname']);
  $lastname= fix_string($_POST['lastname']);
  $matricNum = fix_string($_POST['matric_num']);
  $phone = fix_string($_POST['phone']);
  $email = fix_string($_POST['email']);
  $pass = fix_string($_POST['pword']);
  $name = $firstname . " " . $lastname;
  $semester = '1.1';

  
  // Hash encryption for protecting password in the database
  $salt1 = "qm&h*";
  $salt2 = "pg!@";
  $passwrd = hash('ripemd128', "$salt1$pass$salt2");

  // Checking if the course exists in database already
  $querySelect = "SELECT* FROM student WHERE MatricNum = '$matricNum'";
  $resultSelect = $conn->query($querySelect);
  $rowNum = $resultSelect->num_rows;

  if ($rowNum < 1) {
    // Code to Insert the details of the new admin to database
    $stmt = $conn->prepare("INSERT INTO student (Name,MatricNum,phone,email,password,current_semester) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$name,$matricNum,$phone,$email,$passwrd,$semester);

    if($stmt->execute()){
      ?>
     <script>
      alert("Registration Successful, proceed to login");
     window.location.href = 'index.php';
     </script>
     <?php
    }
    else{
      echo "Data not Successfully Inserted" . $stmt->error;
       ?>
    <script>
        document.getElementById("message").innerHTML = "Registration Not Successful, Please try again";
        document.getElementById("message").style.color = "red";
    </script>
    <?php
    }

  }//End of what to perform when the course has not been registered yet

  else{
    echo "You have been registered already";
    ?>
    <script>
        document.getElementById("message").innerHTML = "You have been Registered already";
        document.getElementById("message").style.color = "red";
    </script>
    <?php

  }//End of what to perform when the course is registered already

}//End of validating that the POST variables are not empty
else{
?>
      <script>
        document.getElementById("message").innerHTML = "Text Fields cannot be empty";
        document.getElementById("message").style.color = "red";
    </script>
<?php
}
}//End of validating that the request method is a POST method



function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}


?>
