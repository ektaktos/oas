<?php
// Validating that the Student is really logged in and authorized
session_start();
if (!empty($_SESSION['oas_studmatricNum']) && !empty($_SESSION['oas_studpos'])) {
 	# What to perform if the student is really logged in

require_once 'Admin/connect.php';
$matricNum = $_SESSION['oas_studmatricNum'];


$queryStudent = "SELECT* FROM student WHERE MatricNum = '$matricNum'";
$resultStudent = $conn->query($queryStudent);
$rownum = $resultStudent->num_rows;

 while ($row = $resultStudent->fetch_assoc()) {
        $studentName = $row['Name'];
        $phone = $row['phone'];
        $email = $row['email'];
        $courses = $row['courses'];
    }


 }

 else{
 	echo "Sorry You are not Authorized to view this page";
 	header("Location:index.php");
 } 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Profile - Online Assignment Submission</title>

    <!-- Bootstrap core CSS -->
    <link href="admin/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="admin/css/dashboard.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-dark navbar-fixed-top bg-inverse">
      <button type="button" class="navbar-toggler hidden-sm-up" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="student.php">Home</a>
      <div id="navbar">
        <nav class="nav navbar-nav pull-xs-left">
          <a class="nav-item nav-link active" href="#">Profile</a>
          <a class="nav-item nav-link" href="logout.php">Logout</a>
         
        </nav>
        <span class="pull-xs-right">
          <P>Welcome here, <?php echo $studentName; ?></P>
        </span>
      </div>
    </nav>
  <!-- Main jumbotron for -->
    <div class="jumbotron">
      <div class="container" align="center">
        <h1 class="display-5">Online Assignment Submission System</h1>
        <p>Profile</p>
      </div>
    </div><!-- End of Main Jumbotron-->

    <div class="container-fluid" id="Assignments">
        
        <?php
          if ($rownum >0) {
                        
              echo "<br>Name: " . $studentName ;
              echo "<br>Matric. Number: " . $matricNum ;
              echo "<br>Name: " . $studentName ;
              echo "<br>Phone: " . $phone ;
              echo "<br>Email: " . $email ;
              $course = implode(",", json_decode($courses));
              echo "<br>Courses: " . $course;



          }
          else{
            echo "Profile not available";
          }


        ?>


    </div>

    <div class="container-fluid col-sm-12">
    <footer class="footer">
         <hr>
       <p align="center">&copy; <?php echo Date("Y");?> Alphatim Inc. </p>
      </footer>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
