<?php
session_start();
require_once "connect.php";

if(empty($_SESSION['oas_adminuser']))
{
?>
<script type="text/javascript">
        alert("You are currently Logged out \n Login to view this page")
        window.location='index.php';
        </script>
 <?php
}
else
{
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
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.jpeg">

<title>OAS System</title>

<link href="dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>



<body>
	<!-- Main jumbotron for -->
    <div class="jumbotron" style="margin-bottom: -20px;">
      <div class="container" align="center">
        <h1 class="display-4">Online Assignment Submission System</h1>
        <p>New Tutor Page</p>
      </div>
    </div><!-- End of Main Jumbotron-->
     <!-- The Navigation or menu bar-->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">OAS</a>
  <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> -->
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="newCourse.php">New Course</a>
      <a class="nav-item nav-link active" href="#">New Tutor <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="assignTutor.php">Assign Tutor</a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
</nav>
<div class="container" style="margin-top: 30px;">
	<!-- FORM CONTROLS-->
	<form class="form-horizontal" method="post" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
    <div class="offset-md-3 col-md-6">
		
		  <div class="form-group">
    		<input type="text" name="tutorName" class="form-control" placeholder="Enter Tutor Name">
    	</div>
 		 
   	   <div class="form-group">
    		<input type="text" name="tutorId" class="form-control" placeholder="Enter Tutor Id">
    	</div>

      <div class="form-group">
        <input type="tel" name="tutorPhone" class="form-control" placeholder="Enter Tutor Phone Contact">
      </div>

      <div class="form-group">
        <input type="email" name="tutorEmail" class="form-control" placeholder="Enter Tutor Email">
      </div>

      <div class="form-group">
        <input type="password" name="tutorPassword" class="form-control" placeholder="Enter Tutor Password">
      </div>

      <div class="form-group col-sm-7">
        <label>Select Courses </label> <br>
        <?php
        if ($resultSelectCourse->num_rows > 0) {
          # code...
        while ($row = $resultSelectCourse->fetch_assoc()) {
            echo "<input type='checkbox' name='courses[]' value='".$row['courseCode']."'> ".$row['courseCode']."";
        }
        }
        else{
          echo "No Course Found";
        }

        ?>
        </div>
           	  		

   		 <div class="col-sm-offset-2 col-sm-10" align="center">
    		  <input type="Submit" name="submit" value="Submit" class="btn btn-primary">
   		 </div>

       </div>

    </form>

 </div>

<!-- FOOTER -->
   
      <footer class="footer">
         <hr>
       <p align="center">&copy; <?php echo Date("Y");?> Oas system </p>
      </footer>
 
</body>
</html> 



<?php
}// CLose of the else statement for the session variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['tutorName']) && !empty($_POST['tutorId']) && !empty($_POST['tutorPhone']) && !empty($_POST['tutorEmail']) && !empty($_POST['tutorPassword']) && !empty($_POST['courses'])) {
  
  $tutorName = fix_string($_POST['tutorName']);
  $tutorId = fix_string($_POST['tutorId']);
  $tutorPhone = fix_string($_POST['tutorPhone']);
  $tutorEmail = fix_string($_POST['tutorEmail']);
  $password = fix_string($_POST['tutorPassword']);
  $courses = $_POST['courses'];

  $courses_json = json_encode($courses);

  // Hash encryption for protecting password in the database
  $salt1 = "qm&h*";
  $salt2 = "pg!@";
  $tutorPassword= hash('ripemd128', "$salt1$password$salt2");

  // Checking if the tutor exists in database already
  $querySelect = "SELECT* FROM tutor WHERE Name = '$tutorName' AND StaffId ='$tutorId'";
  $resultSelect = $conn->query($querySelect);
  $rowNum = $resultSelect->num_rows;

  if ($rowNum < 1) {
    // What to perform if tutor does not exist in database yet.
    // Code to Insert the details of the new tutor to database
    $stmt = $conn->prepare("INSERT INTO tutor (Name,courses,StaffId,phone,email,password) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",$tutorName,$courses_json,$tutorId,$tutorPhone,$tutorEmail,$tutorPassword);
    if($stmt->execute()){
      echo "Data Inserted Successfully";
    }
    else{
      echo "Data not Successfully Inserted" . $stmt->error;
    }

  }//End of what to perform when the tutor has not been registered yet

  else{
        echo "Tutor has been registered before";
  }//End of what to perform when the course is registered already

}//End of validating that the POST variables are not empty

}//End of validating that the request method is a POST method



function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}

?>
