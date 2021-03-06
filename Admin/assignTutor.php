 <!-- On this page, courses will be assigned to tutors. The courses column will be selected from the tutor database and treated as a json object which will later be decoded back to an array. The tutor Id will also be inserted as a json file into the tutor column of the course table -->

<?php
session_start();
require_once 'connect.php';
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

	// GEtting the registered courses and tutors from database
	$selectCourse = "SELECT* FROM course";
	$resultCourse = $conn->query($selectCourse);

	$selectTutor = "SELECT* FROM tutor ";
	$resultTutor = $conn->query($selectTutor);

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

<title>Assign Tutor</title>

<link href="dashboard/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

</head>



<body>
	<!-- Main jumbotron for -->
    <div class="jumbotron" style="margin-bottom: -20px;">
      <div class="container" align="center">
        <h1 class="display-4">Online Assignment Submission System</h1>
        <p>Assign Tutor Page</p>
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
      <a class="nav-item nav-link" href="newTutor.php">New Tutor</a>
      <a class="nav-item nav-link active" href="#">Assign Tutor <span class="sr-only">(current)</span></a>
      <a class="nav-item nav-link" href="logout.php">Logout</a>
    </div>
  </div>
</nav>
<div class="container" style="margin-top: 30px;">
	<!-- FORM CONTROLS-->
	<form class="form-horizontal" method="post" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		
    <div class="offset-md-3 col-md-6">
		
		 	<div class="form-group">
        <select class="form-control" name="course">
        	<option value="">-- Select Course--</option>
        	<?php
        		if ($resultCourse->num_rows < 1) {
        			
        		}
        		else{
	        	while ($row = $resultCourse->fetch_assoc())
			    {
			         echo '<option value="'.$row['courseCode'].'">'.$row['courseName'].' ('.str_replace('_',' ',$row['courseCode']).')</option>'; 
			    } 
			    }
        	?>

        </select>
    	</div>

    	<div class="form-group">
        <select class="form-control" name="tutor">
        	<option value="">-- Select Tutor--</option>
        	<?php
        		if ($resultTutor->num_rows < 1) {
        			
        		}
        		else{
	        	while ($row = $resultTutor->fetch_assoc())
			    {
			         echo '<option value="'.$row['StaffId'].'">'.$row['Name'].'</option>'; 
               $tutorcourse[] = $row['courses'];
			    } 
			    }
        	?>

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
 // echo "$ courses is ". $tutorcourse;
require_once "connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!empty($_POST['course']) && !empty($_POST['tutor'])) {
  
  $course = fix_string($_POST['course']);
  $tutor = fix_string($_POST['tutor']);
  
  $tutorcourse[] = $course;
  $courses_json = json_encode($tutorcourse);
  $stmt = $conn->query("UPDATE tutor SET courses = '$courses_json' WHERE StaffId = '$tutor'");
  $stmt2 = $conn->query("UPDATE course SET tutor = '$tutor' WHERE courseCode = '$course'");

  

  if($stmt === TRUE && $stmt2 === TRUE){
    echo "Data Inserted Successfully";
  }
  else{
    echo "Data not Successfully Inserted" . $conn->error;
  }

 

}//End of validating that the POST variables are not empty

}//End of validating that the request method is a POST method



function fix_string($string)
{
if (get_magic_quotes_gpc()) $string = stripslashes($string);
return htmlentities ($string);
}

?>
