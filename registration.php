<?php include 'server.php'; ?>

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
<link href="Admin/dashboard/css/login.css" rel="stylesheet">
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
	<form class="form-horizontal" method="POST" role="form" action="registration.php">
    <!-- Errors display here -->


    <div class="container">
      <div class="card card-register mx-auto mt-5">

        <div class="card-header">Register an Account</div>
        <div id="message" style="text-align: center; margin-top: 5px;"></div>
        <div class="card-body">
          <?php include('errors.php'); ?>
          <br />
          <form>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="firstName" class="form-control" placeholder="First name" name="firstname" autofocus="autofocus">
                    <label for="firstName">First name</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="lastName" class="form-control" placeholder="Last name" name="lastname">
                    <label for="lastName">Last name</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email">
                <label for="inputEmail">Email address</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="matricNum" class="form-control" placeholder="Matric Number" name="matric_num">
                    <label for="matricNum">Matric Number</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="phoneNum" class="form-control" placeholder="Phone Number" name="phone">
                    <label for="phoneNum">Phone Number</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password_1">
                    <label for="inputPassword">Password</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" name="password_2">
                    <label for="confirmPassword">Confirm password</label>
                  </div>
                </div>
              </div>
            </div>
            
            <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
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