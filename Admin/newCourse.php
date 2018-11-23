<?php
session_start();
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

<title>AU GES Exams</title>

<link href="dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>



<body>
	<!-- Main jumbotron for -->
    <div class="jumbotron" style="margin-bottom: -20px;">
      <div class="container" align="center">
        <h1 class="display-4">Online Assignment Submission System</h1>
        <p>New Course Page</p>
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
      <a class="nav-item nav-link active" href="#">New Course<span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="newTutor.php">New Tutor</a>
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
    		<input type="text" name="courseCode" class="form-control" placeholder="Enter Course Code">
    </div>
 		 
   	<div class="form-group">
      	<input type="text" name="courseTitle" class="form-control" placeholder="Enter Course Title">
    </div>

    <div class="form-group">
       <input type="number" name="courseUnit" class="form-control" placeholder="Enter Course Unit">
    </div>

    <div class="form-group">
      <select name="level" class="form-control">
          <option value="">--Select Level--</option>
          <option value="100"> 100 Level</option>
          <option value="200"> 200 Level</option>
          <option value="300"> 300 Level</option>
          <option value="400"> 400 Level</option>
      </select>
    </div>  	  	

    <div class="form-group">
      <select name="semester" class="form-control">
          <option value="">--Select Semester--</option>
          <option value="1"> First </option>
          <option value="2"> Second </option>
      </select>
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

require_once "connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['courseTitle']) && !empty($_POST['courseCode']) && !empty($_POST['level'])) {
  
  $courseCode = fix_string($_POST['courseCode']);
  $courseTitle = fix_string($_POST['courseTitle']);
  $level = $_POST['level'];
  $unit = $_POST['courseUnit'];
  $semester = $_POST['semester'];

  $courseCode = str_replace(' ', '_', $courseCode);
 
  // Checking if the course exists in database already
  $querySelect = "SELECT* FROM course WHERE courseCode = '$courseCode' AND courseName = '$courseTitle'";
  $resultSelect = $conn->query($querySelect);
  $rowNum = $resultSelect->num_rows;

  if ($rowNum < 1) {
    // What to perform if course does not exist in database yet.
    // Code to Insert the details of the new admin to database
    $stmt = $conn->prepare("INSERT INTO course (courseCode,courseName,unit,level,semester) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss",$courseCode,$courseTitle,$unit,$level,$semester);
    if($stmt->execute()){
      echo "Data Inserted Successfully";
    }
    else{
      echo "Data not Successfully Inserted" . $stmt->error;
    }

  }//End of what to perform when the course has not been registered yet

  else{
    echo "Course has been registered before";

  }//End of what to perform when the course is registered already

}//End of validating that the POST variables are not empty

}//End of validating that the request method is a POST method



function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}

?>
