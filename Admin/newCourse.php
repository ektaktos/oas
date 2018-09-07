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

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
</head>



<body>
	<!-- Main jumbotron for -->
    <div class="jumbotron">
      <div class="container" align="center">
        <h1 class="display-4">Online Assignment Submission System</h1>
        <p>New Course Page</p>
      </div>
    </div><!-- End of Main Jumbotron-->
     <!-- The Navigation or menu bar-->
    <nav class="navbar navbar-dark navbar-static-top bg-inverse">
  <a class="navbar-brand" href="adminpage.html"><img src="favicon.jpeg" height="30" width="30" class="img-circle"></a></a>
  <ul class="nav navbar-nav nav-pills">
        <ul class="nav navbar-nav">
        
        <li class="nav-item active">
          <a class="nav-link" href="#">New Course<span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="newTutor.php">New Tutor</a>
        </li>

         <li class="nav-item">
          <a class="nav-link" href="assignTutor.php">Assign tutor</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        
      </ul> 
</nav>
<div class="container">
	<!-- FORM CONTROLS-->
	<form class="form-horizontal" method="post" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
    <div class="offset-md-3 col-md-6">
		
		<div class="form-group">
    		<input type="text" name="courseCode" class="form-control" placeholder="Enter Course Code">
    	</div>
 		 
   	   	<div class="form-group">
    		<input type="text" name="courseTitle" class="form-control" placeholder="Enter Course Title">
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
       <p align="center">&copy; Developed by Alabi Wale Timothy</p>
      </footer>
 
</body>
</html> 



<?php
}// CLose of the else statement for the session variable

require_once "connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['courseTitle']) && !empty($_POST['courseCode'])) {
  
  $courseCode = fix_string($_POST['courseCode']);
  $courseTitle = fix_string($_POST['courseTitle']);

  // Checking if the course exists in database already
  $querySelect = "SELECT* FROM course WHERE courseCode = '$courseCode' AND courseName = '$courseTitle'";
  $resultSelect = $conn->query($querySelect);
  $rowNum = $resultSelect->num_rows;

  if ($rowNum < 1) {
    // What to perform if course does not exist in database yet.
    // Code to Insert the details of the new admin to database
    $stmt = $conn->prepare("INSERT INTO course (courseCode,courseName) VALUES (?,?)");
    $stmt->bind_param("ss",$courseCode,$courseTitle);
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
